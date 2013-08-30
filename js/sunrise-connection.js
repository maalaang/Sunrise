// Sunrise Connection
function SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, opponent, initiator, stereo, remoteVideoContainer, remoteVideoClass, focusedVideo) {
    var conn = this;

    this.remoteStream = null;
    this.pc = null;
    this.xmlhttp = null;
    this.started = false;
    this.turnDone = false;
    this.msgQueue = [];
    this.isAudioMuted = false;
    this.isVideoMuted = false;
    this.pcConfig = pcConfig;
    this.pcConstraints = pcConstraints;
    this.offerConstraints = offerConstraints;
    this.mediaConstraints = mediaConstraints;
    this.sdpConstraints = sdpConstraints;
    this.opponent = opponent;
    this.initiator = initiator;
    this.stereo = stereo;
    this.signalingReady = initiator;
    this.remoteVideoContainer = remoteVideoContainer;
    this.remoteVideoClass = remoteVideoClass;

    this.card = document.getElementById('card');

    this.remoteVideo = null;
    this.focusedVideo = document.getElementById(focusedVideo);


    this.initialize = function() {
        console.log('Initializing;');
        this.resetStatus();
        this.maybeRequestTurn();
    }

    this.maybeRequestTurn = function() {
        console.log('skip turn request');

        this.turnDone = true;
        return;

        // Skipping TURN Http request for Firefox version <=22.
        // Firefox does not support TURN for version <=22.
        if (webrtcDetectedBrowser === 'firefox' && webrtcDetectedVersion <=22) {
            console.log('maybeRequestTurn - 1');
            this.turnDone = true;
            return;
        }

        for (var i = 0, len = this.pcConfig.iceServers.length; i < len; i++) {
            if (this.pcConfig.iceServers[i].url.substr(0, 5) === 'turn:') {
                console.log('maybeRequestTurn - 2');
                turnDone = true;
                return;
            }
        }

        var currentDomain = document.domain;
        if (currentDomain.search('localhost') === -1 &&
                currentDomain.search('apprtc') === -1) {
            console.log('maybeRequestTurn - 3');
            // Not authorized domain. Try with default STUN instead.
            turnDone = true;
            return;
        }

        // No TURN server. Get one from computeengineondemand.appspot.com.
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = onTurnResult;
        xmlhttp.open('GET', turnUrl, true);
        xmlhttp.send();
    }

    this.onTurnResult = function() {
        if (xmlhttp.readyState !== 4)
            return;

        if (xmlhttp.status === 200) {
            var turnServer = JSON.parse(xmlhttp.responseText);
            // Create a turnUri using the polyfill (adapter.js).
            var iceServer = createIceServer(turnServer.uris[0], turnServer.username,
                    turnServer.password);
            if (iceServer !== null) {
                this.pcConfig.iceServers.push(iceServer);
            }
        } else {
            console.log('Request for TURN server failed.');
        }
        // If TURN request failed, continue the call with default STUN.
        turnDone = true;
        this.maybeStart();
    }

    this.resetStatus = function() {
        if (!this.initiator) {
            this.setStatus('Waiting for someone to join: \ <a href=' + roomLink + '>' + roomLink + '</a>');
        } else {
            this.setStatus('Initializing...');
        }
    }

    this.createPeerConnection = function() {
        try {
            // Create an RTCPeerConnection via the polyfill (adapter.js).
            this.pc = new RTCPeerConnection(this.pcConfig, this.pcConstraints);
            this.pc.onicecandidate = this.onIceCandidate;
            console.log('Created RTCPeerConnnection with:\n' +
                    '  config: \'' + JSON.stringify(this.pcConfig) + '\';\n' +
                    '  constraints: \'' + JSON.stringify(this.pcConstraints) + '\'.');
        } catch (e) {
            console.log('Failed to create PeerConnection, exception: ' + e.message);
            alert('Cannot create RTCPeerConnection object; \
                    WebRTC is not supported by this browser.');
            return;
        }

        this.pc.onaddstream = this.onRemoteStreamAdded;
        this.pc.onremovestream = this.onRemoteStreamRemoved;
        this.pc.oniceconnectionstatechange = this.onIceConnectionStateChagne;
    }

    this.maybeStart = function() {
        console.log('started: ' + this.started);
        console.log('signalingReady: ' + this.signalingReady);
        console.log('localStream: ' + localStream);
        console.log('channelReady: ' + channel.isReady);
        console.log('turnDone: ' + this.turnDone);
        this.turnDone = true;
        if (!this.started && this.signalingReady && localStream && channel.isReady && this.turnDone) {
            this.setStatus('Connecting...');
            console.log('Creating PeerConnection.');

            this.createPeerConnection();
            console.log('Adding local stream.');

            this.pc.addStream(localStream);
            this.started = true;

            if (this.initiator)
                this.doCall();
            else
                this.calleeStart();
        }
    }

    this.setStatus = function(state) {
        // document.getElementById('footer').innerHTML = state;
    }

    this.doCall = function() {
        var constraints = this.mergeConstraints(this.offerConstraints, this.sdpConstraints);
        console.log('Sending offer to peer, with constraints: \n' + '  \'' + JSON.stringify(constraints) + '\'.')
        this.pc.createOffer(conn.setLocalAndSendMessage, null, constraints);
    }

    this.calleeStart = function() {
        // Callee starts to process cached offer and other messages.
        while (this.msgQueue.length > 0) {
            this.processSignalingMessage(this.msgQueue.shift());
        }
    }

    this.doAnswer = function() {
        console.log('Sending answer to peer.');
        this.pc.createAnswer(conn.setLocalAndSendMessage, null, this.sdpConstraints);
    }

    this.mergeConstraints = function(cons1, cons2) {
        var merged = cons1;
        for (var name in cons2.mandatory) {
            merged.mandatory[name] = cons2.mandatory[name];
        }
        merged.optional.concat(cons2.optional);
        return merged;
    }

    this.setLocalAndSendMessage = function(sessionDescription) {
        // Set Opus as the preferred codec in SDP if Opus is present.
        // sessionDescription.sdp = conn.preferOpus(sessionDescription.sdp);
        conn.pc.setLocalDescription(sessionDescription);
        channel.sendMessage(sessionDescription, conn.opponent);
    }

    this.onChannelMessage = function(msg) {
        if (!this.initiator && !this.started) {
            if (msg.type === 'offer') {
                console.log('got offer');
                this.msgQueue.unshift(msg);
                this.signalingReady = true;
                this.maybeStart();
            } else {
                this.msgQueue.push(msg);
            }
        } else {
            this.processSignalingMessage(msg);
        }
    }

    this.processSignalingMessage = function(message) {
        console.log('processSignalingMessage');
        if (!this.started) {
            console.log('peerConnection has not been created yet!');
            return;
        }

        if (message.type === 'offer') {
            console.log('processing message - offer');
            if (this.stereo) {
                message.sdp = this.addStereo(message.sdp);
            }
            this.pc.setRemoteDescription(new RTCSessionDescription(message));
            this.doAnswer();

        } else if (message.type === 'answer') {
            console.log('processing message - answer');
            if (this.stereo) {
                message.sdp = this.addStereo(message.sdp);
            }
            this.pc.setRemoteDescription(new RTCSessionDescription(message));

        } else if (message.type === 'candidate') {
            console.log('processing message - candidate');
            var candidate = new RTCIceCandidate({sdpMLineIndex: message.label, candidate: message.candidate});
            this.pc.addIceCandidate(candidate);
        }
    }

    this.onIceCandidate = function(event) {
        console.log('onIceCandidate()');
        if (event.candidate) {
            channel.sendMessage({type: 'candidate',
                    label: event.candidate.sdpMLineIndex,
                    id: event.candidate.sdpMid,
                    candidate: event.candidate.candidate}, conn.opponent);
        } else {
            console.log('End of candidates.');
        }
    }

    this.onRemoteStreamAdded = function(event) {
        console.log('onRemoteStreamAdded(): Remote stream added.');

        conn.addRemoteVideo();
        conn.remoteVideo = document.getElementById(conn.getRemoteVideoId());

        attachMediaStream(conn.focusedVideo, event.stream);
        attachMediaStream(conn.remoteVideo, event.stream);
        focusedVideoId = conn.opponent;

        // reattachMediaStream(conn.remoteVideo, localVideo);
        
        conn.remoteStream = event.stream;
        conn.waitForRemoteVideo();
    }

    this.addRemoteVideo = function() {
        $('#' + conn.remoteVideoContainer).append('<video id="' + conn.getRemoteVideoId() + '" class="' + conn.remoteVideoClass + ' " autoplay="autoplay" />');
    }

    this.removeRemoteVideo = function() {
        $('#' + conn.getRemoteVideoId()).remove();
        conn.remoteStream = null;
        conn.remoteVideo = null;
    }

    this.onRemoteStreamRemoved = function(event) {
        console.log('onRemoteStreamRemoved(): Remote stream removed.');
    }

    this.onIceConnectionStateChagne = function(event) {
    //    if (this.iceConnectionState == 'disconnected') {
    //    }
        console.log('onIceConnectionStateChange()');
        console.log('iceConnectionState = ' + this.iceConnectionState);
    //    printObject('pc', this);
    //    started = false;
    //    maybeStart();
    }

    this.onHangup = function() {
        console.log('Hanging up.');
        conn.transitionToDone();
        conn.stop();
    }

    this.onRemoteHangup = function() {
        console.log('Session terminated.');
        conn.transitionToWaiting();
        conn.stop();
    }

    this.stop = function() {
        console.log('stop()');

        conn.removeRemoteVideo();

        this.started = false;
        this.isAudioMuted = false;
        this.isVideoMuted = false;
        this.signalingReady = true;
        this.initiator = false;
        this.pc.close();
        this.pc = null;
        this.msgQueue.length = 0;
    }

    this.waitForRemoteVideo = function() {
        // Call the getVideoTracks method via adapter.js.
        console.log('waitForRemoteVideo()');

        if (conn.remoteStream == null || conn.remoteVideo == null) {
            return;
        }

        var videoTracks = conn.remoteStream.getVideoTracks();
        if (videoTracks.length === 0 || conn.remoteVideo.currentTime > 0) {
            conn.transitionToActive();
        } else {
            setTimeout(conn.waitForRemoteVideo, 100);
        }
    }

    this.transitionToActive = function() {
        this.focusedVideo.style.opacity = 1;
        this.remoteVideo.style.opacity = 1;
        return;
        console.log('transitionToActive()');
        this.focusedVideo.style.opacity = 1;
        this.card.style.webkitTransform = 'rotateY(180deg)';
        setTimeout(function() { localVideo.src = ''; }, 500);
        setTimeout(function() { this.remoteVideo.style.opacity = 1; }, 1000);
        // Reset window display according to the asperio of remote video.
        // window.onresize();
        this.setStatus('<input type=\'button\' id=\'hangup\' value=\'Hang up\' \
                onclick=\'onHangup()\' />');
    }

    this.transitionToWaiting = function() {
        return;
        this.card.style.webkitTransform = 'rotateY(0deg)';
        setTimeout(function() {
                localVideo.src = this.remoteVideo.src;
                this.remoteVideo.src = '';
                this.focusedVideo.src = '' }, 500);
        this.remoteVideo.style.opacity = 0;
        this.focusedVideo.style.opacity = 0;
        this.resetStatus();
    }

    this.transitionToDone = function() {
        return;
        localVideo.style.opacity = 0;
        this.focusedVideo.style.opacity = 0;
        this.remoteVideo.style.opacity = 0;
        setStatus('You have left the call. <a href=' + roomLink + '>\ Click here</a> to rejoin.');
    }

    this.enterFullScreen = function() {
        // container.webkitRequestFullScreen();
    }

    // Set Opus as the default audio codec if it's present.
    this.preferOpus = function(sdp) {
        var sdpLines = sdp.split('\r\n');

        // Search for m line.
        for (var i = 0; i < sdpLines.length; i++) {
            if (sdpLines[i].search('m=audio') !== -1) {
                var mLineIndex = i;
                break;
            }
        }
        if (mLineIndex === null)
            return sdp;

        // If Opus is available, set it as the default in m line.
        for (var i = 0; i < sdpLines.length; i++) {
            if (sdpLines[i].search('opus/48000') !== -1) {
                var opusPayload = this.extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
                if (opusPayload)
                    sdpLines[mLineIndex] = this.setDefaultCodec(sdpLines[mLineIndex],
                            opusPayload);
                break;
            }
        }

        // Remove CN in m line and sdp.
        sdpLines = this.removeCN(sdpLines, mLineIndex);

        sdp = sdpLines.join('\r\n');
        return sdp;
    }

    // Set Opus in stereo if stereo is enabled.
    this.addStereo = function(sdp) {
        var sdpLines = sdp.split('\r\n');

        // Find opus payload.
        for (var i = 0; i < sdpLines.length; i++) {
            if (sdpLines[i].search('opus/48000') !== -1) {
                var opusPayload = this.extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
                break;
            }
        }

        // Find the payload in fmtp line.
        for (var i = 0; i < sdpLines.length; i++) {
            if (sdpLines[i].search('a=fmtp') !== -1) {
                var payload = this.extractSdp(sdpLines[i], /a=fmtp:(\d+)/ );
                if (payload === opusPayload) {
                    var fmtpLineIndex = i;
                    break;
                }
            }
        }
        // No fmtp line found.
        if (fmtpLineIndex === null)
            return sdp;

        // Append stereo=1 to fmtp line.
        sdpLines[fmtpLineIndex] = sdpLines[fmtpLineIndex].concat(' stereo=1');

        sdp = sdpLines.join('\r\n');
        return sdp;
    }

    this.extractSdp = function(sdpLine, pattern) {
        var result = sdpLine.match(pattern);
        return (result && result.length == 2)? result[1]: null;
    }

    // Set the selected codec to the first in m line.
    this.setDefaultCodec = function(mLine, payload) {
        var elements = mLine.split(' ');
        var newLine = new Array();
        var index = 0;
        for (var i = 0; i < elements.length; i++) {
            if (index === 3) // Format of media starts from the fourth.
                newLine[index++] = payload; // Put target payload to the first.
            if (elements[i] !== payload)
                newLine[index++] = elements[i];
        }
        return newLine.join(' ');
    }

    // Strip CN from sdp before CN constraints is ready.
    this.removeCN = function(sdpLines, mLineIndex) {
        var mLineElements = sdpLines[mLineIndex].split(' ');
        // Scan from end for the convenience of removing an item.
        for (var i = sdpLines.length-1; i >= 0; i--) {
            var payload = this.extractSdp(sdpLines[i], /a=rtpmap:(\d+) CN\/\d+/i);
            if (payload) {
                var cnPos = mLineElements.indexOf(payload);
                if (cnPos !== -1) {
                    // Remove CN payload from m line.
                    mLineElements.splice(cnPos, 1);
                }
                // Remove CN line in sdp
                sdpLines.splice(i, 1);
            }
        }

        sdpLines[mLineIndex] = mLineElements.join(' ');
        return sdpLines;
    }

    this.getRemoteVideoId = function() {
        return 'remoteVideo-' + this.opponent;
    }

    this.initialize();
}

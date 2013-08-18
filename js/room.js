var channel = null;
var connections = null;
var localVideo = null;
var localStream = null;
var pcConfig = {"iceServers": [{"url": "stun:stun.l.google.com:19302"}]};
var pcConstraints = {"optional": [{"DtlsSrtpKeyAgreement": true}]};
var offerConstraints = {"optional": [], "mandatory": {}};
var mediaConstraints = {"audio": true, "video": {"mandatory": {}, "optional": []}};
var sdpConstraints = {'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true }};
var stereo = false;
var participant_id = null;

function onChannelMessage(msg) {
    if (!(msg.sender in connections)) {
        connections[msg.sender] = new SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, msg.sender, false, true);
    }

    connections[msg.sender].onChannelMessage(msg);
}

function onChannelOpened(msg) {
    connections = [];
    for (p in msg.participant_list) {
        connections[p] = new SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, p, true, true);
        connections[p].maybeStart();
    }

    participant_id = msg.participant_id;
    roomJoin();
}

function onChannelBye(msg) {
    connections[msg.participant_id].onRemoteHangup();
    delete connections[msg.participant_id];

    console.log('removed ' + msg.participant_id + ' from connection list');
    printObject('connections', connections);
}

function onHangup() {
    console.log('Hanging up.');
    for (p in connections) {
        connections[p].onHangup();
        delete connections[p];
    }
}

// for debuging
function printObject(name, obj) {
    console.log(name + '=');
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            console.log(name + '.' + key + '=' + obj[key]);
        }
    }
}

function onUserMediaSuccess(stream) {
    console.log('User has granted access to local media.');

    // Call the polyfill wrapper to attach the media stream to this element.
    attachMediaStream(localVideo, stream);

    localVideo.style.opacity = 1;
    localStream = stream;

    initializeChannel();
}

function onUserMediaError(error) {
    console.log('Failed to get access to local media. Error code was ' + error.code);
    alert('Failed to get access to local media. Error code was ' + error.code + '.');
}

function initializeChannel() {
    channel = new SunriseChannel(channelServer, channelToken, userName);

    channel.onChannelConnected = null;
    channel.onChannelOpened = onChannelOpened;
    channel.onChannelClosed = null;
    channel.onChannelBye = onChannelBye;
    channel.onChannelMessage = onChannelMessage;
    channel.onChannelDisconnected = null;
    channel.onChannelError = null;

    channel.open();
}

function addSmallVideo() {
}

function roomJoin() {
    var params = {};
    params.participant_id = participant_id;
    params.room_id = roomId;
    params.is_registered_user = isRegisteredUser;
    params.user_name = userName;
    params.user_id = userId;

    $.post(roomApi + '/d/room/join/', params, function (data) {
        var json = $.parseJSON(data);
        if (json.result === 0) {
            console.log('done: room-join');
        } else {
            console.log('error on room-join: failed to get participant_id');
        }
    });
}

function roomExit() {
    var params = {};
    params.participant_id = participant_id;

    $.post(roomApi + '/d/room/exit/', params, function (data) {
        var json = $.parseJSON(data);
        if (json.result === 0) {
            console.log('done: room-exit');
        } else {
            console.log('error on room-join: failed to get participant_id');
        }
    });
}

//window.onbeforeunload = function() {
//    channel.sendMessage({type: 'channel', subtype: 'close'});
//}

// Set the video diplaying in the center of window.
window.onresize = function() {
    var smallVideo = document.getElementById('smallVideo');
    var largeVideo = document.getElementById('largeVideo');

//    var aspectRatio;
//    if (largeVideo.style.opacity === '1') {
//        aspectRatio = largeVideo.videoWidth/largeVideo.videoHeight;
//    } else if (localVideo.style.opacity === '1') {
//        aspectRatio = localVideo.videoWidth/localVideo.videoHeight;
//    } else {
//        return;
//    }

//    var innerHeight = this.innerHeight;
//    var innerWidth = this.innerWidth;
//    var videoWidth = innerWidth < aspectRatio * window.innerHeight ?
//        innerWidth : aspectRatio * window.innerHeight;
//    var videoHeight = innerHeight < window.innerWidth / aspectRatio ?
//        innerHeight : window.innerWidth / aspectRatio;
//    containerDiv = document.getElementById('container');
//    containerDiv.style.width = videoWidth + 'px';
//    containerDiv.style.height = videoHeight + 'px';
//    containerDiv.style.left = (innerWidth - videoWidth) / 2 + 'px';
//    containerDiv.style.top = (innerHeight - videoHeight) / 2 + 'px';
}

(function() {
    // Reset localVideo display to center.
    localVideo = document.getElementById('localVideo');
//    localVideo.addEventListener('loadedmetadata', function() {
//        window.onresize();
//    });

    // Call into getUserMedia via the polyfill (adapter.js).
    try {
        getUserMedia(mediaConstraints, onUserMediaSuccess, onUserMediaError);
        console.log('Requested access to local media with mediaConstraints:\n' + ' \'' + JSON.stringify(mediaConstraints) + '\'');
    } catch (e) {
        alert('getUserMedia() failed. Is this a WebRTC capable browser?');
        console.log('getUserMedia failed with exception: ' + e.message);
    }
}());

//function toggleVideoMute() {
//     Call the getVideoTracks method via adapter.js.
//    videoTracks = localStream.getVideoTracks();

//    if (videoTracks.length === 0) {
//        console.log('No local video available.');
//        return;
//    }

//    if (isVideoMuted) {
//        for (i = 0; i < videoTracks.length; i++) {
//            videoTracks[i].enabled = true;
//        }
//        console.log('Video unmuted.');
//    } else {
//        for (i = 0; i < videoTracks.length; i++) {
//            videoTracks[i].enabled = false;
//        }
//        console.log('Video muted.');
//    }

//    isVideoMuted = !isVideoMuted;
//}

//function toggleAudioMute() {
//     Call the getAudioTracks method via adapter.js.
//    audioTracks = localStream.getAudioTracks();

//    if (audioTracks.length === 0) {
//        console.log('No local audio available.');
//        return;
//    }

//    if (isAudioMuted) {
//        for (i = 0; i < audioTracks.length; i++) {
//            audioTracks[i].enabled = true;
//        }
//        console.log('Audio unmuted.');
//    } else {
//        for (i = 0; i < audioTracks.length; i++){
//            audioTracks[i].enabled = false;
//        }
//        console.log('Audio muted.');
//    }

//    isAudioMuted = !isAudioMuted;
//}

// Ctrl-D: toggle audio mute; Ctrl-E: toggle video mute.
// On Mac, Command key is instead of Ctrl.
// Return false to screen out original Chrome shortcuts.
//document.onkeydown = function() {
//    if (navigator.appVersion.indexOf('Mac') != -1) {
//        if (event.metaKey && event.keyCode === 68) {
//            toggleAudioMute();
//            return false;
//        }
//        if (event.metaKey && event.keyCode === 69) {
//            toggleVideoMute();
//            return false;
//        }
//    } else {
//        if (event.ctrlKey && event.keyCode === 68) {
//            toggleAudioMute();
//            return false;
//        }
//        if (event.ctrlKey && event.keyCode === 69) {
//            toggleVideoMute();
//            return false;
//        }
//    }
//}


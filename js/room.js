var channel = null;
var connections = null;
var focusedVideo = null;
var localVideo = null;
var localStream = null;
var pcConfig = {"iceServers": [{"url": "stun:14.63.224.178"}]};
var pcConstraints = {"optional": [{"DtlsSrtpKeyAgreement": true}]};
var offerConstraints = {"optional": [], "mandatory": {}};
var mediaConstraints = {"audio": true, "video": {"mandatory": {}, "optional": []}};
var sdpConstraints = {'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true }};
var stereo = false;
var participantId = null;
var participantNames = null;
var isAudioMuted = false;
var isVideoMuted = false;
var focusedVideoId = null;
var isPasswordHidden = true;
var emailRegex = new RegExp(/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/);

var v = null;
var c = null;
var c1 = null;

function onChannelMessage(msg) {
    if (!(msg.sender in connections)) {
        // create a new connection
        connections[msg.sender] = new SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, msg.sender, false, true, 'remote-videos', 'small-video', 'focused-video');
        setParticipantName(msg.sender, msg.name);
        appendChatMessage(null, msg.name + ' has joined the room.');
    }

    connections[msg.sender].onChannelMessage(msg);
}

function onChannelOpened(msg) {
    connections = [];
    participantNames = [];

    for (p in msg.participant_list) {
        connections[p] = new SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, p, true, true, 'remote-videos', 'small-video', 'focused-video');
        connections[p].maybeStart();

        setParticipantName(p, msg.participant_list[p].name);
    }

    participantId = msg.participant_id;
    roomJoin();
}

function onChannelBye(msg) {
    videoFocusOut(msg.participant_id);

    connections[msg.participant_id].onRemoteHangup();
    delete connections[msg.participant_id];

    // show message a participant left the room
    appendChatMessage(null, getParticipantName(msg.participant_id) + ' has left the room.');

    // for debugging
    console.log('removed ' + msg.participant_id + ' from connection list');
    printObject('connections', connections);
}

function getParticipantName(senderId) {
    return participantNames[senderId];
}

function setParticipantName(senderId, name) {
    participantNames[senderId] = name;
}

function setParticipantName(senderId, name) {
    participantNames[senderId] = name;
}

function onChannelChat(msg) {
    switch (msg.subtype) {
        case 'normal':
            appendChatMessage(getParticipantName(msg.sender), msg.content);
            break;
        case 'title':
            appendChatMessage(null, getParticipantName(msg.sender) + ' has changed the room title - "' + msg.content + '"');
            $('#room-title').val(msg.content);
            break;
        case 'description':
            appendChatMessage(null, getParticipantName(msg.sender) + ' has changed the room description - "' + msg.content + '"');
            $('#room-description').val(msg.content);
            break;
        case 'open-status':
            if (msg.open) {
                appendChatMessage(null, getParticipantName(msg.sender) + ' has made this room public.');
                $('#menu-public-private i').removeClass('icon-lock');
                $('#menu-public-private i').addClass('icon-unlock');
            } else {
                if (roomIsOpen) {
                    appendChatMessage(null, getParticipantName(msg.sender) + ' has made this room private.');
                    $('#menu-public-private i').removeClass('icon-unlock');
                    $('#menu-public-private i').addClass('icon-lock');
                } else {
                    appendChatMessage(null, getParticipantName(msg.sender) + ' has changed the password.');
                }
            }

            roomIsOpen = msg.open;
            roomPassword = msg.password;
            $('#room-password').val(roomPassword);
            changeOpenStatus(roomIsOpen);
            break;
        case 'chat-name':
            appendChatMessage(null, getParticipantName(msg.sender) + ' changed his name with "' + msg.chat_name + '"');
            setParticipantName(msg.sender, msg.chat_name);
            break;
        case 'focus':
            videoFocusIn(msg.sender);
            break;
    }
}

function appendChatMessage(sender, msg) {
    if (sender) {
        $('#chat-content').append(sender + ': ' + msg + '<br/>');
    } else {
        $('#chat-content').append(msg + '<br/>');
    }
    $('#chat-content').scrollTop($('#chat-content')[0].scrollHeight);
}

function onHangup() {
    console.log('hang up');

    for (p in connections) {
        connections[p].onHangup();
        delete connections[p];
    }

    if (channel && channel.isReady) {
        channel.close();
    }

    appendChatMessage(null, 'You have left from the room.');

    videoFocusOut(null);
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
    console.log('got access to local media');
    localStream = stream;

    attachMediaStream(localVideo, stream);
    attachMediaStream(focusedVideo, stream);

    localVideo.style.opacity = 1;

    initializeChannel();
}

function onUserMediaError(error) {
    console.log('Failed to get access to local media. Error code was ' + error.code);
    alert('Failed to get access to local media. Error code was ' + error.code + '.');
}

function initializeChannel() {
    channel = new SunriseChannel(channelServer, channelToken, chatName);

    channel.onChannelConnected = null;
    channel.onChannelOpened = onChannelOpened;
    channel.onChannelClosed = null;
    channel.onChannelBye = onChannelBye;
    channel.onChannelMessage = onChannelMessage;
    channel.onChannelDisconnected = null;
    channel.onChannelError = null;
    channel.onChannelChat = onChannelChat;

    channel.open();
}

function roomJoin() {
    var params = {};
    params.participant_id = participantId;
    params.room_id = roomId;
    params.is_registered_user = isRegisteredUser;
    params.user_name = chatName;
    params.user_id = userId;

    $.post(roomApi + '/d/room/join/', params, function (data) {
        var json = $.parseJSON(data);
        if (json.result === 0) {
            console.log('done: room-join');
            appendChatMessage(null, 'You have joined the room.');
        } else {
            console.log('error on room-join: failed to get participantId');
        }
    });
}

function videoFocusIn(connectionId) {
    if (connectionId === focusedVideoId) {
        return;
    }

    if (connectionId == null) {
        attachMediaStream(focusedVideo, localStream);
        focusedVideoId = null;
        console.log('focused - local video');

    } else {
        var connection = connections[connectionId];
        if (connection) {
            var remoteVideo = document.getElementById(connection.getRemoteVideoId());
            attachMediaStream(focusedVideo, connection.remoteStream);
            attachMediaStream(remoteVideo, connection.remoteStream);
            focusedVideoId = connectionId;

            console.log('focused - ' + connectionId);
        }
    }
}

function videoFocusOut(connectionId) {
    if (connectionId === null) {
        // hide focused video
        focusedVideo.style.opacity = '0';
        focusedVideoId = null;
        return;

    } else if (connectionId !== focusedVideoId) {
        // specified video is not focused
        return;
    }

    for (var i in connections) {
        if (i !== connectionId) {
            // focus to another video
            attachMediaStream(focusedVideo, connections[i].remoteStream);
            focusedVideoId = i;
            return;
        }
    }

    // there is no video to be focused
    focusedVideoId = null;
    if (localStream != null) {
        attachMediaStream(focusedVideo, localStream);
        console.log('focused - local video');
    } else {
        focusedVideo.style.opacity = '0';
    }
}

function micToggle() {
    var audioTracks = localStream.getAudioTracks();

    if (audioTracks.length === 0) {
        console.log('No local audio available.');
        return;
    }

    if (isAudioMuted) {
        console.log('microphone on');
        for (i = 0; i < audioTracks.length; i++) {
            audioTracks[i].enabled = true;
        }
        $('#menu-mic span').html('Microphone On');
        $('#menu-mic i').toggleClass('icon-microphone-off icon-microphone');
    } else {
        console.log('microphone off');
        for (i = 0; i < audioTracks.length; i++) {
            audioTracks[i].enabled = false;
        }
        $('#menu-mic span').html('Microphone Muted');
        $('#menu-mic i').toggleClass('icon-microphone icon-microphone-off');
    }

    isAudioMuted = !isAudioMuted;
}

function screenToggle() {
    var videoTracks = localStream.getVideoTracks();

    if (videoTracks.length === 0) {
        console.log('No local video available.');
        return;
    }

    if (isVideoMuted) {
        for (i = 0; i < videoTracks.length; i++) {
            videoTracks[i].enabled = true;
        }
        console.log('camera on');
        $('#menu-screen i').toggleClass('icon-eye-close icon-eye-open');
        $('#menu-screen span').html('Camera On');

    } else {
        for (i = 0; i < videoTracks.length; i++) {
            videoTracks[i].enabled = false;
        }
        console.log('camera off');
        $('#menu-screen i').toggleClass('icon-eye-open icon-eye-close');
        $('#menu-screen span').html('Camera Off');
    }

    isVideoMuted = !isVideoMuted;
}

function roomExit() {
    onHangup();
}

function chatSend() {
    var msg = $('#chat-input').val();

    channel.sendMessage({type: 'chat',
        subtype: 'normal',
        recipient: 'ns',
        content: msg
    });

    appendChatMessage(chatName, msg);

    $('#chat-input').val('');
}

function invite(obj) {
    switch (obj.id) {
        case 'invite-email':
            $('#tab-email').addClass('active');
            break;
        case 'invite-facebook':
            $('#tab-facebook').addClass('active');
            break;
        case 'invite-twitter':
            $('#tab-twitter').addClass('active');
            break;
        case 'invite-url':
            $('#tab-url').addClass('active');
            break;
    }
}

function onSmallVideoClicked() {
    var id = $(this).attr('id');
    var idTokens = id.split('-');

    if (idTokens[0] == 'local') {
        videoFocusIn(null);
    } else if (idTokens[0] == 'remote') {
        videoFocusIn(idTokens[2]);
    }
}

function changeOpenStatus(open) {
    if (open) {
        $('#btn-public').addClass('active');
        $('#btn-private').removeClass('active');
        $('#menu-public-private span').html('Public Room');
    } else {
        $('#btn-public').removeClass('active');
        $('#btn-private').addClass('active');
        $('#menu-public-private span').html('Private Room');
    }
    $('#room-password').prop('disabled', open);
    $('#room-password-hide').prop('disabled', open);


    $('#open-status-save-text').html('Save');
    if (open != roomIsOpen || (!open && $('#room-password').val() != roomPassword)) {
        $('#open-status-save').prop('disabled', false);
    } else {
        $('#open-status-save').prop('disabled', true);
    }
}

function onResize() {
    $('#chat-content').scrollTop($('#chat-content')[0].scrollHeight);

    if (localStream == null) {
        return;
    }

//    console.log('video width=' + v.width() + ' height=' + v.height());

    if (c.height() / c.width() >= v.height() / v.width()) {
//        console.log('+++++++++++++');
        v.css('width', 'auto');
        v.css('height', '100%');
        v.css('bottom', '0');
        v.css('right', ((v.width()-c.width())/2) + 'px');
    } else {
//        console.log('--------------');
        v.css('height', 'auto');
        v.css('width', '100%');
        v.css('bottom', ((v.height()-c.height())/2) + 'px');
        v.css('right', '0');
    }
}

function addEmail() {
    var email = $('#invite-email').val();
    if (emailRegex.test(email)) {
        $('#invite-email-set').append('<button class="btn btn-inverse btn-added-email" onclick="removeEmail(this)"><div class="added-email pull-left">' + email + '</div> <div class="close">&times;</span></div>');
        $('#invite-email').val('');
        $('.invite-email-info').css('display', 'none');
    } else {
        $('.invite-email-info').html('Invalid email address.');
        $('.invite-email-info').css('display', 'block');
    }
}

function removeEmail(email) {
    $(email).remove();
}

function sendEmail() {
    var list = [];
    $.each($('.added-email'), function (index, email) {
        list.push(email.innerHTML.trim());
    });

    if (list.length == 0) {
        return;
    }

    var params = {}
    params.emails = JSON.stringify(list);
    params.is_open = roomIsOpen;
    if (!roomIsOpen) {
        params.password = roomPassword;
    }
    $.post(roomApi + '/d/room/invite/email/', params, function (data) {
        var json = $.parseJSON(data);
        if (json.result === 0) {
            console.log('invitation sent');
            $('#invite-email-set').html('');
            $('.invite-email-info').html('Invitation sent.');
            $('.invite-email-info').css('display', 'block');
        } else {
            console.log('failed to send invitation emails');
        }
    });
    return list;
}

function firefoxStart() {
    onResize();
    $('.large-videos').css('visibility', 'visible');
    $('.btn-invite').css('visibility', 'visible');
}

function requestFocus() {
    channel.sendMessage({type: 'chat',
        subtype: 'focus',
        recipient: 'ns',
    });
}

$(document).ready(function() {
    // text message send
    $('#chat-input').bind('keypress', function(e) {
        if(e.which == 13) {
            e.preventDefault();
            chatSend();
        }
    });

    localVideo = document.getElementById('local-video');
    focusedVideo = document.getElementById('focused-video');

    try {
        getUserMedia(mediaConstraints, onUserMediaSuccess, onUserMediaError);
        console.log('Requested access to local media with mediaConstraints:\n' + ' \'' + JSON.stringify(mediaConstraints) + '\'');
    } catch (e) {
        alert('getUserMedia() failed. Is this a WebRTC capable browser?');
        console.log('getUserMedia failed with exception: ' + e.message);
    }

    // alert before leaving the room
    $(window).on('beforeunload', function(){
          return 'You are going to leave from the video chat room.';
    });

    $('#room-title').focusout(function(event) {
        var value = $(this).val().trim();
        $(this).val(value);

        if (value !== roomTitle) {
            if (!channel.isReady) {
                console.log("Cannot update room information before the channel is ready");
                alert('You are not allowed to change the room information before joining the room.');
                return;
            }

            roomTitle = value;

            // send reqeust to save title
            var params = {};
            params.id = roomId;
            params.title = value;

            $.post(roomApi + '/d/room/title/save/', params, function (data) {
                var json = $.parseJSON(data);
                if (json.result === 0) {
                    console.log('done: title save');
                } else {
                    console.log('error on saving title: ' + json.msg);
                }
            });

            // send message to the participants in the room
            channel.sendMessage({ type: 'chat',
                subtype: 'title',
                recipient: 'ns',
                content: value
            });

            appendChatMessage(null, 'You have changed the room title - "' + value + '"');
        }
    });

    $('#room-description').focusout(function(event) {
        var value = $(this).val().trim();
        $(this).val(value);
        if (value !== roomDescription) {
            if (!channel.isReady) {
                console.log("Cannot update room information before the channel is ready");
                alert('You are not allowed to change the room information before joining the room');
                return;
            }

            roomDescription = value;

            // send reqeust to save description
            var params = {};
            params.id = roomId;
            params.description = value;

            $.post(roomApi + '/d/room/description/save/', params, function (data) {
                var json = $.parseJSON(data);
                if (json.result === 0) {
                    console.log('done: description save');
                } else {
                    console.log('error on saving description: ' + json.msg);
                }
            });

            // send message to the participants in the room
            channel.sendMessage({ type: 'chat',
                subtype: 'description',
                recipient: 'ns',
                content: value
            });

            appendChatMessage(null, 'You have changed the room description - "' + value + '"');
        }
    });

    $('.small-video').click(onSmallVideoClicked);

    $('#btn-public').click(function() {
        changeOpenStatus(true);
    });

    $('#btn-private').click(function() {
        changeOpenStatus(false);
    });

    $('#room-password-hide').change(function() {
        isPasswordHidden = $(this).prop('checked');
        if (isPasswordHidden) {
            $('#room-password').attr({type:"password"});
        } else {
            $('#room-password').attr({type:"text"});
        }
    });

    $('#room-password').bind('change paste keyup', function() {
        if (roomIsOpen != $('#btn-public').hasClass('active') || (!roomIsOpen && $(this).val() != roomPassword)) {
            $('#open-status-save-text').html('Save');
            $('#open-status-save').prop('disabled', false);
        } else {
            $('#open-status-save-text').html('Save');
            $('#open-status-save').prop('disabled', true);
        }
    });

    $('#open-status-save').click(function() {
        if (!channel.isReady) {
            console.log("Cannot update room information before the channel is ready");
            alert('You are not allowed to change the room information before joining the room');
            return;
        }

        $(this).prop('disabled', true);
        $(this).addClass('active');

        var params = {};
        params.id = roomId;
        params.open = $('#btn-public').hasClass('active');
        params.password = $('#room-password').val();

        $.post(roomApi + '/d/room/open-status/save/', params, function (data) {
            var json = $.parseJSON(data);
            if (json.result === 0) {
                console.log('done: room open status save');

                // show notification on the chat box
                if ($('#btn-public').hasClass('active')) {
                    appendChatMessage(null, 'You have made this room public.');
                } else {
                    if (roomIsOpen) {
                        appendChatMessage(null, 'You made this room private.');
                    } else {
                        appendChatMessage(null, 'You have changed the password.');
                    }
                }

                // accept the changes
                roomPassword = $('#room-password').val();
                roomIsOpen = $('#btn-public').hasClass('active');

                // change the ui components
                $('#open-status-save').removeClass('active');
                $('#open-status-save-text').html('Saved');

                if (roomIsOpen) {
                    $('#menu-public-private i').removeClass('icon-lock');
                    $('#menu-public-private i').addClass('icon-unlock');
                } else {
                    $('#menu-public-private i').removeClass('icon-unlock');
                    $('#menu-public-private i').addClass('icon-lock');
                }

                // send message to the participants in the room
                channel.sendMessage({ type: 'chat',
                    subtype: 'open-status',
                    recipient: 'ns',
                    open: roomIsOpen,
                    password: roomPassword
                });

                $('#open-status-modal').modal('hide');
            } else {
                console.log('error on saving room open status: ' + json.msg);
                $('#open-status-save').prop('disabled', false);
                $('#open-status-save').removeClass('active');
            }
        });

    });

    $('#open-status-cancel').click(function() {
        $('#room-password').val(roomPassword);
        changeOpenStatus(roomIsOpen);
        $('#open-status-modal').modal('hide');
    });

    changeOpenStatus(roomIsOpen);

    $('#chat-name-save').click(function() {
        if (!channel.isReady) {
            console.log("Cannot update chat name before the channel is ready");
            alert('You are not allowed to change your display name before joining the room');
            return;
        }

        var params = {};
        params.id = participantId;
        params.chat_name = $('#chat-name').val();

        $.post(roomApi + '/d/room/chat-name/save/', params, function (data) {
            var json = $.parseJSON(data);
            if (json.result === 0) {
                console.log('done: change chat name');

                // accept the changes
                chatName = $('#chat-name').val();

                // show notification on the chat box
                appendChatMessage(null, 'You changed your chat name - ' + chatName);

                $('#chat-name-save').removeClass('active');
                $('#chat-name-save-text').html('Saved');

                // send message to the participants in the room
                channel.sendMessage({ type: 'chat',
                    subtype: 'chat-name',
                    recipient: 'ns',
                    chat_name: chatName,
                });

                $('#chat-name-modal').modal('hide');
            } else {
                console.log('error on updating your chat name: ' + json.msg);
                $('#chat-name-save').prop('disabled', false);
                $('#chat-name-save').removeClass('active');
                $('#chat-name-modal .msg .alert').html(json.msg);
                $('#chat-name-modal .msg').css('display', 'block');
            }
        });
    });

    $('#chat-name-cancel').click(function() {
        $('#chat-name').val(chatName);
        $('#chat-name-modal').modal('hide');
        $('#chat-name-save').prop('disabled', true);
        $('#chat-name-save-text').html('Saved');
        $('#chat-name-modal .msg').css('display', 'none');
    });

    $('#chat-name').bind('change paste keyup', function() {
        if (chatName != $('#chat-name').val()) {
            $('#chat-name-save').prop('disabled', false);
            $('#chat-name-save-text').html('Save');
        } else {
            $('#chat-name-save').prop('disabled', true);
            $('#chat-name-save-text').html('Saved');
        }
        $('#chat-name-modal .msg').css('display', 'none');
    });

    $('#chat-name-save').prop('disabled', true);

    $(window).resize(onResize);

    v = $('.large-video');
    c = $('.large-videos');
    c1 = $('.small-videos');

    v.bind('play', function() {
        onResize();
        if (webrtcDetectedBrowser === 'firefox') {
            setTimeout(firefoxStart, 2000);
        } else {
            $('.btn-invite').css('visibility', 'visible');
            $('.large-videos').css('visibility', 'visible');
        }
    });

    $('.large-videos').dblclick(requestFocus);
    $('.large-videos').click(requestFocus);

    $('.btn-invite').click();

    $('#invite-email').bind('keypress', function(e) {
        if(e.which == 13) {
            e.preventDefault();
            addEmail();
        }
    });
    
    if ($(window).width() < 480) {
        $('meta[name=viewport]').remove();
        $('head').append('<meta name="viewport" content="width=device-width, initial-scale=0.7, minimum-scale=0.7, maximum-scale=0.7, user-scaleable=no">');
    };

});


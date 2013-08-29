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
var email_cnt = 0;
var participant_names = null;

function onChannelMessage(msg) {
    if (!(msg.sender in connections)) {
        connections[msg.sender] = new SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, msg.sender, false, true);
        participant_names[msg.sender] = msg.name;
    }

    connections[msg.sender].onChannelMessage(msg);
}

function onChannelOpened(msg) {
    connections = [];
    participant_names = [];

    for (p in msg.participant_list) {
        connections[p] = new SunriseConnection(pcConfig, pcConstraints, offerConstraints, mediaConstraints, sdpConstraints, p, true, true);
        connections[p].maybeStart();

        participant_names[p] = msg.participant_list[p].name;
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

function onChannelChat(msg) {
    appendChatMessage(participant_names[msg.sender], msg.content);
}

function appendChatMessage(sender, msg) {
    $('#chat_content').append(sender + ': ' + msg + '\n');
    $('#chat_content').scrollTop($('#chat_content')[0].scrollHeight);
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

function addSmallVideo() {
}

function roomJoin() {
    var params = {};
    params.participant_id = participant_id;
    params.room_id = roomId;
    params.is_registered_user = isRegisteredUser;
    params.user_name = chatName;
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
    $('#chat_content').scrollTop($('#chat_content')[0].scrollHeight);

//    var smallVideo = document.getElementById('smallVideo');
//    var largeVideo = document.getElementById('largeVideo');


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


function whenClickMicToggle(){
    $('#menu_mic i').toggleClass('glyphicon glyphicon-volume-off glyphicon glyphicon-volume-up');
}

function whenClickScreenToggle(){
    $('#menu_screen i').toggleClass('glyphicon glyphicon-eye-close glyphicon glyphicon-eye-open');
}

function whenClickExit(){
}

function whenClickChatSend(){
    var msg = $('#chat_input').val();

    channel.sendMessage({type: 'chat',
        recipient: 'ns',
        content: msg});

    appendChatMessage(chatName, msg);

    $('#chat_input').val('');
}

function whenClickTitleEdit(){
    var title;
    var description;

    $('#edit_title').val('');
    $('#edit_description').val('');

    title = $('#title').html();
    description = $('#description').html();

    $('#edit_title').attr("placeholder", title);
    $('#edit_description').attr("placeholder", description);
}

 function whenClickTitleSave(){
     var title;
     var description;
     var edit_title;
     var edit_description;


     //value initializing
    
     title = $('#title').html();
     description = $('#description').html();
                                     
     edit_title = $('#edit_title').val();
     edit_description = $('#edit_description').val();

     if(edit_title !== '')
         $('#title').html(edit_title);

     if(edit_description !== '')
         $('#description').html(edit_description);
 }

function whenClickAddEmail(){
    var group = document.createElement("span"); 
    var txt = document.createElement("input");
    var btn_span = document.createElement("span");
    var btn = document.createElement("button");
    var panel = document.getElementById("email_set");
    var email = $('#email').val();

    if(checkEmailForm(email) === false){
        console.log("Empty");
        return;
    }

    group.setAttribute("class", "input-group");
    group.setAttribute("id","Test");

    txt.setAttribute("type", "text");
    txt.setAttribute("class", "form-control");
    txt.setAttribute("value", email);
    txt.setAttribute("id", email_cnt);

    btn_span.setAttribute("class", "input-group-btn");
    btn.setAttribute("class", "btn-default");
    btn.setAttribute("type", "button");
    btn.setAttribute("onclick", "whenClickDelEmail(this)");
    btn.setAttribute("id", email_cnt);
    btn.innerHTML = "&times";
    btn_span.appendChild(btn);

    group.appendChild(txt);
    group.appendChild(btn_span);

    panel.appendChild(group);
    email_cnt++;
}

function whenClickDelEmail(obj){
    var output = obj.id;
    console.log(output);

    //Remove text component and button component
    //Text name and button name are same. So removal is twice.
    $('#'+output).remove();
    $('#'+output).remove();
    email_cnt--;
}

function whenClickInvite(obj){
    var invite_type = obj.id;
    
    if(invite_type === "invite_email")
        $('#tab_email').addClass('active');
    else if(invite_type === "invite_facebook")
        $('#tab_acebook').addClass('active');
    else if(invite_type === "invite_twitter")
        $('#tab_twitter').addClass('active');
    else if(invite_type === "invite_url")
        $('#tab_url').addClass('active');
}

//Activating tab-pane make inactive.
function whenClickInviteExit() {
    $('.active.tab-pane').removeClass('active');
}

function checkEmailForm(obj) {
    var obj_len = obj.length;
    console.log(obj[0]);

    for(var i = 0; i < obj_len; i++) {
        if(obj[i] === " ")
            return false;

        if(obj[i] === "@")
            break;
    }

    if(obj.length === 0)
        return false;
    else if(i === obj.length)
        return false;
    else
        return true;

}

$(document).ready(function() {
    $('#chat_input').bind('keypress', function(e) {
        if(e.which == 13) {
            e.preventDefault();
            whenClickChatSend();
        }
    });

    localVideo = document.getElementById('localVideo');

    try {
        getUserMedia(mediaConstraints, onUserMediaSuccess, onUserMediaError);
        console.log('Requested access to local media with mediaConstraints:\n' + ' \'' + JSON.stringify(mediaConstraints) + '\'');
    } catch (e) {
        alert('getUserMedia() failed. Is this a WebRTC capable browser?');
        console.log('getUserMedia failed with exception: ' + e.message);
    }
});

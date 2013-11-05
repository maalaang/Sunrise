var socket;

function initChannelStatus() {
    updateChannelStatus(null, 'requesting');
    try {
        socket = new WebSocket(channelServerUri);
        console.log("Connecting to the server..");
        socket.onopen = onOpen;
        socket.onmessage = onMessage;
        socket.onclose = onClose;
        socket.onerror = onError;
    } catch (ex) {
        console.log("Exception: " + ex);
    }
    $("msg").focus();
}

function send(message){
    var strMessage = JSON.stringify(message);
    console.log('C->S ' + strMessage);
    try {
        socket.send(strMessage);
    } catch (ex) {
        console.log(ex);
    }
}

function onOpen(message) {
    if (this.readyState == 1) {
        console.log("Connected");
        getChannelStatus();
    } else {
        console.log("Failed");
        $('#channel_server_status').html('Stopped');
    }
}

function onMessage(message) {
    console.log('S->C ' + message.data);

    var data = JSON.parse(message.data);

    switch (data.subtype) {
    case 'status':
        updateChannelStatus(data, 'running');
        break;
    }
}

function onClose(event) {
    console.log("Connection closed");
    updateChannelStatus(null, 'stopped');
}

function onError(event) {
    console.log("Error occurred: " + event);
}

function getChannelStatus() {
    send({type:'channel', subtype:'status'});
}

function updateChannelStatus(data, type) {
    switch (type) {
    case 'requesting':
        $('#channel_count').html('-');
        $('#client_count').html('-');
        $('#channel_server_status').html('Requesting..');
        $('#channel_server_status_tbody').html('');
        break;

    case 'running':
        var clientCnt = 0;
        var channelCnt = 0;
        var channelList = data.channel_list;

        var html = "";

        for (var i in channelList) {
            channelCnt++;
            html += "<tr>";
            html += "<td>" + channelCnt + "</td>"
            html += "<td>" + i + "</td><td>"

            var isFirst = true;
            for (var j in channelList[i]) {
                clientCnt++;
                if (isFirst) {
                    isFirst = false;
                } else {
                    html += ", ";
                }
                html += j + "(" + channelList[i][j].name + ")";
            }
            isFirst = true;
            html += "</td></tr>";
        }

        $('#channel_count').html(channelCnt);
        $('#client_count').html(clientCnt);
        $('#channel_server_status').html('Running');
        $('#channel_server_status_tbody').html(html);

        if (channelCnt > 0) {
            $('#channel_server_status_msg').html('');
            $('#channel_server_status_msg').css("display", "none");
            $('#channel_server_status_content').css("display", "block");
        } else {
            $('#channel_server_status_msg').html('No channel is currently opened.');
            $('#channel_server_status_msg').css("display", "block");
            $('#channel_server_status_content').css("display", "none");
        }

        enableChannelStartButton('disable');
        break;

    case 'stopped':
        $('#channel_count').html('-');
        $('#client_count').html('-');
        $('#channel_server_status').html('Stopped');
        $('#channel_server_status_tbody').html('');
        $('#channel_server_status_msg').css("display", "block");
        $('#channel_server_status_msg').html('the sunrise channel server is not running.');
        $('#channel_server_status_content').css("display", "none");

        enableChannelStartButton('enable');
        break;
    }
}

function onChannelStatusRefresh() {
    console.log("Refresh channel server status");
    if (!socket || socket.readyState != 1) {
        initChannelStatus();
    } else {
        getChannelStatus();
    }
}

function onChannelServerStart() {
    console.log("Start channel server");
    var params = {};
    $.post(channelServerControlApi + '/start/', params, function(data) {
        var json = JSON.parse(data);
        if (json.result === 0) {
            enableChannelStartButton('disable-all');
            onChannelStatusRefresh();
        }
    });
}

function onChannelServerRestart() {
    console.log("Restart channel server");

    if (socket && (socket.readyState == WebSocket.CLOSING || socket.readyState == WebSocket.CLOSED)) {
        socket.close();
    }
    socket = null;

    var params = {};
    $.post(channelServerControlApi + '/restart/', params, function(data) {
        var json = JSON.parse(data);
        if (json.result === 0) {
            updateChannelStatus(null, 'stopped');
            enableChannelStartButton('disable-all');
            onChannelStatusRefresh();
        }
    });
}

function onChannelServerStop() {
    console.log("Stop channel sever");

    if (socket && (socket.readyState == WebSocket.CLOSING || socket.readyState == WebSocket.CLOSED)) {
        socket.close();
    }
    socket = null;

    var params = {};
    $.post(channelServerControlApi + '/stop/', params, function(data) {
        var json = JSON.parse(data);
        if (json.result === 0) {
            updateChannelStatus(null, 'stopped');
        }
    });
}

function enableChannelStartButton(flag) {
    switch (flag) {
    case 'enable':
        $('#channel_server_start_btn').removeClass('disabled');
        $('#channel_server_stop_btn').addClass('disabled');
        $('#channel_server_restart_btn').addClass('disabled');
        break;
    case 'disable':
        $('#channel_server_start_btn').addClass('disabled');
        $('#channel_server_stop_btn').removeClass('disabled');
        $('#channel_server_restart_btn').removeClass('disabled');
        break;
    case 'disable-all':
        $('#channel_server_start_btn').addClass('disabled');
        $('#channel_server_stop_btn').addClass('disabled');
        $('#channel_server_restart_btn').addClass('disabled');
        break;
    }
}


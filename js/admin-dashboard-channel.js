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

function onChannelStatusRefresh() {
    console.log("Refresh channel server status");
    if (!socket || socket.readyState != 1) {
        initChannelStatus();
    } else {
        getChannelStatus();
    }
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
        $('#channel_server_status').html('Running (' + data.time + ')');
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
        break;
    case 'stopped':
        $('#channel_count').html('-');
        $('#client_count').html('-');
        $('#channel_server_status').html('Stopped');
        $('#channel_server_status_tbody').html('');
        $('#channel_server_status_msg').css("display", "block");
        $('#channel_server_status_msg').html('The sunrise channel server is not running.');
        $('#channel_server_status_content').css("display", "none");
        break;
    }
}

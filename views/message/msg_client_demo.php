<html>
<head>
<title>Sunrise - WebSocket Client Test</title>

<style>
html,body {
    font:normal 0.9em arial,helvetica;
}
#log {
    width:500px;
    height:600px;
    border:1px solid gray;
    overflow:auto;
}
#msg {
    width:400px;
}
</style>

<script>
var socket;
var host = "ws://dev.maalaang.com:8889/echo";

function init() {
    try {
        socket = new WebSocket(host);
        log("Connecting to the server..");
        socket.onopen = onOpen;
        socket.onmessage = onMessage;
        socket.onclose = onClose;
        socket.onerror = onError;
    } catch (ex) {
        log("Exception: " + ex);
    }
    $("msg").focus();
}

function send(){
    var txt = $("msg");
    var msg = txt.value;
    if (!msg) {
        return;
    }
    txt.value="";
    txt.focus();
    try {
        socket.send(msg);
        log('>>> '+ msg);
    } catch (ex) {
        log(ex);
    }
}

function exit(){
    log("Closing the connection..");
    socket.close();
    socket = null;
}


function onOpen(message) {
    if (this.readyState == 1) {
        log("Connected");
    } else {
        log("Failed");
    }
}

function onMessage(message) {
    log("<<< " + message.data);
}

function onClose(event) {
    log("Connection closed");
}

function onError(event) {
    log("Error occurred: " + event);
}

function $(id) {
    return document.getElementById(id);
}

function log(msg) {
    $("log").innerHTML += "<br>" + msg;
}

function onkey(event) {
    if (event.keyCode == 13) {
        send();
    }
}
</script>

</head>

<body onload="init()">
    <h3>Sunrise - WebSocket Client Test</h3>
    <div id="log"></div>
    <input id="msg" type="textbox" onkeypress="onkey(event)"/>
    <button onclick="send()">Send</button>
    <button onclick="exit()">Exit</button>
</body>
</html>


// Sunrise Channel Client
function SunriseChannel(channelServer, channelToken, userName) {
    var socket = null;
    var channel = this;

    var channelServer = channelServer;
    var channelToken = channelToken;
    var userName = userName;

    this.isReady = false;

    this.onChannelConnected = null;
    this.onChannelOpened = null;
    this.onChannelClosed = null;
    this.onChannelBye = null;
    this.onChannelMessage = null;
    this.onChannelDisconnected = null;
    this.onChannelError = null;

    this.open = function() {
        console.log('Open sunrise channel');

        try {
            socket = new WebSocket(channelServer);
            socket.onopen    = this._onChannelConnected;
            socket.onmessage = this._onChannelMessage;
            socket.onclose   = this._onChannelDisconnected;
            socket.onerror   = this._onChannelError;

        } catch(ex) {
            console.log(ex);
        }
    }

    this.close = function() {
        this.isReady = false;
        socket.close();
        socket = null;
    }

    this.sendMessage = function(message, recipient) {
        if (recipient === undefined || recipient === null) {
            // not specified
            message.recipient = 'ns';
        } else {
            // specify the recipient of this message
            message.recipient = recipient;
        }

        var messageString = JSON.stringify(message);
        console.log('C->S: ' + messageString);
        socket.send(messageString);
    }

    this._onChannelConnected = function() {
        console.log('Opening sunrise channel');

        channel.sendMessage({type: 'channel',
            subtype: 'open',
            channel_token: channelToken,
            user_name: userName
        });

        if (typeof this.onChannelConnected === 'function') {
            this.onChannelConnected();
        }
    }

    this._onChannelMessage = function(message) {
        console.log('S->C: ' + message.data);

        var msg = JSON.parse(message.data);

        if (msg.type === 'channel') {
            switch (msg.subtype) {
            case 'open':
                channel._onChannelOpened(msg);
                break;
            case 'close':
                channel._onChannelClosed();
                break;
            case 'bye':
                channel._onChannelBye(msg);
                break;
            }
            return;
        }

        if (typeof channel.onChannelMessage === 'function') {
            channel.onChannelMessage(msg);
        }
    }

    this._onChannelOpened = function(msg) {
        console.log('Channel opened');
        channel.isReady = true;

        if (typeof channel.onChannelOpened === 'function') {
            channel.onChannelOpened(msg);
        }
    }

    this._onChannelClosed = function() {
        console.log('Channel closded');
        channel.isReady = false;

        if (typeof channel.onChannelClosed === 'function') {
            channel.onChannelClosed();
        }
    }

    this._onChannelBye = function(msg) {
        console.log('Got bye message');

        if (typeof channel.onChannelBye === 'function') {
            channel.onChannelBye(msg);
        }
    }

    this._onChannelDisconnected = function() {
        console.log('Channel disconnected.');
        channel.isReady = false;

        if (typeof channel.onChannelDisconnected === 'function') {
            channel.onChannelDisconnected();
        }
    }

    this._onChannelError = function() {
        console.log('Channel error.');

        if (typeof channel.onChannelError === 'function') {
            channel.onChannelError();
        }
    }
}

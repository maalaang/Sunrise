<!DOCTYPE html>
<html>
    <head>
        <title>WebRTC Reference App</title>

        <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
    
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/adapter.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/room-webrtc.js"></script>

        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/main.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css">
    </head>

    <body>
        <script type="text/javascript">
            var channelToken = '<?= $context['room']->channel_token ?>';
            var roomId = '<?= $context['room']->id ?>';
            var participantId = '<?= $context['participant']->id ?>';
            var roomLink = '<?= $context['room_link'] ?>';
            var initiator = <?= $context['initiator'] ?>;
            var pcConfig = {"iceServers": [{"url": "stun:stun.l.google.com:19302"}]};
            var pcConstraints = {"optional": [{"DtlsSrtpKeyAgreement": true}]};
            var offerConstraints = {"optional": [], "mandatory": {}};
            var mediaConstraints = {"audio": true, "video": {"mandatory": {}, "optional": []}};
            var stereo = false;
            var roomName = '<?= $context['room']->name ?>';
            var userName = '<?= $context['participant']->name ?>';
            var userId = '<?= $context['participant']->user_id ?>';
            var isRegisteredUser = 0;
            var sunriseChannelServer = "ws://dev.maalaang.com:8889/sunrise/channel/";
            setTimeout(initialize, 1);
        </script>
        <div class="header">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
                    <div class="nav-collapse collapse">
                        <form class="navbar-form form-inline pull-right" name="option_form" id="option_form">
                            <input type="text" class="form-control">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="container" ondblclick="enterFullScreen()"> 
            <div id="card">
                <div id="local">
                    <video id="localVideo" autoplay="autoplay" muted="true"/>
                </div>
                <div id="remote">
                    <video id="remoteVideo" autoplay="autoplay"></video>
                    <div id="mini">
                        <video id="miniVideo" autoplay="autoplay" muted="true"/></video>
                    </div>
                </div>
            </div>
        </div>
    </body>

<!--footer id="footer">
</footer-->

</html>

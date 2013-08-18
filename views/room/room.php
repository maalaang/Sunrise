<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise - Video Conference Room</title>

        <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
    
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/adapter.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/sunrise-channel.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/sunrise-connection.js"></script>

        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/room-temp.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css">
    </head>

    <body>
        <script type="text/javascript">
            var channelServer = "ws://dev.maalaang.com:8889/sunrise/channel/";
            var channelToken = '<?= $context['room']->channel_token ?>';
            var roomLink = '<?= $context['room_link'] ?>';
            var roomName = '<?= $context['room']->name ?>';
            var userName = '<?= $context['user_name'] ?>';
//            var roomId = '<?= $context['room']->id ?>';
//            var participantId = '<?= $context['participant']->id ?>';
//            var initiator = <?= $context['initiator'] ?>;
//            var isRegisteredUser = 0;
//            setTimeout(initialize, 1);
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
        <!-- div id="container" ondblclick="enterFullScreen()"> 
            <div id="card">
                <div id="local">
                    <video id="localVideo" autoplay="autoplay" muted="true"/>
                </div>
                <div id="remote">
                    <video id="largeVideo" autoplay="autoplay"></video>
                    <div id="mini">
                        <video id="smallVideo" autoplay="autoplay" muted="true"/></video>
                    </div>
                </div>
            </div>
        </div-->
        <div id="container">
            <div id="largeVideoContainer">
                <video id="focusedVideo" class="largeVideo" autoplay="autoplay" muted="true"/>
            </div>
            <div id="smallVideoContainer">
                <video id="localVideo" class="smallVideo" autoplay="autoplay" muted="true"/>
            </div>
        </div>
    </body>

    <script src="<?= $GLOBALS['sr_root'] ?>/js/room.js"></script>

<!--footer id="footer">
</footer-->

</html>

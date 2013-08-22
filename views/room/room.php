<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise - Video Conference Room</title>

        <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
    
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/adapter.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/sunrise-channel.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/sunrise-connection.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.min.js"></script>
        


        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/room-temp.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap-glyphicons.css">
    </head>

    <body>
        <script type="text/javascript">
            var channelServer = '<?= $context['channel_server'] ?>';
            var channelToken = '<?= $context['room']->channel_token ?>';
            var roomId = '<?= $context['room']->id ?>';
            var roomLink = '<?= $context['room_link'] ?>';
            var roomName = '<?= $context['room']->name ?>';
            var roomApi = '<?= $context['room_api'] ?>';
            var isRegisteredUser = <?= $context['is_registered_user'] ?>;
            var userName = '<?= $context['user_name'] ?>';
            var userId = <?= $context['user_id'] ?>;

        </script>
        <div class="header">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
                    <div class="nav-collapse collapse">
<!--                        <form class="navbar-form form-inline pull-right" name="option_form" id="option_form">
                            <input type="text" class="form-control">
                        </form>-->
                        
                    <form class="navbar-form form-inline pull-right" name"option_form" id="option_form">
                        <ul class="nav navbar-nav">
                            <li>
                                <a id="menu_screen" href="#" onclick="whenClickScreen()">
                                    <i class="glyphicon glyphicon-eye-open"></i>
                                </a>
                            </li>
                            <li>
                                <a id="menu_mic" href="#" onclick="whenClickMic()">
                                    <i class="glyphicon glyphicon-volume-up"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" id="menu_sns" href="#">
                                    <i class="glyphicon glyphicon-link"></i>
                                    <span class="caret"></span>
                                </a> 
                                <ul class="dropdown-menu">
                                    <li><a href="#">Facebook</a></li>
                                    <li><a href="#">Twitter</a></li>
                                    <li><a href="#">Google+</a></li>
                                </ul>
                            </li>
                            <li>
                                <a id="menu_exit" href="#" onclick="whenClickExit()">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>
                            </li>
                        </ul>
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

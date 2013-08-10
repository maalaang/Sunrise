<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content"">
        <meta name="author" content="">

        <title>WebRTC Reference App</title>

        <script src="http://code.jquery.com/jquery-1.7.1.js"></script>
        <script src="/workspace/whale/Sunrise/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="/workspace/whale/Sunrise/js/jquery.mousewheel.js"></script>
        <script type="text/javascript" src="/workspace/whale/Sunrise/js/jquery.jscrollpane.min.js"></script>

        <link type="text/css" href="/workspace/whale/Sunrise/css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
        <link type="text/css" rel="stylesheet" href="/workspace/whale/Sunrise/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="/workspace/whale/Sunrise/css/bootstrap-glyphicons.css">
        <link type="text/css" rel="stylesheet" href="/workspace/whale/Sunrise/css/docs.css">
        <link type="text/css" rel="stylesheet" href="/workspace/whale/Sunrise/css/foot.css">
        <style>
            body{
                padding-top:40px;
            }
            .sns_btn{
                float:right;
            }
        </style>


        <script>
            function whenClickSpeaker(){
                $("#btn_speaker i").toggleClass("glyphicon glyphicon-volume-off glyphicon glyphicon-volume-up");
            }
            function whenClickVideo(){
                $("#btn_video i").toggleClass("glyphicon glyphicon-eye-close glyphicon glyphicon-eye-open");
            }
            function whenClickExit(){
            }

            //Initalizing JScrollpane
            $(document).ready(function(){
                $('.scroll-pane').jScrollPane();
            });
        </script>
    </head>

    <body>


        <div class="head_content">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
                <div class="nav-collapse collapse">
                    <form class="navbar-form form-inline pull-right" name="option_form" id="option_form">
                        <button type="button" class="btn btn-primary" id="btn_video" onclick="whenClickVideo()">
                            <i class="glyphicon glyphicon-eye-open"></i>
                        </button>
                        <button type="button" class="btn btn-primary" id="btn_speaker" onclick="whenClickSpeaker()">
                            <i class="glyphicon glyphicon-volume-up"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-link"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Facebook</a></li>
                                <li><a href="#">Twitter</a></li>
                                <li><a href="#">Google+</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary" id="btn_exit">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>


        <div class="main_content col-lg-8">
            <div class="header">
                <span class="sns_btn">Invite People</span>
                
                <span><h3>Design team weekly meeting</h3></span>
                The layout of the video chat room...
            </div>
        </div>


        <div class="side_content col-lg-4">
            <h1>Side_Content</h1>
            <div class="scroll-pane jspScrollable" tabindex="0" style="overflow: hidden; padding:0px; width: auto;height:200px;">
                <div class="jspPane" style="padding:0px; top:0px; width:auto;height:200px">
                    <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec in ligula id sem tristique ultrices
                    eget id neque. Duis enim turpis, tempus at accumsan vitae, lobortis id sapien. Pellentesque nec orci
                    mi, in pharetra ligula. Nulla facilisi. Nulla facilisi. Mauris convallis venenatis massa, quis
                    consectetur felis ornare quis. Sed aliquet nunc ac ante molestie ultricies. Nam pulvinar ultricies
                    bibendum. Vivamus diam leo, faucibus et vehicula eu, molestie sit amet dui. Proin nec orci et elit
                    semper ultrices. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus
                    mus. Sed quis urna mi, ac dignissim mauris. Quisque mollis ornare mauris, sed laoreet diam malesuada
                    quis. Proin vel elementum ante. Donec hendrerit arcu ac odio tincidunt posuere. Vestibulum nec risus
                    eu lacus semper viverra.
                    </p>
                    <p>
                    Vestibulum dictum consectetur magna eu egestas. Praesent molestie dapibus erat, sit amet sodales
                    lectus congue ut. Nam adipiscing, tortor ac blandit egestas, lorem ligula posuere ipsum, nec
                    faucibus nisl enim eu purus. Quisque bibendum diam quis nunc eleifend at molestie libero tincidunt.
                    Quisque tincidunt sapien a sapien pellentesque consequat. Mauris adipiscing venenatis augue ut
                    tempor. Donec auctor mattis quam quis aliquam. Nullam ultrices erat in dolor pharetra bibendum.
                    Suspendisse eget odio ut libero imperdiet rhoncus. Curabitur aliquet, ipsum sit amet aliquet varius,
                    est urna ullamcorper magna, sed eleifend libero nunc non erat. Vivamus semper turpis ac turpis
                    volutpat non cursus velit aliquam. Fusce id tortor id sapien porta egestas. Nulla venenatis luctus
                    libero et suscipit. Sed sed purus risus. Donec auctor, leo nec eleifend vehicula, lacus felis
                    sollicitudin est, vitae lacinia lectus urna nec libero. Aliquam pellentesque, arcu condimentum
                    pharetra vestibulum, lectus felis malesuada felis, vel fringilla dolor dui tempus nisi. In hac
                    habitasse platea dictumst. Ut imperdiet mauris vitae eros varius eget accumsan lectus adipiscing.
                    </p>
                    <p>
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                    Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit
                    amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.
                    </p>
                </div>
                <div class="jspVerticalBar">
                    <div class="jspCap jspCapTop"></div>
                    <div class="jspTrack" style="height:200px;">
                        <div class="jspDrag" style="height:77px;">
                            <div class="jspDragTop"></div>
                            <div class="jspDragBottom"></div>
                        </div>
                    </div>
                    <div class="jspCap jspCapBottom"></div>
                </div>
            </div>
        </div>


        <div class="tail_content">
            <div class="container" align="center">
                <p>
                    <a href="#" id="foot_link">Privacy Policy</a>
                    <a href="#" id="foot_link">About Sunrise</a>
                    <a href="#" id="foot_link">Admin Page</a>
                    <a href="#" id="foot_link">Powered by Sunrise</a>
                </p>
            </div> 
    </body>

            

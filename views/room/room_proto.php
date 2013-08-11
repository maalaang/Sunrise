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
            .navbar-inverse{
                background-color:purple;
            }
        </style>


        <script>
            function whenClickMic(){
                $("#menu_mic i").toggleClass("glyphicon glyphicon-volume-off glyphicon glyphicon-volume-up");
            }
            function whenClickScreen(){
                $("#menu_screen i").toggleClass("glyphicon glyphicon-eye-close glyphicon glyphicon-eye-open");
            }
            function whenClickExit(){
            }
            function whenClickSend(){
                $("#output_message").value = "asdf";
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
                                        <!--Button Ver.-->
<!--                <div class="nav-collapse collapse">
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
                </div>-->
            </div>
        </div>


        <div class="main_content col-lg-8">
            <div class="header">
                <span class="sns_btn">Invite People</span> 
                <span><h1><a id="title" href="#" style="color:purple;">Design team weekly meeting</a></h1></span>
                <span><h3><a id="title_description" href="#" style="color:gray;">The layout of the video chat room...</a></h3></span>
            </div>
        </div>


        <div class="side_content col-lg-4">
            <h1>Side_Content</h1>
<!--                <div class="scroll-pane" style="width:100%; height:400px; overflow:auto;">
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
                    Quisque et massa leo, sit amet adipiscing nisi. Mauris vel condimentum dolor. Duis quis ullamcorper
                    eros. Proin metus dui, facilisis id bibendum sed, aliquet non ipsum. Aenean pulvinar risus eu nisi
                    dictum eleifend. Maecenas mattis dolor eget lectus pretium eget molestie libero auctor. Praesent sit
                    amet tellus sed nibh convallis semper. Curabitur nisl odio, feugiat non dapibus sed, tincidunt ut
                    est. Nullam erat velit, suscipit aliquet commodo sit amet, mollis in mauris. Curabitur pharetra
                    dictum interdum. In posuere pretium ultricies. Curabitur volutpat eros vehicula quam ultrices
                    varius. Proin volutpat enim a massa tempor ornare. Sed ullamcorper fermentum nisl, ac hendrerit sem
                    feugiat ac. Donec porttitor ullamcorper quam. Morbi pretium adipiscing quam, quis bibendum diam
                    congue eget. Sed at lectus at est malesuada iaculis. Sed fermentum quam dui. Donec eget ipsum dolor,
                    id mollis nisi. Donec fermentum vehicula porta.
                    </p>
                    <p>
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                    Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero
                    sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.
                    Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed,
                    commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros
                    ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis.
                    Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna
                    eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis
                    luctus, metus
                    </p>
                    <p>
                    Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                    Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit
                    amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.
                    </p>
            </div>-->
            <div class="chat-form">
                <div class="form-group">
                    <textarea class="form-control" id="output_message" rows="20" text="asdfae"></textarea>
                    <form class="form-inline">
                        <button type="button" class="btn btn-primary" style="float:right; width:20%;" onclick="whenClickSend">Send</button>
                        <!--Send message to server-->
                        <!--<button type="button" class="btn btn-primary" style="float:right; width:20%;">Send</button>-->
                        <input type="text" class="form-control" id="input_message" placeholder="Input your message" style="width:80%;">
                    </form>
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

            

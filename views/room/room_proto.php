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
                var input_message;
                var output_message;

                input_message = document.getElementById('input_message').value;
                output_message = document.getElementById('output_message').value;

                if(input_message !== ''){
                console.log(input_message);
                console.log(output_message);
                
                output_message += input_message+'\n';
                document.getElementById('input_message').value = '';
                document.getElementById('output_message').value = output_message;
                }
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
            </div>
        </div>


        <div class="main_content col-lg-8">
            <div class="header">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <a id="title" href="#">
                                    <h2 style="text-align:left">The title</h2>
                                </a>
                                <a id="title_decription" href="#">
                                    <h3 style="text-align:left">The layout of the video chat room...</h3>
                                </a>

 
<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>
<a href="#myModal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
                            </td>
                            <td align="right">
                                <table>
                                    <td><span id="invite_label" class="label label-important">Invite People </td>
                                    <td><a id="invite_email" href="#"/>Email</td>
                                    <td><a id="invite_facebook" href="#"/>face</td>
                                    <td><a id="invite_twit" href="#"/>Twit</td>
                                    <td><a id="invite_url" href="#"/>Link</td>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="title_inputform">
            
        </div>

        <div class="side_content col-lg-4">
            <h1>Side_Content</h1>
            <div class="chat-form" style="padding-bottom:40px;">
                <div class="form-group">
                    <textarea class="form-control" id="output_message" rows="20" text="asdfae"></textarea>
                    <form class="form-inline">
                        <button type="button" class="btn btn-primary" style="float:right; width:20%;" onclick="whenClickSend()">Send</button>
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

            

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
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/foot.css">
        
        <style>
            .sns btn{
                float:right;
            }
        </style>
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
            var email_cnt = 0;

            function whenClickMic(){
                $('#menu_mic i').toggleClass('glyphicon glyphicon-volume-off glyphicon glyphicon-volume-up');
            }

            function whenClickScreen(){
                $('#menu_screen i').toggleClass('glyphicon glyphicon-eye-close glyphicon glyphicon-eye-open');
            }


            function whenClickExit(){
            }

            function whenClickSend(){
                var input_message;
                var output_message;

                input_message = document.getElementById('input_message').value;
                output_message = document.getElementById('output_message').value;

                if(input_message !== ''){                                                    
                    output_message += input_message+'\n';
                    document.getElementById('input_message').value = '';
                    document.getElementById('output_message').value = output_message;
                }
            }

            function whenClickEdit(){
                var title;
                var description;

                $('#edit_title').val('');
                $('#edit_description').val('');

                title = $('#title').html();
                description = $('#description').html();

                $('#edit_title').attr("placeholder", title);
                $('#edit_description').attr("placeholder", description);
            }

             function whenClickEditSave(){
                 var title;
                 var description;
                 var edit_title;
                 var edit_description;


                 //value initializing
                
                 title = $('#title').html();
                 description = $('#description').html();
                                                 
                 edit_title = $('#edit_title').val();
                 edit_description = $('#edit_description').val();

                 if(edit_title !== '')
                     $('#title').html(edit_title);

                 if(edit_description !== '')
                     $('#description').html(edit_description);
             }

            function whenClickAddEmail(){
                var group = document.createElement("span"); 
                var txt = document.createElement("input");
                var btn_span = document.createElement("span");
                var btn = document.createElement("button");
                var panel = document.getElementById("email_set");
                var email = $('#email').val();

                if(CheckEmailForm(email) === false){
                    console.log("Empty");
                    return;
                }

                group.setAttribute("class", "input-group");
                group.setAttribute("id","Test");

                txt.setAttribute("type", "text");
                txt.setAttribute("class", "form-control");
                txt.setAttribute("value", email);
                txt.setAttribute("id", email_cnt);

                btn_span.setAttribute("class", "input-group-btn");
                btn.setAttribute("class", "btn-default");
                btn.setAttribute("type", "button");
                btn.setAttribute("onclick", "whenClickDelEmail(this)");
                btn.setAttribute("id", email_cnt);
                btn.innerHTML = "&times";
                btn_span.appendChild(btn);

                group.appendChild(txt);
                group.appendChild(btn_span);

                panel.appendChild(group);
                email_cnt++;
            }

            function whenClickDelEmail(obj){
                var output = obj.id;
                console.log(output);

                //Remove text component and button component
                //Text name and button name are same. So removal is twice.
                $('#'+output).remove();
                $('#'+output).remove();
                email_cnt--;
            }
            
            function whenClickInvite(obj){
                var invite_type = obj.id;
                
                if(invite_type === "invite_email")
                    $('#Email').addClass('active');
                else if(invite_type === "invite_facebook")
                    $('#Facebook').addClass('active');
                else if(invite_type === "invite_twit")
                    $('#Twitter').addClass('active');
                else if(invite_type === "invite_url")
                    $('#URL').addClass('active');
            }

            function whenClickInviteExit(){
                $('.active.tab-pane').removeClass('active');
            }

            function CheckEmailForm(obj){
                var obj_len = obj.length;
                console.log(obj[0]);

                for(var i = 0; i < obj_len; i++){
                    if(obj[i] === " ")
                        return false;

                    if(obj[i] === "@")
                        break;
                }

                if(obj.length === 0)
                    return false;
                else if(i === obj.length)
                    return false;
                else
                    return true;

            }
        </script>
        <div class="header">
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
        <div class="main_content col-lg-8">
            <div id="main_head">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <h2 id="title" style="text-align:left">The title</h2>
                                <h3 id="description" style="text-align:left">The layout of the video chat room...</h3>
                                    <a data-toggle="modal" href="#editModal" onclick="whenClickEdit()">
                                        <i class="glyphicon glyphicon-link"></i>
                                    </a>
                            </td>
                            <td align="right">
                                <table>
                                    <td><span id="invite_label" class="label label-important">Invite People </span></td>
                                    <td>
                                        <a id="invite_email" data-toggle="modal" href="#inviteModal" onclick="whenClickInvite(this)">
                                            <i class="glyphicon glyphicon-envelope"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a id="invite_facebook" data-toggle="modal" href="#inviteModal" onclick="whenClickInvite(this)">
                                            face
                                        </a>
                                    </td>
                                    <td>
                                        <a id="invite_twit" data-toggle="modal" href="#inviteModal" onclick="whenClickInvte(this)">
                                            Twit
                                        </a>
                                    </td>
                                    <td>
                                        <a id="invite_url" data-toggle="modal" href="#inviteModal" onclick="whenClickInvte(this)">
                                            <i class="glyphicon glyphicon-link"></i>
                                        </a>
                                    </td>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="container"> 
                <div id="largeVideoContainer">
                    <video id="focusedVideo" class="largeVideo" autoplay="autoplay" muted="true"/>
                </div>
                <div id="smallVideoContainer">
                    <video id="localVideo" class="smallVideo" autoplay="autoplay" muted="true"/>
                </div>
            </div>
        </div>
        <div class="side_content col-lg-4">
            <h1>Side_Content</h1>
            <div class="chat-form" style="padding-bottom:40px;">
                <div class="form-group">
                    <textarea class="form-control" id="output_message" rows="20" text="asdfae"></textarea>
                    <form class="form-inline">
                        <button type="button" class="btn btn-primary" style="float:right; width:20%;" onclick="whenClickSend()">Send</button>
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
        </div>

        <div class="modal fade" id="editModal">
            <div class="modal-dialog" id="editModalForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td>
                                    Title : 
                                </td>
                                <td width="80%">
                                    <input type="text" id="edit_title" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Description : 
                                </td>
                                <td>
                                    <input type="text" id="edit_description" class="form-control">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="whenClickEditSave()">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" id="inviteModal">
            <div class="modal-dialog" id="inviteModalForm" style="height:500px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Invite People</h4>
                    </div><!--modal-header-->
                    <div class="modal-body">
                        <div class="row">
                            <ul class="nav nav-pills nav-stacked col-lg-2" id="inviteTab" style="text-align:left;">
                                <li <a href="#Email" data-toggle="tab">Email</a></li>                                           
                                <li><a href="#Facebook" data-toggle="tab">Facebook</a></li>  
                                <li><a href="#Twitter" data-toggle="tab">Twitter</a></li>   
                                <li><a href="#URL" data-toggle="tab">URL</a></li>   
                            </ul>
                            <div class="tab-content col-lg-8">
                                <div class="tab-pane" id="Email">
                                    <table>
                                        <tr>
                                            <td>Send invitation by E-mail</td>
                                        </tr>
                                        <tr>
                                            <div id="email_set">
                                            </div> 
                                        </tr>
                                        <tr>
                                            <td><input type="text" id="email" class="form-control"></td>
                                            <td><button type="button" class="btn btn-default" id="btn_add" onclick="whenClickAddEmail()">Add</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" id="btn_send">Send Invitation</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="Facebook">
                                    <table width="100%">
                                        <tr>
                                            <td>Invite Facebook friends</td>
                                        </tr>
                                        <tr>
                                            <td>Friends:</td>
                                        </tr>
                                        <tr>
                                            <div id="facebook_set">
                                            </div> 
                                        </tr>
                                        <tr>
                                            <td>Message:</td>
                                        </tr>
                                        <tr>
                                            <td><textarea class="form-control" id="face_message" rows="3"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" id="btn_face">Send Message</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="Twitter">
                                    <table width="100%">
                                        <tr>
                                            <td>Send a direct message to Twitter Friends</td>
                                        </tr>
                                        <tr>
                                            <td>Friends:</td>
                                        </tr>
                                        <tr>
                                            <div id="twit_set">
                                            </div> 
                                        </tr>
                                        <tr>    
                                            <td>Message:</td>
                                        </tr>
                                        <tr>
                                            <td><textarea class="form-control" id="twit_message" rows="3"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" id="btn_twit">Send Message</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="URL">
                                    <table width="100%">
                                        <tr>
                                            <td>Copy the following URL and share it to invite people</td>
                                        </tr>
                                        <tr>
                                            <td>URL:</td>
                                        </tr>
                                        <tr>
                                            <td><textarea class="form-control" id="url_message" rows="3"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" id="btn_url">Send Message</button></td>
                                        </tr>
                                    </table>
                                </div>            
                            </div>
                        </div>
                    </div><!--modal-body-->
                </div><!--modal-content-->
            </div><!--modal-dialog-->
        </div><!--modal-->
    </body>

    <script src="<?= $GLOBALS['sr_root'] ?>/js/room.js"></script>

<!--footer id="footer">
</footer-->

</html>

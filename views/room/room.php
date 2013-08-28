<!DOCTYPE html>
<html>
    <head>
        <title><?= $context['room_ui_title'] ?></title>

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
            .navbar-brand {
                font-weight: bold;
                font-size: 19pt;
                -webkit-transition: all .3s linear;
                -moz-transition: all .3s linear;
                transition: all .3s linear;
            }
            .navbar-nav > li > a {
                padding-top: 13px;
                padding-bottom: 0px;
                -webkit-transition: all .3s linear;
                -moz-transition: all .3s linear;
                transition: all .3s linear;
            }
            .glyphicon {
                font-size: 22px;
            }
            .glyphicon-volume-off, .glyphicon-volume-up {
                font-size: 23px;
            }
            .glyphicon-link {
                font-size: 21px;
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

            function whenClickMicToggle(){
                $('#menu_mic i').toggleClass('glyphicon glyphicon-volume-off glyphicon glyphicon-volume-up');
            }

            function whenClickScreenToggle(){
                $('#menu_screen i').toggleClass('glyphicon glyphicon-eye-close glyphicon glyphicon-eye-open');
            }


            function whenClickExit(){
            }

            function whenClickChatSend(){
                var input_message;
                var output_message;

                input_message = document.getElementById('chat_input').value;
                output_message = document.getElementById('chat_output').value;

                if(input_message !== ''){                                                    
                    output_message += input_message+'\n';
                    document.getElementById('chat_input').value = '';
                    document.getElementById('chat_output').value = output_message;
                }
            }

            function whenClickTitleEdit(){
                var title;
                var description;

                $('#edit_title').val('');
                $('#edit_description').val('');

                title = $('#title').html();
                description = $('#description').html();

                $('#edit_title').attr("placeholder", title);
                $('#edit_description').attr("placeholder", description);
            }

             function whenClickTitleSave(){
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

                if(checkEmailForm(email) === false){
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
                    $('#tab_email').addClass('active');
                else if(invite_type === "invite_facebook")
                    $('#tab_acebook').addClass('active');
                else if(invite_type === "invite_twitter")
                    $('#tab_twitter').addClass('active');
                else if(invite_type === "invite_url")
                    $('#tab_url').addClass('active');
            }

            //Activating tab-pane make inactive.
            function whenClickInviteExit(){
                $('.active.tab-pane').removeClass('active');
            }

            function checkEmailForm(obj){
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
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav navbar-nav">
                        <li>
                            <a id="menu_screen" href="#" onclick="whenClickScreenToggle()">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </a>
                        </li>
                        <li>
                            <a id="menu_mic" href="#" onclick="whenClickMicToggle()">
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
                </div>
            </div>
        </div>

        <div class="main_content col-lg-9">
            <div id="main_head">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td>
                                <h2 id="title" style="text-align:left">The title</h2>
                                <h3 id="description" style="text-align:left">The layout of the video chat room...</h3>
                                    <a data-toggle="modal" href="#editModal" onclick="whenClickTitleEdit()">
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
                                        <a id="invite_twitter" data-toggle="modal" href="#inviteModal" onclick="whenClickInvte(this)">
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
        <div class="side_content col-lg-3">
            <div class="chat-form" >
                <div class="form-group">
                    <p id="text">
                        <textarea class="form-control" id="chat_output" rows="20" text="asdfae"></textarea>
                        <input type="text" class="form-control" id="chat_input" placeholder="Input your message" >
                    </p>
                </div>
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
                        <button type="button" class="btn btn-primary" onclick="whenClickTitleSave()">Save changes</button>
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
                                <li><a href="#tab_email" data-toggle="tab">Email</a></li>                                           
                                <li><a href="#tab_facebook" data-toggle="tab">Facebook</a></li>  
                                <li><a href="#tab_twitter" data-toggle="tab">Twitter</a></li>   
                                <li><a href="#tab_url" data-toggle="tab">URL</a></li>   
                            </ul>
                            <div class="tab-content col-lg-8">
                                <div class="tab-pane" id="tab_email">
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
                                            <td><button type="button" class="btn btn-default" id="btn_addemail" onclick="whenClickAddEmail()">Add</button></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" id="btn_email">Send Invitation</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_facebook">
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
                                            <td><button type="button" class="btn btn-primary" id="btn_facebook">Send Message</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_twitter">
                                    <table width="100%">
                                        <tr>
                                            <td>Send a direct message to Twitter Friends</td>
                                        </tr>
                                        <tr>
                                            <td>Friends:</td>
                                        </tr>
                                        <tr>
                                            <div id="twitter_set">
                                            </div> 
                                        </tr>
                                        <tr>    
                                            <td>Message:</td>
                                        </tr>
                                        <tr>
                                            <td><textarea class="form-control" id="twitter_message" rows="3"></textarea></td>
                                        </tr>
                                        <tr>
                                            <td><button type="button" class="btn btn-primary" id="btn_twitter">Send Message</button></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tab_url">
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

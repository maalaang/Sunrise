<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
        <meta charset='utf-8'> 

        <title><?= $context['room_ui_title'] ?></title>
    
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/adapter.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/sunrise-channel.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/sunrise-connection.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.0.min.js"></script>

        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.0.min.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/room.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/header.css">

        <script type="text/javascript">
            var channelServer = '<?= $context['channel_server'] ?>';
            var channelToken = '<?= $context['room']->channel_token ?>';
            var roomId = '<?= $context['room']->id ?>';
            var roomLink = '<?= $context['room_link'] ?>';
            var roomName = '<?= $context['room']->name ?>';
            var roomTitle = '<?= $context['room']->title ?>';
            var roomDescription = '<?= $context['room']->description ?>';
            var roomApi = '<?= $context['room_api'] ?>';
            var roomIsOpen = <?= $context['room']->is_open ?>;
            var roomPassword = '<?= $context['room']->password?>';
            var isRegisteredUser = <?= $context['is_registered_user'] ?>;
            var userId = <?= $context['user_id'] ?>;
            var userName = '<?= $context['user_name'] ?>';
            var chatName = '<?= $context['chat_name'] ?>';
        </script>
    </head>

    <body>
        <div class="header">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
                <div class="nav-collapse collapse pull-right">
                    <ul class="nav navbar-nav">
                        <li>
                            <a id="menu_screen" href="#" onclick="whenClickScreenToggle()">
                                <i class="control_icon icon-large icon-eye-open"></i>
                            </a>
                        </li>
                        <li>
                            <a id="menu_mic" href="#" onclick="whenClickMicToggle()">
                                <i class="control_icon icon-large icon-microphone"></i>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" id="menu_sns" href="#">
                                <i class="control_icon icon-large icon-share-sign"></i>
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
                                <i class="control_icon icon-large icon-remove"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main_content col-9">
            <div class="room_head">
                <div class="room_info col-6">
                    <div class="room_title_wrapper">
                        <input id="room_title" type="text" placeholder="Room title" value="<?= $context['room']->title ?>"/>
                    </div>
                    <div class="room_description_wrapper">
                        <input id="room_description" type="text" placeholder="Room description" value="<?= $context['room']->description ?>"/>
                    </div>
                </div>
                <div class="room_invite col-6">
                    <span class="label label-important invite_label">Invite People:</span>
                    <span class="invite_icons_wrapper">
                        <a id="invite_email" data-toggle="modal" href="#inviteModal" onclick="whenClickInvite(this)">
                            <i class="invite_icon icon-large icon-envelope"></i>
                        </a>
                        <a id="invite_facebook" data-toggle="modal" href="#inviteModal" onclick="whenClickInvite(this)">
                            <i class="invite_icon icon-large icon-facebook"></i>
                        </a>
                        <a id="invite_twitter" data-toggle="modal" href="#inviteModal" onclick="whenClickInvte(this)">
                            <i class="invite_icon icon-large icon-twitter"></i>
                        </a>
                        <a id="invite_url" data-toggle="modal" href="#inviteModal" onclick="whenClickInvte(this)">
                            <i class="invite_icon icon-large icon-link"></i>
                        </a>
                    </span>
                    <span class="label label-important invite_label invite_label_right">Opan Status:</span>
                    <span class="invite_icons_wrapper">
                        <a id="invite_open_status" data-toggle="modal" href="#openStatusModal">
                        <i class="invite_icon icon-large <?= $context['room']->is_open ? 'icon-unlock' : 'icon-lock' ?>"></i>
                        </a>
                    </span>
                </div>
            </div>
            <div class="room_videos">
                <div id="largeVideoContainer">
                    <video id="focusedVideo" class="largeVideo" autoplay="autoplay" muted="true"/>
                </div>
                <div id="smallVideoContainer">
                    <video id="localVideo" class="smallVideo" autoplay="autoplay" muted="true"/>
                </div>
            </div>
        </div>
        <div class="side_content col-3">
            <div class="chat_content_wrapper">
                <textarea class="chat_content" id="chat_content" ></textarea>
            </div>
            <div class="chat_input_wrapper">
                <!--button type="button" class="btn btn-primary" style="float:right; width:20%;" onclick="whenClickChatSend()">Send</button-->
                <textarea class="chat_input" id="chat_input" placeholder=""></textarea>
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
                            <ul class="nav nav-pills nav-stacked col-2" id="inviteTab" style="text-align:left;">
                                <li><a href="#tab_email" data-toggle="tab">Email</a></li>                                           
                                <li><a href="#tab_facebook" data-toggle="tab">Facebook</a></li>  
                                <li><a href="#tab_twitter" data-toggle="tab">Twitter</a></li>   
                                <li><a href="#tab_url" data-toggle="tab">URL</a></li>   
                            </ul>
                            <div class="tab-content col-8">
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

        <!-- Open Status Modal -->
        <div class="modal fade" id="openStatusModal">
            <div class="modal-dialog" style="height:500px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Open Status</h4>
                    </div>
                    <div class="modal-body open_status_modal_body">
                        <div>
                            <div>
                                <label for="input_access_control" class="col-lg-4 control-label">Access Control</label>
                                <div class="col-lg-8">
                                    <div class="btn-group access_control_btn" id="input_access_control">
                                        <button type="button" class="btn btn-default btn-small" id="btn_public">Public</button>
                                        <button type="button" class="btn btn-default btn-small" id="btn_private">Private</button>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <label for="room_password" class="col-lg-4 control-label">Password</label>
                                    <div class="col-lg-8">
                                        <input type="password" class="form-control" id="room_password" placeholder="Password" value="<?= $context['room']->password ?>">
                                    </div>
                                </div>
                                <div>
                                    <div class="col-lg-8 col-offset-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="room_password_hide" checked> Hide Password
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-8 col-offset-4 open_status_save">
                                    <button id="open_status_save" type="submit" class="btn btn-default btn-small open_status_save_btn has-spinner">
                                        <span class="spinner"><i class="icon-spin icon-refresh"></i></span>
                                        <span id="open_status_save_text">Save</span>
                                     </button>
                                    <button id="open_status_cancel" type="submit" class="btn btn-default btn-small open_status_save_btn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="<?= $GLOBALS['sr_root'] ?>/js/room.js"></script>


</html>

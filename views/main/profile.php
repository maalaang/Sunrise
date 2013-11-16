<!DOCTYPE html>
<html>
    <head>
        <? include("views/meta.php"); ?>

        <title>Sunrise</title>

        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/profile.css" rel="stylesheet">

        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
        <script>
            function whenSaveBasic() {
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('profile_email').value;

                var nameRegex = new RegExp(<?= sr_regex('name') ?>);
                var emailRegex = new RegExp(<?= sr_regex('email') ?>);

                if(!nameRegex.test(first_name)) {
                    showMessage('basic', 'Please enter your name.');
                    $('#first_name').focus();
                    return false;
                }
                if(!nameRegex.test(last_name)) {
                    showMessage('basic', 'Please enter your name');
                    $('#last_name').focus();
                    return false;
                }
                if(!emailRegex.test(email)) {
                    showMessage('basic', 'Please enter a valid email address.');
                    $('#profile_email').focus();
                    return false;
                }

                document.basic_form.submit();
            }

            function whenSavePassword() {
                var old_password = document.getElementById('old_password').value;
                var new_password = document.getElementById('new_password').value;
                var repeat_password = document.getElementById('repeat_password').value;

                var passwordRegex = new RegExp(<?= sr_regex('password') ?>);

                if(!passwordRegex.test(old_password)) {
                    showMessage('password', 'Please enter a valid pasword.<br />Password should be alphanumeric.');
                    $('#old_password').focus();
                    return false;
                }
                if(!passwordRegex.test(new_password)) {
                    showMessage('password', 'Please enter a valid pasword.<br />Password should be alphanumeric.');
                    $('#new_password').focus();
                    return false;
                }
                if(new_password != repeat_password) {
                    showMessage('password', 'Please repeat your password.');
                    $('#repeat_password').focus();
                    return false;
                }

                document.password_form.submit();
            }

            function whenDeleteAccount() {
                $.ajax({
                    url: "<?= sr_home_path() ?>/d/main/profile/",
                    type: 'POST',
                    dataType: 'JSON',
                    data: { which: 'delete' },
                    success: function (data) {
                        location.replace("<?= sr_home_path() ?>");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Ajax Error');
                    },
                });
            }

            function showMessage(which, str) {
                $('#' + which + '-div .alert').attr('class', 'alert alert-danger');
                $('#' + which + '-div .alert').html(str);
                $('#' + which + '-div .alert').addClass('alert-visible');
            }
        </script>
    </head>
    <body>
        <? 
            if (sr_is_signed_in()) {
                include("views/header04.php");
            } else {
                include("views/header02.php");
            }
        ?>
        <div class="container">
            <div class="col-sm-2">
                <div class="sidebar" id="sidebar-div">
                    <ul class="nav nav-pills nav-stacked">
                        <li <? if ($context['which'] == 'basic') echo 'class="active"'; ?>><a href="#basic-div" data-toggle="tab">Basic Information<span class="arrow"><b>></b></span></a></li>
                        <li <? if ($context['which'] == 'password') echo 'class="active"'; ?>><a href="#password-div" data-toggle="tab">Change Password<span class="arrow"><b>></b></span></a></li>
                        <li><a href="#delete-div" data-toggle="tab">Delete Account<span class="arrow"><b>></b></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="profile" id="profile-div">
                    <div class="tab-content">

                        <div class="tab-pane <? if ($context['which'] == 'basic') echo 'active'; ?>" id="basic-div">
                            <form action="<?= sr_home_path() ?>/d/main/profile/" name="basic_form" id="basic_form" method="post">
                                <input type="hidden" id="which" name="which" value="basic" />
                                <fieldset>
                                    <legend>Basic Information</legend>
                                    <table>
                                        <tr>
                                            <td><input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value=<?= $context['first_name'] ?> /></td>
                                            <td><input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value=<?= $context['last_name'] ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="sep"><input type="text" class="form-control" id="profile_email" name="profile_email" placeholder="Email" value=<?= $context['email'] ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="sep">
                                                <div class="well well-sm">
                                                    <? if ($context['is_admin']) { ?>
                                                    <span class="glyphicon glyphicon-user" style="color:steelblue"></span> &nbsp;<b>Administrator</b><br /> 
                                                    <? } ?>
                                                    <? if ($context['is_authorized']) { ?>
                                                    <span class="glyphicon glyphicon-ok" style="color:green"></span> &nbsp;<b>You were Authorized</b><br />
                                                    <? } else { ?>
                                                    <span class="glyphicon glyphicon-remove" style="color:red"></span> &nbsp;<b>You were NOT Authorized</b><br />
                                                    <? } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><input type="button" class="btn btn-primary" value="Save chenges" onclick="whenSaveBasic()" /></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </form>
                            <div class="alert <? if ($context['which'] == 'basic' && $context['result'] === 1) echo 'alert-success '; else echo 'alert-danger '; if ($context['which'] == 'basic' && $context['result']) echo 'alert-visible'; ?>" id="error">
                                <?  if ($context['which'] == 'basic') echo $context['msg']; ?>
                            </div>
                        </div>

                        <div class="tab-pane <? if ($context['which'] == 'password') echo 'active'; ?>" id="password-div">
                            <form action="<?= sr_home_path() ?>/d/main/profile/" name="password_form" id="password_form" method="post">
                                <input type="hidden" id="which" name="which" value="password" />
                                <fieldset>
                                    <legend>Change Password</legend>
                                    <table>
                                        <tr>
                                            <td class="sep"><input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password" /></td>
                                        </tr>
                                        <tr>
                                            <td><input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" /></td>
                                        </tr>
                                        <tr>
                                            <td class="sep"><input type="password" class="form-control"id="repeat_password" name="repeat_password" placeholder="Repeat Password" /></td>
                                        </tr>
                                        <tr>
                                            <td><input type="button" class="btn btn-primary" value="Change my password" onclick="whenSavePassword()" /></td>
                                        </tr>
                                    </table>
                                </fieldset>
                            </form>
                            <div class="alert <? if ($context['which'] == 'password' && $context['result'] === 1) echo 'alert-success '; else echo 'alert-danger '; if ($context['which'] == 'password' && $context['result']) echo 'alert-visible'; ?>" id="error">
                                <?  if ($context['which'] == 'password') echo $context['msg']; ?>
                            </div>
                        </div>

                        <div class="tab-pane" id="delete-div">
                            <legend>Delete My Account</legend>
                            <table>
                                <tr>  
                                    <td>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <p>Are you sure to remove your account permanently?</p>
                                                <p><b>It cannot be recovered.</b></p>
                                            </div> 
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><input type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete-modal" value="I'm sure. Delete my account" /></td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Delete Your Account</h4>
                </div>
                <div class="modal-body">
                    <h4>It cannot be recovered!<br /><br />Are you really sure?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="whenDeleteAccount()">Yes, I'm really sure.</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <? include("views/footer00.php") ?>
    </div>
</body>
</html>

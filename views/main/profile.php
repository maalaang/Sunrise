<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/profile.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
        <script>
            function whenBack() {
                window.location='<?= sr_home_path() ?>';
            }
            function whenSave() {
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('profile_email').value;
                var password = document.getElementById('profile_password').value;
                var repeat_password = document.getElementById('repeat_password').value;

                var nameRegex = new RegExp(<?= sr_regex('name') ?>);
                var emailRegex = new RegExp(<?= sr_regex('email') ?>);
                var passwordRegex = new RegExp(<?= sr_regex('password') ?>);

                if(!nameRegex.test(first_name)) {
                    showMessage('Please enter your name.');
                    $('#first_name').focus();
                    return false;
                }
                if(!nameRegex.test(last_name)) {
                    showMessage('Please enter your name');
                    $('#last_name').focus();
                    return false;
                }
                if(!emailRegex.test(email)) {
                    showMessage('Please enter a valid email address.');
                    $('#profile_email').focus();
                    return false;
                }
                if(!passwordRegex.test(password)) {
                    showMessage('Please enter a valid pasword.<br />Password should be alphanumeric.');
                    $('#profile_password').focus();
                    return false;
                }
                if(password != repeat_password) {
                    showMessage('Please repeat your password.');
                    $('#repeat_password').focus();
                    return false;
                }

                document.profile_form.submit();
            }

            function showMessage(str) {
                $('.alert').html(str);
                $('.alert').addClass('alert-visible');
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

        <div class="container profile" id="profile-div">
            <form action="<?= sr_home_path() ?>/d/main/profile/" name="profile_form" id="profile_form" method="post">
                <fieldset>
                    <legend>Profile</legend>
                    <table>
                        <tr>
                            <td><input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value=<?= $context['first_name'] ?> /></td>
                            <td><input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value=<?= $context['last_name'] ?> /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text" class="form-control" id="profile_email" name="profile_email" placeholder="Email" value=<?= $context['email'] ?> /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="password" class="form-control" id="profile_password" name="profile_password" placeholder="Password" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="sep"><input type="password" class="form-control"id="repeat_password" name="repeat_password" placeholder="Repeat Password" /></td>
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
                            <td><input type="button" class="btn btn-primary" id="btn_back" name="btn_back" value="Back to main" onclick="whenBack()" /></td>
                            <td><input type="button" class="btn btn-primary" id="btn_save" name="btn_save" value="Save modified" onclick="whenSave()" /></td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <div class="alert <? if ($context['result'] === 1) echo 'alert-success '; else echo 'alert-danger '; if ($context['result']) echo 'alert-visible'; ?>" id="error">
                <?php
                    echo $context['msg'];
                ?>
            </div>
        </div>


        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

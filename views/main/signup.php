<!DOCTYPE html>
<html>
    <head>
        <? include("views/meta.php"); ?>

        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/signup.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
        <script>
            function whenSignup() {
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('signup_email').value;
                var password = document.getElementById('signup_password').value;
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
                    $('#signup_email').focus();
                    return false;
                }
                if(!passwordRegex.test(password)) {
                    showMessage('Please enter a valid pasword. Password should be alphanumeric.');
                    $('#signup_password').focus();
                    return false;
                }
                if(password != repeat_password) {
                    showMessage('Please repeat your password.');
                    $('#repeat_password').focus();
                    return false;
                }

                document.signup_form.submit();
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

        <div class="container signup" id="signup-div">
            <form action="<?= $GLOBALS['sr_root'] ?>/d/main/signup/" name="signup_form" id="signup_form" method="post">
                <fieldset>
                    <legend>Create a new account</legend>
                    <table>
                        <tr>
                            <td><input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" autofocus /></td>
                            <td><input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" /></td>
                        </tr>
                        <tr>
                             <td colspan="2"><input type="text" class="form-control" id="signup_email" name="signup_email" placeholder="Email" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="password" class="form-control" id="signup_password" name="signup_password" placeholder="Password" /></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="sep"><input type="password" class="form-control"id="repeat_password" name="repeat_password" placeholder="Repeat Password" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="button" class="btn btn-primary" id="btn_signup" name="btn_signup" value="Sign up" onclick="whenSignup()" /></td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <div class="alert alert-danger <?php if ($context['result']) { echo 'alert-visible'; } ?>" id="error">
                <?php
                    if ($context['result'] !== 0) {
                        echo $context['msg'];
                    }
                ?>
            </div>
        </div>


        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

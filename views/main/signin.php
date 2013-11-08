<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/signin.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
        <script>
            function whenSignin(e) {
                var email = document.getElementById('signin_email').value;
                var password = document.getElementById('signin_password').value;
            
                var emailRegex = new RegExp(<?= sr_regex('email') ?>);
                var passwordRegex = new RegExp(<?= sr_regex('password') ?>);

                if(!emailRegex.test(email)) {
                    showMessage('Please enter a valid e-mail address.');
                    return false;
                }
                if(!passwordRegex.test(password)) {
                    showMessage('Please enter a valid password. (Password should be alphanumeric)');
                    return false;
                }

                document.signin_form.submit();
            }

            function whenClickSignup(e) {
                window.location.replace("<?= $GLOBALS['sr_root'] ?>/d/main/signup/");
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
                include("views/header03.php");
            }
        ?>

        <div class="container signin">
            <form action="<?= $GLOBALS['sr_root'] ?>/d/main/signin/" name="signin_form" id="signin_form" method="post">
                <fieldset>
                    <legend>Sign In</legend>
                    <table>
                        <tr>
                            <td><input type="text" class="form-control" id="signin_email" name="signin_email" placeholder="Email" autofocus /></td>
                        </tr>
                        <tr>
                            <td class="sep"><input type="password" class="form-control" id="signin_password" name="signin_password" placeholder="Password" /></td>
                        </tr>
                        <tr>
                            <td><input type="button" class="btn btn-primary" id="btn_signin" name="btn_signin" value="Sign in" onclick="whenSignin(event)" /></td>
                        </tr>
                        <tr>
                            <td><input type="button" class="btn btn-primary" id="btn_signup" name="btn_signup" value="Sign up" onclick="whenClickSignup(event)" /></td>
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

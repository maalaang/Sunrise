<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
        <script>
            function whenSignin(e) {
                var email = document.getElementById('signin_email').value;
                var password = document.getElementById('signin_password').value;
            
                var emailRegex = new RegExp(<?= sr_regex('email') ?>);
                var passwordRegex = new RegExp(<?= sr_regex('password') ?>);

                if(!emailRegex.test(email)) {
                    alert('Check Email Form');
                    return false;
                }
                if(!passwordRegex.test(password)) {
                    alert('Check Password Form');
                    return false;
                }

                document.signin_form.submit();
            }
            function whenSignup(e) {
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('signup_email').value;
                var password = document.getElementById('signup_password').value;
                var repeat_password = document.getElementById('repeat_password').value;

                var nameRegex = new RegExp(<?= sr_regex('name') ?>);
                var emailRegex = new RegExp(<?= sr_regex('email') ?>);
                var passwordRegex = new RegExp(<?= sr_regex('password') ?>);

                if(!nameRegex.test(first_name) || !nameRegex.test(last_name)) {
                    alert('Check Name Form');
                    return false;
                }
                if(!passwordRegex.test(password)) {
                    alert('Check Password Form');
                    return false;
                }
                if(!emailRegex.test(email)) {
                    alert('Check Email Form');
                    return false;
                }
                if(password != repeat_password) {
                    alert('Check Repeat Password');
                    return false;
                }

                document.signup_form.submit();
            }
        </script>
        <style>
            body {
                padding-top: 70px;
            }
            #signup-div{
                width:300px;
                margin:100px auto;
                text-align:left;
            }
        </style>
    </head>
    <body>
        <? 
            if (sr_is_signed_in()) {
                include("views/header04.php");
            } else {
                include("views/header02.php");
            }
        ?>

        <div class="container" id="signup-div">
            <form action="<?= $GLOBALS['sr_root'] ?>/d/main/signup/" name="signup_form" id="signup_form" method="post">
                <fieldset>
                    <legend>Sign Up</legend>
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
                            <td colspan="2"><input type="password" class="form-control"id="repeat_password" name="repeat_password" placeholder="Repeat Password" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="button" class="btn btn-primary" id="btn_signup" name="btn_signup" style="width:300px;" value="Sign Up" onclick="whenSignup(event)" /></td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>

        <div id="error" style="text-align:center;">
            <?php
                if ($context['result'] !== 0) {
                    echo $context['msg'];
                } else {
                    // for test
                    echo 'Signup done';
                }
            ?>
        </div>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

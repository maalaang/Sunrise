<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css">
        <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/foot.css">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script>
            function whenSubmit(e) {
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
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
            #signup-div{
                width:300px;
                margin:100px auto;
                text-align:left;
            }
            #footer{
                bottom:0;
                position:fixed;            
                width:100%;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <a class="navbar-brand" href="#">Sunrise</a>
                    <div class="nav-collapse collapse">
                        <form class="navbar-form form-inline pull-right">
                            <input type="text" placeholder="Email" class="form-control">
                            <input type="password" placeholder="Password" class="form-control">
                            <button type="submit" class="btn" id="btn_in">Sign In</button>
                            <button type="submit" class="btn" id="btn_up">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                             <td colspan="2"><input type="text" class="form-control" id="email" name="email" placeholder="Email" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="password" class="form-control" id="password" name="password" placeholder="Password" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="password" class="form-control"id="repeat_password" name="repeat_password" placeholder="Repeat Password" /></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="button" class="btn btn-primary" id="btn_signup" name="btn_signup" style="width:300px;" value="Sign Up" onclick="whenSubmit(event)" /></td>
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

        <div id="footer">
            <div class="container" align="center">
                <p>
                    <a href="#" class="foot_link">Privacy Policy</a>
                    <a href="#" class="foot_link">About Sunrise</a>
                    <a href="#" class="foot_link">Admin Page</a>
                    <a href="#" class="foot_link_right">Powered by Sunrise</a>
                </p>
            </div>
        </div>
    </body>
</html>

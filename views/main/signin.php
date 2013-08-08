<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<<<<<<< HEAD

        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/signin.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
=======
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css" rel="stylesheet">
        <script>
            function whenSubmit(e) {
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
>>>>>>> 96bd73fd21cbe5a5b9f02bf5b470cde4e5317327

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
        </script>
    </head>

    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Sunrise</a>
            </div>
        </div>
        
        <div class="container">
<<<<<<< HEAD
            <form class="form-signin" action="<?= $GLOBALS['sr_root'] ?>/controllers/signin.php" name="signin_form" id="signin_form" class="signin_form" method="post">
                <h2 class="form-signin-heading">Sign in</h2>
                <input type="text" class="input-block-level" placeholder="Email address" autofocus>
                <input type="password" class="input-block-level" placeholder="Password">
                <button class="btn btn-large btn-primary btn-block" type="submit">Sign in</button>
            </form>
=======
            <div class="jumbotron">
                <label>Sign in</label> 
                <form action="<?= $GLOBALS['sr_root'] ?>/d/main/signin/" name="signin_form" id="signin_form" method="post">
                    <input type="text" id="email" name="email" placeholder="Email" /><br />
                    <input type="password" id="password" name="password" placeholder="Password" /><br />
                    <input type="button" id="signin" name="signin" value="Sign In" onclick="whenSubmit(event)" />
                    <!-- For sign out test -->
                    <a href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/"><input type="button" value="Sign Out"></a>
                </form>
                <div id="error">
                    <?php
                        if ($context['result'] !== 0) {
                            echo $context['msg'];
                        } else {
                            // for test
                            echo 'Signin done';    
                        }
                    ?>
                </div>
            </div>
>>>>>>> 96bd73fd21cbe5a5b9f02bf5b470cde4e5317327
        </div>
    </body>

    <footer>
        <div class="container">
            <span><a href="#" class="foot_link"><ins>Privacy Policy</ins></a></span>
            <span><a href="#" class="foot_link"><ins>About Sunrise</ins></a></span>
            <span><a href="#" class="foot_link"><ins>Admin Page</ins></a></span>
            <span><a href="#" class="foot_link_right"><ins>Powered by Sunrise</ins></a></span>
        </div>
    </footer>
</html>

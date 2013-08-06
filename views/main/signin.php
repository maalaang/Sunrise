<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css" rel="stylesheet">
        <script>
            function whenSubmit(e) {
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;

                var email_pattern = /^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
                var password_pattern = /^[a-zA-Z0-9]+$/;

                if(!email_pattern.test(email)) {
                    alert('Check Email Form');
                    return false;
                }
                if(!password_pattern.test(password)) {
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
            <div class="jumbotron">
                <label>Sign in</label> 
                <form action="<?= $GLOBALS['sr_root'] ?>/d/main/signin/" name="signin_form" id="signin_form" method="post">
                    <input type="text" id="email" name="email" placeholder="Email" /><br />
                    <input type="password" id="password" name="password" placeholder="Password" /><br />
                    <input type="button" id="button" name="button" value="Sign In" onclick="whenSubmit(event)" />
                </form>
                <div id="error">
                    <?php
                        if ($context['result'] !== 0) {
                            echo $context['msg'];
                        } else {
                            // for test
                            echo 'signin done';    
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sunrise</title>

        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css" rel="stylesheet">

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script>
            $(document).ready(function () {
                $('input:text').bind('focus', function () {
                    $(this).val('');
                });
                $('#password').bind('focus', function () {
                    $(this).attr('type', 'password');
                });
            });
        </script>
        <style>
            .jumbotron{
                margin: 40px;
            }
        </style>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Sunrise</a>
            </div>
        </div>

        <div class="container">
            <div class="jumbotron">
                Sign In
                <form action="<?= $GLOBALS['sr_root_husky'] ?>/controllers/signin.php" name="signin_form" id="signin_form" method="post">
                    <input type="text" id="email" name="email" placeholder="Email" /><br />
                    <input type="password" id="password" name="password" placeholder="Password" /><br />
                    <button type="button" class="btn btn-primary">Sign In</button>
                </form>
            </div>
        </div>
    </body>
</html>

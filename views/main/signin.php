<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Sunrise</title>

        <link href="../css/bootstrap.css" rel="stylesheet">

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
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Sunrise</a>
            </div>
        </div>
        <form action="<?= $GLOBALS['sr_root'] ?>/models/user.php" name="signin_form" id="signin_form" method="post">
            <input type="text" id="email" name="email" value="Email" /><br />
            <input type="text" id="password" name="password" value="Password" /><br />
            <input type="submit" value="Sign In" />
        </form>
    </body>
</html>

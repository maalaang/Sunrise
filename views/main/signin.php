<!DOCTYPE html>
<html>
    <head>
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
        <h1>Sign In</h1>
        <form action="<?= $GLOBALS['sr_root'] ?>/models/user.php" name="signin_form" id="signin_form" method="post">
            <input type="text" id="email" name="email" value="Email" /><br />
            <input type="text" id="password" name="password" value="Password" /><br />
            <input type="submit" value="Sign In" />
        </form>
    </body>
</html>

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
                $('#pw > *').bind('focus', function () {
                    $(this).attr('type', 'password');
                });
            });
        </script>
    </head>
    <body>
        <h1>Sign Up</h1>
        <form action="<?= $GLOBALS['sr_root'] ?>/models/user.php" name="signup_form" id="signup_form" method="post">
            <input type="text" id="first_name" name="first_name" value="First Name" />
            <input type="text" id="last_name" name="last_name" value="Last Name" /><br />
            <input type="text" id="email" name="email" value="Email" /><br />
            <div id="pw">
                <input type="text" id="password" name="password" value="Password" /><br />
                <input type="text" id="repeat_password" name="repeat_password" value="Repeat Password" /><br />
            </div>
            <input type="submit" id="submit" name="submit" value="Sign Up" />
        </form>
    </body>
</html>

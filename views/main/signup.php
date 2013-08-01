<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Sign Up</h1>
        <form action="<?= $GLOBALS['sr_root_husky'] ?>/controllers/signup.php" name="signup_form" id="signup_form" method="post">
            <input type="text" id="first_name" name="first_name" placeholder="First Name" />
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" /><br />
            <input type="text" id="email" name="email" placeholder="Email" /><br />
            <input type="password" id="password" name="password" placeholder="Password" /><br />
            <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat Password" /><br />
            <input type="submit" id="submit" name="submit" value="Sign Up" />
        </form>
    </body>
</html>

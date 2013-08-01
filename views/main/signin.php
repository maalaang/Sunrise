<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <h1>Sign In</h1>
        <form action="<?= $GLOBALS['sr_root_husky'] ?>/controllers/signin.php" name="signin_form" id="signin_form" method="post">
            <input type="text" id="email" name="email" placeholder="Email" /><br />
            <input type="password" id="password" name="password" placeholder="Password" /><br />
            <input type="submit" id="submit" name="submit" value="Sign In" />
        </form>
    </body>
</html>

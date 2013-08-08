<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/signin.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>

        <title>Sunrise</title>
    </head>

    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Sunrise</a>
            </div>
        </div>
        
        <div class="container">
            <form class="form-signin" action="<?= $GLOBALS['sr_root'] ?>/controllers/signin.php" name="signin_form" id="signin_form" class="signin_form" method="post">
                <h2 class="form-signin-heading">Sign in</h2>
                <input type="text" class="input-block-level" placeholder="Email address" autofocus>
                <input type="password" class="input-block-level" placeholder="Password">
                <button class="btn btn-large btn-primary btn-block" type="submit">Sign in</button>
            </form>
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

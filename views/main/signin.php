<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css" rel="stylesheet">
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <style>
            .jumbotron{
                margin: 40px;
            }
        </style>

        <title>Sunrise</title>
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
                <form action="<?= $GLOBALS['sr_root'] ?>/controllers/signin.php" name="signin_form" id="signin_form" class="signin_form" method="post">
                    <input type="text" id="email" name="email" placeholder="Email" /><br />
                    <input type="password" id="password" name="password" placeholder="Password" /><br />
                    <input type="submit" id="submit" name="submit" value="Sign In" />
                </form>
            </div>
        </div>
    </body>
</html>

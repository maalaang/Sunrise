<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.0.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.0.min.js"></script>
        <script>
            function whenSignin(e) {
                var email = document.getElementById('signin_email').value;
                var password = document.getElementById('signin_password').value;
            
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
            function whenClickSignup(e) {
                window.location.replace("<?= $GLOBALS['sr_root'] ?>/d/main/signup/");
            }
        </script>
        <style>

        </style>
    </head>
    <body>
        <? 
            if (sr_is_signed_in()) {
                include("views/header04.php");
            } else {
                include("views/header01.php");
            }
        ?>

        <div class="container">
            <div class="jumbotron">
                <h1><?= $context['content']['title'] ?></h1>
                <p>
                    <?= $context['content']['description'] ?>
                </p>
                <hr/>
                <form class="room-info" action="<?= $GLOBALS['sr_root'] ?>/d/main/room/" method="GET">
                    <fieldset>
                        <table align="center" class="room-info-table">
                            <tr>
                                <td><label for="room_name">Room Name :</label></td>
                                <td><input id="room_name" name="room_name" type="text" placeholder="Developer Weekly Meeting" /></td>
                            </tr>
                            <tr>
                                <td><label for="your_name">Your Name :</label></td>
                                <td><input id="your_name" name="user_name" type="text" placeholder="Steve Kim" value="<?= sr_user_name() ?>"/></td>
                            </tr>
                        </table>
                        <p style="text-align:center; margin: 10px">
                            <button id="room-join-btn" type="submit" class="btn btn-primary btn-normal">Go to the Room!</button> 
                        </p>
                    </fieldset>
                </form>
                <hr/>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-lg-4">
                        <?= $context['content']['info1'] ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $context['content']['info2'] ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $context['content']['info3'] ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

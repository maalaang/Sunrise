<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.0.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
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
            body {
                padding: 70px;
            }
            .roomInfo label {
                float: right;
            }
            .roomInfo input {
                padding-left: 5px;
                position: relative;
                top: -4px;
                left: 10px;
            }
        </style>
    </head>
    <body>
        <? 
            if (!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
                include("views/header01.php");
            } else {
                include("views/header04.php");
            }
        ?>

        <div class="container">
            <div class="jumbotron">
                <h1>Welcome to Sunrise</h1>
                <p>
                    Sunrise is an open video conference solution based on HTML5 WebRTC.
                    You can use this software for online meeting at your company or for talking to your friends.
                    Moreover, you may provide more enhanced customer service using video chat.
                    Enjoy the next generation of the Web with Sunrise.
                    It is an open source sofrware licensed under Apache License Version 2.0.
                </p>
                <hr/>
                <form action="<?= $GLOBALS['sr_root'] ?>/d/main/room/" method="GET">
                    <fieldset>
                        <table align="center" class="roomInfo">
                            <tr>
                                <td><label for="room_name">Room Name :</label></td>
                                <td><input id="room_name" name="room_name" type="text" placeholder="ex.Sunrise Meeting" /></td>
                            </tr>
                            <tr>
                                <td><label for="your_name">Your Name :</label></td>
                                <td><input id="your_name" name="user_name" type="text" placeholder="ex.Steve Kim" /></td>
                            </tr>
                        </table>
                        <p style="text-align:center; margin: 10px">
                        <button type="submit" class="btn btn-primary btn-large">Go to the Room!</button> 
                        </p>
                    </fieldset>
                </form>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-lg-4">
                        <h2>Custom Heading 1</h2>
                        <p>Custom Message 1</p>
                    </div>
                    <div class="col-lg-4">
                        <h2>Custom Heading 2</h2>
                        <p>Custom Message 2</p>
                    </div>
                    <div class="col-lg-4">
                        <h2>Custom Heading 3</h2>
                        <p>Custom Message 3</p>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

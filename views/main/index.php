<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/jumbotron.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet">
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
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
                <div class="nav-collapse collapse">
                    <form class="navbar-form form-inline pull-right" action="<?= $GLOBALS['sr_root'] ?>/d/main/signin/" name="signin_form" id="signin_form" method="post">
                        <input type="text" id=signin_email name=signin_email placeholder="Email" class="form-control">
                        <input type="password" id=signin_password name=signin_password placeholder="Password" class="form-control">
                        <input type="button" class="btn" id="btn_signin" name="btn_signin" value="Sign In" onclick="whenSignin(event)" />
                        <input type="button" class="btn" id="btn_signup" name="btn_signup" value="Sign Up" onclick="whenClickSignup(event)" />
                    </form>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="jumbotron">
                <h1>Welcome to Sunrise</h1>
                <p>Sunrise is an open video conference solution based on HTML5 WebRTC. You can use this software for online meeting at your company or for talking to your friends. Moreover, you may provide more enhanced customer service using video chat. Enjoy the next generation of the Web with Sunrise. It is an open source sofrware licensed under Apache License Version 2.0.</p>
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

        <div class="tail_content">
            <div class="container" align="center">
                <p>
                <a href="#" class="foot_link">Privacy Policy</a>
                <a href="#" class="foot_link">About Sunrise</a>
                <a href="#" class="foot_link">Admin Page</a>
                <a href="#" class="foot_link_right">Powered by Sunrise</a>
                </p>
            </div>
        </div>
    </body>
</html>

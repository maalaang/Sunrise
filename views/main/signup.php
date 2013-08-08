<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script>
            function whenSubmit(e) {
                var first_name = document.getElementById('first_name').value;
                var last_name = document.getElementById('last_name').value;
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var repeat_password = document.getElementById('repeat_password').value;

                var nameRegex = new RegExp(<?= sr_regex('name') ?>);
                var emailRegex = new RegExp(<?= sr_regex('email') ?>);
                var passwordRegex = new RegExp(<?= sr_regex('password') ?>);

                if(!nameRegex.test(first_name) || !nameRegex.test(last_name)) {
                    alert('Check Name Form');
                    return false;
                }
                if(!passwordRegex.test(password)) {
                    alert('Check Password Form');
                    return false;
                }
                if(!emailRegex.test(email)) {
                    alert('Check Email Form');
                    return false;
                }
                if(password != repeat_password) {
                    alert('Check Password Form');
                    return false;
                }

                document.signup_form.submit();
            }
        </script>
    </head>
    <body>
        <h1>Sign Up</h1>
        <form action="<?= $GLOBALS['sr_root'] ?>/d/main/signup/" name="signup_form" id="signup_form" method="post">
            <input type="text" id="first_name" name="first_name" placeholder="First Name" />
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" /><br />
            <input type="text" id="email" name="email" placeholder="Email" /><br />
            <input type="password" id="password" name="password" placeholder="Password" /><br />
            <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat Password" /><br />
            <input type="button" id="button" name="button" value="Sign Up" onclick="whenSubmit(event)" />
        </form>
        <div id="error">
            <?php
                if ($context['result'] !== 0) {
                    echo $context['msg'];
                } else {
                    // for test
                    echo 'Signup done';
                }
            ?>
        </div>
    </body>
</html>

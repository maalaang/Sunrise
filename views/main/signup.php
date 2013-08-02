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

            var name_pattern = /^[a-zA-Z]+$/;
            var password_pattern = /^[a-zA-Z0-9]+$/;
            var email_pattern = /^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

            if(!name_pattern.test(first_name) || !name_pattern.test(last_name)) {
                alert('Check Name');
                return false;
            }
            if(!password_pattern.test(password)) {
                alert('Check Password');
                return false;
            }
            if(!email_pattern.test(email)) {
                alert('Check Email');
                return false;
            }
            if(password != repeat_password) {
                alert('Check Password');
                return false;
            }

            document.signup_form.submit();
        }
    </script>
    </head>
    <body>
        <h1>Sign Up</h1>
        <form action="<?= $GLOBALS['sr_root'] ?>/controllers/signup.php" name="signup_form" id="signup_form" method="post">
            <input type="text" id="first_name" name="first_name" placeholder="First Name" />
            <input type="text" id="last_name" name="last_name" placeholder="Last Name" /><br />
            <input type="text" id="email" name="email" placeholder="Email" /><br />
            <input type="password" id="password" name="password" placeholder="Password" /><br />
            <input type="password" id="repeat_password" name="repeat_password" placeholder="Repeat Password" /><br />
            <input type="button" id="button" name="button" value="Sign Up" onclick="whenSubmit(event)" />
        </form>
    </body>
</html>

<!-- Header for Before Signin without Signup Button -->

<link href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet" media="screen">

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
        <div class="nav-collapse collapse pull-right">
            <form class="navbar-form form-inline" action="<?= $GLOBALS['sr_root'] ?>/d/main/signin/" id="signin_form" name="signin_form" method="post">
                <input type="text" class="form-control" id="signin_email" name="signin_email" placeholder="Email">
                <input type="password" class="form-control" id="signin_password" name="signin_password" placeholder="Password">
                <button type="button" class="btn btn-inverse" id="btn_signin" onclick="whenSignin(event)">Sign In</button>
            </form>
        </div>
    </div>
</div>

<!-- Header for Before Signin without Signup Button -->
<header class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
        </div>
        <nav class="collapse navbar-collapse bs-navbar-collapse " role="navigation">
            <ul class="nav navbar-nav pull-right">
                <li>
                    <form class="navbar-form form-inline" action="<?= $GLOBALS['sr_root'] ?>/d/main/signin/" id="signin_form" name="signin_form" method="post">
                        <input type="text" class="form-control" id="signin_email" name="signin_email" placeholder="Email">
                        <input type="password" class="form-control" id="signin_password" name="signin_password" placeholder="Password">
                        <button type="submit" class="btn btn-inverse" id="btn_signin">Sign In</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</header>

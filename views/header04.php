<!-- Header for After Signin -->
<link href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet" media="screen">

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
        <div class="nav-collapse collapse pull-right">
            <ul class="nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?= $_SESSION['user_name'] ?> <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li> <a tabindex="-1" href="#">Profile</a> </li>
                        <li class="divider"></li>
                        <li> <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/">Sign Out</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

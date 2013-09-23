<!-- Header for After Signin -->
<link href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet" media="screen">

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?= $GLOBALS['sr_root'] ?>/d/main/">Sunrise</a>
        <div class="nav-collapse collapse pull-right">
            <ul class="nav">
                <li class="dropdown user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user"></i>
                        <span class="user-name"><?= sr_user_name() ?></span>
                        <i class="caret"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li> <a tabindex="-1" href="#">My Profile</a> </li>
                        <? if (sr_is_admin()) { ?>
                        <li> <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/admin/">Admin Page</a> </li>
                        <? } ?>
                        <li class="divider"></li>
                        <li> <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/">Sign Out</a> </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

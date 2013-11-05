<!-- Header for After Signin -->
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
            <ul class="nav navbar-nav pull-right navbar-nav-small">
                <li> <a tabindex="-1" href="#">My Profile</a> </li>
                <? if (sr_is_admin()) { ?>
                <li> <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/admin/">Admin Page</a> </li>
                <? } ?>
                <li class="divider"></li>
                <li> <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/">Sign Out</a> </li>
            </ul>
            <ul class="nav navbar-nav pull-right navbar-nav-large">
                <li class="dropdown user-menu user-menu-large">
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
        </nav>
    </div>
</header>

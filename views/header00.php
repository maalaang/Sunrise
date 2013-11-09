<!-- Header for Admin Pages -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/">Sunrise Admin Page</a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right admin-nav-small">
                    <li>
                        <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/"><i class="icon icon-th-list"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon icon-comments"></i> Rooms</a>
                    </li>
                    <li>
                        <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon icon-group"></i> Users</a>
                    </li>
                    <li>
                        <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon icon-cog"></i> Settings</a>
                    </li>
                    <li>
                        <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>"><i class="icon icon-mail-reply"></i> Back to Sunrise Main</a>
                    </li>
                    <li>
                        <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/profile/"><i class="icon icon-user"></i> Profile</a>
                    </li>
                    <li>
                        <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/"><i class="icon icon-signout"></i> Sign Out</a>
                    </li>
                </ul>
                <ul class="nav pull-right admin-nav-large">
                    <li class="dropdown admin-user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i>
                            <span class="user-name"><?= sr_user_name() ?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/profile/"><i class="icon icon-user"></i> Profile</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/"><i class="icon icon-signout"></i> Sign Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


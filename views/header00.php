<!-- Header for Admin Pages -->
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/">Sunrise Admin Page</a>
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
            </a>
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li class="dropdown admin-user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i>
                            <span class="user-name"><?= sr_user_name() ?></span>
                            <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a tabindex="-1" href="#">Profile</a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/">Sign Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>


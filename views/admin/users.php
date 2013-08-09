<? require_once (dirname(__FILE__) . '/../../include/user_session.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/styles.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet" media="screen">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/scripts.js"></script>
        <style>
            #sr_table * {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <!---------- Part 1 ---------->
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Sunrise Admin Page</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?= $userName ?> <i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
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

        <!---------- Part 2 ---------->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li>
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/"><i class="icon-chevron-right"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon-chevron-right"></i> Rooms</a>
                        </li>
                        <li class="active">
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon-chevron-right"></i> Users</a>
                        </li>
                        <li>
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon-chevron-right"></i> Settings</a>
                        </li>
                    </ul>
                </div>
                <div class="span9" id="content">

                    <!-- Table -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Registered Users</div>
                                <div class="pull-right"><span class="badge badge-info">1,234</span></div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="sr_table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>E-mail</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Authorize</th>
                                            <th>Admin</th>
                                            <th>Join Date</th>
                                            <th>Last Active Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $user_list = $context['user_list'];

                                        $checked_box = '<input type="checkbox" checked />';
                                        $unchecked_box = '<input type="checkbox" />';

                                        foreach ($user_list as $user) {

                                            if ($user->is_authorized) {
                                                $is_authorized = $checked_box;
                                            } else {
                                                $is_authorized= $unchecked_box;
                                            }

                                            echo '<tr><td>' . $user->id . '</td>' .
                                                '<td>' . $user->email . '</td>' .
                                                '<td>' . $user->first_name . '</td>' .
                                                '<td>' . $user->last_name . '</td>' .
                                                '<td>' . $is_authorized . '</td>' .
                                                '<td>' . $unchecked_box . '</td>' .
                                                '<td>' . $user->join_date . '</td>' .
                                                '<td>' . $user->last_active_date . '</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!---------- Part 3 ---------->
        <div id="footer">
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

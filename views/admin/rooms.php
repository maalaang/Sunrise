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
                        <li class="active">
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon-chevron-right"></i> Rooms</a>
                        </li>
                        <li>
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon-chevron-right"></i> Users</a>
                        </li>
                        <li>
                            <a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon-chevron-right"></i> Settings</a>
                        </li>
                    </ul>
                </div>
                <div class="span9" id="content">

                    <!-- Table 1 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Currently Opened Rooms</div>
                                <div class="pull-right"><span class="badge badge-info">1,234</span></div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="sr_table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Start Time</th>
                                            <th>Is Open</th>
                                            <th>Participants</th>
                                            <th>Close Session</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Table 2 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Room History</div>
                                <div class="pull-right"><span class="badge badge-info">1,234</span></div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="sr_table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Is Open</th>
                                            <th>Participants</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                            <td>Test</td>
                                        </tr>
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

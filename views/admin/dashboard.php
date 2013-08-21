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
            .sr_num_info * {
                width: 230px;
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
                        <li class="active"><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/"><i class="icon-chevron-right"></i> Dashboard</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon-chevron-right"></i> Rooms</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon-chevron-right"></i> Users</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon-chevron-right"></i> Settings</a></li>
                    </ul>
                </div>
                <div class="span9" id="content">

                    <!-- Graph 1 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Room Opened</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div id="g1_sr_graph" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="pull-left sr_num_info">
                                    <button class="btn disabled" disabled>Total Rooms: 1,234</button>
                                    <button class="btn disabled" disabled>Currently Opened: 12</button>
                                </div>
                                <div class="pull-right sr_page">
                                    <div class="btn-group sr_page">
                                        <button class="btn"><i class="icon-arrow-left"></i></button>
                                        <button class="btn"><i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Graph 2 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Participants</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div id="g2_sr_graph" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="pull-left sr_num_info">
                                    <button class="btn disabled" disabled>Total Participants: 31,234</button>
                                    <button class="btn disabled" disabled>Current Participants: 122</button>
                                </div>
                                <div class="pull-right sr_page">
                                    <div class="btn-group">
                                        <button class="btn"><i class="icon-arrow-left"></i></button>
                                        <button class="btn"><i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
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

        <!---------- Part 4 ---------->
        <link rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/morris.css">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/raphael-min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/morris.min.js"></script>
        <script>
        // Graph 1
        var room_data = [
            {"period": "2013-08", "visits": 2407, "signups": 660},
            {"period": "2013-07", "visits": 3351, "signups": 729},
            {"period": "2013-06", "visits": 2469, "signups": 1318},
            {"period": "2013-05", "visits": 2246, "signups": 461},
            {"period": "2013-04", "visits": 3171, "signups": 1676},
            {"period": "2013-03", "visits": 2155, "signups": 681},
            {"period": "2013-02", "visits": 1226, "signups": 620},
            {"period": "2013-01", "visits": 2245, "signups": 500}
        ];
        Morris.Line({
            element: 'g1_sr_graph',
            data: room_data,
            xkey: 'period',
            xLabels: 'month',
            ykeys: ['visits', 'signups'],
            labels: ['Visits', 'User signups']
        });

        // Graph 2
        var participant_data= [
            {"period": "2013-04", "visits": 2407, "signups": 660},
            {"period": "2013-03", "visits": 3351, "signups": 729},
            {"period": "2013-02", "visits": 2469, "signups": 1318},
            {"period": "2013-01", "visits": 2246, "signups": 461},
            {"period": "2012-12", "visits": 3171, "signups": 1676},
            {"period": "2012-11", "visits": 2155, "signups": 681},
            {"period": "2012-10", "visits": 1226, "signups": 620},
            {"period": "2012-09", "visits": 2245, "signups": 500}
        ];
        Morris.Line({
            element: 'g2_sr_graph',
            data: participant_data,
            xkey: 'period',
            xLabels: "month",
            ykeys: ['visits', 'signups'],
            labels: ['Visits', 'User signups']
        });
        </script>
    </body>
</html>

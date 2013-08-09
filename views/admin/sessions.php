<? require_once (dirname(__FILE__) . '/../../include/user_session.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/styles.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <!---------- Part 1 ---------->
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Sunrise Admin Page</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i><?= $userName ?> <i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="<?= $GLOBALS['sr_root'] ?>/d/main/signout/">Logout</a>
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
                            <a href="#"><i class="icon-chevron-right"></i><span class="badge badge-info pull-right">123</span> Dashboard</a>
                        </li>
                        <li class="active">
                            <a href="#"><i class="icon-chevron-right"></i><span class="badge badge-success pull-right">234</span> Sessions</a>
                        </li>
                        <li>
                            <a href="#"><i class="icon-chevron-right"></i><span class="badge badge-important pull-right">3,456</span> Users</a>
                        </li>
                        <li>
                            <a href="#"><i class="icon-chevron-right"></i><span class="badge badge-warning pull-right">4,567</span> Settings</a>
                        </li>
                    </ul>
                </div>
                <div class="span9" id="content">
                    <!-- Graph 1 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Currently Opened Sessions</div>
                                <div class="pull-right"><span class="badge badge-warning">View More</span></div>
                            </div>
                            <div class="block-content collapse in">

                            </div>
                        </div>
                    </div>
                    <!-- Graph 2 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Session History</div>
                                <div class="pull-right"><span class="badge badge-warning">View More</span></div>
                            </div>
                            <div class="block-content collapse in">

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
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/raphael-min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/morris.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/scripts.js"></script>
        <script>
        // Graph 1
        var tax_data_1 = [
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
            element: 'hero-graph-1',
            data: tax_data_1,
            xkey: 'period',
            xLabels: "month",
            ykeys: ['visits', 'signups'],
            labels: ['Visits', 'User signups']
        });
        // Graph 2
        var tax_data_2 = [
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
            element: 'hero-graph-2',
            data: tax_data_2,
            xkey: 'period',
            xLabels: "month",
            ykeys: ['visits', 'signups'],
            labels: ['Visits', 'User signups']
        });
        </script>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/styles.css" rel="stylesheet" media="screen">
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
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>Husky Kim<i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="#">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="#">Dashboard</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Sessions<b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="#">Tools<i class="icon-arrow-right"></i></a>
                                    </li>
                                    <li>
                                        <a href="#">Status</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Users<i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">User List</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="#">Custom Pages</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Custom Pages</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Settings<i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Search</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="#">Calendar</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Permissions</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">FAQ</a>
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
                        <li class="active">
                            <a href="#"><i class="icon-chevron-right"></i><span class="badge badge-info pull-right">123</span> Dashboard</a>
                        </li>
                        <li>
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
                                <div class="muted pull-left">Morris.js <small>Monthly growth</small></div>
                                <div class="pull-right"><span class="badge badge-warning">View More</span></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div id="hero-graph-1" style="height: 230px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Graph 2 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Morris.js <small>Monthly growth</small></div>
                                <div class="pull-right"><span class="badge badge-warning">View More</span></div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div id="hero-graph-2" style="height: 230px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <hr>
            <footer>
                <p>&copy; Sunrise 2013</p>
            </footer>
        </div>

        <!---------- Part 3 ---------->
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

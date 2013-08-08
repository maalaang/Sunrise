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
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Settings <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="#">Tools<i class="icon-arrow-right"></i></a>
                                    </li>
                                    <li>
                                        <a href="#">SEO Settings</a>
                                    </li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                    <li>
                                        <a href="#">Other Link</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Content <i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">News</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Custom Pages</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Calendar</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="#">FAQ</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Users <i class="caret"></i></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">User List</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Search</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Permissions</a>
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

                    <!-- morris graph chart -->
                    <div class="row-fluid section">
                         <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Morris.js <small>Monthly growth</small></div>
                                <div class="pull-right"><span class="badge badge-warning">View More</span>

                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div id="hero-graph" style="height: 230px;"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>

                    <!-- morris bar & donut charts -->
                    <div class="row-fluid section">
                         <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Morris.js</div>
                                <div class="pull-right"><span class="badge badge-warning">View More</span>

                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span6 chart">
                                    <h5>Devices sold</h5>
                                    <div id="hero-bar" style="height: 250px;"></div>
                                </div>
                                <div class="span5 chart">
                                    <h5>Month traffic</h5>
                                    <div id="hero-donut" style="height: 250px;"></div>    
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
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

        // Morris Bar Chart
        Morris.Bar({
            element: 'hero-bar',
            data: [
                {device: '1', sells: 136},
                {device: '3G', sells: 1037},
                {device: '3GS', sells: 275},
                {device: '4', sells: 380},
                {device: '4S', sells: 655},
                {device: '5', sells: 1571}
            ],
            xkey: 'device',
            ykeys: ['sells'],
            labels: ['Sells'],
            barRatio: 0.4,
            xLabelMargin: 10,
            hideHover: 'auto',
            barColors: ["#3d88ba"]
        });

        // Morris Donut Chart
        Morris.Donut({
            element: 'hero-donut',
            data: [
                {label: 'Direct', value: 25 },
                {label: 'Referrals', value: 40 },
                {label: 'Search engines', value: 25 },
                {label: 'Unique visitors', value: 10 }
            ],
            colors: ["#30a1ec", "#76bdee", "#c4dafe"],
            formatter: function (y) { return y + "%" }
        });

        // Morris Line Chart
        var tax_data = [
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
            element: 'hero-graph',
            data: tax_data,
            xkey: 'period',
            xLabels: "month",
            ykeys: ['visits', 'signups'],
            labels: ['Visits', 'User signups']
        });

        </script>
    </body>
</html>

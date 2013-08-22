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
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?= $user_name ?> <i class="caret"></i></a>
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

        var room_log_data = <?= json_encode($context['room_log_data']) ?>;
        var participant_log_data = <?= json_encode($context['participant_log_data']) ?>;

        // Graph 1
        Morris.Line({
            element: 'g1_sr_graph',
            data: room_log_data,
            xkey: 'period',
            xLabels: 'month',
            ykeys: ['total', 'public', 'private'],
            labels: ['Total', 'Public', 'Private']
        });

        // Graph 2
        Morris.Line({
            element: 'g2_sr_graph',
            data: participant_log_data,
            xkey: 'period',
            xLabels: "month",
            ykeys: ['total', 'non-member', 'member'],
            labels: ['Total', 'Non-member', 'Member']
        });
        </script>
    </body>
</html>

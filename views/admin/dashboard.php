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
        <script src="<?= $GLOBALS['sr_root'] ?>/js/admin-dashboard-channel.js"></script>
        <style>
            .sr_num_info * {
                width: 230px;
            }
        </style>
        <script>
            var channelServerUri = "<?= $context['channel_server_uri'] ?>";
            var channelServerControlApi = "<?= $context['channel_server_control_api'] ?>";
            $(document).ready(initChannelStatus);
        </script>
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
                    <!-- Channel Server Status -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Channel Server Status :: <span id="channel_server_status"></span></h4>
                                </div>
                            </div>

                            <?php
                                if ($context['show_channel_server_controls']) {
                            ?>
                            <div class="block-content collapse in">
                                <div class="pull-left">
                                    <span class="label" style="line-height: 30px; padding: 0 10px 0 10px;">Channel Server Control: </span>
                                    <button id="channel_server_start_btn" class="btn disabled" onclick="onChannelServerStart()">Start</button>
                                    <button id="channel_server_restart_btn" class="btn disabled" onclick="onChannelServerRestart()">Restart</button>
                                    <button id="channel_server_stop_btn" class="btn disabled" onclick="onChannelServerStop()">Stop</button>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                            <div id="channel_server_status_content" class="block-content collapse in" style="display:none;">
                                <div class="span12">
                                    <table class="table table-striped" id="t2_sr_table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Channel Token</td>
                                                <th>Client(Name)</th>
                                            </tr>
                                        </thead>
                                        <tbody id="channel_server_status_tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <p id="channel_server_status_msg" style="padding:20px 0 10px 10px;">
                                <p>
                            </div>
                            <div class="block-content collapse in">
                                <div class="pull-left sr_num_info">
                                    <button class="btn disabled" disabled>Total Channels: <span id="channel_count"></span></button>
                                    <button class="btn disabled" disabled>Total Clients: <span id="client_count"></span></button>
                                </div>
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button class="btn" onclick="onChannelStatusRefresh()">Refresh</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

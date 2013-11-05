<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
        <meta charset='utf-8'> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.2.3.2.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/morris.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/admin.css" rel="stylesheet" media="screen">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.2.3.2.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/admin.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/raphael-min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/morris.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/admin-dashboard-channel.js"></script>
        <script>
            var channelServerUri = "<?= $context['channel_server_uri'] ?>";
            var channelServerControlApi = "<?= $context['channel_server_control_api'] ?>";

            $(document).ready(function () {
                $('.sr_page button').click(function () {
                    if (!$(this).attr('class').match('disabled')) {
                        if (this.id.substring(0, 2) == 'g1') {
                            loadData('room', this.id.substring(3, this.id.length));
                        } else {
                            loadData('participant', this.id.substring(3, this.id.length));
                        }
                    }
                });

                initChannelStatus();
            });
        </script>
        <style>
            .sr_num_info * {
                width: 230px;
            }
        </style>
    </head>
    <body>
        <? include("views/header00.php") ?>

        <!-- Side Menu Bar-->
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <button class="btn-inverse btn-back" onclick="window.location='<?= $GLOBALS['sr_root'] ?>'"><i class="icon icon-mail-reply"></i> Back to Sunrise Main</button>
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
                                <div class="muted">
                                    <h4>Channel Server Status :: <span class="label" style="line-height: 20px; padding: 0 8px 0 8px;" id="channel_server_status"></span></h4>
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
                                <div class="muted">
                                    <h4>Room Opened</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div class="g1_sr_graph" id="g1_sr_graph" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="pull-left sr_num_info">
                                    <button class="btn disabled" id="g1_total" disabled></button>
                                    <button class="btn disabled" id="g1_current" disabled></button>
                                </div>
                                <div class="pull-right sr_page">
                                    <div class="btn-group">
                                        <button class="btn" id="g1_prev"><i class="icon-arrow-left"></i></button>
                                        <button class="btn" id="g1_next"><i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Graph 2 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted">
                                    <h4>Participants</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <div class="g2_sr_graph" id="g2_sr_graph" style="height: 300px;"></div>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="pull-left sr_num_info">
                                    <button class="btn disabled" id="g2_total" disabled></button>
                                    <button class="btn disabled" id="g2_current" disabled></button>
                                </div>
                                <div class="pull-right sr_page">
                                    <div class="btn-group">
                                        <button class="btn" id="g2_prev"><i class="icon-arrow-left"></i></button>
                                        <button class="btn" id="g2_next"><i class="icon-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <? include("views/footer00.php") ?>

        <!---------- Javascript ---------->
        <script>
            function loadData(graph, selected_btn) {
                var current_first_date = '';

                if (graph == 'room') {
                    viewed_date_first = $('.g1_sr_graph tspan:last').text();
                } else {
                    viewed_date_first = $('.g2_sr_graph tspan:last').text();
                }

                $.ajax({
                    url: "<?= $GLOBALS['sr_root'] ?>/d/admin/fetch/",
                    type: 'POST',
                    dataType: 'JSON',
                    data: { page: 'dashboard',
                            type: 'pagination',
                            graph: graph,
                            selected_btn: selected_btn,
                            viewed_date_first: viewed_date_first,
                    },
                    success: function (data) {
                        updateGraph(graph, data['log_data']);
                        updateNumInfo(graph, data['num_data']);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert('Ajax Error: ' + textStatus);
                    },
                });
            }

            function updateGraph(graph, log_data) {
                if (graph == 'room') {
                    $('#g1_sr_graph').html('');
                    Morris.Line({
                        element: 'g1_sr_graph',
                        data: log_data,
                        xkey: 'period',
                        xLabels: 'month',
                        ykeys: ['total', 'public', 'private'],
                        labels: ['Total', 'Public', 'Private']
                    });
                } else {
                    $('#g2_sr_graph').html('');
                    Morris.Line({
                        element: 'g2_sr_graph',
                        data: log_data,
                        xkey: 'period',
                        xLabels: "month",
                        ykeys: ['total', 'non-member', 'member'],
                        labels: ['Total', 'Non-member', 'Member']
                    });
                }

                updatePage(graph, log_data[0]['period']);
            }

            function updatePage(graph, viewed_date) {
                var d = new Date();
                var year = d.getFullYear().toString();
                var month = (d.getMonth()+1).toString();

                if (month.length == 1) {
                    month = '0' + month;
                }

                if (viewed_date == year + '-' + month) {
                    if (graph == 'room') {
                        $('#g1_next').attr('class', 'btn disabled');
                    } else {
                        $('#g2_next').attr('class', 'btn disabled');
                    }
                } else {
                    if (graph == 'room') {
                        $('#g1_next').attr('class', 'btn');
                    } else {
                        $('#g2_next').attr('class', 'btn');
                    }
                }
            }

            function updateNumInfo(graph, num_data) {
                if (graph == 'room') {
                    $('#g1_total').text('Total Rooms: ' + num_data['total']);
                    $('#g1_current').text('Currently Opened: ' + num_data['current']);
                } else {
                    $('#g2_total').text('Total Participants: ' + num_data['total']);
                    $('#g2_current').text('Current Participants: ' + num_data['current']);
                }
            }

            // Initialize graph 
            updateGraph('room', <?= json_encode($context['room_log_data']) ?>);
            updateGraph('participant', <?= json_encode($context['participant_log_data']) ?>);
            updateNumInfo('room', <?= json_encode($context['room_num_data']) ?>);
            updateNumInfo('participant', <?= json_encode($context['participant_num_data']) ?>);
        </script>
    </body>
</html>

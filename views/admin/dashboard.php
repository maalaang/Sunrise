<!DOCTYPE html>
<html>
    <head>
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/styles.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/foot.css" rel="stylesheet" media="screen">
        <link href="<?= $GLOBALS['sr_root'] ?>/css/morris.css" rel="stylesheet" media="screen">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/scripts.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/raphael-min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/morris.min.js"></script>
        <script>
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
            });
        </script>
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
                                <div class="muted pull-left">
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

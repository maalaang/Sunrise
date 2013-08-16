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
        <script>
            $(document).ready(function () {
                $('#t1_sr_filter > *').click(function () {
                    if (!$(this).attr('class').match('disabled')) {
                        setTimeout(function () { loadData('t1', 'filter') }, 0);
                    }
                });
                $('#t2_sr_filter > *').click(function () {
                    if (!$(this).attr('class').match('disabled')) {
                        setTimeout(function () { loadData('t2', 'filter') }, 0);
                    }
                });
                $('#t1_sr_page li').click(function () {
                    if ($(this).attr('class') != 'active' && $(this).attr('class') != 'disabled') {
                        loadData('t1', this.id);
                    }
                });
                $('#t2_sr_page li').click(function () {
                    if ($(this).attr('class') != 'active' && $(this).attr('class') != 'disabled') {
                        loadData('t2', this.id);
                    }
                });
            });
        </script>
        <style>
            #t1_sr_filter, #t2_sr_filter {
                padding-top: 0px;
            }
            #t1_sr_table, #t2_sr_table {
                margin-bottom: 0px;
            }
            #t1_sr_table *, #t2_sr_table * {
                text-align: center;
            }
            #t1_sr_page, #t2_sr_page {
                margin-top: 0px;
                margin-bottom: 5px;
            }
            #t1_sr_page li, #t2_sr_page li {
                cursor: pointer;
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
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/"><i class="icon-chevron-right"></i> Dashboard</a></li>
                        <li class="active"><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon-chevron-right"></i> Rooms</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon-chevron-right"></i> Users</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon-chevron-right"></i> Settings</a></li>
                    </ul>
                </div>
                <div class="span9" id="content">

                    <!-- Table 1 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Currently Opened Rooms</h4>
                                </div>
                                <div class="pull-right">
                                    <div class="btn-group" data-toggle="buttons-radio" id="t1_sr_filter">
                                        <button class="btn btn-small btn-inverse disabled" disabled>Filter <i class="icon-check icon-white"></i></button>
                                        <button class="btn btn-small active" id="t1_filter_all">All</button>
                                        <button class="btn btn-small" id="t1_filter_public">Public</button>
                                        <button class="btn btn-small" id="t1_filter_private">Private</button>
                                    </div>
                                    <button class="btn btn-small btn-info disabled" id="t1_record_number" disabled></button>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="t1_sr_table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Start Time</th>
                                            <th>Is Open</th>
                                            <th>Participants</th>
                                            <th>Close Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="t1_tr0"> </tr>
                                        <tr id="t1_tr1"> </tr>
                                        <tr id="t1_tr2"> </tr>
                                        <tr id="t1_tr3"> </tr>
                                        <tr id="t1_tr4"> </tr>
                                        <tr id="t1_tr5"> </tr>
                                        <tr id="t1_tr6"> </tr>
                                        <tr id="t1_tr7"> </tr>
                                        <tr id="t1_tr8"> </tr>
                                        <tr id="t1_tr9"> </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="navbar navbar-inner block-header">
                                <div class="pagination pagination-right" id="t1_sr_page">
                                    <ul>
                                        <li id="t1_begin"><a>&laquo;</a></li>
                                        <li id="t1_prev"><a>&lsaquo;</a></li>
                                        <li id="t1_1st"><a id="t1_1st_a"></a></li>
                                        <li id="t1_2nd"><a id="t1_2nd_a"></a></li>
                                        <li id="t1_3rd"><a id="t1_3rd_a"></a></li>
                                        <li id="t1_4th"><a id="t1_4th_a"></a></li>
                                        <li id="t1_5th"><a id="t1_5th_a"></a></li>
                                        <li id="t1_next"><a>&rsaquo;</a></li>
                                        <li id="t1_end"><a>&raquo;</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table 2 -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Room History</h4>
                                </div>
                                <div class="pull-right">
                                    <div class="btn-group" data-toggle="buttons-radio" id="t2_sr_filter">
                                        <button class="btn btn-small btn-inverse disabled" disabled>Filter <i class="icon-check icon-white"></i></button>
                                        <button class="btn btn-small active" id="t2_filter_all">All</button>
                                        <button class="btn btn-small" id="t2_filter_public">Public</button>
                                        <button class="btn btn-small" id="t2_filter_private">Private</button>
                                    </div>
                                    <button class="btn btn-small btn-info disabled" id="t2_record_number" disabled></button>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="t2_sr_table">
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
                                        <tr id="t2_tr0"> </tr>
                                        <tr id="t2_tr1"> </tr>
                                        <tr id="t2_tr2"> </tr>
                                        <tr id="t2_tr3"> </tr>
                                        <tr id="t2_tr4"> </tr>
                                        <tr id="t2_tr5"> </tr>
                                        <tr id="t2_tr6"> </tr>
                                        <tr id="t2_tr7"> </tr>
                                        <tr id="t2_tr8"> </tr>
                                        <tr id="t2_tr9"> </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="navbar navbar-inner block-header">
                                <div class="pagination pagination-right" id="t2_sr_page">
                                    <ul>
                                        <li id="t2_begin"><a>&laquo;</a></li>
                                        <li id="t2_prev"><a>&lsaquo;</a></li>
                                        <li id="t2_1st"><a id="t2_1st_a"></a></li>
                                        <li id="t2_2nd"><a id="t2_2nd_a"></a></li>
                                        <li id="t2_3rd"><a id="t2_3rd_a"></a></li>
                                        <li id="t2_4th"><a id="t2_4th_a"></a></li>
                                        <li id="t2_5th"><a id="t2_5th_a"></a></li>
                                        <li id="t2_next"><a>&rsaquo;</a></li>
                                        <li id="t2_end"><a>&raquo;</a></li>
                                    </ul>
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
            $.ajaxSetup({
                url: "<?= $GLOBALS['sr_root'] ?>/controllers/admin.php",
                type: 'POST',
                error: function (jqXHR, textStatus, errorThrown) { alert('Ajax Error: ' + textStatus); },
            });

            function closeRoom() {
                $.ajax({
                    data: { page: 'rooms', type: 'closeRoom', id: this.id },
                    success: function (data) {
                        alert('Closed the room successfully');
                        loadData('t1', $('#t1_sr_page li.active').attr('id'));
                    }
                });
            }

            function loadData(table, selected_btn) {
                var id = '';
                var pnum = '';

                var filter_arr = new Object();
                var selected_filter = $('#' + table + '_sr_filter .active').text();

                switch (selected_filter) {
                case 'All': break;
                case 'Public': filter_arr['is_open'] = '1'; break;
                case 'Private': filter_arr['is_open'] = '2'; break;
                }

                switch (selected_btn) {
                case table + '_begin':
                    pnum = Number('1');
                    break;
                case table + '_prev':
                    id = $('#' + table + '_sr_page li.active').attr('id'); 
                    pnum = Number($('#' + table + '_' + id + '_a').text()) - 1;
                    break;
                case table + '_next':
                    id = $('#' + table + '_sr_page li.active').attr('id'); 
                    pnum = Number($('#' + table + '_' + id + '_a').text()) + 1;
                    break;
                case table + '_end':
                    pnum = Number('-1');
                    break;
                case 'filter':
                    pnum = Number('1');
                    break;
                default:
                    pnum = Number($('#' + selected_btn + '_a').text());
                    break;
                }

                $.ajax({
                    data: { page: 'rooms',
                            type: 'pagination',
                            table: table,
                            filter: JSON.stringify(filter_arr),
                            page_number: pnum
                    },
                    dataType: 'JSON',
                    success: function (data) {
                        if (selected_btn == 'end') {
                            pnum = parseInt(data['total_record_number'] / 10 + 1);
                        }
                        updateTable(table, data['record_list']);
                        updatePage(table, pnum, data['total_record_number']);
                    }
                });
            }

            function updateTable(table, record_list) {
                var id = '';
                var tags = '';
                var indexNum = 0;

                $.each(record_list, function(index, record) {
                    id = '';
                    tags = '';

                    $.each(record, function(key, val) {
                        if (key != 'password' && key != 'channel_token') {
                            if (key == 'id') {
                                id = val;
                            }
                            if (key == 'is_open') {
                                if (val = 1) {
                                    val = 'Public';
                                } else {
                                    val = 'Private';
                                }
                            }
                            tags += '<td>' + val + '</td>';
                            indexNum++;
                        }
                    });

                    if (table == 't1') {
                        tags += '<td><button class="btn btn-mini closeRoom" id="' + id + '">Close</button></td>';
                        indexNum++;
                    }

                    $('#' + table + '_tr' + index).html(tags);
                });

                indexNum /= record_list.length;

                if (isNaN(indexNum)) {
                    indexNum = 8;
                }

                if (record_list.length < 10) {
                    tags = '<td>-</td>';
                    for (var i = 0; i < indexNum-1; i++) {
                        tags += '<td></td>';
                    }
                    for (var i = record_list.length; i < 10; i++) {
                        $('#' + table + '_tr' + i).html(tags);
                    }
                }

                $('.closeRoom').click(closeRoom);
            }

            function updatePage(table, current_page, total_record_number) {
                var last_page = parseInt(total_record_number / 10 + 1);
                var first_page_in_view = parseInt((current_page - 1) / 5) * 5 + 1;
                var selected_button = (current_page - 1) % 5 + 1;

                var ordinal = [ '', '1st', '2nd', '3rd', '4th', '5th' ];

                for (var btn = 1; btn <= 5; btn++) {
                    $('#' + table + '_' + ordinal[btn] + '_a').text(first_page_in_view + btn - 1);
                }

                $('#' + table + '_record_number').html('Total: ' + total_record_number);

                $('#' + table + '_sr_page li').attr('class', '');
                $('#' + table + '_' + ordinal[selected_button]).attr('class', 'active');

                if (current_page == 1) {
                    $('#' + table + '_begin, #' + table + '_prev').attr('class', 'disabled');
                } else {
                    $('#' + table + '_begin, #' + table + '_prev').attr('class', '');
                }

                if (current_page == last_page) {
                    $('#' + table + '_next, #' + table + '_end').attr('class', 'disabled');
                } else {
                    $('#' + table + '_next, #' + table + '_end').attr('class', '');
                }

                if (last_page - first_page_in_view < 4) {
                    for (var btn = (last_page - 1) % 5 + 2; btn <= 5; btn++) {
                        $('#' + table + '_' + ordinal[btn]).attr('class', 'disabled');
                    }
                }
            }

            // Initialize table
            updateTable('t1', <?= json_encode($context['room_list']) ?>);
            updateTable('t2', <?= json_encode($context['history_list']) ?>);
            updatePage('t1', 1, <?= Room::getRecordNum(array()) ?>);
            updatePage('t2', 1, <?= History::getRecordNum(array()) ?>);
        </script>
    </body>
</html>

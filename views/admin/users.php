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
                $('#sr_page li').click(function () {
                    if ($(this).attr('class') != 'active' && $(this).attr('class') != 'disabled') {
                        var id = '';
                        var pnum = '';

                        switch (this.id) {
                        case 'begin':
                            pnum = Number('1');
                            break;
                        case 'prev':
                            id = $('#sr_page li.active').attr('id'); 
                            pnum = Number($('#' + id + '_a').text()) - 1;
                            break;
                        case 'next':
                            id = $('#sr_page li.active').attr('id'); 
                            pnum = Number($('#' + id + '_a').text()) + 1;
                            break;
                        case 'end':
                            pnum = parseInt(<?= User::getRecordNum() ?> / 10 + 1);
                            break;
                        default:
                            pnum = Number($('#' + this.id + '_a').text());
                            break;
                        }

                        $.ajax({
                            data: { page: 'users', type: 'pagination', page_number: pnum },
                                dataType: 'JSON',
                                success: function (data) {
                                    updateTable(data);
                                    updatePage(pnum);
                                }
                        });
                    }
                });
            });
        </script>
        <style>
            #sr_table * {
                text-align: center;
            }
            #sr_page li {
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
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon-chevron-right"></i> Rooms</a></li>
                        <li class="active"><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon-chevron-right"></i> Users</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon-chevron-right"></i> Settings</a></li>
                    </ul>
                </div>
                <div class="span9" id="content">

                    <!-- Table -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Registered Users</div>
                                <div class="pull-right"><span class="badge badge-info">1,234</span></div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="sr_table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>E-mail</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Authorize</th>
                                            <th>Admin</th>
                                            <th>Join Date</th>
                                            <th>Last Active Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($i = 0; $i < 10; $i++) {
                                            echo '<tr id="tr' . $i . '"></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="sr_page">
                            <div class="pagination pagination-right">
                                <ul>
                                    <li id="begin"><a>&laquo;</a></li>
                                    <li id="prev"><a>&lsaquo;</a></li>
                                    <li id="1st"><a id="1st_a"></a></li>
                                    <li id="2nd"><a id="2nd_a"></a></li>
                                    <li id="3rd"><a id="3rd_a"></a></li>
                                    <li id="4th"><a id="4th_a"></a></li>
                                    <li id="5th"><a id="5th_a"></a></li>
                                    <li id="next"><a>&rsaquo;</a></li>
                                    <li id="end"><a>&raquo;</a></li>
                                </ul>
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

            function checkAuthorized() {
                var isChecked = 'unchecked';
                if (this.checked) {
                    isChecked = 'checked';
                }
                $.ajax({
                    data: { page: 'users', type: 'authorized', id: this.id, checked: isChecked }
                });
            }

            function checkAdmin() {
                var isChecked = 'unchecked';
                if (this.checked) {
                    isChecked = 'checked';
                }
                $.ajax({
                    data: { page: 'users', type: 'admin', id: this.id, checked: isChecked }
                });
            }

            function updateTable(user_list) {
                var id = '';
                var temp = '';
                var tags = '';
                var indexNum = 0;
                var checkbox = '<input type="checkbox" ';

                $.each(user_list, function(index, user) {
                    id = '';
                    tags = '';

                    $.each(user, function(key, val) {
                        if (key != 'password') {
                            switch (key) {
                            case 'is_authorized':
                                temp = checkbox;
                                temp += 'class="authorized" id="' + id + '" ';
                                if (val == '1') temp += 'checked '; 
                                temp += '/>';
                                val = temp;
                                break;
                            case 'is_admin':
                                temp = checkbox;
                                temp += 'class="admin" id="' + id + '" ';
                                if (val == '1') temp += 'checked '; 
                                temp += '/>';
                                val = temp;
                                break;
                            case 'id':
                                id = val;
                                break;
                            }
                            tags += '<td>' + val + '</td>';
                            indexNum++;
                        }
                    });
                    $('#tr' + index).html(tags);
                });

                indexNum /= user_list.length;

                if (user_list.length < 10) {
                    tags = '<td>-</td>';
                    for (var i = 0; i < indexNum-1; i++) {
                        tags += '<td></td>';
                    }
                    for (var i = user_list.length; i < 10; i++) {
                        $('#tr' + i).html(tags);
                    }
                }

                $('.authorized').click(checkAuthorized);
                $('.admin').click(checkAdmin);
            }

            function updatePage(current_page) {
                var last_page = parseInt(<?= User::getRecordNum() ?> / 10 + 1);
                var first_page_in_view = parseInt((current_page - 1) / 5) * 5 + 1;
                var selected_button = (current_page - 1) % 5 + 1;

                var ordinal = [ '', '1st', '2nd', '3rd', '4th', '5th' ];

                for (var btn = 1; btn <= 5; btn++) {
                    $('#' + ordinal[btn] + '_a').text(first_page_in_view + btn - 1);
                }

                if (current_page == 1) {
                    $('#begin, #prev').attr('class', 'disabled');
                } else {
                    $('#begin, #prev').attr('class', '');
                }

                if (current_page == last_page) {
                    $('#next, #end').attr('class', 'disabled');
                } else {
                    $('#next, #end').attr('class', '');
                }

                $('#sr_page li.active').attr('class', '');
                $('#' + ordinal[selected_button]).attr('class', 'active');

                if (last_page - first_page_in_view < 4) {
                    for (var btn = (last_page - 1) % 5 + 2; btn <= 5; btn++) {
                        $('#' + ordinal[btn]).attr('class', 'active');
                    }
                }
            }

            // Initialize table
            updateTable(<?= json_encode($context['user_list']) ?>);
            updatePage(1);
        </script>
    </body>
</html>

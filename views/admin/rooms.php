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
            #sr_filter {
                padding-top: 0px;
            }
            #sr_table {
                margin-bottom: 0px;
            }
            #sr_table * {
                text-align: center;
            }
            #sr_page {
                margin-top: 0px;
                margin-bottom: 5px;
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
                                    <div class="btn-group" data-toggle="button-checkbox" id="sr_filter">
                                        <button class="btn btn-small btn-inverse disabled" disabled>Filter <i class="icon-check icon-white"></i></button>
                                        <button class="btn btn-small" id="t1_filter_public">Public</button>
                                        <button class="btn btn-small" id="t1_filter_private">Private</button>
                                    </div>
                                    <button class="btn btn-small btn-info disabled" id="t1_record_number" disabled></button>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="sr_table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Start Time</th>
                                            <th>Is Open</th>
                                            <th>Participants</th>
                                            <th>Close Session</th>
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
                                <div class="pagination pagination-right" id="sr_page">
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
                                    <div class="btn-group" data-toggle="button-checkbox" id="sr_filter">
                                        <button class="btn btn-small btn-inverse disabled" disabled>Filter <i class="icon-check icon-white"></i></button>
                                        <button class="btn btn-small" id="t2_filter_public">Public</button>
                                        <button class="btn btn-small" id="t2_filter_private">Private</button>
                                    </div>
                                    <button class="btn btn-small btn-info disabled" id="t2_record_number" disabled></button>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped" id="sr_table">
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
                                <div class="pagination pagination-right" id="sr_page">
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
    </body>
</html>

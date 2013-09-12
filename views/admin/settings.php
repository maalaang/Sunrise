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
            .type {
                font-weight: bold;
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
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/dashboard/"><i class="icon-chevron-right"></i> Dashboard</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/rooms/"><i class="icon-chevron-right"></i> Rooms</a></li>
                        <li><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/users/"><i class="icon-chevron-right"></i> Users</a></li>
                        <li class="active"><a href="<?= $GLOBALS['sr_root'] ?>/d/admin/settings/"><i class="icon-chevron-right"></i> Settings</a></li>
                    </ul>
                </div>
                <div class="span9" id="content">

                    <!-- Database Configuration -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Database Configuration</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <col width="150px" />
                                    <tr> <td class="type">Type</td>          <td><?= $context['db_type'] ?></td>        </tr>
                                    <tr> <td class="type">Host</td>          <td><?= $context['db_host'] ?></td>        </tr>
                                    <tr> <td class="type">Port</td>          <td><?= $context['db_port'] ?></td>        </tr>
                                    <tr> <td class="type">Database</td>      <td><?= $context['db_database'] ?></td>    </tr>
                                    <tr> <td class="type">Username</td>      <td><?= $context['db_username'] ?></td>    </tr>
                                    <tr> <td class="type">Password</td>      <td><?= $context['db_password'] ?></td>    </tr>
                                    <tr> <td class="type">Character set</td> <td><?= $context['db_char_set'] ?></td>    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- User Authorization -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>User Authorization</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <col width="300px" />
                                    <tr> <td class="type">Give authorization on sign up</td>          <td><?= $context['give_authority'] ?></td>  </tr>
                                    <tr> <td class="type">Allow anonymous users to join to chat</td>  <td><?= $context['allow_anonymous'] ?></td> </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- E-mail Configuration -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>E-mail Configuration</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <col width="150px" />
                                    <tr> <td class="type">SMTP Server</td>  <td><?= $context['smtp_server'] ?></td>    </tr>
                                    <tr> <td class="type">Port</td>         <td><?= $context['smtp_port'] ?></td>      </tr>
                                    <tr> <td class="type">Username</td>     <td><?= $context['smtp_username'] ?></td>  </tr>
                                    <tr> <td class="type">Password</td>     <td><?= $context['smtp_password'] ?></td>  </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Installation Path -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Installation Path</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <col width="250px" />
                                    <tr> <td class="type">Path from web server root</td> <td><?= $context['installation_path'] ?></td> </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Room Setting -->
                    <div class="row-fluid section">
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                    <h4>Room Setting</h4>
                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <table class="table table-striped">
                                    <col width="250px" />
                                    <tr> <td class="type">Maximum number of users</td>  <td><?= $context['maximum_users'] ?></td>   </tr>
                                    <tr> <td class="type">STUN Server</td>              <td><?= $context['stun_server'] ?></td>     </tr>
                                    <tr> <td class="type">Use XMPP</td>                 <td><?= $context['xmpp_server_use'] ?></td> </tr>
                                    <tr> <td class="type">XMPP Server</td>              <td><?= $context['xmpp_server'] ?></td>     </tr>
                                </table>
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

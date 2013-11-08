<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="chrome=1"/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sunrise</title>

        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
    </head>
    <body>
        <? 
            if (sr_is_signed_in()) {
                include("views/header04.php");
            } else {
                include("views/header01.php");
            }
        ?>

        <div class="container">
            <div class="jumbotron">
                <h1><?= $context['content']['title'] ?></h1>
                <p>
                    <?= $context['content']['description'] ?>
                </p>
                <hr/>
                <form class="room-info" action="<?= $GLOBALS['sr_root'] ?>/d/main/room/" method="GET" role="form">
                    <fieldset>
                        <table align="center" class="room-info-table">
                            <tr>
                                <td><label for="room_name">Room Name :</label></td>
                                <td><input class="form-control" id="room_name" name="room_name" type="text" placeholder="Developer Weekly Meeting" /></td>
                            </tr>
                            <tr>
                                <td><label for="your_name">Your Name :</label></td>
                                <td><input class="form-control" id="your_name" name="user_name" type="text" placeholder="Steve Kim" value="<?= sr_user_name() ?>"/></td>
                            </tr>
                        </table>
                        <p style="text-align:center; margin: 10px">
                            <button id="room-join-btn" type="submit" class="btn btn-primary btn-normal">Go to the Room!</button> 
                        </p>
                    </fieldset>
                </form>
                <hr/>
            </div>
            <div class="body-content">
                <div class="row">
                    <div class="col-lg-4">
                        <?= $context['content']['info1'] ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $context['content']['info2'] ?>
                    </div>
                    <div class="col-lg-4">
                        <?= $context['content']['info3'] ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

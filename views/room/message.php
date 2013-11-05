<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
    </head>
    <style>
        body {
            padding-top: 70px;
        }
        #outer-container {
            width: 500px;
            margin: 100px auto;
        }
    </style>
    <body>
        <? 
            if (sr_is_signed_in()) {
                include("views/header04.php");
            } else {
                include("views/header01.php");
            }
        ?>

        <div class="container" id="outer-container">
            <div class="jumbotron">
                <div class="container">
                    <p><?= $context['msg'] ?></p>
        <?  if ($context['type'] == 1) { ?>
                    <p><a class="btn btn-danger" role="button" href="<?= sr_home_path() ?>/d/">Go Back to Home</a></p>
        <?  } else if ($context['type'] == 2) { ?>
                    <p>
                        <form class="form-inline" role="form" onSubmit="return passwordCheck(e)">
                            <div class="form-group">
                                <input type="password" class="form-control" id="room_pw" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-default">Go to the room</button>
                        </form>
                    </p>
        <? } else { ?>

        <? } ?>
                </div>
            </div>
        </div>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

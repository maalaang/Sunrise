<!DOCTYPE html>
<html>
    <head>
        <title>Sunrise</title>
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.0.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">
        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.0.min.js"></script>
    </head>
    <style>
        body {
            padding-top: 70px;
        }
        #outer-container {
            width: 500px;
            margin: 100px auto;
            text-align: center;
        }
    </style>
    <body>
        <? 
            include("views/header04.php");
        ?>

        <?  if ($context['type'] == 1) { ?>

        <div class="container" id="outer-container">
            <div class="jumbotron">
                <div class="container">
                    <p><?= $context['msg'] ?></p>
                    <p><a class="btn btn-danger" role="button" href="<?= $GLOBALS['sr_root'] ?>/d/">Go Back to Home</a></p>
                </div>
            </div>
        </div>

        <? } ?>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

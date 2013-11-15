<!DOCTYPE html>
<html>
    <head>
        <? include("views/meta.php"); ?>

        <title>Sunrise</title>

        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/bootstrap.3.0.1.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/sunrise.css" rel="stylesheet">
        <link type="text/css" href="<?= $GLOBALS['sr_root'] ?>/css/header.css" rel="stylesheet">

        <script src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?= $GLOBALS['sr_root'] ?>/js/bootstrap.3.0.1.min.js"></script>
    </head>
    <script>
        function passwordCheck(e) {
            $.ajax({
                url: "<?= sr_home_path() ?>/d/room/message/pswd/",
                type: 'POST',
                dataType: 'JSON',
                data: { input_password: $('#room_pw').val() },
                success: function (data) {
                    if (data['result']) {
                        location.replace("<?= sr_home_path() ?>/d/room/?name=<?= $_SESSION['room_name'] ?>");
                    } else {
                        showMessage('Invalid password.');

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showMessage('Error occurred (' + textStatus + ')');
                },
            });
        }

        function showMessage(str) {
            $('#alert-message').addClass('alert-visible');
            $('#alert-message').html(str);

        }
    </script>
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
                <div class="message">
                    <div class="message-text">
                        <?= $context['msg'] ?>
                    </div>
                    <?  if ($context['type'] == 1) { ?>
                    <div>
                        <a class="btn btn-danger" role="button" href="<?= sr_home_path() ?>/d/">Go Back to Home</a>
                    </div>
                    <?  } else if ($context['type'] == 2) { ?>
                    <div>
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <input type="password" class="form-control" id="room_pw" placeholder="Password">
                            </div>
                            <button type="button" class="btn btn-default" onClick="passwordCheck(this)">Go to the room</button>
                        </form>
                    </div>
                    <? } else { ?>

                    <? } ?>
                    <div class="alert alert-danger" id="alert-message">
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <? include("views/footer00.php") ?>
        </div>
    </body>
</html>

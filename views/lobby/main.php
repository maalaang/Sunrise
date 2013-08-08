<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="<?= $GLOBALS['sr_root'] ?>/js/jquery-1.9.1.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?= $GLOBALS['sr_root'] ?>/css/default.css">
    <script>
        function onCreateRoom() {
            var params = {};
            params['name'] = $("#room_name").val();

            $.post('<?= $GLOBALS['sr_root'] ?>/d/room/open/', arams, function(data) {
                if (data.result == 0) {
                    // a room is created. move to the room
                    window.location.replace('<?= $GLOBALS['sr_root'] ?>/d/room/?name=' + encodeURIComponent(data.name));

                } else {
                    // failed to create a room
                    $("#message").html(data.msg);
                }
            }, 'json');
        }
    </script>
</head>
<body>
    <h1>Lobby Main</h1>

    <div>
       <input id="room_name" type="text" value="" placeholder="Room Name" />
       <input id="room_create" type="button" value="Create a Room" />
    </div>
    <div id="message">
    </div>
    
    <script>
        $("#room_create").click(onCreateRoom);
    </script>
</body>
</html>

<h1>Admin Page: Room List</h1>

<?php

$room_list = $context['room_list'];

foreach ($room_list as $room) {
    echo '<div><p>Room ID = ' . $room->id . '</p><p>' . $room . '</p></div><hr/>';
}

?>

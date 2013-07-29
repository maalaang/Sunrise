<h1>Admin Page: Session List</h1>

<?php

$session_list = $context['session_list'];

foreach ($session_list as $session) {
    echo '<div><p>Session ID = ' . $session->id . '</p><p>' . $session . '</p></div><hr/>';
}

?>

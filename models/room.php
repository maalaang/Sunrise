<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * A video conference room.
 */
class Room extends Model {
    /** Room ID. Primary key */
    public $id;

    /** Room name. Unique key */
    public $name;

    /** Room title */
    public $title;

    /** Room description */
    public $description;

    /** Sunrise channel token. Unique key */
    public $channel_token;

    /** Flag for public or private room */
    public $is_open;

    /** Start time of this room */
    public $start_time;

    /** Password */
    public $password;

    public function open($db) {
        $this->id = Room::getUniqueId('r');
        $this->start_time = Room::getCurrentTime();
        $this->channel_token = Room::getUniqueId('h');

        $this->add($db);
    }

    public function close($db) {
        $this->delete($db);
    }
}

?>

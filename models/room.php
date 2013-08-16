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

    /** Start time of this room */
    public $start_time;

    /** Password */
    public $password;

    /** Flag for public or private room */
    public $is_open;

    /** Participants of this room */
    public $participants;

    public function open($db) {
        $this->start_time = Model::getCurrentTime();
        $this->channel_token = Model::getUniqueId('c');

        $this->add($db);
    }

    public function close($db) {
        $this->delete($db);
    }
}

?>

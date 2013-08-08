<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Video conference participant.
 */
class Participant extends Model {
    /** Participant ID. Primary key */
    public $id;

    /** The id of the room in which this participant is present */
    public $room_id;

    /** Name of participant */
    public $name;

    /** IP address */
    public $ip_address;

    /** User ID. It is used only when the participant is a registered user. */
    public $user_id;

    /** Flag for this participant is a registered user or not */
    public $is_registered_user;

    public function joinRoom($db) {
        $this->add($db);
    }

    public function exitRoom($db) {
        $this->delete($db);
    }

}

?>

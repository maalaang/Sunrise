<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Session participant.
 */
class Participant extends Model {
    /** Participant ID. Primary key */
    public $id;

    /** Session ID which this participant is present at */
    public $session_id;

    /** Name of participant */
    public $name;

    /** IP address */
    public $ip_address;

    /** User ID. It is used only when the participant is a registered user. */
    public $user_id;

    /** Flag for this participant is a registered user or not */
    public $is_registered_user;

    public function join_session($db) {
        $this->add($db);
    }

    public function exit_session($db) {
        $this->delete($db);
    }

}

?>

<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * A room history.
 */
class History extends Model {
    /** Room ID. Primary key */
    public $id;

    /** Room name. */
    public $name;

    /** Room title */
    public $title;

    /** Room description */
    public $description;

    /** Start time of this room */
    public $start_time;

    /** End time of this room */
    public $end_time;

    /** Flag for public or private room */
    public $is_open;

    /** Participants of this room */
    public $participants;

}

?>

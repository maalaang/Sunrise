<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Log for video conference rooms.
 */
class RoomLog extends Model {
    /** Log ID. Primary key */
    public $id;

    /** Room ID. */
    public $room_id;

    /** Room name. */
    public $name;

    /** Room title */
    public $title;

    /** Room description */
    public $description;

    /** Flag for public or private room */
    public $is_open;

    /** Start time of this room */
    public $start_time;

    /** End time of this room */
    public $end_time;

    /**
     * Returns the database table name associated with this model. The default table name
     * is the lowercased class name.
     * 
     * @return  the table name that is associated with the model
     */
    public static function getTableName() {
        return 'room_log';
    }
}

?>

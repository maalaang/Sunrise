<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Video conference participant.
 */
class ParticipantLog extends Model {
    /** Participant Log ID. Primary key */
    public $id;

    /** Type of the log. 1:join, 2:exit */
    public $type;

    /** The id of the room which this log is about */
    public $room_id;

    /** Name of participant */
    public $participant_name;

    /** User ID. It is used only when the participant is a registered user. */
    public $user_id;

    /** Flag for this participant is a registered user or not */
    public $is_registered_user;

    /** IP address */
    public $ip_address;

    /** The time when the log is written */
    public $time;

    /**
     * Returns the database table name associated with this model. The default table name
     * is the lowercased class name.
     * 
     * @return  the table name that is associated with the model
     */
    public static function getTableName() {
        return 'participant_log';
    }
}

?>

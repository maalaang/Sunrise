<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * A video conference room.
 */
class Room extends Model {
    /** Primary key */
    public $id;

    /** Room name. Unique */
    public $name;

    /** Room title */
    public $title;

    /** Room description */
    public $description;

    /** Start time of this room */
    public $start_time;

    /** Password */
    public $password;

    /** Flag for public or private room */
    public $is_open;

    public function open($db) {
        $this->add($db);
    }

    public function close($db) {
        $this->delete($db);
    }

    public function generateToken() {
        return md5($this->id . 'sunrise' . $this->name);
    }

    public function validateToken($token) {
        if ($token == md5($this->id . 'sunrise' . $this->name)) {
            return True;
        } else {
            return False;
        }
    }
}

?>

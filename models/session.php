<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * A video conference room session.
 */
class Session extends Model {
    /** Primary key */
    public $id;

    /** Session name. Unique */
    public $name;

    /** Session title */
    public $title;

    /** Session description */
    public $description;

    /** Start time of this session */
    public $start_time;

    /** Password */
    public $password;

    /** Flag for public or private session */
    public $is_open;

    public function open_session($db) {
        $this->add($db);
    }

    public function close_session($db) {
        $this->delete($db);
    }

    public function generate_token() {
        return md5($this->id . 'sunrise' . $this->name);
    }

    public function validate_token($token) {
        if ($token == md5($this->id . 'sunrise' . $this->name)) {
            return True;
        } else {
            return False;
        }
    }
}

?>

<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Sunrise VC user.
 */
class User extends Model {
    /** User ID. Primary key */
    public $id;

    /** Real name. */
    public $name;

    /** Password */
    public $password;

    /** Email address */
    public $email;

    /** Flag for having been authorized or not */
    public $is_authorized;

    /** Date when the user joined */
    public $join_date;

    /** The last date when the user was active */
    public $last_active_date;

}

?>

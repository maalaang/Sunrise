<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Sunrise VC user.
 */
class User extends Model {

    /** Email address. Primary key */
    public $email;

    /** Password */
    public $password;

    /** First name. */
    public $first_name;

    /** Last name. */
    public $last_name;

    /** Flag for having been authorized or not */
    public $is_authorized;

    /** Date when the user joined */
    public $join_date;

    /** The last date when the user was active */
    public $last_active_date;

}

?>

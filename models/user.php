<?php

require_once (dirname(__FILE__) . '/model.php');

/**
 * Sunrise VC user.
 */
class User extends Model {

    /** User ID. Primary key */
    public $id;

    /** Email address. Unique key */
    public $email;

    /** Password */
    public $password;

    /** First name. */
    public $first_name;

    /** Last name. */
    public $last_name;

    /** Flag for having been authorized or not */
    public $is_authorized;

    /** Flag for having administrator authority */
    public $is_admin;

    /** Date when the user joined */
    public $join_date;

    /** The last date when the user was active */
    public $last_active_date;

}

?>

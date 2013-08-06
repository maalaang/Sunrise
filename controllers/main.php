<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function main() {
    sr_response('views/main/index.php', null);
}

function signin() {
    sr_response('views/main/signin.php', null);
}

function signup() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = new User();

        // TODO: parameter validation - empty, length, valid email format, password complexity

        $user->first_name = $_POST['first_name'];
        $user->last_name = $_POST['last_name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->is_authorized = 1;
        $user->join_date = Model::getCurrentTime();
        $user->last_active_date = Model::getCurrentTime();


        $context = array();

        try {
            $db = sr_pdo();
            $id = $user->add($db);

            // TODO: what page will be shown up after signup?
            $context['result'] = 0;
            $context['msg'] = 'Successfully registered';

            sr_response('views/main/signup.php', $context);

        } catch (PDOException $e) {
            switch ($e->errorInfo[1]) {
            case 1062:
                // duplicated entry
                $context['result'] = 1;
                $context['msg'] = 'The email address is already registered.';
                break;
            default:
                // other exceptions
                $context['result'] = 2;
                $context['msg'] = 'Failed to signup. Please try it again.';
            }
            sr_response('views/main/signup.php', $context);
        }

    } else {
        // show signuo view
        sr_response('views/main/signup.php', null);
    }
}

?>

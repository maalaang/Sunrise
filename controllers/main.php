<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');
require_once (dirname(__FILE__) . '/../settings/config.php');

function main() {
    sr_response('views/main/index.php', null);
}


function signin() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        global $sr_regex_email;
        global $sr_regex_password;

        $user = new User();
        $context = array();

        if (!preg_match($sr_regex_email, $_POST['email'])) {
            $context['result'] = 4;
            $context['msg'] = 'Invalid Email Adress';
        } else if (!preg_match($sr_regex_password, $_POST['password'])) {
            $context['result'] = 5;
            $context['msg'] = 'Invalid Password';
        } else {
            // TODO: Session Administration
            try {
                $db = sr_pdo();

                $stmt = $db->prepare('SELECT * FROM user WHERE email = :email');
                $stmt->bindParam(':email', $_POST['email']);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                $stmt->execute();

                $user = $stmt->fetch();

                if ($user == Null || $user == false) {
                    $context['result'] = 2;
                    $context['msg'] = 'Couldn\'t Find Email Address';
                } else if ($user->password != $_POST['password']) {
                    $context['result'] = 3;
                    $context['msg'] = 'Wrong Password';
                } else {
                    $context['result'] = 0;
                    $context['msg'] = 'Successfully signined';
                }

            } catch (PDOException $e) {
                $context['result'] = 1;
                $context['msg'] = 'Failed to signip. Please try it again.';
            }
        }
        // TODO: What page will be shown up after signin?
        sr_response('views/main/signin.php', $context);

    } else {
        // Show signin view
        sr_response('views/main/signin.php', null);
    }
}


function signup() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        global $sr_regex_name;
        global $sr_regex_email;
        global $sr_regex_password;

        $user = new User();
        $context = array();

        if (!preg_match($sr_regex_email, $_POST['email'])) {
            $context['result'] = 3;
            $context['msg'] = 'Invalid Email Adress';
        } else if (!preg_match($sr_regex_password, $_POST['password'])) {
            $context['result'] = 4;
            $context['msg'] = 'Invalid Password';
        } else if (!preg_match($sr_regex_name, $_POST['first_name'])) {
            $context['result'] = 5;
            $context['msg'] = 'Invalid Name';
        } else if (!preg_match($sr_regex_name, $_POST['last_name'])) {
            $context['result'] = 6;
            $context['msg'] = 'Invalid Name';
        } else {

            //TODO: Manage is_authorized, last_active_date
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->email = $_POST['email'];
            $user->password = $_POST['password'];
            $user->is_authorized = 1;
            $user->join_date = Model::getCurrentTime();
            $user->last_active_date = Model::getCurrentTime();

            try {
                $db = sr_pdo();
                $id = $user->add($db);

                $context['result'] = 0;
                $context['msg'] = 'Successfully registered';

            } catch (PDOException $e) {
                switch ($e->errorInfo[1]) {
                case 1062:
                    // Duplicated entry
                    $context['result'] = 1;
                    $context['msg'] = 'The email address is already registered.';
                    break;
                default:
                    // Other exceptions
                    $context['result'] = 2;
                    $context['msg'] = 'Failed to signup. Please try it again.';
                }
            }
        }
        // TODO: What page will be shown up after signup?
        sr_response('views/main/signup.php', $context);

    } else {
        // Show signup view
        sr_response('views/main/signup.php', null);
    }
}

?>

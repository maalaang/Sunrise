<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');

function main() {
    sr_response('views/main/index.php', null);
}


function signin() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // TODO: parameter validation - empty, length, valid email format, password complexity
        // TODO: Session Administration
        
        $user = new User();
        $context = array();

        try {
            $db = sr_pdo();

            $stmt = $db->prepare('SELECT * FROM user WHERE email = :email');
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $stmt->execute();

            $user = $stmt->fetch();

        } catch (PDOException $e) {
            $context['result'] = 1;
            $context['msg'] = 'Failed to signip. Please try it again.';
            sr_response('views/main/signin.php', $context);
        }

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

        // TODO: what page will be shown up after signin?
        sr_response('views/main/signin.php', $context);

    } else {
        // show signin view
        sr_response('views/main/signin.php', null);
    }
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
        // show signup view
        sr_response('views/main/signup.php', null);
    }
}

?>

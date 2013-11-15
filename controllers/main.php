<?php

require_once (dirname(__FILE__) . '/../models/user.php');
require_once (dirname(__FILE__) . '/../include/utils.php');
require_once (dirname(__FILE__) . '/../settings/config.php');

function main_welcome() {
    global $sr_main_content;

    $context = array();
    $context['content'] = $sr_main_content;

    sr_response('views/main/index.php', $context);
}


function main_signin() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        global $sr_regex_email;
        global $sr_regex_password;

        $user = new User();
        $context = array();

        $context['email'] = $_POST['signin_email'];

        if (!preg_match($sr_regex_email, $_POST['signin_email'])) {
            $context['result'] = 4;
            /* invalid email address */
            $context['msg'] = 'Invalid email address or password.';
        } else if (!preg_match($sr_regex_password, $_POST['signin_password'])) {
            $context['result'] = 5;
            /* invalid password */
            $context['msg'] = 'Invalid email address or password.';
        } else {
            try {
                $db = sr_pdo();

                $stmt = $db->prepare('SELECT * FROM user WHERE email = :email');
                $stmt->bindParam(':email', $_POST['signin_email']);
                $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
                $stmt->execute();

                $user = $stmt->fetch();

                if ($user == Null || $user == false) {
                    $context['result'] = 2;
                    /* not registered email address */
                    $context['msg'] = 'Invalid email address or password.';
                } else if ($user->password != md5($_POST['signin_password'])) {
                    $context['result'] = 3;
                    /* password not matched */
                    $context['msg'] = 'Invalid email address or password.';
                } else {
                    /* signin done */
                    $context['result'] = 0;
                    $context['msg'] = 'Successfully signed in';

                    sr_signin($user);
                }

            } catch (PDOException $e) {
                $context['result'] = 1;
                $context['msg'] = 'Failed to signin. Please try it again.';
            }
        }

        if ($context['result'] === 0) {
            if (isset($_SESSION['next_page']) && isset($_SESSION['room_name'])) {
                $room_name = $_SESSION['room_name'];
                unset($_SESSION['next_page']);
                unset($_SESSION['room_name']);
                sr_redirect('/d/room/?name=' . $room_name);
            } else {
                sr_redirect('/d/');
            }
        } else {
            sr_response('views/main/signin.php', $context);
        }

    } else {
        // Show signin view
        sr_response('views/main/signin.php', null);
    }
}


function main_signup() {
    if (sr_is_signed_in()) {
        sr_redirect('/d/');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        global $sr_regex_name;
        global $sr_regex_email;
        global $sr_regex_password;
        global $sr_default_authority;

        $user = new User();
        $context = array();

        if (!preg_match($sr_regex_email, $_POST['signup_email'])) {
            $context['result'] = 3;
            $context['msg'] = 'Please enter a valid email address';
        } else if (!preg_match($sr_regex_password, $_POST['signup_password'])) {
            $context['result'] = 4;
            $context['msg'] = 'Please enter a valid password. Password should be alphanumeric.';
        } else if (!preg_match($sr_regex_name, $_POST['first_name'])) {
            $context['result'] = 5;
            $context['msg'] = 'Name should consist of only alphabets (uppercase or lowercase).';
        } else if (!preg_match($sr_regex_name, $_POST['last_name'])) {
            $context['result'] = 6;
            $context['msg'] = 'Name should consist of only alphabets (uppercase or lowercase).';
        } else if ($_POST['signup_password'] != $_POST['repeat_password']) {
            $context['result'] = 7;
            $context['msg'] = 'Please repeat your password.';
        } else {
            $user->first_name = ucfirst($_POST['first_name']);
            $user->last_name = ucfirst($_POST['last_name']);
            $user->email = strtolower($_POST['signup_email']);
            $user->password = md5($_POST['signup_password']);
            $user->is_authorized = $sr_default_authority;
            $user->is_admin = 0;
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

        if ($context['result'] === 0) {
            sr_signin($user);
            if (isset($_SESSION['next_page']) && isset($_SESSION['room_name'])) {
                $room_name = $_SESSION['room_name'];
                unset($_SESSION['next_page']);
                unset($_SESSION['room_name']);
                sr_redirect('/d/room/?name=' . $room_name);
            } else {
                sr_redirect('/d/');
            }
        } else {
            sr_response('views/main/signup.php', $context);
        }

    } else {
        // Show signup view
        sr_response('views/main/signup.php', null);
    }
}

function main_profile() {
    if (!sr_is_signed_in()) {
        sr_response_error(400);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        global $sr_regex_name;
        global $sr_regex_email;
        global $sr_regex_password;

        $user = new User();
        $context = array();

        if (!preg_match($sr_regex_email, $_POST['profile_email'])) {
            $context['result'] = 3;
            $context['msg'] = 'Please enter a valid email address';
        } else if (!preg_match($sr_regex_password, $_POST['profile_password'])) {
            $context['result'] = 4;
            $context['msg'] = 'Please enter a valid password.<br />Password should be alphanumeric.';
        } else if (!preg_match($sr_regex_name, $_POST['first_name'])) {
            $context['result'] = 5;
            $context['msg'] = 'Name should consist of only alphabets (uppercase or lowercase).';
        } else if (!preg_match($sr_regex_name, $_POST['last_name'])) {
            $context['result'] = 6;
            $context['msg'] = 'Name should consist of only alphabets (uppercase or lowercase).';
        } else if ($_POST['profile_password'] != $_POST['repeat_password']) {
            $context['result'] = 7;
            $context['msg'] = 'Please repeat your password.';
        } else {
            try {
                $db = sr_pdo();

                $user = $user->get($db, sr_user_id());

                $user->first_name = ucfirst($_POST['first_name']);
                $user->last_name = ucfirst($_POST['last_name']);
                $user->email = strtolower($_POST['profile_email']);
                $user->password = md5($_POST['profile_password']);

                $user->save($db);

                $context['result'] = 1;
                $context['msg'] = 'Successfully updated';

                sr_set_user_first_name($user->first_name);
                sr_set_user_last_name($user->last_name);
                sr_set_user_name($user->first_name . ' ' . $user->last_name);
                sr_set_user_email($user->email);

            } catch (PDOException $e) {
                $context['result'] = 2;
                $context['msg'] = 'Failed to save. Please try it again.';
            }
        }

        $context['first_name']  = sr_user_first_name();
        $context['last_name']   = sr_user_last_name();
        $context['email']       = sr_user_email();
        $context['is_authorized']   = sr_is_authorized();
        $context['is_admin']        = sr_is_admin();
        
        sr_response('views/main/profile.php', $context);

    } else {
        // Show profile view
        $context = array(
            'first_name'  => sr_user_first_name(),
            'last_name'   => sr_user_last_name(),
            'email'       => sr_user_email(),
            'is_authorized'   => sr_is_authorized(),
            'is_admin'        => sr_is_admin()
        );

        sr_response('views/main/profile.php', $context);
    }
}

function main_signout() {
    $context = array();

    if (sr_is_signed_in()) {
        $context['result'] = 0;
        $context['msg'] = 'Thank you, '. $_SESSION['user_name'] .' :)<br />Please wait...';
        sr_signout();
        sr_response('views/main/signout.php', $context);
    } else {
        sr_response_error(400);
    }
}

function main_goto_room() {
    global $sr_root;
    global $sr_default_chat_name;

    if ($room_name = $_GET['room_name']) {
        $room_name = str_replace(' ', '_', $room_name);
    } else {
        $room_name = uniqid('r');
    }

    if (isset($_GET['user_name']) && strlen($_GET['user_name']) > 0) {
        $_SESSION['chat_name'] = $_GET['user_name'];

    } else {
        if (isset($_SESSION['user_name'])) {
            $_SESSION['chat_name'] = $_SESSION['user_name'];
        } else {
            $_SESSION['chat_name'] = $sr_default_chat_name;
        }
    }

    if (!isset($_SESSION['user_name'])) {
        $_SESSION['user_name'] = $_SESSION['chat_name'];
    }

    header('Location: ' . $sr_root . '/d/room/?name=' . $room_name);
}

?>

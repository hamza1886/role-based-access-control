<?php
session_start();
require_once '../model/User.php';
$data = array();
$error = false;
$_SESSION['user'] = array();

if ($_POST) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $remember_me = filter_input(INPUT_POST, 'remember_me', FILTER_VALIDATE_BOOLEAN);

    if (is_null($email) || $email === false ||
        is_null($password) || $password === false) {
        $error = true;
    } else {
        $user = User::validate($email, $password);

        if ($user === false) {
            $error = true;
            $_SESSION['user'] = array('email' => $email);
        } else {
            $_SESSION['user'] = $user;
//            $_SESSION['user']['member_since'] = date('F Y', strtotime($user->created_on));
        }
    }
} else {
    $error = true;
    $_SESSION['user'] = array('email' => '');
}

$data = array(
    'session' => $_SESSION['user'],
    'error' => $error,
);

echo json_encode($data);

?>

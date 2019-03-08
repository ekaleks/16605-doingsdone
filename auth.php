<?php
session_start();

require_once('functions.php');
require_once('connect.php');

$projects = [];
$required_fields = [];
$errors = [];
$error_email = false;
$users = [];
$error_user = false;
$error_password = false;
$user;
$password;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['email', 'password'];
    $users = $_POST;

    foreach ($required_fields as $field) {
		if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }

    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_validate'] = 'Email введен неккоректно';
        $error_email = true;
    }

    if (!count($errors)) {

        $user = get_email_for_user($connect, $users['email']);

        if (isset($user)) {
                $user = get_user($connect, $users['email']);
                foreach ($user as $key) {
                if (password_verify($users['password'], $key['password'])) {

                    header('Location: /index.php');
                    die();
                }
                else {
                    $error_password = true;
                    var_dump($error_password);
                }

            }

        }
        else {
            $error_user = true;
            var_dump($error_user);
            }
    }
}


$content = include_template('auth.php', ['errors' => $errors, 'users' => $users, 'error_email' => $error_email ]);

$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'title' => 'Дела в порядке']);

print($layout);


?>

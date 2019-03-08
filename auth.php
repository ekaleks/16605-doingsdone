<?php

require_once('functions.php');
require_once('connect.php');

session_start();

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

        if ($user) {
                $user = get_user($connect, $users['email']);
                foreach ($user as $key) {
                if (password_verify($users['password'], $key['password'])) {
                     $_SESSION['user'] = $user;
                }
                {
                    $errors['password'] = 'Неверный пароль';
                }

            }

        }
        else {
            $errors['errors_user'] = 'Такой пользователь не найден';
            }
    }

    if (count($errors)) {
		$page_content = include_template('auth.php', ['users' => $users, 'errors' => $errors]);
    }


}




$content = include_template('auth.php', ['errors' => $errors, 'users' => $users, 'error_email' => $error_email ]);

$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'title' => 'Дела в порядке']);

print($layout);


?>

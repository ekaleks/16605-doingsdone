<?php

require_once('functions.php');
require_once('connect.php');


$projects = [];
$required_fields = [];
$errors = [];
$error_email = false;
$form = [];
$error_user = false;
$error_password = false;
$user;
$password;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $required_fields = ['email', 'password'];
    $form = $_POST;

    foreach ($required_fields as $field) {
		if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }

    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_validate'] = 'Email введен неккоректно';
        $error_email = true;
    }

    $user = get_user($connect, $form['email']);

    if (!count($errors) && $user !== []) {

        if (password_verify($form['password'], $user['0']['password'])) {

                     $_SESSION['user'] = $user;
                }

                else {
                    $errors['error_password'] = 'Неверный пароль';

                }


        }
        else {
            $errors['error_user'] = 'Такой пользователь не найден';
            }


    if (count($errors)) {
		$content = include_template('auth.php', ['form' => $form, 'errors' => $errors, 'user' => $user, 'error_email' => $error_email ]);
    }

else {
    header("Location: index.php");
		die();
}

}

$content = include_template('auth.php', ['form' => $form, 'errors' => $errors, 'error_email' => $error_email ]);

$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'title' => 'Дела в порядке']);

print($layout);


?>

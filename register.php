<?php
require_once('functions.php');
require_once('connect.php');

$projects =[];
$required_fields = [];
$errors = [];
$users = [];
$user_email = [];
$error_field = false;
$error_email = false;
$error_unique = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['email', 'password', 'name'];
    $users = $_POST;

    foreach ($required_fields as $field) {

		if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }

    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_validate'] = 'Неправильный формат email';
        $error_email = true;
    }

    else {
        $user_email = get_email_for_user($connect, $_POST['email']);
            if ($user_email) {
            $errors['unique'] = 'Этот email уже есть';
            $error_unique = true;
            }

    }

    if (!count($errors)) {
        $users['password'] = password_hash ($users['password'], PASSWORD_DEFAULT);

        put_user_in_database($connect, $users);
        header('Location: /index.php');
        die();

    }

    }


$content = include_template('register.php', ['projects' => $projects, 'connect' => $connect, 'users' => $users, 'errors' => $errors,
'error_field' => $error_field, 'error_email' => $error_email, 'error_unique' => $error_unique]);

$layout = include_template('layout.php', ['content' => $content, 'title' => 'Дела в порядке']);

print($layout);
?>

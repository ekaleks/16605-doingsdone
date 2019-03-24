<?php
require_once('functions.php');
require_once('connect.php');

$projects = [];
$required_fields = [];
$errors = [];
$users = [];
$user_email = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['email', 'password', 'name'];

    $users = $_POST;

    foreach ($required_fields as $field) {

        if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    if (isset($_POST['email']) && !empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email_validate'] = 'Неправильный формат email';
    } else {
        if (isset($_POST['email'])) {

            $user_email = get_email_for_user($connect, $_POST['email']);
            if ($user_email) {
                $errors['unique'] = 'Этот email уже есть';
            }
        }
    }

    if (!count($errors)) {
        $users['password'] = password_hash($users['password'], PASSWORD_DEFAULT);

        put_user_in_database($connect, $users);
        header('Location: /index.php');
        die();
    }
}


$content = include_template('register.php', [
    'projects' => $projects,
    'connect' => $connect,
    'users' => $users,
    'errors' => $errors
]);

$layout = include_template('layout.php', [
    'content' => $content,
    'title' => 'Дела в порядке']);

print($layout);

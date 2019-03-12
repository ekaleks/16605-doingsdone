<?php

require_once('functions.php');
require_once('connect.php');

$user = [];


if (isset($_SESSION['user']['0']['id'])) {

    $user = $_SESSION['user']['0']['id'];

$projects = get_projects_for_user($connect, $user);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['name'];
    $form['name'] = $_POST['name'];
    $form['user_id'] = strval($user);


    foreach ($required_fields as $field) {
		if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    if (trim($_POST['name']) === '') {
        $errors['name_error'] = 'Неправильно указано название проекта';
    }

    $project = get_projects_with_title_for_user($connect, $_POST['name'], $user);

    if ($project) {
        $errors['unique'] = 'Этот проект уже есть';
        }


        if (!count($errors)) {

            put_project_in_database($connect, $form);

            header('Location: /index.php');
            die();
        }


}
}
else {
    header('Location: /guest.php');
            die();
}


$content = include_template('addProject.php', ['user' => $user, 'connect' => $connect, 'projects' => $projects,
'errors' => $errors]);

$layout = include_template('layout.php', ['projects' => $projects, 'connect' => $connect, 'content' => $content, 'title' => 'Дела в порядке', 'user' => $user]);

print($layout);
?>

<?php

$user = [];

require_once('functions.php');
require_once('connect.php');


if (isset($_SESSION['user']['0']['id'])) {

    $user = $_SESSION['user']['0']['id'];

$projects = get_projects_for_user($connect, $user);
$error_file = false;
$date_error = false;
$name_project_error = false;
$name_task_error = false;
$tasks = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required_fields = ['name', 'date'];
    $tasks['name'] = $_POST['name'];

    foreach ($required_fields as $field) {
		if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    	if (isset($_FILES['preview']) && $_FILES['preview']['error'] === 0) {
            $file_name = $_FILES['preview']['name'];
            $file_path = __DIR__ . '/uploads/';
            $file_url = '/uploads/'.$file_name;

            move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name);
            $tasks['user_file'] = $file_url;
        }

        else {
            $errors['file'] = 'Вы не загрузили файл';
            $error_file = true;
        }

        $field_date = $_POST['date'];
        $current_date = time();


        if (check_date_format($field_date) === false && strtotime($field_date) < ($current_date - 86400)) {
            $errors['date_error'] = 'Неправильный формат даты';
            $date_error = true;
        }
        else{
            $tasks['date'] = date('Y-m-d', strtotime($_POST['date']));
        }


        foreach ($projects as $project) {
        if ($project['id'] === []){
            $errors['name_project_error'] = 'Названия проекта нет в базе';
            $name_project_error = true;
        }
        else {
            $tasks['project_id'] = strval($project['id']);
        }
    }

        if ($tasks['name'] === ' ') {
            $errors['name_error'] = 'Неправильно указано название задачи';
            $name_task_error = true;
        }

        if (!count($errors)) {
            put_task_in_database($connect, $tasks);

            header('Location: /index.php');
            die();
        }
}
}
else {
    header('Location: /guest.php');
            die();
}

$content = include_template('add.php', ['user' => $user, 'connect' => $connect,'tasks' => $tasks, 'projects' => $projects,
'errors' => $errors, 'error_file' => $error_file,
'date_error' => $date_error, 'name_project_error' => $name_project_error,
'name_task_error' => $name_task_error]);

$layout = include_template('layout.php', [ 'connect' => $connect, 'tasks' => $tasks, 'projects' => $projects, 'content' => $content, 'title' => 'Дела в порядке', 'user' => $user]);

print($layout);
?>

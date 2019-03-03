<?php

require_once('functions.php');
require_once('connect.php');

$user = 3;
$projects = get_projects_for_user($connect, $user);
$error_field = false;
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
            $errors['field'] = 'Это поле надо заполнить';
            $error_field = true;
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

        if (check_date_format($field_date) === false && strtotime($field_date) < $current_date ) {
            $errors['date_error'] = 'Неправильный формат даты';
            $date_error = true;
        }
        else{
            $tasks['date'] = date( 'Y-m-d h:i:s', strtotime($_POST['date']));
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

            header('Location: http://16605-doingsdone/index.php');
        }
}


$content = include_template('add.php', ['tasks' => $tasks, 'projects' => $projects,
'errors' => $errors, 'error_field' => $error_field, 'error_file' => $error_file,
'date_error' => $date_error, 'name_project_error' => $name_project_error,
'name_task_error' => $name_task_error]);

$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'projects' => $projects, 'title' => 'Дела в порядке']);

print($layout);
?>

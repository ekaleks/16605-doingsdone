<?php

require_once('functions.php');
require_once('connect.php');

$user = 3;
$projects = get_projects_for_user($connect, $user);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tasks = $_POST;
    $required_fields = ['name', 'date'];
    /*$dictionary = ['name' => 'Название задачи', 'project' => 'Название проекта', 'date' => 'Дата', 'preview' => 'Файл'];*/
    $errors = [];

    $error_field = false;
    $error_file = false;

    foreach ($required_fields as $field) {
		if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
            $error_field = true;
        }
    }

    	if (isset($_FILES['preview'])) {
            var_dump($_FILES);
            $file_name = $_FILES['preview']['name'];
            $file_path = __DIR__ . '/uploads/';
            $file_url = '/uploads/'.$file_name;

            move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name);
            $tasks['user_file'] = $file_path;
        }
        else {
            $errors['file'] = 'Вы не загрузили файл';
            $error_file = true;
        }

        $field_date = $_POST['date'];
        $current_date = time();
        $date_error = false;
        $name_project_error = false;
        $name_task_error = false;

        if (check_date_format($field_date) === false && strtotime($field_date) < $current_date ) {
            $errors['date_error'] = 'Неправильный формат даты';
            $date_error = true;
        }

        if ($projects['id'] === []){
            $errors['name_project'] = 'Названия проекта нет в базе';
            $name_project_error = true;
        }

        if ($tasks['name'] === ' ') {
            $errors['name_error'] = 'Неправильно указано название задачи';
            $name_task_error = true;
        }

        if (count($errors)) {
            $content = include_template('add.php', ['tasks' => $tasks, 'projects' => $projects, 'errors' => $errors, /*'dictionary' => $dictionary*/]);
        }
        else {
            $content = include_template('add.php', ['tasks' => $tasks, 'projects' => $projects]);
            put_task_in_database($connect, $tasks);

        }
}

else {
	$content = include_template('add.php', ['projects' => $projects]);
}


$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'projects' => $projects, 'title' => 'Дела в порядке']);

print($layout);
?>

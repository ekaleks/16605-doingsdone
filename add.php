<?php

$user = [];

require_once('functions.php');
require_once('connect.php');


if (isset($_SESSION['user']['0']['id'])) {

    $user = $_SESSION['user']['0']['id'];

    $projects = get_projects_for_user($connect, $user);

    $form = [];
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required_fields = ['name', 'date'];

        if (isset($_POST['name'])) {
            $form['name'] = $_POST['name'];
        }

        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = 'Это поле надо заполнить';
            }
        }

        if (isset($_FILES['preview']) && $_FILES['preview']['error'] === 0) {
            $file_name = $_FILES['preview']['name'];
            $file_path = __DIR__ . '/uploads/';
            $file_url = '/uploads/' . $file_name;

            move_uploaded_file($_FILES['preview']['tmp_name'], $file_path . $file_name);
            $form['user_file'] = $file_url;
        } else {
            $form['user_file'] = '';
        }


        if (isset($_POST['date'])) {
            $form['date'] = $_POST['date'];
        }
        $current_date = time();



        if (isset($form['date']) && !empty($form['date']) && check_date_format($form['date']) === false && strtotime($form['date']) < ($current_date - 86400)) {
            $errors['date_error'] = 'Неправильный формат даты';
        } else {
            if (isset($_POST['date'])) {
                $form['date'] = date('Y-m-d', strtotime($_POST['date']));
            }
        }

        if (isset($projects)) {
            foreach ($projects as $project) {
                if ($project['id'] === []) {
                    $errors['name_project_error'] = 'Названия проекта нет в базе';
                } else {
                    if (isset($project['id'])) {
                        $form['project_id'] = strval($project['id']);
                    }
                }
            }
        }

        if (!isset($errors['name']) && isset($form['name']) && trim($form['name']) === '') {
            $errors['name_error'] = 'Неправильно указано название задачи';
        }


        if (!count($errors)) {
            put_task_in_database($connect, $form);

            header('Location: /index.php');
            die();
        }
    }
} else {
    header('Location: /guest.php');
    die();
}

$content = include_template('add.php', [
    'user' => $user,
    'connect' => $connect,
    'form' => $form,
    'projects' => $projects,
    'errors' => $errors
]);

$layout = include_template('layout.php', [
    'connect' => $connect,
    'projects' => $projects,
    'content' => $content,
    'title' => 'Дела в порядке',
    'user' => $user]);

print($layout);

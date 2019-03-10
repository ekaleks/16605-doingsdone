<?php

require_once('functions.php');
require_once('connect.php');

$user = [];

if (isset($_SESSION['user']['0']['id'])) {
    $user = $_SESSION['user']['0']['id'];
// показывать или нет выполненные задачи

$show_complete_tasks = rand(0, 1);

$projects;
$tasks;
$project_id = null;
$result_sql = null;
$check = 0;

$projects = get_projects_for_user($connect, $user);

if (isset($_GET['task_id']) && isset($_GET['check'])) {

    $task_id = $_GET['task_id'];
    $check = $_GET['check'];
    $task = get_status_task($connect, $task_id);
    $status = $task['0']['is_done'];

    if ($check === '1' && $status === 0) {
       update_tasks_status_check($connect, $task_id);
       header('Location: /index.php');
    die();

    }

     if ($check === '1' && $status === 1) {
        update_tasks_status_not_check($connect, $task_id);
        header('Location: /index.php');
        die();

    }
}


if (isset($_GET['id'])) {
    $project_id = (int)$_GET['id'];
    $result_sql = get_tasks_for_user_and_project($connect, $user, $project_id);
    $tasks = $result_sql;

    if ($result_sql === []) {
        $content = include_template('error.php', []);
    }

    else {
        foreach ($tasks as $key => $task) {
            if ((floor((strtotime($task['date']) - time())/3600)) <= 24 && (strtotime($task['date'])) !== false && $task['is_done'] == false) {
                $tasks[$key]['is_important'] = true;}
            else {
                $tasks[$key]['is_important'] = false;
            }
        };


        $content = include_template('index.php', ['check' => $check, 'user' => $user, 'connect' => $connect, 'tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks]);

    }
}

else {
    $tasks = get_tasks_for_user($connect, $user);

    foreach ($tasks as $key => $task) {
        if ((floor((strtotime($task['date']) - time())/3600)) <= 24 && (strtotime($task['date'])) !== false && $task['is_done'] == false) {
            $tasks[$key]['is_important'] = true;}
        else {
            $tasks[$key]['is_important'] = false;
        }
    };
    $content = include_template('index.php', ['check' => $check, 'connect' => $connect, 'tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks, 'user' => $user]);
}

}
else {
    header('Location: /guest.php');
    die();

}


$layout = include_template('layout.php',
['projects' => $projects, 'tasks' => $tasks, 'connect' => $connect, 'content' => $content, 'title' => 'Дела в порядке']);

print($layout);
?>


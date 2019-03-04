<?php

require_once('functions.php');
require_once('connect.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects;
$tasks;
$project_id = null;
$result_sql = null;

$user = 3;

$projects = get_projects_for_user($connect, $user);

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
        $content = include_template('index.php', ['tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks]);
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

    $content = include_template('index.php', ['tasks' => $tasks, 'projects' => $projects, 'show_complete_tasks' => $show_complete_tasks]);
}



$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'title' => 'Дела в порядке']);

print($layout);
?>


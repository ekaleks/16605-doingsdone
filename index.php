<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once('functions.php');
require_once('connect.php');

$projects;
$tasks;

$user = 3;
if (isset($user)) {
$projects = get_projects_for_user($connect, $user);
$tasks = get_tasks_for_user($connect, $user);
}
else {
    $projects = [];
    $tasks = [];
}

$project_id = null;
$result_sql = null;

try{
if (isset($_GET['id'])) {
    $project_id = (int)$_GET['id'];
    $result_sql = get_tasks_for_user_and_project($connect, $user, $project_id);
    $tasks = $result_sql;
    if ($result_sql === []) {
        throw new Exception('Ошибка 404: задач не найдено.');
    }
}
else {
    $tasks = get_tasks_for_user($connect, $user);
}
}
catch(Exception $e){
    echo $e->getMessage();
    exit();
}

foreach ($tasks as $key => $task) {
    if ((floor((strtotime($task['date']) - time())/3600)) <= 24 && (strtotime($task['date'])) !== false && $task['is_done'] == false) {
        $tasks[$key]['is_important'] = true;}
    else {
        $tasks[$key]['is_important'] = false;
    }
};

$content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'title' => 'Дела в порядке']);

print($layout);
?>


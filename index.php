<?php

/*$projects = ['Входящие', 'Учёба', 'Работа', 'Домашние дела', 'Авто'];
$tasks = [
    [
        'name' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
        'category' => 'Работа',
        'is_done' => false
    ],
    [
        'name' => 'Выполнить тестовое задание',
        'date' => '25.12.2019',
        'category' => 'Работа',
        'is_done' => false
    ],
    [
        'name' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'category' => 'Учёба',
        'is_done' => true
    ],
    [
        'name' => 'Встреча с другом',
        'date' => '01.12.2019',
        'category' => 'Входящие',
        'is_done' => false
    ],
    [
        'name' => 'Купить корм для кота',
        'date' => '12.02.2019',
        'category' => 'Домашние дела',
        'is_done' => false
    ],
    [
        'name' => 'Заказать пиццу',
        'date' => Null,
        'category' => 'Домашние дела',
        'is_done' => false
    ]
];
*/

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once('functions.php');
require_once('connect.php');

$user = ['3'];

if ($user !== Null) {

$projects = get_projects_for_user($connect, $user);

$tasks = get_tasks_for_user($connect, $user);
}
else {
    $projects = [];
    $tasks = [];
}

if(isset($_GET['id'])) {
    $project_id = $_GET['id'];
}
else{
    $project_id = '';
}

if ($project_id !== '') {
    $tasks = get_tasks_for_project($connect, $project_id);
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
['project_id' => $project_id, 'content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'title' => 'Дела в порядке']);

print($layout);
?>


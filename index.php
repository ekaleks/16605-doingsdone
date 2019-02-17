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

$connect = mysqli_connect('localhost', 'root', '', 'things_in_order');

if ($connect == false) {
    print('Ошибка подключения' . mysqli_connect_error());
}
mysqli_set_charset($connect, 'utf8');

$sql_query_projects = 'SELECT title FROM projects WHERE user_id = 3';
$projects = mysqli_query($connect, $sql_query_projects);
if($projects === false) {
    $projects_error = mysqli_error($connect);
    print('Ошибка MySQL:' . $projects_error);
}

$projects = mysqli_fetch_all($projects, MYSQLI_ASSOC);


$sql_query_tasks = 'SELECT title_task, deadline, title, status FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = 3';
$tasks = mysqli_query($connect, $sql_query_tasks);
if($projects === false) {
    $tasks_error = mysqli_error($connect);
    print('Ошибка MySQL:' . $tasks_error);
}

$tasks = mysqli_fetch_all($tasks, MYSQLI_ASSOC);

foreach ($tasks as $key => $task) {
    if ((floor((strtotime($task['deadline']) - time())/3600)) <= 24 && (strtotime($task['deadline'])) !== false && $task['status'] == false) {
        $tasks[$key]['is_important'] = true;}
    else {
        $tasks[$key]['is_important'] = false;
    }
};

require_once('functions.php');

$content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks]);

$layout = include_template('layout.php',
['content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'title' => 'Дела в порядке']);

print($layout);
?>


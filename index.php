<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$projects = ['Входящие', 'Учёба', 'Работа', 'Домашние дела', 'Авто'];
$tasks = [
    [
        'name' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
        'category' => 'Работа',
        'done' => false
    ],
    [
        'name' => 'Выполнить тестовое задание',
        'date' => '25.12.2019',
        'category' => 'Работа',
        'done' => false
    ],
    [
        'name' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'category' => 'Учёба',
        'done' => true
    ],
    [
        'name' => 'Встреча с другом',
        'date' => '01.12.2019',
        'category' => 'Входящие',
        'done' => false
    ],
    [
        'name' => 'Купить корм для кота',
        'date' => '11.02.2019',
        'category' => 'Домашние дела',
        'done' => false
    ],
    [
        'name' => 'Заказать пиццу',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'done' => false
    ]
];

require_once('functions.php');

$content = include_template('index.php', ['tasks' => $tasks, 'show_complete_tasks' => $show_complete_tasks,]);

$layout = include_template('layout.php',
['content' => $content, 'projects' => $projects, 'tasks' => $tasks, 'title' => 'Дела в порядке']);

print($layout);
?>


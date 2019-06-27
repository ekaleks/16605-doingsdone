<?php

require_once('vendor/autoload.php');
require_once('functions.php');
require_once('connect.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$tasks = null;
$result_sql = null;

$result_sql = get_tasks_for_sending_letter($connect);

$tasks = $result_sql;

$result_sql = get_users_for_sending_letter($connect);

$users = $result_sql;

$recipients = [];

foreach ($users as $user) {
    $recipients[$user['email']] = $user['name'];
}

$message = new Swift_Message();
$message->setSubject( "Уведомление от сервиса «Дела в порядке»");
$message->setFrom(['keks@phpdemo.ru' => 'Doingsdone']);
$message->setBcc($recipients);

$msg_content = include_template('notify.php', ['tasks' => $tasks]);
$message->setBody($msg_content, 'text/html');

$result = $mailer->send($message);

if ($result) {
    print("Рассылка успешно отправлена");
} else {
    print("Не удалось отправить рассылку: " . $logger->dump());
}

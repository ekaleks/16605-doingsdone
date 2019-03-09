<?php

require_once('functions.php');
require_once('connect.php');

$content = include_template('guest.php', []);

$layout = include_template('layout.php',
['connect' => $connect, 'content' => $content, 'title' => 'Дела в порядке']);

print($layout);

?>

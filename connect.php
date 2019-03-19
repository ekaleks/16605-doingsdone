<?php

$connect = mysqli_connect('localhost', 'root', '', 'things_in_order');

if ($connect == false) {
    print('Ошибка подключения' . mysqli_connect_error());
    exit;
}
mysqli_set_charset($connect, 'utf8');

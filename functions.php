<?php
//Функция шаблонизатор
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

/*
 Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 @param string $date строка с датой
 @return bool
 */
function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    return $result;
}


//Функция подсчитывающая количество задач в проекте
function countTasksInProject($connect, $projectName) {
    $tasks = get_category_tasks($connect);
    $count = 0;
    foreach ($tasks as $task) {
    if ( $task['category'] === $projectName) {
    $count++;
}
    }
    return $count;
};

require('mysql_helper.php');

//Функция получающая из БД список категорий задач для сравнения их с названиями проектов
function get_category_tasks($connect){
    $sql_query = 'SELECT p.title AS category FROM tasks t JOIN projects p ON t.project_id = p.id';
    $result = mysqli_query($connect, $sql_query);
    if($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач для текущего юзера и проекта
function get_tasks_for_user_and_project($connect, $data1, $data2){
    $data = [$data1, $data2];
    $sql_query = 'SELECT t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = ? AND project_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список проектов для текущего юзера
function get_projects_for_user($connect, $data){
    $data = [$data];
    $sql_query = 'SELECT id,title FROM projects WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач для текущего юзера
function get_tasks_for_user($connect, $data){
    $data = [$data];
    $sql_query = 'SELECT t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач для текущего проекта
function get_tasks_for_project($connect, $data){
    $data = [$data];
    $sql_query = 'SELECT t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE project_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//функция добавляющая новую задачу в БД для текущего проекта

function put_task_in_database($connect, $data){
    $sql_query = 'INSERT INTO tasks (title, user_file, deadline, project_id) VALUES (?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if($result){
        $result = mysqli_insert_id($connect);
    }

    return $result;
};

//Функция получающая из БД список юзеров


function get_email_for_user($connect, $data){
    $data = [$data];
    $sql_query = 'SELECT e_mail AS email FROM users WHERE e_mail = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

function get_user($connect, $data){
    $data = [$data];
    $sql_query = 'SELECT id, e_mail AS email, password, name FROM users WHERE e_mail = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};


//функция добавляющая нового юзера в БД
function put_user_in_database ($connect, $data) {
    $sql_query = 'INSERT INTO users (e_mail, password, name) VALUES (?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if($result){
        $result = mysqli_insert_id($connect);
    }

    return $result;
};


?>

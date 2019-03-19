<?php
 // подключение сессии
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('mysql_helper.php');

//Функция шаблонизатор
function include_template($name, $data)
{
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
function check_date_format($date)
{
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    return $result;
}


//Функция подсчитывающая количество задач в проекте
function countTasksInProject($connect, $projectName, $data)
{
    $tasks = get_category_tasks_for_user($connect, $data);
    $count = 0;
    foreach ($tasks as $task) {
        if ($task['category'] === $projectName) {
            $count++;
        }
    }
    return $count;
};



//Функция получающая из БД список категорий задач для сравнения их с названиями проектов
function get_category_tasks_for_user($connect, $data)
{
    $sql_query = 'SELECT p.title AS category FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач для текущего юзера и проекта
function get_tasks_for_user_and_project($connect, $data1, $data2)
{
    $data = [$data1, $data2];
    $sql_query = 'SELECT t.id AS task_id, t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = ? AND project_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач на текущую дату
function get_tasks_for_user_now($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT t.id AS task_id, t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE deadline <= NOW()   AND deadline > DATE_SUB(NOW(), INTERVAL 1 DAY) AND user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач на завтра
function get_tasks_for_user_tomorrow($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT t.id AS task_id, t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE deadline > NOW() AND deadline < DATE_ADD(NOW(), INTERVAL 1 DAY) AND user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список просроченых задач
function get_tasks_for_user_yesterday($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT t.id AS task_id, t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE deadline < DATE_SUB(NOW(), INTERVAL 1 DAY) AND user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};



//Функция получающая из БД список проектов для текущего юзера
function get_projects_for_user($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT id, title, user_id FROM projects WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция проверяющая наличие проекта с определенным названием в БД

function get_projects_with_title_for_user($connect, $data1, $data2)
{
    $data = [$data1, $data2];
    $sql_query = 'SELECT id, title FROM projects WHERE title = ? AND user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};


//Функция получающая из БД список задач для текущего юзера
function get_tasks_for_user($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT t.id AS task_id, t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//Функция получающая из БД список задач для текущего проекта
function get_tasks_for_project($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT t.id AS task_id, t.title AS name, user_file, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE project_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

//функция добавляющая новую задачу в БД для текущего проекта

function put_task_in_database($connect, $data)
{
    $sql_query = 'INSERT INTO tasks (title, user_file, deadline, project_id) VALUES (?, ?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};


function put_project_in_database($connect, $data)
{
    $sql_query = 'INSERT INTO projects (title, user_id) VALUES (?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};

//Функция получающая из БД список юзеров


function get_email_for_user($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT e_mail AS email FROM users WHERE e_mail = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

function get_user($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT id, e_mail AS email, password, name FROM users WHERE e_mail = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};


//функция добавляющая нового юзера в БД
function put_user_in_database($connect, $data)
{
    $sql_query = 'INSERT INTO users (e_mail, password, name) VALUES (?, ?, ?)';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};


// функция меняющая статус задачи на 'выполнено'
function update_tasks_status_check($connect, $data)
{
    $data = [$data];
    $sql_query = 'UPDATE tasks SET status = 1 WHERE id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};


// функция меняющая статус задачи на 'невыполнено'
function update_tasks_status_not_check($connect, $data)
{
    $data = [$data];
    $sql_query = 'UPDATE tasks SET status = 0 WHERE id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }

    return $result;
};

// функция получающая статус задачи
function get_status_task($connect, $data)
{
    $data = [$data];
    $sql_query = 'SELECT status AS is_done FROM tasks WHERE id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

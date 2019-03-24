<?php

// подключение сессии
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('mysql_helper.php');


/**
 * Функция - шаблонизатор
 *
 * @param $name Имя файла шаблона
 * @param array $data Данные для этого шаблона
 *
 * @return $result Итоговый HTML-код с подставленными данными
 */
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


/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 *
 * @param string $date строка с датой
 *
 * @return bool
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



/**
 * Подсчитывает количество задач в проекте
 *
 * @param $connect Ресурс соединения
 * @param string $projectName Строка с названием проекта
 * @param array $data Данные для запроса из базы SQL
 *
 * @return integer $count Количество задач
 */
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


/**
 * Получает из БД список категорий задач
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return array $result Массив с категориями задач
 */
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


/**
 * Получает из БД список задач для текущего юзера и проекта
 *
 * @param $connect Ресурс соединения
 * @param integer $data1 Id юзера для запроса из базы SQL
 * @param integer $data2 Id проекта для запроса из базы SQL
 *
 * @return array $result Массив задач
 */
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


/**
 * Получает из БД список задач для юзера на текущую дату
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id юзера для запроса из базы SQL
 *
 * @return array $result Массив задач
 */
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

/**
 * Получает из БД список задач для юзера на завтрашнюю дату
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id юзера для запроса из базы SQL
 *
 * @return array $result Массив задач
 */
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


/**
 * Получает из БД список просроченых задач для юзера
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id юзера для запроса из базы SQL
 *
 * @return array $result Массив задач
 */
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


/**
 * Получает из БД список проектов для текущего юзера
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id юзера для запроса из базы SQL
 *
 * @return array $result Массив проектов
 */
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

/**
 * Проверяет наличие проекта с определенным названием в БД
 *
 * @param $connect Ресурс соединения
 * @param string $data1 Название проекта для запроса из базы SQL
 * @param integer $data2 Id юзера для запроса из базы SQL
 *
 * @return array $result Массив проектов
 */
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

/**
 * Получает из БД список задач для текущего юзера
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id юзера для запроса из базы SQL
 *
 * @return array $result Массив задач
 */
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

/**
 * Получает из БД список задач для текущего проекта
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id проекта для запроса из базы SQL
 *
 * @return array $result Массив задач
 */
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

/**
 * Добавляет в БД новую задачу
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return bool
 */
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

/**
 * Добавляет в БД новый проект
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return bool
 */
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


/**
 * Получает из БД список email-ов юзеров по email
 *
 * @param $connect Ресурс соединения
 * @param string $data Email юзера для запроса из базы SQL
 *
 * @return array $result Массив юзеров
 */
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

/**
 * Получает из БД список юзеров по email
 *
 * @param $connect Ресурс соединения
 * @param integer $data Email юзера для запроса из базы SQL
 *
 * @return array $result Массив юзеров
 */
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

/**
 * Добавляет в БД нового юзера
 *
 * @param $connect Ресурс соединения
 * @param array $data Данные для запроса из базы SQL
 *
 * @return bool
 */
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

/**
 * Меняет статус задачи на 'выполнено'
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id задачи для запроса из базы SQL
 *
 * @return bool
 */
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

/**
 * Меняет статус задачи на 'невыполнено'
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id задачи для запроса из базы SQL
 *
 * @return bool
 */
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

/**
 * Получает статус задачи
 *
 * @param $connect Ресурс соединения
 * @param integer $data Id задачи для запроса из базы SQL
 *
 * @return array $result Массив со статусом задачи
 */
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

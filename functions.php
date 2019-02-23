<?php function include_template($name, $data) {
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

function countTasksInProject($tasks, $projectName) {
    $count = 0;
    foreach ($tasks as $task) {
    if ( $task['category'] === $projectName) {
    $count++;
}
    }

    return $count;
};

require('mysql_helper.php');


function get_projects($connect){
    $sql_query = 'SELECT * FROM projects';
    $result = mysqli_query($connect, $sql_query);
    if($result === false) {
        $error = mysqli_error($connect);
        print('Ошибка MySQL:' . $error);
    }
    {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

function get_tasks_for_project($connect, $data){
    $sql_query = 'SELECT t.title AS name, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE p.id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result === false) {
        $error = mysqli_error($connect);
        print('Ошибка MySQL:' . $error);
    }
    {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

function get_projects_for_user($connect, $data){
    $sql_query = 'SELECT id,title FROM projects WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result === false) {
        $error = mysqli_error($connect);
        print('Ошибка MySQL:' . $error);
    }
    {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};

function get_tasks_for_user($connect, $data){
    $sql_query = 'SELECT t.title AS name, DATE_FORMAT(deadline, "%d.%m.%Y") AS date, p.title AS category, status AS is_done FROM tasks t JOIN projects p ON t.project_id = p.id WHERE user_id = ?';
    $stmt = db_get_prepare_stmt($connect, $sql_query, $data);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if($result === false) {
        $error = mysqli_error($connect);
        print('Ошибка MySQL:' . $error);
    }
    {
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
};
?>

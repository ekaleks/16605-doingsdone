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

function get_result_sql_query($connect, $sql_query){
    $result = mysqli_query($connect, $sql_query);
    if($result === false) {
        $error = mysqli_error($connect);
        print('Ошибка MySQL:' . $error);
    }
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $result;
};

?>

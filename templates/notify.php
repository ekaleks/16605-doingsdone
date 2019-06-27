<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <h1>Уведомление от сервиса «Дела в порядке»</h1>

    <p>Уважаемый пользователь! У вас запланирована задача:</p>

    <table>
        <thead>
            <tr>
                <th style="padding: 5px;">Имя задачи</th>
                <th style="padding: 5px;">Время задачи</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task) : ?>
                <tr>
                    <td><?= htmlspecialchars($task['name']); ?></td>
                    <td><?= $task['date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>

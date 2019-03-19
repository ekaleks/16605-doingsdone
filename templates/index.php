<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/index.php?filter=all" class="tasks-switch__item <?php if (isset($_GET['filter']) && $_GET['filter'] === 'all') : ?> tasks-switch__item--active<?php endif; ?>">Все задачи</a>
        <a href="/index.php?filter=now" class="tasks-switch__item <?php if (isset($_GET['filter']) && $_GET['filter'] === 'now') : ?> tasks-switch__item--active<?php endif; ?>">Повестка дня</a>
        <a href="/index.php?filter=tomorrow" class="tasks-switch__item <?php if (isset($_GET['filter']) && $_GET['filter'] === 'tomorrow') : ?> tasks-switch__item--active<?php endif; ?>">Завтра</a>
        <a href="/index.php?filter=yesterday" class="tasks-switch__item <?php if (isset($_GET['filter']) && $_GET['filter'] === 'yesterday') : ?> tasks-switch__item--active<?php endif; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks == 1) : ?>checked<?php endif; ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
    <?php foreach ($tasks as $task) : ?>
    <tr class="tasks__item task <?php if ($task['is_done']) : ?>task--completed<?php endif; ?>
<?php if ($task['is_done'] && $show_complete_tasks === 0) : ?> hidden<?php endif; ?>
<?php if ($task['is_important']) : ?> task--important<?php endif; ?>">
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden task__checkbox " type="checkbox" value="<?= $task['task_id']; ?>">
                <span class="checkbox__text"><?= htmlspecialchars($task['name']); ?></span>
            </label>
        </td>

        <td class="task__file">
            <a class="download-link" href="<?= htmlspecialchars($task['user_file']); ?>"><?= htmlspecialchars($task['user_file']); ?></a>
        </td>

        <td class="task__date"><?= htmlspecialchars($task['date']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

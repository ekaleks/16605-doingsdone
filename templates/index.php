<header class="main-header">
            <a href="/">
                <img src="img/logo.png" width="153" height="42" alt="Логотип Дела в порядке">
            </a>

            <div class="main-header__side">
                <a class="main-header__side-item button button--plus open-modal" href="add.php">Добавить задачу</a>

                <div class="main-header__side-item user-menu">
                    <div class="user-menu__image">
                        <img src="img/user.png" width="40" height="40" alt="Пользователь">
                    </div>

                    <div class="user-menu__data">
                        <p>Константин</p>

                        <a href="logout.php">Выйти</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            <section class="content__side">
                <h2 class="content__side-heading">Проекты</h2>

                <nav class="main-navigation">
                    <ul class="main-navigation__list">
                    <?php foreach ($projects as $project): ?>
                        <li class="main-navigation__list-item">
                            <a class="main-navigation__list-item-link" href="/index.php<?= '?id='.$project['id']; ?>"><?=htmlspecialchars($project['title']); ?></a>
                            <span class="main-navigation__list-item-count"><?= countTasksInProject($connect, $project['title']); ?></span>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                </nav>

                <a class="button button--transparent button--plus content__side-button"
                   href="pages/form-project.html" target="project_add">Добавить проект</a>
            </section>
<main class="content__main">
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?php if ($show_complete_tasks == 1): ?>checked<?php endif; ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">
<?php foreach ($tasks as $task): ?>
<tr class="tasks__item task <?php if ($task['is_done'] == true): ?>task--completed<?php endif; ?>
<?php if ( $task['is_done'] == true && $show_complete_tasks === 0): ?> hidden<?php endif; ?>
<?php if ($task['is_important'] === true): ?> task--important<?php endif; ?>">
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                <span class="checkbox__text"><?=htmlspecialchars($task['name']);?></span>
            </label>
        </td>

        <td class="task__file">
            <a class="download-link" href="<?=htmlspecialchars($task['user_file']);?>"><?=htmlspecialchars($task['user_file']);?></a>
        </td>

        <td class="task__date"><?=htmlspecialchars($task['date']);?></td>
    </tr>
    <?php endforeach;?>
</table>
</main>
</div>

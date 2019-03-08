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
<h2 class="content__main-heading">Добавление задачи</h2>

        <form class="form"  action="" method="post" enctype="multipart/form-data">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?php if (($errors['name']) || $name_task_error):?>
             form__input--error
             <?php endif; ?> " type="text" name="name" id="name" value="<?= isset($tasks['name']) ? $tasks['name'] : ' ';?>" placeholder="Введите название">
            <?php if (isset($errors['name'])):?>
            <p class="form__message"><?= $errors['name']; ?></p>
            <?php endif; ?>
            <?php if ($name_task_error):?>
            <p class="form__message"><?= $errors['name_error'];?></p>
            <?php endif; ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="project">Проект</label>
            <select class="form__input form__input--select<?php if ($name_project_error):?> form__input--error<?php endif; ?> " name="project" id="project">
            <?php foreach ($projects as $project): ?>
              <option value=""><?=htmlspecialchars($project['title']); ?></option>
              <?php endforeach; ?>
            </select>
            <?php if ($name_project_error):?>
            <p class="form__message"><?= $errors['name_project_error'];?></p>
            <?php endif; ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

    <input class="form__input form__input--date<?php if ($errors['date'] || $date_error):?> form__input--error <?php endif; ?>" type="date" name="date" id="" value="<?= isset($tasks['date']) ? $tasks['date']: ' '; ?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    <?php if (isset($errors['date'])):?><p class="form__message"><?= $errors['date']; ?></p><?php endif; ?>
    <?php if ($date_error):?><p class="form__message"><?= $errors['date_error'];?></p><?php endif; ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="preview" id="preview" value="">

              <label class="button button--transparent" for="preview">
                <span>Выберите файл</span>
              </label>
            </div>
            <?php if ($error_file):?><p class="form__message"><?=$errors['file']?></p><?php endif; ?>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
</main>
</div>

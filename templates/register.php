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
<h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="" method="post">
            <div class="form__row">
              <label class="form__label" for="email">E-mail <sup>*</sup></label>

<input class="form__input <?php if ($errors['email']||$error_email || $error_unique ):?> form__input--error"<?php endif; ?> type="text" name="email" id="email" value="<?= isset($users['email']) ? $users['email'] : ''; ?>" placeholder="Введите e-mail">
<?php if (isset($errors['email'])):?><p class="form__message"><?= $errors['email']; ?></p><?php endif; ?>
<?php if ($error_email ):?><p class="form__message"><?= $errors['email_validate'] ?></p><?php endif; ?>
<?php if (!$error_email && $error_unique):?><p class="form__message"><?= $errors['unique']; ?></p><?php endif; ?>
            </div>

            <div class="form__row">
              <label class="form__label" for="password">Пароль <sup>*</sup></label>

              <input class="form__input <?php if ($errors['password']):?> form__input--error"<?php endif; ?> " type="password" name="password" id="password" value="<?= isset($users['password']) ? $users['password'] : ''; ?>" placeholder="Введите пароль">
              <?php if (isset($errors['password'])):?><p class="form__message"><?= $errors['password']; ?></p><?php endif; ?>
            </div>

            <div class="form__row">
              <label class="form__label" for="name">Имя <sup>*</sup></label>

              <input class="form__input <?php if ($errors['name']):?> form__input--error"<?php endif; ?> " type="password" name="name" id="name" value="<?= isset($users['name']) ? $users['name'] : ''; ?>" placeholder="Введите пароль">
              <?php if (isset($errors['name'])):?><p class="form__message"><?= $errors['name']; ?></p><?php endif; ?>
            </div>

            <div class="form__row form__row--controls">

            <?php if ($error_field):?><p class="error-message">Пожалуйста, исправьте ошибки в форме</p><?php endif; ?>

              <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>
          </form>
</main>
</div>

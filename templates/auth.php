<header class="main-header">
      <a href="index.php">
        <img src="../img/logo.png" width="153" height="42" alt="Логитип Дела в порядке">
      </a>

      <div class="main-header__side">
        <a class="main-header__side-item button button--transparent" href="auth.php">Войти</a>
      </div>
    </header>

    <div class="content">

      <section class="content__side">
        <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

        <a class="button button--transparent content__side-button" href="auth.php">Войти</a>
      </section>

      <main class="content__main">
        <h2 class="content__main-heading">Вход на сайт</h2>

        <form class="form" action="" method="post">
          <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

       <input class="form__input <?php if (($error['email']) || $error_email):?> form__input--error <?php endif; ?>"
        type="text" name="email" id="email" value="<?= isset($form['email']) ? $form['email'] : ' ';?>" placeholder="Введите e-mail">
        <?php if (isset($errors['email'])):?>
            <p class="form__message"><?= $errors['email']; ?></p>
        <? endif;?>
        <?php if ($error_email):?>
        <p class="form__message"><?= $errors['email_validate']; ?></p>
        <?php endif; ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input <?php if ($errors['password']):?> form__input--error<?php endif; ?>"
        type="password" name="password" id="password" value="<?= isset($form['password']) ? $form['password'] : ' ';?>" placeholder="Введите пароль">
        <?php if (isset($errors['password'])):?>
            <p class="form__message"><?= $errors['password']; ?></p>
        <? endif;?>
        <?php if (isset($errors['error_password'])):?>
            <p class="form__message"><?= $errors['error_password']; ?></p>
        <? endif;?>
        <?php if (isset($errors['error_user'])):?>
            <p class="form__message"><?= $errors['error_user']; ?></p>
        <? endif;?>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
          </div>
        </form>

      </main>

    </div>

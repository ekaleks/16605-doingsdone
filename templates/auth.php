
        <h2 class="content__main-heading">Вход на сайт</h2>

        <form class="form" action="" method="post">
          <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

       <input class="form__input <?php if (($error['email'] ?? false) || $error_email ?? false):?> form__input--error <?php endif; ?>"
        type="text" name="email" id="email" value="<?= isset($form['email']) ? htmlspecialchars($form['email']) : '';?>" placeholder="Введите e-mail">
        <?php if (isset($errors['email'])):?>
            <p class="form__message"><?= $errors['email']; ?></p>
        <? endif;?>
        <?php if ($error_email ?? false ):?>
        <p class="form__message"><?= $errors['email_validate']; ?></p>
        <?php endif; ?>
          </div>

          <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input <?php if ($errors['password'] ?? false):?>  form__input--error<?php endif; ?>"
        type="password" name="password" id="password" value="" placeholder="Введите пароль">
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

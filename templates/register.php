
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


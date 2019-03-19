<h2 class="content__main-heading">Добавление проекта</h2>

<form class="form" action="" method="post">
    <div class="form__row">
        <label class="form__label" for="project_name">Название <sup>*</sup></label>

        <input class="form__input <?php if (isset($errors['name']) || isset($errors['name_error']) || isset($errors['unique'])) : ?> form__input--error <?php endif; ?>" type="text" name="name" id="project_name" value="<?= (isset($_form['name'])) ? htmlspecialchars($_form['name']) : ''; ?>" placeholder="Введите название проекта">
        <?php if (isset($errors['name'])) : ?><p class="form__message"><?= $errors['name']; ?></p><?php endif; ?>
        <?php if (isset($errors['name_error'])) : ?><p class="form__message"><?= $errors['name_error']; ?></p><?php endif; ?>
        <?php if (isset($errors['unique'])) : ?><p class="form__message"><?= $errors['unique']; ?></p><?php endif; ?>

    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>

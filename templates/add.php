
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

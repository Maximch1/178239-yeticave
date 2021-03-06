<?php
/**
 * @var array $categories категории лотов
 * @var array $errors     массив ошибок
 * @var array $lot        массив с данными добавляемого лота
 */
?>
<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="category.php?id=<?= get_value($category, 'id'); ?>">
                  <?= get_value($category,'title'); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<main class="container">
    <form class="form form--add-lot container <?= $errors ? "form--invalid" : null; ?>" action="add.php" method="post"
          enctype="multipart/form-data"><!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= get_value($errors, 'title') ? " form__item--invalid" : null; ?>">
                <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot[title]" placeholder="Введите наименование лота"
                       value="<?= htmlspecialchars(get_value($lot, 'title')) ? htmlspecialchars(get_value($lot,
                           'title')) : null; ?>">
                <span class="form__error"><?= get_value($errors, 'title') ? get_value($errors,
                        'title') : null; ?></span>
            </div>
            <div class="form__item <?= get_value($errors, 'category_id') ? " form__item--invalid" : null; ?>">
                <label for="category">Категория</label>
                <select id="category" name="lot[category_id]">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= get_value($category, 'id'); ?>" <?= htmlspecialchars(get_value($lot,
                            'category_id')) === get_value($category,
                            'id') ? " selected" : null; ?> ><?= get_value($category, 'title'); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?= get_value($errors, 'category_id') ? get_value($errors,
                        'category_id') : null; ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= get_value($errors,
            'description') ? " form__item--invalid" : null; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="lot[description]"
                      placeholder="Напишите описание лота"><?= htmlspecialchars(get_value($lot,
                    'description')) ? htmlspecialchars(get_value($lot, 'description')) : null; ?></textarea>
            <span class="form__error"><?= get_value($errors, 'description') ? get_value($errors,
                    'description') : null; ?></span>
        </div>
        <div class="form__item form__item--file <?= get_value($errors, 'img') ? " form__item--invalid" : null; ?>">
            <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="lot_img" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= get_value($errors, 'img') ? get_value($errors, 'img') : null; ?></span>
        </div>
        <div class="form__container-three">
            <div
                class="form__item form__item--small <?= get_value($errors, 'price') ? "form__item--invalid" : null; ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot[price]" placeholder="0"
                       value="<?= htmlspecialchars(get_value($lot, 'price')) ? htmlspecialchars(get_value($lot,
                           'price')) : null; ?>">
                <span class="form__error"><?= get_value($errors, 'price') ? get_value($errors,
                        'price') : null; ?></span>
            </div>
            <div class="form__item form__item--small <?= get_value($errors,
                'step_rate') ? " form__item--invalid" : null; ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot[step_rate]" placeholder="0"
                       value="<?= htmlspecialchars(get_value($lot, 'price')) ? htmlspecialchars(get_value($lot,
                           'step_rate')) : null; ?>">
                <span class="form__error"><?= get_value($errors, 'step_rate') ? get_value($errors,
                        'step_rate') : null; ?></span>
            </div>
            <div class="form__item <?= get_value($errors, 'end_time') ? "form__item--invalid" : null; ?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="lot[end_time]"
                       value="<?= htmlspecialchars(get_value($lot, 'price')) ? htmlspecialchars(get_value($lot,
                           'end_time')) : null; ?>">
                <span class="form__error"><?= get_value($errors, 'end_time') ? get_value($errors,
                        'end_time') : null; ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>

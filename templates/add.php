<?php
?>
<nav class="nav">
    <ul class="nav__list container">
    <?php foreach ($categories as $category): ?>
        <li class="nav__item">
            <a href="all-lots.html"><?= $category['title']; ?></a>
        </li>
    <?php endforeach; ?>
    </ul>
</nav>
<main class="container">
    <form class="form form--add-lot container <?= !empty($errors) ? "form--invalid" : null; ?>" action="add.php" method="post" enctype="multipart/form-data"><!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?= isset($errors['title']) ? "form__item--invalid" : null; ?>"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot[title]" placeholder="Введите наименование лота" value="<?= isset($lot['title']) ? $lot['title'] : null; ?>"> <!-- required -->
                <span class="form__error"><?= isset($errors['title']) ? $errors['title'] : null; ?></span>
            </div>
            <div class="form__item <?= isset($errors['category_id']) ? "form__item--invalid" : null; ?>">
                <label for="category">Категория</label>
                <select id="category" name="lot[category_id]" > <!-- required -->
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id']; ?>" <?= ($lot['category_id'] == $category['id']) ? " selected" : null; ?> ><?= $category['title']; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?= isset($errors['category_id']) ? $errors['category_id'] : null; ?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?= isset($errors['description']) ? "form__item--invalid" : null; ?>">
            <label for="message">Описание</label>
            <textarea id="message" name="lot[description]" placeholder="Напишите описание лота"><?= isset($lot['description']) ? $lot['description'] : null; ?></textarea> <!-- required -->
            <span class="form__error"><?= isset($errors['description']) ? $errors['description'] : null; ?></span>
        </div>
        <div class="form__item form__item--file <?= isset($errors['img']) ? "form__item--invalid" : null; ?>"> <!-- form__item--uploaded -->
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
            <span class="form__error"><?= isset($errors['img']) ? $errors['img'] : null; ?></span>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?= isset($errors['price']) ? "form__item--invalid" : null; ?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot[price]" placeholder="0" value="<?= isset($lot['price']) ? $lot['price'] : null; ?>" > <!-- required -->
                <span class="form__error"><?= isset($errors['price']) ? $errors['price'] : null; ?></span>
            </div>
            <div class="form__item form__item--small <?= isset($errors['step_rate']) ? "form__item--invalid" : null; ?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot[step_rate]" placeholder="0" value="<?= isset($lot['price']) ? $lot['step_rate'] : null; ?>" > <!-- required -->
                <span class="form__error"><?= isset($errors['step_rate']) ? $errors['step_rate'] : null; ?></span>
            </div>
            <div class="form__item <?= isset($errors['end_time']) ? "form__item--invalid" : null; ?>">
                <label for="lot-date">Дата окончания торгов</label>
                <input class="form__input-date" id="lot-date" type="date" name="lot[end_time]" value="<?= isset($lot['price']) ? $lot['end_time'] : null; ?>" > <!-- required -->
                <span class="form__error"><?= isset($errors['end_time']) ? $errors['end_time'] : null; ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>

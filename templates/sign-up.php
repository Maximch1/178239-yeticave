<?php
?>

<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.php?category=<?= $category['id']; ?>"><?= $category['title']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? "form--invalid" : null; ?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : null; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="signup[email]" placeholder="Введите e-mail" value="<?= isset($signup['email']) ? $signup['email'] : null; ?>" required> <!-- required -->
            <span class="form__error"><?= isset($errors['email']) ? $errors['email'] : null; ?></span>
        </div>
        <div class="form__item <?= isset($errors['password']) ? "form__item--invalid" : null; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="signup[password]" placeholder="Введите пароль" value="<?= isset($signup['password']) ? $signup['password'] : null; ?>" required><!-- required -->
            <span class="form__error"><?= isset($errors['password']) ? $errors['password'] : null; ?></span>
        </div>
        <div class="form__item <?= isset($errors['name']) ? "form__item--invalid" : null; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="signup[name]" placeholder="Введите имя" value="<?= isset($signup['name']) ? $signup['name'] : null; ?>" required><!-- required -->
            <span class="form__error"><?= isset($errors['name']) ? $errors['name'] : null; ?></span>
        </div>
        <div class="form__item <?= isset($errors['contacts']) ? "form__item--invalid" : null; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="signup[contacts]" placeholder="Напишите как с вами связаться" required><?= isset($signup['contacts']) ? $signup['contacts'] : null; ?></textarea><!-- required -->
            <span class="form__error"><?= isset($errors['contacts']) ? $errors['contacts'] : null; ?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?= isset($errors['img']) ? "form__item--invalid" : null; ?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="avatar" id="photo2" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?= isset($errors['img']) ? $errors['img'] : null; ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>


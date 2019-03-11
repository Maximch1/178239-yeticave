<?php
/**
 * @var array $categories категории лотов
 * @var array $errors     массив ошибок
 * @var array $signup     массив с данными добавляемого юзера
 */
?>

<main>
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
    <form class="form container <?= $errors ? "form--invalid" : null; ?>" action="sign-up.php" method="post"
          enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?= get_value($errors, 'email') ? "form__item--invalid" : null; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="signup[email]" placeholder="Введите e-mail"
                   value="<?= get_value($signup, 'email') ? get_value($signup, 'email') : null; ?>">
            <span class="form__error"><?= get_value($errors, 'email') ? get_value($errors, 'email') : null; ?></span>
        </div>
        <div class="form__item <?= get_value($errors, 'password') ? "form__item--invalid" : null; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="signup[password]" placeholder="Введите пароль"
                   value="<?= get_value($signup, 'password') ? get_value($signup, 'password') : null; ?>">
            <span class="form__error"><?= get_value($errors, 'password') ? get_value($errors,
                    'password') : null; ?></span>
        </div>
        <div class="form__item <?= get_value($errors, 'name') ? "form__item--invalid" : null; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="signup[name]" placeholder="Введите имя"
                   value="<?= htmlspecialchars(get_value($signup, 'name')) ? htmlspecialchars(get_value($signup,
                       'name')) : null; ?>">
            <span class="form__error"><?= get_value($errors, 'name') ? get_value($errors, 'name') : null; ?></span>
        </div>
        <div class="form__item <?= get_value($errors, 'contacts') ? "form__item--invalid" : null; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="signup[contacts]"
                      placeholder="Напишите как с вами связаться"><?= get_value($signup,
                    'contacts') ? get_value($signup, 'contacts') : null; ?></textarea>
            <span class="form__error"><?= get_value($errors, 'contacts') ? get_value($errors,
                    'contacts') : null; ?></span>
        </div>
        <div class="form__item form__item--file form__item--last <?= get_value($errors,
            'img') ? "form__item--invalid" : null; ?>">
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
            <span class="form__error"><?= get_value($errors, 'img') ? get_value($errors, 'img') : null; ?></span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>


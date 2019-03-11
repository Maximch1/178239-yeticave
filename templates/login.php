<?php
/**
 * @var array $categories категории лотов
 * @var array $login      массив с данными входа на сайт
 * @var array $errors     массив с ошибками
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
    <form class="form container <?= $errors ? "form--invalid" : null; ?>" action="login.php" method="post">
        <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?= get_value($errors, 'email') ? " form__item--invalid" : null; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="login[email]" placeholder="Введите e-mail"
                   value="<?= get_value($login, 'email') ? get_value($login, 'email') : null; ?>">
            <span class="form__error"><?= get_value($errors, 'email') ? get_value($errors, 'email') : null; ?></span>
        </div>
        <div class="form__item form__item--last <?= get_value($errors, 'password') ? "form__item--invalid" : null; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="login[password]" placeholder="Введите пароль"><!--required-->
            <span class="form__error"><?= get_value($errors, 'password') ? get_value($errors,
                    'password') : null; ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>


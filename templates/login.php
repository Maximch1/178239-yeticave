<?php
?>

<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?= $category['title']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?= !empty($errors) ? "form--invalid" : null; ?>" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?= isset($errors['email']) ? "form__item--invalid" : null; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="login[email]" placeholder="Введите e-mail" value="<?= isset($login['email']) ? $login['email'] : null; ?>" > <!--required-->
            <span class="form__error"><?= isset($errors['email']) ? $errors['email'] : null; ?></span>
        </div>
        <div class="form__item form__item--last <?= isset($errors['password']) ? "form__item--invalid" : null; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="login[password]" placeholder="Введите пароль" ><!--required-->
            <span class="form__error"><?= isset($errors['password']) ? $errors['password'] : null; ?></span>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>
</main>


<?php
/**
 * @var array $categories категории лотов
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
    <section class="lot-item container">
        <h2>404 Страница не найдена</h2>
        <p>Данной страницы не существует на сайте.</p>
    </section>
</main>


<?php
/**
 * @var array  $categories  категории лотов
 * @var array  $lots        массив с данными лотов
 * @var array  $pages       массив с номерами страниц
 * @var float  $pages_count количество страниц
 * @var int    $cur_page    текущая страница
 * @var string $search      поисковый запрос
 * @var string $error       ошибка
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
    <div class="container">
        <section class="lots">
            <?php if ( ! $error): ?>
                <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($search); ?></span>»</h2>
                <ul class="lots__list">
                    <?php foreach ($lots as $lot): ?>
                        <li class="lots__item lot">
                            <div class="lot__image">
                                <img src="<?= htmlspecialchars(get_value($lot, 'image')); ?>" width="350" height="260"
                                     alt="<?= htmlspecialchars(get_value($lot, 'name')); ?>">
                            </div>
                            <div class="lot__info">
                                <span class="lot__category"><?= get_value($lot, 'category'); ?></span>
                                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= get_value($lot,
                                        'id'); ?>"><?= htmlspecialchars(get_value($lot, 'name')); ?></a></h3>
                                <div class="lot__state">
                                    <div class="lot__rate">
                                        <span class="lot__amount">Стартовая цена</span>
                                        <span class="lot__cost"><?= format_price(htmlspecialchars(get_value($lot,
                                                'price'))); ?></span>
                                    </div>
                                    <div class="lot__timer timer">
                                        <?= time_to_end(get_value($lot, 'end_time')); ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <h2><?= $error ?></h2>
            <?php endif; ?>
        </section>
        <?php if ($pages_count > 1): ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a
                        <?php if ($cur_page != 1): ?>href="search.php?search=<?= $search; ?>&page=<?= $cur_page - 1; ?>"<?php endif; ?>>Назад</a>
                </li>
                <?php foreach ($pages as $page): ?>
                    <li class="pagination-item <?php if ((int)$page === $cur_page): ?>pagination-item-active<?php endif; ?>">
                        <a href="search.php?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="pagination-item pagination-item-next"><a
                        <?php if ($cur_page != $pages_count): ?>href="search.php?search=<?= $search; ?>&page=<?= $cur_page + 1; ?>"<?php endif; ?>>Вперед</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</main>


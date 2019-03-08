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
    <div class="container">
        <section class="lots">
            <?php if (!$errors):?>
                <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($search); ?></span>»</h2>
                <ul class="lots__list">
                <?php foreach ($lots as $lot): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?= htmlspecialchars($lot['image']); ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['name']); ?>">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= $lot['category']; ?></span>
                            <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot["id"]; ?>"><?= htmlspecialchars($lot['name']); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?= format_price(htmlspecialchars(get_lot($link, $lot['id'])['max_rate'])); ?></span>
                                </div>
                                <div class="lot__timer timer">
                                    <?= time_to_end($lot['end_time']); ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <h2><?= $errors ?></h2>
            <?php endif; ?>
        </section>
        <?php if ($pages_count > 1): ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a <?php if ($cur_page != 1): ?>href="search.php?search=<?= $search; ?>&page=<?= $cur_page-1; ?>"<?php endif; ?>>Назад</a></li>
                <?php foreach ($pages as $page): ?>
                    <li class="pagination-item <?php if ($page == $cur_page): ?>pagination-item-active<?php endif; ?>">
                        <a href="search.php?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a>
                    </li>
                <?php endforeach; ?>
                <li class="pagination-item pagination-item-next"><a <?php if ($cur_page != $pages_count): ?>href="search.php?search=<?= $search; ?>&page=<?= $cur_page+1; ?>"<?php endif; ?>>Вперед</a></li>
            </ul>
        <?php endif; ?>
    </div>
</main>


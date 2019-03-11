<?php
/**
 * @var array $categories категории лотов
 * @var array $lots       список лотов
 */
?>
<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
            снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $category): ?>
                <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="category.php?id=<?= get_value($category, 'id'); ?>">
                        <?= get_value($category, 'title'); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
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
    </section>
</main>

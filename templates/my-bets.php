<?php
/**
 * @var array $categories категории лотов
 * @var array $bets       массив ставок сделанный юзером
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
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($bets as $bet): ?>
                <?php if (get_value($bet, 'winner_id') === get_value($bet, 'bet_user_id')): ?>
                    <tr class="rates__item rates__item--win">
                        <td class="rates__info">
                            <div class="rates__img">
                                <img src="<?= htmlspecialchars(get_value($bet, 'image')); ?>" width="54" height="40"
                                     alt="<?= htmlspecialchars(get_value($bet, 'name')); ?>">
                            </div>
                            <div>
                                <h3 class="rates__title"><a href="lot.php?id=<?= get_value($bet,
                                        "lot_id"); ?>"><?= htmlspecialchars(get_value($bet, 'name')); ?></a></h3>
                                <p><?= htmlspecialchars(get_value($bet, 'description')); ?></p>
                            </div>

                        </td>
                        <td class="rates__category">
                            <?= get_value($bet, 'category'); ?>
                        </td>
                        <td class="rates__timer ">
                            <div class="timer timer--win">Ставка выиграла</div>
                        </td>
                        <td class="rates__price">
                            <?= format_price_bets(get_value($bet, 'rate')); ?>
                        </td>
                        <td class="rates__time">
                            <?= get_time_format(get_value($bet, 'create_time')) ? get_time_format(get_value($bet,
                                'create_time')) : get_value($bet, 'format_bet_create_time'); ?>
                        </td>
                    </tr>
                <?php elseif (strtotime(get_value($bet, 'end_time')) < time()): ?>
                    <tr class="rates__item rates__item--end">
                        <td class="rates__info">
                            <div class="rates__img">
                                <img src="<?= htmlspecialchars(get_value($bet, 'image')); ?>" width="54" height="40"
                                     alt="<?= htmlspecialchars(get_value($bet, 'name')); ?>">
                            </div>
                            <h3 class="rates__title"><a href="lot.php?id=<?= get_value($bet,
                                    "lot_id"); ?>"><?= htmlspecialchars(get_value($bet, 'name')); ?></a></h3>
                        </td>
                        <td class="rates__category">
                            <?= get_value($bet, 'category'); ?>
                        </td>
                        <td class="rates__timer ">
                            <div class="timer timer--end">Торги окончены</div>
                        </td>
                        <td class="rates__price">
                            <?= format_price_bets(get_value($bet, 'rate')); ?>
                        </td>
                        <td class="rates__time">
                            <?= get_time_format(get_value($bet, 'create_time')) ? get_time_format(get_value($bet,
                                'create_time')) : get_value($bet, 'format_bet_create_time'); ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr class="rates__item">
                        <td class="rates__info">
                            <div class="rates__img">
                                <img src="<?= htmlspecialchars(get_value($bet, 'image')); ?>" width="54" height="40"
                                     alt="<?= htmlspecialchars(get_value($bet, 'name')); ?>">
                            </div>
                            <h3 class="rates__title"><a href="lot.php?id=<?= get_value($bet,
                                    "lot_id"); ?>"><?= htmlspecialchars(get_value($bet, 'name')); ?></a></h3>
                        </td>
                        <td class="rates__category">
                            <?= get_value($bet, 'category'); ?>
                        </td>
                        <td class="rates__timer">
                            <div class="timer <?= (strtotime(get_value($bet,
                                    'end_time')) < strtotime('30 min')) ? ' timer--finishing ' : null; ?>"><?= time_to_end(get_value($bet,
                                    'end_time')); ?></div>
                        </td>
                        <td class="rates__price">
                            <?= format_price_bets(get_value($bet, 'rate')); ?>
                        </td>
                        <td class="rates__time">
                            <?= get_time_format(get_value($bet, 'create_time')) ? get_time_format(get_value($bet,
                                'create_time')) : get_value($bet, 'format_bet_create_time'); ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>
    </section>
</main>


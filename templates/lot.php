<?php
/**
 * @var array   $categories    категории лотов
 * @var array   $lot           массив с данными лотов
 * @var array   $user          массив с данными юзера
 * @var array   $bets          массив со ставками
 * @var string  $rate          шаг ставки введенный юзером
 * @var string  $error         ошибка
 * @var boolean $show_bet_form определяем, можно ли показывать форму ввода ставки, или нет
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
        <h2><?= htmlspecialchars(get_value($lot, 'name')); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?= htmlspecialchars(get_value($lot, 'image')); ?>" width="730" height="548"
                         alt="<?= htmlspecialchars(get_value($lot, 'name')); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= htmlspecialchars(get_value($lot,
                            'category')); ?></span></p>
                <p class="lot-item__description"><?= htmlspecialchars(get_value($lot, 'description')); ?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?= time_to_end(get_value($lot, 'end_time')); ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= format_price(htmlspecialchars(get_value($lot,
                                    'max_rate'))); ?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= format_price(htmlspecialchars(get_value($lot,
                                        'max_rate') + get_value($lot, 'step_rate'))); ?></span>
                        </div>
                    </div>
                    <?php if ($show_bet_form): ?>
                        <form class="lot-item__form" action="lot.php?id=<?= get_value($lot, 'id'); ?>" method="post">
                            <p class="lot-item__form-item form__item <?= ! empty($error) ? "form__item--invalid" : null; ?>">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="text" name="rate"
                                       placeholder="<?= htmlspecialchars(get_value($lot, 'max_rate') + get_value($lot,
                                               'step_rate')); ?>"
                                       value="<?= htmlspecialchars($rate) ? htmlspecialchars($rate) : null; ?>">
                                <span class="form__error"><?= $error; ?></span>
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="history">
                    <h3>История ставок (<span><?= count($bets) ?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bets as $bet): ?>
                            <tr class="history__item">
                                <td class="history__name"><?= htmlspecialchars(get_value($bet, 'name')) ?></td>
                                <td class="history__price"><?= format_price_bets(get_value($bet, 'rate')) ?></td>
                                <td class="history__time"><?= get_time_format(get_value($bet,
                                        'create_time')) ? get_time_format(get_value($bet,
                                        'create_time')) : get_value($bet, 'format_create_time'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

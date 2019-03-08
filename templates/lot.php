<?php
?>

<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?= $category['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<main class="container">
    <section class="lot-item container">
    <h2><?= htmlspecialchars($lot['name']); ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= htmlspecialchars($lot['image']); ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['name']); ?>">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['category']; ?></span></p>
            <p class="lot-item__description"><?= $lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?= time_to_end($lot['end_time']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?= format_price(htmlspecialchars($lot['max_rate'])); ?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= format_price(htmlspecialchars($lot['max_rate'] + $lot['step_rate'])); ?></span>
                    </div>
                </div>
                <?php if (is_auth() & (time_to_end($lot['end_time']) > 0) & !validate_bet_user($user['id'], $lot['user_id'], $bets['0']['user_id'])):?>
                <form class="lot-item__form" action="lot.php?id=<?= $lot['id']; ?>" method="post">
                    <p class="lot-item__form-item form__item <?= !empty($errors) ? "form__item--invalid" : null; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="rate" placeholder="<?= htmlspecialchars($lot['max_rate'] + $lot['step_rate']); ?>">
                        <span class="form__error"><?=$errors;?></span>
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
                                <td class="history__name"><?= htmlspecialchars($bet['name']) ?></td>
                                <td class="history__price"><?= format_price_bets($bet['rate']) ?></td>
                                <td class="history__time"><?= get_time_format_bet($bet['create_time']) ? get_time_format_bet($bet['create_time']) : $bet['format_create_time']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
        </div>
    </div>
</section>
</main>

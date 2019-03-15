<?php
?>
<h1>Поздравляем с победой</h1>
<p>Здравствуйте, [имя пользователя]</p>
<p>Ваша ставка для лота <a href="lot.php?id=<?= get_value($lot,"lot_id"); ?>"><?= htmlspecialchars(get_value($lot,'name')); ?></a> победила.</p>
<p>Перейдите по ссылке <a href="my-bets.php">мои ставки</a>,
    чтобы связаться с автором объявления</p>

<small>Интернет Аукцион "YetiCave"</small>

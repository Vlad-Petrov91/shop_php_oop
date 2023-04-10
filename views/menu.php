<?php

if ($isAuth): ?>
    Добро пожаловать <?= $userName ?> <a href="/?c=auth&a=logout">[Выход]</a>
<?php else: ?>
    <form action="/?c=auth&a=login" method="post">
        <input type="text" name="login" placeholder="Логин">
        <input type="text" name="pass" placeholder="Пароль">
        <input type="submit" name="submit" value="Войти">
    </form>
<?php endif; ?><br>

<a href="/">Главная</a>
<a href="/?c=product&a=catalog">Каталог</a>
<a href="/?c=basket">Корзина(<span id="count">0</span>)</a><br>

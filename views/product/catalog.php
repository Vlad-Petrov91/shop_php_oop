<h2>Каталог</h2>

<?php foreach ($catalog as $item): ?>
    <div>
        <h3><a href="/?c=product&a=card&id=<?= $item['id'] ?>"><?= $item['name'] ?></a></h3>
        <p><?= $item->name ?></p>
        <button>Купить</button>
    </div>
<?php endforeach; ?>

<a href="/?c=product&a=catalog&page=<?=$page?>">Ещё</a>

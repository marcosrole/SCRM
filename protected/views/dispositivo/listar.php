<h1>
    LISTA
</h1>

<ul>
    <?php foreach ($dispositivos as $d) : ?>
    <li>
        <h2>ID: <?= $d->id_dispositivo ?> - Ubicación: <?= $d->ubicacion ?></h2>
    </li>
    <?php endforeach;?>
</ul>

    

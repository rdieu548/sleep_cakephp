<?php foreach ($menus as $menu): ?>
    <div class="menu-item">
        <?= $this->Html->link(
            $menu->intitule,
            $menu->lien,
            ['class' => 'menu-link']
        ) ?>
    </div>
<?php endforeach; ?> 
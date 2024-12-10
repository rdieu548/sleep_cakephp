<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<?php $this->Html->scriptStart(['block' => true]); ?>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-menu');
    if (el) {
        new Sortable(el, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function (evt) {
                const items = evt.to.children;
                const orders = [];
                
                // Collecte les nouveaux ordres
                for(let i = 0; i < items.length; i++) {
                    orders.push({
                        id: items[i].dataset.id,
                        ordre: i + 1
                    });
                }
                
                console.log('Envoi des ordres:', orders);
                
                // Envoie les nouveaux ordres au serveur
                fetch('/menus/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': <?= json_encode($this->request->getAttribute('csrfToken')) ?>
                    },
                    body: JSON.stringify(orders)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Ordre mis à jour avec succès');
                    } else {
                        console.error('Erreur lors de la mise à jour de l\'ordre');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }
});
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->script('https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.getElementById('menu');
    
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', function() {
            menu.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }
});
<?php $this->Html->scriptEnd(); ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        NuitZen:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Réactiver les fichiers CSS de base -->
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>" class="app-title">NuitZen</a>
        </div>
        <div class="top-nav-links">
            <?php if ($this->Identity->isLoggedIn()): ?>
                <span class="desktop-only">
                    <?= $this->Html->link('Se déconnecter', 
                        ['controller' => 'Users', 'action' => 'logout'],
                        ['class' => 'logout-button']
                    ) ?>
                </span>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <div class="content">
                <?= $this->Flash->render() ?>
                <div class="row">
                    <?php if ($current_user): ?>
                        <div class="menu-toggle">
                            <i class="fas fa-bars"></i>
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="column column-25" id="menu">
                            <ul class="side-nav">
                                <?php if ($this->Identity->isLoggedIn()): ?>
                                    <?php 
                                        $currentUser = $this->request->getAttribute('identity');
                                        
                                        // Si admin, afficher tous les menus
                                        if ((int)$currentUser->is_admin === 1) {
                                            echo $this->cell('Menu::display')->render();
                                        } else {
                                            // Pour les utilisateurs normaux, ne pas afficher le menu Utilisateurs
                                            echo $this->cell('Menu::display', ['hideAdmin' => true])->render();
                                        }
                                    ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <div class="column column-75">
                            <?= $this->fetch('content') ?>
                        </div>
                    <?php else: ?>
                        <div class="column column-100">
                            <?= $this->fetch('content') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

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
        CakeSleepCalculator:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Réactiver les fichiers CSS de base -->
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Style du bouton hamburger */
        .menu-toggle {
            display: none;
            font-size: 20px;
            cursor: pointer;
            padding: 8px 12px;
            position: absolute;
            top: 12px;
            left: 10px;
            z-index: 1000;
            background: #333;
            color: white;
            border-radius: 4px;
            width: 35px;
            height: 35px;
            text-align: center;
        }

        .menu-toggle i.fa-times {
            display: none;
        }

        .menu-toggle.active i.fa-bars {
            display: none;
        }

        .menu-toggle.active i.fa-times {
            display: block;
        }

        /* Style du menu */
        #menu {
            width: 25% !important;
            float: left !important;
            background-color: #f8f8f8 !important;
            padding: 10px !important;
            transition: transform 0.3s ease-in-out !important;
            display: block !important;
            visibility: visible !important;
        }

        .column-75 {
            width: 75% !important;
            float: left !important;
        }

        .side-nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .side-nav li {
            margin-bottom: 10px;
        }

        .side-nav a {
            color: #333;
            text-decoration: none;
        }

        /* Style pour le bouton Se déconnecter */
        .button.btn-danger {
            font-size: 14px !important;
            padding: 2px 8px !important;
            height: auto !important;
            line-height: normal !important;
            min-height: 25px !important;
            margin: 0 !important;
            background-color: #D33C43 !important;
            color: white !important;
            border: none !important;
        }

        /* Media query pour les écrans < 768px */
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .top-nav .container {
                padding-left: 50px;
            }

            #menu {
                position: fixed;
                left: -100%;
                top: 0;
                height: 100vh;
                width: 100vw;
                background: white;
                box-shadow: 2px 0 5px rgba(0,0,0,0.2);
                z-index: 999;
                padding: 60px 20px 20px 20px;
                transition: left 0.3s ease;
            }

            #menu.active {
                left: 0;
            }

            .column.column-75 {
                width: 100%;
                margin-left: 0;
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>">CakeSleepCalculator</a>
        </div>
        <div class="top-nav-links">
            <?php if ($current_user): ?>
                <div class="user-info">
                    <span><?= h($current_user->prenom) ?> <?= h($current_user->nom) ?></span>
                    <?= $this->Html->link('Se déconnecter', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'button btn-danger']) ?>
                </div>
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

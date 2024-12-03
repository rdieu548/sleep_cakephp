<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="home">
    <h1>Bienvenue</h1>
    
    <?php if ($this->Authentication->getIdentity()): ?>
        <div class="user-welcome">
            <h2>Bonjour <?= ucfirst(strtolower(h($this->Authentication->getIdentity()->prenom))) ?> <?= ucfirst(strtolower(h($this->Authentication->getIdentity()->nom))) ?></h2>
            <h3>Vous êtes connecté, bienvenue sur notre WebAPP.</h3>
        </div>
    <?php else: ?>
        <div class="auth-links">
            <?= $this->Html->link('Se connecter', 
                ['controller' => 'Users', 'action' => 'login'],
                ['class' => 'button btn-primary']
            ) ?>
            <?= $this->Html->link('S\'inscrire', 
                ['controller' => 'Users', 'action' => 'register'],
                ['class' => 'button btn-success']
            ) ?>
        </div>
    <?php endif; ?>
</div>

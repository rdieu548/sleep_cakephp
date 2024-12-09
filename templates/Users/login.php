<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Connexion') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true, 'label' => 'Mot de passe']) ?>
    </fieldset>
    <?= $this->Form->button(__('Se connecter')); ?>
    <?= $this->Form->end() ?>
    
    <p class="text-center">
        <?= $this->Html->link("S'inscrire", ['action' => 'add']) ?>
    </p>
</div>

<style>
.users.form {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

fieldset {
    border: none;
    padding: 0;
    margin: 0 0 20px 0;
}

legend {
    font-size: 1.5em;
    margin-bottom: 20px;
    color: #333;
}

.input {
    margin-bottom: 15px;
}
</style>
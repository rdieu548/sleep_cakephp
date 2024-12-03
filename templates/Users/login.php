<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form content">
    <h3>Connexion</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Veuillez entrer vos identifiants') ?></legend>
        <?= $this->Form->control('email', ['label' => 'Email']) ?>
        <?= $this->Form->control('password', ['label' => 'Mot de passe']) ?>
    </fieldset>
    <?= $this->Form->button(__('Connexion'), ['class' => 'button']) ?>
    <?= $this->Form->end() ?>

    <div class="additional-links">
        <?= $this->Html->link('Mot de passe oublié ?', ['action' => 'forgotPassword']) ?>
        <br>
        <?= $this->Html->link('S\'enregistrer', ['action' => 'register']) ?>
    </div>
</div>

<style>
    .users.form.content {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
    }

    .additional-links {
        margin-top: 20px;
        text-align: center;
    }

    .additional-links a {
        color: #D33C43;
        text-decoration: none;
    }

    .additional-links a:hover {
        text-decoration: underline;
    }
</style>
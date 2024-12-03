<div class="users form content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Inscription') ?></legend>
        <?= $this->Form->control('nom', ['required' => true]) ?>
        <?= $this->Form->control('prenom', ['required' => true]) ?>
        <?= $this->Form->control('email', ['required' => true, 'type' => 'email']) ?>
        <?= $this->Form->control('password', ['required' => true, 'type' => 'password', 'label' => 'Mot de passe']) ?>
    </fieldset>
    <?= $this->Form->button(__('S\'inscrire')) ?>
    <?= $this->Form->end() ?>
    
    <p>Déjà inscrit ? <?= $this->Html->link('Connectez-vous', ['action' => 'login']) ?></p>
</div> 
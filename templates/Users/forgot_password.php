<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Mot de passe oublié</h3>
    <?= $this->Form->create() ?>
        <?= $this->Form->control('email', ['label' => 'Entrez votre email']) ?>
        <?= $this->Form->submit('Envoyer') ?>
    <?= $this->Form->end() ?>
</div> 
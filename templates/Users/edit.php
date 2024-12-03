<div class="users form content">
    <h3>Modifier l'utilisateur</h3>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <?php
            echo $this->Form->control('prenom', ['label' => 'Prénom']);
            echo $this->Form->control('nom', ['label' => 'Nom']);
            echo $this->Form->control('email', ['label' => 'Email']);
            echo $this->Form->control('password', [
                'label' => 'Mot de passe',
                'value' => '',
                'required' => false,
                'type' => 'password'
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button('Enregistrer') ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Retour à la liste', ['action' => 'index'], ['class' => 'button']) ?>
</div> 
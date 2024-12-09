<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Se connecter'), ['action' => 'login'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Inscription') ?></legend>
                <?php
                    echo $this->Form->control('nom', ['required' => true]);
                    echo $this->Form->control('prenom', ['required' => true, 'label' => 'Prénom']);
                    echo $this->Form->control('email', ['required' => true]);
                    echo $this->Form->control('password', ['required' => true, 'label' => 'Mot de passe']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('S\'inscrire')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
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
    margin: 0;
}

legend {
    font-size: 1.5em;
    margin-bottom: 20px;
    color: #333;
}

.input {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #555;
}

input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button {
    background: #dc2626;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
}

button:hover {
    background: #b91c1c;
}

.side-nav {
    margin-bottom: 20px;
}

.side-nav-item {
    color: #dc2626;
    text-decoration: none;
}

.side-nav-item:hover {
    text-decoration: underline;
}
</style> 
<div class="users form content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Modifier l\'utilisateur') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('new_password', [
                'type' => 'password',
                'label' => 'Nouveau mot de passe',
                'required' => false,
                'value' => ''
            ]);
            echo $this->Form->control('confirm_password', [
                'type' => 'password',
                'label' => 'Confirmer le mot de passe',
                'required' => false
            ]);
            
            // Seuls les admins voient ce champ
            if ($this->Identity->get('is_admin')) {
                echo $this->Form->control('is_admin', ['label' => 'Administrateur']);
            }
        ?>
    </fieldset>
    <?= $this->Form->button(__('Enregistrer')) ?>
    <?= $this->Form->end() ?>
</div>

<style>
.users.form {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
}

.users.form fieldset {
    border: none;
    padding: 0;
}

.users.form legend {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.users.form .input {
    margin-bottom: 20px;
}

.users.form label {
    display: block;
    margin-bottom: 5px;
    color: #666;
}

.users.form input[type="email"],
.users.form input[type="password"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.users.form button {
    background: #dc2626;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.users.form button:hover {
    background: #b91c1c;
}

.flash {
    margin: 20px 0;
    padding: 10px;
    border-radius: 4px;
}

.flash.success {
    background: #22c55e;
    color: white;
}

.flash.error {
    background: #dc2626;
    color: white;
}
</style> 
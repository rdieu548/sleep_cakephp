<h1>Inscription</h1>
<?= $this->Form->create($user) ?>
<?= $this->Form->control('username') ?>
<?= $this->Form->control('email') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->button(__('S\'inscrire')) ?>
<?= $this->Form->end() ?> 
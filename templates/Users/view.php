<div class="users view content">
    <h3><?= h($user->prenom) ?> <?= h($user->nom) ?></h3>
    <table>
        <tr>
            <th>ID</th>
            <td><?= h($user->id) ?></td>
        </tr>
        <tr>
            <th>Prénom</th>
            <td><?= h($user->prenom) ?></td>
        </tr>
        <tr>
            <th>Nom</th>
            <td><?= h($user->nom) ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th>Créé le</th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th>Modifié le</th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <?= $this->Html->link('Modifier', ['action' => 'edit', $user->id], ['class' => 'button']) ?>
    <?= $this->Html->link('Retour à la liste', ['action' => 'index'], ['class' => 'button']) ?>
</div> 
<div class="users index content">
    <h3><?= __('Utilisateurs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('is_admin', 'Admin') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Créé le') ?></th>
                    <th><?= $this->Paginator->sort('modified', 'Modifié le') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= $user->is_admin ? '✓' : '✗' ?></td>
                    <td><?= h($user->created->format('d/m/Y H:i')) ?></td>
                    <td><?= h($user->modified->format('d/m/Y H:i')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $user->id], ['class' => 'button']) ?>
                        <?php if ($this->Identity->get('is_admin') && $user->id !== $this->Identity->get('id')): ?>
                            <?= $this->Html->link('Définir comme admin', ['action' => 'makeAdmin', $user->id], ['confirm' => 'Êtes-vous sûr ?']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div> 

<style>
/* ... autres styles ... */

.button {
    display: inline-block;
    padding: 6px 12px;
    margin: 0 5px;
    border-radius: 4px;
    text-decoration: none;
    color: white !important; /* Forcer la couleur blanche */
    background: #dc2626;
}

.button:hover {
    background: #b91c1c;
    color: white !important; /* Garder le texte blanc au survol */
}

.button.delete {
    background: #991b1b;
    color: white !important;
}

.button.delete:hover {
    background: #7f1d1d;
    color: white !important;
}

/* ... autres styles ... */
</style> 
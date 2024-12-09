<div class="sleep-entries index content">
    <h3><?= __('Mon journal de sommeil') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('Date') ?></th>
                    <th><?= __('Heure de coucher') ?></th>
                    <th><?= __('Heure de réveil') ?></th>
                    <th><?= __('Durée de sommeil') ?></th>
                    <th><?= __('Qualité') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $entry): ?>
                <tr>
                    <td><?= h($entry->date->format('d/m/Y')) ?></td>
                    <td><?= h($entry->bedtime->format('H:i')) ?></td>
                    <td><?= h($entry->wake_time->format('H:i')) ?></td>
                    <td><?= h($entry->sleep_duration) ?> heures</td>
                    <td><?= h($entry->quality) ?>/5</td>
                    <td class="actions">
                        <?= $this->Html->link(__('Voir'), ['action' => 'view', $entry->id]) ?>
                        <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $entry->id]) ?>
                        <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $entry->id], ['confirm' => __('Êtes-vous sûr de vouloir supprimer cette entrée ?')]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="button-container">
        <?= $this->Html->link(__('Nouvelle entrée'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    </div>
</div>

<style>
.button-container {
    margin-top: 20px;
    text-align: right;
}

.button {
    background: #dc2626;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
}

.button:hover {
    background: #b91c1c;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f8f9fa;
}

.actions a {
    color: #dc2626;
    text-decoration: none;
    margin-right: 10px;
}

.actions a:hover {
    text-decoration: underline;
}
</style> 
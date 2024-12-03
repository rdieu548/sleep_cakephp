<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Menu> $menus
 */
?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', ['block' => true]); ?>

<div class="menus index content">
    <h3>Gestion des Menus</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Ordre</th>
                    <th>Intitulé</th>
                    <th>Lien</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="sortable-list">
                <?php foreach ($menus as $menu): ?>
                <tr data-id="<?= $menu->id ?>">
                    <td class="handle">⇅ <?= $menu->ordre ?></td>
                    <td><?= h($menu->intitule) ?></td>
                    <td><?= h($menu->lien) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $menu->id]) ?>
                        <?= $this->Form->postLink('Supprimer', 
                            ['action' => 'delete', $menu->id],
                            ['confirm' => 'Êtes-vous sûr ?']) 
                        ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.handle {
    cursor: move;
    user-select: none;
}
.sortable-ghost {
    background-color: #f0f0f0;
    opacity: 0.5;
}
</style>

<?php $this->Html->scriptStart(['block' => true]); ?>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-list');
    if (el) {
        new Sortable(el, {
            animation: 150,
            handle: '.handle',
            ghostClass: 'sortable-ghost',
            onEnd: function (evt) {
                const items = evt.to.children;
                const orders = [];
                
                for(let i = 0; i < items.length; i++) {
                    orders.push({
                        id: items[i].dataset.id,
                        ordre: i + 1
                    });
                }
                
                fetch('/menus/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': <?= json_encode($this->request->getAttribute('csrfToken')) ?>
                    },
                    body: JSON.stringify(orders)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        console.log('Ordre mis à jour avec succès');
                        window.location.reload();
                    } else {
                        console.error('Erreur lors de la mise à jour de l\'ordre');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
            }
        });
    }
});
<?php $this->Html->scriptEnd(); ?>

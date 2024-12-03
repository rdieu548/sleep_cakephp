<div class="users index content">
    <h3>Liste des utilisateurs</h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->nom) ?></td>
                    <td><?= h($user->prenom) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td class="actions">
                        <?= $this->Html->link('Voir', ['action' => 'view', $user->id], ['class' => 'button button-small']) ?>
                        <?= $this->Html->link('Modifier', ['action' => 'edit', $user->id], ['class' => 'button button-small']) ?>
                        <?= $this->Form->postLink('Supprimer', ['action' => 'delete', $user->id], 
                            ['confirm' => 'Êtes-vous sûr de vouloir supprimer cet utilisateur ?', 
                             'class' => 'button button-small button-outline']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="paginator">
        <ul class="pagination">
            <?php
            echo $this->Paginator->prev('< Précédent');
            echo $this->Paginator->numbers();
            echo $this->Paginator->next('Suivant >');
            ?>
        </ul>
    </div>
</div>

<style>
    /* Styles pour la table responsive */
    .table-responsive {
        overflow-x: auto;
        margin-bottom: 1rem;
    }

    /* Style pour les boutons d'action */
    .actions .button {
        color: white !important;
        min-width: 90px;
        text-align: center;
        margin: 2px;
    }

    .actions .button-outline {
        color: #333 !important;
    }

    @media screen and (max-width: 768px) {
        /* Ajustements pour les petits écrans */
        table {
            font-size: 14px;
        }

        .button-small {
            padding: 3px 6px;
            font-size: 12px;
            min-width: 70px;
        }

        .actions {
            white-space: nowrap;
            min-width: 100px;
        }

        /* Pagination responsive */
        .paginator ul.pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5px;
        }

        .paginator ul.pagination li {
            margin: 2px;
        }

        .paginator ul.pagination li a {
            padding: 5px 10px;
        }
    }

    /* Pour les très petits écrans */
    @media screen and (max-width: 480px) {
        table {
            font-size: 12px;
        }

        .button-small {
            padding: 2px 4px;
            font-size: 11px;
            min-width: 60px;
        }

        .paginator {
            font-size: 12px;
        }
    }
</style> 
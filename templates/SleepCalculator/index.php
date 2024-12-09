<div class="sleep-entries index">
    <h3>Mon Journal de Sommeil</h3>
    
    <?= $this->Html->link('Nouvelle entrée', ['action' => 'calculate'], ['class' => 'button']) ?>
    
    <div class="entries-list">
        <?php foreach ($entries as $entry): ?>
            <div class="entry-card">
                <h4><?= (new \Cake\I18n\FrozenDate($entry->date))->format('d/m/Y') ?></h4>
                <div class="sleep-time">
                    <p>Coucher : <?= (new \DateTime($entry->bedtime))->format('H:i') ?></p>
                    <p>Réveil : <?= (new \DateTime($entry->wakeuptime))->format('H:i') ?></p>
                </div>
                <div class="stats">
                    <p>Cycles : <?= $entry->cycles ?> 
                        <?php if ($entry->is_optimal_cycle): ?>
                            <span class="optimal">✓</span>
                        <?php endif; ?>
                    </p>
                    <p>Forme : <?= $entry->morning_score ?>/10</p>
                </div>
                <div class="activities">
                    <?php if ($entry->afternoon_nap): ?>
                        <span class="tag">Sieste après-midi</span>
                    <?php endif; ?>
                    <?php if ($entry->evening_nap): ?>
                        <span class="tag">Sieste soir</span>
                    <?php endif; ?>
                    <?php if ($entry->did_sport): ?>
                        <span class="tag">Sport</span>
                    <?php endif; ?>
                </div>
                <?php if ($entry->comments): ?>
                    <div class="comments">
                        <p><?= h($entry->comments) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.entry-card {
    background: #f8f9fa;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.sleep-time {
    display: flex;
    gap: 20px;
}

.stats {
    margin: 10px 0;
}

.optimal {
    color: #28a745;
    font-weight: bold;
}

.tag {
    display: inline-block;
    padding: 4px 8px;
    background: #e9ecef;
    border-radius: 4px;
    margin-right: 8px;
    font-size: 0.9em;
}

.comments {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #dee2e6;
}
</style> 
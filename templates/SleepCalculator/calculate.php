<div class="row">
    <div class="column">
        <h3>Journal de Sommeil</h3>
        <?= $this->Form->create(null, ['url' => ['controller' => 'SleepCalculator', 'action' => 'calculate']]) ?>
        
        <?= $this->Form->control('date', [
            'label' => 'Date',
            'type' => 'date',
            'value' => date('Y-m-d')
        ]) ?>
        
        <div class="sleep-time-section">
            <h4>Horaires de Sommeil</h4>
            <div class="input-group">
                <?= $this->Form->control('bedtime', [
                    'label' => 'Heure du coucher',
                    'type' => 'time',
                    'class' => 'form-control'
                ]) ?>
                <?= $this->Form->control('wakeuptime', [
                    'label' => 'Heure du réveil',
                    'type' => 'time',
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>

        <div class="naps-section">
            <h4>Siestes</h4>
            <div class="input-group">
                <?= $this->Form->control('afternoon_nap', [
                    'label' => 'Sieste après-midi',
                    'type' => 'checkbox'
                ]) ?>
                <?= $this->Form->control('evening_nap', [
                    'label' => 'Sieste du soir (18h-19h)',
                    'type' => 'checkbox'
                ]) ?>
            </div>
        </div>

        <div class="wellness-section">
            <h4>Bien-être</h4>
            <?= $this->Form->control('morning_score', [
                'label' => 'Niveau de forme au réveil',
                'type' => 'select',
                'options' => array_combine(range(0, 10), range(0, 10)),
                'empty' => 'Choisir un score (0-10)'
            ]) ?>
            
            <?= $this->Form->control('did_sport', [
                'label' => 'Activité sportive aujourd\'hui',
                'type' => 'checkbox'
            ]) ?>
            
            <?= $this->Form->control('comments', [
                'label' => 'Commentaires sur votre sommeil',
                'type' => 'textarea',
                'placeholder' => 'Comment vous sentez-vous ? Qualité du sommeil ?'
            ]) ?>
        </div>

        <?= $this->Form->button('Analyser mon sommeil', ['class' => 'btn btn-primary']) ?>
        <?= $this->Form->end() ?>

        <?php if (isset($result)): ?>
            <div class="results">
                <h4>Analyse de votre sommeil :</h4>
                <?php if ($result): ?>
                    <div class="sleep-stats">
                        <p>Durée totale : <?= $result['hours'] ?>h<?= $result['minutes'] ?>min</p>
                        <p>Nombre de cycles : <?= $result['cycles'] ?></p>
                        <div class="cycle-indicator <?= $result['isOptimalCycle'] ? 'optimal' : '' ?>">
                            <?= $result['isOptimalCycle'] ? '✓ Cycles optimaux' : '! Cycles non optimaux' ?>
                        </div>
                        <?php if ($result['cycles'] >= 5): ?>
                            <div class="cycle-success">
                                ✓ Objectif atteint : 5 cycles ou plus
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.input-group {
    margin-bottom: 20px;
}

.sleep-time-section,
.naps-section,
.wellness-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.results {
    margin-top: 30px;
    padding: 20px;
    background: #e9ecef;
    border-radius: 8px;
}

.cycle-indicator {
    padding: 10px;
    border-radius: 4px;
    margin: 10px 0;
}

.cycle-indicator.optimal {
    background: #28a745;
    color: white;
}

.cycle-success {
    background: #198754;
    color: white;
    padding: 10px;
    border-radius: 4px;
    margin-top: 10px;
}

.btn-primary {
    margin-top: 20px;
}
</style>
<div class="row">
    <div class="column">
        <h3>Enregistrer mon sommeil</h3>
        <?= $this->Form->create(null, ['url' => ['controller' => 'SleepCalculator', 'action' => 'calculate'], 'class' => 'sleep-form']) ?>
        
        <div class="form-group">
            <?= $this->Form->control('date', [
                'label' => 'Date',
                'type' => 'date',
                'value' => date('Y-m-d'),
                'class' => 'form-control'
            ]) ?>
        </div>
        
        <div class="sleep-time-section">
            <h4>Horaires de Sommeil</h4>
            <div class="time-inputs">
                <?= $this->Form->control('bedtime', [
                    'label' => 'Heure du coucher',
                    'type' => 'time',
                    'class' => 'form-control time-input'
                ]) ?>
                <?= $this->Form->control('wakeuptime', [
                    'label' => 'Heure du réveil',
                    'type' => 'time',
                    'class' => 'form-control time-input'
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
                'required' => false,
                'default' => '',
                'empty' => true
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
.sleep-form {
    max-width: 100%;
    padding: 15px;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.time-inputs {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.time-input {
    width: 100%;
}

/* Styles responsive */
@media (max-width: 768px) {
    .column {
        padding: 0;
    }

    .sleep-form {
        padding: 10px;
    }

    h3 {
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    h4 {
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }

    .form-control {
        font-size: 16px; /* Évite le zoom sur iOS */
        padding: 0.8rem;
    }

    .sleep-time-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .time-inputs {
        gap: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

}

/* Pour les très petits écrans */
@media (max-width: 375px) {
    .sleep-form {
        padding: 5px;
    }

    h3 {
        font-size: 1.6rem;
    }

    h4 {
        font-size: 1.2rem;
    }
}

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
</style>
<div class="row">
    <div class="column column-100">
        <div class="sleep-calculator form content">
            <h3>Calculateur de Sommeil</h3>
            <?= $this->Form->create(null, ['class' => 'sleep-form']) ?>
            <fieldset>
                <legend>Entrez vos horaires de sommeil</legend>
                <?= $this->Form->control('bedtime', [
                    'label' => 'Heure de coucher',
                    'type' => 'time',
                    'required' => true
                ]) ?>
                <?= $this->Form->control('waketime', [
                    'label' => 'Heure de réveil souhaitée',
                    'type' => 'time',
                    'required' => true
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('Calculer'), ['class' => 'button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
    .row {
        display: flex;
        justify-content: center;
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .column-100 {
        flex: 0 0 100%;
        max-width: 100%;
        display: flex;
        justify-content: center;
    }

    .sleep-calculator {
        max-width: 500px;
        width: 100%;
        margin: 50px 0;
        padding: 20px;
    }

    .sleep-form {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        width: 100%;
    }

    h3 {
        text-align: center;
        margin-bottom: 20px;
    }

    fieldset {
        border: none;
        padding: 0;
        margin-bottom: 20px;
    }

    legend {
        font-size: 1.2em;
        margin-bottom: 15px;
        color: #333;
        text-align: center;
    }

    .input {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        color: #666;
    }

    input[type="time"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .button {
        width: 100%;
        padding: 10px;
        background: #D33C43 !important;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .button:hover {
        background: #C13238 !important;
    }

    @media (max-width: 768px) {
        .sleep-calculator {
            padding: 10px;
            margin: 20px 0;
        }

        .sleep-form {
            padding: 15px;
        }
    }
</style>
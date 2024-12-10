<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->css('home', ['block' => true]);
?>
<div class="home">
    <div class="hero-section">
        <h1>Suivez votre sommeil, améliorez votre vie</h1>
        <p class="subtitle">Découvrez les secrets d'un sommeil réparateur grâce à notre application de suivi personnalisé</p>
        
        <?php if ($this->Authentication->getIdentity()): ?>
            <div class="user-welcome">                
                <div class="action-cards">
                    <div class="card">
                        <i class="fas fa-bed icon-feature"></i>
                        <?= $this->Html->link('Enregistrer mon sommeil', 
                            ['controller' => 'SleepCalculator', 'action' => 'calculate'],
                            ['class' => 'button btn-primary']
                        ) ?>
                        <p>Notez vos heures de sommeil pour un meilleur suivi</p>
                    </div>
                    
                    <div class="card">
                        <i class="fas fa-chart-line icon-feature"></i>
                        <?= $this->Html->link('Mon journal de sommeil', 
                            ['controller' => 'SleepCalculator', 'action' => 'index'],
                            ['class' => 'button btn-secondary']
                        ) ?>
                        <p>Visualisez vos statistiques et votre progression</p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="auth-links">
                <p class="cta-text">Commencez à améliorer votre sommeil dès aujourd'hui</p>
                <?= $this->Html->link('Se connecter', 
                    ['controller' => 'Users', 'action' => 'login'],
                    ['class' => 'button btn-primary']
                ) ?>
                <?= $this->Html->link('S\'inscrire', 
                    ['controller' => 'Users', 'action' => 'register'],
                    ['class' => 'button btn-success']
                ) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="features-section">
        <h2>Pourquoi utiliser notre application ?</h2>
        <div class="features-grid">
            <div class="feature">
                <i class="fas fa-clock"></i>
                <h3>Suivi simple</h3>
                <p>Enregistrez facilement vos cycles de sommeil</p>
            </div>
            <div class="feature">
                <i class="fas fa-chart-bar"></i>
                <h3>Statistiques détaillées</h3>
                <p>Analysez vos habitudes de sommeil</p>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css') ?>

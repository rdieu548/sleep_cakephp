<div class="sleep-stats">
    <h3>Statistiques de sommeil</h3>
    
    <div class="weekly-stats">
        <h4>Semaine du <?= $startOfWeek->format('d/m/Y') ?> au <?= $endOfWeek->format('d/m/Y') ?></h4>
        
        <div class="stats-grid">
            <div class="stat-box">
                <h4>Moyenne de sommeil</h4>
                <p class="stat-value"><?= $stats['moyenne'] ?> heures</p>
            </div>
            
            <div class="stat-box">
                <h4>Objectif atteint</h4>
                <p class="stat-value"><?= $stats['objectif_atteint'] ?>%</p>
                <p class="stat-detail">(7h ou plus de sommeil)</p>
            </div>
            
            <div class="stat-box">
                <h4>Cycles de sommeil</h4>
                <p class="stat-value"><?= $stats['total_cycles'] ?> / <?= $stats['objectif_cycles'] ?></p>
            </div>
        </div>

        <?php if (!empty($stats['derniere_semaine'])): ?>
            <div class="sleep-history">
                <h4>Détail de la semaine</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Coucher</th>
                            <th>Réveil</th>
                            <th>Durée</th>
                            <th>Cycles</th>
                            <th>Objectif</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['derniere_semaine'] as $entry): ?>
                            <tr>
                                <td><?= $entry->date->format('d/m/Y') ?></td>
                                <td><?= $entry->bedtime ?></td>
                                <td><?= $entry->wakeuptime ?></td>
                                <td><?= $entry->sleep_duration ?> heures</td>
                                <td><?= $entry->cycles ?></td>
                                <td>
                                    <?php if ($entry->sleep_duration >= 7): ?>
                                        <span class="badge success">✓</span>
                                    <?php else: ?>
                                        <span class="badge warning">✗</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="chart-container">
                <canvas id="sleepChart"></canvas>
            </div>
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('sleepChart').getContext('2d');
                const sleepData = <?= json_encode(array_map(function($entry) {
                    return [
                        'date' => $entry->date->format('d/m'),
                        'duration' => $entry->sleep_duration,
                        'cycles' => $entry->cycles
                    ];
                }, $stats['derniere_semaine'])) ?>;
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: sleepData.map(item => item.date),
                        datasets: [{
                            label: 'Heures de sommeil',
                            data: sleepData.map(item => item.duration),
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            tension: 0.1,
                            fill: true
                        }, {
                            label: 'Cycles',
                            data: sleepData.map(item => item.cycles),
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.1,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Évolution du sommeil'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value + (this.chart.data.datasets[0].label === 'Heures de sommeil' ? 'h' : '');
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        <?php else: ?>
            <div class="no-data">
                <p>Aucune donnée disponible pour cette semaine.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.sleep-stats {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-box {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    text-align: center;
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    color: #dc2626;
    margin: 10px 0;
}

.stat-detail {
    font-size: 14px;
    color: #666;
}

.sleep-history {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.badge {
    display: inline-block;
    width: 24px;
    height: 24px;
    line-height: 24px;
    text-align: center;
    border-radius: 50%;
    color: white;
}

.badge.success {
    background: #22c55e;
}

.badge.warning {
    background: #dc2626;
}

.no-data {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    color: #666;
}

.chart-container {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 30px;
}
</style> 
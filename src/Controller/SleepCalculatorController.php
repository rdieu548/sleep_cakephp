<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

class SleepCalculatorController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('SleepEntries');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        if (!$this->Authentication->getIdentity()) {
            $this->Flash->error('Veuillez vous connecter pour accéder à votre journal de sommeil.');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function index()
    {
        $user = $this->request->getAttribute('identity');
        
        // Définir la période avec FrozenTime
        $startOfWeek = FrozenTime::now()->startOfWeek();
        $endOfWeek = FrozenTime::now()->endOfWeek();
        
        // Récupérer les entrées de sommeil de la semaine
        $sleepEntries = $this->fetchTable('SleepEntries')->find()
            ->where([
                'user_id' => $user->id,
                'date >=' => $startOfWeek,
                'date <=' => $endOfWeek
            ])
            ->order(['date' => 'DESC'])
            ->toArray();
        
        // Calculer les statistiques
        $totalSleep = 0;
        $totalCycles = 0;
        $entriesCount = count($sleepEntries);
        $objectifAtteint = 0;
        
        foreach ($sleepEntries as $entry) {
            // Calculer la durée de sommeil en heures
            $dateStr = $entry->date instanceof FrozenDate ? $entry->date->format('Y-m-d') : $entry->date;
            $bedtime = FrozenTime::parse($dateStr . ' ' . $entry->bedtime);
            $wakeuptime = FrozenTime::parse($dateStr . ' ' . $entry->wakeuptime);
            
            // Si l'heure de réveil est avant l'heure de coucher, ajouter 1 jour
            if ($wakeuptime < $bedtime) {
                $wakeuptime = $wakeuptime->modify('+1 day');
            }
            
            $duration = ($wakeuptime->getTimestamp() - $bedtime->getTimestamp()) / 3600;
            $entry->sleep_duration = round($duration, 1);
            
            $totalSleep += $entry->sleep_duration;
            $totalCycles += $entry->cycles ?? floor($entry->sleep_duration / 1.5);
            
            if ($entry->sleep_duration >= 7) {
                $objectifAtteint++;
            }
        }
        
        // Objectif hebdomadaire (par exemple, 35 cycles par semaine)
        $weeklyGoal = 35;
        $isWeeklyGoalMet = $totalCycles >= $weeklyGoal;
        
        $stats = [
            'moyenne' => $entriesCount > 0 ? round($totalSleep / $entriesCount, 1) : 0,
            'objectif_atteint' => $entriesCount > 0 ? round(($objectifAtteint / $entriesCount) * 100) : 0,
            'nombre_entrees' => $entriesCount,
            'derniere_semaine' => $sleepEntries,
            'total_cycles' => $totalCycles,
            'objectif_cycles' => $weeklyGoal,
            'objectif_atteint_cycles' => $isWeeklyGoalMet
        ];
        
        $this->set(compact('stats', 'startOfWeek', 'endOfWeek', 'totalCycles', 'isWeeklyGoalMet'));
    }

    public function calculate()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $userId = $this->Authentication->getIdentity()->id;
            
            $bedtime = date('H:i:s', strtotime($data['bedtime']));
            $wakeuptime = date('H:i:s', strtotime($data['wakeuptime']));
            
            $bedDateTime = new \DateTime($bedtime);
            $wakeDateTime = new \DateTime($wakeuptime);
            
            if ($wakeDateTime < $bedDateTime) {
                $wakeDateTime->modify('+1 day');
            }
            
            $interval = $bedDateTime->diff($wakeDateTime);
            $totalMinutes = ($interval->h * 60) + $interval->i;
            $cycles = $totalMinutes / 90;
            $isOptimalCycle = abs($cycles - round($cycles)) <= (10/90);
            
            $entryData = [
                'user_id' => $userId,
                'date' => $data['date'] ? new FrozenDate($data['date']) : new FrozenDate(),
                'bedtime' => $bedtime,
                'wakeuptime' => $wakeuptime,
                'afternoon_nap' => !empty($data['afternoon_nap']),
                'evening_nap' => !empty($data['evening_nap']),
                'morning_score' => (int)$data['morning_score'],
                'did_sport' => !empty($data['did_sport']),
                'comments' => !empty($data['comments']) ? $data['comments'] : null,
                'cycles' => floor($cycles),
                'is_optimal_cycle' => $isOptimalCycle
            ];
            
            $entry = $this->SleepEntries->newEntity($entryData);
            
            if ($this->SleepEntries->save($entry)) {
                $this->Flash->success('Entrée enregistrée avec succès !');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Erreur lors de l\'enregistrement.');
            }
        }
    }
} 
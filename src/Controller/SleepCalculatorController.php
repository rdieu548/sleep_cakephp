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
        // Vérifier si l'utilisateur est connecté
        if (!$this->Authentication->getIdentity()) {
            $this->Flash->error('Veuillez vous connecter pour accéder à votre journal de sommeil.');
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function index()
    {
        $userId = $this->Authentication->getIdentity()->id;
        $entries = $this->SleepEntries->find()
            ->where(['user_id' => $userId])
            ->order(['date' => 'DESC'])
            ->limit(7)
            ->all();
        
        $this->set(compact('entries'));
    }

    public function calculate()
    {
        $userId = $this->Authentication->getIdentity()->id;
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Formatage des heures
            $bedtime = date('H:i:s', strtotime($data['bedtime']));
            $wakeuptime = date('H:i:s', strtotime($data['wakeuptime']));
            
            // Calcul des cycles
            $bedDateTime = new \DateTime($bedtime);
            $wakeDateTime = new \DateTime($wakeuptime);
            
            if ($wakeDateTime < $bedDateTime) {
                $wakeDateTime->modify('+1 day');
            }
            
            $interval = $bedDateTime->diff($wakeDateTime);
            $totalMinutes = ($interval->h * 60) + $interval->i;
            $cycles = $totalMinutes / 90;
            $isOptimalCycle = abs($cycles - round($cycles)) <= (10/90);
            
            // Préparation des données
            $entryData = [
                'user_id' => $userId,  // Ajout de l'ID utilisateur
                'date' => $data['date'] ? new FrozenDate($data['date']) : new FrozenDate(),
                'bedtime' => $bedtime,
                'wakeuptime' => $wakeuptime,
                'afternoon_nap' => !empty($data['afternoon_nap']),
                'evening_nap' => !empty($data['evening_nap']),
                'morning_score' => (int)$data['morning_score'],
                'did_sport' => !empty($data['did_sport']),
                'comments' => $data['comments'],
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
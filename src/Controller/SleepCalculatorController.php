<?php
declare(strict_types=1);

namespace App\Controller;

class SleepCalculatorController extends AppController
{
    public function calculate()
    {
        if ($this->request->is('post')) {
            $bedtime = $this->request->getData('bedtime');
            $waketime = $this->request->getData('waketime');
            // Le calcul sera ajouté plus tard
        }
    }
} 
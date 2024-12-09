<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class SleepEntry extends Entity
{
    protected $_accessible = [
        'user_id' => true,
        'date' => true,
        'bedtime' => true,
        'wakeuptime' => true,
        'afternoon_nap' => true,
        'evening_nap' => true,
        'morning_score' => true,
        'did_sport' => true,
        'comments' => true,
        'cycles' => true,
        'is_optimal_cycle' => true,
        'created' => true,
        'modified' => true,
    ];
} 
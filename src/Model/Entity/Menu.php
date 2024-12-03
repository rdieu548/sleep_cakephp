<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Menu extends Entity
{
    protected $_accessible = [
        'ordre' => true,
        'intitule' => true,
        'lien' => true,
        'created' => true,
        'modified' => true,
    ];
} 
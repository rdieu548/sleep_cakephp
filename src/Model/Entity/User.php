<?php

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'nom' => true,
        'prenom' => true,
        '*' => false,
    ];

    protected $_hidden = [
        'password'
    ];

    protected function _setPassword(string $password)
    {
        if (strlen($password) > 0) {
            $hasher = new DefaultPasswordHasher();
            return $hasher->hash($password);
        }
    }
} 
<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users'); // Nom de la table dans la base de données
        $this->setDisplayField('email'); // Champ à afficher par défaut
        $this->setPrimaryKey('id'); // Clé primaire
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmptyString('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 255)
            ->requirePresence('prenom', 'create')
            ->notEmptyString('prenom');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')  // Requis uniquement à la création
            ->allowEmptyString('password', 'update'); // Autorise un mot de passe vide lors de la modification

        return $validator;
    }
} 
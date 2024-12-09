<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use ArrayObject;

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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password', null, 'create');
        
        $validator
            ->scalar('new_password')
            ->maxLength('new_password', 255)
            ->allowEmptyString('new_password')
            ->add('new_password', 'custom', [
                'rule' => function ($value, $context) {
                    return empty($value) || strlen($value) >= 6;
                },
                'message' => 'Le mot de passe doit faire au moins 6 caractères'
            ]);
        
        $validator
            ->scalar('confirm_password')
            ->allowEmptyString('confirm_password')
            ->add('confirm_password', 'custom', [
                'rule' => function ($value, $context) {
                    if (empty($context['data']['new_password'])) {
                        return true;
                    }
                    return $value === $context['data']['new_password'];
                },
                'message' => 'Les mots de passe ne correspondent pas'
            ]);

        return $validator;
    }

    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        return $query
            ->select(['id', 'email', 'password', 'is_admin', 'nom', 'prenom'])
            ->formatResults(function ($results) {
                return $results->map(function ($row) {
                    // Force la conversion de is_admin en booléen
                    $row->is_admin = (bool)$row->is_admin;
                    return $row;
                });
            });
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!empty($entity->new_password)) {
            $entity->set('password', $entity->new_password);
        }
        return true;
    }
} 
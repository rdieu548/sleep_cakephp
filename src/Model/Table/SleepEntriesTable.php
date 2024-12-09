<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SleepEntriesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sleep_entries');
        $this->setPrimaryKey('id');
        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id', 'Un utilisateur est requis');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->time('bedtime')
            ->requirePresence('bedtime', 'create')
            ->notEmptyTime('bedtime');

        $validator
            ->time('wakeuptime')
            ->requirePresence('wakeuptime', 'create')
            ->notEmptyTime('wakeuptime');

        $validator
            ->boolean('afternoon_nap')
            ->allowEmptyString('afternoon_nap');

        $validator
            ->boolean('evening_nap')
            ->allowEmptyString('evening_nap');

        $validator
            ->integer('morning_score')
            ->range('morning_score', [0, 10])
            ->allowEmptyString('morning_score');

        $validator
            ->boolean('did_sport')
            ->allowEmptyString('did_sport');

        $validator
            ->scalar('comments')
            ->allowEmptyString('comments');

        return $validator;
    }

    public function buildRules(\Cake\ORM\RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        return $rules;
    }
} 
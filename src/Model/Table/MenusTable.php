<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class MenusTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('menus');
        $this->setDisplayField('intitule');
        $this->setPrimaryKey('id');
    }
} 
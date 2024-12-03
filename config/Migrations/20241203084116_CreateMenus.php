<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMenus extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('menus');
        $table->addColumn('ordre', 'integer', [
            'default' => null,
            'null' => false,
        ])
        ->addColumn('intitule', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('lien', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ])
        ->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ])
        ->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ])
        ->create();

        // Ajouter les données initiales
        $rows = [
            [
                'ordre' => 1,
                'intitule' => 'Utilisateurs',
                'lien' => '/users/index',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'ordre' => 2,
                'intitule' => 'Menu',
                'lien' => '/menus/index',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ];

        $this->table('menus')->insert($rows)->save();
    }
}
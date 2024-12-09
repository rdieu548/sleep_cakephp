<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddIsAdminToUsers extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('is_admin', 'boolean', [
            'default' => false,
            'null' => false,
            'after' => 'email'
        ]);
        $table->update();
    }
} 
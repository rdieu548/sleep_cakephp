<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSleepEntries extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('sleep_entries');
        $table->addColumn('date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('bedtime', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('wakeuptime', 'time', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('afternoon_nap', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('evening_nap', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('morning_score', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('did_sport', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('comments', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('cycles', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('is_optimal_cycle', 'boolean', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}

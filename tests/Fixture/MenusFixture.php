<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MenusFixture
 */
class MenusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'menus';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'ordre' => 1,
                'intitule' => 'Lorem ipsum dolor sit amet',
                'lien' => 'Lorem ipsum dolor sit amet',
                'created' => '2024-12-03 08:46:25',
                'modified' => '2024-12-03 08:46:25',
            ],
        ];
        parent::init();
    }
}

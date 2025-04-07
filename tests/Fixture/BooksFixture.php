<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BooksFixture
 */
class BooksFixture extends TestFixture
{
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
                'title' => 'Lorem ipsum dolor sit amet',
                'publisher_id' => 1,
                'author_id' => 1,
                'published_date' => '2025-03-25',
                'created' => '2025-03-25 17:07:07',
                'modified' => '2025-03-25 17:07:07',
            ],
        ];
        parent::init();
    }
}

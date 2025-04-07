<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublishersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublishersTable Test Case
 */
class PublishersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublishersTable
     */
    protected $Publishers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Publishers',
        'app.Books',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Publishers') ? [] : ['className' => PublishersTable::class];
        $this->Publishers = $this->getTableLocator()->get('Publishers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Publishers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublishersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

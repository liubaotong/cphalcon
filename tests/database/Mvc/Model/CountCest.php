<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the
 * LICENSE.txt file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Database\Mvc\Model;

use DatabaseTester;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Storage\Exception;
use Phalcon\Tests\Fixtures\Migrations\InvoicesMigration;
use Phalcon\Tests\Fixtures\Traits\DiTrait;
use Phalcon\Tests\Fixtures\Traits\RecordsTrait;
use Phalcon\Tests\Models\Invoices;
use Phalcon\Tests\Models\InvoicesMap;

class CountCest
{
    use DiTrait;
    use RecordsTrait;

    /**
     * @var InvoicesMigration
     */
    private InvoicesMigration $invoiceMigration;

    /**
     * Executed before each test
     *
     * @param  DatabaseTester $I
     * @return void
     */
    public function _before(DatabaseTester $I): void
    {
        try {
            $this->setNewFactoryDefault();
        } catch (Exception $e) {
            $I->fail($e->getMessage());
        }

        $this->setDatabase($I);

        $this->invoiceMigration = new InvoicesMigration($I->getConnection());
    }

    /**
     * Tests Phalcon\Mvc\Model :: count()
     *
     * @param  DatabaseTester $I
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-01-29
     *
     * @group  mysql
     * @group  pgsql
     * @group  sqlite
     */
    public function mvcModelCount(DatabaseTester $I): void
    {
        /**
         * TODO: The following tests need to skip sqlite because we will get
         *       a General Error 5 database is locked error
         */
        $invId = ('sqlite' === $I->getDriver()) ? 'null' : 'default';
        $this->seed($invId);

        $total = Invoices::count();
        $I->assertEquals(33, $total);

        $total = Invoices::count(
            [
                'distinct' => 'inv_cst_id',
            ]
        );
        $I->assertEquals(3, $total);

        $total = Invoices::count(
            'inv_cst_id = 2'
        );
        $I->assertEquals(12, $total);

        $results = Invoices::count(
            [
                'group' => 'inv_cst_id',
                'order' => 'inv_cst_id',
            ]
        );
        $I->assertInstanceOf(Simple::class, $results);

        if ('pgsql' !== $I->getDriver()) {
            $matrix = [
                0 => [1, 20],
                1 => [2, 12],
                2 => [3, 1],
            ];
        } else {
            $matrix = [
                0 => [3, 1],
                1 => [2, 12],
                2 => [1, 20],
            ];
        }

        foreach ($matrix as $id => $expected) {
            $I->assertSame($expected[0], (int) $results[$id]->inv_cst_id);
            $I->assertSame($expected[1], (int) $results[$id]->rowcount);
        }

        $results = Invoices::count(
            [
                'group' => 'inv_cst_id',
                'order' => 'inv_cst_id DESC',
            ]
        );
        $I->assertInstanceOf(Simple::class, $results);

        foreach ($matrix as $id => $expected) {
            $I->assertSame($expected[0], (int) $results[$id]->inv_cst_id);
            $I->assertSame($expected[1], (int) $results[$id]->rowcount);
        }

        /**
         * @issue https://github.com/phalcon/cphalcon/issues/15486
         */
        $total = Invoices::count(
            [
                'conditions' => 'inv_cst_id IN ({ids:array})',
                'bind' => [
                    'ids' => [2],
                ],
            ]
        );

        $actual   = $total;
        $expected = 12;
        $I->assertEquals($expected, $actual);

        /**
         * Checking the countable
         */
        $total = Invoices::find(
            [
                'conditions' => 'inv_cst_id IN ({ids:array})',
                'bind' => [
                    'ids' => [2],
                ],
            ]
        );

        $actual   = count($total);
        $expected = 12;
        $I->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Mvc\Model :: count() - Column Map
     *
     * @param  DatabaseTester $I
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2023-12-26
     * @issue  https://github.com/phalcon/cphalcon/issues/16471
     *
     * @group  mysql
     * @group  pgsql
     */
    public function mvcModelCountColumnMap(DatabaseTester $I): void
    {
        /**
         * @todo The following tests need to skip sqlite because we will get
         *       a General Error 5 database is locked error
         */
        $invId = ('sqlite' === $I->getDriver()) ? 'null' : 'default';
        $this->seed($invId);

        $total = InvoicesMap::count();
        $I->assertEquals(33, $total);

        $total = InvoicesMap::count(
            [
                'distinct' => 'cst_id',
            ]
        );
        $I->assertEquals(3, $total);

        $total = InvoicesMap::count(
            'cst_id = 2'
        );
        $I->assertEquals(12, $total);

        $results = InvoicesMap::count(
            [
                'group' => 'cst_id',
                'order' => 'cst_id',
            ]
        );
        $I->assertInstanceOf(Simple::class, $results);

        /**
         * This is here because each engine sorts their groupped results
         * differently
         */
        if ('mysql' !== $I->getDriver()) {
            $matrix = [
                0 => [3, 1],
                1 => [2, 12],
                2 => [1, 20],
            ];
        } else {
            $matrix = [
                0 => [1, 20],
                1 => [2, 12],
                2 => [3, 1],
            ];
        }

        foreach ($matrix as $id => $expected) {
            $I->assertSame($expected[0], (int) $results[$id]->cst_id);
            $I->assertSame($expected[1], (int) $results[$id]->rowcount);
        }

        $results = InvoicesMap::count(
            [
                'group' => 'cst_id',
                'order' => 'cst_id DESC',
            ]
        );
        $I->assertInstanceOf(Simple::class, $results);

        foreach ($matrix as $id => $expected) {
            $I->assertSame($expected[0], (int) $results[$id]->cst_id);
            $I->assertSame($expected[1], (int) $results[$id]->rowcount);
        }
    }

    /**
     * @param string $invId
     *
     * @return void
     */
    private function seed(string $invId): void
    {
        $this->insertDataInvoices($this->invoiceMigration, 7, $invId, 2, 'ccc');
        $this->insertDataInvoices($this->invoiceMigration, 1, $invId, 3, 'aaa');
        $this->insertDataInvoices($this->invoiceMigration, 11, $invId, 1, 'aaa');
        $this->insertDataInvoices($this->invoiceMigration, 9, $invId, 1, 'bbb');
        $this->insertDataInvoices($this->invoiceMigration, 5, $invId, 2, 'aaa');
    }
}

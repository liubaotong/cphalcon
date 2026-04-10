<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Unit\Mvc\Model\Query\Phql\Select;

use Phalcon\Mvc\Model\Query\Lang;
use Phalcon\Tests\AbstractUnitTestCase;

final class FromTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql121(): void
    {
        $source   = "SELECT i.inv_id, c.name FROM Invoices AS i, Customers AS c WHERE i.inv_cst_id = c.id";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'   => 355,
                            'domain' => 'i',
                            'name'   => 'inv_id',
                        ],
                    ],
                    1 => [
                        'type'   => 354,
                        'column' => [
                            'type'   => 355,
                            'domain' => 'c',
                            'name'   => 'name',
                        ],
                    ],
                ],
                'tables'  => [
                    0 => [
                        'qualifiedName' => [
                            'type' => 355,
                            'name' => 'Invoices',
                        ],
                        'alias'         => 'i',
                    ],
                    1 => [
                        'qualifiedName' => [
                            'type' => 355,
                            'name' => 'Customers',
                        ],
                        'alias'         => 'c',
                    ],
                ],
            ],
            'where'  => [
                'type'  => 61,
                'left'  => [
                    'type'   => 355,
                    'domain' => 'i',
                    'name'   => 'inv_cst_id',
                ],
                'right' => [
                    'type'   => 355,
                    'domain' => 'c',
                    'name'   => 'id',
                ],
            ],
            'id'     => 124,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}
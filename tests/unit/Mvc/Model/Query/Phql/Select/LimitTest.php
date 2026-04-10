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

final class LimitTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql66(): void
    {
        $source   = "SELECT * FROM Invoices LIMIT 10";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type' => 352,
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'limit'  => [
                'number' => [
                    'type'  => 258,
                    'value' => '10',
                ],
            ],
            'id'     => 69,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql67(): void
    {
        $source   = "SELECT * FROM Invoices LIMIT 10 OFFSET 20";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type' => 352,
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'limit'  => [
                'number' => [
                    'type'  => 258,
                    'value' => '10',
                ],
                'offset' => [
                    'type'  => 258,
                    'value' => '20',
                ],
            ],
            'id'     => 70,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql68(): void
    {
        $source   = "SELECT * FROM Invoices LIMIT 20, 10";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type' => 352,
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'limit'  => [
                'number' => [
                    'type'  => 258,
                    'value' => '10',
                ],
                'offset' => [
                    'type'  => 258,
                    'value' => '20',
                ],
            ],
            'id'     => 71,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql69(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_status_flag = 1 ORDER BY inv_id DESC LIMIT 5";
        $expected = [
            'type'    => 309,
            'select'  => [
                'columns' => [
                    0 => [
                        'type' => 352,
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'where'   => [
                'type'  => 61,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_status_flag',
                ],
                'right' => [
                    'type'  => 258,
                    'value' => '1',
                ],
            ],
            'orderBy' => [
                'column' => [
                    'type' => 355,
                    'name' => 'inv_id',
                ],
                'sort'   => 328,
            ],
            'limit'   => [
                'number' => [
                    'type'  => 258,
                    'value' => '5',
                ],
            ],
            'id'      => 72,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql70(): void
    {
        $source   = "SELECT * FROM Invoices LIMIT ?0";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type' => 352,
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'limit'  => [
                'number' => [
                    'type'  => 273,
                    'value' => '?0',
                ],
            ],
            'id'     => 73,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }

    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql71(): void
    {
        $source   = "SELECT * FROM Invoices LIMIT :limit: OFFSET :offset:";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type' => 352,
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'limit'  => [
                'number' => [
                    'type'  => 274,
                    'value' => 'limit',
                ],
                'offset' => [
                    'type'  => 274,
                    'value' => 'offset',
                ],
            ],
            'id'     => 74,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}

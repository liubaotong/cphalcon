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

final class OrderByTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql55(): void
    {
        $source   = "SELECT * FROM Invoices ORDER BY inv_id";
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
            'orderBy' => [
                'column' => [
                    'type' => 355,
                    'name' => 'inv_id',
                ],
            ],
            'id'      => 58,
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
    public function testMvcModelQueryPhql56(): void
    {
        $source   = "SELECT * FROM Invoices ORDER BY inv_id ASC";
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
            'orderBy' => [
                'column' => [
                    'type' => 355,
                    'name' => 'inv_id',
                ],
                'sort'   => 327,
            ],
            'id'      => 59,
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
    public function testMvcModelQueryPhql57(): void
    {
        $source   = "SELECT * FROM Invoices ORDER BY inv_id DESC";
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
            'orderBy' => [
                'column' => [
                    'type' => 355,
                    'name' => 'inv_id',
                ],
                'sort'   => 328,
            ],
            'id'      => 60,
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
    public function testMvcModelQueryPhql58(): void
    {
        $source   = "SELECT * FROM Invoices ORDER BY inv_created_at DESC, inv_id ASC";
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
            'orderBy' => [
                0 => [
                    'column' => [
                        'type' => 355,
                        'name' => 'inv_created_at',
                    ],
                    'sort'   => 328,
                ],
                1 => [
                    'column' => [
                        'type' => 355,
                        'name' => 'inv_id',
                    ],
                    'sort'   => 327,
                ],
            ],
            'id'      => 61,
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
    public function testMvcModelQueryPhql59(): void
    {
        $source   = "SELECT * FROM Invoices ORDER BY inv_total DESC, inv_title ASC, inv_id ASC";
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
            'orderBy' => [
                0 => [
                    'column' => [
                        'type' => 355,
                        'name' => 'inv_total',
                    ],
                    'sort'   => 328,
                ],
                1 => [
                    'column' => [
                        'type' => 355,
                        'name' => 'inv_title',
                    ],
                    'sort'   => 327,
                ],
                2 => [
                    'column' => [
                        'type' => 355,
                        'name' => 'inv_id',
                    ],
                    'sort'   => 327,
                ],
            ],
            'id'      => 62,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}
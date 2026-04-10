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

final class AggregateTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql74(): void
    {
        $source   = "SELECT COUNT(*) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'COUNT',
                            'arguments' => [
                                0 => [
                                    'type' => 352,
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 77,
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
    public function testMvcModelQueryPhql75(): void
    {
        $source   = "SELECT COUNT(inv_id) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'COUNT',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_id',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 78,
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
    public function testMvcModelQueryPhql76(): void
    {
        $source   = "SELECT SUM(inv_total) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'SUM',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 79,
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
    public function testMvcModelQueryPhql77(): void
    {
        $source   = "SELECT AVG(inv_total) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'AVG',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 80,
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
    public function testMvcModelQueryPhql78(): void
    {
        $source   = "SELECT MIN(inv_total) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'MIN',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 81,
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
    public function testMvcModelQueryPhql79(): void
    {
        $source   = "SELECT MAX(inv_total) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'MAX',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 82,
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
    public function testMvcModelQueryPhql80(): void
    {
        $source   = "SELECT MIN(inv_created_at) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'MIN',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_created_at',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 83,
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
    public function testMvcModelQueryPhql81(): void
    {
        $source   = "SELECT MAX(inv_created_at) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'MAX',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_created_at',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 84,
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
    public function testMvcModelQueryPhql82(): void
    {
        $source   = "SELECT COUNT(DISTINCT inv_cst_id) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'COUNT',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_cst_id',
                                ],
                            ],
                            'distinct'  => true,
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 85,
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
    public function testMvcModelQueryPhql83(): void
    {
        $source   = "SELECT COUNT(*), SUM(inv_total), AVG(inv_total), MIN(inv_total), MAX(inv_total) FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'COUNT',
                            'arguments' => [
                                0 => [
                                    'type' => 352,
                                ],
                            ],
                        ],
                    ],
                    1 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'SUM',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                    2 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'AVG',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                    3 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'MIN',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                    4 => [
                        'type'   => 354,
                        'column' => [
                            'type'      => 350,
                            'name'      => 'MAX',
                            'arguments' => [
                                0 => [
                                    'type' => 355,
                                    'name' => 'inv_total',
                                ],
                            ],
                        ],
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 86,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}
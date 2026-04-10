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

final class PlaceholdersTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql46(): void
    {
        $source   = "SELECT inv_total + 10 FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 43,
                            'left'  => [
                                'type' => 355,
                                'name' => 'inv_total',
                            ],
                            'right' => [
                                'type'  => 258,
                                'value' => '10',
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
            'id'     => 49,
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
    public function testMvcModelQueryPhql47(): void
    {
        $source   = "SELECT inv_total - 5 FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 45,
                            'left'  => [
                                'type' => 355,
                                'name' => 'inv_total',
                            ],
                            'right' => [
                                'type'  => 258,
                                'value' => '5',
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
            'id'     => 50,
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
    public function testMvcModelQueryPhql48(): void
    {
        $source   = "SELECT inv_total * 1.1 FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 42,
                            'left'  => [
                                'type' => 355,
                                'name' => 'inv_total',
                            ],
                            'right' => [
                                'type'  => 259,
                                'value' => '1.1',
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
            'id'     => 51,
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
    public function testMvcModelQueryPhql49(): void
    {
        $source   = "SELECT inv_total / 2 FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 47,
                            'left'  => [
                                'type' => 355,
                                'name' => 'inv_total',
                            ],
                            'right' => [
                                'type'  => 258,
                                'value' => '2',
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
            'id'     => 52,
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
    public function testMvcModelQueryPhql50(): void
    {
        $source   = "SELECT inv_total % 3 FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 37,
                            'left'  => [
                                'type' => 355,
                                'name' => 'inv_total',
                            ],
                            'right' => [
                                'type'  => 258,
                                'value' => '3',
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
            'id'     => 53,
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
    public function testMvcModelQueryPhql51(): void
    {
        $source   = "SELECT inv_id, inv_total * 1.1 AS total_with_tax FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type' => 355,
                            'name' => 'inv_id',
                        ],
                    ],
                    1 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 42,
                            'left'  => [
                                'type' => 355,
                                'name' => 'inv_total',
                            ],
                            'right' => [
                                'type'  => 259,
                                'value' => '1.1',
                            ],
                        ],
                        'alias'  => 'total_with_tax',
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 54,
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
    public function testMvcModelQueryPhql52(): void
    {
        $source   = "SELECT inv_id, (inv_total + 5) * 2 AS adjusted FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'columns' => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type' => 355,
                            'name' => 'inv_id',
                        ],
                    ],
                    1 => [
                        'type'   => 354,
                        'column' => [
                            'type'  => 42,
                            'left'  => [
                                'type' => 356,
                                'left' => [
                                    'type'  => 43,
                                    'left'  => [
                                        'type' => 355,
                                        'name' => 'inv_total',
                                    ],
                                    'right' => [
                                        'type'  => 258,
                                        'value' => '5',
                                    ],
                                ],
                            ],
                            'right' => [
                                'type'  => 258,
                                'value' => '2',
                            ],
                        ],
                        'alias'  => 'adjusted',
                    ],
                ],
                'tables'  => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 55,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}
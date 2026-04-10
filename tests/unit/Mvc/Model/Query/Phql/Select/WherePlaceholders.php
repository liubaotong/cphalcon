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

final class WherePlaceholders extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql40(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_id = ?0";
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
            'where'  => [
                'type'  => 61,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_id',
                ],
                'right' => [
                    'type'  => 273,
                    'value' => '?0',
                ],
            ],
            'id'     => 43,
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
    public function testMvcModelQueryPhql41(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_id = ?1 AND inv_status_flag = ?2";
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
            'where'  => [
                'type'  => 61,
                'left'  => [
                    'type'  => 61,
                    'left'  => [
                        'type' => 355,
                        'name' => 'inv_id',
                    ],
                    'right' => [
                        'type'  => 266,
                        'left'  => [
                            'type'  => 273,
                            'value' => '?1',
                        ],
                        'right' => [
                            'type' => 355,
                            'name' => 'inv_status_flag',
                        ],
                    ],
                ],
                'right' => [
                    'type'  => 273,
                    'value' => '?2',
                ],
            ],
            'id'     => 44,
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
    public function testMvcModelQueryPhql42(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_title = :title:";
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
            'where'  => [
                'type'  => 61,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_title',
                ],
                'right' => [
                    'type'  => 274,
                    'value' => 'title',
                ],
            ],
            'id'     => 45,
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
    public function testMvcModelQueryPhql43(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_cst_id = :custId: AND inv_status_flag = :status:";
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
            'where'  => [
                'type'  => 61,
                'left'  => [
                    'type'  => 61,
                    'left'  => [
                        'type' => 355,
                        'name' => 'inv_cst_id',
                    ],
                    'right' => [
                        'type'  => 266,
                        'left'  => [
                            'type'  => 274,
                            'value' => 'custId',
                        ],
                        'right' => [
                            'type' => 355,
                            'name' => 'inv_status_flag',
                        ],
                    ],
                ],
                'right' => [
                    'type'  => 274,
                    'value' => 'status',
                ],
            ],
            'id'     => 46,
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
    public function testMvcModelQueryPhql44(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_id = {id}";
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
            'where'  => [
                'type'  => 61,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_id',
                ],
                'right' => [
                    'type'  => 277,
                    'value' => 'id',
                ],
            ],
            'id'     => 47,
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
    public function testMvcModelQueryPhql45(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_cst_id = {custId} AND inv_total > {minTotal}";
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
            'where'  => [
                'type'  => 62,
                'left'  => [
                    'type'  => 61,
                    'left'  => [
                        'type' => 355,
                        'name' => 'inv_cst_id',
                    ],
                    'right' => [
                        'type'  => 266,
                        'left'  => [
                            'type'  => 277,
                            'value' => 'custId',
                        ],
                        'right' => [
                            'type' => 355,
                            'name' => 'inv_total',
                        ],
                    ],
                ],
                'right' => [
                    'type'  => 277,
                    'value' => 'minTotal',
                ],
            ],
            'id'     => 48,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}

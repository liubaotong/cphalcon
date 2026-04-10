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

final class DistinctTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql9(): void
    {
        $source   = "SELECT DISTINCT inv_status_flag FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'distinct' => 1,
                'columns'  => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type' => 355,
                            'name' => 'inv_status_flag',
                        ],
                    ],
                ],
                'tables'   => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 12,
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
    public function testMvcModelQueryPhql10(): void
    {
        $source   = "SELECT ALL inv_status_flag FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'distinct' => 0,
                'columns'  => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type' => 355,
                            'name' => 'inv_status_flag',
                        ],
                    ],
                ],
                'tables'   => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 13,
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
    public function testMvcModelQueryPhql11(): void
    {
        $source   = "SELECT DISTINCT inv_cst_id, inv_status_flag FROM Invoices";
        $expected = [
            'type'   => 309,
            'select' => [
                'distinct' => 1,
                'columns'  => [
                    0 => [
                        'type'   => 354,
                        'column' => [
                            'type' => 355,
                            'name' => 'inv_cst_id',
                        ],
                    ],
                    1 => [
                        'type'   => 354,
                        'column' => [
                            'type' => 355,
                            'name' => 'inv_status_flag',
                        ],
                    ],
                ],
                'tables'   => [
                    'qualifiedName' => [
                        'type' => 355,
                        'name' => 'Invoices',
                    ],
                ],
            ],
            'id'     => 14,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}
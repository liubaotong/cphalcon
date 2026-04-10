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

final class LikeTest extends AbstractUnitTestCase
{
    /**
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-09
     */
    public function testMvcModelQueryPhql28(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_title LIKE '%test%'";
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
                'type'  => 268,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_title',
                ],
                'right' => [
                    'type'  => 260,
                    'value' => '%test%',
                ],
            ],
            'id'     => 31,
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
    public function testMvcModelQueryPhql29(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_title NOT LIKE '%draft%'";
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
                'type'  => 351,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_title',
                ],
                'right' => [
                    'type'  => 260,
                    'value' => '%draft%',
                ],
            ],
            'id'     => 32,
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
    public function testMvcModelQueryPhql30(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_title ILIKE '%invoice%'";
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
                'type'  => 275,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_title',
                ],
                'right' => [
                    'type'  => 260,
                    'value' => '%invoice%',
                ],
            ],
            'id'     => 33,
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
    public function testMvcModelQueryPhql31(): void
    {
        $source   = "SELECT * FROM Invoices WHERE inv_title NOT ILIKE '%draft%'";
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
                'type'  => 357,
                'left'  => [
                    'type' => 355,
                    'name' => 'inv_title',
                ],
                'right' => [
                    'type'  => 260,
                    'value' => '%draft%',
                ],
            ],
            'id'     => 34,
        ];
        $actual   = Lang::parsePhql($source);
        $this->assertSame($expected, $actual);
    }
}
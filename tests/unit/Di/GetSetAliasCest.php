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

namespace Phalcon\Tests\Unit\Di;


use Phalcon\Di\Di;
use Phalcon\Di\Exception;
use Phalcon\Html\Escaper;
use Phalcon\Html\Escaper\EscaperInterface;
use UnitTester;

class GetSetAliasCest
{
    /**
     * Unit Tests Phalcon\Di\Di :: getAlias()/setAlias()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-02-17
     */
    public function testDiGetAlias(UnitTester $I): void
    {
        $container = new Di();

        /**
         * Alias does not exist
         */
        $name   = uniqid('nam-');
        $actual = $container->getAlias($name);
        $I->assertEmpty($actual);

        // Set the service
        $container->set('escaper', Escaper::class, true);
        $container->setAlias('escaper', EscaperInterface::class);

        $source  = $container->get('escaper');
        $aliased = $container->get(EscaperInterface::class);
        $I->assertSame($source, $aliased);
    }

    /**
     * Unit Tests Phalcon\Di\Di :: getAlias()/setAlias()
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-02-17
     */
    public function testDiSetAliases(UnitTester $I): void
    {
        $container = new Di();

        $aliases = [
            EscaperInterface::class,
            'my_escaper',
        ];

        $container->set('escaper', Escaper::class, true);
        $container->setAlias('escaper', $aliases);

        $source  = $container->get('escaper');
        $aliased = $container->get(EscaperInterface::class);
        $I->assertSame($source, $aliased);

        $aliased = $container->get('my_escaper');
        $I->assertSame($source, $aliased);
    }

    /**
     * Unit Tests Phalcon\Di\Di :: setAlias() exception name not string
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-02-17
     */
    public function testDiSetAliasesExceptionNameNotString(UnitTester $I): void
    {
        $I->expectThrowable(
            new Exception('Alias name must be a string'),
            function () {
                $container = new Di();

                $aliases = [
                    123456,
                ];

                $container->set('escaper', Escaper::class, true);
                $container->setAlias('escaper', $aliases);
            }
        );
    }

    /**
     * Unit Tests Phalcon\Di\Di :: setAlias() exception name exists
     *
     * @return void
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-02-17
     */
    public function testDiSetAliasesExceptionNameExists(UnitTester $I): void
    {
        $I->expectThrowable(
            new Exception(
                "Alias 'escaper' is already in use by an existing service"
            ),
            function () {
                $container = new Di();

                $aliases = [
                    EscaperInterface::class,
                    'escaper'
                ];

                $container->set('escaper', Escaper::class, true);
                $container->setAlias('escaper', $aliases);
            }
        );
    }
}

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

namespace Phalcon\Tests\Unit\Mvc\Application;

use Phalcon\Di\Di;
use Phalcon\Di\DiInterface;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Application\Exception;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\View;
use Phalcon\Tests\Modules\Backend\Module;
use Phalcon\Tests\AbstractUnitTestCase;

final class RegisterModulesTest extends AbstractUnitTestCase
{
    public function tearDown(): void
    {
        Di::reset();
    }

    public function testModulesDefinition(): void
    {
        Di::reset();

        $di = new FactoryDefault();

        $di->set(
            'router',
            function () {
                $router = new Router(false);

                $router->add(
                    '/index',
                    [
                        'controller' => 'index',
                        'module'     => 'frontend',
                        'namespace'  => 'Phalcon\Tests\Modules\Frontend\Controllers',
                    ]
                );

                return $router;
            }
        );

        $application = new Application();

        $application->registerModules(
            [
                'frontend' => [
                    'path'      => dataDir('fixtures/modules/frontend/Module.php'),
                    'className' => \Phalcon\Tests\Modules\Frontend\Module::class,
                ],
                'backend'  => [
                    'path'      => dataDir('fixtures/modules/backend/Module.php'),
                    'className' => Module::class,
                ],
            ]
        );

        $application->setDI($di);

        $response = $application->handle('/index');

        $expected = '<html>here</html>' . PHP_EOL;
        $actual   = $response->getContent();
        $this->assertEquals($expected, $actual);
    }

    public function testModulesClosure(): void
    {
        Di::reset();

        $di = new FactoryDefault();

        $di->set(
            'router',
            function () {
                $router = new Router(false);

                $router->add(
                    '/index',
                    [
                        'controller' => 'index',
                        'module'     => 'frontend',
                        'namespace'  => 'Phalcon\Tests\Modules\Frontend\Controllers',
                    ]
                );

                $router->add(
                    '/login',
                    [
                        'controller' => 'login',
                        'module'     => 'backend',
                        'namespace'  => 'Phalcon\Tests\Modules\Backend\Controllers',
                    ]
                );

                return $router;
            }
        );

        $application = new Application();
        $view        = new View();

        $application->registerModules(
            [
                'frontend' => function (DiInterface $di) use ($view) {
                    $di->set(
                        'view',
                        function () use ($view) {
                            $view->setViewsDir(
                                dataDir('fixtures/modules/frontend/views/')
                            );

                            return $view;
                        }
                    );
                },
                'backend'  => function (DiInterface $di) use ($view) {
                    $di->set(
                        'view',
                        function () use ($view) {
                            $view->setViewsDir(
                                dataDir('fixtures/modules/backend/views/')
                            );

                            return $view;
                        }
                    );
                },
            ]
        );

        $application->setDI($di);

        $response = $application->handle('/login');

        $expected = '<html>here</html>' . PHP_EOL;
        $actual   = $response->getContent();
        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Mvc\Application :: registerModules() - bad path throws exception
     *
     * @author Sid Roberts <https://github.com/SidRoberts>
     * @since  2019-05-15
     */
    public function testMvcApplicationRegisterModulesBadPathThrowsAnException(): void
    {
        Di::reset();

        $di = new FactoryDefault();

        $di->set(
            'router',
            function () {
                $router = new Router(false);

                $router->add(
                    '/index',
                    [
                        'controller' => 'index',
                        'module'     => 'frontend',
                        'namespace'  => 'Phalcon\Tests\Modules\Frontend\Controllers',
                    ]
                );

                return $router;
            }
        );

        $application = new Application();

        $application->registerModules(
            [
                'frontend' => [
                    'path'      => dataDir('not-a-real-file.php'),
                    'className' => \Phalcon\Tests\Modules\Frontend\Module::class,
                ],
            ]
        );

        $application->setDI($di);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(
            "Module definition path '" . dataDir('not-a-real-file.php') . "' doesn't exist"
        );

        $application->handle('/index');
    }
}

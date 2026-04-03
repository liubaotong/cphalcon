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

namespace Phalcon\Tests\Unit\Annotations\Adapter\Stream;

use Phalcon\Annotations\Adapter\Stream;
use Phalcon\Annotations\Collection;
use Phalcon\Tests\AbstractUnitTestCase;
use TestClass;

use function dataDir;
use function outputDir;

final class GetMethodTest extends AbstractUnitTestCase
{
    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testAnnotationsAdapterStreamGetMethod(): void
    {
        require_once supportDir('assets/Annotations/TestClass.php');

        $adapter = new Stream(
            [
                'annotationsDir' => outputDir('tests/annotations/'),
            ]
        );

        $methodAnnotation = $adapter->getMethod(TestClass::class, 'testMethod1');

        $this->assertInstanceOf(Collection::class, $methodAnnotation);

        $this->safeDeleteFile(outputDir('tests/annotations/testclass.php'));
    }
}

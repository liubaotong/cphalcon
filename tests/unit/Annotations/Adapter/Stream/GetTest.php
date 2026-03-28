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
use Phalcon\Annotations\Reflection;
use Phalcon\Tests\AbstractUnitTestCase;
use TestClass;

use function dataDir;
use function outputDir;

final class GetTest extends AbstractUnitTestCase
{
    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2018-11-13
     */
    public function testAnnotationsAdapterStreamGet(): void
    {
        require_once dataDir('fixtures/Annotations/TestClass.php');

        $adapter = new Stream(
            [
                'annotationsDir' => outputDir('tests/annotations/'),
            ]
        );

        $classAnnotations = $adapter->get(TestClass::class);

        $this->assertIsObject($classAnnotations);
        $this->assertInstanceOf(Reflection::class, $classAnnotations);
        $this->assertInstanceOf(Collection::class, $classAnnotations->getClassAnnotations());

        $this->safeDeleteFile(outputDir('tests/annotations/testclass.php'));
    }
}

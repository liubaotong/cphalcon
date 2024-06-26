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

namespace Phalcon\Tests\Unit\Http\Request;

use Phalcon\Http\Request;
use UnitTester;

class GetUploadedFilesCest
{
    /**
     * Tests Phalcon\Http\Request :: getUploadedFiles()
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-03-17
     */
    public function httpRequestGetUploadedFiles(UnitTester $I)
    {
        $I->wantToTest('Http\Request - getUploadedFiles()');

        $store  = $_FILES ?? [];
        $_FILES = [
            'photo' => [
                'name'     => ['f0', 'f1', ['f2', 'f3'], [[[['f4']]]]],
                'type'     => [
                    'text/plain',
                    'text/csv',
                    ['image/png', 'image/gif'],
                    [[[['application/octet-stream']]]],
                ],
                'tmp_name' => ['t0', 't1', ['t2', 't3'], [[[['t4']]]]],
                'error'    => [0, 0, [0, 0], [[[[8]]]]],
                'size'     => [10, 20, [30, 40], [[[[50]]]]],
            ],
        ];

        $request    = new Request();
        $all        = $request->getUploadedFiles(false);
        $successful = $request->getUploadedFiles(true);

        $I->assertCount(5, $all);
        $I->assertCount(4, $successful);

        for ($i = 0; $i <= 4; ++$i) {
            $I->assertFalse(
                $all[$i]->isUploadedFile()
            );
        }

        $data = [
            'photo.0',
            'photo.1',
            'photo.2.0',
            'photo.2.1',
            'photo.3.0.0.0.0',
        ];

        for ($i = 0; $i <= 4; ++$i) {
            $I->assertSame(
                $data[$i],
                $all[$i]->getKey()
            );
        }

        $I->assertSame('f0', $all[0]->getName());
        $I->assertSame('f1', $all[1]->getName());
        $I->assertSame('f2', $all[2]->getName());
        $I->assertSame('f3', $all[3]->getName());
        $I->assertSame('f4', $all[4]->getName());

        $I->assertSame('t0', $all[0]->getTempName());
        $I->assertSame('t1', $all[1]->getTempName());
        $I->assertSame('t2', $all[2]->getTempName());
        $I->assertSame('t3', $all[3]->getTempName());
        $I->assertSame('t4', $all[4]->getTempName());

        $I->assertSame('f0', $successful[0]->getName());
        $I->assertSame('f1', $successful[1]->getName());
        $I->assertSame('f2', $successful[2]->getName());
        $I->assertSame('f3', $successful[3]->getName());

        $I->assertSame('t0', $successful[0]->getTempName());
        $I->assertSame('t1', $successful[1]->getTempName());
        $I->assertSame('t2', $successful[2]->getTempName());
        $I->assertSame('t3', $successful[3]->getTempName());

        $_FILES = $store;
    }
}

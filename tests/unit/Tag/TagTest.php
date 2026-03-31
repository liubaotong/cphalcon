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

namespace Phalcon\Tests\Unit\Tag;

use Phalcon\Tag;
use Phalcon\Tests\AbstractUnitTestCase;
use Phalcon\Tests\Fixtures\Traits\DiTrait;

final class TagTest extends AbstractUnitTestCase
{
    use DiTrait;

    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2022-06-11
     * @issue  15992
     */
    public function testTagTextAreaNullValue(): void
    {
        $this->setNewFactoryDefault();

        $parameters = [
            'suggest',
            'class' => 'form-control',
            'style' => 'height:100px',
            'value' => null,
        ];

        $expected = '<textarea id="suggest" name="suggest" '
            . 'class="form-control" style="height:100px"></textarea>';
        $actual   = Tag::textArea($parameters);
        $this->assertSame($expected, $actual);
    }
}

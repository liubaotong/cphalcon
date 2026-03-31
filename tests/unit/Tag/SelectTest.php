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

final class SelectTest extends AbstractUnitTestCase
{
    use DiTrait;

    protected int $doctype = Tag::HTML5;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->newDi();
        $this->setDiService('escaper');
        $this->setDiService('url');

        Tag::setDI($this->container);
        Tag::resetInput();

        $this->doctype = Tag::HTML5;
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        Tag::setDocType($this->doctype);
        Tag::resetInput();

        parent::tearDown();
    }

    /**
     * Tests Phalcon\Tag :: select()
     *
     * @author Cameron Hall <me@chall.id.au>
     * @since  2019-01-27
     */
    public function testTagSelect(): void
    {
        Tag::setDocType(Tag::HTML5);

        $options = [
            'potato',
            [
                'Phalcon',
                'PHP',
            ],
        ];

        $expected = '<select id="potato" name="potato">' . PHP_EOL . "\t"
            . '<option value="0">Phalcon</option>' . PHP_EOL . "\t<option value=\"1\">"
            . 'PHP</option>' . PHP_EOL . '</select>';

        $actual = Tag::select($options);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests Phalcon\Tag :: select() with no options
     *
     * @author Cameron Hall <me@chall.id.au>
     * @since  2019-01-27
     * @issue  https://github.com/phalcon/cphalcon/issues/13352
     */
    public function testTagSelectWithNoOptions(): void
    {
        Tag::setDocType(Tag::HTML5);

        $options = [
            'potato',
        ];

        $expected = '<select id="potato" name="potato">' . PHP_EOL . '</select>';

        $actual = Tag::select($options);

        $this->assertEquals($expected, $actual);
    }
}

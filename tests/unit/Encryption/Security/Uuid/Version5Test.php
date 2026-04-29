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

namespace Phalcon\Tests\Unit\Encryption\Security\Uuid;

use Phalcon\Encryption\Security\Uuid\UuidInterface;
use Phalcon\Encryption\Security\Uuid\Version5;
use Phalcon\Tests\AbstractUnitTestCase;

final class Version5Test extends AbstractUnitTestCase
{
    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-29
     */
    public function testEncryptionSecurityUuidVersion5Format(): void
    {
        $version = new Version5();
        $uuid    = $version(UuidInterface::NAMESPACE_DNS, 'phalcon.io');

        $this->assertMatchesRegularExpression(
            '/^[a-f0-9]{8}-[a-f0-9]{4}-5[a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/',
            $uuid
        );
    }

    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-29
     */
    public function testEncryptionSecurityUuidVersion5Deterministic(): void
    {
        $version = new Version5();
        $uuid1   = $version(UuidInterface::NAMESPACE_DNS, 'phalcon.io');
        $uuid2   = $version(UuidInterface::NAMESPACE_DNS, 'phalcon.io');

        $this->assertSame($uuid1, $uuid2);
    }

    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-29
     */
    public function testEncryptionSecurityUuidVersion5DifferentNames(): void
    {
        $version = new Version5();

        $this->assertNotSame(
            $version(UuidInterface::NAMESPACE_DNS, 'phalcon.io'),
            $version(UuidInterface::NAMESPACE_DNS, 'phalcon.org')
        );
    }

    /**
     * @author Phalcon Team <team@phalcon.io>
     * @since  2026-04-29
     */
    public function testEncryptionSecurityUuidVersion5DifferentNamespaces(): void
    {
        $version = new Version5();

        $this->assertNotSame(
            $version(UuidInterface::NAMESPACE_DNS, 'phalcon.io'),
            $version(UuidInterface::NAMESPACE_URL, 'phalcon.io')
        );
    }
}

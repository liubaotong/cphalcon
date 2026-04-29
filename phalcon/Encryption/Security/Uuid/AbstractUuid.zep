
/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Encryption\Security\Uuid;

/**
 * Shared helpers for UUID version adapters.
 */
abstract class AbstractUuid implements UuidInterface
{
    /**
     * Formats a 32-character hex string as a canonical UUID string.
     */
    protected function format(string hex) -> string
    {
        return substr(hex, 0, 8)
            . "-"
            . substr(hex, 8, 4)
            . "-"
            . substr(hex, 12, 4)
            . "-"
            . substr(hex, 16, 4)
            . "-"
            . substr(hex, 20, 12);
    }

    /**
     * Converts a canonical UUID string to its 16-byte binary representation.
     */
    protected function namespaceToBytes(string uuid) -> string
    {
        return hex2bin(
            str_replace("-", "", uuid)
        );
    }
}

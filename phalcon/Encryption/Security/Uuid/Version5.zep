
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
 * Generates a version 5 (name-based SHA-1) UUID.
 *
 * Given a namespace UUID and a name string, produces a deterministic UUID
 * by hashing namespace bytes + name with SHA-1 (first 16 bytes used),
 * then stamping version/variant bits.
 *
 * @link https://www.ietf.org/rfc/rfc4122.txt
 */
class Version5 extends AbstractUuid
{
    public function __invoke(string! namespaceName, string! name) -> string
    {
        var hash;

        let hash = substr(sha1(this->namespaceToBytes(namespaceName) . name, true), 0, 16);
        let hash = substr_replace(hash, chr((ord(substr(hash, 6, 1)) & 0x0f) | 0x50), 6, 1);
        let hash = substr_replace(hash, chr((ord(substr(hash, 8, 1)) & 0x3f) | 0x80), 8, 1);

        return this->format(bin2hex(hash));
    }
}

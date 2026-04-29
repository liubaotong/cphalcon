
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
 * Generates a version 7 (Unix timestamp) UUID per RFC 9562.
 *
 * Layout (128 bits):
 *   unix_ts_ms (48) | ver=7 (4) | rand_a (12) | var=10 (2) | rand_b (62)
 *
 * @link https://www.rfc-editor.org/rfc/rfc9562
 */
class Version7 extends AbstractUuid
{
    public function __invoke() -> string
    {
        var ms, timeHigh32, timeLow16, verRandA, varRandB, randBytes;

        let ms = (int) (microtime(true) * 1000);

        let timeHigh32 = (ms >> 16) & 0xffffffff,
            timeLow16  = ms & 0xffff;

        let randBytes = random_bytes(10);

        // 4-bit version (7) + 12-bit rand_a
        let verRandA = 0x7000 | (hexdec(bin2hex(substr(randBytes, 0, 2))) & 0x0fff);

        // 2-bit variant (10) + 14-bit rand_b_hi, then 48-bit rand_b_lo
        let varRandB = 0x8000 | (hexdec(bin2hex(substr(randBytes, 2, 2))) & 0x3fff);

        return sprintf(
            "%08x-%04x-%04x-%04x-%s",
            timeHigh32,
            timeLow16,
            verRandA,
            varRandB,
            bin2hex(substr(randBytes, 4, 6))
        );
    }
}

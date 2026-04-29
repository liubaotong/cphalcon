
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
 * Generates a version 6 (reordered time-based) UUID.
 *
 * Uses the same 60-bit UUID timestamp as version 1 but rearranges the
 * fields so the most-significant time bits come first, producing UUIDs
 * that sort lexicographically in chronological order.
 *
 * @link https://www.rfc-editor.org/rfc/rfc9562
 */
class Version6 extends AbstractUuid
{
    public function __invoke() -> string
    {
        // nowSec/nowUsec receive PHP return values (must be var).
        // sec/usec/timestamp are typed int (C long, 64-bit) for precise arithmetic.
        var nowSec, nowUsec, timeHigh32, timeMid16, timeLow12, clockSeqBytes, clockSeqHiRes, clockSeqLow, nodeBytes;
        int sec, usec, timestamp;

        // time() returns current Unix seconds as a PHP int (64-bit safe).
        // Subtract sec from microtime(true) to isolate the sub-second fraction
        // (small float, no precision loss) and convert to 100-ns units.
        // 12219292800 = seconds between UUID epoch (Oct 15, 1582) and Unix epoch.
        let nowSec  = time();
        let sec     = nowSec;
        let nowUsec = intval(round((microtime(true) - doubleval(nowSec)) * 10000000.0));
        let usec    = nowUsec;

        let timestamp = (sec + 12219292800) * 10000000 + usec;

        // Reorder timestamp so high bits come first (lexicographic == chronological)
        let timeHigh32 = (timestamp >> 28) & 0xffffffff,
            timeMid16  = (timestamp >> 12) & 0xffff,
            timeLow12  = 0x6000 | (timestamp & 0x0fff);

        let clockSeqBytes = random_bytes(2);
        let clockSeqHiRes = (ord(substr(clockSeqBytes, 0, 1)) & 0x3f) | 0x80;
        let clockSeqLow   = ord(substr(clockSeqBytes, 1, 1));

        // Random node with multicast bit set (RFC 4122 §4.5)
        let nodeBytes = random_bytes(6);
        let nodeBytes = chr(ord(substr(nodeBytes, 0, 1)) | 0x01) . substr(nodeBytes, 1);

        return sprintf(
            "%08x-%04x-%04x-%02x%02x-%s",
            timeHigh32,
            timeMid16,
            timeLow12,
            clockSeqHiRes,
            clockSeqLow,
            bin2hex(nodeBytes)
        );
    }
}

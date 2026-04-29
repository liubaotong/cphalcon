
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
 * Generates a version 1 (time-based) UUID.
 *
 * The timestamp is the number of 100-nanosecond intervals since
 * October 15, 1582 00:00:00.00 UTC (the UUID epoch). The node is a
 * random 48-bit value with the multicast bit set, as permitted by
 * RFC 4122 section 4.5 when a MAC address is not available.
 *
 * @link https://www.ietf.org/rfc/rfc4122.txt
 */
class Version1 extends AbstractUuid
{
    public function __invoke() -> string
    {
        // nowSec/nowUsec receive PHP return values (must be var).
        // sec/usec/timestamp are typed int (C long, 64-bit) for precise arithmetic.
        var nowSec, nowUsec, timeLow, timeMid, timeHi, clockSeqBytes, clockSeqHiRes, clockSeqLow, nodeBytes;
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

        let timeLow = timestamp & 0xffffffff,
            timeMid = (timestamp >> 32) & 0xffff,
            timeHi  = ((timestamp >> 48) & 0x0fff) | 0x1000;

        let clockSeqBytes = random_bytes(2);
        let clockSeqHiRes = (ord(substr(clockSeqBytes, 0, 1)) & 0x3f) | 0x80;
        let clockSeqLow   = ord(substr(clockSeqBytes, 1, 1));

        // Random node with multicast bit set (RFC 4122 §4.5)
        let nodeBytes = random_bytes(6);
        let nodeBytes = chr(ord(substr(nodeBytes, 0, 1)) | 0x01) . substr(nodeBytes, 1);

        return sprintf(
            "%08x-%04x-%04x-%02x%02x-%s",
            timeLow,
            timeMid,
            timeHi,
            clockSeqHiRes,
            clockSeqLow,
            bin2hex(nodeBytes)
        );
    }
}

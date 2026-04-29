
/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Encryption\Security;

use Phalcon\Encryption\Security\Uuid\Version1;
use Phalcon\Encryption\Security\Uuid\Version3;
use Phalcon\Encryption\Security\Uuid\Version4;
use Phalcon\Encryption\Security\Uuid\Version5;
use Phalcon\Encryption\Security\Uuid\Version6;
use Phalcon\Encryption\Security\Uuid\Version7;

/**
 * Factory that generates UUIDs of versions 1 through 7.
 *
 * Each version adapter is instantiated once and cached for reuse.
 *
 * @method string v1()
 * @method string v3(string $namespaceName, string $name)
 * @method string v4()
 * @method string v5(string $namespaceName, string $name)
 * @method string v6()
 * @method string v7()
 */
class Uuid
{
    /**
     * @var Version1|null
     */
    private version1 = null;

    /**
     * @var Version3|null
     */
    private version3 = null;

    /**
     * @var Version4|null
     */
    private version4 = null;

    /**
     * @var Version5|null
     */
    private version5 = null;

    /**
     * @var Version6|null
     */
    private version6 = null;

    /**
     * @var Version7|null
     */
    private version7 = null;

    /**
     * Generates a version 1 (time-based) UUID.
     */
    public function v1() -> string
    {
        if this->version1 === null {
            let this->version1 = new Version1();
        }

        return this->version1->__invoke();
    }

    /**
     * Generates a version 3 (name-based MD5) UUID.
     */
    public function v3(string! namespaceName, string! name) -> string
    {
        if this->version3 === null {
            let this->version3 = new Version3();
        }

        return this->version3->__invoke(namespaceName, name);
    }

    /**
     * Generates a version 4 (random) UUID.
     */
    public function v4() -> string
    {
        if this->version4 === null {
            let this->version4 = new Version4();
        }

        return this->version4->__invoke();
    }

    /**
     * Generates a version 5 (name-based SHA-1) UUID.
     */
    public function v5(string! namespaceName, string! name) -> string
    {
        if this->version5 === null {
            let this->version5 = new Version5();
        }

        return this->version5->__invoke(namespaceName, name);
    }

    /**
     * Generates a version 6 (reordered time-based) UUID.
     */
    public function v6() -> string
    {
        if this->version6 === null {
            let this->version6 = new Version6();
        }

        return this->version6->__invoke();
    }

    /**
     * Generates a version 7 (Unix timestamp) UUID.
     */
    public function v7() -> string
    {
        if this->version7 === null {
            let this->version7 = new Version7();
        }

        return this->version7->__invoke();
    }
}

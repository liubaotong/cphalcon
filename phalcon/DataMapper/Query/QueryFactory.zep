
/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by AtlasPHP
 *
 * @link    https://github.com/atlasphp/Atlas.Query
 * @license https://github.com/atlasphp/Atlas.Qyert/blob/1.x/LICENSE.md
 */

namespace Phalcon\DataMapper\Query;

use Phalcon\DataMapper\Pdo\Connection;

/**
 * QueryFactory
 */
class QueryFactory
{
    /**
     * @var string
     */
    protected selectClass = "";

    /**
     * QueryFactory constructor.
     *
     * @param string $selectClass
     */
    public function __construct(string selectClass = "")
    {
        if empty selectClass {
            let selectClass = "Phalcon\\DataMapper\\Query\\Select";
        }

        let this->selectClass = selectClass;
    }

    /**
     * Create a new Bind object
     *
     * @return Bind
     */
    public function newBind() -> <Bind>
    {
        return new Bind();
    }

    /**
     * Create a new Delete object
     *
     * @param <Connection> connection
     *
     * @return Delete
     */
    public function newDelete(<Connection> connection) -> <Delete>
    {
        return new Delete(connection, this->newBind());
    }

    /**
     * Create a new Insert object
     *
     * @param <Connection> connection
     *
     * @return Insert
     */
    public function newInsert(<Connection> connection) -> <Insert>
    {
        return new Insert(connection, this->newBind());
    }

    /**
     * Create a new Select object
     *
     * @param <Connection> connection
     *
     * @return Select
     */
    public function newSelect(<Connection> connection) -> <Select>
    {
        string selectClass;

        let selectClass = this->selectClass;

        return new {selectClass}(connection, this->newBind());
    }

    /**
     * Create a new Update object
     *
     * @param <Connection> connection
     *
     * @return Update
     */
    public function newUpdate(<Connection> connection) -> <Update>
    {
        return new Update(connection, this->newBind());
    }
}

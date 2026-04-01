
#ifdef HAVE_CONFIG_H
#include "../../../ext_config.h"
#endif

#include <php.h>
#include "../../../php_ext.h"
#include "../../../ext.h"

#include <Zend/zend_operators.h>
#include <Zend/zend_exceptions.h>
#include <Zend/zend_interfaces.h>

#include "kernel/main.h"
#include "kernel/exception.h"
#include "kernel/object.h"


/**
* This file is part of the Phalcon Framework.
*
* (c) Phalcon Team <team@phalcon.io>
*
* For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
*/
/**
 * A read only Collection object
 */
ZEPHIR_INIT_CLASS(Phalcon_Support_Collection_ReadOnlyCollection)
{
	ZEPHIR_REGISTER_CLASS_EX(Phalcon\\Support\\Collection, ReadOnlyCollection, phalcon, support_collection_readonlycollection, phalcon_support_collection_ce, phalcon_support_collection_readonlycollection_method_entry, 0);

	return SUCCESS;
}

/**
 * Delete the element from the collection
 */
PHP_METHOD(Phalcon_Support_Collection_ReadOnlyCollection, remove)
{
	zval element_zv;
	zend_string *element = NULL;

	ZVAL_UNDEF(&element_zv);
	ZEND_PARSE_PARAMETERS_START(1, 1)
		Z_PARAM_STR(element)
	ZEND_PARSE_PARAMETERS_END();
	ZVAL_STR(&element_zv, element);
	ZEPHIR_THROW_EXCEPTION_DEBUG_STRW(phalcon_support_collection_exception_ce, "The object is read only", "phalcon/Support/Collection/ReadOnlyCollection.zep", 25);
	return;
}

/**
 * Set an element in the collection
 */
PHP_METHOD(Phalcon_Support_Collection_ReadOnlyCollection, set)
{
	zval element_zv, *value, value_sub;
	zend_string *element = NULL;

	ZVAL_UNDEF(&element_zv);
	ZVAL_UNDEF(&value_sub);
	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(element)
		Z_PARAM_ZVAL(value)
	ZEND_PARSE_PARAMETERS_END();
	value = ZEND_CALL_ARG(execute_data, 2);
	ZVAL_STR(&element_zv, element);
	ZEPHIR_THROW_EXCEPTION_DEBUG_STRW(phalcon_support_collection_exception_ce, "The object is read only", "phalcon/Support/Collection/ReadOnlyCollection.zep", 33);
	return;
}


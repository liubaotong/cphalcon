
#ifdef HAVE_CONFIG_H
#include "../../../../ext_config.h"
#endif

#include <php.h>
#include "../../../../php_ext.h"
#include "../../../../ext.h"

#include <Zend/zend_operators.h>
#include <Zend/zend_exceptions.h>
#include <Zend/zend_interfaces.h>

#include "kernel/main.h"
#include "kernel/memory.h"
#include "kernel/object.h"
#include "kernel/operators.h"


/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */
/**
 * Phalcon\Mvc\Model\MetaData\Memory
 *
 * Stores model meta-data in memory. Data will be erased when the request finishes
 *
 */
ZEPHIR_INIT_CLASS(Phalcon_Mvc_Model_MetaData_Memory)
{
	ZEPHIR_REGISTER_CLASS_EX(Phalcon\\Mvc\\Model\\MetaData, Memory, phalcon, mvc_model_metadata_memory, phalcon_mvc_model_metadata_ce, phalcon_mvc_model_metadata_memory_method_entry, 0);

	return SUCCESS;
}

/**
 * Phalcon\Mvc\Model\MetaData\Memory constructor
 *
 * @param array options
 */
PHP_METHOD(Phalcon_Mvc_Model_MetaData_Memory, __construct)
{
	zval *options = NULL, options_sub, __$null;

	ZVAL_UNDEF(&options_sub);
	ZVAL_NULL(&__$null);
	bool is_null_true = 1;
	ZEND_PARSE_PARAMETERS_START(0, 1)
		Z_PARAM_OPTIONAL
		Z_PARAM_ZVAL_OR_NULL(options)
	ZEND_PARSE_PARAMETERS_END();
	zephir_fetch_params_without_memory_grow(0, 1, &options);
	if (!options) {
		options = &options_sub;
		options = &__$null;
	}
}

/**
 * Reads the meta-data from temporal memory
 */
PHP_METHOD(Phalcon_Mvc_Model_MetaData_Memory, read)
{
	zval key_zv;
	zend_string *key = NULL;

	ZVAL_UNDEF(&key_zv);
	ZEND_PARSE_PARAMETERS_START(1, 1)
		Z_PARAM_STR(key)
	ZEND_PARSE_PARAMETERS_END();
	ZVAL_STR(&key_zv, key);
	RETURN_NULL();
}

/**
 * Writes the meta-data to temporal memory
 */
PHP_METHOD(Phalcon_Mvc_Model_MetaData_Memory, write)
{
	zephir_method_globals *ZEPHIR_METHOD_GLOBALS_PTR = NULL;
	zval data;
	zval key_zv, *data_param = NULL;
	zend_string *key = NULL;

	ZVAL_UNDEF(&key_zv);
	ZVAL_UNDEF(&data);
	ZEND_PARSE_PARAMETERS_START(2, 2)
		Z_PARAM_STR(key)
		Z_PARAM_ARRAY(data)
	ZEND_PARSE_PARAMETERS_END();
	ZEPHIR_METHOD_GLOBALS_PTR = pecalloc(1, sizeof(zephir_method_globals), 0);
	zephir_memory_grow_stack(ZEPHIR_METHOD_GLOBALS_PTR, __func__);
	data_param = ZEND_CALL_ARG(execute_data, 2);
	ZVAL_STR(&key_zv, key);
	zephir_get_arrval(&data, data_param);
	RETURN_MM_NULL();
}



#ifdef HAVE_CONFIG_H
#include "../../ext_config.h"
#endif

#include <php.h>
#include "../../php_ext.h"
#include "../../ext.h"

#include <Zend/zend_operators.h>
#include <Zend/zend_exceptions.h>
#include <Zend/zend_interfaces.h>

#include "kernel/main.h"
#include "kernel/operators.h"
#include "kernel/exception.h"
#include "kernel/object.h"
#include "ext/spl/spl_exceptions.h"
#include "kernel/memory.h"


/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */
/**
 * This class defines component entity and its description
 */
ZEPHIR_INIT_CLASS(Phalcon_Acl_Component)
{
	ZEPHIR_REGISTER_CLASS(Phalcon\\Acl, Component, phalcon, acl_component, phalcon_acl_component_method_entry, 0);

	/**
	 * Component description
	 *
	 * @var string
	 */
	zend_declare_property_null(phalcon_acl_component_ce, SL("description"), ZEND_ACC_PRIVATE);
	/**
	 * Component name
	 *
	 * @var string
	 */
	zend_declare_property_null(phalcon_acl_component_ce, SL("name"), ZEND_ACC_PRIVATE);
	zend_class_implements(phalcon_acl_component_ce, 1, phalcon_acl_componentinterface_ce);
	return SUCCESS;
}

/**
 * Phalcon\Acl\Component constructor
 */
PHP_METHOD(Phalcon_Acl_Component, __construct)
{
	zephir_method_globals *ZEPHIR_METHOD_GLOBALS_PTR = NULL;
	zval *name_param = NULL, *description_param = NULL;
	zval name, description;
	zval *this_ptr = getThis();

	ZVAL_UNDEF(&name);
	ZVAL_UNDEF(&description);
	bool is_null_true = 1;
	ZEND_PARSE_PARAMETERS_START(1, 2)
		Z_PARAM_STR(name)
		Z_PARAM_OPTIONAL
		Z_PARAM_STR_OR_NULL(description)
	ZEND_PARSE_PARAMETERS_END();
	ZEPHIR_METHOD_GLOBALS_PTR = pecalloc(1, sizeof(zephir_method_globals), 0);
	zephir_memory_grow_stack(ZEPHIR_METHOD_GLOBALS_PTR, __func__);
	zephir_fetch_params(1, 1, 1, &name_param, &description_param);
	if (UNEXPECTED(Z_TYPE_P(name_param) != IS_STRING && Z_TYPE_P(name_param) != IS_NULL)) {
		zephir_throw_exception_string(spl_ce_InvalidArgumentException, SL("Parameter 'name' must be of the type string"));
		RETURN_MM_NULL();
	}
	if (EXPECTED(Z_TYPE_P(name_param) == IS_STRING)) {
		zephir_get_strval(&name, name_param);
	} else {
		ZEPHIR_INIT_VAR(&name);
	}
	if (!description_param) {
		ZEPHIR_INIT_VAR(&description);
	} else {
		zephir_get_strval(&description, description_param);
	}
	if (UNEXPECTED(ZEPHIR_IS_STRING_IDENTICAL(&name, "*"))) {
		ZEPHIR_THROW_EXCEPTION_DEBUG_STR(phalcon_acl_exception_ce, "Component name cannot be '*'", "phalcon/Acl/Component.zep", 38);
		return;
	}
	zephir_update_property_zval(this_ptr, ZEND_STRL("name"), &name);
	zephir_update_property_zval(this_ptr, ZEND_STRL("description"), &description);
	ZEPHIR_MM_RESTORE();
}

PHP_METHOD(Phalcon_Acl_Component, __toString)
{

	RETURN_MEMBER(getThis(), "name");
}

PHP_METHOD(Phalcon_Acl_Component, getDescription)
{

	RETURN_MEMBER(getThis(), "description");
}

PHP_METHOD(Phalcon_Acl_Component, getName)
{

	RETURN_MEMBER(getThis(), "name");
}


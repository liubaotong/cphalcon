
extern zend_class_entry *phalcon_filter_validation_validator_identical_ce;

ZEPHIR_INIT_CLASS(Phalcon_Filter_Validation_Validator_Identical);

PHP_METHOD(Phalcon_Filter_Validation_Validator_Identical, __construct);
PHP_METHOD(Phalcon_Filter_Validation_Validator_Identical, validate);

ZEND_BEGIN_ARG_INFO_EX(arginfo_phalcon_filter_validation_validator_identical___construct, 0, 0, 0)
ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, options, IS_ARRAY, 0, "[]")
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_phalcon_filter_validation_validator_identical_validate, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_OBJ_INFO(0, validation, Phalcon\\Filter\\Validation, 0)
	ZEND_ARG_INFO(0, field)
ZEND_END_ARG_INFO()

ZEPHIR_INIT_FUNCS(phalcon_filter_validation_validator_identical_method_entry) {
	PHP_ME(Phalcon_Filter_Validation_Validator_Identical, __construct, arginfo_phalcon_filter_validation_validator_identical___construct, ZEND_ACC_PUBLIC|ZEND_ACC_CTOR)
	PHP_ME(Phalcon_Filter_Validation_Validator_Identical, validate, arginfo_phalcon_filter_validation_validator_identical_validate, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

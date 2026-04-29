
#ifdef HAVE_CONFIG_H
#include "../../../../ext_config.h"
#endif

#include <php.h>
#include "../../../../php_ext.h"
#include "../../../../ext.h"

#include <Zend/zend_exceptions.h>

#include "kernel/main.h"


/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 *
 * Implementation of this file has been influenced by sinbadxiii/cphalcon-uuid
 * @link    https://github.com/sinbadxiii/cphalcon-uuid
 */
ZEPHIR_INIT_CLASS(Phalcon_Encryption_Security_Uuid_TimeBasedUuidInterface)
{
	ZEPHIR_REGISTER_INTERFACE(Phalcon\\Encryption\\Security\\Uuid, TimeBasedUuidInterface, phalcon, encryption_security_uuid_timebaseduuidinterface, phalcon_encryption_security_uuid_timebaseduuidinterface_method_entry);

	return SUCCESS;
}

ZEPHIR_DOC_METHOD(Phalcon_Encryption_Security_Uuid_TimeBasedUuidInterface, getDateTime);
ZEPHIR_DOC_METHOD(Phalcon_Encryption_Security_Uuid_TimeBasedUuidInterface, getNode);

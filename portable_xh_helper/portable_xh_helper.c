/*
   +----------------------------------------------------------------------+
   | Copyright (c) The PHP Group                                          |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Christoph M. Becker <cmb@php.net>                            |
   +----------------------------------------------------------------------+
*/

#ifdef HAVE_CONFIG_H
# include "config.h"
#endif

#include "php.h"
#include "ext/standard/info.h"
#include "php_portable_xh_helper.h"

/* True global for storing the original zend_ast_process */
static void (*original_zend_ast_process)(zend_ast*);

/**
 * This function replaces the original `zend_ast_process` function. If one was
 * previously provided, call that one after this one.
 */
static void portable_xh_helper_ast_process(zend_ast *ast)
{
	/* Drop toplevel definitions of XH_isAccessProtected if the function is already defined. */
	HashTable *function_table = CG(function_table);
	if (!zend_ast_is_list(ast)) goto out;
	zend_ast_list *ast_list = zend_ast_get_list(ast);
	for (uint32_t i = ast_list->children; i-- > 0;) {
		if (ast_list->child[i] == NULL || ast_list->child[i]->kind != ZEND_AST_FUNC_DECL) continue;
		zend_ast_decl *ast_decl = (zend_ast_decl*) ast_list->child[i];
		if (zend_string_equals_literal_ci(ast_decl->name, "xh_isAccessProtected")) {
			zend_string *lower_name = zend_string_tolower(ast_decl->name);
			zend_bool exists = zend_hash_exists(function_table, lower_name);
			zend_string_release(lower_name);
			if (exists) {
				zend_ast_destroy(ast_list->child[i]);
				for (uint32_t j = i; j < ast_list->children - 1; ++j) {
					ast_list->child[j] = ast_list->child[j + 1];
				}
				ast_list->children--;
			}
		}
	}
out:
	if (original_zend_ast_process) {
		original_zend_ast_process(ast);
	}
}

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(portable_xh_helper)
{
	/*
	 * Save original zend_ast_process function and use our own to modify the AST.
	 */
	original_zend_ast_process = zend_ast_process;
	zend_ast_process = portable_xh_helper_ast_process;

	return SUCCESS;
}

/* {{{ PHP_MSHUTDOWN_FUNCTION */
PHP_MSHUTDOWN_FUNCTION(portable_xh_helper)
{
	/*
	 * Restore original zend_ast_process function.
	 */
	zend_ast_process = original_zend_ast_process;

	return SUCCESS;
}

/* {{{ PHP_RINIT_FUNCTION */
PHP_RINIT_FUNCTION(portable_xh_helper)
{
#if defined(ZTS) && defined(COMPILE_DL_PORTABLE_XH_HELPER)
	ZEND_TSRMLS_CACHE_UPDATE();
#endif

	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION */
PHP_MINFO_FUNCTION(portable_xh_helper)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "portable_xh_helper support", "enabled");
	php_info_print_table_end();
}
/* }}} */

/* {{{ portable_xh_helper_module_entry */
zend_module_entry portable_xh_helper_module_entry = {
	STANDARD_MODULE_HEADER,
	"portable_xh_helper",				/* Extension name */
	NULL,								/* zend_function_entry */
	PHP_MINIT(portable_xh_helper),		/* PHP_MINIT - Module initialization */
	PHP_MSHUTDOWN(portable_xh_helper),	/* PHP_MSHUTDOWN - Module shutdown */
	PHP_RINIT(portable_xh_helper),		/* PHP_RINIT - Request initialization */
	NULL,								/* PHP_RSHUTDOWN - Request shutdown */
	PHP_MINFO(portable_xh_helper),		/* PHP_MINFO - Module info */
	PHP_PORTABLE_XH_HELPER_VERSION,		/* Version */
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_PORTABLE_XH_HELPER
# ifdef ZTS
ZEND_TSRMLS_CACHE_DEFINE()
# endif
ZEND_GET_MODULE(portable_xh_helper)
#endif

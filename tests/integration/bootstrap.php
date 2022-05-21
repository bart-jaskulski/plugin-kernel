<?php

// disable xdebug backtrace
if ( function_exists( 'xdebug_disable' ) ) {
	xdebug_disable();
}

define( 'DOING_TESTS', true );

if ( getenv( 'DEPENDENT_PLUGINS_DIR' ) !== false ) {
	define( 'DEPENDENT_PLUGINS_DIR', getenv( 'DEPENDENT_PLUGINS_DIR' ) );
} else {
	define( 'DEPENDENT_PLUGINS_DIR', '/tmp/plugins' );
}

if ( getenv( 'PLUGIN_PATH' ) !== false ) {
	define( 'PLUGIN_PATH', getenv( 'PLUGIN_PATH' ) );
} else {
	define( 'PLUGIN_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR );
}

require_once( getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit/includes/functions.php' );

tests_add_filter( 'muplugins_loaded', function () {
	$plugins_to_active   = get_option( 'active_plugins' );
	$plugins_to_active[] = 'woocommerce/woocommerce.php';
	update_option( 'active_plugins', $plugins_to_active );
}, 100 );

putenv( 'WP_TESTS_DIR=' . getenv( 'WP_DEVELOP_DIR' ) . '/tests/phpunit' );
require_once( getenv( 'WC_DEVELOP_DIR' ) . '/tests/legacy/bootstrap.php' );

<?php

use WPDesk\Plugin\Flow\Initialization\Simple\TrackerInstanceAsFilterTrait;

class Test_Plugin_Start_Using_Flow extends WP_UnitTestCase {
	const TESTED_PLUGIN_CLASS = 'Flexible_Checkout_Fields_Plugin';

	/**
	 * Start prepared plugin.
	 *
	 * @param string $flow_file Path to file with flow to use.
	 */
	private function plugin_start_from_flow_file($flow_file) {
		$plugin_name              = 'Flexible Checkout Fields';
		$plugin_class_name        = self::TESTED_PLUGIN_CLASS;
		$plugin_text_domain       = 'flexible-checkout-fields';
		$plugin_release_timestamp = date( 'Y-m-d' );

		$plugin_version = '1.0';
		$product_id     = 'Flexible Checkout Fields';
		$plugin_file    = DEPENDENT_PLUGINS_DIR . '/flexible-checkout-fields/flexible-checkout-fields.php';
		$plugin_dir     = dirname( $plugin_file );
		$requirements   = [
			'php' => '5.6',
			'wp'  => '4.5',
		];

		defined('FLEXIBLE_CHECKOUT_FIELDS_VERSION') || define( 'FLEXIBLE_CHECKOUT_FIELDS_VERSION', $plugin_version );
		require_once $plugin_dir . '/inc/wpdesk-woo27-functions.php';

		// we need to inject Prefixed names as library is not prefixed and plugin libraries also are not prefixed
		if (!class_exists(\FcfVendor\WPDesk_Plugin_Info::class)) {
			class_alias( \WPDesk_Plugin_Info::class, \FcfVendor\WPDesk_Plugin_Info::class );
			class_alias( \WPDesk\PluginBuilder\Plugin\AbstractPlugin::class, \FcfVendor\WPDesk\PluginBuilder\Plugin\AbstractPlugin::class );
		}

		require $flow_file;

		do_action( 'plugins_loaded' );
	}

	/**
	 * Assert that prepared plugin is running.
	 */
	private function assert_plugin_started() {
		/** @var \WPDesk\PluginBuilder\Storage\StorageFactory $storage */
		$storage = new \WPDesk\PluginBuilder\Storage\StorageFactory();
		$storage = $storage->create_storage();
		$plugin = $storage->get_from_storage(self::TESTED_PLUGIN_CLASS);

		$this->assertInstanceOf( self::TESTED_PLUGIN_CLASS, $plugin, 'Plugin works.' );
	}

	public function test_plugin_paid_can_start() {
		remove_all_actions('wpdesk_tracker_instance');
		$this->plugin_start_from_flow_file(__DIR__ . '/../../src/plugin-init-php52.php');
		$this->assert_plugin_started();
	}

	// disabled until new builder loaded into tested FCF plugin

//	public function test_plugin_free_can_start() {
//		remove_all_actions('wpdesk_tracker_instance');
//		$this->plugin_start_from_flow_file(__DIR__ . '/../../src/plugin-init-php52-free.php');
//		$this->assert_plugin_started();
//	}
}

<?php

use WPDesk\Plugin\Flow\Initialization\Simple\SimpleFreeStrategy;

class Test_Plugin_Initialization_Strategy_Simple_Free extends \WP_Mock\Tools\TestCase {

	public function setUp() {
		WP_Mock::setUp();
	}

	public function tearDown() {
		WP_Mock::tearDown();
	}

	/**
	 * @runInSeparateProcess
	 */
	public function test_strategy_can_build() {
		$info = new \WPDesk_Plugin_Info();
		$info->set_class_name( Stub_Plugin::class );

		WP_Mock::userFunction( 'plugin_dir_url',
			[
				'return' => 'whatever',
			] );
		WP_Mock::userFunction( 'plugin_basename',
			[
				'return' => 'whatever',
			] );

		$strategy = new SimpleFreeStrategy( $info );
		$this->assertInstanceOf( Stub_Plugin::class, $strategy->run_init( $info ), "Plugin should be actually built" );
	}
}

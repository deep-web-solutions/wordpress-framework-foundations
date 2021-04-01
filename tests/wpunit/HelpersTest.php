<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ChildInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\ChildObject;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\NodeObject;
use DeepWebSolutions\Framework\Tests\Foundations\Hierarchy\ParentObject;
use DeepWebSolutions\Framework\Tests\Foundations\Plugin;
use DeepWebSolutions\Framework\Tests\Foundations\PluginAwareObject;
use DeepWebSolutions\Framework\Tests\Foundations\PluginComponent;
use WpunitTester;

/**
 * Tests for the Helpers traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration
 */
class HelpersTest extends WPTestCase {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of the WP actor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     WpunitTester
	 */
	protected WpunitTester $tester;

	// endregion

	// region TESTS

	/**
	 * Tests the HooksHelpers trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_hooks_helpers_trait() {
		$plugin = dws_foundations_test_plugin_instance();
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test', $plugin->get_hook_tag( 'test' ) );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test-extra', $plugin->get_hook_tag( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'my_custom_root-test-extra_test', $plugin->get_hook_tag( 'test', array( 'extra_test' ), 'my_custom_root' ) );

		$plugin_aware_object = new PluginAwareObject( $plugin );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test', $plugin_aware_object->get_hook_tag( 'test' ) );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test-extra', $plugin_aware_object->get_hook_tag( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'my_custom_root-test-extra_test', $plugin_aware_object->get_hook_tag( 'test', array( 'extra_test' ), 'my_custom_root' ) );

		$plugin_component = new PluginComponent( $plugin, 'test-id', 'Test NAME' );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test_name-test', $plugin_component->get_hook_tag( 'test' ) );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test_name-test-extra', $plugin_component->get_hook_tag( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-my_custom_root-test-extra_test', $plugin_component->get_hook_tag( 'test', array( 'extra_test' ), 'my_custom_root' ) );

		$plugin_component = new PluginComponent( $plugin, 'test-id', 'Test Näme Curaçao' );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test_nme_curaao-test', $plugin_component->get_hook_tag( 'test' ) );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-test_nme_curaao-test-extra', $plugin_component->get_hook_tag( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'dws_wp_foundations_test_plugin-my_custom_root-test-extra_test', $plugin_component->get_hook_tag( 'test', array( 'extra_test' ), 'my_custom_root' ) );
	}

	/**
	 * Tests the AssetsHelpers trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_assets_helpers_trait() {
		$plugin = dws_foundations_test_plugin_instance();
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test', $plugin->get_asset_handle( 'test' ) );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test_extra', $plugin->get_asset_handle( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'my-custom-root_test_extra-test', $plugin->get_asset_handle( 'test', array( 'extra-test' ), 'my-custom-root' ) );

		$plugin_aware_object = new PluginAwareObject( $plugin );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test', $plugin_aware_object->get_asset_handle( 'test' ) );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test_extra', $plugin_aware_object->get_asset_handle( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'my-custom-root_test_extra-test', $plugin_aware_object->get_asset_handle( 'test', array( 'extra-test' ), 'my-custom-root' ) );

		$plugin_component = new PluginComponent( $plugin, 'test-id', 'Test NAME' );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test-name_test', $plugin_component->get_asset_handle( 'test' ) );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test-name_test_extra', $plugin_component->get_asset_handle( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_my-custom-root_test_extra-test', $plugin_component->get_asset_handle( 'test', array( 'extra-test' ), 'my-custom-root' ) );

		$plugin_component = new PluginComponent( $plugin, 'test-id', 'Test Näme Curaçao' );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test-näme-curaçao_test', $plugin_component->get_asset_handle( 'test' ) );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_test-näme-curaçao_test_extra', $plugin_component->get_asset_handle( 'test', array( 'extra' ) ) );
		$this->assertEquals( 'dws-wp-foundations-test-plugin_my-custom-root_test_extra-test', $plugin_component->get_asset_handle( 'test', array( 'extra-test' ), 'my-custom-root' ) );
	}

	// endregion
}

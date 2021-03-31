<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Exceptions\InexistentPropertyException;
use DeepWebSolutions\Framework\Foundations\Exceptions\ReadOnlyPropertyException;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Tests\Foundations\PluginComponents\GenericPluginComponent;
use WpunitTester;

/**
 * Tests for the Plugin and PluginComponents abstractions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration
 */
class PluginAbstractionsTest extends WPTestCase {
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
	 * Tests the AbstractPlugin class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_plugin_instance() {
		$plugin = dws_foundations_test_plugin_instance();

		$this->assertEquals( 'DWS WordPress Framework Foundations Test Plugin', $plugin->get_plugin_name() );
		$this->assertEquals( 'dws-wp-foundations-test-plugin', $plugin->get_plugin_slug() );
		$this->assertEquals( '1.0.0', $plugin->get_plugin_version() );

		$this->assertEquals( 'Deep Web Solutions GmbH', $plugin->get_plugin_author_name() );
		$this->assertEquals( 'https://www.deep-web-solutions.com', $plugin->get_plugin_author_uri() );
		$this->assertEquals( 'A WP plugin used to run automated tests against the DWS WP Framework Foundations package.', $plugin->get_plugin_description() );
		$this->assertEquals( $plugin->get_plugin_slug(), $plugin->get_plugin_language_domain() );
	}

	/**
	 * Tests the AbstractPluginComponent class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_plugin_component() {
		$plugin           = dws_foundations_test_plugin_instance();
		$plugin_component = new GenericPluginComponent( new LoggingService( $plugin ), 'test-id', 'Test Name' );

		$this->assertEquals( 'Test Name', $plugin_component->get_name() );
		$this->assertEquals( 'test-id', $plugin_component->get_id() );

		$plugin_component->set_name( 'Test Name 2' );
		$this->assertEquals( 'Test Name 2', $plugin_component->get_name() );

		$plugin_component->set_id( 'test-id-2' );
		$this->assertEquals( 'test-id-2', $plugin_component->get_id() );

		// Now test the fancy magic methods.
		$this->assertEquals( 'Test Name 2', $plugin_component->name );
		$this->assertEquals( 'test-id-2', $plugin_component->id );

		$plugin_component->name = 'Test Name 3';
		$plugin_component->id   = 'test-id-3';

		$this->assertEquals( 'Test Name 3', $plugin_component->name );
		$this->assertEquals( 'test-id-3', $plugin_component->id );
		$this->assertEquals( 'Test Name 3', $plugin_component->get_name() );
		$this->assertEquals( 'test-id-3', $plugin_component->get_id() );

		$this->assertTrue( isset( $plugin_component->name ) );
		$this->assertTrue( isset( $plugin_component->id ) );

		// Now test the fancy magic methods error-ing out.
		$plugin_component->test = true;
		$this->assertTrue( $plugin_component->test );
		$plugin_component->test = false;
		$this->assertFalse( $plugin_component->test );

		$this->assertEquals( 'immutable', $plugin_component->readonly_test );
		try {
			$plugin_component->readonly_test = 'new value';
			$this->fail( 'Changed value of readonly property' );
		} catch ( ReadOnlyPropertyException $exception ) {
			$this->assertEquals( 'Property readonly_test is ready-only', $exception->getMessage() );
		}

		$this->assertInstanceOf( InexistentPropertyException::class, $plugin_component->inexistent_test );
		try {
			$plugin_component->inexistent_test = 'value';
			$this->fail( 'Set value on inexistent property' );
		} catch ( InexistentPropertyException $exception ) {
			$this->assertEquals( 'Inexistent property: inexistent_test', $exception->getMessage() );
		}
	}

	// endregion
}

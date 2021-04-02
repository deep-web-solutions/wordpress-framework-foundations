<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\States;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Tests\Foundations\States\ActiveableExtensionObject;
use DeepWebSolutions\Framework\Tests\Foundations\States\ActiveableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\States\ActiveableObject;
use WpunitTester;

/**
 * Tests for the Activeable objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\States
 */
class ActiveableTest extends WPTestCase {
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
	 * Tests the default activeable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_activeable_trait() {
		$activeable_object = new ActiveableObject();
		$this->assertEquals( true, $activeable_object->is_active() );
	}

	/**
	 * Test for the local activeable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _activeable_local_trait_provider
	 */
	public function test_activeable_local_trait( array $example ) {
		$activeable_object = new ActiveableLocalObject( $example['is_active_local'] );
		$this->assertEquals( $example['is_active_local'], $activeable_object->is_active_local() );
		$this->assertEquals( $example['is_active'], $activeable_object->is_active() );
	}

	/**
	 * Test for the extension activeable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _activeable_extension_trait_provider
	 */
	public function test_activeable_extension_trait( array $example ) {
		$activeable_object = new ActiveableExtensionObject( $example['is_active_local'], $example['is_active_extension'] );
		$this->assertEquals( $example['is_active_local'], $activeable_object->is_active_local() );
		$this->assertEquals( $example['is_active_extension'], $activeable_object->is_active_extension() );
		$this->assertEquals( $example['is_active'], $activeable_object->is_active() );
	}

	// endregion

	// region PROVIDERS

	/**
	 * Provides examples for the 'activeable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _activeable_local_trait_provider(): array {
		return array(
			array(
				array(
					'is_active_local' => true,
					'is_active'       => true,
				),
			),
			array(
				array(
					'is_active_local' => false,
					'is_active'       => false,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'activeable_extension_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _activeable_extension_trait_provider(): array {
		return array(
			array(
				array(
					'is_active_local'     => true,
					'is_active_extension' => true,
					'is_active'           => true,
				),
			),
			array(
				array(
					'is_active_local'     => false,
					'is_active_extension' => true,
					'is_active'           => false,
				),
			),
			array(
				array(
					'is_active_local'     => true,
					'is_active_extension' => false,
					'is_active'           => false,
				),
			),
			array(
				array(
					'is_active_local'     => false,
					'is_active_extension' => false,
					'is_active'           => false,
				),
			),
		);
	}

	// endregion
}

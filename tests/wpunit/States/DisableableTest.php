<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\States;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Tests\Foundations\States\DisableableExtensionObject;
use DeepWebSolutions\Framework\Tests\Foundations\States\DisableableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\States\DisableableObject;
use WpunitTester;

/**
 * Tests for the Disableable objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\States
 */
class DisableableTest extends WPTestCase {
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
	 * Tests the default disableable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_disableable_trait() {
		$disableable_object = new DisableableObject();
		$this->assertEquals( false, $disableable_object->is_disabled() );
	}

	/**
	 * Test for the local disableable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _disableable_local_trait_provider
	 */
	public function test_disableable_local_trait( array $example ) {
		$disableable_object = new DisableableLocalObject( $example['is_disabled_local'] );
		$this->assertEquals( $example['is_disabled_local'], $disableable_object->is_disabled_local() );
		$this->assertEquals( $example['is_disabled'], $disableable_object->is_disabled() );
	}

	/**
	 * Test for the extension disableable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _disableable_extension_trait_provider
	 */
	public function test_disableable_extension_trait( array $example ) {
		$disableable_object = new DisableableExtensionObject( $example['is_disabled_local'], $example['is_disabled_extension'] );
		$this->assertEquals( $example['is_disabled_local'], $disableable_object->is_disabled_local() );
		$this->assertEquals( $example['is_disabled_extension'], $disableable_object->is_disabled_extension() );
		$this->assertEquals( $example['is_disabled'], $disableable_object->is_disabled() );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'disableable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _disableable_local_trait_provider(): array {
		return array(
			array(
				array(
					'is_disabled_local' => false,
					'is_disabled'       => false,
				),
			),
			array(
				array(
					'is_disabled_local' => true,
					'is_disabled'       => true,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'disableable_extension_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _disableable_extension_trait_provider(): array {
		return array(
			array(
				array(
					'is_disabled_local'     => false,
					'is_disabled_extension' => false,
					'is_disabled'           => false,
				),
			),
			array(
				array(
					'is_disabled_local'     => true,
					'is_disabled_extension' => false,
					'is_disabled'           => true,
				),
			),
			array(
				array(
					'is_disabled_local'     => false,
					'is_disabled_extension' => true,
					'is_disabled'           => true,
				),
			),
			array(
				array(
					'is_disabled_local'     => true,
					'is_disabled_extension' => true,
					'is_disabled'           => true,
				),
			),
		);
	}

	// endregion
}

<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Actions;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable\SetupableExtensionObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable\SetupableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable\SetupableObject;
use WpunitTester;

/**
 * Tests for the Setupable objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Actions
 */
class SetupableTest extends WPTestCase {
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
	 * Tests the default setupable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_setupable_trait() {
		$setupable_object = new SetupableObject();

		$this->assertEquals( null, $setupable_object->is_setup() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$setupable_object->get_setup_result();
			$this->fail( 'Accessed setup result before setting up the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$setupable_object->setup();
		$this->assertEquals( true, $setupable_object->is_setup() );
		$this->assertEquals( null, $setupable_object->get_setup_result() );

		$setup_result = $setupable_object->setup();
		$this->assertInstanceOf( SetupFailureException::class, $setup_result );
		$this->assertStringEndsWith( 'has been setup already', $setup_result->getMessage() );
	}

	/**
	 * Test for the local setupable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _setupable_local_trait_provider
	 */
	public function test_setupable_local_trait( array $example ) {
		$setupable_object = new SetupableLocalObject( $example['setup_result_local'] );

		$this->assertEquals( null, $setupable_object->is_setup() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$setupable_object->get_setup_result();
			$this->fail( 'Accessed setup result before setting up the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$setupable_object->setup();
		$this->assertEquals( $example['is_setup'], $setupable_object->is_setup() );
		$this->assertEquals( $example['setup_result'], $setupable_object->get_setup_result() );
	}

	/**
	 * Test for the extension setupable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _setupable_extension_trait_provider
	 */
	public function test_setupable_extension_trait( array $example ) {
		$setupable_object = new SetupableExtensionObject( $example['setup_result_local'], $example['setup_result_extension'] );

		$this->assertEquals( null, $setupable_object->is_setup() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$setupable_object->get_setup_result();
			$this->fail( 'Accessed initialization result before initializing the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$setupable_object->setup();
		$this->assertEquals( $example['is_setup'], $setupable_object->is_setup() );
		$this->assertEquals( $example['setup_result'], $setupable_object->get_setup_result() );
	}

	// endregion

	// region PROVIDERS

	/**
	 * Provides examples for the 'setupable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _setupable_local_trait_provider(): array {
		return array(
			array(
				array(
					'setup_result_local' => null,
					'setup_result'       => null,
					'is_setup'           => true,
				),
			),
			array(
				array(
					'setup_result_local' => ( $local_result = new SetupFailureException() ), // phpcs:ignore
					'setup_result'       => $local_result,
					'is_setup'           => false,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'setupable_extension_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _setupable_extension_trait_provider(): array {
		return array(
			array(
				array(
					'setup_result_local'     => null,
					'setup_result_extension' => null,
					'setup_result'           => null,
					'is_setup'               => true,
				),
			),
			array(
				array(
					'setup_result_local'     => ( $local_result = new SetupFailureException( 'Local failure' ) ), // phpcs:ignore
					'setup_result_extension' => null,
					'setup_result'           => $local_result,
					'is_setup'               => false,
				),
			),
			array(
				array(
					'setup_result_local'     => null,
					'setup_result_extension' => ( $extension_result = new SetupFailureException( 'Extension failure' ) ), // phpcs:ignore
					'setup_result'           => $extension_result,
					'is_setup'               => false,
				),
			),
			array(
				array(
					'setup_result_local'     => ( $local_result = new SetupFailureException( 'Local failure' ) ), // phpcs:ignore
					'setup_result_extension' => ( $extension_result = new SetupFailureException( 'Extension failure' ) ), // phpcs:ignore
					'setup_result'           => $local_result,
					'is_setup'               => false,
				),
			),
		);
	}

	// endregion
}

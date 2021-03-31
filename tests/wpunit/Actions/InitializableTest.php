<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration\Actions;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable\InitializableExtensionObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable\InitializableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable\InitializableObject;
use WpunitTester;

/**
 * Tests for the Initializable objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration\Actions
 */
class InitializableTest extends WPTestCase {
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
	 * Tests the default initializable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_initializable_trait() {
		$initializable_object = new InitializableObject();

		$this->assertEquals( null, $initializable_object->is_initialized() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$initializable_object->get_initialization_result();
			$this->fail( 'Accessed initialization result before initializing the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$initializable_object->initialize();
		$this->assertEquals( true, $initializable_object->is_initialized() );
		$this->assertEquals( null, $initializable_object->get_initialization_result() );

		$initialization_result = $initializable_object->initialize();
		$this->assertInstanceOf( InitializationFailureException::class, $initialization_result );
		$this->assertStringEndsWith( 'has been initialized already', $initialization_result->getMessage() );
	}

	/**
	 * Test for the local initializable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _initializable_local_trait_provider
	 */
	public function test_initializable_local_trait( array $example ) {
		$initializable_object = new InitializableLocalObject( $example['init_result_local'] );

		$this->assertEquals( null, $initializable_object->is_initialized() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$initializable_object->get_initialization_result();
			$this->fail( 'Accessed initialization result before initializing the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$initializable_object->initialize();
		$this->assertEquals( $example['is_initialized'], $initializable_object->is_initialized() );
		$this->assertEquals( $example['init_result'], $initializable_object->get_initialization_result() );
	}

	/**
	 * Test for the extension initializable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _initializable_extension_trait_provider
	 */
	public function test_initializable_extension_trait( array $example ) {
		$initializable_object = new InitializableExtensionObject( $example['init_result_local'], $example['init_result_extension'] );

		$this->assertEquals( null, $initializable_object->is_initialized() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$initializable_object->get_initialization_result();
			$this->fail( 'Accessed initialization result before initializing the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$initializable_object->initialize();
		$this->assertEquals( $example['is_initialized'], $initializable_object->is_initialized() );
		$this->assertEquals( $example['init_result'], $initializable_object->get_initialization_result() );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'initializable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _initializable_local_trait_provider(): array {
		return array(
			array(
				array(
					'init_result_local' => null,
					'init_result'       => null,
					'is_initialized'    => true,
				),
			),
			array(
				array(
					'init_result_local' => ( $local_result = new InitializationFailureException() ), // phpcs:ignore
					'init_result'       => $local_result,
					'is_initialized'    => false,
				),
			),
		);
	}

	/**
	 * Provides examples for the 'initializable_extension_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _initializable_extension_trait_provider(): array {
		return array(
			array(
				array(
					'init_result_local'     => null,
					'init_result_extension' => null,
					'init_result'           => null,
					'is_initialized'        => true,
				),
			),
			array(
				array(
					'init_result_local'     => ( $local_result = new InitializationFailureException( 'Local failure' ) ), // phpcs:ignore
					'init_result_extension' => null,
					'init_result'           => $local_result,
					'is_initialized'        => false,
				),
			),
			array(
				array(
					'init_result_local'     => null,
					'init_result_extension' => ( $extension_result = new InitializationFailureException( 'Extension failure' ) ), // phpcs:ignore
					'init_result'           => $extension_result,
					'is_initialized'        => false,
				),
			),
			array(
				array(
					'init_result_local'     => ( $local_result = new InitializationFailureException( 'Local failure' ) ), // phpcs:ignore
					'init_result_extension' => ( $extension_result = new InitializationFailureException( 'Extension failure' ) ), // phpcs:ignore
					'init_result'           => $local_result,
					'is_initialized'        => false,
				),
			),
		);
	}

	// endregion
}

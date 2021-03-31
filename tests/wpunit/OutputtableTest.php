<?php declare( strict_types = 1 );

namespace DeepWebSolutions\Framework\Tests\Foundations\Integration;

use Codeception\TestCase\WPTestCase;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Outputtable\OutputtableLocalObject;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Outputtable\OutputtableObject;
use WpunitTester;

/**
 * Tests for the Outputtable objects and traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Integration
 */
class OutputtableTest extends WPTestCase {
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
	 * Tests the default outputtable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function test_outputtable_trait() {
		$outputtable_object = new OutputtableObject();

		$this->assertEquals( null, $outputtable_object->is_outputted() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$outputtable_object->get_output_result();
			$this->fail( 'Accessed output result before running the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$outputtable_object->output();
		$this->assertEquals( true, $outputtable_object->is_outputted() );
		$this->assertEquals( null, $outputtable_object->get_output_result() );

		$output_result = $outputtable_object->output();
		$this->assertInstanceOf( OutputFailureException::class, $output_result );
		$this->assertStringEndsWith( 'has been outputted already', $output_result->getMessage() );
	}

	/**
	 * Test for the local outputtable trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $example    Example to run the test on.
	 *
	 * @dataProvider    _outputtable_local_trait_provider
	 */
	public function test_outputtable_local_trait( array $example ) {
		$outputtable_object = new OutputtableLocalObject( $example['output_result_local'] );

		$this->assertEquals( null, $outputtable_object->is_outputted() );
		try {
			/* @noinspection PhpExpressionResultUnusedInspection */
			$outputtable_object->get_output_result();
			$this->fail( 'Accessed output result before running the object' );
		} catch ( \Error $e ) {
			$this->assertStringStartsWith( 'Typed property', $e->getMessage() );
		}

		$outputtable_object->output();
		$this->assertEquals( $example['is_outputted'], $outputtable_object->is_outputted() );
		$this->assertEquals( $example['output_result'], $outputtable_object->get_output_result() );
	}

	// endregion

	// region HELPERS

	/**
	 * Provides examples for the 'outputtable_local_trait' tester.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array[][][]
	 */
	public function _outputtable_local_trait_provider(): array {
		return array(
			array(
				array(
					'output_result_local' => null,
					'output_result'       => null,
					'is_outputted'        => true,
				),
			),
			array(
				array(
					'output_result_local' => ( $local_result = new OutputFailureException() ), // phpcs:ignore
					'output_result'       => $local_result,
					'is_outputted'        => false,
				),
			),
		);
	}

	// endregion
}

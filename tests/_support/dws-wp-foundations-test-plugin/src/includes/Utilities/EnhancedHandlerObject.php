<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\OutputtableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class EnhancedHandlerObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class EnhancedHandlerObject extends HandlerObject implements OutputtableInterface, RunnableInterface, ResettableInterface {
	// region TRAITS

	use OutputLocalTrait;
	use ResetLocalTrait;
	use RunLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local output result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     OutputFailureException|null
	 */
	protected ?OutputFailureException $output_result_local;

	/**
	 * Dummy local run result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     RunFailureException|null
	 */
	protected ?RunFailureException  $run_result_local;

	/**
	 * Dummy local reset result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     ResetFailureException|null
	 */
	protected ?ResetFailureException $reset_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * EnhancedHandlerObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string                          $handler_id             The ID of the handler.
	 * @param   OutputFailureException|null     $output_result_local    Dummy local output result.
	 * @param   ResetFailureException|null      $reset_result_local     Dummy local reset result.
	 * @param   RunFailureException|null        $run_result_local       Dummy local run result.
	 */
	public function __construct( string $handler_id, ?OutputFailureException $output_result_local, ?ResetFailureException $reset_result_local, ?RunFailureException $run_result_local ) {
		parent::__construct( $handler_id );

		$this->output_result_local = $output_result_local;
		$this->reset_result_local  = $reset_result_local;
		$this->run_result_local    = $run_result_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy local output result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  OutputFailureException|null
	 */
	protected function output_local(): ?OutputFailureException {
		return $this->output_result_local;
	}

	/**
	 * Returns the dummy local reset result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ResetFailureException|null
	 */
	protected function reset_local(): ?ResetFailureException {
		return $this->reset_result_local;
	}

	/**
	 * Returns the dummy local run result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  RunFailureException|null
	 */
	protected function run_local(): ?RunFailureException {
		return $this->run_result_local;
	}

	// endregion
}

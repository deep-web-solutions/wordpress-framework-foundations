<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResettableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\HandlerServiceInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\MultiHandlerServiceInterface;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use Psr\Log\LogLevel;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of a runnable handler(s) service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services\Actions
 */
trait RunnableHandlerServiceTrait {
	// region TRAITS

	use RunnableTrait;

	// endregion

	// region METHODS

	/**
	 * Execute the run logic of runnable handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function run(): ?RunFailureException {
		if ( ! \is_a( $this, HandlerServiceInterface::class ) && ! \is_a( $this, MultiHandlerServiceInterface::class ) ) {
			return new RunFailureException( \sprintf( '%s can only be used in handler service instances', __TRAIT__ ) );
		}

		if ( \is_null( $this->is_run ) ) {
			$this->run_result = null;

			$handlers = ( $this instanceof HandlerServiceInterface ) ? (array) $this->get_handler() : $this->get_handlers();
			$handlers = array_filter(
				$handlers,
				function ( HandlerInterface $handler ) {
					return \is_a( $handler, RunnableInterface::class );
				}
			);

			foreach ( $handlers as $handler ) {
				$result = $handler->run();
				if ( ! \is_null( $result ) ) {
					$this->run_result = $result;
					break;
				}
			}

			$this->is_run = \is_null( $this->run_result );
			if ( $this->run_result instanceof RunFailureException ) {
				$this->log_event_and_finalize( $this->run_result->getMessage(), array(), LogLevel::ERROR, 'framework' );
			}

			if ( Objects::has_trait_deep( ResettableTrait::class, $this ) ) {
				$this->is_reset     = null;
				$this->reset_result = null;
			}
		} else {
			return $this->log_event( 'The service has been run already.', array(), 'framework' )
						->set_log_level( LogLevel::NOTICE )->doing_it_wrong( __FUNCTION__, '1.0.0' )
						->return_exception( RunFailureException::class )->finalize();
		}

		return $this->run_result;
	}

	// endregion
}

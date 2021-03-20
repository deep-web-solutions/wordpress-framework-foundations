<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResettableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableTrait;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\HandlerServiceInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\MultiHandlerServiceInterface;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use Psr\Log\LogLevel;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of a resettable handler(s) service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services\Actions
 */
trait ResettableHandlerServiceTrait {
	// region TRAITS

	use ResettableTrait;

	// endregion

	// region METHODS

	/**
	 * Execute the reset logic of runnable handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function reset(): ?ResetFailureException {
		if ( ! \is_a( $this, HandlerServiceInterface::class ) && ! \is_a( $this, MultiHandlerServiceInterface::class ) ) {
			return new ResetFailureException( \sprintf( '%s can only be used in handler service instances', __TRAIT__ ) );
		}

		if ( \is_null( $this->is_reset ) ) {
			$this->reset_result = null;

			$handlers = ( $this instanceof HandlerServiceInterface ) ? (array) $this->get_handler() : $this->get_handlers();
			$handlers = array_filter(
				$handlers,
				function ( HandlerInterface $handler ) {
					return \is_a( $handler, ResettableInterface::class );
				}
			);

			foreach ( $handlers as $handler ) {
				$result = $handler->reset();
				if ( ! \is_null( $result ) ) {
					$this->reset_result = $result;
					break;
				}
			}

			$this->is_reset = \is_null( $this->reset_result );
			if ( $this->reset_result instanceof ResetFailureException ) {
				$this->log_event_and_finalize( $this->reset_result->getMessage(), array(), LogLevel::ERROR, 'framework' );
			}

			if ( Objects::has_trait_deep( RunnableTrait::class, $this ) ) {
				$this->is_run     = null;
				$this->run_result = null;
			}
		} else {
			return $this->log_event( 'The service has been reset already.', array(), 'framework' )
						->set_log_level( LogLevel::NOTICE )->doing_it_wrong( __FUNCTION__, '1.0.0' )
						->return_exception( ResetFailureException::class )->finalize();
		}

		return $this->reset_result;
	}

	// endregion
}

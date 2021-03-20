<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Services\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputtableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\OutputtableInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Services\HandlerServiceInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Services\MultiHandlerServiceInterface;
use Psr\Log\LogLevel;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of an outputtable handler(s) service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Services\Actions
 */
trait OutputtableHandlerServiceTrait {
	// region TRAITS

	use OutputtableTrait;

	// endregion

	// region METHODS

	/**
	 * Execute the output logic of runnable handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function output(): ?OutputFailureException {
		if ( ! \is_a( $this, HandlerServiceInterface::class ) && ! \is_a( $this, MultiHandlerServiceInterface::class ) ) {
			return new OutputFailureException( \sprintf( '%s can only be used in handler service instances', __TRAIT__ ) );
		}

		if ( \is_null( $this->is_outputted ) ) {
			$this->output_result = null;

			$handlers = ( $this instanceof HandlerServiceInterface ) ? (array) $this->get_handler() : $this->get_handlers();
			$handlers = array_filter(
				$handlers,
				function ( HandlerInterface $handler ) {
					return \is_a( $handler, OutputtableInterface::class );
				}
			);

			foreach ( $handlers as $handler ) {
				$result = $handler->output();
				if ( ! \is_null( $result ) ) {
					$this->output_result = $result;
					break;
				}
			}

			$this->is_outputted = \is_null( $this->output_result );
			if ( $this->output_result instanceof OutputFailureException ) {
				$this->log_event_and_finalize( $this->output_result->getMessage(), array(), LogLevel::ERROR, 'framework' );
			}
		} else {
			return $this->log_event( 'The service has been outputted already.', array(), 'framework' )
						->set_log_level( LogLevel::NOTICE )->doing_it_wrong( __FUNCTION__, '1.0.0' )
						->return_exception( OutputFailureException::class )->finalize();
		}

		return $this->run_result;
	}

	// endregion
}

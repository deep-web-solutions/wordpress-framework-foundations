<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Handlers\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputtableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\Actions\OutputtableInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\MultiHandlerAwareInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Output extension trait for outputting handlers in the same-go.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Handlers\Actions
 */
trait OutputHandlersTrait {
	// region TRAITS

	use OutputtableExtensionTrait;

	// endregion

	// region METHODS

	/**
	 * Makes one's own successful output dependent on that of one's handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  OutputFailureException|null
	 */
	public function output_handlers(): ?OutputFailureException {
		$output_result = null;

		if ( $this instanceof HandlerAwareInterface || $this instanceof MultiHandlerAwareInterface ) {
			$handlers = ( $this instanceof HandlerAwareInterface ) ? array( $this->get_handler() ) : $this->get_handlers();
			$handlers = \array_filter(
				$handlers,
				function ( HandlerInterface $handler ) {
					return \is_a( $handler, OutputtableInterface::class );
				}
			);

			foreach ( $handlers as $handler ) {
				$output_result = $handler->output();
				if ( ! \is_null( $output_result ) ) {
					break;
				}
			}
		}

		return $output_result;
	}

	// endregion
}

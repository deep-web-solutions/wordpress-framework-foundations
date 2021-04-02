<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Handlers\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\MultiHandlerAwareInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Run extension trait for running handlers in the same-go.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Handlers\Actions
 */
trait RunHandlersTrait {
	// region TRAITS

	use RunnableExtensionTrait;

	// endregion

	// region METHODS

	/**
	 * Makes one's own successful run dependent on that of one's handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  RunFailureException|null
	 */
	public function run_handlers(): ?RunFailureException {
		$run_result = null;

		if ( $this instanceof HandlerAwareInterface || $this instanceof MultiHandlerAwareInterface ) {
			$handlers = ( $this instanceof HandlerAwareInterface ) ? array( $this->get_handler() ) : $this->get_handlers();
			$handlers = \array_filter(
				$handlers,
				function ( HandlerInterface $handler ) {
					return \is_a( $handler, RunnableInterface::class );
				}
			);

			foreach ( $handlers as $handler ) {
				$run_result = $handler->run();
				if ( ! \is_null( $run_result ) ) {
					break;
				}
			}
		}

		return $run_result;
	}

	// endregion
}

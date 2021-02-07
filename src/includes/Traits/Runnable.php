<?php

namespace DeepWebSolutions\Framework\Utilities\Traits;

use DeepWebSolutions\Framework\Core\Abstracts\PluginBase;
use DeepWebSolutions\Framework\Utilities\Interfaces\Runnable as IRunnable;

/**
 * Handles the registration of the runnable object with the executing plugin auto-magically on construction.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Traits
 */
trait Runnable {
	/**
	 * Runnable constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginBase      $plugin     Instance of the current plugin.
	 */
	public function __construct( PluginBase $plugin ) {
		if ( $this instanceof IRunnable ) {
			$plugin->register_runnable( $this );
		}
	}
}

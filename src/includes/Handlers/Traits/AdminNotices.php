<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Utilities\Handlers\AdminNoticesHandler;
use DeepWebSolutions\Framework\Utilities\Interfaces\Identifiable;
use DeepWebSolutions\Framework\Utilities\Interfaces\Pluginable;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the admin notices handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait AdminNotices {
	/**
	 * Using classes should define their admin notices in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler      Instance of the admin notices handler.
	 */
	abstract protected function register_admin_notices( AdminNoticesHandler $admin_notices_handler ): void;

	/**
	 * Returns a name for the notice-registering object, as descriptive as possible.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler      Instance of the admin notices handler.
	 *
	 * @return  string
	 */
	protected function get_registrant_name( AdminNoticesHandler $admin_notices_handler ): string {
		$plugin_name = $admin_notices_handler->get_plugin()->get_plugin_name();

		return ( $this instanceof Identifiable )
			? sprintf( '%s: %s', $plugin_name, $this->get_instance_public_name() )
			: $plugin_name;
	}

	/**
	 * Returns a meaningful, hopefully unique, ID for a notice.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   The actual descriptor of the notice's purpose.
	 * @param   array   $extra  Further descriptors of the notice's purpose.
	 * @param   string  $root   Prepended to all notice IDs inside the same class.
	 *
	 * @return  string
	 */
	public function get_notice_id( string $name, array $extra = array(), string $root = '' ): string {
		if ( $this instanceof Identifiable ) {
			$notice_id = array( $this->get_plugin()->get_plugin_slug(), $root ?: $this->get_instance_public_name(), $name ); // phpcs:ignore
		} elseif ( $this instanceof Pluginable ) {
			$notice_id = array( $this->get_plugin_slug(), $root, $name );
		} else {
			$notice_id = array( $root, $name );
		}

		return str_replace(
			array( ' ', '/', '\\' ),
			array( '-', '', '_' ),
			strtolower(
				join(
					'_',
					array_filter(
						array_merge(
							$notice_id,
							$extra
						)
					)
				)
			)
		);
	}
}

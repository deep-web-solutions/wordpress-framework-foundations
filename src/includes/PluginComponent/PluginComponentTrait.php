<?php

namespace DeepWebSolutions\Framework\Foundations\PluginComponent;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareTrait;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the plugin component interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginComponent
 */
trait PluginComponentTrait {
	// region TRAITS

	use PluginAwareTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * The unique persistent ID of the using class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $component_id;

	/**
	 * The public name of the using class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $component_name;

	// endregion

	// region GETTERS

	/**
	 * Gets the ID of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_id(): string {
		return $this->component_id;
	}

	/**
	 * Gets the public name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_name(): string {
		return $this->component_name;
	}

	// endregion

	// region SETTERS

	/**
	 * Set the ID of the current class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $component_id   The value to be set.
	 */
	public function set_id( string $component_id ) {
		$this->component_id = $component_id;
	}

	/**
	 * Set the public name of the current class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $component_name     The value to be set.
	 */
	public function set_name( string $component_name ) {
		$this->component_name = $component_name;
	}

	// endregion

	// region HELPERS

	/**
	 * Gets a PHP-friendly version of the public name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_safe_name(): string {
		$ascii_name = \filter_var( $this->get_name(), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH );

		if ( $this->get_name() !== $ascii_name && \extension_loaded( 'iconv' ) && \seems_utf8( $ascii_name ) ) {
			try {
				$ascii_name = \iconv( 'UTF-8', 'ASCII//TRANSLIT//IGNORE', $this->get_name() );
			} catch ( \Exception $error ) { // phpcs:ignore
				/* do nothing */
			}
		}

		return Strings::to_safe_string(
			$ascii_name,
			array(
				'-' => '_',
				' ' => '_',
			)
		);
	}

	// endregion
}

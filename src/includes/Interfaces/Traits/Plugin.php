<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Pluginable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Plugin {
	// region FIELDS AND CONSTANTS

	/**
	 * The human-readable name of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @access      protected
	 * @var         string
	 */
	protected string $plugin_name;

	/**
	 * The current version of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @access      protected
	 * @var         string
	 */
	protected string $plugin_version;

	/**
	 * The name of the plugin's author as set by the mandatory WP plugin header.
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @access      protected
	 * @var         string
	 */
	protected string $plugin_author_name;

	/**
	 * The URI of the plugin's author as set by the mandatory WP plugin header.
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @access      protected
	 * @var         string
	 */
	protected string $plugin_author_uri;

	/**
	 * The description of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @access      protected
	 * @var         string
	 */
	protected string $plugin_description;

	/**
	 * The language domain of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $plugin_language_domain;

	/**
	 * The slug of the plugin as deduced from the installation path.
	 *
	 * @since       1.0.0
	 * @version     1.0.0
	 *
	 * @access      protected
	 * @var         string
	 */
	protected string $plugin_slug;

	// endregion

	// region GETTERS

	/**
	 * Gets the name of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_name(): string {
		return $this->plugin_name;
	}

	/**
	 * Gets the (hopefully) semantic version of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_version(): string {
		return $this->plugin_version;
	}

	/**
	 * Gets the name of the plugin's author as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_author_name(): string {
		return $this->plugin_author_name;
	}

	/**
	 * Gets the URI of the plugin's author as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_author_uri(): string {
		return $this->plugin_author_uri;
	}

	/**
	 * Gets the description of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_description(): string {
		return $this->plugin_description;
	}

	/**
	 * Gets the language domain of the plugin as set by the mandatory WP plugin header.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_language_domain(): string {
		return $this->plugin_language_domain;
	}

	/**
	 * Gets the slug of the plugin as deduced from the installation path.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_slug(): string {
		return $this->plugin_slug;
	}

	/**
	 * Converts the potentially unsafe plugin's slug to a PHP-friendlier version.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_safe_slug(): string {
		return strtolower( str_replace( '-', '_', $this->get_plugin_slug() ) );
	}

	// endregion

	// region SETTERS

	/**
	 * Using classes should use this to set the plugin data.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function set_plugin_data(): void;

	// endregion
}

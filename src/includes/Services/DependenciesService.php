<?php

namespace DeepWebSolutions\Framework\Utilities\Services;

use DeepWebSolutions\Framework\Helpers\PHP\Misc;
use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Filesystem;
use Symfony\Component\Uid\Ulid;

defined( 'ABSPATH' ) || exit;

/**
 * Checks a specific set of dependencies against the current environment.
 *
 * @see     https://github.com/skyverge/wc-plugin-framework/blob/de7f429af153a17a0fd84cf9a1c56c6ac5ffbc08/woocommerce/class-sv-wc-plugin-dependencies.php
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Services
 */
class DependenciesService {
	use Filesystem;

	// region FIELDS AND CONSTANTS

	/**
	 * List of PHP extensions that must be present for identifiable to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string[]
	 */
	protected array $php_extensions = array();

	/**
	 * List of PHP functions that must be present for identifiable to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string[]
	 */
	protected array $php_functions = array();

	/**
	 * List of PHP settings that must be present for identifiable to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string[]
	 */
	protected array $php_settings = array();

	/**
	 * List of WP plugins that must be present and active for identifiable to setup.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string[]
	 */
	protected array $active_plugins = array();

	/**
	 * A universally unique lexicographically sortable identifier for the current instance. Useful to cache
	 * the results of the checks.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $ulid;

	/**
	 * Whether the set dependencies are fulfilled or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     array|null
	 */
	protected ?array $dependencies_status = null;

	// endregion

	// region MAGIC METHODS

	/**
	 * DependenciesChecker constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array           $configuration      Dependencies configuration.
	 */
	public function __construct( array $configuration ) {
		$this->php_extensions = $configuration['php_extensions'] ?? array();
		$this->php_functions  = $configuration['php_functions'] ?? array();
		$this->php_settings   = $configuration['php_settings'] ?? array();
		$this->active_plugins = $configuration['active_plugins'] ?? array();

		$this->ulid = ( new Ulid() )->toBase32();
	}

	// endregion

	// region METHODS

	/**
	 * Returns whether the dependencies are fulfilled or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	public function get_dependencies_status(): array {
		if ( is_null( $this->dependencies_status ) ) {
			$this->dependencies_status = array(
				'php_extensions' => array(
					'required' => empty( $this->get_missing_php_extensions( 'required' ) ),
					'optional' => empty( $this->get_missing_php_extensions( 'optional' ) ),
				),
				'php_functions'  => array(
					'required' => empty( $this->get_missing_php_functions( 'required' ) ),
					'optional' => empty( $this->get_missing_php_functions( 'optional' ) ),
				),
				'php_settings'   => array(
					'required' => empty( $this->get_incompatible_php_settings( 'required' ) ),
					'optional' => empty( $this->get_incompatible_php_settings( 'optional' ) ),
				),
				'active_plugins' => array(
					'required' => empty( $this->get_missing_active_plugins( 'required' ) ),
					'optional' => empty( $this->get_missing_active_plugins( 'optional' ) ),
				),
			);
		}

		return $this->dependencies_status;
	}

	/**
	 * Returns a list of missing PHP extensions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  array
	 */
	public function get_missing_php_extensions( string $type ): array {
		static $missing_php_extensions = array();

		if ( ! isset( $missing_php_extensions[ $this->ulid ][ $type ] ) ) {
			$missing_php_extensions[ $this->ulid ][ $type ] = array_filter(
				array_map(
					function( $php_extension ) {
						return extension_loaded( $php_extension ) ? false : $php_extension;
					},
					$this->get_php_extensions( $type )
				)
			);
		}

		return $missing_php_extensions[ $this->ulid ][ $type ];
	}

	/**
	 * Returns a list of missing PHP function.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  array
	 */
	public function get_missing_php_functions( string $type ): array {
		static $missing_php_functions = array();

		if ( ! isset( $missing_php_functions[ $this->ulid ][ $type ] ) ) {
			$missing_php_functions[ $this->ulid ][ $type ] = array_filter(
				array_map(
					function( $php_function ) {
						return function_exists( $php_function ) ? false : $php_function;
					},
					$this->get_php_functions( $type )
				)
			);
		}

		return $missing_php_functions[ $this->ulid ][ $type ];
	}

	/**
	 * Returns a list of incompatible PHP settings.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  array
	 */
	public function get_incompatible_php_settings( string $type ): array {
		static $incompatible_settings = array();

		if ( ! isset( $incompatible_settings[ $this->ulid ][ $type ] ) ) {
			$incompatible_settings[ $this->ulid ][ $type ] = array();

			if ( function_exists( 'ini_get' ) ) {
				foreach ( $this->get_php_settings( $type ) as $php_setting => $expected_value ) {
					$environment_value = ini_get( $php_setting );
					if ( empty( $environment_value ) ) {
						continue;
					}

					if ( is_int( $expected_value ) ) {
						$is_size                  = ! is_numeric( substr( $environment_value, -1 ) );
						$environment_value_actual = $is_size ? Misc::let_to_num( $environment_value ) : $environment_value;

						if ( $environment_value_actual < $expected_value ) {
							$incompatible_settings[ $this->ulid ][ $type ][ $php_setting ] = array(
								'expected'    => $is_size ? size_format( $expected_value ) : $expected_value,
								'environment' => $is_size ? size_format( $environment_value_actual ) : $environment_value_actual,
								'type'        => 'min',
							);
						}
					} elseif ( $environment_value !== $expected_value ) {
						$incompatible_settings[ $this->ulid ][ $type ][ $php_setting ] = array(
							'expected'    => $expected_value,
							'environment' => $environment_value,
						);
					}
				}
			}
		}

		return $incompatible_settings[ $this->ulid ][ $type ];
	}

	/**
	 * Returns a list of missing active plugins.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  array
	 */
	public function get_missing_active_plugins( string $type ): array {
		static $missing_plugins = array();

		if ( ! isset( $missing_plugins[ $this->ulid ][ $type ] ) ) {
			$missing_plugins[ $this->ulid ][ $type ] = array();

			foreach ( $this->get_active_plugins( $type ) as $active_plugin => $active_plugin_config ) {
				if ( isset( $active_plugin_config['active_checker'] ) && is_callable( $active_plugin_config['active_checker'] ) ) {
					$is_active = boolval( call_user_func( $active_plugin_config['active_checker'] ) );
				} else {
					$is_active = in_array( $active_plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ); // phpcs:ignore
					if ( is_multisite() && ! $is_active ) {
						$is_active = isset( get_site_option( 'active_sitewide_plugins', array() )[ $active_plugin ] );
					}
				}

				if ( ! $is_active ) {
					$missing_plugins[ $this->ulid ][ $type ][ $active_plugin ] = $active_plugin_config;
				} elseif ( isset( $active_plugin_config['min_version'] ) ) {
					if ( isset( $active_plugin_config['version_checker'] ) && is_callable( $active_plugin_config['version_checker'] ) ) {
						$version = call_user_func( $active_plugin_config['version_checker'] );
					} else {
						$wp_filesystem = $this->get_wp_filesystem();
						$version       = '0.0.0';

						if ( $wp_filesystem ) {
							$plugin_data = get_file_data( trailingslashit( $wp_filesystem->wp_plugins_dir() ) . $active_plugin, array( 'Version' => 'Version' ) );
							if ( isset( $plugin_data['Version'] ) ) {
								$version = $plugin_data['Version'];
							}
						}
					}

					if ( version_compare( $active_plugin_config['min_version'], $version, '>' ) ) {
						$missing_plugins[ $this->ulid ][ $type ][ $active_plugin ] = $active_plugin_config + array( 'version' => $version );
					}
				}
			}
		}

		return $missing_plugins[ $this->ulid ][ $type ];
	}

	// endregion

	// region GETTERS

	/**
	 * Returns the list of dependent PHP extensions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  string[]
	 */
	public function get_php_extensions( string $type ): array {
		return $this->php_extensions[ $type ];
	}

	/**
	 * Returns the list of dependent PHP functions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  string[]
	 */
	public function get_php_functions( string $type ): array {
		return $this->php_functions[ $type ];
	}

	/**
	 * Returns the list of dependent PHP settings.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  string[]
	 */
	public function get_php_settings( string $type ): array {
		return $this->php_settings[ $type ];
	}

	/**
	 * Returns the list of dependent active plugins.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $type   Type of PHP settings to check for. Possible values are 'required' and 'optional'.
	 *
	 * @return  array
	 */
	public function get_active_plugins( string $type ): array {
		return $this->active_plugins[ $type ];
	}

	// endregion
}

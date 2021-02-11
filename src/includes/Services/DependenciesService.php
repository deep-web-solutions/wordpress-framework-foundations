<?php

namespace DeepWebSolutions\Framework\Utilities\Services;

use DeepWebSolutions\Framework\Helpers\PHP\Misc;
use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Filesystem;
use DeepWebSolutions\Framework\Utilities\Handlers\AdminNoticesHandler;
use DeepWebSolutions\Framework\Utilities\Handlers\Traits\AdminNotices;
use DeepWebSolutions\Framework\Utilities\Interfaces\Identifiable;
use DeepWebSolutions\Framework\Utilities\Interfaces\Pluginable;

defined( 'ABSPATH' ) || exit;

/**
 * Checks a specific set of dependencies against the current environment.
 *
 * @see     https://github.com/skyverge/wc-plugin-framework/blob/de7f429af153a17a0fd84cf9a1c56c6ac5ffbc08/woocommerce/class-sv-wc-plugin-dependencies.php
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Services
 */
class DependenciesService {
	use Filesystem;
	use AdminNotices;

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
	 * Whether the set dependencies are fulfilled or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $are_dependencies_fulfilled = null;

	/**
	 * The identifiable instance having these dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     Identifiable
	 */
	protected Identifiable $identifiable;

	// endregion

	// region MAGIC METHODS

	/**
	 * DependenciesChecker constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   Identifiable    $identifiable       The identifiable the dependencies are checked for.
	 * @param   array           $configuration      Dependencies configuration.
	 */
	public function __construct( Identifiable $identifiable, array $configuration ) {
		$this->identifiable = $identifiable;

		$this->php_extensions = $configuration['php_extensions'] ?? array();
		$this->php_functions  = $configuration['php_functions'] ?? array();
		$this->php_settings   = $configuration['php_settings'] ?? array();
		$this->active_plugins = $configuration['active_plugins'] ?? array();
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Checks whether the dependencies are fulfilled or not and registers admin notices accordingly.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler      Instance of the admin notices handler to register notices with.
	 */
	protected function register_admin_notices( AdminNoticesHandler $admin_notices_handler ): void {
		// Start by assuming that the dependencies are fulfilled.
		$this->are_dependencies_fulfilled = true;

		// Check whether all required PHP extensions are present.
		$missing_php_extensions = $this->get_missing_php_extensions();
		if ( ! empty( $missing_php_extensions ) ) {
			$this->are_dependencies_fulfilled = false;

			$admin_notices_handler->add_admin_notice(
				sprintf(
					/* translators: 1. Plugin or identifiable name, 2. Comma-separated list of missing PHP extensions. */
					_n(
						'<strong>%1$s</strong> requires the %2$s PHP extension to function. Contact your host or server administrator to install and configure the missing extension.',
						'<strong>%1$s</strong> requires the following PHP extensions to function: %2$s. Contact your host or server administrator to install and configure the missing extensions.',
						count( $missing_php_extensions ),
						'dws-wp-framework-utilities'
					),
					esc_html( $this->get_identifiable_name() ),
					'<strong>' . implode( ', ', $missing_php_extensions ) . '</strong>'
				),
				'dws-missing-extensions-' . $this->identifiable->get_instance_id(),
				array(
					'capability'  => 'activate_plugins',
					'dismissible' => false,
				)
			);
		}

		// Check whether all required PHP functions are present.
		$missing_php_functions = $this->get_missing_php_functions();
		if ( ! empty( $missing_php_functions ) ) {
			$this->are_dependencies_fulfilled = false;

			$admin_notices_handler->add_admin_notice(
				sprintf(
					/* translators: 1. Plugin name or identifiable name, 2. Comma-separated list of missing PHP functions. */
					_n(
						'<strong>%1$s</strong> requires the %2$s PHP function to exist. Contact your host or server administrator to install and configure the missing function.',
						'<strong>%1$s</strong> requires the following PHP functions to exist: %2$s. Contact your host or server administrator to install and configure the missing functions.',
						count( $missing_php_functions ),
						'dws-wp-framework-utilities'
					),
					esc_html( $this->get_identifiable_name() ),
					'<strong>' . implode( ', ', $missing_php_functions ) . '</strong>'
				),
				'dws-missing-functions-' . $this->identifiable->get_instance_id(),
				array(
					'capability'  => 'activate_plugins',
					'dismissible' => false,
				)
			);
		}

		// Check whether all PHP settings are compatible with the requirements.
		$incompatible_php_settings = $this->get_incompatible_php_settings();
		if ( ! empty( $incompatible_php_settings ) ) {
			// PHP settings work differently as far as dependencies go. Namely, the plugin/identifiable will NOT run if an issue is detected,
			// but a user with appropriate permission levels (probably whoever activates the plugin the first time around) may dismiss the shown notice
			// and if that happens, the plugin will ignore the limitations and run anyway. So it's more of a soft-warning than a hard-error.
			$notice_id                        = 'dws-incompatible-php-settings-' . $this->identifiable->get_instance_id() . '-' . md5( wp_json_encode( $incompatible_php_settings ) );
			$this->are_dependencies_fulfilled = $this->are_dependencies_fulfilled && $admin_notices_handler->is_notice_dismissed( $notice_id, true );

			if ( false === $this->are_dependencies_fulfilled ) {
				$message = sprintf(
					/* translators: Plugin name or identifiable name. */
					__( '<strong>%s</strong> may behave unexpectedly because the following PHP configuration settings are expected:', 'dws-wp-framework-utilities' ),
					esc_html( $this->get_identifiable_name() )
				) . '<ul>';

				foreach ( $incompatible_php_settings as $setting => $values ) {
					$setting_message = "<code>{$setting} = {$values['expected']}</code>";
					if ( ! empty( $values['type'] ) ) {
						switch ( $values['type'] ) {
							case 'min':
								$setting_message = sprintf(
								/* translators: PHP settings value. */
									__( '%s or higher', 'dws-wp-framework-utilities' ),
									$setting_message
								);
						}
					}

					$message .= "<li>{$setting_message}</li>";
				}

				$message .= '</ul>' . __( 'Please contact your hosting provider or server administrator to configure these settings. If you dismiss this notice, the plugin will attempt to run despite this warning.', 'dws-wp-framework-utilities' );

				$admin_notices_handler->add_global_admin_notice(
					$message,
					$notice_id,
					array(
						'capability' => 'activate_plugins',
					)
				);
			}
		}

		// Check whether all required plugins are installed and active.
		$missing_active_plugins = $this->get_missing_active_plugins();
		if ( ! empty( $missing_active_plugins ) ) {
			$this->are_dependencies_fulfilled = false;

			$admin_notices_handler->add_admin_notice(
				sprintf(
					/* translators: 1. Plugin name or identifiable name, 2. Comma-separated list of missing active plugins. */
					_n(
						'<strong>%1$s</strong> requires the %2$s plugin to be installed and active. Please install and activate the plugin first.',
						'<strong>%1$s</strong> requires the following plugins to be installed and active: %2$s. Please install and activate these plugins first.',
						count( $missing_active_plugins ),
						'dws-wp-framework-utilities'
					),
					esc_html( $this->get_identifiable_name() ),
					'<strong>' . $this->format_plugins_list( $missing_active_plugins ) . '</strong>'
				),
				'dws-missing-or-inactive-plugins-' . $this->identifiable->get_instance_id(),
				array(
					'capability'  => 'activate_plugins',
					'dismissible' => false,
				)
			);
		}
	}

	// endregion

	// region METHODS

	/**
	 * Returns whether the dependencies are fulfilled or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler  Instance of the admin notices handler to register notices with.
	 *
	 * @return  bool
	 */
	public function are_dependencies_fulfilled( AdminNoticesHandler $admin_notices_handler ): bool {
		if ( is_null( $this->are_dependencies_fulfilled ) ) {
			$this->register_admin_notices( $admin_notices_handler );
		}

		return $this->are_dependencies_fulfilled;
	}

	/**
	 * Returns a list of missing PHP extensions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	public function get_missing_php_extensions(): array {
		return array_filter(
			array_map(
				function( $dependent_php_extension ) {
					return extension_loaded( $dependent_php_extension ) ? false : $dependent_php_extension;
				},
				$this->get_dependent_php_extensions()
			)
		);
	}

	/**
	 * Returns a list of missing PHP function.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	public function get_missing_php_functions(): array {
		return array_filter(
			array_map(
				function( $dependent_php_function ) {
					return function_exists( $dependent_php_function ) ? false : $dependent_php_function;
				},
				$this->get_dependent_php_functions()
			)
		);
	}

	/**
	 * Returns a list of incompatible PHP settings.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	public function get_incompatible_php_settings(): array {
		$incompatible_settings = array();

		if ( function_exists( 'ini_get' ) ) {
			foreach ( $this->get_dependent_php_settings() as $php_setting => $expected_value ) {
				$environment_value = ini_get( $php_setting );
				if ( empty( $environment_value ) ) {
					continue;
				}

				if ( is_int( $expected_value ) ) {
					$is_size                  = ! is_numeric( substr( $environment_value, -1 ) );
					$environment_value_actual = $is_size ? Misc::let_to_num( $environment_value ) : $environment_value;

					if ( $environment_value_actual < $expected_value ) {
						$incompatible_settings[ $php_setting ] = array(
							'expected'    => $is_size ? size_format( $expected_value ) : $expected_value,
							'environment' => $is_size ? size_format( $environment_value_actual ) : $environment_value_actual,
							'type'        => 'min',
						);
					}
				} elseif ( $environment_value !== $expected_value ) {
					$incompatible_settings[ $php_setting ] = array(
						'expected'    => $expected_value,
						'environment' => $environment_value,
					);
				}
			}
		}

		return $incompatible_settings;
	}

	/**
	 * Returns a list of missing active plugins.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	public function get_missing_active_plugins(): array {
		$missing_plugins = array();

		foreach ( $this->get_dependent_active_plugins() as $dependent_active_plugin => $dependent_active_plugin_config ) {
			if ( isset( $dependent_active_plugin_config['active_checker'] ) && is_callable( $dependent_active_plugin_config['active_checker'] ) ) {
				$is_active = boolval( call_user_func( $dependent_active_plugin_config['active_checker'] ) );
			} else {
				$is_active = in_array( $dependent_active_plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ); // phpcs:ignore
				if ( is_multisite() && ! $is_active ) {
					$is_active = isset( get_site_option( 'active_sitewide_plugins', array() )[ $dependent_active_plugin ] );
				}
			}

			if ( ! $is_active ) {
				$missing_plugins[ $dependent_active_plugin ] = $dependent_active_plugin_config;
			} elseif ( isset( $dependent_active_plugin_config['min_version'] ) ) {
				if ( isset( $dependent_active_plugin_config['version_checker'] ) && is_callable( $dependent_active_plugin_config['version_checker'] ) ) {
					$version = call_user_func( $dependent_active_plugin_config['version_checker'] );
				} else {
					$wp_filesystem = $this->get_wp_filesystem();
					$version       = '0.0.0';

					if ( $wp_filesystem ) {
						$plugin_data = get_file_data( trailingslashit( $wp_filesystem->wp_plugins_dir() ) . $dependent_active_plugin, array( 'Version' => 'Version' ) );
						if ( isset( $plugin_data['Version'] ) ) {
							$version = $plugin_data['Version'];
						}
					}
				}

				if ( version_compare( $dependent_active_plugin_config['min_version'], $version, '>' ) ) {
					$missing_plugins[ $dependent_active_plugin ] = $dependent_active_plugin_config + array( 'version' => $version );
				}
			}
		}

		return $missing_plugins;
	}

	// endregion

	// region GETTERS

	/**
	 * Returns the list of dependent PHP extensions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string[]
	 */
	public function get_dependent_php_extensions(): array {
		return $this->php_extensions;
	}

	/**
	 * Returns the list of dependent PHP functions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string[]
	 */
	public function get_dependent_php_functions(): array {
		return $this->php_functions;
	}

	/**
	 * Returns the list of dependent PHP settings.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string[]
	 */
	public function get_dependent_php_settings(): array {
		return $this->php_settings;
	}

	/**
	 * Returns the list of dependent active plugins.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	public function get_dependent_active_plugins(): array {
		return $this->active_plugins;
	}

	// endregion

	// region HELPERS

	/**
	 * Returns the name of the identifiable as it should appear in dependency admin notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	protected function get_identifiable_name(): string {
		$plugin_name = $this->identifiable->get_plugin()->get_plugin_name();

		return ( $this->identifiable instanceof Pluginable )
			? $plugin_name
			: sprintf( '%s: %s', $plugin_name, $this->identifiable->get_instance_public_name() );
	}

	/**
	 * Formats the list of missing plugin dependencies in a human-friendly way.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $missing_plugins    List of missing plugin dependencies.
	 *
	 * @return  string
	 */
	protected function format_plugins_list( array $missing_plugins ): string {
		$formatted_plugin_names = array();

		foreach ( $missing_plugins as $missing_plugin ) {
			$formatted_plugin_name = $missing_plugin['name'];

			if ( isset( $missing_plugin['min_version'] ) ) {
				$formatted_plugin_name .= " {$missing_plugin['min_version']}+";
			}

			if ( isset( $missing_plugin['version'] ) ) {
				$formatted_version = sprintf(
					/* translators: %s: Installed version of the dependant plugin */
					__( 'You\'re running version %s', 'dws-wp-framework-utilities' ),
					$missing_plugin['version']
				);
				$formatted_plugin_name .= '<em>(' . esc_html( $formatted_version ) . ')</em>';
			}

			$formatted_plugin_names[] = $formatted_plugin_name;
		}

		return join( ', ', $formatted_plugin_names );
	}

	// endregion
}

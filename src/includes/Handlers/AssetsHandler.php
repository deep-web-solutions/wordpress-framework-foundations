<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers;

use DeepWebSolutions\Framework\Helpers\PHP\Files;
use DeepWebSolutions\Framework\Helpers\WordPress\Assets as AssetsHelpers;
use DeepWebSolutions\Framework\Helpers\WordPress\Requests;
use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Filesystem;
use DeepWebSolutions\Framework\Utilities\Handlers\Traits\Hooks;
use DeepWebSolutions\Framework\Utilities\Interfaces\Runnable;

defined( 'ABSPATH' ) || exit;


/**
 * Compatibility layer between the framework and WordPress' API for assets.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers
 */
class AssetsHandler implements Runnable {
	use Filesystem;
	use Hooks;

	// region FIELDS

	/**
	 * The styles to be registered with WordPress when the handler runs.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     array       $styles
	 */
	protected array $styles = array();

	/**
	 * The scripts to be registered with WordPress when the handler runs.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     array       $scripts
	 */
	protected array $scripts = array();

	// endregion

	// region MAGIC METHODS

	/**
	 * AssetsHandler constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HooksHandler    $hooks_handler      Instance of the hooks handler.
	 */
	public function __construct( HooksHandler $hooks_handler ) {
		$this->reset();
		$this->register_hooks( $hooks_handler );
	}

	// endregion

	// region INHERITED FUNCTIONS

	/**
	 * Register hooks with the hooks handler.
	 *
	 * @param   HooksHandler    $hooks_handler      Instance of the hooks handler.
	 *
	 * @version 1.0.0
	 *
	 * @see     Hooks::register_hooks()
	 *
	 * @since   1.0.0
	 */
	protected function register_hooks( HooksHandler $hooks_handler ): void {
		if ( Requests::is_request( Requests::FRONTEND_REQUEST ) ) {
			// Register assets on public side of the website.
			$hooks_handler->add_action( 'wp_enqueue_scripts', $this, 'run', PHP_INT_MAX );
		} elseif ( Requests::is_request( Requests::ADMIN_REQUEST ) ) {
			// Register assets on the admin-side of the website.
			$hooks_handler->add_action( 'admin_enqueue_scripts', $this, 'run', PHP_INT_MAX );
		}
	}

	/**
	 * Registers and enqueues the styles and scripts with WordPress.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function run(): void {
		$this->styles = Requests::is_request( Requests::FRONTEND_REQUEST ) ? $this->styles['public'] : $this->styles['admin'];
		foreach ( $this->styles as $styles ) {
			foreach ( $styles['register'] as $style ) {
				wp_register_style(
					$style['handle'],
					$style['src'],
					$style['deps'],
					$style['ver'],
					$style['media'],
				);
			}
			foreach ( $styles['enqueue'] as $style ) {
				wp_enqueue_style(
					$style['handle'],
					$style['src'],
					$style['deps'],
					$style['ver'],
					$style['media'],
				);
			}
		}

		$this->scripts = Requests::is_request( Requests::FRONTEND_REQUEST ) ? $this->scripts['public'] : $this->scripts['admin'];
		foreach ( $this->scripts as $scripts ) {
			foreach ( $scripts['register'] as $script ) {
				wp_register_script(
					$script['handle'],
					$script['src'],
					$script['deps'],
					$script['ver'],
					$script['in_footer'],
				);
			}
			foreach ( $scripts['enqueue'] as $script ) {
				wp_enqueue_script(
					$script['handle'],
					$script['src'],
					$script['deps'],
					$script['ver'],
					$script['in_footer'],
				);
			}
		}
	}

	/**
	 * Sets the handler into a valid state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function reset(): void {
		$this->styles  = array(
			'public' => array(
				'register' => array(),
				'enqueue'  => array(),
			),
			'admin'  => array(
				'register' => array(),
				'enqueue'  => array(),
			),
		);
		$this->scripts = array(
			'public' => array(
				'register' => array(),
				'enqueue'  => array(),
			),
			'admin'  => array(
				'register' => array(),
				'enqueue'  => array(),
			),
		);
	}

	// endregion

	// region METHODS

	/**
	 * Registers a public-facing stylesheet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be active at.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function register_public_style( string $handle, string $relative_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->styles['public']['register'] = $this->add_style( $this->styles['public']['register'], $handle, $relative_path, $fallback_version, $deps, $media, $constant_name );
	}

	/**
	 * Removes a style from the list of assets that should be registered publicly.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function deregister_public_style( string $handle ) {
		$this->styles['public']['register'] = $this->remove( $this->styles['public']['register'], $handle );
	}

	/**
	 * Enqueues a public-facing stylesheet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be active at.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function enqueue_public_style( string $handle, string $relative_path = '', string $fallback_version = '', array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->styles['public']['enqueue'] = $this->add_style( $this->styles['public']['enqueue'], $handle, $relative_path, $fallback_version, $deps, $media, $constant_name );
	}

	/**
	 * Removes a style from the list of assets that should be enqueued publicly.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function dequeue_public_style( string $handle ) {
		$this->styles['public']['enqueue'] = $this->remove( $this->styles['public']['enqueue'], $handle );
	}

	/**
	 * Registers an admin-side stylesheet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be active at.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function register_admin_style( string $handle, string $relative_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->styles['admin']['register'] = $this->add_style( $this->styles['admin']['register'], $handle, $relative_path, $fallback_version, $deps, $media, $constant_name );
	}

	/**
	 * Removes a style from the list of assets that should be registered on the admin-side.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function deregister_admin_style( string $handle ) {
		$this->styles['admin']['register'] = $this->remove( $this->styles['admin']['register'], $handle );
	}

	/**
	 * Registers an admin-side stylesheet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media                  The media query that the CSS asset should be active at.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function enqueue_admin_style( string $handle, string $relative_path, string $fallback_version, array $deps = array(), string $media = 'all', string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->styles['admin']['enqueue'] = $this->add_style( $this->styles['admin']['enqueue'], $handle, $relative_path, $fallback_version, $deps, $media, $constant_name );
	}

	/**
	 * Removes a style from the list of assets that should be enqueued on the admin-side.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function dequeue_admin_style( string $handle ) {
		$this->styles['admin']['enqueue'] = $this->remove( $this->styles['admin']['enqueue'], $handle );
	}

	/**
	 * Registers a public-facing script.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer              Whether the script asset should be loaded in the footer or the header of the page.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function register_public_script( string $handle, string $relative_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->scripts['public']['register'] = $this->add_script( $this->scripts['public']['register'], $handle, $relative_path, $fallback_version, $deps, $in_footer, $constant_name );
	}

	/**
	 * Removes a script from the list of assets that should be registered publicly.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function deregister_public_script( string $handle ) {
		$this->scripts['public']['register'] = $this->remove( $this->scripts['public']['register'], $handle );
	}

	/**
	 * Enqueues a public-facing script.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer              Whether the script asset should be loaded in the footer or the header of the page.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function enqueue_public_script( string $handle, string $relative_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->scripts['public']['enqueue'] = $this->add_script( $this->scripts['public']['enqueue'], $handle, $relative_path, $fallback_version, $deps, $in_footer, $constant_name );
	}

	/**
	 * Removes a script from the list of assets that should be enqueued publicly.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function dequeue_public_script( string $handle ) {
		$this->scripts['public']['enqueue'] = $this->remove( $this->scripts['public']['enqueue'], $handle );
	}

	/**
	 * Registers an admin-side script.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer              Whether the script asset should be loaded in the footer or the header of the page.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function register_admin_script( string $handle, string $relative_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->scripts['admin']['register'] = $this->add_script( $this->scripts['admin']['register'], $handle, $relative_path, $fallback_version, $deps, $in_footer, $constant_name );
	}

	/**
	 * Removes a script from the list of assets that should be registered on the admin-side.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function deregister_admin_script( string $handle ) {
		$this->scripts['admin']['register'] = $this->remove( $this->scripts['admin']['register'], $handle );
	}

	/**
	 * Enqueues an admin-side script.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle                 A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path          The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version       The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps                   Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer              Whether the script asset should be loaded in the footer or the header of the page.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 */
	public function enqueue_admin_script( string $handle, string $relative_path, string $fallback_version, array $deps = array(), bool $in_footer = true, string $constant_name = 'SCRIPT_DEBUG' ) {
		$this->scripts['admin']['enqueue'] = $this->add_script( $this->scripts['admin']['enqueue'], $handle, $relative_path, $fallback_version, $deps, $in_footer, $constant_name );
	}

	/**
	 * Removes a script from the list of assets that should be enqueued on the admin-side.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handle     The handle of the asset that should be removed.
	 */
	public function dequeue_admin_script( string $handle ) {
		$this->scripts['admin']['enqueue'] = $this->remove( $this->scripts['admin']['enqueue'], $handle );
	}

	// endregion

	// region HELPERS

	/**
	 * Adds a properly formatted style asset to a list of other style assets.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $assets             Array of style assets to append the new style to.
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   string  $media              The media query that the CSS asset should be active at.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  array
	 */
	protected function add_style( array $assets, string $handle, string $relative_path, string $fallback_version, array $deps, string $media, string $constant_name ): array {
		$wp_filesystem = $this->get_wp_filesystem();

		if ( $wp_filesystem ) {
			$relative_path = $this->maybe_switch_to_minified_file( $relative_path, $constant_name );
			$absolute_path = Files::generate_full_path( $wp_filesystem->abspath(), $relative_path );

			if ( $wp_filesystem->is_file( $absolute_path ) ) {
				$assets[] = array(
					'handle' => $handle,
					'src'    => $relative_path,
					'deps'   => $deps,
					'ver'    => $this->maybe_generate_mtime_version_string( $absolute_path, $fallback_version ),
					'media'  => $media,
				);
			}
		}

		return $assets;
	}

	/**
	 * Adds a properly formatted script asset to a list of other script assets.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $assets             Array of script assets to append the new script to.
	 * @param   string  $handle             A string that should uniquely identify the CSS asset.
	 * @param   string  $relative_path      The path to the CSS file relative to WP's root directory.
	 * @param   string  $fallback_version   The string to be used as a cache-busting fallback if everything else fails.
	 * @param   array   $deps               Array of dependent CSS handles that should be loaded first.
	 * @param   bool    $in_footer          Whether the script asset should be loaded in the footer or the header of the page.
	 * @param   string  $constant_name      The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  array
	 */
	protected function add_script( array $assets, string $handle, string $relative_path, string $fallback_version, array $deps, bool $in_footer, string $constant_name ): array {
		$wp_filesystem = $this->get_wp_filesystem();

		if ( $wp_filesystem ) {
			$relative_path = $this->maybe_switch_to_minified_file( $relative_path, $constant_name );
			$absolute_path = Files::generate_full_path( $wp_filesystem->abspath(), $relative_path );

			if ( $wp_filesystem->is_file( $absolute_path ) ) {
				$assets[] = array(
					'handle'    => $handle,
					'src'       => $relative_path,
					'deps'      => $deps,
					'ver'       => $this->maybe_generate_mtime_version_string( $absolute_path, $fallback_version ),
					'in_footer' => $in_footer,
				);
			}
		}

		return $assets;
	}

	/**
	 * Removes an asset from a list based on its handle.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $assets     The collection of assets to manipulate.
	 * @param   string  $handle     The handle of the asset that should be removed.
	 *
	 * @return  array
	 */
	protected function remove( array $assets, string $handle ): array {
		foreach ( $assets as $index => $asset_info ) {
			if ( $handle === $asset_info['handle'] ) {
				unset( $assets[ $index ] );
				break;
			}
		}

		return $assets;
	}

	/**
	 * Maybe updates the relative path such that it loads the minified version of the file, if it exists and minification
	 * enqueuing is active.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $relative_path          The relative path to WP's root directory.
	 * @param   string  $constant_name          The name of the constant to check for truthful values in case the assets should be loaded in a minified state.
	 *
	 * @return  string  The updated relative path.
	 */
	protected function maybe_switch_to_minified_file( string $relative_path, string $constant_name = 'SCRIPT_DEBUG' ): string {
		$suffix = AssetsHelpers::get_assets_minified_state( $constant_name );
		if ( ! empty( $suffix ) && strpos( $relative_path, $suffix ) === false ) {
			$wp_filesystem = $this->get_wp_filesystem();
			if ( $wp_filesystem ) {
				$full_path = Files::generate_full_path( $wp_filesystem->abspath(), $relative_path );
				$extension = pathinfo( $full_path, PATHINFO_EXTENSION );

				$minified_relative_path = str_replace( $extension, "{$suffix}{$extension}", $relative_path );
				$minified_full_path     = Files::generate_full_path( $wp_filesystem->abspath(), $minified_relative_path );

				if ( $wp_filesystem->is_file( $minified_full_path ) ) {
					$relative_path = $minified_relative_path;
				}
			}
		}

		return $relative_path;
	}

	/**
	 * Tries to generate an asset file's version based on its last modified time.
	 * If that fails, defaults to the fallback versioning.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $absolute_path      The absolute path to an asset file.
	 * @param   string  $fallback_version   The fallback version in case reading the mtime fails.
	 *
	 * @return  string
	 */
	protected function maybe_generate_mtime_version_string( string $absolute_path, string $fallback_version ): string {
		$wp_filesystem = $this->get_wp_filesystem();
		$version       = $wp_filesystem ? $wp_filesystem->mtime( $absolute_path ) : false;

		return ( empty( $version ) ) ? $fallback_version : strval( $version );
	}

	// endregion
}

<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers;

use DeepWebSolutions\Framework\Core\Abstracts\PluginBase;
use DeepWebSolutions\Framework\Helpers\Assets;

defined( 'ABSPATH' ) || exit;

/**
 * Handles the registration and display of notices in the admin area.
 *
 * @see     https://github.com/skyverge/wc-plugin-framework/blob/de7f429af153a17a0fd84cf9a1c56c6ac5ffbc08/woocommerce/class-sv-wc-admin-notice-handler.php
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers
 */
class AdminNoticesHandler {
	// region FIELDS AND CONSTANTS

	/**
	 * The slug of admin error notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  ERROR
	 */
	public const ERROR = 'error';

	/**
	 * The slug of admin warning notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  WARNING
	 */
	public const WARNING = 'warning';

	/**
	 * The slug of admin success notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  SUCCESS
	 */
	public const SUCCESS = 'success';

	/**
	 * The slug of admin info notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  public
	 * @var     string  INFO
	 */
	public const INFO = 'info';

	/**
	 * Instance of the current plugin.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     PluginBase|null
	 */
	protected ?PluginBase $plugin = null;

	/**
	 * Collection of dynamically generated admin notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     array
	 */
	protected array $dynamic_admin_notices = array(
		self::ERROR   => array(),
		self::WARNING => array(),
		self::SUCCESS => array(),
		self::INFO    => array(),
	);

	/**
	 * Whether any user notices have been outputted during the current request.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	private bool $outputted_user_admin_notices = false;

	// endregion

	// region MAGIC METHODS

	/**
	 * AdminNoticesHandler constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginBase  $plugin     Instance of the current plugin.
	 * @param   Loader      $loader     Instance of the hooks and shortcodes loader.
	 */
	public function __construct( PluginBase $plugin, Loader $loader ) {
		$this->plugin = $plugin;

		// Output the admin notices.
		$loader->add_action( 'admin_notices', $this, 'output_user_admin_notices' );
		$loader->add_action( 'admin_notices', $this, 'output_dynamic_admin_notices' );
		$loader->add_action( 'admin_footer', $this, 'output_admin_notice_dismiss_js' );

		// AJAX handler for dismissing a notice.
		$loader->add_action( 'wp_ajax_dws_framework_utilities_' . $this->plugin->get_plugin_safe_slug() . '_dismiss_notice', $this, 'handle_ajax_dismiss' );
	}

	// endregion

	// region HOOKS

	/**
	 * Output user specific admin notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function output_user_admin_notices(): void {
		$user_id = get_current_user_id();
		$notices = get_user_meta( $user_id, $this->get_user_notices_meta_key(), true );

		foreach ( array( self::ERROR, self::WARNING, self::SUCCESS, self::INFO ) as $type ) {
			if ( ! isset( $notices[ $type ] ) ) {
				continue;
			}

			foreach ( $notices[ $type ] as $notice_id => $message ) {
				if ( empty( $message ) ) {
					unset( $notices[ $type ][ $notice_id ] );
					continue;
				} elseif ( ! $this->should_display_notice( $notice_id ) ) {
					unset( $notices[ $type ][ $notice_id ] );
					continue;
				}

				$this->outputted_user_admin_notices = true;
				$this->output_admin_notice(
					$message,
					$notice_id,
					array(
						'type'        => $type,
						'dismissible' => true,
					)
				);
			}
		}

		update_user_meta( $user_id, $this->get_user_notices_meta_key(), $notices );
	}

	/**
	 * Output dynamic admin notices.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function output_dynamic_admin_notices(): void {
		foreach ( $this->dynamic_admin_notices as $type => $notices ) {
			foreach ( $notices as $notice_id => $notice ) {
				$this->output_admin_notice( $notice['message'], $notice_id, $notice['params'] );
			}
		}
	}

	/**
	 * Intercepts an AJAX request for dismissing a given notice.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function handle_ajax_dismiss(): void {
		if ( wp_verify_nonce( $_POST['nonce'], 'dws-dismiss-notice' ) ) {
			$this->dismiss_notice( $_POST['notice_id'] );
		}
	}

	// endregion

	// region METHODS

	/**
	 * Registers a dynamic notice that will be displayed to all eligible users that have not dismissed it yet.
	 *
	 * @param   string  $message    The message that should be displayed to the current user on the next page load.
	 * @param   string  $notice_id  A unique message ID that helps us avoid displaying duplicates.
	 * @param   array   $params     {
	 *      Optional parameters.
	 *
	 *      @type string      type           The type of notice to display.
	 *      @type bool        dismissible    Whether the notice is dismissible or not.
	 *      @type string|null capability     The capability that a user must possess to be displayed the notice. Null if it doesn't apply.
	 * }
	 */
	public function add_admin_notice( string $message, string $notice_id, array $params = array() ) {
		$params = wp_parse_args(
			$params,
			array(
				'type'        => self::ERROR,
				'dismissible' => true,
				'capability'  => null,
			)
		);

		if ( $this->should_display_notice( $notice_id, $params ) ) {
			$this->dynamic_admin_notices[ $params['type'] ][ $notice_id ] = array(
				'message' => $message,
				'params'  => $params,
			);
		}
	}

	/**
	 * Adds a message to the current user's meta data that will be displayed to the user on the next page load until they
	 * manually dismiss it.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    The message that should be displayed to the current user on the next page load.
	 * @param   string  $notice_id  A unique message ID that helps us avoid displaying duplicates.
	 * @param   array   $params     {
	 *      Optional parameters.
	 *
	 *      @type string type   The type of notice to display.
	 * }
	 */
	public function add_admin_notice_to_user( string $message, string $notice_id, array $params = array() ): void {
		$params = wp_parse_args(
			$params,
			array(
				'type' => self::ERROR,
			)
		);

		$user_id = get_current_user_id();
		$notices = get_user_meta( $user_id, $this->get_user_notices_meta_key(), true );

		if ( ! is_array( $notices ) ) {
			$notices = array();
		}

		$notices[ $params['type'] ]               = isset( $notices[ $params['type'] ] ) ? $notices[ $params['type'] ] : array();
		$notices[ $params['type'] ][ $notice_id ] = $message;

		update_user_meta( $user_id, $this->get_user_notices_meta_key(), $notices );
	}

	/**
	 * Outputs the JS that handles the notice dismiss action.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function output_admin_notice_dismiss_js(): void {
		if ( empty( $this->dynamic_admin_notices ) && false === $this->outputted_user_admin_notices ) {
			return; // No notices were outputted.
		}

		ob_start();

		?>

		( function( $ ) {
			$( '.dws-framework-notice-<?php echo esc_js( $this->plugin->get_plugin_slug() ); ?>' ).on( 'click.wp-dismiss-notice', '.notice-dismiss', function( e ) {
				var notice = $( this ).closest( '.dws-framework-notice' );
				$.ajax( {
					url: ajaxurl,
					method: 'POST',
					data: {
						action: 'dws_framework_utilities_<?php echo esc_js( $this->plugin->get_plugin_safe_slug() ); ?>_dismiss_notice',
						notice_id: $( notice ).data( 'notice-id' ),
						nonce: <?php echo esc_js( wp_create_nonce( 'dws-dismiss-notice' ) ); ?>
					}
				} );
			} );
		} ) ( jQuery );

		<?php

		echo Assets::get_javascript_from_string( ob_get_clean() ); // phpcs:ignore
	}

	/**
	 * Marks a specific notice as dismissed for a specific user.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $notice_id  The ID of the notice to dismiss.
	 * @param   int|null    $user_id    The ID of the user to dismiss the notice for.
	 */
	public function dismiss_notice( string $notice_id, ?int $user_id = null ): void {
		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$dismissed_notices               = $this->get_dismissed_notices( $user_id );
		$dismissed_notices[ $notice_id ] = true;

		update_user_meta( $user_id, $this->get_dismissed_notices_meta_key(), $dismissed_notices );

		/**
		 * Fires when a user dismisses an admin notice.
		 *
		 * @since   1.0.0
		 * @version 1.0.0
		 *
		 * @param   string  $notice_id  The unique ID of a notice.
		 * @param   int     $user_id    The ID of the user dismissing the notice.
		 */
		do_action( 'dws_' . $this->plugin->get_plugin_safe_slug() . '_dismiss_notice', $notice_id, $user_id );
	}

	// endregion

	// region HELPERS

	/**
	 * Outputs a single notice.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    The message contained by the notice.
	 * @param   string  $notice_id  The unique ID of the notice.
	 * @param   array   $params     {
	 *      Optional parameters.
	 *
	 *      @type string      type           The type of notice to display.
	 *      @type bool        dismissible    Whether the notice is dismissible or not.
	 * }
	 */
	protected function output_admin_notice( string $message, string $notice_id, array $params = array() ): void {
		$params = wp_parse_args(
			$params,
			array(
				'type'        => self::ERROR,
				'dismissible' => true,
			)
		);

		$classes = array(
			'notice',
			'notice-' . $params['type'],
			'dws-framework-notice',
			'dws-framework-notice-' . $this->plugin->get_plugin_slug(),
		);
		if ( $params['dismissible'] ) {
			$classes[] = 'is-dismissible';
		}

		echo sprintf(
			'<div class="%1$s" data-plugin-slug="%2$s" data-notice-id="%3$s"><p>%4$s</p></div>',
			esc_attr( implode( ' ', $classes ) ),
			esc_attr( $this->plugin->get_plugin_slug() ),
			esc_attr( $notice_id ),
			wp_kses_post( $message )
		);
	}

	/**
	 * Checks whether a specific notice should be displayed for the current user or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $notice_id  The ID of the notice to check for.
	 * @param   array   $params     The parameters of the notice.
	 *
	 * @return  bool    True if the notice should be displayed, false otherwise.
	 */
	protected function should_display_notice( string $notice_id, array $params = array() ): bool {
		$params = wp_parse_args(
			$params,
			array(
				'capability'  => null,
				'dismissible' => true,
			)
		);

		// Do not display the notice if the user does not have the required capability.
		if ( ! is_null( $params['capability'] ) && ! current_user_can( $params['capability'] ) ) {
			return false;
		}

		// Always display non-dismissible notices.
		if ( ! $params['dismissible'] ) {
			return true;
		}

		return ! $this->is_notice_dismissed( $notice_id );
	}

	/**
	 * Checks whether a specific notice has been dismissed by a specific user or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $notice_id  The ID of the notice to check the dismissed status for.
	 * @param   int|null    $user_id    The ID of the user to check the dismissed status for.
	 *
	 * @return  bool    Whether the given notice has been dismissed by the given user or not.
	 */
	protected function is_notice_dismissed( string $notice_id, ?int $user_id = null ): bool {
		$dismissed_notices = $this->get_dismissed_notices( $user_id );
		return isset( $dismissed_notices[ $notice_id ] ) && boolval( $dismissed_notices[ $notice_id ] );
	}

	/**
	 * Returns the list of dismissed notices for a given user.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int|null    $user_id    The user ID that the dismissed notices are being searched for.
	 *
	 * @return  array
	 */
	protected function get_dismissed_notices( ?int $user_id = null ): array {
		if ( is_null( $user_id ) ) {
			$user_id = get_current_user_id();
		}

		$dismissed_notices = get_user_meta( $user_id, $this->get_dismissed_notices_meta_key(), true );

		return is_array( $dismissed_notices )
			? $dismissed_notices : array();
	}

	/**
	 * Ensures no typos take place by encapsulating the dismissed notices meta key in its own helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	protected function get_dismissed_notices_meta_key(): string {
		return '_dws_admin_notices_' . $this->plugin->get_plugin_safe_slug() . '_dismissed_notices';
	}

	/**
	 * Ensures no typos take place by encapsulating the user notices meta key in its own helper.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	protected function get_user_notices_meta_key(): string {
		return '_dws_admin_notices_' . $this->plugin->get_plugin_safe_slug();
	}

	// endregion
}

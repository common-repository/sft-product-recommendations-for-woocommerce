<?php
/**
 * Plugin Name:  AI Product Recommendations for WooCommerce
 * Description:  It is used to display recently viewed products by users, sale on them, related products to recently viewed products.
 * Author URI:  https://www.saffiretech.com
 * Author:      SaffireTech
 * Text Domain:  sft-product-recommendations-woocommerce
 * Domain Path: /languages
 * Stable Tag : 2.0.0
 * Requires at least: 5.0
 * Tested up to: 6.6.2
 * Requires PHP: 7.2
 * WC requires at least: 4.0.0
 * WC tested up to: 9.3.3
 * License:     GPLv3
 * License URI: URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Version:     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check the installation of pro version.
 *
 * @return bool
 */
function prwfr_check_pro_version() {

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( is_plugin_active( 'sft-product-recommendations-woocommerce/sft-product-recommendations-woocommerce.php' ) ) {
		return true;
	} else {
		return false;
	}
}

add_action( 'plugins_loaded', 'prwfr_plugin_install' );

/**
 * Display notice if pro plugin found and decativate the free version.
 */
function prwfr_plugin_install() {

	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	// if pro plugin found deactivate free plugin.
	if ( prwfr_check_pro_version() ) {

		// deactivate free plugin if pro found.
		deactivate_plugins( plugin_basename( __FILE__ ), true );

		// nonce verification.
		$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
		$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

		if ( ! $id_nonce_verified ) {
			wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
		}

		// If pro plugin is defined deactivate it after activate is triggred.
		if ( defined( 'PRWFR_PRO_PLUGIN' ) ) {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			// Trigger admin notice.
			add_action( 'admin_notices', 'prwfr_install_admin_notice' );
		}
	}
}

/**
 * Add message if pro version is installed.
 */
function prwfr_install_admin_notice() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php esc_html_e( 'Free version deactivated Pro version Installed', 'sft-product-recommendations-woocommerce' ); ?></p>
	</div>
	<?php
}


add_action( 'init', 'prwfr_color_picker' );

/**
 * The color picker utilized on the general settings page has been incorporated.
 */
function prwfr_color_picker() {

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	if ( isset( $_GET['page'] ) && 'prwfr_general_submenu' === $_GET['page'] ) {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp_color_picker', plugins_url( '/assets/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), '1.0.0', true );

	}
}

add_action( 'init', 'prwfr_plugin_assets' );

/**
 * All files are included here and a check is performed to determine if WooCommerce is active or not.
 */
function prwfr_plugin_assets() {
	global $wpdb;
	$check_woocommerce_activation = class_exists( 'WC_Auth' ) ? true : false;
	$user_id                      = get_current_user_id();

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	// $check_woocommerce_activation is used to check if woocommerce plugin is active or not.
	if ( intval( $check_woocommerce_activation ) ) {
		if ( ! prwfr_check_pro_version() ) {

			require_once dirname( __FILE__ ) . '/includes/prwfr-custom-functions.php';
			require_once dirname( __FILE__ ) . '/includes/prwfr-recently-viewed-related-settings.php';
			require_once dirname( __FILE__ ) . '/includes/prwfr-purchase-related-settings.php';
			require_once dirname( __FILE__ ) . '/includes/prwfr-all-ajax-action.php';
			require_once dirname( __FILE__ ) . '/includes/prwfr-highlighting-features-setting.php';
			require_once dirname( __FILE__ ) . '/includes/prwfr-setting-tabs.php';

			wp_enqueue_style( 'prwfr-icon-css', esc_url( 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' ), true, '4.7.0' );
			// wp_enqueue_script( 'prwfr_multi_ajax_js', plugins_url( 'assets/js/jQuery-multi-select-js/src/jquery.multi-select.js', __FILE__ ), array(), '10.10.1', false );

			// wp_enqueue_script( 'prwfr_ajax_js', plugins_url( 'assets/js/prwfr-ajax.js', __FILE__ ), array(), '10.10.1', false );
			// Library for SweetAlert.
			wp_enqueue_style( 'prwfr_sweetalert_css', plugins_url( '/assets/css/sweetalert2.min.css', __FILE__ ), array(), '1.0.0' );

			wp_enqueue_script( 'prwfr_sweetalert_js', plugins_url( '/assets/js/sweetalert2.all.min.js', __FILE__ ), array( 'jquery' ), '1.0.0' );

			wp_enqueue_style( 'prwfr_style', plugins_url( '/assets/css/prwfr-product-recommendations.css', __FILE__ ), array(), '1.0.0' );

			// Enqueue Select2 CSS.
			wp_enqueue_style( 'prwfr-select2-css', plugins_url( 'assets/css/select2.min.css', __FILE__ ), array(), '10.0.0', false );

			// Library for Search Option for Font Awesome Icon.
			wp_enqueue_style( 'prwfr_icon_star', plugins_url( 'assets/css/font-awesome.min.css', __FILE__ ), array(), '1.0.0' );

			// Enqueue js file.
			wp_enqueue_script( 'prwfr_ajax_action', plugins_url( '/assets/js/prwfr-product-recommendations.js', __FILE__ ), array( 'jquery' ), '1.0.0' );

			if ( 'prwfr_menu' === ( isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '' ) || 'prwfr_post_purcahse_submenu' === ( isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '' ) || 'prwfr_product_discovery_submenu' === ( isset( $_GET['page'] ) ? sanitize_key( $_GET['page'] ) : '' ) ) {
				wp_enqueue_script( 'prwfr-select2-js', plugins_url( 'assets/js/select2.min.js', __FILE__ ), array( 'jquery' ), '1.1.0', false );
				wp_enqueue_script( 'prwfr-backend-js', plugins_url( 'assets/js/prwfr-backend.js', __FILE__ ), array( 'jquery' ), '1.1.0', false );
			}

			wp_localize_script(
				'prwfr_ajax_action',
				'prwfr_ajax_action_obj',
				array(
					'url'                                  => admin_url( 'admin-ajax.php' ),
					'nonce'                                => wp_create_nonce( 'sft-product-recommendations-woocommerce' ),
					'shortcode_text_js'                    => __( 'ShortCode Copied', 'sft-product-recommendations-woocommerce' ),
					'cat_tag_save_msg'                     => __( 'To save your changes, you must choose tags or categories within the \'include/exclude\' field or disable the \'Filter by Categories and tags\' switch.', 'sft-product-recommendations-woocommerce' ),
					'rvp_page_select'                      => __( 'Please choose a custom page to apply the modifications for Recently Viewed Products.', 'sft-product-recommendations-woocommerce' ),
					'rvp_related_page_select'              => __( 'Please choose a custom page to apply the modifications for Products related to Recently Viewed Products.', 'sft-product-recommendations-woocommerce' ),
					'rvp_onsale_page_select'               => __( 'Please choose a custom page to apply the modifications for On-Sale Products related to Recently Viewed Products.', 'sft-product-recommendations-woocommerce' ),
					// Free to Pro Upgrade alert translation.
					'prwfr_free_to_pro_alert_title'        => __( 'Pro Field Alert !', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_alert_messgae'      => __( 'This field is available with pro version of Product Recommendations for woocommerce', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_upgrade'            => __( 'Upgrade Now!', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_line_one'     => __( 'Looking for this cool feature? Go Pro!', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_line_two'     => __( 'Go with our premium version to unlock the following features:', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_one_bold' => __( 'AI powered Product Recommendations: ', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_one'  => __( 'Leverage the power of ChatGPT to create personalized product recommendations for your customers.', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_two_bold' => __( '"Recommended Products" Emails based on Browsing History: ', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_two'  => __( 'Customers get "Recommended Products" email notifications based on their browsing history.', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_three_bold' => __( '"Price Drop" Email Alerts for your Featured Sale Items: ', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_three' => __( 'Sends "Price Drop" email to customers on products marked as "Featured Sale Item" at specified intervals of your choice.', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_four_bold' => __( '"Buy It Again" Widget & Purchase History Related items: ', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_four' => __( 'Display previously bought items and similar items to your customers to boost repeat orders or similar orders.', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_five_bold' => __( 'Product Discovery Widgets: ', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_five' => __( 'Attract customers with the latest arrivals, top performers, and spotlighted items using customizable widgets.', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_six_bold' => __( 'Customization options for All Widgets: ', 'sft-product-recommendations-woocommerce' ),
					'prwfr_free_to_pro_popup_listing_six'  => __( 'Get a plethora of options to customize widget like Star Ratings, Title, Sale Price etc.', 'sft-product-recommendations-woocommerce' ),

				)
			);

			// // ------------- api key --------------------

			// wp_localize_script(
			// 'prwfr_ajax_js',
			// 'prwfr_ajax_object',
			// array(
			// 'ajax_url'            => admin_url( 'admin-ajax.php' ),
			// 'api_valid_key'       => get_option( 'prwfr_api_valid_key_status' ),
			// 'api_request_status'  => get_option( 'prwfr_api_request_created_status' ),
			// 'api_response_status' => get_option( 'prwfr_api_request_created_status' ),
			// )
			// );

			// -------------------------------------

			$user_id       = get_current_user_id();
			$check_default = (string) get_option( 'prwfr_default_check' );

			if ( '' === $check_default ) {
				update_user_meta( $user_id, 'browsing_history_on_off_' . $user_id, '1' );
				update_option( 'prwfr_manage_history_access', '1' );
				update_option( 'prwfr_color_picker_background_front', '#e8e8e8' );
				update_option( 'prwfr_color_picker_btn', '#000000' );
				update_option( 'prwfr_product_image_size', 'thumbnail' );
				update_option( 'prwfr_rvps_filter_switch', '1' );
				update_option( 'prwfr_default_check', '1' );
				update_option( 'prwfr_rvp_email_send', '1' );
				update_option( 'prwfr_rvp_email_recurrence_interval', 'hours' );
				update_option( 'prwfr_rvp_email_hours_interval', 8 );
				update_option( 'prwfr_email_template_header_bg_color', '#7f54b3' );
			}

			// ------------------------------------------------------------

			$default_ai_check = (string) get_option( 'prwfr_default_ai_check' );

			if ( '' === $default_ai_check ) {
				update_option( 'prwfr_recurrence_period_ai', 'one_time' );
				update_option( 'prwfr_multiple_products_check', 'on' );
				update_option( 'prwfr_products_name', 'on' );
				update_option( 'prwfr_products_desc', 'on' );
				update_option( 'prwfr_fbt_data', '' );
				update_option( 'prwfr_default_ai_prompt', 'Here is selected products data: {selected_products} and here is all products data {all_products} and here is frequently purchased products data {fbt_data}  and suggest 5 recommendations for each product from this set.' );
				update_option( 'prwfr_ai_prompt_type', 'default' );
				update_option( 'prwfr_default_ai_check', '1' );
				prwfr_update_tokens();
			}

			// RVP email scheduling
			$send_email_RVP = get_option( 'prwfr_rvp_email_send' );
			// Check if the option to send RVP (Recently Viewed Products) emails is enabled
			if ( $send_email_RVP ) {
				if ( get_option( 'prwfr_rvp_email_recurrence_interval' ) === 'hours' ) {
					if ( false === as_has_scheduled_action( 'prwfr_schedule_mails_RVP' ) ) {
						$interval_in_seconds = 1 * HOUR_IN_SECONDS; // Replace 6 with the desired number of hours

						// Schedule a recurring action every X hours
						as_schedule_recurring_action( time(), $interval_in_seconds, 'prwfr_schedule_mails_RVP' );
					}
				}
			} else {
				// If the RVP email sending option is disabled, unschedule any existing actions for sending RVP emails
				as_unschedule_action( 'prwfr_schedule_mails_RVP' );
			}

			if ( ( false === as_has_scheduled_action( 'prwfr_api_request_prompt' ) ) && ( get_option( 'prwfr_api_request_created_status' ) === 'created' ) && ( 'one_time' == get_option( 'prwfr_recurrence_period_ai' ) ) ) {

				// Schedule the action to run immediately send api prompt.
				as_schedule_single_action( time() + 1 * 60, 'prwfr_api_request_prompt', array() );
				update_option( 'prwfr_api_request_created_status', 'pending' );

			}

			// Define the table name by prefixing a base name to adhere to WordPress's naming convention
			$table_name = $wpdb->prefix . 'sft_user_product_interactions';

			// Check if the table already exists in the database
			if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) !== $table_name ) {
				// SQL query to create a new table for storing user-product interactions
				$query = 'CREATE TABLE ' . $table_name . '(
					interaction_id INTEGER NOT NULL AUTO_INCREMENT,
					customer_id INTEGER,
					interaction_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
					interaction_type VARCHAR(500),
					product_details TEXT NOT NULL ,
					order_ids VARCHAR(500), 
					total_sales DECIMAL(20, 2),
					PRIMARY KEY (interaction_id))';
				if ( ! function_exists( 'dbDelta' ) ) {
					require_once ABSPATH . 'wp-admin/includes/upgrade.php';
				}

				dbDelta( $query );
			}

			// $table = $wpdb->prefix . 'prwfr_api_request_log';

			// // Check if the table already exists in the database.
			// if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) !== $table ) {
			// 	$charset_collate = $wpdb->get_charset_collate();
			// 	$sql             = 'CREATE TABLE ' . $table . ' (
			// 		id INT NOT NULL AUTO_INCREMENT,
			// 		request_time DATETIME DEFAULT CURRENT_TIMESTAMP,
			// 		prompt TEXT NOT NULL,
			// 		response TEXT NOT NULL,
			// 		status INT NOT NULL,
			// 		tokens_used INT NOT NULL,
			// 		recommendations_recurrence TEXT NOT NULL,
			// 		associated_product_category_ids TEXT NOT NULL,
			// 		product_details TEXT NOT NULL,
			// 		about_store TEXT NOT NULL,
			// 		PRIMARY KEY (id)
			// 	) ' . $charset_collate . ';';

			// 	if ( ! function_exists( 'dbDelta' ) ) {
			// 		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			// 	}

			// 	dbDelta( $sql );
			// }
		}
	} else {
		add_action( 'admin_notices', 'prwfr_admin_notice__success' );
	}

	// Only loads file if proversion is not installed already.
}

add_action( 'admin_init', 'prprow_js_multiselect' );
function prprow_js_multiselect() {
	// wp_enqueue_style( 'prwfr-icon-css', esc_url( 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css' ), true, '4.7.0' );
	wp_enqueue_script( 'prwfr_multi_ajax_js', plugins_url( 'assets/js/jQuery-multi-select-js/src/jquery.multi-select.js', __FILE__ ), array(), '10.10.1', false );
	wp_enqueue_script( 'prwfr_ajax_js', plugins_url( 'assets/js/prwfr-ajax.js', __FILE__ ), array(), '10.10.1', false );
	// ------------- api key --------------------

	wp_localize_script(
		'prwfr_ajax_js',
		'prwfr_ajax_object',
		array(
			'ajax_url'            => admin_url( 'admin-ajax.php' ),
			'api_valid_key'       => get_option( 'prwfr_api_valid_key_status' ),
			'api_request_status'  => get_option( 'prwfr_api_request_created_status' ),
			'api_response_status' => get_option( 'prwfr_api_request_created_status' ),
		)
	);
}

/**
 * Admin Notice success.
 */
function prwfr_admin_notice__success() {
	$class   = 'notice notice-error is-dismissible';
	$message = __( 'Sorry, but \'Product Recommendations for woocommerce \' plugin requires the Woocommerce Plugin to be installed and active.', 'sft-product-recommendations-woocommerce' );

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

// To create a new page, function is called that displays all products for each widget.

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'prwfr_action_links_callback', 10, 1 );

/**
 * Settings link in plugin page.
 *
 * @param array $links .
 * @return array
 */
function prwfr_action_links_callback( $links ) {

	if ( ! prwfr_check_pro_version() ) {
		$settinglinks = array(
			'<a href="' . admin_url( 'admin.php?page=prwfr_menu' ) . '">' . __( 'Settings', 'sft-product-recommendations-woocommerce' ) . '</a>',
			'<a class="prwfr-setting-upgrade" href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=plugins_archive&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">' . __( 'UpGrade to Pro!', 'sft-product-recommendations-woocommerce' ) . '</a>',

		);
		return array_merge( $settinglinks, $links );
	} else {
		return $links;
	}
}

add_filter(
	'wp_mail_content_type',
	function( $content_type ) {
		return 'text/html';
	}
);

add_action( 'woocommerce_edit_account_form', 'prwfr_manage_history_content' );

// Re-order button is added as action on orders page.
add_filter( 'woocommerce_my_account_my_orders_actions', 'prwfr_reorder', 10, 2 );

add_action( 'admin_notices', 'prwfr_plugin_notice' );

/**
 * Rating notice widget.
 * Save the date to display notice after 10 days.
 */
function prwfr_plugin_notice() {
	global $current_user;

	wp_enqueue_script( 'jquery' );

	// Current user id.
	$user_id = $current_user->ID;

	// if plugin is activated and date is not set then set the next 10 days.
	$today_date = strtotime( 'now' );

	if ( ! get_user_meta( $user_id, 'prwfr_notices_time' ) ) {
		$after_10_day = strtotime( '+10 day', $today_date );
		update_user_meta( $user_id, 'prwfr_notices_time', $after_10_day );
	}

	// gets the option of user rating status and week status.
	$rate_status = get_user_meta( $user_id, 'prwfr_rate_notices', true );
	$next_w_date = get_user_meta( $user_id, 'prwfr_notices_time', true );

	// show if user has not rated the plugin and it has been 10 days.
	if ( 'rated' !== $rate_status && $today_date > $next_w_date ) {
		?>

		<!-- Notice warning div -->
		<div class="notice notice-warning is-dismissible">
			<p><span><?php esc_html_e( "Awesome, you've been using", 'sft-product-recommendations-woocommerce' ); ?></span><span><?php echo '<strong> Product Recommendations for WooCommerce </strong>'; ?><span><?php esc_html_e( 'for more than 1 week', 'sft-product-recommendations-woocommerce' ); ?></span></p>
			<p><?php esc_html_e( 'If you like our plugin would you like to rate our plugin at WordPress.org ?', 'sft-product-recommendations-woocommerce' ); ?></p>
			<span>
				<a href="https://wordpress.org/plugins/sft-product-recommendations-woocommerce/#reviews" target="_blank"><?php esc_html_e( "Yes, I'd like to rate it!", 'sft-product-recommendations-woocommerce' ); ?></a>
			</span>&nbsp; - &nbsp;
			<span>
				<a class="prwfr_hide_rate" href="#"><?php esc_html_e( 'I already did!', 'sft-product-recommendations-woocommerce' ); ?></a>
			</span>
			<br/><br/>
		</div>
		<?php
	}
	?>

	<script>
		let prwfrAjaxURL = "<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>";
		let prwfrNonce = "<?php echo esc_attr( wp_create_nonce( 'sft-product-recommendations-woocommerce' ) ); ?>";

		// redirect to same page after rated link is pressed.
		jQuery(".prwfr_hide_rate").click(function (event) {
			event.preventDefault();

			jQuery.ajax({
				method: 'POST',
				url: prwfrAjaxURL,
				data: {
					action: 'prwfr_update',
					nonce: prwfrNonce,
				},
				success: (res) => {
					window.location.href = window.location.href
				}
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_prwfr_update', 'prwfr_ajax_update_notice' );
add_action( 'wp_ajax_nopriv_prwfr_update', 'prwfr_ajax_update_notice' );

/**
 * Update rating Notice.
 */
function prwfr_ajax_update_notice() {
	global $current_user;

	if ( isset( $_POST['nonce'] ) && ! empty( $_POST['nonce'] ) ) {
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'sft-product-recommendations-woocommerce' ) ) {
			wp_die( esc_html__( 'Permission Denied.', 'sft-product-recommendations-woocommerce' ) );
		}

		update_user_meta( $current_user->ID, 'prwfr_rate_notices', 'rated' );
		echo esc_url( network_admin_url() );
	}
	wp_die();
}

/**
 * Function to convert a date and time string with UTC offset to a UTC timestamp
 *
 * @param string $date_time_string .
 */
function prwfr_convert_datetime_to_utc_timestamp( $date_time_string ) {
	// Get the GMT offset from WordPress settings
	$gmt_offset = get_option( 'gmt_offset' );

	if ( is_numeric( $gmt_offset ) ) {
		// Calculate the timezone offset in seconds
		$timezone_offset_seconds = $gmt_offset * 3600;

		// Create a DateTime object for the given date and time
		$datetime = new DateTime( $date_time_string );

		// Adjust the time based on the sign of the GMT offset
		if ( $timezone_offset_seconds >= 0 ) {
			$datetime->modify( "-{$timezone_offset_seconds} seconds" );
		} else {
			$datetime->modify( "+{$timezone_offset_seconds} seconds" );
		}

		// Convert the time to UTC
		$datetime->setTimezone( new DateTimeZone( 'UTC' ) );

		// Get the UTC time as a timestamp
		$timestamp = $datetime->getTimestamp();

		return $timestamp;
	} else {
		return false;
	}
}

add_action( 'woocommerce_after_checkout_billing_form', 'prwfr_email_gdpr_permision' );
function prwfr_email_gdpr_permision() {

	$user = wp_get_current_user();
	if ( $user->exists() ) {  // Check if the user is logged in
		$user_mail       = $user->user_email;  // Return the email address of the current user
		$no_thanks_email = get_option( 'email_gdpr_no_thanks' ) ? json_decode( get_option( 'email_gdpr_no_thanks' ), true ) : array();

		if ( ! in_array( $user_mail, $no_thanks_email ) ) {
			echo '<span class="prwfr-gdpr-no-thanks-email" style="font-size: xx-small">We can send email reminders about this order. <a style="cursor: pointer" id="prwfr_gdpr_no_thanks"> No Thanks </a></span>';
		}
	}

}

add_action( 'init', 'prwfr_view_pages_back' );

add_action( 'prwfr_schedule_mails_RVP', 'prwfr_schedule_mails_RVP' );

add_action( 'init', 'prwfr_schedule_mails_RVP' );

function prwfr_update_tokens() {

	// Initialize arrays and variables .
	$selected_products                       = array();
	$selected_categories_products            = array();
	$selected_product_prompt_data            = array();
	$final_response                          = array();
	$all_products_prompt_data                = array();
	$selected_categories_product_prompt_data = array();
	$all_products                            = prwfr_get_all_products(); // Get all products with variations .
	$ai_build_prompt_data                    = '';
	$about_store_text                        = get_option( 'prwfr_about_store' );
	$prompt_text                             = '';

	if ( get_option( 'prwfr_ai_prompt_type' ) == 'default' ) {
		$prompt_text = get_option( 'prwfr_default_ai_prompt' );
	} elseif ( get_option( 'prwfr_ai_prompt_type' ) == 'edit' ) {
		$prompt_text = get_option( 'prwfr_ai_request_prompt' );
	}

	if ( get_option( 'prwfr_multiple_categories_check' ) == 'on' ) {
		// Get products based on selected categories.
		$category_ids = get_option( 'prwfr_category_selection' );
		$args         = array(
			'post_type'      => 'product',
			'posts_per_page' => -1,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $category_ids,
				),
			),
		);

		$query = new WP_Query( $args );

		// Add product IDs from the query results to the $products array.
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				array_push( $selected_categories_products, get_the_ID() );
			}
			wp_reset_postdata();
		}
	}

	if ( get_option( 'prwfr_multiple_products_check' ) == 'on' ) {
		// Use the provided selected products.
		$selected_products = get_option( 'prwfr_product_selection' );
	}

	$selected_product_detail_check = array( 'products_url', 'products_name', 'products_price', 'products_desc', 'products_desc_long', 'products_categories' );

	$selected_product_detail = array();

	foreach ( $selected_product_detail_check as $selected_option ) {
		$selected_product_detail[] = get_option( 'prwfr_' . $selected_option ) == 'on' ? $selected_option : '';
	}

	// Gather product details for the selected products .
	foreach ( $selected_categories_products as $product_id ) {

		$product            = wc_get_product( $product_id );
		$temp               = array();
		$temp['product_id'] = $product_id;

		if ( ! $product ) {
			// Handle the case where the product is not found .
			continue;
		}

		// Add product details based on selected product detail options .
		if ( in_array( 'products_name', $selected_product_detail ) ) {
			$temp['products_name'] = get_the_title( $product_id );
		}

		if ( in_array( 'product_url', $selected_product_detail ) ) {
			$temp['product_url'] = get_permalink( $product_id );
		}

		if ( in_array( 'products_desc', $selected_product_detail ) ) {
			$temp['products_desc'] = strip_tags( $product->get_short_description() );
		}

		if ( in_array( 'products_price', $selected_product_detail ) ) {
			$temp['products_price'] = $product->get_price();
		}

		if ( in_array( 'products_categories', $selected_product_detail ) ) {
			$categories     = get_the_terms( $product->get_id(), 'product_cat' );
			$category_slugs = array();
			foreach ( $categories as $category ) {
				$category_slugs[] = $category->slug;
			}
			$temp['products_categories'] = $category_slugs;
		}

		if ( in_array( 'products_desc_long', $selected_product_detail ) ) {
			$temp['products_desc_long'] = strip_tags( $product->get_description() );
		}

		$selected_categories_product_prompt_data[] = $temp;
	}

	// Gather product details for the selected products .
	foreach ( $selected_products as $product_id ) {

		$product            = wc_get_product( $product_id );
		$temp               = array();
		$temp['product_id'] = $product_id;

		if ( ! $product ) {
			// Handle the case where the product is not found .
			continue;
		}

		// Add product details based on selected product detail options .
		if ( in_array( 'products_name', $selected_product_detail ) ) {
			$temp['products_name'] = get_the_title( $product_id );
		}

		if ( in_array( 'product_url', $selected_product_detail ) ) {
			$temp['product_url'] = get_permalink( $product_id );
		}

		if ( in_array( 'products_desc', $selected_product_detail ) ) {
			$temp['products_desc'] = strip_tags( $product->get_short_description() );
		}

		if ( in_array( 'products_price', $selected_product_detail ) ) {
			$temp['products_price'] = $product->get_price();
		}

		if ( in_array( 'products_categories', $selected_product_detail ) ) {
			$categories     = get_the_terms( $product->get_id(), 'product_cat' );
			$category_slugs = array();
			foreach ( $categories as $category ) {
				$category_slugs[] = $category->slug;
			}
			$temp['products_categories'] = $category_slugs;
		}

		if ( in_array( 'products_desc_long', $selected_product_detail ) ) {
			$temp['products_desc_long'] = strip_tags( $product->get_description() );
		}

		$selected_product_prompt_data[] = $temp;
	}

	// Gather product details for all products .
	foreach ( $all_products as $product_id => $value ) {

		$product            = wc_get_product( $value['product_id'] );
		$temp               = array();
		$temp['product_id'] = $value['product_id'];

		if ( ! $product ) {
			// Handle the case where the product is not found .
			continue;
		}

		// Add product details based on selected product detail options .
		if ( in_array( 'products_name', $selected_product_detail ) ) {
			$temp['products_name'] = get_the_title( $product_id );
		}

		if ( in_array( 'products_desc', $selected_product_detail ) ) {
			$temp['products_desc'] = strip_tags( $product->get_short_description() );
		}

		$all_products_prompt_data[] = $temp;
	}

	$fbt_products = array();
	if ( get_option( 'prwfr_fbt_data' ) == 'on' ) {

		$args = array(
			'post_type'      => 'any', // Change to a specific post type if needed.
			'meta_query'     => array(
				array(
					'key'     => '_bought_together',
					'compare' => 'EXISTS',
				),
			),
			'posts_per_page' => -1, // To get all posts.
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$post_id                  = get_the_ID();
				$bought_together          = get_post_meta( $post_id, '_bought_together', true );
				$fbt_products[ $post_id ] = $bought_together;
			}
		}
	}

	$selected_product_prompt = wp_json_encode( $selected_product_prompt_data );

	$selected_categories_products_prompt = wp_json_encode( $selected_categories_product_prompt_data );

	$all_products_prompt = wp_json_encode( $all_products_prompt_data );

	$fbt_products_prompt = wp_json_encode( $fbt_products );

	// Replace placeholder in the prompt text with the JSON data .
	$modified_string_all = str_replace( '{all_products}', $all_products_prompt, $prompt_text );

	// // // Customize the prompt based on the selected product type option .
	if ( get_option( 'prwfr_multiple_categories_check' ) == 'on' ) {
		$modified_string_all = str_replace( '{selected_categories}', $selected_categories_products_prompt, $modified_string_all );
	}

	if ( get_option( 'prwfr_multiple_products_check' ) == 'on' ) {
		$modified_string_all = str_replace( '{selected_products} ', $selected_product_prompt, $modified_string_all );
	}

	if ( get_option( 'prwfr_fbt_data' ) == 'on' ) {
		$modified_string_all = str_replace( '{fbt_products} ', $fbt_products_prompt, $modified_string_all );
	}

	$ai_build_prompt_data = $modified_string_all;
	// Build the final prompt string to send .
	$prompt_to_send = $about_store_text . '. Generate a JSON object listing product recommendations for a WooCommerce store based on product descriptions and provided frequently purchased products data. Exclude any products where the type is "child". ' . $ai_build_prompt_data . 'The JSON output should only include product IDs and should be formatted compactly without unnecessary spaces. For example, for a product with ID 123 has 5 recommendations of prdouct with ids 1,2,3,4,5, the output should be: {"123":["1,2,3,4,5"]}. Ensure the product IDs are listed without spaces and that the relationships are based on significant description similarities. Do not include any additional content or commentary, just provide the JSON data.';

	// // Build the prompt string to save .
	$prompt_to_save = $about_store_text . '. Generate a JSON object listing product recommendations for a WooCommerce store based on product descriptions and provided frequently purchased products data. Exclude any products where the type is "child". ' . $prompt_text . '. The JSON output should only include product IDs and should be formatted compactly without unnecessary spaces. For example, for a product with ID 123 has 5 recommendations of prdouct with ids 1,2,3,4,5, the output should be: {"123":["1,2,3,4,5"]}. Ensure the product IDs are listed without spaces and that the relationships are based on significant description similarities. Do not include any additional content or commentary, just provide the JSON data.';

	// echo $prompt_to_send;
	// echo $prompt_to_save;
	// Calculate the token length for the prompt to send .
	$token_length = ceil( strlen( $prompt_to_send ) / 4 );

	// Update the token usage option .
	update_option( 'prwfr_tokens_used', $token_length );

	// Prepare the response array .
	$built_prompt['prompt_to_send'] = $prompt_to_send;
	$built_prompt['prompt_to_save'] = $prompt_to_save;
	$built_prompt['prompt_token']   = $token_length;

	// Return the response array .
	return $built_prompt;
}

// Define the action hook to handle the scheduled event
add_action( 'prwfr_api_request_prompt', 'prwfr_openai_setup_api_call' );

/**
 * Server Api Call with product datas.
 */
function prwfr_openai_setup_api_call() {

	global $wpdb;
	$final_response = array();

	// If set with ai is hit start the action.
	if ( get_option( 'prwfr_prompt_request_button_hit' ) ) {
		// Check if the request has already been fulfilled .
		if ( get_option( 'prwfr_api_request_created_status' ) === 'fulfilled' ) {
			return;
		}

		// Check the status if already not fullfilled.
		if ( ( 'fulfilled' !== get_option( 'prwfr_api_request_created_status' ) ) ) {
			// Reset error status.
			update_option( 'rprow_api_error_data', '' );
			update_option( 'rprow_prompt_request_button_hit', 0 );

			$selected_product_detail_check = array( 'products_url', 'products_name', 'products_price', 'products_desc', 'products_desc_long', 'products_categories' );

			$selected_product_detail = array();

			foreach ( $selected_product_detail_check as $selected_option ) {
				$selected_product_detail[] = get_option( 'prwfr_' . $selected_option ) == 'on' ? $selected_option : '';
			}

			$build_prompt = prwfr_update_tokens();

			// Get the api key added by user.
			$api_key = ( get_option( 'prwfr_openai_api_key' ) ) ? get_option( 'prwfr_openai_api_key' ) : 0;

			// Get the mode name.
			$model_name = ( get_option( 'prwfr_api_model_name' ) ) ? get_option( 'prwfr_api_model_name' ) : 0;

			// // // $api_key    = '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';
			// // // $model_name = 'gpt-3.5-turbo-0125';

			// // The API endpoint for the OpenAI completions API.
			$request_url = 'https://api.openai.com/v1/chat/completions';

			$request_body = array(
				'model'             => $model_name,
				'messages'          => array(
					array(
						'role'    => 'user',
						'content' => $build_prompt['prompt_to_send'],
					),
				),
				'max_tokens'        => 4096,
				'temperature'       => 0.7,
				'top_p'             => 1,
				'frequency_penalty' => 0,
				'presence_penalty'  => 0,
			);

			// Set up the arguments for the request, including the headers and body.
			$args = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $api_key,
				),
				'body'    => wp_json_encode( $request_body ),
				'timeout' => 100, // Increase the timeout to 100 seconds.
			);

			update_option( 'prwfr_current_ai_request', '' );

			// Make the POST request to the OpenAI.
			$response = wp_remote_post( $request_url, $args );

			// Check for errors in the response.
			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 500 ) {// Prepare the final response with the OpenAI API response.
				$final_response = array(
					'status'          => 1,
					'openai_response' => 'Request to OpenAI API failed.',
				);

				update_option( 'prwfr_api_request_created_status', 'failed' );

			}

			// Check for errors in the response on quota exced.
			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 429 ) {

				// Prepare the final response with the OpenAI API response .
				$final_response = array(
					'status'          => 0,
					'openai_response' => 'insufficient_quota',
				);

				update_option( 'prwfr_api_request_created_status', 'insufficient_quota' );

			}

			// Check for errors in the response on incorrect API Key.
			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 401 ) {

				// Prepare the final response with the OpenAI API response .
				$final_response = array(
					'status'          => 0,
					'openai_response' => 'incorrect_api',
				);
				update_option( 'prwfr_api_request_created_status', 'incorrect_api' );

			}

			// Check for errors if the system is overloaded.
			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 503 ) {

				// Prepare the final response with the OpenAI API response .
				$final_response = array(
					'status'          => 0,
					'openai_response' => 'system_overloaded',
				);
				update_option( 'prwfr_api_request_created_status', 'system_overloaded' );

			}

			// Check for errors if the system is overloaded.
			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {

				// Decode the response from JSON .
				$response_data = json_decode( wp_remote_retrieve_body( $response ), true );

				// Prepare the final response with the OpenAI API response .
				$final_response = array(
					'status'          => 1,
					'openai_response' => $response_data,
				);

				update_option( 'prwfr_api_request_created_status', 'response_recieved' );

			}

			$headers = wp_remote_retrieve_headers( $response );

			// Get the body content.
			$body    = wp_remote_retrieve_body( $response );
			$content = json_decode( $body, true );

			// Calculate tokens used (if possible from content).
			$tokens_used = isset( $content['usage']['total_tokens'] ) ? $content['usage']['total_tokens'] : 0;

			$recommendations_recurrence['prwfr_ai_recurrence']       = get_option( 'prwfr_recurrence_period_ai' );
			$recommendations_recurrence['prwfr_ai_weekly_type']      = get_option( 'prwfr_weekly_save_recommendations' );
			$recommendations_recurrence['prwfr_ai_weekly_date_time'] = get_option( 'prwfr_ai_recommendations_everyweek' ) . '-' . get_option( 'prwfr_ai_recommendations_weekly_time' );
			$recommendations_recurrence['prwfr_ai_weekly_email']     = get_option( 'prwfr_ai_admin_email' );

			$association_prod_cat_ids['products']            = get_option( 'prwfr_multiple_products_check' );
			$association_prod_cat_ids['categories']          = get_option( 'prwfr_multiple_categories_check' );
			$association_prod_cat_ids['selected_categories'] = get_option( 'prwfr_category_selection' );
			$association_prod_cat_ids['selected_products']   = get_option( 'prwfr_product_selection' );

			// // Insert the log into the database.
			// $wpdb->insert(
			// 	$wpdb->prefix . 'prwfr_api_request_log',
			// 	array(
			// 		'prompt'                          => $build_prompt['prompt_to_save'],
			// 		'response'                        => $body,
			// 		'status'                          => $final_response['status'],
			// 		'tokens_used'                     => $tokens_used,
			// 		'recommendations_recurrence'      => wp_json_encode( $recommendations_recurrence ),
			// 		'associated_product_category_ids' => wp_json_encode( $association_prod_cat_ids ),
			// 		'product_details'                 => implode( ',', $selected_product_detail ),
			// 		'about_store'                     => get_option( 'prwfr_about_store' ),
			// 	),
			// 	array(
			// 		'%s',
			// 		'%s',
			// 		'%d',
			// 		'%d',
			// 		'%s',
			// 		'%s',
			// 		'%s',
			// 		'%s',
			// 	)
			// );

			update_option( 'prwfr_ai_request_logs', $final_response );
			update_option( 'response_ai', $final_response );

			prwfr_save_product_data( get_option( 'prwfr_ai_request_logs' ) );
		}
	}
}

function prwfr_save_product_data( $product_data ) {

	// If choices set.
	if ( isset( $product_data['openai_response']['choices'] ) ) {

		// Final reponse data.
		$final_data           = $product_data['openai_response']['choices'][0]['message']['content'];
		$ai_recommendations   = str_replace( 'json', '', $final_data );
		$ai_recommendations   = str_replace( '```', '', $ai_recommendations );
		$recommendations_data = json_decode( $ai_recommendations, true );

		if ( ! empty( $recommendations_data ) ) {
			foreach ( $recommendations_data as $key => $item ) {
				update_post_meta( $key, 'prwfr_ai_generated_product_recommendations', $item );

			}
		}
	}

	update_option( 'prwfr_api_request_created_status', 'fulfilled' );
}

add_action( 'admin_notices', 'prwfr_ai_admin_notice' );

/**
 * Request Status Notice Rendering.
 */
function prwfr_ai_admin_notice() {

	$reload_page = esc_url( $_SERVER['REQUEST_URI'] );

	if ( get_option( 'prwfr_recurrence_period_ai' ) == 'one_time' ) {
		if ( ( get_option( 'prwfr_display_ai_request_notice' ) == 'yes' ) ) {
			// Show notice if request fullfilled.
			if ( 'fulfilled' !== get_option( 'prwfr_api_request_created_status ' ) ) {

				// For pending request.
				if ( 'created' === get_option( 'prwfr_api_request_created_status ' ) || 'pending' === get_option( 'prwfr_api_request_created_status ' ) ) {
					?>
					<div class="notice notice-warning is-dismissible">
						<p><b><?php _e( 'Product Recommendations for WooCommerce', 'sft-product-recommendations-woocommerce' ); ?></b></p>
						<p>
							<b><?php _e( 'Your request is currently being processed. We appreciate your patience and will notify you as soon as it\'s ready!', 'sft-product-recommendations-woocommerce' ); ?></b>
						</p>
						<p>
							<b><?php _e( 'Actions you can perform: ', 'sft-product-recommendations-woocommerce' ); ?><a href="<?php echo $reload_page; ?>"><?php _e( 'Reload Page', 'sft-product-recommendations-woocommerce' ); ?></a></b>
						</p>
					</div>
					<?php
				}
			} else {
				// Get the API response data.
				$api_response_data = get_option( 'prwfr_ai_request_logs' );

				// For all false case.
				switch ( $api_response_data['openai_response'] ) {
					case 'insufficient_quota':
						?>
						<div class="notice notice-error is-dismissible">
							<p><b><?php _e( 'Product Recommendations for WooCommerce', 'sft-product-recommendations-woocommerce' ); ?></b></p>
							<p>
								<b>
									<?php _e( 'We\'re sorry, but your current request could not be processed due to insufficient quota remaining on your API key. It appears that you have used up most of your allocated quota. Please check your API usage or consider upgrading your plan.', 'sft-product-recommendations-woocommerce' ); ?>
								</b>
							</p>
						</div>
						<?php
						break;
					case 'incorrect_api':
						?>
						<div class="notice notice-error is-dismissible">
							<p><b><?php _e( 'Product Recommendations for WooCommerce', 'sft-product-recommendations-woocommerce' ); ?></b></p>
							<p>
								<b>
									<?php _e( 'Your API Key is incorrect! Please double-check your entry and try again.', 'sft-product-recommendations-woocommerce' ); ?>
								</b>
							</p>
						</div>
						<?php
						break;
					case 'system_overloaded':
						?>
						<div class="notice notice-error is-dismissible">
							<p><b><?php _e( 'Product Recommendations for WooCommerce', 'sft-product-recommendations-woocommerce' ); ?></b></p>
							<p>
								<b>
									<?php _e( 'Unfortunately, we were unable to fulfill your request at this time because the API system is currently experiencing heavy load. Our servers are working at full capacity. Please try again in a few moments when the system has stabilized.', 'sft-product-recommendations-woocommerce' ); ?>
								</b>
							</p>
						</div>
						<?php
						break;
					default:
						if ( isset( $api_response_data['openai_response']['choices'] ) ) {

							?>
							<div class="notice notice-success is-dismissible">
								<p><b><?php _e( 'Product Recommendations for WooCommerce', 'sft-product-recommendations-woocommerce' ); ?></b></p>
								<p>
									<b>
										<?php _e( 'Your request has been successfully fulfilled!', 'sft-product-recommendations-woocommerce' ); ?>
									</b>
								</p>
							</div>
							<?php

						}
						break;
				}

				// Reset the hit button option.
				update_option( 'prwfr_prompt_request_button_hit', 0 );
				update_option( 'prwfr_display_ai_request_notice', 'no' );
			}
		}
	}
}

// ------------------------------------------ New Feature Notice ------------------------------------.


add_action( 'admin_notices', 'prwfr_updated_features_admin_notice' );


/**
 * Related pro new update notice.
 */
function prwfr_updated_features_admin_notice() {

	// Check if the notice has been dismissed.
	$current_version = '2.0.0';

	// Check the user meta.
	if ( metadata_exists( 'user', get_current_user_id(), 'prwfr_latest_version_read_message' ) ) {

		$prwfr_notice_user_meta = get_user_meta( get_current_user_id(), 'prwfr_latest_version_read_message', true );
		$notice_read_version    = $prwfr_notice_user_meta['version'];

		if ( $notice_read_version != $current_version ) {
			$prwfr_show_notice = true;
		} else {
			$prwfr_show_notice = false;
		}
	} else {
		$prwfr_show_notice = true;
	}

	if ( ! $prwfr_show_notice ) {
		return;
	}
	?>


   <!-- Notice div -->
   <div class="notice notice-warning is-dismissible prwfr-custom-notice" data-notice="prwfr_new_features_notice">
	   <h3>
		   <?php echo esc_html__( '🎉 Exciting New AI Features in AI Product Recommendations for WooCommerce (v2.0.0) !', 'sft-product-recommendations-woocommerce' ); ?>
	   </h3>


	   <?php echo esc_html__( 'We’re excited to launch the latest update to our AI Product Recommendations for WooCommerce Plugin, leveraging Chat GPT technology to revolutionize how you connect with your customers. This update enhances your eCommerce platform by offering more precise and relevant product suggestions, designed to increase your Average Order Value (AOV) and boost your sales.', 'sft-product-recommendations-woocommerce' ); ?>


	   <h4><?php echo esc_html__( 'What’s New:', 'sft-product-recommendations-woocommerce' ); ?></h4>
	   <ul>
			<li>&#x2022; <?php echo esc_html__( 'Get AI-powered personalized product suggestions tailored to each customer\'s browsing and purchase history.', 'sft-product-recommendations-woocommerce' ); ?></li>
			<li>&#x2022; <?php echo esc_html__( 'Get Recently Viewed Products Email Notifications that remind users about their top 5 priciest viewed items, sent after specific hours to drive conversions.', 'sft-product-recommendations-woocommerce' ); ?></li>
	   </ul>


	   <a style="text-decoration:none;">
		   <button style="cursor:pointer;" class="prwfr-notice-button" onclick="window.open('https://www.saffiretech.com/blog/how-to-get-ai-product-recommendations-in-woocommerce?utm_source=wp_plugin&utm_medium=notice&utm_campaign=blog&utm_id=c1&utm_term=ai_update&utm_content=prwfr', '_blank')">
			   <svg fill="#FFD700" height="24px" width="24px" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M12,17c0.8-4.2,1.9-5.3,6.1-6.1c0.5-0.1,0.8-0.5,0.8-1s-0.3-0.9-0.8-1C13.9,8.1,12.8,7,12,2.8C11.9,2.3,11.5,2,11,2 c-0.5,0-0.9,0.3-1,0.8C9.2,7,8.1,8.1,3.9,8.9C3.5,9,3.1,9.4,3.1,9.9s0.3,0.9,0.8,1c4.2,0.8,5.3,1.9,6.1,6.1c0.1,0.5,0.5,0.8,1,0.8 S11.9,17.4,12,17z"></path> <path d="M22,24c-2.8-0.6-3.4-1.2-4-4c-0.1-0.5-0.5-0.8-1-0.8s-0.9,0.3-1,0.8c-0.6,2.8-1.2,3.4-4,4c-0.5,0.1-0.8,0.5-0.8,1 s0.3,0.9,0.8,1c2.8,0.6,3.4,1.2,4,4c0.1,0.5,0.5,0.8,1,0.8s0.9-0.3,1-0.8c0.6-2.8,1.2-3.4,4-4c0.5-0.1,0.8-0.5,0.8-1 S22.4,24.1,22,24z"></path> <path d="M29.2,14c-2.2-0.4-2.7-0.9-3.1-3.1c-0.1-0.5-0.5-0.8-1-0.8c-0.5,0-0.9,0.3-1,0.8c-0.4,2.2-0.9,2.7-3.1,3.1 c-0.5,0.1-0.8,0.5-0.8,1s0.3,0.9,0.8,1c2.2,0.4,2.7,0.9,3.1,3.1c0.1,0.5,0.5,0.8,1,0.8c0.5,0,0.9-0.3,1-0.8 c0.4-2.2,0.9-2.7,3.1-3.1c0.5-0.1,0.8-0.5,0.8-1S29.7,14.1,29.2,14z"></path> <path d="M5.7,22.3C5.4,22,5,21.9,4.6,22.1c-0.1,0-0.2,0.1-0.3,0.2c-0.1,0.1-0.2,0.2-0.2,0.3C4,22.7,4,22.9,4,23s0,0.3,0.1,0.4 c0.1,0.1,0.1,0.2,0.2,0.3c0.1,0.1,0.2,0.2,0.3,0.2C4.7,24,4.9,24,5,24c0.1,0,0.3,0,0.4-0.1s0.2-0.1,0.3-0.2 c0.1-0.1,0.2-0.2,0.2-0.3C6,23.3,6,23.1,6,23s0-0.3-0.1-0.4C5.9,22.5,5.8,22.4,5.7,22.3z"></path> <path d="M28,7c0.3,0,0.5-0.1,0.7-0.3C28.9,6.5,29,6.3,29,6s-0.1-0.5-0.3-0.7c-0.1-0.1-0.2-0.2-0.3-0.2c-0.2-0.1-0.5-0.1-0.8,0 c-0.1,0-0.2,0.1-0.3,0.2C27.1,5.5,27,5.7,27,6c0,0.3,0.1,0.5,0.3,0.7C27.5,6.9,27.7,7,28,7z"></path> </g> </g></svg>
			   <?php echo esc_html__( ' Click here to view', 'sft-product-recommendations-woocommerce' ); ?>
		   </button>
	   </a>
   </div>
	<?php
}


add_action( 'wp_ajax_prwfr_update_new_feature_notice_read', 'prwfr_update_new_feature_notice_read_callback' );
add_action( 'wp_ajax_nopriv_prwfr_update_new_feature_notice_read', 'prwfr_update_new_feature_notice_read_callback' );


/**
 * Update meta on dismiss.
 */
function prwfr_update_new_feature_notice_read_callback() {

	// Current version.
	$current_version = '2.0.0';

	// Get current user id.
	$current_user_id = get_current_user_id();

	$prwfr_notice_status = array(
		'prwfr_update_notice_read' => 'read',
		'version'                  => $current_version,
	);

	update_user_meta( $current_user_id, 'prwfr_latest_version_read_message', $prwfr_notice_status );

	echo 'status_updated';
	wp_die();
}

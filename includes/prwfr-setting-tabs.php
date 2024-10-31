<?php

add_action( 'admin_menu', 'prwfr_setting_api_tabs' );

/**
 * Add options page first.
 */
function prwfr_setting_api_tabs() {
	add_menu_page( '', __( 'Product Recommendations', 'sft-product-recommendations-woocommerce' ), 'manage_options', 'prwfr_menu', 'prwfr__rvp_setting_tabs' );
	add_submenu_page( 'prwfr_menu', '', __( 'Post-Purchase Products', 'sft-product-recommendations-woocommerce' ), 'manage_options', 'prwfr_post_purcahse_submenu', 'prwfr_post_purcahse_set_tabs' );
	add_submenu_page( 'prwfr_menu', '', __( 'Product Discovery Features', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />', 'manage_options', 'prwfr_product_discovery_submenu', 'prwfr_product_discovery_set_tabs' );
	add_submenu_page( 'prwfr_menu', '', __( 'General Settings', 'sft-product-recommendations-woocommerce' ), 'manage_options', 'prwfr_general_submenu', 'prwfr_general_set_tabs' );
	add_submenu_page(
		'prwfr_menu',
		'Chat GPT (API) Key Settings',
		__( 'Chat GPT (API) Key Settings', 'woocommerce-related-products-pro' ),
		'manage_options',
		'prwfr_api_setting_page',
		'prwfr_api_integration_settings_section'
	);
}

/**
 * Displaying page HTML and print settings.
 */
function prwfr__rvp_setting_tabs() {

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	$all_products = prwfr_get_all_products();

	// Get all WooCommerce product categories.
	$product_categories = get_terms( 'product_cat', array( 'hide_empty' => false ) );

	$selected_products     = get_option( 'prwfr_product_selection' );
	$selected_categories   = get_option( 'prwfr_category_selection' );
	$time_interval         = get_option( 'prwfr_ai_recommendations_weekly_time' );
	$days_of_week          = array( __( 'Monday', 'sft-product-recommendations-woocommerce' ), __( 'Tuesday', 'sft-product-recommendations-woocommerce' ), __( 'Wednesday', 'sft-product-recommendations-woocommerce' ), __( 'Thursday', 'sft-product-recommendations-woocommerce' ), __( 'Friday', 'sft-product-recommendations-woocommerce' ), __( 'Saturday', 'sft-product-recommendations-woocommerce' ), __( 'Sunday', 'sft-product-recommendations-woocommerce' ) );
	$value                 = get_option( 'prwfr_ai_recommendations_everyweek' );
	$display_prompt        = get_option( 'prwfr_ai_request_prompt' ) ? get_option( 'prwfr_ai_request_prompt' ) : get_option( 'prwfr_default_ai_prompt' );
	$tokens_used           = get_option( 'prwfr_tokens_used' ) ? get_option( 'prwfr_tokens_used' ) : '2000';
	$validation_key_status = get_option( 'prwfr_api_valid_key_status' ) ? get_option( 'prwfr_api_valid_key_status' ) : '';

	// Response status.
	$key_response_status = get_option( 'prwfr_api_request_created_status' ) ? get_option( 'prwfr_api_request_created_status' ) : '';

	// Api settings page url.
	$api_settings_page = admin_url( 'admin.php?page=prwfr_api_setting_page' );
	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php
		$tabs = array(
			'rvp'         => __( 'Recently Viewed Products', 'sft-product-recommendations-woocommerce' ),
			'rvp_related' => __( 'Products related to Recently Viewed Products', 'sft-product-recommendations-woocommerce' ),
			'rvp_onsale'  => __( 'On-Sale Products related to Recently Viewed Products', 'sft-product-recommendations-woocommerce' ),
		);

		$current_tab = isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ? sanitize_key( $_GET['tab'] ) : array_key_first( $tabs );
		?>

		<form method="post" action="options.php" class="prwfr-setting-tabs">
			<nav class="nav-tab-wrapper">

				<?php
				foreach ( $tabs as $tab => $name ) {
					$current = $tab === $current_tab ? ' nav-tab-active' : '';
					$url     = admin_url( 'admin.php' );
					echo wp_kses_post( "<a class=\"nav-tab{$current}\" href=\"{$url}?page=prwfr_menu&tab={$tab}\">{$name}</a>" );
				}
				?>

				<!-- <div class="prwfr-upgrade-pro-btn">
					<a href='https://www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=profiled&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr' target='_blank'> 
						<input type='button' value='<?php // esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>' class="btn"/>
					</a>
				</div> -->

				<div style="display: inline-block; float: right;">
					<button id="prwfr-popup-button" class="button button-secondary prwfr-ai-recommendations">
						<svg fill="#FFFFFF" height="24px" width="24px" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M12,17c0.8-4.2,1.9-5.3,6.1-6.1c0.5-0.1,0.8-0.5,0.8-1s-0.3-0.9-0.8-1C13.9,8.1,12.8,7,12,2.8C11.9,2.3,11.5,2,11,2 c-0.5,0-0.9,0.3-1,0.8C9.2,7,8.1,8.1,3.9,8.9C3.5,9,3.1,9.4,3.1,9.9s0.3,0.9,0.8,1c4.2,0.8,5.3,1.9,6.1,6.1c0.1,0.5,0.5,0.8,1,0.8 S11.9,17.4,12,17z"></path> <path d="M22,24c-2.8-0.6-3.4-1.2-4-4c-0.1-0.5-0.5-0.8-1-0.8s-0.9,0.3-1,0.8c-0.6,2.8-1.2,3.4-4,4c-0.5,0.1-0.8,0.5-0.8,1 s0.3,0.9,0.8,1c2.8,0.6,3.4,1.2,4,4c0.1,0.5,0.5,0.8,1,0.8s0.9-0.3,1-0.8c0.6-2.8,1.2-3.4,4-4c0.5-0.1,0.8-0.5,0.8-1 S22.4,24.1,22,24z"></path> <path d="M29.2,14c-2.2-0.4-2.7-0.9-3.1-3.1c-0.1-0.5-0.5-0.8-1-0.8c-0.5,0-0.9,0.3-1,0.8c-0.4,2.2-0.9,2.7-3.1,3.1 c-0.5,0.1-0.8,0.5-0.8,1s0.3,0.9,0.8,1c2.2,0.4,2.7,0.9,3.1,3.1c0.1,0.5,0.5,0.8,1,0.8c0.5,0,0.9-0.3,1-0.8 c0.4-2.2,0.9-2.7,3.1-3.1c0.5-0.1,0.8-0.5,0.8-1S29.7,14.1,29.2,14z"></path> <path d="M5.7,22.3C5.4,22,5,21.9,4.6,22.1c-0.1,0-0.2,0.1-0.3,0.2c-0.1,0.1-0.2,0.2-0.2,0.3C4,22.7,4,22.9,4,23s0,0.3,0.1,0.4 c0.1,0.1,0.1,0.2,0.2,0.3c0.1,0.1,0.2,0.2,0.3,0.2C4.7,24,4.9,24,5,24c0.1,0,0.3,0,0.4-0.1s0.2-0.1,0.3-0.2 c0.1-0.1,0.2-0.2,0.2-0.3C6,23.3,6,23.1,6,23s0-0.3-0.1-0.4C5.9,22.5,5.8,22.4,5.7,22.3z"></path> <path d="M28,7c0.3,0,0.5-0.1,0.7-0.3C28.9,6.5,29,6.3,29,6s-0.1-0.5-0.3-0.7c-0.1-0.1-0.2-0.2-0.3-0.2c-0.2-0.1-0.5-0.1-0.8,0 c-0.1,0-0.2,0.1-0.3,0.2C27.1,5.5,27,5.7,27,6c0,0.3,0.1,0.5,0.3,0.7C27.5,6.9,27.7,7,28,7z"></path> </g> </g></svg>
						<div><?php echo esc_html__( 'AI Recommendations !', 'sft-product-recommendations-woocommerce' ); ?></div>
						<div class="prwfr-popup-btn-tooltip-container" data-tooltip="Configuring Related, Upsell, and Cross-Sell Products with AI.">
							<svg width="18px" height="18px" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0" transform="translate(5.88,5.88), scale(0.51)"><rect x="0" y="0" width="24.00" height="24.00" rx="12" fill="#000000" strokewidth="0"></rect></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM12 17.75C12.4142 17.75 12.75 17.4142 12.75 17V11C12.75 10.5858 12.4142 10.25 12 10.25C11.5858 10.25 11.25 10.5858 11.25 11V17C11.25 17.4142 11.5858 17.75 12 17.75ZM12 7C12.5523 7 13 7.44772 13 8C13 8.55228 12.5523 9 12 9C11.4477 9 11 8.55228 11 8C11 7.44772 11.4477 7 12 7Z" fill="#ffffff"></path> </g></svg>
							<div class="prwfr-ai-popup-btn-tooltip"><?php echo esc_html__( 'Added configuration for Product Recommendations in the shortcode using ChatGPT', 'sft-product-recommendations-woocommerce' ); ?></div>
						</div>
					</button>
				</div>

			</nav>

			<div class="prwfr-setting-section">
				<?php
				settings_fields( "prwfr__page_{$current_tab}_settings" );
				do_settings_sections( "prwfr__page_{$current_tab}" );
				?>
				<div class="prwfr-submt-btn"><?php submit_button(); ?></div>
			</div>
		</form>
	</div>

	<!-- Upgrade footer -->
	<div class="sft-prwfr-upgrade-to-pro-banner">
		<div class="sft-uppro-inner-container">
			<div class="sft-uppro-main-logo">
				<a href="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
					<img src="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
				</a>
			</div>
		</div>

		<div class="sft-uppro-hidden-desktop">
			<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2>
		</div>

		<div class="sft-uppro-details-container">
			<div class="sft-uppro-money-back-guarantee">
				<div>
					<a href="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
						<img src="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
					</a>
				</div>
				<div>
					<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2> 
					<h3><?php esc_html_e( '100% Risk-Free Money Back Guarantee!', 'sft-product-recommendations-woocommerce' ); ?></h3>
					<p><?php esc_html_e( 'We guarantee you a complete refund for new purchases or renewals if a request is made within 15 Days of purchase.', 'sft-product-recommendations-woocommerce' ); ?></p>
					<div class="prwfr-upgrade-pro-btn">
						<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
							<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
								<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
							</button>
						</a>
					</div>
				</div>
			</div>

			<div class="sft-uppro-features-container">
				<h3> <?php echo esc_html__( 'Pro Features', 'sft-product-recommendations-woocommerce' ); ?></h3>
				<ul>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'AI powered Product Recommendations:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Leverage the power of ChatGPT to create personalized product recommendations for your customers.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Recommended Products" Emails  based on Browsing History:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Customers get "Recommended Products" email notifications based on their browsing history.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Price Drop" Email Alerts for your Featured Sale Items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Sends "Price Drop" email to customers on products marked as "Featured Sale Item" at specified intervals of your choice.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Buy It Again" Widget & Purchase History Related items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Display previously bought items and similar items to your customers to boost repeat orders or similar orders.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Product Discovery Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Attract customers with the latest arrivals, top performers, and spotlighted items using customizable widgets.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Customization options for All Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Get a plethora of options to customize widget like Star Ratings, Title, Sale Price etc.', 'sft-product-recommendations-woocommerce' ); ?></li>
				</ul>
			</div>

		</div>

	</div>

	<script>
		function prwfrAiPopup(){
			Swal.fire({
				title: '<div class="prwfr-ai-popup-header"><?php echo esc_html__( 'AI PRODUCT RECOMMENDATIONS', 'sft-product-recommendations-woocommerce' ); ?></div>',
				showCloseButton: true,
				html: `
					<div class="prwfr-ai-popup">
						<div>
							<div class="prwfr-ai-section-heading">
								<?php echo esc_html__( 'AI General Settings', 'sft-product-recommendations-woocommerce' ); ?>
								<div class="prwfr-popup-btn-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/information-icon.svg' ); ?>" width="15px" height="15px" class="prwfr-popup-tooltip-icon">
									<div class="prwfr-ai-popup-btn-tooltip prwfr-tooltip-bottom-left"><?php echo esc_html__( 'Choose how frequently you want to receive AI product recommendations, whether as a one-time update or on a weekly basis. You can also set a specific date and time for generating and applying the suggestions.', 'sft-product-recommendations-woocommerce' ); ?></div>
								</div>
							</div>
							<div class="prwfr-ai-sub-section">
								<div><?php echo esc_html__( 'How often should recommendations be generated?', 'sft-product-recommendations-woocommerce' ); ?><span class="prwfr-required">*</span></div>
								<div class="prwfr-ai-radio-btn-container">
									<div>
										<input type="radio" id="one_time" name="prwfr_recurrence_period_ai" value="one_time"<?php echo checked( 'one_time', get_option( 'prwfr_recurrence_period_ai' ), false ); ?>>
										<label for="one_time"><?php echo esc_html__( 'One-Time', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
									<div>
										<input type="radio" id="weekly" name="prwfr_recurrence_period_ai" value="weekly"<?php echo checked( 'weekly', get_option( 'prwfr_recurrence_period_ai' ), false ); ?>/>
										<label for="weekly"><?php echo esc_html__( 'Weekly', 'sft-product-recommendations-woocommerce' ); ?></label>
										<div class="prwfr-pro-lock-tooltip-container">
											<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
											<div class="prwfr-pro-lock-btn-tooltip">
												<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
												<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
													<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="prwfr-ai-recommendations-weekly prwfr-ai-sub-section">
								<div>
									<?php echo esc_html__( 'On which day and at what time should recommendations be generated?', 'sft-product-recommendations-woocommerce' ); ?>
									<div class="prwfr-pro-lock-tooltip-container">
										<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
										<div class="prwfr-pro-lock-btn-tooltip">
											<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
											<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
												<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
											</a>
										</div>
									</div>
								</div>
								<div class="prwfr-ai-day-time-container">
									<div>
										<select id="day-of-week" name="prwfr_ai_recommendations_everyweek">
											<?php
											foreach ( $days_of_week as $day ) {
												if ( ucfirst( $value ) == $day ) {
													?>
													<option selected="selected" value='<?php echo esc_html( ucfirst( $value ) ); ?>'><?php echo esc_html( $day ); ?></option>
													<?php
												} else {
													?>
													<option value='<?php echo esc_html( $day ); ?>'><?php echo esc_html( $day ); ?></option>
													<?php
												}
											}
											?>
										</select>
									</div>

									<div>
										<input type="time" name="prwfr_ai_recommendations_weekly_time" value="12:00" id="time-of-day">
									</div>
								</div> 
							</div>

							<div class="prwfr-save-recommendations-weekly prwfr-ai-sub-section">
								<div><?php echo esc_html__( 'Do you want to directly save the recommendations made by AI?', 'sft-product-recommendations-woocommerce' ); ?></div>
								<div class="prwfr-ai-radio-btn-container" style="flex-direction: column; align-items: flex-start;">
									<div>
										<input type="radio" id="prwfr_weekly_automatic" name="prwfr_weekly_save_recommendations" value="automatic" disabled>
										<label for="prwfr_weekly_automatic"><?php echo esc_html__( 'Yes, save recommendations automatically', 'sft-product-recommendations-woocommerce' ); ?></label>
										<div class="prwfr-pro-lock-tooltip-container">
											<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
											<div class="prwfr-pro-lock-btn-tooltip">
												<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
												<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
													<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
												</a>
											</div>
										</div>
									</div>
									<div>
										<input type="radio" id="prwfr_weekly_manual" name="prwfr_weekly_save_recommendations" value="manual" checked="checked"/>
										<label for="prwfr_weekly_manual"><?php echo esc_html__( 'No, I want to review the recommendations before saving them', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
								</div>
							</div>

							<div class="prwfr-ai-recommendations-admin-email prwfr-ai-sub-section">
							<div>
								<label for="prwfr_ai_admin_email"><?php echo esc_html__( 'Provide an email address to receive notifications when recommendations are ready', 'sft-product-recommendations-woocommerce' ); ?></label>
								<div class="prwfr-pro-lock-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
									<div class="prwfr-pro-lock-btn-tooltip" style="width: 130px;">
										<?php echo esc_html__( 'Available in ', 'sft-product-recommendations-woocommerce' ); ?>
										<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
											<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
										</a>
									</div>
								</div>
							</div>
							<input type="text" disabled id="prwfr_ai_admin_email" name="prwfr_ai_admin_email" style="max-width:312px; width:100%;" value="<?php echo get_option( 'admin_email' ); ?>"/>
							</div>

						</div>
						
						<div>
							<div class="prwfr-ai-section-heading">
								<?php echo esc_html__( 'Product Selection Settings', 'sft-product-recommendations-woocommerce' ); ?>
								<div class="prwfr-popup-btn-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/information-icon.svg' ); ?>" width="15px" height="15px" class="prwfr-popup-tooltip-icon">
									<div class="prwfr-ai-popup-btn-tooltip"><?php echo esc_html__( 'Select specific products or categories for the AI to generate product recommendations.', 'sft-product-recommendations-woocommerce' ); ?></div>
								</div>
							</div>
							<div class="prwfr-ai-sub-section">

								<div><?php echo esc_html__( 'Select specific products or categories for AI recommendations', 'sft-product-recommendations-woocommerce' ); ?></div>

								<div class="prwfr-ai-checkbox-container">
									<div>
										<input type="checkbox" id="prwfr_multiple_categories_check" name="prwfr_multiple_categories_check" value="on" <?php echo checked( 'on', get_option( 'prwfr_multiple_categories_check' ), false ); ?> disabled />
										<label class="prwfr-ai-checkbox-label" for="prwfr_multiple_categories_check"><?php echo esc_html__( 'Select Categories', 'sft-product-recommendations-woocommerce' ); ?></label>
										<div class="prwfr-pro-lock-tooltip-container">
											<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
											<div class="prwfr-pro-lock-btn-tooltip">
												<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
												<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
													<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
												</a>
											</div>
										</div>
										</div>
									<div>
										<input type="checkbox" id="prwfr_multiple_products_check" name="prwfr_multiple_products_check" value="on" <?php echo checked( 'on', get_option( 'prwfr_multiple_products_check' ), false ); ?> />
										<label class="prwfr-ai-checkbox-label" for="prwfr_multiple_products_check"><?php echo esc_html__( 'Select products', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
								</div>

							</div>

							<div class="prwfr-ai-sub-section prwfr-align-start prwfr-all-cat-selection">

								<div><?php echo esc_html__( 'Choose Categories', 'sft-product-recommendations-woocommerce' ); ?><span class="prwfr-required">*</span></div>

								<span>
									<select class="prwfr_category_selection" name="prwfr_category_selection[]" id="prwfr_category_selection" multiple>
										
										<?php
										foreach ( $product_categories as $product_category ) {

											if ( ! empty( $selected_categories ) && in_array( $product_category->term_id, $selected_categories ) ) {
												?>
												<option selected="selected" value='<?php echo esc_attr( $product_category->term_id ); ?>'><?php echo esc_html( $product_category->name ); ?></option>
												<?php
											} else {
												?>
												<option value='<?php echo esc_attr( $product_category->term_id ); ?>'><?php echo esc_html( $product_category->name ); ?></option>
												<?php
											}
										}
										?>

									</select>
								</span>

							</div>

							<div class="prwfr-ai-sub-section prwfr-align-start prwfr-products-selection">
								
								<div><?php echo esc_html__( 'Select specific products to be included in the recommendations', 'sft-product-recommendations-woocommerce' ); ?><span class="prwfr-required">*</span></div>
								
								<div class="prwfr-ai-settings-placeholder"><?php echo esc_html__( 'You can select only', 'sft-product-recommendations-woocommerce' ); ?> <b><?php echo esc_html__( '5 Products', 'sft-product-recommendations-woocommerce' ); ?></b></div>

								<span class="prwfr-all-products-list">
									<select class="prwfr_product_selection" name="prwfr_product_selection[]" id="prwfr_product_selection" multiple>
										<?php
										foreach ( $all_products as $product ) {

											if ( ! empty( $selected_products ) && in_array( $product['product_id'], $selected_products ) ) {
												?>
												<option selected="selected" value='<?php echo esc_attr( $product['product_id'] ); ?>'><?php echo esc_html( $product['label'] ); ?></option>
												<?php
											} else {
												?>
												<option value='<?php echo esc_attr( $product['product_id'] ); ?>'><?php echo esc_html( $product['label'] ); ?></option>
												<?php
											}
										}
										?>

									</select>
								</span>

							</div>									

							<div class="prwfr-ai-sub-section">
								
								<div>
									<?php echo esc_html__( 'Select product details For AI Prompt', 'sft-product-recommendations-woocommerce' ); ?><span class="prwfr-required">*</span>
									<div class="prwfr-pro-lock-tooltip-container">
										<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
										<div class="prwfr-pro-lock-btn-tooltip">
											<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
											<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
												<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
											</a>
										</div>
									</div>
								</div>

								<div class="prwfr-ai-checkbox-container" style="flex-direction: column; gap: 10px;">
									<div>
										<input type="checkbox" id="prwfr_products_url" name="prwfr_products_url" value="on" <?php echo checked( 'on', get_option( 'prwfr_products_url' ), false ); ?> disabled />
										<label for="prwfr_products_url"><?php echo esc_html__( 'Product URL', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
									<div>
										<input type="checkbox" id="prwfr_products_name" name="prwfr_products_name" value="on" <?php echo checked( 'on', get_option( 'prwfr_products_name' ), false ); ?> />
										<label for="prwfr_products_name"><?php echo esc_html__( 'Product Name', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
									<div>
										<input type="checkbox" id="prwfr_products_price" name="prwfr_products_price" value="on" <?php echo checked( 'on', get_option( 'prwfr_products_price' ), false ); ?> disabled />
										<label for="prwfr_products_price"><?php echo esc_html__( 'Product Price', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
									<div>
										<input type="checkbox" id="prwfr_products_desc" name="prwfr_products_desc" value="on" <?php echo checked( 'on', get_option( 'prwfr_products_desc' ), false ); ?> />
										<label for="prwfr_products_desc"><?php echo esc_html__( 'Product Description( Short Description )', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
									<div>
										<input type="checkbox" id="prwfr_products_desc_long" name="prwfr_products_desc_long" value="on" <?php echo checked( 'on', get_option( 'prwfr_products_desc_long' ), false ); ?> disabled />
										<label for="prwfr_products_desc_long"><?php echo esc_html__( 'Product Description( Long Description )', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
									<div>
										<input type="checkbox" id="prwfr_products_categories" name="prwfr_products_categories" value="on" <?php echo checked( 'on', get_option( 'prwfr_products_categories' ), false ); ?> disabled />
										<label for="prwfr_products_categories"><?php echo esc_html__( 'Product Category', 'sft-product-recommendations-woocommerce' ); ?></label>
									</div>
								</div>
							</div>

						</div>

						<div>
							<div class="prwfr-ai-section-heading">

								<?php echo esc_html__( 'Set Number of Product Suggestions per Product', 'sft-product-recommendations-woocommerce' ); ?>
								
								<div class="prwfr-popup-btn-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/information-icon.svg' ); ?>" width="15px" height="15px" class="prwfr-popup-tooltip-icon">
									<div class="prwfr-ai-popup-btn-tooltip"><?php echo esc_html__( 'Choose the number of suggestions you want to have for each Product.', 'sft-product-recommendations-woocommerce' ); ?></div>
								</div>

								<div class="prwfr-pro-lock-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
									<div class="prwfr-pro-lock-btn-tooltip">
										<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
										<a href="https://www.saffiretech.com/woocommerce-related-products-pro/">
											<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
										</a>
									</div>
								</div>

							</div>

							<div class="prwfr-ai-checkbox-container">
								<div>
								<input type="number" id="prwfr_ai_recommendations_limit" name="prwfr_ai_recommendations_limit" min="1" max="10" value="5" disabled>
								</div>
									<p id="prwfr-limit-message" style="color: red; display: none;"><?php echo esc_html__( 'Please enter a number between 1 and 10.', 'sft-product-recommendations-woocommerce' ); ?></p>
								</div>
							</div>
						<div>

						<div class="prwfr-ai-section-heading">
							<?php echo esc_html__( 'Product Sales Data Settings', 'sft-product-recommendations-woocommerce' ); ?>
							<div class="prwfr-popup-btn-tooltip-container">
								<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/information-icon.svg' ); ?>" width="15px" height="15px" class="prwfr-popup-tooltip-icon">
								<div class="prwfr-ai-popup-btn-tooltip"><?php echo esc_html__( 'Include your store\'s  sales data in AI-generated suggestions to enhance the relevance of recommendations by suggesting products that are often purchased together.', 'sft-product-recommendations-woocommerce' ); ?></div>
							</div>
							<div class="prwfr-pro-lock-tooltip-container">
								<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
								<div class="prwfr-pro-lock-btn-tooltip">
									<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
									<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
										<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
									</a>
								</div>
							</div>
						</div>
							
						<div class="prwfr-ai-sub-section prwfr-ai-checkbox-container">

							<div>
								<input type="checkbox" id="prwfr_fbt_data" name="prwfr_fbt_data" value="on" disabled /> <?php echo esc_html__( 'Include your store\'s sales data to receive the best recommendations.', 'sft-product-recommendations-woocommerce' ); ?>
							</div>
						</div>
						</div>
							
						<div>

							<div class="prwfr-ai-section-heading">
								<?php echo esc_html__( 'Describe Your Store', 'sft-product-recommendations-woocommerce' ); ?><span class="prwfr-required">*</span>
								<div class="prwfr-popup-btn-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/information-icon.svg' ); ?>" width="15px" height="15px" class="prwfr-popup-tooltip-icon">
									<div class="prwfr-ai-popup-btn-tooltip prwfr-tooltip-top-right"><?php echo esc_html__( 'Provide a description of your store to help the AI generate more tailored product recommendations based on your business needs.', 'sft-product-recommendations-woocommerce' ); ?></div>
								</div>
							</div>

							<div class="prwfr-ai-checkbox-container" style="flex-direction: column;">
									<textarea id="prwfr_about_store" name="prwfr_about_store" rows="3" placeholder="E.g. I have WooCommerce store that offers clothing and accessories for men and women, featuring a wide range of apparel and fashion items. The store is organized by categories, making it easy for customers to navigate and find what they need."><?php echo get_option( 'prwfr_about_store' ); ?></textarea>
							</div>
						</div>

						<div class="prwfr-ai-reset-save-container">
							<button id="prwfr_save_ai_settings" class="prwfr-btn"><?php echo esc_html__( 'Save Settings', 'sft-product-recommendations-woocommerce' ); ?> <span class="prwfr-ai-save-loader"></span></button>
							<button id="prwfr_reset_ai_settings"><?php echo esc_html__( 'Reset Settings', 'sft-product-recommendations-woocommerce' ); ?></button>
							<button id="prwfr_undo_ai_changes"><?php echo esc_html__( 'Undo Changes', 'sft-product-recommendations-woocommerce' ); ?></button> 
						</div>

						<div class="send_prompt prwfr-ai-outer-container">

							<div class="prwfr-ai-section-heading">
								<?php echo esc_html__( 'AI Prompt', 'sft-product-recommendations-woocommerce' ); ?><span class="prwfr-required">*</span>
								<div class="prwfr-popup-btn-tooltip-container">
									<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/information-icon.svg' ); ?>" width="15px" height="15px" class="prwfr-popup-tooltip-icon">
									<div class="prwfr-ai-popup-btn-tooltip prwfr-tooltip-top-right"><?php echo esc_html__( 'The default prompt is set to work seamlessly with Products but you can choose to edit the default prompt and add your own custom prompt if required.', 'sft-product-recommendations-woocommerce' ); ?></div>
								</div>
							</div>

							<div class="prwfr-prompt-default-edit-radio prwfr-ai-radio-btn-container" style="font-size: 14px;">
								<div>
									<input type="radio" class="prwfr_ai_prompt_default" id="prwfr_ai_prompt_default" name="prwfr_ai_prompt_type" value="default" checked="checked" />
									<label for="prwfr_ai_prompt_default"><?php echo esc_html__( 'Use Default Prompt', 'sft-product-recommendations-woocommerce' ); ?></label>
								</div>
								<div>
									<input type="radio" class="prwfr_ai_prompt_edit" id="prwfr_ai_prompt_edit" name="prwfr_ai_prompt_type" value="edit" />
									<label for="prwfr_ai_prompt_edit"><?php echo esc_html__( 'Customize Default Prompt', 'sft-product-recommendations-woocommerce' ); ?></label>
									<div class="prwfr-pro-lock-tooltip-container">
										<img src="<?php echo esc_attr( plugin_dir_url( dirname( __FILE__, 1 ) ) . 'assets/images/pro-crown-logo.svg' ); ?>" width="15px" height="15px" title="Available in Pro Version" class="prwfr-pro-version-lock alt">
										<div class="prwfr-pro-lock-btn-tooltip">
											<?php echo esc_html__( 'Complete Feature Available in ', 'sft-product-recommendations-woocommerce' ); ?>
											<a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/" target="_blank">
												<?php echo esc_html__( 'Pro Version', 'sft-product-recommendations-woocommerce' ); ?> 
											</a>
										</div>
									</div>
								</div>
							</div>

							<div class="prwfr-ai-prompt-container" id="prwfr_textarea_container">
								<textarea id="prwfr_ai_request_prompt" name="prwfr_ai_request_prompt" rows="4" style="width: 100%;"><?php echo esc_html( $display_prompt ); ?></textarea>
							</div>
							<div class="prwfr-tokens-request-container prwfr-ai-sent-prompt-btn-container">
								<span class="prwfr-token-status"></span>
								<div class="prprow-prompt-placeholder-container" style="margin: 12px 0px 8px 0px; display: flex; flex-direction: column; gap: 5px;">
									<div class="prwfr-ai-settings-placeholder"><?php echo esc_html__( 'Use placeholder {all_products} to use all products in prompt ', 'sft-product-recommendations-woocommerce' ); ?>
										<button class="prwfr-all-products-clipboard clipboard">&#128203;</button>
										<span class="prwfr-all-products-text-copied"></span>
									</div>
									<div class="prwfr-ai-settings-placeholder"><?php echo esc_html__( 'Use placeholder {selected_categories} to use selected categories in prompt', 'sft-product-recommendations-woocommerce' ); ?> 
									<button class="prwfr-selected-categories-clipboard clipboard">&#128203;</button><span class="prwfr-selected-categories-text-copied"></span>
									</div>
									<div class="prwfr-ai-settings-placeholder"><?php echo esc_html__( 'Use placeholder {selected_products} to use selected products in prompt', 'sft-product-recommendations-woocommerce' ); ?>
										<button class="prwfr-selected-products-clipboard clipboard">&#128203;</button><span class="prwfr-selected-products-text-copied"></span>
									</div>
									<div class="prwfr-ai-settings-placeholder"><?php echo esc_html__( 'Use placeholder {fbt_products} to use Sales data in prompt ', 'sft-product-recommendations-woocommerce' ); ?><button class="prwfr-fbt-data-clipboard clipboard">&#128203;</button><span class="prwfr-fbt-data-text-copied"></span></div>
								</div>
								<div class="prwfr-ai-request-warning"></div>
								<button id="prwfr-send-prompt-btn" class="prwfr-btn"><?php echo esc_html__( 'Create Request', 'sft-product-recommendations-woocommerce' ); ?></button>
							</div>
							
						</div>
					</div>`,
				customClass: "prwfr-popup",
				showConfirmButton: false,
				// willOpen: (popup) => {
				// 	popup.classList.add('swal-slide-down');
				// },
				// willClose: (popup) => {
				// 	popup.classList.remove('swal-slide-down');
				// 	popup.classList.add('swal-slide-up');
				// },
				// didClose: (popup) => {
				// 	// Delay to allow slide-up animation to complete
				// 	//console.log('Popup closed, cleaning up classes');
				// 	setTimeout(() => {
				// 		popup.classList.remove('swal-slide-up');
				// 	}, 500); // Match the duration of the CSS animation
				// }
			})
		}

		jQuery( '.prwfr-ai-recommendations' ).click(function(e){
			e.preventDefault();

			let validation_status = '<?php echo esc_js( $validation_key_status ); ?>';

			// Response status.
			let response_status = '<?php echo esc_js( $key_response_status ); ?>';

			if ( validation_status != 1 ) {

				// For invalid Api key.
				Swal.fire({
					text: '<?php echo esc_html__( 'Please Enter Your Valid API Key First !', 'sft-product-recommendations-woocommerce' ); ?>',
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: '<?php echo esc_html__( 'Configure API Key', 'sft-product-recommendations-woocommerce' ); ?>'
					}).then((result) => {
						if (result.isConfirmed) {

							// Move to Api key settings page.
							window.location.assign( '<?php echo esc_url( $api_settings_page ); ?>' );
						}
					});
			} else {

				if ( response_status != 'insufficient_quota' ) {

					if ((response_status != 'created') && (response_status != 'pending')) {
						prwfrAiPopup();

						// jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).hide();

						// jQuery( 'textarea#prwfr_ai_request_prompt' ).attr('disabled','disabled');
						// jQuery('select.prwfr_category_selection').multiSelect();
						// jQuery( 'select.prwfr_product_selection' ).multiSelect();

						jQuery( '.prwfr_product_selection').multiSelect();

						// jQuery('#prwfr_weekly_automatic, #prwfr_weekly_manual, .prwfr-ai-day-time-container, #prwfr_ai_admin_email, #prwfr_products_url, #prwfr_products_name, #prwfr_products_price, #prwfr_products_desc, #prwfr_products_desc_long, #prwfr_products_categories, #prwfr_ai_request_prompt, #prwfr_multiple_categories_check, #prwfr_multiple_products_check, #prwfr_fbt_data').closest('div').css('pointer-events', 'none');

						//Disable all remaining products after limit is reached
						jQuery('select.prwfr_product_selection').change( function() {
							if (jQuery('select.prwfr_product_selection option:selected').length >= 5){

								var nonSelectedProducts = jQuery('.prwfr_product_selection option').not(':selected');

								nonSelectedProducts.each(function() {
									var productOption = jQuery('input[value="' + jQuery(this).val() + '"]');
									productOption.prop('disabled', true);
								});

							}else{

								jQuery('.prwfr_product_selection option').each(function() {
									var productOption = jQuery('input[value="' + jQuery(this).val() + '"]');
									productOption.prop('disabled', false);
								});
							}
						});

						// jQuery( 'input[name=rprow_ai_prompt_type]' ).change( function(){
						jQuery(document).on('change', 'input[name=prwfr_ai_prompt_type]', function(){
							if( jQuery( 'input[name=prwfr_ai_prompt_type]:checked' ).val() == 'default' ){
								jQuery( 'textarea#prwfr_ai_request_prompt' ).val('')
								jQuery( 'textarea#prwfr_ai_request_prompt' ).val('<?php echo get_option( 'prwfr_default_ai_prompt' ); ?>').attr('disabled','disabled');
								// jQuery( 'textarea#rprow_ai_request_prompt' ).hide();
								jQuery( '#prwfr_textarea_container.prwfr-ai-prompt-container, .prprow-prompt-placeholder-container' ).slideUp();
							} else if( jQuery( 'input[name=prwfr_ai_prompt_type]:checked' ).val() == 'edit' ) {
								// jQuery( 'textarea#rprow_ai_request_prompt' ).show();
								jQuery( '#prwfr_textarea_container.prwfr-ai-prompt-container, .prprow-prompt-placeholder-container' ).slideDown();
								jQuery( 'textarea#prwfr_ai_request_prompt' ).removeAttr('disabled');
							}
						})

						if( jQuery( 'input[name=prwfr_ai_prompt_type]:checked' ).val() == 'default' ){
							jQuery( 'textarea#prwfr_ai_request_prompt' ).val('')
							jQuery( 'textarea#prwfr_ai_request_prompt' ).val('<?php echo get_option( 'prwfr_default_ai_prompt' ); ?>').attr('disabled','disabled');
							jQuery( '#prwfr_textarea_container.prwfr-ai-prompt-container, .prprow-prompt-placeholder-container' ).hide();
							// jQuery( 'textarea#rprow_ai_request_prompt' ).slideUp();
							// jQuery( '#rprow_textarea_container.prwfr-ai-prompt-container' ).slideUp();


						} else if( jQuery( 'input[name=prwfr_ai_prompt_type]:checked' ).val() == 'edit' ) {
							jQuery( '#prwfr_textarea_container.prwfr-ai-prompt-container, .prprow-prompt-placeholder-container' ).show();
							// jQuery( '#rprow_textarea_container.prwfr-ai-prompt-container' ).slideDown();
							// jQuery( 'textarea#rprow_ai_request_prompt' ).slideDown();
							jQuery( 'textarea#prwfr_ai_request_prompt' ).removeAttr('disabled');
							jQuery( 'textarea#prwfr_ai_request_prompt' ).val('')
							jQuery( 'textarea#prwfr_ai_request_prompt' ).val('<?php echo get_option( 'prwfr_ai_request_prompt' ); ?>')
						}

						jQuery(document).on('click', '#prwfr_undo_ai_changes', function(){
							jQuery(".prwfr-ai-recommendations").click()
						})

						// jQuery(document).on('change', 'input[name="prwfr_recurrence_period_ai"]', function() {
						// 	let prwfrRecurrencePeriod = jQuery('input[name="prwfr_recurrence_period_ai"]:checked').val();
						// 	if( prwfrRecurrencePeriod == 'weekly' ){
						// 		jQuery( '.prwfr-save-recommendations-weekly' ).show();
						// 		jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).slideDown();

						// 	} else{
						// 		jQuery( '.prwfr-save-recommendations-weekly' ).hide();
						// 		jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).slideUp();
						// 	}
						// });

						// let prwfrRecurrencePeriod = jQuery('input[name="prwfr_recurrence_period_ai"]:checked').val();
						// if( prwfrRecurrencePeriod == 'weekly' ){
						// 	jQuery( '.prwfr-save-recommendations-weekly' ).show();
						// 	if( jQuery( 'input[name="prwfr_weekly_save_recommendations"]:checked' ).val() == 'manual' ){
						// 		jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).show();
						// 	} else {
						// 		jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).hide();
						// 	}
						// } else{
						// 	jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).hide();
						// 	jQuery( '.prwfr-save-recommendations-weekly' ).hide();
						// }

						// jQuery(document).on('change', 'input[name="prwfr_weekly_save_recommendations"]', function() {
						// 	if( jQuery( 'input[name="prwfr_weekly_save_recommendations"]:checked' ).val() == 'manual' ){
						// 		jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).slideDown();
						// 	} else {
						// 		jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email' ).slideUp();
						// 	}
						// })

						jQuery( document ).on( 'change', '#prwfr_multiple_categories_check', function() {
							if( jQuery( '#prwfr_multiple_categories_check' ).is(':checked') ){
								jQuery( '.prwfr-all-cat-selection' ).slideDown(200);
							} else {
								jQuery( '.prwfr-all-cat-selection' ).slideUp(200);
							}
						})

						jQuery( document ).on( 'change', '#prwfr_multiple_products_check', function() {
							if( jQuery( '#prwfr_multiple_products_check' ).is(':checked') ){
								jQuery( '.prwfr-products-selection' ).slideDown(200);
							} else {
								jQuery( '.prwfr-products-selection' ).slideUp(200);
							}
						})

						if( jQuery( '#prwfr_multiple_categories_check' ).is(':checked') ){
							jQuery( '.prwfr-all-cat-selection' ).show();
						} else {
							jQuery( '.prwfr-all-cat-selection' ).hide();
						}

						if( jQuery( '#prwfr_multiple_products_check' ).is(':checked') ){
							jQuery( '.prwfr-products-selection' ).show();
						} else {
							jQuery( '.prwfr-products-selection' ).hide();
						}

						jQuery(document).on( 'click', '#prwfr_reset_ai_settings', function(){

							let saveSettings = prwfrGetSelectedOptions();
							// Define the loader icon (replace with actual loader HTML or an <img> tag)
							// let loaderIcon = '<span class="fa fa-spinner fa-spin"></span>'; // Example using FontAwesome
							// let loaderElement = jQuery('.prwfr-ai-reset-loader');

							// // Clear the existing content and append the loader icon
							// loaderElement.empty().append(loaderIcon);

							// // Set a timeout to remove the loader after 2000ms
							// setTimeout(function() {
							// 	loaderElement.empty(); // Remove the loader after 2 seconds

							// 	// Display "Saved" message
							// 	loaderElement.append('Reset Done!');

							// 	// Set another timeout to remove the "Saved" message after 2000ms
							// 	setTimeout(function() {
							// 		loaderElement.empty(); // Remove "Saved" after 2 seconds
							// 	}, 5000);
							// }, 5000);

							jQuery('#prwfr_reset_ai_settings').empty().text('<?php echo esc_html__( 'Resetting..', 'sft-product-recommendations-woocommerce' ); ?>');
							
							jQuery( 'input[name="prwfr_recurrence_period_ai"][value="one_time"]').prop('checked', true);	
							jQuery( 'input[name="prwfr_all_products"]').prop('checked', true);
							jQuery( 'input[name="prwfr_multiple_products_check"]').prop('checked', true);
							jQuery( 'input[name="prwfr_fbt_data"]').prop('checked', false);
							jQuery( 'input[name="prwfr_products_name"]').prop('checked', true);
							jQuery( 'input[name="prwfr_products_desc"]').prop('checked', true);
							jQuery( 'input[name="prwfr_multiple_categories_check"]').prop('checked', false);
							jQuery( 'input[name="prwfr_products_price"]').prop('checked', false);
							jQuery( 'input[name="prwfr_products_url"]').prop('checked', false);
							jQuery( 'input[name="prwfr_products_desc_long"]').prop('checked', false);
							jQuery( 'input[name="prwfr_products_categories"]').prop('checked', false);
							jQuery('input[name=prwfr_weekly_save_recommendations]').prop('checked', false);

							// jQuery( '.prwfr-ai-recommendations-weekly, .prwfr-ai-recommendations-admin-email, .prwfr-save-recommendations-weekly' ).hide();
							jQuery.ajax({
								url: '<?php echo admin_url( 'admin-ajax.php' ); ?>', // Use a localized variable for the AJAX URL
								type: 'POST',
								data: {
									action: 'prwfr_ai_help',
									reset_settings: 1,
								},
								success: function(response) {
									jQuery('#prwfr_reset_ai_settings').empty().text('<?php echo esc_html__( 'Reset Settings', 'sft-product-recommendations-woocommerce' ); ?>');
								}
							})
						})


						// Get all category ids.
						let catIds = new Set();
						let productIds = new Set();

						jQuery('#prwfr_category_selection').change(function() {

							catIds.clear();

							jQuery.each(jQuery('select.prwfr_category_selection option:selected'), function () {
								catIds.add(jQuery(this).val());
							});

						});

						// Example of how to populate productIds and catIds
						jQuery('#prwfr_product_selection').change(function() {

							productIds.clear();

							jQuery.each(jQuery('select.prwfr_product_selection option:selected'), function () {
								productIds.add(jQuery(this).val());
							});

						});

						// Initialize the parent checkbox state
						jQuery(document).on('click', '#prwfr_save_ai_settings', function(){

							let saveSettings = prwfrGetSelectedOptions();
							// Define the loader icon (replace with actual loader HTML or an <img> tag)
							let loaderIcon = '<span class="fa fa-spinner fa-spin"></span>'; // Example using FontAwesome
							let loaderElement = jQuery('.prwfr-ai-save-loader');

							// Clear the existing content and append the loader icon
							loaderElement.empty().append(loaderIcon);

							// Set a timeout to remove the loader after 2000ms
							setTimeout(function() {
								loaderElement.empty(); // Remove the loader after 2 seconds

								// Display "Saved" message
								// loaderElement.append('Saved');

								// Set another timeout to remove the "Saved" message after 2000ms
								setTimeout(function() {
									loaderElement.empty(); // Remove "Saved" after 2 seconds
								}, 5000);
							}, 5000); // This timeout is for the loader
						})

						jQuery( '.prwfr-ai-request-warning' ).empty();

						jQuery(document).on('click', '#prwfr-send-prompt-btn', function(e){
							e.preventDefault();

							let createRequest = prwfrGetSelectedOptions();

							jQuery('#prwfr-send-prompt-btn').empty().text('<?php echo esc_html__( 'Requesting.......', 'sft-product-recommendations-woocommerce' ); ?>');


							if( createRequest == 1 ){
								jQuery.ajax({
									url: '<?php echo admin_url( 'admin-ajax.php' ); ?>', // Use a localized variable for the AJAX URL
									type: 'POST',
									data: {
										action: 'prwfr_ai_help',
										create_request: 1,
									},
									success: function(response) {

										Swal.fire({
											title: "",
											text: "<?php _e( 'Your request was initiated successfully!', 'sft-product-recommendations-woocommerce' ); ?>",
											icon: "success",
											customClass: "prwfr-request-sent",
										}).then(() => {
											location.reload(); // This will refresh the page after the Swal modal is closed
										});
									},
								})
							} else {
								jQuery('#prwfr-send-prompt-btn').empty().text( '<?php _e( 'Create Request', 'sft-product-recommendations-woocommerce' ); ?>');

								jQuery( '.prwfr-ai-request-warning' ).empty().text( '<?php _e( 'Please ensure that all required fields are selected before submitting your request.', 'sft-product-recommendations-woocommerce' ); ?>' );
							}
						});

						let tokensUsed = <?php echo $tokens_used; ?>;
						jQuery( '.prwfr-token-status' ).empty().append( tokensUsed + ' <?php echo esc_html__( 'tokens will be used out of 4096', 'sft-product-recommendations-woocommerce' ); ?>' );

						jQuery(document).on('keyup', '#prwfr_ai_request_prompt', function() {
							jQuery('.prwfr-token-status').empty();
							let createRequest = prwfrGetSelectedOptions();
							// Make api request and check token count.
							jQuery.ajax({
								type: "POST",
								url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
								data: {
									action: 'prwfr_ai_help',
									prompt_token: 1,
								},
								success: function(response) {
									jQuery('.prwfr-token-status').empty().append(response + ' <?php echo esc_html__( 'tokens will be used out of 4096', 'sft-product-recommendations-woocommerce' ); ?>');
								}
							})
						})

						function prwfrGetSelectedOptions(){

							let sendPrompt = 1;
							// Convert the Set to an array
							let productIdsArray = Array.from(productIds);

							// // Convert the Set to an array
							let catIdsArray = Array.from(catIds);

							
							if( productIdsArray.length == 0 ){
								productIdsArray = jQuery('#prwfr_product_selection').val();
							}
							
							if( catIdsArray.length == 0 ){
								catIdsArray = jQuery('#prwfr_category_selection').val();
							}

							let prwfrRecurrencePeriod = jQuery('input[name=prwfr_recurrence_period_ai]:checked').val();
							let prwfrSaveWeeklyRecommendations = jQuery('input[name=prwfr_weekly_save_recommendations]:checked').val();
							let prwfrAllProducts = jQuery('input[name=prwfr_all_products]:checked').val();
							let prwfrMultipleProducts = jQuery('input[name=prwfr_multiple_products_check]:checked').val();
							let prwfrMultipleCategories = jQuery('input[name=prwfr_multiple_categories_check]:checked').val();
							let prwfrFbtData = jQuery('input[name=prwfr_fbt_data]:checked').val();
							let prwfrProductsUrl = jQuery('input[name=prwfr_products_url]:checked').val();
							let prwfrProductsPrice = jQuery('input[name=prwfr_products_price]:checked').val();
							let prwfrProductsName = jQuery('input[name=prwfr_products_name]:checked').val();
							let prwfrProductsDesc = jQuery('input[name=prwfr_products_desc]:checked').val();
							let prwfrProductsDescLong = jQuery('input[name=prwfr_products_desc_long]:checked').val();
							let prwfrProductsCategories = jQuery('input[name=prwfr_products_categories]:checked').val();
							let prwfrManualWeeklyDay = jQuery('select[name=prwfr_ai_recommendations_everyweek]').val();
							let prwfrManualWeeklyTime = jQuery('input[name=prwfr_ai_recommendations_weekly_time]').val();
							let prwfrManualWeeklyEmail = jQuery('input[name=prwfr_ai_admin_email]').val();
							let prwfrAboutStore = jQuery('textarea#prwfr_about_store').val();
							let prwfrPrompt = jQuery('textarea#prwfr_ai_request_prompt').val();
							let prwfrAiPromptType = 'default';
							let prwfrActivateAiRecommendations = jQuery( 'input[name=prwfr_activate_ai_recommendations]:checked').val();
							// console
							// console.log( 'prwfrPrompt ' + prwfrPrompt );
							// console.log( 'prwfrAiPromptType ' + prwfrAiPromptType );
							// console.log( 'prwfrProductsUrl ' + prwfrProductsName );
							// console.log( 'prwfrProductsPrice ' + prwfrProductsDescLong );
							// console.log( 'prwfrProductsDesc ' + prwfrProductsCategories );
							// console.log( 'prwfrProductsName ' + prwfrProductsName );
							// console.log( 'prwfrProductsDescLong ' + prwfrProductsDescLong );
							// console.log( 'prwfrProductsCategories ' + prwfrProductsCategories );
							// console.log( 'catIdsArray ' + catIdsArray );
							// console.log( 'productIdsArray ' + productIdsArray );
							// console.log( 'prwfrRecurrencePeriod ' + prwfrRecurrencePeriod );
							// console.log( 'prwfrSaveWeeklyRecommendations ' + prwfrSaveWeeklyRecommendations );
							// console.log( 'prwfrAllProducts ' + prwfrAllProducts );
							// console.log( 'prwfrMultipleProducts ' + prwfrMultipleProducts );
							// console.log( 'prwfrMultipleCategories ' + prwfrMultipleCategories );
							// console.log( 'prwfrSalesData ' + prwfrSalesData );
							// console.log( 'prwfrFbtData ' + prwfrFbtData );
							// console.log( 'prwfrManualWeeklyDay ' + prwfrManualWeeklyDay );
							// console.log( 'prwfrManualWeeklyTime ' + prwfrManualWeeklyTime );
							
							jQuery.ajax({
								url: '<?php echo admin_url( 'admin-ajax.php' ); ?>', // Use a localized variable for the AJAX URL
								type: 'POST',
								data: {
									action: 'prwfr_ai_help',
									save_settings: 1,
									prwfr_category_selection: catIdsArray,
									prwfr_product_selection: productIdsArray,
									prwfr_recurrence_period_ai: prwfrRecurrencePeriod,
									prwfr_save_weekly_recommendations: prwfrSaveWeeklyRecommendations,
									prwfr_all_products: prwfrAllProducts,
									prwfr_multiple_products_check: prwfrMultipleProducts,
									prwfr_multiple_categories_check: prwfrMultipleCategories,
									prwfr_fbt_data: prwfrFbtData,
									prwfr_products_url: prwfrProductsUrl,
									prwfr_products_price: prwfrProductsPrice,
									prwfr_products_name: prwfrProductsName,
									prwfr_products_desc: prwfrProductsDesc,
									prwfr_products_desc_long: prwfrProductsDescLong,
									prwfr_products_categories: prwfrProductsCategories,
									prwfr_ai_recommendations_everyweek: prwfrManualWeeklyDay,
									prwfr_ai_recommendations_weekly_time: prwfrManualWeeklyTime,
									prwfr_ai_admin_email: prwfrManualWeeklyEmail,
									prwfr_about_store: prwfrAboutStore,
									prwfr_ai_request_prompt: prwfrPrompt,
									prwfr_ai_prompt_type: prwfrAiPromptType,
									prwfr_activate_ai_recommendations: prwfrActivateAiRecommendations == 1 ? 1 : 0,
								},
								success: function(response) {
									// jQuery( '.prwfr-ai-save-loader' ).empty();
								},
							});

							if ( ( prwfrProductsUrl == undefined && prwfrProductsPrice == undefined && prwfrProductsName == undefined && prwfrProductsDesc == undefined && 
								prwfrProductsDescLong == undefined && prwfrProductsCategories == undefined ) ) {
									sendPrompt = 0;
							}

							if( !prwfrPrompt ){
									sendPrompt = 0;
							}
							if(( prwfrMultipleProducts == 'on') && (productIdsArray.length == 0) ){
								sendPrompt = 0;
							}

							if(( prwfrMultipleCategories == 'on') && (catIdsArray.length == 0) ){
								sendPrompt = 0;
							}

							if( prwfrActivateAiRecommendations == 0 ){
								sendPrompt = 0;
							}

							return sendPrompt;
						}

						jQuery('.swal2-container.swal2-center').css('z-index', '100000');
						jQuery('.prwfr-popup').css('width', '840px');
						jQuery('.prwfr-popup').css('text-align', 'left');
						jQuery('.prwfr-popup > .swal2-header').css('background', '#061727');
						jQuery('.prwfr-popup > .swal2-header').css('margin', '-20px');
						jQuery('.prwfr-popup > .swal2-content').css('padding', '0px 0px 0px 10px');
						jQuery('.pro-alert-header').css('padding-top', '25px');
						jQuery('.pro-alert-header').css('padding-bottom', '20px');
						jQuery('.pro-alert-header').css('color', 'white');
					} else {
						Swal.fire('', 'Your Last request is Processing..!', 'warning');
					}
				} else {

					// For expired tokens status.
					Swal.fire({
						text: '<?php echo esc_html__( 'Your API token credit limit has expired !', 'sft-product-recommendations-woocommerce' ); ?>',
						icon: "warning",
						showDenyButton: true,
						showCloseButton: true,
						confirmButtonText: '<?php echo esc_html__( 'Renew Credits', 'sft-product-recommendations-woocommerce' ); ?>',
						denyButtonText: '<?php echo esc_html__( 'Configure API Key', 'sft-product-recommendations-woocommerce' ); ?>',
						denyButtonColor: "#32CD32",
						confirmButtonColor: "#6CB4EE",
					}).then((result) => {

						if (result.isConfirmed) {

							// Move to billing page.
							window.location.assign('https://platform.openai.com/settings/organization/billing/');
						} else if (result.isDenied) {

							// Move to settings page.
							window.location.assign( '<?php echo esc_url( $api_settings_page ); ?>' );
						}
					});
				}
			}

			// copy the clipboard text when button is clicked.
			jQuery("button.prwfr-fbt-data-clipboard").click(function(e) {
				e.preventDefault();
				let shotcodetext = "{fbt_products}";

				// Copy the text to the clipboard
				navigator.clipboard.writeText(shotcodetext).then(() => {
					// Render the "Text Copied!" message
					jQuery('.prwfr-fbt-data-text-copied').empty().text("<?php _e( 'Text Copied!', 'sft-product-recommendations-woocommerce' ); ?>");

					// Set a timeout to clear the text after a few seconds (e.g., 2 seconds)
					setTimeout(function() {
						jQuery('.prwfr-text-copied').empty(); // Clear the text after the interval
					}, 2000); // 2000 milliseconds = 2 seconds
				}).catch(err => {
					console.error('Failed to copy text: ', err);
				});
			});

			jQuery("button.prwfr-all-products-clipboard").click(function(e) {
				e.preventDefault();
				let shotcodetext = "{all_products}";
				// Copy the text to the clipboard
				navigator.clipboard.writeText(shotcodetext).then(() => {
					// Render the "Text Copied!" message
					jQuery('.prwfr-all-products-text-copied').empty().text("<?php _e( 'Text Copied!', 'sft-product-recommendations-woocommerce' ); ?>");

					// Set a timeout to clear the text after a few seconds (e.g., 2 seconds)
					setTimeout(function() {
						jQuery('.prwfr-text-copied').empty(); // Clear the text after the interval
					}, 2000); // 2000 milliseconds = 2 seconds
				}).catch(err => {
					console.error('Failed to copy text: ', err);
				});
			});

			jQuery("button.prwfr-selected-products-clipboard").click(function(e) {
				e.preventDefault();
				let shotcodetext = "{selected_products}";
				// Copy the text to the clipboard
				navigator.clipboard.writeText(shotcodetext).then(() => {
					// Render the "Text Copied!" message
					jQuery('.prwfr-selected-products-text-copied').empty().text("<?php _e( 'Text Copied!', 'sft-product-recommendations-woocommerce' ); ?>");

					// Set a timeout to clear the text after a few seconds (e.g., 2 seconds)
					setTimeout(function() {
						jQuery('.prwfr-text-copied').empty(); // Clear the text after the interval
					}, 2000); // 2000 milliseconds = 2 seconds
				}).catch(err => {
					console.error('Failed to copy text: ', err);
				});
			});

			jQuery("button.prwfr-selected-categories-clipboard").click(function(e) {
				e.preventDefault();
				let shotcodetext = "{selected_products}";
				// Copy the text to the clipboard
				navigator.clipboard.writeText(shotcodetext).then(() => {
					// Render the "Text Copied!" message
					jQuery('.prwfr-selected-categories-text-copied').empty().text("<?php _e( 'Text Copied!', 'sft-product-recommendations-woocommerce' ); ?>");

					// Set a timeout to clear the text after a few seconds (e.g., 2 seconds)
					setTimeout(function() {
						jQuery('.prwfr-text-copied').empty(); // Clear the text after the interval
					}, 2000); // 2000 milliseconds = 2 seconds
				}).catch(err => {
					console.error('Failed to copy text: ', err);
				});
			});
		});
	</script>
	<?php
}

/**
 * Get all product in required format ( simple + variation ).
 *
 * @return array
 */
function prwfr_get_all_products() {
	$all_products = array();

	$products_id = wc_get_products(
		array(
			'limit'  => -1,  // All products.
			'status' => 'publish', // Only published products.
			'return' => 'ids',
		)
	);

	foreach ( $products_id as $product_id ) {
		$product = wc_get_product( $product_id );

		// All simple products.
		$all_products[] = array(
			'product_id' => intval( $product_id ),
			'label'      => 'ID:' . esc_attr( $product_id ) . ' ' . esc_html( wp_strip_all_tags( $product->get_formatted_name() ) ),
		);

		// // All variation product.
		// if ( $product->is_type( 'variable' ) ) {

		// foreach ( $product->get_children() as $variation_id ) {
		// $variation      = wc_get_product( $variation_id );
		// $all_products[] = array(
		// 'product_id' => intval( $variation_id ),
		// 'label'      => 'ID:' . esc_attr( $variation_id ) . ' ' . esc_html( wp_strip_all_tags( $variation->get_formatted_name() ) ),
		// );

		// }
		// }
	}

	return $all_products;
}

add_action( 'admin_init', 'prwfr_register_settings' );

/**
 * Registering fields .
 */
function prwfr_register_settings() {

	// ========================api settings======================
	add_settings_section( 'prwfr-account-settings-group', '', null, 'prwfr-ai-key-settings-options' );

	// Setting api key enter.
	register_setting( 'prwfr-api-field-setting', 'prwfr_openai_api_key' );
	add_settings_field(
		'prwfr_openai_api_key',
		esc_attr__( 'Enter Open AI API Key', 'woocommerce-related-products-pro' ),
		'prwfr_get_ai_api_key_field',
		'prwfr-ai-key-settings-options',
		'prwfr-account-settings-group'
	);

	// Setting api model select.
	register_setting( 'prwfr-api-field-setting', 'prwfr_openai_api_model' );
	add_settings_field(
		'prwfr_openai_api_model',
		esc_attr__( 'Select OpenAi Model', 'woocommerce-related-products-pro' ),
		'prwfr_get_ai_api_model_field',
		'prwfr-ai-key-settings-options',
		'prwfr-account-settings-group'
	);

	// -------------------- General ---------------------------------------

	// For the first tab.
	$page_slug    = 'prwfr__general';
	$option_group = 'prwfr__general_settings';

	// add section.
	add_settings_section( 'prwfr_general_section', '', '', $page_slug );

	// register fields.
	register_setting( $option_group, 'prwfr_color_picker_btn' );
	register_setting( $option_group, 'prwfr_color_picker_background_front' );
	register_setting( $option_group, 'prwfr_product_image_size' );
	register_setting( $option_group, 'prwfr_button_arrow_color' );

	// Field to pick cololr for back and next button.
	add_settings_field(
		'prwfr_color_picker_btn',
		__( 'Slider Background Color', 'sft-product-recommendations-woocommerce' ),
		'prwfr_bgcolor_picker_field',
		$page_slug,
		'prwfr_general_section'
	);

	// Field to pick cololr for back and next button.
	add_settings_field(
		'prwfr_color_picker_background_front',
		__( 'Slider Button Color', 'sft-product-recommendations-woocommerce' ),
		'prwfr_color_picker_field',
		$page_slug,
		'prwfr_general_section'
	);

	add_settings_field(
		'prwfr_arrow_color_row',
		__( 'Select Button Arrow Icon Color', 'sft-product-recommendations-woocommerce' ),
		'prwfr_color_picker_field_for_arrow_icon',
		$page_slug,
		'prwfr_general_section',
	);

	add_settings_field(
		'prwfr_Products_Rating_field',
		__( 'Display rating in Products Slider', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_Products_Rating_field',
		$page_slug,
		'prwfr_general_section'
	);

	// ==========================email notification========================

	// for the second tab.
	$page_slug    = 'prwfr__email_general';
	$option_group = 'prwfr__email_general_settings';

	// add section.
	add_settings_section( 'prwfr_email_section', '', '', $page_slug );

	register_setting( $option_group, 'prwfr_email_logo' );

	add_settings_field(
		'prwfr_price_drop_email_template_logo',
		__( 'Upload Logo for Email Header ', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_email_template_logo',
		$page_slug,
		'prwfr_email_section'
	);

	add_settings_field(
		'prwfr_learn_more_btn_color',
		__( 'Select "Learn more" CTA Color for Email', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_learn_more_btn_color',
		$page_slug,
		'prwfr_email_section'
	);

	add_settings_field(
		'prwfr_email_gdpr_permission',
		__( 'Enable GDPR Integration', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_email_gdpr_permission',
		$page_slug,
		'prwfr_email_section'
	);

	add_settings_field(
		'prwfr_email_template_header_bg_color',
		__( 'Choose Background for Email Template Header', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_email_template_header_bg_color',
		$page_slug,
		'prwfr_email_section'
	);

	// ---------------------------------------reorder------------------------------------------------------------

	// add section.
	add_settings_section( 'prwfr_reorder_section', '', '', 'prwfr__post_purchase_reorder' );
	register_setting( 'prwfr__post_purchase_reorder_settings', 'prwfr_display_reorder' );
	add_settings_field(
		'prwfr_display_reorder_value',
		__( 'Display Re-Order button', 'sft-product-recommendations-woocommerce' ),
		'prwfr_reorder_field',
		'prwfr__post_purchase_reorder',
		'prwfr_reorder_section'
	);

	// ------------------- Recently Viewed Products ------------------------------------------

	// for the second tab.
	$page_slug    = 'prwfr__page_rvp';
	$option_group = 'prwfr__page_rvp_settings';

	// add section.
	add_settings_section( 'prwfr_rvp_section', '', 'prwfr_rvp_section', $page_slug );

	// register fields.
	register_setting( $option_group, 'prwfr_rvps_title' );
	register_setting( $option_group, 'prwfr_rvps_page_redirect_radio' );
	register_setting( $option_group, 'prwfr_rvps_see_more_option' );
	register_setting( $option_group, 'prwfr_manage_history_access' );
	register_setting( $option_group, 'prwfr_rvps_desktop_limit' );
	register_setting( $option_group, 'prwfr_rvps_tab_limit' );
	register_setting( $option_group, 'prwfr_rvps_mobile_limit' );
	register_setting( $option_group, 'prwfr_rvps_hide_cookie' );

	// Manage history field.
	add_settings_field(
		'prwfr_manage_history_access',
		__( 'Allow Users to Turn Off Browsing History', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_manage_history_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// Field to select redirect page for rvps.
	add_settings_field(
		'prwfr_rvps_page_redirect_radio',
		__( '"See More" Page', 'sft-product-recommendations-woocommerce' ),
		'prwfr_rvps_page_redirect_radio_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// select page from dropdown for rvps.
	add_settings_field(
		'prwfr_rvps_see_more_option',
		__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_url_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// Takes the no of products to display in single row.
	add_settings_field(
		'prwfr_rvp_ajax_slider',
		__( 'Products Per Row', 'sft-product-recommendations-woocommerce' ),
		'prwfr_rvps_shortcode_container_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// Rvps label field.
	add_settings_field(
		'prwfr_rvps_title',
		__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ),
		'prwfr_rvps_label_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	add_settings_field(
		'prwfr_rvps_out_of_stock',
		__( 'Remove Out-of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_outofstock_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// Cookie disable for rvp.
	add_settings_field(
		'prwfr_rvps_hide_cookie',
		__( 'Hide Recently Viewed Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_cookie_field_rvps',
		$page_slug,
		'prwfr_rvp_section'
	);

	// For Categories and tags.
	add_settings_field(
		'prwfr_rvps_filter_switch',
		__( 'Filter by Categories and Tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_toggle_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// Radio button for categories and tags.
	add_settings_field(
		'prwfr_rvps_cat_tag_selection_radio',
		__( 'Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_cat_tag_selection_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// For category include/exclude.
	add_settings_field(
		'prwfr_rvps_cat_inc_exc_radio',
		__( 'Category Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_category_radio_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	add_settings_field(
		'prwfr_rvps_cat_exc_selection',
		__( 'Categories to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_category_exclude_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	add_settings_field(
		'prwfr_rvps_cat_inc_selection',
		__( 'Categories to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_category_include_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// For tag include/exclude.

	add_settings_field(
		'prwfr_rvps_tag_inc_exc_radio',
		__( 'Tag Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_tag_radio_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	add_settings_field(
		'prwfr_rvps_tag_exc_selection',
		__( 'Tags to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_tag_exclude_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	add_settings_field(
		'prwfr_rvps_tag_inc_selection',
		__( 'Tags to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_rvps_tag_include_field',
		$page_slug,
		'prwfr_rvp_section'
	);

	// -----------------------------------------------------------------------------------------------------.

	// --------------------- Recently Viewed Related -------------------------------------------------------.

	$page_slug    = 'prwfr__page_rvp_related';
	$option_group = 'prwfr__page_rvp_related_settings';

	// add section.
	add_settings_section( 'prwfr_rvp_related_section', '', 'prwfr_rvp_related_section', $page_slug );

	register_setting( $option_group, 'prwfr_viewed_related_page_redirect_radio' );
	register_setting( $option_group, 'prwfr_viewed_related_see_more_option' );
	register_setting( $option_group, 'prwfr_viewed_related_desktop_limit' );
	register_setting( $option_group, 'prwfr_viewed_related_tab_limit' );
	register_setting( $option_group, 'prwfr_viewed_related_mobile_limit' );
	register_setting( $option_group, 'prwfr_viewed_related_hide_cookie' );
	register_setting( $option_group, 'prwfr_viewed_related_title' );
	register_setting( $option_group, 'prwfr_activate_ai_recommendations' );

	add_settings_field(
		'prwfr_viewed_related_page_redirect_radio',
		__( '"See More" Page', 'sft-product-recommendations-woocommerce' ),
		'prwfr_views_related_page_redirect_radio_field',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	// select page from dropdown for rvps related.
	add_settings_field(
		'prwfr_viewed_related_see_more_option',
		__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_views_related_url_field',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	// Takes the no of products to display in single row.
	add_settings_field(
		'prwfr_viewed_related_shortcode_container',
		__( 'Products Per Row', 'sft-product-recommendations-woocommerce' ),
		'prwfr_views_related_shortcode_container_field',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	// Rvps related label field.
	add_settings_field(
		'prwfr_viewed_related_title',
		__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ),
		'prwfr_view_related_label_field',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	add_settings_field(
		'prwfr_enable_ai_recommendations',
		__( 'Display AI Product Recommendations in Widget', 'sft-product-recommendations-woocommerce' ),
		'prwfr_enable_ai_recommendations',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	add_settings_field(
		'prwfr_viewed_related_out_of_stock',
		__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_views_related_outofstock_field',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	// Cookie disable for rvp related.
	add_settings_field(
		'prwfr_viewed_related_hide_cookie',
		__( 'Hide Products related to Recently Viewed Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_cookie_field_rvps_related',
		$page_slug,
		'prwfr_rvp_related_section'
	);

	add_settings_section( 'prwfr_rvp_related_filter_section', '', 'prwfr_rvp_related_filter_section', $page_slug );

	// ------------------------------------------------------------------------------------------------------.

	// --------------------- RVP-onsale ---------------------------
		$page_slug    = 'prwfr__page_rvp_onsale';
		$option_group = 'prwfr__page_rvp_onsale_settings';

		// add section
		add_settings_section( 'prwfr_rvp_onsale_section', '', 'prwfr_rvp_onsale_section', $page_slug );

		register_setting( $option_group, 'prwfr_rvps_onsale_title' );
		register_setting( $option_group, 'prwfr_rvps_onsale_page_redirect_radio' );
		register_setting( $option_group, 'prwfr_rvps_onsale_see_more_option' );
		register_setting( $option_group, 'prwfr_rvps_onsale_desktop_limit' );
		register_setting( $option_group, 'prwfr_rvps_onsale_tab_limit' );
		register_setting( $option_group, 'prwfr_rvps_onsale_mobile_limit' );
		register_setting( $option_group, 'prwfr_rvps_onsale_hide_cookie' );
		register_setting( $option_group, 'prwfr_rvps_onsale_out_of_stock' );

		// Field to select redirect page for rvps onsale.
		add_settings_field(
			'prwfr_rvps_onsale_page_redirect_radio',
			__( '"See More" Page', 'sft-product-recommendations-woocommerce' ),
			'prwfr_rvps_onsale_page_redirect_radio_field',
			$page_slug,
			'prwfr_rvp_onsale_section'
		);

		// select page from dropdown for rvps onsale.
		add_settings_field(
			'prwfr_rvps_onsale_see_more_option',
			__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_rvps_onsale_url_field',
			$page_slug,
			'prwfr_rvp_onsale_section'
		);

		// Takes the no of products to display in single row.
		add_settings_field(
			'prwfr_rvps_onsale_shortcode_container',
			__( 'Products Per Row', 'sft-product-recommendations-woocommerce' ),
			'prwfr_rvps_onsale_shortcode_container_field',
			$page_slug,
			'prwfr_rvp_onsale_section'
		);

		// Rvps and related on sale label field.
		add_settings_field(
			'prwfr_rvps_onsale_title',
			__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ),
			'prwfr_rvps_onsale_label_field',
			$page_slug,
			'prwfr_rvp_onsale_section'
		);

		add_settings_field(
			'prwfr_rvps_onsale_out_of_stock',
			__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_rvps_onsale_outofstock_field',
			$page_slug,
			'prwfr_rvp_onsale_section'
		);

		// Cookie disable for rvp_onsale.
		add_settings_field(
			'prwfr_rvps_onsale_hide_cookie',
			__( 'Hide On-Sale Products related to Recently Viewed Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_cookie_field_rvps_onsale',
			$page_slug,
			'prwfr_rvp_onsale_section'
		);

		add_settings_section( 'prwfr_rvp_onsale_filter_section', '', 'prwfr_rvp_onsale_filter_section', $page_slug );

	// -------------------------------------------------------------

	// -------------------Purchase History Related-----------------------------------------

	$page_slug    = 'prwfr__post_purchase_phrp';
	$option_group = 'prwfr__post_purchase_phrp_settings';

	// add section.
	add_settings_section( 'prwfr_phrp_section', '', '', $page_slug );

	register_setting( $option_group, 'prwfr_phrp_title' );

	add_settings_field(
		'prwfr_phrp_page_redirect_radio',
		__( '"See More" Page', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_page_redirect_radio_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_see_more_option',
		__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_url_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_shortcode_container',
		__( 'Products per row', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_shortcode_container_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_title',
		__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_label_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_out_of_stock',
		__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_outofstock_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_no_of_days',
		__( 'Purchase History Period', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_no_of_days_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_toggle_value',
		__( 'Filter by Categories and Tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_toggle_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_cat_tag_selection_value',
		__( 'Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_cat_tag_selection_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_category_radio_value',
		__( 'Category Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_category_radio_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_category_exclude_value',
		__( 'Categories to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_category_exclude_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_category_include_value',
		__( 'Categories to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_category_include_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_tag_radio_value',
		__( 'Tag Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_tag_radio_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_tag_exclude_value',
		__( 'Tags to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_tag_exclude_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	add_settings_field(
		'prwfr_phrp_tag_include_value',
		__( 'Tags to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_phrp_tag_include_field',
		$page_slug,
		'prwfr_phrp_section',
	);

	// --------------------------------------------------------------

	// ------------------------Buy-it again--------------------------

	$page_slug    = 'prwfr__post_purchase_buy_again';
	$option_group = 'prwfr__post_purchase_buy_again_settings';

	// add section.
	add_settings_section( 'prwfr_buy_again_section', '', 'prwfr_buy_again_url_section', $page_slug );

	register_setting( $option_group, 'prwfr_buy_again_title' );

	// add section
	add_settings_field(
		'prwfr_buy_again_redirect_radio',
		__( '"See More" Page', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_page_redirect_radio_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_see_more_option',
		__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_url_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_title',
		__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_label_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_no_of_days',
		__( 'Number of Days after Purchase', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_no_of_days_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_toggle_value',
		__( 'Filter by Categories and Tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_toggle_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_cat_tag_selection_value',
		__( 'Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_cat_tag_selection_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_category_radio_value',
		__( 'Category Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_category_radio_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_category_exclude_value',
		__( 'Categories to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_category_exclude_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_category_include_value',
		__( 'Categories to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_category_include_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_tag_radio_value',
		__( 'Tag Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_tag_radio_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_tag_exclude_value',
		__( 'Tags to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_tag_exclude_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	add_settings_field(
		'prwfr_buy_again_tag_include_value',
		__( 'Tags to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-required">*</span><span class="prwfr-pro">Pro</span>',
		'prwfr_buy_again_tag_include_field',
		$page_slug,
		'prwfr_buy_again_section',
	);

	// -------------------- All On-Sale ----------------------
		$page_slug    = 'prwfr__highlighting_all_onsale';
		$option_group = 'prwfr__highlighting_all_onsale_settings';

		// add section.
		add_settings_section( 'prwfr_all_onsale_section', '', '', $page_slug );

		register_setting( $option_group, 'prwfr_all_onsale_title' );

		add_settings_field(
			'prwfr_all_onsale_page_redirect_radio',
			__( '"See More" Page', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_page_redirect_radio_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// Select default and custom page.
		add_settings_field(
			'prwfr_all_onsale_see_more_option',
			__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_url_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// Get no of products to display in single row.
		add_settings_field(
			'prwfr_all_onsale_shortcode_container',
			__( 'Products per row', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_shortcode_container_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// All on sale label field.
		add_settings_field(
			'prwfr_all_onsale_title',
			__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_label_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		add_settings_field(
			'prwfr_all_onsale_out_of_stock',
			__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_outofstock_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// Cookie disable for all onsale.
		add_settings_field(
			'prwfr_all_onsale_cookie_display',
			__( 'Hide All On-Sale Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_cookie_field_all_onsale',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// Category and tag field.
		add_settings_field(
			'prwfr_all_onasle_toggle_value',
			__( 'Filter by Categories and Tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_toggle_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		add_settings_field(
			'prwfr_all_onsale_cat_tag_selection_value',
			__( 'Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_cat_tag_selection_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// Category radio field.
		add_settings_field(
			'prwfr_all_onsale_category_radio_value',
			__( 'Category Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_category_radio_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		add_settings_field(
			'prwfr_all_onsale_category_exclude_value',
			__( 'Categories to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_category_exclude_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		add_settings_field(
			'prwfr_all_onsale_category_include_value',
			__( 'Categories to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_category_include_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		// Tag radio field.
		add_settings_field(
			'prwfr_all_onsale_tag_radio_value',
			__( 'Tag Filter Mode', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_tag_radio_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		add_settings_field(
			'prwfr_all_onsale_tag_exclude_value',
			__( 'Tags to Exclude', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_tag_exclude_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);

		add_settings_field(
			'prwfr_all_onsale_tag_include_value',
			__( 'Tags to Include', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_all_onsale_tag_include_field',
			$page_slug,
			'prwfr_all_onsale_section'
		);
	// -----------------------------------------------------------

	// -------------------------- Best Selling ---------------------------------------

		$page_slug    = 'prwfr__highlighting_best_selling';
		$option_group = 'prwfr__highlighting_best_selling_settings';

		// add section.
		add_settings_section( 'prwfr_best_selling_section', '', '', $page_slug );

		register_setting( $option_group, 'prwfr_best_selling_title' );

		add_settings_field(
			'prwfr_best_selling_redirect_page_radio',
			__( '"See More" Page', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_page_redirect_radio_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_see_more_option',
			__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_url_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_seller_shortcode_container',
			__( 'Products per row', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_shortcode_container_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_title',
			__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_label_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_out_of_stock',
			__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_outofstock_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_cookie_display',
			__( 'Hide Recently Viewed Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_cookie_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_display_mode',
			__( 'Product Display Filter', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_product_display_option_selection',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_category_selection',
			__( 'Choose Categories', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_product_display_category_selection_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_tag_selection',
			__( 'Choose tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_product_display_tags_selection_field',
			$page_slug,
			'prwfr_best_selling_section'
		);

		add_settings_field(
			'prwfr_best_selling_individual_selection',
			__( 'Choose individual products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_best_seller_product_display_individual_selection_field',
			$page_slug,
			'prwfr_best_selling_section'
		);
	// ----------------------------------------------------------------------------

	// -------------------------------- Featured Products ------------------------------
		$page_slug    = 'prwfr__highlighting_featured';
		$option_group = 'prwfr__highlighting_featured_settings';

		// add section.
		add_settings_section( 'prwfr_featured_section', '', '', $page_slug );

		register_setting( $option_group, 'prwfr_featured_title' );

		add_settings_field(
			'prwfr_featured_page_redirect_radio',
			__( '"See More" Page', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_page_redirect_radio_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_see_more_option',
			__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_url_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_shortcode_container',
			__( 'Products per row', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_shortcode_container_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_title',
			__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_label_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_out_of_stock',
			__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_product_outofstock_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_cookie_display',
			__( 'Hide Recently Viewed Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_cookie_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_display_radio',
			__( 'Product Display Filter', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_product_display_option_selection',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_category_selection',
			__( 'Choose Categories', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_product_display_category_selection_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_tag_name',
			__( 'Choose tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_product_display_tags_selection_field',
			$page_slug,
			'prwfr_featured_section'
		);

		add_settings_field(
			'prwfr_featured_individual_selection',
			__( 'Choose individual products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_featured_product_display_individual_selection_field',
			$page_slug,
			'prwfr_featured_section'
		);
	// ----------------------------------------------------------------------

	// --------------------------------New Arrivals----------------------------------
		$page_slug    = 'prwfr__highlighting_new_arrivals';
		$option_group = 'prwfr__highlighting_new_arrivals_settings';

		// add section.
		add_settings_section( 'prwfr_new_arrivals_section', '', '', $page_slug );

		register_setting( $option_group, 'prwfr_new_arrivals_title' );

		add_settings_field(
			'prwfr_new_arrivals_page_redirect_radio',
			__( '"See More" Page', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrivals_page_redirect_radio_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrival_see_more_option',
			__( 'Choose page title', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrivals_url_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_shortcode_container',
			__( 'Products per row', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrivals_shortcode_container_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_title',
			__( 'Title for Widget', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrivals_label_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_out_of_stock',
			__( 'Remove Out-Of-Stock Products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrivals_outofstock_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_cookie_display',
			__( 'Hide Recently Viewed Products for Non-Logged Users', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrivals_cookie_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_display_radio',
			__( 'Product Display Filter', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrival_product_display_option_selection',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_category_selection',
			__( 'Choose Categories', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrival_product_display_category_selection_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_tag_selection',
			__( 'Choose tags', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrival_product_display_tags_selection_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

		add_settings_field(
			'prwfr_new_arrivals_individual_selection',
			__( 'Choose individual products', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
			'prwfr_new_arrival_product_display_individual_selection_field',
			$page_slug,
			'prwfr_new_arrivals_section'
		);

	// -------------------------------------------------------------------------------
	// email notification.
	$page_slug    = 'prwfr__email_price_drop';
	$option_group = 'prwfr__email_price_drop_settings';

	// add section.
	add_settings_section( 'prwfr_price_drop_email_section', '', '', $page_slug );

	register_setting( $option_group, 'prwfr_price_drop_email_send_check' );

	add_settings_field(
		'prwfr_price_drop_email_send_check_status',
		__( 'Send Emails', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_email_send_check',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_email_trigger',
		__( 'Select Email Trigger', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_email_trigger',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_price_drop_trigger_type_all',
		__( 'Schedule Emails to be Sent', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_price_drop_trigger_type_all',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_onetime',
		__( 'Schedule One-time Event', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_date_time_onetime',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_daily',
		__( 'Schedule Event Daily', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_date_time_select',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_everyweek',
		__( 'Schedule Event Every Week', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_date_time_all_everyweek',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_monthly',
		__( 'Schedule Event Every Month', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_all_monthly',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	// recently viewed

	add_settings_field(
		'prwfr_price_drop_rvp_duration',
		__( 'Schedule Emails to be Sent', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span>',
		'prwfr_price_drop_rvp_schedule_event',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_rvp_everyweek',
		__( 'Schedule Event Every Week', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_date_time_rvp_everyweek',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_rvp_monthly',
		__( 'Schedule Event Every Month', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_rvp_monthly',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_rvp_fortnightly',
		__( 'Schedule Event Fortnightly', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_rvp_fortnightly',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_price_drop_email_template_subject',
		__( 'Add Header to Email', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_price_drop_email_template_subject',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	add_settings_field(
		'prwfr_price_drop_email_template_content',
		__( 'Include Content to Email', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span><span class="prwfr-content-placeholder"><div class="placeholder-disabled-color" style="margin: 10px 0;">' . esc_html__( 'Use placeholder {First_name} to display First name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-firstname-placeholder clipboard">&#128203;</button>
		</div> 
		<div class="placeholder-disabled-color" style="margin: 10px 0;">' .
			esc_html__( 'Use placeholder {Last_name} to display Last name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-lastname-placeholder clipboard">&#128203;</button>
		</div>
		<div class="placeholder-disabled-color" style="margin: 10px 0;">' .
			esc_html__( 'Use placeholder {User_name} to display User name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-username-placeholder clipboard">&#128203;</button>
		</div> </span>',
		'prwfr_price_drop_email_template_content',
		$page_slug,
		'prwfr_price_drop_email_section'
	);

	// ==============================new recommendations===================================
	$page_slug    = 'prwfr__email_related_rvp';
	$option_group = 'prwfr__email_related_rvp_settings';
	// add section.
	add_settings_section( 'prwfr_rvp_related_email_section', '', '', $page_slug );

	register_setting( $option_group, 'prwfr_related_rvp_email_send' );

	// email notification.
	add_settings_field(
		'prwfr_related_rvp_email_send_status',
		__( 'Send Email', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_related_rvp_email_send',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	add_settings_field(
		'prwfr_rvp_related_duration',
		__( 'Schedule Emails to be Sent', 'sft-product-recommendations-woocommerce' ) . '<span class="trigger-rvp"></span>',
		'prwfr_rvp_related_schedule_event',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	add_settings_field(
		'prwfr_date_time_rvp_related_everyweek',
		__( 'Schedule Event Every Week', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_date_time_rvp_related_everyweek',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_rvp_related_fortnightly',
		__( 'Schedule Event Fortnightly', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_rvp_related_fortnightly',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	add_settings_field(
		'prwfr_date_time_picker_rvp_related_monthly',
		__( 'Schedule Event Every Month', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_rvp_related_monthly',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	add_settings_field(
		'prwfr_related_rvp_email_template_subject',
		__( 'Add Header to Email', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_related_rvp_email_template_subject',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	add_settings_field(
		'prwfr_related_rvp_email_template_content',
		__( 'Include Content to Email', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-pro">Pro</span><span class="prwfr-content-placeholder"><div class="placeholder-disabled-color" style="margin: 10px 0;">' . esc_html__( 'Use placeholder {First_name} to display First name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-firstname-placeholder clipboard">&#128203;</button>
		</div> 
		<div class="placeholder-disabled-color" style="margin: 10px 0;">' .
			esc_html__( 'Use placeholder {Last_name} to display Last name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-lastname-placeholder clipboard">&#128203;</button>
		</div>
		<div class="placeholder-disabled-color" style="margin: 10px 0;">' .
			esc_html__( 'Use placeholder {User_name} to display User name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-username-placeholder clipboard">&#128203;</button>
		</div> </span>',
		'prwfr_related_rvp_email_template_content',
		$page_slug,
		'prwfr_rvp_related_email_section'
	);

	// --------------------------------------------------------------
	// --------------------------RVP EMAIL NOTIFICATION--------------------
	$page_slug    = 'prwfr__rvp_email';
	$option_group = 'prwfr__rvp_email_settings';
	// add section.
	add_settings_section( 'prwfr_rvp_email_section', '', '', $page_slug );

	register_setting( $option_group, 'prwfr_rvp_email_send' );
	register_setting( $option_group, 'prwfr_rvp_email_content' );
	register_setting( $option_group, 'prwfr_rvp_email_recurrence_interval' );

	// email notification.
	add_settings_field(
		'prwfr_rvp_email_send_status',
		__( 'Send Email', 'sft-product-recommendations-woocommerce' ),
		'prwfr_rvp_email_send',
		$page_slug,
		'prwfr_rvp_email_section'
	);

	add_settings_field(
		'prwfr_rvp_schedule_type',
		__( 'Email Recurrence Interval', 'sft-product-recommendations-woocommerce' ),
		'prwfr_rvp_email_recurrence',
		$page_slug,
		'prwfr_rvp_email_section'
	);

	add_settings_field(
		'prwfr_rvp_hours_duration',
		__( 'Schedule Emails to be Sent', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_rvp_related_hours_duration',
		$page_slug,
		'prwfr_rvp_email_section'
	);

	add_settings_field(
		'prwfr_rvp_days_duration',
		__( 'Schedule Emails to be Sent', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_rvp_related_days_duration',
		$page_slug,
		'prwfr_rvp_email_section'
	);

	add_settings_field(
		'prwfr_rvp_email_template_subject',
		__( 'Add Header to Email', 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>",
		'prwfr_rvp_email_template_subject',
		$page_slug,
		'prwfr_rvp_email_section'
	);

	add_settings_field(
		'prwfr_rvp_email_template_content',
		__( 'Include Content to Email', 'sft-product-recommendations-woocommerce' ) . '<span class="prwfr-content-placeholder"><div class="placeholder-disabled-color" style="margin: 10px 0;">' . esc_html__( 'Use placeholder {First_name} to display First name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-firstname-placeholder clipboard">&#128203;</button>
		</div> 
		<div class="placeholder-disabled-color" style="margin: 10px 0;">' .
			esc_html__( 'Use placeholder {Last_name} to display Last name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-lastname-placeholder clipboard">&#128203;</button>
		</div>
		<div class="placeholder-disabled-color" style="margin: 10px 0;">' .
			esc_html__( 'Use placeholder {User_name} to display User name', 'sft-product-recommendations-woocommerce' ) . '<button class="prwfr-email-username-placeholder clipboard">&#128203;</button>
		</div> </span>',
		'prwfr_rvp_email_template_content',
		$page_slug,
		'prwfr_rvp_email_section'
	);
}


/**
 * Function to display Filter text.
 */
function prwfr_rvp_related_filter_section() {
	?>
	<div style = "margin-top: 10px; padding: 21px 11px 20px 20px;">
		<?php
		echo esc_html__( "The product filter applied for 'Recently Viewed Products' will be effective on 'Products related to Recently Viewed Products", 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>";
		?>
	</div>
	<?php
}


/**
 * Function to display Filter text.
 */
function prwfr_rvp_onsale_filter_section() {
	?>
	<div style = "margin-top: 10px; padding: 21px 11px 20px 20px;">
		<?php
		echo esc_html__( "The product filter applied for 'Recently Viewed Products' will be effective on 'On-Sale Products related to Recently Viewed Products", 'sft-product-recommendations-woocommerce' ) . "<span class='prwfr-pro'>Pro</span>";
		?>
	</div>
	<?php
}

/**
 * Highliting tabs settings tabs.
 */
function prwfr_product_discovery_set_tabs() {

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	?>

	<div class="wrap">
		<h1><?php echo esc_url( get_admin_page_title() ); ?></h1>

		<?php
		$tabs = array(
			'all_onsale'   => __( 'All Products On-Sale', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
			'best_selling' => __( 'Best Selling Products', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
			'featured'     => __( 'Featured Products', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
			'new_arrivals' => __( 'Newly Arrived Products', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
		);

		$current_tab = isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ? sanitize_key( $_GET['tab'] ) : array_key_first( $tabs );
		?>

		<form method="post" action="options.php" class="prwfr-setting-tabs">
			<nav class="nav-tab-wrapper">
				<?php
				foreach ( $tabs as $tab => $name ) {
					$current = $tab === $current_tab ? ' nav-tab-active' : '';
					$url     = admin_url( 'admin.php' );
					echo wp_kses_post( "<a class=\"nav-tab{$current}\" href=\"{$url}?page=prwfr_product_discovery_submenu&tab={$tab}\">{$name}</a>" );
				}
				?>

				<div class="prwfr-upgrade-pro-btn">
					<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
						<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
							<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
						</button>
					</a>
				</div>
			</nav>

			<div class="prwfr-setting-section">
				<?php
				settings_fields( "prwfr__highlighting_{$current_tab}_settings" );
				do_settings_sections( "prwfr__highlighting_{$current_tab}" );
				?>
				<div class="prwfr-submt-btn"><?php submit_button(); ?></div>
			</div>
		</form>
	</div>

	<!-- Upgrade footer -->

	<div class="sft-prwfr-upgrade-to-pro-banner">
		<div class="sft-uppro-inner-container">
			<div class="sft-uppro-main-logo">
				<a href="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
					<img src="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
				</a>
			</div>
		</div>

		<div class="sft-uppro-hidden-desktop">
			<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2>
		</div>

		<div class="sft-uppro-details-container">
			<div class="sft-uppro-money-back-guarantee">
				<div>
					<a href="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
						<img src="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
					</a>
				</div>
				<div>
					<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2> 
					<h3><?php esc_html_e( '100% Risk-Free Money Back Guarantee!', 'sft-product-recommendations-woocommerce' ); ?></h3>
					<p><?php esc_html_e( 'We guarantee you a complete refund for new purchases or renewals if a request is made within 15 Days of purchase.', 'sft-product-recommendations-woocommerce' ); ?></p>
					<div class="prwfr-upgrade-pro-btn">
						<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
							<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
								<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
							</button>
						</a>
					</div>
				</div>
			</div>

			<div class="sft-uppro-features-container">
				<h3> <?php echo esc_html__( 'Pro Features', 'sft-product-recommendations-woocommerce' ); ?></h3>
				<ul>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'AI powered Product Recommendations:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Leverage the power of ChatGPT to create personalized product recommendations for your customers.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Recommended Products" Emails  based on Browsing History:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Customers get "Recommended Products" email notifications based on their browsing history.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Price Drop" Email Alerts for your Featured Sale Items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Sends "Price Drop" email to customers on products marked as "Featured Sale Item" at specified intervals of your choice.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Buy It Again" Widget & Purchase History Related items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Display previously bought items and similar items to your customers to boost repeat orders or similar orders.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Product Discovery Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Attract customers with the latest arrivals, top performers, and spotlighted items using customizable widgets.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Customization options for All Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Get a plethora of options to customize widget like Star Ratings, Title, Sale Price etc.', 'sft-product-recommendations-woocommerce' ); ?></li>
				</ul>
			</div>

		</div>

	</div>

	<?php
}

/**
 * Displaying page HTML and print settings.
 */
function prwfr_post_purcahse_set_tabs() {

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php
		$tabs = array(
			'reorder'   => __( 'Re-order', 'sft-product-recommendations-woocommerce' ),
			'phrp'      => __( 'Purchase History Related Products  ', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
			'buy_again' => __( 'Buy-it Again Products  ', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
		);

		$current_tab = isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ? sanitize_key( $_GET['tab'] ) : array_key_first( $tabs );
		?>

		<form method="post" action="options.php" class="prwfr-setting-tabs">
			<nav class="nav-tab-wrapper">
				<?php
				foreach ( $tabs as $tab => $name ) {
					$current = $tab === $current_tab ? ' nav-tab-active' : '';
					$url     = admin_url( 'admin.php' );
					echo wp_kses_post( "<a class=\"nav-tab{$current}\" href=\"{$url}?page=prwfr_post_purcahse_submenu&tab={$tab}\">{$name}</a>" );
				}
				?>

				<div class="prwfr-upgrade-pro-btn">
					<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
						<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
							<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
						</button>
					</a>
				</div>
			</nav>

			<div class="prwfr-setting-section">
				<?php
				settings_fields( "prwfr__post_purchase_{$current_tab}_settings" );
				do_settings_sections( "prwfr__post_purchase_{$current_tab}" );
				?>
				<div class="prwfr-submt-btn"><?php submit_button(); ?></div>
			</div>
		</form>
	</div>

	<!-- Upgrade footer -->

	<div class="sft-prwfr-upgrade-to-pro-banner">
		<div class="sft-uppro-inner-container">
			<div class="sft-uppro-main-logo">
				<a href="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
					<img src="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
				</a>
			</div>
		</div>

		<div class="sft-uppro-hidden-desktop">
			<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2>
		</div>

		<div class="sft-uppro-details-container">
			<div class="sft-uppro-money-back-guarantee">
				<div>
					<a href="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
						<img src="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
					</a>
				</div>
				<div>
					<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2> 
					<h3><?php esc_html_e( '100% Risk-Free Money Back Guarantee!', 'sft-product-recommendations-woocommerce' ); ?></h3>
					<p><?php esc_html_e( 'We guarantee you a complete refund for new purchases or renewals if a request is made within 15 Days of purchase.', 'sft-product-recommendations-woocommerce' ); ?></p>
					<div class="prwfr-upgrade-pro-btn">
						<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
							<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
								<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
							</button>
						</a>
					</div>
				</div>
			</div>

			<div class="sft-uppro-features-container">
				<h3> <?php echo esc_html__( 'Pro Features', 'sft-product-recommendations-woocommerce' ); ?></h3>
				<ul>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'AI powered Product Recommendations:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Leverage the power of ChatGPT to create personalized product recommendations for your customers.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Recommended Products" Emails  based on Browsing History:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Customers get "Recommended Products" email notifications based on their browsing history.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Price Drop" Email Alerts for your Featured Sale Items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Sends "Price Drop" email to customers on products marked as "Featured Sale Item" at specified intervals of your choice.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Buy It Again" Widget & Purchase History Related items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Display previously bought items and similar items to your customers to boost repeat orders or similar orders.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Product Discovery Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Attract customers with the latest arrivals, top performers, and spotlighted items using customizable widgets.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Customization options for All Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Get a plethora of options to customize widget like Star Ratings, Title, Sale Price etc.', 'sft-product-recommendations-woocommerce' ); ?></li>
				</ul>
			</div>

		</div>

	</div>
	<?php
}

/**
 * General setting tabs.
 */
function prwfr_general_set_tabs() {

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php
		$tabs = array(
			'general'           => __( 'General', 'sft-product-recommendations-woocommerce' ),
			'email_general'     => __( 'Email Template Settings', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
			'rvp_email'         => __( 'Recently viewed products', 'sft-product-recommendations-woocommerce' ),
			'email_price_drop'  => __( 'Price Drop Email Notification', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
			'email_related_rvp' => __( 'New Recommendations Email Notification', 'sft-product-recommendations-woocommerce' ) . '<img class="prwfr-pro-feature-tab-icon" src="' . esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ) . '" />',
		);

		$current_tab = isset( $_GET['tab'] ) && isset( $tabs[ $_GET['tab'] ] ) ? sanitize_key( $_GET['tab'] ) : array_key_first( $tabs );
		?>

		<form method="post" action="options.php" class="prwfr-setting-tabs">
			<nav class="nav-tab-wrapper">
				<?php
				foreach ( $tabs as $tab => $name ) {
					$current = $tab === $current_tab ? ' nav-tab-active' : '';
					$url     = admin_url( 'admin.php' );
					echo wp_kses_post( "<a class=\"nav-tab{$current}\" href=\"{$url}?page=prwfr_general_submenu&tab={$tab}\">{$name}</a>" );
				}
				?>

				<div class="prwfr-upgrade-pro-btn">
					<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
						<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
							<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
						</button>
					</a>
				</div>
			</nav>

			<div class="prwfr-setting-section">
				<?php
				settings_fields( "prwfr__{$current_tab}_settings" );
				do_settings_sections( "prwfr__{$current_tab}" );
				?>
				<div class="prwfr-submt-btn"><?php submit_button(); ?></div>
			</div>
		</form>
	</div>

	<!-- Upgrade footer -->

	<div class="sft-prwfr-upgrade-to-pro-banner">
		<div class="sft-uppro-inner-container">
			<div class="sft-uppro-main-logo">
				<a href="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
					<img src="<?php echo esc_url( plugins_url( '../assets/images/saffiretech_logo.png', __FILE__ ) ); ?>">
				</a>
			</div>
		</div>

		<div class="sft-uppro-hidden-desktop">
			<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2>
		</div>

		<div class="sft-uppro-details-container">
			<div class="sft-uppro-money-back-guarantee">
				<div>
					<a href="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
						<img src="<?php echo esc_url( plugins_url( '../assets/images/moneyback-badge.png', __FILE__ ) ); ?>">
					</a>
				</div>
				<div>
					<h2><?php esc_html_e( 'Unlock Advanced Features For Product Recommendations', 'sft-product-recommendations-woocommerce' ); ?></h2> 
					<h3><?php esc_html_e( '100% Risk-Free Money Back Guarantee!', 'sft-product-recommendations-woocommerce' ); ?></h3>
					<p><?php esc_html_e( 'We guarantee you a complete refund for new purchases or renewals if a request is made within 15 Days of purchase.', 'sft-product-recommendations-woocommerce' ); ?></p>
					<div class="prwfr-upgrade-pro-btn">
						<a href="https://www.saffiretech.com/woocommerce-related-products-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank">
							<button class="prwfr-upgrade-to-pro-btn"  onclick="window.open('https:\/\/www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=footer&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr', '_blank');">
								<?php esc_html_e( 'Upgrade To Pro!', 'sft-product-recommendations-woocommerce' ); ?>
							</button>
						</a>
					</div>
				</div>
			</div>

			<div class="sft-uppro-features-container">
				<h3> <?php echo esc_html__( 'Pro Features', 'sft-product-recommendations-woocommerce' ); ?></h3>
				<ul>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'AI powered Product Recommendations:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Leverage the power of ChatGPT to create personalized product recommendations for your customers.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Recommended Products" Emails  based on Browsing History:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Customers get "Recommended Products" email notifications based on their browsing history.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Price Drop" Email Alerts for your Featured Sale Items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Sends "Price Drop" email to customers on products marked as "Featured Sale Item" at specified intervals of your choice.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( '"Buy It Again" Widget & Purchase History Related items:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Display previously bought items and similar items to your customers to boost repeat orders or similar orders.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Product Discovery Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Attract customers with the latest arrivals, top performers, and spotlighted items using customizable widgets.', 'sft-product-recommendations-woocommerce' ); ?></li>
					<li><img width="15px" height="13px" src="<?php echo esc_url( plugins_url( '../assets/images/footer-green-tick.svg', __FILE__ ) ); ?>"> <strong><?php echo esc_html__( 'Customization options for All Widgets:', 'sft-product-recommendations-woocommerce' ); ?></strong> <?php echo esc_html__( 'Get a plethora of options to customize widget like Star Ratings, Title, Sale Price etc.', 'sft-product-recommendations-woocommerce' ); ?></li>
				</ul>
			</div>

		</div>

	</div>
	<?php
}

function prwfr_email_template_header_bg_color() {
	$value = get_option( 'prwfr_email_template_header_bg_color' ) ? get_option( 'prwfr_email_template_header_bg_color' ) : '#7f54b3';

	?>

	<div style="display: flex; align-items: center;">
		<?php
		if ( $value ) {
			?>
			<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
				<input type="text" id="prwfr_email_template_header_bg_color" class="prwfr-btn-color" name="prwfr_email_template_header_bg_color" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php esc_html( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			</div>
			<?php
		} else {
			?>
			<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
				<input type="text" id="prwfr_email_template_header_bg_color" class="prwfr-btn-color" name="prwfr_email_template_header_bg_color" value="#7f54b3" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			</div>
			<?php
		}
		?>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to pick the background color to change background color of custom email template', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_learn_more_btn_color() {
	$value = get_option( 'prwfr_learn_more_btn_color' );
	?>

	<div style="display: flex; align-items: center;">
		<?php
		if ( $value ) {
			?>
			<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
				<input type="text" id="prwfr_learn_more_btn_color" class="prwfr-btn-color" name="prwfr_learn_more_btn_color" value="<?php echo get_option( 'prwfr_learn_more_btn_color' ); ?>" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			</div>
			<?php
		} else {
			?>
			<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
				<input type="text" id="prwfr_learn_more_btn_color" class="prwfr-btn-color" name="prwfr_learn_more_btn_color" value="#0473aa" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			</div>
			<?php
		}
		?>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to pick the color to change color of learn more CTA in email', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_color_picker_field_for_arrow_icon() {
	$value = get_option( 'prwfr_button_arrow_color' );
	?>

	<div style="display: flex; align-items: center;">
		<?php
		if ( $value ) {
			?>
			<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
				<input type="text" class="prwfr-btn-color" name="prwfr_button_arrow_color" value="<?php echo get_option( 'prwfr_button_arrow_color' ); ?>" placeholder="Add label">
			</div>
			<?php
		} else {
			?>
			<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
				<input type="text" class="prwfr-btn-color" name="prwfr_button_arrow_color" value="#FFF" placeholder="Add label">
			</div>
			<?php
		}
		?>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to pick the color to change color of previous and next button within shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php

}

function prwfr_email_gdpr_permission() {
	?>
	<div>
		<label class="switch">
			<input type="checkbox" class="prwfr-email-gdpr-permission" name="prwfr_email_gdpr_permission" value="1" <?php echo checked( '1', get_option( 'prwfr_email_gdpr_permission' ), false ); ?> style="padding-right: 12px;" checked="checked">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'By checking this, it will show up confirmation text below the email id on checkout page.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	
	<?php
}


function prwfr_price_drop_rvp_schedule_event() {

	?>
	<div class="prwfr-rvp-price-drop" style="display:flex; flex-wrap: wrap; align-items: center; gap: 10px;">

		<div>
			<input type="radio" id="weekly" class="prwfr-price-drop-email-days-interval" name="prwfr_price_drop_rvp_email_days_interval" value="7"<?php echo checked( '7', get_option( 'prwfr_price_drop_rvp_email_days_interval' ), false ); ?> checked="checked">
			<label for="weekly"><?php esc_html_e( 'Weekly ', 'sft-product-recommendations-woocommerce' ); ?></label>
		</div>
		<div>
			<input type="radio" id="fortnightly" class="prwfr-price-drop-email-days-interval" name="prwfr_price_drop_rvp_email_days_interval" value="15"<?php echo checked( '15', get_option( 'prwfr_price_drop_rvp_email_days_interval' ), false ); ?>>
			<label for="fortnightly"><?php esc_html_e( 'Fortnightly ', 'sft-product-recommendations-woocommerce' ); ?></label>
		</div>
			<input type="radio" id="monthly" class="prwfr-price-drop-email-days-interval" name="prwfr_price_drop_rvp_email_days_interval" value="30"<?php echo checked( '30', get_option( 'prwfr_price_drop_rvp_email_days_interval' ), false ); ?>>
			<label for="monthly"><?php esc_html_e( 'Monthly ', 'sft-product-recommendations-woocommerce' ); ?></label>

			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to schedule an email notification to be sent to the user according to the trigger set.', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>

	</div>
	
	<?php
}

function prwfr_price_drop_email_template_logo() {

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	?>
	<form enctype="multipart/form-data">
		<?php
		if ( get_option( 'prwfr_email_logo' ) != '' ) {
		} else {
			?>
			<div class="prwfr-email-logo">
			<i class="fa-solid fa-circle-xmark fa-lg prwfr-cross-icon" style="color: #ff3d3d; cursor: pointer;"></i>
				<img src="" class="prwfr-img-logo" style="height: 100px;"/>
			</div>
			<style>
				.prwfr-email-logo-loader, .prwfr-email-logo{
					visibility: hidden;
				}
			</style>
			<?php
		}
		?>
		
		<div class="prwfr-email-img-logo">
			<input type="file" name="prwfr_email_logo" id="prwfr_image_upload_form" accept="image/*" style="
		margin: 10px !important;">
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to set your company\'s logo, which will be displayed in the header of the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		
	</form>
	<?php

}

function prwfr_price_drop_email_template_content() {

	?>
	<div class="prwfr-textarea-field-container" style="position: relative;width: 70%;">
	<?php
		wp_editor(
			'',
			'prwfr_price_drop_email_content_text',
			array(
				'textarea_name' => 'prwfr_price_drop_email_content[prwfr_price_drop_email_content_text]',
				'textarea_rows' => 10,
				'teeny'         => true,
			)
		);

	?>
		<div class="setting-help-tip" style="position: absolute !important; z-index: 10; right: -28px; top: 10px;">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to add content body for the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</div>
	</div>
	<?php
}

function prwfr_price_drop_email_template_subject() {
	?>
	<div style="display: flex; align-items: center;">
		<input type="text" class="prwfr-email-subject" name="prwfr_price_drop_email_header_content" value="<?php echo get_option( 'prwfr_price_drop_email_header_content' ); ?>" <?php echo get_option( 'prwfr_price_drop_email_header_content' ); ?>>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to set the subject for the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_related_rvp_email_send() {
	?>
	<div style="display: flex; align-items: center;">
	<label class="switch">
			<input type="checkbox" name="prwfr_related_rvp_email_send" value="1" <?php echo checked( '1', get_option( 'prwfr_related_rvp_email_send' ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose whether to send emails to users or not.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_related_rvp_schedule_event() {

	?>
	<div>

		<input type="radio" id="7days" checked="checked" class="prwfr-price-drop-email-days-interval" name="prwfr_related_rvp_email_days_interval" value="7"<?php echo checked( '7', get_option( 'prwfr_related_rvp_email_days_interval' ), false ); ?>>
		<label for="7days"><?php esc_html_e( '7 Days ', 'sft-product-recommendations-woocommerce' ); ?></label>

		<input type="radio" id="15days" class="prwfr-price-drop-email-days-interval" name="prwfr_related_rvp_email_days_interval" value="15"<?php echo checked( '15', get_option( 'prwfr_related_rvp_email_days_interval' ), false ); ?>>
		<label for="15days"><?php esc_html_e( '15 Days ', 'sft-product-recommendations-woocommerce' ); ?></label>

		<input type="radio" id="30day" class="prwfr-price-drop-email-days-interval" name="prwfr_related_rvp_email_days_interval" value="30"<?php echo checked( '30', get_option( 'prwfr_related_rvp_email_days_interval' ), false ); ?>>
		<label for="30day"><?php esc_html_e( '30 Days ', 'sft-product-recommendations-woocommerce' ); ?></label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose the recurrence interval after which the next email will be sent to the user.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	
	<?php
}

function prwfr_related_rvp_schedule_event_time() {

	$time_interval = get_option( 'prwfr_related_rvp_email_time_interval' );

	?>
	<div>
		<input type="time" class="prwfr-price-drop-email-time-interval" name="prwfr_related_rvp_email_time_interval" value="<?php echo esc_attr( sanitize_text_field( $time_interval ) ); ?>">
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to specify the time at which you want to send emails to users.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_related_rvp_email_template_subject() {
	?>
	<div>
		<input type="text" class="prwfr-email-subject" name="prwfr_personalized_recommendations_email_header_content" value="<?php echo ''; ?>" <?php echo ''; ?>>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to add content body for the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_related_rvp_email_template_content() {

	?>
	<div class="prwfr-textarea-field-container" style="position: relative;width: 70%;">
		<?php
		wp_editor(
			'',
			'prwfr_personalized_recommendations_email_content_text',
			array(
				'textarea_name' => 'prwfr_personalized_recommendations_email_content[prwfr_personalized_recommendations_email_content_text]',
				'textarea_rows' => 10,
				'teeny'         => true,
			)
		);

		?>
		<span class="setting-help-tip" style="position: absolute !important; z-index: 10; right: -28px; top: 10px;">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to add content body for the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_rvp_email_template_subject() {
	?>
	<div style="display:flex; align-items:center;">
		<input type="text" class="prwfr-email-subject" name="prwfr_rvp_email_header_content" value="Still Thinking About Them? It's Time to Make Those Recently Viewed Items Yours!" <?php echo get_option( 'prwfr_rvp_email_header_content' ); ?>>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to add content body for the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_rvp_email_template_content() {

	?>
	<div class="prwfr-textarea-field-container" style="position: relative;width: 70%;">
	<?php
	wp_editor(
		'We noticed you\'ve been checking out some great items on our site and wanted to give you a quick recap to help you make your decision. Here\'s a reminder of what caught your eye:',
		'prwfr_rvp_email_content_text',
		array(
			'textarea_name' => 'prwfr_rvp_email_content[prwfr_rvp_email_content_text]',
			'textarea_rows' => 10,
			'teeny'         => true,
		)
	);
	?>
	<span class="setting-help-tip" style="position: absolute !important; z-index: 10; right: -28px; top: 10px;">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to add content body for the custom email template.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

// -16-03-24-
function prwfr_price_drop_date_time_onetime() {

	?>
	<div>
		<input type="datetime-local" class="prwfr-price-drop-date-time" name="prwfr_price_drop_date_time_onetime" value="<?php echo ''; ?>" <?php echo ''; ?>>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to schedule a one-time event that will trigger an email notification only once according to the provided date and time.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_price_drop_email_trigger() {

	?>
	<div style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
		<div>
			<input type="radio" id="all_customer" 
			   name="prwfr_price_drop_email_trigger" value="all"<?php echo checked( 'all', get_option( 'prwfr_price_drop_email_trigger' ), false ); ?> checked="checked"> 
			<label for="all_customer"><?php esc_html_e( 'All Customers', 'sft-product-recommendations-woocommerce' ); ?></label>
		</div>
		<div>
			<input type="radio" id="rvp_sale" 
				name="prwfr_price_drop_email_trigger" value="rvp_sale"<?php echo checked( 'rvp_sale', get_option( 'prwfr_price_drop_email_trigger' ), false ); ?>> 
			<label for="rvp_sale"><?php esc_html_e( 'Users with Recently Viewed Products', 'sft-product-recommendations-woocommerce' ); ?></label> 

			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to choose whether to send emails to all users or only to those who have recently viewed products on your site.', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
	</div>
	<?php
}

function prwfr_price_drop_date_time_select() {

	$time_interval = get_option( 'prwfr_price_drop_daily_time' );
	?>
	<div>
		<input type="time" class="prwfr-price-drop-email-daily" name="prwfr_price_drop_daily_time" value="<?php echo esc_html( $time_interval ); ?>">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose whether to send emails to all users or only to those who have recently viewed products on your site.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php

}

function prwfr_price_drop_date_time_all_everyweek() {

	$time_interval = get_option( 'prwfr_price_drop_weekly_time' );
	$days_of_week  = array( __( 'Monday', 'sft-product-recommendations-woocommerce' ), __( 'Tuesday', 'sft-product-recommendations-woocommerce' ), __( 'Wednesday', 'sft-product-recommendations-woocommerce' ), __( 'Thursday', 'sft-product-recommendations-woocommerce' ), __( 'Friday', 'sft-product-recommendations-woocommerce' ), __( 'Saturday', 'sft-product-recommendations-woocommerce' ), __( 'Sunday', 'sft-product-recommendations-woocommerce' ) );
	$value         = get_option( 'prwfr_price_drop_everyweek' );
	?>
	<div class="prwfr-price-drop-all-email-weekly">
	<label for="day-of-week"><?php echo esc_html__( 'Day of the Week:', 'sft-product-recommendations-woocommerce' ); ?></label>
		<select id="day-of-week" name="prwfr_price_drop_everyweek">
			<?php
			foreach ( $days_of_week as $day ) {
				if ( $value === $day ) {
					?>
					<option selected="selected" value='<?php echo esc_html( $value ); ?>'><?php echo esc_html( $day ); ?></option>
					<?php
				} else {
					?>
					<option value='<?php echo esc_html( $day ); ?>'><?php echo esc_html( $day ); ?></option>
					<?php
				}
			}
			?>
		</select>

		<label for="time-of-day"><?php echo esc_html__( 'Time:', 'sft-product-recommendations-woocommerce' ); ?> </label>
		<input type="time" name="prwfr_price_drop_weekly_time" value="<?php echo esc_html( $time_interval ); ?>" id="time-of-day">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose a day of the week when you want to schedule email notifications.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	
	<?php
}

function prwfr_price_drop_date_time_rvp_everyweek() {
	$time_interval = get_option( 'prwfr_price_drop_weekly_time_rvp' );
	$days_of_week  = array( __( 'Monday', 'sft-product-recommendations-woocommerce' ), __( 'Tuesday', 'sft-product-recommendations-woocommerce' ), __( 'Wednesday', 'sft-product-recommendations-woocommerce' ), __( 'Thursday', 'sft-product-recommendations-woocommerce' ), __( 'Friday', 'sft-product-recommendations-woocommerce' ), __( 'Saturday', 'sft-product-recommendations-woocommerce' ), __( 'Sunday', 'sft-product-recommendations-woocommerce' ) );
	$value         = get_option( 'prwfr_price_drop_everyweek_rvp' );

	?>
	<div class="prwfr-price-drop-rvp-email-weekly">
	<label for="day-of-week"><?php esc_html_e( 'Day of the Week: ', 'sft-product-recommendations-woocommerce' ); ?></label>
		<select id="day-of-week" name="prwfr_price_drop_everyweek_rvp">
			<?php
			foreach ( $days_of_week as $day ) {
				if ( ucfirst( $value ) === $day ) {
					?>
					<option selected="selected" value='<?php echo esc_html( ucfirst( $value ) ); ?>'><?php echo esc_html( $day ); ?></option>
					<?php
				} else {
					?>
					<option value='<?php echo esc_html( $day ); ?>'><?php echo esc_html( $day ); ?></option>
					<?php
				}
			}
			?>
		</select>

		<label for="time-of-day"><?php esc_html_e( 'Time: ', 'sft-product-recommendations-woocommerce' ); ?></label>
		<input type="time" name="prwfr_price_drop_weekly_time_rvp" value="<?php echo esc_html( $time_interval ); ?>" id="time-of-day">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose a day of the week when you want to schedule email notifications.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_price_drop_all_monthly() {

	$value         = get_option( 'prwfr_price_drop_monthly' );
	$time_interval = get_option( 'prwfr_price_drop_monthly_time' );
	?>
	<div class="prwfr-price-drop-all-email-monthly">
		<label for="day-of-month"><?php esc_html_e( 'Select the nth day of the month: ', 'sft-product-recommendations-woocommerce' ); ?></label>
		<input type="number" id="day-of-month" name="prwfr_price_drop_monthly" value="<?php echo esc_html( $value ); ?>" min="1" max="31">

		<label for="time-of-day"><?php esc_html_e( 'Time: ', 'sft-product-recommendations-woocommerce' ); ?></label>
		<input type="time" name="prwfr_price_drop_monthly_time" value="<?php echo esc_html( $time_interval ); ?>" id="time-of-day">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose the day of the month on which to schedule an email to be sent once a month.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	
	<?php
}

function prwfr_price_drop_rvp_monthly() {

	$value         = intval( get_option( 'prwfr_price_drop_monthly_rvp' ) ) ? get_option( 'prwfr_price_drop_monthly_rvp' ) : 1;
	$time_interval = get_option( 'prwfr_price_drop_monthly_time_rvp' );
	?>
	<div class="prwfr-price-drop-rvp-email-monthly">

		<label for="day-of-month"><?php esc_html_e( 'Select the nth day of the month: ', 'sft-product-recommendations-woocommerce' ); ?></label>
		<input type="number" id="day-of-month" name="prwfr_price_drop_monthly_rvp" value="<?php echo esc_html( $value ); ?>" min="1" max="31">

		<label for="time-of-day">Time: </label>
		<input type="time" name="prwfr_price_drop_monthly_time_rvp" value="<?php echo esc_html( $time_interval ); ?>" id="time-of-day">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose the day of the month on which to schedule an email to be sent once a month.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	
	<?php
}

function prwfr_price_drop_rvp_fortnightly() {
	?>
	<div>
		<input type="datetime-local" class="prwfr-price-drop-date-time-fortnightly" name="prwfr_price_drop_date_time_rvp_fortnightly" value="<?php echo ''; ?>" <?php echo ''; ?>>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to schedule an email to be sent after every 15 days.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_price_drop_trigger_type_all() {

	?>
	<div style="display:flex; flex-wrap:wrap; align-items:center; gap: 10px;">
		<div>
			<input type="radio" id="onetime" 
					name="prwfr_price_drop_trigger_type_all" value="onetime"<?php echo checked( 'onetime', get_option( 'prwfr_price_drop_trigger_type_all' ), false ); ?> checked="checked"> 
			<label for="onetime"><?php esc_html_e( 'One-Time', 'sft-product-recommendations-woocommerce' ); ?></label> 
		</div>
		<div>
			<input type="radio" id="daily" 
					name="prwfr_price_drop_trigger_type_all" value="1"<?php echo checked( '1', get_option( 'prwfr_price_drop_trigger_type_all' ), false ); ?> > 
			<label for="daily"><?php esc_html_e( 'Daily', 'sft-product-recommendations-woocommerce' ); ?></label> 
		</div>
		<div>
			<input type="radio" id="weekly" 
					name="prwfr_price_drop_trigger_type_all" value="7"<?php echo checked( '7', get_option( 'prwfr_price_drop_trigger_type_all' ), false ); ?>> 
			<label for="weekly"><?php esc_html_e( 'Weekly', 'sft-product-recommendations-woocommerce' ); ?></label>
		</div>
		<div>
			<input type="radio" id="monthly" 
					name="prwfr_price_drop_trigger_type_all" value="30"<?php echo checked( '30', get_option( 'prwfr_price_drop_trigger_type_all' ), false ); ?>> 
			<label for="monthly"><?php esc_html_e( 'Monthly', 'sft-product-recommendations-woocommerce' ); ?></label> 

			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to schedule an email to be sent One-time, Daily, Weekly and Monthly.', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
	</div>
	<?php
}

function prwfr_rvp_related_schedule_event() {

	?>
	<div class="prwfr-rvp-related-duration" style="display:flex; flex-wrap:wrap; align-items: center; gap: 10px;">

		<div>
			<input type="radio" id="weekly" 
					name="prwfr_rvp_related_duration" value="7"<?php echo checked( '7', get_option( 'prwfr_rvp_related_duration' ), false ); ?> > 
			<label for="weekly"><?php esc_html_e( 'Weekly', 'sft-product-recommendations-woocommerce' ); ?></label> 
		</div>

		<div>
			<input type="radio" id="fortnightly" 
					name="prwfr_rvp_related_duration" value="15"<?php echo checked( '15', get_option( 'prwfr_rvp_related_duration' ), false ); ?>> 
			<label for="fortnightly"><?php esc_html_e( 'Fortnightly', 'sft-product-recommendations-woocommerce' ); ?></label> 
		</div>

		<div>
			<input type="radio" id="monthly" 
					name="prwfr_rvp_related_duration" value="30"<?php echo checked( '30', get_option( 'prwfr_rvp_related_duration' ), false ); ?>> 
			<label for="monthly"><?php esc_html_e( 'Monthly', 'sft-product-recommendations-woocommerce' ); ?></label> 

			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to schedule an email to be sent Weekly, After 15days and Monthly.', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
	</div>
	<?php

}

function prwfr_date_time_rvp_related_everyweek() {

	$time_interval = get_option( 'prwfr_rvp_related_weekly_time' );
	$days_of_week  = array( __( 'Monday', 'sft-product-recommendations-woocommerce' ), __( 'Tuesday', 'sft-product-recommendations-woocommerce' ), __( 'Wednesday', 'sft-product-recommendations-woocommerce' ), __( 'Thursday', 'sft-product-recommendations-woocommerce' ), __( 'Friday', 'sft-product-recommendations-woocommerce' ), __( 'Saturday', 'sft-product-recommendations-woocommerce' ), __( 'Sunday', 'sft-product-recommendations-woocommerce' ) );
	$value         = get_option( 'prwfr_rvp_related_everyweek' );

	?>
	<div class="prwfr-rvp-related-weekly">
	<label for="day-of-week"><?php esc_html_e( 'Day of the Week:', 'sft-product-recommendations-woocommerce' ); ?></label>
		<select id="day-of-week" name="prwfr_rvp_related_everyweek">
			<?php
			foreach ( $days_of_week as $day ) {
				if ( ucfirst( $value ) == $day ) {
					?>
					<option selected="selected" value='<?php echo esc_html( ucfirst( $value ) ); ?>'><?php echo esc_html( $day ); ?></option>
					<?php
				} else {
					?>
					<option value='<?php echo esc_html( $day ); ?>'><?php echo esc_html( $day ); ?></option>
					<?php
				}
			}
			?>
		</select>

		<label for="time-of-day"><?php esc_html_e( 'Time: ', 'sft-product-recommendations-woocommerce' ); ?></label>
		<input type="time" name="prwfr_rvp_related_weekly_time" value="<?php echo esc_html( $time_interval ); ?>" id="time-of-day">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to schedule an email to be sent Weekly, After 15days and Monthly.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	
	<?php

}

function prwfr_rvp_related_monthly() {
	$value         = get_option( 'prwfr_rvp_related_monthly_day' ) ? intval( get_option( 'prwfr_rvp_related_monthly_day' ) ) : 1;
	$time_interval = get_option( 'prwfr_rvp_related_monthly_time' ) == ':' ? '' : get_option( 'prwfr_rvp_related_monthly_time' );

	?>
	<div class="prwfr-rvp-related-monthly">

		<label for="day-of-month"><?php esc_html_e( 'Select the nth day of the month:', 'sft-product-recommendations-woocommerce' ); ?></label>
		<input type="number" id="day-of-month" name="prwfr_rvp_related_monthly_day" value="<?php echo esc_html( $value ); ?>" min="1" max="31">

		<label for="time-of-day">Time: </label>
		<input type="time" name="prwfr_rvp_related_monthly_time" value="<?php echo esc_html( $time_interval ); ?>" id="time-of-day">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose the day of the month on which to schedule an email to be sent once a month.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	
	<?php
}

function prwfr_rvp_related_fortnightly() {

	?>
	<div>
		<input type="datetime-local" class="prwfr-rvp-related-fortnightly" name="prwfr_rvp_related_fortnightly" value="<?php echo ''; ?>">

		<span class="setting-help-tip">        
			<div class="tooltipdata">      
				<?php esc_html_e( 'This setting allows you to choose the day of the month on which to schedule an email to be sent once a month.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_rvp_related_hours_duration() {
	$value = get_option( 'prwfr_rvp_email_hours_interval' ) ? get_option( 'prwfr_rvp_email_hours_interval' ) : 8;
	?>
	<div class="prwfr-rvp-email-hours-interval" style="margin: 0px 0 15px;">
		<?php esc_html_e( 'After ', 'sft-product-recommendations-woocommerce' ); ?>
		<input type="number" style="width: 50px;" name="prwfr_rvp_email_hours_interval" value="<?php echo esc_attr( $value ); ?>" <?php echo esc_attr( $value ); ?>>
		<?php esc_html_e( ' Hours ', 'sft-product-recommendations-woocommerce' ); ?>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose the hours of the day to schedule an email to be sent every \'n\' hours if a user has viewed a new batch of products.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_rvp_related_days_duration() {

	?>
	<div class="prwfr-rvp-email-days-interval">
		<?php esc_html_e( 'After Every ', 'sft-product-recommendations-woocommerce' ); ?>
		<input type="number" id="ndays" style="width: 50px;" name="prwfr_rvp_email_days_interval" value="<?php echo ''; ?>" min="1">
		<?php esc_html_e( '  Days at ', 'sft-product-recommendations-woocommerce' ); ?>
		<input type="time" name="prwfr_rvp_email_time" value="<?php echo ''; ?>" <?php echo ''; ?>>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose the hours of the day to schedule an email to be sent every \'n\' hours if a user has viewed a new batch of products.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	
	<?php
}

function prwfr_rvp_email_send() {
	?>
	<div style="display: flex; align-items: center;">
		<label class="switch">
			<input type="checkbox" name="prwfr_rvp_email_send" value="1" <?php echo checked( '1', get_option( 'prwfr_rvp_email_send' ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose whether to send emails to users or not.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_price_drop_email_send_check() {
	?>
	<div style="display: flex; align-items: center;">
	<label class="switch">
			<input type="checkbox" name="prwfr_price_drop_email_send_check" value="1" <?php echo checked( '1', get_option( 'prwfr_price_drop_email_send_check' ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose whether to send emails to users or not.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

function prwfr_rvp_email_recurrence() {
	?>
	<div style="display: flex; align-items: center; gap: 5px;">

		<div>
			<input type="radio" class = "prwfr-email-recurrence-radio" id="hours" name="prwfr_rvp_email_recurrence_interval" value="hours"<?php echo checked( 'hours', get_option( 'prwfr_rvp_email_recurrence_interval' ), false ); ?> checked="checked">
			<label for="hours"><?php esc_html_e( 'After X Hours ', 'sft-product-recommendations-woocommerce' ); ?></label>
		</div>
		<div>
			<input type="radio" class = "prwfr-email-recurrence-radio" id="days" name="prwfr_rvp_email_recurrence_interval" value="days"<?php echo checked( 'days', get_option( 'prwfr_rvp_email_recurrence_interval' ), false ); ?>>
			<label for="days"><?php esc_html_e( 'After X Days', 'sft-product-recommendations-woocommerce' ); ?><img class="prwfr-pro-feature-tab-icon" src="<?php echo esc_url( plugins_url( '../assets/images/pro-feature-icon.png', __FILE__ ) ); ?>" /></label><br>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to schedule an email to be sent every \'n\' hours or \'n\' days.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>


	</div>
	<?php
}

// --------------------------------------AI Section Settings ---------------------------------------------.

/**
 * Api key section.
 */
function prwfr_api_integration_settings_section() {
	?>
	<div class="pluginHeadingwrap">

		<section class="pluginHeader">
			<div class="headerRight">
			</div>
		</section>

		<main>
			<div class="notificationGrup"></div>

			<!-- Form saving api key -->
			<form method="post" action="options.php">
				<?php
				settings_fields( 'prwfr-api-field-setting' );
				do_settings_sections( 'prwfr-ai-key-settings-options' );
				?>
				<input type="submit" name="prwfr_save_key" class="button button-primary" value="<?php echo esc_html__( 'Save API Key', 'woocommerce-related-products-pro' ); ?>">
			</form><br><br />
		</main>
	</div>
	<?php
}

/**
 * Api Logs section.
 */
function prwfr_api_integration_logs_settings_section() {

	// If view is set.
	if ( isset( $_GET['view'] ) ) {
		update_option( 'prwfr_view_hit', 1 );
	}

	if ( ( ! isset( $_GET['tab'] ) ) || ( $_GET['tab'] == 'related_products' ) ) {
		?>
		<div>
			<!-- <div class="prwfr-log-tab" id="tab2" onclick="showContent('content2')">Previous Logs</div> -->
			<?php echo prwfr_get_log_request_status(); ?>
		</div>

		<div class="prwfr-log-content-main-container">
			<div class="prwfr-log-content-container" id="content2">
			</div>
		</div>
		<?php
	}

	if ( $_GET['tab'] == 'product_recommendation' ) {
		echo 'recommendations';
	}
}

/**
 * To display To get API Key.
 */
function prwfr_get_ai_api_key_field() {
	$display_key_status = '';
	?>

	<div class="prwfr-add-api-key-container">
		<input type="text" class="prwfr-token-invalid" name="prwfr_openai_api_key" id="prwfr_api_key" value="<?php echo esc_attr( get_option( 'prwfr_openai_api_key' ) ); ?>" />
		<input type="button" name="prwfr_ajax_button" class="prwfr_ajax_button" id="prwfr_ajax_button" value="<?php echo esc_html_e( 'Validate API Key', 'woocommerce-related-products-pro' ); ?>" />
		<span style="margin-top: 12px;"><a href="https://www.saffiretech.com/docs/sft-woocommerce-related-products/" target='_blank'><?php echo esc_html__( 'learn more', 'woocommerce-related-products-pro' ); ?></a></span>
	</div>

	<div class="prwfr-add-api-key-message-container">
		<?php
		if ( get_option( 'prwfr_api_valid_key_status' ) == 1 ) {
			$display_key_status = '<i class="fas fa-check-circle" style="color: green;"></i> ' . __( 'Your API key is valid!', 'woocommerce-related-products-pro' );
		} else {
			$display_key_status = '<i class="fas fa-times-circle" style="color: red;"></i> ' . __( 'Please Enter Valid API key!', 'woocommerce-related-products-pro' );
		}
		?>
		<span id="prwfr-key-valid-message"><?php echo wp_kses_post( $display_key_status ); ?></span>
	</div>
	<?php
}

/**
 * To display all chat model name available with this api key.
 */
function prwfr_get_ai_api_model_field() {

	// Call the request and save data.
	$api_key_data = get_option( 'prwfr_openai_api_key' );

	if ( $api_key_data == '' ) {
		echo esc_html__( 'API Key is required to fetch models', 'sft-product-recommendations-woocommerce' );
	} else {

		// Check existing models if not found refresh the models again.
		if ( ( false === get_transient( 'prwfr_set_model_names' ) ) || ( empty( get_transient( 'prwfr_set_model_names' ) ) ) ) {

			// Get the api response data for model names.
			$response_data = prwfr_api_server_callback_validation( $api_key_data );
			$model_names   = $response_data['data']['data'];

			// Get the valid model names.
			$model_data = prwfr_get_valid_model_names( $model_names, $api_key_data );

			// If valid models found.
			if ( $model_data ) {

				// Initally update the first model names for dropdown to option.
				update_option( 'prwfr_openai_api_model', $model_data[0] );

				// Refresh models after one month.
				set_transient( 'prwfr_set_model_names', $model_data, 2628000 );

				// Get the selected model name.
				$selected_model = get_option( 'prwfr_openai_api_model' );

				// Update insufficient quota to empty.
				update_option( 'prwfr_api_request_created_status', '' );
				?>

				<!-- Load all the valid model names -->
				<select name="prwfr_openai_api_model" class="prwfr_openai_api_model">
					<?php
					foreach ( $model_data as $model ) {
						if ( $selected_model == $model ) {
							?>
							<option value="<?php echo esc_html( $model ); ?>" selected><?php echo esc_html( $model ); ?></option>
							<?php
						} else {
							?>
							<option value="<?php echo esc_html( $model ); ?>"><?php echo esc_html( $model ); ?></option>
							<?php
						}
					}
					?>
				</select>

				<!-- Loader div -->
				<p class="prwfr-ai-message-data">
				<?php
			} else {

				// Update insufficient quota.
				update_option( 'prwfr_api_request_created_status', 'insufficient_quota' );
				?>

				<!-- Loader div -->
				<p class="prwfr-ai-message-data"><?php echo esc_html__( 'It looks like you don\'t have access to the ChatGPT model with your current API key.', 'sft-product-recommendations-woocommerce' ); ?><br/> 
				<?php echo esc_html__( 'To resolve this please check your subscription by visiting the', 'sft-product-recommendations-woocommerce' ); ?> <a href="https://platform.openai.com/settings/organization/billing/"><?php echo esc_html__( 'billing', 'sft-product-recommendations-woocommerce' ); ?></a> <?php echo esc_html__( 'page.', 'sft-product-recommendations-woocommerce' ); ?></p>
				<?php
			}
		} else {

			// All the stored model data.
			$model_data = get_transient( 'prwfr_set_model_names' );

			// Get the selected model name.
			$selected_model = get_option( 'prwfr_openai_api_model' );
			?>

			<!-- Load all the valid model names -->
			<select name="prwfr_openai_api_model" class="prwfr_openai_api_model">
				<?php
				// If model data exist.
				if ( ! empty( $model_data ) ) {
					foreach ( $model_data as $model ) {

						if ( $model == $selected_model ) {
							?>
							<option value="<?php echo esc_html( $model ); ?>" selected><?php echo esc_html( $model ); ?></option>
							<?php
						} else {
							?>
							<option value="<?php echo esc_html( $model ); ?>"><?php echo esc_html( $model ); ?></option>
							<?php
						}
					}
				} else {
					?>
					<option value="0"><?php echo esc_html( 'No Models Found !', 'sft-product-recommendations-woocommerce' ); ?></option>
					<?php
				}
				?>
			</select>

			<!-- Loader div -->
			<p class="prwfr-ai-message-data">
			<?php
		}
	}
}

<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'template_redirect', 'prwfr_product_page_load' );

add_shortcode( 'prwfr_recently_viewed_products_front', 'prwfr_recently_viewed_products_front' );

/**
 * To showcase Recently viewed items in a single row, use a shortcode that arranges and displays the products accordingly.
 */
function prwfr_recently_viewed_products_front() {

	global $wpdb;
	$user_id                = get_current_user_id();
	$rvp_product_ids_temp   = array();
	$rvp_product_ids_array  = array();
	$desktop_products_limit = get_option( 'prwfr_rvps_desktop_limit' );
	$tab_products_limit     = get_option( 'prwfr_rvps_tab_limit' );
	$mobile_products_limit  = get_option( 'prwfr_rvps_mobile_limit' );
	$products_array_temp    = array();
	$current_date           = gmdate( 'Y-m-d' );
	$date_before_15days     = gmdate( 'Y-m-d', strtotime( '-15 days', strtotime( $current_date ) ) );
	$table_name             = $wpdb->prefix . 'sft_user_product_interactions';

	if ( intval( $desktop_products_limit ) === 0 ) {
		$desktop_products_limit = '4';
	}

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	ob_start();

	if ( is_user_logged_in() ) {
		// $products_array stores rvps product id for logged in users.

		// Prepare and execute the query safely using wpdb->prepare for values only.
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT product_details FROM `$table_name` WHERE interaction_type=%s AND DATE(interaction_timestamp) BETWEEN %s AND %s AND customer_id=%d",
				'recently-viewed-products',
				$date_before_15days,
				$current_date,
				$user_id
			)
		);

		$rvp_products = array();
		foreach ( $result as $row ) {
			$prdoucts     = json_decode( $row->product_details, true );
			$rvp_products = array_merge( $rvp_products, $prdoucts['product_ids'] );
		}

		$products_array       = array_reverse( $rvp_products );
		$products_array       = array_unique( $products_array );
		$rvp_product_ids_temp = $products_array;

		?>
		<!-- Displays title for rvps -->
		<div class="prwfr-rvps-front-title prwfr-widget-title-container">
			<?php
			$title = get_option( 'prwfr_rvps_title' );
			?>
				<?php
				if ( ! $title ) {
					echo '<h2>' . esc_html__( 'Recently Viewed Products', 'sft-product-recommendations-woocommerce' ) . '</h2>';
				} else {
					echo '<h2>' . esc_html( $title ) . '</h2>';
				}

				$page_id            = get_option( 'prwfr_rvps_page_id' );
				$translated_page_id = prwfr_translate_woocommerce_title( $page_id );
				?>

			<div class="prwfr-widget-inner-container">

				<!-- See more link to redirect to page containig all recently viewed prdoucts -->
				<div class="prwfr-see-more">
					<a href="<?php echo esc_url( get_permalink( $translated_page_id ) ); ?>" onMouseOver="this.style.color='#CD5C5C'"
					onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; color: #4682B4; font-size: small !important;"><?php esc_html_e( 'See more', 'sft-product-recommendations-woocommerce' ); ?></a>
				</div>
				
				<!-- Displays pagination and start over on right corner of row -->
				<!-- <div style="float: right; display: flex;gap: 15px;"> -->
				<div class="prwfr-pagination-container">
					<div class="prwfr-rvps-page-display prwfr-page-display" style="font-size: medium;"><?php esc_html_e( 'Page no', 'sft-product-recommendations-woocommerce' ); ?></div>
					<div class="prwfr-rvps-start-over prwfr-start-over" onMouseOver="this.style.color='#CD5C5C'"
					onMouseOut="this.style.color='#4682B4'" style="font-size: small; color: #4682B4; display:none; z-index:200; cursor: pointer;" data-name="rvps"><?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?></div>
				</div>
			
			</div>


		</div>
		<?php

		foreach ( $rvp_product_ids_temp as $product_id ) {
			array_push( $products_array_temp, $product_id );
		}

		$rvp_product_ids_temp = $products_array_temp;

		if ( ! empty( $rvp_product_ids_temp ) && ! intval( $rvp_product_ids_temp[ count( $rvp_product_ids_temp ) - 1 ] ) ) {
			array_pop( $rvp_product_ids_temp );
		}

		if ( count( $rvp_product_ids_temp ) < intval( $desktop_products_limit ) ) {

			?>
			<!-- If there is no element in $rvp_product_ids_temp array, rvps will be hidden in shortcode -->
			<script>
					jQuery(document).ready(function() {
					jQuery(".prwfr-rvps-front-title").hide();
					})
			</script>
			<?php
		} else {

			foreach ( $rvp_product_ids_temp as $product_id ) {
				if ( intval( $product_id ) ) {
					array_push( $rvp_product_ids_array, $product_id );
				}
			}
			if ( is_product() ) {
				$curr_products         = (array) get_the_ID();
				$rvp_product_ids_array = array_diff( $rvp_product_ids_array, $curr_products );
			}
			prwfr_display_products( $rvp_product_ids_array, intval( $desktop_products_limit ), intval( $tab_products_limit ), intval( $mobile_products_limit ), 'rvps', 'rvps' );

		}
	} else {

		// If admin donot toggle hide switch.
		if ( ! intval( get_option( 'prwfr_rvps_hide_cookie' ) ) ) {

			if ( isset( $_SERVER['SERVER_NAME'] ) ) {

				// Sanitize the server name to create a safe cookie name.
				$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
				$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

				// Retrieve the option value using the sanitized cookie name.
				$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

			}

			if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) {

				// $products_array stores rvps product id for non logged in users.
				$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
				$products_array = explode( ',', $products_array );
				$products_array = array_reverse( $products_array );
				$products_array = array_unique( $products_array );

				// print_r( $products_array );
				if ( count( $products_array ) ) {
					?>

					<!-- Title to diaplay rvps for non logged in users in shortcode container  -->
					<div class="prwfr-cookie-rvps-front-title prwfr-widget-title-container">

						<?php
						$title = get_option( 'prwfr_rvps_title' );

						if ( ! $title ) {
							echo '<h2>' . esc_html__( 'Recently Viewed Products', 'sft-product-recommendations-woocommerce' ) . '</h2>';
						} else {
							echo '<h2>' . esc_html( $title ) . '</h2>';
						}

						$page_id            = get_option( 'prwfr_rvps_page_id' );
						$translated_page_id = prwfr_translate_woocommerce_title( $page_id );
						?>

						<div class="prwfr-widget-inner-container">

							<span class="prwfr-see-more">
								<a href="<?php echo esc_url( get_permalink( $translated_page_id ) ); ?>" onMouseOver="this.style.color='#CD5C5C'"
								onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; color: #4682B4; font-size: small !important;"><?php esc_html_e( 'See more', 'sft-product-recommendations-woocommerce' ); ?>
								</a>
							</span>

							<div class="prwfr-pagination-container">

								<div class="prwfr-cookie-rvps-page-display prwfr-page-display" style="font-size: medium;"><?php esc_html_e( 'Page no', 'sft-product-recommendations-woocommerce' ); ?></div>
								<div class="prwfr-cookie-rvps-start-over prwfr-start-over" onMouseOver="this.style.color='#CD5C5C'"
								onMouseOut="this.style.color='#4682B4'" style="font-size: small; color: #4682B4; display:none; z-index:200;" data-name="cookie-rvps"><?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?></div>

							</div>
							
						</div>

					</div>
					<?php

					// Call function if no of elements in array is greater than or equal to the desktop limit set.
					if ( count( $products_array ) >= intval( $desktop_products_limit ) ) {

						if ( is_product() ) {
							$curr_products  = (array) get_the_ID();
							$products_array = array_diff( $products_array, $curr_products );
						}

						prwfr_display_products( $products_array, intval( $desktop_products_limit ), intval( $tab_products_limit ), intval( $mobile_products_limit ), 'cookie-rvps', 'rvps' );

					} else {
						?>
						<script>
							jQuery('.prwfr-cookie-rvps-front-title').hide();
						</script>
						<?php
					}
				}
			}
		}
	}

	$content = ob_get_clean();
	return $content;
}

add_shortcode( 'prwfr_onsale_recently_viewed_products_front', 'prwfr_onsale_recently_viewed_products_front' );

/**
 * To showcase Related products and Recently viewed items on sale in a single row, use a shortcode that arranges and displays the products accordingly.
 */
function prwfr_onsale_recently_viewed_products_front() {

	global $wpdb;
	$user_id                   = get_current_user_id();
	$onsale_products_with_slug = array();
	$rvp_onsale_products_array = array();
	$products_onsale_ids       = wc_get_product_ids_on_sale();
	$rvps_onsale_products_id   = array();

	$desktop_products_limit = get_option( 'prwfr_rvps_onsale_desktop_limit' );
	$tab_products_limit     = get_option( 'prwfr_rvps_onsale_tab_limit' );
	$mobile_products_limit  = get_option( 'prwfr_rvps_onsale_mobile_limit' );

	$current_date       = gmdate( 'Y-m-d' );
	$date_before_15days = gmdate( 'Y-m-d', strtotime( '-15 days', strtotime( $current_date ) ) );
	$table_name         = $wpdb->prefix . 'sft_user_product_interactions';

	if ( intval( $desktop_products_limit ) === 0 ) {
		$desktop_products_limit = '4';
	}

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	ob_start();

	if ( ! empty( $products_onsale_ids ) ) {

		if ( is_user_logged_in() ) {

			// Prepare and execute the query safely using wpdb->prepare for values only.
			$result = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT product_details FROM $table_name WHERE interaction_type=%s AND DATE(interaction_timestamp) BETWEEN %s AND %s AND customer_id=%d",
					'recently-viewed-products',
					$date_before_15days,
					$current_date,
					$user_id
				)
			);

			$rvp_products = array();
			foreach ( $result as $row ) {
				$prdoucts     = json_decode( $row->product_details, true );
				$rvp_products = array_merge( $rvp_products, $prdoucts['product_ids'] );
			}

			$products_array = array_reverse( $rvp_products );
			$products_array = array_unique( $products_array );

			?>
			<div class="prwfr-rvps-onsale-front-title prwfr-widget-title-container">
					<?php
					$title = get_option( 'prwfr_rvps_onsale_title' );

					if ( ! $title ) {
						echo '<h2>' . esc_html__( 'Trending Deals', 'sft-product-recommendations-woocommerce' ) . '</h2>';
					} else {
						echo '<h2>' . esc_html( $title ) . '</h2>';
					}
					$page_id            = get_option( 'prwfr_rvps_onsale_page_id' );
					$translated_page_id = prwfr_translate_woocommerce_title( $page_id );
					?>

					<div class="prwfr-widget-inner-container">
						<!-- See more link to redirect to page containig all recently viewed prdoucts and related on sale -->
						<span class="prwfr-see-more">
							<a href="<?php echo esc_url( get_permalink( $translated_page_id ) ); ?>" onMouseOver="this.style.color='#CD5C5C'"
							onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; color: #4682B4; font-size: small !important;"><?php esc_html_e( 'See more', 'sft-product-recommendations-woocommerce' ); ?></a>
						</span>

						<!-- Displays pagination and <?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?> on right corner of row -->
						<div class="prwfr-pagination-container">
							<div class="prwfr-rvps-onsale-page-display prwfr-page-display" style="font-size: medium;"><?php esc_html_e( 'Page no', 'sft-product-recommendations-woocommerce' ); ?></div>
							<div class="prwfr-rvps-onsale-start-over prwfr-start-over" onMouseOver="this.style.color='#CD5C5C'"
							onMouseOut="this.style.color='#4682B4'" style="font-size: small; color: #4682B4; display:none; z-index:200; cursor:pointer;" data-name="rvps-onsale"><?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?></div>
						</div>
					</div>
				</div>
			<?php
			// If the variable $products_array has elements, then the slugs of the categories associated with products in the rvps will be stored in $onsale_products_with_slug.
			if ( count( $products_array ) ) {

				foreach ( $products_array as $product_id ) {

					if ( intval( $product_id ) !== 0 ) {
						$product_categories = wp_get_post_terms( $product_id, 'product_cat' );
						foreach ( $product_categories as $product ) {
							array_push( $onsale_products_with_slug, $product->slug );
						}
					}
				}

				// Get all the products that have categories from $onsale_products_with_slug included in them.
				$onsale_products_with_slug = array_unique( $onsale_products_with_slug );
				$args_rvps_onsale          = array(
					'posts_per_page' => -1,
					'post_type'      => 'product',
					'post__in'       => $products_onsale_ids,
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => $onsale_products_with_slug,
						),
					),
				);

				$query_rvps_onsale = new WP_Query( $args_rvps_onsale );

				// $rvp_onsale_products_array contains all products on sale which are related to rvps
				foreach ( $query_rvps_onsale->posts as $post ) {
					array_push( $rvp_onsale_products_array, $post->ID );
				}

				$rvps_onsale_products_id = $rvp_onsale_products_array;
			}

			// Function is called to display rvps and realted on sale in shortcode container.
			if ( count( $rvps_onsale_products_id ) >= intval( $desktop_products_limit ) ) {
				// Limit is no of products to display in single row in shortcode container, get the limit from setting page.

				if ( is_product() ) {
					$curr_products           = (array) get_the_ID();
					$rvps_onsale_products_id = array_diff( $rvps_onsale_products_id, $curr_products );
				}

				prwfr_display_products( $rvps_onsale_products_id, intval( $desktop_products_limit ), intval( $tab_products_limit ), intval( $mobile_products_limit ), 'rvps-onsale', 'rvps_onsale' );

			} else {
				?>
				<!-- If there is no element in $rvp_product_ids_temp array, rvps will be hidden in shortcode -->
				<script>
						jQuery(document).ready(function() {
						jQuery(".prwfr-rvps-onsale-front-title").hide();
						})
				</script>
				<?php
			}
		} else {
			if ( ! intval( get_option( 'prwfr_rvps_onsale_hide_cookie' ) ) ) {

				if ( isset( $_SERVER['SERVER_NAME'] ) ) {

					// Sanitize the server name to create a safe cookie name.
					$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
					$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

					// Retrieve the option value using the sanitized cookie name.
					$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

				}

				if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) {

					// $products_array stores recently viewed prdoucts for non logge in users.
					$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
					$products_array = explode( ',', $products_array );
					$products_array = array_reverse( $products_array );
					$products_array = array_unique( $products_array );

					if ( count( $products_array ) ) {
						?>

						<!-- Title for rvps and realted products onsale for non logged in users  -->
						<div class="prwfr-cookie-rvps-onsale-front-title prwfr-widget-title-container">

							<?php
							$title = get_option( 'prwfr_rvps_onsale_title' );
							if ( ! $title ) {
								// $title = 'Trending Deals';
								echo '<h2>' . esc_html__( 'Trending Deals', 'sft-product-recommendations-woocommerce' ) . '</h2>';
							} else {
								echo '<h2>' . esc_html( $title ) . '</h2>';
							}

							$page_id            = get_option( 'prwfr_rvps_onsale_page_id' );
							$translated_page_id = prwfr_translate_woocommerce_title( $page_id );
							?>

							<div class="prwfr-widget-inner-container">

								<!-- See more redirects to the page caintaing all the products of rvps and realted products onsale -->
								<span class="prwfr-see-more">
									<a href="<?php echo esc_url( get_permalink( $translated_page_id ) ); ?>" onMouseOver="this.style.color='#CD5C5C'"
									onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; color: #4682B4; font-size: small !important;"><?php esc_html_e( 'See more', 'sft-product-recommendations-woocommerce' ); ?></a>
								</span>

								<div class="prwfr-pagination-container">
									<div class="prwfr-cookie-rvps-onsale-page-display prwfr-page-display" style="font-size: medium;"><?php esc_html_e( 'Page no', 'sft-product-recommendations-woocommerce' ); ?></div>
									<div class="prwfr-cookie-rvps-onsale-start-over prwfr-start-over" onMouseOver="this.style.color='#CD5C5C'"
									onMouseOut="this.style.color='#4682B4'" style="font-size: small; color: #4682B4; display:none; z-index:200;" data-name="cookie-rvps-onsale"><?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?></div>
								</div>

							</div>
						</div>
						<?php
						// rvps and related on sale non logged in user.
						foreach ( $products_array as $product_id ) {

							if ( intval( $product_id ) !== 0 ) {
								$product            = wc_get_product( $product_id );
								$product_categories = wp_get_post_terms( $product_id, 'product_cat' );
								foreach ( $product_categories as $product ) {
									array_push( $onsale_products_with_slug, $product->slug );
								}
							}
						}

						$onsale_products_with_slug = array_unique( $onsale_products_with_slug );

						// Retrieves all the products containing slugs from $onsale_products_with_slug.
						$args  = array(
							'posts_per_page' => -1,
							'post_type'      => 'product',
							'post__in'       => $products_onsale_ids,
							'tax_query'      => array(
								array(
									'taxonomy' => 'product_cat',
									'field'    => 'slug',
									'terms'    => $onsale_products_with_slug,
								),
							),
						);
						$query = new WP_Query( $args );

						foreach ( $query->posts as $post ) {
							array_push( $rvp_onsale_products_array, $post->ID );
						}

						if ( count( $rvp_onsale_products_array ) >= intval( $desktop_products_limit ) ) {

							if ( is_product() ) {
								$curr_products             = (array) get_the_ID();
								$rvp_onsale_products_array = array_diff( $rvp_onsale_products_array, $curr_products );
							}

							prwfr_display_products( $rvp_onsale_products_array, intval( $desktop_products_limit ), intval( $tab_products_limit ), intval( $mobile_products_limit ), 'cookie-rvps-onsale', 'rvps_onsale' );
						} else {
							?>
							<script>
								jQuery('.prwfr-cookie-rvps-onsale-front-title').hide();
							</script>
							<?php
						}
					}
				}
			}
		}
	}

	$content = ob_get_clean();
	return $content;
}

add_shortcode( 'prwfr_related_recently_viewed_products_front', 'prwfr_related_recently_viewed_products_front' );

/**
 * To showcase Related products for Recently viewed items in a single row, use a shortcode that arranges and displays the products accordingly.
 */
function prwfr_related_recently_viewed_products_front() {

	global $wpdb;
	$user_id                    = get_current_user_id();
	$product_categories         = array();
	$rvp_related_products_array = array();
	$products_array             = array();
	$rvp_related_products       = array();
	$desktop_products_limit     = get_option( 'prwfr_viewed_related_desktop_limit' );
	$tab_products_limit         = get_option( 'prwfr_viewed_related_tab_limit' );
	$mobile_products_limit      = get_option( 'prwfr_viewed_related_mobile_limit' );
	$current_date               = gmdate( 'Y-m-d' );
	$date_before_15days         = gmdate( 'Y-m-d', strtotime( '-15 days', strtotime( $current_date ) ) );
	$table_name                 = $wpdb->prefix . 'sft_user_product_interactions';

	if ( intval( $desktop_products_limit ) === 0 ) {
		$desktop_products_limit = '4';
	}

	// nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-product-recommendations-woocommerce' );
	$id_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-product-recommendations-woocommerce' );

	if ( ! $id_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-product-recommendations-woocommerce' ) );
	}

	ob_start();

	if ( is_user_logged_in() ) {

		// Prepare and execute the query safely using wpdb->prepare for values only.
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT product_details FROM $table_name WHERE interaction_type=%s AND DATE(interaction_timestamp) BETWEEN %s AND %s AND customer_id=%d",
				'recently-viewed-products',
				$date_before_15days,
				$current_date,
				$user_id
			)
		);

		$rvp_products = array();
		foreach ( $result as $row ) {
			$prdoucts     = json_decode( $row->product_details, true );
			$rvp_products = array_merge( $rvp_products, $prdoucts['product_ids'] );
		}

		$products_array = array_reverse( $rvp_products );
		$products_array = array_unique( $products_array );

		?>
		<!-- Title of Rvps related shortcode container -->
		<div class="prwfr-viewed-related-front-title prwfr-widget-title-container">
			<?php
			$title = get_option( 'prwfr_viewed_related_title' );

			if ( ! $title ) {
				echo '<h2>' . esc_html__( 'Related to items you\'ve viewed', 'sft-product-recommendations-woocommerce' ) . '</h2>';
			} else {
				echo '<h2>' . esc_html( $title ) . '</h2>';
			}

			$page_id            = get_option( 'prwfr_viewed_related_page_id' );
			$translated_page_id = prwfr_translate_woocommerce_title( $page_id );
			?>

		<div class="prwfr-widget-inner-container">

			<!-- See more link to redirect to page containig all recently viewed prdoucts -->
			<div class="prwfr-see-more">
				<a href="<?php echo esc_url( get_permalink( $translated_page_id ) ); ?>" onMouseOver="this.style.color='#CD5C5C'"
				onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; color: #4682B4; font-size: small !important;"><?php esc_html_e( 'See more', 'sft-product-recommendations-woocommerce' ); ?></a>
			</div>

			<!-- Displays pagination and start over on right corner of row -->
			<div class="prwfr-pagination-container">
				<div class="prwfr-viewed-related-page-display prwfr-page-display" style="font-size: medium;"><?php esc_html_e( 'Page no', 'sft-product-recommendations-woocommerce' ); ?></div>
				<div class="prwfr-viewed-related-start-over prwfr-start-over" onMouseOver="this.style.color='#CD5C5C'"
				onMouseOut="this.style.color='#4682B4'" style="font-size: small; display:none; color: #4682B4; z-index:200; cursor:pointer;" data-name="viewed-related"><?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?></div>
			</div>

		</div>

		</div>	
		<?php

		if ( get_option( 'prwfr_activate_ai_recommendations' ) ) {

			$args = array(
				'post_type'      => 'any',  // Adjust to target specific post types.
				'post_status'    => 'any',
				'posts_per_page' => -1,     // Retrieve all posts.
				'meta_key'       => 'prwfr_ai_generated_product_recommendations', // The meta key you want to delete.
				'fields'         => 'ids',   // Only get post IDs to improve performance.
			);

			$posts_with_meta = get_posts( $args );

			$rvp_ai_recommendations            = array_intersect( $products_array, $posts_with_meta );
			$ai_viewed_related_recommendations = array();
			// Loop through each post ID.
			foreach ( $rvp_ai_recommendations as $post_id ) {

				echo $post_id;
				// Retrieve the specific post meta data for the current post ID.
				$ai_recommendations = get_post_meta( $post_id, 'prwfr_ai_generated_product_recommendations', true );
				print_r( $ai_recommendations );
				// Check if there is any data retrieved.
				if ( ! empty( $ai_recommendations ) ) {
					$ai_viewed_related_recommendations = array_merge( $ai_viewed_related_recommendations, $ai_recommendations );
				}
			}
			$rvp_related_products = array_values( array_unique( array_diff( $ai_viewed_related_recommendations, $products_array ) ) );
		} else {
			// Get category slug of rvps products.
			foreach ( $products_array as $product_id ) {

				if ( intval( $product_id ) !== 0 ) {
					$product_category = wp_get_post_terms( $product_id, 'product_cat' );

					foreach ( $product_category as $product ) {
						array_push( $product_categories, $product->slug );
					}
				}
			}

			$product_categories = array_unique( $product_categories );

			$args_viewed_related  = array(
				'posts_per_page' => -1,
				'post_type'      => 'product',
				'post__not_in'   => $products_array,
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $product_categories,
					),
				),
			);
			$query_viewed_related = new WP_Query( $args_viewed_related );

			foreach ( $query_viewed_related->posts as $post ) {
				array_push( $rvp_related_products_array, $post->ID );
			}

			$rvp_related_products = $rvp_related_products_array;
		}

		if ( count( $rvp_related_products ) >= intval( $desktop_products_limit ) ) {
			if ( is_product() ) {
				$curr_products        = (array) get_the_ID();
				$rvp_related_products = array_diff( $rvp_related_products, $curr_products );
			}

			prwfr_display_products( $rvp_related_products, intval( $desktop_products_limit ), intval( $tab_products_limit ), intval( $mobile_products_limit ), 'viewed-related', 'viewed_related' );
		} else {
			?>
			<script>
				jQuery(document).ready(function() {
					jQuery('.prwfr-viewed-related-front-title').hide();
				})					
			</script>
			<?php
		}
	} else {
		if ( ! intval( get_option( 'prwfr_viewed_related_hide_cookie' ) ) ) {

			if ( isset( $_SERVER['SERVER_NAME'] ) ) {

				// Sanitize the server name to create a safe cookie name.
				$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
				$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

				// Retrieve the option value using the sanitized cookie name.
				$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

			}

			if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) {

				// Cookie array stores ids of products viewed by non logged in user.
				$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
				$products_array = explode( ',', $products_array );
				$products_array = array_reverse( $products_array );
				$products_array = array_unique( $products_array );

				if ( count( $products_array ) ) {
					?>

					<!-- Title for rvps related products in shortcode container -->
					<div class="prwfr-cookie-viewed-related-front-title prwfr-widget-title-container">
						<?php
						$title = get_option( 'prwfr_viewed_related_title' );

						if ( ! $title ) {
							// $title = 'Related to items you\'ve viewed';
							echo '<h2>' . esc_html__( 'Related to items you\'ve viewed', 'sft-product-recommendations-woocommerce' ) . '</h2>';
						} else {
							echo '<h2>' . esc_html( $title ) . '</h2>';
						}

						$page_id            = get_option( 'prwfr_viewed_related_page_id' );
						$translated_page_id = prwfr_translate_woocommerce_title( $page_id );
						?>

						<div class="prwfr-widget-inner-container">

							<span class="prwfr-see-more">
								<a href="<?php echo esc_url( get_permalink( $translated_page_id ) ); ?>" onMouseOver="this.style.color='#CD5C5C'"
								onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; color: #4682B4; font-size: small !important;"><?php esc_html_e( 'See more', 'sft-product-recommendations-woocommerce' ); ?></a>
							</span>

							<div class="prwfr-pagination-container">
								<div class="prwfr-cookie-viewed-related-page-display prwfr-page-display" style="font-size: medium;"><?php esc_html_e( 'Page no', 'sft-product-recommendations-woocommerce' ); ?></div>
								<div class="prwfr-cookie-viewed-related-start-over prwfr-start-over" onMouseOver="this.style.color='#CD5C5C'"
								onMouseOut="this.style.color='#4682B4'" style="font-size: small; color: #4682B4; display:none; z-index:200;" data-name="cookie-viewed-related"><?php esc_html_e( 'Start over', 'sft-product-recommendations-woocommerce' ); ?></div>
							</div>

						</div>
					</div>
					<?php

					// Initialize an array to store all product category slugs
					$all_product_categories = array();

					// Retrieves category slugs for rvps products.
					foreach ( $products_array as $product_id ) {
						if ( intval( $product_id ) !== 0 ) {
							$product_categories = wp_get_post_terms( $product_id, 'product_cat' );
							foreach ( $product_categories as $category ) {
								// Add the category slug to the array of all slugs
								array_push( $all_product_categories, $category->slug );
							}
						}
					}

					// Remove duplicate slugs from the array
					$product_categories = array_unique( $all_product_categories );

					// Retrieves all products containing acaltegories stored in $product_categories .
					$args_viewed_related  = array(
						'posts_per_page' => -1,
						'post_type'      => 'product',
						'post__not_in'   => $products_array,
						'tax_query'      => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'slug',
								'terms'    => $product_categories,
							),
						),
					);
					$query_viewed_related = new WP_Query( $args_viewed_related );
					foreach ( $query_viewed_related->posts as $post ) {
						array_push( $rvp_related_products_array, $post->ID );
					}

					if ( count( $rvp_related_products_array ) >= intval( $desktop_products_limit ) ) {

						if ( is_product() ) {
							$curr_products              = (array) get_the_ID();
							$rvp_related_products_array = array_diff( $rvp_related_products_array, $curr_products );
						}

						prwfr_display_products( $rvp_related_products_array, intval( $desktop_products_limit ), intval( $tab_products_limit ), intval( $mobile_products_limit ), 'cookie-viewed-related', 'viewed_related' );

					} else {

						?>
						<script>
							jQuery(document).ready(function() {
								jQuery('.prwfr-cookie-viewed-related-front-title').hide();
							})					
						</script>
						<?php

					}
				}
			}
		}
	}

	$content = ob_get_clean();
	return $content;
}

/**
 * Function to display products in widget .
 *
 * @param array  $product_ids_array .
 * @param string $stock_status .
 */
function prwfr_get_products_widget( $product_ids_array, $stock_status ) {
	$iterator = 0;

	foreach ( $product_ids_array as $product_id ) {
		if ( intval( $product_id ) !== 0 && $iterator < 6 ) {
			?>
			<div class="product-container-widget">
				<?php

				echo '<div class="widget-product-thumbnail"><a href="' . esc_url( get_permalink( $product_id ) ) . '"><span class = "prwfr-image-container">' . esc_attr( get_the_post_thumbnail( $product_id ) ) . '</span></a></div>';
				echo '<div class="prwfr-product-title"><a href="' . esc_url( get_permalink( $product_id ) ) . '">' . esc_html( get_the_title( $product_id ) ) . '</a></div>';

				// If the product is on sale then display sale price else regular price.
				++$iterator;
				?>
			</div>
			<?php
		}
	}
}

/**
 * Function to display products in shortcode.
 *
 * @param array   $product_ids_array .
 * @param integer $desktop_products_limit .
 * @param integer $tab_products_limit .
 * @param integer $mobile_products_limit .
 * @param string  $feature_name .
 * @param string  $stock_status .
 */
function prwfr_display_products( $product_ids_array, $desktop_products_limit, $tab_products_limit, $mobile_products_limit, $feature_name, $stock_status ) {

	// $products_array_temp     = array();
	$button_color = (string) get_option( 'prwfr_color_picker_btn' );
	$row_bg_color = (string) get_option( 'prwfr_color_picker_background_front' );
	$arrow_color  = get_option( 'prwfr_button_arrow_color' ) ? (string) get_option( 'prwfr_button_arrow_color' ) : '#fff';

	$products_array_imploded = array();
	$iterator                = 0;
	$products_array_imploded = implode( ',', $product_ids_array );

	$check_all_products = explode( ',', $products_array_imploded );

	// Usage.
	$product_ids = prwfr_get_products_ids_by_language();

	$product_ids_array            = array_unique( array_intersect( $check_all_products, $product_ids ) );
	$translated_products_imploded = implode( ',', $product_ids_array );

	if ( '' === $row_bg_color ) {
		$row_bg_color = '#e8e8e8';
	}

	if ( '' === $button_color ) {
		$button_color = '#000000';
	}

	if ( ! intval( $desktop_products_limit ) ) {
		$desktop_products_limit = 4;
	}

	if ( ! intval( $tab_products_limit ) ) {
		$tab_products_limit = 3;
	}

	if ( ! intval( $mobile_products_limit ) ) {
		$mobile_products_limit = 2;
	}

	// Add it to class to identify no of columns for desktop view.
	if ( 4 === $desktop_products_limit ) {
		$desktop = 'four';
	} elseif ( 5 === $desktop_products_limit ) {
		$desktop = 'five';
	} elseif ( 6 === $desktop_products_limit ) {
		$desktop = 'six';
	}

	// Add it to class to identify no of columns for tablet view.
	if ( 3 === $tab_products_limit ) {
		$tab = 'three';
	} elseif ( 4 === $tab_products_limit ) {
		$tab = 'four';
	}

	// Add it to class to identify no of columns for mobile view.
	if ( 1 === $mobile_products_limit ) {
		$mobile = 'one';
	} elseif ( 2 === $mobile_products_limit ) {
		$mobile = 'two';
	}

	if ( empty( $product_ids_array ) || ( 1 === count( $product_ids_array ) && '' === $product_ids_array[0] ) || count( $product_ids_array ) < $desktop_products_limit ) {

		wp_enqueue_script( 'jquery' );
		?>
		<script>
			jQuery(document).ready( function(){
				jQuery(".prwfr-<?php echo esc_attr( $feature_name ); ?>-front-title").hide();
			})
		</script>
		<?php
	} else {
		?>
		<script>
	
			jQuery(document).ready(function() {
				var productsArray = '<?php echo esc_js( $translated_products_imploded ); ?>';
				var featureName  = '<?php echo esc_js( $feature_name ); ?>';
				var sliderProductsLimit = 4;

				if( jQuery(window).width() >= 1200 ){
					sliderProductsLimit = <?php echo esc_js( $desktop_products_limit ); ?>;
				} else if( jQuery(window).width() >= 450 && jQuery(window).width() < 1200 ){
					sliderProductsLimit = <?php echo esc_js( $tab_products_limit ); ?>;
				} else if( jQuery(window).width() < 450 ){
					sliderProductsLimit = <?php echo esc_js( $mobile_products_limit ); ?>;
				}
	
				sliderProductsLimit = parseInt(sliderProductsLimit);

				jQuery.ajax({
					type: "POST",
					url: prwfr_ajax_action_obj.url,
					data: {
						action: 'prwfr_ajax_slider',
						page_reload : 1,
						products_array: productsArray,
						feature_name: featureName,
						slider_products_limit: sliderProductsLimit,
						nonce: '<?php echo esc_js( wp_create_nonce( 'sft-product-recommendations-woocommerce' ) ); ?>',
					},
					success: function (response) {
	
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-parent-front-container').attr('data-limit', sliderProductsLimit );
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-back-button').show();
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-next-button').show();
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-parent-front-container').empty().html(response);
	
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-parent-front-container').attr('data-page_count', '1');
						var pageNos = <?php echo esc_js( count( $product_ids_array ) ); ?> / sliderProductsLimit;
						pageNos = Math.ceil(pageNos);
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-parent-front-container').attr('data-pages', pageNos );	
						var page_count = parseInt(jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-parent-front-container').attr('data-page_count'));
						jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-page-display').html('Page 1 of ' + parseInt(pageNos));	
	
						if( page_count === pageNos  ){
							jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-next-button').hide();
							jQuery('.prwfr-<?php echo esc_js( $feature_name ); ?>-back-button').hide();
						}
					}
				})
	
			})
		</script>
	
	  
		<!-- Parent container to display rvps, rvps and related on sale, rvps related, purchase history related, back and next button, image loader. -->
		<div class="prwfr-product-list-wrap prwfr-desktop-<?php echo esc_html( $desktop ); ?>-columns prwfr-tab-<?php echo esc_html( $tab ); ?>-columns prwfr-mobile-<?php echo esc_html( $mobile ); ?>-columns">
	
			<!-- div for back button.  -->
			<div class="prwfr-parent-back-button" >
				<button class="prwfr-back-button prwfr-<?php echo esc_html( $feature_name ); ?>-back-button" type="button" value="<" style="background:<?php echo esc_html( $button_color ); ?> !important; border-radius: 4px; overflow: hidden;">
					<svg style="fill:<?php echo esc_html( $arrow_color ); ?> !important; width:20px; height:100%;" fill="<?php echo esc_html( $arrow_color ); ?>" viewBox="-6.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" transform="rotate(90)matrix(1, 0, 0, 1, 0, 0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>dropdown</title> <path d="M18.813 11.406l-7.906 9.906c-0.75 0.906-1.906 0.906-2.625 0l-7.906-9.906c-0.75-0.938-0.375-1.656 0.781-1.656h16.875c1.188 0 1.531 0.719 0.781 1.656z"></path> </g></svg>
				</button>
			</div>	
	
			<!-- Parent container to display product image, title, price, rating -->
			<div class="prwfr-parent-front-product-container prwfr-<?php echo esc_html( $feature_name ); ?>-parent-front-container" data-limit="4" data-limit-desktop="<?php echo esc_html( $desktop_products_limit ); ?>" data-limit-tablet="<?php echo esc_html( $tab_products_limit ); ?>" data-limit-mobile="<?php echo esc_html( $mobile_products_limit ); ?>" data-array="<?php print_r( $translated_products_imploded ); ?>" data-name="<?php echo esc_html( $feature_name ); ?>" data-page_count="1" data-page_count_back="0" data-pages="1" style="background:<?php echo esc_html( $row_bg_color ); ?> !important;">
	
				<?php

				foreach ( $product_ids_array as $product_id ) {
					if ( intval( $product_id ) !== 0 && $iterator < $desktop_products_limit ) {

						?>
						<div class="prwfr-product-container" >
							<a href="<?php echo esc_url( plugins_url( '../assets/images/shimmer-loader5.gif', __FILE__ ) ); ?>">
								<img src="<?php echo esc_url( plugins_url( '../assets/images/shimmer-loader5.gif', __FILE__ ) ); ?>" style="width: 100%;">
							</a>
							<a href="<?php echo esc_url( plugins_url( '../assets/images/shimmer-loader-2nd-half.gif', __FILE__ ) ); ?>">
								<img src="<?php echo esc_url( plugins_url( '../assets/images/shimmer-loader-2nd-half.gif', __FILE__ ) ); ?>" style="width: 100%;">
							</a>
						</div>
						<?php
						++$iterator;
					}
				}

				?>
			</div>
	
			<div class="prwfr-parent-next-button">
				<button class="prwfr-next-button prwfr-<?php echo esc_html( $feature_name ); ?>-next-button" type="button" value=">" style="background:<?php echo esc_html( $button_color ); ?> !important; border-radius: 4px; overflow: hidden;">
					<svg style="fill:<?php echo esc_html( $arrow_color ); ?> !important; width:20px; height:100%;" fill="<?php echo esc_html( $arrow_color ); ?>" viewBox="-6.5 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" transform="rotate(270)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>dropdown</title> <path d="M18.813 11.406l-7.906 9.906c-0.75 0.906-1.906 0.906-2.625 0l-7.906-9.906c-0.75-0.938-0.375-1.656 0.781-1.656h16.875c1.188 0 1.531 0.719 0.781 1.656z"></path> </g></svg>
				</button>
			</div>
	
		</div> 
		<?php
	}

}

/**
 * This function stores viewed products in user_meta for logged in users or in cookie for non logged in users.
 */
function prwfr_product_page_load() {

	global $wpdb;
	$user_id               = get_current_user_id();
	$user_browsing_history = get_user_meta( $user_id, 'browsing_history_on_off_' . $user_id, true ); // Get 1 if browsing history is on or 0.
	$current_timestamp     = time();
	$current_date          = gmdate( 'Y-m-d' );
	$table_name            = $wpdb->prefix . 'sft_user_product_interactions';

	// If user is logged in then viewed product's id will be stored in user meta.
	if ( is_user_logged_in() && intval( $user_browsing_history ) ) {

		$products_array = array();
		if ( is_product() && is_singular() && ! is_page() ) {

			$post_id = get_post()->ID;

			// Prepare and execute the query safely using wpdb->prepare for values only.
			$result = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT product_details FROM `$table_name` WHERE interaction_type=%s AND DATE(interaction_timestamp)=%s AND customer_id=%d",
					'recently-viewed-products',
					$current_date,
					$user_id
				)
			);

			if ( ! empty( $result ) ) {
				$viewed_products = json_decode( $result[0]->product_details, true );
				$viewed_products = array_merge( $viewed_products['product_ids'], (array) $post_id );
				$product_data    = wp_json_encode( array( 'product_ids' => $viewed_products ) );

				// Execute the query using $wpdb->query()
				$wpdb->query(
					$wpdb->prepare(
						"UPDATE $table_name SET product_details = %s, interaction_timestamp = %s WHERE DATE(interaction_timestamp) = %s AND interaction_type = %s AND customer_id = %d",
						$product_data,
						gmdate( 'Y-m-d H:i:s', $current_timestamp ),
						$current_date,
						'recently-viewed-products',
						$user_id
					)
				);
			} else {
				$product_data = wp_json_encode( array( 'product_ids' => array( $post_id ) ) );
				$wpdb->insert(
					$table_name,
					array(
						'customer_id'           => $user_id,
						'interaction_timestamp' => gmdate( 'Y-m-d H:i:s', $current_timestamp ),
						'interaction_type'      => 'recently-viewed-products',
						'product_details'       => $product_data,
						'order_ids'             => '',
						'total_sales'           => 0,
					)
				);
			}
		}
	} else {

		$products_array = array();
		// If product is viewed then for non logged in user, ids will be stored in  cookie.
		if ( is_product() && is_singular() && ! is_page() ) {

			$products_array = array();
			// If product is viewed then for non logged in user, ids will be stored in  cookie.
			if ( is_product() && is_singular() && ! is_page() ) {

				if ( isset( $_SERVER['SERVER_NAME'] ) ) {

					// Sanitize the server name to create a safe cookie name.
					$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
					$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

					// Retrieve the option value using the sanitized cookie name.
					$cookie_exist = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

				}

				if ( ! $cookie_exist ) {
					$current_date           = gmdate( 'Y-m-d', strtotime( 'now' ) ); // Current date.
					$date_object            = date_create( $current_date );
					$date_array             = (array) $date_object;
					$formatted_current_date = substr( $date_array['date'], 0, 10 );
					update_option( 'prwfr_' . $recently_viewed_products_cookie_name, $recently_viewed_products_cookie_name . '_' . $formatted_current_date );

				}

				$post_data                            = get_post();
				$post_id                              = $post_data->ID;
				$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

				if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) { // Stores cookie for 30days.
					$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
					print_r( $products_array );

					$products_array = explode( ',', $products_array );
					array_push( $products_array, $post_id );

					setcookie( $recently_viewed_products_cookie_name, implode( ',', $products_array ), time() + ( 30 * 24 * 60 * 60 ), '/' );
				} else {
					setcookie( $recently_viewed_products_cookie_name, strval( $post_id ), time() + ( 30 * 24 * 60 * 60 ), '/' );
				}
			} else {
				return;
			}
		}
	}
}

add_shortcode( 'prwfr_recently_viewed_products_back', 'prwfr_recently_viewed_products_back' );

/**
 * Function to display all recently viewed products in a page.
 */
function prwfr_recently_viewed_products_back() {

	global $wpdb;
	$user_id             = get_current_user_id();
	$products_array_temp = array();
	$current_date        = gmdate( 'Y-m-d' );
	$date_before_15days  = gmdate( 'Y-m-d', strtotime( '-15 days', strtotime( $current_date ) ) );
	$table_name          = $wpdb->prefix . 'sft_user_product_interactions';
	ob_start();

	if ( is_user_logged_in() ) {

		// Prepare and execute the query safely using wpdb->prepare for values only.
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT product_details FROM $table_name WHERE interaction_type=%s AND DATE(interaction_timestamp) BETWEEN %s AND %s AND customer_id=%d",
				'recently-viewed-products',
				$date_before_15days,
				$current_date,
				$user_id
			)
		);

		$rvp_products = array();
		foreach ( $result as $row ) {
			$prdoucts     = json_decode( $row->product_details, true );
			$rvp_products = array_merge( $rvp_products, $prdoucts['product_ids'] );
		}

		$products_array = array_reverse( $rvp_products );
		$products_array = array_unique( $products_array );

		$rvp_product_ids_temp = $products_array;

		$browse_history = get_user_meta( $user_id, 'browsing_history_on_off_' . $user_id, true );
		?>

		<div class="prwfr-products-wrapdiv-back">
			<!-- Manage history container appears on top right corner of page  -->

			<div class="prwfr-manage-history-div" style="margin: 20px 0px;">
				<div class="prwfr-manage-history" onMouseOver="this.style.color='#CD5C5C'"
				onMouseOut="this.style.color='#4682B4'" style="text-decoration: underline; cursor: pointer;"><?php esc_html_e( 'Manage History', 'sft-product-recommendations-woocommerce' ); ?></div>
					<div class="prwfr-browsing-history-switch-div" style="display: flex; align-items:center; gap: 8px; margin: 10px 0px;"><?php echo esc_html__( 'Turn On or Off Browsing History', 'sft-product-recommendations-woocommerce' ); ?>

						<label class="switch" style="margin: 0px;">
							<!-- Switch for browsing history -->
							<input type="checkbox" class="prwfr-browsing-history-switch-display" name="<?php echo esc_html( 'browsing_history_on_off_' ) . esc_attr( $user_id ); ?>" value="1" <?php echo checked( '1', esc_attr( $browse_history ), false ); ?> style="padding-right: 12px;">
							<span class="slider round prwfr-browing-history-user" ></span>
						</label>
					</div>

				<!-- Button to remove all products from the page -->
				<div>
					<input type="button" class="prwfr-rvps-remove-all-btn" value="<?php esc_html_e( 'Remove All Products', 'sft-product-recommendations-woocommerce' ); ?>" style="padding: 10px; margin-bottom: 7px;"/>
				</div>		

			</div>

			<div class="prwfr-back-product-parent" >
				<?php

				// If last element of $rvp_product_ids_temp is empty.
				foreach ( $rvp_product_ids_temp as $product_id ) {
					array_push( $products_array_temp, $product_id );
				}

				$rvp_product_ids_temp = $products_array_temp;

				if ( ! empty( $rvp_product_ids_temp ) && ! intval( $rvp_product_ids_temp[ count( $rvp_product_ids_temp ) - 1 ] ) ) {
					array_pop( $rvp_product_ids_temp );
				}

				if ( count( $rvp_product_ids_temp ) ) {
					echo '<p>' . esc_html__( 'These items were viewed recently. We use them to personalise recommendations.', 'sft-product-recommendations-woocommerce' ) . '</p>';

					?>

					<div class="prwfr-products-wrapdiv-back">
				<div class="prwfr-back-product-parent" >
					<div class="prwfr-back-product-container">
						<?php
						prwfr_get_back_shortcode_products( $rvp_product_ids_temp, 'rvps' );
						?>
					</div>
				</div>
			</div>
					<?php
				} else {
					?>
					<div class="prwfr-back-page-text-container">
						<?php echo esc_html__( 'You Have No Recently Viewed Items.', 'sft-product-recommendations-woocommerce' ); ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php

	} else {

		if ( isset( $_SERVER['SERVER_NAME'] ) ) {

			// Sanitize the server name to create a safe cookie name.
			$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
			$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

			// Retrieve the option value using the sanitized cookie name.
			$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

		}

		if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) {

			// Cookie array stores ids of products viewed by non logged in user.
			$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
			$products_array = explode( ',', $products_array );
			$products_array = array_reverse( $products_array );
			$products_array = array_unique( $products_array );
			?>

			<div class="prwfr-products-wrapdiv-back">
				<div class="prwfr-back-product-parent" >
					<div class="prwfr-back-product-container">
						<?php
						prwfr_get_back_shortcode_products( $products_array, 'rvps' );
						?>
					</div>
				</div>
			</div>
			<?php

		} else {
			?>
			<div class="prwfr-back-page-text-container">
				<?php echo esc_html__( 'You Have Not Viewed Any Product Yet!', 'sft-product-recommendations-woocommerce' ); ?>
			</div>
			<?php
		}
	}

	$content = ob_get_clean();
	return $content;
}

add_shortcode( 'prwfr_onsale_recently_viewed_products_back', 'prwfr_onsale_recently_viewed_products_back' );

/**
 * Function to display all recently viewed products and realted on sale.
 */
function prwfr_onsale_recently_viewed_products_back() {

	global $wpdb;
	$user_id                   = get_current_user_id();
	$onsale_products_with_slug = array();
	$rvp_onsale_products_array = array();
	$products_onsale_ids       = wc_get_product_ids_on_sale();
	$rvps_onsale_products_id   = array();
	$current_date              = gmdate( 'Y-m-d' );
	$date_before_15days        = gmdate( 'Y-m-d', strtotime( '-15 days', strtotime( $current_date ) ) );
	$table_name                = $wpdb->prefix . 'sft_user_product_interactions';
	ob_start();

	if ( ! empty( $products_onsale_ids ) ) {

		if ( is_user_logged_in() ) {

			// Prepare and execute the query safely using wpdb->prepare for values only.
			$result = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT product_details FROM $table_name WHERE interaction_type=%s AND DATE(interaction_timestamp) BETWEEN %s AND %s AND customer_id=%d",
					'recently-viewed-products',
					$date_before_15days,
					$current_date,
					$user_id
				)
			);

			$rvp_products = array();
			foreach ( $result as $row ) {
				$prdoucts     = json_decode( $row->product_details, true );
				$rvp_products = array_merge( $rvp_products, $prdoucts['product_ids'] );
			}

			$products_array = array_reverse( $rvp_products );
			$products_array = array_unique( $products_array );

			// Store the categories slug of recently viewed products.
			foreach ( $products_array as $product_id ) {
				if ( intval( $product_id ) !== 0 ) {
					$product            = wc_get_product( $product_id );
					$product_categories = wp_get_post_terms( $product_id, 'product_cat' );
					foreach ( $product_categories as $product ) {
						array_push( $onsale_products_with_slug, $product->slug );
					}
				}
			}

			$onsale_products_with_slug = array_unique( $onsale_products_with_slug );

			// Retrieve all products on sale which have categories from $onsale_products_with_slug in them.
			$args  = array(
				'posts_per_page' => -1,
				'post_type'      => 'product',
				'post__in'       => $products_onsale_ids,
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $onsale_products_with_slug,
					),
				),
			);
			$query = new WP_Query( $args );

			foreach ( $query->posts as $post ) {
				array_push( $rvp_onsale_products_array, $post->ID );
			}

			$rvps_onsale_products_id = $rvp_onsale_products_array;

			if ( ! count( $rvps_onsale_products_id ) ) {
				?>
				<div class="prwfr-back-page-text-container">
					<?php echo esc_html__( 'Please View More Products!', 'sft-product-recommendations-woocommerce' ); ?>
				</div>
				<?php
			} else {
				?>
				<div class = "prwfr-products-wrapdiv-back">
					<div class="prwfr-back-product-parent">
						<div class="prwfr-back-product-container">
							<?php
							prwfr_get_back_shortcode_products( $rvps_onsale_products_id, 'rvps_onsale' );
							?>
						</div>
					</div>
				</div>
				<?php
			}
		} else {

			if ( isset( $_SERVER['SERVER_NAME'] ) ) {

				// Sanitize the server name to create a safe cookie name.
				$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
				$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

				// Retrieve the option value using the sanitized cookie name.
				$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

			}

			if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) {
				// $products_array stores recently viewed prdoucts for non logge in users.
				$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
				$products_array = explode( ',', $products_array );
				$products_array = array_reverse( $products_array );
				$products_array = array_unique( $products_array );

				foreach ( $products_array as $product_id ) {
					if ( intval( $product_id ) !== 0 ) {
						$product            = wc_get_product( $product_id );
						$product_categories = wp_get_post_terms( $product_id, 'product_cat' );
						foreach ( $product_categories as $product ) {
							array_push( $onsale_products_with_slug, $product->slug );
						}
					}
				}

				$onsale_products_with_slug = array_unique( $onsale_products_with_slug );

				// Get products which are on sale and have categories from $onsale_products_with_slug.
				$args = array(
					'posts_per_page' => -1,
					'post_type'      => 'product',
					'post__in'       => $products_onsale_ids,
					'tax_query'      => array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => $onsale_products_with_slug,
						),
					),
				);

				$query = new WP_Query( $args );

				foreach ( $query->posts as $post ) {
					array_push( $rvp_onsale_products_array, $post->ID );
				}

				if ( ! count( $rvp_onsale_products_array ) ) {
					?>
					<div class="prwfr-back-page-text-container">
						<?php echo esc_html__( 'Please View More Products!', 'sft-product-recommendations-woocommerce' ); ?>
					</div>
					<?php
				} else {
					?>
					<div class = "prwfr-products-wrapdiv-back">
						<div class="prwfr-back-product-parent">
							<div class="prwfr-back-product-container">
								<?php
								// Recently viewed prdoucts and related on sale displayed on a page.
								prwfr_get_back_shortcode_products( $rvp_onsale_products_array, 'rvps_onsale' );
								?>
							</div>
						</div>
					</div>
					<?php
				}
			} else {
				?>
				<div class="prwfr-back-page-text-container">
					<?php echo esc_html__( 'You Have Not Browsed Any Product Yet!', 'sft-product-recommendations-woocommerce' ); ?>
				</div>
				<?php
			}
		}
	}

	$content = ob_get_clean();
	return $content;
}

add_shortcode( 'prwfr_related_recently_viewed_products_back', 'prwfr_related_recently_viewed_products_back' );

/**
 * Function to display Products related to recently viewed products.
 */
function prwfr_related_recently_viewed_products_back() {

	global $wpdb;
	$user_id                    = get_current_user_id();
	$product_categories         = array();
	$rvp_related_products_array = array();
	$products_array             = array();
	$rvp_related_products       = array();
	$current_date               = gmdate( 'Y-m-d' );
	$date_before_15days         = gmdate( 'Y-m-d', strtotime( '-15 days', strtotime( $current_date ) ) );
	$table_name                 = $wpdb->prefix . 'sft_user_product_interactions';

	ob_start();

	if ( is_user_logged_in() ) {

		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT product_details FROM $table_name WHERE interaction_type=%s AND DATE(interaction_timestamp) BETWEEN %s AND %s AND customer_id=%d",
				'recently-viewed-products',
				$date_before_15days,
				$current_date,
				$user_id
			)
		);

		$rvp_products = array();
		foreach ( $result as $row ) {
			$prdoucts     = json_decode( $row->product_details, true );
			$rvp_products = array_merge( $rvp_products, $prdoucts['product_ids'] );
		}

		$products_array = array_reverse( $rvp_products );
		$products_array = array_unique( $products_array );

		// Store category slug of products that are recently viewed.
		foreach ( $products_array as $product_id ) {
			if ( intval( $product_id ) !== 0 ) {
				$product          = wc_get_product( $product_id );
				$product_category = wp_get_post_terms( $product_id, 'product_cat' );

				foreach ( $product_category as $product ) {
					array_push( $product_categories, $product->slug );
				}
			}
		}

		$product_categories = array_unique( $product_categories );

		// Retrieve all the products having categories from $product_categories .
		$args  = array(
			'posts_per_page' => -1,
			'post_type'      => 'product',
			'post__not_in'   => $products_array,
			'tax_query'      => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $product_categories,
				),
			),
		);
		$query = new WP_Query( $args );

		foreach ( $query->posts as $post ) {
			array_push( $rvp_related_products_array, $post->ID );
		}

		$rvp_related_products = $rvp_related_products_array;

		if ( ! count( $rvp_related_products ) ) {
			?>
			<div class="prwfr-back-page-text-container">
				<?php echo esc_html__( 'Please View More Products!', 'sft-product-recommendations-woocommerce' ); ?>
			</div>
			<?php
		} else {
			?>
			<div class = "prwfr-products-wrapdiv-back">
				<div class="prwfr-back-product-parent">
					<div class="prwfr-back-product-container">
						<?php
						// Display all products related to recently viewed products in a page.
						prwfr_get_back_shortcode_products( $rvp_related_products, 'viewed_related' );
						?>
					</div>
				</div>
			</div>
			<?php
		}
	} else {

		if ( isset( $_SERVER['SERVER_NAME'] ) ) {

			// Sanitize the server name to create a safe cookie name.
			$recently_viewed_products_cookie_name = sanitize_key( $_SERVER['SERVER_NAME'] );
			$recently_viewed_products_cookie_name = str_replace( '.', '_', $recently_viewed_products_cookie_name );

			// Retrieve the option value using the sanitized cookie name.
			$recently_viewed_products_cookie_name = get_option( 'prwfr_' . $recently_viewed_products_cookie_name );

		}

		if ( isset( $_COOKIE[ $recently_viewed_products_cookie_name ] ) ) {
			// Cookie array stores ids of products viewed by non logged in user.
			$products_array = sanitize_text_field( wp_unslash( $_COOKIE[ $recently_viewed_products_cookie_name ] ) );
			$products_array = explode( ',', $products_array );
			$products_array = array_reverse( $products_array );
			$products_array = array_unique( $products_array );

			// Initialize an array to store all product category slugs
			$all_product_categories = array();

			// Retrieves category slugs for rvps products.
			foreach ( $products_array as $product_id ) {
				if ( intval( $product_id ) !== 0 ) {
					$product_categories = wp_get_post_terms( $product_id, 'product_cat' );
					foreach ( $product_categories as $category ) {
						// Add the category slug to the array of all slugs
						array_push( $all_product_categories, $category->slug );
					}
				}
			}

			// Remove duplicate slugs from the array
			$product_categories = array_unique( $all_product_categories );

			// Retrieve all the products having categories from $product_categories .
			$args = array(
				'posts_per_page' => -1,
				'post_type'      => 'product',
				'post__not_in'   => $products_array,
				'tax_query'      => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'slug',
						'terms'    => $product_categories,
					),
				),
			);

			$query = new WP_Query( $args );

			foreach ( $query->posts as $post ) {
				array_push( $rvp_related_products_array, $post->ID );
			}

			if ( ! count( $rvp_related_products_array ) ) {
				?>
				<div class="prwfr-back-page-text-container">
					<?php echo esc_html__( 'Please View More Products!', 'sft-product-recommendations-woocommerce' ); ?>
				</div>
				<?php
			} else {
				?>
				<div class = "prwfr-products-wrapdiv-back">
					<div class="prwfr-back-product-parent">
						<div class="prwfr-back-product-container">
							<?php
							prwfr_get_back_shortcode_products( $rvp_related_products_array, 'viewed_related' );
							?>
						</div>
					</div>
				</div>
				<?php
			}
		} else {
			?>
			<div class="prwfr-back-page-text-container">
				<?php echo esc_html__( 'You Have Not Browsed Any Product Yet!', 'sft-product-recommendations-woocommerce' ); ?>
			</div>
			<?php
		}
	}

	$content = ob_get_clean();
	return $content;
}

/**
 * Function to display products in back shortcode
 *
 * @param array  $all_product_ids .
 * @param string $stock_status .
 */
function prwfr_get_back_shortcode_products( $all_product_ids, $stock_status ) {
	$iterator           = 0;
	$image_size         = get_option( 'prwfr_product_image_size' );
	$stock_status_check = 0;

	// Usage.
	$product_ids = prwfr_get_products_ids_by_language();

	$all_product_ids = array_unique( array_intersect( $all_product_ids, $product_ids ) );

	// Display all products  in a page -> back shortcode.
	foreach ( $all_product_ids as $product_id ) {
		if ( intval( $product_id ) !== 0 ) {
			$product = wc_get_product( $product_id );
			?>
			<div class="prwfr-back-product-div">
				<?php

				$image_id   = $product->get_image_id();
				$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );
				// $image = $product->get_image_id();
				// Use WooCommerce function to get the image HTML
				$image_html = $image_id ? wp_get_attachment_image( $image_id, $image_size ) : wc_placeholder_img( $image_size );

				echo '<div style="width: fit-content; margin: auto;"><a href="' . esc_url( get_permalink( $product_id ) ) . '">' . $image_html . '</a></div>';

				echo '<div class="prwfr-product-title"><a href="' . esc_url( get_permalink( $product_id ) ) . '">' . esc_attr( get_the_title( $product_id ) ) . '</a></div>';

				++$iterator;
				?>
			</div>
			<?php
		}
	}
}

/**
 * Gives array of product ids specific to particular language.
 */
function prwfr_get_products_ids_by_language() {
	$args = array(
		'post_type'        => 'product',
		'posts_per_page'   => -1,
		'post_status'      => 'publish',
		'fields'           => 'ids',
		'suppress_filters' => false, // Important for WPML to filter by language.
	);

	$products_ids = get_posts( $args );

	return $products_ids;
}

/**
 * Function to add reorder button on order detail page, this function is called.
 *
 * @param mixed $actions .
 * @return $actions
 */
function prwfr_reorder( $actions ) {
	$show_reorder = get_option( 'prwfr_display_reorder' );
	if ( intval( $show_reorder ) ) {
		$actions['reorder'] = array(
			'url'  => wc_get_cart_url(),
			'name' => __( 'Reorder', 'sft-product-recommendations-woocommerce' ),
		);
	}

	return $actions;
}

/**
 * Creating pages for back shortcode.
 */
function prwfr_view_pages_back() {

	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	// rvps shortcode page - prwfr_rvps_page_id.
	$rvps_page_title = get_option( 'prwfr_rvps_title' );

	if ( ! $rvps_page_title ) {
		$rvps_page_title = 'Recently Viewed Products';// If title is not provided.
	}

	$shortcode      = '[prwfr_recently_viewed_products_back]';
	$option_page_id = 'prwfr_rvps_see_more_option';
	$page_id        = 'prwfr_rvps_page_id';
	prwfr_new_page_template_back( $option_page_id, $rvps_page_title, $shortcode, $page_id );

	// rvps on sale shortcode page - prwfr_rvps_onsale_page_id.
	$rvps_onsale_page_title = get_option( 'prwfr_rvps_onsale_title' );

	if ( ! $rvps_onsale_page_title ) {
		$rvps_onsale_page_title = 'Trending Deals';
	}

	$shortcode      = '[prwfr_onsale_recently_viewed_products_back]';
	$option_page_id = 'prwfr_rvps_onsale_see_more_option';
	$page_id        = 'prwfr_rvps_onsale_page_id';
	prwfr_new_page_template_back( $option_page_id, $rvps_onsale_page_title, $shortcode, $page_id );

	// viewed related shortcode page - prwfr_viewed_related_page_id.
	$view_related_page_title = get_option( 'prwfr_viewed_related_title' );

	if ( ! $view_related_page_title ) {
		$view_related_page_title = 'Related to items you\'ve viewed';
	}

	$shortcode      = '[prwfr_related_recently_viewed_products_back]';
	$option_page_id = 'prwfr_viewed_related_see_more_option';
	$page_id        = 'prwfr_viewed_related_page_id';
	prwfr_new_page_template_back( $option_page_id, $view_related_page_title, $shortcode, $page_id );

}

/**
 * Callback for Creating pages for back shortcode.
 *
 * @param string $option_page_id .
 * @param string $title .
 * @param string $shortcode .
 * @param string $page_id .
 */
function prwfr_new_page_template_back( $option_page_id, $title, $shortcode, $page_id ) {

	$iterator = 0;
	$new_page = 'default';

	if ( 'default' === $new_page || '' === $new_page || ! $new_page ) {

		$args  = array(
			'title'     => $title,
			'post_type' => 'page',
		);
		$query = new WP_Query( $args );

		// If page already exists.
		if ( $query->posts[0]->ID ) {
			foreach ( $query->posts as $post ) {
				$page    = get_post( $post->ID );
				$content = $page->post_content;

				if ( $content === $shortcode ) {
					$iterator = 1;
					update_option( $page_id, $post->ID );
				}
			}
		}

		// if page with shortcode or page does not exists.
		if ( 0 === $iterator ) {
			$current_user = wp_get_current_user();

			// create post object.
			$page = array(
				'post_title'   => $title,
				'post_content' => $shortcode,
				'post_status'  => 'publish',
				'post_author'  => $current_user->ID,
				'post_type'    => 'page',
			);

			// insert the post into the database.
			wp_insert_post( $page );
			$args  = array(
				'title'     => $title,
				'post_type' => 'page',
			);
			$query = new WP_Query( $args );
			update_option( $page_id, $query->posts[0]->ID );
		}
	} else {
		$page = get_option( $option_page_id );
		update_option( $page_id, $page );
	}
}

/**
 * Function for manage history on rvps all products page, , this function is called in sales-booster.php
 */
function prwfr_manage_history_content() {
	$show_browsing_history = get_option( 'prwfr_manage_history_access' );
	if ( intval( $show_browsing_history ) ) {
		echo '<h3 class="prwfr-manage-account-page-title">' . esc_html__( 'Manage Browsing history', 'sft-product-recommendations-woocommerce' ) . '</h3>';
		$user_id               = get_current_user_id();
		$user_browsing_history = get_user_meta( $user_id, 'browsing_history_on_off_' . $user_id, true );
		?>

		<!-- Manage history is available on account details page and page containing all recently viewed products. -->
		<div class="prwfr-manage-account-page">
			<div style="display: flex; gap: 20px;"><?php esc_html_e( 'Turn On or Off Browsing History', 'sft-product-recommendations-woocommerce' ); ?>
				<label class="switch" >
					<input class="prwfr-browsing-history-switch-display" type="checkbox"  name="<?php echo esc_html( 'browsing_history_on_off_' ) . esc_html( $user_id ); ?>" value="1" <?php echo checked( '1', esc_html( $user_browsing_history ), false ); ?> style="padding-right: 12px;">
					<span class="slider round" style="background: #1770bbe6;"></span>
				</label>
			</div>
		</div>
		<?php
	}
}

/**
 * Retrieve all the pages by specific language .
 *
 * @param int $original_id .
 */
function prwfr_translate_woocommerce_title( $original_id ) {

	global $wpdb;

	$language_code = substr( get_locale(), 0, 2 );

	$table_name = esc_sql( $wpdb->prefix . 'icl_translations' );

	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) === $table_name ) {
		// Table exists, proceed with the query.

		$translated_id = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT t.element_id
				FROM {$wpdb->prefix}icl_translations t
				JOIN {$wpdb->prefix}icl_translations tr ON t.trid = tr.trid
				WHERE tr.element_id = %d
				AND t.language_code = %s
				AND t.element_type = %s",
				$original_id,
				$language_code,
				'post_page'
			)
		);
	} else {
		// Table does not exist, handle accordingly.
		$translated_id = $original_id;
	}

	return $translated_id ? $translated_id : $original_id;
}

/**
 * Send email to users based on their notification type.
 *
 * @param array  $user_mails Array containing user emails and product details.
 * @param string $email_type Type of email notification to be sent.
 * @param int    $similar_products_pageid Page ID for displaying similar products.
 * @param string $email_content_text Content text for the email.
 * @param string $email_header_content Header content for the email.
 */
function prwfr_send_mails( $user_mails, $email_type, $similar_products_pageid, $email_content_text, $email_header_content ) {

	global $wpdb;
	$custom_upload_dir = wp_upload_dir()['baseurl'] . '/prwfr-email-notification-logo';
	$logo_img          = get_option( 'prwfr_email_logo' ) ? str_replace( ' ', '%20', get_option( 'prwfr_email_logo' ) ) : '';
	$current_timestamp = time();
	$iterator          = 1;
	$email_no_thanks   = get_option( 'email_gdpr_no_thanks' ) ? json_decode( get_option( 'email_gdpr_no_thanks' ), true ) : array();
	$table_name        = $wpdb->prefix . 'sft_user_product_interactions';
	foreach ( $user_mails as $email => $value ) {

		if ( $iterator % 10 == 0 ) {
			sleep( 10 );
		}

		if ( ! empty( $value ) && ! in_array( $email, $email_no_thanks ) ) {

			$temp_products_array = array_unique( $value );
			$products_array      = count( $temp_products_array ) > 5 ? array_slice( $temp_products_array, 0, 5 ) : $temp_products_array;

			// Reindex the array to ensure sequential keys.
			$products_array = array_values( $products_array );

			$product_data = wp_json_encode( array( 'product_ids' => $products_array ) );

			$user = get_user_by( 'email', $email );

			$wpdb->insert(
				$table_name,
				array(
					'customer_id'           => $user->ID,
					'interaction_timestamp' => gmdate( 'Y-m-d H:i:s', $current_timestamp ),
					'interaction_type'      => 'email-sent-' . $email_type,
					'product_details'       => $product_data,
					'order_ids'             => '',
					'total_sales'           => '',
				)
			);

			$email_header_content = get_option( 'prwfr_' . $email_type . '_email_header_content' ) ? get_option( 'prwfr_' . $email_type . '_email_header_content' ) : $email_header_content;
			$options              = get_option( 'prwfr_' . $email_type . '_email_content' );
			$actual_string        = wpautop( $options[ 'prwfr_' . $email_type . '_email_content_text' ] );

			$user_info = get_userdata( $user->ID );
			$username  = $user_info->user_login;

			$first_name = $user->user_firstname;
			$last_name  = $user->user_lastname;

			$value   = '"' . get_the_title( $products_array[0] ) . '" and more...';
			$subject = apply_filters( 'prwfr_' . $email_type . '_email_subject', $value );

			$encoded_string = $subject;

			$decoded_string_subject = html_entity_decode( $encoded_string, ENT_HTML5, 'UTF-8' );
			$replacements           = array(
				'{User_name}'  => $username,
				'{First_name}' => $first_name,
				'{Last_name}'  => $last_name,
			);

			if ( $actual_string != '' ) {
				// Perform replacements.
				foreach ( $replacements as $old => $new ) {
					$actual_string = str_replace( $old, $new, $actual_string );
				}
			}
			// // Perform the replacement
			$content = $actual_string != '' ? $actual_string : 'Hello ' . $first_name . ',<br><br>' . $email_content_text;

			$email_header = '<p style="
			color: white;
			font-size: 25px;
			margin: 0;
			line-height: 1.2;
			">' . $email_header_content . '</p>';

			// // echo $custom_upload_dir . '/' . $logo_img;
			// $email_logo = '<a href="#" style="display: inline-block; margin: 0; padding: 20px 10px;"><img src="' . $custom_upload_dir . '/' . $logo_img . '" alt="" width="" height="" style="display: block; height:120px; border: 0px;"></a>';

			$email_logo = '';
			if ( $logo_img != '' ) {
				$email_logo = '<tr><td align="center" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;" class="mobile-center"><a href="#" style="display: inline-block; margin: 0; padding: 0px 10px 20px 10px;"><img src="' . $custom_upload_dir . '/' . $logo_img . '" alt="" width="" height="" style="display: block; height:110px; border: 0px;"></a></td></tr>';
			}

			$similar_products_section = '';
			if ( intval( get_option( 'prwfr_display_similar_products_link' ) ) == 1 ) {
				$similar_products_section = '<tr>
					<td align="left" style="background-color: #FFF; padding: 20px 15px;" bgcolor="#FFF">
					<!--[if (gte mso 9)|(IE)]>
					<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
					<tr>
					<td align="center" valign="top" width="600">
					<![endif]-->  
					<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
						<tr>
							<td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
							<img src="' . esc_url( plugins_url( '../assets/images/arrow-left.png', __FILE__ ) ) . '" alt="" width="10" height="12" style="width:15px; height: 12px; block; max-width: 100%; height: auto; border: 0px; display: inline-block; vertical-align: sub;"> 

								<a href="' . get_permalink( $similar_products_pageid ) . '" style="display: inline-block; margin: 0; padding: 0; font-size: 18px; font-weight: 600; color:#2282ca;">
									See similar products
								</a>
							</td>
						</tr>
					</table>    
					<!--[if (gte mso 9)|(IE)]>
					</td>
					</tr>
					</table>
					<![endif]-->
					</td>
				</tr>';
			}

			wp_mail( $email, $decoded_string_subject, prwfr_get_email_content( $content, $similar_products_section, $products_array, $email_logo, $email_header ) );

		}

		++$iterator;
	}

}

/**
 * Schedule mails for Recently Viewed Products (RVP).
 * This function retrieves users' interactions with products from the database
 * and sends reminder emails about recently viewed products.
 */
function prwfr_schedule_mails_RVP() {

	global $wpdb;
	$user_mails_rvp = array();
	$current_date   = gmdate( 'Y-m-d' );
	$table_name     = $wpdb->prefix . 'sft_user_product_interactions';

	// Create a DateTime object for UTC.
	$utcTime = new DateTime( 'now', new DateTimeZone( 'UTC' ) );

	if ( get_option( 'prwfr_rvp_email_recurrence_interval' ) === 'hours' ) {

		$n_hours_ago = get_option( 'prwfr_rvp_email_hours_interval' ) ? intval( get_option( 'prwfr_rvp_email_hours_interval' ) ) : 8;

		$mail_already_sent_users = array();
		$existing_row            = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT customer_id, product_details, interaction_timestamp FROM {$table_name} WHERE interaction_type = %s AND DATE(interaction_timestamp) = %s",
				'email-sent-rvp',
				$current_date
			)
		);
		foreach ( $existing_row as $row ) {
			// date-time string.
			$date_time_string = $row->interaction_timestamp;

			// Create a DateTime object.
			$current_date_time = new DateTime( $date_time_string );
			// Calculate the difference between the two times.
			$interval = $current_date_time->diff( $utcTime );

			// Display the difference in hours.
			if ( intval( $interval->format( '%h' ) ) < $n_hours_ago ) {
				array_push( $mail_already_sent_users, $row->customer_id );
			}
		}

		// Construct the SQL query using $wpdb->prepare.
		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT customer_id, product_details 
				FROM {$table_name} 
				WHERE interaction_type = %s 
				AND DATE(interaction_timestamp) = %s",
				'recently-viewed-products',
				$current_date,
			)
		);

		// // Example usage of the results
		foreach ( $result as $row ) {
			if ( ! in_array( $row->customer_id, $mail_already_sent_users ) ) {

				$user_info  = get_userdata( $row->customer_id );
				$user_email = $user_info->user_email;

				$email_sent = $wpdb->get_row(
					$wpdb->prepare(
						"SELECT product_details FROM {$table_name}
					WHERE interaction_type = %s AND DATE(interaction_timestamp) = %s AND customer_id = %d",
						'email-sent-rvp',
						$current_date,
						$row->customer_id,
					)
				);

				$products_sent = json_decode( $email_sent->product_details, true );
				$products_sent = $products_sent['product_ids'];

				$viewed_products = json_decode( $row->product_details, true );
				$viewed_products = $viewed_products['product_ids'];

				if ( ! empty( $products_sent ) ) {
					$products_to_send = array_values( array_diff( $viewed_products, $products_sent ) );
				} else {
					$products_to_send = array_values( $viewed_products );
				}

				$user_mails_rvp[ $user_email ] = array_unique( $products_to_send );
				usort( $user_mails_rvp[ $user_email ], 'prwfr_compare_product_prices' );

			}
		}
	}

	if ( ! empty( $user_mails_rvp ) ) {

		$similar_products_pageid = get_option( 'prwfr_rvps_page_id' );

		$email_content_text = 'We noticed you\'ve been checking out some great items on our site and wanted to give you a quick recap to help you make your decision. Here\'s a reminder of what caught your eye:';

		$email_header_content = 'Still Thinking About Them? It\'s Time to Make Those Recently Viewed Items Yours!';

		prwfr_send_mails( $user_mails_rvp, 'rvp', $similar_products_pageid, $email_content_text, $email_header_content );
	}

}

/**
 * Generate email content with product grid and similar products link.
 *
 * @param string $content               The main content of the email.
 * @param int    $similar_products_section ID of the page with similar products.
 * @param array  $products              Array of product IDs.
 * @param string $email_logo            HTML for the email logo.
 * @param string $email_header          Header text for the email.
 * @return string                       HTML content for the email.
 */
function prwfr_get_email_content( $content, $similar_products_section, $products, $email_logo, $email_header ) {

	$email_body = '<!DOCTYPE html>
	<html>
	<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<style type="text/css">
	/* CLIENT-SPECIFIC STYLES */
	body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
	table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
	img { -ms-interpolation-mode: bicubic; }
	
	/* RESET STYLES */
	img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
	table { border-collapse: collapse !important; }
	body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }
	
	/* iOS BLUE LINKS */
	a[x-apple-data-detectors] {
		color: inherit !important;
		text-decoration: none !important;
		font-size: inherit !important;
		font-family: inherit !important;
		font-weight: inherit !important;
		line-height: inherit !important;
	}
	
	/* MEDIA QUERIES */
	@media screen and (max-width: 480px) {
		.mobile-hide {
			display: none !important;
		}
		.mobile-center {
			text-align: center !important;
			padding: 0 16px;
		}
	}
	
	/* ANDROID CENTER FIX */
	div[style*="margin: 16px 0;"] { margin: 0 !important; }
	</style>
	<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">
	
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">
			<!--[if (gte mso 9)|(IE)]>
			<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
			<tr>
			<td align="center" valign="top" width="600">
			<![endif]-->
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; margin-top: 50px; margin-bottom: 50px;">
				' . $email_logo . '
				<tr>
					<td align="center" height="100%" valign="top" width="100%" style="font-size:0; padding: 35px; background:' . get_option( 'prwfr_email_template_header_bg_color' ) . ';" bgcolor="' . get_option( 'prwfr_email_template_header_bg_color' ) . '">
						<!--[if (gte mso 9)|(IE)]>
						<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
						<tr>
						<td align="center" valign="top" width="600">
						<![endif]-->
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
		
							<tr>
								<td align="left" valign="top" style="font-size:0;">
									<!--[if (gte mso 9)|(IE)]>
									<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
									<tr>
									<td align="left" valign="top" width="300">
									<![endif]-->
									<div style="display:inline-block; vertical-align:top; width:100%;">
		
										<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;" class="mobile-center">
													' . $email_header . '
												</td>
											</tr>
										</table>
									</div>
									<!--[if (gte mso 9)|(IE)]>
									</td>
									</tr>
									</table>
									<![endif]-->
								</td>
							</tr>
		
					 
						</table>
						<!--[if (gte mso 9)|(IE)]>
						</td>
						</tr>
						</table>
						<![endif]-->
						</td>
					
				</tr>
				<tr>
					<td align="center" style="padding: 15px 20px; background-color: #ffffff;" bgcolor="#ffffff">
					<!--[if (gte mso 9)|(IE)]>
					<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
					<tr>
					<td align="center" valign="top" width="600">
					<![endif]-->
					<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
						<!-- <tr>
							<td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
								<h2 style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
									Thank You For Your Order!
								</h2>
							</td>
						</tr> -->
						<tr>
							<td align="left" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
								<p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777;">
								' . $content . '
								</p>
							</td>
						</tr>
					 
				   
					</table>
					<!--[if (gte mso 9)|(IE)]>
					</td>
					</tr>
					</table>
					<![endif]-->
					</td>
				</tr>
				<!-- prdoucts grid -->
				 <tr>
					<td align="center" height="100%" valign="top" width="100%" style="background-color: #ffffff;" bgcolor="#ffffff">
					<!--[if (gte mso 9)|(IE)]>
					<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
					<tr>
					<td align="center" valign="top" width="600">
					<![endif]-->
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
						
						' . prwfr_get_products_grid( $products ) . '
				  
					</table>
					<!--[if (gte mso 9)|(IE)]>
					</td>
					</tr>
					</table>
					<![endif]-->
					</td>
				</tr>
				<!-- similar products link -->
				' . $similar_products_section . '                        
			</table>
			<!--[if (gte mso 9)|(IE)]>
			</td>
			</tr>
			</table>
			<![endif]-->
			</td>
		</tr>
	</table>
		
	</body>
	</html>';

	return $email_body;
}

/**
 * Generate HTML grid for displaying products.
 *
 * @param array $products Array of product IDs.
 * @return string HTML string representing the product grid.
 */
function prwfr_get_products_grid( $products ) {
	$temp                = '';
	$learnmore_btn_color = get_option( 'prwfr_learn_more_btn_color' ) ? get_option( 'prwfr_learn_more_btn_color' ) : '#0473aa';
	foreach ( $products as $id ) {
		$product      = wc_get_product( intval( $id ) );
		$actual_price = $product->is_type( 'variable' ) ? $product->get_variation_regular_price() : $product->get_regular_price();
		$sale_price   = $product->is_type( 'variable' ) ? $product->get_variation_sale_price() : $product->get_sale_price();

		if ( strlen( get_the_title( $id ) ) > 75 ) {
			$product_title  = substr( get_the_title( $id ), 0, 75 );
			$product_title .= '...';
		} else {
			$product_title = get_the_title( $id );
		}
		$savings = $sale_price ? intval( $actual_price ) - intval( $sale_price ) : 0;
		// $image_id = $product->get_image_id();
		// $image_url = wp_get_attachment_url($image_id); // Get the image URL

		$image_id   = $product->get_image_id();
		$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

		// Use WooCommerce function to get the image URL of the specified size
		$image_url = $image_id ? wp_get_attachment_image_src( $image_id, $image_size )[0] : wc_placeholder_img_src( $image_size );

		// If you still need the image HTML
		$image_html = $image_id ? wp_get_attachment_image( $image_id, $image_size ) : wc_placeholder_img( $image_size );

		$temp .= '<tr>
		<td align="center" valign="top" style="font-size:0;border: 1px solid #f5f5f5; background: #fdfdfd;">
			<!--[if (gte mso 9)|(IE)]>
			<table align="center" border="0" cellspacing="0" cellpadding="0" width="600">
			<tr>
			<td align="left" valign="top" width="200">
			<![endif]-->
			<div style="display:inline-block; max-width:35%; vertical-align:middle; width:100%;">

				<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:300px;">
					<tr>
						<td align="center" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 0px;">
							<img src="' . $image_url . '" width="100%" height="" style="display: block; max-width: 100%; height: auto; border: 0px;"/>
						</td>
					</tr>
				</table>
			</div>
			<!--[if (gte mso 9)|(IE)]>
			</td>
			<td align="left" valign="top" width="400">
			<![endif]-->
			<div style="display:inline-block; max-width:60%; vertical-align:middle; width:100%;">
				<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
					<tr>
						<td align="left" valign="top" style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 0 0 0 15px;" >
							<p style="font-weight: 400;"><a href="' . get_permalink( $id ) . '" target="_blank" style="font-size:14px; text-decoration: underline;">' . $product_title . '</a></p>' . prwfr_get_product_prices( $actual_price, $sale_price, $savings ) . '<p><a href="' . get_permalink( $id ) . '" style="display: inline-block; font-size: 13px;box-sizing: border-box;  padding: 0 19px;line-height: 32px;background: ' . $learnmore_btn_color . '; color: #FFF; text-decoration: none;">Learn More</a></p>
						</td>
					</tr>
				</table>
			</div>
			<!--[if (gte mso 9)|(IE)]>
			</td>
			</tr>
			</table>
			<![endif]-->
		</td>
	</tr>';
	}

	return $temp;
}

/**
 * Generate HTML displaying product prices including regular price, sale price, and savings.
 *
 * @param float      $regular_price Regular price of the product.
 * @param float|null $sale_price Sale price of the product, or null if not on sale.
 * @param float|null $savings Amount saved on the sale price, or null if not on sale.
 * @return string HTML string displaying the product prices.
 */
function prwfr_get_product_prices( $regular_price, $sale_price, $savings ) {

	if ( $sale_price ) {
		$temp = '<p style="font-size: 14px; font-weight: 400; line-height: 18px;">
			Regular Price: <span style="color: red; font-size: 16px; font-weight: 400; text-decoration: line-through;">' . wc_price( $regular_price ) . '</span> <br/>
			Sale Price: <span style="color: red; font-size: 14px; font-weight: 600; text-decoration:none;">' . wc_price( $sale_price ) . '</span><br/>
			You Save: <span style="color: red; font-size: 14px; font-weight: 400; text-decoration:none;">' . wc_price( $savings ) . '</span><br/>
		</p>';
	} else {
		$temp = '<p style="font-size: 14px; font-weight: 400; line-height: 18px;">
			Regular Price: <span style="color: red; font-size: 16px; font-weight: 400;">' . wc_price( $regular_price ) . '</span> <br/>
		</p>';
	}

	return $temp;
}

/**
 * Custom comparison function used for sorting products by price.
 *
 * This function compares the prices of two products and determines their relative order for sorting.
 *
 * @param int $product_id_a The ID of the first product.
 * @param int $product_id_b The ID of the second product.
 * @return int Returns 0 if the prices are equal, 1 if the price of the first product is greater, and -1 if the price of the second product is greater.
 */
function prwfr_compare_product_prices( $product_id_a, $product_id_b ) {
	$product_a = wc_get_product( $product_id_a );
	$product_b = wc_get_product( $product_id_b );

	$price_a = $product_a ? $product_a->get_price() : 0;
	$price_b = $product_b ? $product_b->get_price() : 0;

	if ( $price_a == $price_b ) {
		return 0;
	}

	return ( $price_a < $price_b ) ? 1 : -1;
}

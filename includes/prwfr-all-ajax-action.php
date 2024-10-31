<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'wp_ajax_prwfr_ajax_slider', 'prwfr_display_ajax_slider' );
add_action( 'wp_ajax_nopriv_prwfr_ajax_slider', 'prwfr_display_ajax_slider' );

/**
 * Function for slider shortcode in front.
 */
function prwfr_display_ajax_slider() {

	if ( isset( $_POST['nonce'] ) ) {

		// Verify the nonce for security.
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'sft-product-recommendations-woocommerce' ) ) {
			wp_die( esc_html__( 'Permission Denied.', 'sft-product-recommendations-woocommerce' ) );
		}

		// IDs to add to cart (reorder page).
		if ( isset( $_POST['reorder_action_btn'] ) ) {
			$reorder_products = isset( $_POST['reorder_action_btn'] ) ? sanitize_text_field( wp_unslash( $_POST['reorder_action_btn'] ) ) : '';
			$product_ids      = array();
			$orders           = new WC_Order( $reorder_products );
			$ordered_items    = $orders->get_items();
			foreach ( $ordered_items as $product ) {
				if ( $product['variation_id'] ) {
					array_push( $product_ids, $product['variation_id'] );
				} else {
					array_push( $product_ids, $product['product_id'] );
				}
			}
			foreach ( $product_ids as $product_id ) {
				WC()->cart->add_to_cart( $product_id );

			}
			$cart_url = wc_get_cart_url();
			echo esc_url( $cart_url );
		}

		if ( isset( $_POST['remove_all_products_btn'] ) ) {
			global $wpdb;
			$user_id = get_current_user_id();

			$table_name = $wpdb->prefix . 'sft_user_product_interactions';

			// Execute the query
			$deleted = $wpdb->query( $wpdb->prepare( "DELETE FROM `$table_name` WHERE customer_id = %d", $user_id ) );
		}

		if ( isset( $_POST['slider_back_btn'] ) ) {

			$iterator              = 0;
			$starting_index        = isset( $_POST['starting_index'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['starting_index'] ) ) ) : '';
			$feature_name          = isset( $_POST['feature_name'] ) ? sanitize_text_field( wp_unslash( $_POST['feature_name'] ) ) : '';
			$products_array        = isset( $_POST['products_array'] ) ? sanitize_text_field( wp_unslash( $_POST['products_array'] ) ) : array();
			$product_ids           = explode( ',', $products_array );
			$slider_products_limit = isset( $_POST['slider_products_limit'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['slider_products_limit'] ) ) ) : '';
			$page_count            = isset( $_POST['page_count'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['page_count'] ) ) ) : '';
			$page_count_back       = isset( $_POST['page_count_back'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['page_count_back'] ) ) ) : '';
			$diff                  = $slider_products_limit * $page_count_back;

			if ( $page_count >= 1 ) {

				if ( $starting_index + 1 >= $slider_products_limit ) {
					$product_ids = array_slice( $product_ids, $starting_index - $diff, $slider_products_limit, true );

					$starting_index = $starting_index - $diff;
				} else {
					$product_ids    = array_slice( $product_ids, 0, $slider_products_limit, true );
					$starting_index = 0;
				}
			} else {
				$products_display_range = fmod( count( $product_ids ), $slider_products_limit );
				if ( ! $products_display_range ) {
					$products_display_range = $slider_products_limit;
				}

				$starting_index = count( $product_ids ) - $products_display_range;
				$product_ids    = array_slice( $product_ids, -( $products_display_range ) );

			}

			foreach ( $product_ids as $product_id ) {
				if ( intval( $product_id ) !== 0 && $iterator < $slider_products_limit ) {

					$product = wc_get_product( $product_id );
					if ( $product ) { // Check if product exists.
						?>
						<div class="prwfr-product-container prwfr-<?php echo esc_attr( $feature_name ); ?>-product-container" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-index="<?php echo esc_attr( $starting_index ); ?>" >

							<div class="prwfr-product-thumbnail">					
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php

									// Get the image ID and size
									$image_id   = $product->get_image_id();
									$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

									// Use WooCommerce function to get the image HTML
									$image_html = $image_id ? wp_get_attachment_image( $image_id, $image_size ) : wc_placeholder_img( $image_size );

									// Output the image in a container
									echo wp_kses_post( '<div class="prwfr-image-container">' . $image_html . '</div>' );
									?>
								</a>
							</div>
							<div class="prwfr-product-title">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo esc_html( $product->get_name() ); // Get translated title. ?>
								</a>
							</div>

						</div>
						<?php
						++$iterator;
					}
					++$starting_index;
				}
			}
		}

		if ( isset( $_POST['slider_next_btn'] ) ) {

			$iterator              = 0;
			$products_array_temp   = array();
			$starting_index        = isset( $_POST['starting_index'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['starting_index'] ) ) ) : '';
			$feature_name          = isset( $_POST['feature_name'] ) ? sanitize_text_field( wp_unslash( $_POST['feature_name'] ) ) : '';
			$products_array        = isset( $_POST['products_array'] ) ? sanitize_text_field( wp_unslash( $_POST['products_array'] ) ) : array();
			$product_ids           = explode( ',', $products_array );
			$slider_products_limit = isset( $_POST['slider_products_limit'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['slider_products_limit'] ) ) ) : '';
			$page_nos              = isset( $_POST['page_nos'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['page_nos'] ) ) ) : '';
			$page_count            = isset( $_POST['page_count'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['page_count'] ) ) ) : '';

			if ( $page_nos < $page_count ) {
				$starting_index = 0;
			} else {
				if ( $starting_index < ( count( $product_ids ) - 1 ) ) {
					$product_ids = array_slice( $product_ids, $starting_index + 1 );

					++$starting_index;

				} else {
					$mod = fmod( count( $product_ids ), $slider_products_limit );
					if ( ! intval( $mod ) ) {
						$products_array_temp = array_slice( $product_ids, ( count( $product_ids ) - $slider_products_limit ) );
						$starting_index      = count( $product_ids ) - $slider_products_limit;

					} else {
						$products_array_temp = array_slice( $product_ids, ( count( $product_ids ) - $mod ) );
						$starting_index      = count( $product_ids ) - $mod;
					}

					$product_ids = $products_array_temp;
				}
			}

			foreach ( $product_ids as $product_id ) {
				if ( intval( $product_id ) !== 0 && $iterator < $slider_products_limit ) {

					$product = wc_get_product( $product_id );
					if ( $product ) { // Check if product exists.
						?>
						<div class="prwfr-product-container prwfr-<?php echo esc_attr( $feature_name ); ?>-product-container" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-index="<?php echo esc_attr( $starting_index ); ?>" >

							<div class="prwfr-product-thumbnail">					
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php
									// Get the image ID and size
									$image_id   = $product->get_image_id();
									$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

									// Use WooCommerce function to get the image HTML
									$image_html = $image_id ? wp_get_attachment_image( $image_id, $image_size ) : wc_placeholder_img( $image_size );

									// Output the image in a container
									echo wp_kses_post( '<div class="prwfr-image-container">' . $image_html . '</div>' );
									?>
								</a>
							</div>
							<div class="prwfr-product-title">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo esc_html( $product->get_name() ); ?>
								</a>
							</div>

						</div>
						<?php
						++$iterator;
					}
					++$starting_index;
				}
			}
		}

		if ( isset( $_POST['slider_start_over_btn'] ) ) {

			$feature_name          = isset( $_POST['feature_name'] ) ? sanitize_text_field( wp_unslash( $_POST['feature_name'] ) ) : '';
			$products_array        = isset( $_POST['products_array'] ) ? sanitize_text_field( wp_unslash( $_POST['products_array'] ) ) : array();
			$product_ids           = explode( ',', $products_array );
			$slider_products_limit = isset( $_POST['slider_products_limit'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['slider_products_limit'] ) ) ) : '';

			$starting_index = 0;
			foreach ( $product_ids as $product_id ) {
				if ( intval( $product_id ) !== 0 && $iterator < $slider_products_limit ) {

					$product = wc_get_product( $product_id );
					if ( $product ) { // Check if product exists.
						?>
						<div class="prwfr-product-container prwfr-<?php echo esc_attr( $feature_name ); ?>-product-container" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-index="<?php echo esc_attr( $starting_index ); ?>" >

							<div class="prwfr-product-thumbnail">					
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php
									// Get the image ID and size.
									$image_id   = $product->get_image_id();
									$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

									// Use WooCommerce function to get the image HTML.
									$image_html = $image_id ? wp_get_attachment_image( $image_id, $image_size ) : wc_placeholder_img( $image_size );

									// Output the image in a container.
									echo wp_kses_post( '<div class="prwfr-image-container">' . $image_html . '</div>' );
									?>
								</a>
							</div>
							<div class="prwfr-product-title">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo esc_html( $product->get_name() ); ?>
								</a>
							</div>

						</div>
						<?php
						++$iterator;
					}
					++$starting_index;
				}
			}
		}

		// Product displayed in shortcode on page reload.
		if ( isset( $_POST['page_reload'] ) ) {
			$feature_name          = isset( $_POST['feature_name'] ) ? sanitize_text_field( wp_unslash( $_POST['feature_name'] ) ) : '';
			$products_array        = isset( $_POST['products_array'] ) ? sanitize_text_field( wp_unslash( $_POST['products_array'] ) ) : array();
			$slider_products_limit = isset( $_POST['slider_products_limit'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['slider_products_limit'] ) ) ) : '';
			$product_ids           = explode( ',', $products_array );

			foreach ( $product_ids as $product_id ) {
				if ( intval( $product_id ) !== 0 && $iterator < $slider_products_limit ) {

					$product = wc_get_product( $product_id );
					if ( $product ) { // Check if product exists.
						?>
						<div class="prwfr-product-container prwfr-<?php echo esc_attr( $feature_name ); ?>-product-container" data-product_id="<?php echo esc_attr( $product_id ); ?>" data-index="<?php echo esc_attr( $starting_index ); ?>" >

							<div class="prwfr-product-thumbnail">					
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php
									// Get the image ID and size.
									$image_id   = $product->get_image_id();
									$image_size = apply_filters( 'single_product_archive_thumbnail_size', 'woocommerce_thumbnail' );

									// Use WooCommerce function to get the image HTML.
									$image_html = $image_id ? wp_get_attachment_image( $image_id, $image_size ) : wc_placeholder_img( $image_size );

									// Output the image in a container.
									echo wp_kses_post( '<div class="prwfr-image-container">' . $image_html . '</div>' );
									?>
								</a>
							</div>
							<div class="prwfr-product-title">
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
									<?php echo esc_html( $product->get_name() ); // Get translated title. ?>
								</a>
							</div>

						</div>
						<?php
						++$iterator;
					}
					++$starting_index;
				}
			}
		}

		// browsing history.
		$user_id  = get_current_user_id();
		$meta_key = 'browsing_history_on_off_' . $user_id;

		if ( isset( $_POST['browsing_history'] ) ) {

			if ( intval( sanitize_text_field( wp_unslash( $_POST['browsing_history'] ) ) ) ) {
				update_user_meta( $user_id, $meta_key, '1' );
			} else {
				update_user_meta( $user_id, $meta_key, '0' );
			}
		}
	}

	die();
}

add_action( 'wp_ajax_prwfr_gdpr_permission', 'prwfr_gdpr_permission' );
add_action( 'wp_ajax_nopriv_prwfr_gdpr_permission', 'prwfr_gdpr_permission' );

/**
 * Undocumented function.
 */
function prwfr_gdpr_permission() {

	if ( isset( $_POST['prwfr_nonce'] ) ) {

		// Verify the nonce for security.
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['prwfr_nonce'] ) ), 'sft-product-recommendations-woocommerce' ) ) {
			wp_die( esc_html__( 'Permission Denied.', 'sft-product-recommendations-woocommerce' ) );
		}

		if ( isset( $_POST['gdpr_no_thanks'] ) ) {
			$email_address = isset( $_POST['email_address'] ) ? sanitize_text_field( wp_unslash( $_POST['email_address'] ) ) : '';

			$no_thanks_email = get_option( 'email_gdpr_no_thanks' ) ? json_decode( get_option( 'email_gdpr_no_thanks' ), true ) : '';
			if ( $no_thanks_email == '' ) {
				$user_emails = wp_json_encode( array( $email_address ) );
				update_option( 'email_gdpr_no_thanks', $user_emails );
			} else {
				$user_emails = array_merge( $no_thanks_email, (array) $email_address );
				update_option( 'email_gdpr_no_thanks', wp_json_encode( array_unique( $user_emails ) ) );
			}
		}
	}

}

// ============================== api request ===========================

add_action( 'wp_ajax_prwfr_ai_help', 'prwfr_ai_help' );
add_action( 'wp_ajax_nopriv_prwfr_ai_help', 'prwfr_ai_help' );

/**
 * Undocumented function
 */
function prwfr_ai_help() {

	if ( isset( $_POST['create_request'] ) ) {

		update_option( 'prwfr_ai_request_created', 'created' );
		update_option( 'prwfr_api_request_created_status', 'created' );
		update_option( 'prwfr_prompt_request_button_hit', 1 );
		update_option( 'prwfr_display_ai_request_notice', 'yes' );
		update_option( 'prwfr_current_ai_request', date( 'Y-m-d H:i:s' ) );

		// Fetch posts that have the specific meta key
		// $args = array(
		// 'post_type'   => 'any', // Adjust to target specific post types
		// 'post_status' => 'any',
		// 'numberposts' => -1,  // Retrieve all posts
		// 'meta_key'    => 'prwfr_ai_generated_product_recommendations', // The meta key you want to delete
		// );

		// $posts_with_meta = get_posts( $args );

		// // Loop through the posts and delete the meta key
		// foreach ( $posts_with_meta as $post ) {
		// delete_post_meta( $post->ID, 'prwfr_ai_generated_product_recommendations' );
		// }

		if ( as_has_scheduled_action( 'prwfr_api_request_prompt' ) ) {
			as_unschedule_action( 'prwfr_api_request_prompt' );
		}
	}

	if ( isset( $_POST['prwfr_product_selection'] ) ) {

		$prwfr_product_selection = $_POST['prwfr_product_selection'];
		update_option( 'prwfr_product_selection', $_POST['prwfr_product_selection'] );

	}

	if ( isset( $_POST['prwfr_category_selection'] ) ) {

		$category_ids = $_POST['prwfr_category_selection'];
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

		$query   = new WP_Query( $args );
		$options = '';

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$options .= '<option value="' . get_the_ID() . '">' . get_the_title() . '</option>';
			}
			wp_reset_postdata();
		}

		echo $options;
	}

	if ( isset( $_POST['save_settings'] ) ) {

		update_option( 'prwfr_ai_prompt_type', 'default' );

		if ( isset( $_POST['prwfr_activate_ai_recommendations'] ) ) {
			if ( $_POST['prwfr_activate_ai_recommendations'] == '1' ) {
				update_option( 'prwfr_activate_ai_recommendations', $_POST['prwfr_activate_ai_recommendations'] );
			} else {
				update_option( 'prwfr_activate_ai_recommendations', '' );
			}
		}

		if ( isset( $_POST['prwfr_about_store'] ) ) {
			update_option( 'prwfr_about_store', $_POST['prwfr_about_store'] );
		} else {
			update_option( 'prwfr_about_store', '' );
		}

		update_option( 'prwfr_ai_request_prompt', 'Here is selected products data: {selected_products} and here is all products data {all_products} and here is frequently purchased products data {fbt_data}  and suggest 5 recommendations for each product from this set.' );

		if ( isset( $_POST['prwfr_product_selection'] ) ) {
			update_option( 'prwfr_product_selection', $_POST['prwfr_product_selection'] );
		} else {
			update_option( 'prwfr_product_selection', '' );
		}

		update_option( 'prwfr_category_selection', '' );

		update_option( 'prwfr_recurrence_period_ai', 'one_time' );

		if ( isset( $_POST['prwfr_all_products'] ) ) {
			update_option( 'prwfr_all_products', $_POST['prwfr_all_products'] );
		} else {
			update_option( 'prwfr_all_products', '' );
		}

		if ( isset( $_POST['prwfr_multiple_products_check'] ) ) {
			update_option( 'prwfr_multiple_products_check', $_POST['prwfr_multiple_products_check'] );
		} else {
			update_option( 'prwfr_multiple_products_check', '' );
		}

		update_option( 'prwfr_fbt_data', '' );
		update_option( 'prwfr_products_url', '' );
		update_option( 'prwfr_products_desc_long', '' );
		update_option( 'prwfr_products_categories', '' );

		if ( isset( $_POST['prwfr_products_name'] ) ) {
			update_option( 'prwfr_products_name', $_POST['prwfr_products_name'] );
		} else {
			update_option( 'prwfr_products_name', '' );
		}

		if ( isset( $_POST['prwfr_products_desc'] ) ) {
			update_option( 'prwfr_products_desc', $_POST['prwfr_products_desc'] );
		} else {
			update_option( 'prwfr_products_desc', '' );
		}

		update_option( 'prwfr_products_price', '' );
		update_option( 'prwfr_ai_recommendations_everyweek', '' );
		update_option( 'prwfr_ai_recommendations_weekly_time', '' );
		update_option( 'prwfr_ai_admin_email', '' );
	}

	if ( isset( $_POST['reset_settings'] ) ) {
		update_option( 'prwfr_weekly_save_recommendations', '' );
		update_option( 'prwfr_recurrence_period_ai', 'one_time' );
		update_option( 'prwfr_all_products', 'on' );
		update_option( 'prwfr_multiple_products_check', 'on' );
		update_option( 'prwfr_fbt_data', 'on' );
		update_option( 'prwfr_products_name', 'on' );
		update_option( 'prwfr_products_desc', 'on' );
		update_option( 'prwfr_multiple_categories_check', '' );
		update_option( 'prwfr_products_price', '' );
		update_option( 'prwfr_products_url', '' );
		update_option( 'prwfr_products_desc_long', '' );
		update_option( 'prwfr_products_categories', '' );
	}

	if ( isset( $_POST['prwfr_save_recommedations'] ) ) {

		$args = array(
			'post_type'   => 'any', // Adjust to target specific post types
			'post_status' => 'any',
			'numberposts' => -1,  // Retrieve all posts
			'meta_key'    => 'prwfr_ai_generated_product_recommendations', // The meta key you want to delete
		);

		$posts_with_meta = get_posts( $args );

		// Loop through the posts and delete the meta key
		foreach ( $posts_with_meta as $post ) {
			delete_post_meta( $post->ID, 'prwfr_ai_generated_product_recommendations' );
		}

		$save_recommendations = $_POST['prwfr_save_recommedations'];
		// print_r( $save_recommendations );

		$product_data         = get_option( 'prwfr_ai_request_logs' );
		$final_data           = $product_data['openai_response']['choices'][0]['message']['content'];
		$ai_recommendations   = str_replace( 'json', '', $final_data );
		$ai_recommendations   = str_replace( '```', '', $ai_recommendations );
		$recommendations_data = json_decode( $ai_recommendations, true );

		if ( ! empty( $recommendations_data ) ) {
			foreach ( $recommendations_data as $key => $item ) {
				if ( isset( $save_recommendations[ $key ] ) ) {
					update_post_meta( $key, 'prwfr_ai_generated_product_recommendations', $save_recommendations[ $key ] );
				} else {
					// update_post_meta( $key, 'prwfr_ai_generated_product_recommendations', array() );
					delete_post_meta( $key, 'prwfr_ai_generated_product_recommendations' );
				}
			}
		}
	}

	if ( isset( $_POST['prompt_token'] ) ) {

		$build_prompt = prwfr_update_tokens();

		echo json_encode( $build_prompt['prompt_token'] );
	}

	wp_die();
}

add_action( 'wp_ajax_prwfr_api_key_validation', 'prwfr_api_key_validation' );
add_action( 'wp_ajax_nopriv_prwfr_api_key_validation', 'prwfr_api_key_validation' );

/**
 * Send the api response to check usage.
 */
function prwfr_api_key_validation() {

	// Nonce verification.
	$secure_nonce      = wp_create_nonce( 'sft-related-products-woocommerce' );
	$is_nonce_verified = wp_verify_nonce( $secure_nonce, 'sft-related-products-woocommerce' );

	if ( ! $is_nonce_verified ) {
		wp_die( esc_html__( 'Nonce Not verified', 'sft-related-products-woocommerce' ) );
	}

	// Delete trasient on validation is done.
	delete_transient( 'sft_set_model_names' );

	// Get entered key data.
	$api_key_data = isset( $_POST['key_data'] ) ? sanitize_text_field( $_POST['key_data'] ) : 0;

	// Call the request and save data.
	$response_data = prwfr_api_server_callback_validation( $api_key_data );

	// Get the api status value.
	$api_status = $response_data['status'];

	// If Status is on.
	if ( $api_status ) {

		// Send status data.
		echo wp_json_encode(
			array(
				'usage'  => get_option( 'prwfr_api_usage_status' ),
				'status' => $api_status,
			)
		);
	} else {

		// Send status data.
		echo wp_json_encode(
			array(
				'usage'  => get_option( 'prwfr_api_usage_status' ),
				'status' => 0,
			)
		);
	}

	wp_die();
}

/**
 * Account key info Validation.
 *
 * @param mixed $request .
 * @return mixed
 */
function prwfr_api_server_callback_validation( $request ) {

	// Get Api key data.
	$api_key_data = isset( $request ) ? $request : 0;

	// Api request url.
	$model_api_url = 'https://api.openai.com/v1/models';

	// Set up the arguments for the request, including the headers.
	$request_args = array(
		'method'  => 'GET',
		'headers' => array(
			'Authorization' => 'Bearer ' . $api_key_data,
		),
		'timeout' => 50,
	);

	// Make the GET request to the OpenAI.
	$response = wp_remote_get( $model_api_url, $request_args );

	// Status code 200.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 200 ) {

		// Decode the response from JSON.
		$response_data = json_decode( wp_remote_retrieve_body( $response ), true );

		// Access the token usage information.
		$total_tokens_used = $response_data['data']['total_tokens'] ? $response_data['data']['total_tokens'] : '';

		// Prepare the final response with the OpenAI API response.
		$status_response = array(
			'status'           => 1,
			'used_token'       => $total_tokens_used,
			'data'             => $response_data,
			'openai_sresponse' => $response,
		);

		// Update the model name and usage data.
		update_option( 'prwfr_api_model_name', 'gpt-4o' );
		update_option( 'prwfr_api_valid_key_status', 1 );
		update_option( 'prwfr_api_usage_status', 'Your API Key is Valid !' );

		return $status_response;
	}

	// Check for errors in the response.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 500 ) {
		update_option( 'prwfr_api_usage_status', 'Request to OpenAI API failed.' );
		return new WP_Error( 'request_failed', 'Request to OpenAI API failed.' );
	}

	// Check for errors in the response bad request.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 400 ) {

		// Prepare the final response with the OpenAI API response.
		$final_response = array(
			'status'          => 0,
			'openai_response' => 'Your Key Bad Request!',
		);

		update_option( 'prwfr_api_valid_key_status', 0 );
		update_option( 'prwfr_api_usage_status', 'Your Key Bad Request !' );

		return $final_response;
	}

	// Check for errors in the response on quota exceed.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 429 ) {

		// Prepare the final response with the OpenAI API response.
		$final_response = array(
			'status'          => 0,
			'openai_response' => 'Insufficient Quota',
		);

		update_option( 'prwfr_api_valid_key_status', 0 );
		update_option( 'prwfr_api_usage_status', 'Insufficient Quota' );

		return $final_response;
	}

	// Check for errors in the response on incorrect API Key.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 401 ) {

		// Prepare the final response with the OpenAI API response.
		$final_response = array(
			'status'           => 0,
			'openai_response'  => 'The requesting API key is not correct.',
			'openai_sresponse' => $response,
		);

		update_option( 'prwfr_api_valid_key_status', 0 );
		update_option( 'prwfr_api_usage_status', 'The requesting API key is not correct.' );

		return $final_response;
	}

	// Check for errors in the response un-supported country.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 403 ) {

		// Prepare the final response with the OpenAI API response.
		$final_response = array(
			'status'          => 0,
			'openai_response' => 'You are accessing the API from an unsupported country, region, or territory.',
		);

		update_option( 'prwfr_api_valid_key_status', 0 );
		update_option( 'prwfr_api_usage_status', 'You are accessing the API from an unsupported country, region, or territory.' );

		return $final_response;
	}

	// Check for errors if the system is overloaded.
	if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) === 503 ) {

		// Prepare the final response with the OpenAI API response.
		$final_response = array(
			'status'          => 0,
			'openai_response' => 'System Overloaded',
		);

		update_option( 'prwfr_api_valid_key_status', 0 );
		update_option( 'prwfr_api_usage_status', 'System Overloaded' );

		return $final_response;
	}
}

/**
 * Fetch valid model names.
 *
 * @param mixed $model_names .
 * @param mixed $api_key_data .
 * @return mixed
 */
function prwfr_get_valid_model_names( $model_names, $api_key_data ) {

	$valid_model = array();

	// Iterate all the model names.
	foreach ( $model_names as $model ) {

		// Get the model name.
		$model_name = $model['id'];

		// The API endpoint for the OpenAI completions API.
		$request_model_url = 'https://api.openai.com/v1/chat/completions';

		// Request body array.
		$request_body = array(
			'model'             => $model_name,
			'messages'          => array(
				array(
					'role'    => 'user',
					'content' => 'how are you ?',
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
				'Authorization' => 'Bearer ' . $api_key_data,
			),
			'body'    => wp_json_encode( $request_body ),
			'timeout' => 100,
		);

		// Make the POST request to the OpenAI.
		$response_data = wp_remote_post( $request_model_url, $args );

		// Check the response code.
		if ( ! in_array( $response_data['response']['code'], array( '404', '403', '400', '429', '401', '403', '503' ) ) ) {
			array_push( $valid_model, $model['id'] );
		}
	}

	return $valid_model;
}

/**
 * Save date and time and value on option update.
 *
 * @param mixed $date .
 * @param mixed $time .
 * @param mixed $count .
 * @param mixed $value .
 */
function prwfr_save_data_with_date_and_time( $date, $time, $count = 0, $value ) {

	$option_name = 'prwfr_ai_request_logs';

	$existing_data = get_option( $option_name );

	// Check if the date key exists.
	if ( ! isset( $existing_data[ $date ] ) ) {
		$existing_data[ $date ] = array();
	}

	// Update the data for the specified date and time.
	$existing_data[ $date ][ $time ] = $value;

	// Save the updated data back to the option.
	update_option( $option_name, $existing_data );
}

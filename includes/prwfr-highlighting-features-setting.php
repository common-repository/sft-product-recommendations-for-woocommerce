<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Section for Best Selling Products.
 */
function prwfr_best_seller_section() {
}

/**
 * Setting Field to display default, categories, tags and individual pick radio button for Best Selling Products Section
 */
function prwfr_best_seller_product_display_option_selection() {
	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-radio-btn-column-container">
			<div>
				<input type="radio" class = "prwfr-best-seller-product-display-select-radio" id="default_bs" name="prwfr_best_selling_display_mode" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_best_selling_display_mode' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-best-seller-product-display-select-radio" id="categories" name="prwfr_best_selling_display_mode" value="categories"<?php echo checked( 'categories', esc_attr( get_option( 'prwfr_best_selling_display_mode' ) ), false ); ?>>
				<label for="categories"><?php esc_html_e( 'Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-best-seller-product-display-select-radio" id="tags" name="prwfr_best_selling_display_mode" value="tags"<?php echo checked( 'tags', esc_attr( get_option( 'prwfr_best_selling_display_mode' ) ), false ); ?>>
				<label for="tags"><?php esc_html_e( 'Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-best-seller-product-display-select-radio" id="individual" name="prwfr_best_selling_display_mode" value="individual"<?php echo checked( 'individual', esc_attr( get_option( 'prwfr_best_selling_display_mode' ) ), false ); ?>>
				<label for="individual"><?php esc_html_e( 'Individual pick', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting enables you to refine your product display with precision, allowing you to filter items based on categories, tags, or handpick specific products for a tailored showcase.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to choose multiple Categories of Best Selling Products Section.
 */
function prwfr_best_seller_product_display_category_selection_field() {

	$categories = get_terms( 'product_cat' );

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-best-selling-cat-inc-parent prwfr-select2-outer-container">
			<?php

			if ( ! $categories ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-best-selling-cat-inc-selection" name="prwfr_best_selling_category_selection[]" multiple="multiple">
				</select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple categories to include products of that categories', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to choose multiple tags of Best Selling Products Section.
 */
function prwfr_best_seller_product_display_tags_selection_field() {

	$terms = get_terms( 'product_tag' );
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-best-selling-tag-inc-parent prwfr-select2-outer-container">
			<?php

			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-best-selling-tag-inc-selection" name="prwfr_best_selling_tag_selection[]" multiple="multiple">

				</select>
				<?php
			}

			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple tags to include products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Field to choose multiple products of Best Selling Products Section
 */
function prwfr_best_seller_product_display_individual_selection_field() {

	$all_product_ids = array();

	$products = wc_get_products(
		array(
			'limit'  => -1, // All products.
			'status' => 'publish', // Only published products.
		)
	);

	foreach ( $products as $product ) {
		array_push( $all_product_ids, $product->id );
	}

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-best-selling-single-include prwfr-select2-outer-container">
			<?php

			if ( empty( $all_product_ids ) ) {
				echo esc_html__( 'There are no Products to show. Please add some products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-best-selling-individual-include" name="prwfr_best_selling_individual_selection[]" multiple="multiple"></select>
				<?php
			}

			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple products which will be displayed to the users.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to set no of products per row in destop, tab and mobile mode.
 */
function prwfr_best_seller_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_best_selling_desktop_limit' );

	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php

	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_best_selling_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_best_selling_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_best_selling_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_best_selling_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_best_selling_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_best_selling_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_best_selling_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_best_selling_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_best_selling_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_best_selling_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_best_selling_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "Best Selling Products" shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Field to choose default page or another page for see more link redirection
 */
function prwfr_best_seller_page_redirect_radio_field() {

	?>

	<div style="display: flex; align-items: center;">

		<div class="prwfr-radio-btn-column-container">
			<div>
				<input type="radio" class = "prwfr-best-selling-redirect-page-radio" id="default_best_seller" name="prwfr_best_selling_redirect_page_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_best_selling_redirect_page_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-best-selling-redirect-page-radio" id="new" name="prwfr_best_selling_redirect_page_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_best_selling_redirect_page_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_best_selling_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>

	<div class = "best-seller-shortcode-text" style=" margin-top: 10px;">        
		<?php esc_html_e( 'Use shortcode [prwfr_best_selling_back]', 'sft-product-recommendations-woocommerce' ); ?>  
		<button class="best-selling-clipboard-button clipboard">&#128203;</button>  
	</div>    
	<?php
}

/**
 * Field to set new page where see more will direct after selection.
 */
function prwfr_best_seller_url_field() {

	// Retrieve all the page.
	$args = array(
		'posts_per_page' => -1,
		'post_type'      => 'page',
	);

	$query = new WP_Query( $args );
	?>
	<div style="display: flex; align-items: center;">

		<div>

			<select class = "prwfr-best-selling-see-more-option" name="prwfr_best_selling_see_more_option">
			</select>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field for admin to set title for widget instead of Best Selling Products
 */
function prwfr_best_seller_label_field() {

	?>
	<div style="display: flex; align-items: center;">

		<input type="text" id="best_selling_label" class="prwfr-title" name="prwfr_best_selling_title" value="<?php echo esc_attr( get_option( 'prwfr_best_selling_title' ) ); ?>" placeholder="<?php esc_html_e( 'Best Selling Products', 'sft-product-recommendations-woocommerce' ); ?> " style="margin: 5px 0px;">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "Best Selling Products" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
   
	<?php
}

/**
 * Field to show/hide Best Selling Products to non logged in users
 */
function prwfr_best_seller_cookie_field() {

	?>
	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" name="prwfr_best_selling_cookie_display" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_best_selling_cookie_display' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "Best Selling Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Newly Arrived Products Section
 */
function prwfr_new_arrivals_section() {
	?>
	<div style = "margin-top: 10px">        
		<?php esc_html_e( 'Use shortcode [prwfr_new_arrivals_front] to display "New Arrivals"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-new-arrivals-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * Setting Field to display default, categories, tags and individual pick radio button for Newly Arrived Products Section
 */
function prwfr_new_arrival_product_display_option_selection() {

	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-radio-btn-column-container">

			<div>
				<input type="radio" class = "prwfr-new-arrivals-product-display-radio" id="default_na" name="prwfr_new_arrivals_display_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_new_arrivals_display_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-new-arrivals-product-display-radio" id="categories" name="prwfr_new_arrivals_display_radio" value="categories"<?php echo checked( 'categories', esc_attr( get_option( 'prwfr_new_arrivals_display_radio' ) ), false ); ?>>
				<label for="categories"><?php esc_html_e( 'Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-new-arrivals-product-display-radio" id="tags" name="prwfr_new_arrivals_display_radio" value="tags"<?php echo checked( 'tags', esc_attr( get_option( 'prwfr_new_arrivals_display_radio' ) ), false ); ?>>
				<label for="tags"><?php esc_html_e( 'Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-new-arrivals-product-display-radio" id="individual" name="prwfr_new_arrivals_display_radio" value="individual"<?php echo checked( 'individual', esc_attr( get_option( 'prwfr_new_arrivals_display_radio' ) ), false ); ?>>
				<label for="individual"><?php esc_html_e( 'Individual pick', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting enables you to refine your product display with precision, allowing you to filter items based on categories, tags, or handpick specific products for a tailored showcase.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to choose multiple Categories
 */
function prwfr_new_arrival_product_display_category_selection_field() {

	$categories = get_terms( 'product_cat' );

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-new-arrivals-cat-inc-parent prwfr-select2-outer-container">

			<?php
			if ( ! $categories ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-new-arrivals-cat-inc-selection" name="prwfr_new_arrivals_category_selection[]" multiple="multiple"></select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple categories to exclude products of that categories', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Field to choose multiple Tags
 */
function prwfr_new_arrival_product_display_tags_selection_field() {
	$values = get_option( 'prwfr_new_arrivals_tag_selection' );
	$terms  = get_terms( 'product_tag' );
	$data   = ( $values ) ? $values : array();
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-new-arrivals-tag-inc-parent prwfr-select2-outer-container">

			<?php
			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-new-arrivals-tag-inc-selection" name="prwfr_new_arrivals_tag_selection[]" multiple="multiple">
					<?php
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $data, true ) ) {
							?>
							<option selected="selected" value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple tags to exclude products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Field to choose multiple products
 */
function prwfr_new_arrival_product_display_individual_selection_field() {

	$all_product_ids = array();

	$products = wc_get_products(
		array(
			'limit'  => -1, // All products.
			'status' => 'publish', // Only published products.
		)
	);
	foreach ( $products as $product ) {
		array_push( $all_product_ids, $product->id );
	}
	?>

	<div style="display: flex; align-items: center;">

		<div class = "prwfr-new-arrivals-single-inc-parent prwfr-select2-outer-container">
			<?php
			if ( empty( $all_product_ids ) ) {
				echo esc_html__( 'There are no Products to show. Please add some products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "new_arrivals_individual_include" name="prwfr_new_arrivals_individual_selection[]" multiple="multiple">

				</select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple tags to exclude products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php

}

/**
 * Field to set no of products per row in destop, tab and mobile mode.
 */
function prwfr_new_arrivals_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_new_arrivals_desktop_limit' );
	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php
	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_new_arrivals_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_new_arrivals_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_new_arrivals_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_new_arrivals_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_new_arrivals_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_new_arrivals_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_new_arrivals_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_mobile = get_option( 'prwfr_new_arrivals_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_new_arrivals_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_new_arrivals_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_new_arrivals_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "New Arrivals" shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Field to choose default page or another page for see more link redirection
 */
function prwfr_new_arrivals_page_redirect_radio_field() {

	$value = get_option( 'prwfr_new_arrivals_page_redirect_radio' );
	?>

	<div style="display: flex; align-items: center;">

		<div class="prwfr-radio-btn-column-container">
			<div>
				<input type="radio" class = "prwfr-new-arrivals-redirect-page-radio" id="default_new_arrivals" name="prwfr_new_arrivals_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_new_arrivals_page_redirect_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-new-arrivals-redirect-page-radio" id="new" name="prwfr_new_arrivals_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_new_arrivals_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_new_arrivals_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>

	<div class = "prwfr-new-arrivals-shortcode-text" style=" margin-top: 10px;">        
		<?php esc_html_e( 'Use shortcode [prwfr_new_arrivals_back]', 'sft-product-recommendations-woocommerce' ); ?>  
		<button class="prwfr-new-arrivals-clipboard-button clipboard">&#128203;</button>  
	</div>    
	<?php
}

/**
 * Field to set new page where see more will direct after selection.
 */
function prwfr_new_arrivals_url_field() {

	?>

	<div style="display: flex; align-items: center;">

		<div>
			<select class = "prwfr-new-arrivals-see-more-option" name="prwfr_new_arrival_see_more_option"></select>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field for admin to set title for widget instead of Best Selling Products.
 */
function prwfr_new_arrivals_label_field() {
	?>
	<div style="display: flex; align-items: center;">

		<input type="text" id="new_arrivalsing_label" class="prwfr-title" name="prwfr_new_arrivals_title" value="<?php echo esc_attr( get_option( 'prwfr_new_arrivals_title' ) ); ?>" placeholder="<?php esc_html_e( 'New Arrivals', 'sft-product-recommendations-woocommerce' ); ?> " style="margin: 5px 0px;">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "New Arrivals" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
   
	<?php
}

/**
 * Field to show/hide Best Selling Products to non logged in users.
 */
function prwfr_new_arrivals_cookie_field() {

	$values = get_option( 'prwfr_new_arrivals_cookie_display' );
	?>

	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" name="prwfr_new_arrivals_cookie_display" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_new_arrivals_cookie_display' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "Newly arrived Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Section for Featured Products
 */
function prwfr_featured_section() {
	?>
	<div style = "margin-top: 10px">        
		<?php esc_html_e( 'Use shortcode [prwfr_featured_products_front] to display "Featured Products"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-featured-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * Setting Field to display default, categories, tags and individual pick radio button for Featured Products Section
 */
function prwfr_featured_product_display_option_selection() {
	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-radio-btn-column-container">

			<div>
				<input type="radio" class = "prwfr-featured-display-radio" id="default_fp" name="prwfr_featured_display_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_featured_display_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-featured-display-radio" id="categories" name="prwfr_featured_display_radio" value="categories"<?php echo checked( 'categories', esc_attr( get_option( 'prwfr_featured_display_radio' ) ), false ); ?>>
				<label for="categories"><?php esc_html_e( 'Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-featured-display-radio" id="tags" name="prwfr_featured_display_radio" value="tags"<?php echo checked( 'tags', esc_attr( get_option( 'prwfr_featured_display_radio' ) ), false ); ?>>
				<label for="tags"><?php esc_html_e( 'Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-featured-display-radio" id="individual" name="prwfr_featured_display_radio" value="individual"<?php echo checked( 'individual', esc_attr( get_option( 'prwfr_featured_display_radio' ) ), false ); ?>>
				<label for="individual"><?php esc_html_e( 'Individual pick', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting enables you to refine your product display with precision, allowing you to filter items based on categories, tags, or handpick specific products for a tailored showcase.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to select multiple Categories.
 */
function prwfr_featured_product_display_category_selection_field() {

	$categories = get_terms( 'product_cat' );

	?>
	<div style="display: flex; align-items: center;">
		<div class = "prwfr-featured-cat-inc-parent prwfr-select2-outer-container">
			<?php

			if ( ! $categories ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-featured-cat-inc-selection" name="prwfr_featured_category_selection[]" multiple="multiple"></select>
				<?php
			}
			?>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple categories to exclude products of that categories', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Field to select multiple Tags.
 */
function prwfr_featured_product_display_tags_selection_field() {

	$values = get_option( 'prwfr_featured_tag_name' );
	$terms  = get_terms( 'product_tag' );
	$data   = ( $values ) ? $values : array();

	?>
	<div style="display: flex; align-items: center;">
		<div class = "prwfr-featured-tag-inc-parent prwfr-select2-outer-container">

			<?php
			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-featured-tag-inc-selection" name="prwfr_featured_tag_name[]" multiple="multiple">
					<?php
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $data, true ) ) {
							?>
							<option selected="selected" value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple tags to exclude products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Field to select multiple products.
 */
function prwfr_featured_product_display_individual_selection_field() {

	$all_product_ids = array();

	$products = wc_get_products(
		array(
			'limit'  => -1, // All products.
			'status' => 'publish', // Only published products.
		)
	);

	foreach ( $products as $product ) {
		array_push( $all_product_ids, $product->id );
	}

	?>
	<div style="display: flex; align-items: center;">
		<div class = "prwfr-featured-single-inc-parent prwfr-select2-outer-container">
			<?php

			if ( empty( $all_product_ids ) ) {
				echo esc_html__( 'There are no Products to show. Please add some products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-featured-single-inc-selection" name="prwfr_featured_individual_selection[]" multiple="multiple">
				</select>
				<?php
			}

			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple tags to exclude products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php

}

/**
 * Field to set no of products per row in destop, tab and mobile mode.
 */
function prwfr_featured_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_featured_desktop_limit' );
	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php

	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_featured_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_featured_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_featured_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_featured_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_featured_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_featured_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_featured_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_featured_mobile_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_featured_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_featured_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_featured_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "Featured Products" shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Field to choose default page or another page for see more link redirection
 */
function prwfr_featured_page_redirect_radio_field() {

	?>

	<div style="display: flex; align-items: center;">

		<div class="prwfr-radio-btn-column-container">

			<div>
				<input type="radio" class = "prwfr-featured-page-redirect-radio" id="default_featured" name="prwfr_featured_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_featured_page_redirect_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-featured-page-redirect-radio" id="new" name="prwfr_featured_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_featured_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_featured_products_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>

	<div class = "featured-shortcode-text" style=" margin-top: 10px;">        
		<?php esc_html_e( 'Use shortcode [prwfr_featured_products_back]', 'sft-product-recommendations-woocommerce' ); ?>  
		<button class="featured-clipboard-button clipboard">&#128203;</button>  
	</div>    
	<?php
}

/**
 * Field to set new page where see more will direct after selection
 */
function prwfr_featured_url_field() {

	?>
	<div style="display: flex; align-items: center;">
		<div>
			<select class = "prwfr-featured-see-more-option" name="prwfr_featured_see_more_option"></select>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field for admin to set title for widget instead of Best Selling Products
 */
function prwfr_featured_label_field() {
	?>
	<div style="display: flex; align-items: center;">

		<input type="text" id="featureding_label" class="prwfr-title" name="prwfr_featured_title" value="<?php echo esc_attr( get_option( 'prwfr_featured_title' ) ); ?>" placeholder="<?php esc_html_e( 'Featured Products', 'sft-product-recommendations-woocommerce' ); ?> " style="margin: 5px 0px;">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "Featured Products" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to show/hide Best Selling Products to non logged in users
 */
function prwfr_featured_cookie_field() {

	?>
	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" name="prwfr_featured_cookie_display" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_featured_cookie_display' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "Featured Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to hide/show out of stock products.
 */
function prwfr_best_seller_outofstock_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" class="prwfr-rvps-stock-status-switch" name="prwfr_best_selling_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_best_selling_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to include or exclude out of stock products. By default all out of stock products are not shown.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to hide/show out of stock products.
 */
function prwfr_new_arrivals_outofstock_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" class="prwfr-rvps-stock-status-switch" name="prwfr_new_arrivals_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_new_arrivals_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to include or exclude out of stock products. By default all out of stock products are not shown.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to hide/show out of stock products.
 */
function prwfr_featured_product_outofstock_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" class="prwfr-rvps-stock-status-switch" name="prwfr_featured_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_featured_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to include or exclude out of stock products. By default all out of stock products are not shown.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * All products on sale section.
 */
function prwfr_all_onsale_section() {
	?>
	<div class = "prwfr-front-shortcode-text" style = "margin-top: 10px">        
		<?php esc_html_e( 'Use shortcode [prwfr_all_onsale_products_front] to display "All Onsale Products"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-all-onsale-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * All on sale label field to get title for widget and shortcode.
 */
function prwfr_all_onsale_label_field() {
	?>
	<div style="display: flex; align-items: center;">

		<input type="text" id="rvps_label" class="prwfr-title" name="prwfr_all_onsale_title" value="<?php echo esc_attr( get_option( 'prwfr_all_onsale_title' ) ); ?>" placeholder="<?php esc_html_e( 'Blockbuster deals', 'sft-product-recommendations-woocommerce' ); ?>" style="margin: 5px 0px;">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "All products on Sale" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to display radio button for page redirect.
 */
function prwfr_all_onsale_page_redirect_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-all-onsale-page-redirect-radio prwfr-radio-btn-column-container">
			<div>
				<input type="radio" class = "prwfr-all-onsale-see-more-redirect-radio" id="default_all_onsale" name="prwfr_all_onsale_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_all_onsale_page_redirect_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-all-onsale-see-more-redirect-radio" id="new" name="prwfr_all_onsale_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_all_onsale_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
			<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_all_onsale_products_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>

	<div class = "prwfr-all-onsale-back-shortcode-text" style = "margin-top: 10px">        
		<?php esc_html_e( 'Use shortcode [prwfr_all_onsale_products_back]', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-all-onsale-back-shortcode-clipboard-button clipboard">&#128203;</button>
	</div>    
	<?php
}

/**
 * Function for page selection dropdown.
 */
function prwfr_all_onsale_url_field() {

	?>

	<div style="display: flex; align-items: center;">
		<div>
			<select class = "prwfr-all-onsale-redirect-page-selection" name="prwfr_all_onsale_see_more_option">
			</select>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to select no of products to display in one row in shortcode.
 */
function prwfr_all_onsale_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_all_onsale_desktop_limit' );

	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php

	if ( $value_desktop ) {
		?>
		<input  type="number" step="1" min="4" max="6" name="prwfr_all_onsale_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_all_onsale_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input  type="number" step="1" min="4" max="6" name="prwfr_all_onsale_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_all_onsale_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input  type="number" step="1" min="3" max="4" name="prwfr_all_onsale_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_all_onsale_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input  type="number" step="1" min="3" max="4" name="prwfr_all_onsale_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_all_onsale_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input  type="number" step="1" min="1" max="2" name="prwfr_all_onsale_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_all_onsale_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input  type="number" step="1" min="1" max="2" name="prwfr_all_onsale_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "All On-Sale Products" shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Field for admin to select if recently viewed product should be visible to non logged in users.
 */
function prwfr_cookie_field_all_onsale() {

	?>
	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" name="prwfr_all_onsale_cookie_display" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_all_onsale_cookie_display' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "All On-Sale Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Section for categories and tags filter
 */
function prwfr_all_onsale_toggle_switch_section() {
	echo esc_html__( 'Filter products to display in the shortcode and widget based on categories and tags.', 'sft-product-recommendations-woocommerce' );
}

/**
 * Function to display switch to enable disable categories and tags
 */
function prwfr_all_onsale_toggle_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class = "switch">
			<input type="checkbox" class = "prwfr-all-onsale-filter-switch" name="prwfr_all_onsale_toggle" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_all_onsale_toggle' ) ), false ); ?>>
			<span class = "slider round" ></span>
		</label>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to include or exclude certain products based on their categories or tags. By default all products are tracked.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to select radio button for categories and tags
 */
function prwfr_all_onsale_cat_tag_selection_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-all-onsale-cat-tag-radio prwfr-radio-btn-column-container">

			<div>
				<input type="radio" class = "prwfr-all-onsale-select-cat-tag" id="tag" name="prwfr_all_onsale_cat_tag_selection_radio" value="tag"<?php echo checked( 'tag', esc_attr( get_option( 'prwfr_all_onsale_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="tag"><?php esc_html_e( 'Only Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-all-onsale-select-cat-tag" id="cat" name="prwfr_all_onsale_cat_tag_selection_radio" value="cat"<?php echo checked( 'cat', esc_attr( get_option( 'prwfr_all_onsale_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="cat"><?php esc_html_e( 'Only Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-all-onsale-select-cat-tag" id="both" name="prwfr_all_onsale_cat_tag_selection_radio" value="both"<?php echo checked( 'both', esc_attr( get_option( 'prwfr_all_onsale_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="both"><?php esc_html_e( 'Both', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to pick either a category, a tag, or both.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Category selection field
 */
function prwfr_all_onsale_category_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-all-onsale-cat-inc-exc-selection prwfr-all-onsale-category-parent prwfr-radio-btn-column-container">

			<div>
				<input type="radio" class = "prwfr-all-onsale-cat-inc-exc-radio" id="cat_exclude" name="prwfr_all_onsale_cat_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_all_onsale_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_exclude"><?php esc_html_e( 'Exclude Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-all-onsale-cat-inc-exc-radio" id="cat_include" name="prwfr_all_onsale_cat_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_all_onsale_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_include"><?php esc_html_e( 'Include Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Categories" to remove products of those categories, and "Include Categories" to display products having those categories in the widget and shortcode."', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Category exclude field
 */
function prwfr_all_onsale_category_exclude_field() {

	$categories = get_terms( 'product_cat' );

	if ( ! $categories ) {
		?>

		<div class = "prwfr-all-onsale-cat-exc-parent prwfr-all-onsale-category-parent">
			<?php
			echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			?>
		</div>

		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;">

			<div class = "prwfr-all-onsale-cat-exc-parent prwfr-all-onsale-category-parent prwfr-select2-outer-container">
				<select class = "prwfr-all-onsale-cat-exc-select" name="prwfr_all_onsale_cat_exc_selection[]" multiple="multiple"></select>
			</div>

			<span class = "setting-help-tip">        
				<div class = "tooltipdata">        
					<?php esc_html_e( 'This setting allows you to  select multiple categories to exclude products containing categories', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>

		</div>
		<?php
	}
}

/**
 * Category include field
 */
function prwfr_all_onsale_category_include_field() {

	$categories = get_terms( 'product_cat' );

	if ( ! $categories ) {
		?>
		<div class = "prwfr-all-onsale-cat-inc-parent prwfr-all-onsale-category-parent">
			<?php
			echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			?>
		</div>
		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;">

			<div class = "prwfr-all-onsale-cat-inc-parent prwfr-all-onsale-category-parent prwfr-select2-outer-container">

				<select class = "prwfr-all-onsale-cat-inc-select" name="prwfr_all_onsale_cat_inc_selection[]" multiple="multiple">
				</select>

			</div>

			<span class = "setting-help-tip">        
				<div class = "tooltipdata">        
					<?php esc_html_e( 'This setting allows you to  select multiple categories to include products containing categories', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>

		</div>
		<?php
	}
}


/**
 * Tag selection field
 */
function prwfr_all_onsale_tag_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-all-onsale-tag-inc-exc-radio prwfr-all-onsale-tag-parent prwfr-radio-btn-column-container">

			<div>
				<input type="radio" class = "prwfr-all-onsale-tag-inc-exc-radio" id="tag_exclude" name="prwfr_all_onsale_tag_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_all_onsale_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_exclude"><?php esc_html_e( 'Exclude Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-all-onsale-tag-inc-exc-radio" id="tag_include" name="prwfr_all_onsale_tag_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_all_onsale_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_include"><?php esc_html_e( 'Include Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Tags" to remove products containing those tags, and "Include Tags" to display products containing those tags from the widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Tag exclude field
 */
function prwfr_all_onsale_tag_exclude_field() {
	$values = get_option( 'prwfr_all_onsale_tag_exc_selection' );
	$terms  = get_terms( 'product_tag' );
	$data   = ( $values ) ? $values : array();

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-all-onsale-tag-exc-parent prwfr-all-onsale-tag-parent prwfr-select2-outer-container">
			<?php

			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-all-onsale-tag-exc-select" name="prwfr_all_onsale_tag_exc_selection[]" multiple="multiple">
					<?php
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $data, true ) ) {
							?>
							<option selected="selected" value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select multiple tags to exclude products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<?php
}

/**
 * Tag include field
 */
function prwfr_all_onsale_tag_include_field() {

	$values = get_option( 'prwfr_all_onsale_tag_inc_selection' );
	$terms  = get_terms( 'product_tag' );
	$data   = ( $values ) ? $values : array();
	?>

	<div style="display: flex; align-items: center;">

		<div class = "prwfr-all-onsale-tag-inc-parent prwfr-all-onsale-tag-parent prwfr-select2-outer-container">
			<?php

			if ( ! $terms ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-all-onsale-tag-inc-select" name="prwfr_all_onsale_tag_inc_selection[]" multiple="multiple">
					<?php
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $data, true ) ) {
							?>
							<option selected="selected" value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_attr( $term->slug ); ?>'><?php echo esc_attr( $term->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
				<?php
			}
			?>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to  select multiple tags to include products containing those tags', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to hide/show out of stock products
 */
function prwfr_all_onsale_outofstock_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" class="prwfr-rvps-stock-status-switch" name="prwfr_all_onsale_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_all_onsale_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to include or exclude out of stock products. By default all out of stock products are not shown.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}
?>

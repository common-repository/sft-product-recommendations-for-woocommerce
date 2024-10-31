<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 *  Purchase history related label field.
 */
function prwfr_phrp_label_field() {
	?>
	<div style="display: flex; align-items: center;">

		<input type="text" id="phrp_label" class="prwfr-phrp-title pro" style="max-width: 500px; width: 100%;" name="prwfr_phrp_title" value="<?php echo esc_attr( get_option( 'prwfr_phrp_title' ) ); ?>" placeholder="<?php esc_html_e( 'Suggested Products from Past Purchases', 'sft-product-recommendations-woocommerce' ); ?> " style="margin: 5px 0px;">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "Products related to Past Purchases" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
   
	<?php
}

/**
 * Phrp section
 */
function prwfr_phrp_url_section() {
	?>
	<div style = "margin-top: 10px">        
		<?php esc_html_e( 'Use shortcode [prwfr_past_purchase_related_products_front] to display "Products related to Past Purchases"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-phrp-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * Function to select default or another page.
 */
function prwfr_phrp_page_redirect_radio_field() {
	$value = get_option( 'prwfr_phrp_page_redirect_radio' );
	?>

	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-page-redirect-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-phrp-see-more-option pro" id="default" name="prwfr_phrp_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_phrp_page_redirect_radio' ) ), false ); ?> checked="checked">
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-phrp-see-more-option pro" id="new" name="prwfr_phrp_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_phrp_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_past_purchase_related_products_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Dropdown to select custom page.
 */
function prwfr_phrp_url_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-redirect-page-parent">

			<select class = "prwfr-phrp-redirect-page-selection pro" name="prwfr_phrp_see_more_option" disabled>
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
 * Function to display no of days radio button.
 */
function prwfr_phrp_no_of_days_field() {
	?>

	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-no-of-days-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" id="30_day" name="prwfr_phrp_no_of_days pro" value="30"<?php echo checked( '30', esc_attr( get_option( 'prwfr_phrp_no_of_days' ) ), false ); ?> checked="checked">
				<label for="30_day"><?php esc_html_e( '30 days', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
			<div>
				<input type="radio" id="60_days" name="prwfr_phrp_no_of_days pro" value="60"<?php echo checked( '60', esc_attr( get_option( 'prwfr_phrp_no_of_days' ) ), false ); ?>>
				<label for="60_days"><?php esc_html_e( '60 days', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
			<div>
				<input type="radio" id="90_days" name="prwfr_phrp_no_of_days pro" value="90"<?php echo checked( '90', esc_attr( get_option( 'prwfr_phrp_no_of_days' ) ), false ); ?>>
				<label for="90_days"><?php esc_html_e( '90 days', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting enables you to choose the number of days within which products purchased by the user and products related to it will be displayed.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Toggle section phrp
 */
function prwfr_phrp_toggle_switch_section() {
	echo esc_html__( 'Filter products to display in the shortcode and widget based on categories and tags.', 'sft-product-recommendations-woocommerce' );
}

/**
 * Category Tag enable/disable toggle field.
 */
function prwfr_phrp_toggle_field() {
	$values = get_option( 'prwfr_phrp_filter_switch' );
	?>

	<div style="display: flex; align-items: center;">

		<label class = "switch">
			<input type="checkbox" class = "prwfr-phrp-filter-switch pro" name="prwfr_phrp_filter_switch" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_phrp_filter_switch' ) ), false ); ?>>
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
 * Select category tag or both radio field.
 */
function prwfr_phrp_cat_tag_selection_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-cat-tag-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-phrp-select-cat-tag pro" id="tag" name="prwfr_phrp_cat_tag_selection_radio" value="tag"<?php echo checked( 'tag', esc_attr( get_option( 'prwfr_phrp_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="tag"><?php esc_html_e( 'Only Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-phrp-select-cat-tag pro" id="cat" name="prwfr_phrp_cat_tag_selection_radio" value="cat"<?php echo checked( 'cat', esc_attr( get_option( 'prwfr_phrp_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="cat"><?php esc_html_e( 'Only Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-phrp-select-cat-tag pro" id="both" name="prwfr_phrp_cat_tag_selection_radio" value="both"<?php echo checked( 'both', esc_attr( get_option( 'prwfr_phrp_cat_tag_selection_radio' ) ), false ); ?>>
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
 * Category Include exclude field.
 */
function prwfr_phrp_category_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-cat-inc-exc-selection prwfr-phrp-category-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-phrp-cat-inc-exc-radio pro" id="cat_exclude" name="prwfr_phrp_cat_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_phrp_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_exclude"><?php esc_html_e( 'Exclude Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-phrp-cat-inc-exc-radio pro" id="cat_include" name="prwfr_phrp_cat_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_phrp_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_include"><?php esc_html_e( 'Include Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>	

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Categories" to remove products of those categories from the widget, and "Include Categories" to display products having those categories."', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Categories exclude selection.
 */
function prwfr_phrp_category_exclude_field() {

	$categories = get_terms( 'product_cat' );
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-cat-exc-parent prwfr-phrp-category-parent prwfr-select2-outer-container">

			<?php
			if ( ! $categories ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-phrp-cat-exc-selection pro" name="prwfr_phrp_cat_exc_selection[]" multiple="multiple" disabled>
				</select>
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
 * Categories include selection.
 */
function prwfr_phrp_category_include_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-cat-inc-parent prwfr-phrp-category-parent prwfr-select2-outer-container">

			<?php
			$categories = get_terms( 'product_cat' );
			if ( ! $categories ) {
				echo esc_html__( ' There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-phrp-cat-inc-selection pro" name="prwfr_phrp_cat_inc_selection[]" multiple="multiple" disabled>
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
 * Tag Include Exclude selection field.
 */
function prwfr_phrp_tag_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-tag-inc-exc-selection prwfr-phrp-tag-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-phrp-select-tag-inc-exc-radio pro" id="tag_exclude" name="prwfr_phrp_tag_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_phrp_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_exclude"><?php esc_html_e( 'Exclude Tags', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
			<div>
				<input type="radio" class = "prwfr-phrp-select-tag-inc-exc-radio pro" id="tag_include" name="prwfr_phrp_tag_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_phrp_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_include"><?php esc_html_e( 'Include Tags', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude tags" to remove products of those tags, and "Include Tags" to display products having those tags from the widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Tag exclude field.
 */
function prwfr_phrp_tag_exclude_field() {

	$terms = get_terms( 'product_tag' );
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-tag-exc-parent prwfr-phrp-tag-parent prwfr-select2-outer-container">

			<?php
			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-phrp-tag-exc-selection pro" name="prwfr_phrp_tag_exc_selection[]" multiple="multiple" disabled>
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
 * Tag include field.
 */
function prwfr_phrp_tag_include_field() {

	$terms = get_terms( 'product_tag' );
	?>

	<div style="display: flex; align-items: center;">

		<div class = "prwfr-phrp-tag-inc-parent prwfr-phrp-tag-parent prwfr-select2-outer-container">
			<?php
			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-phrp-tag-inc-selection pro" name="prwfr_phrp_tag_inc_selection[]" multiple="multiple" disabled>
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
 * Buy again section
 */
function prwfr_buy_again_url_section() {
}

/**
 *  Buy again label field.
 */
function prwfr_buy_again_label_field() {
	?>
	<div style="display: flex; align-items: center;">
		<input type="text" id="buy_again_label" class="prwfr-buy-again-title pro" style="max-width: 500px; width: 100%;" name="prwfr_buy_again_title" value="<?php echo esc_attr( get_option( 'prwfr_buy_again_title' ) ); ?>" placeholder="<?php esc_html_e( 'Buy It Again', 'sft-product-recommendations-woocommerce' ); ?>" style="margin: 5px 0px;">

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "Buy again products" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to select default or another page.
 */
function prwfr_buy_again_page_redirect_radio_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-page-redirect-radio" style="display:flex; flex-direction:column; gap:5px;">
			<div>
				<input type="radio" class = "prwfr-buy-again-see-more-option pro" id="default" name="prwfr_buy_again_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_buy_again_redirect_radio' ) ), false ); ?> checked="checked">
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-see-more-option pro" id="new" name="prwfr_buy_again_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_buy_again_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_buy_it_again_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div> 
 
	<?php
}


/**
 * Dropdown to select custom page.
 */
function prwfr_buy_again_url_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-redirect-page-parent">

			<select class = "prwfr-buy-again-redirect-page-selection pro" name="prwfr_buy_again_see_more_option" disabled>
			</select>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'select page to render shortcode here', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to display no of days radio button.
 */
function prwfr_buy_again_no_of_days_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-agian-no-of-days-radio prwfr-buy-agian-no-of-days-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-buy-again-days-selection pro" id="15_days" name="prwfr_buy_again_no_of_days" value="15"<?php echo checked( '15', esc_attr( get_option( 'prwfr_buy_again_no_of_days' ) ), false ); ?>>
				<label for="15_days"><?php esc_html_e( '15 days', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-days-selection pro" id="30_days" name="prwfr_buy_again_no_of_days" value="30"<?php echo checked( '30', esc_attr( get_option( 'prwfr_buy_again_no_of_days' ) ), false ); ?>>
				<label for="30_days"><?php esc_html_e( '30 days', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-days-selection pro" id="45_days" name="prwfr_buy_again_no_of_days" value="45"<?php echo checked( '45', esc_attr( get_option( 'prwfr_buy_again_no_of_days' ) ), false ); ?>>
				<label for="45_days"><?php esc_html_e( '45 days', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to set number of day after which the buyer\'s purchased product will show up in the widget and shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Category Tag enable/disable toggle Section.
 */
function prwfr_buy_again_toggle_switch_section() {
	echo esc_html__( 'Filter products to display in the shortcode and widget based on categories and tags.', 'sft-product-recommendations-woocommerce' );
}

/**
 * Category Tag enable/disable toggle field.
 */
function prwfr_buy_again_toggle_field() {

	?>
	<div style="display: flex; align-items: center;">
		<label class = "switch">
			<input type="checkbox" class = "prwfr-buy-again-filter-switch pro" name="prwfr_buy_again_filter_switch" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_buy_again_filter_switch' ) ), false ); ?>>
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
 * Select category tag or both radio field.
 */
function prwfr_buy_again_cat_tag_selection_field() {

	?>

	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-cat-tag-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-buy-again-select-cat-tag pro" id="tag" name="prwfr_cat_tag_selection_radio" value="tag"<?php echo checked( 'tag', esc_attr( get_option( 'prwfr_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="tag"><?php esc_html_e( 'Only Tags', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-select-cat-tag pro" id="cat" name="prwfr_cat_tag_selection_radio" value="cat"<?php echo checked( 'cat', esc_attr( get_option( 'prwfr_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="cat"><?php esc_html_e( 'Only Categories', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-select-cat-tag pro" id="both" name="prwfr_cat_tag_selection_radio" value="both"<?php echo checked( 'both', esc_attr( get_option( 'prwfr_cat_tag_selection_radio' ) ), false ); ?>>
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
 * Category Include exclude field
 */
function prwfr_buy_again_category_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-cat-inc-exc-selection prwfr-buy-again-category-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-buy-again-cat-inc-exc-radio pro" id="cat_exclude" name="prwfr_buy_again_cat_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_buy_again_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_exclude"><?php esc_html_e( 'Exclude Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-cat-inc-exc-radio pro" id="cat_include" name="prwfr_buy_again_cat_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_buy_again_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_include"><?php esc_html_e( 'Include Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Categories" to remove products of those categories from the widget, and "Include Categories" to display products having those categories."', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Category exclude field select.
 */
function prwfr_buy_again_category_exclude_field() {

	$categories = get_terms( 'product_cat' );
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-cat-exc-parent prwfr-buy-again-category-parent prwfr-select2-outer-container">

			<?php
			if ( ! $categories ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-buy-again-cat-exc-selection pro" name="prwfr_buy_again_cat_exc_selection[]" multiple="multiple" disabled>
				</select>
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
 * Category include field select.
 */
function prwfr_buy_again_category_include_field() {

	$categories = get_terms( 'product_cat' );
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-cat-inc-parent prwfr-buy-again-category-parent prwfr-select2-outer-container">

			<?php
			if ( ! $categories ) {
				echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-buy-again-cat-inc-selection pro" name="prwfr_buy_again_cat_inc_selection[]" multiple="multiple" disabled>
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
 * Tag Include exclude field
 */
function prwfr_buy_again_tag_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-tag-inc-exc-selection prwfr-buy-again-tag-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class = "prwfr-buy-again-tag-inc-exc-radio pro" id="tag_exclude" name="prwfr_buy_again_tag_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_buy_again_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_exclude"><?php esc_html_e( 'Exclude Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class = "prwfr-buy-again-tag-inc-exc-radio pro" id="tag_include" name="prwfr_buy_again_tag_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_buy_again_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_include"><?php esc_html_e( 'Include Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
				
		</div>

		<span class = "setting-help-tip">        
			<div class = "tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Tags" to remove products of those tags, and "Include tags" to display products containing those tags from the widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Tag exclude field select.
 */
function prwfr_buy_again_tag_exclude_field() {

	$terms = get_terms( 'product_tag' );

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-tag-exc-parent prwfr-buy-again-tag-parent prwfr-select2-outer-container">

			<?php
			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-buy-again-tag-exc-selection pro" name="prwfr_buy_again_tag_exc_selection[]" multiple="multiple" disabled>
				</select>
			<?php } ?>
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
 * Tags include field select.
 */
function prwfr_buy_again_tag_include_field() {

	$terms = get_terms( 'product_tag' );

	?>
	<div style="display: flex; align-items: center;">

		<div class = "prwfr-buy-again-tag-inc-parent prwfr-buy-again-tag-parent prwfr-select2-outer-container">
			<?php
			if ( ! $terms ) {
				echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			} else {
				?>
				<select class = "prwfr-buy-again-tag-inc-selection pro" name="prwfr_buy_again_tag_inc_selection[]" multiple="multiple" disabled>
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
 * Function to display field containing no of elements to display per row.
 */
function prwfr_phrp_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_phrp_desktop_limit' );

	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php

	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_phrp_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_phrp_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_phrp_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_phrp_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_phrp_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_phrp_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_phrp_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_phrp_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_phrp_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_phrp_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_phrp_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "Products related to Past Purchases" shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Field to hide/show out of stock prdoucts
 */
function prwfr_phrp_outofstock_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" class="prwfr-rvps-stock-status-switch pro" name="prwfr_phrp_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_phrp_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
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

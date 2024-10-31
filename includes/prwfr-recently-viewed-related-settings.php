<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Field for admin to select if recently viewed product should be visible to non logged in users.
 */
function prwfr_cookie_field_rvps() {
	?>
	<div style="display: flex; align-items: center;">
	<label class="switch prwfr-disable">
			<input type="checkbox" name="prwfr_rvps_hide_cookie" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_hide_cookie' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "Recently Viewed Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field for admin to select if recently viewed product on sale should be visible to non logged in users.
 */
function prwfr_cookie_field_rvps_onsale() {

	?>
	<div style="display: flex; align-items: center;">
	<label class="switch prwfr-disable">
			<input type="checkbox" name="prwfr_rvps_onsale_hide_cookie" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_onsale_hide_cookie' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "On-Sale Products related to Recently Viewed Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field for admin to select if products related to recently viewed product should be visible to non logged in users.
 */
function prwfr_cookie_field_rvps_related() {

	?>
	<div style="display: flex; align-items: center;">
	<label class="switch prwfr-disable">
			<input type="checkbox" name="prwfr_viewed_related_hide_cookie" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_viewed_related_hide_cookie' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to display or hide "Products related to Recently Viewed Products" to users who are not logged in', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to display/hide reorder button on order detail page.
 */
function prwfr_reorder_field() {

	?>
	<div style="display: flex; align-items: center;">
		<label class="switch">
			<input type="checkbox" name="prwfr_display_reorder" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_display_reorder' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip" style="display: flex;">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to enable/disable Re-order button on Order detail page in My Account', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Section to get labels for all the widgets available.
 */
function prwfr_label_section() {
}

/**
 * Rvps label field.
 */
function prwfr_rvps_label_field() {
	?>
	<div style="display: flex; align-items: center;" >
		<input type="text" id="rvps_label" class="prwfr-title" name="prwfr_rvps_title" value="<?php echo esc_attr( get_option( 'prwfr_rvps_title' ) ); ?>" placeholder="<?php esc_html_e( 'Recently Viewed Products', 'sft-product-recommendations-woocommerce' ); ?>" style="margin: 5px 0px;">
		<span class="setting-help-tip" style="display: flex;">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "Recently Viewed Products" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Function to display manage history button hide and show browsing history switch to user
 */
function prwfr_manage_history_field() {

	?>
	<div style="display: flex; align-items: center;">
		<label class="switch prwfr-disable">
			<input type="checkbox" name="prwfr_manage_history_access" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_manage_history_access' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to enable/disable Browsing History switch to user.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Rvps and related on sale label field.
 */
function prwfr_rvps_onsale_label_field() {
	?>
	<div style="display: flex; align-items: center;">
		<input type="text" id="rvps_label" class="prwfr-title" name="prwfr_rvps_onsale_title" value="<?php echo esc_attr( get_option( 'prwfr_rvps_onsale_title' ) ); ?>" placeholder="<?php esc_html_e( 'Trending Deals', 'sft-product-recommendations-woocommerce' ); ?>" style="margin: 5px 0px;">
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "On-Sale Products related to Recently Viewed Products" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>	
	<?php
}

/**
 * Rvps related label field.
 */
function prwfr_view_related_label_field() {
	?>
	<div style="display: flex; align-items: center;">
		<input type="text" id="view_related_label" class="prwfr-title" name="prwfr_viewed_related_title" value="<?php echo esc_attr( get_option( 'prwfr_viewed_related_title' ) ); ?>" placeholder="<?php esc_html_e( "Related to items you've viewed", 'sft-product-recommendations-woocommerce' ); ?>" style="margin: 5px 0px;">
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting enables you to specify the title you want to show for "Products related to Recently Viewed Products" widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>	
	<?php
}

function prwfr_enable_ai_recommendations() {
	?>
	<div style="display: flex; align-items: center;">
		<label class="switch">
			<!-- <input type="checkbox" name="prwfr_manage_history_access" value="1" <?php //echo checked( '1', esc_attr( get_option( 'prwfr_manage_history_access' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span> -->

			<input type="checkbox" name="prwfr_activate_ai_recommendations" value="1" <?php echo checked( '1', get_option( 'prwfr_activate_ai_recommendations' ), false ); ?> style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>
		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'Enable this setting to display AI-generated product suggestions on the frontend using shortcodes. The AI will recommend relevant products based on your configuration, and these suggestions will appear in widgets for Recently Viewed Products and Purchase History.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to pick cololr for back and next button.
 */
function prwfr_color_picker_field() {
	$value = get_option( 'prwfr_color_picker_btn' );
	if ( $value ) {
		?>
		<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
			<input type="text" class="prwfr-btn-color" name="prwfr_color_picker_btn" value="<?php echo esc_attr( get_option( 'prwfr_color_picker_btn' ) ); ?>" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to pick the color to change color of previous and next button within shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
			<input type="text" class="prwfr-btn-color" name="prwfr_color_picker_btn" value="#000000" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to pick the color to change color of previous and next button within shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	}

}

/**
 * Field to pick background color for front shortcodes
 */
function prwfr_bgcolor_picker_field() {
	$value = get_option( 'prwfr_color_picker_background_front' );

	if ( $value ) {
		?>
		<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
			<input type="text" class="prwfr-btn-color" name="prwfr_color_picker_background_front" value="<?php echo esc_attr( get_option( 'prwfr_color_picker_background_front' ) ); ?>" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to pick the background color to change background color of products slider', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;" class="prwfr-color-picker-container">
			<input type="text" class="prwfr-btn-color" name="prwfr_color_picker_background_front" value="#e8e8e8" placeholder="<?php esc_html_e( 'Add label', 'sft-product-recommendations-woocommerce' ); ?>">
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to pick the background color to change background color of prdoucts slider', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	}

}

/**
 * Section to display configure options for rvps.
 */
function prwfr_rvp_section() {
	?>
	<div class="prwfr-shortcode-text-display-container">        
		<?php esc_html_e( 'Use shortcode [prwfr_recently_viewed_products_front] to display "Recently Viewed Products"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-rvps-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * Field to select redirect page for rvps.
 */
function prwfr_rvps_page_redirect_radio_field() {

	?>
	<div style="display: flex; align-items: center;margin-bottom: 10px;">

		<div class="prwfr-rvps-page-redirect-radio" style="display:flex; flex-direction:column; gap: 5px;">

			<div>
				<input type="radio" class="prwfr-rvps-see-more-redirect-option" id="default_rvp" name="prwfr_rvps_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_rvps_page_redirect_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
			<div>
				<input type="radio" class="prwfr-rvps-see-more-redirect-option" id="new" name="prwfr_rvps_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_rvps_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>
		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_recently_viewed_products_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>
	<div class="prwfr-rvps-back-shortcode-text" style="color: #8f8f8f;"><?php esc_html_e( 'Use shortcode [prwfr_recently_viewed_products_back]', 'sft-product-recommendations-woocommerce' ); ?> <button class="prwfr-rvps-clipboard-button clipboard">&#128203;</button></div>
	<?php
}

/**
 * Select page from dropdown for rvps.
 */
function prwfr_rvps_url_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-rvps-redirect-page-parent">

			<select class="prwfr-rvps-redirect-page-selection" name="prwfr_rvps_see_more_option">
				<option value='Select'></option>
			</select>
		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Takes the no of products to display in single row. Recently Viewed Products Tab
 */
function prwfr_rvps_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_rvps_desktop_limit' );

	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php

	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_rvps_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_rvps_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_rvps_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_rvps_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_rvps_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_rvps_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_rvps_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_rvps_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_rvps_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_rvps_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_rvps_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "Recently Viewed Products" shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Section to configure options for recently viewed and related on sale.
 */
function prwfr_rvp_onsale_section() {
	?>
	<div class="prwfr-shortcode-text-display-container">        
		<?php esc_html_e( 'Use shortcode [prwfr_onsale_recently_viewed_products_front] to display "On-Sale Products related to Recently Viewed Products"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-rvp-onsale-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * Field to select redirect page for rvps onsale.
 */
function prwfr_rvps_onsale_page_redirect_radio_field() {

	?>
	<div style="display: flex; align-items: center; margin-bottom: 10px;">

		<div class="prwfr-rvps-onsale-page-redirect-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class="prwfr-rvps-onsale-see-more-option" id="default_rvp_onsale" name="prwfr_rvps_onsale_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_rvps_onsale_page_redirect_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class="prwfr-rvps-onsale-see-more-option" id="new" name="prwfr_rvps_onsale_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_rvps_onsale_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting lets you change the "See more" link to lead to a another page. By default, it goes to the default page. To display all products on a another page, create a new page, insert the shortcode [prwfr_onsale_recently_viewed_products_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>

	<div class="prwfr-rvps-onsale-back-shortcode-text" style="color: #8f8f8f;">        
		<?php esc_html_e( 'Use shortcode [prwfr_onsale_recently_viewed_products_back]', 'sft-product-recommendations-woocommerce' ); ?>
		<button class="prwfr-rvp-onsale-clipboard-button clipboard">&#128203;</button>
	</div>    
	<?php
}

/**
 * Select page from dropdown for rvps onsale.
 */
function prwfr_rvps_onsale_url_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-rvps-onsale-redirect-page-parent">

			<select class="prwfr-rvps-onsale-redirect-page-selection" name="prwfr_rvps_onsale_see_more_option">
			<option value='Select'></option>
			</select>
		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Takes the no of products to display in single row. On sale Products related to Recently viewed Products
 */
function prwfr_rvps_onsale_shortcode_container_field() {

	// For desktop.
	$value_desktop = get_option( 'prwfr_rvps_onsale_desktop_limit' );

	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">

	<?php

	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_rvps_onsale_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_rvps_onsale_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_rvps_onsale_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_rvps_onsale_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_rvps_onsale_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_rvps_onsale_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_rvps_onsale_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_rvps_onsale_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_rvps_onsale_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_rvps_onsale_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_rvps_onsale_mobile_limit" value="2" >
		<?php
	}

	?>
	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "On-Sale Products related to Recently Viewed Products" product slider.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>

	<?php
}

/**
 * Section to configure options for Recently Viewed Products related.
 */
function prwfr_rvp_related_section() {
	?>
	<div class="prwfr-shortcode-text-display-container">        
		<?php esc_html_e( 'Use shortcode [prwfr_related_recently_viewed_products_front] to display "Products related to Recently Viewed Products"', 'sft-product-recommendations-woocommerce' ); ?>    
		<button class="prwfr-viewed-related-front-clipboard-button clipboard">&#128203;</button>
	</div> 
	<?php
}

/**
 * Field to select redirect page for rvps related.
 */
function prwfr_views_related_page_redirect_radio_field() {

	?>
	<div style="display: flex; align-items: center; margin-bottom: 10px;">

		<div class="prwfr-viewed-related-page-redirect-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class="prwfr-viewed-related-see-more-option" id="default_related" name="prwfr_viewed_related_page_redirect_radio" value="default"<?php echo checked( 'default', esc_attr( get_option( 'prwfr_viewed_related_page_redirect_radio' ) ), false ); ?>>
				<label for="default"><?php esc_html_e( 'Default page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
			<div>
				<input type="radio" class="prwfr-viewed-related-see-more-option" id="new" name="prwfr_viewed_related_page_redirect_radio" value="new"<?php echo checked( 'new', esc_attr( get_option( 'prwfr_viewed_related_page_redirect_radio' ) ), false ); ?>>
				<label for="new"><?php esc_html_e( 'Another page', 'sft-product-recommendations-woocommerce' ); ?> </label><br>
			</div>
		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( '	 This setting lets you change the "See more" link to lead to a different page. By default, it goes to the default page. To display all products on a different page, create a new page, insert the shortcode [prwfr_related_recently_viewed_products_back], and in the settings, choose the "Another page" option. Then, select your preferred page from the dropdown below.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>

	</div>

	<div class="prwfr-viewed-related-back-shortcode-text" style="color: #8f8f8f;"> <?php esc_html_e( 'Use shortcode [prwfr_related_recently_viewed_products_back]', 'sft-product-recommendations-woocommerce' ); ?> <button class="prwfr-viewed-related-clipboard-button clipboard">&#128203;</button></div>
	<?php

}

/**
 * Select page from dropdown for rvps related.
 */
function prwfr_views_related_url_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-viewed-related-redirect-page-parent">
			<select class="prwfr-viewed-related-redirect-page-selection" name="prwfr_viewed_related_see_more_option">
			<option value='Select'></option>
			</select>
		</div>

		<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you select the page where you\'ve inserted the shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
		</span>
	</div>
	<?php
}

/**
 * Takes the no of products to display in single row. Related to recently viewed products
 */
function prwfr_views_related_shortcode_container_field() {
	// For desktop.
	$value_desktop = get_option( 'prwfr_viewed_related_desktop_limit' );

	?>
	<div style="display:flex; align-items: center; gap: 5px;">
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-desktop.svg', __FILE__ ) ); ?>' width="22px" height="22px" class="prwfr-desktop-icon-svg">
	<?php

	if ( $value_desktop ) {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_viewed_related_desktop_limit" value="<?php echo esc_attr( get_option( 'prwfr_viewed_related_desktop_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="4" max="6" name="prwfr_viewed_related_desktop_limit" value="4" style="
		margin-right: 15px;
		">
		<?php
	}

	// For tab.
	$value_tab = get_option( 'prwfr_viewed_related_tab_limit' );

	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-tablet.svg', __FILE__ ) ); ?>' width="18px" height="20px" class="prwfr-tablet-icon-svg">
	<?php

	if ( $value_tab ) {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_viewed_related_tab_limit" value="<?php echo esc_attr( get_option( 'prwfr_viewed_related_tab_limit' ) ); ?>" style="
		margin-right: 15px;
		">
		<?php
	} else {
		?>
		<input type="number" step="1" min="3" max="4" name="prwfr_viewed_related_tab_limit" value="3" style="
		margin-right: 15px;
		">
		<?php
	}

	// For mobile.
	$value_mobile = get_option( 'prwfr_viewed_related_mobile_limit' );
	?>
	<img src='<?php echo esc_attr( plugins_url( '../assets/images/device-mobile.svg', __FILE__ ) ); ?>' width="16px" height="20px" class="prwfr-mobile-icon-svg">
	<?php

	if ( $value_mobile ) {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_viewed_related_mobile_limit" value="<?php echo esc_attr( get_option( 'prwfr_viewed_related_mobile_limit' ) ); ?>" >
		<?php
	} else {
		?>
		<input type="number" step="1" min="1" max="2" name="prwfr_viewed_related_mobile_limit" value="2" >
		<?php
	}
	?>

	<span class="setting-help-tip">        
		<div class="tooltipdata">        
			<?php esc_html_e( 'This setting allows you to specify the number of products you wish to showcase within the "Products related to Recently Viewed Products" products slider.', 'sft-product-recommendations-woocommerce' ); ?>    
		</div>    
	</span>
	</div>
	<?php
}

/**
 * Section to choose categories and tags to include/exclude.
 */
function prwfr_rvps_toggle_section() {
	echo esc_html__( 'Filter products to display in the shortcode and widget based on categories and tags.', 'sft-product-recommendations-woocommerce' );
}

/**
 * Field for Categories and tags.
 */
function prwfr_rvps_toggle_field() {

	?>
	<div style="display: flex; align-items: center;">

		<label class="switch">
			<input type="checkbox" class="prwfr-rvps-filter-switch" name="prwfr_rvps_filter_switch" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_filter_switch' ) ), false ); ?> style="padding-right: 12px;">
			<span class="slider round prwfr-rvps-filter" ></span>
		</label>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to include or exclude certain products based on their categories or tags. By default all products are tracked.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}


/**
 * Switch field for category or tag or both.
 */
function prwfr_rvps_cat_tag_selection_field() {

	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-rvps-cat-tag-radio" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class="prwfr-rvps-select-cat-tag" id="tag" name="prwfr_rvps_cat_tag_selection_radio" value="tag"<?php echo checked( 'tag', esc_attr( get_option( 'prwfr_rvps_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="tag"><?php esc_html_e( 'Tags Only', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class="prwfr-rvps-select-cat-tag" id="cat" name="prwfr_rvps_cat_tag_selection_radio" value="cat"<?php echo checked( 'cat', esc_attr( get_option( 'prwfr_rvps_cat_tag_selection_radio' ) ), false ); ?>>
				<label for="cat"><?php esc_html_e( 'Categories Only', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class="prwfr-rvps-select-cat-tag" id="both" name="prwfr_rvps_cat_tag_selection_radio" value="both"<?php echo checked( 'both', esc_attr( get_option( 'prwfr_rvps_cat_tag_selection_radio' ), false ) ); ?>>
				<label for="both"><?php esc_html_e( 'Categories and Tags', 'sft-product-recommendations-woocommerce' ); ?></label>
			</div>

		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to pick either a category, a tag, or both.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Category radio field.
 */
function prwfr_rvps_category_radio_field() {
	?>

	<div style="display: flex; align-items: center;">

		<div class="prwfr-rvps-cat-inc-exc-selection prwfr-rvps-category-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class="prwfr-rvps-cat-inc-exc-radio" id="cat_exclude" name="prwfr_rvps_cat_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_rvps_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_exclude"><?php esc_html_e( 'Exclude Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class="prwfr-rvps-cat-inc-exc-radio" id="cat_include" name="prwfr_rvps_cat_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_cat_inc_exc_radio' ) ), false ); ?>>
				<label for="cat_include"><?php esc_html_e( 'Include Categories', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Categories" to remove products of those categories, and "Include Categories" to display products having those categories in the widget and shortcode."', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Category exclude field.
 */
function prwfr_rvps_category_exclude_field() {
	$values     = get_option( 'prwfr_rvps_cat_exc_selection' );
	$data       = ( $values ) ? $values : array();
	$categories = get_terms( 'product_cat' );

	if ( ! $categories ) {
		?>
		<div class="prwfr-rvps-category-parent prwfr-rvps-cat-exc-parent">
			<?php
			echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			?>
		</div>
		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;">

			<div class="prwfr-rvps-category-parent prwfr-rvps-cat-exc-parent prwfr-select2-outer-container">

				<select class="prwfr-rvps-cat-exc-select" name="prwfr_rvps_cat_exc_selection[]" multiple="multiple">
					<?php
					foreach ( $categories as $cat ) {
						if ( in_array( $cat->slug, $data ) ) {
							?>
							<option selected="selected" value='<?php echo esc_html( $cat->slug ); ?>'><?php echo esc_html( $cat->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_html( $cat->slug ); ?>'><?php echo esc_html( $cat->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>

			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to select multiple categories to exclude products of that categories from widget and shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	}
}

/**
 * Category include field.
 */
function prwfr_rvps_category_include_field() {
	$values = get_option( 'prwfr_rvps_cat_inc_selection' );
	$data   = ( $values ) ? $values : array();

	$categories = get_terms( 'product_cat' );

	if ( ! $categories ) {
		?>
		<div class="prwfr-rvps-category-parent prwfr-rvps-cat-inc-parent">
			<?php
			echo esc_html__( 'There are no categories to show. Please add some categories to products first!', 'sft-product-recommendations-woocommerce' );
			?>
		</div>
		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;">

			<div class="prwfr-rvps-category-parent prwfr-rvps-cat-inc-parent prwfr-select2-outer-container">

				<select class="prwfr-rvps-cat-inc-select" name="prwfr_rvps_cat_inc_selection[]" multiple="multiple">
					<?php
					foreach ( $categories as $cat ) {
						if ( in_array( $cat->slug, $data ) ) {
							?>
							<option selected="selected" value='<?php echo esc_html( $cat->slug ); ?>'><?php echo esc_html( $cat->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_html( $cat->slug ); ?>'><?php echo esc_html( $cat->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to select multiple categories to include products of that categories in widget and shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	}
}


/**
 * Tag radio field
 */
function prwfr_rvps_tag_radio_field() {
	?>
	<div style="display: flex; align-items: center;">

		<div class="prwfr-rvps-tag-inc-exc-selection prwfr-rvps-tag-parent" style="display:flex; flex-direction:column; gap:5px;">

			<div>
				<input type="radio" class="prwfr-rvps-tag-inc-exc-radio" id="tag_exclude" name="prwfr_rvps_tag_inc_exc_radio" value="0"<?php echo checked( '0', esc_attr( get_option( 'prwfr_rvps_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_exclude"><?php esc_html_e( 'Exclude Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>
			<div>
				<input type="radio" class="prwfr-rvps-tag-inc-exc-radio" id="tag_include" name="prwfr_rvps_tag_inc_exc_radio" value="1"<?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_tag_inc_exc_radio' ) ), false ); ?>>
				<label for="tag_include"><?php esc_html_e( 'Include Tags', 'sft-product-recommendations-woocommerce' ); ?></label><br>
			</div>

		</div>

		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to choose "Exclude Tags" to remove products containing those tags, and "Include Tags" to display products containing those tags from the widget and shortcode.', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Tag exclude field.
 */
function prwfr_rvps_tag_exclude_field() {
	$values = get_option( 'prwfr_rvps_tag_exc_selection' );
	$terms  = get_terms( 'product_tag' );
	$data   = ( $values ) ? $values : array();

	if ( ! $terms ) {
		?>
		<div class="prwfr-rvps-tag-parent prwfr-rvps-tag-exc-parent">
			<?php
			echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			?>
		</div>
		<?php
	} else {
		?>
		<div style="display: flex; align-items: center;">
			<div class="prwfr-rvps-tag-parent prwfr-rvps-tag-exc-parent prwfr-select2-outer-container">
				<select class="prwfr-rvps-tag-exc-select" name="prwfr_rvps_tag_exc_selection[]" multiple="multiple">
					<?php
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $data ) ) {
							?>
							<option selected="selected" value='<?php echo esc_html( $term->slug ); ?>'><?php echo esc_html( $term->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_html( $term->slug ); ?>'><?php echo esc_html( $term->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to select multiple tags to exclude products containing those tags from widget and shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	}
}

/**
 * Tag include field.
 */
function prwfr_rvps_tag_include_field() {

	$values = get_option( 'prwfr_rvps_tag_inc_selection' );
	$terms  = get_terms( 'product_tag' );
	$data   = ( $values ) ? $values : array();

	if ( ! $terms ) {
		?>
		<div class="prwfr-rvps-tag-parent prwfr-rvps-tag-inc-parent">
			<?php
			echo esc_html__( 'There are no tags to show. Please add some tags to products first!', 'sft-product-recommendations-woocommerce' );
			?>
		</div>
		<?php
	} else {
		?>

		<div style="display: flex; align-items: center;">

			<div class="prwfr-rvps-tag-parent prwfr-rvps-tag-inc-parent prwfr-select2-outer-container">

				<select class="prwfr-rvps-tag-inc-select" name="prwfr_rvps_tag_inc_selection[]" multiple="multiple">
					<?php
					foreach ( $terms as $term ) {
						if ( in_array( $term->slug, $data ) ) {
							?>
							<option selected="selected" value='<?php echo esc_html( $term->slug ); ?>'><?php echo esc_html( $term->slug ); ?></option>
							<?php
						} else {
							?>
							<option value='<?php echo esc_html( $term->slug ); ?>'><?php echo esc_html( $term->slug ); ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>

			<span class="setting-help-tip">        
				<div class="tooltipdata">        
					<?php esc_html_e( 'This setting allows you to select multiple tags to include products containing those tags in widget and shortcode', 'sft-product-recommendations-woocommerce' ); ?>    
				</div>    
			</span>
		</div>
		<?php
	}
}

/**
 * Get size of product image .
 */
function prwfr_Products_Rating_field() {
	?>
	<div style="display: flex; align-items: center;margin-bottom: 10px;">

		<label class="switch prwfr-disable">
			<input type="checkbox" value="1" style="padding-right: 12px;">
			<span class="slider round" ></span>
		</label>


		<span class="setting-help-tip">        
			<div class="tooltipdata">        
				<?php esc_html_e( 'This setting allows you to select image size you wish to display to users', 'sft-product-recommendations-woocommerce' ); ?>    
			</div>    
		</span>
	</div>
	<?php
}

/**
 * Field to show/hide out of stock products
 */
function prwfr_rvps_outofstock_field() {

	?>

	<div style="display: flex; align-items: center;">

		<label class="switch prwfr-disable">
			<input type="checkbox" class="prwfr-rvps-stock-status-switch" name="prwfr_rvps_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
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
 * Field to hide/show out of stock prdoucts.
 */
function prwfr_views_related_outofstock_field() {

	?>
	<div style="display: flex; align-items: center;">

		<label class="switch prwfr-disable">
			<input type="checkbox" class="prwfr-rvps-related-stock-status-switch" name="prwfr_viewed_related_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_viewed_related_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
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
 * Field to hide/show out of stock prdoucts.
 */
function prwfr_rvps_onsale_outofstock_field() {

	?>
	<div style="display: flex; align-items: center;">

		<label class="switch prwfr-disable">
			<input type="checkbox" class="prwfr-rvps-onsale-stock-status-switch" name="prwfr_rvps_onsale_out_of_stock" value="1" <?php echo checked( '1', esc_attr( get_option( 'prwfr_rvps_onsale_out_of_stock' ) ), false ); ?> style="padding-right: 12px;">
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

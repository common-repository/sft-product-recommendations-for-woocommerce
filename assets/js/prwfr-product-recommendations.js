jQuery(document).ready(function () {

  jQuery( '#toplevel_page_prwfr_menu > .wp-submenu > li.wp-first-item a' ).html('Pre-Purchase Products');
  jQuery('#default_rvp, #default_related, #default_rvp_onsale, #default_best_seller, #default_new_arrivals, #default_featured, #default_all_onsale, #default_bs, #default_na, #default_fp').attr('checked', 'checked');

  jQuery('.prwfr-all-onsale-filter-switch, .prwfr-rvps-filter-switch').attr('checked', false);

  jQuery('.prwfr-pro').css('cursor', 'pointer');
  jQuery('.prwfr-pro').click(function () {

    var prwfrUpgradeNow = prwfr_ajax_action_obj.prwfr_free_to_pro_upgrade;
    var lineOne = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_line_one;
    var lineTwo = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_line_two;
    var lineThree = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_one_bold;
    var lineFour = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_one;
    var lineFive = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_two_bold;
    var lineSix = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_two;
    var lineSeven = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_three_bold;
    var lineEight = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_three;
    var lineNine = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_four_bold;
    var lineTen = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_four;
    var lineEleven = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_five_bold;
    var lineTwelve = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_five;
    var lineThirteen = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_six_bold;
    var lineFourteen = prwfr_ajax_action_obj.prwfr_free_to_pro_popup_listing_six;
    Swal.fire({
      title: '<div class="pro-alert-header">' + prwfr_ajax_action_obj.prwfr_free_to_pro_alert_title + '</div>',
      showCloseButton: true,
      html: '<div class="pro-crown"><svg xmlns="http://www.w3.org/2000/svg" height="100" width="100" viewBox="0 0 640 512"><path fill="#f8c844" d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5 .4 5.1 .8 7.7 .8 26.5 0 48-21.5 48-48s-21.5-48-48-48z"/></svg></div><div class="popup-text-one">' + lineOne + '</div><div class="popup-text-two">' + lineTwo + '</div> <ul style="font-size:16px;"><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> <b>' + lineThree + '</b>' + lineFour + '</li><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg><b>' + lineFive + '</b>' + lineSix + '</li><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg><b>' + lineSeven + '</b>' + lineEight + '</li> <li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> <b>' + lineNine + '</b>' + lineTen + '</li><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> <b>' + lineEleven + '</b>' + lineTwelve + '</li><li><svg xmlns="http://www.w3.org/2000/svg" height="25" width="25" viewBox="0 0 448 512"><path fill="#ff3d3d" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg> <b>' + lineThirteen + '</b>' + lineFourteen + '</li></ul>' + '<button class="prwfr-upgrade-now" style="border: none"><a href="https://www.saffiretech.com/woocommerce-product-recommendations-pro/?utm_source=wp_plugin&utm_medium=profield&utm_campaign=free2pro&utm_id=c1&utm_term=upgrade_now&utm_content=prwfr" target="_blank" class="purchase-pro-link">' + prwfrUpgradeNow + '</a></button>',
      customClass: "prwfr-popup",
      showConfirmButton: false,
    });

    jQuery('.prwfr-popup').css('width', '800px');
    jQuery('.prwfr-popup > .swal2-header').css('background', '#061727');
    jQuery('.prwfr-popup > .swal2-header').css('margin', '-20px');
    jQuery('.pro-alert-header').css('padding-top', '25px');
    jQuery('.pro-alert-header').css('padding-bottom', '20px');
    jQuery('.pro-alert-header').css('color', 'white');
    jQuery('.pro-crown').css('margin-top', '20px');
    jQuery('.popup-text-one').css('font-size', '30px');
    jQuery('.popup-text-one').css('font-weight', '600');
    jQuery('.popup-text-one').css('padding-bottom', '10px');
    jQuery('.prwfr-popup > .swal2-content > .swal2-html-container > ul').css('text-align', 'left');
    jQuery('.prwfr-popup > .swal2-content > .swal2-html-container > ul svg').css({'position': 'relative', 'top': '6px'});
    // jQuery('.prwfr-popup > .swal2-content > .swal2-html-container > ul ').css('padding-left', '25px');
    // jQuery('.prwfr-popup > .swal2-content > .swal2-html-container > ul ').css('padding-right', '25px');
    jQuery('.prwfr-popup > .swal2-content > .swal2-html-container > ul ').css('line-height', '2em');
    jQuery('.popup-text-two').css('padding', '10px');
    jQuery('.popup-text-two').css('font-weignt', '500');
    jQuery('.prwfr-popup > .swal2-content > .swal2-html-container > ul, .popup-text-one, .popup-text-two').css('color', '#061727');

    if(jQuery('.swal2-container .prwfr-popup')) {
      jQuery('.swal2-container').css('z-index', '10000000');
    }

  })

  // =================================
  // Setting timeout.
  setTimeout( () => {
    // AJAX to show notice of new features.
    jQuery('div[data-notice="prwfr_new_features_notice"] .notice-dismiss').on('click', function(e){
        e.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: prwfr_ajax_object.ajax_url,
            data: {
                action: 'prwfr_update_new_feature_notice_read',
            },
            success: (res) => {
            }
        });
    })
  }, 2000);

  // =======================================

  jQuery('.prwfr-disable input, .prwfr-rvps-cat-exc-select, .prwfr-rvps-cat-inc-select, .prwfr-rvps-tag-inc-select, .prwfr-rvps-tag-exc-select, .prwfr-rvps-redirect-page-selection, .prwfr-rvps-clipboard-button, .prwfr-viewed-related-redirect-page-selection, .prwfr-viewed-related-clipboard-button, .prwfr-rvps-onsale-redirect-page-selection, .prwfr-rvp-onsale-clipboard-button, .prwfr-new-arrivals-see-more-option, .prwfr-new-arrivals-clipboard-button, .prwfr-featured-see-more-option, .featured-clipboard-button, .prwfr-best-selling-see-more-option, .best-selling-clipboard-button, .prwfr-all-onsale-redirect-page-selection, .prwfr-all-onsale-back-shortcode-clipboard-button').attr('disabled', 'disabled');

  // ----------------------- all onsale ---------------------
  jQuery('input[name="prwfr_all_onsale_desktop_limit"], input[name="prwfr_all_onsale_tab_limit"], input[name="prwfr_all_onsale_mobile_limit"], input[name="prwfr_all_onsale_title"], .prwfr-rvps-stock-status-switch, input[name="prwfr_all_onsale_cookie_display"], .prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-select, .prwfr-all-onsale-tag-exc-select, .prwfr-all-onsale-tag-inc-select, .prwfr-phrp-title, .prwfr-buy-again-title').attr('disabled', 'disabled');
  // ----------------------------------------------

  // -------------------- best selling ----------------------------
  jQuery('input[name="prwfr_best_selling_desktop_limit"], input[name="prwfr_best_selling_tab_limit"], input[name="prwfr_best_selling_mobile_limit"], input[name="prwfr_best_selling_title"], .prwfr-rvps-stock-status-switch, input[name="prwfr_best_selling_cookie_display"], .prwfr-best-selling-cat-inc-selection, .prwfr-best-selling-tag-inc-selection, .prwfr-best-selling-individual-include').attr('disabled', 'disabled');
  // ---------------------------------------------

  // ----------------------- Featured ---------------------------
  jQuery('input[name="prwfr_featured_desktop_limit"], input[name="prwfr_featured_tab_limit"], input[name="prwfr_featured_mobile_limit"], input[name="prwfr_featured_title"], .prwfr-rvps-stock-status-switch, input[name="prwfr_featured_cookie_display"], .prwfr-featured-cat-inc-selection, .prwfr-featured-tag-inc-selection, .prwfr-featured-single-inc-selection').attr('disabled', 'disabled');
  // --------------------------------------------

  // ----------------------- Featured ---------------------------
  jQuery('input[name="prwfr_new_arrivals_desktop_limit"], input[name="prwfr_new_arrivals_tab_limit"], input[name="prwfr_new_arrivals_mobile_limit"], input[name="prwfr_new_arrivals_title"], .prwfr-rvps-stock-status-switch, input[name="prwfr_new_arrivals_cookie_display"], .prwfr-new-arrivals-cat-inc-selection, .prwfr-new-arrivals-tag-inc-selection, .new_arrivals_individual_include, input[name=prwfr_phrp_no_of_days], input[name=prwfr_phrp_desktop_limit], input[name=prwfr_phrp_tab_limit], input[name=prwfr_phrp_mobile_limit]').attr('disabled', 'disabled');
  // --------------------------------------------

  jQuery('.prwfr-browsing-history-switch-div, .prwfr-rvps-remove-all-btn').hide();

  // ===============purchase related===========

  if (!jQuery('.prwfr-buy-again-days-selection').is(':checked')) {
    jQuery("#30_days").attr('checked', 'checked');
  }

  jQuery(".prwfr-buy-again-filter-switch").on('change', function () {

    if (jQuery('.prwfr-buy-again-filter-switch').is(':checked')) {

      jQuery(".prwfr-buy-again-cat-tag-radio").parents('tr').show();
    } else {

      jQuery(".prwfr-buy-again-cat-exc-selection, .prwfr-buy-again-cat-inc-selection, .prwfr-buy-again-tag-exc-selection, .prwfr-buy-again-tag-inc-selection").val('').change();
      jQuery(".prwfr-buy-again-cat-tag-radio, .prwfr-buy-again-tag-inc-exc-selection, .prwfr-buy-again-cat-inc-exc-selection").children().removeAttr('checked');
      jQuery(".prwfr-buy-again-cat-tag-radio, .prwfr-buy-again-category-parent, .prwfr-buy-again-tag-parent").parents('tr').hide();

    }
  })

  if (jQuery('.prwfr-buy-again-filter-switch').is(':checked')) {
    jQuery(".prwfr-buy-again-cat-tag-radio").parents('tr').show();
  } else {
    jQuery(".prwfr-buy-again-cat-exc-selection, .prwfr-buy-again-cat-inc-selection, .prwfr-buy-again-tag-exc-selection, .prwfr-buy-again-tag-inc-selection").val('').change();
    jQuery(".prwfr-buy-again-cat-tag-radio, .prwfr-buy-again-tag-inc-exc-selection, .prwfr-buy-again-cat-inc-exc-selection").children().removeAttr('checked');
    jQuery(".prwfr-buy-again-cat-tag-radio, .prwfr-buy-again-category-parent, .prwfr-buy-again-tag-parent").parents('tr').hide();
  }

  jQuery('.prwfr-buy-again-select-cat-tag').change(function () {
    jQuery(".prwfr-buy-again-cat-exc-selection, .prwfr-buy-again-cat-inc-selection, .prwfr-buy-again-tag-exc-selection, .prwfr-buy-again-tag-inc-selection").val('').change();
    jQuery('.prwfr-buy-again-tag-inc-exc-selection, .prwfr-buy-again-cat-inc-exc-selection').children().removeAttr('checked');
    var buyAgainSelectCatTag = jQuery(this).val();

    if (buyAgainSelectCatTag == 'tag') {
      jQuery(".prwfr-buy-again-cat-inc-exc-radio, .prwfr-buy-again-category-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-inc-exc-radio").parents('tr').show();

    } else if (buyAgainSelectCatTag == 'cat') {
      jQuery(".prwfr-buy-again-tag-inc-exc-radio, .prwfr-buy-again-tag-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-cat-inc-exc-radio").parents('tr').show();

    } else if (buyAgainSelectCatTag == 'both') {
      jQuery(".prwfr-buy-again-category-parent, .prwfr-buy-again-tag-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-inc-exc-radio, .prwfr-buy-again-cat-inc-exc-radio").parents('tr').show();

    }

  })

  if (jQuery('.prwfr-buy-again-select-cat-tag').is(':checked')) {
    var buyAgainSelectCatTag = jQuery('.prwfr-buy-again-select-cat-tag:checked').val();
    if (buyAgainSelectCatTag == 'tag') {
      jQuery(".prwfr-buy-again-cat-inc-exc-radio, .prwfr-buy-again-category-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-inc-exc-radio").parents('tr').show();

    } else if (buyAgainSelectCatTag == 'cat') {
      jQuery(".prwfr-buy-again-tag-inc-exc-radio, .prwfr-buy-again-tag-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-cat-inc-exc-radio").parents('tr').show();

    } else if (buyAgainSelectCatTag == 'both') {
      jQuery(".prwfr-buy-again-category-parent, .prwfr-buy-again-tag-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-inc-exc-radio, .prwfr-buy-again-cat-inc-exc-radio").parents('tr').show();

    }
  }

  jQuery('.prwfr-buy-again-cat-inc-exc-radio').change(function () {
    var selectCat = jQuery(this).val();
    jQuery(".prwfr-buy-again-cat-exc-selection, .prwfr-buy-again-cat-inc-selection").val('').change();
    if (selectCat == '0') {
      jQuery(".prwfr-buy-again-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-cat-exc-parent").parents('tr').show();
    } else if (selectCat == '1') {
      jQuery(".prwfr-buy-again-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-cat-inc-parent").parents('tr').show();
    }
  })

  if (jQuery('.prwfr-buy-again-cat-inc-exc-radio').is(':checked')) {
    var selectCat = jQuery('.prwfr-buy-again-cat-inc-exc-radio:checked').val();
    if (selectCat == '0') {
      jQuery(".prwfr-buy-again-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-cat-exc-parent").parents('tr').show();
    } else if (selectCat == '1') {
      jQuery(".prwfr-buy-again-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-cat-inc-parent").parents('tr').show();
    }
  }

  jQuery('.prwfr-buy-again-tag-inc-exc-radio').change(function () {
    var selectTag = jQuery(this).val();
    jQuery(".prwfr-buy-again-tag-exc-selection, .prwfr-buy-again-tag-inc-selection").val('').change();
    if (selectTag == '0') {
      jQuery(".prwfr-buy-again-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-exc-parent").parents('tr').show();
    } else if (selectTag == '1') {
      jQuery(".prwfr-buy-again-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-inc-parent").parents('tr').show();
    }
  })

  if (jQuery('.prwfr-buy-again-tag-inc-exc-radio').is(':checked')) {
    var selectTag = jQuery('.prwfr-buy-again-tag-inc-exc-radio:checked').val();
    if (selectTag == '0') {
      jQuery(".prwfr-buy-again-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-exc-parent").parents('tr').show();
    } else if (selectTag == '1') {
      jQuery(".prwfr-buy-again-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-buy-again-tag-inc-parent").parents('tr').show();
    }
  }

  jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').hide();
  jQuery('.prwfr-buy-again-back-shortcode-text').hide();

  jQuery('.prwfr-buy-again-see-more-option').change(function () {
    var buyAgainSeeMore = jQuery(this).val();
    if (buyAgainSeeMore == 'new') {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-buy-again-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-buy-again-back-shortcode-text').hide();
      jQuery('.prwfr-buy-again-redirect-page-selection').val(' ').change();
    }
  })

  if (jQuery('.prwfr-buy-again-see-more-option').is(':checked')) {
    var buyAgainSeeMore = jQuery('.prwfr-buy-again-see-more-option:checked').val();
    if (buyAgainSeeMore == 'new') {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-buy-again-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-buy-again-back-shortcode-text').hide();

      jQuery('.prwfr-buy-again-redirect-page-selection').val(' ').change();
    }
  }

  //4. buy again
  jQuery(".prwfr-phrp-submit-btn .button-primary").click(function (e) {

    var categorySelected = 0;
    var tagSelected = 0;
    if (jQuery(".prwfr-buy-again-filter-switch").is(':checked')) {

      if (((jQuery("select").hasClass("prwfr-buy-again-cat-inc-selection")) && (jQuery("select").hasClass("prwfr-buy-again-cat-exc-selection")))) {
        var includeCategory = jQuery(".prwfr-buy-again-cat-inc-selection").val().length;
        var excludeCategory = jQuery(".prwfr-buy-again-cat-exc-selection").val().length;
        if (includeCategory || excludeCategory) {
          categorySelected = 1;
        }
      }

      if (((jQuery("select").hasClass("prwfr-buy-again-tag-inc-selection")) && (jQuery("select").hasClass("prwfr-buy-again-tag-exc-selection")))) {
        var excludeTag = jQuery(".prwfr-buy-again-tag-exc-selection").val().length;
        var includeTag = jQuery(".prwfr-buy-again-tag-inc-selection").val().length;
        if (excludeTag || includeTag) {
          tagSelected = 1;
        }
      }

      if (!(categorySelected || tagSelected)) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: "Error",
          html: prwfr_ajax_obj.cat_tag_save_msg,
          confirmButtonText: "Ok",
        });
      }
    }

    if (jQuery('.prwfr-buy-again-see-more-option:checked').val() == 'new') {
      if (!parseInt(jQuery('.prwfr-buy-again-redirect-page-selection').val())) {
        e.preventDefault();

        Swal.fire({
          icon: 'error',
          title: "Error",
          html: prwfr_ajax_obj.buy_again_page_select,
          confirmButtonText: "Ok",
        });
      }
    }

  })

  // Do nothing.
  jQuery(".prwfr-buy-again-clipboard-button").click(function (e) {
    e.preventDefault();
  });

  jQuery(".prwfr-buy-again-front-clipboard-button").click(function (e) {
    e.preventDefault();
  });
  // END

  //phrp - purchase history related setting page

  jQuery(".prwfr-phrp-filter-switch").on('change', function () {

    if (jQuery('.prwfr-phrp-filter-switch').is(':checked')) {

      jQuery(".prwfr-phrp-cat-tag-radio").parents('tr').show();
    } else {

      jQuery('.prwfr-phrp-cat-exc-selection, .prwfr-phrp-cat-inc-selection, .prwfr-phrp-tag-inc-selection, .prwfr-phrp-tag-exc-selection').val('').change();
      jQuery(".prwfr-phrp-cat-tag-radio, .prwfr-phrp-tag-inc-exc-radio").children().removeAttr('checked');
      jQuery(".prwfr-phrp-cat-tag-radio, .prwfr-phrp-category-parent, .prwfr-phrp-tag-parent").parents('tr').hide();

    }
  })

  if (jQuery('.prwfr-phrp-filter-switch').is(':checked')) {
    jQuery(".prwfr-phrp-cat-tag-radio").parents('tr').show();
  } else {
    jQuery(".prwfr-phrp-cat-exc-selection, .prwfr-phrp-cat-inc-selection, .prwfr-phrp-tag-exc-selection, .prwfr-phrp-tag-inc-selection").val('').change();
    jQuery(".prwfr-phrp-cat-tag-radio, .prwfr-phrp-cat-inc-exc-selection, .prwfr-phrp-tag-inc-exc-selection, .prwfr-phrp-select-tag-inc-exc-radio").children().removeAttr('checked');
    jQuery(".prwfr-phrp-cat-tag-radio, .prwfr-phrp-category-parent, .prwfr-phrp-tag-parent").parents('tr').hide();

  }

  jQuery('.prwfr-phrp-select-cat-tag').change(function () {
    var selectCatTag = jQuery(this).val();
    jQuery(".prwfr-phrp-tag-inc-exc-selection, .prwfr-phrp-cat-inc-exc-selection").children().removeAttr('checked');
    if (selectCatTag == 'tag') {
      jQuery(".prwfr-phrp-category-parent, .prwfr-phrp-tag-exc-parent, .prwfr-phrp-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-select-tag-inc-exc-radio").parents('tr').show();

    } else if (selectCatTag == 'cat') {
      jQuery(".prwfr-phrp-tag-parent, .prwfr-phrp-cat-exc-parent, .prwfr-phrp-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-inc-exc-radio").parents('tr').show();

    } else if (selectCatTag == 'both') {
      jQuery(".prwfr-phrp-tag-parent, .prwfr-phrp-cat-exc-parent, .prwfr-phrp-cat-inc-parent, .prwfr-phrp-category-parent, .prwfr-phrp-tag-exc-parent, .prwfr-phrp-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-inc-exc-radio, .prwfr-phrp-select-tag-inc-exc-radio").parents('tr').show();

    }

  })

  if (jQuery('.prwfr-phrp-select-cat-tag').is(':checked')) {
    var selectCatTag = jQuery('.prwfr-phrp-select-cat-tag:checked').val();
    if (selectCatTag == 'tag') {
      jQuery(".prwfr-phrp-category-parent, .prwfr-phrp-tag-exc-parent, .prwfr-phrp-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-select-tag-inc-exc-radio").parents('tr').show();

    } else if (selectCatTag == 'cat') {
      jQuery(".prwfr-phrp-tag-parent, .prwfr-phrp-cat-exc-parent, .prwfr-phrp-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-inc-exc-radio").parents('tr').show();

    } else if (selectCatTag == 'both') {
      jQuery(".prwfr-phrp-tag-parent, .prwfr-phrp-cat-exc-parent, .prwfr-phrp-cat-inc-parent, .prwfr-phrp-category-parent, .prwfr-phrp-tag-exc-parent, .prwfr-phrp-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-inc-exc-radio, .prwfr-phrp-select-tag-inc-exc-radio").parents('tr').show();

    }
  }

  jQuery('.prwfr-phrp-cat-inc-exc-radio').change(function () {
    var selectCat = jQuery(this).val();
    jQuery(".prwfr-phrp-cat-exc-selection, .prwfr-phrp-cat-inc-selection").val('').change();
    if (selectCat == '0') {
      jQuery(".prwfr-phrp-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-exc-parent").parents('tr').show();
    } else if (selectCat == '1') {
      jQuery(".prwfr-phrp-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-inc-parent").parents('tr').show();
    }
  })

  if (jQuery('.prwfr-phrp-cat-inc-exc-radio').is(':checked')) {
    var selectCat = jQuery('.prwfr-phrp-cat-inc-exc-radio:checked').val();
    if (selectCat == '0') {
      jQuery(".prwfr-phrp-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-exc-parent").parents('tr').show();
    } else if (selectCat == '1') {
      jQuery(".prwfr-phrp-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-cat-inc-parent").parents('tr').show();
    }
  }

  jQuery('.prwfr-phrp-select-tag-inc-exc-radio').change(function () {
    var selectTag = jQuery(this).val();
    jQuery(".prwfr-phrp-tag-exc-selection, .prwfr-phrp-tag-inc-selection").val('').change();
    if (selectTag == '0') {
      jQuery(".prwfr-phrp-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-tag-exc-parent").parents('tr').show();
    } else if (selectTag == '1') {
      jQuery(".prwfr-phrp-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-tag-inc-parent").parents('tr').show();
    }
  })

  if (jQuery('.prwfr-phrp-select-tag-inc-exc-radio').is(':checked')) {
    var selectTag = jQuery('.prwfr-phrp-select-tag-inc-exc-radio:checked').val();
    if (selectTag == '0') {
      jQuery(".prwfr-phrp-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-tag-exc-parent").parents('tr').show();
    } else if (selectTag == '1') {
      jQuery(".prwfr-phrp-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-phrp-tag-inc-parent").parents('tr').show();
    }
  }

  //purchase related products radio button
  jQuery('.prwfr-phrp-redirect-page-selection').parents('tr').hide();
  jQuery('.prwfr-phrp-back-shortcode-text').hide();

  jQuery('.prwfr-phrp-see-more-option').change(function () {
    var phrpSeeMore = jQuery(this).val();
    if (phrpSeeMore == 'new') {
      jQuery('.prwfr-phrp-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-phrp-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-phrp-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-phrp-back-shortcode-text').hide();
      jQuery('.prwfr-phrp-redirect-page-selection').val(' ').change();
    }
  })

  if (jQuery('.prwfr-phrp-see-more-option').is(':checked')) {
    var phrpSeeMore = jQuery('.prwfr-phrp-see-more-option:checked').val();
    if (phrpSeeMore == 'new') {
      jQuery('.prwfr-phrp-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-phrp-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-phrp-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-phrp-back-shortcode-text').hide();
      jQuery('.prwfr-phrp-redirect-page-selection').val(' ').change();
    }
  }

  jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').hide();
  jQuery('.prwfr-buy-again-back-shortcode-text').hide();

  jQuery('.prwfr-buy-again-see-more-option').change(function () {
    var buyAgainSeeMore = jQuery(this).val();
    if (buyAgainSeeMore == 'new') {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-buy-again-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-buy-again-back-shortcode-text').hide();
      jQuery('.prwfr-buy-again-redirect-page-selection').val(' ').change();
    }
  })

  if (jQuery('.prwfr-buy-again-see-more-option').is(':checked')) {
    var buyAgainSeeMore = jQuery('.prwfr-buy-again-see-more-option:checked').val();
    if (buyAgainSeeMore == 'new') {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-buy-again-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-buy-again-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-buy-again-back-shortcode-text').hide();

      jQuery('.prwfr-buy-again-redirect-page-selection').val(' ').change();
    }
  }

  //3. phrp

  jQuery(".prwfr-phrp-submit-btn .button-primary").click(function (e) {

    var categorySelected = 0;
    var tagSelected = 0;
    if (jQuery(".prwfr-phrp-filter-switch").is(':checked')) {

      if (((jQuery("select").hasClass("prwfr-phrp-cat-inc-selection")) && (jQuery("select").hasClass("prwfr-phrp-cat-exc-selection")))) {
        var includeCategory = jQuery(".prwfr-phrp-cat-inc-selection").val().length;
        var excludeCategory = jQuery(".prwfr-phrp-cat-exc-selection").val().length;
        if (includeCategory || excludeCategory) {
          categorySelected = 1;
        }
      }

      if (((jQuery("select").hasClass("prwfr-phrp-tag-exc-selection")) && (jQuery("select").hasClass("prwfr-phrp-tag-inc-selection")))) {
        var excludeTag = jQuery(".prwfr-phrp-tag-exc-selection").val().length;
        var includeTag = jQuery(".prwfr-phrp-tag-inc-selection").val().length;
        if (excludeTag || includeTag) {
          tagSelected = 1;
        }
      }

      if (!(categorySelected || tagSelected)) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: "Error",
          html: prwfr_ajax_obj.cat_tag_save_msg,
          confirmButtonText: "Ok",
        });
      }
    }

    //phrp products select page
    if (jQuery('.prwfr-phrp-see-more-option:checked').val() == 'new') {
      if (!parseInt(jQuery('.prwfr-phrp-redirect-page-selection').val())) {
        e.preventDefault();

        Swal.fire({
          icon: 'error',
          title: "Error",
          html: prwfr_ajax_obj.purchase_related_page_select,
          confirmButtonText: "Ok",
        });
      }
    }
  })

  // ==============================================================

  jQuery('.prwfr-manage-history').click(function () {
    jQuery('.prwfr-browsing-history-switch-div, .prwfr-rvps-remove-all-btn').toggle();
  });

  jQuery('.prwfr-browsing-history-switch-display').click(function () {

    let browsingHistorySwitch = 0;
    if (jQuery('.prwfr-browsing-history-switch-display').is(':checked')) {
      browsingHistorySwitch = 1;
    }

    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_ajax_slider',
        nonce: prwfr_ajax_action_obj.nonce,
        browsing_history: browsingHistorySwitch,
      },
      success: function (response) {
      }
    })

  })

  jQuery(".prwfr-rvps-remove-all-btn").click(function (e) {

    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_ajax_slider',
        nonce: prwfr_ajax_action_obj.nonce,
        remove_all_products_btn: 1,
      },
      success: function (response) {
        location.reload();
      }
    })
  })


  // ==============================================
  jQuery('.prwfr-rvps-filter-switch').change(function () {

    if (jQuery('.prwfr-rvps-filter-switch').is(':checked')) {
      jQuery(".prwfr-rvps-cat-tag-radio").parents('tr').show();
    } else {
      jQuery(".prwfr-rvps-cat-inc-select, .prwfr-rvps-cat-exc-select, .prwfr-rvps-tag-exc-select, .prwfr-rvps-tag-inc-select").val('').change();
      jQuery(".prwfr-rvps-cat-tag-radio, .prwfr-rvps-cat-inc-exc-selection, .prwfr-rvps-tag-inc-exc-selection").children().removeAttr('checked');
      jQuery(".prwfr-rvps-cat-tag-radio, .prwfr-rvps-category-parent, .prwfr-rvps-tag-parent").parents('tr').hide();
    }
  })

  //toggle switch which hides all the fields under it if not checked and on being checked displays only radio button field

  if (jQuery('.prwfr-rvps-filter-switch').is(':checked')) {

    jQuery(".prwfr-rvps-cat-tag-radio").parents('tr').show();

  } else {

    jQuery(".prwfr-rvps-cat-inc-select, .prwfr-rvps-cat-exc-select, .prwfr-rvps-tag-exc-select, .prwfr-rvps-tag-inc-select").val('').change();
    jQuery(".prwfr-rvps-cat-tag-radio, .prwfr-rvps-cat-inc-exc-selection, .prwfr-rvps-tag-inc-exc-selection").children().removeAttr('checked');
    jQuery(".prwfr-rvps-cat-tag-radio, .prwfr-rvps-category-parent, .prwfr-rvps-tag-parent").parents('tr').hide();
  }



  // //on change of radio button to select category, tag or both

  jQuery('.prwfr-rvps-select-cat-tag').change(function () {

    jQuery(".prwfr-rvps-cat-exc-select, .prwfr-rvps-cat-inc-select, .prwfr-rvps-tag-exc-select, .prwfr-rvps-tag-inc-select").val('').change();
    jQuery('.prwfr-rvps-cat-inc-exc-selection, .prwfr-rvps-tag-inc-exc-selection').children().removeAttr('checked');
    var rvpSelectCatTag = jQuery(this).val();

    if (rvpSelectCatTag == 'tag') {
      jQuery(".prwfr-rvps-cat-inc-exc-radio, .prwfr-rvps-category-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-inc-exc-radio").parents('tr').show();

    } else if (rvpSelectCatTag == 'cat') {
      jQuery(".prwfr-rvps-tag-inc-exc-radio, .prwfr-rvps-tag-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-cat-inc-exc-radio").parents('tr').show();

    } else if (rvpSelectCatTag == 'both') {
      jQuery(".prwfr-rvps-category-parent, .prwfr-rvps-tag-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-inc-exc-radio, .prwfr-rvps-cat-inc-exc-radio").parents('tr').show();

    }

  })

  // // //if radio button is already checked prwfr-rvps-cat-inc-exc-selection prwfr-rvps-tag-inc-exc-selection

  if (jQuery('.prwfr-rvps-select-cat-tag').is(':checked')) {

    var rvpSelectCatTag = jQuery('.prwfr-rvps-select-cat-tag:checked').val();

    if (rvpSelectCatTag == 'tag') {
      jQuery(".prwfr-rvps-cat-inc-exc-radio, .prwfr-rvps-category-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-inc-exc-radio").parents('tr').show();

    } else if (rvpSelectCatTag == 'cat') {
      jQuery(".prwfr-rvps-tag-inc-exc-radio, .prwfr-rvps-tag-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-cat-inc-exc-radio").parents('tr').show();

    } else if (rvpSelectCatTag == 'both') {
      jQuery(".prwfr-rvps-category-parent, .prwfr-rvps-tag-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-inc-exc-radio, .prwfr-rvps-cat-inc-exc-radio").parents('tr').show();

    }
  }

  // //radio button category exclude include on change
  jQuery('input[name=prwfr_rvps_cat_inc_exc_radio]').change(function () {
    var rvpSelectCat = jQuery(this).val();

    if (rvpSelectCat == '0') {
      jQuery(".prwfr-rvps-cat-inc-select").val('').change();
      jQuery(".prwfr-rvps-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-cat-exc-parent").parents('tr').show();
    } else if (rvpSelectCat == '1') {
      jQuery(".prwfr-rvps-cat-exc-select").val('').change();
      jQuery(".prwfr-rvps-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-cat-inc-parent").parents('tr').show();
    }
  });

  // //radio button category exclude include is checked
  if (jQuery('.prwfr-rvps-cat-inc-exc-radio').is(':checked')) {
    var rvpSelectCat = jQuery('.prwfr-rvps-cat-inc-exc-radio:checked').val();
    if (rvpSelectCat == '0') {
      jQuery(".prwfr-rvps-cat-inc-select").val('').change();
      jQuery(".prwfr-rvps-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-cat-exc-parent").parents('tr').show();
    } else if (rvpSelectCat == '1') {
      jQuery(".prwfr-rvps-cat-exc-select").val('').change();
      jQuery(".prwfr-rvps-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-cat-inc-parent").parents('tr').show();
    }
  }

  // // //radio button tag exclude include on change
  jQuery('input[name=prwfr_rvps_tag_inc_exc_radio]').change(function () {
    var rvpSelectTag = jQuery(this).val();

    if (rvpSelectTag == '0') {
      jQuery(".prwfr-rvps-tag-inc-select").val('').change();
      jQuery(".prwfr-rvps-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-exc-parent").parents('tr').show();
    } else if (rvpSelectTag == '1') {
      jQuery('.prwfr-rvps-tag-exc-select').val('').change();
      jQuery(".prwfr-rvps-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-inc-parent").parents('tr').show();
    }
  });

  // radio button tag exclude include is checked
  if (jQuery('.prwfr-rvps-tag-inc-exc-radio').is(':checked')) {
    var rvpSelectTag = jQuery('.prwfr-rvps-tag-inc-exc-radio:checked').val();

    if (rvpSelectTag == '0') {
      jQuery(".prwfr-rvps-tag-inc-select").val('').change();
      jQuery(".prwfr-rvps-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-exc-parent").parents('tr').show();
    } else if (rvpSelectTag == '1') {
      jQuery('.prwfr-rvps-tag-exc-select').val('').change();
      jQuery(".prwfr-rvps-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-rvps-tag-inc-parent").parents('tr').show();
    }
  }

  // ========================================
  //radio button rvps
  jQuery('.prwfr-rvps-redirect-page-parent').parents('tr').hide();
  jQuery('.prwfr-rvps-back-shortcode-text').hide();

  jQuery('.prwfr-rvps-see-more-redirect-option').change(function () {
    var rvpSeeMore = jQuery(this).val();
    if (rvpSeeMore == 'new') {
      jQuery('.prwfr-rvps-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-rvps-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-rvps-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-rvps-back-shortcode-text').hide();
      jQuery('.prwfr-rvps-redirect-page-selection').val('').change();

    }
  })

  if (jQuery('.prwfr-rvps-see-more-redirect-option').is(':checked')) {
    var rvpSeeMore = jQuery('.prwfr-rvps-see-more-redirect-option:checked').val();
    if (rvpSeeMore == 'new') {
      jQuery('.prwfr-rvps-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-rvps-back-shortcode-text').show();
    } else {
      jQuery('.prwfr-rvps-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-rvps-back-shortcode-text').hide();
    }
  }

  //rvps onsale radio button
  jQuery('.prwfr-rvps-onsale-redirect-page-parent').parents('tr').hide();
  jQuery('.prwfr-rvps-onsale-back-shortcode-text').hide();

  jQuery('.prwfr-rvps-onsale-see-more-option').change(function () {
    var rvpOnsaleSeeMore = jQuery(this).val();
    if (rvpOnsaleSeeMore == 'new') {
      jQuery('.prwfr-rvps-onsale-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-rvps-onsale-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-rvps-onsale-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-rvps-onsale-back-shortcode-text').hide();
      jQuery('.prwfr-rvps-onsale-redirect-page-selection').val(' ').change();
    }
  })

  if (jQuery('.prwfr-rvps-onsale-see-more-option').is(':checked')) {
    var rvpOnsaleSeeMore = jQuery('.prwfr-rvps-onsale-see-more-option:checked').val();
    if (rvpOnsaleSeeMore == 'new') {
      jQuery('.prwfr-rvps-onsale-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-rvps-onsale-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-rvps-onsale-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-rvps-onsale-back-shortcode-text').hide();
    }
  }

  //hide title

  if ((jQuery('.prwfr-rvps-parent-front-container').attr('data-array')) === undefined) {
    jQuery(".prwfr-viewed-related-front-title, .prwfr-rvps-onsale-front-title").hide();
    jQuery(".prwfr-rvps-onsale-parent-front-container").parents(".prwfr-product-list-wrap").hide();
    jQuery(".prwfr-viewed-related-parent-front-container").parents(".prwfr-product-list-wrap").hide();
  }

  if ((jQuery('.prwfr-cookie-rvps-parent-front-container').attr('data-array')) === undefined) {
    jQuery(".prwfr-cookie-viewed-related-front-title, .prwfr-cookie-rvps-onsale-front-title").hide();
    jQuery(".prwfr-cookie-rvps-onsale-parent-front-container").parents(".prwfr-product-list-wrap").hide();
    jQuery(".prwfr-cookie-viewed-related-parent-front-container").parents(".prwfr-product-list-wrap").hide();

  }

  jQuery(".prwfr-rvp-onsale-front-clipboard-button").click(function (e) {
    e.preventDefault();
    let clipboardText = "[prwfr_onsale_recently_viewed_products_front]";
    navigator.clipboard.writeText(clipboardText);
    Swal.fire({
      text: 'Shortcode Copied',
      width: 300,
      heightAuto: false,
      icon: 'success',
    })
  });

  jQuery(".prwfr-viewed-related-front-clipboard-button").click(function (e) {
    e.preventDefault();
    let clipboardText = "[prwfr_related_recently_viewed_products_front]";
    navigator.clipboard.writeText(clipboardText);
    Swal.fire({
      text: 'Shortcode Copied',
      width: 300,
      heightAuto: false,
      icon: 'success',
    })
  });

  jQuery(".prwfr-rvps-front-clipboard-button").click(function (e) {
    e.preventDefault();
    let clipboardText = "[prwfr_recently_viewed_products_front]";
    navigator.clipboard.writeText(clipboardText);
    Swal.fire({
      text: 'Shortcode Copied',
      width: 300,
      heightAuto: false,
      icon: 'success',
    })
  });

  jQuery(".prwfr-back-button").click(function (e) {

    let featureName = jQuery(this).parent().next().attr('data-name');
    backBtnProductsDisplay(featureName);

  });

  jQuery(".prwfr-next-button").click(function (e) {
    let featureName = jQuery(this).parent().prev().attr('data-name');
    nextBtnProductsDisplay(featureName);

  });

  jQuery(".prwfr-start-over").click(function (e) {
    let featureName = jQuery(this).attr('data-name');
    startOverProductsDisplay(featureName);

  });

  function backBtnProductsDisplay(featureName) {

    var productsArray = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-array');
    var featureName = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-name');
    var pageCount = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count');
    var pageNos = parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-pages'));
    var pageCountBackBtn = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count_back');
    var sliderProductsLimit = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-limit');
    sliderProductsLimit = parseInt(sliderProductsLimit);
    var startIndex = parseInt(jQuery('.prwfr-' + featureName + '-product-container:first-child').attr('data-index'));

    if (parseInt(pageCount) > 2) {
      jQuery('.prwfr-' + featureName + '-start-over').show();
    } else {
      jQuery('.prwfr-' + featureName + '-start-over').hide();
    }

    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_ajax_slider',
        nonce: prwfr_ajax_action_obj.nonce,
        slider_back_btn: 1,
        starting_index: startIndex,
        products_array: productsArray,
        feature_name: featureName,
        slider_products_limit: sliderProductsLimit,
        page_count: parseInt(pageCount) - 1,
        page_count_back: parseInt(pageCountBackBtn) + 1,
      },
      success: function (response) {

        if (parseInt(pageCount) === 1) {
          jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count', pageNos);
          jQuery('.prwfr-' + featureName + '-start-over').show();
        } else {
          jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count', parseInt(pageCount) - 1);
        }

        jQuery('.prwfr-' + featureName + '-parent-front-container').empty().html(response);

        if (jQuery('.prwfr-' + featureName + '-parent-front-container').length) {
          jQuery('.prwfr-' + featureName + '-loader, .prwfr-' + featureName + '-product-title-loader').show();
          setTimeout(loaderFuncHide, 250, featureName);
        }

        jQuery('.prwfr-' + featureName + '-page-display').html('Page ' + parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count')) + ' of ' + parseInt(pageNos));

      }
    })

  }

  function nextBtnProductsDisplay(featureName) {

    var productsArray = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-array');
    var featureName = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-name');
    var pageCount = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count');
    var pageNos = parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-pages'));

    var sliderProductsLimit = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-limit');
    sliderProductsLimit = parseInt(sliderProductsLimit);
    var endIndex = parseInt(jQuery('.prwfr-' + featureName + '-product-container:nth-child(' + sliderProductsLimit + ')').attr('data-index'));

    if (parseInt(pageCount) > 0 && parseInt(pageCount) != parseInt(pageNos)) {
      jQuery('.prwfr-' + featureName + '-start-over').show();
    }

    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_ajax_slider',
        nonce: prwfr_ajax_action_obj.nonce,
        slider_next_btn: 1,
        starting_index: endIndex,
        products_array: productsArray,
        feature_name: featureName,
        slider_products_limit: sliderProductsLimit,
        page_nos: pageNos,
        page_count: parseInt(pageCount) + 1,
      },
      success: function (response) {

        if (parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count')) == parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-pages'))) {
          jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count', 1);
        } else {
          jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count', parseInt(pageCount) + 1);
        }

        jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count_back', "0");
        jQuery('.prwfr-' + featureName + '-parent-front-container').empty().html(response);
        if (jQuery('.prwfr-' + featureName + '-parent-front-container').length) {
          jQuery('.prwfr-' + featureName + '-loader, .prwfr-' + featureName + '-product-title-loader').show();
          setTimeout(loaderFuncHide, 250, featureName);
        }

        jQuery('.prwfr-' + featureName + '-page-display').html('Page ' + parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count')) + ' of ' + parseInt(pageNos));

        if (parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count')) == 1) {
          jQuery('.prwfr-' + featureName + '-start-over').hide();
        }

      }
    })

  }

  function startOverProductsDisplay(featureName) {

    var productsArray = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-array');
    var featureName = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-name');
    var pageNos = parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-pages'));
    var sliderProductsLimit = jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-limit');
    sliderProductsLimit = parseInt(sliderProductsLimit);

    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_ajax_slider',
        nonce: prwfr_ajax_action_obj.nonce,
        slider_start_over_btn: 1,
        products_array: productsArray,
        feature_name: featureName,
        slider_products_limit: sliderProductsLimit,
      },
      success: function (response) {
        jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count_back', "0");
        jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count', "1");
        jQuery('.prwfr-' + featureName + '-parent-front-container').empty().html(response);

        if (jQuery('.prwfr-' + featureName + '-parent-front-container').length) {
          jQuery('.prwfr-' + featureName + '-loader, .prwfr-' + featureName + '-product-title-loader').show();
          setTimeout(loaderFuncHide, 250, featureName);
        }
        jQuery('.prwfr-' + featureName + '-page-display').html('Page ' + parseInt(jQuery('.prwfr-' + featureName + '-parent-front-container').attr('data-page_count')) + ' of ' + parseInt(pageNos));
        jQuery('.prwfr-' + featureName + '-start-over').hide();
      }
    })

  }


  function loaderFuncHide(featureName) {

    jQuery('.prwfr-' + featureName + '-loader, .prwfr-' + featureName + '-product-title-loader').hide();

  }

  jQuery( '#prwfr_gdpr_no_thanks' ).click( function(){
    var emailAddress = jQuery('#billing_email').val(); // Get the current value of the field
  
    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_gdpr_permission',
        gdpr_no_thanks: 1,
        email_address: emailAddress,
        prwfr_nonce: prwfr_ajax_action_obj.nonce,
      },
      success: function (response) {
        jQuery( '.prwfr-gdpr-no-thanks-email' ).empty().html( 'You won\'t receive further emails from us, thank you!' );
        setTimeout(function() {
          jQuery( '.prwfr-gdpr-no-thanks-email' ).empty();
        }, 3000); // 2000 milliseconds = 2 seconds
        
      },
    });
  })

  //radio button view related
  jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').hide();
  jQuery('.prwfr-viewed-related-back-shortcode-text').hide();

  jQuery('.prwfr-viewed-related-see-more-option').change(function () {
    var rvpRelatedSeeMore = jQuery(this).val();
    if (rvpRelatedSeeMore == 'new') {
      jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-viewed-related-back-shortcode-text').show();
    } else {
      jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-viewed-related-back-shortcode-text').hide();
      jQuery('.prwfr-viewed-related-redirect-page-selection').val('').change();
    }
  })

  if (jQuery('.prwfr-viewed-related-see-more-option').is(':checked')) {
    var rvpRelatedSeeMore = jQuery('.prwfr-viewed-related-see-more-option:checked').val();
    if (rvpRelatedSeeMore == 'new') {
      jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-viewed-related-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-viewed-related-back-shortcode-text').hide();

    }
  }

  //radio button view related
  jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').hide();
  jQuery('.prwfr-viewed-related-back-shortcode-text').hide();

  jQuery('.prwfr-viewed-related-see-more-option').change(function () {
    var rvpRelatedSeeMore = jQuery(this).val();
    if (rvpRelatedSeeMore == 'new') {
      jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').show();
      jQuery('.prwfr-viewed-related-back-shortcode-text').show();
    } else {
      jQuery('.prwfr-viewed-related-redirect-page-parent').parents('tr').hide();
      jQuery('.prwfr-viewed-related-back-shortcode-text').hide();
      jQuery('.prwfr-viewed-related-redirect-page-selection').val('').change();
    }
  })

  // -------------------------- Highlighting Features ------------------------------------
  // Best selling setting page

  if (jQuery(".prwfr-best-seller-product-display-select-radio").is(':checked')) {
    var bsSelectFilter = jQuery(".prwfr-best-seller-product-display-select-radio:checked").val();
    if (bsSelectFilter == 'default') {
      jQuery(".prwfr-best-selling-cat-inc-parent, .prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-single-include").parents('tr').hide();
    } else if (bsSelectFilter == 'categories') {
      jQuery(".prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-single-include").parents('tr').hide();
      jQuery(".prwfr-best-selling-cat-inc-parent").parents('tr').show();
    } else if (bsSelectFilter == 'tags') {
      jQuery(".prwfr-best-selling-cat-inc-parent, .prwfr-best-selling-single-include").parents('tr').hide();
      jQuery(".prwfr-best-selling-tag-inc-parent").parents('tr').show();
    } else if (bsSelectFilter == 'individual') {
      jQuery(".prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-best-selling-single-include").parents('tr').show();
    }
  }

  jQuery(".prwfr-best-seller-product-display-select-radio").change(function () {
    var bsSelectFilter = jQuery(this).val();
    jQuery(".prwfr-best-selling-cat-inc-parent, .prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-single-include").val('').change();
    if (bsSelectFilter == 'default') {
      jQuery(".prwfr-best-selling-cat-inc-parent, .prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-single-include").parents('tr').hide();
    } else if (bsSelectFilter == 'categories') {
      jQuery(".prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-single-include").parents('tr').hide();
      jQuery(".prwfr-best-selling-cat-inc-parent").parents('tr').show();
    } else if (bsSelectFilter == 'tags') {
      jQuery(".prwfr-best-selling-cat-inc-parent, .prwfr-best-selling-single-include").parents('tr').hide();
      jQuery(".prwfr-best-selling-tag-inc-parent").parents('tr').show();
    } else if (bsSelectFilter == 'individual') {
      jQuery(".prwfr-best-selling-tag-inc-parent, .prwfr-best-selling-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-best-selling-single-include").parents('tr').show();
    }
  })

  jQuery('.prwfr-best-selling-see-more-option').parents('tr').hide();
  jQuery('.best-seller-shortcode-text').hide();

  jQuery('.prwfr-best-selling-redirect-page-radio').change(function () {
    var bsSeeMore = jQuery(this).val();
    if (bsSeeMore == 'new') {
      jQuery('.prwfr-best-selling-see-more-option').parents('tr').show();
      jQuery('.best-seller-shortcode-text').show();

    } else {
      jQuery('.prwfr-best-selling-see-more-option').parents('tr').hide();
      jQuery('.best-seller-shortcode-text').hide();
      jQuery('.prwfr-best-selling-see-more-option').val('').change();
    }
  })

  if (jQuery('.prwfr-best-selling-redirect-page-radio').is(':checked')) {
    var bsSeeMore = jQuery('.prwfr-best-selling-redirect-page-radio:checked').val();
    if (bsSeeMore == 'new') {
      jQuery('.prwfr-best-selling-see-more-option').parents('tr').show();
      jQuery('.best-seller-shortcode-text').show();

    } else {
      jQuery('.prwfr-best-selling-see-more-option').parents('tr').hide();
      jQuery('.best-seller-shortcode-text').hide();
      jQuery('.prwfr-best-selling-see-more-option').val('').change();
    }
  }

  //new arrivals setting page
  if (jQuery(".prwfr-new-arrivals-product-display-radio").is(':checked')) {
    var naSelectFilter = jQuery(".prwfr-new-arrivals-product-display-radio:checked").val();
    if (naSelectFilter == 'default') {
      jQuery(".prwfr-new-arrivals-cat-inc-parent, .prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-single-inc-parent").parents('tr').hide();
    } else if (naSelectFilter == 'categories') {
      jQuery(".prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-new-arrivals-cat-inc-parent").parents('tr').show();
    } else if (naSelectFilter == 'tags') {
      jQuery(".prwfr-new-arrivals-cat-inc-parent, .prwfr-new-arrivals-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-new-arrivals-tag-inc-parent").parents('tr').show();
    } else if (naSelectFilter == 'individual') {
      jQuery(".prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-new-arrivals-single-inc-parent").parents('tr').show();
    }
  }

  jQuery(".prwfr-new-arrivals-product-display-radio").change(function () {
    var naSelectFilter = jQuery(this).val();
    jQuery(".prwfr-new-arrivals-cat-inc-parent, .prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-single-inc-parent").val('').change();
    if (naSelectFilter == 'default') {
      jQuery(".prwfr-new-arrivals-cat-inc-parent, .prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-single-inc-parent").parents('tr').hide();
    } else if (naSelectFilter == 'categories') {
      jQuery(".prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-new-arrivals-cat-inc-parent").parents('tr').show();
    } else if (naSelectFilter == 'tags') {
      jQuery(".prwfr-new-arrivals-cat-inc-parent, .prwfr-new-arrivals-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-new-arrivals-tag-inc-parent").parents('tr').show();
    } else if (naSelectFilter == 'individual') {
      jQuery(".prwfr-new-arrivals-tag-inc-parent, .prwfr-new-arrivals-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-new-arrivals-single-inc-parent").parents('tr').show();
    }
  })

  jQuery('.prwfr-new-arrivals-see-more-option').parents('tr').hide();
  jQuery('.prwfr-new-arrivals-shortcode-text').hide();

  jQuery('.prwfr-new-arrivals-redirect-page-radio').change(function () {
    var naSeeMore = jQuery(this).val();
    if (naSeeMore == 'new') {
      jQuery('.prwfr-new-arrivals-see-more-option').parents('tr').show();
      jQuery('.prwfr-new-arrivals-shortcode-text').show();

    } else {
      jQuery('.prwfr-new-arrivals-see-more-option').parents('tr').hide();
      jQuery('.prwfr-new-arrivals-shortcode-text').hide();
      jQuery('.prwfr-new-arrivals-see-more-option').val('').change();
    }
  })

  if (jQuery('.prwfr-new-arrivals-redirect-page-radio').is(':checked')) {
    var naSeeMore = jQuery('.prwfr-new-arrivals-redirect-page-radio:checked').val();
    if (naSeeMore == 'new') {
      jQuery('.prwfr-new-arrivals-see-more-option').parents('tr').show();
      jQuery('.prwfr-new-arrivals-shortcode-text').show();

    } else {
      jQuery('.prwfr-new-arrivals-see-more-option').parents('tr').hide();
      jQuery('.prwfr-new-arrivals-shortcode-text').hide();
      jQuery('.prwfr-new-arrivals-see-more-option').val('').change();
    }
  }

  //featured products
  if (jQuery(".prwfr-featured-display-radio").is(':checked')) {
    var featuredSelectFilter = jQuery(".prwfr-featured-display-radio:checked").val();
    if (featuredSelectFilter == 'default') {
      jQuery(".prwfr-featured-cat-inc-parent, .prwfr-featured-tag-inc-parent, .prwfr-featured-single-inc-parent").parents('tr').hide();
    } else if (featuredSelectFilter == 'categories') {
      jQuery(".prwfr-featured-tag-inc-parent, .prwfr-featured-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-featured-cat-inc-parent").parents('tr').show();
    } else if (featuredSelectFilter == 'tags') {
      jQuery(".prwfr-featured-cat-inc-parent, .prwfr-featured-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-featured-tag-inc-parent").parents('tr').show();
    } else if (featuredSelectFilter == 'individual') {
      jQuery(".prwfr-featured-tag-inc-parent, .prwfr-featured-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-featured-single-inc-parent").parents('tr').show();
    }
  }

  jQuery(".prwfr-featured-display-radio").change(function () {
    var featuredSelectFilter = jQuery(this).val();
    jQuery(".prwfr-featured-cat-inc-parent, .prwfr-featured-tag-inc-parent, .prwfr-featured-single-inc-parent").val('').change();
    if (featuredSelectFilter == 'default') {
      jQuery(".prwfr-featured-cat-inc-parent, .prwfr-featured-tag-inc-parent, .prwfr-featured-single-inc-parent").parents('tr').hide();
    } else if (featuredSelectFilter == 'categories') {
      jQuery(".prwfr-featured-tag-inc-parent, .prwfr-featured-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-featured-cat-inc-parent").parents('tr').show();
    } else if (featuredSelectFilter == 'tags') {
      jQuery(".prwfr-featured-cat-inc-parent, .prwfr-featured-single-inc-parent").parents('tr').hide();
      jQuery(".prwfr-featured-tag-inc-parent").parents('tr').show();
    } else if (featuredSelectFilter == 'individual') {
      jQuery(".prwfr-featured-tag-inc-parent, .prwfr-featured-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-featured-single-inc-parent").parents('tr').show();
    }
  })

  jQuery('.prwfr-featured-see-more-option').parents('tr').hide();
  jQuery('.featured-shortcode-text').hide();

  jQuery('.prwfr-featured-page-redirect-radio').change(function () {
    var featuredSeeMore = jQuery(this).val();
    if (featuredSeeMore == 'new') {
      jQuery('.prwfr-featured-see-more-option').parents('tr').show();
      jQuery('.featured-shortcode-text').show();

    } else {
      jQuery('.prwfr-featured-see-more-option').parents('tr').hide();
      jQuery('.featured-shortcode-text').hide();
      jQuery('.prwfr-featured-see-more-option').val('').change();
    }
  })

  if (jQuery('.prwfr-featured-page-redirect-radio').is(':checked')) {
    var featuredSeeMore = jQuery('.prwfr-featured-page-redirect-radio:checked').val();
    if (featuredSeeMore == 'new') {
      jQuery('.prwfr-featured-see-more-option').parents('tr').show();
      jQuery('.featured-shortcode-text').show();

    } else {
      jQuery('.prwfr-featured-see-more-option').parents('tr').hide();
      jQuery('.featured-shortcode-text').hide();
      jQuery('.prwfr-featured-see-more-option').val('').change();
    }
  }
  // ------------------------------------------------------------

  // ------------------------------- All onsale ------------------------------
  //for all onsale setting page

  //on toggle switch all the fields below it hides
  jQuery(".prwfr-all-onsale-filter-switch").on('change', function () {

    if (jQuery('.prwfr-all-onsale-filter-switch').is(':checked')) {

      jQuery(".prwfr-all-onsale-cat-tag-radio").parents('tr').show();

    } else {
      jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-select, .prwfr-all-onsale-tag-exc-select, .prwfr-all-onsale-tag-inc-select").val('').change();
      jQuery(".prwfr-all-onsale-cat-tag-radio, .prwfr-all-onsale-cat-inc-exc-selection, .prwfr-all-onsale-tag-inc-exc-radio").children().removeAttr('checked');
      jQuery(".prwfr-all-onsale-cat-tag-radio, .prwfr-all-onsale-category-parent, .prwfr-all-onsale-tag-parent").parents('tr').hide();

    }

  })

  //on page refresh toggle is checked or unchecked
  if (jQuery(".prwfr-all-onsale-filter-switch").is(':checked')) {

    if (!jQuery(".prwfr-all-onsale-select-cat-tag").is(':checked')) {

      jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-select, .prwfr-all-onsale-tag-exc-select, .prwfr-all-onsale-tag-inc-select").val('').change();
      jQuery(".prwfr-all-onsale-cat-inc-exc-selection, .prwfr-all-onsale-tag-inc-exc-radio").children().removeAttr('checked');

    }

    jQuery(".prwfr-all-onsale-category-parent, .prwfr-all-onsale-tag-parent").parents('tr').hide();
    jQuery(".prwfr-all-onsale-cat-tag-radio").parents('tr').show();
  } else {

    jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-select, .prwfr-all-onsale-tag-exc-select, .prwfr-all-onsale-tag-inc-select").val('').change();
    jQuery(".prwfr-all-onsale-cat-tag-radio, .prwfr-all-onsale-cat-inc-exc-selection, .prwfr-all-onsale-tag-inc-exc-radio").children().removeAttr('checked');
    jQuery(".prwfr-all-onsale-cat-tag-radio, .prwfr-all-onsale-category-parent, .prwfr-all-onsale-tag-parent").parents('tr').hide();

  }

  //radio button to select category, tag or both
  jQuery(".prwfr-all-onsale-select-cat-tag").on('change', function () {
    jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-select, .prwfr-all-onsale-tag-exc-select, .prwfr-all-onsale-tag-inc-select").val('').change();
    jQuery(".prwfr-all-onsale-cat-inc-exc-selection, .prwfr-all-onsale-tag-inc-exc-radio").children().removeAttr('checked');
    var allOnsaleSelectTerm = jQuery(this).val();
    if (allOnsaleSelectTerm == 'tag') {

      jQuery(".prwfr-all-onsale-tag-parent").parents('tr').show();
      jQuery(".prwfr-all-onsale-category-parent, .prwfr-all-onsale-tag-exc-parent, .prwfr-all-onsale-tag-inc-parent").parents('tr').hide();
    } else if (allOnsaleSelectTerm == 'cat') {

      jQuery(".prwfr-all-onsale-category-parent").parents('tr').show();
      jQuery(".prwfr-all-onsale-tag-parent, .prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-parent").parents('tr').hide();
    } else if (allOnsaleSelectTerm == 'both') {

      jQuery(".prwfr-all-onsale-tag-parent, .prwfr-all-onsale-category-parent").parents('tr').show();
      jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-parent, .prwfr-all-onsale-tag-exc-parent, .prwfr-all-onsale-tag-inc-parent").parents('tr').hide();
    }
  })

  //radio button checked or unchecked on page refresh
  if (jQuery(".prwfr-all-onsale-select-cat-tag").is(':checked')) {

    var allOnsaleSelectTerm = jQuery('.prwfr-all-onsale-select-cat-tag:checked').val();

    if (allOnsaleSelectTerm == 'tag') {

      jQuery(".prwfr-all-onsale-tag-parent").parents('tr').show();
      jQuery(".prwfr-all-onsale-category-parent, .prwfr-all-onsale-tag-exc-parent, .prwfr-all-onsale-tag-inc-parent").parents('tr').hide();
    } else if (allOnsaleSelectTerm == 'cat') {

      jQuery(".prwfr-all-onsale-category-parent").parents('tr').show();
      jQuery(".prwfr-all-onsale-tag-parent, .prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-parent").parents('tr').hide();
    } else if (allOnsaleSelectTerm == 'both') {

      jQuery(".prwfr-all-onsale-tag-parent, .prwfr-all-onsale-category-parent").parents('tr').show();
      jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-parent, .prwfr-all-onsale-tag-exc-parent, .prwfr-all-onsale-tag-inc-parent").parents('tr').hide();
    }
  }

  //on change of category radio button
  jQuery(".prwfr-all-onsale-cat-inc-exc-radio").on('change', function () {
    var allOnsaleSelectCat = jQuery(this).val();

    jQuery(".prwfr-all-onsale-cat-exc-select, .prwfr-all-onsale-cat-inc-select").val('').change();
    if (allOnsaleSelectCat == '1') {
      jQuery(".prwfr-all-onsale-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-cat-inc-parent").parents('tr').show();
    } else if (allOnsaleSelectCat == '0') {
      jQuery(".prwfr-all-onsale-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-cat-exc-parent").parents('tr').show();
    }
  })

  if (jQuery(".prwfr-all-onsale-cat-inc-exc-radio").is(':checked')) {
    var allOnsaleSelectCat = jQuery('.prwfr-all-onsale-cat-inc-exc-radio:checked').val();
    if (allOnsaleSelectCat == '1') {
      jQuery(".prwfr-all-onsale-cat-exc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-cat-inc-parent").parents('tr').show();
    } else if (allOnsaleSelectCat == '0') {
      jQuery(".prwfr-all-onsale-cat-inc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-cat-exc-parent").parents('tr').show();
    }
  }

  //on change of tag radio button
  jQuery(".prwfr-all-onsale-tag-inc-exc-radio").on('change', function () {
    var allOnsaleSelectTag = jQuery(this).val();
    jQuery(".prwfr-all-onsale-tag-exc-select, .prwfr-all-onsale-tag-inc-select").val('').change();
    if (allOnsaleSelectTag == '1') {
      jQuery(".prwfr-all-onsale-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-tag-inc-parent").parents('tr').show();
    } else if (allOnsaleSelectTag == '0') {
      jQuery(".prwfr-all-onsale-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-tag-exc-parent").parents('tr').show();
    }
  })

  if (jQuery(".prwfr-all-onsale-tag-inc-exc-radio").is(':checked')) {
    var allOnsaleSelectTag = jQuery('.prwfr-all-onsale-tag-inc-exc-radio:checked').val();
    if (allOnsaleSelectTag == '1') {
      jQuery(".prwfr-all-onsale-tag-exc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-tag-inc-parent").parents('tr').show();
    } else if (allOnsaleSelectTag == '0') {
      jQuery(".prwfr-all-onsale-tag-inc-parent").parents('tr').hide();
      jQuery(".prwfr-all-onsale-tag-exc-parent").parents('tr').show();
    }
  }



  //all onsale radio button
  jQuery('.prwfr-all-onsale-redirect-page-selection').parents('tr').hide();
  jQuery('.prwfr-all-onsale-back-shortcode-text').hide();

  jQuery('.prwfr-all-onsale-see-more-redirect-radio').change(function () {
    var allOnsaleSeeMore = jQuery(this).val();
    if (allOnsaleSeeMore == 'new') {
      jQuery('.prwfr-all-onsale-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-all-onsale-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-all-onsale-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-all-onsale-back-shortcode-text').hide();
      jQuery('.prwfr-all-onsale-redirect-page-selection').val(' ').change();
    }
  })

  if (jQuery('.prwfr-all-onsale-see-more-redirect-radio').is(':checked')) {
    var allOnsaleSeeMore = jQuery('.prwfr-all-onsale-see-more-redirect-radio:checked').val();
    if (allOnsaleSeeMore == 'new') {
      jQuery('.prwfr-all-onsale-redirect-page-selection').parents('tr').show();
      jQuery('.prwfr-all-onsale-back-shortcode-text').show();

    } else {
      jQuery('.prwfr-all-onsale-redirect-page-selection').parents('tr').hide();
      jQuery('.prwfr-all-onsale-back-shortcode-text').hide();
      jQuery('.prwfr-all-onsale-redirect-page-selection').val(' ').change();
    }
  }
  // ----------------------------------------------------------------------------------

  //re-order button
  jQuery(".reorder").click(function (e) {
    e.preventDefault();
    var reorderBtn = jQuery(this).parents('tr').find(".woocommerce-orders-table__cell-order-number a").text().trim().slice(1);

    reorderBtn = parseInt(reorderBtn);

    jQuery.ajax({
      type: "POST",
      url: prwfr_ajax_action_obj.url,
      data: {
        action: 'prwfr_ajax_slider',
        nonce: prwfr_ajax_action_obj.nonce,
        reorder_action_btn: reorderBtn,
      },
      success: function (response) {

        window.location.href = response;
      }
    })
  });

  jQuery( 'input[name=prwfr_rvp_email_hours_interval], input[name=prwfr_rvp_email_days_interval], input[name=prwfr_rvp_email_time], input[name=prwfr_rvp_email_header_content], .prwfr-email-firstname-placeholder, .prwfr-email-lastname-placeholder, .prwfr-email-username-placeholder').attr( 'disabled', 'disabled' );

  jQuery( 'input[name=prwfr_rvp_email_hours_interval], input[name=prwfr_rvp_email_days_interval]' ).parents('tr').hide();

  jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]').change( function(){
    var recurrenceInterval = jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]:checked').val();

    if( recurrenceInterval == 'days' ){
      jQuery( 'input[name=prwfr_rvp_email_days_interval]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').hide();
    } else if( recurrenceInterval == 'hours' ){
      jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_rvp_email_days_interval]' ).parents('tr').hide();
    }
  })

  // if(jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]').is( ':checked' )){
  //   var recurrenceInterval = jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]:checked').val();
  //   console.log( recurrenceInterval );
  //   if( recurrenceInterval == 'days' ){
  //     jQuery( 'input[name=prwfr_rvp_email_days_interval]' ).parents('tr').show();
  //     jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').hide();
  //   } else if( recurrenceInterval == 'hours' ){
  //     jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').show();
  //     jQuery( 'input[name=prwfr_rvp_email_days_interval]' ).parents('tr').hide();
  //   }
  // };

  jQuery('input[name=prwfr_related_rvp_email_send]').prop('checked', false);

  jQuery( 'select[name=prwfr_rvp_related_everyweek], input[name=prwfr_rvp_related_weekly_time], input[name=prwfr_rvp_related_fortnightly], input[name=prwfr_rvp_related_monthly_day], input[name=prwfr_rvp_related_monthly_time], input[name=prwfr_personalized_recommendations_email_header_content]' ).attr( 'disabled', 'disabled' );

  jQuery( 'select[name=prwfr_rvp_related_everyweek], input[name=prwfr_rvp_related_weekly_time], input[name=prwfr_rvp_related_fortnightly], input[name=prwfr_rvp_related_monthly_day], input[name=prwfr_rvp_related_monthly_time]' ).parents('tr').hide();
  jQuery( 'input[name=prwfr_rvp_related_duration]' ).attr( 'disabled', 'disabled' );

  jQuery( 'input[name=prwfr_related_rvp_email_send]' ).change( function(){
    jQuery( 'select[name=prwfr_rvp_related_everyweek], input[name=prwfr_rvp_related_weekly_time], input[name=prwfr_rvp_related_fortnightly], input[name=prwfr_rvp_related_monthly_day], input[name=prwfr_rvp_related_monthly_time], input[name=prwfr_personalized_recommendations_email_header_content]' ).parents('tr').hide();
    if( jQuery( 'input[name=prwfr_related_rvp_email_send]:checked' ).val() == 1 ){
      jQuery( 'input[name=prwfr_rvp_related_duration]' ).removeAttr( 'disabled' );
    } else {
      jQuery( 'input[name=prwfr_rvp_related_duration]' ).attr( 'disabled', 'disabled' );
    }
  })

  if (window.tinymce) {
    var editor = tinymce.get('prwfr_personalized_recommendations_email_content_text');
  }
  if (editor) {
    editor.setMode('readonly');  
  }

  jQuery( 'input[name=prwfr_rvp_related_duration]' ).change( function(e) {
    jQuery( 'select[name=prwfr_rvp_related_everyweek], input[name=prwfr_rvp_related_weekly_time], input[name=prwfr_rvp_related_fortnightly], input[name=prwfr_rvp_related_monthly_day], input[name=prwfr_rvp_related_monthly_time], input[name=prwfr_personalized_recommendations_email_header_content]' ).parents('tr').hide();
    if( jQuery( 'input[name=prwfr_rvp_related_duration]:checked' ).val() == 7 ){
      jQuery( 'select[name=prwfr_rvp_related_everyweek]' ).parents('tr').show();
    } else if( jQuery( 'input[name=prwfr_rvp_related_duration]:checked' ).val() == 15 ){
      jQuery( 'input[name=prwfr_rvp_related_fortnightly]' ).parents('tr').show();
    } else if( jQuery( 'input[name=prwfr_rvp_related_duration]:checked' ).val() == 30 ){ 
      jQuery( 'input[name=prwfr_rvp_related_monthly_day]' ).parents('tr').show();
    }
  })

  if( jQuery( 'input[name=prwfr_rvp_related_duration]' ).is( ':checked' ) ){
    if( jQuery( 'input[name=prwfr_rvp_related_duration]' ).val() == 7 ){
      jQuery( 'select[name=prwfr_rvp_related_everyweek]' ).parents('tr').show();
    } else if( jQuery( 'input[name=prwfr_rvp_related_duration]' ).val() == 15 ){
      jQuery( 'input[name=prwfr_rvp_related_fortnightly]' ).parents('tr').show();
    } else if( jQuery( 'input[name=prwfr_rvp_related_duration]' ).val() == 30 ){ 
      jQuery( 'input[name=prwfr_rvp_related_monthly_day]' ).parents('tr').show();
    }
  }

  jQuery( 'input[name=prwfr_rvp_email_send]' ).change( function(){
    if (window.tinymce) {
      var editor = tinymce.get('prwfr_rvp_email_content_text');
    }
    if( jQuery( 'input[name=prwfr_rvp_email_send]:checked' ).val() == 1 ){
      if( editor ){
        editor.setMode('design');  
      }
      jQuery('#hours').prop('checked', true);
      jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]' ).removeAttr('disabled');
    }else{
      if( editor ){
        editor.setMode('readonly');
      }
      jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]' ).removeAttr('checked');
      jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').hide();
      jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]' ).attr( 'disabled', 'disabled' )
    }
  })

  if( jQuery( 'input[name=prwfr_rvp_email_send]' ).is( ':checked' )){
    if (window.tinymce) {
      var editor = tinymce.get('prwfr_rvp_email_content_text');
      if (editor) {
        editor.setMode('design');  
      }
    }
    
    jQuery('#hours').prop('checked', true);
    jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]' ).removeAttr('disabled');
    jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').show();

  }else{
    if (window.tinymce) {
      var editor = tinymce.get('prwfr_rvp_email_content_text');
      if (editor) {
        editor.setMode('readonly');
      }
    }
    
    jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').hide();
    jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]' ).removeAttr('checked');
    jQuery( 'input[name=prwfr_rvp_email_recurrence_interval]' ).attr( 'disabled', 'disabled' )
  }

  if(jQuery('input[name="prwfr_rvp_email_recurrence_interval"]').is(':checked')) {
    jQuery('#hours').prop('checked', true);
    jQuery( 'input[name=prwfr_rvp_email_hours_interval]' ).parents('tr').show();
    jQuery( 'input[name=prwfr_rvp_email_days_interval]' ).parents('tr').hide();
  }

  // var editor = tinymce.get('prwfr_price_drop_email_content_text');
  // editor.setMode('readonly');
  if (window.tinymce) {
    var editor = tinymce.get('prwfr_price_drop_email_content_text');
    if (editor) {
      editor.setMode('readonly');
    }
  }
  

  jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_date_time_onetime], input[name=prwfr_price_drop_daily_time], select[name=prwfr_price_drop_everyweek], input[name=prwfr_price_drop_monthly], input[name=prwfr_price_drop_rvp_email_days_interval], select[name=prwfr_price_drop_everyweek_rvp], input[name=prwfr_price_drop_monthly_rvp], input[name=prwfr_price_drop_date_time_rvp_fortnightly]').parents('tr').hide();

  jQuery( 'input[name=prwfr_price_drop_date_time_onetime], input[name=prwfr_price_drop_daily_time], select[name=prwfr_price_drop_everyweek], input[name=prwfr_price_drop_monthly], select[name=prwfr_price_drop_everyweek_rvp], input[name=prwfr_price_drop_monthly_rvp], input[name=prwfr_price_drop_date_time_rvp_fortnightly], input[name=prwfr_price_drop_weekly_time], input[name=prwfr_price_drop_monthly_time], input[name=prwfr_price_drop_weekly_time_rvp], input[name=prwfr_price_drop_monthly_time_rvp], input[name=prwfr_price_drop_email_header_content]').attr('disabled', 'disabled');

  jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_rvp_email_days_interval], input[name=prwfr_price_drop_email_trigger]').removeAttr( 'checked' );

  jQuery( 'input[name=prwfr_price_drop_email_send_check]' ).prop( 'checked', false);

  jQuery( 'input[name=prwfr_price_drop_email_send_check]' ).change( function(){
    var sendCheck = jQuery( 'input[name=prwfr_price_drop_email_send_check]:checked' ).val()
    if( sendCheck == 1){
      jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).parents('tr').show();
      jQuery( '#all' ).prop( 'checked', true );
      jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).removeAttr( 'disabled' );
    }else{
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_rvp_email_days_interval]' ).parents('tr').hide();
      jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).attr( 'disabled', 'disabled' );
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_rvp_email_days_interval], input[name=prwfr_price_drop_email_trigger]').removeAttr( 'checked' );
    }
  })

  if( jQuery( 'input[name=prwfr_price_drop_email_send_check]').is( ':checked' ) ){
    jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).parents('tr').show();
    jQuery( '#all' ).prop( 'checked', true );
    jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).removeAttr( 'disabled' );
  } else {
    jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_rvp_email_days_interval]' ).parents('tr').hide();
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_rvp_email_days_interval], input[name=prwfr_price_drop_email_trigger]').removeAttr( 'checked' );
      jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).attr( 'disabled', 'disabled' );
  }

  jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).change(function(){

    jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_date_time_onetime], input[name=prwfr_price_drop_daily_time], select[name=prwfr_price_drop_everyweek], input[name=prwfr_price_drop_monthly], input[name=prwfr_price_drop_rvp_email_days_interval], select[name=prwfr_price_drop_everyweek_rvp], input[name=prwfr_price_drop_monthly_rvp], input[name=prwfr_price_drop_date_time_rvp_fortnightly]').parents('tr').hide();

    var priceDropTrigger = jQuery( 'input[name=prwfr_price_drop_email_trigger]:checked' ).val();
    jQuery( 'input[name=prwfr_price_drop_trigger_type_all], input[name=prwfr_price_drop_rvp_email_days_interval]').removeAttr( 'checked' );
    if( priceDropTrigger == 'all' ){
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_price_drop_rvp_email_days_interval]' ).parents('tr').hide();

    } else if( priceDropTrigger == 'rvp_sale' ) {
      jQuery( 'input[name=prwfr_price_drop_rvp_email_days_interval]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all]' ).parents('tr').hide();
    }
  })

  if( jQuery( 'input[name=prwfr_price_drop_email_trigger]' ).is( ':checked' ) ){
    var priceDropTrigger = jQuery( 'input[name=prwfr_price_drop_email_trigger]:checked' ).val();
    if( priceDropTrigger == 'all' ){
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_price_drop_rvp_email_days_interval]' ).parents('tr').hide();

    } else if( priceDropTrigger == 'rvp_sale' ) {
      jQuery( 'input[name=prwfr_price_drop_rvp_email_days_interval]' ).parents('tr').show();
      jQuery( 'input[name=prwfr_price_drop_trigger_type_all]' ).parents('tr').hide();
    }
  }

  jQuery( 'input[name=prwfr_price_drop_trigger_type_all]' ).change( function(){

    jQuery( 'input[name=prwfr_price_drop_date_time_onetime], input[name=prwfr_price_drop_daily_time], select[name=prwfr_price_drop_everyweek], input[name=prwfr_price_drop_monthly], select[name=prwfr_price_drop_everyweek_rvp], input[name=prwfr_price_drop_monthly_rvp], input[name=prwfr_price_drop_date_time_rvp_fortnightly]').parents('tr').hide();

    var allSendTrigger = jQuery( 'input[name=prwfr_price_drop_trigger_type_all]:checked' ).val();
    if (allSendTrigger == 'onetime') {
      jQuery('input[name=prwfr_price_drop_date_time_onetime]').parents('tr').show();
    } else if (allSendTrigger == '1') {
        jQuery('input[name=prwfr_price_drop_daily_time]').parents('tr').show();
    } else if (allSendTrigger == '7') {
        jQuery('select[name=prwfr_price_drop_everyweek]').parents('tr').show();
    } else if (allSendTrigger == '30') {
        jQuery('input[name=prwfr_price_drop_monthly]').parents('tr').show();
    }
  })

  jQuery( 'input[name=prwfr_price_drop_rvp_email_days_interval]' ).change( function(){
    jQuery( 'input[name=prwfr_price_drop_date_time_onetime], input[name=prwfr_price_drop_daily_time], select[name=prwfr_price_drop_everyweek], input[name=prwfr_price_drop_monthly], select[name=prwfr_price_drop_everyweek_rvp], input[name=prwfr_price_drop_monthly_rvp], input[name=prwfr_price_drop_date_time_rvp_fortnightly]').parents('tr').hide();
    var emailSendTrigger = jQuery( 'input[name=prwfr_price_drop_rvp_email_days_interval]:checked' ).val();
    if (emailSendTrigger == '15') {
      jQuery('input[name=prwfr_price_drop_date_time_rvp_fortnightly]').parents('tr').show();
    } else if (emailSendTrigger == '7') {
      jQuery('select[name=prwfr_price_drop_everyweek_rvp]').parents('tr').show();
    } else if (emailSendTrigger == '30') {
      jQuery('input[name=prwfr_price_drop_monthly_rvp]').parents('tr').show();
    }
  })

  jQuery( 'input[name=prwfr_email_logo]' ).attr( 'disabled', 'disabled' );
  jQuery( 'input[name=prwfr_email_gdpr_permission]' ).attr( 'disabled', 'disabled' );
  jQuery( 'input[name=prwfr_email_gdpr_permission], input[name=prwfr_all_onsale_toggle]:checked' ).next().css( 'background', '#ccc' );

});
document.onreadystatechange = function () {
  var state = document.readyState

  if (state == 'interactive') {

    jQuery(".prwfr-loader").show();
    setTimeout(loader, 250);

  } else if (state == 'complete') {

    jQuery(".prwfr-loader").hide();

  }
}

// jQuery('#prwfr-manage-history-access').attr( 'disabled', 'disabled' );



function loader() {

  jQuery(".prwfr-loader").hide();

}
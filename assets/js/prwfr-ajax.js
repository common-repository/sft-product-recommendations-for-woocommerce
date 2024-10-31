jQuery(document).ready(function () {

    // Final setup ajax.
    jQuery('#prwfr_ajax_setup_button').click(function (e) {

        e.preventDefault();

        Swal.fire('', 'Your Request Created Successfully..!', 'success');

        let selectedValue = jQuery('input[name="prwfr_selected_radio"]:checked').val();
        let catId = jQuery('input[name="prwfr_cat_selection"]:checked').val();

        jQuery.ajax({
            url: prwfr_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'prwfr_api_request_data',
                selected_option: selectedValue,
                catId: catId,
            },
            success: function (response) {
                // location.reload();
            }
        });
    });

    // Log Toggle Date.
    jQuery('.prwfr-log-toggle-button').click(function () {

        let content = jQuery(this).parent().next('.prwfr-log-data-submenu');
        let isExpanded = content.css('display') !== 'none';

        if (isExpanded) {
            content.slideUp();
        } else {
            content.slideDown();
        }
    });

    // Key Validation ajax.
    jQuery('#prwfr_ajax_button').click(function (e) {

        // e.preventDefault();
        jQuery.ajax({
            url: prwfr_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'prwfr_api_key_validation',
                key_data: jQuery('input[name="prwfr_openai_api_key"]').val(),
            },
            beforeSend: function () {
                jQuery('span#prwfr-key-valid-message').html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                jQuery( '.prwfr-ai-message-data' ).html('<i class="fas fa-spinner fa-spin"></i> Processing');
                jQuery( '.sft_openai_api_model' ).hide();
            },
            success: function (response) {

                let final_data = JSON.parse(response);

                if( final_data.status == 1 ){
                    jQuery('span#prwfr-key-valid-message').empty().html('<i class="fas fa-check-circle" style="color: green;"></i> ' + final_data.usage);
                } else {
                    jQuery('span#prwfr-key-valid-message').empty().html('<i class="fas fa-times-circle" style="color: red;"></i> ' + final_data.usage);
                }

                // Set processing status.
                jQuery( '.prwfr-ai-message-data' ).html('<i class="fas fa-spinner fa-spin"></i> Processing');

                // Trigger save button.
                jQuery("input[name='prwfr_save_key']").click();
            }
        });
    });

    // Final setup ajax.
    jQuery('#prwfr_ajax_setup_button').click(function (e) {

        e.preventDefault();

        Swal.fire('', 'Your Request Created Successfully..!', 'success');

        let selectedValue = jQuery('input[name="prwfr_selected_radio"]:checked').val();
        let catId = jQuery('input[name="prwfr_cat_selection"]:checked').val();

        jQuery.ajax({
            url: prwfr_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'prwfr_api_request_data',
                selected_option: selectedValue,
                catId: catId,
            },
            success: function (response) {
            }
        });
    });
});


function showContent(contentId) {

    // Hide all content divs
    const contents = document.querySelectorAll('.prwfr-log-content-container');
    contents.forEach(content => content.classList.remove('active'));

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.prwfr-log-tab');
    tabs.forEach(tab => tab.classList.remove('active'));

    // Show the selected content
    document.getElementById(contentId).classList.add('active');

    // Set the clicked tab as active
    document.getElementById('tab' + contentId.slice(-1)).classList.add('active');
}

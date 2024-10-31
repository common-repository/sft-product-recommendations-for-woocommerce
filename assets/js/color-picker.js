jQuery(document).ready(function() {
    jQuery('.prwfr-btn-color').wpColorPicker();
    jQuery( '#prwfr_email_template_header_bg_color' ).wpColorPicker().closest('.wp-picker-container').find('.wp-color-result').unbind('click');
    jQuery( '#prwfr_learn_more_btn_color' ).wpColorPicker().closest('.wp-picker-container').find('.wp-color-result').unbind('click');

})
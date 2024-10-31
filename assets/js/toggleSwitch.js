jQuery(document).ready(function($) {
    $('#toggle-switch').on('change', function() {
        var isChecked = $(this).is(':checked');
        var optionValue = isChecked ? "true" : "false";
        
        // Update the option value
        $.ajax({
            type: 'POST',
            url: ajaxurl, // WordPress AJAX URL
            data: {
                action: 'pieeye_update_consent',
                option_value: optionValue,
            },
            success: function(response) {
                console.log('Option updated: ' + response);
                window.location.reload();
            },
        });
    });
    $('#pieeye_redirect').click(function(e){
        var isChecked = $('#toggle-switch').is(':checked');
        !isChecked ? e.preventDefault() : null
    })
});
  
jQuery(document).ready(function () {
	jQuery("#pitchbox_slideshow_autoslide").change( function () {
		if ( jQuery('#pitchbox_slideshow_autoslide option:selected').val() === 'yes' ) {
			jQuery('#pitchbox_slideshow_autoslideduration input').prop('disabled', false);
			jQuery('#pitchbox_slideshow_autoslideduration').show();
		}
		else {
			jQuery('#pitchbox_slideshow_autoslideduration input').prop('disabled', 'disabled');
			jQuery('#pitchbox_slideshow_autoslideduration').hide();
		}
	});
	jQuery("div[id^='slideSettingsContent']").each( function() {
		var parent = jQuery(this);
		jQuery(this).find("input[name$='[use_slideshow_transition]']").change( parent, function() {
			if (jQuery(this).prop('checked')) {
				parent.find("select[name$='[transition]']").prop('disabled', 'disabled');
			}
			else {
				parent.find("select[name$='[transition]']").prop('disabled', false);
			}
		});
	});
	jQuery('#pitchbox_create_pitch_submit').click(function(e) {
		e.preventDefault();
		jQuery('#publish').click();
	});
	jQuery('.meta-box-sortables').sortable({
        disabled: true
    });
	jQuery("#premium-addon").find("*").off();
	jQuery("#premium-addon").removeClass("closed");
});
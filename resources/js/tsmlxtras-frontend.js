jQuery(window).load(function ($) {
	jQuery( 'tr.expandable' ).click( function (event) {
		// jQuery(this).nextAll('.datarow:first').toggleClass('tw-hidden')
        var accordionrow = jQuery(this).nextAll('.datarow:first').find('div.tsmlx-container').first()
        var accordionheight = accordionrow.prop('scrollHeight')
        accordionrow.css("max-height", accordionheight+'px').toggleClass('tw-max-h-0')
		jQuery(this).find('svg.accordion-toggle').toggleClass('tw-hidden')
		event.stopPropagation()
		return false
	})

	// jQuery('.expander').click(function (evt) {
	// 	jQuery(this).nextAll('.expandable').toggle('fast')
	// 	evt.stopPropagation()
	// 	return false;
	// })

	//handle directions links; send to Apple Maps (iOS), or Google Maps (everything else)
	var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
	jQuery('body').on('click', 'a.tsmlx-directions', function (e) {
		e.preventDefault();
		var directions =
			(iOS ? 'maps://?' : 'https://maps.google.com/?') +
			jQuery.param({
				daddr: jQuery(this).attr('data-latitude') + ',' + jQuery(this).attr('data-longitude'),
				saddr: 'Current Location',
				q: jQuery(this).attr('data-location')
			});
		window.open(directions);
	});
});
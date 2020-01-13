const { _x } = wp.i18n;

(function ($) {
	$(function () {
		const $search = $('#media-search-input');

		$search.on('input', function (event) {
			const $input = $(this);
			let value = $input.val();

			$icons = $('.shp-icon-list__item').not('.shp-icon-list__item--no-results');
			$('.shp-icon-list__item--no-results').hide();

			if(value && value !== '') {
				value = value.replace(' ', '-').toLowerCase();
				$results = $('svg[data-shp-icon*="' + value + '"]');
				$icons.hide();

				if($results.length) {
					$results.parent().parent().parent().show();
				} else {
					$('.shp-icon-list__item--no-results').show();
				}

			} else {
				$icons.show();
			}

		})
	});
})(jQuery);
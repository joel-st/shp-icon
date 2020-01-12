(function ($) {
	$(function () {
		const $toggleButton = $('#shp-icon-upload-toggle');
		const $toggleTarget = $('#shp-icon-upload');

		if($toggleTarget && $toggleButton) {
			$toggleButton.on('click', function (event) {
				event.preventDefault();
				const expanded = ($toggleTarget.attr('aria-expanded') == 'false') ? 'true' : 'false';

				$toggleButton.attr('aria-expanded', expanded);
				$toggleTarget.attr('aria-expanded', expanded);
			});
		}
	});
})(jQuery);
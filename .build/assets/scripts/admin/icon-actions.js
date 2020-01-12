(function ($) {
	$(function () {
		const $actionToggle = $('.shp-icon-list__actions-toggle');

		$actionToggle.on('click', function () {
			$toggle = $(this);
			$item = $toggle.parent().parent();
			$actions = $item.find('.shp-icon-list__action-list');
			$icon = $item.find('.shp-icon-list__icon > svg');

			$actions.slideToggle('fast');
			$item.toggleClass('shp-icon-list__item--actions-visible');
		});
	});
})(jQuery);
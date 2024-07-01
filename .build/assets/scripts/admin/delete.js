import { _x, __ } from '@wordpress/i18n';

(function ($) {
	$(function () {

		const $deleteAction = $('.shp-icon-list__action-remove');

		$deleteAction.on('click', function (event) {
			event.preventDefault();
			const $item = $(this).closest('.shp-icon-list__item');
			const fileName = $item.find('.shp-icon-list__icon svg').attr('data-shp-icon');
			const iconName = $item.find('.shp-icon-list__name').text();

			if(confirm(_x('Confirm Deletion of', 'Confirm deletion. Confirm deletion of [IconName]', 'shp-icon') + ' ' + iconName)) {
				deleteIcon(fileName);
			}
		});
	});
})(jQuery);

export function deleteIcon(icon) {
	(function ($) {
		if(icon) {

			if(!icon.includes('.svg')) {
				icon = icon + '.svg';
			}

			$.ajax({
				type: 'POST',
				url: shp_icon_data.ajaxUrl,
				data: {
					action: 'shp_icon_delete',
					file_name: icon,
				},
				success: function (response) {
					const $icon = $('[data-shp-icon="' + response.fileName.replace('.svg', '') + '"]');
					const $item = $icon.closest('.shp-icon-list__item');
					const $statusElement = $('.shp-icon-upload__status');

					const $status = $('<div class="notice notice-success"><p><b class="notice__filename">' + response.name + '</b> <span>' + _x('deleted', 'Admin notice delete file sucessfully', 'shp-icon') + '</span></p></div>');
					$statusElement.append($status);

					if($item) {
						$item.remove();
					}

					console.log(response);
				},
				error: function (XMLHttpRequest, textStatus, errorThrown) {
					console.log(XMLHttpRequest);
				}
			});
		}
	})(jQuery);
}

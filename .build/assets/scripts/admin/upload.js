const { _x } = wp.i18n;

(function ($) {
	$(function () {
		const $fileInput = $('#shp-icon-upload-input');
		const $form = $('#shp-icon-upload .shp-icon-upload__form');
		const $pageTitleActionElement = $('.page-title-action');

		if($fileInput) {

			const $statusElement = $('.shp-icon-upload__status');

			$fileInput.change(function () {
				//$pageTitleActionElement.attr('disabled', 'true');
				const fileList = $fileInput[0].files;
				let uploadId = 1;

				Object.keys(fileList).forEach(key => {
					$status = $('<div class="notice notice-info" data-id="' + uploadId + '"><p><b class="notice__filename">' + fileList[key]['name'] + '</b> <span>' + _x('processing', 'Admin notice processing [Filename] if file is selected for upload', 'shp-icon') + '</span></p><div class="spinner is-active"></div></div>');
					$statusElement.append($status);

					const formData = new FormData();
					formData.append('action', shp_icon_data.action);
					formData.append('_wpnonce', shp_icon_data.ajaxNonce);
					formData.append('file', fileList[key]);
					formData.append('id', uploadId);

					$.ajax({
						type: 'POST',
						url: shp_icon_data.ajaxUrl,
						data: formData,
						processData: false,
						contentType: false,
						cache: false,
						success: function (response) {
							console.log(response);
							$notice = $('[data-id="' + response.id + '"]');

							$notice.removeClass('notice-info');
							$notice.find('.spinner').remove();
							if(response.upload.error) {
								$notice.addClass('notice-error');
								$notice.find('p span').html(_x('Something went wrong while processing the file.', 'Admin notice response.upload.error returns true', 'shp-icon'));
							} else {
								$notice.addClass('notice-success');
								$notice.find('p span').html('<b>' + response.name + '</b> ' + _x('Added successfully!', 'Admin notice [Icon] added successfully', 'shp-icon'));
								insertIcon(response.fileName);
							}
						},
						error: function (XMLHttpRequest, textStatus, errorThrown) {
							$notice = $('[data-id="' + XMLHttpRequest.responseJSON.id + '"]');

							$notice.removeClass('notice-info');
							$notice.find('.spinner').remove();

							$notice.addClass('notice-error');
							$notice.find('p span').html(_x('Upload failed!', 'Admin notice upload failed', 'shp-icon') + ' <i class="notice__error">' + XMLHttpRequest.responseJSON.message + '</i>');

							console.log(XMLHttpRequest);
						}
					});

					uploadId++;
				});
			});

			function insertIcon(icon) {
				$.ajax({
					type: 'POST',
					url: shp_icon_data.ajaxUrl,
					data: {
						action: 'shp_icon_push_icon',
						icon: icon
					},
					success: function (response) {
						$('.shp-icon-list').prepend(response);

						$toggle = $($('.shp-icon-list__item')[0]).find('.shp-icon-list__actions-toggle');
						$toggle.on('click', function () {
							$item = $toggle.parent().parent();
							$actions = $item.find('.shp-icon-list__action-list');
							$icon = $item.find('.shp-icon-list__icon > svg');

							$actions.slideToggle('fast');
							$item.toggleClass('shp-icon-list__item--actions-visible');
						});

						console.log(response);
					},
					error: function (XMLHttpRequest, textStatus, errorThrown) {
						console.log(XMLHttpRequest);
					}
				});
			}
		}
	});
})(jQuery);
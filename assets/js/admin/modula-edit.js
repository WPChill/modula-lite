(function($) {
	'use strict';

	$(document).ready(function() {
		$('.modula-feedback-notice .notice-dismiss').click(function(evt) {
			evt.preventDefault();

			var notice = $(this).parent();
			$.ajax({
				method: 'POST',
				url: ajaxurl,
				data: { action: 'modula-edit-notice' }
			}).done(function(msg) {
				notice.remove();
			});
		});

		// Copy shortcode functionality
		$('.copy-modula-shortcode').click(function(e) {
			e.preventDefault();
			var gallery_shortcode = $(this).parent().find('input');
			gallery_shortcode.focus();
			gallery_shortcode.select();
			document.execCommand('copy');
			$(this).next('span').text('Shortcode copied');
			$('.copy-modula-shortcode').not($(this)).parent().find('span').text('');
		});

		// Dismiss notice
		$('body').on('click', '#modula-lightbox-upgrade .notice-dismiss', function(e) {
			e.preventDefault();
			var notice = $(this).parent();

			var data = {
				action: 'modula_lbu_notice',
				nonce: modulaHelper._wpnonce
			};

			$.post(modulaHelper.ajax_url, data, function(response) {
				// Redirect to plugins page
				notice.remove();
			});
		});
	});

	const modulaOpenModal = (e) => {
		e.preventDefault();
		$.get(
			modulaHelper.ajax_url,
			{
				action: 'modula_modal_upgrade'
			},
			(html) => {
				$('body').addClass('modal-open');
				$('body').append(html);

				$(document).one('click', '.modula-modal__overlay', modulaCloseModal);
				$(document).one('click', '.modula-modal__dismiss', modulaCloseModal);
			}
		);
	};

	const modulaCloseModal = () => {
		$('.modula-modal__overlay').remove();
		$('body').removeClass('modal-open');
	};

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=#modula-albums"]',
		modulaOpenModal
	);
})(jQuery);

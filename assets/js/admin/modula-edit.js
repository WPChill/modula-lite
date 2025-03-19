(function ($) {
	'use strict';

	$(document).ready(function () {
		//prevents the modula metaboxes from being dragged.
		$(
			'.modula-no-drag #normal-sortables, .modula-no-drag #side-sortables'
		).off();

		$('.modula-feedback-notice .notice-dismiss').click(function (evt) {
			evt.preventDefault();

			var notice = $(this).parent();
			$.ajax({
				method: 'POST',
				url: ajaxurl,
				data: {
					action: 'modula-edit-notice',
				},
			}).done(function (msg) {
				notice.remove();
			});
		});

		// Copy shortcode functionality
		$('.copy-modula-shortcode').click(function (e) {
			e.preventDefault();
			var gallery_shortcode = $(this).parent().find('input');
			gallery_shortcode.focus();
			gallery_shortcode.select();
			document.execCommand('copy');
			$(this).next('span').text('Shortcode copied');
			$('.copy-modula-shortcode')
				.not($(this))
				.parent()
				.find('span')
				.text('');
		});

		// Dismiss notice
		$('body').on(
			'click',
			'#modula-lightbox-upgrade .notice-dismiss',
			function (e) {
				e.preventDefault();
				var notice = $(this).parent();

				var data = {
					action: 'modula_lbu_notice',
					nonce: modulaHelper._wpnonce,
				};

				$.post(modulaHelper.ajax_url, data, function (response) {
					// Redirect to plugins page
					notice.remove();
				});
			}
		);
	});

	const modulaOpenModal = (e) => {
		e.preventDefault();
		const upsell = e.data.upsell;
		$.get(
			modulaHelper.ajax_url,
			{
				action: 'modula_modal-' + upsell + '_upgrade',
			},
			(html) => {
				$('body').addClass('modal-open');
				$('body').append(html);

				$(document).one(
					'click',
					'.modula-modal__overlay.' + upsell,
					{
						upsell,
					},
					modulaCloseModal
				);
				$(document).one(
					'click',
					'.modula-modal__dismiss.' + upsell,
					{
						upsell,
					},
					modulaCloseModal
				);
			}
		);
	};

	const modulaCloseModal = (e) => {
		const upsell = e.data.upsell;
		$('.modula-modal__overlay.' + upsell).remove();
		$('body').removeClass('modal-open');
	};

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=#modula-albums"]',
		{
			upsell: 'albums',
		},
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=#gallery-defaults"]',
		{ upsell: 'gallery-defaults' },
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=#albums-defaults"]',
		{ upsell: 'albums-defaults' },
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=#image-proofing-upsell"]',
		{
			upsell: 'image-proofing',
		},
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=go-pro"]',
		function (e) {
			e.preventDefault();
			window.open(
				'https://wp-modula.com/pricing/?utm_source=modula-lite&utm_medium=admin-menu&utm_campaign=upsell',
				'_blank'
			);
		}
	);

	$('body').on(
		'click',
		'#adminmenu #menu-posts-modula-gallery ul li a[href="edit.php?post_type=modula-gallery&page=#modula-licenses"]',
		{
			upsell: 'image-licensing',
		},
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#modula-pro-bulk-editor-upsell .button',
		{
			upsell: 'bulk-editor',
		},
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#modula-content-galleries-upsell',
		{
			upsell: 'content-galleries',
		},
		modulaOpenModal
	);

	$('body').on(
		'click',
		'#modula-instagram-upsell',
		{
			upsell: 'instagram',
		},
		modulaOpenModal
	);
	
	$('body').on(
		'click',
		'#modula-video-upsell, #modula-video-playlist-upsell',
		{
			upsell: 'video',
		},
		modulaOpenModal
	);

	jQuery(window).on('load', function () {
		let searchParams = new URLSearchParams(window.location.search);
		if (
			searchParams.has('page') &&
			'modula-lite-vs-pro' === searchParams.get('page') &&
			searchParams.has('extension')
		) {
			jQuery('html,body').animate(
				{
					scrollTop:
						jQuery(
							'.wpchill-plans-table.wpchill-highlight'
						).offset().top - 150,
				},
				600
			);
		}
	});

	const checkSticky = () => {
		const sideSortables = document.getElementById('side-sortables');
		const submitDiv = document.getElementById('submitdiv');

		if ( ! submitDiv || ! sideSortables ) {
			return;
		}
		
		const offsetTop = submitDiv.offsetTop + 100;
		const stickyClass = 'is-sticky';
		if (window.scrollY >= offsetTop) {
            sideSortables.classList.add(stickyClass);
        } else {
            sideSortables.classList.remove(stickyClass);
        }
	};

	window.addEventListener('scroll', checkSticky);

    checkSticky();
})(jQuery);

(function (global) {
	var eventBus = {};
	var events = {};

	eventBus.on = function (eventName, listener) {
	  if (!events[eventName]) {
		events[eventName] = [];
	  }
	  events[eventName].push(listener);
	};
  
	eventBus.off = function (eventName, listener) {
	  if (!events[eventName]) return;
	  events[eventName] = events[eventName].filter(function (l) {
		return l !== listener;
	  });
	};
  
	eventBus.emit = function (eventName, data) {
	  if (!events[eventName]) return;
	  events[eventName].forEach(function (listener) {
		listener(data);
	  });
	};
  
	global.modulaEventBus = eventBus;
})(this);

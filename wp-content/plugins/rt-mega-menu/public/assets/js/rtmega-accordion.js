(function ($) {

	$.fn.mgaccordion = function (options) {

		var defaults = {
			theme: "flat",
			leaveOpen: false
		};

		var settings = $.extend({}, defaults, options);
		var openIcon, closeIcon;

		this.initialize = function () {
			if (!this.is('ul') && !this.is('ol')) {
				console.log('Element is not a list');
				return;
			}

			this.removeClass('mg-accordion mg-tree mg-flat');
			this.addClass('mg-accordion');

			var theme = settings.theme;
			var leaveOpen = settings.leaveOpen;

			if (theme === 'tree') {
				this.addClass('mg-tree');
			} else {
				this.addClass('mg-flat');
			}

			$.each(this.find('li'), function () {
				var $li = $(this);
				var $a = $li.children('a');
				var $icon = $a.find('.submenu-parent-icon');

				if ($li.children('ul').length) {
					$li.addClass('dropdown');
					$li.find('ul').addClass('submenu');

					var href = $a.attr('href');


					if (typeof href === 'undefined' || href === '' || href === '#') {
						$a.off('click').on('click', function (e) {
							e.preventDefault();
							e.stopImmediatePropagation();

							if (leaveOpen === false) {
								closeOther($(this));
							}
							$(this).siblings('ul.submenu').stop(true, true).slideToggle(function () {
								$(this).toggleClass('closed', $(this).is(':visible'));
							});
							updateIcons($(this));
						});
					} else {
						$icon.off('click').on('click', function (e) {
							e.preventDefault();
							e.stopPropagation();
							e.stopImmediatePropagation();

							if (leaveOpen === false) {
								closeOther($a);
							}
							$a.siblings('ul.submenu').stop(true, true).slideToggle(function () {
								$(this).toggleClass('closed', $(this).is(':visible'));
							});
							updateIcons($a);
						});
					}
				}
			});

			return this;
		};


		var setIcons = function () {
			if (settings.theme === 'tree') {
				openIcon = '<span class="toggler"><i class="fa fa-plus-circle"></i> </span>';
				closeIcon = '<span class="toggler"><i class="fa fa-minus-circle"></i> </span>';
			} else if (settings.theme === 'flat') {
				openIcon = '<span class="toggler"><i class="fa fa-arrow-circle-down"></i> </span>';
				closeIcon = '<span class="toggler"> <i class="fa fa-arrow-circle-up"></i></span>';
			}
		}

		var closeOther = function (obj) {
			setIcons();
			var items = obj.parent().siblings().find('ul.submenu');
			items.each(function () {
				if ($(this).is(':visible')) {
					$(this).slideUp('slow').removeClass('closed')
						.parent().find('a').removeClass('openItem');
				}
			});
		}

		var updateIcons = function (obj) {
			if (settings.theme === 'flat') {
				if (obj.siblings('.submenu').is(':visible')) {
					obj.addClass('openItem');
				} else {
					obj.removeClass('openItem');
				}
			}
		}

		return this.initialize();
	};

}(jQuery));
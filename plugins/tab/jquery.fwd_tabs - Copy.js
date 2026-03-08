(function ( $ ) {
	$.fn.fwd_tabs = function() {
		return this.each(function() {
			var tabs = $(this);
			var tabMenuList = $(".tab-menu", tabs).children();

			/* Create any missing content areas that are required for AJAX requests */
			for (i = $(".tab-content", tabs).length, j = tabMenuList.length; i < j; i++ ) {
				tabs.append('<div class="tab-content"></div>');
	    		}

			var tabContent = $(".tab-content", tabs);

			/* Hide all but the first content area */
			tabContent.slice(1).hide();

			/* Mark the first tab as active by default */
			tabMenuList.eq(0).addClass("active");

			/* Listen for clicks on the tab menu */
			tabMenuList.find("a").click(function(e) {
				var theParent = $(this).parent().index();

				/* Deactivate any other tab menus and make the selected one active */
				tabMenuList.removeClass('active').eq(theParent).addClass('active');

				/* Hide any other content areas and make the selected content area visible */
				tabContent.hide().eq(theParent).show();

				/* If this is an external link and hasn't been called before, load the data into the content area */
				if (tabContent.eq(theParent).html().length == 0 && $(this).attr("href").substr(0, 1) != "#") {
					var fragment = ($(this).data("fragment") ? " " + $(this).data("fragment") : "");
					tabContent.eq(theParent).append('<div class="tab-loading"></div>').load($(this).attr("href") + fragment, function(response, status, xhr) {
						if (status == "error") {
							tabContent.eq(theParent).html("Sorry, the content could not be loaded");
						}
					});
				}
				e.preventDefault();
			});
		});
	}
}(jQuery));
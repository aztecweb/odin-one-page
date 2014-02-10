"use strict";

/**
 * Scroll the page to the element
 */
jQuery.fn.extend({
	odinOnePageScroll : function(options) {
		options = jQuery.extend({
			animate : true
		}, options);
		
		// scroll to the page
		var scroll = jQuery(this).offset().top - 70;
		if(jQuery("body").hasClass("admin-bar")) {
			scroll -= 28;
		}
		
		var $body = jQuery("html, body");
		if(options.animate) {
			$body.animate({
			    scrollTop: scroll
			}, 'medium');
		} else {
			$body.scrollTop(scroll);
		}		
	}
});

jQuery(function($) {
	// scroll to the selected page
	if(odin_onepage.selected_page) {
		$("#" + odin_onepage.selected_page).odinOnePageScroll({
			animate : false
		});
	}	
	
	$("#main-navigation .menu-item a").click(function(e) {
		// if is a external link, continue
		var regex = new RegExp("^https?:\/\/" + document.domain);
		if(!regex.test($(this).attr("href"))) {
			return true;
		}
		
		// find the page that corresponding with the menu item
		var regex = /page-[0-9]+/;
		var classes = $(this).parent().attr("class");
		var match = regex.exec(classes);
		
		// if not is a page, continue
		if(match == null) {
			return true;
		}
		
		// change the active class
		$(this)
			.parents("ul")
				.find(".active")
					.removeClass("active")
				.end()
			.end()
			.parent()
				.addClass("active");
		
		var element_id = "#" + match[0];
		$(element_id).odinOnePageScroll();
		
		// save the new state
		window.history.pushState({ id : element_id }, null, $(this).attr("href"));

		e.preventDefault();
	});
});

window.onpopstate = function(e) {
	if(e.state.id !== null) {
		jQuery(e.state.id).odinOnePageScroll();
	}
};
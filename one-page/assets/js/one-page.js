"use strict";

jQuery.fn.extend({
	/**
	 * Scroll the page to the element
	 */
	odinOnePageScroll : function(options) {
		options = jQuery.extend({
			animate : true
		}, options);
		
		var animatestart = {
			type: "animatestart",
		};
		
		var animatestop = {
			type: "animatestop",
		};
		
		// scroll to the page
		var scroll = jQuery(this).offset().top - 70;
		if(jQuery("body").hasClass("admin-bar")) {
			scroll -= 28;
		}

		var $body = jQuery("html, body");
		if(options.animate) {
			jQuery.event.trigger(animatestart);
			$body.animate({
			    scrollTop: scroll
			}, 'medium', function() {
				jQuery.event.trigger(animatestop);
			});
		} else {
			$body.scrollTop(scroll);
		}		
	},

	/**
	 * Change the active menu
	 */
	odinOnePageChangeActive : function() {		
		jQuery(this)
			.parents("ul")
				.find(".active")
					.removeClass("active")
				.end()
			.end()
				.addClass("active");
	}
});

jQuery(function($) {
	
	var inAnimation = false;
	$(window)
		.on('scroll', function () {
			if(!inAnimation) {
			    var scrollTop = $(window).scrollTop();
			    
			    var found = false;
			    $($('section').get().reverse()).each(function(i, item) {
				    var elementOffset = $(item).offset().top;
				    var distance = (elementOffset - scrollTop);
				    
				    if(distance < 75) {
				    	$("#main-navigation").find("." + $(item).attr("id")).odinOnePageChangeActive();
				    	return false;
				    }
				});
			}
		})
		.on('animatestart', function() {
			inAnimation = true;
		})
		.on('animatestop', function() {
			inAnimation = false;
		});
	
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
		
		$(this).parent().odinOnePageChangeActive();
		
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
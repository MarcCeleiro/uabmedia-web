(function (jQuery) {
    "use strict";
    jQuery(document).ready(function () {
        function activaTab(pill) {
            jQuery(pill).addClass("active show");
        }
        function headerHeight() {
            var height = jQuery("#capcalera").height();
            jQuery(".um-height").css("height", height + "px");
        }
        var btn = $("#back-to-top");
        $(window).scroll(function () {
            if ($(window).scrollTop() > 50) {
                btn.addClass("show");
            } else {
                btn.removeClass("show");
            }
        });
        btn.on("click", function (e) {
            e.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, "300");
        });
        jQuery("[data-toggle=more-toggle]").on("click", function () {
            jQuery(this).next().toggleClass("show");
        });
        jQuery(document).on("click", function (e) {
            let myTargetElement = e.target;
            let selector, mainElement;
            if (jQuery(myTargetElement).hasClass("search-toggle") || jQuery(myTargetElement).parent().hasClass("search-toggle") || jQuery(myTargetElement).parent().parent().hasClass("search-toggle")) {
                if (jQuery(myTargetElement).hasClass("search-toggle")) {
                    selector = jQuery(myTargetElement).parent();
                    mainElement = jQuery(myTargetElement);
                } else if (jQuery(myTargetElement).parent().hasClass("search-toggle")) {
                    selector = jQuery(myTargetElement).parent().parent();
                    mainElement = jQuery(myTargetElement).parent();
                } else if (jQuery(myTargetElement).parent().parent().hasClass("search-toggle")) {
                    selector = jQuery(myTargetElement).parent().parent().parent();
                    mainElement = jQuery(myTargetElement).parent().parent();
                }
                if (!mainElement.hasClass("active") && jQuery(".navbar-list li").find(".active")) {
                    jQuery(".navbar-right li").removeClass("um-show");
                    jQuery(".navbar-right li .search-toggle").removeClass("active");
                }
                selector.toggleClass("um-show");
                mainElement.toggleClass("active");
                e.preventDefault();
            } else if (jQuery(myTargetElement).is(".search-input")) {
            } else {
                jQuery(".navbar-right li").removeClass("um-show");
                jQuery(".navbar-right li .search-toggle").removeClass("active");
				
            }
        });
        jQuery(".llista-opcions .llista-opcions-block .llista-opcions-details").hide();
        jQuery(".llista-opcions .llista-opcions-block:first").addClass("um-active").children().slideDown("slow");
        jQuery(".llista-opcions .llista-opcions-block").on("click", function () {
            if (jQuery(this).children("div.llista-opcions-details").is(":hidden")) {
                jQuery(".llista-opcions .llista-opcions-block").removeClass("um-active").children("div.llista-opcions-details").slideUp("slow");
                jQuery(this).toggleClass("um-active").children("div.llista-opcions-details").slideDown("slow");
            }
        });
        jQuery(document).on("click", function (event) {
            var $trigger = jQuery(".capcalera .navbar");
            if ($trigger !== event.target && !$trigger.has(event.target).length) {
                jQuery(".capcalera .navbar-collapse").collapse("hide");
                jQuery("body").removeClass("nav-open");
            }
        });
        jQuery(".c-toggler").on("click", function () {
            jQuery("body").addClass("nav-open");
        });
        jQuery(".trending-content").each(function () {
            var highestBox = 0;
            jQuery(".tab-pane", this).each(function () {
                if (jQuery(this).height() > highestBox) {
                    highestBox = jQuery(this).height();
                }
            });
            jQuery(".tab-pane", this).height(highestBox);
        });
        if (jQuery("select").hasClass("season-select")) {
            jQuery("select").select2({ theme: "bootstrap4", allowClear: !1, width: "resolve" });
        }
        if (jQuery("select").hasClass("pro-dropdown")) {
            jQuery(".pro-dropdown").select2({ theme: "bootstrap4", minimumResultsForSearch: Infinity, width: "resolve" });
            jQuery("#lang").select2({ theme: "bootstrap4", placeholder: "Language Preference", allowClear: !0, width: "resolve" });
        }
    });
})(jQuery);

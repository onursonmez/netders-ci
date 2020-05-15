// Theme    : Lantern - Responsive vCard & Resume Template
//	Theme URI: http://themeforest.net/user/lanternthemes
//	Description: This javascript file is using as a settings file for slideshow background.
//	Version: 1.0
//	Author: Lantern Themes
//	Author URI: http://themeforest.net/user/lanternthemes
//	Tags:
//  ====================================================================

// ---------- Header Slideshow ----------

$(function() {
	$.vegas('slideshow', {
		backgrounds:[
			{ src:'public/theme1/img/low-poly00.jpg', fade:1000 },
			{ src:'public/theme1/img/low-poly01.jpg', fade:1000 },
			{ src:'public/theme1/img/low-poly02.jpg', fade:1000 },
			{ src:'public/theme1/img/low-poly03.jpg', fade:1000 }
		]
	})
});



// Theme    : Lantern - Responsive vCard & Resume Template
//	Theme URI: http://themeforest.net/user/lanternthemes
//	Description: This javascript file is using as a settings file. This file includes the sub scripts for the javascripts used in this template.
//	Version: 1.0
//	Author: Lantern Themes
//	Author URI: http://themeforest.net/user/lanternthemes
//	Tags:
//  ====================================================================

//	TABLE OF CONTENTS
//	---------------------------
//	 02. Adding fixed position to header
//   03. Easy Tab
//	 04. Menu Toggle
//	 05. Testimonial Carousel
//	 06. Image Popup

//  ====================================================================



(function() {
	"use strict";
	
	$(window).on('load', function(){
		
		setTimeout(function(){
		//Google Map script
		var $googleMaps = $('#map');
		if ( $googleMaps.length ) {
			$googleMaps.each(function() {
				var $map = $(this);
	
				var lat;
				var lng;
				var map;
	
				//map styles. You can grab different styles on https://snazzymaps.com/
				var styles = [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}];
				
				//map settings
				var address = $map.data('address') ? $map.data('address') : 'istanbul';
				var markerDescription = $map.find('.map_marker_description').prop('outerHTML');
	
				//if you do not provide map title inside #map (.page_map) section inside H3 tag - default titile (Map Title) goes here:
				var markerTitle = $map.find('h3').first().text() ? $map.find('h3').first().text() : 'Başlık';
				var markerIconSrc = $map.find('.map_marker_icon').first().attr('src');
	
				//type your address after "address="
				jQuery.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address=' + address, function(data) {
					
					lat = data.results[0].geometry.location.lat;
					lng = data.results[0].geometry.location.lng;
	
				}).complete(function(){
					
					var center = new google.maps.LatLng(lat, lng);
					var settings = {
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						zoom: 13,
						draggable: true,
						scrollwheel: false,
						center: center,
						styles: styles 
					};
					map = new google.maps.Map($map[0], settings);
	
					var marker = new google.maps.Marker({
						position: center,
						title: markerTitle,
						map: map,
						icon: markerIconSrc,
					});
	
					var infowindow = new google.maps.InfoWindow({ 
						content: markerDescription
					});
					
					google.maps.event.addListener(marker, 'click', function() {
						infowindow.open(map,marker);
					});
					
					$('#map').trigger('resize');
	
				});
			}); //each
		}//google map length
		}, 100);
	
	}); //end of "window load" event

	// ---------- 02 Adding fixed position to header ----------
	// --------------------------------------------------------

	$(document).scroll(function() {
		if ($(document).scrollTop() >= 1) {
			  $('.header-area').addClass('navbar-fixed-top');
			  $('html').addClass('has-fixed-nav');
		} else {
			  $('.header-area').removeClass('navbar-fixed-top');
			  $('html').removeClass('has-fixed-nav');
		}
	});

	// --------------------- 03 Easy Tab ----------------------
	// --------------------------------------------------------

	$(document).ready(function ($) {     
		$('#tab-container').easytabs({
			 updateHash: false
		});
		$('.view-profile').click( function(e) {
			e.preventDefault();
			$('#tab-container').easytabs('select', '#contact');
		});
		$('.home-profile-quick a[href="#about"]').click( function(e) {
			e.preventDefault();
			$('#tab-container').easytabs('select', '#about');
		});
	});

	// -------------------- 04 Menu Toggle --------------------
	// --------------------------------------------------------
	
	$( ".nav-toggle" ).click(function() {
		$( ".navigation-area" ).toggle();
	});

	// --------------- 05 Testimonial Carousel ----------------
	// --------------------------------------------------------
	
	$('.carousel').carousel({
	  interval: 5000
	})
	
	// -------------------- 06 Image Popup --------------------
	// --------------------------------------------------------
	
	$('.portfolio-gal').magnificPopup({
	  delegate: 'a', // child items selector, by clicking on it popup will open
	  type: 'image'
	  // other options
	});
	
	$('[data-toggle="tooltip"]').tooltip(); 
	
	$('[data-type="mobile-number"]').intlTelInput({
		preferredCountries: [ "tr", "de", "us" ],
		separateDialCode: true,
		initialCountry: "TR",
		defaultCountry: "TR",
		numberType: "MOBILE",
		geoIpLookup: false,
		nationalMode: false,
		/*
		geoIpLookup: function(callback) {
			$.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
				var countryCode = (resp && resp.country) ? resp.country : "";
				callback(countryCode);
			});
		},
		*/     
		utilsScript: base_url + "public/vendor/intl-tel-input/lib/libphonenumber/build/utils.js?7"
	});
	$('[data-type="mobile-number"]').on('keyup', function(){	
		if($(this).attr('placeholder').substring(0,3) == +90){
			$(this).mask('+00 000 000 0000');
		}
	});	

})(jQuery);

function getmobile(hash){
    $.get(base_url + 'users/getmobile?hash=' + hash, function(data){
      if(data)
      $('.ajaxmobile a').html(data);
    });		
}
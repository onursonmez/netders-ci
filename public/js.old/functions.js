function jgrowl(msg, theme){
	$.jGrowl(msg, { theme: theme, life: 10000 });
}

function get_prices(){
	$.getJSON(base_url + "users/prices/?user_prices=1", function( res ) {
		if(res.items == ""){
			$("#prices").hide();
		} else {
			$("#prices").show();
		}
		$("#prices").html("");
		$("#prices_tmpl").tmpl(res).appendTo("#prices");
	});
}

function delete_price(id)
{
	$.get(base_url + 'users/delete_price/' + id, function( res ) {
		getResponse(res);
		return false;
	});
}

function get_locations(){
	$.getJSON(base_url + "users/locations/?user_locations=1", function( res ) {
		if(res.items == ""){
			$("#mylocations").hide();
		} else {
			$("#mylocations").show();
		}
		$("#mylocations").html("");
		$("#mylocations_tmpl").tmpl(res).appendTo("#mylocations");
	});
}

function delete_location(id)
{
	$.get(base_url + 'users/delete_location/' + id, function( res ) {
		getResponse(res);
		return false;
	});
}

function checkCart()
{
	$.get(base_url + 'services/check_cart', function( res ) {
		if(res > 0){
			$('#shopping_cart').removeClass('hide');
			$('#shopping_cart .badge').html(res);
		} else {
			$('#shopping_cart').addClass('hide');
		}
	});
}

function getmobile(hash){
    $.get(base_url + 'users/getmobile?hash=' + hash, function(data){
      if(data){
      	$('.ajaxmobile a').html(data);

		var google_conversion_id = 872564745;
		var google_conversion_language = "en";
		var google_conversion_format = "3";
		var google_conversion_color = "ffffff";
		var google_conversion_label = "YyOFCIHP3m0QiZCJoAM";
		var google_remarketing_only = false;

		$.getScript('//www.googleadservices.com/pagead/conversion.js');

		var image = new Image(1, 1);
		image.src = "//www.googleadservices.com/pagead/conversion/872564745/?label=YyOFCIHP3m0QiZCJoAM&guid=ON&script=0";


      }
    });
}

function open_window(url, target, specs)
{
	window.open(
	  url,
	  target,
	  specs
	);
}

var disallowed_characters = {"%": ""};

jQuery(document).ready(function()
{
	function toTitleCase(str)
	{

	}

	$(".tofirstupper").bind("keyup", function(e) {
		if($(this).val().length > 2){
			$(this).val($(this).val().replace(/^[\u00C0-\u1FFF\u2C00-\uD7FF\w]|\s[\u00C0-\u1FFF\u2C00-\uD7FF\w]/g, function(letter){ return letter.toUpperCase(); } ));
		}
	});


	$("input, textarea").bind("keyup", function(e) {
		if($(this).val().indexOf("%") !== -1){
			alert("% işaretinin kullanımı yasaktır. Lütfen yazı ile (%100 yerine yüzde yüz, %40 yerine yüzde kırk vb. şekilde) giriş yapınız.");
			$(this).val($(this).val().replace("%", "yüzde "));
		}
	});

	$(window).load(function(){
		$.each($('[data-name="security-code"]'), function(i, item) {
			var form = $(this).closest('form').find('input[name="form"]').val();
			$.post(base_url + 'users/captcha', 'form=' + form + '&' + $.param(csrf), function(res)
			{
				var r = $.parseJSON(res);
				$(item).html(r.image);
				$('input[name="'+r.csrf_name+'"]').val(r.csrf_hash);
			});
		});

		$('.carousel-wrapper').removeClass('hide');
	});

	var $navbar = $("#navbar").mmenu({
	   "counters": true,
	   "navbar" : {
			"title" : "Menü"
		},
	   "setSelected": {
            "hover": true,
            "parent": true
       },
	   "searchfield": {
		   "placeholder": "Menüde ara...",
		   "resultsPanel": true,
	   },
       "extensions": [
          "effect-menu-zoom",
          "effect-panels-zoom",
          "theme-dark"
       ],
	   "sectionIndexer" : {
			"add" : true,
			"addTo" : "[id*='menu-']"
	   },
       "navbars": [
          {
             "position": "top",
             "content": [
                "searchfield"
             ]
          },
          {
             "position": "bottom",
             "content": [
                "<a class='fa fa-envelope' href='"+base_url+"iletisim.html'></a>",
                "<a class='fa fa-twitter' href='http://twitter.com/netderscom'></a>",
                "<a class='fa fa-facebook' href='http://facebook.com/netderscom'></a>"
             ]
          }
       ]
    },{
     "searchfield": {
        "clear": true
      }
     });

	var $icon = $("#navbar-icon");
	var API = $navbar.data( "mmenu" );

	$icon.on( "click", function() {
	   API.open();
	});

	API.bind( "opened", function() {
	   setTimeout(function() {
	      $icon.addClass( "is-active" );
	   }, 100);
	});
	API.bind( "closed", function() {
	   setTimeout(function() {
	      $icon.removeClass( "is-active" );
	   }, 100);
	});

	// Rewires the default bootstrap hamburger to point to mmenu.
	$(".navbar-header button").removeAttr("data-toggle data-target")
	.removeClass('collapsed')
	.wrap( "<a href='#navbar'></a>" );
	// Pulls removes classes for dropdown menus/submenus
	// TODO: toggle classes instead of remove to make development easier
	$("#navbar li.dropdown").removeClass('dropdown');
	$("#navbar ul.dropdown-menu").removeClass('dropdown-menu');
	$("#navbar .caret").toggleClass('caret');

    $(".scrollto").click(function(event) {
        event.preventDefault();

        var defaultAnchorOffset = 0;

        var anchor = $(this).attr('data-attr-scroll');

        var anchorOffset = $('#'+anchor).attr('data-scroll-offset');
        if (!anchorOffset)
            anchorOffset = defaultAnchorOffset;

        $('html,body').animate({
            scrollTop: $('#'+anchor).offset().top - anchorOffset - 20
        }, 500);

    });

	$("#carousel").owlCarousel({
		stopOnHover: true,
		autoPlay: 3000,
		items : 4,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3]

	});

	$("#carousel2").owlCarousel({

		autoPlay: 3000, //Set AutoPlay to 3 seconds
		items : 2,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3]

	});

	$('.masonry').masonry({
	  // options
	  itemSelector: '.masonry-item',
	  columnWidth: '.masonry-item',
	  percentPosition: true
	});

	$("#town").remoteChained("#city", base_url + "locations/gettowns", {selected: town});
	if($("#city").length){
		$("#city").trigger('change');
	}

	$("#town-search").remoteChained("#city-search", base_url + "locations/gettownssearch", {selected: town});
	if($("#city-search").length){
		$("#city-search").trigger('change');
	}

	$("#level_day").remoteChained("#subject_day", base_url + "services?get_levels=1");
	if($("#subject_day").length){
		$("#subject_day").trigger('change');
	}

	$("#level_week").remoteChained("#subject_week", base_url + "services?get_levels=1");
	if($("#subject_week").length){
		$("#subject_week").trigger('change');
	}

	$("#level_month").remoteChained("#subject_month", base_url + "services?get_levels=1");
	if($("#subject_month").length){
		$("#subject_month").trigger('change');
	}

	$("#level").remoteChained("#subject", base_url + "users/get_levels", {selected: level});
	if($("#subject").length){
		$("#subject").trigger('change');
		$('.js-level-select').removeClass('hide');
	}

	if($('[data-type="count"]').length){
		$.each($('[data-type="count"]'), function(i, item) {
			$(this).next('span').html($(this).attr('data-length') - $(this).val().length + ' karakter kaldı');
		});
	}

	$('[data-type="count"]').on('keyup', function()
	{
		$(this).next('span').html($(this).attr('data-length') - $(this).val().length + ' karakter kaldı');
	});

	$('.js-click-on-loading').on('click', function(){
		var url = $(this).attr('href');
		$(this).removeAttr('href').html('<i class="fa fa-spinner fa-pulse"></i> Lütfen bekleyiniz...');
		location.href = url;
	});

	$('.js-non-original-town-select').on('click', function(){
		$('.js-non-original-town-select').hide();
		$('.js-original-town-select').removeClass('hide');
	});

	$('#subject').on('change', function(){
		$('.js-level-select').removeClass('hide');
	});

	$('#price_new_subject').on('change', function()
	{
		$.get($(this).attr('data-url'), 'subject_id='+$(this).val(), function(res)
		{
			$("#levels").html("");
			$("#levels_tmpl").tmpl(res).appendTo("#levels");
		});
	});

	$('#level_day, #level_week, #level_month').on('change', function(){
		if($(this).val() > 0){
			$.post(base_url + 'services/unavailables', $(this).closest('form').serialize(), function(res){
				var res = $.parseJSON(res);
				return render_daterangepicker(res);
			});
		}
	});

	$('.ajax-location-form #city').on('change', function()
	{
		$.get($(this).attr('data-url'), 'city_id='+$(this).val(), function(res)
		{
			$("#towns").html("");
			$("#towns_tmpl").tmpl(res).appendTo("#towns");
		});
	});

    $('.ajax-form').submit(function() {

	    var options = {
	        beforeSubmit:  setLoader,  // pre-submit callback
	        success:       getResponse  // post-submit callback
	    };

		$(this).ajaxSubmit(options);

		return false;

    });

	$('.ajax-price-form').submit(function()
	{
	    var options = {
	        beforeSubmit:  setLoader,  			// pre-submit callback
	        success:       getResponse  		// post-submit callback
	    };

		$(this).ajaxSubmit(options);

		return false;
	});

	$('.ajax-location-form').submit(function()
	{
	    var options = {
	        beforeSubmit:  setLoader,  				// pre-submit callback
	        success:       getResponse			  	// post-submit callback
	    };

		$(this).ajaxSubmit(options);

		return false;
	});	

	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();

	$(":input").inputmask();

	$(":file:not(.ocupload)").filestyle({icon: false});

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

	$(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});
});

function setLoader(formData, jqForm, options)
{
	jqForm.find(".js-loader").removeClass('hide');
	jqForm.find(".js-submit-btn").hide();
}

function getResponse(responseText, statusText, xhr, form)
{
	var res = $.parseJSON(responseText);

	if(res.CSRF_NAME && res.CSRF_HASH)
	$('input[name="'+res.CSRF_NAME+'"]').val(res.CSRF_HASH);

	if(res.RES == 'ERR')
	{
		$.each(res.MSG, function(i, item) {
		    jgrowl(item, 'red');
		});
	} else {
		$.each(res.MSG, function(i, item) {
		    jgrowl(item);
		});

		if(res.CALL){
			eval(res.CALL);
		}

		if(!$('.ajax-form').hasClass('js-dont-reset'))
		$('.ajax-form').trigger('reset');
	}

	if(res.REDIR){
		jgrowl('<i class="fa fa-refresh fa-pulse fa-fw"></i> Yönlendiriliyorsunuz, lütfen bekleyiniz... Yönlendirme gerçekleşmezse lütfen <a href="'+res.REDIR+'">buraya</a> tıklayınız.');
		setTimeout(function(){
			location.href = res.REDIR;
		}, 5000);
	} else {
		$(".js-loader").addClass('hide');
		$(".js-submit-btn").show();
	}
}

function register_conversation()
{
	var google_conversion_id = 872564745;
	var google_conversion_language = "en";
	var google_conversion_format = "3";
	var google_conversion_color = "ffffff";
	var google_conversion_label = "9qdhCI6c320QiZCJoAM";
	var google_remarketing_only = false;

	$.getScript('//www.googleadservices.com/pagead/conversion.js');

	var image = new Image(1, 1);
	image.src = "//www.googleadservices.com/pagead/conversion/872564745/?label=9qdhCI6c320QiZCJoAM&guid=ON&script=0";

}

function render_daterangepicker(res)
{
	var d = new Date();

	if(res.type == 'day')
	{
		$('.drp-day').removeAttr('readonly');

		if($('.drp-day').data('dateRangePicker')){
			$('.drp-day').data('dateRangePicker').destroy();
		}

		$('.drp-day').dateRangePicker({
			selectForward: true,
			format: 'DD.MM.YYYY',
			separator: ' - ',
			startOfWeek: 'monday',
			maxDays: 1,
			minDays: 1,
			autoClose: true,
			singleDate:true,
			singleMonth:true,
			startDate: (d.getDate()+1)+'.'+(d.getMonth()+1)+'.'+d.getFullYear(),
			language:'tr',
			beforeShowDay: function(t)
			{
				var thedate = moment(t).format('DD.MM.YYYY');

		        if (res.items && $.inArray(thedate, res.items) > -1){
		            return  [false, '', 'Rezerve'];
		        } else {
			        return  [true, '', ''];
		        }
			}
		});
	}

	if(res.type == 'week')
	{
		$('.drp-week').removeAttr('readonly');

		if($('.drp-week').data('dateRangePicker')){
			$('.drp-week').data('dateRangePicker').destroy();
		}

		$('.drp-week').dateRangePicker({
			selectForward: true,
			format: 'DD.MM.YYYY',
			separator: ' - ',
			startOfWeek: 'monday',
			batchMode: 'week',
			language:'tr',
			startDate: (d.getDate()+1)+'.'+(d.getMonth()+1)+'.'+d.getFullYear(),
			autoClose: true,
			beforeShowDay: function(t)
			{
				var thedate = moment(t).format('DD.MM.YYYY');

		        if (res.items && $.inArray(thedate, res.items) > -1){
		            return  [false, '', 'Rezerve'];
		        } else {
			        return  [true, '', ''];
		        }
			}
		});
	}

	if(res.type == 'month')
	{
		$('.drp-month').removeAttr('readonly');

		if($('.drp-month').data('dateRangePicker')){
			$('.drp-month').data('dateRangePicker').destroy();
		}

		$('.drp-month').dateRangePicker({
			selectForward: true,
			format: 'DD.MM.YYYY',
			separator: ' - ',
			startOfWeek: 'monday',
			batchMode: 'month',
			language:'tr',
			startDate: '01.'+(d.getMonth()+2)+'.'+d.getFullYear(),
			autoClose: true,
			beforeShowDay: function(t)
			{
				var thedate = moment(t).format('DD.MM.YYYY');

		        if (res.items && $.inArray(thedate, res.items) > -1){
		            return  [false, '', 'Rezerve'];
		        } else {
			        return  [true, '', ''];
		        }
			}
		});
	}
}

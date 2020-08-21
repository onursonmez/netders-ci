document.addEventListener(
    "DOMContentLoaded", () => {
        const menu = new MmenuLight(
            document.querySelector( "#main-mmenu" )
        );

        const navigator = menu.navigation();
        const drawer = menu.offcanvas();

        document.querySelector( 'a[href="#main-mmenu"]' )
            .addEventListener( 'click', ( evnt ) => {
                evnt.preventDefault();
                drawer.open();
            });
    }
);

$(function()
{
  $(function(){
    $('#rules-txt').modal('show');
  });

  var input = document.querySelector('[data-type="mobile-number"]');
  if(input)
  {
    var iti = intlTelInput(input, {
      utilsScript: base_url + "public/vendor/intl-tel-input/build/js/utils.js?7",
      initialCountry: "tr",
      preferredCountries: ["tr", "de", "us"],
      hiddenInput: "mobile",
    });
  }

  $('[data-type="mobile-number"]').mask('0#');


  $('[data-toggle="tooltip"]').tooltip();
  $('.mask-birthday').mask("00/00/0000", {placeholder: "__/__/____"});
  $(":file").filestyle();
  $(".select2").length && $(".select2").select2({
    theme: 'bootstrap4',
    width: '100%',
  });

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
      $(this).next('small').html($(this).attr('data-length') - $(this).val().length + ' karakter kaldı');
    });
  }

  $('[data-type="count"]').on('keyup', function()
  {
    $(this).next('small').html($(this).attr('data-length') - $(this).val().length + ' karakter kaldı');
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

      $('.lesson-price-inputs').removeClass('d-none');
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

  $('.ajax-form').submit(function()
  {
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

  $.each($('[data-name="security-code"]'), function(i, item) {
    var form = $(this).closest('form').find('input[name="form"]').val();
    $.post(base_url + 'users/captcha', 'form=' + form + '&' + $.param(csrf), function(res)
    {
      var r = $.parseJSON(res);
      $(item).find('div').html(r.image);
      $('input[name="'+r.csrf_name+'"]').val(r.csrf_hash);
    });
  });

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

});

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

    $('[data-toggle="tooltip"]').tooltip();


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
    	$('.ajaxmobile span').html(data);
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

function setLoader(formData, jqForm, options)
{
	jqForm.find(".js-loader").removeClass('d-none');
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
		$(".js-loader").addClass('d-none');
		$(".js-submit-btn").show();
	}
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

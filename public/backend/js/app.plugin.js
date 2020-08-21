+function ($) { "use strict";

  $(function(){

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
    

	$('.money-three').mask('000000.00', {reverse: true});

	$('ul.sf-menu').supersubs({
		minWidth:	12,	 // minimum width of submenus in em units
		maxWidth:	27,	 // maximum width of submenus in em units
		extraWidth:	1	 // extra width can ensure lines don't sometimes turn over
						 // due to slight rounding differences and font-family
	}).superfish();		 // call supersubs first, then superfish, so that subs are
						 // not display:none when measuring. Call before initialising
						 // containing tabs for same reason.

	var $navbar = $("#mobile-menu").mmenu({
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
          "theme-white",
          "border-full",
          "widescreen",
          "pagedim-black"

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

	// sparkline
	var sr, sparkline = function($re){
		$(".sparkline").each(function(){
			var $data = $(this).data();
			if($re && !$data.resize) return;
			($data.type == 'pie') && $data.sliceColors && ($data.sliceColors = eval($data.sliceColors));
			($data.type == 'bar') && $data.stackedBarColor && ($data.stackedBarColor = eval($data.stackedBarColor));
			$data.valueSpots = {'0:': $data.spotColor};
			$(this).sparkline('html', $data);
		});
	};
	$(window).resize(function(e) {
		clearTimeout(sr);
		sr = setTimeout(function(){sparkline(true)}, 500);
	});
	sparkline(false);

	// easypie
	var easypie = function(){
	$('.easypiechart').each(function(){
		var $this = $(this),
		$data = $this.data(),
		$step = $this.find('.step'),
		$target_value = parseInt($($data.target).text()),
		$value = 0;
		$data.barColor || ( $data.barColor = function($percent) {
	        $percent /= 100;
	        return "rgb(" + Math.round(200 * $percent) + ", 200, " + Math.round(200 * (1 - $percent)) + ")";
	    });
		$data.onStep =  function(value){
			$value = value;
			$step.text(parseInt(value));
			$data.target && $($data.target).text(parseInt(value) + $target_value);
		}
		$data.onStop =  function(){
			$target_value = parseInt($($data.target).text());
			$data.update && setTimeout(function() {
		        $this.data('easyPieChart').update(100 - $value);
		    }, $data.update);
		}
			$(this).easyPieChart($data);
		});
	};
	easypie();

	// datepicker
	$('.dp').datepicker({weekStart: 1, format: 'dd.mm.yyyy', autoclose: true});

	$(".time-picker").timepicker({"minuteStep": 5, "showMeridian": false});

	// dropfile
	$('.dropfile').each(function(){
		var $dropbox = $(this);
		if (typeof window.FileReader === 'undefined') {
		  $('small',this).html('File API & FileReader API not supported').addClass('text-danger');
		  return;
		}

		this.ondragover = function () {$dropbox.addClass('hover'); return false; };
		this.ondragend = function () {$dropbox.removeClass('hover'); return false; };
		this.ondrop = function (e) {
		  e.preventDefault();
		  $dropbox.removeClass('hover').html('');
		  var file = e.dataTransfer.files[0],
		      reader = new FileReader();
		  reader.onload = function (event) {
		  	$dropbox.append($('<img>').attr('src', event.target.result));
		  };
		  reader.readAsDataURL(file);
		  return false;
		};
	});

	// slider
	$('.slider').each(function(){
		$(this).slider();
	});

	// sortable
	if ($.fn.sortable) {
	  $('.sortable').sortable();
	}

	// slim-scroll
	$('.no-touch .slim-scroll').each(function(){
		var $self = $(this), $data = $self.data(), $slimResize;
		$self.slimScroll($data);
		$(window).resize(function(e) {
			clearTimeout($slimResize);
			$slimResize = setTimeout(function(){$self.slimScroll($data);}, 500);
		});
    $(document).on('updateNav', function(){
      $self.slimScroll($data);
    });
	});

	// portlet
	$('.portlet').each(function(){
		$(".portlet").sortable({
	        connectWith: '.portlet',
            iframeFix: false,
            items: '.portlet-item',
            opacity: 0.8,
            helper: 'original',
            revert: true,
            forceHelperSize: true,
            placeholder: 'sortable-box-placeholder round-all',
            forcePlaceholderSize: true,
            tolerance: 'pointer'
	    });
    });

	// docs
  $('#docs pre code').each(function(){
	    var $this = $(this);
	    var t = $this.html();
	    $this.html(t.replace(/</g, '&lt;').replace(/>/g, '&gt;'));
	});

	// table select/deselect all
	$(document).on('change', 'table thead [type="checkbox"]', function(e){
		e && e.preventDefault();
		var $table = $(e.target).closest('table'), $checked = $(e.target).is(':checked');
		$('tbody [type="checkbox"]',$table).prop('checked', $checked);
	});

	// random progress
	$(document).on('click', '[data-toggle^="progress"]', function(e){
		e && e.preventDefault();

		var $el = $(e.target),
		$target = $($el.data('target'));
		$('.progress', $target).each(
			function(){
				var $max = 50, $data, $ps = $('.progress-bar',this).last();
				($(this).hasClass('progress-xs') || $(this).hasClass('progress-sm')) && ($max = 100);
				$data = Math.floor(Math.random()*$max)+'%';
				$ps.css('width', $data).attr('data-original-title', $data);
			}
		);
	});

	// add notes
	/*
	function addMsg($msg){
		var $el = $('.nav-user'), $n = $('.count:first', $el), $v = parseInt($n.text());
		$('.count', $el).fadeOut().fadeIn().text($v+1);
		$($msg).hide().prependTo($el.find('.list-group')).slideDown().css('display','block');
	}
	var $msg = '<a href="#" class="media list-group-item">'+
                  '<span class="pull-left thumb-sm text-center">'+
                    '<i class="fa fa-envelope-o fa-2x text-success"></i>'+
                  '</span>'+
                  '<span class="media-body block m-b-none">'+
                    'Sophi sent you a email<br>'+
                    '<small class="text-muted">1 minutes ago</small>'+
                  '</span>'+
                '</a>';
  setTimeout(function(){addMsg($msg);}, 1500);
  */
	//chosen
	$(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});


	$(document).ready(function(){
	   resizeChosen();
	   jQuery(window).on('resize', resizeChosen);
	});


  });

function resizeChosen() {
	setTimeout(function(){
	   $(".chosen-container").each(function() {
	       $(this).attr('style', 'width: 100%');
	   });
	}, 100);
}
$.fn.faderEffect = function(options){
    options = jQuery.extend({
    	count: 3, // how many times to fadein
    	speed: 500, // spped of fadein
    	callback: false // call when done
    }, options);

    return this.each(function(){

    	// if we're done, do the callback
    	if (0 == options.count)
    	{
    		if ( $.isFunction(options.callback) ) options.callback.call(this);
    		return;
    	}

    	// hide so we can fade in
    	if ( $(this).is(':visible') ) $(this).hide();

    	// fade in, and call again
    	$(this).fadeIn(options.speed, function(){
    		options.count = options.count - 1; // countdown
    		$(this).faderEffect(options);
    	});
    });
}

}(window.jQuery);

function strip_tags(input, allowed) {
  //  discuss at: http://phpjs.org/functions/strip_tags/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Luke Godfrey
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  //    input by: Pul
  //    input by: Alex
  //    input by: Marc Palau
  //    input by: Brett Zamir (http://brett-zamir.me)
  //    input by: Bobby Drake
  //    input by: Evertjan Garretsen
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Onno Marsman
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Eric Nagel
  // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // bugfixed by: Tomasz Wesolowski
  //  revised by: Rafał Kukawski (http://blog.kukawski.pl/)
  //   example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>');
  //   returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
  //   example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
  //   returns 2: '<p>Kevin van Zonneveld</p>'
  //   example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
  //   returns 3: "<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>"
  //   example 4: strip_tags('1 < 5 5 > 1');
  //   returns 4: '1 < 5 5 > 1'
  //   example 5: strip_tags('1 <br/> 1');
  //   returns 5: '1  1'
  //   example 6: strip_tags('1 <br/> 1', '<br>');
  //   returns 6: '1 <br/> 1'
  //   example 7: strip_tags('1 <br/> 1', '<br><br/>');
  //   returns 7: '1 <br/> 1'

  allowed = (((allowed || '') + '')
    .toLowerCase()
    .match(/<[a-z][a-z0-9]*>/g) || [])
    .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
    commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return input.replace(commentsAndPhpTags, '')
    .replace(tags, function($0, $1) {
      return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
    });
}

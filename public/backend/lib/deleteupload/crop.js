
/******************************************************************************
 *
 *	PROJECT: Flynax Classifieds Software
 *	VERSION: 4.0
 *	LISENSE: http://www.flynax.com/license-agreement.html
 *	PRODUCT: General Classifieds
 *	
 *	FILE: CROP.JS
 *
 *	This script is a commercial software and any kind of using it must be 
 *	coordinate with Flynax Owners Team and be agree to Flynax License Agreement
 *
 *	This block may not be removed from this file or any other files with out 
 *	permission of Flynax respective owners.
 *
 *	Copyrights Flynax Classifieds Software | 2012
 *	http://www.flynax.com/
 *
 ******************************************************************************/

$(document).ready(function(){
	crop_handler();
});

var coefficient;
var crop_photo_id;

function crop_handler()
{
	$('#crop_accept').unbind('click');
	$('img.crop').unbind('click');
	$('#crop_cancel').unbind('click');

	$('img.crop').click(function(){
		var add_style = '';
		crop_photo_id = $(this).attr('id').split('_')[2];
		var img_source = $(this).attr('dir');

		$('#fileupload img.delete,#fileupload img.crop').show();
		
		$('img.crop').slideto({
			target : '#crop_block',
			speed  : 'slow'
		});
		
		$(this).hide();
		$(this).parent().parent().find('img.delete').hide();
		$(this).parent().find('span.primary').hide().after('<span class="loading">Yükleniyor...</span>');
		var self = this;
		
		var img_obj = new Image();
		img_obj.onload = function(){
			build_interface(img_obj, add_style, img_source);
			$(self).parent().find('span.primary').show();
			$(self).parent().find('span.loading').remove();
		}
		img_obj.src = img_source;
	});
	
	function build_interface(img_obj, add_style, img_source)
	{
		coefficient = 1;
		
		var area_width = $('#width_detect').width();
		if ( img_obj.width >= area_width )
		{
			coefficient = img_obj.width/area_width;
			add_style = 'width: '+(area_width-30)+'px;';
		}
		
		var html = '<img style="'+add_style+'" src="'+img_source+'" />';
		$('#crop_obj').html(html);
		
		$('#crop_block').fadeIn('slow', function(){
			var crop = $.Jcrop('#crop_block img',{
				bgOpacity: .5,
		        bgColor: 'white',
		        addClass: 'jcrop-light',
				//aspectRatio: photo_width / photo_height,
				onChange: showCoords,
				onSelect: showCoords,
				keySupport: false
			});
			
			/*
			var aspectX = Math.floor(img_obj.width / coefficient);
			var aspectY = Math.floor(img_obj.height / coefficient);
			if ( aspectX > aspectY )
			{
				aspectX = Math.floor(aspectY * photo_width / photo_height);
			}
			else
			{
				aspectY = Math.floor(aspectX * photo_height / photo_width);
			}
			*/
			
			//crop.animateTo([0, 0, aspectX, aspectY]);
		});
	}
	
	$('#crop_cancel').click(function(){
		$('#crop_block').slideUp('slow');
		$('#navbar_'+crop_photo_id+' img.crop').show();
		$('#navbar_'+crop_photo_id).parent().find('img.delete').show();
	});
	
	function showCoords(c)
	{
		cx = Math.floor(c.x*coefficient);
		cy = Math.floor(c.y*coefficient);
		cx2 = Math.floor(c.x2*coefficient);
		cy2 = Math.floor(c.y2*coefficient);
		cw = Math.floor(c.w*coefficient);
		ch = Math.floor(c.h*coefficient);
	}
	
	$('#crop_accept').click(function(){
		crop();
	});
	
	this.crop = function()
	{
		if ( !cw || !ch )
		{
			error_text = ph_empty_error;
			error = true;
		}
		else
		{
			if ( cw < photo_width)
			{
				error_text = ph_too_small_error;
				error = true;
			}
			else
			{
				error = false;
			}
		}
		
		if ( error )
		{
			alert(error_text);
		}
		else
		{
			$('#crop_cancel').fadeOut('fast');
			$('#crop_accept').val("Yükleniyor...");
			var coords = new Array(cx, cy, cx2, cy2, cw, ch);
			$.ajax({
				type:'POST',
				data: '&coords='+coords+'&id='+crop_photo_id,
				dataType: 'json',
				url:base_url+'admin/'+photo_module+'/cropPhotos',
				success:function results(msg){
					$('#crop_block').slideUp('slow');
					$('#navbar_'+crop_photo_id+' img.crop').show();
					$('#navbar_'+crop_photo_id).parent().find('img.delete').show();
					$('#navbar_'+crop_photo_id).parent().find('img.thumbnail').attr('src', ''+msg.thumbnail+'');
					$('#crop_accept').val('Onayla');
					$('#crop_cancel').show();
					$.jGrowl(msg.text);
				}
			});
		}
	}
}
$(document).ready(function(){
	//file upload
	$('#fileupload input[type=file]').attr('multiple', true);
	$('#fileupload').fileupload();
	
	if ( photo_allowed == undefined )
	{
		$('#fileupload span.draft span.allowed').hide();
	}
	
	$.getJSON($('#fileupload form').prop('action'), function (files) {
		var fu = $('#fileupload').data('blueimpFileupload'),
		template;
		fu._adjustMaxNumberOfFiles(-files.length);
		fu._renderDownload(files)
			.appendTo($('#fileupload .files'))
			.fadeIn(function () {
				$(this).show();
				managePhotoDesc();
				crop_handler();
		});
	});
});

function startFormOptions(t){
	if(t){
		$(".loads").show();
		$(".submitter").hide();
	}else{
		$(".loads").hide();
		$(".submitter").show();
		setTimeout(function(){
			$('select.hide').select2().show();
		},500);
	}

}

function checkImage(form_class){
	if($('.preview').length){
		$('a#toTop').trigger('click');
		jAlert('Seçtiğiniz fotoğrafları yüklemek için yükle butonuna basınız.', 'Fotoğraflar Yüklenmedi');
	} else {
		$("form."+form_class).submit();
	}
}

var makeMain = function(id, module_id){
	$.ajax({
		type:'POST',
		data: '&id='+id+'&module_id='+module_id,
		url:base_url+'admin/'+photo_module+'/mainPhotos',
		success:function results(msg){
			$('div#fileupload span.item div.photo_navbar span.primary span').hide();
			$('div#fileupload span.item div.photo_navbar a.makeMain').show();
			
			$('div.#navbar_'+id).find('a.makeMain').hide();
			$('div.#navbar_'+id).find('span.primary span').show();
			$.growl(msg, {type	: 'success'});
		}
	});
};

var editDesc = function(id, description){
	$.ajax({
		type:'POST',
		data: 'description='+description+'&id='+id,
		url:base_url+'admin/'+photo_module+'/descPhotos',
		success:function results(msg){
			$.growl(msg, {type	: 'success'});
		}
	});
	$('div.#navbar_'+id+' input').hide();
	$('div.#navbar_'+id).find('img.edit,img.crop,span.primary').show();
	return false;
};

var setLanguage = function(id, language){	
	$.ajax({
		type:'POST',
		data: 'language='+language+'&id='+id,
		url:base_url+'admin/'+photo_module+'/langPhotos',
		success:function results(msg){
			$.growl(msg, {type	: 'success'});
		}
	});
	return false;
};

var submit_photo_step = function(){
	var not_saved = $('#fileupload span.template-upload').length;
	if ( not_saved > 0 )
	{
		$('#fileupload span.template-upload').addClass('suspended');
		printMessage('warning', lang['unsaved_photos_notice'].replace('{number}', not_saved));
		
		return false;
	}
	else
	{
		return true;
	}
};

var managePhotoDesc = function(){
	$('#fileupload div.photo_navbar img.edit')
		.unbind('click')
		.click(function(){
			var parent = $(this).parent();
			var id = $(parent).attr('id');
			$(parent).find('span.primary, img.edit, img.crop').hide();
			$(parent).find('input').show();
	});
	
	$("#fileupload span.files").sortable({
		items: 'span.item:not(.template-upload)',
		placeholder: 'hover',
		handle: 'img.thumbnail',
		start: function(event, obj){
			$(obj.item).find('div.photo_navbar').hide();
		},
		stop: function(event, obj){
			$(obj.item).find('div.photo_navbar').show();
			var sort = '';
			var count = 0;
			$('#fileupload span.files span.template-download div.photo_navbar').each(function(){
				var id = $(this).attr('id').split('_')[1];
				count++;
				var pos = $('#fileupload span.files span.item').index($(this).parent())+1;
				//sort += id+','+pos+';';
				sort += id+';';
			});
			
			if ( sort.length > 0 && count > 1 && sort_save != sort )
			{
				sort_save = sort;
				sort = rtrim(sort, ';');
				$.ajax({
					type:'POST',
					data: '&id='+module_id+'&sort='+sort,
					url:base_url+'admin/'+photo_module+'/sortPhotos',
					success:function results(msg){
						$.growl(msg, {type	: 'success'});
					}
				});
			}
		}
	});
};
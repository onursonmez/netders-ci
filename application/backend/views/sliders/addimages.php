<section class="panel panel-default">
<header class="panel-heading text-right bg-light">
  <ul class="nav nav-tabs pull-left">
    <li class="active"><a href="#info" data-toggle="tab"><i class="fa fa-info"></i> Görsel Bilgileri</a></li>
    <?if(strstr(uri_string(), 'editimages') == TRUE):?>
    <li><a href="#images" data-toggle="tab"><i class="fa fa-camera text-muted"></i> Görseller</a></li>
    <?endif;?>
  </ul>
  <span><a href="<?=base_url('backend/sliders/images')?>/<?if(isset($item->slider_id)):?><?=$item->slider_id?><?else:?><?=$this->uri->segment(4)?><?endif;?>"><i class="fa fa-reply"></i> Geri Dön</a></span>
</header>
<div class="panel-body">
  <form autocomplete="off" method="post" action="<?=base_url('backend/'.$this->uri->segment(2))?><?if(strstr(uri_string(), 'addimages') == TRUE):?>/addimages<?else:?>/editimages<?endif;?>/<?=$this->uri->segment(4)?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">
  <div class="tab-content">
    <div class="tab-pane active" id="info">
                                
		<div class="form-group">
			<label class="col-lg-2 control-label">Bağlantı Tipi</label>
			<div class="col-lg-10">
		        <select name="link_type" class="form-control link_type">
	                <option value="url"<?if((isset($_REQUEST['link_type']) && $_REQUEST['link_type'] == 'url') || (isset($item->link_type) && $item->link_type == 'url')):?> selected<?endif;?>>Dış Bağlantı (URL)</option>
	                <option value="inurl"<?if((isset($_REQUEST['link_type']) && $_REQUEST['link_type'] == 'inurl') || (isset($item->link_type) && $item->link_type == 'inurl')):?> selected<?endif;?>>İç Bağlantı (URL)</option>
	                <option value="home"<?if((isset($_REQUEST['link_type']) && $_REQUEST['link_type'] == 'home') || (isset($item->link_type) && $item->link_type == 'home')):?> selected<?endif;?>>Ana Sayfa</option>
	                <option value="contents_categories"<?if((isset($_REQUEST['link_type']) && $_REQUEST['link_type'] == 'contents_categories') || (isset($item->link_type) && $item->link_type == 'contents_categories')):?> selected<?endif;?>>Kategori</option>
	                <option value="contents"<?if((isset($_REQUEST['link_type']) && $_REQUEST['link_type'] == 'contents') || (isset($item->link_type) && $item->link_type == 'contents')):?> selected<?endif;?>>İçerik</option>
		        </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-lg-2 control-label">Bağlantı Adresi</label>
			<div class="col-lg-10">
				<input type="text" name="link_value" class="form-control link_value" value="<?if(isset($_REQUEST['link_value'])):?><?=htmlspecialchars($_REQUEST['link_value'])?><?else:?><?if(isset($item)):?><?=htmlspecialchars(parse_menu_link_value($item->link_type, $item->link_value))?><?endif;?><?endif;?>" />
			</div>
		</div>
		
	    <div class="form-group">
	    	<label class="col-lg-2 control-label">Hedef</label>
	    	<div class="col-lg-10">
	    		<select name="link_target" class="form-control">
	    			<option value="self"<?if(isset($_REQUEST['link_target']) && $_REQUEST['link_target'] == 'self' || isset($item) && $item->link_target == 'self'):?> selected<?endif;?>>Aynı pencere</option>
	    			<option value="blank"<?if(isset($_REQUEST['link_target']) && $_REQUEST['link_target'] == 'blank' || isset($item) && $item->link_target == 'blank'):?> selected<?endif;?>>Yeni pencere</option>
	    		</select>
	    	</div>
	    </div>

		<div class="form-group">
			<label class="col-lg-2 control-label">Aktif Bölümler</label>
			<div class="col-lg-10">
			<?
				if(isset($item->lang_code)){
					$item->lang_code = explode(',', $item->lang_code);
				}
			?>
                <?foreach(site_languages(true) as $language):?>
                    <input name="languages[]" type="checkbox" value="<?=$language->lang_code?>"<?if(isset($item->lang_code) && $item->lang_code && in_array($language->lang_code, $item->lang_code)):?> checked<?endif;?> id="lang_<?=$language->lang_code?>"> <label for="lang_<?=$language->lang_code?>"><?=$language->name?></label>&nbsp;&nbsp;&nbsp;
                <?endforeach;?>
			</div>
		</div>	
			    		
		<input type="hidden" name="link_id" class="link_id" value="<?if(isset($_REQUEST['link_id'])):?><?=htmlspecialchars($_REQUEST['link_id'])?><?else:?><?if(isset($item->link_value)):?><?=htmlspecialchars($item->link_value)?><?endif;?><?endif;?>" />


		<?if(strstr(uri_string(), 'addimages') == TRUE):?>
			<button class="btn btn-default pull-right m-t" type="submit" name="submit">İLERİ</button>
		<?else:?>
			<button class="btn btn-default pull-right m-t" type="submit" onclick="return checkImage('form-horizontal');">KAYDET</button>
		<?endif;?>

    </div>
    </form>
    
<script type="text/javascript">
    $(function() {
		
		$(".link_type").each(function(){
			var link_type = $('.link_type');
			var link_value = $('.link_value');
			var link_id = $('.link_id');
			if((link_type.val() == 'contents' || link_type.val() == 'contents_categories') && link_id.val() == ''){
				link_value.val('');
			}
		});	
	
		$(".link_type").change(function(){
			$('.link_value').val('');
			$('.link_id').val('');
		});
		
		$(".link_value").keyup(function(){
			var link_type = $('.link_type option:selected').val();
			if(link_type == 'contents' || link_type == 'contents_categories')
			{
				$(".link_value").autocomplete({
					minLength: 1,
					source: function( request, response ) {
						var term = request.term;
			
						$.getJSON( base_url+"backend/menus/autoComplete/?type="+link_type, request, function( data, status, xhr ) {
							//cache[ term ] = data;
							 response($.map(data, function(item) {
								return {
									value: item.text,
									label: item.text,
									item_id: item.id
								}
							 }));
						});
					},
				    messages: {
				        noResults: 'bulunamadı',
				        results: function() {}
				    },
					select	: function( event, ui ) {
						$(".link_id").val(ui.item.item_id);
					}
				});		
			}
		});		    

	});		
</script>			
    
	<?if(strstr(uri_string(), 'edit') == TRUE):?>
	<div class="tab-pane" id="images">
		<!-- blueimp Gallery styles -->
		<link rel="stylesheet" href="<?=base_url('public/backend/lib/fileupload/css/blueimp-gallery.min.css')?>">
		<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
		<link rel="stylesheet" href="<?=base_url('public/backend/lib/fileupload/css/jquery.fileupload.css')?>">
		<link rel="stylesheet" href="<?=base_url('public/backend/lib/fileupload/css/jquery.fileupload-ui.css')?>">
		<!-- CSS adjustments for browsers with JavaScript disabled -->
		<noscript><link rel="stylesheet" href="<?=base_url('public/backend/lib/fileupload/css/jquery.fileupload-noscript.css')?>"></noscript>
		<noscript><link rel="stylesheet" href="<?=base_url('public/backend/lib/fileupload/css/jquery.fileupload-ui-noscript.css')?>"></noscript>
	    <!-- The file upload form used as target for the file upload widget -->
	    <form id="fileupload" action="<?=current_url()?>" method="POST" enctype="multipart/form-data">
	        <!-- Redirect browsers with JavaScript disabled to the origin page -->
	        <noscript><input type="hidden" name="redirect" value="<?=current_url()?>"></noscript>

	        <!-- The table listing the files available for upload/download -->
	        	<div class="row files-layer">
	        		<span class="fileupload-process pull-left m-r"></span>
	        		<div class="files"></div>
					<div class="col-xs-12 col-sm-4 col-md-2 add-more-div">
						<a><div class="thumbnail add-more fileinput-button">
							<input type="file" name="files[]" multiple>
							<div class="m-t-lg">&nbsp;
							<div class="m-t">
								<i class="fa fa-3x fa-camera"></i><br />
								Resim Ekle<br />
								<small class="text-muted">Buraya tıklayarak resim yükleyebilirsiniz</small>
							</div>
							</div>
						</div></a>
					</div>
	        	</div>

	        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
	        <div class="row fileupload-buttonbar">
	                <!-- The fileinput-button span is used to style the file input field as button -->
	                <!--
	                <span class="btn btn-success fileinput-button">
	                    <span>Add files... 20 adet kaldı</span>
	                    <input type="file" name="files[]" multiple>
	                </span>
	                <button type="submit" class="btn btn-primary start">
	                    <i class="fa fa-upload"></i>
	                    <span>Tümünü Yükle</span>
	                </button>
	                -->
	                <!-- The global file processing state -->
	            <!-- The global progress state -->
	            <div class="col-lg-5 fileupload-progress fade">
	                <!-- The global progress bar -->
	                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
	                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
	                </div>
	                <!-- The extended global progress state -->
	                <div class="progress-extended">&nbsp;</div>
	            </div>
	        </div>
	    </form>
	
		<!-- The blueimp Gallery widget -->
		<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
		    <div class="slides"></div>
		    <h3 class="title"></h3>
		    <a class="prev">‹</a>
		    <a class="next">›</a>
		    <a class="close">×</a>
		    <a class="play-pause"></a>
		    <ol class="indicator"></ol>
		</div>
		<!-- The template to display files available for upload -->
		<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
	        <div class="col-xs-12 col-sm-4 col-md-2 template-upload fade" id="photo-{%=file.id%}">
	          <div class="thumbnail">
	          	<div class="thumbnail-image preview text-center">
	          	</div>
	            <div class="caption">
				  <strong class="error text-danger"></strong>
	              <p class="text-ellipsis name m-b-none">
					{%=file.name%}
	              </p>
				  <small class="text-muted"><p class="size"></p></small>
				  <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
		            {% if (!i && !o.options.autoUpload) { %}
		                <button class="btn btn-primary start" data-toggle="tooltip" title="<?=lang('UPLOAD')?>" disabled>
		                    <i class="fa fa-upload"></i>
		                </button>
		            {% } %}
		            {% if (!i) { %}
		                <button class="btn btn-danger cancel" data-toggle="tooltip" title="<?=lang('CANCEL')?>">
		                    <i class="fa fa-times-circle-o"></i>
		                </button>
		            {% } %}	        
	            </div>
	          </div>
	        </div>
		{% } %}
		</script>
		<!-- The template to display files available for download -->
		<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
        <div class="col-xs-12 col-sm-4 col-md-2 template-download fade" id="photo-{%=file.id%}">
          <div class="thumbnail">
          	<div class="thumbnail-image">
            {% if (file.thumbnail_url) { %}
            <a href="{%=file.thumbnail_url%}" title="{%=file.thumbnail_name%}" data-gallery><img src="{%=file.thumbnail_url%}" alt="{%=file.thumbnail_name%}" class="thumb-{%=file.id%}" id="thumb-{%=file.id%}" /></a>
            {% } %}
          	</div>
            <div class="caption text-center m-t">
				{% if (file.error) { %}
				    <p><span class="label label-danger"><?=lang('ERROR')?></span> {%=file.error%}</p>
				{% } %}
              <p class="text-ellipsis m-b-none">
				{% if (file.thumbnail_url) { %}
				    <a href="{%=file.thumbnail_url%}" title="{%=file.thumbnail_name%}" download="{%=file.thumbnail_name%}" {%=file.thumbnail_url?'data-gallery':''%}>{%=file.thumbnail_name%}</a>
				{% } else { %}
				    {%=file.thumbnail_name%}
				{% } %}
              </p>
			  <div class="m-t-xs"><small class="text-muted">{%=o.formatFileSize(file.thumbnail_size)%}</small></div>
			  <div class="clearfix m-t"></div>
				<div class="text-center">
				{% if (file.delete_url) { %}
					{% if (file.primary) { %}
					    <button class="btn btn-primary btn-xs makemain" data-id="{%=file.id%}" data-toggle="tooltip" title="<?=lang('MAIN_PHOTO')?>" onclick="makeMain('{%=file.id%}', '{%=file.module_id%}'); return false;">
					        <i class="fa fa-star"></i>
					    </button>
				    {% } else { %}
					    <button class="btn btn-primary btn-xs" data-id="{%=file.id%}" data-toggle="tooltip" title="<?=lang('MAKE_MAIN_PHOTO')?>" onclick="makeMain('{%=file.id%}', '{%=file.module_id%}'); return false;">
					        <i class="fa fa-star-o"></i>
					    </button>
				    {% } %}
				    
				    <button class="btn btn-primary btn-xs{% if (file.description) { %} yellow-text{% } %} desc-{%=file.id%}" data-toggle="tooltip" title="<?=lang('EDIT_DESC')?>" onclick="managePhotoDesc('{%=file.id%}'); return false;">
				        <i class="fa fa-pencil"></i>
				    </button>
				    
				    <button class="btn btn-primary btn-xs globe-{%=file.id%}" data-toggle="tooltip" title="<?=lang('EDIT_GLOBE')?>" onclick="managePhotoGlobe('{%=file.id%}', '{%=file.lang_code%}'); return false;">
				        {% if (file.lang_code == 'all') { %}
				        <i class="fa fa-globe"></i>
				        {% } else { %}
				        <i class="flag flag-{%=file.lang_code%}"></i>
				        {% } %}	
				    </button>

				    <button class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?=lang('CROP_SMALL_PIC')?>" onclick="cropThumb({%=file.id%}, '{%=file.original_url%}', '{%=file.original_local%}', '{%=file.thumbnail_local%}', '{%=file.original_width%}', '{%=file.original_height%}'); return false;">
				        <i class="fa fa-expand"></i>
				    </button>
				    				    
				    <button class="btn btn-primary btn-xs" data-toggle="tooltip" title="<?=lang('CROP_LARGE_PIC')?>" onclick="cropLarge({%=file.id%}, '{%=file.original_url%}', '{%=file.original_local%}', '{%=file.large_local%}', '{%=file.large_url%}', '{%=file.original_width%}', '{%=file.original_height%}'); return false;">
				        <i class="fa fa-lg fa-expand"></i>
				    </button>
				    
				    <button class="btn btn-primary btn-xs delete" data-toggle="tooltip" title="<?=lang('DELETE')?>" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				        <i class="fa fa-trash-o"></i>
				    </button>
				{% } else { %}
				    <button class="btn btn-warning cancel" data-toggle="tooltip" title="<?=lang('CANCEL')?>">
				        <i class="fa fa-xxs fa-trash-o"></i>
				        <span>İptal</span>
				    </button>
				{% } %}	
				</div>	        
            </div>
          </div>
          <input type="hidden" name="description" value="{%=file.description%}">
        </div>
                    
		{% } %}
		</script>
	</div>
		
	<!-- fileupload tools start -->
	<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/vendor/jquery.ui.widget.js')?>"></script>
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/tmpl.js')?>"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/load-image.min.js')?>"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/canvas-to-blob.min.js')?>"></script>
	<!-- blueimp Gallery script -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.blueimp-gallery.min.js')?>"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.iframe-transport.js')?>"></script>
	<!-- The basic File Upload plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload.js')?>"></script>
	<!-- The File Upload processing plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload-process.js')?>"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload-image.js')?>"></script>
	<!-- The File Upload audio preview plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload-audio.js')?>"></script>
	<!-- The File Upload video preview plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload-video.js')?>"></script>
	<!-- The File Upload validation plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload-validate.js')?>"></script>
	<!-- The File Upload user interface plugin -->
	<script src="<?=base_url('public/backend/lib/fileupload/js/jquery.fileupload-ui.js')?>"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="<?=base_url('public/backend/lib/fileupload/js/cors/jquery.xdr-transport.js')?>"></script>
	<![endif]-->
	
	<script type="text/javascript">
	    $(function() {    
			//Jquery file upload start
		    // Initialize the jQuery File Upload widget:
		    $('#fileupload').fileupload({
		        // Uncomment the following to send cross-domain cookies:
		        //xhrFields: {withCredentials: true},
		        url: base_url+'backend/<?=$this->uri->segment(2)?>/photos/'+<?=$this->uri->segment(4)?>,
			    previewMaxWidth : 90,
			    previewMaxHeight : 90,
			    add : function(e, data) {
			        data.submit();
			        setTimeout(function(){
				        $('[data-toggle="tooltip"]').tooltip();
				        /*
				        $('[data-toggle="popover"]').popover({ trigger: "hover" });
					    $('[data-toggle="popover"]').bind('click', function(){
					    	return false;
					    });
					    */
			        }, 500);
			    }
		    });
		
		    // Enable iframe cross-domain access via redirect option:
		    /*
		    $('#fileupload').fileupload(
		        'option',
		        'redirect',
		        window.location.href.replace(
		            /\/[^\/]*$/,
		            '/cors/result.html?%s'
		        )
		    );
		    */
			
			// Load existing files:
	        $('#fileupload').addClass('fileupload-processing');
	        $.ajax({
	            // Uncomment the following to send cross-domain cookies:
	            //xhrFields: {withCredentials: true},
	            url: $('#fileupload').fileupload('option', 'url'),
	            dataType: 'json',
	            context: $('#fileupload')[0],
	        }).always(function () {
	            $(this).removeClass('fileupload-processing');
	        }).done(function (result) {
	            $(this).fileupload('option', 'done')
	                .call(this, $.Event('done'), {result: result});
	        });
		    // Jquery file upload end

	    });
	    
		var makeMain = function(id, module_id){
			$.ajax({
				type:'POST',
				data: '&id='+id+'&module_id='+module_id,
				url:base_url+'backend/<?=$this->uri->segment(2)?>/mainPhotos',
				success:function results(msg){
					$('i.fa-star').removeClass('fa-star').addClass('fa-star-o').attr('title', '<?=lang('MAKE_MAIN_PHOTO')?>').attr('data-original-title', '<?=lang('MAKE_MAIN_PHOTO')?>');
					$('button[data-id="'+id+'"] i').removeClass('fa-star-o').addClass('fa-star').attr('title', '<?=lang('MAIN_PHOTO')?>').attr('data-original-title', '<?=lang('MAIN_PHOTO')?>');

					$('.makemain').attr('title', '<?=lang('MAKE_MAIN_PHOTO')?>').attr('data-original-title', '<?=lang('MAKE_MAIN_PHOTO')?>');
					$('button[data-id="'+id+'"]').attr('title', '<?=lang('MAIN_PHOTO')?>').attr('data-original-title', '<?=lang('MAIN_PHOTO')?>');
					$.growl(msg, {type	: 'success'});
				}
			});
		};
		
		var managePhotoDesc = function(id){
			$('#manage-photo-desc .photo_description').val($('#photo-'+id+' input[name="description"]').val());
			$('#manage-photo-desc .photo_id').val(id);
			$('#manage-photo-desc').modal('show');
		};
		
		var editDesc = function()
		{
			var photo_id 		= $('.photo_id').val();
			var description 	= $('.photo_description').val();
			
			if(description){
				$('.desc-'+photo_id).addClass('yellow-text');
			} else {
				$('.desc-'+photo_id).removeClass('yellow-text');
			}
			
			$('#photo-'+photo_id+' input[name="description"]').val(description);
			$.ajax({
				type:'POST',
				data: 'description='+description+'&id='+photo_id,
				url:base_url+'backend/<?=$this->uri->segment(2)?>/descPhotos',
				success:function results(msg){
					$.growl(msg, {type	: 'success'});
				}
			});
		};
		
		var managePhotoGlobe = function(id, lang_code){
			$(".photo_globe option").prop('selected',false);
			$('.photo_globe option[value='+lang_code+']').prop('selected',true);
			$('#manage-photo-globe .photo_id').val(id);
			$('#manage-photo-globe').modal('show');
		};
		
		var editGlobe = function(){
			
			var photo_id 	= $('#manage-photo-globe .photo_id').val();
			var lang_code 	= $('#manage-photo-globe .photo_globe').val();
			
			$.ajax({
				type:'POST',
				data: 'language='+lang_code+'&id='+photo_id,
				url:base_url+'backend/<?=$this->uri->segment(2)?>/langPhotos',
				success:function results(msg){
					$.growl(msg, {type	: 'success'});
				    $('.globe-'+photo_id).removeAttr('onclick');
				    $('.globe-'+photo_id).attr('onclick', 'managePhotoGlobe(\''+photo_id+'\', \''+lang_code+'\'); return false;');				
				    $('.globe-'+photo_id+' i').removeAttr('class').addClass('flag flag-'+lang_code);
				}
			});
		};
	</script>
	
	<div class="modal" id="manage-photo-desc" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Açıklamayı Düzenle</h4>
				</div>
				<div class="modal-body">
					<input type="text" name="photo_description" class="form-control photo_description" />
					<input type="hidden" class="photo_id" name="id" />
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-default" data-dismiss="modal">İptal</a>
					<a href="#" class="btn btn-primary" data-dismiss="modal" onclick="editDesc();">Kaydet</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<div class="modal" id="manage-photo-globe" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Bu resim hangi dillerde yayınlanacaktır?</h4>
				</div>
				<div class="modal-body">
					<select name="photo_globe" class="photo_globe form-control">
					<option value="all">Tümü</option>
					<?foreach(site_languages(true) as $language):?>
					<option value="<?=$language->lang_code?>"><?=$language->name?></option>
					<?endforeach;?>
					</select>				
					<input type="hidden" class="photo_id" name="id" />
				</div>
				<div class="modal-footer">
					<a href="#" class="btn btn-default" data-dismiss="modal">İptal</a>
					<a href="#" class="btn btn-primary" data-dismiss="modal" onclick="editGlobe();">Kaydet</a>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	
	
	<!-- fileupload tools end -->
	<?endif;?>
  </div>
</div>
</section>

<link href="<?=base_url('public/backend/lib/croppic/assets/css/croppic.css')?>" rel="stylesheet">
<script src="<?=base_url('public/backend/lib/croppic/croppic.js')?>"></script>

<script>
	var cropThumb = function(photoId, imageUrl, origPath, savePath, originalWidth, originalHeight){

    	<?if(empty($GLOBALS['settings_global']->photo_thumb_width) || empty($GLOBALS['settings_global']->photo_thumb_height)):?>
			var screenImage = $('#thumb-'+photoId);
			var theImage = new Image();
			theImage.src = screenImage.attr("src");
	    	var width	= theImage.width+'px';
	    	var height	= theImage.height+'px';
    	<?else:?>
	    	var width	= '<?=$GLOBALS['settings_global']->photo_thumb_width?>px';
	    	var height	= '<?=$GLOBALS['settings_global']->photo_thumb_height?>px';    	
    	<?endif;?>
    	
		$('#cropThumb').hide();
		$('body').append('<div id="cropThumb" />');
		$('#cropThumb').css({"width":width, "height":height, "position":"relative"});
		var cropThumbModal = new Croppic(photoId, 'cropThumb', {
				"originalWidth": originalWidth,
				"originalHeight": originalHeight,
				"imageUpdate": true,
				"imageUrl": imageUrl,
				cropData:{
					"origPath": origPath,
					"savePath": savePath
				},
				cropUrl:'<?=site_url('backend/'.$this->uri->segment(2).'/crophere')?>',
				modal:true,
				imgEyecandyOpacity:0.4,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
		});
	};
	
	var cropLarge = function(photoId, imageUrl, origPath, savePath, largeUrl, originalWidth, originalHeight){

    	<?if(empty($GLOBALS['settings_global']->photo_large_width) || empty($GLOBALS['settings_global']->photo_large_height)):?>
			var screenImage = $('#thumb-'+photoId);
			var theImage = new Image();
			theImage.src = largeUrl;
	    	var width	= theImage.width+'px';
	    	var height	= theImage.height+'px';
    	<?else:?>
	    	var width	= '<?=$GLOBALS['settings_global']->photo_large_width?>px';
	    	var height	= '<?=$GLOBALS['settings_global']->photo_large_height?>px';    	
    	<?endif;?>
    	
		$('#cropThumb').hide();
		$('body').append('<div id="cropThumb" />');
		$('#cropThumb').css({"width":width, "height":height, "position":"relative"});
		var cropLargeModal = new Croppic(photoId, 'cropThumb', {
				"originalWidth": originalWidth,
				"originalHeight": originalHeight,
				"imageUrl": imageUrl,
				cropData:{
					"origPath": origPath,
					"savePath": savePath
				},
				cropUrl:'<?=site_url('backend/'.$this->uri->segment(2).'/crophere')?>',
				modal:true,
				imgEyecandyOpacity:0.4,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
		});
	};
</script>


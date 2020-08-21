<? $languages = site_languages(true); ?>

<section class="panel panel-default">
<header class="panel-heading bg-light">
  <ul class="nav nav-tabs">
    <?foreach($languages as $lang):?>
    <li<?if($lang->lang_code == DESCR_SL):?> class="active"<?endif;?>><a href="#lang-<?=$lang->lang_code?>" data-toggle="tab"><i class="flag flag-muted flag-<?=$lang->lang_code?> text-muted"></i> <?=$lang->name?></a></li>
    <?endforeach;?>
    <?if(strstr(uri_string(), 'edit') == TRUE):?>
    <li><a href="#images" data-toggle="tab"><i class="fa fa-camera text-muted"></i> Resimler</a></li>
    <?endif;?>
  </ul>
</header>
<div class="card-body">
  <form method="post" action="<?=base_url('backend/contents')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">
  <div class="tab-content">
    <?foreach($languages as $lang):?>
    <div class="tab-pane<?if($lang->lang_code == DESCR_SL):?> active<?endif;?>" id="lang-<?=$lang->lang_code?>">
			<?if(strstr(uri_string(), 'edit') == TRUE && !empty($item[$lang->lang_code]->title) && !empty($item[$lang->lang_code]->description)):?>
			<div class="clear m-b">
				<a class="btn btn-default btn-xs pull-right" onclick="confirmation('Lütfen dikkat!', 'İçerik &quot;<?=$lang->name?>&quot; dilinde kalıcı olarak silinecektir', '<?=base_url('backend/contents/deletelang/'.$this->uri->segment(4).'/'.$lang->lang_code)?>'); return false;" href="#"><i class="fa fa-trash-o"></i> <?=$lang->name?> içeriği sil</a>
			</div>
			<?endif;?>

			<div class="form-group">
				<label class="col-lg-2 control-label">Ana Kategori</label>
				<div class="col-lg-10">
			        <select name="lang[<?=$lang->lang_code?>][main_category]" class="form-control main-category" data-lang="<?=$lang->lang_code?>">
			        	<option value="0"<?if(!$_REQUEST['lang'][$lang->lang_code]['parent_id'] && !$item[$lang->lang_code]->main_category):?> selected<?endif;?>>-- Belirtilmemiş --</option>
			        	<?if(isset($categories_selectbox)):?>
				        	<?foreach($categories_selectbox as $category):?>
				        		<?if($category->lang_code == $lang->lang_code):?>
			                	<option value="<?=$category->category_id?>"<?if($_REQUEST['lang'][$lang->lang_code]['main_category'] == $category->category_id || $item[$lang->lang_code]->main_category == $category->category_id):?> selected<?endif;?>><?if($category->delimiter != '-'):?><?=$category->delimiter?><?endif;?> <?=$category->title?></option>
			                	<?endif;?>
			                <?endforeach;?>
			            <?endif;?>
			        </select>
				</div>
			</div>
							
			<div class="form-group">
				<label class="col-lg-2 control-label">Alt Kategoriler</label>
				<div class="col-lg-10">
					<div class="input-group">
					  <span class="input-group-btn">
					    <button class="select-category btn btn-default" type="button">Alt Kategori Seç</button>
					  </span>
					  <?
						  if($item[$lang->lang_code]->category){
						  	$ctitles = array();
							  foreach(explode(',', $item[$lang->lang_code]->category) as $category_id){
								  $ctitles[] = super_query('id', $category_id, 'title', 'contents_categories', $lang->lang_code);
							  }
							  $item[$lang->lang_code]->ctitles = implode(', ', $ctitles);
						  }
					  ?>
					  <input type="text" name="lang[<?=$lang->lang_code?>][ctitles]" class="ctitles-<?=$lang->lang_code?> form-control" value="<?if($_REQUEST['lang'][$lang->lang_code]['ctitles']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['ctitles'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->ctitles)?><?endif;?>" disabled="disabled">
					  <input type="hidden" name="lang[<?=$lang->lang_code?>][cids]" class="cids-<?=$lang->lang_code?>" value="<?if($_REQUEST['lang'][$lang->lang_code]['cids']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['cids'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->category)?><?endif;?>" />
					</div>
				</div>
			</div>                        
                        
			<div class="form-group">
				<label class="col-lg-2 control-label">Başlık</label>
				<div class="col-lg-10">
					<input type="text" name="lang[<?=$lang->lang_code?>][title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->title)?><?endif;?>" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-2 control-label">İçerik</label>
				<div class="col-lg-10">

					<script type="text/javascript" src="<?=base_url('public/backend/lib/ckeditor/ckeditor.js')?>"></script>
					<textarea name="lang[<?=$lang->lang_code?>][description]" id="description_<?=$lang->lang_code?>"><?if($_REQUEST['lang'][$lang->lang_code]['description']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['description'])?><?else:?><?=$item[$lang->lang_code]->description?><?endif;?></textarea>
					<script type="text/javascript">
						CKEDITOR.replace('description_<?=$lang->lang_code?>');
						<?if($this->session->userdata('user_group') != 1):?>
							CKEDITOR.config.toolbar = 'Basic';
						<?endif;?>
						CKEDITOR.config.contentsCss = 
							[
								/*
								base_url + 'public/3dParty/bootstrap/css/bootstrap.min.css',
								base_url + 'public/css/global.css',
								base_url + 'public/css/typo.css',
								base_url + 'public/css/boxes.css',
								'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,latin-ext,cyrillic'
								*/
							]
					</script>


				</div>
			</div>

			<div class="ozel-ders-<?=$lang->lang_code?> hide">
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Şehir</label>
			    	<div class="col-lg-10">
			    		<select name="lang[<?=$lang->lang_code?>][city]" class="form-control chosen">
			    			<option value="">-- Lütfen Seçiniz --</option>
			    			<?foreach($cities as $city):?>
			    				<option value="<?=$city->id?>"<?if($_REQUEST['lang'][$lang->lang_code]['city'] == $city->id || $item[$lang->lang_code]->city == $city->id):?> selected<?endif;?>><?=$city->title?></option>
			    			<?endforeach;?>
			    		</select>
			    	</div>
			    </div>
			    
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Anahtar Kelime</label>
			    	<div class="col-lg-10">
			    		<input name="lang[<?=$lang->lang_code?>][keyword]" class="form-control" type="text" value="<?if($item[$lang->lang_code]->keyword):?><?=$item[$lang->lang_code]->keyword?><?endif;?>" />
			    	</div>
			    </div>			    
			</div>


		<section class="panel panel-default pos-rlt">
	    
		    <a class="panel-toggle<?if($this->input->get_post('category') || $this->input->get_post('keyword')):?> active<?endif;?>" href="#">
		    <header class="panel-heading">
		      <ul class="nav nav-pills pull-right">
		        <li>
		          <i class="rel-block fa fa-caret-down text-active"></i><i class="rel-block fa fa-caret-up text"></i>
		        </li>
		      </ul>
		      <span class="text-muted">Opsiyonel Bilgiler</span>
		    </header>
		    </a>
		    
		    <div class="panel-body clearfix<?if(!$this->input->get_post('search_keyword') && !$this->input->get_post('search_category')):?> collapse<?endif;?>">
		    
		    
		    
		    
		    
				<div class="form-group">
					<label class="col-lg-2 control-label">Durum</label>
					<div class="col-lg-10">
				        <select name="lang[<?=$lang->lang_code?>][status]" class="form-control">
		                    <option value="A"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'A' || $item[$lang->lang_code]->status == 'A'):?> selected<?endif;?>>Aktif</option>
		                    <option value="I"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'I' || $item[$lang->lang_code]->status == 'I'):?> selected<?endif;?>>Pasif</option>
				        </select>
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-lg-2 control-label">Başlangıç Tarihi</label>
					<div class="col-lg-10">
						<div class="input-group datetimepicker">
						    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						    <input name="lang[<?=$lang->lang_code?>][date]" class="datetimepicker form-control" type="text" value="<?if($item[$lang->lang_code]->start_date):?><?=date('d.m.Y H:i', $item[$lang->lang_code]->start_date)?><?else:?><?=date('d.m.Y H:i', time())?><?endif;?>" />
						</div>
					</div>
				</div>
	
				<div class="form-group">
					<label class="col-lg-2 control-label">Sonlanma Tarihi</label>
					<div class="col-lg-10">
						<div class="input-group datetimepicker">
						    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						    <input name="lang[<?=$lang->lang_code?>][end]" class="datetimepicker form-control" type="text" value="<?if($item[$lang->lang_code]->end_date):?><?=date('d.m.Y H:i', $item[$lang->lang_code]->end_date)?><?endif;?>" />
						</div>
					</div>
				</div>
	
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Template</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][template_content]" value="<?if($_REQUEST['lang'][$lang->lang_code]['template_content']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['template_content'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->template_content)?><?endif;?>" title="Özel sayfa teması. Boş bırakırsanız varsayılan kullanılır." class="form-control" placeholder="örn. contents/detail" />
			    	</div>
			    </div>
			    
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Etiketler</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][tags]" value="<?if($_REQUEST['lang'][$lang->lang_code]['tags']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['tags'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->tags)?><?endif;?>" class="form-control input-s tm-input-<?=$lang->lang_code?>" />
			    	</div>
			    </div>	
			    <?
			    	$tags = gettag('contents', $item[$lang->lang_code]->content_id, $lang->lang_code);
			    ?>
				<script>
				$(document).ready(function() {
					var tagApi = jQuery(".tm-input-<?=$lang->lang_code?>").tagsManager(<?if(!empty($tags)):?>{prefilled: <?=$tags?>}<?endif;?>);
				
					$(".tm-input-<?=$lang->lang_code?>").autocomplete({
						minLength: 1,
						source: function( request, response ) {
							var term = request.term;
				
							$.getJSON( base_url+"backend/contents/searchtag/?term="+term, request, function( data, status, xhr ) {
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
							tagApi.tagsManager("pushTag", ui.item.label);
							$('.tm-input-<?=$lang->lang_code?>').val('');
							event.preventDefault();
						}
					});	
				});			
				</script>
	
			    
			    <div class="form-group">
			    	<label class="col-lg-2 control-label"><strong>SEO (Optimizasyon)</strong></label>
			    	<div class="col-lg-10">
	
			    	</div>
			    </div>
	
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Sayfa Başlığı</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_title)?><?endif;?>" title="İçeriğin sayfa başlığını özelletirebilirsiniz. Arama motoru optimizasyonu içindir." class="form-control" />
			    	</div>
			    </div>
	
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Meta Açıklama</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_description]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_description']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_description'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_description)?><?endif;?>" title="İçeriğin meta açıklama alanını özelleştirebilirsiniz. Arama motoru optimizasyonu içindir." class="form-control" />
			    	</div>
			    </div>
	
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Meta Anahtar Kelimeler</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_keyword]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_keyword']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_keyword'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_keyword)?><?endif;?>" title="İçeriğin meta anahtar kelimelerini özelleştirebilirsiniz. Virgül ile ayırın (Örn. örnek1, örnek2, örnek3). Arama motoru optimizasyonu içindir." class="form-control" />
			    	</div>
			    </div>
	
			    <?if(strstr(uri_string(), 'edit') == TRUE):?>
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Bağlantı Adresi</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_link]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_link']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_link'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_link)?><?endif;?>" title="Yalnızca türkçe karakter olmayan küçük harf ve - işareti kullanabilirsiniz. Arama motoru optimizasyonu içindir." class="form-control" />
			    	</div>
			    </div>
			    <?endif;?>

			    <div class="form-group">
			    	<label class="col-lg-2 control-label"><strong>İlan Yazıları</strong></label>
			    	<div class="col-lg-10">
						
			    	</div>
			    </div>

			    <div class="form-group">
			    	<label class="col-lg-2 control-label">İlan Üst Yazısı</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][lesson_top_text]" value="<?if($_REQUEST['lang'][$lang->lang_code]['lesson_top_text']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['lesson_top_text'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->lesson_top_text)?><?endif;?>" class="form-control" />
			    	</div>
			    </div>
			    
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">İlan Yazısı URL (örn. ankara-cankaya veya ankara-cankaya-ilkogretim-takviye vb.)</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][lesson_url]" value="<?if($_REQUEST['lang'][$lang->lang_code]['lesson_url']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['lesson_url'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->lesson_url)?><?endif;?>" class="form-control" />
			    	</div>
			    </div>			    
			    	
			</div>
		</section>

		<?if(strstr(uri_string(), 'add') == TRUE):?>
			<button class="btn btn-default pull-right m-t" type="submit" name="submit">İLERİ</button>
		<?else:?>
			<button class="btn btn-default pull-right m-t" type="submit" onclick="return checkImage('form-horizontal');">KAYDET</button>
		<?endif;?>
				


    </div>
    <?endforeach;?>
    </form>
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
	        $( ".files" ).sortable({
				//placeholder: 'col-xs-6 col-sm-6 col-md-2 placeholder',
				revert: true,
		        update: function(event, ui) {
						$.ajax({
							type:'POST',
							data: $(this).sortable("serialize"),
							url:base_url+'backend/<?=$this->uri->segment(2)?>/sortPhotos',
							success:function results(msg){
								$.growl(msg, {type	: 'success'});
							}
						});
		        },
			    placeholder: {
			        element: function(currentItem) {
			            return $("<div class='col-xs -6 col-sm-6 col-md-2 placeholder'><div class='thumbnail'></div></div>")[0];
			        },
			        update: function(container, p) {
			            return;
			        }
			    }
	        });
	        
	        setTimeout(function(){
		        $('[data-toggle="tooltip"]').tooltip();
				/*
				$(document).on('mouseover', '[data-toggle="popover"]', function(){
				    $(this).popover('show');
				});
			    $('[data-toggle="popover"]').bind('click', function(){
			    	return false;
			    });
			    */
	        }, 500);
	        
	        
			//Jquery file upload start
		    // Initialize the jQuery File Upload widget:
		    $('#fileupload').fileupload({
		        // Uncomment the following to send cross-domain cookies:
		        //xhrFields: {withCredentials: true},
		        url: base_url+'backend/contents/photos/'+<?=$this->uri->segment(4)?>,
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
					if($('button[data-id="'+id+'"] i').hasClass('fa-star-o')){
						$('button[data-id="'+id+'"] i').removeClass('fa-star-o').addClass('fa-star');
						$('button[data-id="'+id+'"]').attr('title', '<?=lang('MAIN_PHOTO')?>').attr('data-original-title', '<?=lang('MAIN_PHOTO')?>');
					} else {
						$('button[data-id="'+id+'"] i').removeClass('fa-star').addClass('fa-star-o');
						$('button[data-id="'+id+'"]').attr('title', '<?=lang('MAKE_MAIN_PHOTO')?>').attr('data-original-title', '<?=lang('MAKE_MAIN_PHOTO')?>');
					}
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
<!-- categories modal start -->
<link rel="stylesheet" href="<?=base_url('public/backend/js/nestable/nestable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/js/nestable/jquery.nestable.js')?>"></script>
<script>
$(window).load(function(){
	$('.chosen').chosen();
});

$(document).ready(function() {
	
	setTimeout(function(){
		$('.main-category').trigger('change');
	}, 1000);
	
	$('.main-category').on('change', function(){
		var lang_code = $(this).attr('data-lang');
		var selected = $('option:selected', this).val();
		if(selected == 631){
			$('.ozel-ders-'+lang_code).removeClass('hide');		
		} else {
			$('.ozel-ders-'+lang_code).addClass('hide');
		}
	});
	
	$('.select-category').click(function(e){

		e.preventDefault();
				
		var lang_code = window.location.hash.substr(6) ? window.location.hash.substr(6) : '<?=DESCR_SL?>';
		
		$('.modal-'+lang_code).modal('show');
				
	});
	
	$('.dd').nestable({draggable: false, group: 1});
	
	$('.categories-list-control').on('click', function(e){

        var target = $(e.target), action = target.data('action');
        
        if (action === 'expand-all') {
            $(this).parents('.modal-body').find('.dd').nestable('expandAll');
        }
        
        if (action === 'collapse-all') {
            $(this).parents('.modal-body').find('.dd').nestable('collapseAll');
        }
	});
});

function savecategories(lang_code)
{
	var ids = new Array();
	var titles = new Array();
	$(".modal-"+lang_code+" input:checked").each(function() {
	      ids.push($(this).attr('data-id'));
	      titles.push($(this).attr('data-title'));
	});
	
	$('.ctitles-'+lang_code).val(titles.join(', '));
	$('.cids-'+lang_code).val(ids.join(','));
	
	$('.modal-'+lang_code).modal('hide');
}
</script>
<?foreach($languages as $lang):?>
<div class="modal modal-<?=$lang->lang_code?>">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Kategoriler</h4>
			</div>
			<div class="modal-body">
				<form class="dd-form"><div class="dd"><?=$categories[$lang->lang_code]?></div></form>
				<div class="categories-list-control btn-group pull-right"><a data-action="expand-all" class="btn btn-sm btn-default m-t-sm"><i class="fa fa-plus-circle"></i> Tümünü aç</a><a data-action="collapse-all" class="btn btn-sm btn-default m-t-sm"><i class="fa fa-minus-circle"></i> Tümünü kapat</a></div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" onclick="savecategories('<?=$lang->lang_code?>')">Kaydet</a>
				<a class="btn btn-default" data-dismiss="modal">İptal</a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<?endforeach;?>
<!-- categories modal end -->


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
				cropUrl:'<?=site_url('backend/contents/crophere')?>',
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
				cropUrl:'<?=site_url('backend/contents/crophere')?>',
				modal:true,
				imgEyecandyOpacity:0.4,
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> '
		});
	};
</script>


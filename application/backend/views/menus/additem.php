<? $languages = site_languages(true); ?>

<section class="panel panel-default">
<header class="panel-heading text-right bg-light">
  <ul class="nav nav-tabs pull-left">
    <?foreach($languages as $lang):?>
    <li<?if($lang->lang_code == DESCR_SL):?> class="active"<?endif;?>><a href="#lang-<?=$lang->lang_code?>" data-toggle="tab"><i class="flag flag-muted flag-<?=$lang->lang_code?> text-muted"></i> <?=$lang->name?></a></li>
    <?endforeach;?>
  </ul>
  <span><a href="<?=base_url('backend/menus/items/'.$this->uri->segment(4))?>"><i class="fa fa-bars"></i> Öğe listesi</a></span>
</header>
<div class="panel-body">

  <form method="post" action="<?=base_url('backend/menus')?><?if(strstr(uri_string(), 'additem') == TRUE):?>/additem/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(5)?><?else:?>/edititem/<?=$this->uri->segment(4)?>/<?=$this->uri->segment(5)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">
  <div class="tab-content">
    <?foreach($languages as $lang):?>
    <div class="tab-pane<?if($lang->lang_code == DESCR_SL):?> active<?endif;?>" id="lang-<?=$lang->lang_code?>">
    	<input type="hidden" name="lang[<?=$lang->lang_code?>][id]" value="<?=$item[$lang->lang_code]->id?>" />
		<?if(strstr(uri_string(), 'edit') == TRUE && !empty($item[$lang->lang_code]->title)):?>
		<div class="clear m-b">
			<a class="btn btn-default btn-trash btn-xs pull-right" onclick="confirmation('Lütfen dikkat!', 'Öğe &quot;<?=$lang->name?>&quot; dilinde kalıcı olarak silinecektir', '<?=base_url('backend/menus/deleteitem/'.$item[$lang->lang_code]->item_id.'/'.$lang->lang_code.'/'.base64_encode(current_url()))?>'); return false;" href="#"><i class="fa fa-trash-o"></i> <strong><?=$lang->name?></strong> dilde bu öğeyi sil</a>
		</div>
		<?endif;?>		
		<div class="form-group">
			<label class="col-lg-2 control-label">Üst Öğe</label>
			<div class="col-lg-10">
		        <select name="lang[<?=$lang->lang_code?>][parent_id]" class="form-control">
		        	<option value="0"<?if(!$_REQUEST['lang'][$lang->lang_code]['parent_id'] && !$item[$lang->lang_code]->parent_id):?> selected<?endif;?>>-- Üst Öğe --</option>
		        	<?if(isset($items)):?>
			        	<?foreach($items as $i):?>
			        		<?if($i->lang_code == $lang->lang_code):?>
	                    	<option value="<?=$i->id?>"<?if($_REQUEST['lang'][$lang->lang_code]['parent_id'] == $i->id || $item[$lang->lang_code]->parent_id == $i->id || ($this->uri->segment(5) && $this->uri->segment(5) != $item[$lang->lang_code]->item_id && $this->uri->segment(5) == $i->id)):?> selected<?endif;?>><?if($i->delimiter != '-'):?><?=$i->delimiter?><?endif;?> <?=$i->title?></option>
	                    	<?endif;?>
	                    <?endforeach;?>
                    <?endif;?>
		        </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-lg-2 control-label">Öğe Adı</label>
			<div class="col-lg-10">
				<input type="text" name="lang[<?=$lang->lang_code?>][title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->title)?><?endif;?>" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-lg-2 control-label">Bağlantı Tipi</label>
			<div class="col-lg-10">
		        <select name="lang[<?=$lang->lang_code?>][link_type]" class="form-control link_type link_type_<?=$lang->lang_code?>" data-lang="<?=$lang->lang_code?>">
	                <option value="url"<?if($_REQUEST['lang'][$lang->lang_code]['link_type'] == 'url' || $item[$lang->lang_code]->link_type == 'url'):?> selected<?endif;?>>Dış Bağlantı (URL)</option>
	                <option value="inurl"<?if($_REQUEST['lang'][$lang->lang_code]['link_type'] == 'inurl' || $item[$lang->lang_code]->link_type == 'inurl'):?> selected<?endif;?>>İç Bağlantı (URL)</option>
	                <option value="home"<?if($_REQUEST['lang'][$lang->lang_code]['link_type'] == 'home' || $item[$lang->lang_code]->link_type == 'home'):?> selected<?endif;?>>Ana Sayfa</option>
	                <option value="contents_categories"<?if($_REQUEST['lang'][$lang->lang_code]['link_type'] == 'contents_categories' || $item[$lang->lang_code]->link_type == 'contents_categories'):?> selected<?endif;?>>Kategori</option>
	                <option value="contents"<?if($_REQUEST['lang'][$lang->lang_code]['link_type'] == 'contents' || $item[$lang->lang_code]->link_type == 'contents'):?> selected<?endif;?>>İçerik</option>
		        </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-lg-2 control-label">Bağlantı Adresi</label>
			<div class="col-lg-10">
				<input type="text" name="lang[<?=$lang->lang_code?>][link_value]" class="form-control link_value link_value_<?=$lang->lang_code?>" data-lang="<?=$lang->lang_code?>" value="<?if($_REQUEST['lang'][$lang->lang_code]['link_value']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['link_value'])?><?else:?><?=htmlspecialchars(parse_menu_link_value($item[$lang->lang_code]->link_type, $item[$lang->lang_code]->link_value, $lang->lang_code))?><?endif;?>" />
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
			    	<label class="col-lg-2 control-label">Hedef</label>
			    	<div class="col-lg-10">
			    		<select name="lang[<?=$lang->lang_code?>][link_target]" class="form-control">
			    			<option value="self"<?if($_REQUEST['lang'][$lang->lang_code]['link_target'] == 'self' || $item[$lang->lang_code]->link_target == 'self'):?> selected<?endif;?>>Aynı pencere</option>
			    			<option value="blank"<?if($_REQUEST['lang'][$lang->lang_code]['link_target'] == 'blank' || $item[$lang->lang_code]->link_target == 'blank'):?> selected<?endif;?>>Yeni pencere</option>
			    		</select>
			    	</div>
			    </div>
	
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">CSS Class</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][css_class]" value="<?if($_REQUEST['lang'][$lang->lang_code]['css_class']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['css_class'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->css_class)?><?endif;?>" class="form-control" />
			    	</div>
			    </div>
		    </div>
	  </section>
                  
	
			
	  <button class="btn btn-default pull-right m-t-sm" type="submit">KAYDET</button>

    </div>
    <input type="hidden" name="lang[<?=$lang->lang_code?>][link_id]" class="link_id_<?=$lang->lang_code?>" value="<?if($_REQUEST['lang'][$lang->lang_code]['link_id']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['link_id'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->link_value)?><?endif;?>" />
    <?endforeach;?>
    </form>

  </div>
</div>
</section>

<script>
$(document).ready(function(){
	$(".link_type").each(function(){
		var lang_code = $(this).attr('data-lang');
		var link_type = $('.link_type_'+lang_code);
		var link_value = $('.link_value_'+lang_code);
		var link_id = $('.link_id_'+lang_code);
		if((link_type.val() == 'contents' || link_type.val() == 'contents_categories') && link_id.val() == ''){
			link_value.val('');
		}
	});	
});

$(".link_type").change(function(){
	var lang_code = $(this).attr('data-lang');
	$('.link_value_'+lang_code).val('');
	$('.link_id_'+lang_code).val('');
});

$(".link_value").keyup(function(){
	var lang_code = $(this).attr('data-lang');
	var link_type = $('.link_type_'+lang_code+' option:selected').val();
	if(link_type == 'contents' || link_type == 'contents_categories')
	{
		$(".link_value").autocomplete({
			minLength: 1,
			source: function( request, response ) {
				var term = request.term;
	
				$.getJSON( base_url+"backend/menus/autoComplete/?type="+link_type+'&language='+lang_code, request, function( data, status, xhr ) {
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
				$(".link_id_"+lang_code).val(ui.item.item_id);
			}
		});		
	}
});
</script>
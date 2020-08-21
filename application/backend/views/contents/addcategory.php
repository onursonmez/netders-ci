<? $languages = site_languages(true); ?>

<section class="panel panel-default">
<header class="panel-heading bg-light">
  <ul class="nav nav-tabs">
    <?foreach($languages as $lang):?>
    <li<?if($lang->lang_code == DESCR_SL):?> class="active"<?endif;?>><a href="#lang-<?=$lang->lang_code?>" data-toggle="tab"><i class="flag flag-muted flag-<?=$lang->lang_code?> text-muted"></i> <?=$lang->name?></a></li>
    <?endforeach;?>
  </ul>
</header>
<div class="card-body">

  <form method="post" action="<?=base_url('backend/contents')?><?if(strstr(uri_string(), 'addcategory') == TRUE):?>/addcategory<?else:?>/editcategory/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">
  <div class="tab-content">
    <?foreach($languages as $lang):?>
    <div class="tab-pane<?if($lang->lang_code == DESCR_SL):?> active<?endif;?>" id="lang-<?=$lang->lang_code?>">
    	<input type="hidden" name="lang[<?=$lang->lang_code?>][id]" value="<?=$item[$lang->lang_code]->id?>" />
		<?if(strstr(uri_string(), 'edit') == TRUE && !empty($item[$lang->lang_code]->title)):?>
		<div class="clear m-b">
			<a class="btn btn-default btn-xs pull-right" onclick="confirmation('Lütfen dikkat!', 'Kategori &quot;<?=$lang->name?>&quot; dilinde kalıcı olarak silinecektir', '<?=base_url('backend/contents/deletecategorylang/'.$this->uri->segment(4).'/'.$lang->lang_code)?>'); return false;" href="#"><i class="fa fa-trash-o"></i> <strong><?=$lang->name?></strong> dilde kategoriyi sil</a>
		</div>
		<?endif;?>		
		<div class="form-group">
			<label class="col-lg-2 control-label">Üst Kategori</label>
			<div class="col-lg-10">
		        <select name="lang[<?=$lang->lang_code?>][parent_id]" class="form-control">
		        	<option value="0"<?if(!$_REQUEST['lang'][$lang->lang_code]['parent_id'] && !$item[$lang->lang_code]->parent_id):?> selected<?endif;?>>-- Belirtilmemiş --</option>
		        	<?if(isset($categories)):?>
			        	<?foreach($categories as $category):?>
			        		<?if($category->lang_code == $lang->lang_code):?>
	                    	<option value="<?=$category->id?>"<?if($_REQUEST['lang'][$lang->lang_code]['parent_id'] == $category->id || $item[$lang->lang_code]->parent_id == $category->id):?> selected<?endif;?>><?if($category->delimiter != '-'):?><?=$category->delimiter?><?endif;?> <?=$category->title?></option>
	                    	<?endif;?>
	                    <?endforeach;?>
                    <?endif;?>
		        </select>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-lg-2 control-label">Kategori Adı</label>
			<div class="col-lg-10">
				<input type="text" name="lang[<?=$lang->lang_code?>][title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->title)?><?endif;?>" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-lg-2 control-label">Durum</label>
			<div class="col-lg-10">
		        <select name="lang[<?=$lang->lang_code?>][status]" class="form-control">
                    <option value="A"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'A' || $item[$lang->lang_code]->status == 'A'):?> selected<?endif;?>>Aktif</option>
                    <option value="I"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'I' || $item[$lang->lang_code]->status == 'I'):?> selected<?endif;?>>Pasif</option>
		        </select>
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
					<label class="col-lg-2 control-label">Açıklama</label>
					<div class="col-lg-10">
	
						<script type="text/javascript" src="<?=base_url('public/backend/lib/ckeditor/ckeditor.js')?>"></script>
						<textarea name="lang[<?=$lang->lang_code?>][description]" id="description_<?=$lang->lang_code?>"><?if($_REQUEST['lang'][$lang->lang_code]['description']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['description'])?><?else:?><?=$item[$lang->lang_code]->description?><?endif;?></textarea>
						<script type="text/javascript">
							CKEDITOR.replace('description_<?=$lang->lang_code?>');
							<?if($this->session->userdata('user_group') != 1):?>
								CKEDITOR.config.toolbar = 'Basic';
							<?endif;?>
						</script>
	
	
					</div>
				</div>

			    <div class="form-group">
			    	<label class="col-lg-2 control-label">Kategori Teması</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][template_category]" value="<?if($_REQUEST['lang'][$lang->lang_code]['template_category']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['template_category'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->template_category)?><?endif;?>" title="Özel kategori sayfası teması. Boş bırakırsanız varsayılan kullanılır." class="form-control" placeholder="örn. contents/overview" />
			    	</div>
			    </div>
			    
			    <div class="form-group">
			    	<label class="col-lg-2 control-label">İçerik Teması</label>
			    	<div class="col-lg-10">
			    		<input type="text" name="lang[<?=$lang->lang_code?>][template_content]" value="<?if($_REQUEST['lang'][$lang->lang_code]['template_content']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['template_content'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->template_content)?><?endif;?>" title="Özel sayfa teması. Bu kategoriye ait sayfalar bu temada gösterilir. Boş bırakırsanız varsayılan kullanılır." class="form-control" placeholder="örn. contents/view" />
			    	</div>
			    </div>			    
			    			
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
		    </div>
	  </section>
                  
	
			
	  <button class="btn btn-default pull-right m-t-sm" type="submit">KAYDET</button>

    </div>
    <?endforeach;?>	
    </form>

  </div>
</div>
</section>
<?
	$languages = site_languages(true);
?>
<form method="POST" action="<?=base_url('backend/contents')?><?if(strstr(uri_string(), 'add') == TRUE):?>/addcategory<?else:?>/editcategory/<?=$this->uri->segment(4)?><?endif;?>" class="mainForm">
<div class="widget">
    <ul class="tabs">
    	<?foreach($languages as $lang):?>
        <li><a href="#lang_<?=$lang->lang_code?>"><?=$lang->name?></a></li>
        <?endforeach;?>
    </ul>
    <div class="tab_container">
    	<?foreach($languages as $lang):?>
    	<div id="lang_<?=$lang->lang_code?>" class="tab_content">
    		<?if(strstr(uri_string(), 'edit') == TRUE && !empty($item[$lang->lang_code]->title)):?>
    		<div class="num"><a href="<?=base_url('backend/contents/deletecategorylang/'.$this->uri->segment(4).'/'.$lang->lang_code)?>" class="redNum">Kategoriyi bu dilde sil</a></div>
    		<?endif;?>
			<div class="rowElem nobg">
				<label>Ad<span class="req">*</span></label>
				<div class="formRight">
					<input type="text" name="lang[<?=$lang->lang_code?>][title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->title)?><?endif;?>" title="Bu alana kategori adını giriniz." class="leftDir"  />
				</div>
				<div class="fix"></div>
			</div>
			<div class="rowElem">
				<label>Açıklama</label>
				<div class="formRight">
					<div class="leftDir" title="Bu alana kategori açıklamasını giriniz.">
						<textarea name="lang[<?=$lang->lang_code?>][description]" id="description_<?=$lang->lang_code?>"><?if($_REQUEST['lang'][$lang->lang_code]['description']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['description'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->description)?><?endif;?></textarea>
						<script type="text/javascript">
							CKEDITOR.replace('description_<?=$lang->lang_code?>'); 
							<?if($this->session->userdata('user_group') == 1):?>
								CKEDITOR.config.toolbar = 'myFull'; 
							<?else:?>
								CKEDITOR.config.toolbar = 'Basic'; 
							<?endif;?>
						</script>
					</div>
				</div>
				<div class="fix"></div>
			</div>
			<div class="rowElem">
			    <label>Durum:</label>
			    <div class="formRight">
			        <select name="lang[<?=$lang->lang_code?>][status]" class="select2">
	                    <option value="A"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'A' || $item[$lang->lang_code]->status == 'A'):?> selected<?endif;?>>Aktif</option>
	                    <option value="I"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'I' || $item[$lang->lang_code]->status == 'I'):?> selected<?endif;?>>Pasif</option>
			        </select>
			    </div>
			    <div class="fix"></div>
			</div>
		    <div class="rowElem">
		    	<label>Sayfa Başlığı</label>
		    	<div class="formRight">
		    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_title)?><?endif;?>" title="Kategorinin sayfa başlığını özelletirebilirsiniz. Arama motoru optimizasyonu içindir." class="leftDir" />
		    	</div>
		    	<div class="fix"></div>
		    </div>
		    <div class="rowElem">
		    	<label>Meta Açıklama</label>
		    	<div class="formRight">
		    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_description]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_description']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_description'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_description)?><?endif;?>" title="Kategorinin meta açıklama alanını özelleştirebilirsiniz. Arama motoru optimizasyonu içindir." class="leftDir" />
		    	</div>
		    	<div class="fix"></div>
		    </div>
		    <div class="rowElem">
		    	<label>Meta Anahtar Kelimeler</label>
		    	<div class="formRight">
		    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_keyword]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_keyword']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_keyword'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_keyword)?><?endif;?>" title="Kategorinin meta anahtar kelimelerini özelleştirebilirsiniz. Virgül ile ayırın (Örn. örnek1, örnek2, örnek3). Arama motoru optimizasyonu içindir." class="leftDir" />
		    	</div>
		    	<div class="fix"></div>
		    </div>
		    <?if(strstr(uri_string(), 'edit') == TRUE):?>
		    <div class="rowElem">
		    	<label>Bağlantı Adresi</label>
		    	<div class="formRight seoLink">
		    		<input type="text" name="lang[<?=$lang->lang_code?>][seo_link]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_link']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_link'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_link)?><?endif;?>" title="Yalnızca türkçe karakter olmayan küçük harf ve - işareti kullanabilirsiniz. Arama motoru optimizasyonu içindir." class="leftDir" />
		    	</div>
		    	<div class="fix"></div>
		    </div>
		    <?endif;?>
    	</div>
    	<?endforeach;?>
    </div>
	<div class="fix"></div>
</div>
<input type="submit" name="submit" value="Kaydet" class="basicBtn t20 fRight" />
</form>
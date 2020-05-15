<section class="panel panel-default">
<header class="panel-heading bg-light">
  Genel Ayarlar
</header>
<div class="panel-body">
  <form method="POST" action="<?=base_url('backend/settings')?>" class="form-horizontal" enctype="multipart/form-data">
  <div class="tab-content">

    
			<div class="form-group">
				<label class="col-lg-4 control-label">Site Adı</label>
				<div class="col-lg-6">
					<input type="text" name="form[site_name]" value="<?if($_REQUEST['form']['site_name']):?><?=htmlspecialchars($_REQUEST['form']['site_name'])?><?else:?><?=htmlspecialchars($item->site_name)?><?endif;?>" class="form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Yönetici E-posta</label>
				<div class="col-lg-6">
					<input type="text" name="form[admin_email]" value="<?if($_REQUEST['form']['admin_email']):?><?=htmlspecialchars($_REQUEST['form']['admin_email'])?><?else:?><?=htmlspecialchars($item->admin_email)?><?endif;?>" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label">Danışmanlık Cep Telefonu</label>
				<div class="col-lg-6">
					<input type="text" name="form[mobile]" value="<?if($_REQUEST['form']['mobile']):?><?=htmlspecialchars($_REQUEST['form']['mobile'])?><?else:?><?=htmlspecialchars($item->mobile)?><?endif;?>" class="form-control" placeholder="örn. +90 532 123 4567" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label">Hesap No</label>
				<div class="col-lg-6">
					<textarea name="form[bank_info]" rows="3" class="form-control"><?if($_REQUEST['form']['bank_info']):?><?=htmlspecialchars($_REQUEST['form']['bank_info'])?><?else:?><?=htmlspecialchars($item->bank_info)?><?endif;?></textarea>
				</div>
			</div>
						
			<div class="form-group">
				<label class="col-lg-4 control-label">Proxy Adresi</label>
				<div class="col-lg-6">
					<input type="text" name="form[proxy]" value="<?if($_REQUEST['form']['proxy']):?><?=htmlspecialchars($_REQUEST['form']['proxy'])?><?else:?><?=htmlspecialchars($item->proxy)?><?endif;?>" class="form-control" placeholder="123.123.123.123:1234" />
					<a href="<?=current_url()?>?proxytest=1">Test</a>
				</div>
			</div>			
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Varsayılan site dili</label>
				<div class="col-lg-6">
	                <select name="form[default_language]" class="form-control">
	                <?foreach($languages as $language):?>
	                    <option value="<?=$language->lang_code?>"<?if($_REQUEST['form']['default_language'] == $language->lang_code || $item->default_language == $language->lang_code):?> selected<?endif;?>><?=$language->name?></option>
	                <?endforeach;?>
	                </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Varsayılan yönetici paneli dili</label>
				<div class="col-lg-6">
	                <select name="form[default_admin_language]" class="form-control">
	                <?foreach($languages as $language):?>
	                    <option value="<?=$language->lang_code?>"<?if($_REQUEST['form']['default_admin_language'] == $language->lang_code || $item->default_admin_language == $language->lang_code):?> selected<?endif;?>><?=$language->name?></option>
	                <?endforeach;?>
	                </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label">Site dilleri görünümü</label>
				<div class="col-lg-6">
                    <select name="form[languages_view_type]" class="form-control">
                        <option value="1"<?if(1 == $_REQUEST['form']['languages_view_type'] || 1 == $item->languages_view_type):?> selected<?endif;?>>Seçim Kutusu</option>
                        <option value="2"<?if(2 == $_REQUEST['form']['languages_view_type'] || 2 == $item->languages_view_type):?> selected<?endif;?>>Bayraklı Bağlantı</option>
                    </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label">E-posta gönderimi</label>
				<div class="col-lg-6">
                    <select name="form[mail_notifications]" class="form-control">
                        <option value="Y"<?if('Y' == $_REQUEST['form']['mail_notifications'] || 'Y' == $item->mail_notifications):?> selected<?endif;?>>Açık</option>
                        <option value="N"<?if('N' == $_REQUEST['form']['mail_notifications'] || 'N' == $item->mail_notifications):?> selected<?endif;?>>Kapalı</option>
                    </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">İçerikler bağlantı türü</label>
				<div class="col-lg-6">
                    <select name="form[content_link_type]" class="form-control">
	                    <option value="1"<?if(1 == $_REQUEST['form']['content_link_type'] || 1 == $item->content_link_type):?> selected<?endif;?>>[kategori]/[içerik]</option>
						<option value="2"<?if(2 == $_REQUEST['form']['content_link_type'] || 2 == $item->content_link_type):?> selected<?endif;?>>[içerik]</option>
                    </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Kategori silme işlemi</label>
				<div class="col-lg-6">
                    <select name="form[category_delete_type]" class="form-control">
	                    <option value="1"<?if(1 == $_REQUEST['form']['category_delete_type'] || 1 == $item->category_delete_type):?> selected<?endif;?>>Kategori, alt kategorileri ve bağlı içerikler kalıcı olarak silinsin</option>
						<option value="2"<?if(2 == $_REQUEST['form']['category_delete_type'] || 2 == $item->category_delete_type):?> selected<?endif;?>>Kategori, alt kategorileri ve bağlı içerikler çöp kutusuna gönderilsin</option>
                    </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">İçerik silme işlemi</label>
				<div class="col-lg-6">
                    <select name="form[content_delete_type]" class="form-control">
	                    <option value="1"<?if(1 == $_REQUEST['form']['content_delete_type'] || 1 == $item->content_delete_type):?> selected<?endif;?>>İçerik kalıcı olarak silinsin</option>
						<option value="2"<?if(2 == $_REQUEST['form']['content_delete_type'] || 2 == $item->content_delete_type):?> selected<?endif;?>>İçerik çöp kutusuna gönderilsin</option>
                    </select>
				</div>
			</div>	

			<div class="form-group">
				<label class="col-lg-4 control-label">Sitede kullanmak istediğiniz diller</label>
				<div class="col-lg-8">
                    <?foreach($languages as $language):?>
                	<div class="checkbox i-checks">
                		<label for="lang_<?=$language->lang_code?>">
                        	<input name="form[site_languages][]" type="checkbox" value="<?=$language->lang_code?>"<?if($item->site_languages && in_array($language->lang_code, $item->site_languages) || $language->lang_code == $_REQUEST['form']['default_language']):?> checked<?endif;?> id="lang_<?=$language->lang_code?>" /><i></i> <?=$language->name?>
                		</label>
                	</div>
                    <?endforeach;?>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-4 control-label">Çöp kutusu</label>
				<div class="col-lg-8">
					<span class="m-t-xs pull-left">Verileri&nbsp;&nbsp;</span><div class="pull-left"><input type="text" name="form[trash_delete]" value="<?if($_REQUEST['form']['trash_delete']):?><?=htmlspecialchars($_REQUEST['form']['trash_delete'])?><?else:?><?=htmlspecialchars($item->trash_delete)?><?endif;?>" class="form-control input-s-xs" data-toggle="tooltip" title="Değeri 0 (sıfır) belirlerseniz verileriniz siz silene kadar çöp kutusunda kalır" /></div><span class="m-t-xs pull-left">&nbsp;&nbsp;gün sonra otomatik olarak sil</span>
				</div>
			</div>
											
			<hr />
			
			<?if(!empty($item->photo['versions'])):?>
			<label class="col-lg-4 control-label">Resim boyutları <button data-original-title="&lt;button type=&quot;button&quot; class=&quot;close pull-right&quot; data-dismiss=&quot;popover&quot;&gt;×&lt;/button&gt;Bilgi" title="" data-content="&lt;div class='scrollable' style='width:250px;height:100px'&gt;Genişlik/yükseklik alanlarından birini boş bırakırsanız en boy eşitlemesi yapmaz. Resmin büyük tarafını girdiğiniz değere getirir, diğer taraf getirilen değere orantılı olarak küçülür.&lt;/div&gt;" data-placement="top" data-html="true" data-toggle="popover" class="btn btn-default btn-xs" onclick="return false;">?</button></label>
			<div class="col-lg-8">
				<table class="table">
				  <thead>
				    <tr>
				      <th><span data-toggle="tooltip" title="Küçük harf olmalı, türkçe  karakter ve sembol içermemeli. (örn. large, thumbnail)">Ad</span></th>
				      <th><span data-toggle="tooltip" title="Piksel (px) olarak">Genişlik</span></th>
				      <th></th>
				      <th><span data-toggle="tooltip" title="Piksel (px) olarak">Yükseklik</span></th>
				      <th>Filigran</th>
				      <th>Sil</th>
				    </tr>
				  </thead>
				  <tbody>
				  	<?foreach($item->photo['versions'] as $name => $value):?>
				    <tr>
				      <td width="200">
						  <input type="hidden" name="photo[versions][<?=$name?>][name]" value="<?=$name?>" />
					      <input type="text" name="photo[versions][<?=$name?>][name]" value="<?=$name?>" class="form-control" disabled="disabled" />
				      </td>
				      <td width="100">
				      	<input type="text" name="photo[versions][<?=$name?>][max_width]" value="<?if($_REQUEST['photo']['versions'][$name]['max_width']):?><?=htmlspecialchars($_REQUEST['photo']['versions'][$name]['max_width'])?><?else:?><?=htmlspecialchars($value['max_width'])?><?endif;?>" class="form-control" />
				      </td>
				      <td width="10">
					      x
				      </td>
				      <td width="100">
					      <input type="text" name="photo[versions][<?=$name?>][max_height]" value="<?if($_REQUEST['photo']['versions'][$name]['max_height']):?><?=htmlspecialchars($_REQUEST['photo']['versions'][$name]['max_height'])?><?else:?><?=htmlspecialchars($value['max_height'])?><?endif;?>" class="form-control" />
				      </td>
				      <td width="100">
						<label class="switch" data-toggle="tooltip" title="Filigran">
							<input type="checkbox" name="photo[versions][<?=$name?>][watermark]" value="1" <?if($_REQUEST['photo']['versions'][$name]['watermark'] == 1 || $value['watermark'] == 1):?> checked="checked"<?endif?> />
							<span></span>
						</label>
				      </td>
				      <td>
						<label class="switch" data-toggle="tooltip" title="Filigran">
							<input type="checkbox" name="photo[versions][<?=$name?>][delete]" value="1" />
							<span></span>
						</label>
				      </td>				      
				    </tr>
				    <?endforeach;?>
				    <tr>
				      <td width="200">
					      <input type="text" name="photo[versions][new][name]" value="" placeholder="yeni ekle" class="form-control" />
				      </td>
				      <td width="100">
				      	<input type="text" name="photo[versions][new][max_width]" value="" class="form-control" />
				      </td>
				      <td width="10">
					      x
				      </td>
				      <td width="100">
					      <input type="text" name="photo[versions][new][max_height]" value="" class="form-control" />
				      </td>
				      <td>
						<label class="switch" data-toggle="tooltip" title="Filigran">
							<input type="checkbox" name="photo[versions][new][watermark]" value="1">
							<span></span>
						</label>
				      </td>
				      <td></td>
				    </tr>
				  </tbody>
				</table>
			</div>
			
			<?else:?>
			<div class="form-group">
				<label class="col-lg-4 control-label">Yeni resim boyutu ekle <button data-original-title="&lt;button type=&quot;button&quot; class=&quot;close pull-right&quot; data-dismiss=&quot;popover&quot;&gt;×&lt;/button&gt;Bilgi" title="" data-content="&lt;div class='scrollable' style='width:250px;height:100px'&gt;Genişlik/yükseklik alanlarından birini boş bırakırsanız en boy eşitlemesi yapmaz. Resmin büyük tarafını girdiğiniz değere getirir, diğer taraf getirilen değere orantılı olarak küçülür.&lt;/div&gt;" data-placement="top" data-html="true" data-toggle="popover" class="btn btn-default btn-xs" onclick="return false;">?</button></label>
				
				<div class="col-lg-8">
					<table class="table">
					  <thead>
					    <tr>
					      <th><span data-toggle="tooltip" title="Küçük harf olmalı, türkçe  karakter ve sembol içermemeli. (örn. large, thumbnail)">Ad</span></th>
					      <th><span data-toggle="tooltip" title="Piksel (px) olarak">Genişlik</span></th>
					      <th></th>
					      <th><span data-toggle="tooltip" title="Piksel (px) olarak">Yükseklik</span></th>
					      <th>Filigran</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td width="200">
						      <input type="text" name="photo[versions][new][name]" value="" class="form-control" />
					      </td>
					      <td width="100">
					      	<input type="text" name="photo[versions][new][max_width]" value="" class="form-control" />
					      </td>
					      <td width="10">
						      x
					      </td>
					      <td width="100">
						      <input type="text" name="photo[versions][new][max_height]" value="" class="form-control" />
					      </td>
					      <td>
							<label class="switch" data-toggle="tooltip" title="Filigran">
								<input type="checkbox" name="photo[versions][new][watermark]" value="1">
								<span></span>
							</label>
					      </td>
						  <td></td>
					    </tr>
					  </tbody>
					</table>
				</div>
			</div>			
			<?endif;?>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Maksimum orjinal resim boyutu</label>
				<div class="col-lg-1">
					<input type="text" name="photo[photo_original_max]" value="<?if($_REQUEST['photo']['photo_original_max']):?><?=htmlspecialchars($_REQUEST['photo']['photo_original_max'])?><?else:?><?=@htmlspecialchars($item->photo['photo_original_max'])?><?endif;?>" class="form-control" />
				</div>
				
				<div class="pull-left m-t-xs">
					piksel
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label">Resim kalitesi</label>
				<div class="col-lg-1">
					<input type="text" name="photo[photo_quality]" value="<?if($_REQUEST['photo']['photo_quality']):?><?=htmlspecialchars($_REQUEST['photo']['photo_quality'])?><?else:?><?=@htmlspecialchars($item->photo['photo_quality'])?><?endif;?>" class="form-control" />
				</div>
				
				<div class="pull-left m-t-xs">
					%
				</div>
			</div>

			<button class="btn btn-default pull-right" type="submit" onclick="return checkImage('form-horizontal');">KAYDET</button>
    </div>
    </form>
</div>
</section>









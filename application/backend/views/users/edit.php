<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="#"><?=lang('USERS')?></a></li>
	<li class="active"><?if($this->uri->segment(3) == 'add'):?><?=lang('USERS_NEW')?><?else:?><?=lang('USERS_EDIT')?><?endif;?></li>
</ul>

<form method="post" action="<?=base_url('backend/users')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" onsubmit="return prepareSubmit(this);">
<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=lang('PERSONEL_INFORMATIONS')?>
		<span class="pull-right"><a href="<?=site_url($item->username)?>" target="_blank"><?=$item->username?></a> &bull; <a href="<?=site_url('users/activation?code='.$item->activation_code.'&email='.$item->email)?>" target="_blank">Aktivasyon</a></span>		
	</header>
	<div class="panel-body">
			<div class="row">
								
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Ad</label>
						<input type="text" name="form[firstname]" value="<?if($_REQUEST['form']['firstname']):?><?=htmlspecialchars($_REQUEST['form']['firstname'])?><?else:?><?=htmlspecialchars($item->firstname)?><?endif;?>" class="form-control" />
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Soyad</label>
						<input type="text" name="form[lastname]" value="<?if($_REQUEST['form']['lastname']):?><?=htmlspecialchars($_REQUEST['form']['lastname'])?><?else:?><?=htmlspecialchars($item->lastname)?><?endif;?>" class="form-control" />
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>		
				</div>
	
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">E-posta</label>
						<input type="text" name="form[email]" value="<?if($_REQUEST['form']['email']):?><?=htmlspecialchars($_REQUEST['form']['email'])?><?else:?><?=htmlspecialchars($item->email)?><?endif;?>" class="form-control" />
					</div>
				</div>	
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Onay Bekleyen E-posta</label>
						<input type="text" name="form[email_request]" value="<?if($_REQUEST['form']['email_request']):?><?=htmlspecialchars($_REQUEST['form']['email_request'])?><?else:?><?=htmlspecialchars($item->email_request)?><?endif;?>" class="form-control" />
					</div>
				</div>				
				
				<div class="clearfix"></div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Kullanıcı Adı</label>
						<input type="text" name="form[username]" value="<?if($_REQUEST['form']['username']):?><?=htmlspecialchars($_REQUEST['form']['username'])?><?else:?><?=htmlspecialchars($item->username)?><?endif;?>" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Şifre</label>
						<input type="text" disabled="" name="form[password_text]" value="<?if($_REQUEST['form']['password_text']):?><?=htmlspecialchars($_REQUEST['form']['password_text'])?><?else:?><?=htmlspecialchars($item->password_text)?><?endif;?>" class="form-control" />
					</div>
				</div>				

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Meslek</label>
						<select name="form[profession]" class="chosen-select">
							<option value=""><?=lang('PLEASE_SELECT')?></option>
							<?foreach($professions as $profession):?>
								<option value="<?=$profession->id?>"<?if($_REQUEST['form']['profession'] == $profession->id || $item->profession == $profession->id):?> selected<?endif;?>><?=$profession->title?></option>
							<?endforeach;?>
						</select>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Cinsiyet</label>
						<select name="form[gender]" class="chosen-select">
							<option value="M"<?if($_REQUEST['form']['gender'] == 'M' || $item->gender == 'M'):?> selected<?endif;?>>Erkek</option>
							<option value="F"<?if($_REQUEST['form']['gender'] == 'F' || $item->gender == 'F'):?> selected<?endif;?>>Kadın</option>
						</select>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Şehir</label>
						<select name="form[city]" class="chosen-select" id="city">
							<?foreach($cities as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['form']['city'] == $c->id || $item->city == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
						</select>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">İlçe</label>
						<select name="form[town]" class="chosen-select" id="town"></select>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Cep Telefonu</label>
						<input type="text" name="form[mobile]" data-type="mobile-number" value="<?if($_REQUEST['form']['mobile']):?><?=htmlspecialchars($_REQUEST['form']['mobile'])?><?else:?><?=htmlspecialchars($item->mobile)?><?endif;?>" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Doğum Tarihi</label>
						<input type="text" name="form[birthday]" value="<?if($_REQUEST['form']['birthday']):?><?=htmlspecialchars($_REQUEST['form']['birthday'])?><?else:?><?=$item->birthday?><?endif;?>" class="dp form-control" />
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Randevu Tarihi</label>
						<input type="text" name="form[demo_date]" value="<?if($_REQUEST['form']['demo_date']):?><?=htmlspecialchars($_REQUEST['form']['demo_date'])?><?else:?><?if($item->demo_date):?><?=date('d.m.Y H:i', $item->demo_date)?><?endif;?><?endif;?>" class="datetimepicker form-control" />
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Aktivasyon Kodu</label>
						<input type="text" name="form[activation_code]" value="<?if($_REQUEST['form']['activation_code']):?><?=htmlspecialchars($_REQUEST['form']['activation_code'])?><?else:?><?=$item->activation_code?><?endif;?>" class="form-control" />
					</div>
				</div>	
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Deneme Kullanabilir</label>
						<select name="form[allow_trial]" class="chosen-select">
							<option value=""<?if($_REQUEST['form']['allow_trial'] == '' || $item->allow_trial == ''):?> selected<?endif;?>>Hayır</option>
							<option value="1"<?if($_REQUEST['form']['allow_trial'] == '1' || $item->allow_trial == '1'):?> selected<?endif;?>>Evet</option>
						</select>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Özel Web Sayfası</label>
						<select name="form[service_web]" class="chosen-select">
							<option value="Y"<?if($_REQUEST['form']['service_web'] == 'Y' || $item->service_web == 'Y'):?> selected<?endif;?>>Aktif</option>
							<option value="N"<?if($_REQUEST['form']['service_web'] == 'N' || $item->service_web == 'N'):?> selected<?endif;?>>Pasif</option>
						</select>
					</div>
				</div>															
				
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label block">Yönetici Notu (kullanıcı görmez)</label>
						<textarea name="form[notes]" class="form-control" rows="4"><?if($_REQUEST['form']['notes']):?><?=htmlspecialchars($_REQUEST['form']['notes'])?><?else:?><?=$item->notes?><?endif;?></textarea>
					</div>		
				</div>		
				
				<div class="clearfix"></div>		
			</div>
		</div>
</section>

<?if(is_teacher($item->id)):?>

<!-- dersler -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Eğitmen Dersleri
	</header>
	<div class="panel-body">
	
		<table class="table table-responsive prices-table">
			<tr>
				<th>Kategori</th>
				<th>Konu</th>
				<th>Özel Ders Fiyatı</th>
				<th>Canlı Ders Fiyatı</th>
				<th>İşlemler</th>
			</tr>
			<?if(!empty($prices)):?>
			<?foreach($prices as $price):?>
			<tr>
				<td>
					<select name="current[category][<?=$price->id?>]" data-name="category" class="chosen-select" id="current_category_<?=$price->id?>">
						<?foreach($categories as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['current']['category'] == $c->id || $price->subject_id == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
					</select>					
				</td>
				<td>
					<select name="current[lesson][<?=$price->id?>]" class="chosen-select" id="current_lesson_<?=$price->id?>"></select>
				</td>
				<td>
					<input type="text" class="form-control" name="current[price_private][<?=$price->id?>]" value="<?=$price->price_private?>" />
				</td>
				<td>
					<input type="text" class="form-control" name="current[price_live][<?=$price->id?>]" value="<?=$price->price_live?>" />
				</td>								
				<td>
					<button class="btn btn-danger js-price-delete">Sil</button>
				</td>
			</tr>
			<script type="text/javascript">
				jQuery(document).ready(function(){
				"use strict";			
				jQuery("#current_lesson_<?=$price->id?>").remoteChained("#current_category_<?=$price->id?>", base_url+"backend/users/subcategories", {attribute: 'data-name', selected: '<?=$price->level_id?>'});
				jQuery("#current_category_<?=$price->id?>").trigger('change');
				});
			</script>
			<?endforeach;?>
			<?endif;?>
			<tr class="new">
				<td>
					<select name="new[category][]" class="chosen-select" data-name="category" id="new_category">
						<option value="">-- Kategori Seçiniz --</option>
						<?foreach($categories as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['new']['category'] == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
					</select>					
				</td>
				<td>
					<select name="new[lesson][]" data-name="category" class="chosen-select" id="new_lesson"></select>
				</td>
				<td>
					<input type="text" class="form-control" name="new[price_private][]" />
				</td>				
				<td>
					<input type="text" class="form-control" name="new[price_live][]" />
				</td>				
				<td>
					<button class="btn btn-success js-price-new">Ekle</button>
				</td>
			</tr>						
		</table>

	</div>
</section>

<!-- lokasyonlar -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Lokasyonlar
	</header>
	<div class="panel-body">
	
		<table class="table table-responsive locations-table">
			<tr>
				<th>Şehir</th>
				<th>İlçe</th>
				<th>İşlemler</th>
			</tr>
			<?if(!empty($locations)):?>
			<?foreach($locations as $location):?>
			<tr>
				<td>
					<select name="current_location[city][<?=$location->id?>]" data-name="city" class="chosen-select" id="current_city_<?=$location->id?>">
						<?foreach($cities as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['current_location']['city'] == $c->id || $location->city == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
					</select>					
				</td>
				<td>
					<select name="current_location[town][<?=$location->id?>]" class="chosen-select" id="current_town_<?=$location->id?>"></select>
				</td>								
				<td>
					<button class="btn btn-danger js-location-delete">Sil</button>
				</td>
			</tr>
			<script type="text/javascript">
				jQuery(document).ready(function(){
				"use strict";			
				jQuery("#current_town_<?=$location->id?>").remoteChained("#current_city_<?=$location->id?>", base_url+"backend/users/getLocations", {attribute: 'data-name', selected: '<?=$location->town?>'});
				jQuery("#current_city_<?=$location->id?>").trigger('change');
				});
			</script>
			<?endforeach;?>
			<?endif;?>
			<tr class="new">
				<td>
					<select name="new_location[city][]" class="chosen-select" data-name="city" id="new_city">
						<option value="">-- Kategori Seçiniz --</option>
						<?foreach($cities as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['new_location']['city'] == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
					</select>					
				</td>
				<td>
					<select name="new_location[town][]" data-name="category" class="chosen-select" id="new_town"></select>
				</td>			
				<td>
					<button class="btn btn-success js-location-new">Ekle</button>
				</td>
			</tr>						
		</table>

	</div>
</section>

<!-- egitim bilgileri -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Eğitim Bilgileri
	</header>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th width="120"></th>
						<th>Okul Adı</th>
						<th>Bölüm Adı</th>
						<th width="120">Mezuniyet Yılı</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>Lise</strong></td>
						<td><input type="text" name="form[school_name]" class="form-control" value="<?if($_REQUEST['form']['school_name']):?><?=htmlspecialchars($_REQUEST['form']['school_name'])?><?else:?><?=$item->school_name?><?endif;?>" /></td>
						<td><input type="text" name="form[school_section]" class="form-control" value="<?if($_REQUEST['form']['school_section']):?><?=htmlspecialchars($_REQUEST['form']['school_section'])?><?else:?><?=$item->school_section?><?endif;?>" /></td>
						<td><input type="text" name="form[school_end]" class="form-control" value="<?if($_REQUEST['form']['school_end']):?><?=htmlspecialchars($_REQUEST['form']['school_end'])?><?else:?><?=$item->school_end?><?endif;?>" /></td>								
					</tr>
					<tr>
						<td><strong>Üniversite</strong></td>
						<td><input type="text" name="form[school2_name]" class="form-control" value="<?if($_REQUEST['form']['school2_name']):?><?=htmlspecialchars($_REQUEST['form']['school2_name'])?><?else:?><?=$item->school2_name?><?endif;?>" /></td>
						<td><input type="text" name="form[school2_section]" class="form-control" value="<?if($_REQUEST['form']['school2_section']):?><?=htmlspecialchars($_REQUEST['form']['school2_section'])?><?else:?><?=$item->school2_section?><?endif;?>" /></td>
						<td><input type="text" name="form[school2_end]" class="form-control" value="<?if($_REQUEST['form']['school2_end']):?><?=htmlspecialchars($_REQUEST['form']['school2_end'])?><?else:?><?=$item->school2_end?><?endif;?>" /></td>
					</tr>
					<tr>
						<td><strong>Yüksek Lisans</strong></td>
						<td><input type="text" name="form[school3_name]" class="form-control" value="<?if($_REQUEST['form']['school3_name']):?><?=htmlspecialchars($_REQUEST['form']['school3_name'])?><?else:?><?=$item->school3_name?><?endif;?>" /></td>
						<td><input type="text" name="form[school3_section]" class="form-control" value="<?if($_REQUEST['form']['school3_section']):?><?=htmlspecialchars($_REQUEST['form']['school3_section'])?><?else:?><?=$item->school3_section?><?endif;?>" /></td>
						<td><input type="text" name="form[school3_end]" class="form-control" value="<?if($_REQUEST['form']['school3_end']):?><?=htmlspecialchars($_REQUEST['form']['school3_end'])?><?else:?><?=$item->school3_end?><?endif;?>" /></td>
					</tr>
					<tr>
						<td><strong>Doktora</strong></td>
						<td><input type="text" name="form[school4_name]" class="form-control" value="<?if($_REQUEST['form']['school4_name']):?><?=htmlspecialchars($_REQUEST['form']['school4_name'])?><?else:?><?=$item->school4_name?><?endif;?>" /></td>
						<td><input type="text" name="form[school4_section]" class="form-control" value="<?if($_REQUEST['form']['school4_section']):?><?=htmlspecialchars($_REQUEST['form']['school4_section'])?><?else:?><?=$item->school4_section?><?endif;?>" /></td>
						<td><input type="text" name="form[school4_end]" class="form-control" value="<?if($_REQUEST['form']['school4_end']):?><?=htmlspecialchars($_REQUEST['form']['school4_end'])?><?else:?><?=$item->school4_end?><?endif;?>" /></td>
					</tr>																												
				</tbody>						
			</table>
		</div>	
	</div>
</section>

<!-- tanitim yazilari -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Tanıtım Yazıları
	</header>
	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Başlık</label>
						<input type="text" name="form[text_title]" class="form-control" value="<?if($_REQUEST['form']['text_title']):?><?=htmlspecialchars($_REQUEST['form']['text_title'])?><?else:?><?=$item->text_title?><?endif;?>" />
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>
				</div>
				<!--
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Karşılama Metni</label>
						<textarea name="form[text_short]" class="form-control" rows="5"><?if($_REQUEST['form']['text_short']):?><?=htmlspecialchars($_REQUEST['form']['text_short'])?><?else:?><?=$item->text_short?><?endif;?></textarea>
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>		
				</div>
				-->
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Detaylı Tanıtım Metni</label>
						<textarea name="form[text_long]" class="form-control" rows="5"><?if($_REQUEST['form']['text_long']):?><?=htmlspecialchars($_REQUEST['form']['text_long'])?><?else:?><?=$item->text_long?><?endif;?></textarea>
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>		
				</div>
				<!--
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Ders Yaklaşımı ve Tecrübesi</label>
						<textarea name="form[text_lesson]" class="form-control" rows="5"><?if($_REQUEST['form']['text_lesson']):?><?=htmlspecialchars($_REQUEST['form']['text_lesson'])?><?else:?><?=$item->text_lesson?><?endif;?></textarea>
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>		
				</div>		
				-->		
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Referanslar</label>
						<textarea name="form[text_reference]" class="form-control" rows="5"><?if($_REQUEST['form']['text_reference']):?><?=htmlspecialchars($_REQUEST['form']['text_reference'])?><?else:?><?=$item->text_reference?><?endif;?></textarea>
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>		
				</div>				
			</div>
		</div>
</section>

<!-- tercihler -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Eğitim Bilgileri
	</header>
	<div class="panel-body">
		<div class="table-responsive">
            <table class="table">
                <tbody>   
                    <tr>
						<td colspan="2"><strong>Eğitim Tercihleri</strong></td>
                    </tr>                                            
                    <tr>
						<td>Ders Verilen Şekiller</td>
						<td>
							  <?$figures = $item->figures ? explode(',', $item->figures) : '';?>
							  <div class="row">
								  <div class="col-md-4">
									  <input type="checkbox" name="form[figures][]" id="f1" value="1"<?if(!empty($figures) && in_array(1, $figures)):?> checked<?endif;?>> <label for="f1">Birebir Ders</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[figures][]" id="f2" value="2"<?if(!empty($figures) && in_array(2, $figures)):?> checked<?endif;?>> <label for="f2">Grup Dersi</label>
								  </div>									  
							  </div>
						</td>
                    </tr> 
                    <tr>
						<td>Ders Verilen Mekanlar</td>
						<td>
							  <?$places = $item->places ? explode(',', $item->places) : '';?>
							  <div class="row">
								  <div class="col-md-4">
									  <input type="checkbox" name="form[places][]" id="p1" value="1"<?if(!empty($places) && in_array(1, $places)):?> checked<?endif;?>> <label for="p1">Öğrencinin Evi</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[places][]" id="p2" value="2"<?if(!empty($places) && in_array(2, $places)):?> checked<?endif;?>> <label for="p2">Eğitmen Evi</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[places][]" id="p3" value="3"<?if(!empty($places) && in_array(3, $places)):?> checked<?endif;?>> <label for="p3">Etüd Merkezi</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[places][]" id="p4" value="4"<?if(!empty($places) && in_array(4, $places)):?> checked<?endif;?>> <label for="p4">Kütüphane</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[places][]" id="p5" value="5"<?if(!empty($places) && in_array(5, $places)):?> checked<?endif;?>> <label for="p5">Diğer</label>
								  </div>										  
							  </div>
						</td>
                    </tr>                                                        
                    <tr>
						<td>Ders Verilen Zamanlar</td>
						<td>
							  <?$times = $item->times ? explode(',', $item->times) : '';?>
							  <div class="row">
								  <div class="col-md-4">
									  <input type="checkbox" name="form[times][]" id="t1" value="1"<?if(!empty($times) && in_array(1, $times)):?> checked<?endif;?>> <label for="t1">Hafta İçi Gündüz</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[times][]" id="t2" value="2"<?if(!empty($times) && in_array(2, $times)):?> checked<?endif;?>> <label for="t2">Hafta İçi Akşam</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[times][]" id="t3" value="3"<?if(!empty($times) && in_array(3, $times)):?> checked<?endif;?>> <label for="t3">Hafta Sonu Gündüz</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[times][]" id="t4" value="4"<?if(!empty($times) && in_array(4, $times)):?> checked<?endif;?>> <label for="t4">Hafta Sonu Akşam</label>
								  </div>
							  </div>
						</td>
                    </tr>
                    <tr>
						<td>Sunulan Hizmetler</td>
						<td>
							  <?$services = $item->services ? explode(',', $item->services) : '';?>
							  <div class="row">
								  <div class="col-md-4">
									  <input type="checkbox" name="form[services][]" id="s1" value="1"<?if(!empty($services) && in_array(1, $services)):?> checked<?endif;?>> <label for="s1">Ödev Yardımı</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[services][]" id="s2" value="2"<?if(!empty($services) && in_array(2, $services)):?> checked<?endif;?>> <label for="s2">Tez Yardımı</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[services][]" id="s3" value="3"<?if(!empty($services) && in_array(3, $services)):?> checked<?endif;?>> <label for="s3">Proje Yardımı</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[services][]" id="s4" value="4"<?if(!empty($services) && in_array(4, $services)):?> checked<?endif;?>> <label for="s4">Eğitim Koçluğu</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[services][]" id="s5" value="5"<?if(!empty($services) && in_array(5, $services)):?> checked<?endif;?>> <label for="s5">Yaşam Koçluğu</label>
								  </div>
							  </div>
						</td>
                    </tr>    
                    <tr>
						<td>Ders Verilen Cinsiyetler</td>
						<td>
							  <?$genders = $item->genders ? explode(',', $item->genders) : '';?>
							  <div class="row">
								  <div class="col-md-4">
									  <input type="checkbox" name="form[genders][]" id="g1" value="1"<?if(!empty($genders) && in_array(1, $genders)):?> checked<?endif;?>> <label for="g1">Erkek</label>
								  </div>
								  <div class="col-md-4">
									  <input type="checkbox" name="form[genders][]" id="g2" value="2"<?if(!empty($genders) && in_array(2, $genders)):?> checked<?endif;?>> <label for="g2">Kadın</label>
								  </div>
							  </div>
						</td>
                    </tr>                                                                                      
                    <tr>
						<td colspan="2"><strong>Gizlilik Tercihleri</strong></td>
                    </tr>
                    <tr>
						<td>Soyadı Gizliliği</td>
						<td>
						  <select name="form[privacy_lastname]" class="form-control">
							  <option value="1"<?if($item->privacy_lastname == 1):?> selected<?endif;?>>Soyadımı herkes görsün</option>
							  <option value="2"<?if($item->privacy_lastname == 2):?> selected<?endif;?>>Soyadım yerine Öğretmen yazsın</option>
							  <option value="3"<?if($item->privacy_lastname == 3):?> selected<?endif;?>>Soyadımı sadece üye öğrenciler görsün</option>
						  </select>
						</td>
                    </tr>
                    <tr>
                    	<td>Telefon Gizliliği</td>
						<td>
						  <select name="form[privacy_phone]" class="form-control">
							  <?if($item->ugroup == 4 || $item->ugroup == 5):?>
							  <option value="1"<?if($item->privacy_phone == 1):?> selected<?endif;?>>Telefon numaramı herkes görsün</option>
							  <?endif;?>
							  <option value="2"<?if($item->privacy_phone == 2):?> selected<?endif;?>>Telefon numaramı üye öğrenciler görsün</option>
							  <option value="3"<?if($item->privacy_phone == 3):?> selected<?endif;?>>Telefon numaram hiçbir şekilde görülmesin</option>
						  </select>
						  <?if($item->ugroup == 3):?>
						  <span class="font-size-11 lightgrey-text">Telefon numaranızın herkes tarafından görünebilmesi için Advanced veya Premium üye olmalısınız.</td>
						  <?endif;?>
						</td>
                    </tr>
                </tbody>							                        
            </table>							
		</div>	
	</div>
</section>

<!-- virtual -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Virtual Bilgileri
	</header>
	<div class="panel-body">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Virtual</label>
						<select name="form[virtual]" class="chosen-select">
							<option value="Y"<?if($_REQUEST['form']['virtual'] == 'Y' || $item->virtual == 'Y'):?> selected<?endif;?>>Evet</option>
							<option value="N"<?if($_REQUEST['form']['virtual'] == 'N' || $item->virtual == 'N'):?> selected<?endif;?>>Hayır</option>
						</select>
					</div>
				</div>							

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Virtual ID</label>
						<input type="text" name="form[virtual_id]" value="<?if($_REQUEST['form']['virtual_id']):?><?=htmlspecialchars($_REQUEST['form']['virtual_id'])?><?else:?><?=$item->virtual_id?><?endif;?>" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Virtual URL</label>
						<input type="text" name="form[virtual_url]" value="<?if($_REQUEST['form']['virtual_url']):?><?=htmlspecialchars($_REQUEST['form']['virtual_url'])?><?else:?><?=$item->virtual_url?><?endif;?>" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Virtual Konular</label>
						<input type="text" name="form[virtual_subjects]" value="<?if($_REQUEST['form']['virtual_subjects']):?><?=htmlspecialchars($_REQUEST['form']['virtual_subjects'])?><?else:?><?=$item->virtual_subjects?><?endif;?>" class="form-control" />
					</div>
				</div>				
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Virtual Dersler</label>
						<input type="text" name="form[virtual_levels]" value="<?if($_REQUEST['form']['virtual_levels']):?><?=htmlspecialchars($_REQUEST['form']['virtual_levels'])?><?else:?><?=$item->virtual_levels?><?endif;?>" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Virtual Ücret</label>
						<input type="text" name="form[virtual_price]" value="<?if($_REQUEST['form']['virtual_price']):?><?=htmlspecialchars($_REQUEST['form']['virtual_price'])?><?else:?><?=$item->virtual_price?><?endif;?>" class="form-control" />
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Virtual Yaş</label>
						<input type="text" name="form[virtual_age]" value="<?if($_REQUEST['form']['virtual_age']):?><?=htmlspecialchars($_REQUEST['form']['virtual_age'])?><?else:?><?=$item->virtual_age?><?endif;?>" class="form-control" />
					</div>
				</div>		
				
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label block">Virtual Eğitim</label>
						<textarea name="form[virtual_education]" class="form-control" rows="4"><?if($_REQUEST['form']['virtual_education']):?><?=htmlspecialchars($_REQUEST['form']['virtual_education'])?><?else:?><?=$item->virtual_education?><?endif;?></textarea>
					</div>		
				</div>
			</div>
		</div>
</section>

<!-- hesap -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Hesap Bilgileri
	</header>
	<div class="panel-body">
			<div class="row">
	
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label">Durum</label>
						<select name="form[status]" class="form-control">
							<option value="A"<?if($_REQUEST['form']['status'] == 'A' || $item->status == 'A'):?> selected<?endif;?>>Aktif</option>
							<option value="C"<?if($_REQUEST['form']['status'] == 'C' || $item->status == 'C'):?> selected<?endif;?>>İptal Edilmiş</option>
							<option value="D"<?if($_REQUEST['form']['status'] == 'D' || $item->status == 'D'):?> selected<?endif;?>>Silinmiş</option>
							<option value="B"<?if($_REQUEST['form']['status'] == 'B' || $item->status == 'B'):?> selected<?endif;?>>Yasaklanmış</option>
							<option value="N"<?if($_REQUEST['form']['status'] == 'N' || $item->status == 'N'):?> selected<?endif;?>>Üyelik Tipsiz</option>
							<option value="R"<?if($_REQUEST['form']['status'] == 'R' || $item->status == 'R'):?> selected<?endif;?>>Eksik Tamamlıyor</option>							
							<option value="S"<?if($_REQUEST['form']['status'] == 'S' || $item->status == 'S'):?> selected<?endif;?>>İncelenmede</option>							
							<option value="T"<?if($_REQUEST['form']['status'] == 'T' || $item->status == 'T'):?> selected<?endif;?>>Randevuda</option>							
						</select>
					</div>
				</div>		
				
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label">Üyelik Grubu</label>
						<select name="form[ugroup]" class="form-control">
							<?foreach($groups as $group):?>
							<?if(strstr(uri_string(), 'add') == TRUE && !in_array($group->id, array(2,3,4,5)) || strstr(uri_string(), 'edit') == TRUE):?>
							<option value="<?=$group->id?>"<?if($_REQUEST['form']['group'] == $group->id || $item->ugroup == $group->id):?> selected<?endif;?>><?=$group->name?></option>
							<?endif;?>
							<?endforeach;?>
						</select>
					</div>	
				</div>
				
				<div class="col-sm-4">
					<div class="form-group">
						<label class="control-label">Üyelik Sonlanma Tarihi</label>
						<input type="text" name="form[expire_membership]" value="<?if($_REQUEST['form']['expire_membership']):?><?=htmlspecialchars($_REQUEST['form']['expire_membership'])?><?else:?><?if($item->expire_membership):?><?=date('d.m.Y H:i:s', $item->expire_membership)?><?endif;?><?endif;?>" class="dp form-control" />
					</div>	
				</div>				
														
			</div>
		</div>
</section>

<!-- sifre -->
<div class="row">
	<?if($item->photo):?>
	<div class="col-sm-2">
		<section class="panel panel-default m-t">
			<header class="panel-heading bg-light">
				Fotoğraf
			</header>
			<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<img src="<?=base_url($item->photo)?>" width="100%" />
						</div>				
					</div>
				</div>
		</section>	
		
	</div>
	<?endif;?>
	
	<div class="col-sm-<?if($item->photo):?>10<?else:?>12<?endif;?>">
		<section class="panel panel-default m-t">
			<header class="panel-heading bg-light">
				Şifre<?if(strstr(uri_string(), 'edit') == TRUE):?> Değiştir<?endif;?>
			</header>
			<div class="panel-body">
					<div class="row">
				
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Yeni Şifre</label>
								<input type="text" name="form[password]" class="form-control" />
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Yeni Şifre (Tekrar)</label>
								<input type="text" name="form[password2]" class="form-control" />
							</div>
						</div>
												
					</div>
				</div>
		</section>
	</div>
</div>

<!-- sms -->
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		SMS Gönder
	</header>
	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Mesaj</label>
						<input type="text" name="form[sms_text]" class="form-control" />
					</div>
				</div>			
			</div>
		</div>
</section>

<?endif;?>

<!-- degerlendirme -->
<?if($item->status == 'S'):?>
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		İnceleme Değerlendirmesi
	</header>
	<div class="panel-body">
			<div class="row">
				<div class="col-sm-12 m-b">
					Aktivasyon: <?if($item->email_request):?>Hayır<?else:?>Evet<?endif;?>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Ön Tanımlı Yorumlar</label>
						<select id="preactive-comments" class="form-control">
							<option>-- Lütfen Seçiniz --</option>
							<option>Tanıtım yazılarınızdaki imla ve yazım hatalarını kontrol etmenizi rica ederiz.</option>
							<option>Tanıtım yazılarınızdaki bilgiler yetersizdir. Lütfen tanıtım yazılarınızı gözden geçirerek, kendinizle ve verdiğiniz eğitimlerle ilgili daha detaylı bilgiler veriniz.</option>
							<option>Profilinizi onaylıyoruz ancak profiliniz için doldurduğunuz tanıtım yazılarınız (başlık, karşılama metni, detaylı tanıtım metni, ders yaklaşımı ve tecrübesi) öğrencilerin sizi tercih etmesi için yeterli değildir. Hesabınıza giriş yaparak ayrıntılı ve geniş kapsamlı olarak tanıtım yazılarınızı güncellemeniz gerekmektedir. Kendinizi öğrencinin yerine koyup profilinizi gözden geçiriniz. Siz, "bu profil öğrencilerin beni tercih etmesi için yeterlidir" diyemediğiniz sürece, öğrencilerin sizi seçip, ulaşmasını bekleyemezsiniz. Amacımız sizin gibi değerli eğitmenlere kazanç kapısı oluşturmaktır. Bu nedenle eğitmenlerimize profilini doldurması için baskı kurmuyoruz. Her eğitmen profiline ne kadar etkileyici ve fazla bilgi verirse o kadar çok öğrenci tarafından tercih edilip kazancını arttırmaktadır. Mutlu günler dileriz.</option>
						</select>
					</div>		
				</div>				
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">İnceleme Yorumu</label>
						<textarea name="form[review_comment]" id="review_comment" class="form-control" rows="2"><?if($_REQUEST['form']['review_comment']):?><?=htmlspecialchars($_REQUEST['form']['review_comment'])?><?endif;?></textarea>
					</div>		
				</div>
				
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Değerlendirme Sonucu</label>
						<select name="form[review_status]" class="form-control">
							<option value="">-- Lütfen Seçiniz --</option>
							<option value="A">Profili onaylıyorum</option>
							<option value="R">Profil uygun değil</option>
						</select>
					</div>	
				</div>										
			</div>
		</div>
</section>
<?endif;?>

<!-- aktiviteler -->
<?if($requests_activities):?>
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Talep Kayıtları
	</header>
	<div class="panel-body">
		<table class="table table-responsive prices-table">
			<tr>
				<th>Talep No</th>
				<th>İşlem Adı</th>
				<th>Eğitmen</th>
				<th>Gerçekleşen İşlem</th>
				<th>Açıklama</th>
				<th>Tarih</th>
			</tr>
			<?foreach($requests_activities as $activity):?>
			<tr>
				<td><a href="<?=base_url('backend/requests/edit/'.$activity->request_id)?>" target="_blank"><?=$activity->request_id?></a></td>
				<td><?=$activity->status->title?></td>
				<td><?if($activity->teacher):?><a href="<?=base_url('backend/users/edit/'.$activity->teacher->id)?>" target="_blank"><?=$activity->teacher->firstname?> <?=$activity->teacher->lastname?> (<?=$activity->teacher->mobile?>)</a><?endif;?></td>
				<td>
					<?if($activity->status_id == 4):?><?=date('d.m.Y H:i', $activity->appointment_date)?><?endif;?>
					<?if($activity->status_id == 13):?><?=$activity->lesson_hour?> saat / <?if($activity->price_type == 1):?>hafta<?elseif($activity->price_type == 2):?>ay<?else:?>sabit<?endif;?> (<?=format_price($activity->hourly_price)?> TL)<?endif;?>
					<?if($activity->status_id == 14):?><?=$activity->model->title?><?if($activity->model_price):?> (<?=format_price($activity->model_price)?> TL)<?endif;?><?endif;?>
					<?if($activity->status_id == 7):?><?if($activity->payed == 'Y'):?>Ödendi<?else:?>Ödenmedi<?endif;?>: <?=$activity->lesson_hour?> saat, <?=date('d.m.Y H:i', $activity->start_date)?> - <?=date('d.m.Y H:i', $activity->end_date)?>, <?=format_price($activity->price)?> TL<?endif;?>
				</td>
				<td><?if($activity->description):?><?=$activity->description?><?elseif($activity->status->description):?><?=$activity->status->description?><?endif;?></td>
				<td><?=nicetime($activity->create_date)?> (<?=date('d.m.Y H:i', $activity->create_date)?>)</td>
			</tr>
			<?endforeach;?>
		</table>	
	</div>
</section>
<?endif;?>

<input type="hidden" name="form[activation_code]" value="<?=$item->activation_code?>" />

<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
</form>

<script src="<?=base_url('public/backend/js/datepicker/bootstrap-datepicker.js')?>"></script>
<link rel="stylesheet" href="<?=base_url('public/backend/js/datepicker/datepicker.css')?>" type="text/css" />
<script>
jQuery(document).ready(function(){
"use strict";
	jQuery("#town").remoteChained("#city", base_url+"backend/users/getLocations", {selected: '<?if($_REQUEST['form']['city']):?><?=$_REQUEST['form']['city']?><?else:?><?=$item->town?><?endif;?>'});
	jQuery("#district").remoteChained("#town", base_url+"backend/users/getLocations", {selected: '<?if($_REQUEST['form']['city']):?><?=$_REQUEST['form']['city']?><?else:?><?=$item->district?><?endif;?>'});
	jQuery("#city").trigger('change');
	
	jQuery("#new_lesson").remoteChained("#new_category", base_url+"backend/users/subcategories", {attribute: 'data-name', selected: '<?=$_REQUEST['new']['lesson']?>'});
	jQuery("#new_category").trigger('change');
	
	jQuery("#new_town").remoteChained("#new_city", base_url+"backend/users/getLocations", {attribute: 'data-name', selected: '<?=$_REQUEST['new_location']['town']?>'});
	jQuery("#new_city").trigger('change');	
	
	$('#preactive-comments').on('change', function(){
		var current_comment = $('#review_comment').val();
		if(current_comment !== undefined){
			$('#review_comment').val(current_comment + ' ' + $('#preactive-comments option:selected').text());
		} else {
			$('#review_comment').val($('#preactive-comments option:selected').text());
		}
	});
	
	$('.js-price-new').on('click', function(){

		if(!$('.prices-table .new select[name="new[lesson][]"]').val()){
			alert("Lütfen konu seçiniz");
			return false;	
		}
		
		if(!$('.prices-table .new input[name="new[price][]"]').val() && !$('.prices-table .new input[name="new[price_private][]"]').val()){
			alert("Lütfen fiyat giriniz");
			return false;	
		}
		
		var cloned = $(this).closest('tr').clone();
		var clonedButton = cloned.find('button');
		var theid = $('table select').length;
		var new_category_value = $("#new_category option:selected").val();
		var new_lesson_value = $("#new_lesson option:selected").val();
		var remotechainedcode = '<script type="text/javascript">jQuery("#new_lesson_'+theid+'").remoteChained("#new_category_'+theid+'", "'+base_url+'backend/users/subcategories", {attribute: "data-name", selected: "'+new_lesson_value+'"});</scr'+'ipt>';
		
		cloned.removeAttr('class');
		cloned.find('div').remove();
		cloned.find('select#new_category option[value='+new_category_value+']').attr('selected', 'selected');
		cloned.find('select#new_category').attr('id', 'new_category_' + theid);
		cloned.find('select#new_lesson').attr('id', 'new_lesson_' + theid);
		cloned.append(remotechainedcode);		

		clonedButton.text('Sil');
		clonedButton.removeClass('btn-success');
		clonedButton.removeClass('js-price-new');
		clonedButton.addClass('btn-danger');
		clonedButton.addClass('js-price-delete');
		
		$('.prices-table .new input[name="new[price_live][]"]').val('');
		$('.prices-table .new input[name="new[price_private][]"]').val('');
		
		cloned.insertBefore('.prices-table .new');
		
		jQuery("#new_category_"+theid).trigger('change');
		
		$(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});
		
		$(window).trigger('resize');
		
		return false;
	});
	
	$('.js-location-new').on('click', function(){

		if(!$('.locations-table .new select[name="new_location[town][]"]').val()){
			alert("Lütfen ilçe seçiniz");
			return false;	
		}
		
		var cloned = $(this).closest('tr').clone();
		var clonedButton = cloned.find('button');
		var theid = $('table select').length;
		var new_city_value = $("#new_city option:selected").val();
		var new_town_value = $("#new_town option:selected").val();
		var remotechainedcode = '<script type="text/javascript">jQuery("#new_town_'+theid+'").remoteChained("#new_city_'+theid+'", "'+base_url+'backend/users/getLocations", {attribute: "data-name", selected: "'+new_town_value+'"});</scr'+'ipt>';
		
		cloned.removeAttr('class');
		cloned.find('div').remove();
		cloned.find('select#new_city option[value='+new_city_value+']').attr('selected', 'selected');
		cloned.find('select#new_city').attr('id', 'new_city_' + theid);
		cloned.find('select#new_town').attr('id', 'new_town_' + theid);
		cloned.append(remotechainedcode);		

		clonedButton.text('Sil');
		clonedButton.removeClass('btn-success');
		clonedButton.removeClass('js-location-new');
		clonedButton.addClass('btn-danger');
		clonedButton.addClass('js-location-delete');
		
		cloned.insertBefore('.locations-table .new');
		
		jQuery("#new_city_"+theid).trigger('change');
		
		$(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});
		
		$(window).trigger('resize');
		return false;
	});	
	
	$(document).on('click', '.js-price-delete', function(){
		$(this).closest('tr').remove();
		return false;
	});
	
	$(document).on('click', '.js-location-delete', function(){
		$(this).closest('tr').remove();
		return false;
	});	

	$('select').on('change', function(){
		$(window).trigger('resize');
	});	

	$('.fix-text-capitalize').on('click', function(e){
		e.preventDefault();
		$(this).parent().find('input,textarea').val($(this).parent().find('input,textarea').val().turkishCapitalize());
	});
	
	$('.fix-text-capitalizewords').on('click', function(e){
		e.preventDefault();
		$(this).parent().find('input,textarea').val($(this).parent().find('input,textarea').val().turkishCapitalizeWords());
	});	
	
	String.prototype.turkishUpperCase = function () {
	    return this.replace(/ğ/g, 'Ğ')
	        .replace(/ü/g, 'Ü')
	        .replace(/ş/g, 'Ş')
	        .replace(/ı/g, 'I')
	        .replace(/i/g, 'İ')
	        .replace(/ö/g, 'Ö')
	        .replace(/ç/g, 'Ç')
	        .toUpperCase();
	};
	
	String.prototype.turkishLowerCase = function () {
	    return this.replace(/Ğ/g, 'ğ')
	        .replace(/Ü/g, 'ü')
	        .replace(/Ş/g, 'ş')
	        .replace(/I/g, 'ı')
	        .replace(/İ/g, 'i')
	        .replace(/Ö/g, 'ö')
	        .replace(/Ç/g, 'ç')
	        .toLowerCase();
	};
	
	String.prototype.turkishCapitalize = function()
	{
		//var str = this.charAt(0).turkishUpperCase() + this.slice(1).turkishLowerCase();
		
	    var a = this.replace(/(?:\r\n|\r|\n)/g, '. ').split('.');
	    for(var i=0;i < a.length; i++) 
	    a[i] = a[i].trim().charAt(0).turkishUpperCase() + a[i].trim().slice(1).turkishLowerCase();
	    return a.join('. ').trim().replace(/,/g, ', ').replace(/  /g, ' ');

	};
	
	String.prototype.turkishCapitalizeWords = function() 
	{
	    var a = this.split(' ');
	    for(var i=0;i < a.length; i++) a[i] = a[i].turkishCapitalize();
	    return a.join(' ');
	};
});
</script>
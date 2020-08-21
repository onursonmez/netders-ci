<ul class="breadcrumb">
	<li><a href="<?=base_url('backend')?>"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="<?=base_url('backend/users')?>"><?=lang('USERS')?></a></li>
	<li class="active"><?=lang('USERS_NEW')?></li>
</ul>

<form method="post" action="<?=base_url('backend/users/add')?>">
<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=lang('PERSONEL_INFORMATIONS')?>
	</header>
	<div class="card-body">
			<div class="row">
								
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Ad *</label>
						<input type="text" name="form[firstname]" value="<?if($_REQUEST['form']['firstname']):?><?=htmlspecialchars($_REQUEST['form']['firstname'])?><?endif;?>" class="form-control" />
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Soyad *</label>
						<input type="text" name="form[lastname]" value="<?if($_REQUEST['form']['lastname']):?><?=htmlspecialchars($_REQUEST['form']['lastname'])?><?endif;?>" class="form-control" />
						<a href="#" class="fix-text-capitalize"><small>İlk harf büyük</small></a> &bull; <a href="#" class="fix-text-capitalizewords"><small>Kelime büyük</small></a>
					</div>		
				</div>
	
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">E-posta</label>
						<input type="text" name="form[email]" value="<?if($_REQUEST['form']['email']):?><?=htmlspecialchars($_REQUEST['form']['email'])?><?endif;?>" class="form-control" />
					</div>
				</div>

				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Cep Telefonu *</label>
						<input type="text" data-type="mobile-number" name="form[mobile]" value="<?if($_REQUEST['form']['mobile']):?><?=htmlspecialchars($_REQUEST['form']['mobile'])?><?endif;?>" class="form-control" />
					</div>
				</div>
								
				<div class="clearfix"></div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Cinsiyet</label>
						<select name="form[gender]" class="chosen-select">
							<option value="M"<?if($_REQUEST['form']['gender'] == 'M'):?> selected<?endif;?>>Erkek</option>
							<option value="F"<?if($_REQUEST['form']['gender'] == 'F'):?> selected<?endif;?>>Kadın</option>
						</select>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label block">Şehir</label>
						<select name="form[city]" class="chosen-select" id="city">
							<?foreach($cities as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['form']['city'] == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
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
						<label class="control-label block">Bilgileri E-posta İle Gönder</label>
						<select name="form[send_mail]" class="chosen-select">
							<option value="Y"<?if($_REQUEST['form']['send_mail'] == 'Y'):?> selected<?endif;?>>Evet</option>						
							<option value="N"<?if($_REQUEST['form']['send_mail'] == 'N'):?> selected<?endif;?>>Hayır</option>
						</select>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label block">Yönetici Notu (kullanıcı görmez)</label>
						<textarea name="form[notes]" class="form-control" rows="4"><?if($_REQUEST['form']['notes']):?><?=htmlspecialchars($_REQUEST['form']['notes'])?><?endif;?></textarea>
					</div>		
				</div>					


						
			</div>
		</div>
</section>

<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Hesap Bilgileri
	</header>
	<div class="card-body">
			<div class="row">
	
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Durum</label>
						<select name="form[status]" class="form-control">
							<option value="A"<?if($_REQUEST['form']['status'] == 'A'):?> selected<?endif;?>>Aktif</option>
							<option value="C"<?if($_REQUEST['form']['status'] == 'C'):?> selected<?endif;?>>İptal Edilmiş</option>
							<option value="D"<?if($_REQUEST['form']['status'] == 'D'):?> selected<?endif;?>>Silinmiş</option>
							<option value="B"<?if($_REQUEST['form']['status'] == 'B'):?> selected<?endif;?>>Yasaklanmış</option>
							<option value="N"<?if($_REQUEST['form']['status'] == 'N'):?> selected<?endif;?>>Üyelik Tipsiz</option>
							<option value="R"<?if($_REQUEST['form']['status'] == 'R' || !$_REQUEST['form']['status']):?> selected<?endif;?>>Eksik Tamamlıyor</option>							
							<option value="S"<?if($_REQUEST['form']['status'] == 'S'):?> selected<?endif;?>>İncelenmede</option>							
							<option value="T"<?if($_REQUEST['form']['status'] == 'T'):?> selected<?endif;?>>Randevuda</option>							
						</select>
					</div>
				</div>		
				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Üyelik Grubu</label>
						<select name="form[group]" class="form-control">
							<?foreach($groups as $group):?>
							<option value="<?=$group->id?>"<?if($_REQUEST['form']['group'] == $group->id || (!$_REQUEST['form']['group'] && $group->id == 3)):?> selected<?endif;?>><?=$group->name?></option>
							<?endforeach;?>
						</select>
					</div>	
				</div>	
														
			</div>
		</div>
</section>

<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
</form>

<script src="<?=base_url('public/backend/js/datepicker/bootstrap-datepicker.js')?>"></script>
<link rel="stylesheet" href="<?=base_url('public/backend/js/datepicker/datepicker.css')?>" type="text/css" />
<script>
jQuery(document).ready(function(){
"use strict";
	jQuery("#town").remoteChained("#city", base_url+"backend/users/getLocations", {selected: '<?if($_REQUEST['form']['city']):?><?=$_REQUEST['form']['city']?><?endif;?>'});
	jQuery("#district").remoteChained("#town", base_url+"backend/users/getLocations", {selected: '<?if($_REQUEST['form']['city']):?><?=$_REQUEST['form']['city']?><?endif;?>'});
	jQuery("#city").trigger('change');
	
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
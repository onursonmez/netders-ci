<form  action="<?=site_url('users/personal')?>" method="post" class="ajax-form js-dont-reset" enctype="multipart/form-data">

<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Kişisel Bilgiler</h4>
	</div>
	<div class="card-body">
				<div class="row">
					<div class="form-group col-12 col-lg-6">
						<label>Kullanıcı Adı</label>
						<input type="text" name="username" class="form-control" value="<?=$this->session->userdata('user_username')?>"<?if(!is_numeric($this->session->userdata('user_username'))):?>disabled<?endif;?> data-toggle="tooltip" data-placement="top" title="Kullanıcı adı yalnızca bir defa değiştirilebilir. Kullanıcı adı aynı zamanda sayfa adresinizdir: <?=site_url($this->session->userdata('user_username'))?>" />
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>E-posta Adresi <?if($this->session->userdata('user_email_request')):?><a href="<?=site_url('users/emailchange')?>" class="red-text"><i class="fa fa-refresh fa-spin" data-toggle="tooltip" title="E-posta adresiniz onay bekliyor. Onay kodunu tekrar göndermek veya işlemi iptal etmek istiyorsanız tıklayınız."></i></a><?endif;?></label>
						<input type="email" name="email" class="form-control" value="<?if($this->session->userdata('user_email_request')):?><?=$this->session->userdata('user_email_request')?><?else:?><?=$this->session->userdata('user_email')?><?endif;?>" data-toggle="tooltip" data-placement="top" title="E-posta adresinizi değiştirdiğinizde, değiştirdiğiniz e-posta adresiniz için daha önce yapmadıysanız aktivasyon işlemi yapmanız gerekir. Ayrıca eğitmen hesaplarının profilleri aktivasyon tamamlanana kadar arama sonuçlarında görünmez." />
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Ad</label>
						<input type="text" name="firstname" class="form-control" value="<?=$this->session->userdata('user_firstname')?>" />
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Soyad</label>
						<input type="text" name="lastname" class="form-control" value="<?=$this->session->userdata('user_lastname')?>" data-toggle="tooltip" data-placement="top" title="Lütfen soyadınızı doğru giriniz. Soyadı alanına hoca, öğretmen vb. yazmayınız. Soyadınızın görünmesini istemiyorsanız tercihler bölümünden gizleyebilirsiniz." />
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Doğum Tarihi</label>
						<input type="text" name="birthday" class="form-control mask-birthday" value="<?=$this->session->userdata('user_birthday')?>" data-inputmask="'alias': 'date', 'placeholder': 'GG/AA/YYYY'" />
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Cinsiyet</label>
						<select name="gender" class="form-control">
							<option value="">-- Lütfen Seçiniz --</option>
							<option value="F"<?if($this->session->userdata('user_gender') == 'F'):?> selected<?endif;?>>Kadın</option>
							<option value="M"<?if($this->session->userdata('user_gender') == 'M'):?> selected<?endif;?>>Erkek</option>
						</select>
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Cep Telefonu Numarası</label><br />
						<input type="text" name="intl-mobile" class="form-control" data-type="mobile-number" value="<?=$this->session->userdata('user_mobile')?>" />
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Meslek</label>
						<select name="profession" class="form-control">
							<option value="">-- Lütfen Seçiniz --</option>
							<?foreach($professions as $profession):?>
							<option value="<?=$profession->id?>"<?if($this->input->post('profession') == $profession->id || $this->session->userdata('user_profession') == $profession->id):?> selected<?endif;?>><?=$profession->title?></option>
							<?endforeach;?>
						</select>
					</div>

					<?if(is_teacher()):?>
					<div class="form-group col-12">
						<label>Profil Fotoğrafı</label>
						<input type="file" name="photo" class="filestyle" data-buttonText="Fotoğraf Seç">
						<small class="mt-2 d-block">
							<?if($this->session->userdata('user_photo_request')):?><span class="float-left">Yüklediğiniz fotoğraf onay bekliyor</span><?endif;?>
							<?if($this->session->userdata('user_photo') && !$this->session->userdata('user_photo_request')):?><span class="float-left">Onaylı fotoğraf</span> <a href="<?=base_url($this->session->userdata('user_photo'))?>" target="_blank" class="ml-2">Göster</a> <a href="<?=site_url('users/deletephoto')?>" class="ml-2">Sil</a><?endif;?>
							<span class="float-right">150x150 piksel (jpg, gif, png)</span>
						</small>
					</div>
					<?endif;?>

					<div class="form-group col-12 col-lg-6">
						<label>Bulunduğunuz Şehir</label>
						<select name="city" id="city" data-name="city" class="form-control">
							<option value="">-- Lütfen Seçiniz --</option>
							<?foreach($cities as $city):?>
							<option value="<?=$city->id?>"<?if($this->input->post('city') == $city->id || $this->session->userdata('user_city') == $city->id):?> selected<?endif;?>><?=$city->title?></option>
							<?endforeach;?>
						</select>
					</div>

					<div class="form-group col-12 col-lg-6">
						<label>Bulunduğunuz İlçe</label>
						<select name="town" id="town" data-name="town" class="form-control"></select>
					</div>

					<div class="col-12">
						<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
						<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
					</div>

				</div>
	</div>
</div>


	<?if(is_teacher()):?>
	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Firma Bilgileri</h4>
		</div>
		<div class="card-body">
			<p>Firma olarak özel ders hizmetleri sunuyorsanız lütfen firmanızın adını giriniz. Firmanızın adınızı girerseniz profilinizde adınız soyadınız yerine firmanızın adı yazacaktır. Fotoğraf yerine firmanızın logosunu (yalnızca eğitimle alakalı ise) yükleyebilirsiniz.</p>
			<div class="row">
				<div class="form-group col-12">
					<label>Firma Adı</label>
					<input type="text" name="company_name" class="form-control" value="<?=$this->session->userdata('user_company_name')?>" />
				</div>

				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>

			</div>
		</div>
	</div>
	<?endif;?>

	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>

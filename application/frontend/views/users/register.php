<div class="container">

<div class="card mt-4 box-shadow">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Özel Ders <?if(!empty($page_type)):?><?if($page_type == 1):?>İlanı Vermek<?else:?>Almak<?endif;?><?else:?>Almak veya Vermek<?endif;?> İçin Ücretsiz Üye Olun</h4>
	</div>
	<div class="card-body">
		<a href="<?=site_url('fb')?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden giriş yapın"><i class="fa fa-facebook"></i> Facebook ile üye ol</a>
		<hr />
		<p>veya aşağıdaki formu doldurarak Netders.com'a ücretsiz olarak üye olabilirsiniz.</p>

		<?if($page_type == 1):?>
			<p><a href="<?=site_url('ogrenci-olarak-kayit-olmak-istiyorum')?>">Öğrenci misiniz? Ücretsiz üye olmak için buraya tıklayınız.</a></p>
		<?endif;?>

		<?if($page_type == 2):?>
			<p><a href="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>">Eğitmen misiniz? Ücretsiz üye olmak için buraya tıklayınız.</a></p>
		<?endif;?>

		<form  action="<?=site_url('kayit')?>" method="post" class="ajax-form">
			<div class="row">

				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">Ad</label>
					<input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız" value="<?=$this->input->post('firstname')?>" />
				</div>
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">Soyad</label>
					<input type="text" name="lastname" class="form-control tofirstupper" placeholder="Soyadınız" value="<?=$this->input->post('lastname')?>" />
				</div>
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">E-posta</label>
					<input type="email" name="email" class="form-control" placeholder="E-posta adresiniz" value="<?=$this->input->post('email')?>" />
				</div>
				<div class="form-group col-12 col-lg-6">
					<label class="text-muted">Şifre</label>
					<input type="password" name="password" class="form-control" placeholder="Şifreniz" />
				</div>
				<div class="form-group col-12">
					<input type="radio" name="member_type" value="1" id="mt3" /> <label for="mt3">Öğrenciyim, özel ders alacağım</label><br />
					<input type="radio" name="member_type" value="2" id="mt4" /> <label for="mt4">Eğitmenim, özel ders vereceğim</label><br />
				</div>
				<div class="form-group col-md-2" data-name="security-code">
					<div>
						<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
					</div>
				</div>
				<div class="form-group col-md-2">
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>
				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Üye ol</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>

			</div>
			<input type="hidden" name="form" value="register" />
			<input type="hidden" name="redir" value="<?=base_url('users/choice')?>" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>


		<hr />

		<p class="text-muted">Bilgi: Eğer hesabınıza giriş yapamıyorsanız lütfen aşağıdaki bağlantıları kullanınız.</p>

		<a href="<?=site_url('sifremi-unuttum')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Şifremi unuttum</a>
		<br />
		<a href="<?=_make_link('contents', 37)?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Hesabımla ilgili destek istiyorum</a>
		<br />
		<a href="<?=site_url('giris')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Üyeyim, giriş yapmak istiyorum</a>
	</div>
</div>

<?if(!empty($latest_users)):?>
<div class="card mt-4 box-shadow  rounded-top">
	<div class="card-body">
		<h2 class="text-dark font-weight-bolder mb-4">
			Aramıza yeni katılan eğitmenler
		</h2>
		<div class="owl-4 owl-carousel owl-theme">
			<?foreach($latest_users as $user):?>
			<div class="item card border mr-2 ml-2">
				<a href="<?=site_url($user->username)?>">
					<img class="card-img-top" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>">
				</a>
				<div class="card-body">
					<h5 class="card-title"><a href="<?=site_url($user->username)?>"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></h5>
					<div class="mb-2"><img class="align-text-top" src="<?=base_url('public/img/profile-bonus.svg')?>" width="16" height="16"> <?if($user->virtual_price):?><?=$user->virtual_price?><?else:?><?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL<?endif;?></div>
					<div class="mb-2"><img class="align-text-top" src="<?=base_url('public/img/form-date.svg')?>" width="16" height="16"> <?if($user->virtual_age):?><?=$user->virtual_age?> yaşında<?else:?><?=calculate_age($user->birthday)?> yaşında<?endif;?></div>
					<div class="mb-2"><img class="align-text-top" src="<?=base_url('public/img/form-location.svg')?>" width="16" height="16"> <?=$user->city_title?>, <?=$user->town_title?></div>
					<div class="min-height-50">
						<small class="text-muted"><?if(strlen($user->levels) > 60):?><?=mb_substr($user->levels, 0, 60, 'utf-8')?>...<?else:?><?=$user->levels?><?endif;?></small>
					</div>
				</div>
			</div>
			<?endforeach;?>
		</div>
	</div>
</div>
<?endif;?>

</div>

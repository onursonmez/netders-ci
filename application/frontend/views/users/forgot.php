<div class="container">

<div class="card mt-4 box-shadow rounded-top">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Şifremi Unuttum</h4>
	</div>
	<div class="card-body">
		<p>Şifrenizi unuttuysanız Netders.com'a daha kayıt olduğunuz e-posta adresinizi veya kullanıcı adınızı aşağıdaki alana girerek "Şifremi Hatırlat" butonuna basınız. Bilgilerinizi doğru girdiyseniz e-posta adresinize şifrenizi değiştirmenize yardımcı olacak bir e-posta gönderilecektir. E-posta gelmezse <a href="<?=_make_link('contents', 37)?>">buraya tıklayarak</a> bizimle iletişime geçiniz.</p>

		<form  action="<?=site_url('sifremi-unuttum')?>" method="post" class="ajax-form">
			<div class="row">
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">Kullanıcı adı veya E-posta</label>
					<input type="text" name="login" class="form-control" placeholder="Kullanıcı adı veya e-posta">
				</div>
				<div class="form-group col-12 col-lg-3" data-name="security-code">
					<label class="text-muted">Güvenlik kodu</label>
					<div>
						<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
					</div>
				</div>
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">Güvenlik kodunu girin</label>
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>
				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Şifremi hatırlat</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>
			<input type="hidden" name="form" value="forgot" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>

		<hr />

		<a href="<?=site_url('giris')?>" class="mt-2">Şifremi hatırladım, giriş yapacağım</a>
		<br />
		<a href="<?=site_url('kayit')?>" class="mt-2">Üye değilim, ücretsiz üye olmak istiyorum</a>
		<br />
		<a href="<?=_make_link('contents', 37)?>" class="mt-2">Hesabımla ilgili destek istiyorum</a>
	</div>
</div>

</div>

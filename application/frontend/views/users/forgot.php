<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2 class="margin-bottom-20">Şifremi Unuttum</h2>
		<p>Şifrenizi unuttuysanız Netders.com'a daha kayıt olduğunuz e-posta adresinizi veya kullanıcı adınızı aşağıdaki alana girerek "Şifremi Hatırlat" butonuna basınız. Bilgilerinizi doğru girdiyseniz e-posta adresinize şifrenizi değiştirmenize yardımcı olacak bir e-posta gönderilecektir. E-posta gelmezse <a href="<?=_make_link('contents', 37)?>">buraya tıklayarak</a> bizimle iletişime geçiniz.</p>

		<form  action="<?=site_url('sifremi-unuttum')?>" method="post" class="ajax-form">
			<div class="row">						
				<div class="form-group col-lg-4">
					<input type="text" name="login" class="form-control" placeholder="Kullanıcı adı veya e-posta">
				</div>			
				<div class="form-group col-md-2">
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>
				<div class="form-group col-md-2">
					<img src="<?=base_url('captcha/'.generate_captcha('forgot'))?>" width="100%" height="32" />
				</div>																
				<div class="col-lg-4">
					<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Şifremi Hatırlat</button>
					<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="form" value="forgot" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</section>




<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2 class="margin-bottom-20">Üye Girişi</h2>
		<a href="<?=site_url('fb')?>" class="btn btn-primary white-text margin-bottom-20" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden giriş yapın"><i class="fa fa-facebook"></i> Facebook ile bağlan</a>
		<p>Netders.com hesap bilgilerinizi aşağıdaki alanlara girerek hesabınıza giriş yapabilirsiniz.</p>
		
		<form  action="<?=site_url('giris')?>" method="post" class="ajax-form">
			<div class="row">	
				<div class="form-group col-md-3">
					<input type="text" name="login" class="form-control" placeholder="Kullanıcı adı veya e-posta adresi" value="<?=$this->input->post('login')?>" />
				</div>
				<div class="form-group col-md-3">
					<input type="password" name="password" class="form-control" placeholder="Şifre" value="" />
				</div>				
				<div class="form-group col-md-2">
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>
				<div class="form-group col-md-2">
					<img src="<?=base_url('captcha/'.generate_captcha('login'))?>" width="100%" height="32" />
				</div>																	
				<div class="col-md-2">
					<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Giriş Yap</button>
					<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="form" value="login" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<input type="hidden" name="redir" value="<?php echo $this->input->get('return'); ?>" />
		</form>
		
		<p class="font-size-12 grey-text">Bilgi: Eğer hesabınıza giriş yapamıyorsanız lütfen aşağıdaki bağlantıları kullanınız.</p>
		
		<a href="<?=site_url('sifremi-unuttum')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Şifremi unuttum</a>
		<br />
		<a href="<?=_make_link('contents', 37)?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Hesabımla ilgili destek istiyorum</a>
		<br />
		<a href="<?=site_url('kayit')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Üye değilim, ücretsiz üye olmak istiyorum</a>		
	</div>
</section>




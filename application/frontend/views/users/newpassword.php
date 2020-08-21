<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2 class="margin-bottom-20">Şifrenizi Oluşturun</h2>
		<p>Lütfen aşağıdaki sayfadaki alanları doldurarak yeni şifrenizi oluşturun.</p>

		<form  action="<?=site_url('sifremi-unuttum')?>" method="post" class="ajax-form">
			<div class="row">						
				<div class="form-group col-lg-3">
					<input type="password" name="password" class="form-control" placeholder="Yeni şifre">
				</div>
				<div class="form-group col-lg-3">
					<input type="password" name="password2" class="form-control" placeholder="Yeni şifre (tekrar)">
				</div>				
				<div class="form-group col-md-2">
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>				
				<div class="form-group col-md-2">
					<img src="<?=base_url('captcha/'.generate_captcha('newpassword'))?>" width="100%" height="32" />
				</div>													
				<div class="col-lg-2">
					<button type="submit" class="btn btn-primary js-submit-btn">Kaydet</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="code" value="<?=$this->input->get('code', true)?>" />
			<input type="hidden" name="email" value="<?=$this->input->get('email', true)?>" />
			<input type="hidden" name="form" value="newpassword" />
		</form>
	</div>
</section>




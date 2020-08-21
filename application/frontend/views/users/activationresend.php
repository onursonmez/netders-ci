<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2 class="margin-bottom-20">E-posta Aktivasyon Kodunu Tekrar Gönder</h2>
		<a href="<?=site_url('fb')?>" class="btn btn-primary white-text margin-bottom-20" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden giriş yapın"><i class="fa fa-facebook"></i> Facebook ile aktivasyonsuz bağlan</a>
		<p>Hesabınızı aktif etmeniz için gönderdiğimiz e-postayı almadıysanız lütfen aşağıdaki alana kayıt olurken girdiğiniz e-posta adresini ve güvenlik kodunu girerek "Aktivasyon Kodunu Tekrar Gönder" butonuna basınız.</p>
		
		<form  action="<?=site_url('aktivasyon-tekrar')?>" method="post" class="ajax-form">
			<div class="row">	
				<div class="form-group col-lg-4">
					<input type="text" name="email" class="form-control" placeholder="Kayıt olurken girdiğiniz e-posta adresi" />
				</div>				
				<div class="form-group col-md-2">
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>
				<div class="form-group col-md-2">
					<img src="<?=base_url('captcha/'.generate_captcha('activationresend'))?>" width="100%" height="32" />
				</div>															
				<div class="col-lg-4">
					<button type="submit" class="btn btn-primary js-submit-btn">Aktivasyon Kodunu Tekrar Gönder</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="form" value="activationresend" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
		
		<p class="font-size-12 grey-text">Bilgi: Aktivasyon e-postası istenmeyen posta (spam) bölümüne düşmüş olabilir. Lütfen bu bölümleri kontrol etmeyi unutmayınız.</p>
		
		<a href="<?=site_url('aktivasyon')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Hesap aktivasyonu</a>
		<br />
		<a href="<?=site_url('aktivasyon-diger')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Aktivasyon kodunu başka bir e-posta adresine gönder</a>
	</div>
</section>




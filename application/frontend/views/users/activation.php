<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2 class="margin-bottom-20">E-posta Aktivasyonu</h2>
		<a href="<?=site_url('fb')?>" class="btn btn-primary white-text margin-bottom-20" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden giriş yapın"><i class="fa fa-facebook"></i> Facebook ile aktivasyonsuz bağlan</a>
		<p>Netders.com kayıt formunu doldurduktan sonra e-posta adresinize hesabınızı aktif etmeniz için yapmanız gerekenleri anlatan bir hesap aktivasyonu e-posta gönderilir. Lütfen aşağıdaki alana hesap aktivasyonu e-postasında gönderdiğimiz bilgileri girerek hesabınızı aktif ediniz. Aktivasyon e-postasına tıkladığınızda e-posta alanı ve aktivasyon kodu alanı otomatik olarak doldurulacaktır. Böylece yalnızca güvenlik kodunu girerek "Hesabımı Aktif Et" butonuna basmanız yeterli olacaktır.</p>
		
		<form  action="<?=site_url('aktivasyon')?>" method="post" class="ajax-form">
			<div class="row">	
				<div class="form-group col-md-3">
					<input type="text" name="email" class="form-control" placeholder="Kayıt olurken girdiğiniz e-posta adresi" value="<?if($this->input->get('email')):?><?=$this->input->get('email')?><?else:?><?=$this->input->post('email')?><?endif;?>" />
				</div>
				<div class="form-group col-md-3">
					<input type="text" name="code" class="form-control" placeholder="Aktivasyon kodunuz (e-posta ile gönderildi)" value="<?if($this->input->get('code')):?><?=$this->input->get('code')?><?else:?><?=$this->input->post('code')?><?endif;?>" />
				</div>				
				<div class="form-group col-md-2">
					<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
				</div>
				<div class="form-group col-md-2">
					<img src="<?=base_url('captcha/'.generate_captcha('activation'))?>" width="100%" height="32" />
				</div>				
				<div class="col-md-2">
					<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Hesabımı Aktif Et</button>
					<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="form" value="activation" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
		
		<p class="font-size-12 grey-text">Bilgi: Eğer kayıt formunu doldurduysanız ve aktivasyon e-postası almadıysanız e-posta adresinizi yanlış girmiş olabilirsiniz veya e-posta sunucunuza posta gönderilemiyor olabilir. Bu tür durumlarda başka bir e-posta adresine gönderim yapmamızı sağlayabilirsiniz. Bunun için "Aktivasyon kodunu başka bir e-posta adresine gönder" bağlantısına tıklayarak, kayıt formunda girdiğiniz e-posta adresinizi ve yeni e-posta adresinizi girmeniz yeterlidir.</p>
		
		<a href="<?=site_url('aktivasyon-tekrar')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Aktivasyon kodunu tekrar gönder</a>
		<br />
		<a href="<?=site_url('aktivasyon-diger')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Aktivasyon kodunu başka bir e-posta adresine gönder</a>
	</div>
</section>
<div class="container">

<div class="card mt-4 box-shadow rounded-top">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Üye Girişi</h4>
	</div>
	<div class="card-body">
		<a href="<?=site_url('fb')?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden giriş yapın"><i class="fa fa-facebook"></i> Facebook ile bağlan</a>
		<hr />
		<p>veya aşağıdan hesabınıza giriş yapabilirsiniz.</p>

		<form  action="<?=site_url('giris')?>" method="post" class="ajax-form">
			<div class="row">
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">Kullanıcı adı veya E-posta</label>
					<input type="text" name="login" class="form-control" placeholder="Kullanıcı adı veya e-posta adresi" value="<?=$this->input->post('login')?>" />
				</div>
				<div class="form-group col-12 col-lg-3">
					<label class="text-muted">Şifre</label>
					<input type="password" name="password" class="form-control" placeholder="Şifre" value="" />
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
					<button type="submit" class="btn btn-primary js-submit-btn">Giriş yap</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>
			<input type="hidden" name="form" value="login" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			<input type="hidden" name="redir" value="<?php echo $this->input->get('return'); ?>" />
		</form>

		<hr />

		<p>Hesabınıza giriş yapamıyorsanız lütfen aşağıdaki bağlantıları kullanınız:</p>

		<a href="<?=site_url('sifremi-unuttum')?>" class="mt-2">Şifremi unuttum</a>
		<br />
		<a href="<?=site_url('kayit')?>" class="mt-2">Üye değilim, ücretsiz üye olmak istiyorum</a>
		<br />
		<a href="<?=_make_link('contents', 37)?>" class="mt-2">Hesabımla ilgili destek istiyorum</a>
	</div>
</div>

</div>

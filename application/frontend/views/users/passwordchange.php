<div class="card box-shadow mb-4">
	<div class="card-header"><h4>Şifre Değiştir</h4></div>
	<div class="card-body">
		<p>Bu sayfadan şifrenizi oluşturabilir veya mevcut şifrenizi değiştirebilirsiniz.</p>
		<form action="<?=site_url('users/passwordchange')?>" method="post" class="ajax-form">
			<div class="row margin-top-20">

				<?if(!empty($user->password)):?>
				<div class="form-group col-md-3">
					<label>Mevcut Şifre</label>
					<input type="password" name="password" class="form-control" />
				</div>
				<?endif;?>

				<div class="form-group col-md-<?if(!empty($user->password)):?>3<?else:?>4<?endif;?>">
					<label>Yeni Şifre</label>
					<input type="password" name="password2" class="form-control" />
				</div>

				<div class="form-group col-md-<?if(!empty($user->password)):?>3<?else:?>4<?endif;?>">
					<label>Yeni Şifre (Tekrar)</label>
					<input type="password" name="password3" class="form-control" />
				</div>

				<div class="col-md-<?if(!empty($user->password)):?>3<?else:?>4<?endif;?>">
					<label>&nbsp;</label>
					<button type="submit" class="btn btn-primary js-submit-btn">Şifremi Değiştir</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>

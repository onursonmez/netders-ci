<div class="panel panel-default margin-bottom-20">
	<div class="panel-heading"><h4>Şifre Değiştir</h4></div>
	<div class="panel-body">
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
					<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Şifremi Değiştir</button>
					<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>					
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>
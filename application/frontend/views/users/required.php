<div class="card box-shadow mb-4">
	<div class="card-header"><h4>Eksik Profil Alanları</h4></div>
	<div class="card-body">
		<form  action="<?=site_url('users/education')?>" method="post" class="ajax-form js-dont-reset">
			<div class="row">	

				<div class="col-md-12">
					<p>Profilinizin arama sonuçlarında görünebilmesi için aşağıdaki alanların doldurulması gerekmektedir. Lütfen doldurmak istediğiniz alanın üzerine tıklayınız.</p>
					<?if(!empty($required)):?>
					<?foreach($required as $key => $value):?>
					<a href="<?=$value[0]?>" class="block"><?=$key+1?>. <?=$value[1]?></a>
					<?endforeach;?>
					<?endif;?>
				</div>				
											
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>
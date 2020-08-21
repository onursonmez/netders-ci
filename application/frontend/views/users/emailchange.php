<h2 class="margin-bottom-20">E-posta Adresi Değişikliği</h2>
<p>Bu sayfadan değiştirmek istediğiniz e-posta adresine tekrar onay kodu gönderebilir veya e-posta değiştirme işlemini iptal edebilirsiniz.<?if(is_teacher()):?> E-posta adresi değişikliği tamamlanmayan üyelerin profilleri arama sonuçlarında görünmez.<?endif;?></p>

<form action="<?=site_url('users/emailchange')?>" method="post" class="ajax-form">
	<div class="row margin-top-20">						
		
		<?if(!empty($verified_emails)):?>
		<div class="form-group col-md-3">
			<label>Mevcut E-posta Adresim</label>
			<input type="email" name="email" class="form-control" value="<?=$this->session->userdata('user_email')?>" disabled="disabled" />
		</div>
		<?endif;?>
		
		<div class="form-group col-md-<?if(!empty($verified_emails)):?>3<?else:?>4<?endif;?>">
			<label>Yeni E-posta Adresim</label>
			<input type="email" name="email2" class="form-control" value="<?=$this->session->userdata('user_email_request')?>" />
		</div>
		
		<div class="form-group col-md-<?if(!empty($verified_emails)):?>3<?else:?>4<?endif;?>">
			<label>Yapmak İstediğim İşlem</label>
			<select name="operation" class="form-control">
				<option value="">-- Lütfen Seçiniz --</option>
				<option value="1"<?if($this->input->post('operation') == 1):?> selected<?endif;?>>Yeni e-posta adresime onay kodunu tekrar gönder</option>
				<?if(!empty($verified_emails)):?>
				<option value="2"<?if($this->input->post('operation') == 2):?> selected<?endif;?>>E-posta değiştirme işlemimi iptal et</option>
				<?endif;?>
			</select>
		</div>		
															
		<div class="col-md-<?if(!empty($verified_emails)):?>3<?else:?>4<?endif;?>">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-primary js-submit-btn">İşlemi Gerçekleştir</button>
			<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
		</div>
		
		<div class="col-md-12">
		<p class="font-size-12 grey-text">Bilgi: Eğer e-posta adresinize aktivasyon e-postası gelmiyorsa lütfen aşağıdaki işlemleri deneyiniz:</p>
		<a href="<?=_make_link('contents', 37)?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> E-posta aktivasyonu ile ilgili destek istiyorum</a>			
		</div>						
	</div>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>



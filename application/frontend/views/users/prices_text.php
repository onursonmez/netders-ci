<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3"><?=$price->level_title?> (<?=$price->subject_title?>) Dersi İçin Tanıtım Yazısı</h4>
	</div>
	<div class="card-body">
		<form  action="<?=current_url()?>" method="post" class="ajax-form js-dont-reset">
			<div class="row">

				<div class="form-group col-12">
					<h3 class="mb-2">Başlık</h3>
					<p><?=$price->level_title?> dersi için özel olarak oluşturulacak sayfanın başlığını yazınız.<br /><span class="grey-text font-size-12">Örn. Uzman Eğitmenden <?=$price->level_title?> Dersi, Boğaziçi Öğrencisinden <?=$price->level_title?> Dersi, <?=$price->level_title?> Öğrenmek Çok Kolay vb.</span></p>
					<input name="title" data-type="count" data-length="100" class="form-control" value="<?=$price->title?>" maxlength="100" placeholder="Örneğin; Uzman Eğitmenden <?=$price->level_title?> Dersi, Boğaziçi Öğrencisinden <?=$price->level_title?> Dersi, <?=$price->level_title?> Öğrenmek Çok Kolay vb." />
					<small id="text_title_count">100 karakter kaldı</small>
				</div>

				<div class="form-group col-12">
					<h3 class="mb-2">Açıklama</h3>
					<p><?=$price->level_title?> dersini nasıl işlediğinizi, öğrencilere özel uygulayacağınız teknikleri, bu dersle ilgili deneyiminizi, bu dersle ilgili diğer eğitmenlerden farklarınızı, bu dersi ne kadar süredir verdiğinizi ve mesleğinizi içinde bulunduran bir tanıtım yazısı yazınız.</p>
					<textarea name="description" data-type="count" data-length="500" class="form-control" rows="4" maxlength="500" placeholder="Örneğin; XX okulunda YY öğretmeniyim. XX yıldır <?=$price->level_title?> konusunda özel ders veriyorum. <?=$price->level_title?> dersinin iyi öğrenilebilmesi için öğrenciye özel tekniklerin kullanılması gerektiğine inanıyorum. <?=$price->level_title?> özel dersi verdiğim öğrencilerime uyguladığım görsel ve işitsel tekniklerle ömür boyu kalıcı olacak bir öğrenme modeli geliştirdim. <?=$price->level_title?> öğrenmek isteyen öğrencilerime ilk ders ücretsiz olarak özel ders veriyorum. Benimle birlikte <?=$price->level_title?> öğrenmenin aslında ne kadar kolay olduğunun farkına varacaksınız."><?=$price->description?></textarea>
					<small id="text_description_count">500 karakter kaldı</small>
				</div>

				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>

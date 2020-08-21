<form  action="<?=site_url('users/informations')?>" method="post" class="ajax-form js-dont-reset">
	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Tanıtım Yazıları</h4>
		</div>
		<div class="card-body">

			<div class="row">

				<div class="form-group col-12">
					<h3 class="margin-bottom-5">Başlık</h3>
					<p>Arama sonuçlarında ve profil detay sayfanızda ön planda olan, kendiniz veya eğitiminizle alakalı tek cümleden oluşan yazı/slogan.</p>
					<input name="text_title" data-type="count" data-length="45" class="form-control" value="<?=$this->session->userdata('user_text_title')?>" maxlength="45" placeholder="Örnekler; Matematik mühendisinden özel ders, Boğaziçiliden özel ders, Araç kullanmak kabus değil vb." />
					<small id="text_title_count">45 karakter kaldı</small>
				</div>
				<!--
				<div class="form-group col-12">
					<h3 class="margin-bottom-5">Karşılama Metni</h3>
					<p>Karşılama yazısı, öğrencilerin arama sonuçlarında sizinle ilgili gördüğü ilk kısa bilgidir. Aslında bu alanı <u>detaylı tanıtım metni</u> ile <u>ders yaklaşımı ve tecrübesi</u> alanlarının bir özeti olarak düşünebilirsiniz.</p>
					<textarea name="text_short" data-type="count" data-length="500" class="form-control" rows="4" maxlength="500" placeholder="Örneğin; Alanında 15 yıllık tecrübeye sahip olmuş uzman direksiyon eğitmeninden, yalnızca bir hafta içerisinde İstanbul trafiğinde araç kullanma garantisi ile özel direksiyon dersi. Hemen arayın, size özel indirim fırsatlarını kaçırmayın."><?=$this->session->userdata('user_text_short')?></textarea>
					<span class="lightgrey-text font-size-11" id="text_short_count">500 karakter kaldı</span>
				</div>
				-->
				<div class="form-group col-12">
					<h3 class="margin-bottom-5">Detaylı Tanıtım Metni</h3>
					<p>Kendinizden ve eğitiminizden detaylı olarak bahsedeceğiniz alandır. Lütfen bu alana kendinizle alakalı tüm bilgileri girmeyi unutmayınız. Ayrıntıya dikkat eden öğrenciler için bu alanı maksimum seviyede doldurmak çok önemlidir.</p>
					<textarea name="text_long" data-type="count" data-length="1000" class="form-control" rows="4" maxlength="1000" placeholder="Bu alana; aldığınız eğitim ile ilgili ayrıntılar, dereceleriniz, sertifikalarınız, katıldığınız kurs ve seminerler, iş hayatınız, sosyal hayatınız gibi bilgileri harmanlayarak sizinle ilgili detaylı bir tanıtım metni çıkartabilirsiniz. Lütfen fazla bilgi vermekten çekinmeyin. Kendinizle ilgili ne kadar fazla bilgi verirseniz öğrenciler o kadar çok güven duyarlar."><?=$this->session->userdata('user_text_long')?></textarea>
					<small id="text_long_count">1000 karakter kaldı</small>
				</div>
				<!--
				<div class="form-group col-12">
					<h3 class="margin-bottom-5">Ders Yaklaşımı ve Tecrübesi</h3>
					<p>Bu alana, sizin derslerinizin diğer derslerden farkını, uyguladığınız özel teknikleri, ne kadar süredir kaç kişiye ders verdiğinizi ve başarı oranlarınızı içeren, öğrencilerin sizi seçmesini sağlayacak herşeyi yazınız.</p>
					<textarea name="text_lesson" data-type="count" data-length="1000" class="form-control" rows="4" maxlength="1000" placeholder="Örneğin; Kişiye öze uyguladığım tekniklerle öğrencilerin 1 yılda öğrendiği konuları 2 ayda öğretiyorum. Uyguladığım görsel, işitsel ve eğlenceli eğitim modeli ile ilköğretimden üniversiteye tüm öğrencilerime başarıyla sonuçlanan özel dersler verdim. Uyguladığım eğitim tekniği ile 5 yıldır yaklaşık 1000 öğrenciden %100 başarı oranına sahibim. İstenildiği taktide özel ders verdiğim öğrencilerimle sizi görüştürebilirim."><?=$this->session->userdata('user_text_lesson')?></textarea>
					<span class="lightgrey-text font-size-11" id="text_lesson_count">1000 karakter kaldı</span>
				</div>
				-->
				<div class="form-group col-12">
					<h3 class="margin-bottom-5">Referanslar</h3>
					<p>Daha önce çalıştığınız kamu kurumları veya özel sektörler, bireysel veya grup olarak ders verdiğiniz kitleler gibi size referans olacak kişi ve kurumu her biri tek satır olacak şekilde yazınız.</p>
					<textarea name="text_reference" data-type="count" data-length="1000" class="form-control" rows="4" maxlength="1000"><?=$this->session->userdata('user_text_reference')?></textarea>
					<small id="text_reference_count">1000 karakter kaldı</small>
				</div>

				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>

	</div>
</div>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>

<!-- Modal Expert Terms -->
<div class="modal fade" id="rules-txt" tabindex="-1" role="dialog" aria-labelledby="rulesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="rulesLabel">Tanıtım Yazısı Ekleme Kuralları</h4>
      </div>
      <div class="modal-body">
        <?
        	$content = content(42);
        	echo $content->description;
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Anlaşıldı!</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?
	$places 	= $user->places 	? explode(',', $user->places) 	: '';
	$times 		= $user->times 		? explode(',', $user->times) 		: '';
	$services = $user->services ? explode(',', $user->services) : '';
	$genders 	= $user->genders 	? explode(',', $user->genders) 	: '';
	$discount = get_user_discount($user);
?>

<div class="container">

<?if($user->status == 'C'):?>
<div class="card box-shadow rounded-top">
  <div class="card-body text-center" style="padding:50px 0;">
			Üzgünüz, bu hesap artık kullanılmamaktadır.
	</div>
</div>
<?else:?>

<?if($this->session->userdata('last_search')):?>
<div class="text-right">
	<a class="btn btn-primary btn-sm mr-2 d-inline-block mb-3" href="<?=$this->session->userdata('last_search')?>"><img class="align-middle" src="<?=base_url('public/img/navigation-arrow-left-white.svg')?>" width="12" height="12" /> Arama sonuçlarına geri dön</a>
</div>
<?endif;?>

<div class="card mt-4 mb-2 box-shadow">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-2 text-center">
        <img class="profile-image mb-3" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?>">

				<?if($user->service_badge == 'Y'):?><img class="align-middle mr-1" src="<?=base_url('public/img/claim-beneficiary.svg')?>" width="16" height="16" data-toggle="tooltip" data-placement="top" title="Bu eğitmenin alanında uzman olduğu belgelerle doğrulanmıştır"><?endif;?>
				<?if(!$user->email_request):?><img class="align-middle mr-1" src="<?=base_url('public/img/form-email.svg')?>" width="16" height="16" data-toggle="tooltip" data-placement="top" title="Eğitmenin e-posta adresi doğrulanmıştır"><?endif;?>
				<img class="align-middle mr-1" src="<?=base_url('public/img/navigation-finance-withdrawal.svg')?>" width="16" height="16" data-toggle="tooltip" data-placement="top" title="<?=nicetime($user->joined)?> üye oldu">

				<?if($user->online):?>
					<img class="align-middle mr-1" src="<?=base_url('public/img/profile-icon.svg')?>" width="16" height="16" data-toggle="tooltip" data-placement="top" title="Çevrimiçi">
				<?else:?>
					<img class="align-middle mr-1" src="<?=base_url('public/img/profile-icon-gray.svg')?>" width="16" height="16" data-toggle="tooltip" data-placement="top" title="Çevrimdışı">
				<?endif;?>

      </div>
      <div class="col-lg-10">
        <div class="row">
          <div class="col-lg-9">
            <h1 class="mt-0"><a href=""><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></a></h1>
            <div class="mb-2 font-weight-bolder"><?=nl2br($user->text_title)?></div>
            <div class="row mb-2 text-muted">
							<?if($user->price_min || $user->price_max):?>
								<div class="col-lg-4"><img class="align-text-top" src="<?=base_url('public/img/profile-bonus-gray.svg')?>" width="16" height="16"> <?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> <span>TL/Saat</span></div>
							<?endif;?>
              <div class="col-lg-4"><img class="align-text-top" src="<?=base_url('public/img/form-location-gray.svg')?>" width="16" height="16"> <?=calculate_age($user->birthday)?> yaşında</div>
							<?if(!empty($user->city_title)):?>
              <div class="col-lg-4"><img class="align-text-top" src="<?=base_url('public/img/form-date-gray.svg')?>" width="16" height="16"> <?=$user->city_title?><?if(!empty($user->town_title)):?> / <?=$user->town_title?><?endif;?></div>
							<?endif;?>
            </div>
            <div class="mb-4 mb-lg-0"><?=nl2br($user->text_long)?></div>
          </div>
          <div class="col-lg-3">

						<div class="mb-3">
						<?/*hesabi aktif degilse*/?>
						<?if($user->status != 'A' || $user->privacy_phone == 3):?>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Eğitmen telefon numarasını göstermek istemiyor"><img class="align-middle" src="<?=base_url('public/img/form-tel.svg')?>" width="13" height="13" /> <span><?=substr_replace($user->mobile, 'XX XX', -4)?></span></a> <small class="text-muted d-block">Tıkla ve gör</small>
						<?else:?>
							<?/*görüntüleyen üye değilse*/?>
							<?if(!$this->session->userdata('user_id')):?>
								<?if(($user->privacy_phone == 1 && ($user->ugroup == 3 || $user->ugroup == 4 || $user->ugroup == 5)) || check_viewphones_ips($user->id)):?>
								<a href="#" class="ajaxmobile" onclick="getmobile('<?=$user->activation_code?>-<?=md5(md5(date('d.m.Y', time())))?>')"><img class="align-middle" src="<?=base_url('public/img/form-tel.svg')?>" width="13" height="13" /> <span><?=substr_replace($user->mobile, 'XX XX', -4)?></span></a> <small class="text-muted d-block">Tıkla ve gör</small>
								<?else:?>
								<a href="<a href="<?=site_url('giris')?>" data-toggle="tooltip" data-placement="top" title="Telefon numarasını görüntüleyebilmek için üye girişi yapmanız gerekmektedir. Üye iseniz giriş yapmak için tıklayınız."><img class="align-middle" src="<?=base_url('public/img/form-tel.svg')?>" width="13" height="13" /> <span><?=substr_replace($user->mobile, 'XX XX', -4)?></span></a> <small class="text-muted d-block">Tıkla ve gör</small>
								<?endif;?>
							<?else:?>
								<?/*görüntüleyen basic, silver, gold üye ise*/?>
								<?if($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
									<a href="#" data-toggle="tooltip" data-placement="top" title="Yalnızca üye öğrenciler telefon numarasını görebilir!"><img class="align-middle" src="<?=base_url('public/img/form-tel.svg')?>" width="13" height="13" /> <span><?=substr_replace($user->mobile, 'XX XX', -4)?></span></a> <small class="text-muted d-block">Tıkla ve gör</small>
								<?/*görüntüleyen öğrenci veya admin ise*/?>
								<?else:?>
									<?/*eğitmen silver veya gold ise, telefon herkese ve üye öğrencilere görünsün ise*/?>
									<?if(($user->ugroup == 3 || $user->ugroup == 4 || $user->ugroup == 5) && ($user->privacy_phone == 1 || $user->privacy_phone == 2)):?>
										<a href="#" onclick="getmobile('<?=$user->activation_code?>-<?=md5(md5(date('d.m.Y', time())))?>')" class="ajaxmobile"><img class="align-middle" src="<?=base_url('public/img/form-tel.svg')?>" width="13" height="13" /> <span><?=substr_replace($user->mobile, 'XX XX', -4)?></span></a> <small class="text-muted d-block">Tıkla ve gör</small>
									<?/*değilse*/?>
									<?else:?>
										<span ><a href="#"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>
										<a href="#" data-toggle="tooltip" data-placement="top" title="Eğitmen telefon numarasını göstermek istemiyor. Lütfen mesaj yolu iletişime geçiniz."><img class="align-middle" src="<?=base_url('public/img/form-tel.svg')?>" width="13" height="13" /> <span><?=substr_replace($user->mobile, 'XX XX', -4)?></span></a> <small class="text-muted d-block">Tıkla ve gör</small>
									<?endif;?>
								<?endif;?>
							<?endif;?>
						<?endif;?>
						</div>

            <div class="mb-3"><a href="#" class="scrollto" data-attr-scroll="newmessage" data-scroll-offset="100"><img class="align-middle" src="<?=base_url('public/img/navigation-message.svg')?>" width="13" height="13" /> Mesaj gönder</a> <small class="text-muted d-block">Yazışma başlat</small></div>
            <div class="mb-3">
							<?/*görüntüleyen üye değilse*/?>
							<?if(!$this->session->userdata('user_id')):?>
								<a href="<?=site_url('giris')?>" data-toggle="tooltip" data-placement="top" title="Yorum yapabilmek için üye girişi yapmanız gerekmektedir. Üye iseniz giriş yapmak için tıklayınız."><img class="align-middle" src="<?=base_url('public/img/messaging-terms.svg')?>" width="13" height="13" /> Yorum yap</a> <small class="text-muted d-block">Aldığın dersi değerlendir</small>
							<?else:?>
								<?/*görüntüleyen basic, silver, gold üye ise*/?>
								<?if($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
									<a href="#" data-toggle="tooltip" data-placement="top" title="Yalnızca üye öğrenciler yorum yapabilir!"><img class="align-middle" src="<?=base_url('public/img/messaging-terms.svg')?>" width="13" height="13" /> Yorum yap</a> <small class="text-muted d-block">Aldığın dersi değerlendir</small>
								<?/*görüntüleyen öğrenci veya admin ise*/?>
								<?else:?>
									<a href="#" class="scrollto" data-attr-scroll="newcomment" data-scroll-offset="100"><img class="align-middle" src="<?=base_url('public/img/messaging-terms.svg')?>" width="13" height="13" /> Yorum yap</a> <small class="text-muted d-block">Aldığın dersi değerlendir</small>
								<?endif;?>
							<?endif;?>
						</div>
            <div><a href="#" class="scrollto" data-attr-scroll="newcomplaint" data-scroll-offset="100"><img class="align-middle" src="<?=base_url('public/img/messaging-no-user.svg')?>" width="13" height="13" /> Şikayet et</a> <small class="text-muted d-block">İhlal bildir</small></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card mt-4 mb-2 box-shadow">
  <div class="card-body">
    <div class="row">
			<div class="col-lg-3">
				<img class="align-middle" src="<?if(empty($discount['freefirst'])):?><?=base_url('public/img/navigation-close-small.svg')?><?else:?><?=base_url('public/img/messaging-checked-small.svg')?><?endif;?>" width="14" height="14"> Ücretsiz İlk Ders
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['registered'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['registered']?></span><?endif;?> Üye Öğrenci İndirimi
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['teacher'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['teacher']?></span><?endif;?> Eğitmen Evi İndirimi
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['group'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['group']?></span><?endif;?> Grup İndirimi
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['program'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['program']?></span><?endif;?> Paket Program İndirimi
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['live'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['live']?></span><?endif;?> Canlı Ders İndirimi
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['disabled'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['disabled']?></span><?endif;?> Engelli İndirimi
			</div>

			<div class="col-lg-3">
				<?if(empty($discount['review'])):?><img class="align-middle" src="<?=base_url('public/img/navigation-close-small.svg')?>" width="14" height="14"><?else:?><span class="badge badge-secondary">%<?=$discount['review']?></span><?endif;?> Öneri İndirimi
			</div>

			</div>
		</div>
	</div>

<?if(!empty($prices)):?>
	<div class="card mt-4 box-shadow">
    <div class="card-header">
      <h4 class="mb-0 pt-3 pb-3">Ders Ücretleri</h4>
    </div>
    <div class="card-body">
      <table class="table table-xs">
        <thead>
          <tr>
            <th scope="col">Ders Adı</th>
            <th scope="col">Özel Ders</th>
            <th scope="col">Canlı Ders</th>
          </tr>
        </thead>
        <tbody>
					<?foreach($prices as $price):?>
          <tr>
            <td>
							<?if($price->status == 'A'):?>
								<a href="<?=site_url('ders-detay/' . $price->seo_link)?>" target="_blank"><?=$price->subject_title?> - <?=$price->level_title?></a>
							<?else:?>
								<?=$price->subject_title?> - <?=$price->level_title?>
							<?endif;?>
						</td>
						<td><?if(empty($price->price_private)):?>Vermiyorum<?else:?><?=$price->price_private?> TL<?endif;?></td>
						<td><?if(empty($price->price_live)):?>Vermiyorum<?else:?><?=$price->price_live?> TL<?endif;?></td>
          </tr>
					<?endforeach;?>
        </tbody>
      </table>
    </div>
  </div>
	<?endif;?>

	<?if(!empty($places) || !empty($times) || !empty($services) || !empty($genders)):?>
	<div class="card mt-4 box-shadow">
	  <div class="card-header">
	    <h4 class="mb-0 pt-3 pb-3">Özel Ders Eğitim Tercihleri</h4>
	  </div>
	  <div class="card-body">
	    <div class="row">
	      <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
	        <strong>Mekan</strong>
	        <ul class="list-group list-group-flush">
						<?if(!empty($places)):?>
						<?foreach(education_types(1) as $key => $value):?>
						<?if(!empty($places) && in_array($key, $places)):?>
	          <li class="list-group-item"><img class="align-middle mr-1" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?else:?>
						<li class="list-group-item text-muted"><img class="align-middle mr-1" src="<?=base_url('public/img/navigation-close-small-gray.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?endif;?>
						<?endforeach;?>
						<?else:?>
						<li class="list-group-item">Belirtilmemiş</li>
						<?endif;?>
	        </ul>

	      </div>
	      <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
	        <strong>Zaman</strong>
					<ul class="list-group list-group-flush">
						<?if(!empty($times)):?>
						<?foreach(education_types(2) as $key => $value):?>
						<?if(!empty($places) && in_array($key, $places)):?>
						<li class="list-group-item"><img class="align-middle mr-1" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?else:?>
						<li class="list-group-item text-muted"><img class="align-middle mr-1" src="<?=base_url('public/img/navigation-close-small-gray.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?endif;?>
						<?endforeach;?>
						<?else:?>
						<li class="list-group-item">Belirtilmemiş</li>
						<?endif;?>
					</ul>
	      </div>
	      <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
	        <strong>Hizmet</strong>
					<ul class="list-group list-group-flush">
						<?if(!empty($services)):?>
						<?foreach(education_types(3) as $key => $value):?>
						<?if(!empty($places) && in_array($key, $places)):?>
						<li class="list-group-item"><img class="align-middle mr-1" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?else:?>
						<li class="list-group-item text-muted"><img class="align-middle mr-1" src="<?=base_url('public/img/navigation-close-small-gray.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?endif;?>
						<?endforeach;?>
						<?else:?>
						<li class="list-group-item">Belirtilmemiş</li>
						<?endif;?>
					</ul>
	      </div>
	      <div class="col-6 col-xs-12 col-sm-12 col-lg-3 mb-4 mb-lg-0">
	        <strong>Cinsiyet</strong>
					<ul class="list-group list-group-flush">
						<?if(!empty($genders)):?>
						<?foreach(education_types(4) as $key => $value):?>
						<?if(!empty($places) && in_array($key, $places)):?>
						<li class="list-group-item"><img class="align-middle mr-1" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?else:?>
						<li class="list-group-item text-muted"><img class="align-middle mr-1" src="<?=base_url('public/img/navigation-close-small-gray.svg')?>" width="13" height="13" /> <?=$value?></li>
						<?endif;?>
						<?endforeach;?>
						<?else:?>
						<li class="list-group-item">Belirtilmemiş</li>
						<?endif;?>
					</ul>
	      </div>
	    </div>
	  </div>
	</div>
	<?endif;?>

	<div class="card mt-4 box-shadow">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Özel Ders Verilen Bölgeler</h4>
		</div>
		<div class="card-body">
			<?if(empty($locations)):?>
				Özel ders verilen lokasyon bilgisi bulunmamaktadır.
			<?else:?>
			<table class="table">
				<thead>
					<th>İl</th>
					<th>İlçe</th>
				</thead>
				<tbody>
					<?foreach($locations as $city => $towns):?>
					<tr>
						<td width="100" nowrap=""><strong><?=location_name('cities', $city)?></strong></td>
						<td>
							<?if(!empty($towns)):?>
								<?$town_titles = array()?>
								<?foreach($towns as $town):?>
									<?if(!empty($town->town)):?>
										<?$town_titles[] = location_name('towns', $town->town)?>
									<?endif;?>
								<?endforeach;?>
								<?if(!empty($town_titles)):?><?=@implode(', ', $town_titles)?><br /><?endif;?>
							<?endif;?>
						</td>
					</tr>
					<?endforeach;?>
				</tbody>
			</table>
			<?endif;?>
		</div>
	</div>

	<?if(!empty($user->text_reference)):?>
	<div class="card mt-4 box-shadow">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Referanslar</h4>
		</div>
		<div class="card-body">
			<?=nl2br($user->text_reference)?>
		</div>
	</div>
	<?endif;?>

	<?if(!empty($user->discount11_text) || !empty($user->discount12_text) || !empty($user->discount13_text)):?>
	<div class="card mt-4 box-shadow">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">İndirim Şartları</h4>
		</div>
		<div class="card-body">
			<?if(!empty($user->discount11_text)):?>
				<strong>Paket Program İndirimi Şartları</strong><br />
				<p><?=$user->discount11_text?></p>
			<?endif;?>

			<?if(!empty($user->discount12_text)):?>
				<strong>Engelli İndirimi Şartları</strong><br />
				<p><?=$user->discount12_text?></p>
			<?endif;?>

			<?if(!empty($user->discount13_text)):?>
				<strong>Öneri İndirimi Şartları</strong><br />
				<p><?=$user->discount13_text?></p>
			<?endif;?>
		</div>
	</div>
	<?endif;?>

	<?if(!empty($comments)):?>
	<div class="card mt-4 box-shadow">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Yorumlar</h4>
		</div>
		<div class="card-body">
			<?foreach($comments as $key => $comment):?>
			<?if($key > 0):?><hr /><?endif;?>
			<p class="text-muted"><img class="align-top mt-1" src="<?=base_url('public/img/profile-icon-gray.svg')?>" width="14" height="14"> <?=user_info('username', $comment->from_uid)?> <img class="ml-3 align-top mt-1" src="<?=base_url('public/img/form-date-gray.svg')?>" width="14" height="14"> <?=date('d.m.Y', $comment->date)?></p>
			<p><?if($comment->star):?><?for($i=0;$i<$comment->star;$i++):?><img class="align-middle mr-1" src="<?=base_url('public/img/expression-star.svg')?>" width="13" height="13" /><?endfor;?><?endif;?></p>
			<p><?=nl2br($comment->comment)?></p>
			<?endforeach;?>
		</div>
	</div>
	<?endif;?>

	<?if($this->session->userdata('user_id')):?>
	<div class="card mt-4 box-shadow" id="newcomment">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Yorum Yap</h4>
		</div>
		<div class="card-body">
			<p>Eğitmenden aldığınız dersi aşağıdaki alanları doldurarak değerlendirebilirsiniz.</p>
			<form method="POST" action="<?=site_url('users/sendcomment')?>" class="ajax-form">
					<div class="row">
						<div class="col-lg-12 mb-2">
								<select name="point" class="form-control mb-2">
									<option value="">-- Verdiğiniz Puan --</option>
									<option value="1">1 (Berbat)</option>
									<option value="2">2 (Kötü)</option>
									<option value="3">3 (Normal)</option>
									<option value="4">4 (İyi)</option>
									<option value="5">5 (Kusursuz)</option>
								</select>
						</div>

						<div class="col-lg-12 mb-2">
								<textarea name="comment" rows="5" placeholder="Lütfen yorumunuzu bu alana yazınız" class="form-control mb-2"></textarea>
						</div>

						<div class="col-md-2" data-name="security-code">
							<div>
								<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
							</div>						</div>
						<div class="col-md-2 mb-2">
							<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
						</div>

						<div class="col-lg-12">
							<button type="submit" class="btn btn-primary js-submit-btn">Yorum yap</button>
							<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>

					</div>
			<input type="hidden" name="user_id" value="<?=$user->id?>" />
			<input type="hidden" name="form" value="ajax_comment" />
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
		</div>
	</div>
	<?endif;?>

	<div class="card mt-4 box-shadow" id="newmessage">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Mesaj Gönder</h4>
		</div>
		<div class="card-body">
			<p>Aşağıdaki formu kullanarak eğitmene özel mesaj gönderebilirsiniz.<?if(!$this->session->userdata('user_id')):?> Mesajınızı gönderdiğinizde eğitmen girdiğiniz cep telefonundan sizi arayacaktır. Size yeni bir cevap mesaj gönderildiğinde e-posta ile bilgilendirileceksiniz. Bu nedenle e-posta adresinizi ve cep telefonu numaranızı doğru girmeniz gerekmektedir.<?endif;?></p>
			<form method="POST" action="<?=site_url('users/sendmessage')?>" class="ajax-form">
				<div class="row">
					<?if(!$this->session->userdata('user_id')):?>
					<div class="col-md-3 mb-2">
						<label>Adınız</label>
						<input type="text" name="firstname" class="form-control" value="<?=$this->input->cookie('unknown_msg_firstname')?>" />
					</div>

					<div class="col-md-3 mb-2">
						<label>Soyadınız</label>
						<input type="text" name="lastname" class="form-control" value="<?=$this->input->cookie('unknown_msg_lastname')?>" />
					</div>
					<div class="col-md-3 mb-2">
						<label>E-posta Adresiniz</label>
						<input type="email" name="email" class="form-control" value="<?=$this->input->cookie('unknown_msg_email')?>" />
					</div>
					<div class="col-md-3 mb-2">
						<label>Cep Telefonu Numaranız</label>
						<input type="text" name="intl-mobile" data-type="mobile-number" class="form-control" value="<?=$this->input->cookie('unknown_msg_mobile')?>" />
					</div>
					<?endif;?>
					<div class="col-md-12 mb-2">
						<label>Mesajınız</label>
						<textarea name="message" rows="5" class="form-control" placeholder="Lütfen mesajınızı bu alana yazınız"></textarea>
					</div>
					<div class="col-md-2" data-name="security-code">
						<div>
							<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
						</div>
					</div>
					<div class="col-md-2 mb-2">
						<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary js-submit-btn">Mesaj gönder</button>
						<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
					</div>
				</div>
				<input type="hidden" name="user_id" value="<?=$user->id?>" />
				<input type="hidden" name="form" value="ajax_message" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
		</div>
	</div>

	<div class="card mt-4 box-shadow rounded-top" id="newcomplaint">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Şikayet Et</h4>
		</div>
		<div class="card-body">
			<p>Eğitmeni şikayet etmek için aşağıdaki formu doldurmanız yeterlidir. Şikayetiniz değerlendirildikten sonra e-posta adresinize bilgi verilecektir.</p>
			<form method="POST" action="<?=site_url('users/sendcomplaint')?>" class="ajax-form">
				<div class="row">
					<?if(!$this->session->userdata('user_id')):?>
					<div class="col-md-4 mb-2">
						<label>Adınız</label>
						<input type="text" name="firstname" class="form-control" value="<?=$this->input->cookie('unknown_msg_firstname')?>" />
					</div>

					<div class="col-md-4 mb-2">
						<label>Soyadınız</label>
						<input type="text" name="lastname" class="form-control" value="<?=$this->input->cookie('unknown_msg_lastname')?>" />
					</div>
					<div class="col-md-4 mb-2">
						<label>E-posta Adresiniz</label>
						<input type="email" name="email" class="form-control" value="<?=$this->input->cookie('unknown_msg_email')?>" />
					</div>
					<?endif;?>
					<div class="col-md-12 mb-2">
						<label>Şikayetiniz</label>
						<textarea name="message" rows="5" class="form-control" placeholder="Lütfen şikayetinizi bu alana yazınız"></textarea>
					</div>
					<div class="col-md-2" data-name="security-code">
						<div>
							<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
						</div>
					</div>
					<div class="col-md-2 mb-2">
						<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-primary js-submit-btn">Şikayet et</button>
						<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
					</div>
				</div>
				<input type="hidden" name="user_id" value="<?=$user->id?>" />
				<input type="hidden" name="form" value="ajax_complaint" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
		</div>
	</div>

</div><!--/.container-->

<?endif;?>

</div>

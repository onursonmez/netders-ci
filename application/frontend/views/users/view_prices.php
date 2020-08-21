<div class="container">
	<div class="card mt-4 box-shadow rounded-top">
		<div class="card-header">
			<h1><?=$price->title?></h1>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-lg-8">
					<p><?=$price->description?></p>
					<hr />
					<p><strong>Kategori:</strong> <?=$price->subject_title?></p>
					<p><strong>Özel Ders Ücreti:</strong> <?=$price->price_private?> TL</p>
					<p><strong>Canlı Ders Ücreti:</strong> <?if(empty($price->price_live)):?>Verilmiyor<?else:?><?=$price->price_live?> TL<?endif;?></p>
					<p><?=$price->level_title?> özel dersi veren eğitmenin profiline gitmek için <a href="<?=site_url($user->username)?>">buraya</a> tıklayınız. <?=$price->level_title?> özel dersi veren eğitmenleri görüntülemek için <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/?subject=<?=$price->subject_id?>&level=<?=$price->level_id?>">buraya</a> tıklayınız.</p>
				</div>
				<div class="col-12 col-lg-4 text-center">
					<div><img class="mb-2" src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" /></div>

					<div><strong><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></strong></div>

					<div class="mb-2">
						<?if($user->online):?>
							<span><i class="fa fa-power-off"></i> Çevrimiçi</span>
						<?else:?>
							<span class="text-muted">Çevrimdışı</span>
						<?endif;?>
					</div>

					<a class="btn btn-primary" href="<?=site_url($user->username)?>">Profili Görüntüle</a>

				</div>
			</div>
		</div>
	</div>
</div>

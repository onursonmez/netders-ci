<section class="profile">
	<div class="profile-cover">
		<div class="profile-cover-image" style="background:url(<?=base_url('public/img/cover.jpg')?>); background-attachment: fixed;"></div>
	</div>
	<div class="container">
		<div class="profile-top-wrapper">
			<div class="row">
			
				<div class="col-sm-12 col-md-8 col-lg-9 no-float profile-top-center">
					<h1><?=$price->title?></h1>
					<p><?=$price->description?></p>
					<hr />
					<p><strong>Kategori:</strong> <?=$price->subject_title?></p>
					<p><strong>Özel Ders Ücreti:</strong> <?=$price->price_private?> TL</p>
					<p><strong>Canlı Ders Ücreti:</strong> <?if(empty($price->price_live)):?>Verilmiyor<?else:?><?=$price->price_live?> TL<?endif;?></p>
					<p><?=$price->level_title?> özel dersi veren eğitmenin profiline gitmek için <a href="<?=site_url($user->username)?>">buraya</a> tıklayınız. <?=$price->level_title?> özel dersi veren eğitmenleri görüntülemek için <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/?subject=<?=$price->subject_id?>&level=<?=$price->level_id?>">buraya</a> tıklayınız.</p>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-3 no-float profile-top-right text-center">
					
					<div><img class="img-thumbnail margin-bottom-20" src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" /></div>

					<div><strong><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></strong></div>
					
					<div class="margin-top-10 margin-bottom-20">
						<?if($user->online):?>
							<span class="lightred-text"><i class="fa fa-power-off"></i> Çevrimiçi</span>
						<?else:?>
							<span class="lightgrey-text">Çevrimdışı</span>
						<?endif;?>
					</div>
										
					<div class="btn-group btn-group-justified">
						<div class="btn-group padded-table" style="white-space: nowrap;">
					      <div class="padded-table">
					  		<div class="tc-fluid">
					          <button class="btn btn-default" style="border-radius:4px;">
							  	<a href="<?=site_url($user->username)?>">Profili Görüntüle</a>
					          </button>
					        </div>
					      </div>
						</div>
					</div>
					
		
							
				</div>
			</div>
		</div>
		
				
	</div>
</section>
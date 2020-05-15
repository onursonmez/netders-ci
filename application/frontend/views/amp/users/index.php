<div class="section-white">
<ul class="filters">
	<li class="placeholder"> 
		<a href="#0">SIRALAMA</a> <!-- selected option on mobile -->
	</li> 
	<li class="filter"><a href="<?=make_filter_link()?>" class="<?if(!$this->input->get('sort_price') && !$this->input->get('sort_point')):?> selected<?endif;?>">Akıllı Sıralama <i class="fa fa-caret-down"></i></a></li>
	<li class="filter"><a href="<?=make_filter_link('sort_price')?>" class="<?if($this->input->get('sort_price')):?> selected<?endif;?>">Ücret <i class="fa fa-caret-<?if($this->input->get('sort_price') && $this->input->get('sort_price') == 'asc'):?>up<?else:?>down<?endif;?>"></i></a></li>
	<li class="filter"><a href="<?=make_filter_link('sort_point')?>"<?if($this->input->get('sort_point')):?> class="selected"<?endif;?>>Puan <i class="fa fa-caret-<?if($this->input->get('sort_point') && $this->input->get('sort_point') == 'asc'):?>up<?else:?>down<?endif;?>"></i></a></li>
</ul> <!-- cd-filters -->

<div class="row">
		
	<div class="col-md-12">
		<?if(isset($breadcrumb)):?>
			<ol itemscope itemtype="http://schema.org/BreadcrumbList">
				<?foreach($breadcrumb as $key => $link):?>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
						<a itemprop="item" href="<?=$link['link']?>">
						<span itemprop="name"><?=$link['title']?></span></a>
						<meta itemprop="position" content="<?=$key+1?>" />
					</li>				
				<?endforeach;?>
			</ol>
		<?endif;?>
		<?if(!empty($total)):?>
			<p>Arama sonuçlarına uygun <?=$total?> eğitmen bulundu.</p>
			

			<?if($GLOBALS['settings_global']->mobile):?>
			<div class="row">
				<div class="col-md-12 margin-bottom-20 relative">
					<section class="grey-header padding-10">
						<div class="container">
						    <div class="row">
							    <div class="col-md-12 text-center">
									<h3>Tecrübeli eğitmenlerden uygun fiyatlarla özel ders alın!</h3>
									<p>Netders.com üyesi, yerli ve yabancı uzman eğitmenlerden özel ders alın. Uygun fiyat, kaliteli hizmet politikası ile hizmet veren eğitmenlerden ilk dersi ücretsiz olarak özel ders alın. Beğendiğiniz eğitmenden özel ders almaya devam edin. Beğenmediğiniz eğitmeni hiçbir ücret ödemeden değiştirin. Alanında uzman ve tecrübeli eğitmenlerden hemen özel ders almak için kırmızı yazıya tıklayın.</p>
									<h3><a href="#" class="js-category-phone red-text">Özel ders almak için tıklayın</a></h3>
									<script>
										$(function(){
											$('.js-category-phone').on('click', function(){
												$(this).html("<?=$GLOBALS['settings_global']->mobile?>");
											});
										});
									</script>
							    </div>
						    </div>
						</div>
					</section>						
				</div>
			</div>
			<?endif;?>			
								
		<?endif;?>
	</div>
	
	<?if(empty($total)):?>
	
		<div class="clearfix"></div>
		
		<?if($GLOBALS['settings_global']->mobile):?>
		<div class="col-md-12 margin-bottom-20 relative">
		    <div class="row">
			    <div class="col-md-12">
					<h1>Hemen özel ders alın!</h1>
					<p>Bu kategoride yer alan uzman eğitmenlerden özel ders almak için hemen arayın. Size en uygun eğitmenimiz ile görüşerek almak istediğiniz özel derse kısa süre içerisinde başlayın. Hemen arayarak ücretsiz ilk ders ve rekabetçi özel ders fiyatları ile eğitiminize başlayabilirsiniz.</p>
					<h3 class="red-text">Özel ders almak için hemen arayın: <?=$GLOBALS['settings_global']->mobile?></h3>
			    </div>
		    </div>
		</div>
		<?endif;?>

		<div class="col-md-12 margin-bottom-20 relative">
			<div class="row">
				<div class="col-md-12">
					<div class="alert alert-warning">
						<h3>Üzgünüz, arama kriterlerine uygun eğitmen bulunamadı</h3>
						<p>Arama kriterlerinizi gözden geçirip tekrar deneyebilirsiniz</p>
					</div>						

				</div>
				<div class="col-md-12">
					<div class="alert alert-info">
						<h3>Sizin için en iyi eğitmeni, en uygun fiyatlarla ve %10 ekstra indirim fırsatı ile bulabiliriz!</h3>
						<p>Aradığınız kriterlere uygun eğitmeni bulup, her ders için ekstra %10 indirimli olarak ders almanızı sağlayabilmemiz için aşağıdaki formu doldurmanız yeterlidir. Müşteri temsilcilerimiz mesai saatleri içerisinde size dönüş yaparak, kriterlere uygun olan eğitmenlerle ilgili bilgi verecektir.</p>								
						<form  action="<?=current_url()?>" method="post" class="ajax-form margin-top-20">
							<div class="row">	
								<div class="form-group col-md-3">
									<input type="text" name="fullname" class="form-control" placeholder="Adınız Soyadınız" />
								</div>
								<div class="form-group col-md-3">
									<input type="text" name="mobile" data-type="mobile-number" class="form-control" />
								</div>				
								<div class="form-group col-md-2">
									<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
								</div>
								<div class="form-group col-md-2">
									<amp-img src="<?=base_url('captcha/'.generate_captcha('request_search'))?>" width="200" height="32"></amp-img>
								</div>																	
								<div class="col-md-2">
									<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Talep Bırak</button>
									<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
								</div>								
							</div>
							<input type="hidden" name="form" value="request_search" />
							<input type="hidden" name="url" value="<?=current_url()?>" />
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						</form>
					</div>
				</div>						
			</div>
		</div>
										
		<?if(!empty($latest_users)):?>
		<div class="col-md-12 margin-bottom-20 relative">
			<div class="row">
				<div class="col-md-12 margin-bottom-20"><h3>Aramıza Yeni Katılan Eğitmenler</h3></div>
				<div class="col-md-12">
					<div id="carousel">
						<?foreach($latest_users as $user):?>
						<div class="item">
							<div class="panel panel-default user-box">
								<div class="panel-body">
									<div class="image"><a href="<?=site_url($user->username)?>"><amp-img src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" class="img-padding-border img-circle"></amp-img></a></div>
									<div class="title"><strong class="margin-top-10"><a href="<?=site_url($user->username)?>"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></strong></div>
									<ul class="extra">
										<li><i class="fa fa-money"></i> <?if($user->virtual_price):?><?=$user->virtual_price?><?else:?><?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL<?endif;?></li>
										<li><i class="fa fa-calendar-o"></i> <?if($user->virtual_age):?><?=$user->virtual_age?> yaşında<?else:?><?=calculate_age($user->birthday)?> yaşında<?endif;?></li>
										<li><i class="fa fa-map-marker"></i> <?=$user->city_title?>, <?=$user->town_title?></li>
									</ul>
									<div class="title-bottom"><?if(strlen($user->levels) > 80):?><?=mb_substr($user->levels, 0, 80, 'utf-8')?>...<?else:?><?=$user->levels?><?endif;?></div>
								</div>
							</div>
						</div>
						<?endforeach;?>
					</div>	
				</div>						
			</div>
		</div>
		<?endif;?>
				
	<?endif;?>

	<?if(!empty($total)):?>
	<div class="col-md-12 margin-bottom-20 relative">
		<section class="grey-header padding-10">
			<div class="container">
			    <div class="row">
				    <div class="col-md-12 text-center">
						<h1 class="margin-top-10"><?if($town_title):?><?=$town_title?><?else:?><?=$city_title?><?endif;?> <?if($subject_name && !$level_name):?><?=$subject_name?> <?endif;?><?if($level_name):?><?=$level_name?> <?endif;?><?if($this->input->get('keyword')):?> <?=txtWordUpper($this->input->get('keyword', true))?> <?endif;?>Özel Ders Verenler<?if($level_name):?> - <?=$subject_name?><?endif;?></h1>
						<?if(!empty($text->lesson_top_text)):?>
						<h2 class="margin-top-10"><?=$text->lesson_top_text?></h2>
						<?else:?>
						<h2 class="margin-top-10"><?if($town_title):?><?=$town_title?><?else:?><?=$city_title?><?endif;?> <?if($subject_name && !$level_name):?><?=$subject_name?> <?endif;?><?if($level_name):?><?=txtLower($level_name)?> <?endif;?>özel ders verenler tarafından oluşturulan, <?if($town_title):?><?=txtLower($town_title)?><?else:?><?=$city_title?><?endif;?> <?if($subject_name && !$level_name):?><?=$subject_name?> <?endif;?><?if($level_name):?><?=txtLower($level_name)?> <?endif;?><?if($this->input->get('keyword')):?> <?=txtLower($this->input->get('keyword', true))?> <?endif;?>özel ders ilanları aşağıdadır<?if($level_name):?> - <?=$subject_name?><?endif;?>.</h2>
						<?endif;?>
				    </div>
			    </div>
			</div>
		</section>						
	</div>
	<?endif;?>
				
	<?if(!empty($users_special)):?>
	<?foreach($users_special as $type => $user):?>
	<?if(!empty($user)):?>
	<div class="col-md-12">
		<div class="box <?=$type?>">							
			<div class="media">
				<div class="media-left text-center">
					<a href="<?=site_url($user->username)?>" target="_blank">										
						<amp-img class="media-object img-thumbnail margin-bottom-5" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" width="100"></amp-img>
						
						<?if($user->service_badge == 'Y'):?>
							<i data-original-title="Uzman Eğitmen" class="fa fa-bookmark" data-toggle="tooltip" data-placement="top" title=""></i>
						<?endif;?>
					</a>
				</div>
				<div class="media-body">
					<?if($type == 'month'):?>
					<amp-img class="month-week-day-badge" src="<?=base_url('public/img/ayin-egitmeni.png')?>" width="150"></amp-img>
					<?elseif($type == 'week'):?>
					<amp-img class="month-week-day-badge" src="<?=base_url('public/img/haftanin-egitmeni.png')?>" width="150"></amp-img>
					<?else:?>
					<amp-img class="month-week-day-badge" src="<?=base_url('public/img/gunun-egitmeni.png')?>" width="150"></amp-img>
					<?endif;?>
					<h4 class="media-heading"><a href="<?=site_url($user->username)?>" target="_blank"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></h4>
					<div class="row">
						<div class="col-md-12">
							<?if($user->text_title):?><span class="block grey-text italic-text"><?=txtFirstUpper($user->text_title)?></span><?endif;?>
							<div class="row margin-top-15 margin-bottom-15">
								<div class="col-md-6">
									<i class="fa fa-money"></i> <?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL
								</div>
								
								<?if($user->birthday):?>
								<div class="col-md-6">
									<i class="fa fa-calendar-o"></i> <?=calculate_age($user->birthday)?> yaşında
								</div>
								<?endif;?>
								
								<?if($user->city_title && $user->town_title):?>
								<div class="col-md-6">
									<i class="fa fa-map-marker"></i> <?=$user->city_title?>, <?=$user->town_title?>
								</div>
								<?endif;?>
								
								<div class="col-md-6">
									<?if($user->online == 1):?>
									<span class="lightred-text"><i class="fa fa-power-off"></i> Çevrimiçi</span>
									<?else:?>
									Çevrimdışı
									<?endif;?>
								</div>
							</div>
						</div>
						
						<div class="col-md-12 grey-text italic-text margin-top-15">
						<?if($user->text_long):?><?=txtFirstUpper(truncate($user->text_long, 200))?><?endif;?>
						</div>
									
						<div class="col-md-12">
							<div class="row margin-top-15">
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount7 > 0):?>check<?else:?>close<?endif;?>"></i> Ücretsiz İlk Ders
								</div>
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount10 > 0):?>check<?else:?>close<?endif;?>"></i> Üye Öğrenci İndirimi												
								</div>										
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount8 > 0):?>check<?else:?>close<?endif;?>"></i> Eğitmen Evi İndirimi												
								</div>
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount9 > 0):?>check<?else:?>close<?endif;?>"></i> Grup İndirimi												
								</div>
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount11 > 0):?>check<?else:?>close<?endif;?>"></i> Paket Program İndirimi												
								</div>
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount1 > 0 || $user->discount2 > 0 || $user->discount3 > 0 || $user->discount4 > 0 || $user->discount5 > 0 || $user->discount6 > 0):?>check<?else:?>close<?endif;?>"></i> Canlı Ders İndirimi
								</div>
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount12 > 0):?>check<?else:?>close<?endif;?>"></i> Engelli İndirimi
								</div>
								<div class="col-sm-12 col-md-4">
									<i class="fa fa-<?if($user->discount13 > 0):?>check<?else:?>close<?endif;?>"></i> Öneri İndirimi
								</div>							
							</div>
						</div>
					</div><!--/.row-->
				</div><!--/.media-body-->
			</div><!--/.media"-->							
		</div><!--/.box-->
	</div><!--/.col-md-12-->
	<?endif;?>
	<?endforeach;?>			
	<?endif;?>					
	
	
	<?if(!empty($users)):?>
	<?
		$featured_band = false;
		$all_band = false;
		$masonry_top = false;
	?>
	
	<?foreach($users as $key => $user):?>

	<?if($user->search_point >= 14 && $featured_band == false && !$this->input->get('sort_price') && !$this->input->get('sort_point')):?>
	<div class="col-md-12 margin-bottom-20 relative">
		<section class="grey-header padding-10">
			<div class="container">
			    <div class="row">
				    <div class="col-md-12 text-center">
						<h3 class="margin-bottom-0">Öne Çıkan Eğitmenler</h3>
				    </div>
			    </div>
			</div>
		</section>						
	</div>
	<?$featured_band = true?>
	<?endif;?>

	<?if(($user->search_point < 14 || $this->input->get('sort_price')) && $all_band == false):?>
	<div class="col-md-12 margin-bottom-20 relative">
		<section class="grey-header padding-10">
			<div class="container">
			    <div class="row">
				    <div class="col-md-12 text-center">
						<h3 class="margin-bottom-0">Tüm Eğitmenler</h3>
				    </div>
			    </div>
			</div>
		</section>						
	</div>
	<?$all_band = true?>
	<?endif;?>
	
	<?if($all_band == true && $masonry_top == false && sizeof($users) > 1):?><div class="clearfix"></div><div class="masonry"><?$masonry_top = true?><?endif;?>
	<div class="col-md-<?if($all_band == true && $masonry_top == true && sizeof($users) > 1):?>6 masonry-item<?else:?>12<?endif;?>">
		<div class="box<?if($user->ugroup == 5):?> premium<?elseif($user->ugroup == 4):?> advanced<?endif;?>">							
			<div class="media">
				<div class="media-left text-center">
					<a href="<?=amp_url(site_url($user->username))?>" target="_blank">										
						<amp-img class="media-object img-thumbnail margin-bottom-5" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" width="100" height="100"></amp-img>
						
						<?if($user->service_badge == 'Y'):?>
							<i data-original-title="Uzman Eğitmen" class="fa fa-bookmark" data-toggle="tooltip" data-placement="top" title=""></i>
						<?endif;?>
					</a>
				</div>
				<div class="media-body">
					<h4 class="media-heading"><a href="<?=amp_url(site_url($user->username))?>" target="_blank"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></h4>
					<div class="row">
						<div class="col-md-12">
							<?if($user->text_title):?><span class="block grey-text italic-text"><?=txtFirstUpper($user->text_title)?></span><?endif;?>
							<div class="row margin-top-15 margin-bottom-15">
								<div class="col-md-6">
									<?if($user->virtual == 'Y'):?>
										<?if($user->virtual_price):?>
											<i class="fa fa-money"></i> <?=str_replace('/Saat', '', $user->virtual_price)?>
										<?else:?>
											<i class="fa fa-money"></i> Görüşülür
										<?endif;?>
									<?else:?>
										<i class="fa fa-money"></i> <?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL
									<?endif;?>
								</div>
								
								<?if($user->birthday):?>
								<div class="col-md-6">
									<i class="fa fa-calendar-o"></i> <?=calculate_age($user->birthday)?> yaşında
								</div>
								<?endif;?>
								
								<?if($user->city_title && $user->town_title):?>
								<div class="col-md-6">
									<i class="fa fa-map-marker"></i> <?=$user->city_title?>, <?=$user->town_title?>
								</div>
								<?endif;?>
								
								<div class="col-md-6">
									<?if($user->online == 1):?>
									<span class="lightred-text"><i class="fa fa-power-off"></i> Çevrimiçi</span>
									<?else:?>
									Çevrimdışı
									<?endif;?>
								</div>
							</div>
						</div>
					</div><!--/.row-->
				</div><!--/.media-body-->
			</div><!--/.media"-->							
			<div class="row">
				<div class="col-md-12 grey-text italic-text margin-top-15">
				<?if($user->text_long):?><?=txtFirstUpper(truncate($user->text_long,200))?><?endif;?>
				</div>
				
				<?if($user->virtual == 'Y'):?>
					<div class="col-md-12">
						<div class="row margin-top-15">
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Ücretsiz İlk Ders
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Üye Öğrenci İndirimi												
							</div>										
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Eğitmen Evi İndirimi												
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Grup İndirimi												
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Paket Program İndirimi												
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Canlı Ders İndirimi
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Engelli İndirimi
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-check"></i> Öneri İndirimi
							</div>							
						</div>
					</div>							
				<?else:?>
					<div class="col-md-12">
						<div class="row margin-top-15">
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount7 > 0):?>check<?else:?>close<?endif;?>"></i> Ücretsiz İlk Ders
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount10 > 0):?>check<?else:?>close<?endif;?>"></i> Üye Öğrenci İndirimi												
							</div>										
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount8 > 0):?>check<?else:?>close<?endif;?>"></i> Eğitmen Evi İndirimi												
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount9 > 0):?>check<?else:?>close<?endif;?>"></i> Grup İndirimi												
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount11 > 0):?>check<?else:?>close<?endif;?>"></i> Paket Program İndirimi												
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount1 > 0 || $user->discount2 > 0 || $user->discount3 > 0 || $user->discount4 > 0 || $user->discount5 > 0 || $user->discount6 > 0):?>check<?else:?>close<?endif;?>"></i> Canlı Ders İndirimi
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount12 > 0):?>check<?else:?>close<?endif;?>"></i> Engelli İndirimi
							</div>
							<div class="col-sm-12 col-md-4">
								<i class="fa fa-<?if($user->discount13 > 0):?>check<?else:?>close<?endif;?>"></i> Öneri İndirimi
							</div>							
						</div>
					</div>	
				<?endif;?>					
			</div><!--.row-->					
		</div><!--/.box-->
	</div><!--/.col-md-6/12-->
	<?if($masonry_top == true && $all_band == true && sizeof($users) == $key+1 && sizeof($users) > 1):?></div><!--.masonry--><?endif;?>
	<?endforeach;?>
	<?endif;?>

</div><!--/.row-->

<?if(!empty($pages)):?>
<div class="col-sm-12 text-center">
      <ul class="pagination">
		<?foreach($pages as $page):?>
		<li<?if($page['current'] == 1):?> class="active"<?endif;?>><a href="<?=$page['link']?>"><?=$page['title']?></a></li>
		<?endforeach;?>
      </ul>        
</div>					
<?endif;?>


<?if(!empty($text->description)):?>
<div class="col-sm-12">
<hr />	
<?=$text->description?>
</div>
<?endif;?>
</div>
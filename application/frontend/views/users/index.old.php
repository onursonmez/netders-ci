<main class="cd-main-content">
	<div class="cd-tab-filter-wrapper">
		<div class="cd-tab-filter">
			<ul class="cd-filters">
				<li class="placeholder">
					<a href="#0">SIRALAMA</a> <!-- selected option on mobile -->
				</li>
				<li class="filter"><a href="<?=make_filter_link()?>" class="<?if(!$this->input->get('sort_price') && !$this->input->get('sort_point')):?> selected<?endif;?>">Akıllı Sıralama <i class="fa fa-caret-down"></i></a></li>
				<li class="filter"><a href="<?=make_filter_link('sort_price')?>" class="<?if($this->input->get('sort_price')):?> selected<?endif;?>">Ücret <i class="fa fa-caret-<?if($this->input->get('sort_price') && $this->input->get('sort_price') == 'asc'):?>up<?else:?>down<?endif;?>"></i></a></li>
				<li class="filter"><a href="<?=make_filter_link('sort_point')?>"<?if($this->input->get('sort_point')):?> class="selected"<?endif;?>>Puan <i class="fa fa-caret-<?if($this->input->get('sort_point') && $this->input->get('sort_point') == 'asc'):?>up<?else:?>down<?endif;?>"></i></a></li>
			</ul> <!-- cd-filters -->
		</div> <!-- cd-tab-filter -->
	</div> <!-- cd-tab-filter-wrapper -->

	<section class="cd-gallery">

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
											<img src="<?=base_url('captcha/'.generate_captcha('request_search'))?>" width="100%" height="32" />
										</div>
										<div class="col-md-2">
											<button type="submit" class="btn btn-primary js-submit-btn">Talep Bırak</button>
											<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
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
										<div class="card-body">
											<div class="image"><a href="<?=site_url($user->username)?>"><img src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" class="img-padding-border img-circle" style="max-width:60%;" /></a></div>
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
								<img class="media-object img-thumbnail margin-bottom-5" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" width="100">

								<?if($user->service_badge == 'Y'):?>
									<i data-original-title="Uzman Eğitmen" class="fa fa-bookmark" data-toggle="tooltip" data-placement="top" title=""></i>
								<?endif;?>
							</a>
						</div>
						<div class="media-body">
							<?if($type == 'month'):?>
							<img class="month-week-day-badge" src="<?=base_url('public/img/ayin-egitmeni.png')?>" width="150" />
							<?elseif($type == 'week'):?>
							<img class="month-week-day-badge" src="<?=base_url('public/img/haftanin-egitmeni.png')?>" width="150" />
							<?else:?>
							<img class="month-week-day-badge" src="<?=base_url('public/img/gunun-egitmeni.png')?>" width="150" />
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
								<?if($user->text_long):?><?=txtFirstUpper(truncate($user->text_long,200))?><?endif;?>
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
							<a href="<?=site_url($user->username)?>" target="_blank">
								<img class="media-object img-thumbnail margin-bottom-5" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" width="100">

								<?if($user->service_badge == 'Y'):?>
									<i data-original-title="Uzman Eğitmen" class="fa fa-bookmark" data-toggle="tooltip" data-placement="top" title=""></i>
								<?endif;?>
							</a>
						</div>
						<div class="media-body">
							<h4 class="media-heading"><a href="<?=site_url($user->username)?>" target="_blank"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></h4>
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
						<?if($user->text_long):?><?=txtFirstUpper(truncate($user->text_long, 200))?><?endif;?>
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
	</section> <!-- cd-gallery -->

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


	<div class="cd-filter">
		<form method="GET" action="<?=current_url()?>" id="search-form">
			<div class="cd-filter-block">
				<h4>ANAHTAR KELİME</h4>
				<div class="cd-filter-content">
					<input type="text" name="keyword" value="<?=htmlspecialchars($this->input->get('keyword', true))?>" data-toggle="tooltip" data-placement="bottom" title="Eğitmen adı, soyadı, kullanıcı adı veya tanıtım yazılarında geçen bir metni arayın">
				</div> <!-- cd-filter-content -->
			</div> <!-- cd-filter-block -->

			<h3>LOKASYON</h3>

			<div class="cd-filter-block">
				<h4>ŞEHİR</h4>
				<div class="cd-filter-content">
					<div class="cd-select cd-filters cd-chosen-select">
						<select name="city" data-name="city" id="city-search" class="filter chosen-select">
							<option value=""<?if(!$this->input->get('city') && !$this->session->userdata('site_city')):?> selected<?endif;?>>-- <?=lang('ALL')?> --</option>
							<?foreach($cities as $city):?>
							<option value="<?=$city->id?>"<?if(($this->input->get('city') == $city->id) || ($this->session->userdata('site_city') == $city->id)):?> selected<?endif;?>><?=$city->title?></option>
							<?endforeach;?>
						</select>
					</div> <!-- cd-select -->
				</div> <!-- cd-filter-content -->
			</div> <!-- cd-filter-block -->

			<div class="cd-filter-block">
				<h4>BÖLGE</h4>
				<div class="cd-filter-content">
					<div class="cd-select cd-filters cd-chosen-select">
						<select name="town" data-name="town" id="town-search" class="filter chosen-select">
							<option value="">-- <?=lang('ALL')?> --</option>
						</select>
					</div> <!-- cd-select -->
				</div> <!-- cd-filter-content -->
			</div> <!-- cd-filter-block -->

			<h3>EĞİTİM</h3>

			<div class="cd-filter-block">
				<h4>KONU</h4>
				<div class="cd-filter-content">
					<div class="cd-select cd-filters cd-chosen-select">
						<select name="subject" data-name="subject" id="subject" class="filter chosen-select">
							<option value="">-- <?=lang('ALL')?> --</option>
							<?foreach($subjects as $subject):?>
		            <option value="<?=$subject->category_id?>"<?if($subject->category_id == $this->input->get('subject') || ($this->session->userdata('site_subject') == $subject->category_id)):?> selected<?endif;?>><?=$subject->title?></option>
	            <?endforeach;?>
						</select>
					</div> <!-- cd-select -->
				</div> <!-- cd-filter-content -->
			</div> <!-- cd-filter-block -->

			<div class="cd-filter-block js-level-select<?if(!$this->input->get('subject')):?> hide<?endif;?>">
				<h4>DERS</h4>
				<div class="cd-filter-content">
					<div class="cd-select cd-filters cd-chosen-select">
						<select name="level" data-name="level" id="level" class="filter chosen-select"></select>
					</div> <!-- cd-select -->
				</div> <!-- cd-filter-content -->
			</div> <!-- cd-filter-block -->

			<h3>ÜCRET ARALIĞI</h3>
			<div class="cd-filter-block">
				<div class="cd-filter-content">
					<div class="row">
						<div class="col-xs-6">
							<input type="text" name="price_min" class="filter" placeholder="0" value="<?if($this->input->get('price_min') > 0):?><?=(int)$this->input->get('price_min', true)?><?endif;?>" />
						</div>
						<div class="col-xs-6">
							<input type="text" name="price_max" class="filter" placeholder="999" value="<?if($this->input->get('price_max') > 0):?><?=(int)$this->input->get('price_max', true)?><?endif;?>" />
						</div>
					</div>
				</div>
			</div>

			<h3>ŞEKİL</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="figure[]" value="1" id="f1" class="filter"<?if($this->input->get('figure') && in_array(1, $this->input->get('figure'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="f1">Birebir Ders</label>
					</li>
					<li>
						<input type="checkbox" name="figure[]" value="2" id="f2" class="filter"<?if($this->input->get('figure') && in_array(2, $this->input->get('figure'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="f2">Grup Dersi</label>
					</li>
				</ul>
			</div>

			<h3>MEKAN</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="place[]" value="1" id="p1" class="filter"<?if($this->input->get('place') && in_array(1, $this->input->get('place'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="p1">Öğrencinin Evi</label>
					</li>
					<li>
						<input type="checkbox" name="place[]" value="2" id="p2" class="filter"<?if($this->input->get('place') && in_array(2, $this->input->get('place'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="p2">Eğitmen Evi</label>
					</li>
					<li>
						<input type="checkbox" name="place[]" value="3" id="p3" class="filter"<?if($this->input->get('place') && in_array(3, $this->input->get('place'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="p3">Etüd Merkezi</label>
					</li>
					<li>
						<input type="checkbox" name="place[]" value="4" id="p4" class="filter"<?if($this->input->get('place') && in_array(4, $this->input->get('place'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="p4">Kütüphane</label>
					</li>
					<li>
						<input type="checkbox" name="place[]" value="5" id="p5" class="filter"<?if($this->input->get('place') && in_array(5, $this->input->get('place'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="p5">Diğer</label>
					</li>
				</ul>
			</div>

			<h3>ZAMAN</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="time[]" value="1" id="t1" class="filter"<?if($this->input->get('time') && in_array(1, $this->input->get('time'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="t1">Hafta içi gündüz</label>
					</li>
					<li>
						<input type="checkbox" name="time[]" value="2" id="t2" class="filter"<?if($this->input->get('time') && in_array(2, $this->input->get('time'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="t2">Hafta içi akşam</label>
					</li>
					<li>
						<input type="checkbox" name="time[]" value="3" id="t3" class="filter"<?if($this->input->get('time') && in_array(3, $this->input->get('time'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="t3">Haftasonu gündüz</label>
					</li>
					<li>
						<input type="checkbox" name="time[]" value="4" id="t4" class="filter"<?if($this->input->get('time') && in_array(4, $this->input->get('time'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="t4">Haftasonu akşam</label>
					</li>
				</ul>
			</div>

			<h3>HİZMET</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="service[]" value="1" id="s1" class="filter"<?if($this->input->get('service') && in_array(1, $this->input->get('service'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="s1">Ödev Yardımı</label>
					</li>
					<li>
						<input type="checkbox" name="service[]" value="2" id="s2" class="filter"<?if($this->input->get('service') && in_array(2, $this->input->get('service'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="s2">Tez Yardımı</label>
					</li>
					<li>
						<input type="checkbox" name="service[]" value="3" id="s3" class="filter"<?if($this->input->get('service') && in_array(3, $this->input->get('service'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="s3">Proje Yardımı</label>
					</li>
					<li>
						<input type="checkbox" name="service[]" value="4" id="s4" class="filter"<?if($this->input->get('service') && in_array(4, $this->input->get('service'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="s4">Eğitim Koçluğu</label>
					</li>
					<li>
						<input type="checkbox" name="service[]" value="5" id="s5" class="filter"<?if($this->input->get('service') && in_array(5, $this->input->get('service'))):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="s5">Yaşam Koçluğu</label>
					</li>
				</ul>
			</div>

			<h3>İNDİRİM</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="d1" value="1" id="d1" class="filter"<?if($this->input->get('d1')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d1">Ücretsiz İlk Ders</label>
					</li>
					<li>
						<input type="checkbox" name="d2" value="1" id="d2" class="filter"<?if($this->input->get('d2')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d2">Eğitmen Evi İndirimi</label>
					</li>
					<li>
						<input type="checkbox" name="d3" value="1" id="d3" class="filter"<?if($this->input->get('d3')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d3">Grup İndirimi</label>
					</li>
					<li>
						<input type="checkbox" name="d4" value="1" id="d4" class="filter"<?if($this->input->get('d4')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d4">Üye Öğrenci İndirimi</label>
					</li>
					<li>
						<input type="checkbox" name="d5" value="1" id="d5" class="filter"<?if($this->input->get('d5')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d5">Paket Program İndirimi</label>
					</li>
					<li>
						<input type="checkbox" name="d6" value="1" id="d6" class="filter"<?if($this->input->get('d6')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d6">Canlı Ders İndirimi</label>
					</li>
					<li>
						<input type="checkbox" name="d7" value="1" id="d7" class="filter"<?if($this->input->get('d7')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d7">Engelli İndirimi</label>
					</li>
					<li>
						<input type="checkbox" name="d8" value="1" id="d8" class="filter"<?if($this->input->get('d8')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="d8">Öneri İndirimi</label>
					</li>
				</ul>
			</div>

			<h3>EĞİTMEN GRUBU</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="group[]" value="5" id="g3" class="filter"<?if($this->input->get('group') && in_array(5, $this->input->get('group'))):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="g3">Premium</label>
					</li>
					<li>
						<input type="checkbox" name="group[]" value="4" id="g2" class="filter"<?if($this->input->get('group') && in_array(4, $this->input->get('group'))):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="g2">Advanced</label>
					</li>
					<li>
						<input type="checkbox" name="group[]" value="3" id="g1" class="filter"<?if($this->input->get('group') && in_array(3, $this->input->get('group'))):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="g1">Starter</label>
					</li>
				</ul>
			</div>

			<h3>EĞİTMEN CİNSİYETİ</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="gender" value="F" id="gen1" class="filter"<?if($this->input->get('gender') == 'F'):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="gen1">Yalnızca bayan eğitmenler</label>
					</li>
					<li>
						<input type="checkbox" name="gender" value="M" id="gen1" class="filter"<?if($this->input->get('gender') == 'M'):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="gen1">Yalnızca bay eğitmenler</label>
					</li>
				</ul>
			</div>

			<h3>DİĞER</h3>
			<div class="cd-filter-block">
				<ul class="cd-filter-content cd-filters list">
					<li>
						<input type="checkbox" name="badge" value="1" id="badge" class="filter"<?if($this->input->get('badge')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="badge">Yalnızca Uzman Sertifikalılar</label>
					</li>
					<li>
						<input type="checkbox" name="online" value="1" id="online" class="filter"<?if($this->input->get('online')):?> checked<?endif;?>>
		    			<label class="checkbox-label" for="online">Yalnızca Çevrimiçi Olanlar</label>
					</li>
					<li data-toggle="tooltip" data-placement="top" title="Bu kutucuğu işaretlerseniz lokasyon seçiminiz gözardı edilerek yalnızca canlı ders veren eğitmenler aranır.">
						<input type="checkbox" name="live" value="1" id="live" class="filter"<?if($this->input->get('live')):?> checked="checked"<?endif;?>>
		    			<label class="checkbox-label" for="live">Yalnızca Canlı Ders Verenler</label>
					</li>
				</ul>
			</div>

			<div class="cd-filter-block margin-bottom-10">
				<div class="cd-filter-content">
					<button type="submit" class="btn btn-wide btn-lightred">ARA</button>
				</div>
			</div>

			<!--
			<div class="cd-filter-block">
				<h4>Radyo buton</h4>

				<ul class="cd-filter-content cd-filters list">
					<li>
						<input class="filter" data-filter="" type="radio" name="radioButton" id="radio1" checked>
						<label class="radio-label" for="radio1">Tümü</label>
					</li>

					<li>
						<input class="filter" data-filter=".radio2" type="radio" name="radioButton" id="radio2">
						<label class="radio-label" for="radio2">Seçim2</label>
					</li>

					<li>
						<input class="filter" data-filter=".radio3" type="radio" name="radioButton" id="radio3">
						<label class="radio-label" for="radio3">Seçim3</label>
					</li>
				</ul>
			</div>
			-->
		</form>

		<a href="#0" class="cd-close">Kapat</a>
	</div> <!-- cd-filter -->

	<a href="#0" class="cd-filter-trigger">EĞİTMEN ARA</a>
</main> <!-- cd-main-content -->


<script>
	$(function(){

		(!window.requestAnimationFrame) ? fixGallery() : window.requestAnimationFrame(fixGallery);

		$('.cd-filter-trigger').on('click', function(){
			triggerFilter(true);
			$.cookie("search_left_menu", 'Y');
		});
		$('.cd-filter .cd-close').on('click', function(){
			triggerFilter(false);
			$.cookie("search_left_menu", 'N');
		});

		var filter_tab_placeholder = $('.cd-tab-filter .placeholder a'),
			filter_tab_placeholder_default_value = 'SIRALAMA',
			filter_tab_placeholder_text = filter_tab_placeholder.text();

		$('.cd-tab-filter li').on('click', function(event){
			var selected_filter = $(event.target).data('type');

			if( $(event.target).is(filter_tab_placeholder) ) {
				(filter_tab_placeholder_default_value == filter_tab_placeholder.text()) ? filter_tab_placeholder.text(filter_tab_placeholder_text) : filter_tab_placeholder.text(filter_tab_placeholder_default_value) ;
				$('.cd-tab-filter').toggleClass('is-open');

			} else if( filter_tab_placeholder.data('type') == selected_filter ) {
				filter_tab_placeholder.text($(event.target).text());
				$('.cd-tab-filter').removeClass('is-open');

			} else {
				$('.cd-tab-filter').removeClass('is-open');
				filter_tab_placeholder.text($(event.target).text()).data('type', selected_filter);
				filter_tab_placeholder_text = $(event.target).text();

				$('.cd-tab-filter .selected').removeClass('selected');
				$(event.target).addClass('selected');
			}
		});

		$('.cd-filter-block h4').on('click', function(){
			$(this).toggleClass('closed').siblings('.cd-filter-content').slideToggle(300);
		});

		$(window).on('scroll', function(){
			(!window.requestAnimationFrame) ? fixGallery() : window.requestAnimationFrame(fixGallery);
		});

		$('#search-form').submit(function(e)
		{
			e.preventDefault();

			$(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");

			$('#search-form select').each(function(){
				if(!$(this).val())
				$(this).attr('disabled', 'disabled');
			});

			$.get(base_url + 'users/generate_search_link', $(this).serialize(), function( res ) {
				location.href = res;
			});
		});

		$(window).load(function()
		{
			if($.cookie("search_left_menu") == 'Y' || $.cookie("search_left_menu") == undefined)
			{
				var elementsToTrigger = $([$('.cd-filter-trigger'), $('.cd-filter'), $('.cd-tab-filter'), $('.cd-gallery')]);
				elementsToTrigger.each(function(){
					$(this).toggleClass('filter-is-visible', true);
				});
				setTimeout(function(){
					window.dispatchEvent(new Event('resize'));
				}, 100);
			}

			/*
			setTimeout(function(){
				elementsToTrigger.each(function(){
					$(this).toggleClass('filter-is-visible', false);
				});
			}, 2000);
			*/

		});
	});

	function triggerFilter($bool) {
		var elementsToTrigger = $([$('.cd-filter-trigger'), $('.cd-filter'), $('.cd-tab-filter'), $('.cd-gallery')]);
		elementsToTrigger.each(function(){
			$(this).toggleClass('filter-is-visible', $bool);
		});
		setTimeout(function(){
			window.dispatchEvent(new Event('resize'));
			window.history.back(1);
		}, 100);
	}

	function fixGallery() {
		var offsetTop = $('.cd-main-content').offset().top,
			scrollTop = $(window).scrollTop();
		( scrollTop >= offsetTop ) ? $('.cd-main-content').addClass('is-fixed') : $('.cd-main-content').removeClass('is-fixed');
	}
</script>

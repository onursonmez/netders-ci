<!-- Sidebar  -->
<nav id="sidebar">
	<div id="dismiss" class="mt-2 mr-2">
		<img src="<?=base_url('public/img/navigation-close.svg')?>" />
	</div>
	<div class="p-4 mt-4">
		<h4 class="text-muted">Detaylı Arama</h4>
			<form method="GET" action="<?=current_url()?>" id="search-form" class="mt-2 pb-4">
			<div class="form-group">
				<input type="text" name="keyword" class="form-control" value="<?=htmlspecialchars($this->input->get('keyword', true))?>" data-toggle="tooltip" data-placement="bottom" title="Eğitmen adı, soyadı, kullanıcı adı veya tanıtım yazılarında geçen bir metni arayın" placeholder="Anahtar kelime..." />
			</div>
			<div class="p-2 mb-3 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/form-location.svg')?>" width="16" height="16"> Lokasyon</strong>
			</div>
			<div class="form-group">
				<select name="city" data-name="city" id="city-search" class="form-control select2">
					<option value=""<?if(!$this->input->get('city') && !$this->session->userdata('site_city')):?> selected<?endif;?>>-- <?=lang('ALL')?> --</option>
					<?foreach($cities as $city):?>
					<option value="<?=$city->id?>"<?if(($this->input->get('city') == $city->id) || ($this->session->userdata('site_city') == $city->id)):?> selected<?endif;?>><?=$city->title?></option>
					<?endforeach;?>
				</select>

			</div>
			<div class="form-group">
				<select name="town" data-name="town" id="town-search" class="form-control select2">
					<option value="">-- <?=lang('ALL')?> --</option>
				</select>
			</div>
			<div class="p-2 mb-3 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/claim-guides.svg')?>" width="16" height="16"> Eğitim</strong>
			</div>
			<div class="form-group">
				<select name="subject" data-name="subject" id="subject" class="form-control select2">
					<option value="">-- <?=lang('ALL')?> --</option>
					<?foreach($subjects as $subject):?>
						<option value="<?=$subject->category_id?>"<?if($subject->category_id == $this->input->get('subject') || ($this->session->userdata('site_subject') == $subject->category_id)):?> selected<?endif;?>><?=$subject->title?></option>
					<?endforeach;?>
				</select>
			</div>
			<div class="form-group">
				<select name="level" data-name="level" id="level" class="form-control select2"></select>
			</div>
			<div class="p-2 mb-3 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/profile-bonus.svg')?>" width="16" height="16"> Ücret</strong>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" name="price_min" class="form-control" placeholder="min TL" value="<?if($this->input->get('price_min') > 0):?><?=(int)$this->input->get('price_min', true)?><?endif;?>">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<input type="text" name="price_max" class="form-control" placeholder="maks TL" value="<?if($this->input->get('price_max') > 0):?><?=(int)$this->input->get('price_max', true)?><?endif;?>">
					</div>
				</div>
			</div>
			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/damage-furniture.svg')?>" width="16" height="16"> Şekil</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="figure[]" id="figure_1" value="1"<?if($this->input->get('figure') && in_array(1, $this->input->get('figure'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="figure_1">
					Birebir ders
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="figure[]" id="figure_2" value="2"<?if($this->input->get('figure') && in_array(2, $this->input->get('figure'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="figure_2">
					Grup dersi
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> Mekan</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="place[]" id="place_1" value="1"<?if($this->input->get('place') && in_array(1, $this->input->get('place'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="place_1">
					Öğrencinin evi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="place[]" id="place_2" value="2"<?if($this->input->get('place') && in_array(2, $this->input->get('place'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="place_2">
					Eğitmen evi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="place[]" id="place_3" value="3"<?if($this->input->get('place') && in_array(3, $this->input->get('place'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="place_3">
					Etüd merkezi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="place[]" id="place_4" value="4"<?if($this->input->get('place') && in_array(4, $this->input->get('place'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="place_4">
					Kütüphane
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="place[]" id="place_5" value="5"<?if($this->input->get('place') && in_array(5, $this->input->get('place'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="place_5">
					Diğer
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> Zaman</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="time[]" id="time_1" value="1"<?if($this->input->get('time') && in_array(1, $this->input->get('time'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="time_1">
					Hafta içi gündüz
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="time[]" id="time_2" value="2"<?if($this->input->get('time') && in_array(2, $this->input->get('time'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="time_2">
					Hafta içi akşam
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="time[]" id="time_3" value="3"<?if($this->input->get('time') && in_array(3, $this->input->get('time'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="time_3">
					Haftasonu gündüz
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="time[]" id="time_4" value="4"<?if($this->input->get('time') && in_array(4, $this->input->get('time'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="time_4">
					Haftasonu akşam
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> Hizmet</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="service[]" id="service_1" value="1"<?if($this->input->get('service') && in_array(1, $this->input->get('service'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="service_1">
					Ödev Yardımı
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="service[]" id="service_2" value="2"<?if($this->input->get('service') && in_array(2, $this->input->get('service'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="service_2">
					Tez Yardımı
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="service[]" id="service_3" value="3"<?if($this->input->get('service') && in_array(3, $this->input->get('service'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="service_3">
					Proje Yardımı
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="service[]" id="service_4" value="4"<?if($this->input->get('service') && in_array(4, $this->input->get('service'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="service_4">
					Eğitim Koçluğu
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="service[]" id="service_5" value="5"<?if($this->input->get('service') && in_array(5, $this->input->get('service'))):?> checked="checked"<?endif;?>>
				<label class="form-check-label" for="service_5">
					Yaşam Koçluğu
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> İndirim</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d1" id="discount_1" value="1"<?if($this->input->get('d1')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_1">
					Ücretsiz İlk Ders
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d2" id="discount_2" value="1"<?if($this->input->get('d2')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_2">
					Eğitmen Evi İndirimi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d3" id="discount_3" value="1"<?if($this->input->get('d3')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_3">
					Grup İndirimi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d4" id="discount_4" value="1"<?if($this->input->get('d4')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_4">
					Üye Öğrenci İndirimi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d5" id="discount_5" value="1"<?if($this->input->get('d5')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_5">
					Paket Program İndirimi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d6" id="discount_6" value="1"<?if($this->input->get('d6')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_6">
					Canlı Ders İndirimi
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="d7" id="discount_7" value="1"<?if($this->input->get('d7')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_7">
					Engelli İndirimi
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="d8" id="discount_8" value="1"<?if($this->input->get('d8')):?> checked<?endif;?>>
				<label class="form-check-label" for="discount_8">
					Öneri İndirimi
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> Eğitmen grubu</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="group[]" id="group_1" value="5"<?if($this->input->get('group') && in_array(5, $this->input->get('group'))):?> checked<?endif;?>>
				<label class="form-check-label" for="group_1">
					Premium
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="group[]" id="group_2" value="4"<?if($this->input->get('group') && in_array(4, $this->input->get('group'))):?> checked<?endif;?>>
				<label class="form-check-label" for="group_2">
					Advanced
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="group[]" id="group_3" value="3"<?if($this->input->get('group') && in_array(3, $this->input->get('group'))):?> checked<?endif;?>>
				<label class="form-check-label" for="group_3">
					Starter
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> Eğitmen cinsiyeti</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="gender" id="gender_1" value="F"<?if($this->input->get('gender') == 'F'):?> checked<?endif;?>>
				<label class="form-check-label" for="gender_1">
					Kadın
				</label>
			</div>
			<div class="form-check mb-3">
				<input class="form-check-input" type="checkbox" name="gender" id="gender_2" value="M"<?if($this->input->get('gender') == 'M'):?> checked<?endif;?>>
				<label class="form-check-label" for="gender_2">
					Erkek
				</label>
			</div>

			<div class="p-2 mb-2 bg-light-blue">
				<strong><img class="align-text-top" src="<?=base_url('public/img/category-town-house.svg')?>" width="16" height="16"> Diğer</strong>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="badge" id="other_1" value="1"<?if($this->input->get('badge')):?> checked<?endif;?>>
				<label class="form-check-label" for="other_1">
					Yalnızca Uzman Sertifikalılar
				</label>
			</div>
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="online" id="other_2" value="1"<?if($this->input->get('online')):?> checked<?endif;?>>
				<label class="form-check-label" for="other_2">
					Yalnızca Çevrimiçi Olanlar
				</label>
			</div>
			<div class="form-check mb-3" data-toggle="tooltip" data-placement="top" title="Bu kutucuğu işaretlerseniz lokasyon seçiminiz gözardı edilerek yalnızca canlı ders veren eğitmenler aranır.">
				<input class="form-check-input" type="checkbox" name="live" id="other_3" value="1"<?if($this->input->get('live')):?> checked<?endif;?>>
				<label class="form-check-label" for="other_3">
					Yalnızca Canlı Ders Verenler
				</label>
			</div>

			<button type="submit" class="btn btn-primary btn-block"><img class="align-middle" src="<?=base_url('public/img/form-search-white.svg')?>" width="13" height="13" /> Ara</button>
		</form>
	</div>
</nav>

<div class="container">
	<div class="card box-shadow rounded-top">
		<?if(!empty($breadcrumb)):?>
			<div class="card-header">
				<nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0" itemscope itemtype="http://schema.org/BreadcrumbList">
						<?foreach($breadcrumb as $key => $value):?>
            <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
							<a href="<?=$value['link']?>" itemprop="item">
								<span itemprop="name"><?=$value['title']?></span>
							</a>
						</li>
            <?endforeach;?>
          </ol>
        </nav>
			</div>
		<?endif;?>
		<div class="card-body">


			<div class="mb-2">
        <div class="row">
          <div class="col-12 col-lg-6 pt-015 text-center text-lg-left mb-1 mb-lg-0">
            Arama sonuçlarına uygun <strong><?=$total?></strong> eğitmen bulundu.
          </div>
          <div class="col-12 col-lg-6 text-center text-lg-right">

						<a href="<?=make_filter_link()?>" class="d-inline-block mt-1 mr-2 <?if(!$this->input->get('sort_price') && !$this->input->get('sort_point')):?> font-weight-bolder<?endif;?>">Akıllı Sıralama <img class="align-middle" src="<?=base_url('public/img/action-arrow-down-small-blue.svg')?>" width="8" height="8" /></a>
						<a href="<?=make_filter_link('sort_price')?>" class="d-inline-block mt-1 mr-2 <?if($this->input->get('sort_price')):?> font-weight-bolder<?endif;?>">Ücret <img class="align-middle" src="<?if($this->input->get('sort_price') && $this->input->get('sort_price') == 'asc'):?><?=base_url('public/img/action-arrow-up-small-blue.svg')?><?else:?><?=base_url('public/img/action-arrow-down-small-blue.svg')?><?endif;?>" width="8" height="8" /></a></li>
						<a href="<?=make_filter_link('sort_point')?>" class="d-inline-block mt-1 mr-2 <?if($this->input->get('sort_point')):?> font-weight-bolder<?endif;?>">Puan <img class="align-middle" src="<?if($this->input->get('sort_point') && $this->input->get('sort_point') == 'asc'):?><?=base_url('public/img/action-arrow-up-small-blue.svg')?><?else:?><?=base_url('public/img/action-arrow-down-small-blue.svg')?><?endif;?>" width="8" height="8" /></a></li>

            <a href="#" id="sidebarCollapse" class="btn btn-primary btn-sm mr-2 d-inline-block"><img class="align-text-top" src="<?=base_url('public/img/navigation-menu-white.svg')?>" width="16" height="16" /> Detaylı Arama</a>
          </div>
        </div>
      </div>

			<div class="p-3 mb-2">
        <h1 class="text-center display-5 text-dark font-weight-bolder"><?if($town_title):?><?=$town_title?><?else:?><?=$city_title?><?endif;?> <?if($subject_name && !$level_name):?><?=$subject_name?> <?endif;?><?if($level_name):?><?=$level_name?> <?endif;?><?if($this->input->get('keyword')):?> <?=txtWordUpper($this->input->get('keyword', true))?> <?endif;?>Özel Ders Verenler<?if($level_name):?> - <?=$subject_name?><?endif;?></h1>
				<?if(!empty($text->lesson_top_text)):?>
				<div class="text-center"><?=$text->lesson_top_text?></div>
				<?else:?>
				<div class="text-center"><?if($town_title):?><?=$town_title?><?else:?><?=$city_title?><?endif;?> <?if($subject_name && !$level_name):?><?=$subject_name?> <?endif;?><?if($level_name):?><?=txtLower($level_name)?> <?endif;?>özel ders verenler tarafından oluşturulan, <?if($town_title):?><?=txtLower($town_title)?><?else:?><?=$city_title?><?endif;?> <?if($subject_name && !$level_name):?><?=$subject_name?> <?endif;?><?if($level_name):?><?=txtLower($level_name)?> <?endif;?><?if($this->input->get('keyword')):?> <?=txtLower($this->input->get('keyword', true))?> <?endif;?>özel ders ilanları aşağıdadır<?if($level_name):?> - <?=$subject_name?><?endif;?>.</div>
				<?endif;?>
      </div>

			<?if(!empty($total)):?>
			<?foreach($users as $key => $user):?>
				<?if($user->search_point >= 14 && $featured_band == false && !$this->input->get('sort_price') && !$this->input->get('sort_point')):?>
				<div class="p-2 mb-2 bg-light-blue">
					<strong>Öne Çıkan Eğitmenler</strong>
				</div>
				<?$featured_band = true?>
				<?endif;?>

				<?if(($user->search_point < 14 || $this->input->get('sort_price')) && $all_band == false):?>
				<div class="p-2 mb-2 bg-light-blue">
					<strong>Tüm Eğitmenler</strong>
				</div>
				<?$all_band = true?>
				<?endif;?>

				<div class="card mb-2 border border-light-blue<?if($user->ugroup == 5):?> premium<?elseif($user->ugroup == 4):?> advanced<?endif;?>">
	        <div class="card-body">
	          <div class="media media-list">
	            <a href="<?=site_url($user->username)?>" target="_blank">
	              <img class="mr-3 photo" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>">
	            </a>
	            <div class="media-body">
	              <h4 class="mt-0">
										<a href="<?=site_url($user->username)?>" target="_blank"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a> <?if($user->service_badge == 'Y'):?><img class="align-middle" src="<?=base_url('public/img/claim-beneficiary.svg')?>" width="16" height="16" data-toggle="tooltip" data-placement="top" title="Bu eğitmenin alanında uzman olduğu belgelerle doğrulanmıştır"><?endif;?>
								</h4>
								<?if($user->text_title):?><h6><?=txtFirstUpper($user->text_title)?></h6><?endif;?>
	              <div class="row mb-2">
	                <div class="col-md-4">
										<span class="text-muted">
											<img class="align-text-top" src="<?=base_url('public/img/profile-bonus-gray.svg')?>" width="16" height="16">
											<?if($user->virtual == 'Y'):?>
												<?if($user->virtual_price):?>
													<i class="fa fa-money"></i> <?=str_replace('/Saat', '', $user->virtual_price)?>
												<?else:?>
													<i class="fa fa-money"></i> Görüşülür
												<?endif;?>
											<?else:?>
												<i class="fa fa-money"></i> <?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL
											<?endif;?>
										</span>
									</div>
									<?if($user->birthday):?>
									<div class="col-md-4">
										<span class="text-muted">
											<img class="align-text-top" src="<?=base_url('public/img/form-date-gray.svg')?>" width="16" height="16"> <?=calculate_age($user->birthday)?> yaşında
										</span>
									</div>
									<?endif;?>

									<?if($user->city_title && $user->town_title):?>
	                <div class="col-md-4">
											<span class="text-muted">
													<img class="align-text-top" src="<?=base_url('public/img/form-location-gray.svg')?>" width="16" height="16"> <?=$user->city_title?>, <?=$user->town_title?>
											</span>
									</div>
									<?endif;?>
	              </div>
	              <div>
	                <?if($user->text_long):?><?=txtFirstUpper(truncate($user->text_long, 200))?><?endif;?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
				<?endforeach;?>
			<?endif;?>



			<?if(!empty($pages)):?>
			<nav aria-label="Page navigation" class="mt-4">
				<ul class="pagination">
						<?foreach($pages as $page):?>
						<li class="page-item<?if($page['current']):?> active<?endif;?>"><a href="<?=$page['link']?>" class="page-link"><?=$page['title']?></a></li>
						<?endforeach;?>
				</ul>
			</nav>
			<?endif;?>
		</div>
	</div>
</div>

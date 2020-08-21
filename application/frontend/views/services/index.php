<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2>Hizmet Satınalma</h2>
		<p>Aşağıdaki ücretli hizmetleri satın alarak arama sonuçlarında daha üst sıralarda çıkabilir, ayrıcalıklı olabilir ve daha fazla öğrenciye ulaşarak kazancınızı katlayabilirsiniz.</p>	

		
		<div class="row">
		
		
			<?if($this->session->userdata('user_service_badge') == 'N'):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/uzman-egitmen-rozeti.png')?>" width="100" class="media-object" />
							</a>
							
							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 3):?>
									<?if($price[11]->price > 0):?><?=$price[11]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[12]->price > 0):?><?=$price[12]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 5):?>
									<?if($price[13]->price > 0):?><?=$price[13]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?endif;?>
							</div>
														
						</div>
						<div class="media-body">
							<h4 class="media-heading">Uzman Eğitmen Rozeti</h4>
							<p>Uzman eğitmen rozeti alan eğitmenler aramalarda ayrıcalıklandırılır. Arama sonuçlarında ve profil detay sayfalarında "Uzman Eğitmen Rozeti" bulunur ve açıklamasında "Eğitmenin uzmanlığı belgelerle doğrulanmıştır" bilgisi yer alır.</p>
							<p class="grey-text">Uzman eğitmen rozeti bir defa satın alınır ve ömür boyu kullanılır.</p>
							
							<div class="margin-top-10 margin-bottom-10">
							<input type="checkbox" name="aggrement" value="1" /> <a href="#" data-toggle="modal" data-target="#expert-terms-txt">Uzman eğitmen rozeti şartları</a>nı okudum, kabul ediyorum.
							</div>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 3):?>
						<input type="hidden" name="product_id" value="11" />
					<?elseif($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="12" />
					<?elseif($this->session->userdata('user_ugroup') == 5):?>
						<input type="hidden" name="product_id" value="13" />
					<?endif;?>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>
			
			<?if(($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4) && $this->session->userdata('user_service_web') == 'N'):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/ozel-web-sayfasi.png')?>" width="100" class="media-object" />
							</a>

							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 3):?>
									<?if($price[20]->price > 0):?><?=$price[20]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[21]->price > 0):?><?=$price[21]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?endif;?>
							</div>
							
						</div>
						<div class="media-body">
							<h4 class="media-heading">Özel Web Sayfası</h4>
							<p>Özel Web Sayfası hizmeti alarak diğer eğitmenlerin profil sayfalarından farklı bir profil sayfasına sahip olursunuz. Öğrencilerinize ayrıcalıklı bir eğitim hizmeti verdiğinizi hissettirmek istiyorsanız bu hizmeti satın alabilirsiniz.</p>
							<p class="grey-text">Özel web sayfası bir defa satın alınır ve ömür boyu kullanılır.</p>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 3):?>
						<input type="hidden" name="product_id" value="20" />
					<?elseif($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="21" />
					<?endif;?>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>
			
			<?if(($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4)):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/dikkat-ceken-egitmenler.png')?>" width="100" class="media-object" />
							</a>

							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 3):?>
									<?if($price[9]->price > 0):?><?=$price[9]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[10]->price > 0):?><?=$price[10]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?endif;?>
							</div>
														
						</div>
						<div class="media-body">
							<h4 class="media-heading">Öne Çıkanlar</h4>
							<p>Öne Çıkanlar hizmeti alarak bir hafta boyunca arama sonuçlarında öncelikli olan "Öne Çıkan Eğitmenler" arasında yer alırsınız. Arama sonuçlarında öğrenciler öncelikli olarak sizin profilinizi görür ve daha fazla öğrenciye özel ders verme imkanına sahip olursunuz.</p>
							<p class="grey-text">Öne Çıkanlar hizmetinin süresi 1 haftadır.</p>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 3):?>
						<input type="hidden" name="product_id" value="9" />
					<?elseif($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="10" />
					<?endif;?>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>
			
			<?if($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/siralama-dopingi-ozelligi.png')?>" width="100" class="media-object" />
							</a>
							
							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 3):?>
									<?if($price[14]->price > 0):?><?=$price[14]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[15]->price > 0):?><?=$price[15]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 5):?>
									<?if($price[16]->price > 0):?><?=$price[16]->price?> TL<?else:?>Ücretsiz<?endif;?>						
								<?endif;?>
							</div>							
						</div>
						<div class="media-body">
							<h4 class="media-heading">Haftalık Doping</h4>
							<p>Haftalık doping hizmeti alarak profilinizin arama sonuçlarında bir hafta boyunca grubunun en üstünde yer alması sağlanır.</p>
							<p class="grey-text">Haftalık doping hizmetinin süresi 1 haftadır.</p>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 3):?>
						<input type="hidden" name="product_id" value="14" />
					<?elseif($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="15" />
					<?elseif($this->session->userdata('user_ugroup') == 5):?>
						<input type="hidden" name="product_id" value="16" />			
					<?endif;?>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>
			
			<?if($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/siralama-dopingi-ozelligi.png')?>" width="100" class="media-object" />
							</a>

							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 3):?>
									<?if($price[17]->price > 0):?><?=$price[17]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[18]->price > 0):?><?=$price[18]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 5):?>
									<?if($price[19]->price > 0):?><?=$price[19]->price?> TL<?else:?>Ücretsiz<?endif;?>						
								<?endif;?>
							</div>							
						</div>
						<div class="media-body">
							<h4 class="media-heading">Aylık Doping</h4>
							<p>Aylık doping hizmeti alarak profilinizin arama sonuçlarında bir ay boyunca grubunun en üstünde yer alması sağlanır.</p>
							<p class="grey-text">Aylık doping hizmetinin süresi 1 aydır.</p>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 3):?>
						<input type="hidden" name="product_id" value="17" />
					<?elseif($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="18" />
					<?elseif($this->session->userdata('user_ugroup') == 5):?>
						<input type="hidden" name="product_id" value="19" />			
					<?endif;?>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>
			
			<?if($this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/gunun-haftanin-ayin-egitmeni.png')?>" width="100" class="media-object" />
							</a>

							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[22]->price > 0):?><?=$price[23]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 5):?>
									<?if($price[22]->price > 0):?><?=$price[23]->price?> TL<?else:?>Ücretsiz<?endif;?>						
								<?endif;?>
							</div>
														
						</div>
						<div class="media-body">
							<h4 class="media-heading">Günün Eğitmeni</h4>
							<p>Günün eğitmeni hizmeti alarak, belirlediğiniz konu ve dersin arama sonuçlarında, en üstte, farklı arkaplan rengi ile profiliniz daha çok dikkat çeker. Arama sonuçlarında öğrencilere ilk sizin profiliniz görünür. Profilinizde "günün eğitmeni" ibaresi yer alır.</p>
							<p class="grey-text">Günün eğitmeni hizmetinin süresi 1 gündür.</p>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Konu Seçimi</label>
										<select name="subject" id="subject_day" data-name="subject_id" class="form-control">
											<option value="">-- Lütfen Seçiniz --</option>	
											<?foreach($categories as $item):?>
											<option value="<?=$item->id?>"<?if($this->input->post('subject') == $item->id):?> selected<?endif;?>><?=$item->title?></option>	
											<?endforeach;?>											
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Ders Seçimi</label>
										<select name="level" id="level_day" class="form-control"></select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Tarih Seçimi</label>
										<input type="text" name="date" class="form-control drp-day" />
									</div>								
								</div>								
							</div>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="22" />
					<?elseif($this->session->userdata('user_ugroup') == 5):?>
						<input type="hidden" name="product_id" value="23" />			
					<?endif;?>
					<input type="hidden" name="type" value="day" />
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>
			
			<?if($this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/gunun-haftanin-ayin-egitmeni.png')?>" width="100" class="media-object" />
							</a>

							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[24]->price > 0):?><?=$price[24]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 5):?>
									<?if($price[25]->price > 0):?><?=$price[25]->price?> TL<?else:?>Ücretsiz<?endif;?>						
								<?endif;?>
							</div>
														
						</div>
						<div class="media-body">
							<h4 class="media-heading">Haftanın Eğitmeni</h4>
							<p>Haftanın eğitmeni hizmeti alarak, belirlediğiniz konu ve dersin arama sonuçlarında, en üstte, farklı arkaplan rengi ile profiliniz daha çok dikkat çeker. Arama sonuçlarında öğrencilere ilk sizin profiliniz görünür. Profilinizde "haftanın eğitmeni" ibaresi yer alır.</p>
							<p class="grey-text">Haftanın eğitmeni hizmetinin süresi 1 haftadır.</p>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Konu Seçimi</label>
										<select name="subject" id="subject_week" data-name="subject_id" class="form-control">
											<option value="">-- Lütfen Seçiniz --</option>	
											<?foreach($categories as $item):?>
											<option value="<?=$item->id?>"<?if($this->input->post('subject') == $item->id):?> selected<?endif;?>><?=$item->title?></option>	
											<?endforeach;?>											
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Ders Seçimi</label>
										<select name="level" id="level_week" class="form-control"></select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Tarih Seçimi</label>
										<input type="text" name="date" class="form-control drp-week" />
									</div>								
								</div>								
							</div>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="24" />
					<?elseif($this->session->userdata('user_ugroup') == 5):?>
						<input type="hidden" name="product_id" value="25" />			
					<?endif;?>
					<input type="hidden" name="type" value="week" />
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>	
			
			<?if($this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
			<div class="col-md-12">
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media panel-white padding-10 margin-bottom-20">
						<div class="media-left text-center">
							<a href="#">
								<img src="<?=base_url('public/img/gunun-haftanin-ayin-egitmeni.png')?>" width="100" class="media-object" />
							</a>

							<div class="price margin-top-10 margin-bottom-10">
								<?if($this->session->userdata('user_ugroup') == 4):?>
									<?if($price[26]->price > 0):?><?=$price[26]->price?> TL<?else:?>Ücretsiz<?endif;?>
								<?elseif($this->session->userdata('user_ugroup') == 5):?>
									<?if($price[27]->price > 0):?><?=$price[27]->price?> TL<?else:?>Ücretsiz<?endif;?>						
								<?endif;?>
							</div>
														
						</div>
						<div class="media-body">
							<h4 class="media-heading">Ayın Eğitmeni</h4>
							<p>Ayın eğitmeni hizmeti alarak, belirlediğiniz konu ve dersin arama sonuçlarında, en üstte, farklı arkaplan rengi ile profiliniz daha çok dikkat çeker. Arama sonuçlarında öğrencilere ilk sizin profiliniz görünür. Profilinizde "ayın eğitmeni" ibaresi yer alır.</p>
							<p class="grey-text">Ayın eğitmeni hizmetinin süresi 1 aydır.</p>
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Konu Seçimi</label>
										<select name="subject" id="subject_month" data-name="subject_id" class="form-control">
											<option value="">-- Lütfen Seçiniz --</option>	
											<?foreach($categories as $item):?>
											<option value="<?=$item->id?>"<?if($this->input->post('subject') == $item->id):?> selected<?endif;?>><?=$item->title?></option>	
											<?endforeach;?>											
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Ders Seçimi</label>
										<select name="level" id="level_month" class="form-control"></select>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label>Tarih Seçimi</label>
										<input type="text" name="date" class="form-control drp-month" />
									</div>								
								</div>								
							</div>
							
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
						</div>
					</div>	
					<?if($this->session->userdata('user_ugroup') == 4):?>
						<input type="hidden" name="product_id" value="26" />
					<?elseif($this->session->userdata('user_ugroup') == 5):?>
						<input type="hidden" name="product_id" value="27" />			
					<?endif;?>
					<input type="hidden" name="type" value="month" />
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>	
			</div>
			<?endif;?>					
	
		
		</div>
		
		<div class="text-center">
			<a href="<?=site_url('memberships')?>"><i class="fa fa-user-plus"></i> Üyeliklerimizi de incelemek isterseniz buraya tıklayınız</a>
		</div>
				
	</div>
</section>
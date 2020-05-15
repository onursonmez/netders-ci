<?if($this->session->userdata('user_status') == 'A'):?>
<div class="row">
	
	<div class="col-md-12 text-center">
		<div  style="font-size:18px;border:2px solid yellow; padding:20px; background-image:url(http://localhost/nv2/public/img/geo-background.png);">
			<h3>Fırsat! Facebook Sayfamızı Beğenin Kazançlı Çıkın</h3>
			<p>Gelen öğrenci taleplerini Netders.com'u Facebook'ta beğenen eğitmenlerimize öncelikli olarak yönlendirdiğimizi biliyor muydunuz?</p>
			<div class="fb-like" 
				data-href="https://www.facebook.com/netderscom" 
				data-layout="standard" 
				data-action="like" 
				data-size="large"
				data-show-faces="true">
			</div>			
		</div>
	</div>

	<?if(PAYMENT_SYSTEM == 0):?>
	<div class="col-md-12 margin-top-40">
		Bilgi: Ücretli üyelik ve hizmetler, ödeme sistemi istemcisi güncellemeleri nedeniyle, geliştirme süreci tamamlanana kadar inaktif edilmiştir.
	</div>
	<?endif;?>
		
	<div class="<?if(PAYMENT_SYSTEM == 0):?>hide"<?endif;?>>
	
	<div class="col-md-12 margin-top-40">
		<h2>Hizmetler - Profilinizi ziyaret eden öğrenci sayısını arttırın</h2>
	</div>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
					
					<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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

	<div class="col-md-12">
		<h2 class="margin-top-40">Advanced Üyelik - Ayrıcalıklı bir profile sahip olun</h2>
	</div>
	
	<div class="col-md-12">
		<div class="media panel-white padding-10 margin-bottom-20">
			<div class="media-body">
			<div class="text-center">
				<img src="<?=base_url('public/img/amblem-advanced.png')?>" width="100" class="margin-top-20" />
				<h4 class="margin-top-30 margin-bottom-30">Advanced Üyelik</h4>
			</div>
				<ul class="clear-list bordered-list">
					<li><i class="fa fa-check fa-fw"></i> Tüm öğrenciler telefonunuzu görebilir</li>
					<li><i class="fa fa-check fa-fw"></i> Destek merkezini kullanabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Sanal para kazanabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Özel web sayfası satın alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Uzman eğitmen rozeti satın alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Doping hizmeti satın alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Profilinize başlık yazabilirsiniz</li>								
					<li><i class="fa fa-check fa-fw"></i> Ücretli hizmetleri %10 indirimli alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Aramalarda kalın gri çizgili çerçeve içerisinde daha kolay farkedilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Aramalarda <strong>starter</strong> grubu eğitmenlerin üstünde yer alırsınız</li>
					<li><i class="fa fa-check fa-fw"></i> Poriflinize tanıtım videosu koyabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Günün, haftanın veya ayın eğitmeni olabilirsiniz</li>
				</ul>	
				
				<div class="panel-heading text-center margin-top-20">
					<?if(!is_buyed(array(30)) && $this->session->userdata('user_ugroup') == 3 && $this->session->userdata('user_allow_trial')):?>
					<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
						<button type="submit" class="btn btn-wide btn-lightred js-submit-btn"><i class="fa fa-hourglass"></i> 14 gün ücretsiz dene</button>
						<button disabled="disabled" class="btn btn-wide btn-lightred hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
						<span class="block margin-top-10 margin-bottom-10 lightgrey-text">veya</span>
						<input type="hidden" name="product_id" value="30" />
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					</form>
					<?endif;?>

					<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
						<select name="product_id" class="form-control margin-bottom-10">
							<option value="1">1 Aylık / <?=$price[1]->price?> TL</option>
							<option value="3">3 Aylık / <?=$price[3]->price?> TL</option>
							<option value="5">6 Aylık / <?=$price[5]->price?> TL</option>
							<option value="7">12 Aylık / <?=$price[7]->price?> TL</option>
						</select>
						<button type="submit" class="btn btn-wide btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
						<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					</form>
				</div>
			</div>
		</div>	
	</div>

	<div class="col-md-12">
		<h2 class="margin-top-40">Premium Üyelik - Çok ayrıcalıklı bir profile sahip olun</h2>
	</div>	
	<div class="col-md-12">
		<div class="media panel-white padding-10 margin-bottom-20">
			<div class="media-body">
				<div class="text-center">
					<img src="<?=base_url('public/img/amblem-premium.png')?>" width="120" class="margin-top-20" />
					<h4 class="margin-top-30 margin-bottom-30">Premium Üyelik</h4>
				</div>

				<ul class="clear-list bordered-list">
					<li><i class="fa fa-check fa-fw"></i> Tüm öğrenciler telefonunuzu görebilir</li>
					<li><i class="fa fa-check fa-fw"></i> Destek merkezini kullanabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Sanal para kazanabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Özel web sayfasına sahip olursunuz</li>
					<li><i class="fa fa-check fa-fw"></i> Uzman eğitmen rozeti satın alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Doping hizmeti satın alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Profilinize başlık yazabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Ücretli hizmetleri %20 indirimli alabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Aramalarda kalın sarı çizgili ve gölgeli çerçeve içerisinde çok kolay farkedilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Aramalarda <strong>starter</strong> ve <strong>advanced</strong> grubu eğitmenlerin üstünde yer alırsınız</li>
					<li><i class="fa fa-check fa-fw"></i> Poriflinize tanıtım videosu koyabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Günün, haftanın veya ayın eğitmeni olabilirsiniz</li>
					<li><i class="fa fa-check fa-fw"></i> Aramalarda öncelikli olan <strong>öne çıkanlar</strong> alanında yer alırsınız</li>
				</ul>	
				
				<div class="panel-heading text-center margin-top-20">
					<?if(!is_buyed(array(31)) && $this->session->userdata('user_ugroup') == 3 && $this->session->userdata('user_allow_trial')):?>
					<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
						<button type="submit" class="btn btn-wide btn-lightred js-submit-btn"><i class="fa fa-hourglass"></i> 14 gün ücretsiz dene</button>
						<button disabled="disabled" class="btn btn-wide btn-lightred hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
						<span class="block margin-top-10 margin-bottom-10 lightgrey-text">veya</span>
						<input type="hidden" name="product_id" value="31" />
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					</form>
					<?endif;?>

					<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
						<select name="product_id" class="form-control margin-bottom-10">
							<option value="2">1 Aylık / <?=$price[2]->price?> TL</option>
							<option value="4">3 Aylık / <?=$price[4]->price?> TL</option>
							<option value="6">6 Aylık / <?=$price[6]->price?> TL</option>
							<option value="8">12 Aylık / <?=$price[8]->price?> TL</option>
						</select>
						<button type="submit" class="btn btn-wide btn-orange js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
						<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					</form>
				</div>		
			</div>
		</div>	
	</div>
	
	</div>
	
	
</div><!--.row-->
<?endif;?>
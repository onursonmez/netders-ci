
<div class="card box-shadow mb-4 d-none">
	<div class="card-body">
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

		</div>
	</div>
</div>


<?if(PAYMENT_SYSTEM == 0):?>
<div class="card box-shadow mb-4">
	<div class="card-body">
		Bilgi: Ücretli üyelik ve hizmetler, ödeme sistemi istemcisi güncellemeleri nedeniyle, geliştirme süreci tamamlanana kadar inaktif edilmiştir.
	</div>
</div>
<?endif;?>

<?if(PAYMENT_SYSTEM == 1 && $this->session->userdata('user_status') == 'A'):?>
<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Hizmetler - Profilinizi ziyaret eden öğrenci sayısını arttırın</h4>
	</div>
	<div class="card-body">

		<div class="row">

			<?if($this->session->userdata('user_service_badge') == 'N'):?>
				<div class="col-md-12">
					<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
						<div class="media media-list">
							<a href="#">
								<img src="<?=base_url('public/img/uzman-egitmen-rozeti.png')?>" width="100%" class="mr-3 photo" />
							</a>					
							<div class="media-body">
								<h4 class="media-heading">Uzman Eğitmen Rozeti</h4>

								<div class="mt-2 mb-2">
									<h5>
										<span class="badge badge-secondary">
										<?if($this->session->userdata('user_ugroup') == 3):?>
											<?if($price[11]->price > 0):?><?=$price[11]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?elseif($this->session->userdata('user_ugroup') == 4):?>
											<?if($price[12]->price > 0):?><?=$price[12]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?elseif($this->session->userdata('user_ugroup') == 5):?>
											<?if($price[13]->price > 0):?><?=$price[13]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?endif;?>
										</span>
									</h5>
								</div>

								<p>Uzman eğitmen rozeti alan eğitmenler aramalarda ayrıcalıklandırılır. Arama sonuçlarında ve profil detay sayfalarında "Uzman Eğitmen Rozeti" bulunur ve açıklamasında "Eğitmenin uzmanlığı belgelerle doğrulanmıştır" bilgisi yer alır.</p>
								<p class="text-muted">Uzman eğitmen rozeti bir defa satın alınır ve ömür boyu kullanılır.</p>
								
								<div class="mt-2 mb-2">
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






			<?if(($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4)):?>
			<div class="col-md-12">
				<hr />
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media media-list">
						<a href="#">
							<img src="<?=base_url('public/img/dikkat-ceken-egitmenler.png')?>" width="100%" class="mr-3 photo" />
						</a>
						<div class="media-body">
							<h4 class="media-heading">Öne Çıkanlar</h4>

							<div class="mt-2 mb-2">
								<h5>
									<span class="badge badge-secondary">
										<?if($this->session->userdata('user_ugroup') == 3):?>
											<?if($price[9]->price > 0):?><?=$price[9]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?elseif($this->session->userdata('user_ugroup') == 4):?>
											<?if($price[10]->price > 0):?><?=$price[10]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?endif;?>
									</span>
								</h5>
							</div>

							<p>Öne Çıkanlar hizmeti alarak bir hafta boyunca arama sonuçlarında öncelikli olan "Öne Çıkan Eğitmenler" arasında yer alırsınız. Arama sonuçlarında öğrenciler öncelikli olarak sizin profilinizi görür ve daha fazla öğrenciye özel ders verme imkanına sahip olursunuz.</p>
							<p class="text-muted">Öne Çıkanlar hizmetinin süresi 1 haftadır.</p>
							
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
				<hr />
				<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
					<div class="media media-list">
						<a href="#">
							<img src="<?=base_url('public/img/siralama-dopingi-ozelligi.png')?>" width="100%" class="mr-3 photo" />
						</a>							
						<div class="media-body">
							<h4 class="media-heading">Haftalık Doping</h4>

							<div class="mt-2 mb-2">
								<h5>
									<span class="badge badge-secondary">
									<?if($this->session->userdata('user_ugroup') == 3):?>
										<?if($price[14]->price > 0):?><?=$price[14]->price?> TL<?else:?>Ücretsiz<?endif;?>
									<?elseif($this->session->userdata('user_ugroup') == 4):?>
										<?if($price[15]->price > 0):?><?=$price[15]->price?> TL<?else:?>Ücretsiz<?endif;?>
									<?elseif($this->session->userdata('user_ugroup') == 5):?>
										<?if($price[16]->price > 0):?><?=$price[16]->price?> TL<?else:?>Ücretsiz<?endif;?>						
									<?endif;?>
									</span>
								</h5>
							</div>	

							<p>Haftalık doping hizmeti alarak profilinizin arama sonuçlarında bir hafta boyunca grubunun en üstünde yer alması sağlanır.</p>
							<p class="text-muted">Haftalık doping hizmetinin süresi 1 haftadır.</p>	

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
					<hr />
					<form method="POST" action="<?=site_url('services/buy')?>" class="ajax-form js-dont-reset">
						<div class="media media-list">
							<a href="#">
								<img src="<?=base_url('public/img/siralama-dopingi-ozelligi.png')?>" width="100%" class="mr-3 photo" />
							</a>
							<div class="media-body">
								<h4 class="media-heading">Aylık Doping</h4>
								
								<div class="mt-2 mb-2">
								<h5>
									<span class="badge badge-secondary">
										<?if($this->session->userdata('user_ugroup') == 3):?>
											<?if($price[17]->price > 0):?><?=$price[17]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?elseif($this->session->userdata('user_ugroup') == 4):?>
											<?if($price[18]->price > 0):?><?=$price[18]->price?> TL<?else:?>Ücretsiz<?endif;?>
										<?elseif($this->session->userdata('user_ugroup') == 5):?>
											<?if($price[19]->price > 0):?><?=$price[19]->price?> TL<?else:?>Ücretsiz<?endif;?>						
										<?endif;?>
									</span>
									</h5>
								</div>									
								
								<p>Aylık doping hizmeti alarak profilinizin arama sonuçlarında bir ay boyunca grubunun en üstünde yer alması sağlanır.</p>
								<p class="text-muted">Aylık doping hizmetinin süresi 1 aydır.</p>
								
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
			
		</div>
	</div>
</div>

<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Ücretli Üyelikler - Ayrıcalıklı bir profile sahip olun</h4>
	</div>
	<div class="card-body">

		<div class="row">



			<div class="col-md-12">
				<div class="media panel-white padding-10 margin-bottom-20">
					<div class="media-body">
						<div class="text-center">
							<img src="<?=base_url('public/img/amblem-advanced.png')?>" width="100" class="margin-top-20" />
							<h4 class="margin-top-30 margin-bottom-30">Advanced Üyelik</h4>
						</div>
						
						<ul class="list-group list-group-flush">
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Tüm öğrenciler telefonunuzu görebilir</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Destek merkezini kullanabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Sanal para kazanabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Özel web sayfası satın alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Uzman eğitmen rozeti satın alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Doping hizmeti satın alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Profilinize başlık yazabilirsiniz</li>								
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Ücretli hizmetleri %10 indirimli alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Aramalarda kalın gri çizgili çerçeve içerisinde daha kolay farkedilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Aramalarda <strong>starter</strong> grubu eğitmenlerin üstünde yer alırsınız</li>
						</ul>	

						<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
							<div class="form-row">
								<div class="form-group col-md-3">
									<select name="product_id" class="form-control mt-3 mb-2">
										<option value="1">1 Aylık / <?=$price[1]->price?> TL</option>
										<option value="3">3 Aylık / <?=$price[3]->price?> TL</option>
										<option value="5">6 Aylık / <?=$price[5]->price?> TL</option>
										<option value="7">12 Aylık / <?=$price[7]->price?> TL</option>
									</select>
								</div>
								<div class="form-group col-md-12">
									<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
								</div>
							</div>
							
							<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						</form>
					</div>
				</div>	
			</div>







			<div class="col-md-12">
				<hr />
				<div class="media panel-white padding-10 margin-bottom-20">
					<div class="media-body">
						<div class="text-center">
							<img src="<?=base_url('public/img/amblem-premium.png')?>" width="120" class="margin-top-20" />
							<h4 class="margin-top-30 margin-bottom-30">Premium Üyelik</h4>
						</div>

						<ul class="list-group list-group-flush">
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Tüm öğrenciler telefonunuzu görebilir</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Destek merkezini kullanabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Sanal para kazanabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Özel web sayfasına sahip olursunuz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Uzman eğitmen rozeti satın alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Doping hizmeti satın alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Profilinize başlık yazabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Ücretli hizmetleri %20 indirimli alabilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Aramalarda kalın sarı çizgili ve gölgeli çerçeve içerisinde çok kolay farkedilirsiniz</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Aramalarda <strong>starter</strong> ve <strong>advanced</strong> grubu eğitmenlerin üstünde yer alırsınız</li>
							<li class="list-group-item"><img class="align-middle" src="<?=base_url('public/img/messaging-checked-small.svg')?>" width="14" height="14"> Aramalarda öncelikli olan <strong>öne çıkanlar</strong> alanında yer alırsınız</li>
						</ul>	
						
						<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
						<div class="form-row">
							<div class="form-group col-md-3">						
								<select name="product_id" class="form-control mt-3 mb-2">
									<option value="2">1 Aylık / <?=$price[2]->price?> TL</option>
									<option value="4">3 Aylık / <?=$price[4]->price?> TL</option>
									<option value="6">6 Aylık / <?=$price[6]->price?> TL</option>
									<option value="8">12 Aylık / <?=$price[8]->price?> TL</option>
								</select>
							</div>
							<div class="form-group col-md-12">						
								<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							</div>
							<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						</form>
					</div>
				</div>	
			</div>			




		</div>
	</div>
</div>
<?endif;?>


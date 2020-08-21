<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2>Üyelik Satınalma</h2>
		<p>Aşağıdaki ücretli üyeliklerden satın alarak daha fazla görünür olabilir ve daha fazla öğrenciye ulaşarak kazancınızı katlayabilirsiniz.</p>	

		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-white">
					<div class="panel-heading text-center">
						<img src="<?=base_url('public/img/amblem-starter.png')?>" width="100" class="margin-top-10 margin-bottom-10" />
						<h4>Starter Üyelik</h4>
					</div>
					<div class="card-body">
						<ul class="clear-list bordered-list">
							<li><i class="fa fa-check fa-fw"></i> Yalnızca üye öğrenciler telefonunuzu görebilir</li>
							<li><i class="fa fa-check fa-fw"></i> Destek merkezini kullanabilirsiniz</li>
							<li><i class="fa fa-check fa-fw"></i> Kısıtlı sanal para kazanabilirsiniz</li>
							<li><i class="fa fa-check fa-fw"></i> Özel web sayfası satın alabilirsiniz</li>
							<li><i class="fa fa-check fa-fw"></i> Uzman eğitmen rozeti satın alabilirsiniz</li>
							<li><i class="fa fa-check fa-fw"></i> Doping hizmeti satın alabilirsiniz</li>
							<li><i class="fa fa-check fa-fw"></i> Profilinize başlık yazabilirsiniz</li>							
						</ul>
					</div>
					<div class="panel-heading text-center">
						<strong>Ücretsiz</strong>
					</div>					
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white">
					<div class="panel-heading text-center">
						<img src="<?=base_url('public/img/amblem-advanced.png')?>" width="100" class="margin-top-10 margin-bottom-10" />
						<h4>Advanced Üyelik</h4>
					</div>
					<div class="card-body">
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
					</div>
					<div class="panel-heading text-center">
						<?if(!is_buyed(array(30)) && $this->session->userdata('user_ugroup') == 3 && $this->session->userdata('user_allow_trial')):?>
						<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
							<button type="submit" class="btn btn-wide btn-lightred js-submit-btn"><i class="fa fa-hourglass"></i> 14 gün ücretsiz dene</button>
							<button disabled="disabled" class="btn btn-wide btn-lightred hide js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
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
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-white">
					<div class="panel-heading text-center">
						<img src="<?=base_url('public/img/amblem-premium.png')?>" width="100" class="margin-top-10 margin-bottom-10" />
						<h4>Premium Üyelik</h4>
					</div>					
					<div class="card-body">
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
					</div>
					<div class="panel-heading text-center">
						<?if(!is_buyed(array(31)) && $this->session->userdata('user_ugroup') == 3 && $this->session->userdata('user_allow_trial')):?>
						<form method="POST" action="<?=site_url('memberships/buy')?>" class="ajax-form js-dont-reset">
							<button type="submit" class="btn btn-wide btn-lightred js-submit-btn"><i class="fa fa-hourglass"></i> 14 gün ücretsiz dene</button>
							<button disabled="disabled" class="btn btn-wide btn-lightred hide js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
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
							<button type="submit" class="btn btn-primary js-submit-btn"><i class="fa fa-shopping-cart"></i> Satın Al</button>
							<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						</form>
					</div>					
				</div>				
			</div>
		</div>
		
		<div class="text-center">
			<a href="<?=site_url('services')?>"><i class="fa fa-rocket"></i> Hizmetlerimizi de incelemek isterseniz buraya tıklayınız</a>
		</div>
		
		
		
	</div>
</section>
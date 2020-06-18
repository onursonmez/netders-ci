<?if($this->router->fetch_class() != 'messages'):?>
   <section class="dark-header">
   		<div class="container">
		    <div class="row">
		    	<div class="col-lg-12 text-center">
			    	<img alt="Netders.com" src="<?=base_url($GLOBALS['settings_site']->logo)?>" width="185" height="50" />
		    	</div>
			    <div class="col-lg-12 text-center margin-top-30">
					<p class="lead text-center font-size-24 font-light">Eğitim fırsatları e-posta adresinize gelsin</p>
			    </div>
			    <form  action="<?=site_url('contents/newsletter_subscription')?>" method="post" class="ajax-form margin-top-20">
				    <div class="col-xs-8 col-sm-6 col-md-6 col-lg-6 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
				    	<input type="email" name="email" class="form-control big-input" placeholder="E-posta adresiniz" />
				    </div>
				    <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
				    	<button type="submit" class="form-control big-button btn-lightred-outline js-submit-btn">Katıl</button>
				    	<button disabled="disabled" class="form-control big-button btn-lightred hide js-loader"><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i></button>
				    </div>
				    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			    </form>
		    </div>
   		</div>
    </section>

    <hr class="dark no-margin" />

    <section class="dark-header footer text-xs-center">
	    <div class="container">
		    <div class="row">
		    	<div class="col-sm-4 col-md-3 margin-top-20">
			    	<h3>Sayfalar</h3>
			    	<ul>
				    	<li><a href="<?=_make_link('contents', 1)?>">Hakkımızda</a></li>
				    	<li><a href="<?=_make_link('contents_categories', 570)?>">Haberler</a></li>
				    	<li><a href="<?=_make_link('contents_categories', 631)?>">Özel Ders</a></li>
				    	<li><a href="<?=_make_link('contents_categories', 2)?>">Yardım</a></li>
				    	<li><a href="<?=_make_link('contents', 37)?>">İletişim</a></li>
				    	<li><a href="<?=_make_link('contents', 14)?>">Kullanım Koşulları</a></li>
				    	<li><a href="<?=_make_link('contents', 38)?>">Gizlilik İlkeleri</a></li>
			    	</ul>
		    	</div>
			    <div class="col-sm-4 col-md-3 margin-top-20">
			    	<h3>Araçlar</h3>
			    	<ul>
				    	<li><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>">Ders almak istiyorum</a></li>
				    	<li><a href="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>">Ders vermek istiyorum</a></li>
			    	</ul>
			    </div>
			    <div class="col-sm-4 col-md-3 margin-top-20">
			    	<h3>Hesap</h3>
			    	<ul>
				    	<li><a href="<?=site_url('giris')?>">Giriş yapın</a></li>
				    	<li><a href="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>">Ücretsiz üye olun</a></li>
			    	</ul>
			    </div>
			    <div class="col-sm-12 col-md-3 margin-top-20">
			    	<a href="https://www.facebook.com/netderscom" target="_blank"><i class="fa fa-facebook"></i></a>
			    	<a href="https://www.twitter.com/netderscom" target="_blank"><i class="fa fa-twitter"></i></a>
			    	<a href="https://plus.google.com/u/0/117577151266064180719/posts" target="_blank"><i class="fa fa-google-plus"></i></a>
			    	<div class="clearfix"></div>
			    	<span class="font-size-24 bold">+90 212 909 45 47</span>
			    	<div class="clearfix"></div>
			    	<span class="font-size-12">Pzt - Cum / 09:00 - 17:00</span>
			    	<div class="clearfix"></div>
			    	<span class="font-size-12">Sorunuz mu var? <a href="#"><img src="<?=site_url('public/img/ndm.png')?>" width="120" height="11" /></a></span>
			    </div>
		    </div>
	    </div>
    </section>

   <hr class="dark no-margin" />

	<section class="dark-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 text-center font-size-12 grey-text">
					<p>Netders.com internet üzerinden eğitmenler ile öğrencileri buluşturarak online eğitim imkanı sunan bir internet sitesidir. Herhangi bir kurum ile bağı yoktur.</p>
					<p>Netders.com'a üye olarak <a href="#" data-toggle="modal" data-target="#terms-txt">Kullanım sözleşmesi</a>'ni kabul etmiş sayılırsınız.</p>
					<p class="font-size-14">© 2013 - <?=date('Y', time())?> Netders.com | Tüm hakları saklıdır. | {elapsed_time}</p>
					<p>Netders.com Saati: <?=strftime("%d %B %Y %H:%M", time())?></p>
					<p><img src="<?=base_url('public/img/visa-master.png')?>" width="100" height="30" /></p>
				</div>
			</div>
		</div>
	</section>
	</div>
<?endif;?>
	<!-- Modal Terms -->
	<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="termsLabel">Kullanım Sözleşmesi</h4>
	      </div>
	      <div class="modal-body">
	        <?
	        	$content = content(14);
	        	echo $content->description;
	        ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal Expert Terms -->
	<div class="modal fade" id="expert-terms-txt" tabindex="-1" role="dialog" aria-labelledby="expertTermsLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h4 class="modal-title" id="expertTermsLabel">Uzman Eğitmen Rozeti Şartları</h4>
	      </div>
	      <div class="modal-body">
	        <?
	        	$content = content(39);
	        	echo $content->description;
	        ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<nav id="navbar">
		<ul>
			<li><a href="<?=site_url()?>"><i class="fa fa-home fa-fw yellow-text"></i> Ana Sayfa</a></li>
			<li><a href="<?=_make_link('contents', 1)?>"><i class="fa fa-lightbulb-o fa-fw yellow-text"></i> Biz Kimiz?</a></li>
			<li><a href="<?=_make_link('contents_categories', 570)?>"><i class="fa fa-newspaper-o fa-fw yellow-text"></i> Haberler</a></li>
			<li>
				<span><a href="#"><i class="fa fa-support fa-fw yellow-text"></i> Destek</a></span>
				<ul>
					<li><a href="<?=_make_link('contents_categories', 2)?>"><i class="fa fa-question-circle-o fa-fw yellow-text"></i> Yardım Merkezi</a></li>
					<li><a href="<?=_make_link('contents', 37)?>"><i class="fa fa-envelope fa-fw yellow-text"></i> İletişim</a></li>
				</ul>
			</li>
			<?if($this->session->userdata('user_id')):?>
				<li>
					<span><i class="fa fa-user fa-fw yellow-text"></i> <?=$this->session->userdata('user_firstname')?> <?=$this->session->userdata('user_lastname')?></span>
					<ul>
						<li><a href="<?=site_url('users/my')?>"><i class="fa fa-fax fa-fw yellow-text"></i> İletişim Bilgileri</a></li>
						<?if(is_teacher()):?>
							<li><a href="<?=site_url('users/education')?>"><i class="fa fa-graduation-cap fa-fw yellow-text"></i> Eğitim Bilgileri</a></li>
							<li><a href="<?=site_url('users/informations')?>"><i class="fa fa-file-text-o fa-fw yellow-text"></i> Tanıtım Yazıları</a></li>
							<li><a href="<?=site_url('users/preferences')?>"><i class="fa fa-wrench fa-fw yellow-text"></i> Tercihler</a></li>
							<li><a href="<?=site_url('users/prices')?>"><i class="fa fa-tags fa-fw yellow-text"></i> Ders Ücretleri</a></li>
							<li><a href="<?=site_url('users/locations')?>"><i class="fa fa-globe fa-fw yellow-text"></i> Ders Verilen Bölgeler</a></li>

							<?if($this->session->userdata('user_status') == 'A'):?>
								<li><a href="<?=site_url('users/memberships')?>"><i class="fa fa-star fa-fw yellow-text"></i> Üyelik İşlemleri</a></li>
								<li><a href="<?=site_url('users/activities')?>"><i class="fa fa-tasks fa-fw yellow-text"></i> Hesap Hareketleri</a></li>
								<li><a href="<?=site_url('users/discounts')?>"><i class="fa fa-percent fa-fw yellow-text"></i> İndirimler</a></li>
								<?if($this->session->userdata('user_ugroup') == 5 || $this->session->userdata('user_service_web') == 'Y'):?>
									<li><a href="<?=site_url('users/web')?>"><i class="fa fa-anchor fa-fw yellow-text"></i> Özel Web Sayfası Ayarları</a></li>
								<?endif;?>
								<!--<li><a href="<?=site_url('users/live')?>"><i class="fa fa-laptop fa-fw yellow-text"></i> Canlı Ders Ver</a></li>-->
							<?endif;?>
						<?else:?>
							<li><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>"><i class="fa fa-search fa-fw yellow-text"></i> Eğitmen Ara</a></li>
						<?endif;?>
						<!--
						<?if($this->session->userdata('user_status') == 'A'):?>
							<li><a href="#">Mesajlar</a></li>
						<?endif;?>
						-->
						<li><a href="<?=site_url('messages')?>"><i class="fa fa-comments fa-fw yellow-text"></i> Mesajlar</a></li>
						<li><a href="<?=site_url('users/passwordchange')?>"><i class="fa fa-key fa-fw yellow-text"></i> Şifre Değiştir</a></li>
						<li><a href="<?=site_url('users/logout')?>"><i class="fa fa-unlock fa-fw yellow-text"></i> Güvenli Çıkış</a></li>
					</ul>
				</li>
				<?$check_cart = check_cart();?>
				<?if(!empty($check_cart)):?>
				<li><a href="<?=site_url('services/cart')?>"><i class="fa fa-shopping-basket fa-fw yellow-text"></i> Alışveriş Sepeti <span class="badge"><?=$check_cart?></span></a></li>
				<?endif;?>
			<?else:?>
				<li><a href="<?=site_url('giris')?>"><i class="fa fa-lock fa-fw yellow-text"></i> Giriş Yapın</a></li>
				<li><a href="<?=site_url('kayit')?>"><i class="fa fa-shopping-basket fa-fw yellow-text"></i> Ücretsiz Üye Olun</a></li>
				<li><a href="<?=site_url('sifremi-unuttum')?>"><i class="fa fa-low-vision fa-fw yellow-text"></i> Şifremi Unuttum</a></li>
				<li><a href="<?=site_url('aktivasyon')?>"><i class="fa fa-at fa-fw yellow-text"></i> E-posta Aktivasyonu</a></li>
			<?endif;?>

			<li><a href="<?=_make_link('contents', 14)?>"><i class="fa fa-file-text-o fa-fw yellow-text"></i> Kullanım Koşulları</a></li>
			<li><a href="<?=_make_link('contents', 38)?>"><i class="fa fa-file-text-o fa-fw yellow-text"></i> Gizlilik İlkeleri</a></li>
		</ul>
	</nav>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=v2.4&appId=1590771401140056";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
  </script>

	</div><!--.wrapper-->

  </body>
</html>

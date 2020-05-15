<?=render_page('top')?>

<section class="margin-top-30 margin-bottom-30">
	<div class="container">	
		<div class="row">
			<div class="col-md-3 hidden-xs hidden-sm">
				
				<?if($this->session->userdata('user_status') == 'A' && is_teacher()):?>
				<div class="alert alert-info">
					<p><a href="<?=site_url($this->session->userdata('user_username'))?>" target="_blank"><i class="fa fa-eye fa-fw"></i> Profilim nasıl görünüyor?</a></p>
				</div>
				<?endif;?>					
								
				<ul class="dark-nav">
					<li><a href="<?=site_url('users/personal')?>"<?if(current_url() == site_url('users/personal')):?> class="active"<?endif;?>><i class="fa fa-user fa-fw"></i> İletişim Bilgileri</a></li>
					<?if(is_teacher()):?>
						<li><a href="<?=site_url('users/education')?>"<?if(current_url() == site_url('users/education')):?> class="active"<?endif;?>><i class="fa fa-university fa-fw"></i> Eğitim Bilgileri</a></li>
						<li><a href="<?=site_url('users/informations')?>"<?if(current_url() == site_url('users/informations')):?> class="active"<?endif;?>><i class="fa fa-file-text-o fa-fw"></i> Tanıtım Yazıları</a></li>
						<li><a href="<?=site_url('users/preferences')?>"<?if(current_url() == site_url('users/preferences')):?> class="active"<?endif;?>><i class="fa fa-cog fa-fw"></i> Tercihler</a></li>
						<li><a href="<?=site_url('users/prices')?>"<?if(current_url() == site_url('users/prices')):?> class="active"<?endif;?>><i class="fa fa-money fa-fw"></i> Ders Ücretleri</a></li>
						<li><a href="<?=site_url('users/locations')?>"<?if(current_url() == site_url('users/locations')):?> class="active"<?endif;?>><i class="fa fa-globe fa-fw"></i> Ders Verilen Bölgeler</a></li>
						<?if($this->session->userdata('user_status') == 'A'):?>
							<!--
							<li><a href="<?=site_url('users/calendar')?>"<?if(current_url() == site_url('users/calendar')):?> class="active"<?endif;?>><i class="fa fa-calendar-o fa-fw"></i> Haftalık Müsaitlik</a></li>
							-->
							<li><a href="<?=site_url('users/discounts')?>"<?if(current_url() == site_url('users/discounts')):?> class="active"<?endif;?>><i class="fa fa-percent fa-fw"></i> İndirimler</a></li>
							<li><a href="<?=site_url('users/memberships')?>"<?if(current_url() == site_url('users/memberships')):?> class="active"<?endif;?>><i class="fa fa-rocket fa-fw"></i> Üyelik İşlemleri</a></li>			
							<li><a href="<?=site_url('users/activities')?>"<?if(current_url() == site_url('users/activities')):?> class="active"<?endif;?>><i class="fa fa-calculator fa-fw"></i> Hesap Hareketleri</a></li>			
							<?if($this->session->userdata('user_ugroup') == 5 || $this->session->userdata('user_service_web') == 'Y'):?>
							<li><a href="<?=site_url('users/web')?>"<?if(current_url() == site_url('users/web')):?> class="active"<?endif;?>><i class="fa fa-anchor fa-fw"></i> Özel Web Sayfası Ayarları</a></li>
							<?endif;?>
							<!--
							<li><a href="<?=site_url('users/earn')?>"<?if(current_url() == site_url('users/earn')):?> class="active"<?endif;?>><i class="fa fa-gift fa-fw"></i> Sanal Para Kazan</a></li>
							<li class="clearfix"><a class="pull-left" href="<?=site_url('users/live')?>"<?if(current_url() == site_url('users/live')):?> class="active"<?endif;?>><i class="fa fa-laptop fa-fw"></i> Canlı Ders Ver</a> <img src="<?=base_url('public/img/yeni.png')?>" width="24" class="pull-right margin-top-5" /></li>													
							-->
						<?endif;?>
					<?else:?>						
						<li><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>"><i class="fa fa-search fa-fw"></i> Eğitmen Ara</a></li>
					<?endif;?>
					<li><a href="<?=site_url('messages')?>"<?if(current_url() == site_url('messages')):?> class="active"<?endif;?>><i class="fa fa-comments fa-fw"></i> Mesajlar</a></li>
					<li><a href="<?=site_url('users/passwordchange')?>"<?if(current_url() == site_url('users/passwordchange')):?> class="active"<?endif;?>><i class="fa fa-key fa-fw"></i> Şifre Değiştir</a></li>
					<li><a href="<?=site_url('users/logout')?>"<?if(current_url() == site_url('users/logout')):?> class="active"<?endif;?>><i class="fa fa-lock fa-fw"></i> Güvenli Çıkış</a></li>
				</ul>	
				
				
				<?$user_money = user_money($this->session->userdata('user_id'))?>
				<?if($user_money > 0 && PAYMENT_SYSTEM == 1):?>
				<div class="alert alert-info">
					<p class="font-size-13"><i class="fa fa-gift"></i> Hesabınızda hizmet satın almak için kullanabileceğiniz <strong><?=mtp($user_money)?></strong> TL karşılığı <strong><?=format_money($user_money)?></strong> sanal para bulunmaktadır.<br /><a href="<?=site_url('services')?>">Hizmet satın almak için tıklayınız.</a></p>
				</div>
				<?endif;?>	
															
			</div>
			
			<div class="col-md-9 col-xs-12">

				<?if($this->session->userdata('user_status') == 'A' && is_teacher() && $this->session->userdata('user_email_request')):?>
				<div class="alert alert-warning">
					<p>E-posta adresinizi aktive etmediğiniz için profiliniz arama sonuçlarında görünmüyor.</p>
					<p><a href="<?=site_url('users/emailchange')?>">E-posta aktivasyon işlemleri &raquo;</a></p>
				</div>
				<?endif;?>									

				<?if($this->session->userdata('user_status') == 'R' && required_profile_fields()):?>
				<div class="alert alert-warning">
					<p>[UYARI] Profiliniz arama sonuçlarında görünmüyor!</p>
					<p><a class="btn btn-lightred" href="<?=site_url('users/required')?>">Nedenini öğrenmek için buraya tıklayın &raquo;</a></p>
				</div>
				<?endif;?>
				
				<?if($this->session->userdata('user_status') == 'R' && !required_profile_fields()):?>
				<div class="alert alert-info">
					<p>[UYARI] Profilinizin arama sonuçlarında görünebilmesi için incelemeye gönderiniz.</p>
					<p><a class="btn btn-lightred" href="<?=site_url('users/personal?approval=1')?>" class="js-click-on-loading">Profilimi incelemeye gönder &raquo;</a></p>
				</div>
				<?endif;?>
				
				<?if($this->session->userdata('user_status') == 'S'):?>
				<div class="alert alert-info">
					<p><i class="fa fa-hourglass fa-pulse fa-fw"></i> Profiliniz incelenme aşamasındadır. İncelenme tamamlandıktan sonra e-posta ile bilgilendirileceksiniz.</p>
				</div>
				<?endif;?>

				<?if($this->session->userdata('user_status') == 'A' && is_teacher() && check_lesson_text() && $this->router->fetch_method() != 'prices_text'):?>
				<div class="alert alert-warning">
					<p>[UYARI] Verdiğiniz dersler için tanıtım yapmadınız.</p>
					<p><a href="<?=site_url('users/prices')?>">Ders tanıtımı için buraya tıklayınız &raquo;</a></p>
				</div>
				<?endif;?>				
							
				<?=$viewPage?>
			</div>
		</div>
	</div>
</section>

<?=render_page('bottom')?>
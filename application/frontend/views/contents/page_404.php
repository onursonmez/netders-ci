<div style="background-color:#f5f5f5;">
	<div class="container" style="padding-top: 40px; padding-bottom:40px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="col-md-7">
					<h1 class="page_404_big_title">Oops!</h1>
					<p class="page_404_large_title">Görüntülemeye çalıştığınız sayfayı tüm uğraşlarımıza rağmen bulamadık.</p>
					<p class="page_404_title">Hata kodu: 404</p>
					<p class="page_404_text">Aşağıdaki bağlantılar belki yardımcı olabilir:</p>
					<ul>
						<li><a href="<?=site_url()?>">Ana Sayfa</a></li>
						<li><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>">Eğitmen ara</a></li>
						<li><a href="<?=_make_link('contents_categories', 2)?>">Yardım</a></li>
						<li><a href="<?=site_url('kayit')?>">Üye ol</a></li>
						<li><a href="<?=site_url('giris')?>">Giriş yap</a></li>
						<li><a href="<?=_make_link('contents', 37)?>">İletişim</a></li>
					</ul>
				</div>
				<div class="col-md-5">
					<img src="<?=base_url('public/img/404.gif')?>" />
				</div>
			</div>
		</div>
	</div>
</div>
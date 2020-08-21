
	<div class="container">

		<div class="card mt-4 box-shadow rounded-top" style="background-color:#f5f5f5">
			<div class="card-body">
				<div class="row">
						<div class="col-lg-6">
							<h1>Oops!</h1>
							<p>Görüntülemeye çalıştığınız sayfayı tüm uğraşlarımıza rağmen bulamadık.</p>
							<p>Hata kodu: 404</p>
							<p>Aşağıdaki bağlantılar belki yardımcı olabilir:</p>
							<ul>
								<li><a href="<?=site_url()?>">Ana Sayfa</a></li>
								<li><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>">Eğitmen ara</a></li>
								<li><a href="<?=_make_link('contents_categories', 2)?>">Yardım</a></li>
								<li><a href="<?=site_url('kayit')?>">Üye ol</a></li>
								<li><a href="<?=site_url('giris')?>">Giriş yap</a></li>
								<li><a href="<?=_make_link('contents', 37)?>">İletişim</a></li>
							</ul>
						</div>
						<div class="col-lg-6">
							<img src="<?=base_url('public/img/404.gif')?>" />
						</div>
				</div>
			</div>
		</div>


	</div>

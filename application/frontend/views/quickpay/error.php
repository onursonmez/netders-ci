<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<div class="row">

			<div class="col-md-3">
				<img src="<?=base_url('public/img/netman-uzgun.png')?>" width="100%" />
			</div>
			<div class="col-md-9">
				<h2 class="margin-bottom-20">Üzgünüz, Siparişiniz Tamamlanamadı</h2>
				<p><h3><span class="label label-default">Hata mesajı: <?=$this->input->get('message', true)?></span></h3></p>
				<p>Yaptığınız ödemeler, güvenliğiniz için, ödeme istemcisi tarafından 150 hile kontrol mekanizmasından geçip onaylanmaktadır. Bu kontrol mekanizmasına takılan ödemeler başarı ile sonuçlanamamaktadır.</p>
				<p>Yukarıda yer alan hata mesajı ne yapmanız gerektiği ile ilgili size fikir verebilir.</p>
				<p>Ne yapmanız gerektiğini bilmiyorsanız lütfen <a href="<?=_make_link('contents', 37)?>" target="_blank">buraya tıklayarak (yeni sayfada açılır)</a> online iletişim formu aracılığı ile veya doğrudan telefon numaralarımızı arayıp bize ulaşarak beraber bir çözüm üretmemizi sağlayabilirsiniz.</p>
				<p>Hatanın nedenini biliyorsanız lütfen tekrar denemek için aşağıdaki butona tıklayınız.</p>
				<a href="<?=site_url('quickpay')?>" class="btn btn-orange">Tekrar deneyin</a>
			</div>
		</div>
	</div>
</section>
<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<div class="row">

			<div class="col-md-4">
				<img src="<?=base_url('public/img/is-birligi.png')?>" width="100%" />
			</div>
			<div class="col-md-8">
				<h2 class="margin-bottom-20">Teşekkürler! Siparişiniz Başarıyla Alınmıştır</h2>
				<?if($this->input->get('order')):?>
				<p><h3 class="margin-bottom-30"><span class="label label-default">Sipariş Numaranız: #<?=(int)$this->input->get('order', true)?></span></h3></p>
				<?endif;?>
				<p>Siparişleriniz gerekli incelemelerin tamamlanmasının ardından ortalama 15 dakika içerisinde hesabınıza tanımlanacaktır.</p>
				<p>Ödeme istemcisi tarafından verilen tüm siparişler güvenliğiniz için 150 hile kontrol mekanizmasından geçip onaylanmaktadır. Herhangi bir nedenden dolayı siparişiniz bu aşamalardan birinde takılırsa müşteri temsilcilerimiz konu ile ilgili bilgi vermek amacıyla sizi arayacaktır.</p>
				<p>Siparişlerinizle ilgili sorularınız için <a href="<?=_make_link('contents', 37)?>" target="_blank">buraya tıklayarak (yeni sayfada açılır)</a> online iletişim formu aracılığı ile veya doğrudan telefon numaralarımızı arayarak bize ulaşabilirsiniz.</p>
				<p>Sipariş numarasını kaydetmenize gerek yoktur. Siparişinizin bir kopyası e-posta adresinize gönderilecektir. Ayrıca verdiğiniz tüm siparişlere kontrol panelinizdeki <a href="<?=site_url('users/activities')?>">hesap hareketleri</a> bölümünden ulaşabilirsiniz.</p>
				<p>Daha çok öğrenciye ulaşmanızı sağlayacak hizmetlerimizi incelediniz mi? Hemen <a href="<?=site_url('services')?>">buraya</a> tıklayarak inceleyebilirsiniz.</p>
				<a href="<?=site_url('users/my')?>" class="btn btn-orange">Hesabıma git</a>
			</div>
		</div>
	</div>
</section>
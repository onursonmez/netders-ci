<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<div class="row">

			<div class="col-md-4">
				<img src="<?=base_url('public/img/is-birligi.png')?>" width="100%" />
			</div>
			<div class="col-md-8">
				<h2 class="margin-bottom-20">Teşekkürler! Ödemeniz Başarıyla Alınmıştır</h2>
				<?if($this->input->get('order')):?>
				<p><h3 class="margin-bottom-30"><span class="label label-default">Ödeme Alındı Numaranız: #<?=(int)$this->input->get('order', true)?></span></h3></p>
				<?endif;?>
				<p>Ödeme istemcisi tarafından yapılan tüm ödemeler güvenliğiniz için 150 hile kontrol mekanizmasından geçip onaylanmaktadır. Herhangi bir nedenden dolayı ödemeniz bu aşamalardan birinde takılırsa müşteri temsilcilerimiz konu ile ilgili bilgi vermek amacıyla sizi arayacaktır.</p>
				<p>Ödemenizle ilgili sorularınız için <a href="<?=_make_link('contents', 37)?>" target="_blank">buraya tıklayarak (yeni sayfada açılır)</a> online iletişim formu aracılığı ile veya doğrudan telefon numaralarımızı arayarak bize ulaşabilirsiniz.</p>
				<p>Sipariş numarasını kaydetmenize gerek yoktur. Yalnızca bilgi amaçlıdır.</p>
			</div>
		</div>
	</div>
</section>
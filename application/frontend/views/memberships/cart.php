<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2>Üyelik Satınalma</h2>

		<div class="row">
			<div class="col-md-12">
				
					<div class="table-responsive">
						<table class="table table-bordered table-white">
							<thead>
								<tr>
									<th width="300">Ürün Adı</th>
									<th>Açıklama</th>
									<th width="120">Ürün Ücreti</th>
									<th width="120" class="text-right">İşlemler</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?=$order->title?></td>
									<td><?=$order->description?></td>
									<td><?=$order->price?> TL</td>
									<td align="right"><a href="<?=site_url('memberships/cart?delete='.$order->id)?>"><i class="fa fa-trash-o"></i> Kaldır</a></td>
								</tr>
							</tbody>
								<tr>
									<td colspan="7" align="right"><b>Toplam: <?=number_format($order->price, 2)?> TL</b></td>
								</tr>
								<tr>
									<td colspan="7" align="right" class="green-text"><b>Ödenecek Tutar: <?=number_format($order->price, 2)?> TL</b></td>
								</tr>														
						</table>
					</div>
					
					<?if(!isset($payment_form)):?>
						<form method="POST" action="<?=current_url()?>">
							<h3>Fatura Bilgileri</h3>
							<p>Aşağıda yer alan <strong>ad, soyad, cep telefonu numarası, e-posta adresi, il ve ilçe</strong> bilgileriniz güncel değilse lütfen işleme devam etmeden önce <a href="<?=site_url('users/my')?>" target="_blank">buraya</a> tıklayarak güncelleyiniz.</p>
							<p class="font-size-12 grey-text">Bilgi: Ödeme yapacak kredi kartı sahibi bilgileri ile aşağıdaki bilgilerin aynı olması <u>gerekmemektedir</u>. Bu nedenle lütfen aşağıdaki T.C. kimlik no ve adres alanına kredi kartı sahibinin bilgilerini değil, kendi bilgilerinizi giriniz.</p>
							<div class="table-reponsive">
								<table class="table table-bordered">
									<tbody>
										<tr>
											<td width="30%">Ad</td>
											<td><?=$this->session->userdata('user_firstname')?></td>
										</tr>
										<tr>
											<td>Soyad</td>
											<td><?=$this->session->userdata('user_lastname')?></td>
										</tr>
										<tr>
											<td>E-posta Adresi</td>
											<td><?=$this->session->userdata('user_email')?></td>
										</tr>
										<tr>
											<td>Cep Telefonu Numarası</td>
											<td><?=$this->session->userdata('user_mobile')?></td>
										</tr>
										<tr>
											<td>T.C. Kimlik No</td>
											<td>
												<input type="text" name="identity_no" class="form-control" value="<?if($this->input->post('identity_no')):?><?=$this->input->post('identity_no')?><?else:?><?=$this->session->userdata('user_identity_no')?><?endif;?>" />
												<small class="lightgrey-text">T.C. kimlik numarası banka tarafından istenmektedir.</small>
											</td>
										</tr>
										<tr>
											<td>Adres</td>
											<td>
												<input type="text" name="address" class="form-control" value="<?if($this->input->post('address')):?><?=$this->input->post('address')?><?else:?><?=$this->session->userdata('user_address')?><?endif;?>" />										
												<small class="lightgrey-text">Adresinize il ilçe bilgisi yazmanıza gerek yoktur. Bu bilgiler profilinizden alınmaktadır.</small>
											</td>
										</tr>	
										<tr>
											<td>İl / İlçe</td>
											<td>
												<?=$this->session->userdata('user_city_title')?> / <?=$this->session->userdata('user_town_title')?>
											</td>
										</tr>																							
										<tr>
											<td></td>
											<td>
												<input name="aggrement" type="checkbox" value="1"<?if($this->input->post('aggrement') == 1):?> checked<?endif;?> /> <a href="#" data-toggle="modal" data-target="#sales-txt">Satış sözleşmesi</a>'ni okudum, anladım ve kabul ediyorum.
											</td>
										</tr>								
									</tbody>							
								</table>
							</div>
		
							<button type="submit" class="btn btn-orange btn-lg pull-right margin-top-20 js-submit-btn"><i class="fa fa-credit-card"></i> Ödeme yap</button>
							<button disabled="disabled" class="btn btn-orange btn-lg pull-right margin-top-20 hide js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
						</form>	
					<?else:?>
						<h3 id="js-scroll-payment">Ödeme İşlemi</h3>
						<p>Lütfen aşağıdaki alanları doldurarak ödeme işleminizi tamamlayınız. Ödeme işleminiz tamamlandıktan sonra ödeme alındı ise sipariş numaranızın bulunduğu bir sayfaya yönlendirileceksiniz. Siparişinizin bir kopyası otomatik olarak e-posta adresinize gönderilerek, satın almış olduğunuz ürün ve hizmetler otomatik olarak hesabınıza tanımlanacaktır. Ek olarak herhangi bir işlem yapmanıza gerek yoktur.</p>
						<p>Eğer ödeme işleminde bir hata oluşursa hata mesajının yer aldığı sayfaya yönlendirileceksiniz. Yönlendirildiğiniz sayfada yaptığınız hatayı tespit ederek, düzeltip tekrar ödeme yapmak için o sayfada bulunan ilgili butonlara tıklayabilirsiniz.</p>
						<p>Verdiğiniz tüm siparişler bilinen en yüksek seviyedeki SSL (Secure Server Layer) şifreleme teknolojileri ile güvence altındadır.</p>
						<p>6502 numaralı Tüketicinin Korunması Hakkında Kanun gereğince verdiğiniz tüm siparişleri 30 gün içerisinde hiçbir neden belirtmeksizin iptal edebilirsiniz. Bu durumda ödediğiniz ücretler kanunen en geç 10 gün içerisinde iade edilmektedir.</p>
						<p class="form-loader font-size-18 green-text bold"><i class="fa fa-spinner fa-pulse fa-fw"></i> Ödeme formunuz hazırlanıyor, lütfen bekleyiniz...</p>
						<?=$payment_form?>
						<div id="iyzipay-checkout-form" class="responsive"></div>
					<?endif;?>
					
							
				
			</div>		
	
		</div>



		

	</div>
</section>

<!-- Modal Sales -->
<div class="modal fade" id="sales-txt" tabindex="-1" role="dialog" aria-labelledby="salesLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="salesLabel">Satış Sözleşmesi</h4>
      </div>
      <div class="modal-body">
        <?
        	$content = content(40);
        	echo $content->description;
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(function(){
		$('.js-submit-btn').on('click', function(){
			$(this).hide();
			$('.js-loader').removeClass('hide');
		});
		$(window).load(function(){
			$('.form-loader').hide();
			
			if($('#js-scroll-payment').length){
		        $('html,body').animate({ 
		            scrollTop: $('#js-scroll-payment').offset().top - 20
		        }, 500);			
	        }
		});	        
	});
</script>
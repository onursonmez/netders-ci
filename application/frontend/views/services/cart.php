<?$user_money = user_money($this->session->userdata('user_id'))?>
<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2>Alışveriş Sepeti</h2>
		<div class="row">
			<div class="col-md-12">
				<?if(empty($orders['orders'])):?>
					<p>Alışveriş sepetinizde ürün bulunmamaktadır.</p>
					<a href="<?=site_url('memberships')?>" class="btn btn-orange">Üyelik Satın Al</a> veya 
					<a href="<?=site_url('services')?>" class="btn btn-orange">Hizmet Satın Al</a>
				<?else:?>
					<form method="POST" action="<?=current_url()?>">
						<div class="table-responsive">
							<table class="table table-bordered table-white">
								<thead>
									<tr>
										<th width="300">Ürün Adı</th>
										<th>Açıklama</th>
										<?if($this->session->userdata('user_use_money') == 'Y'):?>
										<th width="120">Ürün Birim Ücreti</th>
										<th width="120">Kullanılacak Sanal Para</th>
										<?endif;?>
										<th width="<?if($this->session->userdata('user_use_money') == 'Y'):?>120<?else:?>200<?endif;?>">Ödenecek Ücret</th>
										<th width="120" class="text-right">İşlemler</th>
									</tr>
								</thead>
								<tbody>
									<?foreach($orders['orders'] as $order):?>
									<tr>
										<td><?=$order->title?></td>
										<td>
											<?if($order->subject_id && $order->level_id):?>
												<?=$order->subject_title?> > <?=$order->level_title?><br /><?=date('d.m.Y H:i', $order->start_date)?> - <?=date('d.m.Y H:i', $order->end_date)?>
											<?else:?>
												<?=$order->description?>
											<?endif;?>
										</td>
										<?if($this->session->userdata('user_use_money') == 'Y'):?>
										<td><?=$order->price?> TL<span class="block font-size-11 grey-text"><?=ptm($order->price)?> Sanal Para</span></td>
										<td><?=$order->used_money?></td>
										<?endif;?>
										<td><?=$order->payed_price?> TL</td>
										<td align="right"><a href="<?=site_url('services/cart?delete='.$order->id)?>"><i class="fa fa-trash-o"></i> Kaldır</a></td>
									</tr>
									<?endforeach;?>
								</tbody>
									<tr>
										<td colspan="7" align="right"><b>Toplam Tutar: <?=format_price($orders['total_price'])?> TL</b></td>
									</tr>
									<?if($this->session->userdata('user_use_money') == 'Y' && $user_money > 0):?>
									<tr>
										<td colspan="7" align="right"><b>Kullanılan Sanal Para: <?=format_money($orders['total_used_money'])?> (<?=mtp($orders['total_used_money'])?> TL)</b></td>
									</tr>							
									<?endif;?>
									<tr>
										<td colspan="7" align="right" class="green-text"><b>Ödenecek Tutar: <?=format_price($orders['total_payed_price'])?> TL</b></td>
									</tr>															
							</table>
						</div>

						<?if($user_money > 0):?>
						<div class="alert alert-info margin-top-20">
							<span class="pull-left">Hesabınızda <b><?=mtp($user_money)?> TL</b> karşılığı <b><?=format_money($user_money)?> sanal para</b> bulunmaktadır.</span>
							
							<span class="pull-right">
								<?if($this->session->userdata('user_use_money') == 'Y'):?>
									<a href="<?=site_url('services/cart?use_money=N')?>"><i class="fa fa-gift"></i> Sanal Para Kullanma</a>
								<?else:?>
									<a href="<?=site_url('services/cart?use_money=Y')?>"><i class="fa fa-gift"></i> Sanal Para Kullan</a>
								<?endif;?>
							</span>
							<div class="clearfix"></div>	
						</div>							
						<?endif;?>	
						
						<?if($orders['total_payed_price'] > 0):?>
						<div class="alert alert-warning margin-top-20 text-left">
							<i class="fa fa-gift"></i> İyi haber! Bu siparişinizden ücretli hizmetlerde kullanacağınız <strong><?=mtp($orders['total_payed_price'])?> TL</strong> değerinde <strong><?=ptm(mtp($orders['total_payed_price']))?></strong> sanal para kazanacaksınız.
						</div>							
						<?endif;?>
						
						<?if($this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
						<div class="alert alert-warning margin-top-20 text-left">
							<i class="fa fa-thumbs-o-up"></i> Tebrikler! Bu siparişinizi <strong><?if($this->session->userdata('user_ugroup') == 4):?>Advanced<?else:?>Premium<?endif;?></strong> üye olarak verdiğiniz için hizmetleri <strong>%<?if($this->session->userdata('user_ugroup') == 4):?>10<?else:?>20<?endif;?></strong> indirimli olarak satın alıyorsunuz.
						</div>							
						<?endif;?>							
						
						<?if(!isset($payment_form)):?>
							<?if($orders['total_payed_price'] > 0):?>	
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
							<?else:?>
								<input name="aggrement" type="checkbox" value="1"<?if($this->input->post('aggrement') == 1):?> checked<?endif;?> /> <a href="#" data-toggle="modal" data-target="#sales-txt">Satış sözleşmesi</a>'ni okudum, anladım ve kabul ediyorum.										
							<?endif;?>
							
							<div class="clearfix"></div>
							
							<a href="<?=site_url('services')?>" class="btn btn-orange btn-lg pull-left margin-top-20"><i class="fa fa-plus"></i> Yeni Hizmet Satın Al</a>
							
							<button type="submit" class="btn btn-orange btn-lg pull-right margin-top-20 js-submit-btn"><?if(empty($orders['total_payed_price'])):?><i class="fa fa-gift"></i> Tamamla<?else:?><i class="fa fa-credit-card"></i> Ödeme yap<?endif;?></button>
							<button disabled="disabled" class="btn btn-orange btn-lg pull-right margin-top-20 hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
							
							<div class="clearfix"></div>
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
					</form>
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
		$(window).load(function()
		{
			if($('.form-loader').length){
				$('.form-loader').hide();
			}
			
			if($('#js-scroll-payment').length){
		        $('html,body').animate({ 
		            scrollTop: $('#js-scroll-payment').offset().top - 20
		        }, 500);			
	        }
		});	        
	});
</script>
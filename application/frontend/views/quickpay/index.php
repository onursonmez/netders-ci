<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2>Ödeme İşlemi</h2>
		<div class="row">
			<div class="col-md-12">
				<?if(empty($payment_form)):?>
					<p>Aşağıda formu doldurarak kredi kartı ile ödeme yapabilirsiniz.</p>
					<form method="POST" action="<?=current_url()?>">
					<div class="table-reponsive">
						<table class="table table-bordered">
							<tbody>
								<tr>
									<td width="30%">Ad</td>
									<td><input type="text" name="firstname" class="form-control" value="<?=$this->input->post('firstname')?>" /></td>
								</tr>
								<tr>
									<td width="30%">Soyad</td>
									<td><input type="text" name="lastname" class="form-control" value="<?=$this->input->post('lastname')?>" /></td>
								</tr>								
								<tr>
									<td>E-posta</td>
									<td><input type="text" name="email" class="form-control" value="<?=$this->input->post('email')?>" /></td>
								</tr>
								<tr>
									<td>Cep Telefonu</td>
									<td><input type="text" name="mobile" data-type="mobile-number" class="form-control" value="<?=$this->input->post('mobile')?>" /></td>
								</tr>
								<tr>
									<td>T.C. Kimlik No</td>
									<td>
										<input type="text" name="identity_no" class="form-control" value="<?if($this->input->post('identity_no')):?><?=$this->input->post('identity_no')?><?else:?><?=$this->session->userdata('user_identity_no')?><?endif;?>" />
									</td>
								</tr>
								<tr>
									<td>Adres</td>
									<td>
										<input type="text" name="address" class="form-control" value="<?if($this->input->post('address')):?><?=$this->input->post('address')?><?else:?><?=$this->session->userdata('user_address')?><?endif;?>" />										
									</td>
								</tr>	
								<tr>
									<td>Şehir</td>
									<td>
										<input type="text" name="city" class="form-control" value="<?=$this->input->post('city')?>" />
									</td>
								</tr>
								<tr>
									<td>Ödenecek Tutar</td>
									<td>
										<input type="text" name="price" class="form-control" value="<?=$this->input->post('price')?>" />
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
					<button type="submit" class="btn btn-orange btn-lg pull-right margin-top-20 js-submit-btn"><?if(empty($payment_form)):?><i class="fa fa-gift"></i> Devam<?else:?><i class="fa fa-credit-card"></i> Ödeme yap<?endif;?></button>
					<button disabled="disabled" class="btn btn-orange btn-lg pull-right margin-top-20 hide js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />						
					</form>
					
					<?else:?>	
					<div id="js-scroll-payment"></div>
					<p>Lütfen aşağıdaki alanları doldurarak ödeme işleminizi tamamlayınız. Ödeme işleminiz tamamlandıktan sonra ödeme alındı ise sipariş numaranızın bulunduğu bir sayfaya yönlendirileceksiniz. Siparişinizin bir kopyası otomatik olarak e-posta adresinize gönderilerek, satın almış olduğunuz ürün ve hizmetler otomatik olarak hesabınıza tanımlanacaktır. Ek olarak herhangi bir işlem yapmanıza gerek yoktur.</p>
					<p>Eğer ödeme işleminde bir hata oluşursa hata mesajının yer aldığı sayfaya yönlendirileceksiniz. Yönlendirildiğiniz sayfada yaptığınız hatayı tespit ederek, düzeltip tekrar ödeme yapmak için o sayfada bulunan ilgili butonlara tıklayabilirsiniz.</p>
					<p>Verdiğiniz tüm siparişler bilinen en yüksek seviyedeki SSL (Secure Server Layer) şifreleme teknolojileri ile güvence altındadır.</p>
					<?=$payment_form?>
					<div id="iyzipay-checkout-form" class="responsive"></div>
					<?endif;?>
				</form>				
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
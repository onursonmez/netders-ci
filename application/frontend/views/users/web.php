<form  action="<?=site_url('users/web')?>" method="post" class="ajax-form js-dont-reset">
	<div class="card box-shadow mb-4">
		<div class="card-header"><h4>Özel Web Sayfası Ayarları</h4></div>
		<div class="card-body">
			<div class="row">	
							
				<div class="col-md-12">
                    <table class="table">
                        <tbody>                                                                                     
                            <tr>
								<td width="30%">Özel Web Sayfası Kullan</td>
								<td>
								  <select name="private_web" class="form-control">
									  <option value="Y"<?if($this->session->userdata('user_private_web') == 'Y'):?> selected<?endif;?>>Evet</option>
									  <option value="N"<?if($this->session->userdata('user_private_web') == 'N'):?> selected<?endif;?>>Hayır</option>
								  </select>
								</td>
                            </tr>
                        </tbody>							                        
                    </table>				
				</div>
				
				<div class="col-md-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>								
			</div>
		</div>
	</div>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>
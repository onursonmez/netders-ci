<form  action="<?=site_url('users/web')?>" method="post" class="ajax-form js-dont-reset">
	<div class="panel panel-default margin-bottom-20">
		<div class="panel-heading"><h4>Özel Web Sayfası Ayarları</h4></div>
		<div class="panel-body">
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
					<button type="submit" class="btn btn-orange js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>								
			</div>
		</div>
	</div>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>
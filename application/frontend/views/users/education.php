<div class="panel panel-default margin-bottom-20">
	<div class="panel-heading"><h4>Eğitim Bilgileri</h4></div>
	<div class="panel-body">
		<form  action="<?=site_url('users/education')?>" method="post" class="ajax-form js-dont-reset">
			<div class="row">	

				<div class="form-group col-md-12 table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="120"></th>
								<th>Okul Adı</th>
								<th>Bölüm Adı</th>
								<th width="120">Mezuniyet Yılı</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><strong>Lise</strong></td>
								<td><input type="text" name="school_name" class="form-control" value="<?=$this->session->userdata('user_school_name')?>" /></td>
								<td><input type="text" name="school_section" class="form-control" value="<?=$this->session->userdata('user_school_section')?>" /></td>
								<td><input type="text" name="school_end" class="form-control" value="<?=$this->session->userdata('user_school_end')?>" /></td>								
							</tr>
							<tr>
								<td><strong>Üniversite</strong></td>
								<td><input type="text" name="school2_name" class="form-control" value="<?=$this->session->userdata('user_school2_name')?>" /></td>
								<td><input type="text" name="school2_section" class="form-control" value="<?=$this->session->userdata('user_school2_section')?>" /></td>
								<td><input type="text" name="school2_end" class="form-control" value="<?=$this->session->userdata('user_school2_end')?>" /></td>
							</tr>
							<tr>
								<td><strong>Yüksek Lisans</strong></td>
								<td><input type="text" name="school3_name" class="form-control" value="<?=$this->session->userdata('user_school3_name')?>" /></td>
								<td><input type="text" name="school3_section" class="form-control" value="<?=$this->session->userdata('user_school3_section')?>" /></td>
								<td><input type="text" name="school3_end" class="form-control" value="<?=$this->session->userdata('user_school3_end')?>" /></td>
							</tr>
							<tr>
								<td><strong>Doktora</strong></td>
								<td><input type="text" name="school4_name" class="form-control" value="<?=$this->session->userdata('user_school4_name')?>" /></td>
								<td><input type="text" name="school4_section" class="form-control" value="<?=$this->session->userdata('user_school4_section')?>" /></td>
								<td><input type="text" name="school4_end" class="form-control" value="<?=$this->session->userdata('user_school4_end')?>" /></td>
							</tr>																												
						</tbody>						
					</table>
				</div>				
				
				<div class="col-md-12">
					<button type="submit" class="btn btn-orange js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>
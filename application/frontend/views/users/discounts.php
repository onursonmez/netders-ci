<form  action="<?=site_url('users/discounts')?>" method="post" class="ajax-form js-dont-reset">
	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Özel Ders İndirimleri</h4>
		</div>
		<div class="card-body">
			<p>Öğrencilerinize çeşitli durumlarda indirim fırsatları sunabilirsiniz. Aşağıdaki alanda yer alan durumlardan, istediğiniz oranlarda indirim oranı belirleyebilirsiniz.</p>
			<div class="row">
				<div class="form-group col-md-12">
					<table class="table">
						<tbody>
							<tr>
								<td>Ücretsiz İlk Ders</td>
								<td><input type="checkbox" name="discount7" id="ucretsiz_ilk_ders" value="1"<?if($this->session->userdata('user_discount7')):?> checked<?endif;?> /></td>
							</tr>
							<tr>
								<td>Üye öğrenci İndirimi</td>
								<td>
									<select name="discount10" id="indirim_uye_ogrenci" class="form-control">
										<option value="">-- Yok --</option>
										<option value="5"<?if($this->session->userdata('user_discount10') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount10') == 10):?> selected<?endif;?>>%10</option>
									</select>
									<span class="lightgrey-text font-size-11">"Bu indirimi tanımlamanız sıralamalarda üst sıralarda çıkmanızı sağlar"</span>
								</td>
							</tr>
							<tr>
								<td>Eğitmen Evi İndirimi</td>
								<td>
									<?$places = $this->session->userdata('user_places') ? explode(',', $this->session->userdata('user_places')) : '';?>
									<select name="discount8" id="indirim_egitmen_evi" class="form-control"<?if((!empty($places) && !in_array(2, array_values($places))) || empty($places)):?> disabled="disabled"<?endif;?>>
										<option value="">-- Yok --</option>
										<option value="5"<?if($this->session->userdata('user_discount8') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount8') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount8') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount8') == 20):?> selected<?endif;?>>%20</option>
									</select>
									<?if((!empty($places) && !in_array(2, array_values($places))) || empty($places)):?><span class="font-size-11 red-text"><i class="fa fa-exclamation-triangle"></i> Eğitmen evinde ders vermediğiniz için bu indirimi tanımlayamazsınız.</span><?endif;?>
								</td>
							</tr>
							<tr>
								<td>Grup İndirimi</td>
								<td>
									<select name="discount9" id="indirim_grup" class="form-control">
										<option value="">-- Yok --</option>
										<option value="5"<?if($this->session->userdata('user_discount9') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount9') == 10):?> selected<?endif;?>>%10</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Engelli İndirimi</td>
								<td>
									<select name="discount12" id="indirim_engelli" class="form-control">
										<option value="">-- Yok --</option>
										<option value="5"<?if($this->session->userdata('user_discount12') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount12') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount12') == 15):?> selected<?endif;?>>%15</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Engelli İndirimi Şartları</td>
								<td>
									<textarea name="discount12_text" class="form-control" rows="5" placeholder="Engelli İndirimi Şartları"><?=$this->session->userdata('user_discount12_text')?></textarea>
									<span class="lightgrey-text font-size-11">Engelli indirimi seçtiyseniz lütfen engelli indirimi şartlarınızdan bahsediniz.</span>
								</td>
							</tr>
							<tr>
								<td>Öneri İndirimi</td>
								<td>
									<select name="discount13" id="indirim_oneri" class="form-control">
										<option value="">-- Yok --</option>
										<option value="5"<?if($this->session->userdata('user_discount13') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount13') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount13') == 15):?> selected<?endif;?>>%15</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Öneri İndirimi Şartları</td>
								<td>
									<textarea name="discount13_text" class="form-control" rows="5" placeholder="Öneri İndirimi Şartları"><?=$this->session->userdata('user_discount13_text')?></textarea>
									<span class="lightgrey-text font-size-11">Öneri indirimi seçtiyseniz lütfen öneri indirimi şartlarınızdan bahsediniz.</span>
								</td>
							</tr>
							<tr>
								<td>Paket Program İndirimi</td>
								<td>
									<select name="discount11" id="indirim_paket_program" class="form-control">
										<option value="">-- Yok --</option>
										<option value="5"<?if($this->session->userdata('user_discount11') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount11') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount11') == 15):?> selected<?endif;?>>%15</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Paket Program Şartları</td>
								<td>
									<textarea name="discount11_text" class="form-control" rows="5" placeholder="Paket Program Şartları"><?=$this->session->userdata('user_discount11_text')?></textarea>
									<span class="lightgrey-text font-size-11">Paket program indirimi seçtiyseniz lütfen paket program kapsamınızdan bahsediniz.</span>
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

	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4 class="mb-0 pt-3 pb-3">Canlı Ders İndirimleri</h4>
		</div>
		<div class="card-body">
			<p>Öğrencilerinize aynı anda birden fazla ders satın alırken indirim yaparak daha fazla ders almalarını sağlayabilirsiniz. Örneğin 3 canlı ders alana %5 indirim yapmak istiyorsanız "3 ders" altındaki seçim kutusundan %5'i seçiniz. Minimum indirim oranı %5, maksimum indirim oranı %20'dir.</p>
			<div class="row">
				<div class="form-group col-md-12 table-responsive">
					<table class="table table-bordered">
	                    <tbody>
	                        <tr style="background:#fdfdfd">
	                            <th></th>
	                            <th>3 ders</th>
	                            <th>5 ders</th>
	                            <th>10 ders</th>
	                            <th>15 ders</th>
	                            <th>25 ders</th>
	                            <th>50 ders</th>
	                        </tr>
	                        <tr>
								<td width="100">İndirim Oranı</td>
								<td width="100">
									<select name="discount1" class="form-control">
										<option value=""<?if(!$this->session->userdata('user_discount1')):?> selected<?endif;?>>Yok</option>
										<option value="5"<?if($this->session->userdata('user_discount1') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount1') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount1') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount1') == 20):?> selected<?endif;?>>%20</option>
									</select>
								</td>
								<td width="100">
									<select name="discount2" class="form-control">
										<option value=""<?if(!$this->session->userdata('user_discount2')):?> selected<?endif;?>>Yok</option>
										<option value="5"<?if($this->session->userdata('user_discount2') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount2') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount2') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount2') == 20):?> selected<?endif;?>>%20</option>
									</select>
								</td>
								<td width="100">
									<select name="discount3" class="form-control">
										<option value=""<?if(!$this->session->userdata('user_discount3')):?> selected<?endif;?>>Yok</option>
										<option value="5"<?if($this->session->userdata('user_discount3') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount3') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount3') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount3') == 20):?> selected<?endif;?>>%20</option>
									</select>
								</td>
								<td width="100">
									<select name="discount4" class="form-control">
										<option value=""<?if(!$this->session->userdata('user_discount4')):?> selected<?endif;?>>Yok</option>
										<option value="5"<?if($this->session->userdata('user_discount4') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount4') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount4') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount4') == 20):?> selected<?endif;?>>%20</option>
									</select>
								</td>
								<td width="100">
									<select name="discount5" class="form-control">
										<option value=""<?if(!$this->session->userdata('user_discount5')):?> selected<?endif;?>>Yok</option>
										<option value="5"<?if($this->session->userdata('user_discount5') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount5') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount5') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount5') == 20):?> selected<?endif;?>>%20</option>
									</select>
								</td>
								<td width="100">
									<select name="discount6" class="form-control">
										<option value=""<?if(!$this->session->userdata('user_discount6')):?> selected<?endif;?>>Yok</option>
										<option value="5"<?if($this->session->userdata('user_discount6') == 5):?> selected<?endif;?>>%5</option>
										<option value="10"<?if($this->session->userdata('user_discount6') == 10):?> selected<?endif;?>>%10</option>
										<option value="15"<?if($this->session->userdata('user_discount6') == 15):?> selected<?endif;?>>%15</option>
										<option value="20"<?if($this->session->userdata('user_discount6') == 20):?> selected<?endif;?>>%20</option>
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

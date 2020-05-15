<form  action="<?=site_url('users/preferences')?>" method="post" class="ajax-form js-dont-reset">
	<div class="panel panel-default margin-bottom-20">
		<div class="panel-heading"><h4>Tercihler</h4></div>
		<div class="panel-body">
			<div class="row">	
							
				<div class="col-md-12">
                    <table class="table">
                        <tbody>   
                            <tr>
								<td colspan="2"><strong>Eğitim Tercihleri</strong></td>
                            </tr>                                            
                            <tr>
								<td>Ders Verilen Şekiller</td>
								<td>
									  <?$figures = $this->session->userdata('user_figures') ? explode(',', $this->session->userdata('user_figures')) : '';?>
									  <div class="row">
										  <div class="col-md-4">
											  <input type="checkbox" name="figures[]" id="f1" value="1"<?if(!empty($figures) && in_array(1, $figures)):?> checked<?endif;?>> <label for="f1">Birebir Ders</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="figures[]" id="f2" value="2"<?if(!empty($figures) && in_array(2, $figures)):?> checked<?endif;?>> <label for="f2">Grup Dersi</label>
										  </div>									  
									  </div>
								</td>
                            </tr> 
                            <tr>
								<td>Ders Verilen Mekanlar</td>
								<td>
									  <?$places = $this->session->userdata('user_places') ? explode(',', $this->session->userdata('user_places')) : '';?>
									  <div class="row">
										  <div class="col-md-4">
											  <input type="checkbox" name="places[]" id="p1" value="1"<?if(!empty($places) && in_array(1, $places)):?> checked<?endif;?>> <label for="p1">Öğrencinin Evi</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="places[]" id="p2" value="2"<?if(!empty($places) && in_array(2, $places)):?> checked<?endif;?>> <label for="p2">Eğitmen Evi</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="places[]" id="p3" value="3"<?if(!empty($places) && in_array(3, $places)):?> checked<?endif;?>> <label for="p3">Etüd Merkezi</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="places[]" id="p4" value="4"<?if(!empty($places) && in_array(4, $places)):?> checked<?endif;?>> <label for="p4">Kütüphane</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="places[]" id="p5" value="5"<?if(!empty($places) && in_array(5, $places)):?> checked<?endif;?>> <label for="p5">Diğer</label>
										  </div>										  
									  </div>
								</td>
                            </tr>                                                        
                            <tr>
								<td>Ders Verilen Zamanlar</td>
								<td>
									  <?$times = $this->session->userdata('user_times') ? explode(',', $this->session->userdata('user_times')) : '';?>
									  <div class="row">
										  <div class="col-md-4">
											  <input type="checkbox" name="times[]" id="t1" value="1"<?if(!empty($times) && in_array(1, $times)):?> checked<?endif;?>> <label for="t1">Hafta İçi Gündüz</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="times[]" id="t2" value="2"<?if(!empty($times) && in_array(2, $times)):?> checked<?endif;?>> <label for="t2">Hafta İçi Akşam</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="times[]" id="t3" value="3"<?if(!empty($times) && in_array(3, $times)):?> checked<?endif;?>> <label for="t3">Hafta Sonu Gündüz</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="times[]" id="t4" value="4"<?if(!empty($times) && in_array(4, $times)):?> checked<?endif;?>> <label for="t4">Hafta Sonu Akşam</label>
										  </div>
									  </div>
								</td>
                            </tr>
                            <tr>
								<td>Sunulan Hizmetler</td>
								<td>
									  <?$services = $this->session->userdata('user_services') ? explode(',', $this->session->userdata('user_services')) : '';?>
									  <div class="row">
										  <div class="col-md-4">
											  <input type="checkbox" name="services[]" id="s1" value="1"<?if(!empty($services) && in_array(1, $services)):?> checked<?endif;?>> <label for="s1">Ödev Yardımı</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="services[]" id="s2" value="2"<?if(!empty($services) && in_array(2, $services)):?> checked<?endif;?>> <label for="s2">Tez Yardımı</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="services[]" id="s3" value="3"<?if(!empty($services) && in_array(3, $services)):?> checked<?endif;?>> <label for="s3">Proje Yardımı</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="services[]" id="s4" value="4"<?if(!empty($services) && in_array(4, $services)):?> checked<?endif;?>> <label for="s4">Eğitim Koçluğu</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="services[]" id="s5" value="5"<?if(!empty($services) && in_array(5, $services)):?> checked<?endif;?>> <label for="s5">Yaşam Koçluğu</label>
										  </div>
									  </div>
								</td>
                            </tr>    
                            <tr>
								<td>Ders Verilen Cinsiyetler</td>
								<td>
									  <?$genders = $this->session->userdata('user_genders') ? explode(',', $this->session->userdata('user_genders')) : '';?>
									  <div class="row">
										  <div class="col-md-4">
											  <input type="checkbox" name="genders[]" id="g1" value="1"<?if(!empty($genders) && in_array(1, $genders)):?> checked<?endif;?>> <label for="g1">Erkek</label>
										  </div>
										  <div class="col-md-4">
											  <input type="checkbox" name="genders[]" id="g2" value="2"<?if(!empty($genders) && in_array(2, $genders)):?> checked<?endif;?>> <label for="g2">Kadın</label>
										  </div>
									  </div>
								</td>
                            </tr>                                                                                      
                            <tr>
								<td colspan="2"><strong>Gizlilik Tercihleri</strong></td>
                            </tr>
                            <tr>
								<td>Soyadı Gizliliği</td>
								<td>
								  <select name="privacy_lastname" class="form-control">
									  <option value="1"<?if($this->session->userdata('user_privacy_lastname') == 1):?> selected<?endif;?>>Soyadımı herkes görsün</option>
									  <option value="2"<?if($this->session->userdata('user_privacy_lastname') == 2):?> selected<?endif;?>>Soyadım yerine Öğretmen yazsın</option>
									  <option value="3"<?if($this->session->userdata('user_privacy_lastname') == 3):?> selected<?endif;?>>Soyadımı sadece üye öğrenciler görsün</option>
								  </select>
								</td>
                            </tr>
                            <tr>
                            	<td>Telefon Gizliliği</td>
								<td>
								  <select name="privacy_phone" class="form-control">
									  <?if($this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
									  <option value="1"<?if($this->session->userdata('user_privacy_phone') == 1):?> selected<?endif;?>>Telefon numaramı herkes görsün</option>
									  <?endif;?>
									  <option value="2"<?if($this->session->userdata('user_privacy_phone') == 2):?> selected<?endif;?>>Telefon numaramı üye öğrenciler görsün</option>
									  <option value="3"<?if($this->session->userdata('user_privacy_phone') == 3):?> selected<?endif;?>>Telefon numaram hiçbir şekilde görülmesin</option>
								  </select>
								  <?if($this->session->userdata('user_ugroup') == 3):?>
								  <span class="font-size-11 lightgrey-text">Telefon numaranızın herkes tarafından görünebilmesi için Advanced veya Premium üye olmalısınız.</td>
								  <?endif;?>
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
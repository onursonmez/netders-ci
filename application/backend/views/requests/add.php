<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="<?=base_url('backend/requests')?>">Talepler</a></li>
	<li class="active"><?if($this->uri->segment(3) == 'add'):?>Yeni Talep<?else:?>Talep Düzenle<?endif;?></li>
</ul>

<form method="post" action="<?=base_url('backend/requests')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" onsubmit="return prepareSubmit(this);">

<div class="row">
	<div class="col-md-6">
		<section class="panel panel-default">
			<header class="panel-heading bg-light">
				Öğrenci Bilgileri
			</header>
			<div class="card-body">
					<div class="row">
		
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label block">Arayan Kişi</label>
								<select name="form[title]" class="chosen-select">
									<option value="1"<?if($_REQUEST['form']['title'] == 1 || $item->title == 1):?> selected<?endif;?>>Kendisi</option>
									<option value="2"<?if($_REQUEST['form']['title'] == 2 || $item->title == 2):?> selected<?endif;?>>Velisi</option>
								</select>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Ad Soyad</label>
								<input type="text" name="form[fullname]" value="<?if($_REQUEST['form']['fullname']):?><?=htmlspecialchars($_REQUEST['form']['fullname'])?><?else:?><?=htmlspecialchars($item->fullname)?><?endif;?>" class="form-control" />
							</div>		
						</div>
		
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label block">Öğrenci Cinsiyet</label>
								<select name="form[gender]" class="chosen-select">
									<option value="M"<?if($_REQUEST['form']['gender'] == 'M' || $item->gender == 'M'):?> selected<?endif;?>>Erkek</option>
									<option value="F"<?if($_REQUEST['form']['gender'] == 'F' || $item->gender == 'F'):?> selected<?endif;?>>Kadın</option>
								</select>
							</div>
						</div>
		
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Öğrenci Yaş</label>
								<input type="text" name="form[age]" value="<?if($_REQUEST['form']['age']):?><?=htmlspecialchars($_REQUEST['form']['age'])?><?else:?><?=htmlspecialchars($item->age)?><?endif;?>" class="form-control" />
							</div>
						</div>
		
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Telefon</label>
								<input type="text" data-type="mobile-number" name="form[phone]" value="<?if($_REQUEST['form']['phone']):?><?=htmlspecialchars($_REQUEST['form']['phone'])?><?else:?><?=htmlspecialchars($item->phone)?><?endif;?>" class="form-control" />
							</div>
						</div>				
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Telefon 2</label>
								<input type="text" data-type="mobile-number" name="form[phone2]" value="<?if($_REQUEST['form']['phone2']):?><?=htmlspecialchars($_REQUEST['form']['phone2'])?><?else:?><?=htmlspecialchars($item->phone2)?><?endif;?>" class="form-control" />
							</div>
						</div>								
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label block">İl</label>
								<select name="form[city]" class="chosen-select" id="city">
									<?foreach($cities as $c):?><option value="<?=$c->id?>"<?if($_REQUEST['form']['city'] == $c->id || $item->city == $c->id):?> selected<?endif;?>><?=$c->title?></option><?endforeach;?>
								</select>
							</div>
						</div>
						
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label block">İlçe</label>
								<select name="form[town]" class="chosen-select" id="town"></select>
							</div>
						</div>										
		
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label block">Adres</label>
								<input name="form[address]" class="form-control" value="<?if($_REQUEST['form']['address']):?><?=htmlspecialchars($_REQUEST['form']['address'])?><?else:?><?=$item->address?><?endif;?>" />
							</div>		
						</div>
		
					</div>
				</div>
		</section>
	</div>
	
	<div class="col-md-6">
		<section class="panel panel-default">
			<header class="panel-heading bg-light">
				Eğitmen/Ders Tercihi
			</header>
			<div class="card-body">
					<div class="row">
		
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label block">Eğitmen Cinsiyet</label>
								<select name="form[teacher_gender]" class="chosen-select">
									<option value="N"<?if($_REQUEST['form']['teacher_gender'] == 'N' || $item->teacher_gender == 'N'):?> selected<?endif;?>>Farketmez</option>
									<option value="M"<?if($_REQUEST['form']['teacher_gender'] == 'M' || $item->teacher_gender == 'M'):?> selected<?endif;?>>Erkek</option>
									<option value="F"<?if($_REQUEST['form']['teacher_gender'] == 'F' || $item->teacher_gender == 'F'):?> selected<?endif;?>>Kadın</option>
								</select>
							</div>
						</div>
												
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Eğitmen Yaş</label>
								<input type="text" name="form[teacher_age]" value="<?if($_REQUEST['form']['teacher_age']):?><?=htmlspecialchars($_REQUEST['form']['teacher_age'])?><?else:?><?=htmlspecialchars($item->teacher_age)?><?endif;?>" class="form-control" />
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label block">Mekan Tercihi</label>
								<?$item->place = $item->place ? explode(',', $item->place) : ''?>
								<?foreach(education_types(1) as $key => $value):?>
								<input type="checkbox" name="form[place][]" id="place_<?=$key?>" value="<?=$key?>"<?if($_REQUEST['form']['place'] && in_array($key, $_REQUEST['form']['place']) || $item->place && in_array($key, $item->place)):?> checked<?endif;?> /> <label for="place_<?=$key?>"><?=$value?></label>&nbsp;&nbsp;&nbsp;
								<?endforeach;?>
							</div>
						</div>	
						
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label block">Zaman Tercihi</label>
								<?$item->time = $item->time ? explode(',', $item->time) : ''?>
								<?foreach(education_types(2) as $key => $value):?>
								<input type="checkbox" name="form[time][]" id="time_<?=$key?>" value="<?=$key?>"<?if($_REQUEST['form']['time'] && in_array($key, $_REQUEST['form']['time']) || $item->time && in_array($key, $item->time)):?> checked<?endif;?> /> <label for="time_<?=$key?>"><?=$value?></label>&nbsp;&nbsp;&nbsp;
								<?endforeach;?>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label block">Ders Türü</label>
								<?$item->figure = $item->figure ? explode(',', $item->figure) : ''?>
								<?foreach(education_types(5) as $key => $value):?>
								<input type="checkbox" name="form[figure][]" id="figure_<?=$key?>" value="<?=$key?>"<?if($_REQUEST['form']['figure'] && in_array($key, $_REQUEST['form']['figure']) || $item->figure && in_array($key, $item->figure)):?> checked<?endif;?> /> <label for="figure_<?=$key?>"><?=$value?></label>&nbsp;&nbsp;&nbsp;
								<?endforeach;?>
							</div>
						</div>												
		
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Notlar</label>
								<textarea name="form[notes]" rows="3" class="form-control"><?if($_REQUEST['form']['notes']):?><?=htmlspecialchars($_REQUEST['form']['notes'])?><?else:?><?=htmlspecialchars($item->notes)?><?endif;?></textarea>
							</div>
						</div>				
								
					</div>
				</div>
		</section>
	</div>
</div><!--.row-->

<section class="panel panel-default m-t">
	<a class="panel-toggle<?if(strstr(uri_string(), 'edit') == TRUE):?> active<?endif;?>" href="#">
	<header class="panel-heading bg-light">
		<ul class="nav nav-pills pull-right">
			<li>
				<i class="rel-block fa fa-caret-down text-active"></i><i class="rel-block fa fa-caret-up text"></i>
			</li>
		</ul>
		<span>Yeni Ders Ekle</span>	
	</header>
	</a>
	<div class="panel-body<?if(strstr(uri_string(), 'edit') == TRUE):?> collapse<?endif;?>">
	
		<table class="table table-responsive prices-table">
			<tr>
				<th>Ders</th>
				<th>Ort. Ücret (TL) / Saat</th>
				<th>Kayıtlı Eğitmen</th>
				<th>Maks. Bütçe (TL) / Saat</th>
				<th>İşlemler</th>
			</tr>
			<tr class="new">
				<td>
					<select name="new[category][]" class="chosen-select" id="new_category" onchange="get_average_prices(this)">
						<option value="">-- Kategori Seçiniz --</option>
						<?foreach($categories as $key => $category):?>
							<?if($category->parent_id == 6):?>
								<?if($category->id != 7):?></optgroup><?endif;?>
								<optgroup label="<?=$category->title?>">
							<?else:?>
								<option value="<?=$category->category_id?>"><?if($category->parent_category_name):?><?=$category->parent_category_name?> > <?endif;?><?=$category->title?></option>
							<?endif;?>
						<?endforeach;?>
						</optgroup>
					</select>					
				</td>
				<td>
					<input type="text" class="form-control" name="new[price_average][]" id="new_price_average" readonly="" />
				</td>
				<td>
					<input type="text" class="form-control" name="new[teacher_count][]" id="new_teacher_count" readonly="" />
				</td>				
				<td>
					<input type="text" class="form-control money-three" name="new[budget][]" />
				</td>				
													
				<td>
					<button class="btn btn-success js-price-new">Ekle</button>
				</td>
			</tr>						
		</table>

	</div>
</section>

<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
</form>

<div class="clearfix"></div>
<?if(!empty($lessons)):?>
<?foreach($lessons as $lesson):?>
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#lesson_tab_<?=$lesson->id?>" data-toggle="tab"><i class="flag flag-muted flag-tr text-muted"></i> <?=$lesson->subject->title?> >  <?=$lesson->level->title?></a></li>
			<?if($lesson->activities):?>
			<li><a href="#lesson_activity_tab_<?=$lesson->id?>" data-toggle="tab"><i class="fa fa-camera text-muted"></i> Aktif Ders Aktiviteleri (<?=sizeof($lesson->activities)?>)</a></li>
			<?endif;?>
			<?if($lesson->activities_old):?>
			<li><a href="#lesson_old_activity_tab_<?=$lesson->id?>" data-toggle="tab"><i class="fa fa-camera text-muted"></i> Eski Ders Aktiviteleri (<?=sizeof($lesson->activities_old)?>)</a></li>
			<?endif;?>
		</ul>
	</header>
	
	<div class="card-body">
		<div class="tab-content">
		
		<div class="tab-pane active" id="lesson_tab_<?=$lesson->id?>">
		<?if($lesson->status_info):?>
		<div class="alert alert-<?=$lesson->status_info['class']?>">
			<button data-dismiss="alert" class="close" type="button">×</button>
			<i class="fa fa-ban-circle"></i><strong><?if($lesson->status_info['class'] == 'danger'):?>Kritik!<?elseif($lesson->status_info['class'] == 'warning'):?>Uyarı!<?endif;?></strong> <?=$lesson->status_info['value']?>
		</div>
		<?endif;?>
								
		<table class="table table-responsive prices-table">
			<?if($lesson->status_info['payed']):?>
			<tr>
				<td>Tahsilatlar</td>
				<td><?=format_price($lesson->status_info['payed'])?> TL</td>
			</tr>
			<?endif;?>
			<?if($lesson->balance):?>
			<tr>
				<td>Kalan Bakiye</td>
				<td><?=format_price($lesson->balance)?> TL</td>
			</tr>
			<?endif;?>
			<?if($lesson->budget):?>
			<tr>
				<td>Maksimum Bütçe</td>
				<td><?=$lesson->budget?> TL / saat</td>
			</tr>
			<?endif;?>
			<tr>
				<td>Son İşlem</td>
				<td><?=$lesson->status->title?></td>
			</tr>
			<tr>
				<td>Durum</td>
				<td>
					<ul class="reset-ul">
						<li><i class="fa fa-check"></i> Talep Alındı</li>
						<li><i class="fa fa-<?if($lesson->teacher_id):?>check<?else:?>close<?endif;?>"></i> Eğitmen Atandı</li>
						<li><i class="fa fa-<?if($lesson->model_id):?>check<?else:?>close<?endif;?>"></i> Çalışma Modeli Belirlendi</li>						
						<li><i class="fa fa-<?if($lesson->status_sms == 'Y'):?>check<?else:?>close<?endif;?>"></i> SMS Gönderildi</li>
						<li><i class="fa fa-<?if($lesson->appointment_date):?>check<?else:?>close<?endif;?>"></i> Randevu Tarihi Belirlendi</li>
						<li><i class="fa fa-<?if($lesson->lesson_hour):?>check<?else:?>close<?endif;?>"></i> Ders Süresi Belirlendi</li>
						<li><i class="fa fa-<?if($lesson->status_start == 'Y'):?>check<?else:?>close<?endif;?>"></i> Ders Başladı</li>
					</ul>
				</td>
			</tr>
			<?if($lesson->teacher):?>
			<tr>
				<td>Atanan Eğitmen</td>
				<td><a href="<?=base_url('backend/users/edit/'.$lesson->teacher->id)?>" target="_blank"><?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)</a></td>
			</tr>
			<?endif;?>
			<tr>
				<td width="200">Talep Tarihi</td>
				<td><?=date('d.m.Y H:i', $lesson->create_date)?></td>
			</tr>			
			<?if($lesson->appointment_date):?>
			<tr>
				<td>Randevu Tarihi</td>
				<td><?=date('d.m.Y H:i', $lesson->appointment_date)?></td>
			</tr>
			<?endif;?>					
			<?if($lesson->model_id):?>		
			<tr>
				<td>Çalışma Modeli</td>
				<td><?=$lesson->model->title?><?if($lesson->model_price):?> (<?=$lesson->model_price?> TL)<?endif;?></td>
			</tr>
			<?endif;?>
			<?if($lesson->hourly_price):?>		
			<tr>
				<td>Saatlik Ücret</td>
				<td><?=$lesson->hourly_price?> TL</td>
			</tr>
			<?endif;?>
			<?if($lesson->price_type && $lesson->lesson_hour):?>		
			<tr>
				<td>Ders Süresi</td>
				<td><?=$lesson->lesson_hour?> saat / <?if($lesson->price_type == 1):?>hafta<?elseif($lesson->price_type == 2):?>ay<?else:?>sabit<?endif;?></td>
			</tr>			
			<?endif;?>
		</table>
    </div>
		
		<?if($lesson->activities):?>
		<div class="tab-pane" id="lesson_activity_tab_<?=$lesson->id?>">
		<table class="table table-responsive prices-table">
			<tr>
				<th>İşlem Adı</th>
				<th>Eğitmen</th>
				<th>Gerçekleşen İşlem</th>
				<th>Açıklama</th>
				<th>Tarih</th>
			</tr>
			<?foreach($lesson->activities as $activity):?>
			<tr>
				<td><?=$activity->status->title?></td>
				<td><?if($activity->teacher):?><a href="<?=base_url('backend/users/edit/'.$activity->teacher->id)?>" target="_blank"><?=$activity->teacher->firstname?> <?=$activity->teacher->lastname?> (<?=$activity->teacher->mobile?>)</a><?endif;?></td>
				<td>
					<?if($activity->status_id == 4):?><?=date('d.m.Y H:i', $activity->appointment_date)?><?endif;?>
					<?if($activity->status_id == 13):?><?=$activity->lesson_hour?> saat / <?if($activity->price_type == 1):?>hafta<?elseif($activity->price_type == 2):?>ay<?else:?>sabit<?endif;?> (<?=format_price($activity->hourly_price)?> TL)<?endif;?>
					<?if($activity->status_id == 14):?><?=$activity->model->title?><?if($activity->model_price):?> (<?=format_price($activity->model_price)?> TL)<?endif;?><?endif;?>
					<?if($activity->status_id == 7):?><?if($activity->payed == 'Y'):?>Ödendi<?else:?>Ödenmedi<?endif;?>: <?=$activity->lesson_hour?> saat, <?=date('d.m.Y H:i', $activity->start_date)?> - <?=date('d.m.Y H:i', $activity->end_date)?>, <?=format_price($activity->price)?> TL<?endif;?>
				</td>
				<td><?if($activity->description):?><?=$activity->description?><?elseif($activity->status->description):?><?=$activity->status->description?><?endif;?></td>
				<td><?=nicetime($activity->create_date)?> (<?=date('d.m.Y H:i', $activity->create_date)?>)</td>
			</tr>
			<?endforeach;?>
		</table>
		</div>
		<?endif;?>

		<?if($lesson->activities_old):?>
		<div class="tab-pane" id="lesson_old_activity_tab_<?=$lesson->id?>">
		<table class="table table-responsive prices-table">
			<tr>
				<th>İşlem Adı</th>
				<th>Eğitmen</th>
				<th>Gerçekleşen İşlem</th>
				<th>Açıklama</th>
				<th>Tarih</th>
			</tr>
			<?foreach($lesson->activities_old as $activity):?>
			<tr>
				<td><?=$activity->status->title?></td>
				<td><?if($activity->teacher):?><a href="<?=base_url('backend/users/edit/'.$activity->teacher->id)?>" target="_blank"><?=$activity->teacher->firstname?> <?=$activity->teacher->lastname?> (<?=$activity->teacher->mobile?>)</a><?endif;?></td>
				<td>
					<?if($activity->status_id == 4):?><?=date('d.m.Y H:i', $activity->appointment_date)?><?endif;?>
					<?if($activity->status_id == 13):?><?=$activity->lesson_hour?> saat / <?if($activity->price_type == 1):?>hafta<?elseif($activity->price_type == 2):?>ay<?else:?>sabit<?endif;?> (<?=format_price($activity->hourly_price)?> TL)<?endif;?>
					<?if($activity->status_id == 14):?><?=$activity->model->title?><?if($activity->model_price):?> (<?=format_price($activity->model_price)?> TL)<?endif;?><?endif;?>
					<?if($activity->status_id == 7):?><?=$activity->lesson_hour?> saat, <?=date('d.m.Y H:i', $activity->start_date)?> - <?=date('d.m.Y H:i', $activity->end_date)?>, <?=format_price($activity->price)?> TL<?endif;?>
				</td>
				<td><?if($activity->description):?><?=$activity->description?><?elseif($activity->status->description):?><?=$activity->status->description?><?endif;?></td>
				<td><?=nicetime($activity->create_date)?> (<?=date('d.m.Y H:i', $activity->create_date)?>)</td>
			</tr>
			<?endforeach;?>
		</table>
		</div>
		<?endif;?>		
		
		
		</div><!--.tab-content-->
	</div><!--.panel-body-->
</section>
<?endforeach;?>
<?endif;?>

<?if(strstr(uri_string(), 'edit') == TRUE):?>
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
	  <ul class="nav nav-tabs">
	    <li class="active"><a href="#information" data-toggle="tab"><i class="fa fa-exclamation-circle text-muted"></i> Bilgi Girişi</a></li>
	    <li><a href="#assignment" data-toggle="tab"><i class="fa fa-user text-muted"></i> Eğitmen Atama</a></li>
	    <li><a href="#setmodel" data-toggle="tab"><i class="fa fa-road text-muted"></i> Çalışma Modeli Girişi</a></li>	    
	    <li><a href="#sms" data-toggle="tab"><i class="fa fa-comment text-muted"></i> SMS Gönder</a></li>
	    <li><a href="#appointment" data-toggle="tab"><i class="fa fa-bell text-muted"></i> Randevu Tarihi Girişi</a></li>
	    <li><a href="#settime" data-toggle="tab"><i class="fa fa-clock-o text-muted"></i> Ders Süresi Girişi</a></li>
	    <li><a href="#setstatus" data-toggle="tab"><i class="fa fa-retweet text-muted"></i> Durum Değişikliği</a></li>	    
	    <li><a href="#balance" data-toggle="tab"><i class="fa fa-money text-muted"></i> Alacak Girişi</a></li>	    
	    <li><a href="#potential" data-toggle="tab"><i class="fa fa-question text-muted"></i> Potansiyel Bilgi Girişi</a></li>	    
	  </ul>
	</header>
	
	<div class="card-body">
	  
	  <div class="tab-content">

	    <div class="tab-pane active" id="information">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'information' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?></option>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Tür *</label>
							<input type="radio" name="type" id="type_1" value="1"<?if($this->input->post('form_name') == 'information' && $this->input->post('type') && $this->input->post('type') == 1):?> checked<?endif;?> /> <label for="type_1">Bilgi Girişi</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="type" id="type_2" value="2"<?if($this->input->post('form_name') == 'information' && $this->input->post('type') && $this->input->post('type') == 2):?> checked<?endif;?> /> <label for="type_2">Görüşme Kaydı</label>
						</div>
					</div>
														
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Görüşülen *</label>
							<input type="radio" name="who" id="who_1" value="1"<?if($this->input->post('form_name') == 'information' && $this->input->post('who') && $this->input->post('who') == 1):?> checked<?endif;?> /> <label for="who_1">Öğrenci</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="who" id="who_2" value="2"<?if($this->input->post('form_name') == 'information' && $this->input->post('who') && $this->input->post('who') == 2):?> checked<?endif;?> /> <label for="who_2">Eğitmen</label>
						</div>
					</div>
	
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Ne Görüşüldü? *</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'information' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>	
										
				</div>   
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
				<input type="hidden" name="form_name" value="information" />
		    </form>   
	    </div> 
	    	    
	    <div class="tab-pane" id="assignment">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">
				
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'assignment' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?></option>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Eğitmen (ad, soyad, id, email, telefon numarasına göre arayınız) *</label>

							<input class="form-control teachers-ac" type="text" />

						</div>		
					</div>
	
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İşlem Açıklaması</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'assignment' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>	
					
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İptal Açıklaması (Eğitmen değiştiriliyorsa nedenini açıkça yazınız)</label>
							<textarea name="description2" rows="3" class="form-control"><?if($this->input->post('form_name') == 'assignment' && $this->input->post('description2')):?><?=htmlspecialchars($this->input->post('description2'))?><?endif;?></textarea>
						</div>
					</div>						
										
				</div>    
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
				<input type="hidden" name="form_name" value="assignment" />
				<input type="hidden" name="teacher_id" value="" />
		    </form>
	    </div>   

	    <div class="tab-pane" id="setmodel">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<?if($lesson->teacher):?>
										<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'setmodel' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?> için <?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)</option>
									<?endif;?>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Çalışma Modeli *</label>
							<select name="model" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($models as $model):?>
									<option value="<?=$model->id?>"<?if($this->input->post('form_name') == 'setmodel' && $this->input->post('model') && $this->input->post('model') == $model->id):?> selected<?endif;?>><?=$model->title?></option>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Sabit Ücret Tutarı (Sabit ücret ile anlaşıldıysa, anlaşılan tutarı giriniz)</label>
							<input type="text" name="price" class="form-control money-three" value="<?if($this->input->post('form_name') == 'setmodel' && $this->input->post('price')):?><?=$this->input->post('price')?><?endif;?>" />
						</div>		
					</div>
																						
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İşlem Açıklaması</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'setmodel' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>	
										
				</div>   
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button> 
				<input type="hidden" name="form_name" value="setmodel" />
		    </form>   
	    </div>  
	    	    
	    <div class="tab-pane" id="sms">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Kime</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<?if($lesson->teacher):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'sms' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?> için <?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)</option>
									<?endif;?>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<input type="checkbox" name="sent" value="Y"<?if($this->input->post('form_name') == 'sms' && $this->input->post('sent') == 'Y'):?> checked<?endif;?> /> SMS göndermeden SMS gönderildi olarak işaretle
						</div>		
					</div>
												
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Mesaj</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'sms' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?else:?>[OGR_NAME], [OGR_TEL], [OGR_DERS]<?endif;?></textarea>
							<strong>Kullanılabilecek kısaltmalar</strong><br />
							Öğrenci Ad Soyad: [OGR_NAME]<br />
							Öğrenci Telefon: [OGR_TEL]<br />
							Almak İstediği Ders: [OGR_DERS]<br />
							Hesap No: [BANK_INFO]<br />
						</div>
					</div>	
										
				</div>   
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">SMS GÖNDER</button> 
				<input type="hidden" name="form_name" value="sms" />
		    </form>   
	    </div>   
	    
	    <div class="tab-pane" id="appointment">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<?if($lesson->teacher):?>
										<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'appointment' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?> için <?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)</option>
									<?endif;?>
								<?endforeach;?>
							</select>
						</div>
					</div>
					
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Randevu Tarihi *</label>
						<input type="text" name="appointment_date" value="<?if($this->input->post('form_name') == 'appointment' && $this->input->post('appointment_date')):?><?=date('d.m.Y H:i', $this->input->post('appointment_date'))?><?endif;?>" class="datetimepicker form-control" />
					</div>
				</div>
							
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İşlem Açıklaması</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'appointment' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>	
										
				</div>   
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button> 
				<input type="hidden" name="form_name" value="appointment" />
		    </form>   
	    </div>  
	    	    
	    <div class="tab-pane" id="settime">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<?if($lesson->teacher):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'settime' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?> için <?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)</option>
									<?endif;?>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Tür *</label>
							<input type="radio" name="price_type" id="price_type_1" value="1"<?if($this->input->post('form_name') == 'settime' && $this->input->post('price_type') && $this->input->post('price_type') == 1):?> checked<?endif;?> /> <label for="price_type_1"> Haftalık</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="price_type" id="price_type_1" value="2"<?if($this->input->post('form_name') == 'settime' && $this->input->post('price_type') && $this->input->post('price_type') == 2):?> checked<?endif;?> /> <label for="price_type_2"> Aylık</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="price_type" id="price_type_3" value="3"<?if($this->input->post('form_name') == 'settime' && $this->input->post('price_type') && $this->input->post('price_type') == 3):?> checked<?endif;?> /> <label for="price_type_3"> Sabit</label>
						</div>
					</div>

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Kaç Saat? *</label>
							<input type="text" name="hour" class="form-control money-three" value="<?if($this->input->post('form_name') == 'settime' && $this->input->post('hour')):?><?=$this->input->post('hour')?><?endif;?>" />
						</div>		
					</div>
					
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Ücret (Haftalık veya aylık ise 1 saat ders ücreti, sabit ise anlaşılan ücret) *</label>
							<input type="text" name="price" class="form-control money-three" value="<?if($this->input->post('form_name') == 'settime' && $this->input->post('price')):?><?=$this->input->post('price')?><?endif;?>" />
						</div>		
					</div>					
																	
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İşlem Açıklaması</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'settime' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>	
										
				</div>   
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button> 
				<input type="hidden" name="form_name" value="settime" />
		    </form>   
	    </div>  

	    <div class="tab-pane" id="setstatus">
		    <form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'setstatus' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?><?if($lesson->teacher):?> için <?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)<?endif;?></option>
								<?endforeach;?>
							</select>
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Durum *</label>
							<select name="status" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<option value="5"<?if($this->input->post('form_name') == 'setstatus' && $this->input->post('status') && $this->input->post('status') == 5):?> selected<?endif;?>>Ders Başladı</option>
								<option value="8"<?if($this->input->post('form_name') == 'setstatus' && $this->input->post('status') && $this->input->post('status') == 8):?> selected<?endif;?>>İptal Edildi</option>
								<option value="15"<?if($this->input->post('form_name') == 'setstatus' && $this->input->post('status') && $this->input->post('status') == 15):?> selected<?endif;?>>Tamamlandı</option>
							</select>
						</div>
					</div>
	
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İşlem Açıklaması (İptal edildiyse nedenini giriniz)</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'setstatus' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>						
				</div>
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
				<input type="hidden" name="form_name" value="setstatus" />
		    </form>
	    </div>	    	    	     	     	    

	    <div class="tab-pane" id="balance">
		    <form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'balance' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?><?if($lesson->teacher):?> için <?=$lesson->teacher->firstname?> <?=$lesson->teacher->lastname?> (<?=$lesson->teacher->mobile?>)<?endif;?></option>
								<?endforeach;?>
							</select>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">İşlenen Ders Saati *</label>
							<input type="text" name="lesson_hour" class="form-control money-three" value="<?if($this->input->post('form_name') == 'balance' && $this->input->post('lesson_hour')):?><?=$this->input->post('lesson_hour')?><?endif;?>" />
						</div>		
					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Başlangıç Tarihi *</label>
							<input type="text" name="start_date" value="<?if($this->input->post('form_name') == 'balance' && $this->input->post('start_date')):?><?=htmlspecialchars($this->input->post('start_date'))?><?endif;?>" class="datetimepicker form-control" />
						</div>
					</div>
					
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Sonlanma Tarihi *</label>
							<input type="text" name="end_date" value="<?if($this->input->post('form_name') == 'balance' && $this->input->post('end_date')):?><?=htmlspecialchars($this->input->post('end_date'))?><?endif;?>" class="datetimepicker form-control" />
						</div>
					</div>					
										
					<div class="col-sm-3">
						<div class="form-group">
							<label class="control-label">Alacak Tutarı *</label>
							<input type="text" name="price" class="form-control money-three" value="<?if($this->input->post('form_name') == 'balance' && $this->input->post('price')):?><?=$this->input->post('price')?><?endif;?>" />
						</div>		
					</div>
						
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">İşlem Açıklaması</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'balance' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>						
				</div>
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
				<input type="hidden" name="form_name" value="balance" />
		    </form>
	    </div>
	    
	    <div class="tab-pane" id="potential">
			<form method="post" action="<?=base_url('backend/requests/edit/'.$this->uri->segment(4))?>">
				<div class="row">

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label block">Ders *</label>
							<select name="lesson" class="chosen-select">
								<option value="">-- Lütfen Seçiniz --</option>
								<?foreach($lessons as $lesson):?>
									<option value="<?=$lesson->lesson_id?>"<?if($this->input->post('form_name') == 'potential' && $this->input->post('lesson') && $this->input->post('lesson') == $lesson->lesson_id):?> selected<?endif;?>><?=$lesson->subject->title?> > <?=$lesson->level->title?></option>
								<?endforeach;?>
							</select>
						</div>
					</div>
	
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Ne Görüşüldü? *</label>
							<textarea name="description" rows="3" class="form-control"><?if($this->input->post('form_name') == 'potential' && $this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?endif;?></textarea>
						</div>
					</div>	
										
				</div>   
				<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
				<input type="hidden" name="form_name" value="potential" />
		    </form>   
	    </div> 	    	    	    	     	     	    	    
	    
	  </div><!--.tab-content-->
	</div><!--.panel-body-->
</section><!--operasyon-->
<?endif;?>

<script src="<?=base_url('public/backend/js/datepicker/bootstrap-datepicker.js')?>"></script>
<link rel="stylesheet" href="<?=base_url('public/backend/js/datepicker/datepicker.css')?>" type="text/css" />
<script>

	

jQuery(document).ready(function(){
"use strict";

  $(".teachers-ac").autocomplete({
		minLength: 3,
		source: function( request, response ) {
			var term = request.term;
			/*
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
			*/
			$.getJSON("<?=base_url('backend/users/get_ajax_teachers')?>", request, function( data, status, xhr ) {
				//cache[ term ] = data;
				 response($.map(data, function(item) {
					return {
						value: '#' + item.id + ' ' + item.firstname + ' ' + item.lastname + ' ' + item.mobile,
						label: '#' + item.id + ' ' + item.firstname + ' ' + item.lastname + ' ' + item.mobile,
						teacher_id: item.id
					}
				 }));
			});
		},
		select	: function( event, ui ) {
			$(this).closest('form').find('input[name="teacher_id"]').val(ui.item.teacher_id);
		}
  });

    
	jQuery("#town").remoteChained("#city", base_url+"backend/users/getLocations", {selected: '<?if($_REQUEST['form']['town']):?><?=$_REQUEST['form']['town']?><?else:?><?=$item->town?><?endif;?>'});
	jQuery("#city").trigger('change');
	
	$('.js-price-new').on('click', function()
	{
		var new_category_value = $(".prices-table .new #new_category option:selected").val();
		
		var cloned = $(this).closest('tr').clone();
			cloned.removeAttr('class');
			cloned.find('div').remove();
			cloned.insertBefore('.prices-table .new');
			cloned.find('select#new_category option[value='+new_category_value+']').attr('selected', 'selected');
			
		var clonedButton = cloned.find('button');
			clonedButton.text('Sil');
			clonedButton.removeClass('btn-success');
			clonedButton.removeClass('js-price-new');
			clonedButton.addClass('btn-danger');
			clonedButton.addClass('js-price-delete');				
		
		$('.prices-table .new select').removeAttr('selected');
		$('.prices-table .new select').val('').trigger("chosen:updated");
		$('.prices-table .new input[name="new[price_average][]"]').val('');
		$('.prices-table .new input[name="new[teacher_count][]"]').val('');
		$('.prices-table .new input[name="new[budget][]"]').val('');
		
		$(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});
		
		$(window).trigger('resize');
		
		return false;
	});
	
	$(document).on('click', '.js-price-delete', function(){
		$(this).closest('tr').remove();
		return false;
	});

	$('select').on('change', function(){
		$(window).trigger('resize');
	});	
	

	

	
});

function get_average_prices(selector){
	
	var city = $('#city').val();
	var town = $('#town').val();	
	var level_id = $(selector).val();
	
	var average_price = $(selector).parent().next().find("input");
	var total_teacher = $(selector).parent().next().next().find("input");
	

	
	$.getJSON(base_url + "backend/requests/get_average_prices?level_id="+level_id+"&city_id="+city+"&town_id="+town, function( res ) {
		if(res.price){
			average_price.val(res.price);
		} else {
			average_price.val('');
		}
		
		if(res.total){
			total_teacher.val(res.total);
		} else {
			total_teacher.val('');
		}
	});
}
</script>
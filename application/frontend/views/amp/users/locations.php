<div class="panel panel-default margin-bottom-20">
	<div class="panel-heading"><h4>Yeni Ders Verilen Bölge</h4></div>
	<div class="panel-body">
		<p>Ders verdiğiniz bölgeleri tanımlamak için önce ülke seçimi (Türkiye otomatik olarak seçilmiştir) daha sonra şehir seçimi yaparak, görünür duruma gelen bölgeleri seçip, ekle butonuna basınız.</p>
		<p class="grey-text">Türkiye dışında bir ülke seçtiğinizde yalnızca şehir seçmeniz yeterlidir. Bölgeler çıkmayacaktır.</p>
		<form  action="<?=site_url('users/add_location')?>" method="post" class="ajax-location-form">
			<div class="row">	

				<div class="form-group col-md-12">
					<label>Şehir</label>
					<select name="city" id="city" data-name="city" class="form-control">
						<option value="">-- Lütfen Seçiniz --</option>	
						<?foreach($cities as $item):?>
						<option value="<?=$item->id?>"<?if($this->input->post('city') == $item->id):?> selected<?endif;?>><?=$item->title?></option>	
						<?endforeach;?>						
					</select>
				</div>
				
				<div class="form-group col-md-12">
					<div id="towns"></div>
				</div>
				
				<div class="clearfix"></div>									
				
				<div class="col-md-12">
					<button type="submit" class="btn btn-orange js-submit-btn">Ekle</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
				</div>								
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>

<div id="mylocations"></div>

<script id="towns_tmpl" type="text/x-tmpl">
	{{if $data.items.length > 0}}
	<div class="row">
	<div class="col-md-12"><label>Bölgeler</label></div>
	{{each(prop, val) $data.items}}
	<div class="col-md-4 alphabetic">
		<input type="checkbox" name="town[]" id="town_${val.id}" value="${val.id}" /> <label for="town_${val.id}">${val.name}</label>
	</div>
	{{/each}}
	</div>
	{{/if}}
</script>

<script id="mylocations_tmpl" type="text/x-tmpl">
<div class="panel panel-default">
	<div class="panel-heading"><h4>Tanımlı Bölgeler</h4></div>
	<div class="panel-body">
		<table class="table table-responsive">
			<thead>
				<tr>
					<th width="100%">Lokasyon Adı</th>
					<th>İşlemler</th>
				</tr>
			</thead>
			<tbody>
				{{each(prop, val) $data.items}}
				<tr>
					<td style="vertical-align:middle">${val.city_title}{{if val.town_title}} > ${val.town_title}{{/if}}</td>
					<td><a class="btn btn-orange" onclick="delete_location('${val.id}')"><i class="fa fa-trash-o"></i> Sil</a></td>
				</tr>
				{{/each}}				
			</tbody>
		</table>
	</div>
</div>
</script>
<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Yeni Ders Verilen Bölge</h4>
	</div>
	<div class="card-body">
		<p>Ders verdiğiniz bölgeleri tanımlamak için önce ülke seçimi (Türkiye otomatik olarak seçilmiştir) daha sonra şehir seçimi yaparak, görünür duruma gelen bölgeleri seçip, ekle butonuna basınız.</p>
		<form  action="<?=site_url('users/add_location')?>" method="post" class="ajax-location-form">
			<div class="row">

				<div class="form-group col-12">
					<label>Şehir</label>
					<select name="city" id="city" data-name="city" class="form-control">
						<option value="">-- Lütfen Seçiniz --</option>
						<?foreach($cities as $item):?>
						<option value="<?=$item->id?>"<?if($this->input->post('city') == $item->id):?> selected<?endif;?>><?=$item->title?></option>
						<?endforeach;?>
					</select>
				</div>

				<div class="form-group col-12">
					<div id="towns"></div>
				</div>

				<div class="clearfix"></div>

				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
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
	<div class="col-12"><label>Bölgeler</label></div>
	{{each(prop, val) $data.items}}
	<div class="col-md-4 alphabetic">
		<input type="checkbox" name="town[]" id="town_${val.id}" value="${val.id}" /> <label for="town_${val.id}">${val.title}</label>
	</div>
	{{/each}}
	</div>
	{{/if}}
</script>

<script id="mylocations_tmpl" type="text/x-tmpl">
<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Tanımlı Ders Verilen Bölgeler</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th width="100%">Lokasyon Adı</th>
						<th>İşlemler</th>
					</tr>
				</thead>
				<tbody>
					{{each(prop, val) $data.items}}
					<tr>
						<td>${val.city_title}{{if val.town_title}} > ${val.town_title}{{/if}}</td>
						<td align="center"><img src="<?=base_url('public/img/action-delete.svg')?>" class="js-link" onclick="delete_location('${val.id}')" width="13" height="13" /></td>
					</tr>
					{{/each}}
				</tbody>
			</table>
		</div>
	</div>
</div>
</script>

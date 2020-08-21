<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Yeni Ders Ücreti</h4>
	</div>
	<div class="card-body">
		<p>Ders ücreti tanımlamak için önce konu seçiniz. Konu seçtikten sonra görünür duruma gelen konuya ait dersleri seçiniz ve ücretlerini de girerek ekle butonuna basınız.</p>
		<p class="grey-text">Birden fazla aynı ücretteki dersleri seçerek tek seferde bu dersler için ücret tanımlaması yapabilirsiniz. Ders ücreti farklı olan derslerin ücret tanımlamasını ayrı ayrı yapmanız gerekmektedir. Ders ücreti tanımlamanız tamamlandığında, dilediğiniz zaman aşağıda yer alan tanımlı ders ücretlerim alanından ders ücretlerinizi değiştirebilirsiniz.</p>
		<form  action="<?=site_url('users/add_price')?>" method="post" class="ajax-price-form">
			<div class="row">

				<div class="form-group col-12">
					<label>Konu <span class="font-size-11"></span></label>
					<select name="subject" id="price_new_subject" data-url="<?=site_url('users/prices/?subject_levels=1')?>" class="form-control">
						<option value="">-- Lütfen Seçiniz --</option>
						<?foreach($subjects as $item):?>
						<option value="<?=$item->id?>"<?if($this->input->post('subject') == $item->id):?> selected<?endif;?>><?=$item->title?></option>
						<?endforeach;?>
					</select>
					<small>Dersler ve ücret tanımlama alanları konu seçiminden sonra görünür duruma gelmektedir.</small>
				</div>

			</div>

			<div class="row" id="levels"></div>

			<div class="row">

				<div class="form-group col-lg-6 mt-2 d-none lesson-price-inputs">
					<label>Özel Ders Ücreti (TL)</label>
					<input type="text" name="price_private" class="form-control" placeholder="50" />
				</div>

				<div class="form-group col-lg-6 mt-2 d-none lesson-price-inputs">
					<label>Canlı Ders Ücreti (TL)</label>
					<input type="text" name="price_live" class="form-control" placeholder="40" />
				</div>

				<div class="col-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Ekle</button>
					<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</div>

<a id="add_price"></a>

<form action="<?=site_url('users/update_price')?>" method="POST" class="ajax-form js-dont-reset">
<div id="prices"></div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>

<script id="levels_tmpl" type="text/x-tmpl">
	<div class="col-12"><label>Dersler</label></div>
	{{each(prop, val) $data.items}}
	<div class="col-lg-4">
		<input type="checkbox" name="level[]" id="level_${val.id}" value="${val.id}" /> <label for="level_${val.id}">${val.title}</label>
	</div>
	{{/each}}
</script>

<script id="prices_tmpl" type="text/x-tmpl">
<div class="card box-shadow mb-4">
	<div class="card-header">
		<h4 class="mb-0 pt-3 pb-3">Tanımlı Ders Ücretleri</h4>
	</div>
	<div class="card-body">
		<p>Ücret belirlediğiniz derslere tanıtım yazısı yazarak profilinizi ziyaret eden öğrencilerin sayısını arttırabilirsiniz. Tanıtım yazısı yazdığınız dersler için özel sayfalar oluşturuyoruz ve profilinizi daha fazla öğrencinin ziyaret etmesini sağlıyoruz.</p>
		<p>Tanıtım yazısı yazmak istediğiniz dersin sırasındaki <u>Tanıtım</u> altındaki ikona veya ders adına tıklayarak o ders için tanıtım yazısı ekleyebilir veya daha önceden eklemiş olduğunuz tanıtım yazısını değiştirebilirsiniz.</p>
		<p>Ders tanıtımı alanındaki görsellerin anlamları aşağıdadır:</p>
		<p>
			<ul class="list-group list-group-flush">
			<li class="list-group-item"><img src="<?=base_url('public/img/messaging-declined.svg')?>" width="13" height="13" /> ders tanıtımı yapılmadı</li>
			<li class="list-group-item"><img src="<?=base_url('public/img/messaging-info.svg')?>" width="13" height="13" /> ders tanıtımı onay bekliyor</li>
			<li class="list-group-item"><img src="<?=base_url('public/img/messaging-success.svg')?>" width="13" height="13" /> ders tanıtımı yapıldı ve onaylandı</li>
			</ul>
		</p>
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Ders Adı</th>
					<th>Özel Ders Ücreti (TL)</th>
					<th>Canlı Ders Ücreti (TL)</th>
					<th class="text-center">Tanıtım</th>
					<th>İşlemler</th>
				</tr>
			</thead>
			<tbody>
				{{each(prop, val) $data.items}}
				<tr>
					<td class="align-middle"><a href="<?=site_url('users/prices_text')?>/${val.id}">${val.subject_title} > ${val.level_title}</a></td>
					<td><input type="text" name="price_private[${val.id}]" class="form-control" value="${val.price_private}" /></td>
					<td><input type="text" name="price_live[${val.id}]" class="form-control" value="${val.price_live}" /></td>
					<td class="align-middle text-center">
						<a href="<?=site_url('users/prices_text')?>/${val.id}">
						{{if !val.status}}
						<img src="<?=base_url('public/img/messaging-declined.svg')?>" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Ders tanıtımı yapılmadı" />
						{{else val.status == 'W'}}
						<img src="<?=base_url('public/img/messaging-info.svg')?>" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Ders tanıtımı onay bekliyor" />
						{{else}}
						<img src="<?=base_url('public/img/messaging-success.svg')?>" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Ders tanıtımı yapıldı" />
						{{/if}}
						</a>
					</td>
					<td class="align-middle text-center"><img src="<?=base_url('public/img/action-delete.svg')?>" class="js-link" onclick="delete_price('${val.id}')" width="13" height="13" data-toggle="tooltip" data-placement="top" title="Sil" /></td>
				</tr>
				{{/each}}
			</tbody>
		</table>
		</div>

		<div class="row">
			<div class="col-12">
				<button type="submit" class="btn btn-primary js-submit-btn">Güncelle</button>
				<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
			</div>
		</div>
	</div>
</div>
</script>

<div class="panel panel-default margin-bottom-20">
	<div class="panel-heading"><h4>Yeni Ders Ücreti</h4></div>
	<div class="panel-body">
		<p>Ders ücreti tanımlamak için önce konu seçiniz. Konu seçtikten sonra görünür duruma gelen konuya ait dersleri seçiniz ve ücretlerini de girerek ekle butonuna basınız.</p>
		<p class="grey-text">Birden fazla aynı ücretteki dersleri seçerek tek seferde bu dersler için ücret tanımlaması yapabilirsiniz. Ders ücreti farklı olan derslerin ücret tanımlamasını ayrı ayrı yapmanız gerekmektedir. Ders ücreti tanımlamanız tamamlandığında, dilediğiniz zaman aşağıda yer alan tanımlı ders ücretlerim alanından ders ücretlerinizi değiştirebilirsiniz.</p>
		<form  action="<?=site_url('users/add_price')?>" method="post" class="ajax-price-form">
			<div class="row">	
				
				<div class="form-group col-md-12">
					<label>Konu <span class="font-size-11"></span></label>
					<select name="subject" id="price_new_subject" data-url="<?=site_url('users/prices/?subject_levels=1')?>" class="form-control">
						<option value="">-- Lütfen Seçiniz --</option>	
						<?foreach($subjects as $item):?>
						<option value="<?=$item->id?>"<?if($this->input->post('subject') == $item->id):?> selected<?endif;?>><?=$item->title?></option>	
						<?endforeach;?>
					</select>
					<span class="font-size-11 lightgrey-text">Dersler ve ücret tanımlama alanları konu seçiminden sonra görünür duruma gelmektedir.</span>
				</div>
				
				<div id="levels"></div>
				
				<div class="clearfix"></div>
				
				<div class="form-group col-md-6 margin-top-10">
					<label>Özel Ders Ücreti (TL)</label>
					<input type="text" name="price_private" class="form-control" placeholder="50" />
				</div>						
				
				<div class="form-group col-md-6 margin-top-10">
					<label>Canlı Ders Ücreti (TL)</label>
					<input type="text" name="price_live" class="form-control" placeholder="40" />
				</div>											
				
				<div class="col-md-12">
					<button type="submit" class="btn btn-orange js-submit-btn">Ekle</button>
					<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
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
	<div class="col-md-12"><label>Dersler</label></div>
	{{each(prop, val) $data.items}}
	<div class="col-md-4">
		<input type="checkbox" name="level[]" id="level_${val.id}" value="${val.id}" /> <label for="level_${val.id}">${val.title}</label>
	</div>
	{{/each}}
</script>

<script id="prices_tmpl" type="text/x-tmpl">
<div class="panel panel-default">
	<div class="panel-heading"><h4>Tanımlı Ders Ücretleri</h4></div>
	<div class="panel-body">
		<p>Eklediğiniz derslere tanıtım yazısı yazarak profilinizi ziyaret eden öğrencilerin sayısını arttırabilirsiniz. Biz, tanıtım yazısı yazdığını dersler için özel sayfalar oluşturarak, profilinizi daha fazla öğrencinin ziyaret etmesini sağlıyoruz.</p>
		<p>Tanıtım yazısı yazmak istediğiniz dersin sırasındaki <u>Ders Tanıtımı</u> altındaki görsele tıklayarak, o ders için tanıtım yazısı ekleyebilir veya daha önceden eklemiş olduğunuz tanıtım yazısını değiştirebilirsiniz.</p>
		<p>Ders tanıtımı alanındaki görsellerin anlamları aşağıdadır:</p>
		<p>
			<ul class="clear-list font-size-13 grey-text">
			<li><i class="fa fa-file-o"></i> ders tanıtımı yapılmadı</li>
			<li><i class="fa fa-hourglass-half"></i> ders tanıtımı onay bekliyor</li>			
			<li><i class="fa fa-file-text-o"></i> ders tanıtımı yapıldı ve onaylandı</li>
			</ul>
		</p>
		<table class="table table-responsive">
			<thead>
				<tr>
					<th>Ders Adı</th>
					<th>Özel Ders Ücreti (TL)</th>
					<th>Canlı Ders Ücreti (TL)</th>
					<th>Ders Tanıtımı</th>
					<th>İşlemler</th>
				</tr>
			</thead>
			<tbody>
				{{each(prop, val) $data.items}}
				<tr>
					<td style="vertical-align:middle">${val.subject_title} > ${val.level_title}</td>
					<td><input type="text" name="price_private[${val.id}]" class="form-control" value="${val.price_private}" /></td>
					<td><input type="text" name="price_live[${val.id}]" class="form-control" value="${val.price_live}" /></td>
					<td align="center">
						<a href="<?=site_url('users/prices_text')?>/${val.id}">
						{{if !val.status}}
						<i class="fa fa-file-o"></i>
						{{else val.status == 'W'}}
						<i class="fa fa-hourglass-half"></i>
						{{else}}
						<i class="fa fa-file-text-o"></i>
						{{/if}}						
						</a>
					</td>
					<td><a class="btn btn-orange" onclick="delete_price('${val.id}')"><i class="fa fa-trash-o"></i> Sil</a></td>
				</tr>
				{{/each}}				
			</tbody>
		</table>
		
		<div class="row">	
			<div class="col-md-12">
				<button type="submit" class="btn btn-orange js-submit-btn">Güncelle</button>
				<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
			</div>								
		</div>
	</div>
</div>
</script>
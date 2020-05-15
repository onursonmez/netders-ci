<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="#"><?=lang('USERS')?></a></li>
	<li class="active">Telefonları Kontrol Et</li>
</ul>

<?if($this->input->post()):?>
<section class="panel panel-default" style="margin-bottom:15px;">
	<header class="panel-heading bg-light">
		Kayıtlı Telefon Numaraları
	</header>
	<div class="panel-body">
		<?if(empty($phones)):?>
		Kayıtlı telefon numarası bulunamadı.
		<?else:?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th># id</th>
					<th>Ad Soyad</th>
					<th>Telefon Numarası</th>
				</tr>
			</thead>
			<tbody>
				<?foreach($phones as $phone):?>
				<tr>
					<td># <?=$phone->id?></td>
					<td><?=$phone->firstname?> <?=$phone->lastname?></td>
					<td><?=$phone->mobile?></td>
				</tr>
				<?endforeach;?>
			</tbody>			
		</table>
		<?endif;?>
	</div>
</section>
<?endif;?>

<form method="post" action="<?=base_url('backend/users/phonescheck')?>" onsubmit="return prepareSubmit(this);">
<section class="panel panel-default">
	<header class="panel-heading bg-light">
		Telefonları Kontrol Et
	</header>
	<div class="panel-body">
			<div class="row">
								
				<div class="col-md-12">
					<div class="form-group">
						<label class="control-label">Telefon Numaraları</label>
						<p>Her satıra bir telefon numarası gelecek şekilde telefon numaralarını yapıştırınız.</p>
						<textarea name="phones" rows="20" class="form-control"><?=$this->input->post('phones')?></textarea>
					</div>
				</div>
		
			</div>
		</div>
</section>
<button class="btn btn-default pull-right m-t" type="submit" name="submit">KONTROL ET</button>
</form>
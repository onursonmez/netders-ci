<section class="panel panel-default">
	<header class="panel-heading">
		Ozelders.com Bot
	</header>
	
	<div class="card-body">
		<form method="GET" action="<?=current_url()?>">
			<div class="row">
				<div class="col-md-4">
					<input type="text" name="url" placeholder="url" value="<?if($this->input->get('url')):?><?=$this->input->get('url')?><?else:?><?=$this->input->cookie('last_bots_ozelders_url')?><?endif;?>" class="form-control" />
				</div>
				<div class="col-md-4">
					<input type="text" name="page" value="<?if($this->input->get('page') != null):?><?=$this->input->get('page') + 10?><?else:?><?if($this->input->cookie('last_bots_ozelders_page')):?><?=$this->input->cookie('last_bots_ozelders_page')?><?else:?>0<?endif;?><?endif;?>" class="form-control" />
				</div>
				<div class="col-md-4">
					<input type="submit" value="Getir" class="btn btn-default" />
					<?if($this->input->get()):?>
						<a href="<?=current_url()?>?url=<?=$this->input->get('url')?>&page=<?=$this->input->get('page')?>" class="btn btn-default">Yenile</a>
					<?endif;?>
				</div>
			</div>
		</form>
	</div>
</section>

<?if(!empty($items)):?>
<?foreach($items as $item):?>
<?if($item['hakkinda'] || $item['hakkinda']):?>
<form method="POST" action="<?=current_url()?>" id="form_<?=$item['id']?>">
	<section class="panel panel-default m-t">
		<header class="panel-heading">
			<?=$item->firstname?> <?=$item->lastname?>
			<span class="pull-right"><a onclick="add(<?=$item['id']?>); return false;" href="#">Ekle</a></span>
			<div class="clearfix"></div>
		</header>
		<div class="card-body">
			<div class="row">
				<div class="col-md-2">
					<div class="row">
						<div class="form-group col-md-12">
							<img src="<?=$item['image']?>" class="img-thumbnail" />
						</div>
					</div>
				</div>
				<div class="col-md-10">
					<div class="row">
						<div class="form-group col-md-3">
							<label>Ad</label>
							<input type="text" name="firstname" value="<?=$item['firstname']?>" class="form-control" />
						</div>
						<div class="form-group col-md-3">
							<label>Soyad</label>
							<input type="text" name="lastname" value="<?=$item['lastname']?>" class="form-control" />
						</div>
						<div class="form-group col-md-6">
							<label>Başlık</label>
							<input type="text" name="title" value="<?=$item['title']?>" class="form-control" />
						</div>
						<div class="form-group col-md-1">
							<label>İl</label>
							<input type="text" name="city" value="<?=$item['city']?>" class="form-control" />
						</div>
						<div class="form-group col-md-1">
							<label>İlçe</label>
							<input type="text" name="town" value="<?=$item['town']?>" class="form-control" />
						</div>
						<div class="form-group col-md-2">
							<label>Ücret</label>
							<input type="text" name="price" value="<?=$item['price']?>" class="form-control" />
						</div>
						<div class="form-group col-md-1">
							<label>Cinsiyet</label>
							<input type="text" name="gender" value="<?=$item['gender']?>" class="form-control" />
						</div>						
						<div class="form-group col-md-1">
							<label>Yaş</label>
							<input type="text" name="age" value="<?=$item['age']?>" class="form-control" />
						</div>
						<div class="form-group col-md-1">
							<label>Şekil</label>
							<input type="text" name="sekil" value="<?=$item['sekil']?>" class="form-control" />
						</div>			
						<div class="form-group col-md-1">
							<label>Mekan</label>
							<input type="text" name="mekan" value="<?=$item['mekan']?>" class="form-control" />
						</div>			
						<div class="form-group col-md-2">
							<label>Zaman</label>
							<input type="text" name="zaman" value="<?=$item['zaman']?>" class="form-control" />
						</div>			
						<div class="form-group col-md-2">
							<label>Hizmet</label>
							<input type="text" name="hizmet" value="<?=$item['hizmet']?>" class="form-control" />
						</div>															
						<div class="form-group col-md-12">
							<label>Kısa Açıklama</label>
							<input type="text" name="short" value="<?=$item['short']?>" class="form-control" />
						</div>
						<div class="form-group col-md-12">
							<label>Eğitim Bilgileri</label>
							<textarea rows="5" name="egitim" class="form-control"><?=$item['egitim']?></textarea>
						</div>
						<?if(!empty($item['no_levels'])):?>
						<div class="form-group col-md-12">
							<label>Bulunamadı</label>
							<?=$item['no_levels']?>
						</div>					
						<?endif;?>	
						<div class="form-group col-md-6">
							<label>Konular</label>
							<input type="text" name="konular" value="<?=$item['konular']?>" class="form-control" />
						</div>			
						<div class="form-group col-md-6">
							<label>Dersler</label>
							<input type="text" name="dersler" value="<?=$item['dersler']?>" class="form-control" />
						</div>									
						<div class="form-group col-md-12">
							<label>Hakkında</label>
							<textarea rows="5" name="hakkinda" class="form-control"><?=$item['hakkinda']?></textarea>
						</div>				
						<div class="form-group col-md-12">
							<label>Tecrübe</label>
							<textarea rows="5" name="tecrube" class="form-control"><?=$item['tecrube']?></textarea>
						</div>																	
					</div>
				</div>
			</div>
		</div>
	</section>
	<input type="hidden" name="id" value="<?=$item['id']?>" />
	<input type="hidden" name="url" value="<?=$item['url']?>" />
	<input type="hidden" name="image" value="<?=$item['image']?>" />
</form>
<?endif;?>
<?endforeach;?>
<?endif;?>

<audio id="my_audio" src="<?=site_url('ad/zil.mp3')?>" loop="loop"></audio>

<script>
	function add(id){
		
		$.post(base_url + 'backend/bots/ozeldersadd', $('#form_'+id).serialize(), function( res ) {
			var res = $.parseJSON(res);

			if(res.csrf_name && res.csrf_hash)
			$('input[name="'+res.csrf_name+'"]').val(res.csrf_hash);
						
			if(res.res == 'ok'){
				$('#form_'+id).fadeOut('slow');
			} else {
				alert(res.msg);
			}
			return false;	
		});	
	}

	$(window).load(function() {
		$("#my_audio").get(0).play();
		setTimeout(function(){
			$("#my_audio").get(0).pause();	
		}, 3000);
	});		
</script>
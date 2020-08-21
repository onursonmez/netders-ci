<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="#"><?=lang('USERS')?></a></li>
	<li class="active"><?if($this->uri->segment(3) == 'add'):?><?=lang('USERS_NEW')?><?else:?>Onay Bekleyen Fotoğraflar<?endif;?></li>
</ul>

<section class="panel panel-default">
	<header class="panel-heading bg-light">
		Onay Bekleyen Fotoğraflar
	</header>
	<div class="card-body">
		<div class="row">
			<?if(!empty($items)):?>
			<?foreach($items as $item):?>
			<form method="post" action="<?=current_url()?>">
				<div class="col-lg-2">
					<div class="thumbnail">
						<div class="image06">
						    <img class="imgB" alt="" src="<?=base_url($item->photo_request)?>" width="100%" />
						    <?if($item->photo):?>
						    <img class="imgT" alt="" src="<?=base_url($item->photo)?>" width="100%" />
						    <div class="caption">Eski Fotoğraf</div>
						    <?endif;?>
						    <select name="crop_area" class="form-control m-t">
								<option value="C">Orta</option>					    
							    <option value="L">Sol</option>
							    <option value="R">Sağ</option>
							    <option value="T">Üst</option>
							    <option value="B">Alt</option>
						    </select>
						    <select name="rotate" class="form-control m-t">
								<option value="">-- Döndür --</option>					    
								<option value="270">Sola Döndür</option>					    
							    <option value="90">Sağa Döndür</option>
						    </select>						    
						</div>
	
						<div class="caption">
							<p class="text-ellipsis text-center"><a href="<?=base_url('backend/users/edit/'.$item->id)?>" target="_blank"><?=$item->username?></a></p> 
							<p id="social-buttons" class="m-b-none text-center">
				                <button type="submit" name="submit" value="approve" class="btn btn-rounded btn-sm btn-icon btn-primary"><i class="fa fa-check"></i></button>
				                <button type="submit" name="submit" value="disapprove" class="btn btn-rounded btn-sm btn-icon btn-default"><i class="fa fa-trash-o"></i></button>
							</p>
						</div>
					</div>
				</div><!--.col-lg-2-->
				<input type="hidden" name="id" value="<?=$item->id?>">
			</form>
			<?endforeach;?>
			<?else:?>
			<div class="col-lg-12">Onay bekleyen fotoğraf bulunmamaktadır.</div>
			<?endif;?>
		</div>	
	</div>
</section>
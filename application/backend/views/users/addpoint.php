<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="#"><?=lang('USERS')?></a></li>
	<li class="active"><?=lang('USERS_POINTS_NEW')?></li>
</ul>

<form method="post" action="<?=base_url('backend/users/addpoint')?>" onsubmit="return prepareSubmit(this);">
<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=lang('USERS_POINTS_NEW')?>
	</header>
	<div class="card-body">
			<div class="row">
								
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Kullanıcı</label>
						<select name="uid" class="chosen-select">
							<?foreach($users as $user):?><option value="<?=$user->id?>"<?if($_REQUEST['uid'] == $user->id):?> selected<?endif;?>><?=$user->firstname?> <?=$user->lastname?> (<?=$user->username?>)</option><?endforeach;?>
						</select>
					</div>
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">İşlem Adı</label>
						<select name="tag" class="chosen-select">
							<?foreach($tags as $tag):?><option value="<?=$tag->id?>"<?if($_REQUEST['tag'] == $tag->id):?> selected<?endif;?>><?=$tag->description?></option><?endforeach;?>
						</select>
					</div>		
				</div>
				
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">İşlem Tipi</label>
						<select name="operation" class="chosen-select">
							<option value="1"<?if($_REQUEST['operation'] == 1):?> selected<?endif;?>>Ekle</option>
							<option value="2"<?if($_REQUEST['operation'] == 2):?> selected<?endif;?>>Çıkar</option>
						</select>
					</div>		
				</div>				
	
				<div class="col-sm-3">
					<div class="form-group">
						<label class="control-label">Puan</label>
						<input type="text" name="point" value="<?=htmlspecialchars($_REQUEST['point'])?>" class="form-control" />
					</div>
				</div>									

				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label block">Açıklama (opsiyonel)</label>
						<textarea name="description" class="form-control" rows="4"><?if($_REQUEST['description']):?><?=htmlspecialchars($_REQUEST['description'])?><?else:?><?=$item->description?><?endif;?></textarea>
					</div>		
				</div>
						
			</div>
		</div>
</section>



<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
</form>
<section class="panel panel-default">
<header class="panel-heading bg-light">Yeni Dil Değişkeni Ekle</header>
<div class="card-body">
  <form method="post" action="<?=current_url()?>" class="form-horizontal">
	
	<div class="form-group">
	    <label class="col-lg-2 control-label">Değişken Kodu</label>
	    <div class="col-lg-10">
	        <input type="text" name="key" value="<?if($this->input->get_post('key')):?><?=htmlspecialchars($this->input->get_post('key'))?><?else:?><?=htmlspecialchars($item->key)?><?endif;?>" class="form-control" />
	    </div>
	</div>
	
	<div class="form-group">
	    <label class="col-lg-2 control-label">Açıklama</label>
	    <div class="col-lg-10">
	        <textarea name="value" rows="5" class="form-control"><?if($this->input->get_post('value')):?><?=htmlspecialchars($this->input->get_post('value'))?><?else:?><?=htmlspecialchars($item->value)?><?endif;?></textarea>
	    </div>
	</div>
	
	<button class="btn btn-default pull-right" type="submit" name="submit"><?=lang('SAVE')?></button>
  </form>
</div>
</section>


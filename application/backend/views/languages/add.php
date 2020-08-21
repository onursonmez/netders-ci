<section class="panel panel-default">
<header class="panel-heading bg-light">Yeni Dil Ekle</header>
<div class="card-body">
  <form method="post" action="<?=current_url()?>" class="form-horizontal">
	
	<div class="form-group">
	    <label class="col-lg-2 control-label">Dil Adı</label>
	    <div class="col-lg-10">
	        <input type="text" name="name" value="<?if($this->input->get_post('name')):?><?=htmlspecialchars($this->input->get_post('name'))?><?else:?><?=htmlspecialchars($item->name)?><?endif;?>" class="form-control" />
	    </div>
	</div>
	
	<div class="form-group">
	    <label class="col-lg-2 control-label">Dil Kodu</label>
	    <div class="col-lg-10">
	        <input type="text" name="code" value="<?if($this->input->get_post('code')):?><?=htmlspecialchars($this->input->get_post('code'))?><?else:?><?=htmlspecialchars($item->lang_code)?><?endif;?>" class="form-control" />
	    </div>
	</div>
		
	<div class="form-group">
	    <label class="col-lg-2 control-label">Durum</label>
	    <div class="col-lg-10">
	        <select name="status" class="form-control">
	        	<option value="A"<?if($this->input->get_post('status') == 'A' || $item->status == 'A'):?> selected<?endif;?>>Aktif</option>
	        	<option value="I"<?if($this->input->get_post('status') == 'I' || $item->status == 'I'):?> selected<?endif;?>>Pasif</option>
	        </select>
	    </div>
	</div>
	
	<?if($this->uri->segment(3) == 'add'):?>
	<div class="form-group">
	    <label class="col-lg-2 control-label">Şundan Aktar</label>
	    <div class="col-lg-10">
	        <select name="language" class="form-control">
				<?foreach(site_languages() as $item):?>
				<option value="<?=$item->id?>" <?if($this->input->get_post('language') == $item->id):?>selected<?endif;?>><?=$item->name?></option>
				<?endforeach;?>
	        </select>
	    </div>
	</div>
	<?endif;?>
	
	<button class="btn btn-default pull-right" type="submit" name="submit"><?=lang('SAVE')?></button>
  </form>
</div>
</section>


<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=lang('SLIDERS_NEW')?> 
		<span class="pull-right"><a href="<?=base_url('backend/sliders')?>"><i class="fa fa-reply"></i> Geri Dön</a></span>
	</header>
	<div class="card-body">
	  <form method="post" action="<?=base_url('backend/sliders')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">
	
			<div class="form-group">
				<label class="col-lg-2 control-label">Başlık</label>
				<div class="col-lg-10">
					<input type="text" name="title" value="<?if($_REQUEST['title']):?><?=htmlspecialchars($_REQUEST['title'])?><?else:?><?=htmlspecialchars($item->title)?><?endif;?>" class="form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-2 control-label">Durum</label>
				<div class="col-lg-10">
			        <select name="status" class="form-control">
	                    <option value="A"<?if($_REQUEST['status'] == 'A' || $item->status == 'A'):?> selected<?endif;?>>Aktif</option>
	                    <option value="I"<?if($_REQUEST['status'] == 'I' || $item->status == 'I'):?> selected<?endif;?>>Pasif</option>
			        </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-2 control-label">Aktif Bölümler</label>
				<div class="col-lg-10">
                    <?foreach(site_languages(true) as $language):?>
                        <input name="languages[]" type="checkbox" value="<?=$language->lang_code?>"<?if($item->lang_code && in_array($language->lang_code, $item->lang_code)):?> checked<?endif;?> id="lang_<?=$language->lang_code?>"> <label for="lang_<?=$language->lang_code?>"><?=$language->name?></label>&nbsp;&nbsp;&nbsp;
                    <?endforeach;?>
				</div>
			</div>			
	
			<button class="btn btn-default pull-right" type="submit" name="submit">KAYDET</button>
	    </form>
	</div>
</section>
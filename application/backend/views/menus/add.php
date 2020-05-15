<? $languages = site_languages(true); ?>

<section class="panel panel-default">
<header class="panel-heading bg-light">
  <ul class="nav nav-tabs">
    <?foreach($languages as $lang):?>
    <li<?if($lang->lang_code == DESCR_SL):?> class="active"<?endif;?>><a href="#lang-<?=$lang->lang_code?>" data-toggle="tab"><i class="flag flag-muted flag-<?=$lang->lang_code?> text-muted"></i> <?=$lang->name?></a></li>
    <?endforeach;?>
  </ul>
</header>
<div class="panel-body">
  <form method="post" action="<?=base_url('backend/menus')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">
  <div class="tab-content">
    <?foreach($languages as $lang):?>
    <div class="tab-pane<?if($lang->lang_code == DESCR_SL):?> active<?endif;?>" id="lang-<?=$lang->lang_code?>">
		<?if(strstr(uri_string(), 'edit') == TRUE && !empty($item[$lang->lang_code]->title)):?>
		<div class="clear m-b">
			<a class="btn btn-default btn-xs pull-right" onclick="confirmation('Lütfen dikkat!', 'İçerik &quot;<?=$lang->name?>&quot; dilinde kalıcı olarak silinecektir', '<?=base_url('backend/contents/deletelang/'.$this->uri->segment(4).'/'.$lang->lang_code)?>'); return false;" href="#"><i class="fa fa-trash-o"></i> <?=$lang->name?> içeriği sil</a>
		</div>
		<?endif;?>           
                    
		<div class="form-group">
			<label class="col-lg-2 control-label">Menü Adı</label>
			<div class="col-lg-10">
				<input type="text" name="lang[<?=$lang->lang_code?>][title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->title)?><?endif;?>" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-lg-2 control-label">Durum</label>
			<div class="col-lg-10">
		        <select name="lang[<?=$lang->lang_code?>][status]" class="form-control">
                    <option value="A"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'A' || $item[$lang->lang_code]->status == 'A'):?> selected<?endif;?>>Aktif</option>
                    <option value="I"<?if($_REQUEST['lang'][$lang->lang_code]['status'] == 'I' || $item[$lang->lang_code]->status == 'I'):?> selected<?endif;?>>Pasif</option>
		        </select>
			</div>
		</div>
    </div>
    <?endforeach;?>
    
    <button class="btn btn-default pull-right" type="submit" name="submit"><?=lang('SAVE')?></button>
    </form>

  </div>
</div>
</section>
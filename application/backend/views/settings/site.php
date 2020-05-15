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
  <form method="post" action="<?=base_url('backend/settings/site')?>" class="form-horizontal" enctype="multipart/form-data">
  <div class="tab-content">
    <?foreach($languages as $lang):?>
    <div class="tab-pane<?if($lang->lang_code == DESCR_SL):?> active<?endif;?>" id="lang-<?=$lang->lang_code?>">
		

		    
            <div class="form-group">
                <label class="col-lg-2 control-label">Sayfa Başlığı</label>
                <div class="col-lg-10">
                    <input type="text" name="lang[<?=$lang->lang_code?>][seo_title]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_title']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_title'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_title)?><?endif;?>" class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Meta Açıklama</label>
                <div class="col-lg-10">
                    <input type="text" name="lang[<?=$lang->lang_code?>][seo_description]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_description']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_description'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_description)?><?endif;?>" class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-lg-2 control-label">Meta Anahtar Kelimeler</label>
                <div class="col-lg-10">
                    <input type="text" name="lang[<?=$lang->lang_code?>][seo_keyword]" value="<?if($_REQUEST['lang'][$lang->lang_code]['seo_keyword']):?><?=htmlspecialchars($_REQUEST['lang'][$lang->lang_code]['seo_keyword'])?><?else:?><?=htmlspecialchars($item[$lang->lang_code]->seo_keyword)?><?endif;?>" class="form-control" />
                </div>
            </div>

           <?if($item[$lang->lang_code]->logo):?>
            <div class="form-group">
                <label class="col-lg-2 control-label">Yüklü Logo</label>
                <div class="col-lg-10">
	                <img src="<?=site_url().$item[$lang->lang_code]->logo?>" style="max-width:800px;" />
				</div>
            </div>
            <?endif;?>

            <div class="form-group">
                <label class="col-lg-2 control-label">Site Logosu</label>
                <div class="col-lg-4">
					<input type="file" name="lang[<?=$lang->lang_code?>][logo]" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">	                
                </div>
            </div>

		<button class="btn btn-default pull-right" type="submit" onclick="$('form.form-horizontal').submit();"><?=lang('SAVE')?></button>
		<input type="hidden" name="lang[<?=$lang->lang_code?>][current_logo]" value="<?=$item[$lang->lang_code]->logo?>" />
    </div><!-- /.tab-pane -->
    <?endforeach;?>
    </form>
  </div>
</div>
</section>

<script src="<?=base_url('public/backend/js/file-input/bootstrap-filestyle.min.js')?>"></script>
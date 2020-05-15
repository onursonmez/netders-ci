<section class="panel panel-default">
<header class="panel-heading bg-light">İçeri Dil Yükle</header>
<div class="panel-body">
  <form method="post" action="<?=current_url()?>" class="form-horizontal" enctype="multipart/form-data">
	
    <div class="form-group">
        <label class="col-lg-2 control-label">Dil Dosyası</label>
        <div class="col-lg-4">
			<input type="file" name="dump" class="filestyle" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">	                
        </div>
    </div>
            	
	<button class="btn btn-default pull-right" type="submit" name="submit"><?=lang('SAVE')?></button>
  </form>
</div>
</section>

<script src="<?=base_url('public/backend/js/file-input/bootstrap-filestyle.min.js')?>"></script>
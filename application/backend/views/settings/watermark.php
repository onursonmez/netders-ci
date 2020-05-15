<section class="panel panel-default">
<header class="panel-heading bg-light">
  <?=lang('SETTINGS_WATERMARK')?>
</header>
<div class="panel-body">
  <form method="POST" action="<?=base_url('backend/settings/watermark')?>" class="form-horizontal" enctype="multipart/form-data">
  <div class="tab-content">

	        <p>Filigran (ing. watermark), eklediğiniz içerikler ve galeri resimlerinin üzerine yapıştırılan metin veya imajdır. Eğer hem metin filigran hem de imaj filigran tanımlarsanız öncelik imaj filigranındır. Filigran tanımlamanızı yaptıktan sonra yukarıda yer alan <u>İçerik resimlerinde filigran (watermark) kullan</u> seçeneğini <u>evet</u> olarak işaretleyiniz.</p>
			
			<div class="line line-dashed b-b line-lg pull-in"></div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Metin Filigran</label>
				<div class="col-lg-9">
					<input type="text" name="form[watermark_text]" data-input="false" value="<?if($_REQUEST['form']['watermark_text']):?><?=htmlspecialchars($_REQUEST['form']['watermark_text'])?><?else:?><?=htmlspecialchars($item->watermark_text)?><?endif;?>" class="form-control input-s-lg" />
				</div>
			</div>

			<?if($item->watermark_image):?>			
			<div class="line line-dashed b-b line-lg pull-in"></div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Yüklü Görsel Filigran</label>
				<div class="col-lg-9">
					<img src="<?=site_url().$item->watermark_image?>" /><br />
					<a onclick="confirmation('Lütfen Dikkat!', 'Filigran kalıcı olarak silinecektir. Devam etmek istediğinizden emin misiniz?', '<?=base_url('backend/settings/watermark/delete')?>');" class="btn btn-xs btn-danger m-t-sm"><i class="fa fa-trash-o"></i> Mevcut filigranı Sil</a>
				</div>
			</div>
			<?endif;?>
			
			<div class="line line-dashed b-b line-lg pull-in"></div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Görsel Filigran</label>
				<div class="col-lg-5">
					<input type="file" name="watermark_image" data-classButton="btn btn-default" data-classInput="form-control inline v-middle input-s">
				</div>
			</div>
			
			<button class="btn btn-default pull-right" type="submit" onclick="return checkImage('form-horizontal');">KAYDET</button>
    </div>
    <input type="hidden" name="form[current_watermark]" value="<?=$item->watermark_image?>" />
    </form>
</div>
</section>

<script type="text/javascript" src="<?=base_url('public/backend/js/file-input/bootstrap-filestyle.min.js')?>"></script>
<script>$(":file").filestyle({buttonText: "Dosya Seçiniz", buttonName: "btn-default", iconName: "fa fa-folder-open-o"});</script>

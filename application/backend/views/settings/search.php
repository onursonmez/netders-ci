<ul class="breadcrumb">
	<li><a href="<?=base_url('backend')?>"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="<?=base_url('backend/settings')?>">Ayarlar</a></li>
	<li class="active">Arama Terimleri</li>
</ul>

<form method="post" action="<?=base_url('backend/settings/search')?>">
<section class="panel panel-default">
	<header class="panel-heading bg-light">
		Yeni Arama Terimi
	</header>
	<div class="panel-body">
			<div class="row">
								
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Anahtar Kelime *</label>
						<input type="text" name="keyword" class="form-control" />
					</div>
				</div>
				
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label">Dersler</label>
						<div class="input-group">
						  <span class="input-group-btn">
						    <button class="select-category btn btn-default" type="button">Lütfen Seçiniz</button>
						  </span>
						  <input type="text" name="ctitles" class="ctitles-categories form-control" disabled="disabled" />
						  <input type="hidden" name="cids" class="cids-categories" />
						</div>
					</div> 
				</div> 		
						
			</div>
		</div>
</section>
<input type="hidden" name="form_name" value="new" />
<button class="btn btn-default pull-right m-t" type="submit" name="submit">EKLE</button>
</form>

<div class="clearfix"></div>

<?if(!empty($items)):?>
<form method="post" action="<?=base_url('backend/settings/search')?>">
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		Arama Terimleri
	</header>
	<div class="panel-body">
			<div class="row">
				<?foreach($items as $item):?>
				<div class="col-md-3">
					<div class="form-group">
						<label class="control-label">Anahtar Kelime *</label>
						<input type="text" name="keyword[<?=$item->id?>]" class="form-control" value="<?=$item->keyword?>" />
					</div>
				</div>
				
				<div class="col-md-9">
					<div class="form-group">
						<label class="control-label">Dersler</label>
						<input type="text" name="cids[<?=$item->id?>]" class="form-control" value="<?=$item->lesson_ids?>" />
					</div> 
				</div> 	
				<?endforeach;?>	
						
			</div>
		</div>
</section>
<input type="hidden" name="form_name" value="update" />
<button class="btn btn-default pull-right m-t" type="submit" name="submit">GÜNCELLE</button>
</form>
<?endif;?>

<!-- categories modal start -->
<link rel="stylesheet" href="<?=base_url('public/backend/js/nestable/nestable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/js/nestable/jquery.nestable.js')?>"></script>

<script>

$(document).ready(function() 
{
	$('.select-category').click(function(e){

		e.preventDefault();
				
		var lang_code = window.location.hash.substr(6) ? window.location.hash.substr(6) : '<?=DESCR_SL?>';
		
		$('.modal-categories').modal('show');
				
	});
	
	$('.dd').nestable({draggable: false, group: 1});
	
	$('.categories-list-control').on('click', function(e){

        var target = $(e.target), action = target.data('action');
        
        if (action === 'expand-all') {
            $(this).parents('.modal-body').find('.dd').nestable('expandAll');
        }
        
        if (action === 'collapse-all') {
            $(this).parents('.modal-body').find('.dd').nestable('collapseAll');
        }
	});
});

function savecategories(lang_code)
{
	var ids = new Array();
	var titles = new Array();
	$(".modal-categories input:checked").each(function() {
	      ids.push($(this).attr('data-id'));
	      titles.push($(this).attr('data-title'));
	});
	
	$('.ctitles-categories').val(titles.join(', '));
	$('.cids-categories').val(ids.join(','));
	
	$('.modal-categories').modal('hide');
}
</script>

<div class="modal modal-categories">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Kategoriler</h4>
			</div>
			<div class="modal-body">
				<form class="dd-form"><div class="dd"><?=$categories?></div></form>
				<div class="categories-list-control btn-group pull-right"><a data-action="expand-all" class="btn btn-sm btn-default m-t-sm"><i class="fa fa-plus-circle"></i> Tümünü aç</a><a data-action="collapse-all" class="btn btn-sm btn-default m-t-sm"><i class="fa fa-minus-circle"></i> Tümünü kapat</a></div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-primary" onclick="savecategories()">Kaydet</a>
				<a class="btn btn-default" data-dismiss="modal">İptal</a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- categories modal end -->

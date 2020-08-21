<? $languages = site_languages(true); ?>

<section class="panel panel-default">
<header class="panel-heading text-right bg-light">
  <ul class="nav nav-tabs pull-left">
    <?foreach($languages as $lang):?>
    <li<?if($lang->lang_code == DESCR_SL):?> class="active"<?endif;?>><a href="#lang-<?=$lang->lang_code?>" data-toggle="tab"><i class="flag flag-muted flag-<?=$lang->lang_code?> text-muted"></i> <?=$lang->name?></a></li>
    <?endforeach;?>
  </ul>
  
  <span><a href="<?=base_url('backend/contents/addcategory')?>"><i class="fa fa-plus"></i> <?=lang('CONTENTS_CATEGORIES_NEW')?></a></span>
  
</header>
<div class="card-body">

<form method="post" action="<?=base_url('backend/contents')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal">
  <div class="tab-content">
    <?foreach($languages as $lang):?>
    <div class="tab-pane<?if($lang->lang_code == DESCR_SL):?> active<?endif;?>" id="lang-<?=$lang->lang_code?>">
				
		<div class="dd dd-<?=$lang->lang_code?>" data-lang="<?=$lang->lang_code?>">
			<?if($items[$lang->lang_code]):?><?=$items[$lang->lang_code]?><?endif;?>
		</div>
				
		<div class="categories-list-control btn-group pull-right">
			<a href="#" data-action="expand-all" class="btn btn-sm btn-default m-t-sm"><i class="fa fa-plus-circle"></i> Tümünü aç</a>
			<a href="#" data-action="collapse-all" class="btn btn-sm btn-default m-t-sm"><i class="fa fa-minus-circle"></i> Tümünü kapat</a>
		</div>
    </div>
    <?endforeach;?>	
  </div>
</form>

<!-- nestable tools start -->
<link rel="stylesheet" href="<?=base_url('public/backend/js/nestable/nestable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/js/nestable/jquery.nestable.js')?>"></script>

<script>
+function ($) { "use strict";
	
	$(function(){
	
		$('.dd').nestable()
		.on('change', function(event){
			  var lang_code = $(this).closest('div').attr('data-lang');
			  var categories = JSON.stringify($('.dd-'+lang_code).nestable('serialize'));
			  $.ajax({
			    type: 'POST',
			    url: base_url+'backend/contents/updatecategories',
			    dataType: 'json',
			    data: {'categories': categories},
			    success: function(msg) {
			      $.growl(msg);
			    }
			  });
		});

		$('.categories-list-control').on('click', function(e)
	    {
	        var target = $(e.target),
	            action = target.data('action');
	        if (action === 'expand-all') {
	            $(this).prev('.dd').nestable('expandAll');
	        }
	        if (action === 'collapse-all') {
	            $(this).prev('.dd').nestable('collapseAll');
	        }
	    });
	    
	    $('.btn').on('click', function(){
	    	var url = $(this).attr('href');
	    	//alert(url + location.hash); return false;
	    	if(location.hash){
		    	window.location = url + location.hash;
		    	return false;
	    	}
	    });
    	
	});
	
}(window.jQuery);
</script>
<!-- nestable tools end -->
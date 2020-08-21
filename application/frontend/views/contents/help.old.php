<?
	$items = $category->id == 2 && !$this->input->get('q') ? $popular : $items;
?>
<section class="background-header padding-10 padding-bottom-30">
<div class="container">
	<div class="row">
		<div class="col-lg-12 text-center">
			<h1>Yardım</h1>
			<p class="lead">Merak ettiğiniz tüm soruların cevapları</p>
		</div>
		<div class="col-lg-8 col-lg-offset-2">
            <form action="<?=_make_link('contents_categories', 2)?>" method="get" id="search-form" autocomplete="off">
				<div class="input-group" >
					<input name="q" type="text" value="<?=$this->input->get('q', true)?>" placeholder="Lütfen merak ettiğiniz konu ile ilgili kelimeler yazınız..." class="form-control big-input" />
					<span class="input-group-btn">
					<button class="big-button btn-lightred" type="submit"><i class="fa fa-search"></i> Ara</button>
					</span>
				</div><!-- /input-group -->
			</form>
		</div>
	</div><!-- End row -->
</div><!-- End container -->
</section>

<section class="margin-top-30 margin-bottom-30">
    <div class="container">

	<?if(!empty($breadcrumb)):?>
		<ol class="breadcrumb">
			<?foreach($breadcrumb as $value):?>
				<?if(!empty($value['link']) && $value['link'] != current_url()):?>
					<li><a href="<?=$value['link']?>"><?=$value['title']?></a></li>
				<?else:?>
					<li class="active"><?=$value['title']?></li>
				<?endif;?>
			<?endforeach;?>
		</ol>
	<?endif;?>

	<div class="row">
		<!--
		<div class="col-md-12">
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Uyarı!</strong> Yardım sayfasında içerik geliştirme çalışmaları yapılmaktadır. Çalışmanın tahmini bitiş tarihi 1 Kasım 2016 olarak planlanmıştır.
			</div>
		</div>
		-->

		<div class="col-sm-3">
			<div class="panel panel-default">
			<div class="card-body">
			<h3>Yardım Konuları</h3>
			<ul class="clear-list">
			<?foreach($help_categories as $help_category):?>
			<?$link = _make_link('contents_categories', $help_category->category_id)?>
			<li><a href="<?=$link?>"<?if($link == current_url()):?> class="active"<?endif;?>><?=str_replace('-', '<i class="fa fa-angle-double-right"></i> ', substr($help_category->delimiter, 1))?> <?=$help_category->title?> (<?=$help_category->count?>)</a></li>
			<?endforeach;?>
			</ul>
			</div>
			</div>
		</div>
		<div class="col-sm-9">
		    <div class="row">
		    	<div class="col-md-12">
		    	<?if($category->category_id == 2):?>
		    		<?if($this->input->get('q')):?>
				        <h2>Arama Sonuçları</h2>
				        <?if(!empty($total)):?>
				        <p>Arama sonuçlarına uygun <?=$total?> kayıt bulundu.</p>
				        <?endif;?>
		    		<?else:?>
		    			<?if(!empty($items)):?>
				        <h2>Popüler Yardım Konuları</h2>
								<small>En çok aşağıdaki yardım konuları incelenmiş</small>
							<?endif;?>
			      <?endif;?>
		      <?else:?>
		        <h2><?=$category->title?></h2>
		        <small><?=$category->title?> kategorisine ait yardım konuları</small>
	        <?endif;?>
		        </div>
		    </div>

    		<div class="row">
    			<?if(empty($items)):?>
	    			<div class="col-sm-12">
		    			Üzgünüz, kriterlere uygun yardım konusu bulunamamıştır. Lütfen kriterleri değiştirip tekrar deneyiniz. Yardıma ihtiyacınız mı var? Hemen bizimle <a href="<?=_make_link('contents', 37)?>">iletişim</a> kurun.
	    			</div>
    			<?else:?>
    				<hr>
	    			<?foreach($items as $key => $item):?>
					<div class="col-md-12">
						<h4 class="media-heading"><a href="<?=_make_link('contents', $item->content_id)?>"><?=$item->title?></a></h4>
						<div class="m-t m-b text-muted">
							<small>
								<span class="margin-right-10"><i class="fa fa-clock-o"></i> <?if($item->up_date):?><?=strftime("%d %b %Y", $item->up_date)?><?else:?><?=strftime("%d %b %Y", $item->start_date)?><?endif;?></a></span>
								<span class="margin-right-10"><i class="fa fa-folder-o"></i> <a href="<?=_make_link('contents_categories', $item->main_category)?>"><?=$item->category_name->title?></a></span>
								<?if(!empty($item->views)):?><span><i class="fa fa-eye"></i> <?=$item->views?> görüntülenme</a></span><?endif;?>
							</small>
						</div>
						<p><?=my_mb_substr(txtFirstUpper(strip_tags($item->description)), 230)?></p>
						<?if($key + 1 < sizeof($items)):?><hr /><?endif;?>
				     </div>
				     <?endforeach;?>
			     <?endif;?>
    		</div>
		</div>
	</div>

    <?if(!empty($pages)):?>
	<hr>
    <div class="text-center">
        <ul class="pagination">
            <?foreach($pages as $page):?>
            <li<?if($page['current']):?> class="active"<?endif;?>><a href="<?=$page['link']?>"><?=$page['title']?></a></li>
            <?endforeach;?>
        </ul><!-- end pagination-->
    </div>
    <?endif;?>


    </div><!-- End container -->
</section>

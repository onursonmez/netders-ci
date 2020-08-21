<?
	$items = $category->id == 2 && !$this->input->get('q') ? $popular : $items;
?>

<div class="container">

	<div class="card box-shadow mb-4 position-relative overflow-hidden">
		<div class="position-absolute bottom-0 left-0 right-0 d-none d-lg-flex flex-row-fluid">
			<span class="svg-icon svg-icon-full flex-row-fluid svg-icon-dark opacity-03">
				<img src="img/home-2.svg" />
			</span>
		</div>
		<div class="position-absolute d-flex top-0 left-0 col-lg-6 opacity-1 opacity-lg-100">
			<span class="svg-icon svg-icon-full flex-row-fluid p-4">
				<img src="img/home-1.svg" />
			</span>
		</div>
		<div class="card-body mt-4 mb-4">
			<div class="row">
				<div class="col-lg-12 text-center">
					<h1 class="text-dark font-weight-bolder mb-2">
						Yardım
					</h1>
					<p class="lead mb-4">Netders.com hakkında merak ettiğiniz soruların cevaplarını bulabileceğiniz Yardım sayfasına hoş geldiniz.</p>
					<form action="<?=_make_link('contents_categories', 2)?>" method="get" id="search-form" autocomplete="off">
						<div class="row mb-2">
							<div class="col-sm-6 offset-sm-2">
								<div class="form-group">
									<input type="text" name="q" value="<?=$this->input->get('q', true)?>" class="form-control border border-primary" placeholder="Yardım konusu arayın...">
								</div>
							</div>
							<div class="col-sm-2">
								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-block"><img class="align-middle" src="<?=base_url('public/img/form-search-white.svg')?>" width="13" height="13" /> Ara</button>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="col-lg-12">
					<div class="d-flex flex-wrap justify-content-center">
					<?foreach($help_categories as $help_category):?>
					<?$link = _make_link('contents_categories', $help_category->category_id)?>
					<div class="p-2"><a href="<?=$link?>"<?if($link == current_url()):?> class="active"<?endif;?>><?=str_replace('-', '<i class="fa fa-angle-double-right"></i> ', substr($help_category->delimiter, 1))?> <?=$help_category->title?> <span class="badge badge-primary"><?=$help_category->count?></span></a></div>
					<?endforeach;?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="card box-shadow rounded-top">
		<div class="card-header">
			<?if($category->category_id == 2):?>
				<?if($this->input->get('q')):?>
						<h2>Arama Sonuçları</h2>
						<?if(!empty($total)):?>
							Arama sonuçlarına uygun <?=$total?> kayıt bulundu
						<?endif;?>
				<?else:?>
					<?if(!empty($items)):?>
						<h2>Popüler Yardım Konuları</h2>
						En çok aşağıdaki yardım konuları incelenmiş
					<?endif;?>
				<?endif;?>
			<?else:?>
				<h2><?=$category->title?></h2>
				<?=$category->title?> kategorisine ait yardım konuları
			<?endif;?>
		</div>
		<div class="card-body">
			<?if(empty($items)):?>
					Üzgünüz, kriterlere uygun yardım konusu bulunamamıştır. Lütfen kriterleri değiştirip tekrar deneyiniz. Yardıma ihtiyacınız mı var? Hemen bizimle <a href="<?=_make_link('contents', 37)?>">iletişim</a> kurun.
			<?else:?>
				<?foreach($items as $key => $item):?>
					<div class="media media-list mt-4">
						<div class="media-body">
							<h4 class="mt-0 mb-2"><a href="<?=_make_link('contents', $item->content_id)?>"><?=$item->title?></a></h4>
							<div class="small mb-2">
								<span class="text-muted mr-3"><img class="align-text-top" src="<?=base_url('public/img/form-date-gray.svg')?>" width="13" height="13"> <?if($item->up_date):?><?=strftime("%d %b %Y", $item->up_date)?><?else:?><?=strftime("%d %b %Y", $item->start_date)?><?endif;?></span>
								<span class="text-muted mr-3"><img class="align-text-top" src="<?=base_url('public/img/form-file-gray.svg')?>" width="13" height="13"> <a href="<?=_make_link('contents_categories', $item->main_category)?>"><?=$item->category_name->title?></a></span>
								<span class="text-muted"><img class="align-text-top" src="<?=base_url('public/img/damage-glasses-gray.svg')?>" width="13" height="13"> <?=$item->views?> görüntüleme</span>
							</div>
							<p class="mb-0"><?=my_mb_substr(txtFirstUpper(strip_tags($item->description)), 230)?></p>
						</div>
					</div>
				 <?endforeach;?>
		 		<?endif;?>

				<?if(!empty($pages)):?>
				<nav aria-label="Page navigation" class="mt-4">
					<ul class="pagination">
							<?foreach($pages as $page):?>
							<li class="page-item<?if($page['current']):?> active<?endif;?>"><a href="<?=$page['link']?>" class="page-link"><?=$page['title']?></a></li>
							<?endforeach;?>
					</ul>
				</nav>
				<?endif;?>



		</div>
	</div>
</div>

<div class="container">
	<div class="card box-shadow rounded-top">
		<?if(!empty($breadcrumb)):?>
			<div class="card-header">
				<nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
						<?foreach($breadcrumb as $value):?>
						<?if(!empty($value['link']) && $value['link'] != current_url()):?>
            <li class="breadcrumb-item"><a href="<?=$value['link']?>"><?=$value['title']?></a></li>
						<?else:?>
						<li class="breadcrumb-item"><?=$value['title']?></li>
						<?endif;?>
            <?endforeach;?>
          </ol>
        </nav>
			</div>
		<?endif;?>
		<div class="card-body">
			<h2 class="text-dark font-weight-bolder mb-4">
				<?=$category->title?>
			</h2>

			<?if(!empty($items)):?>
					<?foreach($items as $key => $item):?>
					<div class="media media-list mt-4">
						<div class="media-body">
							<h4 class="mt-0 mb-2"><a href="<?=_make_link('contents', $item->id)?>"><?=$item->title?></a></h4>
							<div class="small mb-2">
								<span class="text-muted"><img class="align-text-top" src="<?=base_url('public/img/form-date-gray.svg')?>" width="13" height="13"> <?=strftime("%d %B %Y, %H:%M", $item->start_date)?></span>
							</div>
							<p class="mb-0"><?=my_mb_substr(txtFirstUpper(strip_tags($item->description)), 200)?> <a href="<?=_make_link('contents', $item->id)?>"><?=lang('MORE')?></a></p>
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

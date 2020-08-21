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
				<?=$item->title?>
			</h2>

			<?=htmlspecialchars_decode($item->description)?>
		</div>
	</div>
</div>

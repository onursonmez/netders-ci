<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=$item->title?> <span class="text-muted small">(<?=date('d.m.Y H:i', $item->date)?> / IP: <?=$item->ip?>)</span>
	</header>
	<div class="panel-body">
		<?$formdata = unserialize($item->body)?>
		<?foreach($formdata as $key =>$form):?>
			<div class="clearfix m-b"><strong><?=lang($key)?>:</strong> <?=$form?></div>
		<?endforeach;?>
		
		<a href="<?=base_url('backend/forms')?>" class="btn btn-default m-t">Geri dön</a>
 	</div>
</section>
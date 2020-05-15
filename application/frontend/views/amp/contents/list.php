<div class="section-white">
<div class="container">
<?if(!empty($breadcrumb)):?>
	<ol class="breadcrumb">
		<?foreach($breadcrumb as $value):?>
			<?if(!empty($value['link']) && $value['link'] != current_url()):?>
				<li><a href="<?=amp_url($value['link'])?>"><?=$value['title']?></a></li>
			<?else:?>
				<li class="active"><?=amp_url($value['title'])?></li>
			<?endif;?>
		<?endforeach;?>
	</ol>
<?endif;?>

<h2 class="margin-bottom-20"><?=$category->title?></h2>
<?if(!empty($items)):?>
	<div class="row">
		<?foreach($items as $key => $item):?>
		<div class="col-lg-12">
			<h4 class="margin-bottom-0"><a href="<?=amp_url(_make_link('contents', $item->id))?>"><?=$item->title?></a></h4>

			<span class="font-size-12 grey-text"><i class="fa fa-clock-o"></i> <?=strftime("%d %B %Y, %H:%M", $item->start_date)?></span>
			
			<p class="margin-bottom-0"><?=my_mb_substr(txtFirstUpper(strip_tags($item->description)), 200)?></p>
							
			<p><a href="<?=amp_url(_make_link('contents', $item->id))?>"><?=lang('MORE')?></a></p>
		</div>
		<?endforeach;?>		
	</div>
<?endif;?>

   <?if(!empty($pages)):?>
    <div class="text-center">
        <ul class="pagination">
            <?foreach($pages as $page):?>
            <li<?if($page['current']):?> class="active"<?endif;?>><a href="<?=$page['link']?>"><?=$page['title']?></a></li>
            <?endforeach;?>
        </ul><!-- end pagination-->
    </div>
    <?endif;?>		

        
	</div>
</div>
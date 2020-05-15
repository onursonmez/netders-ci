<div class="section-white">
	<div class="container">
		<?if(!empty($breadcrumb)):?>
			<ul class="breadcrumb">
				<?foreach($breadcrumb as $value):?>
					<?if(!empty($value['link']) && $value['link'] != current_url()):?>
						<li><a href="<?=amp_url($value['link'])?>"><?=$value['title']?></a></li>
					<?else:?>
						<li class="active"><?=$value['title']?></li>
					<?endif;?>
				<?endforeach;?>
			</ul>
		<?endif;?>

		<h2 class="margin-bottom-20"><?=$item->title?></h2>
		<?if(isset($main_image->original)):?><img src="<?=base_url($main_image->original)?>" class="pull-left margin-right-20" align="left" /><?endif;?>
		
		<?=htmlspecialchars_decode(strip_tags($item->description))?>
	
		<?if(!empty($teachers->users)):?>
		<?$search=base64_encode(site_url('ozel-ders-ilanlari-verenler/'.seo($item->city_title).'/?keyword='.$item->keyword))?>
		<div class="row margin-top-20 margin-bottom-20">
			<div class="col-md-12">
				<div id="carousel">
					<?foreach($teachers->users as $user):?>
					<div class="item">
						<div class="panel panel-default user-box" style="max-width:100%;">
							<div class="panel-body">
								<div class="image"><a href="<?=site_url($user->username)?>?search=<?=$search?>"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" class="img-padding-border img-circle" style="max-width:60%;" width="60%" /></a></div>
								<div class="title"><strong class="margin-top-10"><a href="<?=site_url($user->username)?>?search=<?=$search?>"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></strong></div>
								<ul class="extra">
									<li><i class="fa fa-money"></i> <?if($user->virtual == 'Y'):?><?=$user->virtual_price?><?else:?><?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?><?endif;?> TL</li>
									<li><i class="fa fa-calendar-o"></i> <?=calculate_age($user->birthday)?> yaşında</li>
									<li><i class="fa fa-map-marker"></i> <?=$user->city_title?>, <?=$user->town_title?></li>
								</ul>
								<div class="title-bottom"><?if(strlen($user->levels) > 80):?><?=mb_substr($user->levels, 0, 80, 'utf-8')?>...<?else:?><?=$user->levels?><?endif;?></div>
							</div>
						</div>
					</div>
					<?endforeach;?>
				</div>	
			</div>
			<div class="col-md-12 text-center"><a href="<?=site_url('ozel-ders-ilanlari-verenler/'.seo($item->city_title).'/?keyword='.$item->keyword)?>" class="btn btn-orange margin-top-20">Diğer "<?=$item->title?>" Konusunda Özel Ders Veren Eğitmenler</a></div>
		</div>
		<?endif;?>		
				
		
		<?if(!empty($images) && sizeof($images) > 1):?>
			<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
			    <div class="slides"></div>
			    <h3 class="title"></h3>
			    <a class="prev">‹</a>
			    <a class="next">›</a>
			    <a class="close">×</a>
			    <a class="play-pause"></a>
			    <ol class="indicator"></ol>
			</div>
			
			<hr>
			
			<div class="row">
				<div id="blueimp_image_groups">
				<?foreach($images as $image):?>
				<div class="col-xs-6 col-md-3 m-t-lg">
					<a class="thumbnail" href="<?=base_url($image->original)?>">
						<img alt="<?=$image->description?>" data-src="<?=base_url($image->original)?>" src="<?=base_url($image->thumbnail)?>">
					</a>
				</div>
				<?endforeach;?>
				</div>
			</div>
		<?endif;?>    
	</div><!-- End container -->
</div>



<?if(!empty($images)):?>
<link rel="stylesheet" href="<?=base_url('public/vendor/blueimp/css/blueimp-gallery.min.css')?>">
<script src="<?=base_url('public/vendor/blueimp/js/blueimp-gallery.min.js')?>"></script>
<script>
document.getElementById('blueimp_image_groups').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
</script>
<?endif;?>





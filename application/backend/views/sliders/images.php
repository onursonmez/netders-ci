<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=lang('SLIDER_IMAGES')?>
		<span class="pull-right"><a href="<?=base_url('backend/sliders/addimages/'.$this->uri->segment(4))?>"><i class="fa fa-plus"></i> <?=lang('SLIDER_NEW_IMAGE')?></a></span> 
	</header>
	<div class="panel-body">
		<?if(sizeof($items) > 0):?>
		<select onchange="window.location.href=this.value">
	        <?foreach(site_languages(true) as $language):?>
	           <option value="<?=base_url('backend/sliders/images/'.$this->uri->segment(4).'?lang_code='.$language->lang_code)?>" <?if($this->input->get('lang_code') == $language->lang_code):?> selected<?endif;?>><?=$language->name?></option>
	        <?endforeach;?>			
		</select>
		<form method="post" action="<?=current_url()?>" class="form-horizontal">
		<table class="table table-striped b-t b-light">
			<thead>
              <tr>
                <th>Görsel</th>
                <th>Bulunduğu Bölümler</th>                
                <th width="100">Sıra</th>
                <th width="30">İşlemler</th>
              </tr>
            </thead>
			<tbody>	
				<?foreach($items as $item):?>
				<tr>
					<td>
		                <?if($item->photos):?>
		                <img src="<?=site_url() . $item->photos[0]->thumbnail?>" />
		                <div class="small"><?=sizeof($item->photos)?> Görsel</div>
		                <?endif;?>
					</td>
					<td>
						<?$item->lang_code = explode(',', $item->lang_code)?>
	                    <?foreach(site_languages(true) as $key => $language):?>
	                        <?if($item->lang_code && in_array($language->lang_code, $item->lang_code)):?> <?=$language->name?><?if(sizeof($item->lang_code) > $key + 1):?>, <?endif;?><?endif;?>
	                    <?endforeach;?>
					</td>
					<td>
		                <input type="text" class="form-control" name="position[<?=$item->id?>]" value="<?=$item->position?>" />
					</td>					
					<td>
						<a href="<?=base_url('backend/sliders/editimages/'.$item->id)?>" title="<?=lang('EDIT')?>" data-toggle="tooltip" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
		            	<a onclick="confirmation('<?=lang('WARNING')?>', 'Görsel kalıcı olarak silinecektir.', '<?=base_url('backend/sliders/deleteimages/'.$item->id)?>')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
				<?endforeach;?>
			</tbody>
		</table>
		<button class="btn btn-primary pull-right m-t" type="submit" name="submit">KAYDET</button>
		<a href="<?=base_url('backend/sliders')?>" class="btn btn-default pull-left m-t">GERİ DÖN</a>
		</form>
		<?else:?>
		    <?=lang('CONTENTS_EMPTY')?>
		<?endif;?>		
	</div>
</section>
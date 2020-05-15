<form name="generate" method="POST" action="<?=current_url()?>">
	<section class="panel panel-default">
		<header class="panel-heading bg-light">
			Yapay Zeka Cümlesi Oluştur
			<span class="pull-right"><a href="#" onclick="document.generate.submit();"><i class="fa fa-cog"></i> <?=lang('GENERATE')?></a></span>
		</header>
		<div class="panel-body">
			<div class="table-responsive" style="width:1375px;overflow-x:scroll!important;">
				<table class="table">
					<thead>
						<tr>
							<th>Anahtar kelime</th>
							<th>URL</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><input type="text" name="keyword" class="form-control" value="<?=$this->input->post('keyword')?>" /></td>
							<td><input type="text" name="url" class="form-control" value="<?=$this->input->post('url')?>" /></td>
						</tr>																										
					</tbody>						
				</table>
			</div>	
		</div>
	</section>
	<input type="hidden" name="form_name" value="generate" />
</form>

<?if($this->input->post('form_name') == 'generate'):?>
	<section class="panel panel-default m-t">
		<header class="panel-heading bg-light">
			Oluşturulan Yapay Zeka Cümlesi
		</header>
		<div class="panel-body">
			<?=$generated_word?>	
		</div>
	</section>
<?else:?>
	<form name="new" method="POST" action="<?=current_url()?>">
		<section class="panel panel-default m-t">
			<header class="panel-heading bg-light">
				Yeni Yapay Zeka Cümlesi
				<span class="pull-right"><a href="#" onclick="document.new.submit();"><i class="fa fa-check"></i> <?=lang('SAVE')?></a></span>
			</header>
			<div class="panel-body">
				<div class="table-responsive" style="width:1375px;overflow-x:scroll!important;">
					<table class="table">
						<thead>
							<tr>
								<?for($i=1;$i<=25;$i++):?>
								<th>Kelime <?=$i?></th>
								<?endfor;?>
								<th>Zorunlu (Y/N)</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<?for($i=1;$i<=25;$i++):?>
								<td>
									<textarea style="min-width:200px;" rows="5" name="phase[<?=$i?>]" class="form-control"><?if($_REQUEST['phase'.$i]):?><?=htmlspecialchars($_REQUEST['phase'.$i])?><?endif;?></textarea>
								</td>
								<?endfor;?>
								<td>
									<select name="status" class="form-control">
										<option value="A"<?if($_REQUEST['status'] == 'A'):?> selected<?endif;?>>Aktif</option>
										<option value="I"<?if($_REQUEST['status'] == 'I'):?> selected<?endif;?>>Pasif</option>
									</select>
								</td>							
							</tr>																										
						</tbody>						
					</table>
				</div>	
			</div>
		</section>
		<input type="hidden" name="form_name" value="new" />
	</form>
	
	<?if(!empty($words)):?>
	<form name="update" method="POST" action="<?=current_url()?>">
	<section class="panel panel-default m-t">
		<header class="panel-heading bg-light">
			Yapay Zeka Cümleleri (Anahtar kelime içeren: <?=$total_words[0]?>, içermeyen: <?=$total_words[1]?>)
			<span class="pull-right"><a href="#" onclick="document.update.submit();"><i class="fa fa-refresh"></i> <?=lang('UPDATE')?></a></span>
		</header>
		<div class="panel-body">
			<div class="table-responsive" style="width:1375px;overflow-x:scroll!important;">
				<table class="table">
					<thead>
						<tr>
							<?for($i=1;$i<=25;$i++):?>
							<th>Kelime <?=$i?></th>
							<?endfor;?>
							<th>Zorunlu (Y/N)</th>
						</tr>
					</thead>
					<tbody>
						<?foreach($words as $word):?>
						<tr>
							<?for($i=1;$i<=25;$i++):?>
							<td>
								<?$phase = 'phase'.$i?>
								<textarea style="min-width:200px;" rows="5" name="phase[<?=$word->id?>][<?=$i?>]" class="form-control"><?if($_REQUEST['phase'.$i]):?><?=htmlspecialchars($_REQUEST['phase'.$i])?><?else:?><?=$word->$phase?><?endif;?></textarea>
							</td>
							<?endfor;?>
							<td>
								<select name="status[<?=$word->id?>]" class="form-control">
									<option value="A"<?if($_REQUEST['status'][$word->id] == 'A' || $word->status == 'A'):?> selected<?endif;?>>Aktif</option>
									<option value="I"<?if($_REQUEST['status'][$word->id] == 'I' || $word->status == 'I'):?> selected<?endif;?>>Pasif</option>
								</select>
								<a href="<?=base_url('backend/contents/words_test/'.$word->id)?>" class="btn btn-default">Test</a>							
							</td>						
						</tr>	
						<?endforeach;?>																									
					</tbody>						
				</table>
			</div>	
		</div>
	</section>
	<input type="hidden" name="form_name" value="update" />
	</form>
	<?endif;?>
<?endif;?>
<? $languages = site_languages(true); ?>

<section class="panel panel-default">
<header class="panel-heading bg-light">
	<?=$name?> grubu için izinler
</header>
<div class="card-body">
  <form method="post" action="<?=current_url()?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">

			<?if(!empty($permissions)):?>
			<div class="form-group">
				<label class="col-lg-2 control-label">İzinler</label>
				<div class="col-lg-10">
					<?foreach($permissions as $key => $item):?>
			        <strong><?=$key?></strong>
			        	<table cellpadding="0" cellspacing="0" border="0" class="m-b" width="100%">
				            <tr>
					            <td>
					            <?foreach($item as $perm => $value):?>
					            	<input type="checkbox" name="permissions[<?=$perm?>]" value="<?=$perm?>" id="<?=$perm?>"<?if(in_array($perm, $userpermissions) || $_REQUEST['permissions'][$perm]):?> checked<?endif;?> /> <label for="<?=$perm?>"><?=$value?></label><br />
					            <?endforeach;?>
					            </td>
				            </tr>
			            </table>
				    <?endforeach;?>
				</div>
			</div>	
			<?endif;?>								

		<input type="submit" name="submit" class="btn btn-default pull-right m-t-xs" value="<?=lang('SAVE')?>" />
		
    </form>
</div>
</section>
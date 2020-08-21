<?
	$price = 0;
	$payed = 0;
	$used = 0;
	$earn = 0;
?>
<form  action="<?=site_url('users/activities')?>" method="post" class="ajax-form js-dont-reset">
	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4>Hesap Hareketleri</h4>
		</div>
		<div class="card-body">

			<table class="table table-striped">
				<thead>
					<tr>
						<th># No</th>
						<th width="220">İşlem Adı</th>
						<th>Süre</th>
						<th>Ücret <i class="fa fa-info-circle" data-toggle="tooltip" title="Ürün Ücreti / Ödenen Ücret"></i></th>
						<th>Sanal Para <i class="fa fa-info-circle" data-toggle="tooltip" title="Kullanılan / Kazanılan"></i></th>
						<th>İşlem Tarihi</th>
					</tr>
				</thead>
				<tbody>
					<?if(!empty($orders)):?>
					<?foreach($orders as $order):?>
					<tr>
						<td><?=$order->id?></td>
						<td>
							<?=$order->title?><?if($order->product_id == 28):?> (<?=$order->referee_username?>)<?endif;?><?if($order->product_id == 28):?> <i class="fa fa-info-circle" data-toggle="tooltip" title="<?=$order->description?>"></i><?endif;?>
							<?if($order->subject_title && $order->level_title):?><br /><i><?=$order->subject_title?> - <?=$order->level_title?></i><?endif;?>
						</td>
						<td><?if($order->start_date && $order->end_date):?><?=date('d.m.Y H:i',$order->start_date)?><br /><?=date('d.m.Y H:i',$order->end_date)?><?else:?><?=$order->string_date?><?endif;?></td>
						<td>
							<?if($order->product_id != 29):?><?=number_format($order->price, 2)?> TL<?endif;?> /
							<?if($order->product_id != 29):?><?=number_format($order->payed_price, 2)?> TL<?endif;?>
						</td>
						<td><?=$order->used_money?> / <?=$order->earn_money?></td>
						<td><?=date('d.m.Y H:i', $order->date)?></td>
					</tr>
					<?endforeach;?>
					<tr>
						<td><strong>Toplam</strong></td>
						<td></td>
						<td></td>
						<td><strong><?=$total_price?> TL</strong> / <strong><?=$total_payed?> TL</strong></td>
						<td><strong><?=$total_used?></strong> / <strong><?=$total_earn?></strong></td>
						<td></td>
					</tr>
					<?else:?>
					<tr>
						<td colspan="8">Hesap hareketiniz bulunmamaktadır</td>
					</tr>
					<?endif;?>
				</tbody>
			</table>

		</div>
	</div>

</form>

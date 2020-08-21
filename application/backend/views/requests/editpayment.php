<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="<?=base_url('backend/requests/payments')?>">Finansal Hareketler</a></li>
	<li class="active">Finansal Hareket Düzenle</li>
</ul>

<form method="post" action="<?=base_url('backend/requests/editpayment/'.$this->uri->segment(4))?>">

	<div class="row">
	
		<div class="col-md-12">
			<section class="panel panel-default">
				<header class="panel-heading bg-light">
					<a href="<?=base_url('backend/requests/edit/'.$item->request_id)?>" target="_blank">#<?=$item->request_id?> Numaralı Talep</a> <?=$item->subject->title?> > <?=$item->level->title?> (<a href="<?=base_url('backend/users/edit/'.$item->teacher->id)?>" target="_blank"><?=$item->teacher->firstname?> <?=$item->teacher->lastname?></a>)
				</header>
				<div class="card-body">
						<div class="row">
	
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label">İşlenen Ders Saati *</label>
									<input type="text" name="lesson_hour" class="form-control money-three" value="<?if($this->input->post('lesson_hour')):?><?=$this->input->post('lesson_hour')?><?else:?><?=$item->lesson_hour?><?endif;?>" />
								</div>		
							</div>
		
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label">Başlangıç Tarihi *</label>
									<input type="text" name="start_date" value="<?if($this->input->post('start_date')):?><?=$this->input->post('start_date')?><?else:?><?=date('d.m.Y H:i', $item->start_date)?><?endif;?>" class="datetimepicker form-control" />
								</div>
							</div>
							
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label">Sonlanma Tarihi *</label>
									<input type="text" name="end_date" value="<?if($this->input->post('end_date')):?><?=$this->input->post('end_date')?><?else:?><?=date('d.m.Y H:i', $item->end_date)?><?endif;?>" class="datetimepicker form-control" />
								</div>
							</div>					
												
							<div class="col-sm-3">
								<div class="form-group">
									<label class="control-label">Alacak Tutarı *</label>
									<input type="text" name="price" class="form-control money-three" value="<?if($this->input->post('price')):?><?=$this->input->post('price')?><?else:?><?=$item->price?><?endif;?>" />
								</div>		
							</div>		
		
							<div class="col-sm-12">
								<div class="form-group">
									<label class="control-label">İşlem Açıklaması</label>
									<textarea name="description" rows="3" class="form-control"><?if($this->input->post('description')):?><?=htmlspecialchars($this->input->post('description'))?><?else:?><?=htmlspecialchars($item->description)?><?endif;?></textarea>
								</div>
							</div>								
									
						</div>
					</div>
			</section>
		</div>
	</div><!--.row-->
<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>

</form>
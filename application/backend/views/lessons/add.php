<section class="panel panel-default">
	<header class="panel-heading bg-light">
		<?=lang('LESSON_EDIT')?> 
		<span class="pull-right"><a href="<?=base_url('backend/lessons')?>"><i class="fa fa-reply"></i> Geri Dön</a></span>
	</header>
	<div class="card-body">
	  <form method="post" action="<?=base_url('backend/lessons')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">

			<div class="form-group">
				<label class="col-lg-3 control-label">Öğrenci</label>
				<div class="col-lg-9">
			        <select name="student" class="form-control">
			        	<?foreach($students as $student):?>
	                    <option value="<?=$student->id?>"<?if($_REQUEST['student'] == $student->id || $item->uid == $student->id):?> selected<?endif;?>><?=$student->firstname?> <?=$student->lastname?></option>
	                    <?endforeach;?>
			        </select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Eğitmen</label>
				<div class="col-lg-9">
			        <select name="tutor" class="form-control">
			        	<?foreach($tutors as $tutor):?>
	                    <option value="<?=$tutor->id?>"<?if($_REQUEST['tutor'] == $tutor->id || $item->tutor_id == $tutor->id):?> selected<?endif;?>><?=$tutor->firstname?> <?=$tutor->lastname?></option>
	                    <?endforeach;?>
			        </select>
				</div>
			</div>			
				
			<div class="form-group">
				<label class="col-lg-3 control-label">Ders</label>
				<div class="col-lg-9">
					<select name="subject" class="chosen-select" id="subject">
						<?foreach($subjects as $s):?><option value="<?=$s->id?>"<?if($_REQUEST['subject'] == $s->id || $item->lesson_level == $s->id):?> selected<?endif;?>><?if($s->delimiter != '-'):?><?=$s->delimiter?><?endif;?> <?=$s->title?></option><?endforeach;?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Başlangıç Tarihi</label>
				<div class="col-lg-9">
					<input type="text" name="slot_start" value="<?if($_REQUEST['slot_start']):?><?=htmlspecialchars($_REQUEST['slot_start'])?><?else:?><?=date_format(date_create($item->slot_start), 'd.m.Y H:i')?><?endif;?>" class="datetimepicker form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Sonlanma Tarihi</label>
				<div class="col-lg-9">
					<input type="text" name="slot_end" value="<?if($_REQUEST['slot_end']):?><?=htmlspecialchars($_REQUEST['slot_end'])?><?else:?><?=date_format(date_create($item->slot_end), 'd.m.Y H:i')?><?endif;?>" class="datetimepicker form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Durum</label>
				<div class="col-lg-9">
			        <select name="slot_status" class="form-control">
	                    <option value="0"<?if($_REQUEST['slot_status'] == 0 || $item->slot_status == 0):?> selected<?endif;?>>Bekliyor</option>
	                    <option value="1"<?if($_REQUEST['slot_status'] == 1 || $item->slot_status == 1):?> selected<?endif;?>>Onaylı</option>
			        </select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label">Tipi</label>
				<div class="col-lg-9">
			        <select name="lesson_type" class="form-control">
			        	<?foreach($types as $t):?>
	                    <option value="<?=$t->id?>"<?if($_REQUEST['lesson_type'] == $t->id || $item->lesson_type == $t->id):?> selected<?endif;?>><?=$t->title?></option>
	                    <?endforeach;?>
			        </select>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Canlı Ders ID</label>
				<div class="col-lg-9">
					<input type="text" name="school_id" value="<?if($_REQUEST['school_id']):?><?=htmlspecialchars($_REQUEST['school_id'])?><?else:?><?=$item->school_id?><?endif;?>" class="form-control" />
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Canlı Ders Eğitmen Şifre</label>
				<div class="col-lg-9">
					<input type="text" name="school_tutor_pwd" value="<?if($_REQUEST['school_tutor_pwd']):?><?=htmlspecialchars($_REQUEST['school_tutor_pwd'])?><?else:?><?=$item->school_tutor_pwd?><?endif;?>" class="form-control" />
					<?if($item->school_tutor_pwd):?>
					<span class="help-block m-b-none"><a href="<?=base_url('backend/lessons/join/tutor/'.$item->id)?>">Eğitmen olarak derse gir</a></span>
					<?endif;?>
				</div>
			</div>			
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Canlı Ders Öğrenci Şifre</label>
				<div class="col-lg-9">
					<input type="text" name="school_student_pwd" value="<?if($_REQUEST['school_student_pwd']):?><?=htmlspecialchars($_REQUEST['school_student_pwd'])?><?else:?><?=$item->school_student_pwd?><?endif;?>" class="form-control" />
					<?if($item->school_student_pwd):?>
					<span class="help-block m-b-none"><a href="<?=base_url('backend/lessons/join/student/'.$item->id)?>">Öğrenci olarak derse gir</a></span>
					<?endif;?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label">Canlı Ders Başlangıç Tarihi</label>
				<div class="col-lg-9">
					<input type="text" name="school_create_date" value="<?if($_REQUEST['school_create_date']):?><?=htmlspecialchars($_REQUEST['school_create_date'])?><?else:?><?if($item->school_create_date):?><?=date('d.m.Y H:i', $item->school_create_date)?><?endif;?><?endif;?>" class="datetimepicker form-control" />
				</div>
			</div>					
	
			<button class="btn btn-default pull-right" type="submit" name="submit">KAYDET</button>
	    </form>
	</div>
</section>

<?print_r($meetings);?>
<hr />
<?print_r($records);?>
<hr />
<?print_r($isrunning);?>
<hr />
<?print_r($info);?>
<section class="panel panel-default m-t">
	<header class="panel-heading bg-light">
		<?=lang('LESSON_RECORDS')?> 
	</header>
	<div class="card-body">
	  <form method="post" action="<?=base_url('backend/lessons')?><?if(strstr(uri_string(), 'add') == TRUE):?>/add<?else:?>/edit/<?=$this->uri->segment(4)?><?endif;?>" class="form-horizontal" onsubmit="return prepareSubmit(this);">

								
	
			<button class="btn btn-default pull-right" type="submit" name="submit">KAYDET</button>
	    </form>
	</div>
</section>

<script src="<?=base_url('public/backend/js/datepicker/bootstrap-datepicker.js')?>"></script>
<link rel="stylesheet" href="<?=base_url('public/backend/js/datepicker/datepicker.css')?>" type="text/css" />
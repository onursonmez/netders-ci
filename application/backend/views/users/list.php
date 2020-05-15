<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('USERS_OVERVIEW')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<div class="m-l pull-right">
			<ul class="nav nav-pills">
				<li>
					<a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-up text-active"></i><i class="fa fa-caret-down text"></i></a>
				</li>
			</ul>
		</div>
                      		
		<? if(check_perm('users_add', TRUE) == TRUE): ?><span class="pull-right"><a href="<?=base_url('backend/users/add')?>"><i class="fa fa-plus"></i> <?=lang('USERS_NEW')?></a></span><?endif;?>		
	</header>
	
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="9%"><?=lang('HASH_NO')?></th>
					<th>Grup</th>
					<th>Durum</th>
					<th><?=lang('FULL_NAME')?></th>
					<th><?=lang('E_MAIL')?></th>
					<th>Aktivasyon</th>
					<th width="15%"><?=lang('REGISTER_DATE')?></th>
					<th width="15%">Randevu Tarihi</th>
					<th width="160"><?=lang('OPERATIONS')?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>

<script src="<?=base_url('public/backend/js/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('public/backend/js/libs/moment.min.js')?>"></script>

<script>
+function ($) { "use strict";
	
	$(function(){
	
		// datatable
		$('[data-ride="datatables"]').each(function() {
			var oTable = $(this).dataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": base_url+"backend/users",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row panel-body collapseonur filters'<'col-sm-2'l><'col-sm-2 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {				
				      $('[data-toggle="tooltip"]').tooltip();
				},
				"fnDrawCallback": function() {
					$('[data-toggle="tooltip"]').tooltip();
				},
				"aoColumns": [
					{ "mData": "id" },
					{ "mData": "group_name" },
					{ "mData": "id",
						"mRender": function(source, type, val)
						{
							switch(val.status){
								case 'A':
									return 'Aktif';
								break;
								
								case 'B':
									return 'Yasaklı';
								break;
								
								case 'D':
									return 'Silinmiş';
								break;
								
								case 'N':
									return 'Üyelik Tipsiz';
								break;
								
								case 'R':
									return 'Eksik Tamamlayan';
								break;
								
								case 'S':
									return 'İncelenmede';
								break;
								
								case 'T':
									return 'Randevuda';
								break;
								
								case 'C':
									return 'İptal Edilmiş';
								break;								
								
								default:
									return '?';
								break;																																											
							}
						}
					},					
					
					{ "mData": "firstname",
						"mRender": function(source, type, val)
						{
							var fullname = val.firstname+' '+val.lastname;
							
							if(val.fb_id)
							fullname = '<i class="fa fa-facebook"></i> ' + fullname;
							
							if(val.message_count > 0)
							fullname = fullname + '('+val.message_count+')';
							
							
							return fullname;
						}
					},
					{ "mData": "email" },
					{ "mData": "email_request",
						"mRender": function(source, type, val)
						{
							return val.email_request ? 'Hayır' : 'Evet'; 
						}
					},							
					{ "mData": "joined",
						"mRender": function(source, type, val){
							var nicetime = val.register_page ? val.nicetime + ' ('+val.register_page+')' : val.nicetime;
							return '<span data-toggle="tooltip" data-placement="top" title="'+nicetime+'">'+moment.unix(val.joined).format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},
					{ "mData": "joined",
						"mRender": function(source, type, val){
							return val.demo_date ? moment.unix(val.demo_date).format('DD-MM-YYYY HH:mm') : '';
						}
					},	
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							if(val.mail_response)
							{
								out += '<a href="<?=base_url('backend/users/register_mail')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="Kayıt E-posta Sonucu"><i class="fa fa-search"></i></a>';																						
							}
							out += '<a href="<?=base_url('backend/users/edit')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('EDIT')?>"><i class="fa fa-pencil"></i></a>';							
							out += '<a href="<?=base_url('backend/users/reactivation')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="Aktivasyon kodunu tekrar gönder"><i class="fa fa-envelope"></i></a>';
							out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'<?=lang('TRASH_CONTENT_TEXT')?>\', \'<?=base_url('backend/users/delete')?>/'+val.id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
							return out;
							
							
						}
					},
				],
				
				"oLanguage": {
					"sLoadingRecords": "<?=lang('LOADING')?>...",
					"sProcessing": "Tablo kayıtları yükleniyor",
					"sInfo": "Toplam _TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
					"sSearch": "Anahtar Kelime: _INPUT_",
					"sLengthMenu": "Göster:<br />_MENU_",
					"oPaginate": {
						"sFirst":	 "İlk",
						"sLast":	 "Son",
						"sNext":	 "İleri",
						"sPrevious": "Geri"
					},
					"sEmptyTable": "Kayıt bulunamadı",
					"sZeroRecords": "Gösterilecek kayıt bulunamadı",
					"sInfoEmpty": "Gösterilecek kayıt bulunamadı",
					"sInfoFiltered": " (_MAX_ kayıt filtrelendi)"
				}
				
			});	
				
		});
		

		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Durum:<br /><select name="status" id="status" class="form-control"><option value=""><?=lang('ALL')?></option><option value="A"><?=lang('ACTIVE')?></option><option value="W">Onay Bekliyor</option><option value="B">Yasaklı</option><option value="D">Silinmiş</option><option value="N">Üyelik Tipsiz</option><option value="R">Eksik Tamamlayan</option><option value="S">İncelenmede</option><option value="T">Randevuda</option></select></label></div></div>');
			$('#status').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#status').val(),
				0,
				true,
				true
			);			
		});	
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Hesap:<br /><select name="ugroup" id="ugroup" class="form-control"><option value=""><?=lang('ALL')?></option><?foreach($groups as $group):?><option value="<?=$group->id?>"><?=$group->name?></option><?endforeach;?></select></label></div></div>');
			$('#ugroup').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#ugroup').val(),
				1,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Rozet:<br /><select name="service_badge" id="service_badge" class="form-control"><option value="">Tümü</option><option value="Y">Var</option><option value="N">Yok</option><option value="W">Onay Bekliyor</option></select></label></div></div>');
			$('#service_badge').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#service_badge').val(),
				2,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Web:<br /><select name="exclusive" id="exclusive" class="form-control"><option value="">Tümü</option><option value="Y">Var</option><option value="N">Yok</option></select></label></div></div>');
			$('#exclusive').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#exclusive').val(),
				3,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Mesaj:<br /><select name="message" id="message" class="form-control"><option value="">Tümü</option><option value="Y">Var</option><option value="N">Yok</option></select></label></div></div>');
			$('#message').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#message').val(),
				4,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Ders:<br /><select name="lesson" id="lesson" class="form-control"><option value="">Tümü</option><?foreach($categories_selectbox as $key => $category):?><?if($category->parent_id == 6):?><?if($category->id != 7):?></optgroup><?endif;?><optgroup label="<?=$category->title?>"><?else:?><option value="<?=$category->category_id?>"><?=$category->title?></option><?endif;?><?endforeach;?></optgroup></select></label></div></div>');
			$('#lesson').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#lesson').val(),
				5,
				true,
				true
			);			
		});	
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Şehir:<br /><select name="city" id="city" class="form-control"><option value="">Tümü</option><?foreach($cities as $city):?><option value="<?=$city->id?>"><?=$city->title?></option><?endforeach;?></select></label></div></div>');
			$('#city').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#city').val(),
				6,
				true,
				true
			);			
		});	
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>İlçe:<br /><select name="town" id="town" class="form-control"><option value="">Tümü</option></select></label></div></div>');
			$('#town').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#town').val(),
				7,
				true,
				true
			);			
		});								
		
		<?if($this->input->get('status')):?>	
		$('#status').val('<?=$this->input->get('status')?>');
		$('#status').trigger('change');
		<?endif;?>
		
		<?if($this->input->get('service_badge')):?>	
		$('#service_badge').val('<?=$this->input->get('service_badge')?>');
		$('#service_badge').trigger('change');
		<?endif;?>
		
		$("#town").remoteChained("#city", base_url+"backend/users/getLocations", {selected: ''});
		$("#city").trigger('change');
		
		$(window).load(function(){
			$('select').chosen();
		});
	});
}(window.jQuery);
</script>
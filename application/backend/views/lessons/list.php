<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('FORMS')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="120"><?=lang('HASH_NO')?></th>
					<th>Konu</th>
					<th>Ders</th>
					<th width="150">Başlangıç Tarihi</th>
					<th width="155">Sonlanma Tarihi</th>
					<th width="100">Durumu</th>
					<th width="150">Tipi</th>
					<th width="170">Öğrenci</th>
					<th width="170">Eğitmen</th>
					<th width="110"><?=lang('OPERATIONS')?></th>
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
				"sAjaxSource": base_url+"backend/lessons",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-3'l><'col-sm-9 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
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
					{ "mData": "subject_title" },
					{ "mData": "level_title" },
					{ "mData": "slot_start",
						"mRender": function(source, type, val){
							return '<span>'+moment(val.slot_start).utc().format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},
					{ "mData": "slot_end",
						"mRender": function(source, type, val){
							return '<span>'+moment(val.slot_end).utc().format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},
					{ "mData": "slot_status",
						"mRender": function(source, type, val){
							return val.slot_status == 1 ? 'Onaylı' : 'Bekliyor';
						}
					},
					{ "mData": "lesson_type_name" },					
					{ "mData": "uid",
						"mRender": function(source, type, val){
							return val.user_firstname + ' ' + val.user_lastname;
						}
					},
					{ "mData": "tutor_id",
						"mRender": function(source, type, val){
							return val.tutor_firstname + ' ' + val.tutor_lastname;
						}
					},
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a href="<?=base_url('backend/lessons/edit')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('VIEW')?>"><i class="fa fa-pencil"></i></a>';
							out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'<?if($GLOBALS['settings_global']->content_delete_type == 1):?><?=lang('DELETE_CONTENT_TEXT')?><?else:?><?=lang('TRASH_CONTENT_TEXT')?><?endif;?>\', \'<?=base_url('backend/lessons/delete')?>/'+val.id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
							return out;
							
							
						}
					},
				],
				
				"oLanguage": {
					"sLoadingRecords": "<?=lang('LOADING')?>...",
					"sProcessing": "Tablo kayıtları yükleniyor",
					"sInfo": "Toplam _TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
					"sSearch": "Anahtar Kelime: _INPUT_",
					"sLengthMenu": "Göster: _MENU_ kayıt",
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
	
	});
}(window.jQuery);
</script>
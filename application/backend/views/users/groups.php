<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('USERS_GROUPS')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<? if(check_perm('users_groups_add', TRUE) == TRUE): ?><span class="pull-right"><a href="<?=base_url('backend/users/addgroup')?>"><i class="fa fa-plus"></i> <?=lang('USERS_NEW_GROUP')?></a></span><?endif;?>
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="10%"><?=lang('HASH_NO')?></th>
					<th><?=lang('NAME')?></th>
					<th><?=lang('USERS_COUNT')?></th>
					<th width="11%"><?=lang('OPERATIONS')?></th>
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
				"sAjaxSource": base_url+"backend/users/groups",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-3'l><'col-sm-7 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {
				      $('[data-toggle="tooltip"]').tooltip();
				},
				"fnRowCallback": function( nRow, mData, iDisplayIndex ) {
					$('[data-toggle="tooltip"]').tooltip();
					// create link
					$('td:eq(1)', nRow).html('<a class="myeditables-class" href="#">' + mData.name + '</a>');
					// add x-editable
					$('td:eq(1) a', nRow).editable({
					  name: mData.id,
					  pk: mData.id,
					  type: 'text',
					  mode: 'inline',
					  url: '<?=base_url('backend/users/updategroup')?>',
					  send:'always',
					  success: function(data, config) {
					  	$.growl('<?=lang('SUCCESS')?>');
					  }
					});
					return nRow;
				},
				"aoColumns": [
					{ "mData": "id" },
					{ "mData": "name",
						"mRender": function(source, type, val)
						{	
							var out = '';
							out += '<a href="" class="editable">'+val.name+'</a>';
							return out;
						}						 
					},
					{ "mData": "users" },
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a href="<?=base_url('backend/users/permissions')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('PERMISSIONS')?>"><i class="fa fa-shield"></i></a>';
							out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'<?=lang('DELETE_CONTENT_TEXT')?>\', \'<?=base_url('backend/users/deletegroup')?>/'+val.id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
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
		

		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Durum: <select name="status" id="status"><option value="A"><?=lang('ACTIVE')?></option><option value="I"><?=lang('INACTIVE')?></option></select></label></div></div>');
			$('#status').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#status').val(),
				1,
				true,
				true
			);			
		});		
	
	});
}(window.jQuery);
</script>

<link rel="stylesheet" href="<?=base_url('public/backend/lib/bootstrap3-editable/css/bootstrap-editable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/lib/bootstrap3-editable/js/bootstrap-editable.min.js')?>"></script>
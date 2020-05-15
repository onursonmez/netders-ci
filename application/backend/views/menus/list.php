<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('MENUS')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<span class="pull-right"><a href="<?=base_url('backend/menus/add')?>"><i class="fa fa-plus"></i> <?=lang('MENUS_NEW')?></a></span>
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="10%"><?=lang('HASH_NO')?></th>
					<th><?=lang('NAME')?></th>
					<th width="11%"><?=lang('STATUS')?></th>
					<th width="124"><?=lang('OPERATIONS')?></th>
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
				"sAjaxSource": base_url+"backend/menus",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-4'l><'col-sm-6 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
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
					{ "mData": "title" },
					{ "mData": "status" },
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a href="<?=base_url('backend/menus/edit')?>/'+val.id+'" title="<?=lang('EDIT')?>" data-toggle="tooltip" data-placement="left" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a> ';
			            	out += '<a href="<?=base_url('backend/menus/items')?>/'+val.id+'" title="<?=lang('MENU_ITEMS')?>" data-toggle="tooltip" data-placement="left" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-bars"></i></a>';
							if(val.defaults != 'Y'){
			            		out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'Menü ve bağlı bütün öğeler çöp kutusuna gönderilecektir\', \'<?=base_url('backend/menus/delete')?>/'+val.menu_id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
			            	}			            	
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
				0,
				true,
				true
			);			
		});
		
		$('select').on('change', function(){
			//console.log("sssa");
		});
		
	
	});
}(window.jQuery);
</script>
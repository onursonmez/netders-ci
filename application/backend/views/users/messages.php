<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('USERS_MESSAGES_OVERVIEW')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="9%"><?=lang('HASH_NO')?></th>
					<th width="60">Okundu</th>
					<th>Mesaj Yazan</th>
					<th>Mesaj Yazılan</th>
					<th>Mesaj</th>
					<th>Tarih</th>
					<th width="150"><?=lang('OPERATIONS')?></th>
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
				"sAjaxSource": base_url+"backend/users/messages",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-1'l><'col-sm-3 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
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
					{ "mData": "readed" },
					{ "mData": "from_firstname",
						"mRender": function(source, type, val)
						{
							var from_virtual = '';
							if(val.from_virtual == 'Y')
							from_virtual = '<i class="fa fa-low-vision"></i> '; 
							return from_virtual + '<a href="<?=base_url('backend/users/edit')?>/'+val.from_id+'">'+val.from_firstname+' '+val.from_lastname+' ('+val.from_groupname+')</a>';
						}
					},						
					{ "mData": "to_firstname",
						"mRender": function(source, type, val)
						{
							var to_virtual = '';
							if(val.to_virtual == 'Y')
							to_virtual = '<i class="fa fa-low-vision"></i> '; 							
							return to_virtual + '<a href="<?=base_url('backend/users/edit')?>/'+val.to_id+'">'+val.to_firstname+' '+val.to_lastname+' ('+val.to_groupname+')</a>';
						}
					},						
					{ "mData": "message" },
					{ "mData": "date",
						"mRender": function(source, type, val){
							return moment.unix(val.date).format('DD-MM-YYYY HH:mm');
						}
					},	
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							if(val.approved  == 'N')
							out += '<a href="<?=base_url('backend/users/messages?approve=')?>'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('APPROVE')?>"><i class="fa fa-check"></i></a>';
							out += '<a href="<?=base_url('backend/users/messages?delete=')?>'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
							return out;
							
							
						}
					},
				],
				
				"oLanguage": {
					"sLoadingRecords": "<?=lang('LOADING')?>...",
					"sProcessing": "Tablo kayıtları yükleniyor",
					"sInfo": "Toplam _TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
					"sSearch": "Anahtar Kelime: _INPUT_",
					"sLengthMenu": "Göster: _MENU_",
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
		

		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Durum: <select name="approved" id="approved"><option value="">Tümü</option><option value="N">Onay Bekliyor</option><option value="Y"><?=lang('ACTIVE')?></option><option value="all"><?=lang('ALL')?></option></select></label></div></div>');
			$('#approved').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#approved').val(),
				0,
				true,
				true
			);			
		});	
		
	});
}(window.jQuery);
</script>
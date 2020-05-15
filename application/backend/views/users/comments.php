<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('USERS_OVERVIEW')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<? if(check_perm('users_add', TRUE) == TRUE): ?><span class="pull-right"><a href="<?=base_url('backend/users/add')?>"><i class="fa fa-plus"></i> <?=lang('USERS_NEW')?></a></span><?endif;?>
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="9%"><?=lang('HASH_NO')?></th>
					<th>Yorum Yapan</th>
					<th>Yorum Yapılan</th>
					<th>Yorum</th>
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
				"sAjaxSource": base_url+"backend/users/comments",
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
					{ "mData": "from_username" },
					{ "mData": "to_username" },
					{ "mData": "comment" },
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
							if(val.status  == 'W')
							out += '<a href="<?=base_url('backend/users/comments?approve=')?>'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('APPROVE')?>"><i class="fa fa-check"></i></a>';
							out += '<a href="<?=base_url('backend/users/comments?delete=')?>'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
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
		

		
		$('.keyword').parent().append('<div class="col-sm-1"><div class="dataTables_filter"><label>Durum: <select name="status" id="status"><option value="W">Onay Bekliyor</option><option value="A"><?=lang('ACTIVE')?></option><option value="all"><?=lang('ALL')?></option></select></label></div></div>');
			$('#status').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#status').val(),
				0,
				true,
				true
			);			
		});	
		
	});
}(window.jQuery);
</script>
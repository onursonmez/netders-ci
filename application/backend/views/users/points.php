<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('USERS_POINTS')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<? if(check_perm('users_points_add', TRUE) == TRUE): ?><span class="pull-right"><a href="<?=base_url('backend/users/addpoint')?>"><i class="fa fa-plus"></i> <?=lang('USERS_POINTS_NEW')?></a></span><?endif;?>
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="9%"><?=lang('HASH_NO')?></th>
					<th><?=lang('FULL_NAME')?></th>
					<th><?=lang('USERNAME')?></th>
					<th>Puan</th>
					<th>İşlem Adı</th>
					<th>İşlem Tipi</th>
					<th width="15%"><?=lang('DATE')?></th>
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
				"sAjaxSource": base_url+"backend/users/points",
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
					{ "mData": "firstname",
						"mRender": function(source, type, val){
							return val.firstname+' '+val.lastname;
						}
					},
				{ "mData": "username",
						"mRender": function(source, type, val){
							return '<a href="'+base_url+val.username+'" target="_blank">'+val.username+'</a>';
						}
					},		
					{ "mData": "point",
						"mRender": function(source, type, val){
							return val.point;
						}
					},
					{ "mData": "description",
						"mRender": function(source, type, val){
							if(val.description){
								return val.tag + ' <i class="fa fa-question-circle" data-toggle="tooltip" title="'+val.description+'"></i>';
							} else {
								return val.tag;
							}
						}
					},
					{ "mData": "operation",
						"mRender": function(source, type, val){
							return val.operation == 1 ? 'Ekleme' : 'Çıkarma';
						}
					},										
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
							out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'<?=lang('DELETE_CONTENT_TEXT')?>\', \'<?=base_url('backend/users/deletepoint')?>/'+val.id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
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
		

		$('.keyword').parent().append('<div class="col-sm-1"><div class="dataTables_filter"><label>İşlem Adı: <select name="operation" id="operation"><option value=""><?=lang('ALL')?></option><?foreach($tags as $tag):?><option value="<?=$tag->id?>"><?=$tag->description?></option><?endforeach;?></select></label></div></div>');
			$('#operation').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#operation').val(),
				0,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-1"><div class="dataTables_filter"><label>İşlem Tipi: <select name="tag" id="tag"><option value=""><?=lang('ALL')?></option><option value="1">Eklenenler</option><option value="2">Çıkartılanlar</option></select></label></div></div>');
			$('#tag').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#tag').val(),
				1,
				true,
				true
			);			
		});		
		
		
	});
}(window.jQuery);
</script>
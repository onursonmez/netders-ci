<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('USERS_ACTIVITIES')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th><?=lang('HASH_NO')?></th>
					<th><?=lang('FULL_NAME')?></th>
					<th><?=lang('USERNAME')?></th>
					<th width="200">İşlem Adı</th>
					<th width="150">Geçerlilik Süresi</th>
					<th width="110">İşlem Ücreti</th>
					<th width="110">Ödenen Ücret</th>
					<th width="100">Kullanılan Sanal Para</th>
					<th width="100">Kazanılan Sanal Para</th>
					<th width="150">İşlem Tarihi</th>
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
				"sAjaxSource": base_url+"backend/users/activities",
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
					{ "mData": "title",
						"mRender": function(source, type, val){
							if(val.product_id == 30){
								return '<span data-toggle="tooltip" data-placement="top" title="'+val.description+'">' + val.title + ' (#' + val.referee_id + ')</span>';
							} else {
								if(val.subject_title && val.level_title){
									return '<span data-toggle="tooltip" data-placement="top" title="'+val.description+'">'+val.title+'<br /><i>'+ val.subject_title+' - '+val.level_title+'</i></span>';
								} else {
									return '<span data-toggle="tooltip" data-placement="top" title="'+val.description+'">'+val.title+'</span>';
								}
							}
						}
					},
					{ "mData": "start_date",
						"mRender": function(source, type, val){
							return '<span data-toggle="tooltip" data-placement="top" title="'+moment.unix(val.start_date).format('DD-MM-YYYY HH:mm') + ' / ' + moment.unix(val.end_date).format('DD-MM-YYYY HH:mm')+'">'+val.string_date+'</span>';
						}
					},
					{ "mData": "price",
						"mRender": function(source, type, val){
							return val.product_id != 31 ? '+' + val.price + ' TL' : '';
						}
					},
					{ "mData": "payed_price",
						"mRender": function(source, type, val){
							return val.product_id != 31 && val.payed_price > 0 ? '+' + val.payed_price + ' TL' : '0 TL';
						}
					},		
					{ "mData": "used_money",
						"mRender": function(source, type, val){
							return val.used_money;
						}
					},																				
					{ "mData": "earn_money",
						"mRender": function(source, type, val){
							return val.earn_money;
						}
					},																									
					{ "mData": "date",
						"mRender": function(source, type, val){
							return moment.unix(val.date).format('DD-MM-YYYY HH:mm');
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
		
		/*
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
		*/	
		
		
	});
}(window.jQuery);
</script>
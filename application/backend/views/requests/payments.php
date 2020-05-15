<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('REQUESTS_PAYMENTS_OVERVIEW')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<div class="m-l pull-right">
			<ul class="nav nav-pills">
				<li>
					<a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-up text-active"></i><i class="fa fa-caret-down text"></i></a>
				</li>
			</ul>
		</div>
		                      		
	</header>
	
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th>Talep No</th>
					<th>Ders Adı</th>
					<th>Eğitmen Adı</th>
					<th>Eğitmen GSM</th>
					<th>İşlenen Ders Saati</th>
					<th>Başlangıç Tarihi</th>
					<th>Sonlanma Tarihi</th>
					<th>Tutar</th>
					<th>Tahsilat Yapıldı</th>
					<th>Açıklama</th>
					<th>Durum</th>
					<th width="150"><?=lang('OPERATIONS')?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</section>

<script src="<?=base_url('public/backend/js/datatables/jquery.dataTables.min.js')?>"></script>

<script>
+function ($) { "use strict";
	
	$(function(){
	
		// datatable
		$('[data-ride="datatables"]').each(function() {
			var oTable = $(this).dataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": base_url+"backend/requests/payments",
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
					{ "mData": "request_id",
						"mRender": function(source, type, val){
							return '<a href="'+base_url+'backend/requests/edit/'+val.request_id+'" target="_blank">' + val.request_id + '</a>';
						}
					},
					{ "mData": "id",
						"mRender": function(source, type, val){
							return val.subject.title + ' > ' + val.level.title;
						}
					},
					{ "mData": "id",
						"mRender": function(source, type, val){
							return '<a href="'+base_url+'backend/users/edit/'+val.user_id+'" target="_blank">' + val.firstname + ' ' + val.lastname + '</a>';
						}
					},
					{ "mData": "mobile" },						
					{ "mData": "lesson_hour" },						
					{ "mData": "start_date",
						"mRender": function(source, type, val){
							return '<span data-toggle="tooltip" data-placement="top" title="'+val.start_date_nicetime+'">'+moment.unix(val.start_date).utcOffset(2).format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},
					{ "mData": "end_date",
						"mRender": function(source, type, val){
							return '<span data-toggle="tooltip" data-placement="top" title="'+val.end_date_nicetime+'">'+moment.unix(val.end_date).utcOffset(2).format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},	
					{ "mData": "price" },										
					{ "mData": "payed",
						"mRender": function(source, type, val){
							if(val.payed == 'Y'){
								return 'Evet';
							} else {
								return 'Hayır';
							}
						}
					},						
					{ "mData": "description" },		
					{ "mData": "status",
						"mRender": function(source, type, val)
						{
							if(val.status == 'A'){
								return 'Aktif';
							} else if(val.status == 'D') {
								return 'Silinmiş';
							} else {
								return 'Bilinmiyor';
							}
						}
					},														
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							if(val.payed == 'N'){
								out += '<a href="<?=base_url('backend/requests/paypayment')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="Ödendi Olarak İşaretle"><i class="fa fa-hourglass"></i></a>';							
							} else {
								out += '<a href="<?=base_url('backend/requests/unpaypayment')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="Ödenmedi Olarak İşaretle"><i class="fa fa-check"></i></a>';							
							}
							out += '<a href="<?=base_url('backend/requests/editpayment')?>/'+val.id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('EDIT')?>"><i class="fa fa-pencil"></i></a>';							
							if(val.status == 'A'){
								out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'Veri silinerek alacak kaydı düşülecektir. Devam etmek istiyor musunuz?\', \'<?=base_url('backend/requests/deletepayment')?>/'+val.id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
							} else if(val.status == 'D') {
								out += '<a href="<?=base_url('backend/requests/undeletepayment')?>/'+val.id+'" class="btn btn-xs btn-default" data-toggle="tooltip" title="Aktif Et"><i class="fa fa-mail-reply"></i></a>';
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
	
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Durum:<br /><select name="payed" id="payed" class="form-control"><option value="">Tümü</option><option value="Y" selected="selected">Ödenmiş</option><option value="N">Ödenmemiş</option><option value="D">Silinmiş</option></select></label></div></div>');
			$('#payed').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#payed').val(),
				0,
				true,
				true
			);			
		});
								

	});
}(window.jQuery);
</script>
<?=$aa?>
<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('REQUESTS_OVERVIEW')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<div class="m-l pull-right">
			<ul class="nav nav-pills">
				<li>
					<a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-up text-active"></i><i class="fa fa-caret-down text"></i></a>
				</li>
			</ul>
		</div>
		<? if(check_perm('requests_add', TRUE) == TRUE): ?><span class="pull-right"><a href="<?=base_url('backend/requests/add')?>"><i class="fa fa-plus"></i> <?=lang('REQUEST_NEW')?></a></span><?endif;?>		                      		
	</header>
	
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th>Talep No</th>
					<th>Talep Dersi No</th>
					<th>Öğrenci Adı</th>
					<th>Öğrenci Telefon</th>
					<th>Öğrenci İl</th>
					<th>Öğrenci İlçe</th>					
					<th>Ders Adı</th>
					<th>Eğitmen</th>
					<th>Alacak</th>
					<th>Tahsilat</th>
					<th width="300">Durum</th>
					<th>Uyarı</th>
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

<script>
+function ($) { "use strict";
	
	$(function(){
	
		// datatable
		$('[data-ride="datatables"]').each(function() {
			var oTable = $(this).dataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": base_url+"backend/requests",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row panel-body collapseonur filters'<'col-sm-2'l><'col-sm-2 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {				
				      $('[data-toggle="tooltip"]').tooltip();
				      $(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});
				},
				"fnDrawCallback": function() {
					$('[data-toggle="tooltip"]').tooltip();
					$(".chosen-select").length && $(".chosen-select").chosen({"search_contains": true});
				},
				"aoColumns": [
					{ "mData": "id" },										
					{ "mData": "request_id",
						"mRender": function(source, type, val){
							return '<a href="'+base_url+'backend/requests/edit/'+val.request_id+'" target="_blank">' + val.request_id + '</a>';
						}
					},
					{ "mData": "fullname" },						
					{ "mData": "phone" },						
					{ "mData": "city_title" },
					{ "mData": "town_title" },						
					{ "mData": "id",
						"mRender": function(source, type, val){
							return val.subject.title + ' > ' + val.level.title;
						}
					},
					{ "mData": "id",
						"mRender": function(source, type, val){
							if(val.user_id){
							return '<a href="'+base_url+'backend/users/edit/'+val.user_id+'" target="_blank">' + val.firstname + ' ' + val.lastname + ' ('+val.mobile+')</a>';
							} else {
								return '';
							}
						}
					},
					{ "mData": "balance" },						
					{ "mData": "payed" },						
					{ "mData": "id",
						"mRender": function(source, type, val)
						{
							var status_data = '<ul class="reset-ul">';
							
							if(val.teacher_id){
								status_data += '<li><i class="fa fa-check"></i> Eğitmen Atandı</li>';
							} else {
								status_data += '<li><i class="fa fa-close"></i> Eğitmen Atandı</li>';
							}
							
							if(val.model_id){
								status_data += '<li><i class="fa fa-check"></i> Çalışma Modeli Belirlendi</li>';
							} else {
								status_data += '<li><i class="fa fa-close"></i> Çalışma Modeli Belirlendi</li>';
							}
							
							if(val.status_sms == 'Y'){
								status_data += '<li><i class="fa fa-check"></i> SMS Gönderildi</li>';
							} else {
								status_data += '<li><i class="fa fa-close"></i> SMS Gönderildi</li>';
							}	
							
							if(val.appointment_date){
								status_data += '<li><i class="fa fa-check"></i> Randevu Tarihi Belirlendi</li>';
							} else {
								status_data += '<li><i class="fa fa-close"></i> Randevu Tarihi Belirlendi</li>';
							}	
							
							if(val.lesson_hour){
								status_data += '<li><i class="fa fa-check"></i> Ders Süresi Belirlendi</li>';
							} else {
								status_data += '<li><i class="fa fa-close"></i> Ders Süresi Belirlendi</li>';
							}
							
							if(val.status_start == 'Y'){
								status_data += '<li><i class="fa fa-check"></i> Ders Başladı</li>';
							} else {
								status_data += '<li><i class="fa fa-close"></i> Ders Başladı</li>';
							}																												
											
							status_data += '</ul>';
							
							return status_data;
						}
					},
					{ "mData": "status_info",
						"mRender": function(source, type, val){
							if(val.status_info.value){
								return val.status_info.value;
							} else {
								return '';
							}
						}
					},	
					{ "mData": "status_info",
						"mRender": function(source, type, val){
							return moment.unix(val.create_date).format('DD-MM-YYYY HH:mm');
						}
					},																				
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a href="<?=base_url('backend/requests/edit')?>/'+val.request_id+'" class="btn btn-xs btn-default" data-toggle="tooltip" title="Görüntüle"><i class="fa fa-search"></i></a>';
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
	
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Alacaklı:<br /><select name="balance" id="balance" class="form-control"><option value="">Tümü</option><option value="Y">Evet</option><option value="N">Hayır</option></select></label></div></div>');
			$('#balance').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#balance').val(),
				0,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-6"><div class="dataTables_filter"><label>Durum:<br /><select name="status" id="status" class="form-control chosen-select" multiple="multiple"><option value="">Tümü</option><?foreach($statuses as $status):?><option value="<?=$status->id?>"<?if($status->id != 8 && $status->id != 15):?> selected="selected"<?endif;?>><?=$status->title?></option><?endforeach;?></select></label></div></div>');
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
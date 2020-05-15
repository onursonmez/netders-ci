<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		Ders Tanıtım Yazıları
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th><?=lang('HASH_NO')?></th>
					<th>Ad Soyad</th>
					<th>Başlık</th>
					<th>Açıklama</th>
					<th>Ders</th>
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
				"sAjaxSource": base_url+"backend/users/prices_text",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-4'l><'col-sm-6 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {
				      setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 100);
				},
				"fnRowCallback": function( nRow, mData, iDisplayIndex ) {
					// create link
					$('td:eq(2)', nRow).html('<a class="myeditables-class" href="#">' + mData.title + '</a>');
					$('td:eq(3)', nRow).html('<a class="myeditables-class" href="#">' + mData.description + '</a>');
					// add x-editable
					$('td:eq(2) a', nRow).editable({
					  name: mData.id,
					  pk: 'title',
					  type: 'text',
					  mode: 'inline',
					  url: '<?=base_url('backend/users/prices_text_update')?>',
					  send:'always',
					  success: function(data, config) {
					  	$.growl('<?=lang('SUCCESS')?>');
					  }
					});
					$('td:eq(3) a', nRow).editable({
					  name: mData.id,
					  pk: 'description',
					  type: 'textarea',
					  mode: 'inline',
					  url: '<?=base_url('backend/users/prices_text_update')?>',
					  send:'always',
					  success: function(data, config) {
					  	$.growl('<?=lang('SUCCESS')?>');
					  }
					});					
					setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 100);
					return nRow;
				},
				"aoColumns": [
					{ "mData": "id" },
					{ "mData": "id",
						"mRender": function(source, type, val)
						{	
							return val.firstname + ' ' + val.lastname;
						}						 
					},
								
					{ "mData": "title",
						"mRender": function(source, type, val)
						{	
							return '<a href="" class="editable">'+val.title+'</a>';
						}						 
					},
					{ "mData": "description",
						"mRender": function(source, type, val)
						{	
							return '<a href="" class="editable">'+val.description+'</a>';
						}						 
					},					
					{ "mData": "level_name" },
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							
							if(val.status == 'W'){
								out += '<a href="<?=base_url('backend/users/prices_text_approve')?>/'+val.id+'" title="Onayla" data-toggle="tooltip" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-hourglass-half"></i></a>';
							} else {
								out += '<a href="<?=base_url('backend/users/prices_text_wait')?>/'+val.id+'" title="Onaylanmış, Onay Bekliyor Yap" data-toggle="tooltip" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-check-circle"></i></a>';
							}
							
							out += '<a href="<?=base_url('backend/users/prices_text_delete')?>/'+val.id+'" title="Sil" data-toggle="tooltip" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-trash-o"></i></a>';
							
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
    		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Durum: <select name="status" id="status"><option value=""><?=lang('ALL')?></option><option value="A">Aktif</option><option value="W">Onay Bekliyor</option></select></label></div></div>');
			$('#status').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#status').val(),
				0,
				true,
				true
			);			
		});	
		
		<?if($this->input->get('status')):?>	
		$('#status').val('<?=$this->input->get('status')?>');
		setTimeout(function(){
			$('#status').trigger('change');
		}, 100);
		<?endif;?>		
		
	});
}(window.jQuery);


</script>

<link rel="stylesheet" href="<?=base_url('public/backend/lib/bootstrap3-editable/css/bootstrap-editable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/lib/bootstrap3-editable/js/bootstrap-editable.min.js')?>"></script>
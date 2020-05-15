<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('LANGUAGES_EDIT')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="10%"><?=lang('HASH_NO')?></th>
					<th><?=lang('LANG_KEY')?></th>
					<th><?=lang('LANG_VALUE')?></th>
					<th width="10%"><?=lang('LANG_CODE')?></th>
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
				"sAjaxSource": base_url+"backend/languages/editphrases",
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
					$('td:eq(2)', nRow).html('<a class="myeditables-class" href="#">' + mData.lang_value + '</a>');
					// add x-editable
					$('td:eq(2) a', nRow).editable({
					  name: mData.lang_key,
					  pk: mData.lang_code,
					  type: 'textarea',
					  mode: 'inline',
					  url: '<?=base_url('backend/languages/updatephrase')?>',
					  send:'always',
					  success: function(data, config) {
					  	$.growl('<?=lang('SUCCESS')?>');
					  }
					});
					setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 100);
					return nRow;
				},
				"aoColumns": [
					{ "mData": "key_id" },
					{ "mData": "lang_key" },
					{ "mData": "lang_value",
						"mRender": function(source, type, val)
						{	
							return '<a href="" class="editable">'+val.lang_value+'</a>';
						}						 
					},
					{ "mData": "lang_code" },
					{ "mData": "key_id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							return '<a onclick="confirmation(\'Lütfen Dikkat!\', \'Bu değişken tüm dillerde mevcuttur ve tüm dillerde silinecektir.\', \'<?=base_url('backend/languages/deletephrase')?>/'+val.lang_key+'\');" href="#" title="<?=lang('DELETE')?>" data-toggle="tooltip" class="btn btn-xs btn-default m-r-xs"><i class="fa fa-trash-o"></i></a>';
							
							
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
    		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Dil: <select name="language" id="language" style="width:auto"><option value="">Tümü</option><?foreach(site_languages() as $language):?><option value="<?=$language->lang_code?>"<?if($this->input->get('lang_code') == $language->lang_code):?> selected<?endif;?>><?=$language->name?></option><?endforeach;?></select></label></div></div>');
			$('#language').on('change', function(event){

			// Prevent default click action
			event.preventDefault(); 			
			
			$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#language').val(),
				0,
				true,
				true
			);
			var stripped_url = removeVariableFromURL(top.location.href, 'lang_code');

			// Detect if pushState is available
			if(history.pushState) {
				history.pushState(null, null, stripped_url);
			}
			return false;
		});
	});
}(window.jQuery);

  function removeVariableFromURL(url_string, variable_name) {
    var URL = String(url_string);
    var regex = new RegExp( "\\?" + variable_name + "=[^&]*&?", "gi");
    URL = URL.replace(regex,'?');
    regex = new RegExp( "\\&" + variable_name + "=[^&]*&?", "gi");
    URL = URL.replace(regex,'&');
    URL = URL.replace(/(\?|&)$/,'');
    regex = null;
    return URL;
  }
</script>

<link rel="stylesheet" href="<?=base_url('public/backend/lib/bootstrap3-editable/css/bootstrap-editable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/lib/bootstrap3-editable/js/bootstrap-editable.min.js')?>"></script>
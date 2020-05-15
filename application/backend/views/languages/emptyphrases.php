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
					<th><?=lang('LANG_KEY')?></th>
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
	
	$(function()
	{
		//fnReloadAjax() reload plugin
		$.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings)
		{
			//oSettings.sAjaxSource = sNewSource;
			this.fnClearTable(this);
			this.oApi._fnProcessingDisplay(oSettings, true );
			var that = this;
			
			$.getJSON(oSettings.sAjaxSource, null, function(json){
				/* Got the data - add it to the table */
				for (var i=0; i<json.aaData.length; i++)
				{
					that.oApi._fnAddData(oSettings, json.aaData[i]);
				}
				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
				that.fnDraw(that);
				that.oApi._fnProcessingDisplay(oSettings, false);
			});
		}
		
		// datatable
		$('[data-ride="datatables"]').each(function() {
			var oTable = $(this).dataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": base_url+"backend/languages/editemptyphrases",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-4'l><'col-sm-8 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {
				     setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 100);
				},
					"fnRowCallback": function( nRow, mData, iDisplayIndex ) {
					// create link
					$('td:eq(0)', nRow).html('<a class="myeditables-class" href="#">' + mData.lang_key + '</a>');
					// add x-editable
					$('td:eq(0) a', nRow).editable({
					  name: mData.lang_key,
					  type: 'textarea',
					  mode: 'inline',
					  toggle: 'mouseenter',
					  url: '<?=base_url('backend/languages/updateemptyphrases')?>',
					  send:'always',
					  success: function(data, config) {
					  	$.growl('<?=lang('SUCCESS')?>');
					  	//$(this).parent('td').fadeOut('slow');
						oTable.fnReloadAjax(oTable.fnSettings());
					  }
					});
					setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 100);
					return nRow;
				},
				"aoColumns": [
					{ "mData": "lang_key",
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a href="" class="editable">'+val.lang_key+'</a>';
							return out;
						}						 
					},
					{ "mData": "lang_key",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a onclick="confirmation(\'Lütfen Dikkat!\', \'Bu boş dil değişkenini silmek istediğinizden emin misiniz? Bu işlemin geri dönüşü yoktur.\', \'<?=base_url('backend/languages/deleteemptyphrase')?>/'+val.lang_key+'\');" href="#" title="<?=lang('DELETE')?>" data-toggle="tooltip" class="btn btn-xs btn-default"><i class="fa fa-trash-o"></i></a>';
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
		
		$('#example tbody').on('click', 'tr', function () {
		    var id = this.id;
		    var index = $.inArray(id, selected);
		
		    if ( index === -1 ) {
		        selected.push( id );
		    } else {
		        selected.splice( index, 1 );
		    }
		
		    $(this).toggleClass('selected');
		} );		
	});
}(window.jQuery);
</script>

<link rel="stylesheet" href="<?=base_url('public/backend/lib/bootstrap3-editable/css/bootstrap-editable.css')?>" type="text/css" />
<script src="<?=base_url('public/backend/lib/bootstrap3-editable/js/bootstrap-editable.min.js')?>"></script>
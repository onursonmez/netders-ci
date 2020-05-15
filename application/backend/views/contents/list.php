<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('CONTENTS')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
		
		<span class="pull-right"><a href="<?=base_url('backend/contents/add')?>"><i class="fa fa-plus"></i> <?=lang('CONTENTS_NEW')?></a></span>
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="10%"><?=lang('HASH_NO')?></th>
					<th><?=lang('TITLE')?></th>
					<th><?=lang('MAIN_CATEGORY')?></th>
					<th width="11%"><?=lang('STATUS')?></th>
					<th width="16%"><?=lang('CREATED_DATE')?></th>
					<th width="8%"><?=lang('POSITION')?></th>					
					<th width="9%"><?=lang('OPERATIONS')?></th>
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
				"sAjaxSource": base_url+"backend/contents",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-3'l><'col-sm-4 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {
		            $('[data-toggle="tooltip"]').tooltip();
				},
		        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
		            nRow.setAttribute('id', aData.id);  //Initialize row id for every row
		            $('[data-toggle="tooltip"]').tooltip();
		        },
				"aoColumns": [
					{ "mData": "id" },
					{ "mData": "title" },
					{ "mData": "main_category" },
					{ "mData": "status_name" },
					{ "mData": "start_date",
						"mRender": function(source, type, val){
							return '<span class="link-dashed" data-toggle="tooltip" title="'+moment.unix(val.start_date).fromNow()+'">'+moment.unix(val.start_date).format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},
					{ "mData": "position" },
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a href="<?=base_url('backend/contents/edit')?>/'+val.content_id+'" class="btn btn-xs btn-default m-r-xs" data-toggle="tooltip" title="<?=lang('EDIT')?>"><i class="fa fa-pencil"></i></a>';
							out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'<?if($GLOBALS['settings_global']->content_delete_type == 1):?><?=lang('DELETE_CONTENT_TEXT')?><?else:?><?=lang('TRASH_CONTENT_TEXT')?><?endif;?>\', \'<?=base_url('backend/contents/delete')?>/'+val.content_id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('DELETE')?>"><i class="fa fa-trash-o"></i></a>';
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
			



		$('tbody', $(this)).sortable({
		    update: function(e, ui) {
		        var order = new Array();
		 
		        $(this).parents('table').find('tr').each(function() {
		        	
		            if (!isNaN($(this).attr('id'))) {
		                //oTable.fnUpdate($(this).index() + 1, oTable.fnGetPosition($(this)[0]), 0, false, false);
		                order.push($(this).attr('id'));
		            }
		        });
		 
		        //oTable.fnDraw();
		 
		        $.ajax({
		            type: "POST",
		            //traditional: true,
		            url: base_url+"backend/contents/update",
		            data: {
		                order: order
		            }
		        });
		    },
		    /*
		    helper: function(e, tr) {
		        var $originals = tr.children();
		        var $helper = tr.clone();
		        $helper.children().each(function(index) {
		            // Set helper cell sizes to match the original sizes
		            $(this).width($originals.eq(index).width())
		        });
		        return $helper;
		    },
		    */
		}).disableSelection();


				
		});
		
		$('.keyword').parent().append('<div class="col-sm-3"><div class="dataTables_filter"><label>Kategori: <select name="main_category" id="main_category" style="width:120px;"><option value="">Tümü</option><?if(isset($categories_selectbox)):?><?foreach($categories_selectbox as $category):?><option value="<?=$category->id?>"><?if($category->delimiter != '-'):?><?=$category->delimiter?><?endif;?> <?=$category->title?></option><?endforeach;?><?endif;?></select></label></div></div>');
			$('#main_category').on('change', function(){
				$('[data-ride="datatables"]').dataTable().fnFilter(
				$('#main_category').val(),
				0,
				true,
				true
			);			
		});
		
		$('.keyword').parent().append('<div class="col-sm-2"><div class="dataTables_filter"><label>Durum: <select name="status" id="status"><option value="A"><?=lang('ACTIVE')?></option><option value="I"><?=lang('INACTIVE')?></option></select></label></div></div>');
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
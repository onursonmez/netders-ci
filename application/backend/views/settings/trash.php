<link rel="stylesheet" href="<?=base_url('public/backend/js/datatables/datatables.css')?>" type="text/css"/>

<section class="panel panel-default">
	<header class="panel-heading">
		<?=lang('TRASH')?> 
		<i class="fa fa-info-sign text-muted" data-toggle="tooltip" data-placement="bottom" data-title="ajax to load the data."></i> 
	</header>
	<div class="table-responsive">
		<table class="table table-striped m-b-none" data-ride="datatables">
			<thead>
				<tr>
					<th width="10%"><?=lang('HASH_NO')?></th>
					<th><?=lang('TITLE')?></th>
					<th width="20%"><?=lang('MODULE')?></th>
					<th width="15%"><?=lang('DELETE_DATE')?></th>
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
				"sAjaxSource": base_url+"backend/settings/trash",
				//"sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sDom": "<'row filters'<'col-sm-4'l><'col-sm-8 keyword'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
				"sPaginationType": "full_numbers", // or two_button
				"aaSorting": [[ 0, "desc" ]],
				"oSearch": {"bSmart": false},
				//"bStateSave": true, // kullanıcı tabloyu nerde bıraktıysa refresh etsede orda kalır
				"fnInitComplete": function() {
				      setTimeout(function(){ $('[data-toggle="tooltip"]').tooltip(); }, 100);
				},
				"aoColumns": [
					{ "mData": "id" },
					{ "mData": "title" },
					{ "mData": "module_name" },
					{ "mData": "date",
						"mRender": function(source, type, val){
							return '<span data-toggle="tooltip" data-placement="top" title="'+val.nicetime+'">'+moment.unix(val.date).format('DD-MM-YYYY HH:mm')+'</span>';
						}
					},
					{ "mData": "id",
						"bSortable": false,
						"mRender": function(source, type, val)
						{
							var out = '';
							out += '<a onclick="confirmation(\'<?=lang('WARNING')?>\', \'<?=lang('TRASH_RESTORE_TEXT')?>\', \'<?=base_url('backend/settings/trash/restore')?>/'+val.id+'\')" class="btn btn-xs btn-default" data-toggle="tooltip" title="<?=lang('RESTORE')?>"><i class="fa fa-reply"></i></a>';
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
		
	
	});
}(window.jQuery);
</script>



<!--
<div class="widget">
    <div class="head <?if($_REQUEST['keyword'] || $_REQUEST['date_start'] || $_REQUEST['date_end'] || $_REQUEST['module']):?>active inactive<?else:?>opened<?endif;?>"><h5>Çöp Kutusunda Ara</h5></div>
    <div class="body">
        <form method="POST" action="<?=current_url()?>" class="mainForm">
            <table cellpadding="0" cellspacing="0" border="0" class="srcTable">
                <tr>
                    <td align="left" height="30">Anahtar Kelime</td>
                    <td align="left" height="30">Tarih Aralığı</td>
                    <td align="left" height="30">Tür</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="left"><input type="text" name="keyword" value="<?=$_REQUEST['keyword']?>" /></td>
                    <td align="left"><input type="text" name="date_start" class="searchDate1 w120" value="<?=$_REQUEST['date_start']?>" /> - <input type="text" name="date_end" class="searchDate2 w120" value="<?=$_REQUEST['date_end']?>" /></td>
                    <td align="left"><div><select name="module" class="select2"><option value="">Tümü</option><option value="contents"<?if($_REQUEST['module'] == 'contents'):?> selected<?endif;?>>İçerik</option><option value="contents_categories"<?if($_REQUEST['module'] == 'contents_categories'):?> selected<?endif;?>>Kategori</option><option value="users"<?if($_REQUEST['module'] == 'users'):?> selected<?endif;?>>Kullanıcı</option></select></div><div class="fix"></div></td>
                    <td align="left"><input type="submit" name="submit" value="Arama" class="basicBtn" /></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="fix b20"></div>

<form action="<?=current_url()?>" method="post" class="mainForm overviewForm">
<div class="widget">
    <div class="head"><h5 class="iFrames">Çöp Kutusu</h5></div>
    <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic">
        <?if(sizeof($items) > 0):?>
        <thead>
            <tr>
                <td>Başlık</td>
                <td>Tür</td>
                <td>Silinme Tarihi</td>
                <td>Silen Kullanıcı</td>
                <td width="43">İşlemler</td>
            </tr>
        </thead>
        <tbody>
        <?foreach($items as $item):?>
        <input type="hidden" name="nid[<?=$item->id?>]" value="<?=$item->id?>" />
        <tr>
            <td>
                <?if($item->module == 'contents' || $item->module == 'contents_categories'):?>
                    <?$titles = @explode('||', $item->title)?>
                    <?$ids = @explode('||', $item->module_id)?>
                    <?$langs = @explode('||', $item->lang_code)?>
                    <?foreach($titles as $key => $title):?>
                    <span class="flag flag-<?=$langs[$key]?>"> <?=$title?></span><br />
                    <?endforeach?>
                <?else:?>
                    <?=$item->title?><br />
                <?endif;?>
            </td>
            <td>
                <?if($item->module == 'users'):?>Kullanıcı
                <?elseif($item->module == 'contents'):?>İçerik
                <?elseif($item->module == 'contents_categories'):?>Kategori
                <?elseif($item->module == 'sliders'):?>Slayt
                <?endif;?>
            </td>
            <td><span class="topDir" title="<?=nicetime(date('d.m.Y H:i', $item->date))?>"><?=date('d.m.Y H:i', $item->date)?></span></td>
            <td><?=user_info('fullname', $item->uid)?></td>
            <td>
                <a onclick="confirmation('Lütfen Dikkat!', 'Veri kurtarılarak tekrar aktif duruma geçecektir.', '<?=base_url('backend/trash/restore/'.$item->id)?>');" title="Geri Yükle" class="btn14 topDir"><img src="<?=base_url('public/backend/images/icons/dark/arrowUp.png')?>" alt=""></a> 
                <a onclick="confirmation('Lütfen Dikkat!', 'Veri kalıcı olarak silinecektir.', '<?=base_url('backend/trash/delete/'.$item->id)?>');" title="Sil" class="btn14 topDir"><img src="<?=base_url('public/backend/images/icons/dark/arrowUp.png')?>" alt=""></a> 
            </td>
        </tr>
        <?endforeach;?>
        <?else:?>
            <div class="descr_lang_padding"><?=lang('CONTENTS_EMPTY')?></div>
        <?endif;?>
        </tbody>
    </table>
</div>
</form>
-->
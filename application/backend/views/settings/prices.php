<ul class="breadcrumb">
	<li><a href="#"><i class="fa fa-home"></i> Ana Sayfa</a></li>
	<li><a href="#"><?=lang('SETTINGS')?></a></li>
	<li><a href="#">Fiyatlar</a></li>
</ul>

<form class="form-inline" method="post" action="<?=current_url()?>">
<section class="panel panel-default">
	<header class="panel-heading bg-light">
		Fiyatlar
	</header>
	<div class="panel-body">
		<table class="table table-striped m-b-none">
			<thead>
				<tr>
					<th><input type="text" name="prices_desc" value="<?if($_REQUEST['prices_desc']):?><?=htmlspecialchars($_REQUEST['prices_desc'])?><?else:?><?=htmlspecialchars($GLOBALS['settings_global']->prices_desc)?><?endif;?>" class="form-control" placeholder="Fiyat açıklaması" /></th>
					<th width="50">Starter</th>
					<th width="50">Advanced</th>
					<th width="50">Premium</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Aylık</td>
					<td>x</td>
					<td><input type="text" name="price[1]" value="<?if($_REQUEST['price'][1]):?><?=htmlspecialchars($_REQUEST['price'][1])?><?else:?><?=htmlspecialchars($price[1]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[2]" value="<?if($_REQUEST['price'][2]):?><?=htmlspecialchars($_REQUEST['price'][2])?><?else:?><?=htmlspecialchars($price[2]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>3 Aylık</td>
					<td>x</td>
					<td><input type="text" name="price[3]" value="<?if($_REQUEST['price'][3]):?><?=htmlspecialchars($_REQUEST['price'][3])?><?else:?><?=htmlspecialchars($price[3]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[4]" value="<?if($_REQUEST['price'][4]):?><?=htmlspecialchars($_REQUEST['price'][4])?><?else:?><?=htmlspecialchars($price[4]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>6 Aylık</td>
					<td>x</td>
					<td><input type="text" name="price[5]" value="<?if($_REQUEST['price'][5]):?><?=htmlspecialchars($_REQUEST['price'][5])?><?else:?><?=htmlspecialchars($price[5]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[6]" value="<?if($_REQUEST['price'][6]):?><?=htmlspecialchars($_REQUEST['price'][6])?><?else:?><?=htmlspecialchars($price[6]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>12 Aylık</td>
					<td>x</td>
					<td><input type="text" name="price[7]" value="<?if($_REQUEST['price'][7]):?><?=htmlspecialchars($_REQUEST['price'][7])?><?else:?><?=htmlspecialchars($price[7]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[8]" value="<?if($_REQUEST['price'][8]):?><?=htmlspecialchars($_REQUEST['price'][8])?><?else:?><?=htmlspecialchars($price[8]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Haftalık VIT</td>
					<td><input type="text" name="price[9]" value="<?if($_REQUEST['price'][9]):?><?=htmlspecialchars($_REQUEST['price'][9])?><?else:?><?=htmlspecialchars($price[9]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[10]" value="<?if($_REQUEST['price'][10]):?><?=htmlspecialchars($_REQUEST['price'][10])?><?else:?><?=htmlspecialchars($price[10]->price)?><?endif;?>" class="form-control" /></td>
					<td>x</td>
				</tr>
				<tr>
					<td>Uzman Eğitmen Rozeti</td>
					<td><input type="text" name="price[11]" value="<?if($_REQUEST['price'][11]):?><?=htmlspecialchars($_REQUEST['price'][11])?><?else:?><?=htmlspecialchars($price[11]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[12]" value="<?if($_REQUEST['price'][12]):?><?=htmlspecialchars($_REQUEST['price'][12])?><?else:?><?=htmlspecialchars($price[12]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[13]" value="<?if($_REQUEST['price'][13]):?><?=htmlspecialchars($_REQUEST['price'][13])?><?else:?><?=htmlspecialchars($price[13]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Haftalık Doping</td>
					<td><input type="text" name="price[14]" value="<?if($_REQUEST['price'][14]):?><?=htmlspecialchars($_REQUEST['price'][14])?><?else:?><?=htmlspecialchars($price[14]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[15]" value="<?if($_REQUEST['price'][15]):?><?=htmlspecialchars($_REQUEST['price'][15])?><?else:?><?=htmlspecialchars($price[15]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[16]" value="<?if($_REQUEST['price'][16]):?><?=htmlspecialchars($_REQUEST['price'][16])?><?else:?><?=htmlspecialchars($price[16]->price)?><?endif;?>" class="form-control" /></td>
				</tr>																				
				<tr>
					<td>Aylık Doping</td>
					<td><input type="text" name="price[17]" value="<?if($_REQUEST['price'][17]):?><?=htmlspecialchars($_REQUEST['price'][17])?><?else:?><?=htmlspecialchars($price[17]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[18]" value="<?if($_REQUEST['price'][18]):?><?=htmlspecialchars($_REQUEST['price'][18])?><?else:?><?=htmlspecialchars($price[18]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[19]" value="<?if($_REQUEST['price'][19]):?><?=htmlspecialchars($_REQUEST['price'][19])?><?else:?><?=htmlspecialchars($price[19]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Özel Web Sayfası</td>
					<td><input type="text" name="price[20]" value="<?if($_REQUEST['price'][20]):?><?=htmlspecialchars($_REQUEST['price'][20])?><?else:?><?=htmlspecialchars($price[20]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[21]" value="<?if($_REQUEST['price'][21]):?><?=htmlspecialchars($_REQUEST['price'][21])?><?else:?><?=htmlspecialchars($price[21]->price)?><?endif;?>" class="form-control" /></td>
					<td>x</td>
				</tr>
				<tr>
					<td>Günün Eğitmeni</td>
					<td>x</td>
					<td><input type="text" name="price[22]" value="<?if($_REQUEST['price'][22]):?><?=htmlspecialchars($_REQUEST['price'][22])?><?else:?><?=htmlspecialchars($price[22]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[23]" value="<?if($_REQUEST['price'][23]):?><?=htmlspecialchars($_REQUEST['price'][23])?><?else:?><?=htmlspecialchars($price[23]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Haftanın Eğitmeni</td>
					<td>x</td>
					<td><input type="text" name="price[24]" value="<?if($_REQUEST['price'][24]):?><?=htmlspecialchars($_REQUEST['price'][24])?><?else:?><?=htmlspecialchars($price[24]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[25]" value="<?if($_REQUEST['price'][25]):?><?=htmlspecialchars($_REQUEST['price'][25])?><?else:?><?=htmlspecialchars($price[25]->price)?><?endif;?>" class="form-control" /></td>
				</tr>
				<tr>
					<td>Ayın Eğitmeni</td>
					<td>x</td>
					<td><input type="text" name="price[26]" value="<?if($_REQUEST['price'][26]):?><?=htmlspecialchars($_REQUEST['price'][26])?><?else:?><?=htmlspecialchars($price[26]->price)?><?endif;?>" class="form-control" /></td>
					<td><input type="text" name="price[27]" value="<?if($_REQUEST['price'][27]):?><?=htmlspecialchars($_REQUEST['price'][27])?><?else:?><?=htmlspecialchars($price[27]->price)?><?endif;?>" class="form-control" /></td>
				</tr>								
			</tbody>
		</table>		
	</div>
</section>

<button class="btn btn-default pull-right m-t" type="submit" name="submit">KAYDET</button>
</form>
<form  action="<?=site_url('users/memberships')?>" method="post" class="ajax-form js-dont-reset">
	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4 class="float-left pt-2">Üyelik Durumu</h4>
			<span class="float-right pt-2"><?if(PAYMENT_SYSTEM == 1):?><a href="<?=site_url('memberships')?>">Üyelik Yükselt</a><?endif;?></span>
			<div class="clearfix"></div>
		</div>
		<div class="card-body">

			<table class="table">
				<tbody>
					<tr>
						<td width="30%">Kayıt Tarihi</td>
						<td><?=date('d.m.Y H:i:s', $this->session->userdata('user_joined'))?></td>
					</tr>
					<tr>
						<td width="30%">Üyelik Tipi</td>
						<td>
							<?if(PAYMENT_SYSTEM == 0):?>
								<?=$this->session->userdata('user_group_name')?>
							<?else:?>
								<a href="<?=site_url('memberships')?>"><?=$this->session->userdata('user_group_name')?><?if($this->session->userdata('user_expire_trial') >  time()):?> (Deneme)<?endif;?></a>
							<?endif;?>
						</td>
					</tr>
					<?if($this->session->userdata('user_expire_membership') > time()):?>
					<tr>
						<td width="30%">Üyelik Sonlanma Tarihi</td>
						<td><?=date('d.m.Y H:i', $this->session->userdata('user_expire_membership'))?></td>
					</tr>
					<?endif;?>
				</tbody>
			</table>

		</div>
	</div>

	<div class="card box-shadow mb-4">
		<div class="card-header">
			<h4 class="float-left pt-2">Hizmetler</h4>
			<span class="float-right pt-2"><?if(PAYMENT_SYSTEM == 1):?><a href="<?=site_url('services')?>">Yeni Hizmet Al</a><?endif;?></span>
			<div class="clearfix"></div>
		</div>
		<div class="card-body">

			<table class="table">
				<thead>
					<th>Hizmet Adı</th>
					<th>Kullanım Durumu</th>
				</thead>
				<tbody>
					<tr>
						<td width="30%">Uzman Eğitmen Rozeti</td>
						<td><?if($this->session->userdata('user_service_badge') == 'Y'):?>Var<?elseif($this->session->userdata('user_service_badge') == 'N'):?>Yok<?else:?>Onay Bekliyor<?endif;?></td>
					</tr>
					<tr>
						<td width="30%">Özel Web Sayfası</td>
						<td><?if($this->session->userdata('user_ugroup') == 5 || $this->session->userdata('user_service_web') == 'Y'):?>Var<?else:?>Yok<?endif;?></td>
					</tr>
					<?if($this->session->userdata('user_ugroup') != 5):?>
					<tr>
						<td width="30%">Öne Çıkanlar</td>
						<td><?if($this->session->userdata('user_service_featured') != NULL && $this->session->userdata('user_service_featured') > time()):?><?=date('d.m.Y H:i', $this->session->userdata('user_service_featured'))?><?else:?>Yok<?endif;?></td>
					</tr>
					<?endif;?>
					<tr>
						<td width="30%">Doping</td>
						<td><?if($this->session->userdata('user_service_doping') != NULL && $this->session->userdata('user_service_doping') > time()):?><?=date('d.m.Y H:i', $this->session->userdata('user_service_doping'))?><?else:?>Yok<?endif;?></td>
					</tr>
					<!--
					<tr>
						<td width="30%">Editör Öneriyor</td>
						<td><?if($this->session->userdata('user_service_recommend') != NULL && $this->session->userdata('user_service_recommend') > time()):?><?=date('d.m.Y H:i', $this->session->userdata('user_service_recommend'))?><?else:?>Yok<?endif;?></td>
					</tr>
					<tr>
						<td width="30%">Arama Vitrini</td>
						<td><?if($this->session->userdata('user_service_showcase') != NULL && $this->session->userdata('user_service_showcase') > time()):?><?=date('d.m.Y H:i', $this->session->userdata('user_service_showcase'))?><?else:?>Yok<?endif;?></td>
					</tr>
					<tr>
						<td width="30%">Parlayan Profil</td>
						<td><?if($this->session->userdata('user_service_shining') != NULL && $this->session->userdata('user_service_shining') > time()):?><?=date('d.m.Y H:i', $this->session->userdata('user_service_shining'))?><?else:?>Yok<?endif;?></td>
					</tr>
					-->
					<tr>
						<td width="30%">Ayın Eğitmeni</td>
						<td>
							<?if(!empty($month)):?>
							<table class="table no-left-padding-td">
								<?foreach($month as $item):?>
								<tr>
									<td width="200"><?=$item['date']?></td>
									<td><?=$item['subject']->title?> > <?=$item['level']->title?></td>
								</tr>
								<?endforeach;?>
							</table>
							<?else:?>
							Yok
							<?endif;?>
						</td>
					</tr>
					<tr>
						<td width="30%">Haftanın Eğitmeni</td>
						<td>
							<?if(!empty($week)):?>
							<table class="table no-left-padding-td">
								<?foreach($week as $item):?>
								<tr>
									<td width="200"><?=$item['date']?></td>
									<td><?=$item['subject']->title?> > <?=$item['level']->title?></td>
								</tr>
								<?endforeach;?>
							</table>
							<?else:?>
							Yok
							<?endif;?>
						</td>
					</tr>
					<tr>
						<td width="30%">Günün Eğitmeni</td>
						<td>
							<?if(!empty($day)):?>
							<table class="table no-left-padding-td">
								<?foreach($day as $item):?>
								<tr>
									<td width="200"><?=$item['date']?></td>
									<td><?=$item['subject']->title?> > <?=$item['level']->title?></td>
								</tr>
								<?endforeach;?>
							</table>
							<?else:?>
							Yok
							<?endif;?>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>

	<?if(!$this->input->get('cancellation')):?>
	<div class="text-right">
		<span class="font-size-12"><a href="<?=site_url('users/memberships?cancellation=1')?>">Üyelik İptali</a></span>
	</div>
	<?endif;?>

	<?if($this->input->get('cancellation')):?>
	<div class="card box-shadow mb-4">
		<div class="card-header"><h4>Üyelik İptali</h4></div>
		<div class="card-body">

			<div class="row">
				<div class="form-group col-md-12">
					<label>Mevcut Şifre</label>
					<input type="password" name="password" class="form-control" />
				</div>

				<div class="form-group col-md-12">
					<label>İptal Nedeni</label>
					<textarea name="reason" class="form-control"></textarea>
				</div>

				<div class="col-md-12">
					<button type="submit" class="btn btn-primary js-submit-btn">Üyeliğimi İptal Et</button>
					<button disabled="disabled" class="btn btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
				</div>
			</div>

		</div>
	</div>
	<?endif;?>
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
</form>

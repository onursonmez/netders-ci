<section class="profile">
	<div class="profile-cover">
		<div class="profile-cover-image">
		</div>
	</div>
	<div class="container">
		<div class="profile-top-wrapper">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 no-float profile-top-left">
					<?if($this->session->userdata('last_search')):?>
					<div class="profile-go-back-link">
						<a href="<?=$this->session->userdata('last_search')?>">
							<i class="fa fa-reply"></i> Arama sonuçlarına geri dön
						</a>
					</div>
					<?endif;?>
					<amp-img width="200" height="200" class="img-thumbnail margin-bottom-20" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>"></amp-img>
					<div class="text-center margin-bottom-20 lightred-text">
						<?if(!$user->email_request):?><i class="fa fa-envelope-o margin-left-5 margin-right-5 font-size-24" data-toggle="tooltip" data-placement="top" title="E-posta Onaylı Üye"></i><?endif;?>
						<?if($user->service_badge == 'Y'):?><i class="fa fa-bookmark margin-left-5 margin-right-5 font-size-24" data-toggle="tooltip" data-placement="top" title="Sertifikalı Eğitmen"></i><?endif;?>
					</div>	
					<div class="row">
						<?if(!empty($user->city_title)):?>
						<div class="col-md-12 margin-bottom-10">
							<i class="fa fa-map-marker lightred-text" data-toggle="tooltip" data-placement="top" title="Yaşadığı Yer"></i> 
							<?=$user->city_title?> / <?=$user->town_title?>
						</div>
						<?endif;?>					
						<div class="col-md-12 margin-bottom-10">
							<i class="fa fa-calendar-o lightred-text" data-toggle="tooltip" data-placement="top" title="Yaş"></i> <?=calculate_age($user->birthday)?> yaşında
						</div>
						<div class="col-md-12 margin-bottom-10">
							<i class="fa fa-user-plus lightred-text" data-toggle="tooltip" data-placement="top" title="Üyelik Tarihi"></i> <?=date('d/m/Y', $user->joined)?>
						</div>						
					</div>
				</div>
				<div class="col-sm-8 col-md-5 col-lg-7 no-float profile-top-center">
					<div class="pull-left">
						<h2><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></h2>
					</div>
					<div class="pull-right">
						<?if($user->online):?>
							<span class="lightred-text"><i class="fa fa-power-off"></i> Çevrimiçi</span>
						<?else:?>
							<span class="lightgrey-text">Çevrimdışı</span>
						<?endif;?>
					</div>
					<div class="clearfix"></div>
					<p class="grey-text"><?=nl2br($user->text_title)?></p>

					<p><?=nl2br($user->text_long)?></p>
				</div>
				<div class="col-sm-12 col-md-4 col-lg-3 no-float profile-top-right">
				
					<div class="btn-group btn-group-justified">
						<div class="btn-group padded-table">
					      <div class="padded-table">
					  		<div class="tc-fluid">
					          <button class="btn btn-default">
									<?/*görüntüleyen üye değilse*/?>
									<?if(!$this->session->userdata('user_id')):?>
										<?if(($user->privacy_phone == 1 && ($user->ugroup == 3 || $user->ugroup == 4 || $user->ugroup == 5)) || check_viewphones_ips($user->id)):?>
										<span class="ajaxmobile"><a href="#" onclick="getmobile('<?=$user->activation_code?>-<?=md5(md5(date('d.m.Y', time())))?>')"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>							
										<?else:?>
										<span data-toggle="tooltip" data-placement="top" title="Telefon numarasını görüntüleyebilmek için üye girişi yapmanız gerekmektedir. Üye iseniz giriş yapmak için tıklayınız."><a href="<?=site_url('giris')?>"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>
										<?endif;?>
									<?else:?>
										<?/*görüntüleyen basic, silver, gold üye ise*/?>
										<?if($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
											<span data-toggle="tooltip" data-placement="top" title="Yalnızca üye öğrenciler telefon numarasını görebilir!"><a href="#"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>
										<?/*görüntüleyen öğrenci veya admin ise*/?>
										<?else:?>
											<?/*eğitmen silver veya gold ise, telefon herkese ve üye öğrencilere görünsün ise*/?>
											<?if(($user->ugroup == 3 || $user->ugroup == 4 || $user->ugroup == 5) && ($user->privacy_phone == 1 || $user->privacy_phone == 2)):?>
												<span class="ajaxmobile"><a href="#" onclick="getmobile('<?=$user->activation_code?>-<?=md5(md5(date('d.m.Y', time())))?>')"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>							
											<?/*değilse*/?>
											<?else:?>
												<span data-toggle="tooltip" data-placement="top" title="Eğitmen telefon numarasını göstermek istemiyor"><a href="#"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>
											<?endif;?>
										<?endif;?>
									<?endif;?>
					          </button>
					        </div>
					         
					        <div class="tc-fixed">
					          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					              <span class="caret"></span>
					              <span class="sr-only">Toggle Dropdown</span>
					          </button>
					          <ul class="dropdown-menu pull-right" role="menu">
									<li><a href="#" class="scrollto" data-attr-scroll="newmessage" data-scroll-offset="100"><i class="fa fa-envelope"></i> Mesaj Gönder</a></li>
									<?/*görüntüleyen üye değilse*/?>
									<?if(!$this->session->userdata('user_id')):?>
										<li data-toggle="tooltip" data-placement="top" title="Yorum yapabilmek için üye girişi yapmanız gerekmektedir. Üye iseniz giriş yapmak için tıklayınız."><a href="<?=site_url('giris')?>"><i class="fa fa-comment fa-fw"></i> Yorum Yap</a></li>
									<?else:?>
										<?/*görüntüleyen basic, silver, gold üye ise*/?>
										<?if($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5):?>
											<li data-toggle="tooltip" data-placement="top" title="Yalnızca üye öğrenciler yorum yapabilir!"><a href="#"><i class="fa fa-comment"></i>Yorum Yap</a></li>					
										<?/*görüntüleyen öğrenci veya admin ise*/?>
										<?else:?>
											<li><a href="#" class="scrollto" data-attr-scroll="newcomment" data-scroll-offset="100"><i class="fa fa-comment"></i> Yorum Yap</a></li>							
										<?endif;?>
									<?endif;?>
					          </ul>
					        </div>
					      </div>
						</div>
					</div>
					
					<?if($user->price_min || $user->price_max):?>
					<div class="text-center margin-top-20 price">
						<?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> <span>TL/Saat</span>
					</div>
					<?endif;?>
					
					<?
						$discount = get_user_discount($user);
					?>
					<ul class="item-stats">
						<li>
							<span class="item-stats-value"><i class="fa<?if(empty($discount['freefirst'])):?> fa-close red-text<?else:?> fa-check<?endif;?>"></i></span><span class="item-stats-name">Ücretsiz İlk Ders</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['registered'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['registered']?>%<?endif;?></span><span class="item-stats-name">Üye Öğrenci İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['teacher'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['teacher']?>%<?endif;?></span><span class="item-stats-name">Eğitmen Evi İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['group'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['group']?>%<?endif;?></span><span class="item-stats-name">Grup İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['program'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['program']?>%<?endif;?></span><span class="item-stats-name">Paket Program İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['live'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['live']?>%<?endif;?></span><span class="item-stats-name">Canlı Ders İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['disabled'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['disabled']?>%<?endif;?></span><span class="item-stats-name">Engelli İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><?if(empty($discount['review'])):?><i class="fa fa-close red-text"></i><?else:?><?=$discount['review']?>%<?endif;?></span><span class="item-stats-name">Öneri İndirimi</span>
						</li>			
					</ul>	
							
				</div>
			</div>
		</div>
		
		<?if($user->school_name || $user->school2_name || $user->school3_name || $user->school4_name):?>
		<div class="profile-well">
			<h3>Eğitim Durumu</h3>
			<div class="profile-well-body">
			
				<?if($user->school4_name && $user->school4_section):?>
					<div><span class="label label-success pull-left margin-right-5">Doktora</span> <strong><?=$user->school4_name?></strong> - <?=$user->school3_section?> <?if($user->school4_end):?>(<?=$user->school4_end?>)<?endif;?></div>
				<?endif;?>
				
				<?if($user->school3_name && $user->school3_section):?>
					<div><span class="label label-success pull-left margin-right-5">Yüksek Lisans</span> <strong><?=$user->school3_name?></strong> - <?=$user->school3_section?> <?if($user->school3_end):?>(<?=$user->school3_end?>)<?endif;?></div>
				<?endif;?>
				
				<?if($user->school2_name && $user->school2_section):?>
					<div><span class="label label-success pull-left margin-right-5">Lisans</span> <strong><?=$user->school2_name?></strong> - <?=$user->school2_section?> <?if($user->school2_end):?>(<?=$user->school2_end?>)<?endif;?></div>
				<?endif;?>								
				
				<?if($user->school_name):?>
					<div><span class="label label-success pull-left margin-right-5">Lise</span> <strong><?=$user->school_name?></strong> <?if($user->school_end):?>(<?=$user->school_end?>)<?endif;?></div>
				<?endif;?>				
			</div>
		</div>
		<?endif;?>

		<div class="profile-well">
			<h3>Ders Ücretleri</h3>
			<div class="profile-well-body">
				<?if(!empty($prices)):?>
				<table class="table table-striped">
					<thead>
						<tr bgcolor="#fafafa">
							<th>Ders Adı</th>
							<th>Özel Ders</th>
							<th>Canlı Ders</th>
						</tr>
					</thead>				
					<tbody>
						<?foreach($prices as $price):?>
						<tr>
							<td><?if($price->status == 'A'):?>
									<a href="<?=site_url($price->seo_link)?>"><?=$price->subject_title?> - <?=$price->level_title?></a>
								<?else:?>
									<?=$price->subject_title?> - <?=$price->level_title?>
								<?endif;?>
							</td>
							<td><?if(empty($price->price_private)):?>Vermiyorum<?else:?><?=$price->price_private?> TL<?endif;?></td>
							<td><?if(empty($price->price_live)):?>Vermiyorum<?else:?><?=$price->price_live?> TL<?endif;?></td>
						</tr>
						<?endforeach;?>
					</tbody>
				</table>			
				<?endif;?>				
			</div>
		</div>

		
		<?if(!empty($user->text_lesson)):?>
		<div class="profile-well">
			<h3>Ders Yaklaşımı ve Tecrübesi</h3>
			<div class="profile-well-body">
				<p><?=nl2br($user->text_lesson)?></p>			
			</div>
		</div>
		<?endif;?>
				
		<div class="profile-well">
			<h3>Özel Ders Eğitim Tercihleri</h3>
			<div class="profile-well-body">
				<div class="row">
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Mekan</strong>
						<?$places = $user->places ? explode(',', $user->places) : '';?>
						<ul class="nav">
							<?foreach(education_types(1) as $key => $value):?>
							<?if(!empty($places) && in_array($key, $places)):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?else:?>
								<li> <i class="fa fa-close red-text"></i> <?=$value?></li>
							<?endif;?>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->
					
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Zaman</strong>
						<?$times = $user->times ? explode(',', $user->times) : '';?>
						<ul class="nav">
							<?foreach(education_types(2) as $key => $value):?>
							<?if(!empty($times) && in_array($key, $times)):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?else:?>
								<li> <i class="fa fa-close red-text"></i> <?=$value?></li>
							<?endif;?>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->
					
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Hizmet</strong>
						<?$services = $user->services ? explode(',', $user->services) : '';?>
						<ul class="nav">
							<?foreach(education_types(3) as $key => $value):?>
							<?if(!empty($services) && in_array($key, $services)):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?else:?>
								<li> <i class="fa fa-close red-text"></i> <?=$value?></li>
							<?endif;?>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->
					
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Cinsiyet</strong>
						<?$genders = $user->genders ? explode(',', $user->genders) : '';?>
						<ul class="nav">
							<?foreach(education_types(4) as $key => $value):?>
							<?if(!empty($genders) && in_array($key, $genders)):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?else:?>
								<li> <i class="fa fa-close red-text"></i> <?=$value?></li>
							<?endif;?>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->										
				</div><!--.row-->
			</div>
		</div>
		
		
		<div class="profile-well">
			<h3>Özel Ders Verilen Bölgeler</h3>
			<div class="profile-well-body">
				<?if(empty($locations)):?>
					Özel ders verilen lokasyon bilgisi bulunmamaktadır.
				<?else:?>
				<table class="table">				
					<tbody>
						<?foreach($locations as $city => $towns):?>
						<tr>
							<td width="100"><strong><?=location_name('cities', $city)?></strong></td>
							<td>
								<?if(!empty($towns)):?>
									<?$town_titles = array()?>
									<?foreach($towns as $town):?>
										<?if(!empty($town->town)):?>
											<?$town_titles[] = location_name('towns', $town->town)?>
										<?endif;?>
									<?endforeach;?>
									<?if(!empty($town_titles)):?><?=@implode(', ', $town_titles)?><br /><?endif;?>
								<?endif;?>								
							</td>
						</tr>
						<?endforeach;?>
					</tbody>
				</table>	
				<?endif;?>			
			</div>
		</div>
		
		<?if(!empty($user->discount11_text) || !empty($user->discount12_text) || !empty($user->discount13_text)):?>
		<div class="profile-well">
			<h3>İndirim Şartları</h3>
			<div class="profile-well-body">
				<?if(!empty($user->discount11_text)):?>
					<strong>Paket Program İndirimi Şartları</strong><br />
					<p><?=$user->discount11_text?></p>				
				<?endif;?>
				
				<?if(!empty($user->discount12_text)):?>
					<strong>Engelli İndirimi Şartları</strong><br />
					<p><?=$user->discount12_text?></p>				
				<?endif;?>
				
				<?if(!empty($user->discount13_text)):?>
					<strong>Öneri İndirimi Şartları</strong><br />
					<p><?=$user->discount13_text?></p>				
				<?endif;?>				
			</div>
		</div>
		<?endif;?>
		
		<?if(!empty($user->text_reference)):?>
		<div class="profile-well">
			<h3>Referanslar</h3>
			<div class="profile-well-body">
				<p><?=nl2br($user->text_reference)?></p>			
			</div>
		</div>
		<?endif;?>
		
		<?if(!empty($comments)):?>
		<div class="profile-well">
			<h3>Yorumlar</h3>
			<div class="profile-well-body">
				<?foreach($comments as $comment):?>
				<hr />
				<p><b><?=user_info('username', $comment->from_uid)?>, <?=date('d F Y', $comment->date)?></b></p>
				<p><?if($comment->star):?><?for($i=0;$i<$comment->star;$i++):?><i class="fa fa-star"></i><?endfor;?><?endif;?></p>
				<p><?=nl2br($comment->comment)?></p>
				<?endforeach;?>
			</div>
		</div>
		<?endif;?>
		
		<?if($this->session->userdata('user_id')):?>
		<div class="profile-well" id="newcomment">
			<h3>Yorum Yap</h3>
			<div class="profile-well-body">
				<p>Eğitmenden ders aldıysanız aşağıdaki alanları doldurarak yorum ve değerlendirme yapabilirsiniz.</p>
		          <form method="POST" action-xhr="<?=site_url('users/sendcomment')?>" class="ajax-form" target="_top">
			            <div class="row">
						  <div class="col-lg-12">
						  		<select name="point" class="form-control margin-bottom-10">
						  			<option value="">-- Verdiğiniz Puan --</option>
						  			<option value="1">1 (Berbat)</option>
						  			<option value="2">2 (Kötü)</option>
						  			<option value="3">3 (Normal)</option>
						  			<option value="4">4 (İyi)</option>
						  			<option value="5">5 (Kusursuz)</option>
						  		</select>
			              </div>
			
			              <div class="col-lg-12">
			                    <textarea name="comment" rows="5" placeholder="Lütfen yorumunuzu bu alana yazınız" class="form-control margin-bottom-10"></textarea>
			              </div>      
			              
						<div class="col-md-2 margin-bottom-10">
							<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
						</div>	
											
						<div class="col-md-2 margin-bottom-10">
							<amp-img src="<?=base_url('captcha/'.generate_captcha('ajax_comment'))?>" width="220" height="32"></amp-img>
						</div>
			              
			              <div class="col-lg-12">
			                  <button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-commenting"></i> Yorum yap</button>
			                  <button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
			              </div>
			
			            </div>
						<input type="hidden" name="user_id" value="<?=$user->id?>" />
						<input type="hidden" name="form" value="ajax_comment" />
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		          </form>
			</div>
		</div>
		<?endif;?>								

		<div class="profile-well" id="newmessage">
			<h3>Mesaj Gönder</h3>
			<div class="profile-well-body">
				<p>Aşağıdaki formu kullanarak eğitmene özel mesaj gönderebilirsiniz.<?if(!$this->session->userdata('user_id')):?> Mesajınızı gönderdiğinizde eğitmen girdiğiniz cep telefonundan sizi arayacaktır. Size yeni bir cevap mesaj gönderildiğinde e-posta ile bilgilendirileceksiniz. Bu nedenle e-posta adresinizi ve cep telefonu numaranızı doğru girmeniz gerekmektedir.<?endif;?></p>	
				<form method="POST" action-xhr="<?=site_url('users/sendmessage')?>" class="ajax-form" target="_top">
					<div class="row">
						<?if(!$this->session->userdata('user_id')):?>
						<div class="col-md-3 margin-bottom-10">
							<label>Adınız</label>
							<input type="text" name="firstname" class="form-control" value="<?=$this->input->cookie('unknown_msg_firstname')?>" />
						</div>
						
						<div class="col-md-3 margin-bottom-10">
							<label>Soyadınız</label>
							<input type="text" name="lastname" class="form-control" value="<?=$this->input->cookie('unknown_msg_lastname')?>" />
						</div>
						<div class="col-md-3 margin-bottom-10">
							<label>E-posta Adresiniz</label>
							<input type="email" name="email" class="form-control" value="<?=$this->input->cookie('unknown_msg_email')?>" />
						</div>												
						<div class="col-md-3 margin-bottom-10">
							<label>Cep Telefonu Numaranız</label>
							<input type="text" name="mobile" data-type="mobile-number" class="form-control" value="<?=$this->input->cookie('unknown_msg_mobile')?>" />
						</div>
						<?endif;?>				
						<div class="col-md-12 margin-bottom-10">
							<label>Mesajınız</label>
							<textarea name="message" rows="5" class="form-control" placeholder="Lütfen mesajınızı bu alana yazınız"></textarea>
						</div>
						<div class="col-md-2 margin-bottom-10">
							<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
						</div>						
						<div class="col-md-2 margin-bottom-10">
							<amp-img src="<?=base_url('captcha/'.generate_captcha('ajax_message'))?>" width="220" height="32"></amp-img>
						</div>
						<div class="col-md-12">
							<button type="submit" class="btn btn-orange js-submit-btn"><i class="fa fa-rocket"></i> Gönder</button>
							<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
						</div>
					</div>
					<input type="hidden" name="user_id" value="<?=$user->id?>" />
					<input type="hidden" name="form" value="ajax_message" />
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				</form>
			</div>
		</div>		
				
	</div>
</section>
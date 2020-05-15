<section class="profile">
	<div class="profile-cover">
		<div class="profile-cover-image" style="background:url(<?=base_url('public/img/cover.jpg')?>); background-attachment: fixed;"></div>
	</div>
	<div class="container">
		<div class="profile-top-wrapper">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 no-float profile-top-left">
					<img class="img-thumbnail margin-bottom-20" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" />
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
						
						<?if(!empty($user->virtual_age)):?>
						<div class="col-md-12 margin-bottom-10">
							<i class="fa fa-calendar-o lightred-text" data-toggle="tooltip" data-placement="top" title="Yaş"></i> <?=$user->virtual_age?> yaşında
						</div>
						<?endif;?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-5 col-lg-7 no-float profile-top-center">
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
					
					<?if(!empty($user->text_long)):?>
					<p><?=nl2br($user->text_long)?></p>
					<?endif;?>
					
				</div>
				<div class="col-sm-12 col-md-4 col-lg-3 no-float profile-top-right">
					
					<?if($GLOBALS['settings_global']->mobile):?>
					<div class="btn-group btn-group-justified">
						<div class="btn-group padded-table" style="white-space: nowrap;">
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
					          </ul>
					        </div>
					      </div>
						</div>
					</div>
					<?else:?>
					<div class="btn-big">
						<a href="#" class="scrollto" data-attr-scroll="newmessage" data-scroll-offset="100"><i class="fa fa-envelope"></i> Hızlı Mesaj Gönder</a>
					</div>			
					<?endif;?>
					
					<div class="text-center margin-top-20 price">
						<?if($user->virtual_price):?><span>Ortalama Ders Ücreti</span><br /><?=$user->virtual_price?><?else:?>Ücret Görüşülür<?endif;?>
					</div>
					
					<?
						$discount = get_user_discount($user);
					?>
					<ul class="item-stats">
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Ücretsiz İlk Ders</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Üye Öğrenci İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Eğitmen Evi İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Grup İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Paket Program İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Canlı Ders İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Engelli İndirimi</span>
						</li>
						<li>
							<span class="item-stats-value"><i class="fa fa-check"></i></span><span class="item-stats-name">Öneri İndirimi</span>
						</li>			
					</ul>	
							
				</div>
			</div>
		</div>
		
		<?if(!empty($user->virtual_education)):?>
		<div class="profile-well">
			<h3>Eğitim Durumu</h3>
			<div class="profile-well-body">
				<?=$user->virtual_education?>			
			</div>
		</div>
		<?endif;?>

		<div class="profile-well">
			<h3>Özel Ders Verilen Bölgeler</h3>
			<div class="profile-well-body">
				Tüm <?=$user->city_title?>			
			</div>
		</div>
				
		<div class="profile-well">
			<h3>Özel Ders Eğitim Tercihleri</h3>
			<div class="profile-well-body">
				<div class="row">
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Mekan</strong>
						<?$places = $user->places ? explode(',', $user->places) : '';?>
						<ul class="nav">
							<?foreach(education_types(1) as $key => $value):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->
					
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Zaman</strong>
						<?$times = $user->times ? explode(',', $user->times) : '';?>
						<ul class="nav">
							<?foreach(education_types(2) as $key => $value):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->
					
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Hizmet</strong>
						<?$services = $user->services ? explode(',', $user->services) : '';?>
						<ul class="nav">
							<?foreach(education_types(3) as $key => $value):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->
					
					<div class="col-md-3 col-sm-6 profile-preferences-item">
						<strong>Cinsiyet</strong>
						<?$genders = $user->genders ? explode(',', $user->genders) : '';?>
						<ul class="nav">
							<?foreach(education_types(4) as $key => $value):?>
								<li><i class="fa fa-check green-text"></i> <?=$value?></li>
							<?endforeach;?>
						</ul>
					</div><!--.col-md-4-->										
				</div><!--.row-->
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
		          <form method="POST" action="<?=site_url('users/sendcomment')?>" class="ajax-form">
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
							<img src="<?=base_url('captcha/'.generate_captcha('ajax_comment'))?>" width="100%" height="32" />
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
				<form method="POST" action="<?=site_url('users/sendmessage')?>" class="ajax-form">
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
							<img src="<?=base_url('captcha/'.generate_captcha('ajax_message'))?>" width="100%" height="32" />
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
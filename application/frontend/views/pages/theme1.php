<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    
    <?if(isset($seo_title)):?>
    <title><?if(isset($seo_title)):?><?=$seo_title?><?else:?><?=$GLOBALS['settings_site']->seo_title?><?endif;?></title>
    <?endif;?>

	<?if(isset($seo_description)):?>
	<meta name="description" content="<?if(isset($seo_description)):?><?=$seo_description?><?else:?><?=$GLOBALS['settings_site']->seo_description?><?endif;?>" />
	<?endif;?>
	
	<?if(isset($seo_keyword)):?>
	<meta name="keywords" content="<?if(isset($seo_keyword)):?><?=$seo_keyword?><?elseif($this->router->fetch_class() == 'home'):?><?=$GLOBALS['settings_site']->seo_keyword?><?endif;?>" />
	<?endif;?>
	
	<meta http-equiv="Content-Language" content="TR" />
	<meta name="robots" content="noodp" />

	<link rel="alternate" hreflang="tr" href="<?=site_url()?>" />

    <link href="<?=base_url('public/theme1/css/bootstrap.css')?>" rel="stylesheet"><!-- Bootstrap -->
    <link href="<?=base_url('public/theme1/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet"><!-- font-awesome -->
    <link href="<?=base_url('public/theme1/css/magnific-popup.css')?>" rel="stylesheet"><!-- Banner BG -->
    <link href="<?=base_url('public/theme1/css/animate.css')?>" rel="stylesheet"><!-- Banner BG -->
    <link href="<?=base_url('public/vendor/intl-tel-input/build/css/intlTelInput.css')?>" rel="stylesheet" />  
    <link href="<?=base_url('public/theme1/css/style.css')?>" rel="stylesheet"><!-- Theme Core CSS -->

	<script type="text/javascript">
		var base_url 					= '<?=base_url()?>';
	</script>    
  </head>
  <body>

    <div id="tab-container" class="black-bg-solid">
    
        <header class="header-area">
            <div class="container">
                <div class="header-outer clearfix">
                    <div class="logo clearfix">
                    	<span><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></span>
                        <a href="#" class="nav-toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="navigation-area">
                        <ul>
                            <li><a href="#home"><i class="fa fa-home"></i> ANA SAYFA</a></li>
                            <li><a href="#about"><i class="fa fa-info"></i> HAKKINDA</a></li>
                            <li><a href="#lessons"><i class="fa fa-book"></i> DERSLER</a></li>
                            <li><a href="#discounts"><i class="fa fa-tag"></i> İNDİRİMLER</a></li>
                            <li><a href="#comments"><i class="fa fa-comments"></i> YORUMLAR</a></li>
                            <li><a href="#contact"><i class="fa fa-envelope"></i> İLETİŞİM</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>

        <section class="full-page-cont clearfix">
            <div class="container">
            	<div class="row">
                    
                    <article class="home-page animated" id="home">
                        <div class="row">
                            
                            <div class="col-md-6 home-profile">
                                <div class="home-profile-image"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt=""></div>
                                <div class="home-profile-quick">
	                                <?if($user->text_long):?>
	                                <h3><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></h3>
	                                <br /><?=truncate($user->text_long, 400)?> <a href="#about">DEVAMI</a>
	                                <br />
	                                <?endif;?>
                                    <a href="#contact" class="view-profile">İLETİŞİME GEÇ</a>
                                </div>
                            </div>

                            <div class="col-md-6 home-details">
                                <h1><span>HOŞGELDİNİZ</span><br /><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></h1>
                                <h2>Özel Ders <?if(!empty($user->company_name)):?>Hizmetleri<?else:?>Eğitmeni<?endif;?></h2>
                            </div>
                                                   
                        </div>
                    </article>

                    <article class="common-inner animated clearfix" id="about">
                        <div class="common-image">
                            <div class="image-cont"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt=""></div>
                        </div>

                        <div class="profile-cont">
                            <div class="profile-top">
                                <h2><span><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></span> HAKKINDA</h2>
                                <h3><?=nl2br($user->text_title)?></h3>
                            </div>
                            
                            <div class="row profile-col-cont">
                                <div class="<?if(!empty($user->company_name)):?>col-md-offset-2<?endif;?> col-md-4 text-center">
                                    <span class="icons"><i class="fa fa-picture-o"></i></span>
                                    <h3>Bulunduğu Yer</h3>
                                    <p><?=$user->city_title?> / <?=$user->town_title?></p>
                                </div>
                                
                                <?if(empty($user->company_name)):?>
                                <div class="col-md-4 text-center">
                                    <span class="icons"><i class="fa fa-desktop"></i></span>
                                    <h3>Yaş</h3>
                                    <p><?=calculate_age($user->birthday)?> yaşında</p>
                                </div>
                                <?endif;?>
                                
                                <div class="col-md-4 text-center">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3>Ders Ücreti</h3>
                                    <p><?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL</p>
                                </div>
                            </div>
                            
                            <div class="row profile-middle-content clearfix">

								<?if($user->school_name || $user->school2_name || $user->school3_name || $user->school4_name):?>
								<div class="col-md-12">
									<h3>Eğitim Durumu</h3>
									<div class="profile-well-body">
									
										<?if($user->school4_name && $user->school4_section):?>
											<div><span class="label label-success pull-left margin-right-5">Doktora</span> <strong><?=$user->school4_name?></strong> - <?=$user->school3_section?> <?if($user->school4_start && $user->school4_end):?>(<?=$user->school4_start?> - <?=$user->school4_end?>)<?endif;?></div>
										<?endif;?>
										
										<?if($user->school3_name && $user->school3_section):?>
											<div><span class="label label-success pull-left margin-right-5">Yüksek Lisans</span> <strong><?=$user->school3_name?></strong> - <?=$user->school3_section?> <?if($user->school2_start && $user->school3_end):?>(<?=$user->school3_start?> - <?=$user->school3_end?>)<?endif;?></div>
										<?endif;?>
										
										<?if($user->school2_name && $user->school2_section):?>
											<div><span class="label label-success pull-left margin-right-5" style="vertical-align:middle;">Lisans</span> <strong><?=$user->school2_name?></strong> - <?=$user->school2_section?> <?if($user->school2_start && $user->school2_end):?>(<?=$user->school2_start?> - <?=$user->school2_end?>)<?endif;?></div>
										<?endif;?>								
										
										<?if($user->school_name):?>
											<div><span class="label label-success pull-left margin-right-5">Lise</span> <strong><?=$user->school_name?></strong> <?if($user->school_start && $user->school_end):?>(<?=$user->school_start?> - <?=$user->school_end?>)<?endif;?></div>
										<?endif;?>				
									</div>
								</div>
								<?endif;?>

								<?if(!empty($user->text_long)):?>
								<div class="col-md-12 margin-top-40">
									<h3>Detaylı Bilgi</h3>
									<p><?=nl2br($user->text_long)?></p>			
								</div>
								<?endif;?>
                                
                                
								<?if(!empty($user->text_reference)):?>
								<div class="col-md-12 margin-top-40">
									<h3>Referanslar</h3>
									<p><?=nl2br($user->text_reference)?></p>			
								</div>
								<?endif;?>                                                              
                            </div>
                        </div>
                    </article>

                    <article class="common-inner animated clearfix" id="lessons">
                        <div class="common-image">
                            <div class="image-cont"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt=""></div>
                        </div>

                        <div class="profile-cont">
                            <div class="profile-top">
                                <h2>DERS <span>ÜCRETLERİ</span></h2>
                                <h3>Öğrencilerime aşağıdaki özel dersleri veriyorum</h3>
                            </div>

							<?if(!empty($prices)):?>
							<table class="table table-striped">
								<thead>
									<tr>
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

                            <div class="profile-top margin-top-40">
                                <h2>DERS VERİLEN <span>LOKASYONLAR</span></h2>
                                <h3>Aşağıdaki lokasyonlarda özel ders veriyorum</h3>
                            </div>
                            							
							<?if(empty($locations)):?>
								Özel ders verilen lokasyon bilgisi bulunmamaktadır.
							<?else:?>
							<table class="table table-striped">				
								<tbody>
									<?foreach($locations as $city => $towns):?>
									<tr>
										<td width="100" nowrap=""><strong><?=location_name('cities', $city)?></strong></td>
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

                            <div class="profile-top margin-top-40">
                                <h2>DERS VERİLEN <span>ŞEKİLLER</span></h2>
                                <h3>Aşağıdaki şekillerde özel ders veriyorum</h3>
                            </div>
                            							
							<div class="col-md-12 bigger-icons">

                                <div class="col-md-offset-1 col-md-2 text-center margin-bottom-30">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3 class="margin-bottom-10">Tür</h3>
                                    <?$figures = $user->figures ? explode(',', $user->figures) : '';?>
                                    <?if(empty($figures)):?>
                                    Tür bilgisi için iletişime geçiniz.
                                    <?else:?>
                                    <?$education_types = education_types(5)?>
                                    <?foreach($figures as $figure):?>
                                    <i class="fa fa-check"></i> <?=$education_types[$figure]?><br />
                                    <?endforeach;?>
                                    <?endif;?>
                                </div>
                                							
                                <div class="col-md-2 text-center margin-bottom-30">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3 class="margin-bottom-10">Mekan</h3>
                                    <?$places = $user->places ? explode(',', $user->places) : '';?>
                                    <?if(empty($places)):?>
                                    Mekan bilgisi için iletişime geçiniz.
                                    <?else:?>
                                    <?$education_types = education_types(1)?>
                                    <?foreach($places as $place):?>
                                    <i class="fa fa-check"></i> <?=$education_types[$place]?><br />
                                    <?endforeach;?>
                                    <?endif;?>
                                </div>
                                
                                <div class="col-md-2 text-center margin-bottom-30">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3 class="margin-bottom-10">Zaman</h3>
                                    <?$times = $user->times ? explode(',', $user->times) : '';?>
                                    <?if(empty($places)):?>
                                    Zaman bilgisi için iletişime geçiniz.
                                    <?else:?>
                                    <?$education_types = education_types(2)?>
                                    <?foreach($times as $time):?>
                                    <i class="fa fa-check"></i> <?=$education_types[$time]?><br />
                                    <?endforeach;?>
                                    <?endif;?>
                                </div>
                                
                                <div class="col-md-2 text-center margin-bottom-30">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3 class="margin-bottom-10">Hizmet</h3>
                                    <?$services = $user->services ? explode(',', $user->services) : '';?>
                                    <?if(empty($places)):?>
                                    Hizmet bilgisi için iletişime geçiniz.
                                    <?else:?>
                                    <?$education_types = education_types(3)?>
                                    <?foreach($services as $service):?>
                                    <i class="fa fa-check"></i> <?=$education_types[$service]?><br />
                                    <?endforeach;?>
                                    <?endif;?>
                                </div> 
                                
                                <div class="col-md-2 text-center margin-bottom-30">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3 class="margin-bottom-10">Cinsiyet</h3>
                                    <?$genders = $user->genders ? explode(',', $user->genders) : '';?>
                                    <?if(empty($places)):?>
                                    Hizmet bilgisi için iletişime geçiniz.
                                    <?else:?>
                                    <?$education_types = education_types(4)?>
                                    <?foreach($genders as $gender):?>
                                    <i class="fa fa-check"></i> <?=$education_types[$gender]?><br />
                                    <?endforeach;?>
                                    <?endif;?>
                                </div>                                                                                                
                                
                                
                            </div>
                            
                           
							
							
														
							                                  
                        </div>
                    </article>

                    <article class="common-inner animated clearfix" id="discounts">
                        <div class="common-image">
                            <div class="image-cont"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt=""></div>
                        </div>

                        <div class="profile-cont">
                            <div class="profile-top">
                                <h2>DERS <span>İNDİRİMLERİ</span></h2>
                                <h3>Aşağıda uyguladığım ders indirimleri yer almaktadır.</h3>
                            </div>
                            
                            <div class="row profile-middle-content clearfix">
                                <div class="col-md-12">
                                    <div class="my-employment">

										<?
											$discount = get_user_discount($user);
										?>					
										<?if(!empty($discount['freefirst'])):?>
                                        <div class="employment">
                                            <h4>Ücretsiz İlk Ders</h4>
                                            <p>Öğrencilerime ilk dersi ücretsiz olarak veriyorum.</p>
                                        </div>
										<?endif;?>
										
										<?if(!empty($discount['registered'])):?>
                                        <div class="employment">
                                            <h4>%<?=$discount['registered']?> Üye Öğrenci İndirimi</h4>
                                            <p>Netders.com'a üye olarak benden ders alan öğrencilerime %<?=$discount['registered']?> indirim uyguluyorum.</p>
                                        </div>
										<?endif;?>
										
										<?if(!empty($discount['teacher'])):?>
                                        <div class="employment">
                                            <h4>%<?=$discount['teacher']?> Eğitmen Evi İndirimi</h4>
                                            <p>Kendi evimde benden özel ders alan öğrencilerime %<?=$discount['teacher']?> indirim uyguluyorum.</p>
                                        </div>
										<?endif;?>
										
										<?if(!empty($discount['group'])):?>
                                        <div class="employment">
                                            <h4>%<?=$discount['group']?> Grup İndirimi</h4>
                                            <p>Benden grup dersi almak isteyen öğrencilerime %<?=$discount['group']?> indirim uyguluyorum.</p>
                                        </div>
										<?endif;?>
										
										<?if(!empty($discount['program'])):?>
                                        <div class="employment">
                                            <h4>%<?=$discount['program']?> Paket Program İndirimi</h4>
                                            <p>Benden toplu olarak ders almayı taahhüt eden öğrencilerime %<?=$discount['program']?> indirim uyguluyorum.</p>
                                            <?if($user->discount11_text):?><p>Şartlar: <?=$user->discount11_text?></p><?endif;?>
                                        </div>
										<?endif;?>
										
										<?if(!empty($discount['disabled'])):?>
                                        <div class="employment">
                                            <h4>%<?=$discount['disabled']?> Engelli İndirimi</h4>
                                            <p>Engelli öğrencilerime %<?=$discount['program']?> indirim uyguluyorum.</p>
                                            <?if($user->discount12_text):?><p>Şartlar: <?=$user->discount12_text?></p><?endif;?>
                                        </div>
										<?endif;?>
										
										<?if(!empty($discount['review'])):?>
                                        <div class="employment">
                                            <h4>%<?=$discount['review']?> Öneri İndirimi</h4>
                                            <p>Beni başkasına önererek ders verdiğim her öğrenci için öneren öğrencime %<?=$discount['program']?> indirim uyguluyorum.</p>
                                            <?if($user->discount13_text):?><p>Şartlar: <?=$user->discount13_text?></p><?endif;?>
                                        </div>
										<?endif;?>																				
                                        
                                    </div>

                                </div>

                            </div>
                            
                        </div>
                    </article>
                    
                    <article class="common-inner animated clearfix" id="comments">
                        <div class="common-image">
                            <div class="image-cont"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt=""></div>
                        </div>

                        <div class="profile-cont">
                            <div class="profile-top">
                                <h2>ÖĞRENCİ <span>YORUMLARI</span></h2>
                                <h3>Aşağıda ders alan öğrencilerin yorumları bulunmaktadır.</h3>
                            </div>
                            
                            <div class="row profile-middle-content clearfix">
                                <div class="col-md-12">
                                    <div class="my-employment">

										<?if(empty($comments)):?>
											<p>Yorum bulunmamaktadır.</p>
										<?else:?>
											<?foreach($comments as $comment):?>
	                                        <div class="employment">
	                                            <h4><?=user_info('username', $comment->from_uid)?>, <?=date('d/m/Y', $comment->date)?> <?if(isset($comment->point)):?><?for($i=0;$i<$comment->point;$i++):?><i class="fa fa-star"></i><?endfor;?><?endif;?></h4>
	                                            <p><?=nl2br($comment->comment)?></p>
	                                        </div>
	                                        <?endforeach;?>
										<?endif;?>
                                        
                                    </div>

                                </div>
                                
                                <div class="col-md-12 contact-form">
                                    <h3 class="margin-bottom-10">Yorum Yap</h3>
                                    <p class="margin-bottom-20">Aşağıdaki formu doldurarak aldığınız ders için yorum yapabilirsiniz.</p>	
                                    <form name="comment" id="comment_form" method="post">
                                        <div id="comment-form">
                                        	<div class="row">
	                                        	<div class="col-md-12">
											  		<select name="point" id="point">
											  			<option value="">-- Verdiğiniz Puan --</option>
											  			<option value="1">1 (Berbat)</option>
											  			<option value="2">2 (Kötü)</option>
											  			<option value="3">3 (Normal)</option>
											  			<option value="4">4 (İyi)</option>
											  			<option value="5">5 (Kusursuz)</option>
											  		</select>
	                                        	</div>                                            
	                                            <div class="col-md-12">
		                                            <textarea cols="10" rows="4" name="comment" id="comment" placeholder="Yorumunuz"></textarea>
	                                            </div>
												<div class="col-md-offset-3 col-md-3">
													<input type="text" name="security_code" id="security_code2" placeholder="Güvenlik kodu">
												</div>
												<div class="col-md-3">
													<img src="<?=base_url('captcha/'.generate_captcha('ajax_comment'))?>" width="100%" height="40" />
												</div>	                                            
	                                            <div class="col-md-12">
		                                            <button type="submit" id="comment-submit" class="submit-btn">Gönder</button>
	                                            </div>
                                        	</div>
                                        </div>
                                        <div id="contact-loading">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Mesajınız gönderiliyor, lütfen bekleyiniz...
                                        </div>
                                        <div id="contact-success">
                                            Yorumunuz başarıyla kaydedilmiştir. En kısa süre içerisinde onaylanıp yayınlanacaktır.
                                        </div>
                                        <div id="contact-failed"></div>
										<input type="hidden" name="user_id" value="<?=$user->id?>" />
										<input type="hidden" name="form" value="ajax_comment" />
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />                                        
                                    </form>
                                </div>                                

                            </div>
                            
                        </div>
                    </article>                    

                    <article class="common-inner animated clearfix" id="contact">
                        <!-- Common Top Start -->
                        <div class="common-image">
                            <div class="image-cont"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt=""></div>
                        </div>

                        <div class="profile-cont">
                            <div class="profile-top">
                                <h2><span><?=txtWordUpper($user->firstname)?> <?=user_lastname(txtWordUpper($user->lastname), $user->privacy_lastname)?></span> İLETİŞİM</h2>
                                <h3><?=nl2br($user->text_title)?></h3>
                            </div>


                            <div class="row profile-col-cont">
                                <div class="col-md-offset-2 col-md-4 text-center">
                                    <span class="icons"><i class="fa fa-globe"></i></span>
                                    <h3>Bulunduğu Yer</h3>
                                    <p><?=$user->city_title?> / <?=$user->town_title?></p>
                                </div>
                                
                                <div class="col-md-4 text-center">
                                    <span class="icons"><i class="fa fa-phone"></i></span>
                                    <h3>Telefon Numarası</h3>
									<?/*görüntüleyen üye değilse*/?>
									<?if(!$this->session->userdata('user_id')):?>
										<?if(($user->privacy_phone == 1 && ($user->ugroup == 3 || $user->ugroup == 4 || $user->ugroup == 5)) || check_viewphones_ips($user->id)):?>
										<span class="ajaxmobile"><a href="#" onclick="getmobile('<?=$user->activation_code?>-<?=md5(md5(date('d.m.Y', time())))?>'); return false;"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>							
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
												<span class="ajaxmobile"><a href="#" onclick="getmobile('<?=$user->activation_code?>-<?=md5(md5(date('d.m.Y', time())))?>'); return false;"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>							
											<?/*değilse*/?>
											<?else:?>
												<span data-toggle="tooltip" data-placement="top" title="Eğitmen telefon numarasını göstermek istemiyor"><a href="#"><?=substr_replace($user->mobile, 'XX XX', -4)?> (Tıkla ve Gör)</a></span>
											<?endif;?>
										<?endif;?>
									<?endif;?>
                                </div>
                            </div>

							
							<div class="clearfix"></div>
									                            
                            <div class="row profile-middle-content">
								
								<iframe width="100%" height="470" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAT1hhOtFmEH1n0QaTvPBfI1KA8T2FKeK8&zoom=13&q=<?=$user->town_title?>+<?=$user->city_title?>" allowfullscreen></iframe>
																
								<div class="clearfix"></div>
							
                                <div class="col-md-12 contact-form">
                                    <h3 class="margin-bottom-10">Mesaj Gönder</h3>
                                    <p class="margin-bottom-20">Aşağıdaki formu kullanarak eğitmene özel mesaj gönderebilirsiniz.<?if(!$this->session->userdata('user_id')):?> Mesajınızı gönderdiğinizde eğitmen girdiğiniz cep telefonundan sizi arayacaktır. Size yeni bir cevap mesaj gönderildiğinde e-posta ile bilgilendirileceksiniz. Bu nedenle e-posta adresinizi ve cep telefonu numaranızı doğru girmeniz gerekmektedir.<?endif;?></p>	
                                    <form name="contact" id="contact_form" method="post">
                                        <div id="contact-form">
                                        	<div class="row">
	                                        	<?if(!$this->session->userdata('user_id')):?>
	                                        	<div class="col-md-3">
		                                            <input type="text" name="firstname" id="firstname" placeholder="Adınız" value="<?=$this->input->cookie('unknown_msg_firstname')?>" />
	                                        	</div>
	                                        	<div class="col-md-3">
		                                            <input type="text" name="lastname" id="lastname" placeholder="Soyadınız" value="<?=$this->input->cookie('unknown_msg_lastname')?>" />
	                                        	</div>
	                                        	<div class="col-md-3">
		                                            <input type="email" name="email" id="email" placeholder="E-posta adresiniz" value="<?=$this->input->cookie('unknown_msg_email')?>" />
	                                        	</div>
	                                        	<div class="col-md-3">
		                                            <input type="text" name="mobile" id="mobile" data-type="mobile-number" value="<?=$this->input->cookie('unknown_msg_mobile')?>" />
	                                        	</div>		                                            
	                                            <?endif;?>
	                                            <div class="col-md-12">
		                                            <textarea cols="10" rows="4" name="message" id="message" placeholder="Mesajınız"></textarea>
	                                            </div>
												<div class="col-md-offset-3 col-md-3">
													<input type="text" name="security_code" id="security_code" placeholder="Güvenlik kodu">
												</div>
												<div class="col-md-3">
													<img src="<?=base_url('captcha/'.generate_captcha('ajax_message'))?>" width="100%" height="40" />
												</div>	                                            
	                                            <div class="col-md-12">
		                                            <button type="submit" id="contact-submit" class="submit-btn">Gönder</button>
	                                            </div>
                                        	</div>
                                        </div>
                                        <div id="contact-loading">
                                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Mesajınız gönderiliyor, lütfen bekleyiniz...
                                        </div>
                                        <div id="contact-success">
                                            Mesajınız başarıyla gönderilmiştir. En kısa süre içerisinde size dönüş yapılacaktır.
                                        </div>
                                        <div id="contact-failed"></div>
										<input type="hidden" name="user_id" value="<?=$user->id?>" />
										<input type="hidden" name="form" value="ajax_message" />
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />                                        
                                    </form>
                                </div>
                              
                            </div>
                        </div>							

                    </article>                    

            	
                </div>
            </div>
        </section>
		
		<?if(!empty($comments)):?>
        <footer class="footer-area">
        
            <div class="testimonial-area">
                <div class="testimonial-solid">
                    <div class="container">
                    	<div class="testi-icon-area">
                        	<div class="quote"><i class="fa fa-microphone"></i></div>
                        </div>
                        
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        
                            <ol class="carousel-indicators">
                            	<?foreach($comments as $key => $comment):?>
                                <li data-target="#carousel-example-generic" data-slide-to="<?=$key?>"<?if($key == 0):?> class="active"<?endif;?>><a href="#"></a></li>
                                <?endforeach;?>
                            </ol>
                            <div class="carousel-inner">
                        		<?foreach($comments as $comment):?>
                                <div class="item active">
                                    <p><?=nl2br($comment->comment)?></p>
                                    <p><b>- <?=user_info('username', $comment->from_uid)?> -</b></p>
                                </div>
                                <?endforeach;?>
                            </div>
                    
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </footer>
        <?endif;?>
   
    </div>
        
    <script type="text/javascript" src="<?=base_url('public/theme1/js/jquery-1.10.2.js')?>"></script><!-- Jquery JS -->
    <script type="text/javascript" src="<?=base_url('public/theme1/js/bootstrap.js')?>"></script><!-- Bootstrap JS -->
	<script type="text/javascript" src="<?=base_url('public/vendor/inputmask/dist/jquery.inputmask.bundle.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/intl-tel-input/build/js/intlTelInput.min.js')?>"></script>    
	<script type="text/javascript" src="<?=base_url('public/vendor/jquery-mask/jquery.mask.min.js')?>"></script>	
    <script type="text/javascript" src="<?=base_url('public/theme1/js/jquery.vegas.js')?>"></script><!-- For Banner Slider -->
    <script type="text/javascript" src="<?=base_url('public/theme1/js/vegas.js')?>"></script><!-- For Banner Slider -->
    <script type="text/javascript" src="<?=base_url('public/theme1/js/jquery.easytabs.js')?>"></script><!-- Easy Tab JS -->
    <script type="text/javascript" src="<?=base_url('public/theme1/js/jquery.magnific-popup.js')?>"></script><!-- Easy Tab JS -->
    <script type="text/javascript" src="<?=base_url('public/theme1/js/system.v32332.js')?>"></script><!-- Easy Tab JS -->
    <script type="text/javascript" src="<?=base_url('public/theme1/js/forms.js')?>"></script><!-- Contact Form -->
  </body>
</html>

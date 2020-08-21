<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no"  />

    <?if(isset($seo_title) || $this->router->fetch_class() == 'home'):?>
    <title><?if(isset($seo_title)):?><?=$seo_title?><?else:?><?=$GLOBALS['settings_site']->seo_title?><?endif;?></title>
    <?endif;?>

	<?if($this->router->fetch_class() != 'users' || ($this->router->fetch_method() != 'view' && $this->router->fetch_method() != 'view_price')):?>

		<?if(isset($seo_description) || $this->router->fetch_class() == 'home'):?>
		<meta name="description" content="<?if(isset($seo_description)):?><?=$seo_description?><?else:?><?=$GLOBALS['settings_site']->seo_description?><?endif;?>" />
		<?endif;?>

		<?if(isset($seo_keyword) || $this->router->fetch_class() == 'home'):?>
		<meta name="keywords" content="<?if(isset($seo_keyword)):?><?=$seo_keyword?><?elseif($this->router->fetch_class() == 'home'):?><?=$GLOBALS['settings_site']->seo_keyword?><?endif;?>" />
		<?endif;?>

	<?endif;?>

	<meta http-equiv="Content-Language" content="TR" />
	<meta name="robots" content="noodp" />

	<?if($this->router->fetch_class() != 'users'):?>
	<link rel="amphtml" href="<?=amp_url()?>">
	<?endif;?>

	<link rel="canonical" href="<?=current_url()?>">

	<?if(($this->router->fetch_class() == 'users' && $this->router->fetch_method()== 'index' && (empty($users) || ($this->input->get() &&   (sizeof($this->input->get()) != 1 || !$this->input->get('keyword'))      ) )) || isset($header_status) || $this->input->get('PageSpeed') || (!empty($user) && $user->virtual == 'Y') || $this->router->fetch_class() == 'quickpay'):?>
	<meta name="robots" content="noindex, nofollow" />
	<?endif;?>

	<meta property="og:url"           content="<?=current_url()?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="<?if(isset($seo_title)):?><?=$seo_title?><?else:?><?=$GLOBALS['settings_site']->seo_title?><?endif;?>" />
	<meta property="og:description"   content="<?if(isset($seo_description)):?><?=$seo_description?><?else:?><?=$GLOBALS['settings_site']->seo_description?><?endif;?>" />
	<meta property="og:image"         content="<?=base_url('uploads/logo_tr.png')?>" />

    <?if($this->router->fetch_class()== 'messages'):?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <?endif;?>

    <link href="<?=base_url('public/vendor/bootstrap-3.3.6/css/bootstrap.min.css')?>" rel="stylesheet" />
    <link href="<?=base_url('public/vendor/font-awesome-4.6.3/css/font-awesome.min.css')?>" rel="stylesheet" />
    <link href="<?=base_url('public/vendor/jgrowl/jquery.jgrowl.min.css')?>" rel="stylesheet" />
    <link href="<?=base_url('public/vendor/intl-tel-input/build/css/intlTelInput.css')?>" rel="stylesheet" />
    <link href="<?=base_url('public/vendor/jquery-date-range-picker/dist/daterangepicker.min.css')?>" rel="stylesheet" />
    <link href="<?=base_url('public/css/hamburgers.css')?>" rel="stylesheet" />
	<link href="<?=base_url('public/vendor/owl-carousel/owl.carousel.css')?>" rel="stylesheet" />
	<link href="<?=base_url('public/vendor/owl-carousel/owl.theme.css')?>" />
	<link href="<?=base_url('public/vendor/jquery-mmenu/dist/css/jquery.mmenu.all.css')?>" rel="stylesheet" />
	<link href="<?=base_url('public/vendor/chosen/chosen.min.css')?>" rel="stylesheet" />
	<link href="<?=base_url('public/css/style.css')?>" rel="stylesheet" />
    <link href="<?=base_url('public/css/responsive.css')?>" rel="stylesheet" />



   <script type="text/javascript">
	    var base_url 					= '<?=base_url()?>';

	    <?if($this->router->fetch_class()== 'users' && $this->router->fetch_method()== 'index'):?>
	    var	city						= <?if($this->session->userdata('site_city')):?><?=$this->session->userdata('site_city')?><?else:?>34<?endif;?>;
	    var	town						= <?if($this->session->userdata('site_town')):?><?=$this->session->userdata('site_town')?><?else:?>null<?endif;?>;
	    <?else:?>
	    var	city						= <?if($this->input->get_post('city')):?><?=$this->input->get_post('city')?><?else:?><?if($this->session->userdata('user_city')):?><?=$this->session->userdata('user_city')?><?else:?>null<?endif;?><?endif;?>;
	    var	town						= <?if($this->input->get_post('town')):?><?if(sizeof($this->input->get_post('town') > 1)):?><?=json_encode($this->input->get('town'))?><?else:?><?=$this->input->post('town')?><?endif;?><?else:?><?if($this->session->userdata('user_town') && $this->router->fetch_method() != 'index'):?><?=$this->session->userdata('user_town')?><?else:?>null<?endif;?><?endif;?>;
		<?endif;?>
	    var	subject						= <?if($this->session->userdata('site_subject')):?><?=$this->session->userdata('site_subject')?><?else:?>null<?endif;?>;
	    var	level						= <?if($this->session->userdata('site_level')):?><?=$this->session->userdata('site_level')?><?else:?>null<?endif;?>;
  	    var csrf 						= {"<?php echo $this->security->get_csrf_token_name(); ?>": "<?php echo $this->security->get_csrf_hash(); ?>"};
    </script>

	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/bootstrap-3.3.6/js/bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/js/jquery.ocupload-min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/moment/moment.min.js')?>"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

	<script type="text/javascript" src="https://cdn.socket.io/socket.io-1.4.5.js"></script>

	<script type="text/javascript" src="<?=base_url('public/vendor/jgrowl/jquery.jgrowl.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/inputmask/dist/jquery.inputmask.bundle.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/bootstrap-filestyle-1.2.1/src/bootstrap-filestyle.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/intl-tel-input/build/js/intlTelInput.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/chained/chained.remote.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/jquery-tmpl/jquery.tmpl.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/form/jquery.form.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/jquery-date-range-picker/dist/jquery.daterangepicker.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/owl-carousel/owl.carousel.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/jquery-mmenu/dist/js/jquery.mmenu.all.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/jquery-mask/jquery.mask.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/masonry/masonry.pkgd.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/jquery-scrollto/jquery.scrollto.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/vendor/chosen/chosen.jquery.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('public/js/functions.js')?>"></script>

	<!--
    <script src="http://136.243.73.203:1443/socket.io/socket.io.js"></script>
    <script>
        var socket = io.connect('http://136.243.73.203:1443');
    </script>
    -->

	<?if($this->router->fetch_class()== 'users' && $this->router->fetch_method() == 'prices'):?>
	<script>get_prices();</script>
	<?endif;?>

	<?if($this->router->fetch_class()== 'users' && $this->router->fetch_method() == 'locations'):?>
	<script>get_locations();</script>
	<?endif;?>

	<!--[if lt IE 9]>
    <script src="<?=base_url('public/vendor/html5shiv/html5shiv.min.js')?>"></script>
    <script src="<?=base_url('public/vendor/respond/respond.min.js')?>"></script>
  <![endif]-->

	<!-- Yeniden Pazarlama Etiketi için Google Kodu -->
	<!--------------------------------------------------
	Yeniden pazarlama etiketleri, kimlik bilgileriyle ilişkilendirilemez veya hassas kategorilerle ilgili sayfalara yerleştirilemez. Daha fazla bilgi edinmek ve etiketin nasıl ayarlanacağıyla ilgili talimatlar için şu adresi ziyaret edin: http://google.com/ads/remarketingsetup
	--------------------------------------------------->
	<script type="text/javascript">
	var google_tag_params = {
	edu_pid: 'REPLACE_WITH_VALUE',
	edu_plocid: 'REPLACE_WITH_VALUE',
	edu_pagetype: 'REPLACE_WITH_VALUE',
	edu_totalvalue: 'REPLACE_WITH_VALUE',
	};
	</script>
	<script type="text/javascript">
	/* <![CDATA[ */
	var google_conversion_id = 872564745;
	var google_custom_params = window.google_tag_params;
	var google_remarketing_only = true;
	/* ]]> */
	</script>
	<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
	</script>
	<noscript>
	<div style="display:inline;">
	<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/872564745/?value=0&amp;guid=ON&amp;script=0"/>
	</div>
	</noscript>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-84598680-1', 'auto');
	  ga('send', 'pageview');

	</script>
<script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.3.4/lib/darkmode-js.min.js"></script>
<script>
  new Darkmode().showWidget();
</script>
  </head>
  <body>
  	<div class="wrapper">
    <section>

		<nav class="navbar navbar-default">
			<div class="container container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">

				<button id="navbar-icon" class="pull-right hamburger hamburger--vortex visible-xs visible-sm hidden-md hidden-lg" type="button">
				   <span class="hamburger-box">
				      <span class="hamburger-inner"></span>
				   </span>
				</button>

					<a class="navbar-brand" href="<?=site_url()?>"><img src="<?=base_url($GLOBALS['settings_site']->logo)?>" width="185" height="50" /></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right hidden-sm">
						<!--<li class="hidden-sm"><a href="<?=_make_link('contents', 2)?>"><i class="fa fa-heart yellow-text"></i> Para kazanın</a></li>-->
						<li class="hidden-sm"><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>"><i class="fa fa-search yellow-text"></i> Eğitmen arayın</a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-info-circle yellow-text"></i> Bizi tanıyın <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=_make_link('contents', 1)?>"><i class="fa fa-question-circle yellow-text"></i> Biz Kimiz?</a></li>
								<li><a href="<?=_make_link('contents_categories', 570)?>"><i class="fa fa-newspaper-o yellow-text"></i> Haberler</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?=_make_link('contents', 14)?>"><i class="fa fa-file-text-o yellow-text"></i> Kullanım Koşullarımız</a></li>
								<li><a href="<?=_make_link('contents', 38)?>"><i class="fa fa-user-secret yellow-text"></i> Gizlilik İlkelerimiz</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-life-ring yellow-text"></i> Yardım alın <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=_make_link('contents_categories', 2)?>"><i class="fa fa-life-ring yellow-text"></i> Destek Merkezi</a></li>
								<li><a href="<?=_make_link('contents', 37)?>"><i class="fa fa-envelope-o yellow-text"></i> İletişim</a></li>
							</ul>
						</li>
						<?if($this->session->userdata('user_id')):?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-unlock yellow-text"></i> <?=$this->session->userdata('user_firstname')?> <?=$this->session->userdata('user_lastname')?> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?=site_url('users/my')?>"><i class="fa fa-user yellow-text"></i> Kontrol Panel</a></li>
								<?if($this->session->userdata('user_status') == 'A'):?>
								<li><a href="<?=site_url('messages')?>"><i class="fa fa-comments yellow-text"></i> Mesajlar</a></li>
								<?endif;?>
								<li><a href="<?=site_url('users/logout')?>"><i class="fa fa-lock yellow-text"></i> Güvenli Çıkış</a></li>
							</ul>
						</li>
						<?$check_cart = check_cart();?>
						<li id="shopping_cart"<?if(empty($check_cart)):?> class="hide"<?endif;?>><a href="<?=site_url('services/cart')?>"><i class="fa fa-shopping-cart yellow-text"></i> Alışveriş Sepeti <span class="badge"><?=$check_cart?></span></a></li>
						<?else:?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-lock yellow-text"></i> Giriş yapın <span class="caret"></span></a>
							<div class="dropdown-menu">
								<form  action="<?=site_url('giris')?>" method="post" class="ajax-form padding-10">
									<div class="row">
										<div class="form-group col-md-12 text-center">
											<a href="<?=site_url('fb')?>" class="btn btn-primary btn-block white-text" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden hesabınıza giriş yapın"><i class="fa fa-facebook"></i> Facebook ile bağlan</a><span class="block margin-top-10">veya</span>
										</div>
										<div class="form-group col-md-12">
											<input type="text" name="login" class="form-control" placeholder="Kullanıcı adı veya e-posta">
										</div>
										<div class="form-group col-md-12">
											<input type="password" name="password" class="form-control" placeholder="Şifre">
										</div>
										<div class="form-group col-md-12" data-name="security-code">
											<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
										</div>
										<div class="form-group col-md-12">
											<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary js-submit-btn">Giriş yap</button>
											<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
										</div>
									</div>
									<input type="hidden" name="form" value="ajax_login" />
									<input type="hidden" name="redir" value="<?=base_url('users/my')?>" />
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

									<a href="<?=site_url('sifremi-unuttum')?>" class="font-size-12 margin-top-10 block"><i class="fa fa-link"></i> Şifremi unuttum</a>
									<a href="<?=site_url('aktivasyon')?>" class="font-size-12 margin-top-5 block"><i class="fa fa-link"></i> Hesap aktivasyonu</a>

								</form>
							</div>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus-circle yellow-text"></i> Ücretsiz üye olun <span class="caret"></span></a>
							<div class="dropdown-menu">
								<form action="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" method="post" class="ajax-form padding-10">
									<div class="row">
										<div class="form-group col-md-12 text-center">
											<a href="<?=site_url('fb')?>" class="btn btn-primary btn-block white-text" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden ücretsiz üye olun"><i class="fa fa-facebook"></i> Facebook ile bağlan</a><span class="block margin-top-10">veya</span>
										</div>
										<div class="form-group col-md-12">
											<input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız">
										</div>
										<div class="form-group col-md-12">
											<input type="text" name="lastname" class="form-control tofirstupper" placeholder="Soyadınız">
										</div>
										<div class="form-group col-md-12">
											<input type="email" name="email" class="form-control" placeholder="E-posta adresiniz">
										</div>
										<div class="form-group col-md-12">
											<input type="password" name="password" class="form-control" placeholder="Şifreniz">
										</div>
										<div class="form-group col-md-12">
											<input type="radio" name="member_type" value="1" id="mt1" /> <label for="mt1"><small>Öğrenciyim, özel ders alacağım</small></label><br />
											<input type="radio" name="member_type" value="2" id="mt2" /> <label for="mt2"><small>Eğitmenim, özel ders vereceğim</small></label><br />
										</div>
										<div class="form-group col-md-12" data-name="security-code">
											<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
										</div>
										<div class="form-group col-md-12">
											<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
										</div>
										<div class="col-md-12">
											<button type="submit" class="btn btn-primary js-submit-btn">Ücretsiz üye ol</button>
											<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>
										</div>
									</div>
									<input type="hidden" name="form" value="ajax_register" />
									<input type="hidden" name="redir" value="<?=base_url('users/my')?>" />
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />

									<a href="<?=site_url('aktivasyon')?>" class="font-size-12 margin-top-10 block"><i class="fa fa-link"></i> E-posta aktivasyonu</a>
								</form>
							</div>
						</li>
						<?endif;?>
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
    </section><!-- /section -->

	<?if($this->session->flashdata('message')):?>
		<?foreach($this->session->flashdata('message') as $item):?>
			<script type="text/javascript">jgrowl("<?=$item?>", "<?if($this->session->flashdata('error') == 1):?>red<?endif;?>");</script>
		<?endforeach;?>
	<?endif;?>

	<?if(!empty($errors) || !empty($messages)):?>
		<?$items = $errors ? $errors : $messages?>
		<?foreach($items as $item):?>
			<script type="text/javascript">jgrowl("<?=$item?>"<?if(!empty($errors)):?>, "red"<?endif;?>);</script>
		<?endforeach;?>
	<?endif;?>

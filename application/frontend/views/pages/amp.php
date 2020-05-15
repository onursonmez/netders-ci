<!doctype html>
<html amp lang="en">
  <head>
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <script async src="https://cdn.ampproject.org/v0.js"></script>
	<script async custom-element="amp-access" src="https://cdn.ampproject.org/v0/amp-access-0.1.js"></script>    
	<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
	<script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
	<script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <link rel="canonical" href="<?=non_amp_url()?>" />
	<style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
	<style amp-custom><?php include(ROOTPATH . '/public/css/amp.css'); ?></style>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
	<script id="amp-access" type="application/json">
	  {
	    "authorization": "<?=site_url('ajax/amp_authorization')?>?rid=READER_ID&url=CANONICAL_URL&ref=DOCUMENT_REFERRER&_=RANDOM",
	    "noPingback": "true",
	    "login": {
	      "sign-in": "<?=site_url('giris')?>?rid=READER_ID&url=CANONICAL_URL",
	      "sign-out": "<?=site_url('cikis')?>"
	    },
	    "authorizationFallbackResponse": {
	      "error": true,
	      "loggedIn": false
	    }
	  }
	</script>     
  </head>
  <body>
	<amp-sidebar id="sidebar" layout="nodisplay" side="right">
		<button class="sidebar-close" on="tap:sidebar.close"><i class="fa fa-close yellow-text"></i> Kapat</button>
		<ul>
			<li><i class="fa fa-home yellow-text"></i> <a href="<?=amp_url(site_url())?>">Ana Sayfa</a></li>
				<li><i class="fa fa-search yellow-text"></i> <a href="<?=amp_url(_make_link('search', $this->session->userdata('site_city')))?>">Eğitmen Arayın</a></li>
				<li><i class="fa fa-info-circle yellow-text"></i> <a href="<?=amp_url(_make_link('contents', 1))?>">Biz Kimiz?</a></li>
				<span amp-access="NOT loggedIn" role="button" tabindex="0" amp-access-hide>
				<li><i class="fa fa-lock yellow-text"></i> <a href="#" on="tap:amp-access.login-sign-in">Giriş Yapın</a></li>
				<li><i class="fa fa-plus-circle yellow-text"></i> <a href="<?=amp_url(site_url('kayit'))?>">Ücretsiz Üye Olun</a></li>					
				</span>
				<span amp-access="loggedIn" role="button" tabindex="0" amp-access-hide>
				<li><i class="fa fa-user yellow-text"></i> <a href="<?=site_url('users/my')?>">Kontrol Panel</a></li>
				<?if($this->session->userdata('user_status') == 'A'):?>
				<li><i class="fa fa-comments yellow-text"></i> <a href="<?=site_url('messages')?>">Mesajlar</a></li>
				<?endif;?>
				<li><i class="fa fa-lock yellow-text"></i> <a href="#" on="tap:amp-access.login-sign-out">Güvenli Çıkış</a></li>
				</span>
		</ul>
	</amp-sidebar>
  	<div class="header">
  		<div class="logo">
	  		<a href="<?=site_url()?>"><amp-img src="<?=base_url($GLOBALS['settings_site']->logo)?>" width="185" height="50"></amp-img></a>
  		</div>
  		<div class="sidebar">
	  		<button class="sidebar-toggle" on="tap:sidebar.toggle"><i class="fa fa-bars yellow-text"></i></button>

  		
  		</div>
  	</div>
  	
  	<div class="content">
  		<?=$viewPage?>
  	</div>  	
  	
  	<div class="bottom">
		<p>Netders.com internet üzerinden eğitmenler ile öğrencileri buluşturarak online eğitim imkanı sunan bir internet sitesidir. Herhangi bir kurum ile bağı yoktur.</p>
		<p>Netders.com'a üye olarak <a href="<?=amp_url(_make_link('contents', 14))?>">Kullanım sözleşmesi</a>'ni kabul etmiş sayılırsınız.</p>
		<p class="font-size-14">© 2013 - <?=date('Y', time())?> Netders.com | Tüm hakları saklıdır. | {elapsed_time}</p>
		<p>Netders.com Saati: <?=strftime("%d %B %Y %H:%M", time())?></p>
		<p><amp-img src="<?=base_url('public/img/visa-master.png')?>" width="100" height="30"></amp-img></p>  	
		<p><a href="<?=non_amp_url(current_url(true))?>">Normal görünüme dön</a></p>  	
  	</div>  	  
  </body>
</html>


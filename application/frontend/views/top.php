<!doctype html>
<html lang="tr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  <?if(($this->router->fetch_class() == 'users' && $this->router->fetch_method()== 'index' && (empty($users) || ($this->input->get() &&   (sizeof($this->input->get()) != 1 || !$this->input->get('keyword'))      ) )) || isset($header_status) || $this->input->get('PageSpeed') || (!empty($user) && $user->virtual == 'Y') || $this->router->fetch_class() == 'quickpay'):?>
    <meta name="robots" content="noindex, nofollow" />
  <?endif;?>
  <meta property="og:url"           content="<?=current_url()?>" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="<?if(isset($seo_title)):?><?=$seo_title?><?else:?><?=$GLOBALS['settings_site']->seo_title?><?endif;?>" />
  <meta property="og:description"   content="<?if(isset($seo_description)):?><?=$seo_description?><?else:?><?=$GLOBALS['settings_site']->seo_description?><?endif;?>" />
  <meta property="og:image"         content="<?=base_url('uploads/logo_tr.png')?>" />

  <link rel="canonical" href="<?=current_url()?>">

  <link href="<?=base_url('public/css/bootstrap.min.css')?>" rel="stylesheet">
  <link href="<?=base_url('public/css/mmenu.css')?>" rel="stylesheet">
  <link href="<?=base_url('public/vendor/jgrowl/jquery.jgrowl.min.css')?>" rel="stylesheet" />
  <link href="<?=base_url('public/css/custom.css')?>" rel="stylesheet">
  <?if($this->router->fetch_class() == 'home' || ($this->router->fetch_class() == 'users' && $this->router->fetch_method() == 'register')):?>
  <link rel="stylesheet" href="<?=base_url('public/css/owl.carousel.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('public/css/owl.theme.default.min.css')?>">
  <?endif;?>
  <?if($this->router->fetch_class() == 'users' && $this->router->fetch_method() == 'index'):?>
  <link rel="stylesheet" href="<?=base_url('public/css/sidebar.css')?>">
  <link rel="stylesheet" href="<?=base_url('public/vendor/select2/dist/css/select2.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('public/vendor/select2/dist/css/select2-bootstrap4.min.css')?>">
  <?endif;?>
  <?if(($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'personal' || $this->router->fetch_method() == 'view') || $this->router->fetch_class() == 'contents')):?>
  <link rel="stylesheet" href="<?=base_url('public/vendor/intl-tel-input/build/css/intlTelInput.css')?>">
  <?endif;?>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
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

  <!--[if lt IE 9]>
    <script src="<?=base_url('public/vendor/html5shiv/html5shiv.min.js')?>"></script>
    <script src="<?=base_url('public/vendor/respond/respond.min.js')?>"></script>
  <![endif]-->
</head>

  <body class="bg-1 bg-medium">

    <?if($this->router->fetch_class() == 'users' && $this->router->fetch_method() == 'index'):?>
    <div class="overlay"></div>
    <?endif;?>

    <div class="container">
      <nav class="navbar navbar-dark navbar-expand-lg p-0 pt-4 pb-4">
          <a class="navbar-brand" href="<?=site_url()?>"><img src="<?=base_url('public/img/netders-logo-white.svg')?>" width="200" /></a>
          <a href="#main-mmenu" class="navbar-toggler">
            <span class="navbar-toggler-icon"></span>
          </a>
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="<?=_make_link('search', $this->session->userdata('site_city'))?>"><img class="align-middle mb-1" src="<?=base_url('public/img/form-search-white.svg')?>" width="13" height="13" /> Eğitmen arayın</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=_make_link('contents', 112)?>"><img class="align-middle mb-1" src="<?=base_url('public/img/messaging-question-white.svg')?>" width="13" height="13" /> Nasıl çalışır?</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=_make_link('contents_categories', 2)?>"><img class="align-middle mb-1" src="<?=base_url('public/img/damage-necessities-white.svg')?>" width="13" height="13" /> Yardım alın</a>
              </li>
              <?if($this->session->userdata('user_id')):?>
              <li class="nav-item">
                <a class="nav-link" href="<?=site_url('users/my')?>"><img class="align-middle mb-1" src="<?=base_url('public/img/profile-icon-white.svg')?>" width="13" height="13" /> Hesabım</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=site_url('cikis')?>"><img class="align-middle mb-1" src="<?=base_url('public/img/navigation-logout-white.svg')?>" width="13" height="13" /> Çıkış yapın</a>
              </li>
              <?else:?>
              <li class="nav-item">
                <a class="nav-link" href="<?=site_url('giris')?>"><img class="align-middle mb-1" src="<?=base_url('public/img/navigation-login-white.svg')?>" width="13" height="13" /> Giriş yapın</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?=site_url('kayit')?>"><img class="align-middle mb-1" src="<?=base_url('public/img/action-add-white.svg')?>" width="13" height="13" /> Ücretsiz üye olun</a>
              </li>
              <?endif;?>
            </ul>
          </div>
        </nav>
    </div>

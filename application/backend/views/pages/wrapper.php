<!DOCTYPE html>
<html lang="en" class="app">
<head>  
  <meta charset="utf-8" />
  <title><?=$GLOBALS['settings_global']->site_name?> - <?=lang('ADMIN_PANEL')?></title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="<?=base_url('public/backend/css/bootstrap.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/animate.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/font-awesome.min.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/icon.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/font.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/app.css')?>" type="text/css" />  
  <link rel="stylesheet" href="<?=base_url('public/backend/js/calendar/bootstrap_calendar.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/js/chosen/chosen.min.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/lib/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/jquery.tagsmanager.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/js/datepicker/datepicker.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/bootstrap-timepicker.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/js/superfish/dist/css/superfish.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/js/jquery-mmenu/dist/css/jquery.mmenu.all.css')?>" type="text/css" />
  <link href="<?=base_url('public/vendor/intl-tel-input/build/css/intlTelInput.css')?>" rel="stylesheet" />  
  <!--[if lt IE 9]>
    <script src="<?=base_url('public/backend/js/ie/html5shiv.js')?>"></script>
    <script src="<?=base_url('public/backend/js/ie/respond.min.js')?>"></script>
    <script src="<?=base_url('public/backend/js/ie/excanvas.js')?>"></script>
  <![endif]-->
  
  <script src="<?=base_url('public/backend/js/jquery.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/jquery-ui.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/bootstrap.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/moment.min.js')?>"></script>

  <!-- App -->
  <script src="<?=base_url('public/backend/js/app.js')?>"></script>  
  <script src="<?=base_url('public/backend/js/jquery.slimscroll.min.js')?>"></script>
  
  <script src="<?=base_url('public/backend/js/chosen/chosen.jquery.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/app.plugin.js')?>"></script>

  <!-- datetimepicker -->
  <script src="<?=base_url('public/backend/lib/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')?>"></script>  
  
  <!-- jGrowl -->
  <script src="<?=base_url('public/backend/js/bootstrap-growl.js')?>"></script>
  
  <!-- Tags -->
  <script src="<?=base_url('public/backend/js/jquery.tagsmanager.js')?>"></script>

  <script src="<?=base_url('public/backend/js/jquery.typehead.js')?>"></script>
  
  <script src="<?=base_url('public/backend/js/jquery.cookie.js')?>"></script>  
  
  <script src="<?=base_url('public/backend/js/file-input/bootstrap-filestyle.min.js')?>"></script>
  
  <script src="<?=base_url('public/backend/js/jquery.selectchained.js')?>"></script>  
    
  <script src="<?=base_url('public/backend/js/datepicker/bootstrap-datepicker.js')?>"></script>
  
  <script src="<?=base_url('public/backend/js/bootstrap-timepicker.js')?>"></script>

  <script src="<?=base_url('public/backend/js/superfish/dist/js/hoverIntent.js')?>"></script>
  <script src="<?=base_url('public/backend/js/superfish/dist/js/superfish.js')?>"></script>
  <script src="<?=base_url('public/backend/js/superfish/dist/js/supersubs.js')?>"></script>

  <script src="<?=base_url('public/backend/js/jquery-mmenu/dist/js/jquery.mmenu.all.min.js')?>" type="text/javascript"></script>	
  
  <script type="text/javascript" src="<?=base_url('public/vendor/intl-tel-input/build/js/intlTelInput.min.js')?>"></script>
  <script type="text/javascript" src="<?=base_url('public/vendor/jquery-mask/jquery.mask.min.js')?>"></script>	
	
  <script>
  	var base_url = '<?=base_url()?>';
  </script>
</head>
<body class="">

  <section class="vbox">
	    <header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
      <div class="navbar-header aside-md dk">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav" id="navbar-icon">
          <i class="fa fa-bars"></i>
        </a>
        <a href="<?=base_url('backend')?>" class="navbar-brand">
          <span class="hidden-nav-xs"><?=lang('ADMIN_PANEL')?></span>
        </a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
          <i class="fa fa-cog"></i>
        </a>
      </div>

      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">

<?
	$approval_comments = approval_comments();
	$approval_photos = approval_photos();
	$approval_profiles = approval_profiles();
	$approval_badges = approval_badges();
	$approval_prices_text = approval_prices_text();
	
	if($approval_comments || $approval_photos || $approval_profiles || $approval_badges || $approval_prices_text)
	$total = $approval_comments + $approval_photos + $approval_profiles + $approval_badges + $approval_prices_text;
?>

<?if($total > 0):?>
<li class="hidden-xs">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <i class="i i-chat3"></i>
    <span class="badge badge-sm up bg-danger count"><?=$total?></span>
  </a>
  <section class="dropdown-menu aside-xl animated flipInY">
    <section class="panel bg-white">
      <div class="panel-heading b-light bg-light">
        <strong><span class="count"><?=$total?></span> bildiriminiz var</strong>
      </div>
      
      <div class="list-group list-group-alt">
        
        <?if($approval_comments):?>
        <a href="<?=base_url('backend/users/comments')?>" class="media list-group-item">
          <span class="pull-left thumb-sm">
            <i class="i i-bubble icon" style="font-size:38px"></i>
          </span>
          <span class="media-body block m-b-none">
            Kullanıcıya yorum yapıldı<br>
            <small class="text-muted"><?=$approval_comments?> kullanıcı yorumu onay bekliyor</small>
          </span>
        </a>
        <?endif;?>
        
        <?if($approval_photos):?>
		<a href="<?=base_url('backend/users/pendingphotos')?>" class="media list-group-item">
          <span class="pull-left thumb-sm">
            <i class="i i-camera icon" style="font-size:38px"></i>
          </span>
          <span class="media-body block m-b-none">
            Kullanıcı fotoğrafını değiştirdi<br>
            <small class="text-muted"><?=$approval_photos?> kullanıcı fotoğraf onayı bekliyor</small>
          </span>
        </a>
        <?endif;?>
        
        <?if($approval_profiles):?>
		<a href="<?=base_url('backend/users?status=S')?>" class="media list-group-item">
          <span class="pull-left thumb-sm">
            <i class="i i-search2 icon" style="font-size:38px"></i>
          </span>
          <span class="media-body block m-b-none">
            Kullanıcı değerlendirme talep etti<br>
            <small class="text-muted"><?=$approval_profiles?> kullanıcı değerlendirme bekliyor</small>
          </span>
        </a>
        <?endif;?>
        
        <?if($approval_badges):?>
		<a href="<?=base_url('backend/users?service_badge=W')?>" class="media list-group-item">
          <span class="pull-left thumb-sm">
            <i class="i i-star2 icon" style="font-size:38px"></i>
          </span>
          <span class="media-body block m-b-none">
            Kullanıcı rozet satın aldı<br>
            <small class="text-muted"><?=$approval_badges?> kullanıcı rozet aktivasyonu bekliyor</small>
          </span>
        </a>
        <?endif;?> 
        
        <?if($approval_prices_text):?>
		<a href="<?=base_url('backend/users/prices_text?status=W')?>" class="media list-group-item">
          <span class="pull-left thumb-sm">
            <i class="i i-star2 icon" style="font-size:38px"></i>
          </span>
          <span class="media-body block m-b-none">
            Kullanıcı ders tanıtım yazısı yazdı<br>
            <small class="text-muted"><?=$approval_prices_text?> kullanıcı ders tanıtım yazısı onayı bekliyor</small>
          </span>
        </a>
        <?endif;?>                        
        
      </div>
      <div class="panel-footer text-sm">
        <a href="<?=base_url('backend/settings')?>" class="pull-right"><i class="fa fa-cog"></i></a>
        <a href="<?=base_url('backend/settings')?>">Bildirim ayarlarını güncelle</a>
      </div>
    </section>
  </section>
</li>
<?endif;?>
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="thumb-sm avatar pull-left">
              <img src="<?=base_url('public/backend/images/a0.png')?>" alt="...">
            </span>
            <?=$this->session->userdata('user_firstname')?> <?=$this->session->userdata('user_lastname')?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">            
            <? if(check_perm('users_edit', TRUE) == TRUE): ?>
            <li><span class="arrow top hidden-nav-xs"></span><a href="<?=base_url('backend/users/edit/'.$this->session->userdata('user_id'))?>"><?=lang('EDIT_PROFILE')?></a></li>
            <?endif;?>
			<? if(check_perm('settings_overview', TRUE) == TRUE): ?>
            <li><a href="<?=base_url('backend/settings')?>"><?=lang('SETTINGS')?></a></li>
			<?endif;?>
			<li class="divider"></li>
      		<li><a href="<?=base_url('backend/users/logout')?>"><?=lang('SECURE_LOGOUT')?></a></li>
          </ul>
        </li>
        
        <?
	        $admin_sl = admin_sl();
	        $descr_sl = descr_sl();
        ?>
        <?if($admin_sl || $descr_sl):?>
        <li class="hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-lg fa-globe"></i>
          </a>
          <section class="dropdown-menu aside-xl animated flipInY">
            <section class="panel bg-white">
              <div class="panel-heading b-light bg-light">
                <strong><?=lang('SELECT_LANGUAGE')?></strong>
              </div>
              <div class="list-group list-group-alt">
                <span class="media list-group-item">
                  <span class="media-body block m-b-none">
                    <b><?=lang('ADMIN_PANEL')?></b><br>
					<?=$admin_sl?>
                  </span>
                </span>
                <span class="media list-group-item">
                  <span class="media-body block m-b-none">
                    <b><?=lang('CONTENTS')?></b><br>
                    <?=$descr_sl?>
                  </span>
                </span>
              </div>
            </section>
          </section>
        </li>
        <?endif;?>
                
      </ul> 
    </header>
    <section>

		<section class="vbox vertical-nav hidden-xs">    
		<ul class="sf-menu">
			<?=get_menu()?>
		</ul>
		</section>    
    
      <section class="hbox stretch">
        <section id="content">
	        <section class="vbox">
	        	<?if(isset($breadcrumb)):?>
				<header class="header bg-white b-b b-light">
					<p><?=$breadcrumb?></p>
				</header>
				<?endif;?>
				<section class="scrollable padder">	  
					<section class="scrollable wrapper">
					  <div class="row">				

						<?if(isset($errors)):?>
						<?foreach($errors as $item):?>
						<div class="alert alert-danger">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<i class="fa fa-ban-circle"></i><strong>Hata!</strong> <?=$item?>
						</div>
						<?endforeach;?>
						<?endif;?>

						<?if($this->session->flashdata('message')):?>
						<?foreach($this->session->flashdata('message') as $item):?>
							<div class="alert alert-<?if($this->session->flashdata('error') == 1):?>danger<?else:?>success<?endif;?>">
								<button data-dismiss="alert" class="close" type="button">×</button>
								<i class="fa fa-ban-circle"></i><strong><?if($this->session->flashdata('error') == 1):?>Hata<?else:?>Başarılı<?endif;?>!</strong> <?=$item?>
							</div>
						<?endforeach;?>
						<?endif;?>
						
						<?if(isset($success) && $success == true):?>
						<div class="alert alert-success">
							<button data-dismiss="alert" class="close" type="button">×</button>
							<i class="fa fa-ban-circle"></i><strong>Başarılı!</strong> <?=lang('SUCCESS')?>
						</div>
						<?endif;?>
	
						<?=$viewPage?>
						
						<div class="modal" id="modal-confirmation-id">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Modal title</h4>
									</div>
									<div class="modal-body">...</div>
									<div class="modal-footer">
										<a href="#" class="btn btn-default" data-dismiss="modal">İptal</a>									
										<a href="#" class="btn btn-primary modal-url">Tamam</a>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					  </div>
					</section>
				</section><!-- scrollable padder-->
            
	        </section>
        </section>
      </section>
    </section>
  </section>
  <nav id="mobile-menu"><ul><?=get_menu('mobile-menu')?></ul></nav>  
</body>
</html>
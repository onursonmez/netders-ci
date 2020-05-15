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
  <link rel="stylesheet" href="<?=base_url('public/backend/js/chosen/chosen.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/bootstrap-datetimepicker.min.css')?>" type="text/css" />
  <link rel="stylesheet" href="<?=base_url('public/backend/css/jquery.tagsmanager.css')?>" type="text/css" />
  
  <!--[if lt IE 9]>
    <script src="<?=base_url('public/backend/js/ie/html5shiv.js')?>"></script>
    <script src="<?=base_url('public/backend/js/ie/respond.min.js')?>"></script>
    <script src="<?=base_url('public/backend/js/ie/excanvas.js')?>"></script>
  <![endif]-->

  <script src="<?=base_url('public/backend/js/jquery.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/jquery-ui.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/bootstrap.min.js')?>"></script>

  <!-- App -->
  <script src="<?=base_url('public/backend/js/app.js')?>"></script>  
  <script src="<?=base_url('public/backend/js/jquery.slimscroll.min.js')?>"></script>
  
  <script src="<?=base_url('public/backend/js/chosen/jquery.chosen.min.js')?>"></script>
  <script src="<?=base_url('public/backend/js/app.plugin.js')?>"></script>

  <!-- datetimepicker -->
  <script src="<?=base_url('public/backend/js/bootstrap-datetimepicker.min.js')?>"></script>  
  <script src="<?=base_url('public/backend/js/bootstrap-datetimepicker.tr.js')?>"></script>
  
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
    
  <script>var base_url = '<?=base_url()?>';</script>
</head>
<body>


	<?=$viewPage?>		
  <!-- footer 
	  
  -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>&copy; 2013 - 2015 Netders.com</small>
      </p>
    </div>
  </footer>

</body>
</html>
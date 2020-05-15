<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
<div class="container aside-xl">
  <a class="navbar-brand block" href="<?=current_url()?>"><?=$GLOBALS['settings_global']->site_name?></a>
  <section class="m-b-lg">
    <header class="wrapper text-center">
      <strong>Hesabınıza giriş yapın</strong>
    </header>
	<?if(isset($errors)):?>
	<?foreach($errors as $item):?>
	<div class="alert alert-danger">
		<button data-dismiss="alert" class="close" type="button">×</button>
		<?=$item?>
	</div>
	<?endforeach;?>
	<?endif;?>
	
	<?if($this->session->flashdata('message')):?>
	<?foreach($this->session->flashdata('message') as $item):?>
		<div class="alert alert-<?if($this->session->flashdata('error') == 1):?>danger<?else:?>success<?endif;?>">
			<button data-dismiss="alert" class="close" type="button">×</button>
			<?=$item?>
		</div>
	<?endforeach;?>
	<?endif;?>
	
	<?if(isset($success) && $success == true):?>
	<div class="alert alert-success">
		<button data-dismiss="alert" class="close" type="button">×</button>
		<?=lang('SUCCESS')?>
	</div>
	<?endif;?>
	    
    <form action="<?=base_url('backend/users/login')?>" method="POST">
      <div class="list-group">
        <div class="list-group-item">
          <input type="email" name="email" placeholder="E-posta" class="form-control no-border" value="<?=$this->input->post('email')?>">
        </div>
        <div class="list-group-item">
           <input type="password" name="password" placeholder="Şifre" class="form-control no-border">
        </div>
      </div>
      <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Giriş" />
	  <div class="text-center m-t m-b"><a href="<?=base_url('backend/users/forgot')?>"><small>Şifremi unuttum</small></a></div>
      <!--
      <div class="line line-dashed"></div>
      <p class="text-muted text-center"><small>Do not have an account?</small></p>
      -->
    </form>
  </section>
</div>
</section>
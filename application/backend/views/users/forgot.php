<?if($this->uri->segment(4)):?>
	<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
	<div class="container aside-xl">
	  <a class="navbar-brand block" href="<?=current_url()?>"><?=$GLOBALS['settings_global']->site_name?></a>
	  <section class="m-b-lg">
	    <header class="wrapper text-center">
	      <strong>Şifre değiştir</strong>
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
		    
	    <form action="<?=current_url()?>" method="POST">
	      <div class="list-group">
	        <div class="list-group-item">
	          <input type="password" name="password" placeholder="Yeni Şifre" class="form-control no-border" />
	        </div>
	      </div>
	      
	      <div class="list-group">
	        <div class="list-group-item">
	          <input type="password" name="password2" placeholder="Yeni Şifre (Tekrar)" class="form-control no-border" />
	        </div>
	      </div>      
	    
	      <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Değiştir" />
	    </form>
	    
	  </section>
	</div>
	</section>
<?else:?>
	<section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
	<div class="container aside-xl">
	  <a class="navbar-brand block" href="<?=current_url()?>"><?=$GLOBALS['settings_global']->site_name?></a>
	  <section class="m-b-lg">
	    <header class="wrapper text-center">
	      <strong>Şifremi unuttum</strong>
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
		    
	    <form action="<?=current_url()?>" method="POST">
	      <div class="list-group">
	        <div class="list-group-item">
	          <input type="email" name="email" placeholder="E-posta" class="form-control no-border" value="<?=$this->input->post('email')?>">
	        </div>
	      </div>
	      <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Hatırlat" />
		  <div class="text-center m-t m-b"><a href="<?=base_url('backend/users/login')?>"><small>Giriş yap</small></a></div>
	    </form>
	  </section>
	</div>
	</section>
<?endif;?>
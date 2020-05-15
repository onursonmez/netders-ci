<section class="margin-top-30 margin-bottom-30">
	<div class="container">
		<h2 class="margin-bottom-10">Hesap Türü Belirleme</h2>
		<p>Lütfen aşağıdaki seçeneklerden birine tıklayarak hesap türünüzü belirleyiniz. Hesap türü belirleme işlemi bir defaya mahsus yapıldığından lütfen doğru seçimi yaptığınızdan emin olunuz.</p>
		<form  action="<?=site_url('users/choice')?>" method="post" class="ajax-form js-dont-reset">
			<div class="row">	
			    <div class="col-md-12 text-center">
			    	<a href="<?=site_url('users/choice/student')?>" class="btn btn-orange margin-top-10 font-size-18 bold"><i class="fa fa-graduation-cap"></i> Öğrenciyim, ders almak istiyorum</a>
			    	<a href="<?=site_url('users/choice/teacher')?>" class="btn btn-orange margin-top-10 font-size-18 bold"><i class="fa fa-user"></i> Eğitmenim, ders vermek istiyorum</a>
			    </div>
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
		</form>
	</div>
</section>
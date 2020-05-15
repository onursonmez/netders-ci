<section class="margin-top-30 margin-bottom-30">
	<div class="container">		
		<div class="row">
		<div class="col-md-6">
			<form  action="<?=site_url('kayit')?>" method="post" class="ajax-form">
				<div class="row">	
					<div class="col-md-12">
						<h2 class="margin-bottom-20">Özel Ders <?if(!empty($page_type)):?><?if($page_type == 1):?>İlanı Vermek<?else:?>Almak<?endif;?><?else:?>Almak veya Vermek<?endif;?> İçin Ücretsiz Üye Ol</h2>
						<a href="<?=site_url('fb')?>" class="btn btn-primary white-text margin-bottom-20" data-toggle="tooltip" data-placement="top" title="Facebook ile onay beklemeden ücretsiz üye olun"><i class="fa fa-facebook"></i> Facebook ile bağlanarak otomatik giriş yap</a>
						<p>Aşağıdaki formu doldurarak Netders.com'a ücretsiz olarak üye olabilirsiniz.</p>					
						<?if($page_type == 1):?>
							<p><a href="<?=site_url('ogrenci-olarak-kayit-olmak-istiyorum')?>">Öğrenci misiniz? Ücretsiz üye olmak için buraya tıklayınız.</a></p>
						<?endif;?>
						
						<?if($page_type == 2):?>
							<p><a href="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>">Eğitmen misiniz? Ücretsiz üye olmak için buraya tıklayınız.</a></p>
						<?endif;?>					
					</div>
					
					<div class="form-group col-md-6">
						<input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız" value="<?=$this->input->post('firstname')?>" />
					</div>
					<div class="form-group col-md-6">
						<input type="text" name="lastname" class="form-control tofirstupper" placeholder="Soyadınız" value="<?=$this->input->post('lastname')?>" />
					</div>
					<div class="form-group col-md-12">
						<input type="email" name="email" class="form-control" placeholder="E-posta adresiniz" value="<?=$this->input->post('email')?>" />
					</div>		
					<div class="form-group col-md-12">
						<input type="password" name="password" class="form-control" placeholder="Şifreniz" />
					</div>
					<div class="form-group col-md-12">
						<input type="radio" name="member_type" value="1" id="mt3" /> <label for="mt3">Öğrenciyim, özel ders alacağım</label><br />
						<input type="radio" name="member_type" value="2" id="mt4" /> <label for="mt4">Eğitmenim, özel ders vereceğim</label><br />
					</div>																					
					<div class="form-group col-md-6">
						<input type="text" name="security_code" class="form-control" placeholder="Dört rakamdan oluşan güvenlik kodunu giriniz">
					</div>
					<div class="form-group col-md-6">
						<img src="<?=base_url('captcha/'.generate_captcha('register'))?>" width="100%" height="32" />
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Üye Ol</button>
						<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
					</div>
					
				</div>
				<input type="hidden" name="form" value="register" />
				<input type="hidden" name="redir" value="<?=base_url('users/choice')?>" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
			
			<p class="font-size-12 grey-text margin-top-30">Bilgi: Eğer hesabınıza varsa lütfen aşağıdaki bağlantıları kullanınız:</p>
			
			<a href="<?=site_url('sifremi-unuttum')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Şifremi unuttum</a>
			<br />
			<a href="<?=_make_link('contents', 37)?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Hesabımla ilgili destek istiyorum</a>
			<br />
			<a href="<?=site_url('giris')?>" class="font-size-12 margin-top-5"><i class="fa fa-link"></i> Üyeyim, giriş yapmak istiyorum</a>				
			
			<?if(!empty($latest_users)):?>
			<div class="row margin-top-20 margin-bottom-20">
				<div class="col-md-12">
					<h3>Aramıza Yeni Katılan Eğitmenler</h3>
					<div id="carousel2">
						<?foreach($latest_users as $user):?>
						<div class="item">
							<div class="panel panel-default user-box" style="max-width:100%;">
								<div class="panel-body">
									<div class="image"><a href="<?=site_url($user->username)?>"><img src="<?if($user->photo):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" class="img-padding-border img-circle" style="max-width:60%;" /></a></div>
									<div class="title"><strong class="margin-top-10"><a href="<?=site_url($user->username)?>"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></strong></div>
									<ul class="extra">
										<li><i class="fa fa-money"></i> <?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL</li>
										<li><i class="fa fa-calendar-o"></i> <?=calculate_age($user->birthday)?> yaşında</li>
										<li><i class="fa fa-map-marker"></i> <?=$user->city_title?>, <?=$user->town_title?></li>
									</ul>
									<div class="title-bottom"><?if(strlen($user->levels) > 80):?><?=mb_substr($user->levels, 0, 80, 'utf-8')?>...<?else:?><?=$user->levels?><?endif;?></div>
								</div>
							</div>
						</div>
						<?endforeach;?>
					</div>	
				</div>
			</div>
			<?endif;?>
			
		</div>
		<div class="col-md-6">		
		
			<?if($page_type == 1):?>
			
			<h2 class="margin-bottom-20">Özel Ders İlanı Vermek İstiyorum</h2>
			
			<p>Eğitmen olarak özel ders ilanı vermek istiyorum diyorsanız Netders'te bunun için harika bir fırsat var. Netders, profil sayfaları ile kendinizi tüm dünyaya tanıtma şansı sunuyor. Bunun yanı sıra verdiğiniz özel ders ilanı ile tüm öğrencilere ulaşabilirsiniz.</p>
			
			<p>Netders profil sayfanızda kişisel bilgilerinizi, ders metotlarınızı, ders özelliklerini, belirlediğiniz ders saat ücret bilgilerini ve bu gibi bir çok bilgiyi sunabilirsiniz. Bu yolla hem kendinizi tanıtıp hem de size uygun olan öğrenciye ders verme imkanı yakalayacaksınız. Öğrenciler gerek web sayfasında gezinerek gerek de arama sayfası aracılığı ile en kısa yoldan kendilerine uygun uzman eğitmeni bulmaya çalışmaktadır. Vereceğiniz özel ders ilanı ile öğrencilerin dikkatini çekerek profil sayfanızı incelemelerini sağlayabilirsiniz.</p>
			
			<p>Netders'in detaylı arama sayfası ile listelenen eğitimcilerin profil sayfalarında verdikleri ilanlara da ulaşılabilmektedir. Öğrenciler eğitmenin güncel olarak hangi konu ile ilgili aktif bir eğitim sunduğunu görerek bilgi sahibi olur. Böylece aradıkları alanda uzman eğitmenleri takip altına alırlar. Aldıkları özel ders ile ilgili sizinle iletişim kurmuş olmasalar da daha sonra sizi denemek isteyebilirler. Güzel bir profil sayfası ve verilen özel ders ilanı daha akılda kalıcı olursunuz. Özel ders ilanı ve profil sayfaları bu anlamda etkili sonuçlar doğurmaktadır.</p>
			
			<h3 class="margin-top-30">Sıkça Sorulan Sorular</h3>
			
			<strong>Netders'te özel ders ilanı vermek istiyorum, ne yapmalıyım?</strong><br />
			Özel ders ilanı vermek için sol tarafta yer alan üyelik formunu doldurmanız yeterlidir. Formu doldurduktan sonra sistem sizi yönlendirecektir. Profilinizin zorunlu alanlarını doldurup incelemeye göndermeniz ve e-posta adresinize gönderilen aktivasyon bağlantısına tıklamanız tüm işlemlerinizin tamamlandığı anlamına gelmektedir.<br /><br />
			
			<strong>İlanda hangi bilgiler sunulacak?</strong><br />
			Profilinizde kendinizle ilgili dilediğiniz bilgiyi paylaşabilirsiniz. Unutmayın, ne kadar çok bilgi paylaşırsanız o kadar çok ilgi göreceksiniz.<br /><br />
			
			<strong>Özel ders ilanı vermek istiyorum, herhangi bir ücret ödemeli miyim?</strong><br />
			Netders.com'a üye olmak ücretsizdir. Arama sonuçlarında daha görünür olmak için isteğe bağlı hizmetlerimizi satın alabilirsiniz.<br /><br />
			
			<strong>Verilen ilanının yayınlanma süreleri nedir?</strong><br />
			Netders.com'da yayınladığınız ilan siz silmediğiniz sürece yayında kalır. Bu da sürekli yeni öğrencilerle tanışmak demektir.<br /><br />
			
			<strong>Üyelik işlemi hangi adımlardan oluşmaktadır?</strong><br />
			Sol taraftaki formu doldurduktan sonra sizi hesabınıza yönlendiriyoruz ve burada profiliniz için girilmesi zorunlu alanları gösteriyoruz. Bu alanları doldurup profilinizi incelenmeye göndermeniz yeterlidir. Son olarak e-posta adresinize gönderilen aktivasyon bağlantısına tıklamayı da unutmayınız.<br /><br />
			
			<strong>Nasıl yardım alabilirim?</strong><br />
			Netders.com'da merak ettiğiniz konuları yardım sayfamızdan öğrenebilirsiniz. Ayrıca iletişim sayfasından telefon veya mesaj yolu ile bize ulaşabilirsiniz. Temsilcilerimiz çevrimiçi olduklarında Canlı Chat sistemini de kullanıp, gerçek zamanlı yardım alabilirsiniz.<br /><br />			

			<?endif;?>
			
			<?if($page_type == 2):?>
			
			<h2 class="margin-bottom-20">Özel Ders Almak İstiyorum</h2>
			
			<p>Netders.com'da uzman eğitmenlerden dilediğiniz konularda özel ders alabilirsiniz. Gelişmiş arama motoru ile özel ders almak istediğiniz eğitmeni kolayca bulabilirsiniz.</p>
			
			<p>Eğitmenlerin telefon numaralarını görmek için Netders.com'a üye olmanız gerekmektedir. Ayrıca Netders.com'a üye olarak, eğitmenlerin sunmuş olduğu üye öğrenci indiriminden de yararlanmış olacaksınız.</p>

			<p>Netders.com dönemsel olarak üye öğrencilerine gönderdiği indirim kuponları ile eğitime destek olur. Netders.com'a üye olarak bu indirim kuponlarından yararlanma fırsatı yakalayacaksınız.</p>
			
			<h3 class="margin-top-30">Sıkça Sorulan Sorular</h3>
			
			<strong>Netders'e üye olmak ücretli midir?</strong><br />
			Özel ders almak için eğitmen arayan öğrencilerimize Netders.com'da yer alan tüm hizmetler ücretsiz olarak sunulmaktadır. Herhangi bir ücret ödemeden Netders.com'u kullanabilirsiniz.<br /><br />
			
			<strong>Netders.com'da aradığım eğitmeni bulabilir miyim?</strong><br />
			Netders.com'da yer alan uzman eğitmenleri gelişmiş arama motoru ile filtreleyerek aradığınız eğitmene ulaşmanız mümkündür. Üye olarak, üye öğrenci indirimi fırsatlarından da yararlanıp, almak istediğiniz özel derse çok uygun ücretlerle sahip olabilirsiniz.<br /><br />			
			
			<strong>Netders.com'da üyeliğimi sonlandırabilir miyim?</strong><br />
			Netders.com'da dilediğiniz zaman üyelik işlemleri altından üyeliğinizi sonlandırabilirsiniz.<br /><br />			

			<strong>Nasıl yardım alabilirim?</strong><br />
			Netders.com'da merak ettiğiniz konuları yardım sayfamızdan öğrenebilirsiniz. Ayrıca iletişim sayfasından telefon veya mesaj yolu ile bize ulaşabilirsiniz. Temsilcilerimiz çevrimiçi olduklarında Canlı Chat sistemini de kullanıp, gerçek zamanlı yardım alabilirsiniz.<br /><br />			
						
			<?endif;?>
			
			<?if(empty($page_type)):?>		
			
			<h2 class="margin-bottom-20">Netders Üyelik Sayfasına Hoşgeldiniz</h2>
			
			<p><strong>Eğitmenler İçin;</strong></p>

			<p>Eğitmen olarak özel ders ilanı vermek istiyorum diyorsanız Netders'te bunun için harika bir fırsat var. Netders, profil sayfaları ile kendinizi tüm dünyaya tanıtma şansı sunuyor. Bunun yanı sıra verdiğiniz özel ders ilanı ile tüm öğrencilere ulaşabilirsiniz.</p>
			
			<p>Netders profil sayfanızda kişisel bilgilerinizi, ders metotlarınızı, ders özelliklerini, belirlediğiniz ders saat ücret bilgilerini ve bu gibi bir çok bilgiyi sunabilirsiniz. Bu yolla hem kendinizi tanıtıp hem de size uygun olan öğrenciye ders verme imkanı yakalayacaksınız. Öğrenciler gerek web sayfasında gezinerek gerek de arama sayfası aracılığı ile en kısa yoldan kendilerine uygun uzman eğitmeni bulmaya çalışmaktadır. Vereceğiniz özel ders ilanı ile öğrencilerin dikkatini çekerek profil sayfanızı incelemelerini sağlayabilirsiniz.</p>
			
			<p>Netders'in detaylı arama sayfası ile listelenen eğitimcilerin profil sayfalarında verdikleri ilanlara da ulaşılabilmektedir. Öğrenciler eğitmenin güncel olarak hangi konu ile ilgili aktif bir eğitim sunduğunu görerek bilgi sahibi olur. Böylece aradıkları alanda uzman eğitmenleri takip altına alırlar. Aldıkları özel ders ile ilgili sizinle iletişim kurmuş olmasalar da daha sonra sizi denemek isteyebilirler. Güzel bir profil sayfası ve verilen özel ders ilanı daha akılda kalıcı olursunuz. Özel ders ilanı ve profil sayfaları bu anlamda etkili sonuçlar doğurmaktadır.</p>
			
			<p><strong>Öğrenciler İçin;</strong></p>
			
			<p>Netders.com'da uzman eğitmenlerden dilediğiniz konularda özel ders alabilirsiniz. Gelişmiş arama motoru ile özel ders almak istediğiniz eğitmeni kolayca bulabilirsiniz.</p>
			
			<p>Eğitmenlerin telefon numaralarını görmek için Netders.com'a üye olmanız gerekmektedir. Ayrıca Netders.com'a üye olarak, eğitmenlerin sunmuş olduğu üye öğrenci indiriminden de yararlanmış olacaksınız.</p>

			<p>Netders.com dönemsel olarak üye öğrencilerine gönderdiği indirim kuponları ile eğitime destek olur. Netders.com'a üye olarak bu indirim kuponlarından yararlanma fırsatı yakalayacaksınız.</p>			
			
			<h3 class="margin-top-30">Sıkça Sorulan Sorular</h3>
			
			<strong>Netders'e üye olmak ücretli midir?</strong><br />
			Netders.com'da hem eğitmenler için hem de öğrenciler için üyelik ücretsizdir. Yalnızca eğitmenler isteğe bağlı olarak arama motorlarında görünürlüğünü arttırmak için ücretli olan hizmetleri satın alabilirler.<br /><br />			
			
			<strong>Netders.com'da üyeliğimi sonlandırabilir miyim?</strong><br />
			Netders.com'da dilediğiniz zaman üyelik işlemleri altından üyeliğinizi sonlandırabilirsiniz.<br /><br />			

			<strong>Nasıl yardım alabilirim?</strong><br />
			Netders.com'da merak ettiğiniz konuları yardım sayfamızdan öğrenebilirsiniz. Ayrıca iletişim sayfasından telefon veya mesaj yolu ile bize ulaşabilirsiniz. Temsilcilerimiz çevrimiçi olduklarında Canlı Chat sistemini de kullanıp, gerçek zamanlı yardım alabilirsiniz.<br /><br />						

			<?endif;?>
		</div>
		

	</div>
</section>
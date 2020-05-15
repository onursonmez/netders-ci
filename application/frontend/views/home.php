<section class="background-header" style="background-image: url(<?=base_url('public/img/background.png')?>);">
	<div class="container">
	    <div class="row">
		    <div class="col-xs-12 col-md-8">
		    	<div class="row">
			    	<div class="col-sm-12">
					    <h1 class="bold2x-text text-center">ÖZEL DERS</h1>
					    <p class="lead text-center">Alanında uzman eğitmenlerden özel ders almak ister misiniz? Netders.com, özel ders almak isteyen öğrencileri, tam aradıkları uzman eğitmenlerle buluşturuyor. Hem de kolay ve ucuz!</p>
			    	</div>
			    	<div class="col-sm-6">
			    		<div class="feature">
				    		<i class="fa fa-asterisk"></i>
					    	<h3 class="yellow-text margin-top-20">Pratik</h3>
					    	<p>Gelişmiş arama motoru ile aradığınız eğitmeni kolayca bulur, yarın derse başlayabilirsiniz.</p>
			    		</div>
			    	</div>
			    	<div class="col-sm-6">
			    		<div class="feature">
			                <i class="fa fa-shield"></i>
			                <h3 class="yellow-text margin-top-20">Güvenli</h3>
			                <p>Tüm eğitmenlerin profilleri ayrıntılı olarak incelenir. Güvenerek eğitmenlerle görüşebilirsiniz.</p>
			    		</div>
			    	</div>	
			    	<div class="col-sm-6">
			    		<div class="feature">
			                <i class="fa fa-heart"></i>
			                <h3 class="yellow-text margin-top-20">Ucuz</h3>
			                <p>Almak istediğiniz derse en uygun fiyatlarla sahip olabilirsiniz.</p>
			    		</div>
			    	</div>	
			    	<div class="col-sm-6">
			    		<div class="feature">
			                <i class="fa fa-smile-o"></i>
			                <h3 class="yellow-text margin-top-20">Ücretsiz</h3>
			                <p>Özel ders veren eğitmenlerin neredeyse tamamı ilk dersi ücretsiz veriyor. Bu fırsat kaçmaz.</p>
			    		</div>
			    	</div>				    				    			    	
		    	</div>
		    </div>
		    <div class="col-xs-12 col-md-4">
				<div class="panel panel-default register-box margin-top-20">
				  <div class="panel-body">
  					<h1><span class="block">Ücretsiz</span> Üye Olun</h1>
					<form  action="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" method="post" class="ajax-form" autocomplete="off">
						<div class="form-group">
							<div class="input-group">
							<input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız">
							<div class="input-group-addon"><i class="fa fa-user"></i></div>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							<input type="text" name="lastname" class="form-control tofirstupper" placeholder="Soyadınız">
							<div class="input-group-addon"><i class="fa fa-user"></i></div>
							</div>
						</div>				
						<div class="form-group">
							<div class="input-group">
							<input type="email" name="email" class="form-control" placeholder="E-posta Adresiniz">
							<div class="input-group-addon"><i class="fa fa-envelope"></i></div>
							</div>
						</div>	
						<div class="form-group">
							<div class="input-group">
							<input type="password" name="password" class="form-control" placeholder="Şifreniz">
							<div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
							</div>
						</div>
						
						<div class="form-group">
							<input type="radio" name="member_type" value="1" id="mt3" /> <label for="mt3" style="cursor:pointer">Öğrenciyim, özel ders alacağım</label><br />
							<input type="radio" name="member_type" value="2" id="mt4" /> <label for="mt4" style="cursor:pointer">Eğitmenim, özel ders vereceğim</label><br />
						</div>
																									
						<div class="form-group">
							<div class="input-group">
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6">
										<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
									</div>								
									<div class="col-xs-12 col-sm-6 col-md-6" data-name="security-code">
										<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
									</div>
								</div>
							</div>
						</div>
						
						<button type="submit" class="btn btn-wide btn-orange js-submit-btn">Üye ol</button>
						<button disabled="disabled" class="btn btn-wide btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
						
						<input type="hidden" name="form" value="ajax_register2" />
						<input type="hidden" name="redir" value="<?=base_url('users/my')?>" />
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
					</form>
				  </div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--
<section class="dark-header">
	<div class="container">
	    <div class="row">
		    <div class="col-md-12 text-center">
				<p class="lead text-center">Öğrenciyseniz ilk dersi ücretsiz ders alın, eğitmenseniz hemen ders vermeye başlayın.</p>
		    </div>
		    <div class="col-md-12 text-center">
		    	<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>" class="btn btn-orange margin-top-10 font-size-24 bold"><i class="fa fa-search"></i> Ders almak istiyorum</a>
		    	<a href="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" class="btn btn-orange margin-top-10 font-size-24 bold"><i class="fa fa-plus"></i> Ders vermek istiyorum</a>
		    </div>
	    </div>
	</div>
</section>
-->

<section class="dark-header">
	<div class="container">
		<form method="GET" action="<?=_make_link('search', $this->session->userdata('site_city'))?>"
	    <div class="row">
		    <div class="col-md-12 text-center">
				<h1 class="margin-bottom-20">Özel Ders Veren Eğitmenleri Arayın</h1>
		    </div>

		    <div class="col-md-8">
				<input name="keyword" type="text" class="form-control margin-top-10" placeholder="Aradığınız dersin adını yazınız..." style="padding:40px; font-size:24px;" />
		    </div>		
		    
		    <div class="col-md-4">
			    <button type="submit" class="btn btn-orange btn-wide margin-top-10" style="padding:24px; font-size:24px;">Eğitmenleri bul</button>
		    </div>    
		    <div class="col-md-12 text-center">
				<h2 class="margin-top-40 margin-bottom-20">veya aşağıdan tercihinizi yapın</h2>
		    </div>		    
		    <div class="col-md-12 text-center">
				<p class="lead text-center">Öğrenciyseniz ilk özel dersi ücretsiz ders alın, eğitmenseniz hemen özel ders vermeye başlayın.</p>
		    </div>
		    <div class="col-md-12 text-center">
		    	<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>" class="btn btn-orange margin-top-10 font-size-24 bold"><i class="fa fa-search"></i> Özel Ders İlanları</a>
		    	<a href="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" class="btn btn-orange margin-top-10 font-size-24 bold"><i class="fa fa-plus"></i> Özel Ders Ver</a>
		    </div>		    
	    </div>
	    </form>
	</div>
</section>

<section class="grey-header home-categories">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-lg-8">
				<h2 class="margin-bottom-20">Özel Ders Kategorileri</h2>
				<p>Alanında tecrübeli eğitmenlerden özel ders alarak, ihtiyacınız olan eğitime, uygun maliyetlerle ve kolayca sahip olabilirsiniz. Almak istediğiniz eğitimle ilgili kutuya tıklayarak, o kategoride özel ders veren eğitmenleri görüntüleyebilirsiniz. Dilerseniz, gelişmiş arama motorunu kullanarak, tam aradığınız eğitmene ulaşmanızı kolaylaştırabilirsiniz. Tercih ettiğiniz eğitmeni seçip, hakkında detaylı bilgi alabilir ve hemen iletişime geçebilirsiniz. Bütçe ve ders saatlerinizin karşılıklı olarak uyuşması sonrasında özel ders almaya hemen başlayabilirsiniz.</p>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/ilkogretim-takviye">
						<img src="<?=base_url('public/img/home-icon-ilkogretim.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>İlköğretim Takviye</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/lise-takviye">
						<img src="<?=base_url('public/img/home-icon-lise.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Lise Takviye</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/universite-takviye">
						<img src="<?=base_url('public/img/home-icon-universite.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Üniversite Takviye</strong>
					</a>
				</div>
			</div>	
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/sinav-hazirlik">
						<img src="<?=base_url('public/img/home-icon-sinavhazirlik.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Sınav Hazırlık</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/yabanci-dil">
						<img src="<?=base_url('public/img/home-icon-yabancidil.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Yabancı Dil</strong>
					</a>
				</div>
			</div>	
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/bilgisayar">
						<img src="<?=base_url('public/img/home-icon-bilgisayar.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Bilgisayar</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/muzik">
						<img src="<?=base_url('public/img/home-icon-muzik.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Müzik</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/spor">
						<img src="<?=base_url('public/img/home-icon-spor.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Spor</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/sanat">
						<img src="<?=base_url('public/img/home-icon-sanat.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Sanat</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/dans">
						<img src="<?=base_url('public/img/home-icon-dans.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Dans</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/kisisel-gelisim">
						<img src="<?=base_url('public/img/home-icon-kisiselgelisim.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Kişisel Gelişim</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/direksiyon">
						<img src="<?=base_url('public/img/home-icon-direksiyon.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Direksiyon</strong>
					</a>
				</div>
			</div>
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/ozel-egitim">
						<img src="<?=base_url('public/img/home-icon-ozelegitim.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Özel Eğitim</strong>
					</a>
				</div>
			</div>			
			<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 margin-bottom-20">
				<div class="text-center">
					<a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/oyun-ve-hobi">
						<img src="<?=base_url('public/img/home-icon-oyunhobi.png')?>" style="width:100%; display:block; margin-bottom:10px;" />
						<strong>Oyun / Hobi</strong>
					</a>
				</div>
			</div>																											
		</div>
	</div>
</section>

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-md-12 text-center">
		    	<h3>Yardımcı Video - Nasıl Özel Ders Verilir?</h3>
				<iframe class="video" width="100%" height="480" src="https://www.youtube.com/embed/cls2-DFJBa0" frameborder="0" allowfullscreen></iframe>
		    </div>	    	    
	    </div>
	</div>
</section> 



<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-md-4 show-lg hidden-md hidden-sm hidden-xs">
				<img src="<?=base_url('uploads/2019-2020.png')?>" />
		    </div>	 
		    
		    <div class="col-lg-8 col-md-12 text-center">
		    	<h3>Netders Nedir?</h3>
				<p>Proje geliştirmesi teknopark çatısı altında devam eden Netders.com interaktif eğitim platformu ve eğitmen profillerinin yer aldığı bir özel ders ilan portalıdır. Bu portalın amacı, eğitmen ve öğrenciyi birebir veya canlı derslerle buluşturmaktır. Canlı ders eğitimleri ile yer ve zaman sınırlamalarından bağımsız, her konuda bilgi ve deneyimin paylaşılabildiği, anlık etkileşimli interaktif bir eğitim ortamı sağlanmaktadır.</p>
				 
				<p>Netders.com portalı üzerinden alınabilecek canlı dersler, eğitim sistemi müfredatına uygun, ana hedef okul derslerinin yanında kültür, sanat, spor, müzik ve daha birçok alanda uzman eğitmenler tarafından verilmektedir. Netders.com portalı sayesinde size çok uzak lokasyonda ikamet eden bir eğitmenden bile yüksek standartlarda ve kaliteli bir eğitim alabilme imkanı elde edebilirsiniz. Netders.com eğitimin verilebilmesi için eğitmen ile öğrenciyi buluşturarak size ayrıcalıklı imkan ve seçenekler sunar.</p>
				 
				<p>Netders.com'u kullanmak oldukça rahattır. Üye olmak ise ücretsiz ve çok kolay. Sizi yol masraflarından kurtaracak, zamandan tasarruf etmenizi sağlayacak Netders.com'a dünyanın her yerinden ulaşabilirsiniz. Başladığınız bir eğitime başka bir ülkede devam etmeniz mümkündür. İnternete bağlanabileceğiniz bir cihazınız olması yeterlidir. Netders size yeni ufuklar açar!</p>
		    </div>	    	    
	    </div>
	</div>
</section>  

<section class="dark-header">
	<div class="container">
	    <div class="row">
		    <div class="col-md-12 text-center">
				<h1>Öğrenciler İçin</h1>
		    </div>
	    </div>
	</div>
</section>

<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="Daima Ücretsiz Kullanma Garantisi" src="<?=base_url('public/img/ucretsiz-kullanma-garantisi.png')?>" width="100%" height="100%" />
		    </div>    
		    <div class="col-sm-10">
		    	<h3>Daima Ücretsiz Kullanma Garantisi</h3>
				<p>Netders.com'a üye olmak ve kullanmak ücretsizdir. Hem eğitmen hem de öğrenci olarak Netders.com'un özelliklerinden ücretsiz olarak yararlanabilirsiniz. Netders.com'u kullanan tüm kullancılarımıza daima ücretsiz kullanım garantisi veriyoruz.</p>
				<p>Ülkemizin ve insanımızın eğitimine katkı sağlaması amacıyla kurulan Netders.com, kapsayıcı ve her kesimin ulaşabileceği ortak bir eğitim platformu olarak tüm topluma eğitim hizmeti vermek için bu politikayı süresiz olarak sürdürecektir.</p>
				<p>Her alanda rahat, kolay ve kesintisiz bir eğitim, hedefe yönelik öğrenim ve öğrenci ile eğitmen için yüksek standartlarda eğitim çözümleri geliştiriyoruz.</p>
				<p>Netders.com'da yalnızca isteğe bağlı bazı özellikler ücretlidir. Bu özellikleri almanız zorunlu değildir. Eğitmenler için arama sonuçlarında daha fazla görünür olma veya öğrenciler için dersleri canlı olarak Netders.com üzerinden alabilme gibi özellikler isteğe bağlı olarak ücretlidir.</p>
	
		    </div>	    
		    <div class="col-sm-2 hidden-xs">
				<img alt="Daima Ücretsiz Kullanma Garantisi" src="<?=base_url('public/img/ucretsiz-kullanma-garantisi.png')?>" width="100%" height="100%" />
		    </div>
	    </div>
	</div>
</section>  
            
<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Dünyanın Her Yerinden Canlı Ders Alma İmkanı" src="<?=base_url('public/img/dunyanin-heryerinden-canli-ders.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Dünyanın Her Yerinden Canlı Ders Alma İmkanı</h3>
		    	<p>Eğitmen ve öğrencinin özel ders amacıyla buluşarak karşılıklı ders işlemesinin özel bir eğitim olduğu şüphesiz. Bir de aldığınız eğitimleri bulunduğunuz yerden ayrılmadan (evinizden, iş yerinizden veya tatilde) aldığınızı düşünün...</p>
				<p>Netders'e dünyanın her yerinden ulaşabilirsiniz. İnterneti olan bir bilgisayar sizin için yeterli. Özel ders, Canlı ders veya çoklu ders için önceden belirlenmiş olan gün ve saatte sisteme giriş yaparak kolay bir şekilde derse katılabilirsiniz.</p>
				 
				<p>Netders'te sesli, görüntülü ve metin tabanlı yazışarak sanal tahta ile etkileşimli olarak özel ders ve canlı ders eğitimi verilmektedir. Daha sonra dilediğiniz zaman aldığınız dersin canlı ders kaydına da ulaşabileceksiniz. Böylelikle hem ders tekrarı yapma hem de diğer derslere hazırlık amaçlı elinizde sesli, görüntülü ve yazılı bir dokümanınız olmuş olacak.</p>
				 
				<p>Netders'te canlı ders olarak alacağınız ilk dersin ücreti bizden. Ücretsiz bu ders ile Netders'i ve eğitmeninizi deneme fırsatını yakalayın.</p>
				 
				<p>Eğitmen ve öğrenciyi buluşturan Netders bir tarafın herhangi bir sebepten ötürü katılım gerçekleştirmemesi durumunda öncelikli olarak öğrenciyi gözetmektedir. Eğitmenin gelmediği durumlarda canlı ders eğitiminin tekrar yapılacağının garantisini vermektedir. </p>
		    </div>		    
	    </div>
	</div>
</section>    

<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="İlk Dersi Ücretsiz Alma Fırsatı" src="<?=base_url('public/img/ilk-ders-ucretsiz.png')?>" width="100%" height="100%" />
		    </div>    
		    <div class="col-sm-10">
		    	<h3>İlk Dersi Ücretsiz Alma Fırsatı</h3>
				<p>Netders'te verilen eğitimin kalite standartlarının yüksek olması ve öğrencinin kendisine uygun olan doğru eğitmen seçimini yapabilmesi için özel bir sistem işlemektedir. Bu sistem içinde eğitmeni tanımak ve ders tecrübesini görmek için öğrencilere ilk canlı ders eğitimini ücretsiz alma fırsatı tanıyoruz. Bu ilk canlı ders ile öğrencinin bilgisini sınama imkanı doğarken bir yandan da gelecek canlı dersler ile ilgili plan belirlenmiş oluyor. Öğrenci memnuniyeti adına yapılan bu uygulama ile aynı zamanda eğitimcinin de verimli ve hedefe yönelik bir iş performansı ortaya koyması sağlanıyor.</p>
				<p>Netders'te ücretsiz ilk canlı ders fırsatını değerlendirerek aradığınız eğitime yüksek standartlarda kavuşabilirsiniz.</p>
	            <p>Dünyanın her yerinden eğitimci ve öğrenciyi buluşturan, mekan ve iletişim problemlerini minimuma indiren Netders, interaktif birçok araç ve özellik ile sınırsız fırsatlar sunuyor.</p>
				<p>Netders'in etkileşimi kolaylaştıran, eğlenceli hale getiren araç ve özelliklerini çok seveceksiniz. Denemek için bu fırsatı kaçırmayın!</p>
		    </div>	    
		    <div class="col-sm-2 hidden-xs">
				<img alt="İlk Dersi Ücretsiz Alma Fırsatı" src="<?=base_url('public/img/ilk-ders-ucretsiz.png')?>" width="100%" height="100%" />
		    </div>		    
	    </div>
	</div>
</section>   

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Gerçek Zamanlı Mesajlaşma" src="<?=base_url('public/img/gercek-zamanli-mesajlasma.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Gerçek Zamanlı Mesajlaşma</h3>
				<p>Netders'te dersler görüntülü, sesli ve metin tabanlı yazışarak verilmektedir. Öğrenci dilediği zaman eğitimciye mesaj yazabilir, ders esnasında soru sorabilir. Ders dışında da öğrenciler eğitimcilere mesaj gönderebilirler. Eğitmen veya öğrenci online ise karşı tarafın mesajını anında görecek ve gelen mesajı cevaplayabilecektir. Site içinde çevrimiçi olunduğu takdirde, gerçek zamanlı bu yazışmalar ile iletişim sağlanarak eğitimci ile anında irtibat sağlamak mümkün olmaktadır. Bu irtibat eğitimci ve öğrenci arasında kurulan özel mesaj kutusu vasıtası ile gerçekleşmektedir.</p>
	            
	            <p>Netders'te gerçek zamanlı mesajlaşmaların logları bir yıl boyunca gizlilik politikaları gereğince saklanmaktadır. Herhangi bir üçüncü şahıslarla paylaşılmamaktadır. </p>
		    </div>		    
	    </div>
	</div>
</section>

<?if(!empty($latest_users)):?>
<section class="white-header hide carousel-wrapper" style="background-image:url(<?=base_url('public/img/geo-background.png')?>);">
	<div class="container">
		<div class="row">
			<div class="col-md-12 margin-bottom-20"><h3>Aramıza Yeni Katılan Eğitmenler</h3></div>
			<div class="col-md-12">
				<div id="carousel">
					<?foreach($latest_users as $user):?>
					<div class="item">
						<div class="panel panel-default user-box">
							<div class="panel-body">
								<div class="image"><a href="<?=site_url($user->username)?>"><img src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>" class="img-padding-border img-circle" style="max-width:60%;" /></a></div>
								<div class="title"><strong class="margin-top-10"><a href="<?=site_url($user->username)?>"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></strong></div>
								<ul class="extra">
									<li><i class="fa fa-money"></i> <?if($user->virtual_price):?><?=$user->virtual_price?><?else:?><?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL<?endif;?></li>
									<li><i class="fa fa-calendar-o"></i> <?if($user->virtual_age):?><?=$user->virtual_age?> yaşında<?else:?><?=calculate_age($user->birthday)?> yaşında<?endif;?></li>
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
	</div>
</section>
<?endif;?>		

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="Canlı Yardım" src="<?=base_url('public/img/canli-yardim.png')?>" width="100%" height="100%" />
		    </div>    
		    <div class="col-sm-10">
		    	<h3>Canlı Destek</h3>
				<p>Netders.com Özel ders ve canlı ders ile ilgili ihtiyaçlarınıza anlık çözümlere üretebilmek amacıyla canlı ders sistemi kullanmaktadır. Müşteri temsilcilerimizin çevrimiçi olduğu anlara sitenin sağ alt tarafında yer alan alana (müşteri temsilcilerimiz çevrimiçi değilse görünmez) mesajınızı yazarak anlık mesajlaşma başlatabilirsiniz.</p>
				<p>Müşteri temsilcilerimiz ihtiyaçlarınıza çevrimiçi çözümlere üreterek sonuca ulaştıracaktır. Netders.com ile ilgili merak ettiğiniz tüm soruları müşteri temsilcilerimize sorabilirsiniz.</p>
		    </div>		    	    
		    <div class="col-sm-2 hidden-xs">
				<img alt="Canlı Yardım" src="<?=base_url('public/img/canli-yardim.png')?>" width="100%" height="100%" />
		    </div>
	    </div>
	</div>
</section>
    
<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Gelişmiş Arama Sihirbazı" src="<?=base_url('public/img/gelismis-arama-sihirbazi.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Gelişmiş Arama Sihirbazı</h3>
				<p>Gelişmiş arama sihirbazı, aradığınız dersi için uzman eğitmenleri filtrelemenizi sağlar.</p>
				
				<p>Dersi veren eğitimci, uygun zaman aralıkları, ders yöntemi, ders alanları, ders konuları ve daha birçok kriterle aramanızı derinleştirerek, yalnızca belirlediğiniz kriterlere uygun olan eğitmenleri görüntüleme imkanına sahip olursunuz. Bu bilgiler ışığında daha spesifik bir seçim yaparak zamandan tasarruf edersiniz. Doğru eğitmen ile yapılan ders daha yoğun, daha verimli, kolay anlaşılır ve hedefe yönelik olacaktır.</p>
			
				<p>Ücretsiz üye olarak, bulunduğunuz şehirde ve dilediğiniz özelliklerdeki tüm özel ders veren eğitmenlere anında ulaşabilirsiniz.</p>
	
				<p>Ayrıca Netders.com'da verilen derslerin güncel listesine de bu bölümden kolayca erişebilirsiniz.</p>
		    </div>		    
	    </div>
	</div>
</section>       

<section>
	<div class="panel panel-default register-box">
	  <div class="panel-body text-center">
	  	<div class="container">
		<h3>Hoşunuza gitti mi? Dilerseniz aşağıdaki alanları doldurarak hemen aramıza katılabilirsiniz...</h3>
			<form  action="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" method="post" class="ajax-form margin-top-20">
				<div class="row">						
					<div class="form-group col-md-2">
						<input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız">
					</div>
					<div class="form-group col-md-2">
						<input type="text" name="lastname" class="form-control tofirstupper" placeholder="Soyadınız">
					</div>
					<div class="form-group col-md-2">
						<input type="email" name="email" class="form-control" placeholder="E-posta Adresiniz">
					</div>
					<div class="form-group col-md-2">
						<input type="password" name="password" class="form-control" placeholder="Şifreniz">
					</div>
					<div class="form-group col-md-2">
						<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
					</div>															
					<div class="form-group col-md-2" data-name="security-code">
						<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
					</div>
					<div class="form-group col-md-12">
						<input type="radio" name="member_type" value="1" id="mt5" /> <label for="mt5">Öğrenciyim, özel ders alacağım</label> &nbsp;&nbsp;&nbsp;
						<input type="radio" name="member_type" value="2" id="mt6" /> <label for="mt6">Eğitmenim, özel ders vereceğim</label>
					</div>
					<div class="col-md-12">
						<button type="submit" class="btn btn-orange js-submit-btn">Ücretsiz üye ol</button>
						<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
					</div>								
				</div>
				<input type="hidden" name="form" value="ajax_register3" />
				<input type="hidden" name="redir" value="<?=base_url('users/my')?>" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
	  	</div>
	  </div>
	</div>
</section> 	

<section class="dark-header">
	<div class="container">
	    <div class="row">
		    <div class="col-md-12 text-center">
				<h1>Eğitmenler İçin</h1>
		    </div>
	    </div>
	</div>
</section>

<!--
<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="Özellikleri Ücretsiz Deneme İmkanı" src="<?=base_url('public/img/ozellikleri-ucretsiz-deneme-imkani.png')?>" width="100%" height="100%" />
		    </div>    
		    <div class="col-sm-10">
		    	<h3>Özellikleri Ücretsiz Deneme İmkanı</h3>
				<p>Netders.com'da yer alan tüm ücretli üyelik ve hizmetler 1 Ocak 2017 tarihine kadar ücretsizdir. Tüm ücretli üyelik ve hizmetleri bu süre içerisinde ücretsiz olarak deneyebilirsiniz.</p>
				<p>1 Ocak 2017 tarihinde Netders.com'da yer alan tüm üyelik ve hizmetler sıfırlanarak yeni bir başlangıç yapılacaktır.</p>
				<p>1 Ocak 2017 tarihinden itibaren ücretli üyelikleri 14 gün boyunca ücretsiz olarak deneme imkanına sahip olacaksınız ancak deneme üyelikleri belli bir kota ile sınırlandırılacaktır. Bunun nedeni, deneme yaptığınız üyeliğin farklarını maksimum düzeyde size göstermektir. Ayrıca, Netders.com'a üye olan eğitmenlerin çoğu deneme üyeliklerini alırsa gerçekten ücretini verip ücretli üyelik alan eğitmenlere de haksızlık yapmış oluruz. Bu nedenle deneme üyelikleri, aktif olarak maksimum 10 kişinin kullanımı ile sınırlandırılacaktır. Deneme üyeliği müsaitlik durumunu Üyelik İşlemleri bölümünde görebileceksiniz. Ancak hızlı olmalısınız, siz almadan başka bir eğitmen alabilir :)</p>
				<p>Amacımız ücretini ödeyip üyelik satın alan eğitmenlerimize haksızlık yapmadan, daha önce denemeyen eğitmenlerimizin ücretli üyelikleri 14 gün boyunca ücretsiz olarak denemesini sağlamaktır.</p>
		    </div>
		    <div class="col-sm-2 hidden-xs">
				<img alt="Özellikleri Ücretsiz Deneme İmkanı" src="<?=base_url('public/img/ozellikleri-ucretsiz-deneme-imkani.png')?>" width="100%" height="100%" />
		    </div>
	    </div>
	</div>
</section>
-->

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Öne Çıkan Eğitmenler" src="<?=base_url('public/img/dikkat-ceken-egitmenler.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Öne Çıkan Eğitmenler</h3>
				<p>Netders.com'da Premium üyelik alarak veya doğrudan Öne Çıkanlar hizmeti alarak profilinizin arama sonuçlarında ayrıcalıklı bir alanda yer almasını sağlayabilirsiniz.</p>
				 
				<p>Netders.com arama sayfasında listelenen eğitmenler üyelik tiplerine ve satın aldıkları hizmetlere göre sıralanır.</p>
				<p>Öne Çıkanlar hizmeti alarak, Tüm Eğitmenler sıralamasından önce, yalnızca Premium üye ve Öne Çıkanlar hizmeti satın alan eğitmenlerin yer aldığı öncelikli bir alanda yer alırsınız.</p>
				<p>Öğrenciler, arama sonuçlarında ilk önce Önce Çıkanlar alanını görmektedir. Profiliniz Önce Çıkanlar alanında yer aldığında, daha fazla öğrenci profilinizi ziyaret edecek ve özel ders verdiğiniz öğrenci sayısını arttırma imkanına sahip olacaksınız.</p>
		    </div>		    
	    </div>
	</div>
</section>

<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="Özel Web Sayfası" src="<?=base_url('public/img/ozel-web-sayfasi.png')?>" width="100%" height="100%" />
		    </div>	    
		    <div class="col-sm-10">
		    	<h3>Özel Web Sayfası</h3>
				<p>Netders.com'da Premium üyelik alarak veya doğrudan Özel Web Sayfası hizmeti alarak ayrıcalıklı bir profil sayfasına sahip olabilirsiniz.</p>
				<p>Alanınızda çok tecrübeliyseniz veya ayrıcalıklı bir eğitim modeli uyguluyorsanız ve bunu öğrencilerinize hissettirmek istiyorsanız, Özel Web Sayfası hizmeti ile bunu gerçekleştirebilirsiniz.</p>
				<p>Netders.com'da eğitmenlerin profil sayfalarını inceleyen öğrenciler, Özel Web Sayfası'na sahip bir profil sayfasını ziyaret ettiklerinde, profil sahibi eğitmenin ayrıcalıklı bir eğitim verdiği hissine kapılıyorlar. Çünkü Özel Web Sayfası hizmeti almış eğitmenlerin profil sayfaları diğer eğitmenlerin profil sayfalarından çok farklı bir dizayna sahip oluyor.</p>
				<p>Özel Web Sayfası alan eğitmenlerin profil sayfalarında Benzer Eğitmenler gibi başka eğitmenlerin profilleri kesinlikle yer almıyor. Profil sayfanızda yalnız size ve verdiğiniz eğitimlere ait bilgilere yer veriliyor.</p>
				<p>Özel Web Sayfası hizmeti alarak, profil sayfanızda bazı küçük değişiklikler yapmanıza da imkan sağlıyoruz. Kullandığınız Özel Web Sayfası dizaynının bazı bölümlerine ait görselleri, dilediğiniz görsellerle değiştirerek çok daha özel bir profil sayfasına sahip olabilirsiniz.</p>
		    </div>	    
		    <div class="col-sm-2 hidden-xs">
				<img alt="Özel Web Sayfası" src="<?=base_url('public/img/ozel-web-sayfasi.png')?>" width="100%" height="100%" />
		    </div>		    
	    </div>
	</div>
</section> 

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Günün, haftanın, ayın eğitmeni" src="<?=base_url('public/img/gunun-haftanin-ayin-egitmeni.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Günün / Haftanın / Ayın Eğitmeni</h3>
				<p>Netders.com'da arama sonuçlarında yer alan Öne Çıkanlar ve Tüm Eğitmenler alanlarından önce, günün, haftanın ve ayın eğitmeni yer alır. Bu alanda yer almak için günün, haftanın veya ayın eğitmeni olacağınız konu ve dersi belirlemeniz gerekir. Günün, haftanın ve ayın eğitmenleri tüm arama sonuçlarının üstünde yer aldığı için yalnızca belirlenen konu ve ders arama sonuçlarında görünür. Eğer arama kriterlerine uygun günün, haftanın veya ayın eğitmeni var ise önce bu eğitmenlerin profilleri, daha sonra Öne Çıkanlar ve Tüm Eğitmenler'in profilleri sıralanır.</p>
				<p>Günün, haftanın ve ayın eğitmenleri, seçtikleri konu ve ders kategorisinde standart arama sonuçlarından bağımsız olarak en üstte yer alır. Her konu ve ders için yalnızca birer günün, haftanın ve ayın eğitmeni profile yer alır. Bir eğitmen belirlediği konu ve ders için günün eğitmeni alırsa başka bir eğitmen aynı günde aynı ders ve konu için Günün Eğitmeni hizmeti satın alamaz. Başka bir gün için satın alması gerekir.</p>
				<p>Boş zamanlarınızın çok olduğu dönemlerde, günün, haftanın veya ayın eğitmeni hizmeti satın alarak, bu dönemlerinizde hızlıca özel ders almak isteyen öğrencilerin size ulaşmasını sağlayabilirsiniz.</p>

		    </div>		    
	    </div>
	</div>
</section>

<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="Sıralama Dopingi" src="<?=base_url('public/img/siralama-dopingi-ozelligi.png')?>" width="100%" height="100%" />
		    </div>    
		    <div class="col-sm-10">
		    	<h3>Sıralama Dopingi</h3>
				<p>Netders.com'da profilinizin üst sıralarda yer alması için Sıralama Dopingi hizmeti alabilirsiniz. Sıralama Dopingi hizmeti ile profiliniz arama sonuçlarında daha üst sıralarda görünür.</p>
				
				<p>Sıralama Dopingi hizmeti aldığınızda, sizden önce yalnızca üst seviyedeki üye grupları yer alır. Sizin profiliniz, arama sonuçlarında, grubunuzdaki diğer tüm eğitmenlerden öncelikli olarak görünür.</p>
				
				<p>En üst seviye bir üyelik grubundaysanız, Sıralama Dopingi hizmeti aldıysanız ve üye öğrenci indirimi uyguluyorsanız, profiliniz arama sonuçlarında ilk sırada yer alır. Aynı tipte birden fazla üye var ise bu üyeler arasında son giriş tarihe göre sıralama yapılır.</p>
				
		    </div>
		    <div class="col-sm-2 hidden-xs">
				<img alt="Sıralama Dopingi" src="<?=base_url('public/img/siralama-dopingi-ozelligi.png')?>" width="100%" height="100%" />
		    </div>
	    </div>
	</div>
</section>

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Çevrimiçi eğitmenlerUzman Eğitmen Rozeti" src="<?=base_url('public/img/uzman-egitmen-rozeti.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Uzman Eğitmen Rozeti</h3>
				<p>Netders'le ders almak istediğiniz alanda kaliteli eğitime, uzman eğitmene ulaşabilirsiniz. Uzman eğitmenler, kayıtlı eğitmenlerin arama sonuçlarında ve profil detay sayfalarında 'uzman eğitmen rozeti' ile karşınıza çıkacak.</p>
				 
				<p>Uzman eğitmen statüsü için eğitmenlerin iş kariyerlerindeki uzmanlıklarını kanıtlayan belgeleri Netders'e ulaştırması gerekmektedir. Belgeler eğitimci ekip tarafından incelenip uygun bulunduğu takdirde bu statü eğitmen tarafından kazanılır. Böylece öğrenciler, eğitmenleri 'uzman eğitmen rozeti', eğitmen puan sistemi ve 'günün, ayın, yılın eğitmeni' gibi derecelendirmeler ile daha kolay tanıyarak seçim yapabilirler.</p>
		    </div>		    
	    </div>
	</div>
</section>

<section class="grey-header">
	<div class="container">
	    <div class="row">
		    <div class="show-xs hidden-sm hidden-md hidden-lg margin-bottom-20">
				<img alt="Eğitmen Puan Sistemi" src="<?=base_url('public/img/egitmen-puanlama-sistemi.png')?>" width="100%" height="100%" />
		    </div>		        
		    <div class="col-sm-10">
		    	<h3>Eğitmen Puan Sistemi</h3>
					<p>Netders.com arama sayfasında puana göre eğitmenleri sıralama özelliği bulunmaktadır. Bu özelliği kullanan öğrencilerin karşısına çıkan eğitmenler üyelik tipi ve satın aldığı hizmetlerden bağımsız olarak, profil puanlarına göre sıralanmaktadır.</p>
					<p>Netders.com'da eğitmenlerin profil puanları, gerçekleştirdikleri işlemlere göre artmaktadır.</p>
					<p><u>Profil puanlarınızı aşağıdaki işlemler arttırmaktadır:</u></p>
					<p>Hesabınıza günlük olarak giriş yapmanız,</p>
					<p>Çevrimiçi kalmanız,</p>
					<p>Profilinizin bir öğrenci tarafından ziyaret edilmesi,</p>
					<p>Size mesaj gönderilmesi,</p>
					<p>Profilinize yorum yapılması,</p>
					<p>Satın aldığınız ürün ve hizmetlerden kazandığınız sanal para kadar,</p>
					<p>Profilinizde güncelleme işlemi yapmanız.</p>
					<p>Yukarıda yer alan işlemlerin tümü, belli bir kontrol mekanizması ve doğrulama sistemi işlemlerinden sonra puan olarak hesabınıza yansıtılmaktadır.</p>
		    </div>	    
		    <div class="col-sm-2 hidden-xs">
				<img alt="Eğitmen Puan Sistemi" src="<?=base_url('public/img/egitmen-puanlama-sistemi.png')?>" width="100%" height="100%" />
		    </div>		    
	    </div>
	</div>
</section>

<section class="white-header">
	<div class="container">
	    <div class="row">
		    <div class="col-sm-2 margin-bottom-20">
				<img alt="Sanal Para" src="<?=base_url('public/img/sanal-para-ozelligi.png')?>" width="100%" height="100%" />
		    </div>
		    <div class="col-sm-10">
		    	<h3>Sanal Para</h3>
<p>Netders.com'da satın aldığınız üyelik ve hizmetler karşılığında sanal para kazanırsınız. Kazandığınız sanal paralar ile Netders.com'un ücretli hizmetlerini ücretsiz olarak satın alabilirsiniz. Alışveriş sepetinizde "Sanal Para Kullan" seçeneği ile ekstra herhangi bir ücret ödemeden ücretli olan hizmetleri sanal paranız kadar ücretsiz olarak satın alabilirsiniz.</p>
<p>Netders.com'da kazandığınız sanal paralar gerçek paraya çevrilmez. Yalnızca ücretli hizmetleri ücretsiz satın almak için kullanılabilir.</p>
<p>Netders.com'da bazı aktiviteler gerçekleştirerek de sanal para kazanabilirsiniz. </p>
<p><u>Netders.com'da sanal para kazanacağınız işlemler aşağıdadır:</u></p>
<p>Site içerisinde dönemsel olarak açılan aktivitelere katılmak ve başarı sağlamak,</p>
<p>Bir eğitmeni Netders.com'a davet etmek ve üye olmasını sağlamak,</p>
<p>Öğrencilerinize Netders.com üzerinden canlı ders vermek,</p>
<p>Ücretli üyelik veya hizmet satın almak (ödenen tutarın %10'u sanal para olarak hesabınıza yatırılır).</p>

		    </div>		    
	    </div>
	</div>
</section>

<section>
	<div class="panel panel-default register-box">
	  <div class="panel-body text-center">
	  	<div class="container">
		<h3>Yukarı çıkmak için zahmet etmeyin. Aşağıdaki alanları doldurarak hemen aramıza katılabilirsiniz...</h3>
			<form  action="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" method="post" class="ajax-form margin-top-20">
				<div class="row">						
					<div class="form-group col-md-2">
						<input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız">
					</div>
					<div class="form-group col-md-2">
						<input type="text" name="lastname" class="form-control tofirstupper" placeholder="Soyadınız">
					</div>					
					<div class="form-gcsrfroup col-md-2">
						<input type="email" name="email" class="form-control" placeholder="E-posta Adresiniz">
					</div>
					<div class="form-group col-md-2">
						<input type="password" name="password" class="form-control" placeholder="Şifreniz">
					</div>
					<div class="form-group col-md-2">
						<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
					</div>															
					<div class="form-group col-md-2" data-name="security-code">
						<img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
					</div>
					<div class="form-group col-md-12">
						<input type="radio" name="member_type" value="1" id="mt7" /> <label for="mt7">Öğrenciyim, özel ders alacağım</label> &nbsp;&nbsp;&nbsp;
						<input type="radio" name="member_type" value="2" id="mt8" /> <label for="mt8">Eğitmenim, özel ders vereceğim</label>
					</div>					
					<div class="col-md-12">
						<button type="submit" class="btn btn-orange js-submit-btn">Ücretsiz üye ol</button>
						<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>
					</div>								
				</div>
				<input type="hidden" name="form" value="ajax_register4" />
				<input type="hidden" name="redir" value="<?=base_url('users/my')?>" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
	  	</div>
	  </div>
	</div>

</section> 	
<div class="container">



    <div class="card position-relative overflow-hidden mb-4">
          <div class="position-absolute bottom-0 left-0 right-0 d-none d-lg-flex flex-row-fluid">
            <span class="svg-icon svg-icon-full flex-row-fluid svg-icon-dark opacity-03">
              <img src="<?=base_url('public/img/home-2.svg')?>" />
            </span>
          </div>

          <div class="position-absolute d-flex top-0 left-0 col-lg-6 opacity-1 opacity-lg-100">
            <span class="svg-icon svg-icon-full flex-row-fluid p-4">
              <img src="<?=base_url('public/img/home-1.svg')?>" />
            </span>
          </div>

          <div class="card-body">
            <div class="row">

              <div class="col-lg-8">
                <h1 class="text-dark font-weight-bolder mb-2">
                  Özel ders
                </h1>
                <p class="lead mb-4">Alanında uzman eğitmenlerden özel ders almak ister misiniz? Netders.com, özel ders almak isteyen öğrencileri, tam aradıkları uzman eğitmenlerle buluşturuyor. Hem de kolay ve ucuz!</p>
                <div class="row">
                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="<?=base_url('public/img/expression-star.svg')?>" />
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Pratik</h3 <p>Gelişmiş arama motoru ile aradığınız eğitmeni kolayca bulur, yarın derse başlayabilirsiniz.</p>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="<?=base_url('public/img/messaging-security.svg')?>" />
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Güvenli</h3 <p>Tüm eğitmenlerin profilleri ayrıntılı olarak incelenir. Güvenerek eğitmenlerle görüşebilirsiniz.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="<?=base_url('public/img/navigation-finance-change.svg')?>">
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Kesintisiz</h3 <p>7/24 eğitmenlerle iletişime geçebilir, dilediğin dersi hemen almaya başlayabilirsiniz.</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="media media-list mb-4">
                      <a href="#" class="width-70 height-70 radius-50 bg-light-blue p-3 text-center mr-2">
                        <img src="<?=base_url('public/img/profile-bonus.svg')?>">
                      </a>
                      <div class="media-body">

                        <h3 class="text-dark font-weight-bolder mr-12">Ücretsiz</h3 <p>Özel ders veren eğitmenlerin neredeyse tamamı ilk dersi ücretsiz veriyor. Bu fırsat kaçmaz.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <h2 class="text-dark font-weight-bolder mb-4">
                  Ücretsiz üye olun
                </h2>
                <form action="<?=site_url('ozel-ders-ilani-vermek-istiyorum')?>" method="post" class="ajax-form" autocomplete="off">
                  <div class="form-group">
                    <input type="text" name="firstname" class="form-control tofirstupper" placeholder="Adınız">
                  </div>
                  <div class="form-group">
                    <input type="text" name="lastname" class="form-control" placeholder="Soyadınız">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="E-posta adresiniz">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Şifreniz">
                  </div>
                  <div class="form-group">
                    <div class="row">

                      <div class="col-xs-12 col-sm-6 col-md-6" data-name="security-code">
                        <div>
                          <img src="<?=base_url('public/img/spin.svg')?>" width="32" height="32" />
                        </div>
                      </div>

                      <div class="col-md-6 mt-3 mt-md-0">
                        <input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
                      </div>
                    </div>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="member_type" value="1">
                    <label class="form-check-label">
                      Öğrenciyim, özel ders alacağım
                    </label>
                  </div>
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="member_type" value="2">
                    <label class="form-check-label">
                      Eğitmenim, özel ders vereceğim
                    </label>
                  </div>

									<button type="submit" class="btn btn-primary js-submit-btn">Üye ol</button>
									<button disabled="disabled" class="btn btn-wide btn-orange d-none js-loader"><img class="align-middle" src="<?=base_url('public/img/spin.svg')?>" width="13" height="13" /> Lütfen bekleyiniz...</button>

									<input type="hidden" name="form" value="ajax_register2" />
									<input type="hidden" name="redir" value="<?=base_url('users/my')?>" />
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								</form>
              </div>
            </div>
          </div>
        </div>

    <div class="card mb-4 box-shadow">
      <div class="card-body">
        <h2 class="text-dark font-weight-bolder mb-4 mt-3">
          Özel ders kategorileri
        </h2>

        <p>Alanında tecrübeli eğitmenlerden özel ders alarak, ihtiyacınız olan eğitime, uygun maliyetlerle ve kolayca sahip olabilirsiniz. <a data-toggle="collapse" href="#ctCollapse" role="button" aria-expanded="false" aria-controls="ctCollapse">Daha fazla...</a></p>

          <div class="collapse" id="ctCollapse">
          <p>Almak istediğiniz eğitimle ilgili aşağıdaki kategorilerden birine tıklayarak, o kategoride özel ders veren eğitmenleri görüntüleyebilirsiniz. Dilerseniz, gelişmiş arama motorunu kullanarak, tam aradığınız eğitmene ulaşmanızı kolaylaştırabilirsiniz. Tercih ettiğiniz eğitmeni seçip, hakkında detaylı bilgi alabilir ve hemen iletişime geçebilirsiniz. Bütçe
          ve ders saatlerinizin karşılıklı olarak uyuşması sonrasında özel ders almaya hemen başlayabilirsiniz.</p>
          </div>

        <div class="owl-6 owl-carousel owl-theme">

          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/ilkogretim-takviye">
              <img src="<?=base_url('public/img/home-icon-ilkogretim.svg')?>">
            </a>
            <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/ilkogretim-takviye">İlköğretim Takviye</a></h5>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/lise-takviye">
              <img src="<?=base_url('public/img/home-icon-lise.svg')?>">
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/lise-takviye">Lise Takviye</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/universite-takviye">
              <img src="<?=base_url('public/img/home-icon-universite.svg')?>">
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/universite-takviye">Üniversite Takviye</a></h5>
            </div>
          </div>

          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/sinav-hazirlik">
              <img src="<?=base_url('public/img/home-icon-sinavhazirlik.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/sinav-hazirlik">Sınav Hazırlık</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/yabanci-dil">
              <img src="<?=base_url('public/img/home-icon-yabancidil.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/yabanci-dil">Yabancı Dil</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/bilgisayar">
              <img src="<?=base_url('public/img/home-icon-bilgisayar.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/bilgisayar">Bilgisayar</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/muzik">
              <img src="<?=base_url('public/img/home-icon-muzik.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/muzik">Müzik</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/spor">
              <img src="<?=base_url('public/img/home-icon-spor.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/spor">Spor</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/sanat">
              <img src="<?=base_url('public/img/home-icon-sanat.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/sanat">Sanat</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/dans">
              <img src="<?=base_url('public/img/home-icon-dans.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/dans">Dans</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/kisisel-gelisim">
              <img src="<?=base_url('public/img/home-icon-kisiselgelisim.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/kisisel-gelisim">Kişisel Gelişim</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/direksiyon">
              <img src="<?=base_url('public/img/home-icon-direksiyon.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/direksiyon">Direksiyon</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/ozel-egitim">
              <img src="<?=base_url('public/img/home-icon-ozelegitim.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/ozel-egitim">Özel Eğitim</a></h5>
            </div>
          </div>
          <div class="item text-center ml-2 mr-2">
            <a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/oyun-ve-hobi">
              <img src="<?=base_url('public/img/home-icon-oyunhobi.svg')?>" />
            </a>
            <div class="caption">
              <h5><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>/oyun-ve-hobi">Oyun / Hobi</a></h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-4 box-shadow">
      <div class="card-body">
        <form method="GET" action="<?=_make_link('search', $this->session->userdata('site_city'))?>" id="search-form">
          <div class="row">
            <div class="col-lg-12">
              <h2 class="text-dark font-weight-bolder mb-4">
                Size en uygun eğitmeni hemen bulun
              </h2>
            </div>

            <div class="col-lg-5 mb-3 mb-lg-0">
              <select name="subject" class="form-control">
                <option>Eğitim seçiniz</option>
                <?foreach($subjects as $subject):?>
                  <option value="<?=$subject->category_id?>"><?=$subject->title?></option>
                <?endforeach;?>
              </select>
            </div>

            <div class="col-lg-5 mb-3 mb-lg-0">
              <select class="form-control">
                <option>Lokasyon seçiniz</option>
                <?foreach($cities as $city):?>
                  <option value="<?=$city->id?>"<?if($this->session->userdata('site_city') == $city->id):?> selected<?endif;?>><?=$city->title?></option>
                <?endforeach;?>
              </select>
            </div>

            <div class="col-lg-2">
              <button type="submit" class="btn btn-primary btn-block"><img class="align-middle" src="<?=base_url('public/img/form-search-white.svg')?>" width="13" height="13" /> Ara</button>
            </div>
          </div>
        </form>
      </div>
    </div>

		<?if(!empty($latest_users)):?>
    <div class="card mb-4 box-shadow">
      <div class="card-body">
        <h2 class="text-dark font-weight-bolder mb-4">
          Aramıza yeni katılan eğitmenler
        </h2>
        <div class="owl-4 owl-carousel owl-theme">
					<?foreach($latest_users as $user):?>
					<div class="item card border mr-2 ml-2">
            <a href="<?=site_url($user->username)?>">
              <img class="card-img-top" src="<?if($user->photo && file_exists(ROOTPATH . $user->photo)):?><?=base_url($user->photo)?><?else:?><?if($user->gender == 'F'):?><?=base_url('public/img/icon-female.png')?><?elseif($user->gender == 'M'):?><?=base_url('public/img/icon-male.png')?><?else:?><?=base_url('public/img/icon-none.png')?><?endif;?><?endif;?>" alt="<?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?>">
            </a>
            <div class="card-body">
              <h5 class="card-title"><a href="<?=site_url($user->username)?>"><?=user_fullname($user->firstname, $user->lastname, $user->privacy_lastname)?></a></h5>
              <div class="mb-2"><img class="align-text-top" src="<?=base_url('public/img/profile-bonus.svg')?>" width="16" height="16"> <?if($user->virtual_price):?><?=$user->virtual_price?><?else:?><?if($user->price_min != $user->price_max):?><?=$user->price_min?> - <?=$user->price_max?><?else:?><?=$user->price_min?><?endif;?> TL<?endif;?></div>
              <div class="mb-2"><img class="align-text-top" src="<?=base_url('public/img/form-date.svg')?>" width="16" height="16"> <?if($user->virtual_age):?><?=$user->virtual_age?> yaşında<?else:?><?=calculate_age($user->birthday)?> yaşında<?endif;?></div>
              <div class="mb-2"><img class="align-text-top" src="<?=base_url('public/img/form-location.svg')?>" width="16" height="16"> <?=$user->city_title?>, <?=$user->town_title?></div>
              <div class="min-height-50">
                <small class="text-muted"><?if(strlen($user->levels) > 60):?><?=mb_substr($user->levels, 0, 60, 'utf-8')?>...<?else:?><?=$user->levels?><?endif;?></small>
              </div>
            </div>
          </div>
					<?endforeach;?>
        </div>
      </div>
    </div>
    <?endif;?>

    <div class="card box-shadow rounded-top">
      <div class="card-body mb-3">
        <h2 class="text-dark font-weight-bolder mb-4">
          Popüler eğitim kategorileri
        </h2>
        <div class="row">
          <div class="col-4">
            <ul class="list-unstyled text-small mb-0">
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/istanbul?keyword=matematik')?>">İstanbul Matematik Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/istanbul?keyword=ingilizce')?>">İstanbul İngilizce Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/istanbul?keyword=fizik')?>">İstanbul Fizik Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/istanbul?keyword=bilgisayar')?>">İstanbul Bilgisayar Özel Ders</a></li>
            </ul>
          </div>

          <div class="col-4">
            <ul class="list-unstyled text-small mb-0">
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/ankara?keyword=matematik')?>">Ankara Matematik Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/ankara?keyword=ingilizce')?>">Ankara İngilizce Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/ankara?keyword=fizik')?>">Ankara Fizik Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/ankara?keyword=bilgisayar')?>">Ankara Bilgisayar Özel Ders</a></li>
            </ul>
          </div>

          <div class="col-4">
            <ul class="list-unstyled text-small mb-0">
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/izmir?keyword=matematik')?>">İzmir Matematik Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/izmir?keyword=ingilizce')?>">İzmir İngilizce Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/izmir?keyword=fizik')?>">İzmir Fizik Özel Ders</a></li>
              <li><a href="<?=site_url('ozel-ders-ilanlari-verenler/izmir?keyword=bilgisayar')?>">İzmir Bilgisayar Özel Ders</a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

  </div>

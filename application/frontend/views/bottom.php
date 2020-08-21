<div class="container">
  <div class="card bg-4 mb-4 box-shadow rounded-bottom">
    <div class="card-body">
  <footer class="pt-4 light text-center">
    <div class="p-2">Copyright © 2013 - <?=date('Y')?> Netders.com</div>

    <div class="d-flex flex-wrap justify-content-center">
      <div class="p-2"><a href="<?=site_url()?>">Ana Sayfa</a></div>
      <div class="p-2"><a href="<?=_make_link('search', $this->session->userdata('site_city'))?>">Eğitmen arayın</a></div>
      <div class="p-2"><a href="<?=_make_link('contents', 112)?>">Nasıl çalışır?</a></div>
      <?if($this->session->userdata('user_id')):?>
      <div class="p-2"><a href="<?=site_url('users/my')?>">Hesabım</a></div>
      <div class="p-2"><a href="<?=site_url('cikis')?>">Çıkış yapın</a></div>
      <?else:?>
      <div class="p-2"><a href="<?=site_url('giris')?>">Giriş yap</a></div>
      <div class="p-2"><a href="<?=site_url('kayit')?>">Ücretsiz üye olun</a></div>
      <?endif;?>
      <div class="p-2"><a href="<?=_make_link('contents_categories', 2)?>">Yardım alın</a></div>
      <div class="p-2"><a href="<?=_make_link('contents', 37)?>">Bize ulaşın</a></div>
    </div>

    <div class="p-2 font-italic"><small>Netders.com internet üzerinden eğitmenler ile öğrencileri buluşturarak online eğitim imkanı sunan bir internet sitesidir. Herhangi bir kurum ile bağı yoktur.<br />Netders.com'a üye olarak <a href="">Kullanım koşulları</a>'nı kabul etmiş sayılırsınız.<br />Netders.com Saati: 23 Mayıs 2020 13:30</small></div>

    <div class="d-flex justify-content-center">
      <div class="p-2"><a href="<?=_make_link('contents', 14)?>">Kullanım Koşulları</a></div>
      <div class="p-2"><a href="<?=_make_link('contents', 38)?>">Gizlilik İlkeleri</a></div>
    </div>
  </footer>
</div>
</div>
</div>

<nav id="main-mmenu">
      <ul>
          <li><a href="/">Ana Sayfa</a></li>
          <li><a href="/work">Eğitmen ara</a></li>
          <li><a href="/work">Nasıl çalışır?</a></li>
          <li><a href="/work">Yardım</a></li>

          <li><span>Hesabım</span>
              <ul>
                <li><a href="#">Kontrol Paneli</a></li>
                <li><a href="#">İletişim Bilgileri</a></li>
                <li><a href="#">Tanıtım Yazıları</a></li>
                <li><a href="#">Tercihler</a></li>
                <li><a href="#">Mesajlar (27)</a></li>
                <li><a href="#">Ders Ücretleri</a></li>
                <li><a href="#">Ders Verilen Bölgeler</a></li>
                <li><a href="#">İndirimler</a></li>
                <li><a href="#">Üyelik İşlemleri</a></li>
                <li><a href="#">Hesap Hareketleri</a></li>
                <li><a href="#">Şifre Değiştir</a></li>
              </ul>
          </li>
          <li><a href="/work">Güvenli çıkış</a></li>
      </ul>
  </nav>

<script type="text/javascript" src="<?=base_url('public/js/jquery-3.5.1.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/bootstrap.bundle.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/mmenu.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/jquery.mask.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/bootstrap-filestyle.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/vendor/chained/chained.remote.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/vendor/form/jquery.form.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/vendor/jgrowl/jquery.jgrowl.min.js')?>"></script>
<?if($this->router->fetch_class() == 'home' || ($this->router->fetch_class() == 'users' && $this->router->fetch_method() == 'register')):?>
<script type="text/javascript" src="<?=base_url('public/js/owl.carousel.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/js/index.js')?>"></script>
<?endif;?>
<?if($this->router->fetch_class() == 'users' && $this->router->fetch_method() == 'index'):?>
<script type="text/javascript" src="<?=base_url('public/js/list.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/vendor/select2/dist/js/select2.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('public/vendor/chained/chained.remote.js')?>"></script>
<?endif;?>
<?if(($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'personal' || $this->router->fetch_method() == 'view') || $this->router->fetch_class() == 'contents')):?>
<script type="text/javascript" src="<?=base_url('public/vendor/intl-tel-input/build/js/intlTelInput.js')?>"></script>
<?endif;?>
<script type="text/javascript" src="<?=base_url('public/js/general.js')?>"></script>

<?if($this->router->fetch_class()== 'users' && ($this->router->fetch_method() == 'prices' || $this->router->fetch_method() == 'locations')):?>
<script type="text/javascript" src="<?=base_url('public/vendor/jquery-tmpl/jquery.tmpl.js')?>"></script>
<?endif;?>

<?if($this->router->fetch_class()== 'users' && $this->router->fetch_method() == 'prices'):?>
<script>get_prices();</script>
<?endif;?>

<?if($this->router->fetch_class()== 'users' && $this->router->fetch_method() == 'locations'):?>
<script>get_locations();</script>
<?endif;?>
</body>
</html>

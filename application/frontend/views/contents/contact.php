<section class="margin-top-30 margin-bottom-30">
<div class="container">
<div class="row">
	<div class="col-md-4">
		<h3>Adres</h3>
		<ul class="clear-list">
			<li><i class="fa fa-home fa-fw"></i> Ali Rıza Gürcan Cad. Eski Çırpıcı Yolu Sok. Merter Meridyen İş Merkezi No: 1 Kat: 6 No:241/D Merter / İstanbul</li>
			<li><i class="fa fa-phone fa-fw"></i> + 90 212 909 45 47</li>
			<li><i class="fa fa-envelope fa-fw"></i> <a href="#"><img src="http://netders.com/public/img/ndm.png" width="120" height="11" /></a></li>
		</ul>
		<hr>
		<h3>Fırsatları kaçırmayın</h3>
		<p>
			Netders.com ile ilgili güncel fırsat ve duyurulardan haberdar olmak için bizi takip edin.
		</p>
		<ul class="clear-list">
			<li><a href="http://fb.com/netderscom" target="_blank"><i class="fa fa-facebook fa-fw"></i> fb.com/netderscom</a></li>
			<li><a href="http://twitter.com/netderscom" target="_blank"><i class="fa fa-twitter fa-fw"></i> twitter.com/netderscom</a></li>
			<li><a href="https://plus.google.com/u/0/117577151266064180719/posts" target="_blank"><i class="fa fa-google-plus fa-fw"></i> Netders.com Google+</a></li>
		</ul>
	</div>
	<div class="col-md-8">
		<div class="panel panel-lightgrey">
			<div class="panel-body padding-30">
				<span class="panel-tape"></span>
				<div class="row">
				<div class="col-md-12">
					<h3>İletişim Formu</h3>
				</div>
			</div>
				<div id="message-contact"></div>
				<form action="<?=site_url('forms')?>" method="post" class="ajax-form">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="firstname" class="form-control" placeholder="Adınız">
	                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="lastname" class="form-control" placeholder="Soyadınız">
	                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<div class="input-group">
								<input type="email" name="email" class="form-control" placeholder="E-posta adresiniz">
	                            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="phone" class="form-control" placeholder="Telefon numaranız">
	                            <div class="input-group-addon"><i class="fa fa-phone"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<textarea name="message" rows="5"  class="form-control" placeholder="Mesajınız"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group">
								<input type="text" name="security_code" class="form-control" placeholder="Güvenlik kodu">
	                            <div class="input-group-addon"><i class="fa fa-shield"></i></div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<img src="<?=base_url('captcha/'.generate_captcha('ajax_contact'))?>" width="100%" height="32" />
						</div>
					</div>					
					
					<div class="col-md-12">
						<button type="submit" class="btn btn-orange js-submit-btn">Gönder</button>
						<button disabled="disabled" class="btn btn-orange hide js-loader"><i class="fa fa-spinner fa-pulse fa-fw"></i> Lütfen bekleyiniz...</button>					
					</div>					
				</div>
				<input type="hidden" name="form" value="ajax_contact" />
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
			</form>
			</div>
		</div>
	</div>
</div>
</div>
</section>

<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=cP0vu1SatRTPIqmm1U-bPL4xokGVTP8P&amp;width=100%&amp;height=500&amp;lang=tr_TR&amp;sourceType=constructor&amp;scroll=true"></script>

<section class="garibbean-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
			<form action="http://maps.google.com/maps" method="get" target="_blank">
				<div class="input-group">
					<input type="text" name="saddr" placeholder="Yola çıkacağınız adresi yazınız" class="form-control medium-input" />
					<input type="hidden" name="daddr" value="Merter Meridyen İş Merkezi Güngören / İstanbul"/>
					<span class="input-group-btn">
						<button class="form-control medium-button btn-lightred" type="submit" value="Yol tarifi al">Yol Tarifi Al</button>
					</span>
				</div>
			</form>
			</div>
		</div>
	</div>
</section>
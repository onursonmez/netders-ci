<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('usersmodel');
		$this->load->model('requestsmodel');
		$this->load->model('locationsmodel');
	}
	
	public function requireds(){
		$this->db
			->select('users.id')
			->from('users')
			->where('birthday !=', '')
			->where('gender !=', '')
			->where('mobile !=', '')
			->where('city !=', '')
			->where('town !=', '')
			->where('text_title !=', '')
			->where('text_long !=', '')
			->where('prices !=', '')
			->where('locations !=', '')
			->get()->result();	
	}
	
	public function adwordsold()
	{
		echo "<table>";
		
		for($i=7;$i<20;$i++){
		
			$main_category = $this->db->from('contents_categories')->where('id', $i)->get()->row();
			$categories = $this->db->from('contents_categories')->where('parent_id', $i)->where_not_in('id', array(95,133,136,141,144,145,146,152,153,163,177,181,313,314,553,554,598,599,606,607))->not_like('title', 'Mühendisliği', 'before')->get()->result();
			
			foreach($categories as $category)
			{
				$keyword = txtLower($category->title);
				$keyword = str_replace("müzik prodüksiyon - ","", $keyword);
				$keyword = str_replace("yetenek sınavları - ","", $keyword);
				$keyword = str_replace(" ve ahlak bilgisi","", $keyword);
				$keyword = str_replace(" ve ahlak bilgisi","", $keyword);
				$keyword = str_replace(" ve "," ", $keyword);
				$keyword = str_replace(" ve "," ", $keyword);
				$keyword = str_replace("-"," ", $keyword);
				$keyword = str_replace(" on rails","", $keyword);
				$keyword = str_replace("dil konuşma bozuklukları","konuşma bozuklukları", $keyword);
				$keyword = str_replace("coreldraw","corel", $keyword);
				$keyword = str_replace("osmanlı türkçesi","osmanlıca", $keyword);
				
				if(strstr($keyword, " ") == true){
					$keywords = explode(" ", $keyword);
					$keyword_array = array();
					foreach($keywords as $key){
						$keyword_array[] = "+$key";
					}
					$keyword = implode(" ", $keyword_array);
				} else {
					$keyword = "+$keyword";
				}
				
				$keyword = str_replace("+mobil +uygulama +geliştirme","+mobil +uygulama", $keyword);
				$keyword = str_replace("+ıelts","+ielts", $keyword);
				$keyword = str_replace("+petrol +doğal +gaz","petrol doğal gaz", $keyword);
				$keyword = str_replace("+film +sinema","+sinema", $keyword);
				$keyword = str_replace("+adobe ","", $keyword);
				$keyword = str_replace("+ms ","", $keyword);
				$keyword = str_replace("+.net","+net", $keyword);
				$keyword = str_replace("+tcp/ıp","+tcp", $keyword);
				$keyword = str_replace("ındesign","indesign", $keyword);
				$keyword = str_replace("ıllustrator","illustrator", $keyword);
				$keyword = str_replace("arcgıs","arcgis", $keyword);
				$keyword = str_replace("+dikiş +nakış +terzilik","dikiş nakış terzilik", $keyword);
				$keyword = str_replace("+otomobil +özel +ders","+direksiyon +özel +ders", $keyword);
				
				$lower_title = txtLower($category->title);
				$lower_title = str_replace("adobe ", "", $lower_title);
				$lower_title = str_replace("ındesign","indesign", $lower_title);
				$lower_title = str_replace("ıllustrator","illustrator", $lower_title);
				$lower_title = str_replace("arcgıs","arcgis", $lower_title);	
				$lower_title = str_replace("tcp/ıp","tcp/ip", $lower_title);
				$lower_title = str_replace("müzik prodüksiyon - ","", $lower_title);
				$lower_title = str_replace("din kültürü ve ahlak bilgisi","din kültürü", $lower_title);
				$lower_title = str_replace("ıelts","ielts", $lower_title);
				$lower_title = str_replace("yetenek sınavları - ","", $lower_title);
				$lower_title = str_replace("yetenek sınavları - ","", $lower_title);
				$lower_title = str_replace("batı dilleri ve edebiyatı","batı dilleri", $lower_title);
				$lower_title = str_replace("mühendisliği","müh.", $lower_title);
				$lower_title = str_replace("yardımcılığı","yard.", $lower_title);
				$lower_title = str_replace("endüstri ürünleri tasarımı","end. ürünleri tasarımı", $lower_title);
				$lower_title = str_replace("sahne dekorları ve kostümü","sahne dekorları", $lower_title);
				$lower_title = str_replace(" ve "," ", $lower_title);
				$lower_title = str_replace("uluslararası","ulusl.", $lower_title);
				$lower_title = str_replace("araştırma teknikleri","araş. teknikleri", $lower_title);
				$lower_title = str_replace("telekomunikasyon müh.","telekomun. müh.", $lower_title);
				$lower_title = str_replace("tıbbi sistemler müh.","tıbbi sis. müh.", $lower_title);
				$lower_title = str_replace("mühendislik","müh.", $lower_title);
				$lower_title = str_replace("tekstil moda tasarımı","tekstil moda tasarım", $lower_title);
				$lower_title = str_replace("mobil uygulama geliştirme","mobil uyg. geliştirme", $lower_title);
				$lower_title = str_replace("temel bilgisayar bilgisi","temel bilg. bilgisi", $lower_title);
				$lower_title = str_replace("dil konuşma bozuklukları","konuşma bozuklukları", $lower_title);
				$lower_title = str_replace("bilgisayarlı muhasebe","bilg. muhasebe", $lower_title);
				$lower_title = str_replace("coreldraw","corel", $lower_title);
				
				$word_upper_title = txtWordUpper($category->title);
				$word_upper_title = str_replace("Adobe ", "", $word_upper_title);
				$word_upper_title = str_replace("Tcp/ıp","Tcp/ip", $word_upper_title);
				$word_upper_title = str_replace("Müzik Prodüksiyon - ","", $word_upper_title);
				$word_upper_title = str_replace("Din Kültürü Ve Ahlak Bilgisi","Din Kültürü", $word_upper_title);
				$word_upper_title = str_replace("Yetenek Sınavları - ","", $word_upper_title);
				$word_upper_title = str_replace("İos","iOS", $word_upper_title);
				$word_upper_title = str_replace("Batı Dilleri Ve Edebiyatı","Batı Dilleri", $word_upper_title);
				$word_upper_title = str_replace("Mühendisliği","Müh.", $word_upper_title);
				$word_upper_title = str_replace("Yardımcılığı","Yard.", $word_upper_title);
				$word_upper_title = str_replace("Endüstri Ürünleri Tasarımı","End. Ürünleri Tasarımı", $word_upper_title);
				$word_upper_title = str_replace("Sahne Dekorları Ve Kostümü","Sahne Dekorları", $word_upper_title);
				$word_upper_title = str_replace(" Ve "," ", $word_upper_title);
				$word_upper_title = str_replace("Uluslararası","Ulusl.", $word_upper_title);
				$word_upper_title = str_replace("Araştırma Teknikleri","Araş. Teknikleri", $word_upper_title);
				$word_upper_title = str_replace("Telekomunikasyon Müh.","Telekomun. Müh.", $word_upper_title);
				$word_upper_title = str_replace("Tıbbi Sistemler Müh.","Tıbbi Sis. Müh.", $word_upper_title);
				$word_upper_title = str_replace("Mühendislik","Müh.", $word_upper_title);
				$word_upper_title = str_replace("Tekstil Moda Tasarımı","Tekstil Moda Tasarım", $word_upper_title);
				$word_upper_title = str_replace("Mobil Uygulama Geliştirme","Mobil Geliştirme", $word_upper_title);
				$word_upper_title = str_replace("Temel Bilgisayar Bilgisi","Bilg. Bilgisi", $word_upper_title);
				$word_upper_title = str_replace("Dil Konuşma Bozuklukları","Konuşma Bozuklukları", $word_upper_title);
				$word_upper_title = str_replace("Bilgisayarlı Muhasebe","Bilg Muhasebe", $word_upper_title);
				$word_upper_title = str_replace("Bilişim Sistemleri","Bilişim Sis.", $word_upper_title);
				$word_upper_title = str_replace("Coreldraw","Corel", $word_upper_title);
				$word_upper_title = str_replace("İşletim Sistemleri","İşletim Sis.", $word_upper_title);
				$word_upper_title = str_replace("Ms ","", $word_upper_title);
				$word_upper_title = str_replace("Nx Unigraphics","Unigraphics", $word_upper_title);
				$word_upper_title = str_replace("Uygulama Geliştirme","Uyg. Gelştrme", $word_upper_title);
				$word_upper_title = str_replace("Web Programlama","Web Prog.", $word_upper_title);
				$word_upper_title = str_replace("Bilgi Teknolojisi","Bilgi Tekn.", $word_upper_title);
				$word_upper_title = str_replace("Sahne Dekorları","Sahne Dek.", $word_upper_title);
				
				$word_upper_long_title = $word_upper_title;
				$word_upper_long_title = str_replace("İletişim Sunum","İletişim Sun.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Sosyal Bilgiler","Sos. Bilgiler", $word_upper_long_title);
				$word_upper_long_title = str_replace("Teknoloji Tasarım","Tekn. Tasarım", $word_upper_long_title);
				$word_upper_long_title = str_replace("Bilgi Teknolojisi","Bilgi Tekn.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Halkla İlişkiler","Halkla İlişk.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Kariyer Planlama","Kariyer Plan.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Mental Aritmetik","Mental Aritm.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Proje Yönetimi","Proje Yön.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Rezüme Hazırlama","Rezüme Haz.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Stratejik Planlama","Stratejik P.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Zaman Yönetimi","Zaman Yön.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Alman Edebiyatı","Alman Edeb.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Analitik Geometri","Analitik Geo.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Araş. Teknikleri","Araş. Tekn.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Bilgi Teknolojisi","Bilgi Tekn.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Diksiyon Hitabet","Diks. Hitabet", $word_upper_long_title);
				$word_upper_long_title = str_replace("Fransız Edebiyatı","Fransız Edeb.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Görsel Sanatlar","Görsel Sanat", $word_upper_long_title);
				$word_upper_long_title = str_replace("Grafik Tasarım","Grafik Tsrm", $word_upper_long_title);
				$word_upper_long_title = str_replace("İngiliz Edebiyatı","İngiliz Edeb.", $word_upper_long_title);
				$word_upper_long_title = str_replace("İtalyan Edebiyatı","İtalyan Edeb.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Osmanlı Türkçesi","Osmanlıca", $word_upper_long_title);
				$word_upper_long_title = str_replace("Proje Hazırlama","Proje Haz.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Türk Edebiyatı","Türk Edeb.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Ulusl. İlişkiler","Ulusl. İlişk.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Yönetim Bilimi","Yönetim Bilim", $word_upper_long_title);
				$word_upper_long_title = str_replace("Müzik Teknolojileri","Müzik Tekn.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Nefesli Çalgılar","Nefesli Çalg.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Şarkı Besteleme","Şarkı Beste", $word_upper_long_title);
				$word_upper_long_title = str_replace("Telli Çalgılar","Telli Çalgı", $word_upper_long_title);
				$word_upper_long_title = str_replace("Tuşlu Çalgılar","Tuşlu Çalgı", $word_upper_long_title);
				$word_upper_long_title = str_replace("Vurmalı Çalgılar","Vurmalı Çalgı", $word_upper_long_title);
				$word_upper_long_title = str_replace("Konuşma Bozuklukları","Konuşma Bzk.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Görme Engelliler","Görme Eng.", $word_upper_long_title);
				$word_upper_long_title = str_replace("İşitme Engelliler","İşitme Eng.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Ortopedik Engelliler","Ortopedik Eng", $word_upper_long_title);
				$word_upper_long_title = str_replace("Zihinsel Engelliler","Zihinsel Eng.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Dikiş Nakış Terzilik","Dikiş Nakış", $word_upper_long_title);
				$word_upper_long_title = str_replace("Sayıştay Eleme","Sayıştay E.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Motor Sporları","Motor Sporu", $word_upper_long_title);
				$word_upper_long_title = str_replace("Uzak Doğu Sporları","Uzak D. Sporu", $word_upper_long_title);
				$word_upper_long_title = str_replace("Vücut Geliştirme","Vücut Geliş.", $word_upper_long_title);
				$word_upper_long_title = str_replace("Yamaç Paraşütü","Paraşütçü", $word_upper_long_title);
				$word_upper_long_title = str_replace("Güzel Sanatlar","Güzel Sanat", $word_upper_long_title);
				$word_upper_long_title = str_replace("Türk Dili Edebiyatı","Türk Dili", $word_upper_long_title);
				$word_upper_long_title = str_replace("Endonezya Dili","Endonezya Dil", $word_upper_long_title);
				$word_upper_long_title = str_replace("Kuzey İskoç Dili","Kuzey İskoçça", $word_upper_long_title);
				$word_upper_long_title = str_replace("Kuzey İskoç Dili","Kuzey İskoçça", $word_upper_long_title);
				
				$url1_title = txtLower(str_replace('.', '', $category->title));
				$url1_title = txtLower(str_replace(' ', '', $url1_title));
				$url1_title = str_replace("adobe", "", $url1_title);
				$url1_title = str_replace("ındesign","indesign", $url1_title);
				$url1_title = str_replace("ıllustrator","illustrator", $url1_title);
				$url1_title = str_replace("arcgıs","arcgis", $url1_title);
				$url1_title = str_replace("tcp/ıp","tcpip", $url1_title);				
				$url1_title = str_replace("müzikprodüksiyon-","", $url1_title);
				$url1_title = str_replace("dinkültürüveahlakbilgisi","dinkültürü", $url1_title);
				$url1_title = str_replace("petrolvedoğalgazmühendisliği","petroldoğalgazmüh", $url1_title);
				$url1_title = str_replace("sistemvekontrolmühendisliği","sistemkontrolmüh", $url1_title);
				$url1_title = str_replace("ve","", $url1_title);
				$url1_title = str_replace("telekomunikasyonmühendisliği","telekommüh", $url1_title);
				$url1_title = str_replace("mühendisliği","müh", $url1_title);
				$url1_title = str_replace("ıelts","ielts", $url1_title);
				$url1_title = str_replace("yeteneksınavları-","", $url1_title);
				$url1_title = str_replace("batıdilleriedebiyatı","batıdilleri", $url1_title);
				$url1_title = str_replace("yardımcılığı","yard", $url1_title);
				$url1_title = str_replace("endüstriürünleritasarımı","endürünlertasarım", $url1_title);
				$url1_title = str_replace("sahnedekorlarıkostümü","sahnedekorları", $url1_title);
				$url1_title = str_replace("uluslararası","ulusl", $url1_title);
				$url1_title = str_replace("araştırmateknikleri","araşteknikleri", $url1_title);
				$url1_title = str_replace("tıbbisistemlermüh","tıbbisismüh", $url1_title);
				$url1_title = str_replace("mühendislik","müh", $url1_title);
				$url1_title = str_replace("tekstilmodatasarımı","tekstilmodatasarım", $url1_title);
				$url1_title = str_replace("mobiluygulamageliştirme","mobilgeliştirme", $url1_title);
				$url1_title = str_replace("temelbilgisayarbilgisi","tbilgbilgisi", $url1_title);
				$url1_title = str_replace("dilkonuşmabozuklukları","konuşmabozuklukları", $url1_title);
				$url1_title = str_replace("bilgisayarlımuhasebe","bilgmuhasebe", $url1_title);
				$url1_title = str_replace("bilişimsistemleri","bilişimsis", $url1_title);
				$url1_title = str_replace("coreldraw","corel", $url1_title);
				$url1_title = str_replace("işletimsistemleri","işletimsis", $url1_title);
				$url1_title = str_replace("uygulamageliştirme","uyggeliştirme", $url1_title);
				$url1_title = str_replace("bilgiteknolojisi","bilgitekn", $url1_title);
				$url1_title = str_replace("analitikgeometri","analitikgeo", $url1_title);
				$url1_title = str_replace("bilgiteknolojisi","bilgitekn", $url1_title);
				$url1_title = str_replace("fransızedebiyatı","fransızedeb", $url1_title);
				$url1_title = str_replace("italyanedebiyatı","italyanedeb", $url1_title);
				$url1_title = str_replace("müzikteknolojileri","müziktekn", $url1_title);
				$url1_title = str_replace("konuşmabozuklukları","konuşmabzk", $url1_title);
				$url1_title = str_replace("işitmeengelliler","işitmeeng", $url1_title);
				$url1_title = str_replace("ortopedikengelliler","ortopedikeng", $url1_title);
				$url1_title = str_replace("zihinselengelliler","zihinseleng", $url1_title);
				$url1_title = str_replace("dikişnakışterzilik","dikişnakış", $url1_title);
				$url1_title = str_replace("uzakdoğusporları","uzakdoğusporu", $url1_title);
				$url1_title = str_replace("türkdiliedebiyatı","türkdili", $url1_title);
				$url1_title = str_replace("ingilizedebiyatı","ingilizedebiyat", $url1_title);
				$url1_title = str_replace("stratejikplanlama","stratejikplan", $url1_title);
				$url1_title = str_replace("teknolojitasarım","teknolojitasarm", $url1_title);
				
				echo "
				<tr>
					<td>689-219-8754</td>
					<td>İstanbul Özel Ders</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>0.00</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$main_category->title." > ".$category->title."</td>
					<td>None</td>
					<td>Conservative</td>
					<td>Default</td>
					<td>Interests and remarketing</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>689-219-8754</td>
					<td>İstanbul Özel Ders</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$main_category->title." > ".$category->title."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$keyword." +özel +ders</td>
					<td>Broad</td>
					<td>0.00</td>
					<td>0.00</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>	
				<tr>
					<td>689-219-8754</td>
					<td>İstanbul Özel Ders</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$main_category->title." > ".$category->title."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>https://www.netders.com/ozel-ders-ilanlari-verenler/samsun/".$category->seo_link."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Uzman eğitmenlerden uygun fiyatlarla ".$lower_title." özel dersi alın.</td>
					<td>".$word_upper_title." Özel Ders</td>
					<td>".$word_upper_long_title." Uzman Eğitmenler</td>
					<td>".$url1_title."</td>
					<td>özelders</td>
				</tr>";
			}
		
		}
		
		
		echo "</table>";
		/*		
		$messages = $this->db->select('COUNT(from_uid) from_count, to_uid, COUNT(id) total')->from('messages')->having('from_count', 1)->group_by('to_uid')->get()->result();
		foreach($messages as $message){
			$this->db->where('id', $message->to_uid)->update('users', array('message_count' => $message->total));
		}
		*/

		
		/*
		$users = $this->db->from('users')->where('email_request !=', '')->where('ugroup', 3)->where('status', 'A')->get()->result();
		foreach($users as $user)
		{
			echo txtFirstUpper($user->firstname).",".txtFirstUpper($user->lastname).",".$user->activation_code.",".$user->email."\n";
		}

		
		$array = json_decode('[{"ID":0,"ParentID":0,"ShortName":null,"Name":"Tüm Konular","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":648,"ParentID":0,"ShortName":null,"Name":"Bale","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":537,"ParentID":0,"ShortName":null,"Name":"Bchata","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":538,"ParentID":0,"ShortName":null,"Name":"Break Dans","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":539,"ParentID":0,"ShortName":null,"Name":"Bolero","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":540,"ParentID":0,"ShortName":null,"Name":"Cha Cha","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":541,"ParentID":0,"ShortName":null,"Name":"Foxtrot","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":542,"ParentID":0,"ShortName":null,"Name":"Halk Oyunları","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":543,"ParentID":0,"ShortName":null,"Name":"Jive","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":544,"ParentID":0,"ShortName":null,"Name":"Koreografi","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":545,"ParentID":0,"ShortName":null,"Name":"Mambo","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":546,"ParentID":0,"ShortName":null,"Name":"Merenge","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":547,"ParentID":0,"ShortName":null,"Name":"Modern Dans","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":548,"ParentID":0,"ShortName":null,"Name":"Oryantal","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":549,"ParentID":0,"ShortName":null,"Name":"Paso Doble","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":550,"ParentID":0,"ShortName":null,"Name":"Quickstep","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":552,"ParentID":0,"ShortName":null,"Name":"Rumba","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":553,"ParentID":0,"ShortName":null,"Name":"Salsa","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":554,"ParentID":0,"ShortName":null,"Name":"Samba","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":555,"ParentID":0,"ShortName":null,"Name":"Tango","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":556,"ParentID":0,"ShortName":null,"Name":"Waltz","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0}]');
		
		foreach($array as $item){
			$q = $this->db->from('contents_categories')->where('parent_id', 16)->where('title', trim($item->Name))->count_all_results();
			if(!$q)
			echo $item->Name.PHP_EOL;
		}
		*/		
	}
	
	public function adwords()
	{
		echo "<table border=1>";
		
		$city = $this->locationsmodel->get_location('locations_cities', ['id' => 68]);
		$category_count = array();
		
		
		for($i=7;$i<20;$i++)
		{
			if($i == 17 || $i == 19){
				continue;
			}
			//Ana kategori
			$categories = $this->db->from('contents_categories')->where('parent_id', $i)->get()->result();
			
			//Virtual
			
			foreach($categories as $category)
			{
				$total = $this->db->from('users')->where('virtual', 'Y')->where('city', $city->id)->where("FIND_IN_SET(".$category->category_id.", virtual_levels)", NULL, FALSE)->count_all_results();
				if($total > 0){
					$category_count[$category->category_id] = $total;
				}
			}

			
			//Real
			foreach($categories as $category)
			{
				$total = $this->db
					->select('users.id')->distinct()
					->from('users')
					->join('prices', 'prices.uid=users.id')
					->join('locations', 'locations.uid=users.id')
					->where('prices.level_id', $category->category_id)
					->where('locations.city', $city->id)
					->count_all_results();
				if($total > 0){
					if(in_array($category->category_id, array_keys($category_count))){
						$category_count[$category->category_id] = $category_count[$category->category_id] + $total;
					} else {
						$category_count[$category->category_id] = $total;
					}
				}
			}
		}
		
		
		//if(empty($category_count))
		if(!empty($category_count))
		{
			$category_ids = array();
			
			foreach($category_count as $id => $value){
				if($value >= 3)
				$category_ids[] = $id;
			}
			
			//$category_ids = array(26,29,31,33,35,39,41,579,22,24,30,34,36,40,44,52,57,59,66,68,76,77,79,50,75,190,117,128,132,137,139,154,158,164,166,234,276,291,543,553);
			
			$categories = $this->db
				->from('contents_categories')
				->where_in('category_id', $category_ids)
				->where('title !=', 'JANA')
				->where('title !=', 'Yabancı Dil')
				->where('title !=', 'Ticaret')
				->where('title !=', 'Temel Bilgisayar Bilgisi')
				->where('title !=', 'Teknoloji ve Tasarım')
				->where('title !=', 'Sosyal Bilgiler')
				->where('title !=', 'İletişim ve Sunum')
				->where('title !=', 'Siyaset')
				->where('title !=', 'Mühendislik Tamamlama')
				->where('title !=', 'Hayat Bilgisi')
				->where('title !=', 'Görsel Sanatlar')
				->where('title !=', 'Futbol')
				->where('title !=', 'Din Kültürü ve Ahlak Bilgisi')
				->where('title !=', 'Dil ve Anlatım')
				->where('title !=', 'Diksiyon ve Hitabet')
				->where('title !=', 'Çeviri')
				->where('title !=', 'Bisiklet')
				->where('title !=', 'Basketbol')
				->where('title !=', 'Salsa')
				->where('title !=', 'Biyokimya')
				->where('title !=', 'C')
				->where('title !=', 'Bilgi Teknolojisi')
				->where('title !=', 'Analitik Geometri')
				->where('title !=', 'Uluslararası İlişkiler')
				->where('title !=', 'Vatandaşlık')
				->where('title !=', 'Batı Dilleri ve Edebiyatı')
				->where('title !=', 'PYBS')
				->where('title !=', 'PMYO')
				->where('title !=', 'SAT')
				->where('title !=', 'YÖS')
				->where('title !=', 'Grafik Tasarım')
				->where('title !=', 'Türk Edebiyatı')
				->where('title !=', 'Yönetim Bilimi')
				->where('title !=', 'Astronomi')
				->where('title !=', 'Bilgisayar Mühendisliği')
				->where('title !=', 'Bilgisayarlı Muhasebe')
				->where('title !=', 'Bilişim Sistemleri')
				->where('title !=', 'Masa Tenisi')
				->where('title !=', 'C++')
				->where('title !=', 'C#')
				->where('title !=', 'CAD')
				->where('title !=', 'Catia')
				->where('title !=', 'Donanım')
				->where('title !=', 'PTE General')
				->where('title !=', 'Elektrik Mühendisliği')
				->where('title !=', 'Elektronik Mühendisliği')
				->where('title !=', 'Endüstri Mühendisliği')
				->where('title !=', 'Endüstri Ürünleri Tasarımı')
				->where('title !=', 'Halk Oyunları')
				->where('title !=', 'HTML')
				->where('title !=', 'İç Mimarlık')
				->where('title !=', 'İç Tasarım')
				->where('title !=', 'İnşaat Mühendisliği')
				->where('title !=', 'İnternet')
				->where('title !=', 'İşletim Sistemleri')
				->where('title !=', 'İşletme Mühendisliği')
				->where('title !=', 'J2EE')
				->where('title !=', 'Javascript')
				->where('title !=', 'JQuery')
				->where('title !=', 'Kimya Mühendisliği')
				->where('title !=', 'Linux')
				->where('title !=', 'Makina Mühendisliği')
				->where('title !=', 'Mobil Uygulama Geliştirme')
				->where('title !=', 'MS .NET')
				->where('title !=', 'MS Project')
				->where('title !=', 'MS Visual Basic')
				->where('title !=', 'MS Windows')
				->where('title !=', 'MS Outlook')
				->where('title !=', 'Adobe Illustrator')
				->where('title !=', 'Adobe Dreamweaver')
				->where('title !=', 'Adobe InDesign')
				->where('title !=', 'Adobe Flash')
				->where('title !=', 'Turizm')
				->where('title !=', 'Yüzme')
				->where('title !=', 'CorelDraw')
				->where('title !=', 'GRE')
				->where('title !=', 'MCAT')
				->where('title !=', 'GMAT')
				->where('title !=', 'Girişimcilik')
				->where('title !=', 'Müzik Tarihi')
				->where('title !=', 'Müzik Teorisi')
				->where('title !=', 'Müzik Teknolojileri')
				->where('title !=', 'Ses Üretimi')
				->where('title !=', 'Uzak Doğu Sporları')
				->where('title !=', 'Vücut geliştirme')
				->where('title !=', 'Vurmalı Çalgılar')
				->where('title !=', 'PTE Academic')
				->where('title !=', 'Müzik Yapımı')
				->where('title !=', 'Network')
				->where('title !=', 'NX Unigraphics')
				->where('title !=', 'Opera')
				->where('title !=', 'Otomotiv Mühendisliği')
				->where('title !=', 'Programlama')
				->where('title !=', 'Proje Hazırlama')
				->where('title !=', 'Sistem ve Kontrol Mühendisliği')
				->where('title !=', 'SPK')
				->where('title !=', 'SPSS')
				->where('title !=', 'TIPDİL')
				->where('title !=', 'Trafik')
				->where('title !=', 'Düşünme')
				->where('title !=', 'TCP/IP')
				->where('title !=', 'Telekomunikasyon Mühendisliği')
				->where('title !=', 'Uçak Mühendisliği')
				->where('title !=', 'Uygulama Geliştirme')
				->where('title !=', 'Veritabanları')
				->where('title !=', 'Web Programlama')
				->where('title !=', 'Web Tasarımı')
				->where('title !=', 'Yapay Zeka')
				->where('title !=', 'Yazılım Mühendisliği')
				->where('title !=', 'Yetenek Sınavları - Müzik')
				->where('title !=', 'Yoga')
				->where('title !=', 'ACT')
				->where('title !=', 'Pilates')
				->where('title !=', 'PTE Young Learners')
				->where('title !=', 'Tıp')
				->where('title !=', 'Modern Dans')
				->group_by('title')
				->get()->result();
			
			foreach($categories as $category)
			{
				
				$title = str_replace("Autodesk ", "", $category->title);
				$title = str_replace("Adobe ", "", $title);
				$title = str_replace("Otomobil", "Direksiyon", $title);
				$title = str_replace("Okuma-Yazma", "Okuma Yazma", $title);
				$title = str_replace("MS ", "", $title);
				$title = str_replace("Türk Dili ve Edebiyatı", "Türk Dili", $title);

				$keyword = $title;
				$keyword = str_replace(" ve ", " ", $keyword);
				
				if(strstr($keyword, " ") == true){
					$keywords = explode(" ", $keyword);
					$keyword_array = array();
					foreach($keywords as $key){
						$keyword_array[] = "+$key";
					}
					$keyword = implode(" ", $keyword_array);
				} else {
					$keyword = "+$keyword";
				}
				
				$title1 = "$title Özel Ders";
				
				if($title == 'İngiliz Edebiyatı' || $title == 'Alman Edebiyatı' || $title == 'Fen ve Teknoloji' || $title == 'Güzel Sanatlar' || $title == 'Osmanlı Türkçesi' || $title == 'Sanat Tarihi' || $title == 'Şarkı Besteleme'){
					$title2 = "$title Eğitmenleri";	
				} elseif($title == 'Bilgisayar' || $title == 'Direksiyon' || $title == 'Ekonometri' || $title == 'Fen Bilgisi' || $title == 'Fen Bilimleri' || $title == 'Fotoğrafcılık' || $title == 'İspanyolca' || $title == 'İstatistik' || $title == 'Kara Kalem' || $title == 'Kompozisyon' || $title == 'Koreografi' || $title == 'Masa Tenisi' || $title == 'Motosiklet' || $title == 'Okuma Yazma' || $title == 'PowerPoint' || $title == 'Rhinoceros 3D' || $title == 'SolidWorks'){
					$title2 = "$title Uzman Eğitmenler";						
				} elseif($title == 'Grafik Tasarım'){
					$title2 = "$title Uzmanları";											
				} else {
					$title2 = "$title Tecrübeli Eğitmenler";
				}
				
				

				if($title == 'İngiliz Edebiyatı'){
					$title3 = "ingiliz";	
				} else {
					$title3 = txtLower(str_replace(' ', '', $title));
				}
				
				if($title == 'İngiliz Edebiyatı'){
					$title4 = "edebiyatı";	
				} else {
					$title4 = "özelders";
				}				
								
				echo "
				<tr>
					<td>689-219-8754</td>
					<td>".$city->title." Özel Ders</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>0.00</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$title."</td>
					<td>None</td>
					<td>Conservative</td>
					<td>Default</td>
					<td>Interests and remarketing</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>689-219-8754</td>
					<td>".$city->title." Özel Ders</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$title."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".txtLower($keyword)." +özel +ders</td>
					<td>Broad</td>
					<td>0.00</td>
					<td>0.00</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>	
				<tr>
					<td>689-219-8754</td>
					<td>".$city->title." Özel Ders</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>".$title."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>https://www.netders.com/ozel-ders-ilanlari-verenler/".$city->seo_link."/?keyword=".txtLower($title)."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Uzmanından ".txtLower($title)." özel dersi. En iyi fiyat garantisi!</td>
					<td>".$title1."</td>
					<td>".$title2."</td>
					<td>".$title3."</td>
					<td>".$title4."</td>
				</tr>";
			}
		}
		
		
		echo "</table>";
		/*		
		$messages = $this->db->select('COUNT(from_uid) from_count, to_uid, COUNT(id) total')->from('messages')->having('from_count', 1)->group_by('to_uid')->get()->result();
		foreach($messages as $message){
			$this->db->where('id', $message->to_uid)->update('users', array('message_count' => $message->total));
		}
		*/

		
		/*
		$users = $this->db->from('users')->where('email_request !=', '')->where('ugroup', 3)->where('status', 'A')->get()->result();
		foreach($users as $user)
		{
			echo txtFirstUpper($user->firstname).",".txtFirstUpper($user->lastname).",".$user->activation_code.",".$user->email."\n";
		}

		
		$array = json_decode('[{"ID":0,"ParentID":0,"ShortName":null,"Name":"Tüm Konular","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":648,"ParentID":0,"ShortName":null,"Name":"Bale","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":537,"ParentID":0,"ShortName":null,"Name":"Bchata","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":538,"ParentID":0,"ShortName":null,"Name":"Break Dans","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":539,"ParentID":0,"ShortName":null,"Name":"Bolero","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":540,"ParentID":0,"ShortName":null,"Name":"Cha Cha","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":541,"ParentID":0,"ShortName":null,"Name":"Foxtrot","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":542,"ParentID":0,"ShortName":null,"Name":"Halk Oyunları","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":543,"ParentID":0,"ShortName":null,"Name":"Jive","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":544,"ParentID":0,"ShortName":null,"Name":"Koreografi","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":545,"ParentID":0,"ShortName":null,"Name":"Mambo","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":546,"ParentID":0,"ShortName":null,"Name":"Merenge","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":547,"ParentID":0,"ShortName":null,"Name":"Modern Dans","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":548,"ParentID":0,"ShortName":null,"Name":"Oryantal","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":549,"ParentID":0,"ShortName":null,"Name":"Paso Doble","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":550,"ParentID":0,"ShortName":null,"Name":"Quickstep","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":552,"ParentID":0,"ShortName":null,"Name":"Rumba","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":553,"ParentID":0,"ShortName":null,"Name":"Salsa","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":554,"ParentID":0,"ShortName":null,"Name":"Samba","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":555,"ParentID":0,"ShortName":null,"Name":"Tango","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0},{"ID":556,"ParentID":0,"ShortName":null,"Name":"Waltz","Description":null,"DirectoryName":null,"Seq":0,"AlwaysSelected":0}]');
		
		foreach($array as $item){
			$q = $this->db->from('contents_categories')->where('parent_id', 16)->where('title', trim($item->Name))->count_all_results();
			if(!$q)
			echo $item->Name.PHP_EOL;
		}
		*/		
	}	
		
	public function index()
	{
		check_perm('users_overview');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/users'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
				
				if($this->input->get_post('sSearch'))
				{
					$search_term = trim($this->input->get_post('sSearch', true));
					$this->db->where("CONCAT_WS(' ', notes, firstname, lastname, username, email, mobile, ".$this->db->dbprefix('users').".id, text_title, text_long, text_reference) LIKE '%".$this->db->escape_str($search_term)."%' COLLATE utf8_general_ci", NULL, FALSE);
				}		

				if($this->input->get_post('sSearch_0')){
					$this->db->where('users.status', $this->input->get_post('sSearch_0'));
				}
				
				if($this->input->get_post('sSearch_1')){
					$this->db->where('users.ugroup', $this->input->get_post('sSearch_1'));
				}		
					
				if($this->input->get_post('sSearch_2')){
					$this->db->where('service_badge', $this->input->get_post('sSearch_2'));
				}			
				
				if($this->input->get_post('sSearch_3')){
					$this->db->where('service_web', $this->input->get_post('sSearch_3'));
				}					

				if($this->input->get_post('sSearch_4') == 'Y' || $this->input->get_post('sSearch_4') == 'N'){
					if($this->input->get_post('sSearch_4') == 'Y')
					$this->db->where('message_count >', 0);
					
					if($this->input->get_post('sSearch_4') == 'N')
					$this->db->where('message_count', 0);
				}

				if($this->input->get_post('sSearch_5')){
					//disable virtual $this->db->where('prices.level_id', $this->input->get_post('sSearch_5'));
					$this->db->where("(".$this->db->dbprefix('prices').".level_id = '".$this->input->get_post('sSearch_5')."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && FIND_IN_SET(".$this->input->get_post('sSearch_5').", ".$this->db->dbprefix('users').".virtual_levels)))");
				}
								
				if($this->input->get_post('sSearch_6')){
					//disable virtual $this->db->where('locations.city', $this->input->get_post('sSearch_6'));
					$this->db->where("(".$this->db->dbprefix('locations').".city = '".$this->input->get_post('sSearch_6')."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".city = '".$this->input->get_post('sSearch_6')."'))");
				}
				
				if($this->input->get_post('sSearch_7')){
					//disable virtual $this->db->where('locations.town', $this->input->get_post('sSearch_7'));
					$this->db->where("(".$this->db->dbprefix('locations').".town = '".$this->input->get_post('sSearch_7')."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".town = '".$this->input->get_post('sSearch_7')."'))");
				}				
								
				$this->db->from('users');
				$this->db->join('users_groups', 'users.ugroup=users_groups.id', 'left');
				
				if($this->input->get_post('sSearch_5')){
					$this->db->join('prices', 'users.id=prices.uid', 'left');
				}	
				
				if($this->input->get_post('sSearch_6') || $this->input->get_post('sSearch_7')){
					$this->db->join('locations', 'users.id=locations.uid', 'left');
				}				

			
			$this->db->stop_cache();
			
			$this->db->select('users.id')->distinct();
	
			$total = $this->db->count_all_results();
			
			$this->db->select('users.*, users_groups.name group_name')->distinct();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();
						
			$this->db->flush_cache();
						
			foreach($items as $item){
				$item->nicetime = nicetime($item->joined);
			}
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}

		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		$data['categories_selectbox'] = $this->_getcategoriesrecursive(6, '', $sub_categories);
		
		$data['cities'] = $this->locationsmodel->get_locations('locations_cities', ['status' => 'A']);
				
		$data['groups'] = $this->db->from('users_groups')->get()->result();
		$data['viewPage'] = $this->load->view('users/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function _getcategoriesrecursive($parent_id = 0, $delimiter = '', $only_this_categories = '')
	{
		if($only_this_categories){
			$this->db->where("category_id IN(".implode(',', $only_this_categories).")");
		}
		
    	$elements = $this->db->from('contents_categories')->where('parent_id', $parent_id)->where('status !=', 'D')->get()->result();
	    $branch = array();
		
		$delimiter = '-';
		
	    foreach ($elements as $element) {
	        
			$element->delimiter = $delimiter;
	        $branch[] = $element;
	        
	        if ($element->parent_id == $parent_id) {
	            $children = $this->_getcategoriesrecursive($element->id, $delimiter, $only_this_categories);
	        }

            if ($children) {
                //$element->children = $children;
                foreach($children as $child){
                	$child->delimiter .= $delimiter;
                	$branch[] = $child;
                }
            }
	            	        
	    }
	
	    return $branch;
	}
		
	public function add()
	{
		check_perm('users_add');
		
		$data = array();
		
		if($this->input->post())
		{

			$form = $this->input->post('form', TRUE);

			
			
			if(!empty($form['email']) || !empty($form['mobile']))
			{
				if(!empty($form['email']))
				$this->db->or_where('email', $form['email']);
				
				if(!empty($form['mobile']))
				$this->db->or_where('mobile', $form['mobile']);
				
				$query = $this->db->from('users')->count_all_results();
				
				if(!empty($query)) $data['errors'][] = "Girilen bilgilere uygun eğitmen bulunmaktadır!";

			}
			
			
			if(empty($form['firstname'])) $data['errors'][] = "Lütfen ad alanını boş bırakmayınız";
			if(empty($form['lastname'])) $data['errors'][] = "Lütfen soyad alanını boş bırakmayınız";
			if(empty($form['mobile'])) $data['errors'][] = "Lütfen cep telefonu alanını boş bırakmayınız";
			if(empty($form['group'])) $data['errors'][] = "Lütfen üyelik grubu alanını boş bırakmayınız";
			if(empty($form['status'])) $data['errors'][] = "Lütfen durum alanını boş bırakmayınız";
			
			if(empty($data['errors']))
			{
				$password = !empty($form['password']) && ($form['password'] == $form['password2']) ? md5(md5($form['password'])) : "";
				$group = $form['group'] ? $form['group'] : 2;

				$this->load->helper('string');					
				$random_number = random_string('alnum', 5);
				$activation_code = md5(time());
						
				$insert_data = array(
					'username' 			=> unique_string('users', 'username', 8, 'numeric'),
				    'firstname' 		=> trim($form['firstname']),
				    'lastname' 			=> trim($form['lastname']),
				    'email' 			=> !empty($form['email']) ? trim($form['email']) : NULL,
				    'email_request' 	=> !empty($form['email']) ? trim($form['email']) : NULL,
				    'mobile' 			=> !empty($form['mobile']) ? trim($form['mobile']) : NULL,
				    'gender' 			=> !empty($form['gender']) ? trim($form['gender']) : NULL,
				    'city' 				=> !empty($form['city']) ? trim($form['city']) : NULL,
				    'town' 				=> !empty($form['town']) ? trim($form['town']) : NULL,
				    'notes' 			=> !empty($form['notes']) ? trim($form['notes']) : NULL,
				    'password' 			=> md5(md5($random_number)),
				    'password_text'		=> $random_number,
				    'ugroup' 			=> $form['group'], 
				    'status' 			=> $form['status'],
				    'search_point' 		=> $form['group'] == 3 || $form['group'] == 4 || $form['group'] == 5 ? point('starter')  : NULL,
				    'activation_code' 	=> $activation_code,
				    'lang_code' 		=> 'tr',
					'register_page'		=> 'backend',
					'register_form'		=> 'user_form',	
					'joined'			=> time()				    
				);

				if($insert_data['group'] == 3 || $insert_data['group'] == 4 || $insert_data['group'] == 5){
					$insert_data['figures'] = '1,2';	
					$insert_data['places'] = '1,2,3,4,5';	
					$insert_data['times'] = '1,2,3,4';	
					$insert_data['services'] = '1,2,3,4,5';	
					$insert_data['genders'] = '1,2';				
				}
								
				$this->db->insert('users', $insert_data);
				$insert_id = $this->db->insert_id();
				
				if(!empty($insert_id)){
					
					if(!empty($form['email']) && $form['send_mail'] == 'Y')
					{
						$this->load->library('email');
						$this->load->helper('email');
			
						$subject = lang('MAIL_NEW_USER_SUBJECT');
						$email = trim($form['email']);
			
						$body = nl2br(lang('MAIL_NEW_USER_BODY'));
			
						$body = str_replace('__FIRSTNAME__', trim($form['firstname']), $body);
						$body = str_replace('__LASTNAME__', trim($form['lastname']), $body);
						$body = str_replace('__EMAIL__', trim($form['email']), $body);
						$body = str_replace('__PASSWORD__', $random_number, $body);
						$body = str_replace('__ACTIVATION_CODE__', $activation_code, $body);
						$body = str_replace('__ACTIVATION_URL__', site_url('aktivasyon/?code='.$activation_code.'&email='.$email), $body);
						$body = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $body);
			
						$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
						$this->email->to($email);
			
						$this->email->subject($subject.' - '.$GLOBALS['settings_global']->site_name);
						$this->email->message($body);
			
						if(!$this->email->send()){
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
							$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
							send_email($email, $subject.' - '.$GLOBALS['settings_global']->site_name, $body);
						}
					}
									
					f_redir(base_url('backend/users/edit/'.$insert_id), array(lang('SUCCESS')));
				}
			}
		}
		
		$data['cities'] = $this->locationsmodel->get_locations('locations_cities', ['status' => 'A']);
		$data['groups'] = $this->db->from('users_groups')->get()->result();

		$data['viewPage'] = $this->load->view('users/add', $data, true);
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function edit($id)
	{
		check_perm('users_edit');

		if($this->input->post())
		{
			$errors = array();
			$form = $this->input->post('form', TRUE);

			if($this->db->from('users')->where('email !=', 'destek@netders.com')->where('email', $form['email'])->where('id !=', (int)$id)->count_all_results()) $errors[] = "Girilen e-posta adresi kullanılmaktadır!";
			if(empty($form['firstname'])) $errors[] = "Lütfen ad alanını boş bırakmayınız";
			if(empty($form['lastname'])) $errors[] = "Lütfen soyad alanını boş bırakmayınız";
				
			if(empty($errors))
			{
				$user = $this->db->from('users')->where('id', $id)->get()->row();
				if(!empty($user))
				{	
					if($form['review_status'] == 'A' || $form['review_status'] == 'R')
					{
						$this->load->library('email');
						$this->load->helper('email');
						
						$subject = lang('MAIL_ADMIN_REVIEW_SUBJECT');
						$email = $form['email'];
						$template 		= lang('MAIL_TEMPLATE');
						
						$review_comment = $form['review_comment'] ? $form['review_comment'] : '';
						
						$approval_info = !empty($form['email_request']) ? nl2br(lang('MAIL_ADMIN_APPROVAL_INFO')) : '';
						$approval_info = !empty($approval_info) ? str_replace('__APPROVAL_LINK__', site_url('aktivasyon/?code='.$form['activation_code'].'&email='.$form['email']), $approval_info) : '';
										
						$body = $form['review_status'] == 'A' ? lang('MAIL_ADMIN_REVIEW_BODY_APPROVE') : lang('MAIL_ADMIN_REVIEW_BODY_DISAPPROVE');
	
						$body = $review_comment ? $body : str_replace('Editörün Mesajı:', '', $body);
						
						$body = str_replace('__FIRSTNAME__', $form['firstname'], $body);
						$body = str_replace('__LASTNAME__', $form['lastname'], $body);
						$body = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $body);
						$body = str_replace('__APPROVAL_INFO__', $approval_info, $body);
						$body = str_replace('__REVIEW_COMMENT__', $review_comment, $body);
						
						$body = str_replace('__BODY__', nl2br($body), $template);
						
						$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
						$this->email->to($email);
						
						$this->email->subject(lang('MAIL_ADMIN_REVIEW_SUBJECT').' - '.$GLOBALS['settings_global']->site_name);
						$this->email->message($body);
						
						if(!$this->email->send()){
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
							$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
							send_email($email, lang('MAIL_ADMIN_REVIEW_SUBJECT').' - '.$GLOBALS['settings_global']->site_name, $body);
						}
					}	
					
					if(!empty($form['figures']))
					$form['figures'] = implode(',',$form['figures']);
					
					if(!empty($form['places']))
					$form['places'] = implode(',',$form['places']);
					
					if(!empty($form['times']))
					$form['times'] = implode(',',$form['times']);
					
					if(!empty($form['services']))
					$form['services'] = implode(',',$form['services']);

					if(!empty($form['genders']))
					$form['genders'] = implode(',',$form['genders']);																				
										
					$update_data = array();
					
					foreach($form as $key => $value)
					{
						$update_data[$key] = $value ? trim($value) : NULL;
					}
					
					if(!empty($update_data['demo_date']))
					$update_data['demo_date'] = strtotime($update_data['demo_date']);
					
					if(!empty($update_data['expire_membership']))
					$update_data['expire_membership'] = strtotime($update_data['expire_membership']);					
					
					$update_data['status'] = $update_data['review_status'] ? $update_data['review_status'] : $update_data['status'];
					
					if(!empty($update_data['sms_text']))
						send_sms($update_data['mobile'], $update_data['sms_text']);
					else
						unset($update_data['sms_text']);
										
					if(!empty($update_data['password']) && !empty($update_data['password2']) && ($update_data['password'] == $update_data['password2']))
					{
						$update_data['password_text']	= trim($update_data['password']);					
						$update_data['password'] 		= md5(md5(trim($update_data['password'])));	
						unset($update_data['password2']);
					} else {
						unset($update_data['password']);
						unset($update_data['password2']);
					}

					if($update_data['ugroup'] != $user->ugroup)
					{
						switch($update_data['ugroup'])
						{
							case 3:
								$update_data['expire_membership'] = NULL;
								if($user->ugroup == 4)
								$update_data['search_point'] = $user->search_point - point('advanced');
								
								if($user->ugroup == 5)
								$update_data['search_point'] = $user->search_point - point('premium');
								
								$update_data['service_badge'] = 'N';
								$update_data['service_web'] = 'N';
								$update_data['service_featured'] = NULL;
								$update_data['service_doping'] = NULL;
								$update_data['last_membership'] = NULL;
								$update_data['last_featured'] = NULL;
								$update_data['last_doping'] = NULL;
							break;

							case 4:
								if($user->ugroup == 3)
								$update_data['search_point'] = $user->search_point + point('advanced');
								
								if($user->ugroup == 5)
								$data['search_point'] = $user->search_point + point('premium') - point('advanced');							
							break;
							
							case 5:
								if($user->ugroup == 3)
								$update_data['search_point'] = $user->search_point + point('premium');
								
								if($user->ugroup == 4)
								$update_data['search_point'] = $user->search_point + point('premium') - point('advanced');														
							break;														
						}
					}
					
					$this->_insert_prices($id);				
					$this->_insert_locations($id);				
					
					unset($update_data['review_status']);
					
					
					$this->db->where('id', $id)->update('users', $update_data);
				}
				
				f_redir(base_url('backend/users/edit/'.$id), array(lang('SUCCESS')));
			}
		}
		
		$item = $this->db->query("SELECT * FROM ".$this->db->dbprefix('users')." WHERE id = ? LIMIT 1", $id)->row();
		if(empty($item)){ f_redir(base_url('backend/users')); }

		$data['item'] = $item;
		
		$data['prices'] = $this->db
								->select('p.*, c.id_path')
								->from('prices p')
								->join('contents_categories c', 'p.level_id=c.category_id', 'left')
								->where('p.uid', $data['item']->id)
								->get()->result();
		
		$data['errors'] = $errors;
		$data['categories'] = $this->db->from('contents_categories')->where('parent_id', 6)->where('lang_code', DESCR_SL)->get()->result();		
		$data['professions'] = $this->db->from('professions')->order_by('position')->get()->result();								
		$data['locations'] = $this->db->from('locations')->where('uid', $data['item']->id)->get()->result();								
		$data['cities'] = $this->locationsmodel->get_locations('locations_cities', ['status' => 'A']);
		$data['groups'] = $this->db->from('users_groups')->get()->result();
		$data['requests_activities'] = $this->requestsmodel->get_request_activities(array('teacher_id' => $data['item']->id));

		$data['viewPage'] = $this->load->view('users/edit', $data, true);
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function _insert_prices($user_id = '')
	{
		if(!empty($user_id) && ($this->input->post('new') || $this->input->post('current')))
		{
			//new prices
			if($this->input->post('new'))
			{
				
				$new = $this->input->post('new');
				$current_prices = array();
				$db_prices = array();
				
				foreach($new['category'] as $key => $value)
				{
					if(!empty($new['price_private'][$key]))
					{
						$check = $this->db->from('prices')->where('uid', $user_id)->where('subject_id', $new['category'][$key])->where('level_id', $new['lesson'][$key])->get()->row();
						if(empty($check)){
							$insert_data = array(
								'uid' => $user_id,
								'subject_id' => $new['category'][$key],
								'level_id' => $new['lesson'][$key],
								'price_live' => $new['price_live'][$key],
								'price_private' => $new['price_private'][$key],
								'date' => time(),
								'ip' => $this->input->ip_address()
								
							);
							$this->db->insert('prices', $insert_data);
							$current_prices[] = $new['lesson'][$key];
						}
					}
				}
			}
			
			//update prices
			if($this->input->post('current'))
			{
				$current = $this->input->post('current');
			
				foreach($current['category'] as $key => $value)
				{
					if(!empty($current['price_private'][$key]))
					{
						$check = $this->db->from('prices')->where('uid', $user_id)->where('id', $key)->get()->row();
						
						if(!empty($check))
						{
							$update_data = array(
								'subject_id' => $current['category'][$key],
								'level_id' => $current['lesson'][$key],
								'price_live' => $current['price_live'][$key],
								'price_private' => $current['price_private'][$key],
								'date' => $check->date ? $check->date : time(),
								'ip' => $check->ip ? $check->ip : $this->input->ip_address()
								
							);
							$this->db->where('id', $check->id)->update('prices', $update_data);
							$current_prices[] = $current['lesson'][$key];
						}
					}
				}
			}
			
			//delete prices
			if(empty($current_prices)){
				$this->db->where('uid', $user_id)->delete('prices');
			} else {
				$check_exists = $this->db->from('prices')->where('uid', $user_id)->get()->result();
				if(!empty($check_exists)){
					foreach($check_exists as $exist){
						if(!in_array($exist->level_id, $current_prices)){
							$this->db->where('id', $exist->id)->delete('prices');
						}
					}
				}
			}
		}
	}
	
	public function _insert_locations($user_id = '')
	{
		if(!empty($user_id) && ($this->input->post('new_location') || $this->input->post('current_location')))
		{
			//new prices
			if($this->input->post('new_location'))
			{
				
				$new_location = $this->input->post('new_location');
				$current_locations = array();
				$db_locations = array();
				
				foreach($new_location['city'] as $key => $value)
				{
					if(!empty($new_location['town'][$key]))
					{
						$check = $this->db->from('locations')->where('uid', $user_id)->where('city', $new_location['city'][$key])->where('town', $new_location['town'][$key])->get()->row();
						if(empty($check)){
							$insert_data = array(
								'uid' => $user_id,
								'city' => $new_location['city'][$key],
								'town' => $new_location['town'][$key],
								'date' => time(),
								'ip' => $this->input->ip_address()
								
							);
							$this->db->insert('locations', $insert_data);
							$current_locations[] = $new_location['town'][$key];
						}
					}
				}
			}
			
			//update prices
			if($this->input->post('current_location'))
			{
				$current_location = $this->input->post('current_location');
			
				foreach($current_location['city'] as $key => $value)
				{
					if(!empty($current_location['town'][$key]))
					{
						$check = $this->db->from('locations')->where('uid', $user_id)->where('id', $key)->get()->row();
						
						if(!empty($check))
						{
							$update_data = array(
								'city' => $current_location['city'][$key],
								'town' => $current_location['town'][$key],
								'date' => $check->date ? $check->date : time(),
								'ip' => $check->ip ? $check->ip : $this->input->ip_address()
								
							);
							$this->db->where('id', $check->id)->update('locations', $update_data);
							$current_locations[] = $current_location['town'][$key];
						}
					}
				}
			}
			
			//delete prices
			if(empty($current_locations)){
				$this->db->where('uid', $user_id)->delete('locations');
			} else {
				$check_exists = $this->db->from('locations')->where('uid', $user_id)->get()->result();
				if(!empty($check_exists)){
					foreach($check_exists as $exist){
						if(!in_array($exist->town, $current_locations)){
							$this->db->where('id', $exist->id)->delete('locations');
						}
					}
				}
			}
		}
	}	
	
	public function delete($id, $redir = true){
		
		check_perm('users_delete');
		
		$myself = $this->db->query("SELECT id FROM ".$this->db->dbprefix('users')." WHERE id = ?", $id)->row();
		if($myself->id == $this->session->userdata('user_id')){
			f_redir(base_url('backend/users'), array("Kendi hesabınızı silemezsiniz"), "", "", TRUE);
		} else {

			switch($GLOBALS['settings_global']->content_delete_type){
				case 1: //delete content
					$user = $this->db->where('id', $id)->from('users')->get()->row();
					if(!empty($user))
					{
						$this->db->where('id', $id)->delete('users');
						$this->db->where('uid', $id)->delete('prices');
						$this->db->where('uid', $id)->delete('locations');
						$this->db->where('uid', $id)->delete('calendar');
						$this->db->where('uid', $id)->delete('calendar_exceptions');
						$this->db->where('uid', $id)->delete('users_verified_emails');
						$this->db->where('uid', $id)->delete('users_money');
						$this->db->where('uid', $id)->or_where('tutor_id', $id)->delete('lessons');
						$this->db->where('uid', $id)->or_where('tutor_id', $id)->delete('orders');
						
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('users')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('prices')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('calendar')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('calendar_exceptions')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('lessons')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('orders')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('users_verified_emails')." AUTO_INCREMENT = 1");
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('users_money')." AUTO_INCREMENT = 1");
						
						if($user->photo)
						@unlink(ROOTPATH . $user->photo);
					}
				break;
				
				case 2: //move to trash content				
					$this->db->where(array('id' => $id));
					$this->db->update('users', array('status' => 'D'));
		
					//Insert trash
					$item = $this->db->from('users')->where('id', $id)->get()->row();
					$data = array(
						'uid' => $this->session->userdata('user_id'),
						'title' => $item->firstname . ' ' . $item->lastname . ' ('.$item->email.')',
						'module' => 'users',
						'module_id' => $item->id,
						'date' => time(),
						'lang_code' => $item->lang_code
					);
					$this->db->insert('trash', $data);
				break;
			}

		}
		
		if($redir == true)
		f_redir(base_url('backend/users'), array(lang('SUCCESS')));	
	}
	
	public function login()
	{
		if($this->session->userdata('user_id')) f_redir(base_url('backend'));
		
		$errors = array();
		
		if($this->input->post())
		{
			
			$email = $this->input->post('email', true);
			$password = $this->input->post('password', true);
			if(empty($email)){$errors[] = lang('PLEASE_CHECK_YOUR_INFORMATIONS');}
			if(empty($password)){$errors[] = lang('PLEASE_CHECK_YOUR_INFORMATIONS');}

			if(empty($errors)){
				$user = $this->usersmodel->userLogin($email, $password);

				if($user)
				{
					if($user->status == "I"){
						$error[] = "Hesabınız pasif durumdadır.";
					} else if($user->status == "B"){
						$error[] = "Hesabınız yasaklanmıştır.";
					} else if($user->status == "W"){
						$error[] = "Hesabınız henüz onaylanmamıştır.";
					} else {
						if(empty($errors)){
							
							$userData = array(
								'user_id' => $user->id,
								'user_firstname' => $user->firstname,
								'user_lastname' => $user->lastname,
								'user_group' => $user->ugroup,
								'user_email' => $user->email
							);
							$this->session->set_userdata($userData);
							
							if($user->ugroup == 1){
								$this->session->set_userdata(array('aeditor' => 1));
							}
							
							$referer = $this->session->userdata('ref') != '' ? $this->session->userdata('ref') : base_url('backend');
							$this->session->unset_userdata('ref');
							f_redir($referer, array(lang('USERS_LOGIN_SUCCESS')));
						} else {
							f_redir(base_url('backend/users/login'), $error, '', '', TRUE);
						}
					}
				} else {
					$errors[] = lang('PLEASE_CHECK_YOUR_INFORMATIONS');
				}
			}
		}
		
		$data['errors'] = $errors;
		$data['viewPage'] = $this->load->view('users/login', $data, true);
		
		$result	 = $this->load->view('pages/user', $data, true);
		$this->output->set_output($result);
	}
	
	public function loginas($user_id = '')
	{
		check_perm('users_edit');
		
		if(empty($user_id)) f_redir(base_url('backend/users'));

		$user = $this->db->from('users')->where('id', $user_id)->get()->row();
		
		unset($user->password);
		unset($user->forgot);
		
		$this->session->set_userdata(prefix_array_key('user_', $user));
		
		f_redir(site_url());
	}	

	public function logout(){
		if($this->session->userdata('user_id'))
		{
			$this->db->where(array('id' => $this->session->userdata('user_id')))->update("users", array('online' => '0'));
		}
		$this->session->sess_destroy();
		f_redir(base_url('backend'));
	}
		
	public function update(){
		if(check_perm('users_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($_POST['status']){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); }  
			
			foreach ($post['status'] as $nid => $var)
			{
				if(!empty($post['status'][$nid]))
				{
					$data = array(
						'status' => $post['status'][$nid],
						'ugroup' => $post['group'][$nid]
					);

					$this->db->where(array('id' => (int)$nid));
					$this->db->update('users', $data);
				}
			}
		}
		echo json_encode(lang('SUCCESS'));
	}

	public function groups()
	{
		check_perm('users_groups');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->deletegroup($id, false);
					}
				}
				f_redir(base_url('backend/users'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
				
				if($this->input->get_post('sSearch')){
					$this->db->like('name', $this->input->get_post('sSearch', true));
				}
				
				$this->db->from('users_groups');
	
			$this->db->stop_cache();
			
			$this->db->select('id');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();

			$this->db->flush_cache();
						
			foreach($items as $item){
				$item->users = $this->db->query("SELECT id FROM ".$this->db->dbprefix('users')." WHERE ugroup = ?", array($item->id))->num_rows();
			}
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('users/groups', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	function addgroup(){		
		check_perm('users_groups_add');
		
		if(isset($_POST['submit'])){
			$errors = array();
			$check_name_exist = $this->db->query("SELECT id FROM ".$this->db->dbprefix('users_groups')." WHERE name = ?", $_POST['name'])->num_rows();
			if($check_name_exist > 0){
				$errors[] = "Bu isimde bir grup mevcuttur";
			}
			if(empty($_POST['name'])){$errors[] = "Lütfen ad alanini bos birakmayin";}
			//if(sizeof($_POST['permissions']) == 0){$errors[] = "Lütfen izinleri seçin";}
			if(count($errors) > 0){
				$data['errors'] = $errors;
			} else {
				$data = array(
				    'name' => $_POST['name']
				);
				$this->db->insert('users_groups', $data);
				
				if($this->db->insert_id()){
					$data2 = array(
						'ugroup' => $this->db->insert_id(),
					    'perm' => $this->input->post('permissions') ? implode(",", $this->input->post('permissions')) : NULL
					);
					$this->db->insert('users_permissions', $data2);
				}
				
				f_redir(base_url('backend/users/groups'), array(lang('SUCCESS')));
			}
		}

		$data['permissions'] = $GLOBALS['permissions'];
		$data['viewPage'] = $this->load->view('users/addgroup', $data, true);
		
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}
		
	function deletegroup($id){
		
		check_perm('users_groups_delete');
		
		$check = $this->db->query("SELECT id FROM ".$this->db->dbprefix('users_groups')." WHERE id = ? OR id IN(?)", array($id, '1,2'))->num_rows();
		if($check > 0){
			$total = $this->db->query("SELECT id FROM ".$this->db->dbprefix('users')." WHERE ugroup = ?", $id)->num_rows();
			if($total == 0){
				$this->db->query("DELETE FROM ".$this->db->dbprefix('users_groups')." WHERE id = ?", array($id));
				$this->db->query("DELETE FROM ".$this->db->dbprefix('users_permissions')." WHERE ugroup = ?", $id);
				$this->db->query("ALTER TABLE ".$this->db->dbprefix('users_groups')." AUTO_INCREMENT = ?", 1);
				f_redir(base_url('backend/users/groups'), array(lang('SUCCESS')));
			} else {
				f_redir(base_url('backend/users/groups'), array("Grupta kullanıcı olduğundan silinemez"), "", "", TRUE);
			}
		} else {
			f_redir(base_url('backend/users/groups'));
		}
	}
	

	function permissions($id){
		
		check_perm('users_perms_overview');
		
		if($this->input->post('submit')){
			check_perm('users_perms_edit');
			
			$errors = array();
			
			if(sizeof($this->input->post('permissions')) == 0){$errors[] = "Lütfen grup izinlerini seçiniz";}
			
			if(count($errors) > 0){
				$smarty->assign('errors', $errors);
			} else {
				$check_group = $this->db->query("SELECT id FROM ".$this->db->dbprefix('users_groups')." WHERE id = ? AND id != ?", array($id, 1))->num_rows();
				if($check_group > 0){
					$data = array(
					    'perm' => @implode(",", $this->input->post('permissions', TRUE))
					);
					$this->db->where(array('ugroup' => $id))->update('users_permissions', $data);
					f_redir(base_url('backend/users/permissions/'.$id), array(lang('SUCCESS')));
				} else {
					f_redir(base_url('backend/users/permissions/'.$id), array(lang('USERS_ERROR_PERMISSIONS_DEFAULT_CHANGED')), '', '', TRUE);
				}
			}
		}
		$group_name = $this->db->query("SELECT name FROM ".$this->db->dbprefix('users_groups')." WHERE id = ? LIMIT 1", $id)->row();
		
		if($group_name->name){
			$userpermissions = $this->db->query("SELECT perm FROM ".$this->db->dbprefix('users_permissions')." WHERE ugroup = ? LIMIT 1", $id)->row();
		}
		
		$data['name'] = $group_name->name;
		$data['userpermissions'] = explode(",", $userpermissions->perm);
		$data['permissions'] = $GLOBALS['permissions'];
		$data['viewPage'] = $this->load->view('users/permissions', $data, true);
		
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);	
	}
	
	function updategroup(){
	
		if(check_perm('users_groups_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('name') && $this->input->post('value'))
		{			
			$this->db->where('id', $this->input->post('name', true));
			$this->db->update('users_groups', array('name' => $this->input->post('value')));
		}
		echo json_encode(lang('SUCCESS'));
	}
		
	public function getLocations()
	{	
		if($this->input->get('form')){
			$form = $this->input->get('form', true);
		} else {
			$form = $this->input->get();
		}
		
		if($form['city'])
		{
			$items = $this->locationsmodel->get_locations('locations_towns', ['city_id' => (int)$form['city']]);
		} 
		else if($form['town'])
		{
			$items = $this->locationsmodel->get_locations('locations_districts', ['town_id' => (int)$form['town']]);
		}
		
		if(!empty($items)){
			$i[0] = array('id' => '', 'name' => "-- ".lang('PLEASE_SELECT')." --");
			foreach($items as $key => $item){
				$i[$key + 1] = array('id' => $item->id, 'name' => $item->title);
			}
		} else {
			$i[0] = array('id' => '', 'name' => lang('CONTENTS_EMPTY'));
		}
		echo json_encode($i, JSON_FORCE_OBJECT);		
	}
	
	public function subcategories()
	{
		$category = $this->input->get('category');
		
		if($category){

			$items = $this->db->from('contents_categories')->where('parent_id', $category)->where('lang_code', DESCR_SL)->get()->result();
		}
		
		if(!empty($items)){
			$i[0] = array('id' => '', 'name' => "-- ".lang('PLEASE_SELECT')." --");
			foreach($items as $key => $item){
				$i[$key + 1] = array('id' => $item->id, 'name' => $item->title);
			}
		} else {
			$i[0] = array('id' => '', 'name' => lang('CONTENTS_EMPTY'));
		}
		echo json_encode($i, JSON_FORCE_OBJECT);
		exit;		
	}	
	
	public function pendingphotos()
	{
		if($this->input->post('submit') && $this->input->post('id')){
			return $this->input->post('submit') == 'approve' ? $this->approvephoto($this->input->post('id')) : $this->rejectphoto($this->input->post('id'));
		}
		
		$data['items'] = $this->db->from('users')->where('ugroup IN(3,4,5)')->where('photo_request !=', NULL)->get()->result();
		$data['viewPage'] = $this->load->view('users/pendingphotos', $data, true);

		$result  = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function approvephoto($user_id)
	{
		$user = $this->db->from('users')->where('id', $user_id)->get()->row();
		
		if(!empty($user))
		{
			$target = 'uploads/users/';
			
			$this->load->library('upload');
			$handle = new Upload(ROOTPATH . $user->photo_request);
			
			$handle->image_resize            	 = true;
	
			if($handle->image_resize){
				$handle->image_x                 = 300;
				$handle->image_y                 = 300;
				$handle->image_ratio_crop		 = true;
			}
	
			$ext = substr($user->photo_request, -3);
			
			if($ext == 'png' || $ext == 'gif'){
				$handle->image_convert 			 = 'jpg';
			}
			
			$handle->file_auto_rename 		 = false;
			$handle->file_new_name_body      = 'photo_'.$user->id.'_'.time();
			$handle->image_ratio_crop		 = $this->input->post('crop_area') == 'C' ? true : $this->input->post('crop_area');
			
			if($this->input->post('rotate'))
			$handle->image_rotate          	 = $this->input->post('rotate');

		    $handle->image_text           	 = 'netders';
			$handle->image_text_position   	 = 'BR';
			$handle->image_text_padding_x 	 = 10;
			$handle->image_text_padding_y 	 = 10;	
			$handle->image_text_percent    	 = 50;
		    $handle->image_text_color        = '#FFFFFF';
			$handle->image_text_font         = 2;
			
			$handle->Process(ROOTPATH . $target);
			
			
			if ($handle->processed) {
				
				$handle->Clean();
				
				$updatedata = array(
					'photo' => $target . $handle->file_dst_name,
					'photo_request' => NULL
				);
				$this->db->where('id', $user->id)->update('users', $updatedata);

				if($user->photo)
				@unlink(ROOTPATH . $user->photo);
				
				$this->load->library('email');
				$this->load->helper('email');
	
				$subject = lang('MAIL_PHOTO_APPROVE_SUBJECT');
				$email = $user->email;
	
				$body = nl2br(lang('MAIL_PHOTO_APPROVE_BODY'));
	
				$body = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $body);
				$body = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST'] .'/'. $user->username), $body);
	
				$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
				$this->email->to($email);
	
				$this->email->subject($subject.' - '.$GLOBALS['settings_global']->site_name);
				$this->email->message($body);
	
				if(!$this->email->send()){
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
					send_email($email, $subject.' - '.$GLOBALS['settings_global']->site_name, $body);
				}
				
			} else {
				print_r($handle->error);
				exit;
			}	
		}	

		f_redir(base_url('backend/users/pendingphotos'), lang('SUCCESS'));
	}

	public function rejectphoto($user_id, $photo_type = 'photo_request')
	{
		$user = $this->db->from('users')->where('id', $user_id)->get()->row();
		if(!empty($user)){
			$updatedata = array(
				$photo_type => NULL
			);
			$this->db->where('id', $user->id)->update('users', $updatedata);
			@unlink(ROOTPATH . $user->{$photo_type});

			$this->load->library('email');
			$this->load->helper('email');

			$subject = lang('MAIL_PHOTO_REJECT_SUBJECT');
			$email = $user->email;

			$body = nl2br(lang('MAIL_PHOTO_REJECT_BODY'));

			$body = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $body);
			$body = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST'] .'/'. $user->username), $body);

			$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
			$this->email->to($email);

			$this->email->subject($subject.' - '.$GLOBALS['settings_global']->site_name);
			$this->email->message($body);

			if(!$this->email->send()){
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
				send_email($email, $subject.' - '.$GLOBALS['settings_global']->site_name, $body);
			}
		}
		
		f_redir(base_url('backend/users/pendingphotos'), lang('SUCCESS'));
	}	
	
	public function showphotos()
	{
		if($this->input->post())
		{

			if($this->input->post('id') && $this->input->post('submit') == 'disapprove'){
				return $this->rejectphoto($this->input->post('id'), 'photo');
			}
						
			$user_id = $this->input->post('id');
			
			$user = $this->db->from('users')->where('id', $user_id)->get()->row();
			
			if(!empty($user))
			{
				$target = 'uploads/users/';
				
				$this->load->library('upload');
				$handle = new Upload(ROOTPATH . $user->photo);
				
				$handle->image_resize            	 = true;
		
				if($handle->image_resize){
					$handle->image_x                 = 300;
					$handle->image_y                 = 300;
					$handle->image_ratio_crop		 = true;
				}
		
				$ext = substr($user->photo, -3);
				
				if($ext == 'png' || $ext == 'gif'){
					$handle->image_convert 			 = 'jpg';
				}
				
				$handle->file_auto_rename 		 = false;
				$handle->file_new_name_body      = 'photo_'.$user->id.'_'.time();
				$handle->image_ratio_crop		 = $this->input->post('crop_area') == 'C' ? true : $this->input->post('crop_area');
				
				if($this->input->post('rotate'))
				$handle->image_rotate          	 = $this->input->post('rotate');
	
			    $handle->image_text           	 = 'netders';
				$handle->image_text_position   	 = 'BR';
				$handle->image_text_padding_x 	 = 10;
				$handle->image_text_padding_y 	 = 10;	
				$handle->image_text_percent    	 = 50;
			    $handle->image_text_color        = '#FFFFFF';
				$handle->image_text_font         = 2;
				
				$handle->Process(ROOTPATH . $target);
				
				
				if ($handle->processed) {
					
					$handle->Clean();
					
					$updatedata = array(
						'photo' => $target . $handle->file_dst_name
					);
					$this->db->where('id', $user->id)->update('users', $updatedata);
	
					if($user->photo)
					@unlink(ROOTPATH . $user->photo);
					
				} else {
					print_r($handle->error);
					exit;
				}	
			}	
			
			f_redir(base_url('backend/users/showphotos?offset='.$this->input->post('offset')), lang('SUCCESS'));
		}
		
		$offset = $this->input->get('offset') ? $this->input->get('offset') : 0;
		$data['items'] = $this->db->select('id, username, photo')->from('users')->where('ugroup IN(3,4,5)')->where("photo is not null")->limit(18, $offset)->get()->result();
		$data['viewPage'] = $this->load->view('users/showphotos', $data, true);

		$result  = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
		
	}	
	
	public function reactivation($user_id)
	{
		$user = $this->db->from('users')->where('id', $user_id)->get()->row();
		//if(!empty($user) && $user->email_request)
		if(!empty($user))
		{
			$this->load->library('email');
			$this->load->helper('email');
			
			//$email = $user->email_request;
			$email = $user->email;
			
			$template 		= lang('MAIL_TEMPLATE');
			$subject = lang('MAIL_NEW_USER_SUBJECT');		
			$msg = nl2br(lang('MAIL_NEW_USER_BODY'));
			$msg = str_replace('__FIRSTNAME__', $user->firstname, $msg);
			$msg = str_replace('__LASTNAME__', $user->lastname, $msg);
			$msg = str_replace('__EMAIL__', $user->email, $msg);
			$msg = str_replace('__ACTIVATION_CODE__', $user->activation_code, $msg);
			$msg = str_replace('__ACTIVATION_URL__', site_url('aktivasyon/?code='.$user->activation_code.'&email='.$user->email_request), $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$msg = str_replace('__BODY__', $msg, $template);
			
			$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
			$this->email->to($email);
			$this->email->subject($subject.' - '.$GLOBALS['settings_global']->site_name);
			$this->email->message($msg);

			if(!$this->email->send(FALSE))
			{
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
				$headers .= 'To: '.$user->email . "\r\n";
				send_email($email, $subject.' - '.$GLOBALS['settings_global']->site_name, $msg);
			}

			$this->db->where('id', $user->id)->update('users', array('mail_response' => $this->email->print_debugger()));	
						
			f_redir(base_url('backend/users'), array(lang('SUCCESS')));			
						
		}
					
	}
	

	public function comments()
	{
		check_perm('users_comments');
		
		$data = array();
		
		if($this->input->get('approve'))
		{
			$comment = $this->db->where('id', $this->input->get('approve', true))->from('comments')->get()->row();
			if(!empty($comment))
			{
				$this->db->where('id', $this->input->get('approve', true))->update('comments', array('status' => 'A'));
				
				$user = $this->db->where('id', $comment->to_uid)->from('users')->get()->row();
				//if(!empty($user)) $this->usersmodel->userpoint($user->id, 1, 1, 2);
			}
		}
		
		if($this->input->get('delete'))
		$this->db->where('id', $this->input->get('delete', true))->delete('comments');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/users/comments'), array(lang('SUCCESS')));
			}

			$this->db->start_cache();

			if($this->input->get_post('sSearch')){
				$this->db->like('c.comment', $this->input->get_post('sSearch', true));
			}

			if($this->input->get_post('sSearch_0')){
				if($this->input->get_post('sSearch_0') != 'all')
					$this->db->where('c.status', $this->input->get_post('sSearch_0'));
			} else {
				$this->db->where('c.status', 'W');
			}
			
			$this->db->from($this->db->dbprefix('comments').' c');
			$this->db->join($this->db->dbprefix('users').' u1', 'c.from_uid=u1.id', 'left');
			$this->db->join($this->db->dbprefix('users').' u2', 'c.to_uid=u2.id', 'left');

			$this->db->stop_cache();

			$this->db->select('id');

			$total = $this->db->count_all_results();
			
			$this->db->set_dbprefix('');
			$this->db->select('c.*, u1.username as from_username, u2.username as to_username');

			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}

			$items = $this->db->get()->result();

			$this->db->flush_cache();

			foreach($items as $item){
				if(!empty($item->joined))
				$item->nicetime = nicetime($item->joined);
			}
			$data['items'] = $items;

			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}

		$data['viewPage'] = $this->load->view('users/comments', $data, true);

		$result = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	
	
	public function points()
	{
		check_perm('users_points_overview');

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->delete($id, false);
					}
				}
				f_redir(base_url('admin/users/points'), array(lang('SUCCESS')));
			}

			$this->db->start_cache();

			if($this->input->get_post('sSearch')){
				$this->db->like('users.firstname', $this->input->get_post('sSearch', true));
				$this->db->or_like('users.lastname', $this->input->get_post('sSearch', true));
				$this->db->or_like('users.username', $this->input->get_post('sSearch', true));
				$this->db->or_like('users_points.description', $this->input->get_post('sSearch', true));
			}

			if($this->input->get_post('sSearch_0')){
				$this->db->where('users_points_tags.id', $this->input->get_post('sSearch_0'));
			}
			
			if($this->input->get_post('sSearch_1')){
				$this->db->where('users_points.tag', $this->input->get_post('sSearch_1'));
			}			
						

			$this->db->from('users_points');
			$this->db->join('users', 'users_points.uid=users.id', 'left');
			$this->db->join('users_points_tags', 'users_points_tags.id=users_points.tag', 'left');

			$this->db->stop_cache();

			$this->db->select('id');

			$total = $this->db->count_all_results();

			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
			
			$this->db->select('users_points.*, users_points_tags.description tag, users.firstname, users.lastname, users.username');
			
			$items = $this->db->get()->result();

			$this->db->flush_cache();

			$data['items'] = $items;

			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}

		$data['tags'] = $this->db->from('users_points_tags')->get()->result();
		$data['viewPage'] = $this->load->view('users/points', $data, true);

		$result = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	
	
	public function addpoint()
	{
		check_perm('users_points_add');

		if($this->input->post())
		{
			$errors = array();

			if(!$this->input->post('uid')){$errors[] = "Kullanıcı ID geçersizdir!";}
			if(!$this->input->post('point')){$errors[] = "Kullanıcı puanı eksiktir!";}
			if(!$this->input->post('tag')){$errors[] = "Kullanıcı puanı işlem adı eksiktir!";}			
			if(!$this->input->post('operation')){$errors[] = "Kullanıcı puanı işlem tipi eksiktir!";}			
			
			if(empty($errors))
			{
				$this->usersModel->userpoint($this->input->post('uid', true), $this->input->post('point', true), $this->input->post('operation', true), $this->input->post('tag', true), $this->input->post('description', true));
				f_redir(base_url('admin/users/points'), array(lang('SUCCESS')));
			}
		}

		$data['errors'] = $errors;
		$data['users'] = $this->db->from('users')->where('status', 'A')->get()->result();
		$data['tags'] = $this->db->from('users_points_tags')->get()->result();
		$data['viewPage'] = $this->load->view('users/addpoint', $data, true);

		$result  = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function deletepoint($id)
	{
		check_perm('users_points_delete');

		$this->usersModel->userpointdelete($id);
		f_redir(base_url('admin/users/points'), array(lang('SUCCESS')));
	}	


	public function activities()
	{
		check_perm('users_activities');

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->delete($id, false);
					}
				}
				f_redir(base_url('admin/users/activities'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
						
			
			if($this->input->get_post('sSearch')){
				$this->db->like('u.firstname', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('u.lastname', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('u.username', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('u.email', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('u.id', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('o.id', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('sp.string_date', $this->input->get_post('sSearch', true), 'both');
				$this->db->or_like('sp.title', $this->input->get_post('sSearch', true), 'both');
			}
			
			/*
			if($this->input->get_post('sSearch_0')){
				$this->db->where('users_points_tags.id', $this->input->get_post('sSearch_0'));
			}
			
			if($this->input->get_post('sSearch_1')){
				$this->db->where('users_points.tag', $this->input->get_post('sSearch_1'));
			}
			*/			
						

			$this->db->from($this->db->dbprefix('orders').' o');
			$this->db->join($this->db->dbprefix('settings_prices').' sp', 'sp.id=o.product_id', 'left');
			$this->db->join($this->db->dbprefix('contents_categories').' c1', 'c1.id=o.subject_id', 'left');
			$this->db->join($this->db->dbprefix('contents_categories').' c2', 'c2.id=o.level_id', 'left');
			$this->db->join($this->db->dbprefix('users').' u', 'u.id=o.uid', 'left');

			$this->db->stop_cache();

			$this->db->select('id');

			$total = $this->db->count_all_results();

			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
			
			$this->db->set_dbprefix('');
			$this->db->select('o.*, u.firstname, u.lastname, u.username, sp.title, sp.description, sp.string_date, c1.title subject_title, c2.title level_title');
			
			$items = $this->db->get()->result();
			
			$this->db->flush_cache();

			$data['items'] = $items;

			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}

		$data['viewPage'] = $this->load->view('users/activities', $data, true);

		$result = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	
	
	public function phonescheck()
	{
		check_perm('users_points_add');
		
		ini_set('memory_limit', -1);

		if($this->input->post('phones'))
		{
			$phones = explode(PHP_EOL, $this->input->post('phones'));
			
			foreach($phones as $phone){
				$phone = preg_replace('/\D/', '', $phone);
				$phone = substr($phone, -10);
				if(substr($phone, 0, 1) == 0){
					$phone = '+9' . $phone;
				} else {
					$phone = '+90' . $phone;
				}
				$newphones[] = substr($phone, 0,3) . ' ' . substr($phone, 3,3) . ' ' . substr($phone, 6,3) . ' ' . substr($phone, 9,4);
			}
			$data['phones'] = $this->db->from('users')->where_in('mobile', $newphones)->get()->result();
		}

		$data['errors'] = $errors;
		$data['users'] = $this->db->from('users')->where('status', 'A')->get()->result();
		$data['tags'] = $this->db->from('users_points_tags')->get()->result();
		$data['viewPage'] = $this->load->view('users/phonescheck', $data, true);

		$result  = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function prices_text()
	{
		check_perm('users_prices_text');
		
		$data = array();
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			$this->db->start_cache();
				
			if($this->input->get_post('sSearch')){
				$this->db->like('prices.title', $this->input->get_post('sSearch', true));
				$this->db->or_like('prices.description', $this->input->get_post('sSearch', true));
			}
			
			if($this->input->get_post('sSearch_0')){
				$this->db->where('prices.status', $this->input->get_post('sSearch_0'));
			} else {
				$this->db->where('prices.status IS NOT NULL');
			}
			
			$this->db->from('prices');
			$this->db->join('users', 'prices.uid=users.id', 'left');
			$this->db->join('contents_categories', 'prices.level_id=contents_categories.category_id', 'left');
	
			$this->db->stop_cache();
			
			$this->db->select('prices.id');
	
			$total = $this->db->count_all_results();
			
			$this->db->select('prices.*, users.firstname, users.lastname, contents_categories.title level_name');
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$data['items'] = $this->db->get()->result();
			$this->db->flush_cache();
			
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
		}
		
		$data['viewPage'] = $this->load->view('users/prices_text', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function prices_text_update()
	{
		if(check_perm('users_prices_text', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $this->input->post('name') && $this->input->post('pk') && $this->input->post('value'))
		{
			
			
			$update_data = array(
				$this->input->post('pk') => $this->input->post('value')
			);
			
			if($this->input->post('pk') == 'title')
			$update_data['seo_link'] = seo($this->input->post('value')) . '-'. $this->input->post('name');
			
			$this->db->where('id', $this->input->post('name'))->update('prices', $update_data);
		}		
	}	

	public function prices_text_approve($id)
	{
		$price = $this->db->from('prices')->where('id', (int)$id)->get()->row();
		
		if(!empty($price))
		{

			$update_data = array(
				'status' => 'A'
			);
			$this->db->where('id', (int)$id)->update('prices', $update_data);
		}	

		f_redir(base_url('backend/users/prices_text?status=W'), lang('SUCCESS'));
	}
	
	public function prices_text_wait($id)
	{
		$price = $this->db->from('prices')->where('id', (int)$id)->get()->row();
		
		if(!empty($price))
		{

			$update_data = array(
				'status' => 'W'
			);
			$this->db->where('id', (int)$id)->update('prices', $update_data);
		}	

		f_redir(base_url('backend/users/prices_text'), lang('SUCCESS'));
	}
	
	public function prices_text_delete($id)
	{
		$price = $this->db->from('prices')->where('id', (int)$id)->get()->row();
		
		if(empty($price)) return false;
		
		$user = $this->db->from('users')->where('id', $price->uid)->get()->row();
		
		if(empty($user)) return false;
		
		$subject_name = $this->db->from('contents_categories')->where('category_id', $price->subject_id)->get()->row()->title;
		$level_name = $this->db->from('contents_categories')->where('category_id', $price->level_id)->get()->row()->title;

		$this->load->library('email');
		$this->load->helper('email');
		
		$email = $user->email;
		
		$template = lang('MAIL_TEMPLATE');
		$subject = lang('LESSON_TEXT_REJECT'). ' ('.$subject_name.' > '.$level_name.')';		
		$msg = nl2br(lang('LESSON_TEXT_REJECT_BODY'));
		$msg = str_replace('__FIRSTNAME__', $user->firstname, $msg);
		$msg = str_replace('__LASTNAME__', $user->lastname, $msg);
		$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
		$msg = str_replace('__LESSON__', "$subject_name > $level_name", $msg);
		$msg = str_replace('__BODY__', $msg, $template);
		
		$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
		$this->email->to($email);
		$this->email->subject($subject.' - '.$GLOBALS['settings_global']->site_name);
		$this->email->message($msg);

		if(!$this->email->send()){
			echo $this->email->print_debugger();
			exit;
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
			send_email($email, $subject.' - '.$GLOBALS['settings_global']->site_name, $msg);
		}
		
		$this->db->where('id', $price->id)->update('prices', array('title' => NULL, 'description' => NULL, 'seo_link' => NULL, 'status' => NULL));

		f_redir(base_url('backend/users/prices_text'), lang('SUCCESS'));
	}	
	
	function uyeliktipsizler(){
		$users = $this->db->from('users')->where('status', 'N')->get()->result();
		$data = array();
		foreach($users as $user){
			echo "{$user->firstname},{$user->lastname},{$user->email},{$user->activation_code}<br />";
		}
	}
	
	
	function teachers()
	{
		$data['cities'] = $this->locationsmodel->get_locations('locations_cities', ['status' => 'A']);
		foreach($data['cities'] as $city)
		{
			$subjects = $this->db->from('contents_categories')->where('parent_id', 6)->get()->result();
			foreach($subjects as $subject)
			{
				$city->count_real[$subject->category_id] = $this->db
					->select('users.id')->distinct()
					->from('users')
					->join('locations', 'users.id=locations.uid', 'left')
					->join('prices', 'users.id=prices.uid', 'left')
					->where("locations.city", $city->this_id)
					->where('prices.subject_id', (int)$subject->category_id)
					->where('users.status', 'A')
					->where_in('users.ugroup', array(3,4,5))
					->count_all_results();

				$city->count_virtual[$subject->category_id] = $this->db
					->select('users.id')->distinct()
					->from('users')
					->join('locations', 'users.id=locations.uid', 'left')
					->join('prices', 'users.id=prices.uid', 'left')
					//virtual remove ->where("locations.city", $city->this_id)
					->where("(".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".city = ".$city->this_id.")")
					//virtual remove ->where('prices.subject_id', (int)$subject->category_id)
					->where("((".$this->db->dbprefix('users').".virtual = 'Y' && FIND_IN_SET(".$subject->category_id.", ".$this->db->dbprefix('users').".virtual_subjects)))")
					->where('users.status', 'A')
					->where_in('users.ugroup', array(3,4,5))
					->count_all_results();					
			}
			
		}
				
		$data['viewPage'] = $this->load->view('users/teachers', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}
	
	function get_ajax_teachers()
	{
		$search_term = trim($this->input->get('term', true));
		
		$this->db->select("id, firstname, lastname, mobile");
		$this->db->where("CONCAT_WS(' ', id, virtual_id, firstname, lastname, email, mobile) LIKE '%".$this->db->escape_str($search_term)."%' COLLATE utf8_general_ci", NULL, FALSE);
		$this->db->where_in('ugroup', array(3,4,5));
		
		$users = $this->db->from('users')->get()->result();
				
		if(!empty($users)){
			echo json_encode($users);
			exit;
		}
	}	
	
	public function messages(){
		check_perm('users_messages');
		
		$data = array();
		
		if($this->input->get('approve'))
		{
			$comment = $this->db->where('id', $this->input->get('approve', true))->from('messages')->get()->row();
			if(!empty($comment))
			{
				$this->db->where('id', $this->input->get('approve', true))->update('messages', array('approved' => 'Y'));
				
				$user = $this->db->where('id', $comment->to_uid)->from('users')->get()->row();
				//if(!empty($user)) $this->usersmodel->userpoint($user->id, 1, 1, 2);
			}
		}
		
		if($this->input->get('delete'))
		$this->db->where('id', $this->input->get('delete', true))->delete('messages');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/users/messages'), array(lang('SUCCESS')));
			}

			$this->db->start_cache();

			if($this->input->get_post('sSearch')){
				$this->db->like('c.message', $this->input->get_post('sSearch', true));
				$this->db->or_like('u1.firstname', $this->input->get_post('sSearch', true));
				$this->db->or_like('u2.firstname', $this->input->get_post('sSearch', true));
				$this->db->or_like('u1.lastname', $this->input->get_post('sSearch', true));
				$this->db->or_like('u2.lastname', $this->input->get_post('sSearch', true));				
			}

			if($this->input->get_post('sSearch_0')){
				if($this->input->get_post('sSearch_0') != 'all')
					$this->db->where('c.approved', $this->input->get_post('sSearch_0'));
			}/* else {
				$this->db->where('c.approved', 'N');
			}*/
			
			$this->db->from($this->db->dbprefix('messages').' c');
			$this->db->join($this->db->dbprefix('users').' u1', 'c.from_uid=u1.id', 'left');
			$this->db->join($this->db->dbprefix('users').' u2', 'c.to_uid=u2.id', 'left');
			$this->db->join($this->db->dbprefix('users_groups').' g1', 'u1.ugroup=g1.id', 'left');
			$this->db->join($this->db->dbprefix('users_groups').' g2', 'u2.ugroup=g2.id', 'left');			

			$this->db->stop_cache();

			$this->db->select('id');

			$total = $this->db->count_all_results();
			
			$this->db->set_dbprefix('');
			$this->db->select('c.*, u1.firstname as from_firstname, u1.lastname as from_lastname, u1.id as from_id, g1.name as from_groupname, u1.virtual as from_virtual, u2.firstname as to_firstname, u2.lastname as to_lastname, g2.name as to_groupname, u2.id to_id, u2.virtual as to_virtual');

			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}

			$items = $this->db->get()->result();

			$this->db->flush_cache();

			foreach($items as $item){
				if(!empty($item->joined))
				$item->nicetime = nicetime($item->joined);
			}
			$data['items'] = $items;

			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}

		$data['viewPage'] = $this->load->view('users/messages', $data, true);

		$result = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	
	
	public function register_mail($user_id){
		echo $this->db->from('users')->where('id', $user_id)->get()->row()->mail_response;
		exit;
	}		
			
}
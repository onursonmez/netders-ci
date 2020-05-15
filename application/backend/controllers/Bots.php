<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bots extends CI_Controller {
	
	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
		exit("İptal edildi.");
		check_perm('bots_overview');
		$this->load->model('locationsmodel');
	}

	public function index()
	{

		$this->load->library('curl');
		
		if($this->input->get('url')){

			$this->load->helper('cookie');
			set_cookie('last_bots_ozelders_url', $this->input->get('url'), 7200);
			set_cookie('last_bots_ozelders_page', $this->input->get('page'), 7200);
											
			$data['items'] = $this->_process_ozelders($this->input->get('url'), $this->input->get('page'));			
		}
		
		$data['viewPage'] = $this->load->view('bots/ozelders', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function ozeldersadd()
	{
		$res 		= 'err';
		$msg 		= 'Hata oluştu';
		
		if($this->db->from('users')->where('virtual_id', $this->input->post('id'))->count_all_results()){
			echo json_encode(array('res' => 'err', 'msg' => 'ID daha önce eklenmiştir!'));
			exit;			
		}
		
		if($this->input->post())
		{	
			/*
			Array
			(
			    	[firstname] => Mustafa
					[lastname] => A.
					[title] => Matematik Öğretmeni
			    	[city] => 1
					[town] => 4
					[price] => 70 - 100 TL/Saat
					[gender] => M
					[age] => 34
					[sekil] => 1,2
					[mekan] => 1,2,3
					[zaman] => 1,2,3,4
					[hizmet] => 3
					[short] => Matematik, Yabancı Dil, KPSS, TEOG, YDS, İngilizce
			    	[egitim] => <p>Lisans: Atatürk Üniversitesi, İlköğretim Matematik, 2004</p><p>Lise: Artvin Anadolu Öğretmen Lisesi, 2000</p>
					[dersler] => <p>İlköğretim Takviye: Matematik, Yabancı Dil</p><p>Lise Takviye: Yabancı Dil</p><p>Sınav Hazırlık: KPSS, TEOG, YDS</p><p>Yabancı Dil: İngilizce</p>
					[hakkinda] => Matematik öğrenmenin başrolünde öğrenci vardır.Öğrenmeyi gerçekten isteyen öğrencilerle her türlü başarıya ulaşacağımızı garanti ederim.
					[tecrube] => 11 yıldır özel ders vermekteyim. 0 505 833 38 76
			    	[id] => 95065
					[url] => http://www.ozelders.com/ders-veren/matematik-ogretmeni-mustafa-a-95065
			    [image] => http://blob.ozelders.com/profiles/pictures/95065_R.jpg
			)	
			*/

			if(!$this->input->post('city')){
				echo json_encode(array('res' => 'err', 'msg' => 'İl ID gönderilmedi!'));
				exit;			
			}
			
			if(!$this->input->post('town')){
				echo json_encode(array('res' => 'err', 'msg' => 'İlçe ID gönderilmedi!'));
				exit;			
			}
			
			if(!$this->input->post('gender')){
				echo json_encode(array('res' => 'err', 'msg' => 'Cinsiyet bilgisi gönderilmedi!'));
				exit;			
			}			
			
			if(!$this->input->post('age')){
				echo json_encode(array('res' => 'err', 'msg' => 'Yaş bilgisi gönderilmedi!'));
				exit;			
			}
			
			if(!$this->input->post('hakkinda') && !$this->input->post('tecrube')){
				echo json_encode(array('res' => 'err', 'msg' => 'Hakkında ve Tecrübe alanlarının en az bir tanesinin dolu olmaması gerekiyor!'));
				exit;			
			}			
					
			$username = unique_string('users', 'username', 8, 'numeric');
			
			$town = $this->input->post('town');
			if(!is_numeric($town)){
				$town_query = $this->locationsmodel->get_location('locations_towns', ['city_id' => (int)$this->input->post('city'), 'title' => $town], 'id');
				if(empty($town_query)){
					$this->db->insert('towns', ['city_id' => $this->input->post('city'), 'status' => 'A', 'title' => $town, 'seo_link' => seo($town)]);
					$town = $this->db->insert_id();
				} else {
					$town = $town_query;
				}
			}			
			
			$insert_data = array(
				'virtual' 				=> 'Y',
				'virtual_id' 			=> $this->input->post('id'),
				'virtual_url' 			=> $this->input->post('url'),
				'virtual_education' 	=> $this->input->post('egitim'),
				'virtual_subjects' 		=> $this->input->post('konular'),
				'virtual_levels' 		=> $this->input->post('dersler'),
				'virtual_price' 		=> $this->input->post('price'),
				'virtual_age' 			=> $this->input->post('age'),
				'firstname' 			=> $this->input->post('firstname'),
				'lastname' 				=> $this->input->post('lastname'),
				'city'					=> $this->input->post('city'),
				'town'					=> $town,
				'text_title'			=> $this->input->post('title'),
				'text_long'				=> $this->input->post('hakkinda'),
				'gender'				=> $this->input->post('gender'),
				'figures'				=> $this->input->post('sekil'),
				'places'				=> $this->input->post('mekan'),
				'times'					=> $this->input->post('zaman'),
				'services'				=> $this->input->post('hizmet'),
				'genders'				=> "1,2",
				
				'joined'				=> time(),
				'ugroup'				=> 3,
				'mobile'				=> '+90 532 '.rand(300,900).' XXXX',
				'status'				=> 'A',
				'username'				=> $username,
				'email'					=> 'destek@netders.com',
				'password'				=> md5(md5($username)),
				'password_text'			=> $username,
				'search_point'			=> 1,
				'activation_code'		=> md5(time())
			);
						
			if($this->input->post('image')){
				
				$this->load->library('curl');
				
				$ext = end(explode('.', $this->input->post('image')));
								
				$this->curl->options(array(CURLOPT_HEADER => 0, CURLOPT_BINARYTRANSFER => 1));
				//$this->curl->proxy($GLOBALS['settings_global']->proxy);
				$image = $this->curl->simple_get($this->input->post('image'));
				if($this->curl->error_string){
					echo json_encode(array('res' => 'err', 'msg' => $this->curl->error_string));
					exit;			
				}
				
				if(!empty($image)){
				    $fp = fopen(ROOTPATH . 'uploads/users/v/'.$username.'.'.$ext, 'x');
				    fwrite($fp, $image);
				    fclose($fp);					
				}
													
				if(file_exists(ROOTPATH . 'uploads/users/v/'.$username.'.'.$ext)){
					$insert_data['photo'] = 'uploads/users/v/'.$username.'.'.$ext;
				}
				
			}
			
			$this->db->insert('users', $insert_data);
			
			if($this->db->insert_id()){
				$res = 'ok';
			}
		}
		
		echo json_encode(array('res' => $res, 'msg' => $msg));
		exit;
	}	
	
	public function _process_ozelders($url, $page = 0){
		
		if(empty($url)) return false;
		
		$this->load->library('curl');
		
		$page = $page ? '/'.$page : '';
		
		//$this->curl->proxy($GLOBALS['settings_global']->proxy);
		$res = $this->curl->simple_get($url . $page);
		
		if($this->curl->error_string){
			exit($this->curl->error_string);
		}
		
		if(strstr($res, 'title-divider') == false){
			exit("Proxy çalışmadı, tekrar dene");
		}
		
		$res = strstr($res, '<h1 class="title-divider font-xs-x1');
		$res = trim($this->_extstres($res, '</h1>', '<ul class="pagination">'));
		$res = explode('<div class="row', $res);
		
		$profiles = array();
		
		sleep(1);
		
		foreach($res as $key => $profile)
		{
			if(!empty($profile))
			{
				$profiles[$key]['url'] = 'http://www.ozelders.com' . trim($this->_extstres($profile, 'data-url="', '">    <div'));
				$profiles[$key]['id'] = end(explode('-', $profiles[$key]['url']));
				
				if($this->db->from('users')->where('virtual_id', $profiles[$key]['id'])->count_all_results()) continue;
				
				$profiles[$key]['image'] = trim($this->_extstres($profile, '<img src="', '" class="img-thumbnail"'));
				$profiles[$key]['image'] = strstr($profiles[$key]['image'], 'w-300.png') == true || strstr($profiles[$key]['image'], 'm-300.png') == true ? '' : $profiles[$key]['image'];
				
				$fullname = trim($this->_extstres($profile, 'alt="', '" />'));
				$profiles[$key]['lastname'] = end(explode(' ', $fullname));
				$profiles[$key]['firstname'] = trim(str_replace($profiles[$key]['lastname'], '', $fullname));				
				
				$profiles[$key]['title'] = trim($this->_extstres($profile, '</p>            <p class="desc">', '</p>'));
				$location = trim($this->_extstres($profile, 'Bulunduğu Semt"></span> <span class="font-xs-x1">', '</span></li><li><span class="fa fa-book'));
				if(!empty($location)){
					$location_array = explode(', ', $location);
					$profiles[$key]['city'] = $this->locationsmodel->get_location('locations_cities', ['title' => $location_array[1]], 'id');
					$town = $this->locationsmodel->get_location('locations_towns', ['city_id' => $profiles[$key]['city']], 'id');
					if(!empty($town)){
						$profiles[$key]['town'] = $town;
					} else {
						$profiles[$key]['town'] = $location_array[0];
					}
				}
								
				$profiles[$key]['short'] = trim($this->_extstres($profile, '<span class="font-xs-x1">', '</span></li><li><span class="fa fa-map'));
				$profiles[$key]['short'] = strstr($profiles[$key]['short'], '</span>') == true ? '' : $profiles[$key]['short'];				
				$lessons = trim($this->_extstres($profile, 'Ders Verdiği Alanlar"></span> <span class="font-xs-x1">', '</span></li><li><span class="fa fa-car'));
				$profiles[$key]['short'] = $profiles[$key]['short'] ? $profiles[$key]['short'] : $lessons;
				$profiles[$key]['price'] = trim($this->_extstres($profile, 'Ders Saat Ücreti"></span> <span class="font-xs-x1">', '</span></li></ul>        </div>    </div>'));
				
				if(!empty($profiles[$key]['url'])){
					//$this->curl->proxy($GLOBALS['settings_global']->proxy);
					$profile_page = $this->curl->simple_get($profiles[$key]['url']);
					if($this->curl->error_string){
						echo $this->curl->error_string;
						continue;
					}
					if(strstr($profile_page, '<div class="profile">') == false){
						echo "Proxy profili getiremedi";
					}					
					$profile_page = strstr($profile_page, '<div class="profile">');
					$profile_page = trim($this->_extstres($profile_page, '<div class="col-md-8">', '<div id="ajax-report-form">'));
					$profile_go = $profile_page;
					$gender = trim($this->_extstres($profile_page, '<p class="role">'.$profiles[$key]['title'].'</p>            <p>', '</p>            <ul>'));
					
					if(!empty($gender)){
						$gender_array = explode(', ', $gender);
						foreach($gender_array as $gender_item){
							if($gender_item == 'Bay') $profiles[$key]['gender'] = 'M';
							if($gender_item == 'Bayan') $profiles[$key]['gender'] = 'F';
							if(strstr($gender_item, 'Yaşında') == true) $profiles[$key]['age'] = str_replace(' Yaşında', '', $gender_item);
						}
					}
					
					//$profiles[$key]['phone'] = '+90 '.trim($this->_extstres($profile_page, '<i class="fa fa-phone fa-fw"></i> ', 'XX XX'));
					//$profiles[$key]['phone'] = $profiles[$key]['phone'] != '+90 ' ? $profiles[$key]['phone'] . ' XX XX' : '';
					
					$egitim_duzeyi = trim($this->_extstres($profile_go, '<span>Eğitim Düzeyi</span>', '<div class="row">'));
					$profiles[$key]['egitim'] = trim($this->_extstres($egitim_duzeyi, '</h5>', '</div>'));
					
					$dersler = trim($this->_extstres($profile_go, '<span>Ders Verdiği Alanlar</span>', '<div class="row">'));
					$dersler = trim($this->_extstres($dersler, '</h5>', '</div>'));
					$subject_ids = array();
					$level_ids = array();
					$no_levels = array();
					
					if(!empty($dersler)){
						$dersler_array = array();
						$count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $dersler, $matches);
						for ($i = 0; $i < $count; ++$i) {
						    $dersler_array[] = $matches[0][$i];
						}
						
						if(!empty($dersler_array))
						{
							foreach($dersler_array as $dersler_item){
								$items = explode(': ', $dersler_item);
								$subject = str_replace('<p>', '', $items[0]);
								$subject = str_replace('</p>', '', $subject);
								$subject_category = $this->db->from('contents_categories')->where('parent_id', 6)->where('title', $subject)->get()->row();
								if(!empty($subject_category)){
									$subject_ids[] = $subject_category->category_id;	
								} else {
									$subject_ids[] = $subject;
								}
								$levels = explode(', ', $items[1]);
			
								if(!empty($levels))
								{
									foreach($levels as $level)
									{
										$level = str_replace('<p>', '', $level);
										$level = str_replace('</p>', '', $level);
										$level_category = $this->db->from('contents_categories')->where('parent_id', $subject_category->category_id)->where('title', $level)->get()->row();
										if(empty($level_category) && strstr($level, 'Müh.') == true){
											$level_category = $this->db->from('contents_categories')->where('parent_id', $subject_category->category_id)->where('title', str_replace('Müh.', 'Mühendisliği', $level))->get()->row();	
										}
										if(!empty($level_category)){
											$level_ids[] = $level_category->category_id;	
										} else {
											$level_ids[] = $level;
											$no_levels[] = $subject_category->title.": $level";
										}
									}
								}
							}
							$profiles[$key]['no_levels'] = implode('|', $no_levels);
							$profiles[$key]['konular'] = implode(',', $subject_ids);
							$profiles[$key]['dersler'] = implode(',', $level_ids);
						}
					}					
					
					$hakkinda = trim($this->_extstres($profile_go, '<span>Kişisel Bilgiler</span>', '<div class="row">'));
					$profiles[$key]['hakkinda'] = trim($this->_extstres($hakkinda, '<p>', '</p>'));					

					$tecrube = trim($this->_extstres($profile_go, '<span>Özel Ders Tecrübesi</span>', '<div class="row">'));
					$profiles[$key]['tecrube'] = trim($this->_extstres($tecrube, '<p>', '</p>'));										

					$sekil = trim($this->_extstres($profile_go, '<span>Ders Verdiği Şekiller</span>', '<div class="row">'));
					if(!empty($sekil)){
						$profiles[$key]['sekil'] = trim($this->_extstres($sekil, '<p>', '</p>'));
						if(!empty($profiles[$key]['sekil']))
						{
							$profiles[$key]['sekil'] = str_replace(', ', ',', $profiles[$key]['sekil']);
							$sekil_array = explode(',', $profiles[$key]['sekil']);
							if(!empty($sekil_array)){
								$sekil_item_array = array();
								foreach($sekil_array as $sekil_item){
									if($sekil_item == 'Birebir Ders'){
										$sekil_item_array[] = 1;
									}
									if($sekil_item == 'Grup Dersi'){
										$sekil_item_array[] = 2;
									}									
								}
								if(!empty($profiles[$key]['sekil'])){
									$profiles[$key]['sekil'] = implode(',', $sekil_item_array);
								}
							}
						}
					}
															
					$mekan = trim($this->_extstres($profile_go, '<span>Ders Verdiği Mekanlar</span>', '<div class="row">'));
					if(!empty($mekan)){
						$profiles[$key]['mekan'] = html_entity_decode(trim($this->_extstres($mekan, '<p>', '</p>')));
						if(!empty($profiles[$key]['mekan']))
						{
							$profiles[$key]['mekan'] = str_replace(', ', ',', $profiles[$key]['mekan']);
							$mekan_array = explode(',', $profiles[$key]['mekan']);
							if(!empty($mekan_array)){
								$mekan_item_array = array();
								foreach($mekan_array as $mekan_item){
									if(strstr($mekan_item, 'Öğrencinin Evi') == true){
										$mekan_item_array[] = 1;
									}
									if(strstr($mekan_item, 'Öğretmenin Evi') == true){
										$mekan_item_array[] = 2;
									}
									if(strstr($mekan_item, 'Etüd Merkezi') == true){
										$mekan_item_array[] = 3;
									}
									if(strstr($mekan_item, 'Kütüphane') == true){
										$mekan_item_array[] = 4;
									}									
								}
								if(!empty($profiles[$key]['mekan'])){
									$profiles[$key]['mekan'] = implode(',', $mekan_item_array);
								}
							}
						}
					}					
					
					$zaman = trim($this->_extstres($profile_go, '<span>Ders İçin Uygun Olduğu Zamanlar</span>', '<div class="row">'));
					if(!empty($zaman) && strstr($zaman, 'scheduler') == false){
						$profiles[$key]['zaman'] = html_entity_decode(trim($this->_extstres($zaman, '<p>', '</p>')));
						if(!empty($profiles[$key]['zaman']))
						{
							$profiles[$key]['zaman'] = str_replace(', ', ',', $profiles[$key]['zaman']);
							$zaman_array = explode(',', $profiles[$key]['zaman']);
							if(!empty($zaman_array)){
								$zaman_item_array = array();
								foreach($zaman_array as $zaman_item){
									if($zaman_item == 'Hafta İçi Gündüz'){
										$zaman_item_array[] = 1;
									}
									if($zaman_item == 'Hafta İçi Akşam'){
										$zaman_item_array[] = 2;
									}
									if($zaman_item == 'Hafta Sonu Gündüz'){
										$zaman_item_array[] = 3;
									}							
									if($zaman_item == 'Hafta Sonu Akşam'){
										$zaman_item_array[] = 4;
									}											
								}
								if(!empty($profiles[$key]['zaman'])){
									$profiles[$key]['zaman'] = implode(',', $zaman_item_array);
								}
							}
						}
					}
					
					$hizmet = trim($this->_extstres($profile_go, '<span>Sunduğu Hizmetler</span>', '<div class="row">'));
					if(!empty($hizmet)){
						$profiles[$key]['hizmet'] = html_entity_decode(trim($this->_extstres($hizmet, '<p>', '</p>')));
						if(!empty($profiles[$key]['hizmet']))
						{
							$profiles[$key]['hizmet'] = str_replace(', ', ',', $profiles[$key]['hizmet']);
							$hizmet_array = explode(',', $profiles[$key]['hizmet']);
							if(!empty($hizmet_array)){
								$hizmet_item_array = array();
								foreach($hizmet_array as $hizmet_item){
									if($hizmet_item == 'Ödev/Tez Yardımı'){
										$hizmet_item_array[] = 1;
										$hizmet_item_array[] = 2;
									}
									if($hizmet_item == 'Proje Yardımı'){
										$hizmet_item_array[] = 3;
									}
									if($hizmet_item == 'Eğitim Koçluğu'){
										$hizmet_item_array[] = 4;
									}							
									if($hizmet_item == 'Yaşam Koçluğu'){
										$hizmet_item_array[] = 5;
									}											
								}
								if(!empty($profiles[$key]['hizmet'])){
									$profiles[$key]['hizmet'] = implode(',', $hizmet_item_array);
								}
							}
						}
					}
				}
			}	
			
			sleep(1);		
		}	
				
		return $profiles;	
	}
	
	public function _extstres($content, $start, $end)
	{
		if ((($content and $start) and $end))
		{
			$r = explode($start, $content);
			if (isset($r[1]))
			{
					$r = explode($end, $r[1]);
					return $r[0];
			}
			return '';
		}
	}	
}
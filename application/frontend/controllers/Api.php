<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {


   public function __construct()
   {
        parent::__construct();
		$this->config->set_item('language', $this->session->userdata('site_sl'));
		$this->load->model('users_model');
		$this->load->model('locations_model');
    }

	public function virtual_check_id($id)
	{
		$users = $this->db->from('users')->where('virtual_id', (int)$id)->count_all_results();
		if(empty($users)){
			echo $this->db->from('users_virtual_blocked')->where('virtual_id', (int)$id)->count_all_results();
		} else {
			echo $users;
		}
	}

	public function virtual_city_id_by_name()
	{
		$name = $this->input->get('name');
		$name = base64_decode($name);
		echo $this->locations_model->get_location('locations_cities', ['title' => $this->security->xss_clean($name)], 'id');
	}

	public function virtual_get_town_id_by_name(){
		$city_id = $this->input->get('city_id');
		$name = $this->input->get('name');
		$name = base64_decode($name);
		echo $this->locations_model->get_location('locations_towns', ['city_id' => (int)$city_id, 'title' => $this->security->xss_clean($name)], 'id');
	}

	public function virtual_get_lesson_category_by_title(){
		$title = $this->input->get('title');
		$title = base64_decode($title);
		echo json_encode($this->db->from('contents_categories')->where('parent_id', 6)->where('title', $this->security->xss_clean($title))->get()->row());
	}

	public function virtual_get_lesson_category_by_parent_id_title(){
		$parent_id = $this->input->get('parent_id');
		$title = $this->input->get('title');
		$title = base64_decode($title);
		echo json_encode($this->db->from('contents_categories')->where('parent_id', (int)$parent_id)->where('title', $this->security->xss_clean($title))->get()->row());
	}

	public function virtual_get_lesson_category_by_parent_id_title3(){
		$parent_id = $this->input->get('parent_id');
		$title = $this->input->get('title');
		echo $title;
	}

	public function virtual_get_lesson_category_by_parent_id_title2(){
		$parent_id = $this->input->get('parent_id');
		$title = $this->input->get('title');
		$title = base64_decode($title);
		echo json_encode($this->db->from('contents_categories')->where('parent_id', (int)$parent_id)->where('title', str_replace('Müh.', 'Mühendisliği', $this->security->xss_clean($title)))->get()->row());
	}

	public function virtual_insert()
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
				$town_query = $this->locations_model->get_location('locations_towns', ['city_id' => (int)$this->input->post('city'), 'title' => $town], 'id');
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

			$this->db->insert('users', $insert_data);

			if($this->db->insert_id()){
				$res = 'ok';
				$msg = $username;
			}
		}

		echo json_encode(array('res' => $res, 'msg' => $msg));
		exit;
	}

	public function virtual_delete(){
		$id = $this->input->get('id');
		$check = $this->db->from('users_virtual_blocked')->where('virtual_id', (int)$id)->count_all_results();
		if(empty($check)){
			$this->db->insert('users_virtual_blocked', array('virtual_id' => (int)$id));
			echo json_encode(array('res' => "ok"));
			exit;
		} else {
			echo json_encode(array('res' => "ok"));
			exit;
		}


	}

	public function virtual_insert_image()
	{
		$username = $this->input->get('username');
		$ext = $this->input->get('ext');

		$this->db->where('username', (int)$username)->update('users', array('photo' => 'uploads/users/v/'.$username.'.'.$ext));
	}

	public function get_users()
	{

		$data 						= array();

		$search_data 				= array(
			'city_id'				=> $this->input->get('city')			? (int)$this->input->get('city')											: null,
			'town_id'				=> $this->input->get('town')			? (int)$this->input->get('town')											: null,
			'subject_id'			=> $this->input->get('subject')			? (int)$this->input->get('subject')											: null,
			'level_id'				=> $this->input->get('level')			? (int)$this->input->get('level')											: null,
			'live'					=> $this->input->get('live') 			? (int)$this->input->get('live', true) 										: null,
			'figure'				=> $this->input->get('figure') 			? array_map('intval', array_values($this->input->get('figure', true))) 		: null,
			'place'					=> $this->input->get('place') 			? array_map('intval', array_values($this->input->get('place', true))) 		: null,
			'time'					=> $this->input->get('time') 			? array_map('intval', array_values($this->input->get('time', true))) 		: null,
			'service'				=> $this->input->get('service') 		? array_map('intval', array_values($this->input->get('service', true))) 	: null,
			'group'					=> $this->input->get('group') 			? array_map('intval', array_values($this->input->get('group', true))) 		: null,
			'price_min'				=> $this->input->get('price_min') 		? (int)$this->input->get('price_min', true) 								: null,
			'price_max'				=> $this->input->get('price_max') 		? (int)$this->input->get('price_max', true) 								: null,
			'keyword'				=> $this->input->get('keyword') 		? $this->input->get('keyword', true) 										: null,
			'keyword_lesson_ids'	=> $this->input->get('keyword')			? $this->db->from('settings_search')->like('keyword', $this->db->escape_str($this->input->get('keyword')), 'both')->get()->row()->lesson_ids	: null,
			'discount7'				=> $this->input->get('d1') 				? (int)$this->input->get('d1', true) 										: null,
			'discount8'				=> $this->input->get('d2') 				? (int)$this->input->get('d2', true) 										: null,
			'discount9'				=> $this->input->get('d3') 				? (int)$this->input->get('d3', true) 										: null,
			'discount10'			=> $this->input->get('d4') 				? (int)$this->input->get('d4', true) 										: null,
			'discount11'			=> $this->input->get('d5') 				? (int)$this->input->get('d5', true) 										: null,
			'discount_live'			=> $this->input->get('d6') 				? (int)$this->input->get('d6', true) 										: null,
			'discount12'			=> $this->input->get('d7') 				? (int)$this->input->get('d7', true) 										: null,
			'discount13'			=> $this->input->get('d8') 				? (int)$this->input->get('d8', true) 										: null,
			'badge'					=> $this->input->get('badge') 			? (int)$this->input->get('badge', true) 									: null,
			'online'				=> $this->input->get('online') 			? (int)$this->input->get('online', true) 									: null,
			'sort_price'			=> $this->input->get('sort_price')		? $this->input->get('sort_price', true)										: null,
			'sort_point'			=> $this->input->get('sort_point')		? $this->input->get('sort_point', true)										: null,
			'page'					=> $this->input->get('page') 			? (int)$this->input->get('page', true) 										: 1,
			'limit'					=> $this->input->get('limit') 			? (int)$this->input->get('limit', true) 									: 10,
			'photo'					=> $this->input->get('photo') 			? (int)$this->input->get('photo', true) 									: 1
		);

		$users						= $this->users_model->get_users_by_search($search_data);
		$data['users'] 				= $users['users'];
		$data['total'] 				= $users['total'];

		echo json_encode($data);
		exit;
	}

	public function get_user()
	{
		if(!$this->input->get('id')) return false;

		$user = $this->users_model->get_user_data(['id' => $this->input->get('id')]);

		echo json_encode($user);
		exit;
	}

	public function bbb_create()
	{
		$this->load->library('bigbluebutton');
		$response = $this->bigbluebutton->create_meeting(1, "İngilizce Özel Ders", 60, 123456, 654321, 2, site_url());

		print_r($response);
	}

	public function bbb_join()
	{
		$this->load->library('bigbluebutton');
		$this->bigbluebutton->join_meeting(1, 1, "Onur Sönmez", 123456);
	}

	public function bbb_running($meeting_id)
	{
		$this->load->library('bigbluebutton');
		$response = $this->bigbluebutton->isMeetingRunningWithXmlResponseArray($meeting_id);

		print_r($response);
	}
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	var $template = 'pages/wrapper';
	var $template2 = 'pages/my';
	var $folder_prefix 	= '';

   public function __construct()
	 {
		 	parent::__construct();

			$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->load->model('payment_model');
			$this->load->model('users_model');
			$this->load->model('locations_model');
			$this->config->set_item('language', $this->session->userdata('site_sl'));
			//if(getip() == '31.206.57.102') $this->logout();
			if($this->session->userdata('user_nopassword') == 1 && $this->router->fetch_method() != 'passwordchange' && $this->router->fetch_method() != 'view' && $this->router->fetch_method() != 'index' && $this->router->fetch_method() != 'sendmessage') redir(site_url('users/passwordchange'));
			if($this->session->userdata('user_status') == 'N' && $this->router->fetch_method() != 'passwordchange' && $this->router->fetch_method() != 'choice' && $this->router->fetch_method() != 'captcha' && $this->router->fetch_method() != 'logout' && $this->router->fetch_method() != 'view' && $this->router->fetch_method() != 'index') redir(site_url('users/choice'));
			if($this->session->userdata('user_status') == 'C' && $this->router->fetch_method() != 'passwordchange' && $this->router->fetch_method() != 'reactivate' && $this->router->fetch_method() != 'captcha' && $this->router->fetch_method() != 'logout' && $this->router->fetch_method() != 'view' && $this->router->fetch_method() != 'index') redir(site_url('users/reactivate'));
    }

    public function generate_search_link()
    {
		$url = array();

		parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $query_strings);

		$url = 'ozel-ders-ilanlari-verenler/';

		if($this->input->get('city'))
		{
			$url .= $this->locations_model->get_location('locations_cities', ['id' => (int)$this->input->get('city', true)], 'seo_link');
			unset($query_strings['city']);
		} else {
			$url .= $this->locations_model->get_location('locations_cities', ['id' => (int)$this->session->userdata('site_city', true)], 'seo_link');
			unset($query_strings['city']);
		}

		if($this->input->get('town'))
		{
			$url .= '-'.$this->locations_model->get_location('locations_towns', ['id' => (int)$this->input->get('town', true)], 'seo_link');
			unset($query_strings['town']);
		}

		$url .= '/';

		if($this->input->get('subject')){
			$url .= seo($this->db->select('title')->from('contents_categories')->where('category_id', (int)$this->input->get('subject', true))->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title);
			unset($query_strings['subject']);
		}

		if($this->input->get('level')){
			$url .= '-'.seo($this->db->select('title')->from('contents_categories')->where('category_id', (int)$this->input->get('level', true))->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title);
			unset($query_strings['level']);
		}

		if($this->input->get('subject') || $this->input->get('level'))
		$url .= '/';

		$query_strings = !empty($query_strings) ? '?' . http_build_query($query_strings) : '';

		$response = site_url($url . $this->security->xss_clean($query_strings));

		if($this->input->is_ajax_request()) exit($response);

		return $response;
    }

	public function index($citytown = null, $subjectlevel = null)
	{
		$data		= array();

		$city 		= find_seo_link_get_id('city', $citytown);
		$town 		= find_seo_link_get_id('town', $citytown, $city);
		$subject 	= find_seo_link_get_id('subject', $subjectlevel);
		$level 		= find_seo_link_get_id('level', $subjectlevel);

		//Talep formu
		if($this->input->post('form') && $this->input->post('form') == 'request_search')
		{
			$errors = array();
			$messages = array();
			$redir = null;

			$this->form_validation->set_rules('fullname', 'Adınız soyadınız alanını boş bırakmayınız', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Telefon numaranız alanını boş bırakmayınız', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if($this->form_validation->run() == FALSE)
			{
				$errors = $this->form_validation->error_array();
			} else {
				$this->users_model->insert_requests_wait($this->input->post());
				$messages[] = 'Talebiniz başarıyla alınmıştır. Müşteri temsilcilerimiz en kısa süre içerisinde size dönüş yapacaktır.';
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && (!empty($errors) || !empty($messages)))
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir($redir, $messages);
				}
			}
		}

		//Onlem amacli, normalde aramada link generate edip submit ettiriliyor
		if($this->input->get('city') || $this->input->get('town') || $this->input->get('subject') || $this->input->get('level'))
		{
			redirect($this->generate_search_link(), 'location', 301);
		}

		$this->session->set_userdata('site_city', $city);
		$this->session->set_userdata('site_town', $town);
		$this->session->set_userdata('site_subject', $subject);
		$this->session->set_userdata('site_level', $level);

		$search_data 				= array(
			'city_id'				=> (int)$city,
			'town_id'				=> (int)$town,
			'subject_id'			=> (int)$subject,
			'level_id'				=> (int)$level,
			'figure'				=> $this->input->get('figure') 			? array_map('intval', array_values($this->input->get('figure', true))) 		: null,
			'live'					=> $this->input->get('live') 			? (int)$this->input->get('live', true) 										: null,
			'gender'				=> $this->input->get('gender') 			? $this->input->get('gender', true) 										: null,
			'place'					=> $this->input->get('place') 			? array_map('intval', array_values($this->input->get('place', true))) 		: null,
			'time'					=> $this->input->get('time') 			? array_map('intval', array_values($this->input->get('time', true))) 		: null,
			'service'				=> $this->input->get('service') 		? array_map('intval', array_values($this->input->get('service', true))) 	: null,
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
			'group'					=> $this->input->get('group') 			? array_map('intval', array_values($this->input->get('group', true))) 		: null,
			'badge'					=> $this->input->get('badge') 			? (int)$this->input->get('badge', true) 									: null,
			'online'				=> $this->input->get('online') 			? (int)$this->input->get('online', true) 									: null,
			'sort_price'			=> $this->input->get('sort_price')		? $this->input->get('sort_price', true)										: null,
			'sort_point'			=> $this->input->get('sort_point')		? $this->input->get('sort_point', true)										: null,
			'page'					=> $this->input->get('page') 			? (int)$this->input->get('page', true) 										: 1
		);

		if ( ! $data = $this->cache->get('users_' . md5(serialize($search_data))))
		{
			$users								= $this->users_model->get_users_by_search($search_data);
			$data['users'] 						= $users['users'];
			$data['total'] 						= $users['total'];
			$data['users_special']['month'] 	= $this->users_model->get_user_month($search_data);
			$data['users_special']['week'] 		= $this->users_model->get_user_week($search_data);
			$data['users_special']['day'] 		= $this->users_model->get_user_day($search_data);
			$data['cities']						= $this->locations_model->get_locations('locations_cities', ['status' => 'A']);
			$data['subjects'] 					= $this->users_model->get_subjects();
			$data['pages'] 						= pagenav($users['total'],$search_data['page'],20,current_url());

			if(empty($data['total']))
			{
				$latest_users = $this->users_model->get_users_by_search(array('virtual' => 'N', 'limit' => 10, 'sort_date' => 'desc', 'photo' => 1));
				foreach($latest_users['users'] as $user){
					$levels = $this->db->select('l.title')->from('prices p')->join('contents_categories l', 'p.level_id=l.category_id')->where('l.lang_code', $this->session->userdata('site_sl'))->where('p.uid', $user->id)->get()->result();
					if(!empty($levels)){
						$user_level = array();
						foreach($levels as $level){
							$user_level[] = $level->title;
						}
						$user->levels = implode(', ', array_unique($user_level));
					}
				}
				$data['latest_users'] = $latest_users['users'];
			}

			parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $query_strings);
			$query_strings = !empty($query_strings) ? '?' . http_build_query($query_strings) : '';

			if(!empty($search_data['city_id']))
			{
				$city_title = $this->locations_model->get_location('locations_cities', ['id' => $search_data['city_id']], 'title');
				$data['breadcrumb'][] =  array(
					'title' => $city_title,
					'link' => site_url('ozel-ders-ilanlari-verenler/' . seo($city_title) . $query_strings)
				);
			}

			if(!empty($search_data['town_id']))
			{
				$town_title = $this->locations_model->get_location('locations_towns', ['id' => $search_data['town_id']], 'title');
				$data['breadcrumb'][] =  array(
					'title' => $town_title,
					'link' => site_url('ozel-ders-ilanlari-verenler/' . seo($city_title) . '-' . seo($town_title) . $query_strings)
				);
			}

			if(!empty($search_data['subject_id']))
			{
				$subject_name = $this->users_model->get_category_name_by_id($search_data['subject_id']);
				$url = !empty($town_title) ? site_url('ozel-ders-ilanlari-verenler/' . seo($city_title) . '-' . seo($town_title) .'/'. seo($subject_name) . $query_strings) : site_url('ozel-ders-ilanlari-verenler/' . seo($city_title) .'/'. seo($subject_name) . $query_strings);
				$data['breadcrumb'][] =  array(
					'title' => $subject_name,
					'link' => $url . $query_strings
				);
			}

			if(!empty($search_data['level_id']))
			{
				$level_name = $this->users_model->get_category_name_by_id($search_data['level_id']);
				$data['breadcrumb'][] =  array(
					'title' => $level_name . ' Özel Ders',
					'link' => current_url()
				);
			}

			if(isset($city_title) && isset($town_title) && isset($subject_name) && isset($level_name)){
				$data['text'] = $this->db->select('lesson_top_text, description')->from('contents')->where('lesson_url', seo($city_title) . '-' . seo($town_title) . '-' . seo($subject_name) . '-' . seo($level_name))->where('main_category', 573)->get()->row();
				$data['seo_title'] = "$level_name Özel Ders Verenler $subject_name $town_title $city_title";
				$data['seo_description'] = "$level_name özel ders verenler bu sayfada. $city_title ".txtLower($town_title)." ".txtLower($subject_name)." ".txtLower($level_name)." özel ders ilanları arayanlar için uzman eğitmenler.";
				$data['seo_keyword'] = txtLower("$city_title $town_title $subject_name $level_name özel ders verenler, $city_title $town_title $subject_name $level_name özel ders ilanları, $city_title $town_title $subject_name $level_name özel ders veren öğretmenler, $city_title $town_title $subject_name $level_name özel ders veren hocalar, $city_title $town_title $subject_name $level_name özel ders almak istiyorum, $city_title $town_title $subject_name $level_name özel ders vermek istiyorum");
			}

			if(isset($city_title) && isset($subject_name) && !isset($level_name) && !isset($town_title)){
				$data['text'] = $this->db->select('lesson_top_text, description')->from('contents')->where('lesson_url', seo($city_title) . '-' . seo($town_title) . '-' . seo($subject_name) . '-' . seo($level_name))->where('main_category', 573)->get()->row();
				$data['seo_title'] = "$subject_name Özel Ders Verenler $city_title";
				$data['seo_description'] = "$city_title ".txtLower($subject_name)." özel ders verenler bu sayfada. $city_title ".txtLower($subject_name)." özel ders ilanları arayanlar için uzman eğitmenler.";
				$data['seo_keyword'] = txtLower("$city_title $subject_name özel ders verenler, $city_title $subject_name özel ders ilanları, $city_title $subject_name özel ders veren öğretmenler, $city_title $subject_name özel ders veren hocalar, $city_title $subject_name özel ders almak istiyorum, $city_title $subject_name özel ders vermek istiyorum");
			}

			if(isset($city_title) && isset($subject_name) && isset($level_name) && !isset($town_title)){
				$data['text'] = $this->db->select('lesson_top_text, description')->from('contents')->where('lesson_url', seo($city_title) . '-' . seo($town_title) . '-' . seo($subject_name) . '-' . seo($level_name))->where('main_category', 573)->get()->row();
				$data['seo_title'] = "$level_name Özel Ders Verenler $subject_name $city_title";
				$data['seo_description'] = "$level_name özel ders verenler bu sayfada. $city_title ".txtLower($level_name)." ".txtLower($subject_name)." özel ders ilanları arayanlar için uzman eğitmenler.";
				$data['seo_keyword'] = txtLower("$city_title $subject_name $level_name özel ders verenler, $city_title $subject_name $level_name özel ders ilanları, $city_title $subject_name $level_name özel ders veren öğretmenler, $city_title $subject_name $level_name özel ders veren hocalar, $city_title $subject_name $level_name özel ders vermek istiyorum, $city_title $subject_name $level_name özel ders almak istiyorum");
			}

			if(isset($city_title) && isset($town_title) && isset($subject_name) && !isset($level_name)){
				$data['text'] = $this->db->select('lesson_top_text, description')->from('contents')->where('lesson_url', seo($city_title) . '-' . seo($town_title) . '-' . seo($subject_name))->where('main_category', 573)->get()->row();
				$data['seo_title'] = "$subject_name Özel Ders Verenler $town_title $city_title";
				$data['seo_description'] = "$city_title ".txtLower($town_title)." ".txtLower($subject_name)." özel ders verenler bu sayfada. $city_title ".txtLower($town_title)." ".txtLower($subject_name)." özel ders ilanları arayanların, uzman eğitmenlere ulaştığı eğitim portalı.";
				$data['seo_keyword'] = txtLower("$city_title $town_title $subject_name özel ders verenler, $city_title $town_title $subject_name özel ders ilanları, $city_title $town_title $subject_name özel ders veren öğretmenler, $city_title $town_title $subject_name veren hocalar, $city_title $town_title $subject_name özel ders vermek istiyorum, $city_title $town_title $subject_name özel ders almak istiyorum");
			}

			if(isset($city_title) && isset($town_title) && !isset($subject_name) && !isset($level_name)){
				$data['text'] = $this->db->select('lesson_top_text, description')->from('contents')->where('lesson_url', seo($city_title) . '-' . seo($town_title))->where('main_category', 573)->get()->row();
				$data['seo_title'] = "$town_title Özel Ders Verenler - $city_title";
				$data['seo_description'] = "$city_title ".txtLower($town_title)." özel ders verenler bu sayfada. $city_title ".txtLower($town_title)." özel ders ilanları arayanların, uzman eğitmenlere ulaştığı eğitim portalı.";
				$data['seo_keyword'] = txtLower("$city_title $town_title özel ders verenler, $city_title $town_title özel ders ilanları, $city_title $town_title özel ders veren öğretmenler, $city_title $town_title özel ders veren hocalar, $city_title $town_title özel ders vermek istiyorum, $city_title $town_title özel ders almak istiyorum");
			}

			if(isset($city_title) && !isset($town_title) && !isset($subject_name) && !isset($level_name)){
				$keyword = $search_data['keyword'] ? txtWordUpper($search_data['keyword']) : '';
				$data['text'] = $this->db->select('lesson_top_text, description')->from('contents')->where('lesson_url', seo($city_title))->where('main_category', 573)->get()->row();
				$data['seo_title'] = "$city_title $keyword Özel Ders Verenler ve $city_title $keyword Özel Ders İlanları";
				$data['seo_description'] = "$city_title $keyword özel ders verenler bu sayfada. $city_title $keyword özel ders ilanları arayanların, uzman eğitmenlere ulaştığı eğitim portalı.";
				$data['seo_keyword'] = txtLower("$city_title $keyword özel ders verenler, $city_title $keyword özel ders ilanları, $city_title $keyword özel ders veren öğretmenler, $city_title $keyword özel ders veren hocalar, $city_title $keyword özel ders vermek istiyorum, $city_title $keyword özel ders almak istiyorum");
			}

			$data['city_title'] = isset($city_title) ? $city_title : null;
			$data['town_title'] = isset($town_title) ? $town_title : null;
			$data['subject_name'] = isset($subject_name) ? $subject_name : null;
			$data['level_name'] = isset($level_name) ? $level_name : null;

			// Save into the cache for 1 day
			$this->cache->save('users_' . md5(serialize($search_data)), $data, 60*60*24);
		}

		$this->session->set_userdata('last_search', current_url());

		$data['viewPage'] = $this->load->view($this->folder_prefix . 'users/index', $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

    public function choice($choice = null)
    {
    	is_notloggedin_redir(site_url('giris'));

    	if($this->session->userdata('user_status') != 'N') redir(site_url('users/my'));

    	$data = array();

    	if(!empty($choice)){
	    	$user_group = $choice == 'student' ? 2 : 3;
	    	$search_point = $user_group == 3 ? point('starter') : NULL;
	    	$status = $user_group == 3 ? 'R' : 'A';

			$update_data = array(
				'ugroup' 		=> $user_group,
				'search_point' 	=> $search_point,
				'status'		=> $status
			);

			if($user_group == 3){
				$update_data['figures'] = '1,2';
				$update_data['places'] = '1,2,3,4,5';
				$update_data['times'] = '1,2,3,4';
				$update_data['services'] = '1,2,3,4,5';
				$update_data['genders'] = '1,2';
			}
	    	$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
	    	redir(site_url('users/my'), array(lang('SUCCESS')));
    	}

		$data['viewPage'] = $this->load->view('users/choice', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
    }

    public function reactivate($choice = null)
    {
    	is_notloggedin_redir(site_url('giris'));

    	if($this->session->userdata('user_status') != 'C') redir(site_url('users/my'));

    	$data = array();

    	if(!empty($choice)){
	    	$user_group = $choice == 'student' ? 2 : 3;
	    	$search_point = $user_group == 3 ? point('starter') : NULL;
	    	$status = $user_group == 3 ? 'R' : 'A';

			$update_data = array(
				'ugroup' 		=> $user_group,
				'search_point' 	=> $search_point,
				'status'		=> $status
			);

			if($user_group == 3){
				$update_data['figures'] = '1,2';
				$update_data['places'] = '1,2,3,4,5';
				$update_data['times'] = '1,2,3,4';
				$update_data['services'] = '1,2,3,4,5';
				$update_data['genders'] = '1,2';
			}
	    	$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
	    	redir(site_url('users/my'), array(lang('SUCCESS')));
    	}

		$data['viewPage'] = $this->load->view('users/choice', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
    }

    public function required()
    {
    	is_notloggedin_redir(site_url('giris'));

    	if($this->session->userdata('user_status') != 'R' || !required_profile_fields()) redir(site_url('users/my'));

    	$data = array();

		$data['required'] = required_profile_fields();
		$data['viewPage'] = $this->load->view('users/required', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
    }

	public function my()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/personal'));

		$data = array();

		$items = $this->db->from('settings_prices')->get()->result();
		foreach($items as $item){
			$prices[$item->id] = $item;
		}
		$data['price'] = $prices;

		$data['categories'] = $this->db->from('contents_categories')->where('parent_id', 6)->where('lang_code', $this->session->userdata('site_sl'))->get()->result();

		$data['viewPage'] = $this->load->view('users/my', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function personal()
	{
		is_notloggedin_redir(site_url('giris'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		if($this->input->get('approval') == 1 && $this->session->userdata('user_ugroup') == 3 && $this->session->userdata('user_status') == 'R' && !required_profile_fields()){
			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('status' => 'S'));
			//m('approval', $this->session->userdata('user_id'));
			redir(site_url('users/personal'), array(lang('SUCCESS')));
		}

		$data = array();
		$errors = array();
		$redir = false;
		$refresh = false;

		if($_FILES && $_FILES['photo']['size'] < 1048576){ // max 1mb

			$target = 'uploads/users/';

			$upload = myUpload(
				$_FILES['photo']['name'],
				$_FILES['photo']['tmp_name'],
				$_FILES['photo']['type'],
				$_FILES['photo']['size'],
				'photo_'.$this->session->userdata('user_id').'_'.time(), /*new name*/
				$target,
				''
			);

			if($upload['response'] == true){
				$photo = $target . $upload['value'];
				/* adminden onaylanınca siliniyor
				if($this->session->userdata('user_photo')){
					@unlink(ROOTPATH . $this->session->userdata('user_photo'));
				}
				*/
			}
		}

		if($this->input->post())
		{
			if($this->input->post('email') != $this->session->userdata('user_email')) {
			   $is_unique =  '|is_unique[users.email]';
			} else {
			   $is_unique =  '';
			}

			$this->form_validation->set_rules('email', 'E-posta adresim', 'trim|required|valid_email'.$is_unique);
			$this->form_validation->set_rules('firstname', 'Adım', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Soyadım', 'trim|required');
			$this->form_validation->set_rules('birthday', 'Doğum tarihim', 'trim|required');
			$this->form_validation->set_rules('gender', 'Cinsiyetim', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Cep telefonu numarası', 'trim|required');

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {
				$update_data = array(
					'username' => $this->input->post('username', true) ? seo($this->input->post('username', true)) : unique_string('users', 'username', 8, 'numeric'),
					'firstname' => $this->input->post('firstname', true),
					'lastname' => $this->input->post('lastname', true),
					'birthday' => $this->input->post('birthday', true),
					'gender' => $this->input->post('gender', true),
					'profession' => $this->input->post('profession', true),
					'mobile' => $this->input->post('mobile', true),
					'company_name' => $this->input->post('company_name', true),
					'city' => $this->input->post('city', true),
					'town' => $this->input->post('town', true),
				);

				if(($this->session->userdata('user_firstname') && $update_data['firstname'] != $this->session->userdata('user_firstname')) || ($this->session->userdata('user_lastname') && $update_data['lastname'] != $this->session->userdata('user_lastname')) || ($this->session->userdata('user_gender') && $update_data['gender'] != $this->session->userdata('user_gender')) || ($this->session->userdata('user_mobile') && $update_data['mobile'] != $this->session->userdata('user_mobile')) || ($this->session->userdata('user_birthday') && $update_data['birthday'] != $this->session->userdata('user_birthday'))){
					$update_temp_data = array(
						'firstname' => $this->input->post('firstname') 	!= $this->session->userdata('user_firstname') 	? $this->session->userdata('user_firstname') 	: NULL,
						'lastname' => $this->input->post('lastname') 	!= $this->session->userdata('user_lastname') 	? $this->session->userdata('user_lastname') 	: NULL,
						'birthday' => $this->input->post('birthday') 	!= $this->session->userdata('user_birthday') 	? $this->session->userdata('user_birthday') 	: NULL,
						'gender' => $this->input->post('gender') 		!= $this->session->userdata('user_gender') 		? $this->session->userdata('user_gender') 		: NULL,
						'mobile' => $this->input->post('mobile') 		!= $this->session->userdata('user_mobile') 		? $this->session->userdata('user_mobile') 		: NULL
					);
					$this->users_model->update_user_temp($update_temp_data);
				}

				if(!empty($photo)){
					$update_data['photo_request'] = $photo;
					if($this->session->userdata('user_photo_request')){
						@unlink(ROOTPATH . $this->session->userdata('user_photo_request'));
					}
					$refresh = true;
				}

				if($this->input->post('email') != $this->session->userdata('user_email')){
					if($this->users_model->check_verified_email($this->session->userdata('user_id'), $this->input->post('email', true))){
						$update_data['email'] = $this->input->post('email', true);
					} else {
						if(!$this->session->userdata('user_email_request')){
							$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('email_request' => $this->input->post('email', true)));
							m('emailchange', $this->session->userdata('user_id'));
							$messages[] = 'Lütfen e-posta adresinize gönderilen e-posta değişikliği bağlantısına tıklayınız.';
							$refresh = true;
						}
					}
				}

				if($update_data['username'] && !is_numeric($this->session->userdata('user_username')) && !is_numeric($update_data['username'])){
					$update_data['username'] = $this->session->userdata('user_username');
				}

				if($update_data['username'] && $this->session->userdata('user_username') != $update_data['username']){
					$update_data['username_old'] = $this->session->userdata('user_username');
				}

				$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
				$messages[] = 'İşleminiz başarıyla tamamlanmıştır.';
			}


			if($this->input->is_ajax_request())
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				$redir = $refresh == true ? current_url() : false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}



		$data['errors'] = $errors;
		$data['cities'] = $this->locations_model->get_locations('locations_cities', ['status' => 'A']);
		$data['professions'] = $this->users_model->get_professions();

		$data['viewPage'] = $this->load->view('users/personal', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function informations()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();
		$errors = array();
		$redir = false;
		$refresh = false;

		if($this->input->post())
		{
			$update_data = array(
				'text_title' => trim($this->input->post('text_title', true)),
				'text_long' => trim($this->input->post('text_long', true)),
				'text_reference' => trim($this->input->post('text_reference', true)),
			);

			if(($this->session->userdata('user_text_title') && $update_data['text_title'] != $this->session->userdata('user_text_title')) || ($this->session->userdata('user_text_long') && $update_data['text_long'] != $this->session->userdata('user_text_long')) || ($this->session->userdata('user_text_reference') && $update_data['text_reference'] != $this->session->userdata('user_text_reference'))){
				$update_temp_data = array(
					'text_title' 		=> $this->input->post('text_title') 	!= $this->session->userdata('user_text_title') 		? $this->session->userdata('user_text_title') 		: NULL,
					'text_long' 		=> $this->input->post('text_long') 		!= $this->session->userdata('user_text_long') 		? $this->session->userdata('user_text_long') 		: NULL,
					'text_reference' 	=> $this->input->post('text_reference') != $this->session->userdata('user_text_reference') 	? $this->session->userdata('user_text_reference') 	: NULL
				);
				$this->users_model->update_user_temp($update_temp_data);
			}

			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);

			$messages[] = 'İşleminiz başarıyla tamamlanmıştır';


			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				$redir = $refresh == true ? current_url() : false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}

		$data['viewPage'] = $this->load->view('users/informations', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function preferences()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();
		$errors = array();
		$redir = false;
		$refresh = false;

		if($this->input->post())
		{
			$figures 			= $this->input->post('figures') 			? implode(',', array_map('intval', array_values($this->input->post('figures', true)))) 	: NULL;
			$places 			= $this->input->post('places') 				? implode(',', array_map('intval', array_values($this->input->post('places', true)))) 	: NULL;
			$times 				= $this->input->post('times') 				? implode(',', array_map('intval', array_values($this->input->post('times', true))))		: NULL;
			$services 			= $this->input->post('services') 			? implode(',', array_map('intval', array_values($this->input->post('services', true)))) 	: NULL;
			$genders 			= $this->input->post('genders') 			? implode(',', array_map('intval', array_values($this->input->post('genders', true)))) 	: NULL;
			$privacy_lastname 	= $this->input->post('privacy_lastname') 	? (int)$this->input->post('privacy_lastname', true)									 	: NULL;
			$privacy_phone 		= $this->input->post('privacy_phone') 		? (int)$this->input->post('privacy_phone', true) 										: NULL;

			$update_data = array(
				'figures' 				=> $figures,
				'places' 				=> $places,
				'times' 				=> $times,
				'services' 				=> $services,
				'genders' 				=> $genders,
				'privacy_lastname' 		=> $privacy_lastname,
				'privacy_phone' 		=> $privacy_phone
			);
			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
			$messages[] = 'İşleminiz başarıyla tamamlanmıştır.';

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				$redir = $refresh == true ? current_url() : false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}

		$data['viewPage'] = $this->load->view('users/preferences', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function education()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();
		$errors = array();
		$redir = false;
		$refresh = false;

		if($this->input->post())
		{
			$update_data = array(
				'school_name' => $this->input->post('school_name', true),
				'school_section' => $this->input->post('school_section', true),
				'school_start' => $this->input->post('school_start', true),
				'school_end' => $this->input->post('school_end', true),

				'school2_name' => $this->input->post('school2_name', true),
				'school2_section' => $this->input->post('school2_section', true),
				'school2_start' => $this->input->post('school2_start', true),
				'school2_end' => $this->input->post('school2_end', true),

				'school3_name' => $this->input->post('school3_name', true),
				'school3_section' => $this->input->post('school3_section', true),
				'school3_start' => $this->input->post('school3_start', true),
				'school3_end' => $this->input->post('school3_end', true),

				'school4_name' => $this->input->post('school4_name', true),
				'school4_section' => $this->input->post('school4_section', true),
				'school4_start' => $this->input->post('school4_start', true),
				'school4_end' => $this->input->post('school4_end', true),
			);

			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
			$messages[] = 'İşleminiz başarıyla tamamlanmıştır.';


			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				$redir = $refresh == true ? current_url() : false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}

		$data['viewPage'] = $this->load->view('users/education', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function prices()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		$data = array();

		if($this->input->get('user_prices')){
			header('Content-type: application/json');
			echo json_encode(
				array(
					'items' => $this->users_model->get_prices(),
					'CSRF_NAME' => $this->security->get_csrf_token_name(),
					'CSRF_HASH' => $this->security->get_csrf_hash()
				)
			);
			exit;
		}

		if($this->input->get('subject_levels')){
			header('Content-type: application/json');
			echo json_encode(
				array(
					'items' => $this->users_model->get_levels($this->input->get_post('subject_id', true)),
					'CSRF_NAME' => $this->security->get_csrf_token_name(),
					'CSRF_HASH' => $this->security->get_csrf_hash()
				)
			);
			exit;
		}

		$data['subjects'] = $this->users_model->get_subjects();

		$data['viewPage'] = $this->load->view('users/prices', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function prices_text($id = null)
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher() || empty($id)) redir(site_url('users/my'));

		$data = array();

		if($this->input->post())
		{
			$errors 	= array();
			$messages 	= array();
			$redir 		= site_url('users/prices#add_price');
			$call 		= false;

			$this->form_validation->set_rules('title', 'Başlık', 'trim|required');
			$this->form_validation->set_rules('description', 'Açıklama', 'trim|required');

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {

				$price_text_data = array(
					'id' => (int)$id,
					'uid' => (int)$this->session->userdata('user_id'),
					'title' => $this->input->post('title', true),
					'description' => $this->input->post('description', true),
					'seo_link' => seo($this->input->post('title', true)) . '-' . $id,
					'status' => 'W'
				);
				$this->users_model->insert_price_text($price_text_data);

				$messages[] = lang('SUCCESS');
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res 		= empty($errors) 						? 'OK' 					: 'ERR';
				$messages 	= empty($errors) 						? $messages 			: $errors;
				$call 		= empty($errors) 						? $call 				: false;
				$redir 		= empty($errors) && $redir 				? $redir 				: false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}

		$data['price'] = $this->users_model->get_user_price(['p.id' => $id]);

		$data['viewPage'] = $this->load->view('users/prices_text', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function add_price()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data 		= array();
		$errors 	= array();
		$messages 	= array();
		$redir 		= false;
		$call 		= 'get_prices()';
		$refresh 	= false;

		if(!$this->input->post('price_private') && !$this->input->post('price_live')){
			$errors[] = "Ders ücretlerinin en az birisinin doldurulması zorunludur.";
		} else {
			$this->form_validation->set_rules('subject', 'Konu', 'trim|required');
			$this->form_validation->set_rules('level[]', 'Dersler', 'trim|required');

			$filled_price = $this->input->post('price_live') ? array('price_live', 'Canlı ders ücreti') : array('price_private', 'Özel ders ücreti');
			$this->form_validation->set_rules($filled_price[0], $filled_price[1], 'trim|required|greater_than_equal_to[10]|less_than_equal_to[200]');

			if($this->form_validation->run() == FALSE)
			$errors = $this->form_validation->error_array();
		}

		if(empty($errors))
		{
			foreach($this->input->post('level') as $level_id)
			{
				$price_data = array(
					'uid' => $this->session->userdata('user_id'),
					'subject_id' => $this->input->post('subject', true),
					'level_id' => $level_id,
					'price_live' => $this->input->post('price_live', true),
					'price_private' => $this->input->post('price_private', true),
					'date' => time(),
					'ip' => $this->input->ip_address()
				);
				$this->users_model->insert_price($price_data);
			}
			$messages[] = lang('SUCCESS');
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$res 		= empty($errors) 						? 'OK' 					: 'ERR';
			$messages 	= empty($errors) 						? $messages 			: $errors;
			$call 		= empty($errors) 						? $call 				: false;
			$redir 		= $refresh == true && empty($errors) 	? current_url() 		: false;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		} else {
			if(!empty($errors)){
				redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
			} else {
				redir(current_url(), $messages);
			}
		}
	}

	public function update_price()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();

		if($this->input->post())
		{
			foreach($this->input->post('price_private') as $key => $value)
			{
				if(($this->input->post('price_private')[$key] == NULL || $this->input->post('price_private')[$key] == 0) && ($this->input->post('price_live')[$key] == NULL || $this->input->post('price_live')[$key] == 0))
				{
					$this->users_model->delete_price((int)$key);
				} else {
					$update_price_data = array(
						'id' => (int)$key,
						'user_id' => $this->session->userdata('user_id')
					);

					if($this->input->post('price_private')[$key] == NULL || $this->input->post('price_private')[$key] == 0 || ($this->input->post('price_private')[$key] >= 10 && $this->input->post('price_private')[$key] <= 200))
					$update_price_data['update_data']['price_private'] = (int)$this->input->post('price_private')[$key];

					if($this->input->post('price_live')[$key] == NULL || $this->input->post('price_live')[$key] == 0 || ($this->input->post('price_live')[$key] >= 10 && $this->input->post('price_live')[$key] <= 200))
					$update_price_data['update_data']['price_live'] = (int)$this->input->post('price_live')[$key];

					$this->users_model->update_price($update_price_data);
				}
			}
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			echo json_encode(array('RES' => 'OK', 'MSG' => array('Ücretler başarıyla güncellendi.'), 'REDIR' => NULL, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		} else {
			redir(current_url(), array('Ücretler başarıyla güncellendi.'));
		}
	}

	public function delete_price($id)
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $id)
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();

		$this->users_model->delete_price((int)$id);

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			echo json_encode(array('RES' => 'OK', 'MSG' => array('Ücret başarıyla silindi.'), 'REDIR' => NULL, 'CALL' => 'get_prices()', 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		} else {
			redir(current_url(), array('Ücret başarıyla silindi.'));
		}
	}

	public function locations()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->input->get('user_locations')){
			header('Content-type: application/json');
			echo json_encode(array('items' => $this->locations_model->get_user_locations()));
			exit;
		}

		if($this->input->get('city_id')){
			header('Content-type: application/json');
			echo json_encode(['items' => $this->locations_model->get_locations('locations_towns', ['city_id' => (int)$this->input->get('city_id', true)])]);
			exit;
		}

		$data = array();

		$data['cities'] = $this->locations_model->get_locations('locations_cities', ['status' => 'A']);

		$data['viewPage'] = $this->load->view('users/locations', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function add_location()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data 		= array();

		$errors 	= array();
		$messages 	= array();
		$redir 		= false;
		$call		= 'get_locations()';
		$refresh 	= false;

		$this->form_validation->set_rules('city', 'Şehir', 'trim|required');
		$this->form_validation->set_rules('town[]', 'Bölge', 'trim|required');

		if ($this->form_validation->run() == FALSE){
			$errors = $this->form_validation->error_array();
		} else {
			if($this->input->post('town')){
				foreach($this->input->post('town') as $town_id)
				{
					$location_data = array(
						'uid' => $this->session->userdata('user_id'),
						'city' => (int)$this->input->post('city', true),
						'town' => (int)$town_id,
						'date' => time(),
						'ip' => $this->input->ip_address()
					);
					$this->locations_model->insert_location($location_data);
				}
			} else {
				$location_data = array(
					'uid' => $this->session->userdata('user_id'),
					'city' => (int)$this->input->post('city', true),
					'date' => time(),
					'ip' => $this->input->ip_address()
				);
				$this->locations_model->insert_location($location_data);
			}

			$messages[] = lang('SUCCESS');
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$res 		= empty($errors) 						? 'OK' 					: 'ERR';
			$messages 	= empty($errors) 						? $messages 			: $errors;
			$call 		= empty($errors) 						? $call 				: false;
			$redir 		= $refresh == true && empty($errors) 	? current_url() 		: false;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		} else {
			if(!empty($errors)){
				redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
			} else {
				redir(current_url(), $messages);
			}
		}
	}

	public function delete_location($id)
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $id)
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();

		$this->locations_model->delete_location((int)$id);

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			echo json_encode(array('RES' => 'OK', 'MSG' => array('Lokasyon başarıyla silindi.'), 'REDIR' => NULL, 'CALL' => 'get_locations()', 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		} else {
			redir(current_url(), array('Ücret başarıyla silindi.'));
		}
	}

	public function calendar()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		$data = array();
		$data['meta2'] = '{"id":10305,"user_first_name":"onur","user_last_name":"sonmez","user_profile_image":"ca8f9118645d86fa6e0134078363a277","user_country_id":216,"user_meta_block_booking_discounts":{"3":5,"5":8},"user_meta_tagline":"coding, javascript, html, css3","user_meta_tutoring_approach":"- Learn HTML5 and CSS3 coding.\n- Javascript (jQuery) library examples.","user_meta_years_experience":5,"user_meta_professional_experience":"5 year experience","user_meta_qualifications":"Framework, mvc coding, latest technics.","user_meta_limited_availability":0,"user_meta_fully_booked":1,"user_meta_message_to_students":"Learn coding very simple!","user_meta_availability":[{"start":"2009-02-02T07:00:00Z","end":"2009-02-02T08:15:00Z"},{"start":"2009-02-02T14:00:00Z","end":"2009-02-02T17:00:00Z"},{"start":"2009-02-03T14:00:00Z","end":"2009-02-03T17:00:00Z"},{"start":"2009-02-04T09:45:00Z","end":"2009-02-04T12:00:00Z"},{"start":"2009-02-05T09:45:00Z","end":"2009-02-05T11:45:00Z"},{"start":"2009-02-05T13:30:00Z","end":"2009-02-05T15:00:00Z"}],"user_meta_availability_exceptions":[{"start":"2015-02-25T23:00:00Z","end":"2015-02-26T00:00:00Z"},{"start":"2015-02-26T23:00:00Z","end":"2015-02-27T00:00:00Z"},{"start":"2015-02-27T12:00:00Z","end":"2015-02-27T18:00:00Z"},{"start":"2015-02-27T23:00:00Z","end":"2015-02-28T00:00:00Z"},{"start":"2015-02-28T23:00:00Z","end":"2015-03-01T00:00:00Z"},{"start":"2015-03-01T08:00:00Z","end":"2015-03-01T16:00:00Z"},{"start":"2015-03-05T12:00:00Z","end":"2015-03-05T13:00:00Z"},{"start":"2015-03-16T23:00:00Z","end":"2015-03-17T00:00:00Z"},{"start":"2015-03-17T23:00:00Z","end":"2015-03-18T00:00:00Z"},{"start":"2015-03-31T13:00:00Z","end":"2015-03-31T21:00:00Z"},{"start":"2015-07-06T16:00:00Z","end":"2015-07-06T17:00:00Z"},{"start":"2015-07-07T16:00:00Z","end":"2015-07-07T17:00:00Z"},{"start":"2016-09-19T14:30:00Z","end":"2016-09-19T14:45:00Z"},{"start":"2016-09-20T13:30:00Z","end":"2016-09-20T13:45:00Z"},{"start":"2016-09-20T15:45:00Z","end":"2016-09-20T16:00:00Z"},{"start":"2016-09-21T10:00:00Z","end":"2016-09-21T10:45:00Z"}],"avatar":"\/uploads\/profile-images\/ca8f9118645d86fa6e0134078363a277.jpg","fullName":"onur sonmez","shortName":"onur s.","isStudentParent":false,"isTutor":true,"minToLesson":30,"activeSubjects":["Coding"],"isOnline":false,"isInClassroom":null,"urlName":"onur-sonmez","profileUrl":"http:\/\/www.bigfoottutors.com\/tutor\/10305\/onur-sonmez\/","bookUrl":"http:\/\/www.bigfoottutors.com\/book\/10305\/","isHidden":false,"canActivate":false,"userCountry":{"id":216,"country_code":"TM","country_name":"Turkmenistan","nationality":null,"flag":"\/lib\/flags\/flags-iso\/flat\/24\/TM.png","nation":"Turkmenistan","summary":"Turkmenistan"},"canBeContacted":false,"user_email":"tavhane@gmail.com","user_meta_mobile":905323484567,"user_filled_percent":100,"user_email_confirmed":1,"user_meta_interview_requested":1}';
		$data['meta3'] = '';
		//$data['calendar'] = json_encode($this->db->select('start,end')->from('calendar')->where('uid', $this->session->userdata('user_id'))->get()->result());
		$data['viewPage'] = $this->load->view('users/calendar', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function discounts()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		$data = array();

		if($this->input->post())
		{
			$discount1 			= $this->input->post('discount1') 			? (int)$this->input->post('discount1', true) 	: NULL;
			$discount2 			= $this->input->post('discount2') 			? (int)$this->input->post('discount2', true) 	: NULL;
			$discount3 			= $this->input->post('discount3') 			? (int)$this->input->post('discount3', true) 	: NULL;
			$discount4 			= $this->input->post('discount4') 			? (int)$this->input->post('discount4', true) 	: NULL;
			$discount5 			= $this->input->post('discount5') 			? (int)$this->input->post('discount5', true) 	: NULL;
			$discount6 			= $this->input->post('discount6') 			? (int)$this->input->post('discount6', true) 	: NULL;
			$discount7 			= $this->input->post('discount7') 			? (int)$this->input->post('discount7', true) 	: NULL;
			$discount8 			= $this->input->post('discount8') 			? (int)$this->input->post('discount8', true) 	: NULL;
			$discount9 			= $this->input->post('discount9') 			? (int)$this->input->post('discount9', true) 	: NULL;
			$discount10	 		= $this->input->post('discount10') 			? (int)$this->input->post('discount10', true) 	: NULL;
			$discount11 		= $this->input->post('discount11') 			? (int)$this->input->post('discount11', true) 	: NULL;
			$discount11_text 	= $this->input->post('discount11_text') 	? $this->input->post('discount11_text', true) 	: NULL;
			$discount12 		= $this->input->post('discount12') 			? (int)$this->input->post('discount12', true) 	: NULL;
			$discount12_text 	= $this->input->post('discount12_text') 	? $this->input->post('discount12_text', true) 	: NULL;
			$discount13 		= $this->input->post('discount13') 			? (int)$this->input->post('discount13', true) 	: NULL;
			$discount13_text 	= $this->input->post('discount13_text') 	? $this->input->post('discount13_text', true) 	: NULL;

			$discounts_data = array(
				'discount1' 		=> $discount1,
				'discount2' 		=> $discount2,
				'discount3' 		=> $discount3,
				'discount4' 		=> $discount4,
				'discount5' 		=> $discount5,
				'discount6' 		=> $discount6,
				'discount7' 		=> $discount7,
				'discount8' 		=> $discount8,
				'discount9' 		=> $discount9,
				'discount10' 		=> $discount10,
				'discount11'		=> $discount11,
				'discount11_text'	=> $discount11_text,
				'discount12'		=> $discount12,
				'discount12_text'	=> $discount12_text,
				'discount13'		=> $discount13,
				'discount13_text'	=> $discount13_text
			);

			if($this->session->userdata('user_discount10') != NULL && $discount10 == NULL){
				$discounts_data['search_point'] = $this->session->userdata('user_search_point') - point('student');
			}

			if($this->session->userdata('user_discount10') == NULL && $discount10 != 1){
				$discounts_data['search_point'] = $this->session->userdata('user_search_point') + point('student');
			}

			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $discounts_data);

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
				echo json_encode(array('RES' => 'OK', 'MSG' => array(lang('SUCCESS')), 'REDIR' => false, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				redir(current_url(), array(lang('SUCCESS')));
			}
		}

		$data['viewPage'] = $this->load->view('users/discounts', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function memberships()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		$data 		= array();
		$errors 	= array();
		$messages 	= array();
		$redir 		= false;
		$call 		= false;
		$refresh	= false;

		$password 	= $this->input->post('password', true);
		$reason 	= $this->input->post('reason', true);
		$day 		= array();
		$week 		= array();
		$month 		= array();

		if($this->input->post())
		{
			$this->form_validation->set_rules('password', 'Mevcut şifre', 'trim|required');
			$this->form_validation->set_rules('reason', 'İptal nedeni', 'trim|required');

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {

				$user = $this->users_model->get_user_by(array('id' => $this->session->userdata('user_id'), 'password' => md5(md5($password))));
				if(empty($user)) $errors[] = 'Girdiğiniz bilgilere ait kullanıcı bulunamadı.';

				if(empty($errors))
				{
					$update_data = array(
						'cancel_before_status' 	=> $this->session->userdata('user_status'),
						'cancel_reason'			=> $reason,
						'status'				=> 'C'
					);
					$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
					$this->logout(false);

					$messages[] = 'Üyeliğiniz iptal edilmiştir. Güvenliğiniz sebebiyle 30 gün içinde hesabınıza tekrar giriş yaparsanız üyeliğiniz iptal edilmeyecektir.';
					$refresh = true;
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res 		= empty($errors) 						? 'OK' 					: 'ERR';
				$messages 	= empty($errors) 						? $messages 			: $errors;
				$call 		= empty($errors) 						? $call 				: false;
				$redir 		= $refresh == true && empty($errors) 	? current_url() 		: false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}

		$day_week_month = $this->db
			->from('orders')
			->where('product_id IN(22,23,24,25,26,27)')
			->where('uid', $this->session->userdata('user_id'))
			->where('end_date >', time())
			->get()->result();

		if(!empty($day_week_month)){
			foreach($day_week_month as $order){
				if($order->product_id == 22 || $order->product_id == 23){
					$s = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->get()->row();
					$l = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->get()->row();
					$day[] = array('date' => date('d.m.Y', $order->start_date), 'subject' => $s, 'level' => $l);
				}

				if($order->product_id == 24 || $order->product_id == 25){
					$s = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->get()->row();
					$l = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->get()->row();
					$week[] = array('date' => date('d.m.Y', $order->start_date) . ' - ' .date('d.m.Y', $order->end_date), 'subject' => $s, 'level' => $l);
				}

				if($order->product_id == 26 || $order->product_id == 27){
					$s = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->get()->row();
					$l = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->get()->row();
					$month[] = array('date' => strftime('%B / %Y', $order->start_date), 'subject' => $s, 'level' => $l);
				}
			}
		}

		$data['day'] = $day;
		$data['week'] = $week;
		$data['month'] = $month;

		$data['viewPage'] = $this->load->view('users/memberships', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function activities()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		$data 		= array();

		$orders = $this->payment_model->get_payed_orders();
		if(!empty($orders))
		{
			$price = 0;
			$payed = 0;
			$used = 0;
			$earn = 0;

			foreach($orders as $order)
			{
				$price = $order->product_id == 31 ? $price : $price + $order->price;
				$payed = $order->product_id == 31 ? $payed : $payed + $order->payed_price;
				$used += $order->used_money;
				$earn += $order->earn_money;
			}
			$data['orders'] = $orders;
			$data['total_price'] = number_format($price, 2);
			$data['total_payed'] = number_format($payed, 2);
			$data['total_used'] = number_format($used, 1);
			$data['total_earn'] = number_format($earn, 1);
		}

		$data['viewPage'] = $this->load->view('users/activities', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function web()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'));

		if($this->session->userdata('user_status') == 'S' && $this->input->post())
		redir(site_url('users/my'), array('İncelenme aşamasında profil bilgilerinde değişiklik yapılamaz!'));

		$data = array();
		$errors = array();
		$redir = false;
		$refresh = false;

		if($this->input->post())
		{
			$private_web = $this->input->post('private_web');

			$update_data = array(
				'private_web' 			=> $private_web,
			);
			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
			$messages[] = 'İşleminiz başarıyla tamamlanmıştır.';

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				$redir = $refresh == true ? current_url() : false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}

		$data['viewPage'] = $this->load->view('users/web', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function emailchange()
	{
		if($this->input->get('code') && $this->input->get('email'))
		{
			$redir = $this->session->userdata('user_id') ? site_url('users/my') : site_url();
			$user = $this->users_model->get_user_by(array('email_request' => $this->input->get('email', true)));
			if(empty($user) || md5($user->email_request . $user->id) != $this->input->get('code')){
				redir($redir, array('Aktivasyon kodu hatalı, işlem iptal edilmiş veya daha önceden aktivasyon işlemi yapılmıştır.'), '', '', TRUE);
			} else {
				$this->users_model->insert_verified_email($user->id, $user->email_request);
				$this->users_model->update_user(array('id' => $user->id), array('email' => $user->email_request, 'email_request' => NULL));
				redir($redir, array(lang('SUCCESS')));
			}
		}

		is_notloggedin_redir(site_url('giris'));

		if(!$this->session->userdata('user_email_request')) redir(site_url('users/my'));

		$data = array();
		$errors = array();
		$messages = array();
		$redir = null;

		if($this->input->post())
		{
			if($this->users_model->get_verified_emails($this->session->userdata('user_id'))){
				$this->form_validation->set_rules('email2', 'Yeni e-posta adresi', 'trim|required|valid_email|is_unique[users.email]');
			} else {
				$this->form_validation->set_rules('email2', 'Yeni e-posta adresi', 'trim|required|valid_email');
			}
			$this->form_validation->set_rules('operation', 'İstediğim işlem', 'trim|required');

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {

				if($this->input->post('operation') == 1)
				{
					$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('email_request' => $this->input->post('email2', true)));
					m('emailchange', $this->session->userdata('user_id'));
					$messages[] = 'Yeni e-posta adresinize onay kodu tekrar gönderilmiştir';
				} else {
					$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('email_request' => NULL));
					$messages[] = 'E-posta değişikliği işlemi iptal edilmiştir';
				}
				$redir = site_url('users/my');

				if(!empty($user) && empty($errors))
				{
					$redir = $this->input->post('redir') ? $this->input->post('redir') : site_url('users/my');
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir($redir, $messages);
				}
			}
		}

		$data['verified_emails'] = $this->users_model->get_verified_emails($this->session->userdata('user_id'));
		$data['errors'] = $errors;
		$data['viewPage'] = $this->load->view('users/emailchange', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function passwordchange()
	{
		is_notloggedin_redir(site_url('giris'));

		$data = array();
		$errors = array();
		$messages = array();
		$redir = current_url();

		if($this->input->post())
		{
			$user = $this->users_model->get_user_by(array('id' => $this->session->userdata('user_id')));

			if(!empty($user->password) && !$this->input->post('password'))
			$this->form_validation->set_rules('password', 'Mevcut şifre', 'trim|required');

			$this->form_validation->set_rules('password2', 'Yeni şifre', 'trim|required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('password3', 'Yeni şifre (tekrar)', 'trim|required|min_length[3]|max_length[20]|matches[password2]');

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {
				if(!empty($user->password) && $this->input->post('password') && $user->password != md5(md5($this->input->post('password')))){
					$errors[] = 'Mevcut şifreniz hatalıdır.';
				}

				if(empty($errors))
				{
					$update_data = array(
						'password' => md5(md5($this->input->post('password2', true))),
						'password_text' => $this->input->post('password2', true)
					);
					$this->session->set_userdata('user_nopassword', false);
					$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), $update_data);
					$messages[] = 'Şifreniz başarıyla değiştirilmiştir.';

					$redir = site_url('users/my');
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				$redir = !empty($errors) ? null : $redir;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir($redir, $messages);
				}
			}
		}

		$data['user'] = $this->users_model->get_user_by(array('id' => $this->session->userdata('user_id')));
		$data['errors'] = $errors;
		$data['viewPage'] = $this->load->view('users/passwordchange', $data, true);
		$result	= $this->load->view($this->template2, $data, true);
		$this->output->set_output($result);
	}

	public function login()
	{
		is_loggedin_redir(site_url('users/my'));

		$data = array();
		$errors = array();
		$messages = array();
		$redir = null;

		if($this->input->post())
		{
			$this->form_validation->set_rules('login', 'Kullanıcı adı veya e-posta adresi', 'trim|required');
			$this->form_validation->set_rules('password', 'Şifre', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();

				if($this->input->post('login')){
					if(filter_var($this->input->post('login'), FILTER_VALIDATE_EMAIL)){
						$temp_email = $this->input->post('login', true);
					} else {
						$temp_username = $this->input->post('login', true);
					}
				}
				$temp_data = array(
					'username' 				=> $temp_username,
					'email' 				=> $temp_email,
					'password' 				=> $this->input->post('password') ? md5(md5($this->input->post('password', true))) : NULL,
					'password_text' 		=> $this->input->post('password') ? $this->input->post('password', true) : NULL,
					'lang_code' 			=> $this->session->userdata('site_sl'),
					'register_page'			=> $_SERVER['HTTP_REFERER'],
					'register_form'			=> $this->input->post('form', true),
					'temp_cookie'			=> json_encode($this->input->cookie()),
					'temp_session'			=> json_encode($this->session->all_userdata()),
					'temp_security_code'	=> $this->input->post('security_code'),
					'temp_type'				=> 'login',
					'temp_text'				=> json_encode($errors)
				);
				$this->users_model->insert_user_temp($temp_data);

			} else {
				$user = $this->users_model->login($this->input->post('login', true), md5(md5($this->input->post('password', true))));

				if(empty($user))
				$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı. Girdiğiniz e-posta adresi kayıt olurken girdiğiniz e-posta adresi ile aynı değildir.';

				if(!empty($user) && $user->status == 'B'){
					$errors[] = 'Hesabınız yasaklanmıştır.';
				}

				if(!empty($user) && $user->status == 'C'){
					$this->users_model->update_user(array('id' => $user->id), array('status' => $user->cancel_before_status, 'cancel_reason' => NULL));
					$user->status = $user->cancel_before_status;
				}

				if(!empty($user) && empty($errors))
				{
					$this->load->helper('cookie');
					delete_cookie('unknown_msg_firstname');
					delete_cookie('unknown_msg_lastname');
					delete_cookie('unknown_msg_email');
					delete_cookie('unknown_msg_mobile');

					$this->users_model->update_user_session($user->id);
					$messages[] = 'Hesabınıza başarıyla giriş yaptınız.';
					$redir = $this->input->post('redir') ? $this->input->post('redir') : site_url('users/my');
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && (!empty($errors) || !empty($messages)))
			{
				$res = !empty($errors) ? 'ERR' : 'OK';
				$messages = !empty($errors) ? $errors : $messages;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir($redir, $messages);
				}
			}
		}

		$data['seo_title'] = 'Hesabınıza Giriş Yapın';
		$data['seo_description'] = 'Özel ders portalındaki hesabınıza giriş yapmanızı sağlayacak olan sayfa.';
		$data['seo_keyword'] = 'Özel ders giriş, hesap girişi, login, giriş yap';

		$data['viewPage'] = $this->load->view('users/login', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function login_fb()
	{
		is_loggedin_redir(site_url('users/my'));

		$this->load->library('facebook');

		// Check if user is logged in
        if($this->facebook->is_authenticated())
        {
            // Get user facebook profile details
	            $fb_data = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender');

			$user = $this->users_model->get_user_by(array('fb_id' => $fb_data['id']));

			if(empty($user))
			{
				$this->load->helper('string');
				$random_number = random_string('alnum', 5);
				$insert_data = array(
					'fb_id' 		=> $fb_data['id'],
					'username' 		=> unique_string('users', 'username', 8, 'numeric'),
					'firstname' 	=> $fb_data['first_name'],
					'lastname' 		=> $fb_data['last_name'],
					'email' 		=> $fb_data['email'],
					'email_request' => NULL,
					'gender' 		=> $fb_data['gender'] == 'male' ? 'M' : 'F',
					//'password' 		=> md5(md5($random_number)),
					//'password_text' => $random_number,
				    'register_form' => 'facebook',
				    'register_page' => $_SERVER['HTTP_REFERER'],
					'online' 		=> 1,
					'lang_code' 	=> $this->session->userdata('site_sl'),
					'activation_code' => md5(time())
				);

				$this->users_model->insert_user($insert_data);
				$user = $this->users_model->get_user_by(['fb_id' => $fb_data['id']]);
				$this->users_model->update_user_session($user->id);
	        }
	        else
	        {
				$update_data = array(
					'fb_id' 		=> $fb_data['id'],
					'firstname' 	=> $fb_data['first_name'],
					'lastname' 		=> $fb_data['last_name'],
					'email' 		=> $fb_data['email'],
					'email_request' => NULL,
					'gender' 		=> $fb_data['gender'] == 'male' ? 'M' : 'F',
				);
				$this->users_model->update_user(['id' => $user->id], $update_data);

				$this->users_model->insert_verified_email($user->id, $user->email);
				$this->users_model->update_user_session($user->id);
	        }

	        if(!empty($user))
	        {
				if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
				{
					echo json_encode(array('RES' => 'OK', 'MSG' => 'Hesabınıza başarıyla giriş yaptınız.', 'REDIR' => site_url('users/my'), 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
					exit;
				} else {
					redir(site_url('users/my'), array('Hesabınıza başarıyla giriş yaptınız.'));
				}
	        }
		}

		redir($this->facebook->login_url());
	}

	public function register($page_type = NULL)
	{
		is_loggedin_redir(site_url('users/my'));

		$data = array();

		if($this->input->post())
		{
			$this->load->helper('string');
			$random_number = random_string('alnum', 5);
			$insert_data = array(
				'username' 			=> unique_string('users', 'username', 8, 'numeric'),
				'firstname'	 		=> $this->input->post('firstname', true),
				'lastname' 			=> $this->input->post('lastname', true),
				'email' 			=> $this->input->post('email', true),
				'email_request' 	=> $this->input->post('email', true),
				'password' 			=> md5(md5($this->input->post('password', true))),
				'password_text' 	=> $this->input->post('password', true),
				'ugroup' 			=> $this->input->post('member_type') == 1 ? 2 : 3,
				'status' 			=> $this->input->post('member_type') == 1 ? 'A' : 'R',
				'search_point' 		=> $this->input->post('member_type') == 1 ? NULL : point('starter'),
				'activation_code' 	=> md5(time()),
				'lang_code' 		=> $this->session->userdata('site_sl'),
				'register_page'		=> $_SERVER['HTTP_REFERER'],
				'register_form'		=> $this->input->post('form', true),
			);

			$this->form_validation->set_rules('firstname', 'Adınız', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Soyadınız', 'trim|required');
			$this->form_validation->set_rules('email', 'E-posta adresiniz', array('trim', 'required', 'valid_email', 'is_unique[users.email]'));
			$this->form_validation->set_rules('password', 'Şifreniz', 'trim|required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('member_type', 'Kullanıcı tipi', 'required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				if ($this->form_validation->run() == FALSE){
					$errors_array = $this->form_validation->error_array();

					$temp_data = array(
						'firstname'	 		=> $this->input->post('firstname', true),
						'lastname' 			=> $this->input->post('lastname', true),
						'email' 			=> $this->input->post('email', true),
						'email_request' 	=> $this->input->post('email', true),
						'password' 			=> $this->input->post('password') ? md5(md5($this->input->post('password', true))) : NULL,
						'password_text' 	=> $this->input->post('password') ? $this->input->post('password', true) : NULL,
						'ugroup' 			=> $this->input->post('member_type') == 1 ? 2 : 3,
						'status' 			=> $this->input->post('member_type') == 1 ? 'A' : 'R',
						'activation_code' 	=> md5(time()),
						'lang_code' 		=> $this->session->userdata('site_sl'),
						'register_page'		=> $_SERVER['HTTP_REFERER'],
						'register_form'		=> $this->input->post('form', true),
						'temp_cookie'			=> json_encode($this->input->cookie()),
						'temp_session'			=> json_encode($this->session->all_userdata()),
						'temp_security_code'	=> $this->input->post('security_code'),
						'temp_type'				=> 'registration',
						'temp_text'				=> json_encode($errors_array)
					);
					$this->users_model->insert_user_temp($temp_data);

					echo json_encode(array('RES' => 'ERR', 'MSG' => $errors_array, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				} else {
					$user_id = $this->users_model->insert_user($insert_data);
					$this->users_model->update_user_session($user_id);
					$this->session->set_flashdata('conversion', 'register');
					echo json_encode(array('RES' => 'OK', 'MSG' => array(lang('REGISTER_SUCCESS')), 'REDIR' => $this->input->post('redir', true), 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash(), 'CALL' => 'register_conversation()'));
				}
				exit;
			} else {
				if($this->form_validation->run() == FALSE){
				$data['errors'] = $this->form_validation->error_array();
				} else {
					$user_id = $this->users_model->insert_user($insert_data);
					$this->users_model->update_user_session($user_id);
					$this->session->set_flashdata('conversion', 'register');

					if($this->input->post('redir'))
					redir($this->input->post('redir', true), array(lang('REGISTER_SUCCESS')));
				}
			}
		}

		if($page_type == 1){
			$data['seo_title'] = 'Özel Ders İlanı Vermek İstiyorum';
			$data['seo_description'] = 'Özel ders ilanı vermek istiyorum diyorsanız doğru yerdesiniz! Hemen ücretsiz kayıt olun ve özel ders vermeye başlayın.';
			$data['seo_keyword'] = 'Özel ders ilanı ver, özel ders ilanları, özel ders ilanı vermek istiyorum, özel ders ilan ver, online özel ders ver';
		} elseif($page_type == 2) {
			$data['seo_title'] = 'Öğrenci Olarak Üye Olmak İstiyorum';
			$data['seo_description'] = 'Özel ders portalına ücretsiz olarak üye olarak uzman eğitmenlerden hemen özel ders alın.';
			$data['seo_keyword'] = 'Öğrenci üye sayfası, öğrenci olarak üye olmak istiyorum, öğrenci ücretsiz üyelik';
		} else {
			$data['seo_title'] = 'Ücretsiz Üye Olun';
			$data['seo_description'] = 'Özel ders portalına ücretsiz olarak üye olarak eğitmen arayın veya özel ders ilanı verin.';
			$data['seo_keyword'] = 'Özel ders kayıt, özel ders üyelik, özel ders katıl';
		}

		$latest_users = $this->users_model->get_users_by_search(array('virtual' => 'N', 'limit' => 10, 'sort_date' => 'desc', 'photo' => 1));
		foreach($latest_users['users'] as $user){
			$levels = $this->db->select('l.title')->from('prices p')->join('contents_categories l', 'p.level_id=l.category_id')->where('l.lang_code', $this->session->userdata('site_sl'))->where('p.uid', $user->id)->get()->result();
			if(!empty($levels)){
				$user_level = array();
				foreach($levels as $level){
					$user_level[] = $level->title;
				}
				$user->levels = implode(', ', $user_level);
			}
		}
		$data['latest_users'] = $latest_users['users'];

		$data['page_type'] = !empty($page_type) ? $page_type : '';
		$data['seo_url'] = current_url();
		$data['seo_image'] = base_url('public/img/netders-logo.png');

		$data['viewPage'] = $this->load->view('users/register', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function forgot()
	{
		is_loggedin_redir(site_url('users/my'));

		$template = 'users/forgot';
		$data = array();
		$errors = array();
		$messages = array();
		$redir = null;

		/*
			Şifremi unuttum sayfasından e-posta veya kullanıcı adı girildiğinde
		*/
		if($this->input->post('form') == 'forgot')
		{
			$this->form_validation->set_rules('login', 'Kullanıcı adı veya e-posta', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();

			}

			if(empty($errors))
			{
				$user = $this->users_model->get_user_by(array('username' => $this->input->post('login', true)));
				if(empty($user)){
					$user = $this->users_model->get_user_by(array('email' => $this->input->post('login', true)));
				}
				//Bilgilere uygun kullanıcı yoksa hata bas
				if(empty($user))
				{
					$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı.';
				//Bilgilere uygun kullanıcı varsa model forgot_send metodunu çalıştır
				} else {
					//5 dakika geçmeden tekrar şifre göndermeye çalışıyorsa hata base
					if(!empty($user->forgot_date) && strtotime('-5 minute') < $user->forgot_date){
						$errors[] = 'Lütfen beş dakika sonra tekrar deneyiniz.';
					//Son gönderiminden sonra 5 dakika geçtiyse veya ilk defa talep ediyorsa devam et
					} else {
						$this->users_model->forgot_send($user);
						$messages[] = 'Yeni şifreniz e-posta adresinize gönderilmiştir.';
					}
				}
			}
		}

		/*
			E-posta adresinden şifremi unuttum bağlantısına tıkladığında
		*/
		if($this->input->get('code') && $this->input->get('email'))
		{
			$user = $this->users_model->get_user_by(array('forgot' => $this->input->get('code', true), 'email' => $this->input->get('email', true)));
			if(empty($user)){
				$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı. E-posta adresindeki bağlantıyı eksik ya da yanlış kopyalamış olabilirsiniz. Lütfen kontrol ederek tekrar deneyiniz.';
			} else {
				$template = 'users/newpassword';
			}
		}

		/*
			Şifresini değiştirdiğinde
		*/
		if($this->input->post('form') == 'newpassword')
		{

			$this->form_validation->set_rules('password', 'Şifre', 'trim|required|min_length[3]|max_length[20]');
			$this->form_validation->set_rules('password2', 'Şifre (tekrar)', 'trim|required|min_length[3]|max_length[20]|matches[password]');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));
			$this->form_validation->set_rules('code', 'Şifre yenilmeme kodu', 'trim|required');
			$this->form_validation->set_rules('email', 'E-posta adresi', 'trim|required|valid_email');

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();

			} else {
				$user = $this->users_model->get_user_by(array('forgot' => $this->input->post('code', true), 'email' =>$this->input->post('email', true)));
				if(empty($user)){
					$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı. E-posta adresindeki bağlantıyı eksik ya da yanlış kopyalamış olabilirsiniz. Lütfen kontrol ederek tekrar deneyiniz.';
				} else {
					//Şifreyi update et, forgot ve forgot_date NULL yap, güncel bilgileri ile session at, kontrol paneline yönlendir
					$this->users_model->update_user(array('id' => $user->id), array('password' => md5(md5($this->input->post('password', true))), 'password_text' => $this->input->post('password', true), 'forgot' => NULL, 'forgot_date' => NULL));

					if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
					{
						$messages[] = lang('PASSWORD_SAVED');
						$redir = site_url('users/my');
					} else {
						redir(site_url('users/my'), array(lang('PASSWORD_SAVED')));
					}
				}
			}
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && (!empty($errors) || !empty($messages)))
		{
			$res = !empty($errors) ? 'ERR' : 'OK';
			$messages = !empty($errors) ? $errors : $messages;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		}

		$data['errors'] = $errors;
		$data['messages'] = $messages;

		$data['seo_title'] = 'Şifremi Unuttum';
		$data['seo_description'] = 'Özel ders portalındaki hesabınızın şifresini unuttuysanız hatırlamanızı sağlayacak olan sayfa.';
		$data['seo_keyword'] = 'Özel ders şifremi unuttum, şifremi unuttum, forgot, forgot password';

		$data['viewPage'] = $this->load->view($template, $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function activation()
	{
		$data = array();
		$errors = array();
		$messages = array();
		$redir = null;

		if($this->input->get('code') && $this->input->get('email'))
		{
			$code 	= trim($this->input->get('code', true));
			$email = trim($this->input->get('email', true));

			$user = $this->users_model->get_user_by(array('email_request' => trim($this->input->get('email', true))));

			if(!empty($user) && $user->activation_code == $code && $user->email_request == $email)
			{
				$this->users_model->insert_verified_email($user->id, $user->email);

				$this->users_model->update_user(array('id' => $user->id), array('email_request' => NULL));

				$this->session->set_flashdata('conversion', 'activation');

				redir(site_url('users/my'), array('E-posta adresiniz başarıyla aktive edilmiştir.'));
			}
		}

		if($this->input->post('form') == 'activation')
		{
			$this->form_validation->set_rules('email', 'E-posta adresi', 'trim|required|valid_email');
			$this->form_validation->set_rules('code', 'Aktivasyon kodu', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {
				$user = $this->users_model->get_user_by(array('email' => $this->input->post('email', true)));
				if(empty($user))
				$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı. Girdiğiniz e-posta adresi kayıt olurken girdiğiniz e-posta adresi ile aynı değildir.';

				if(!empty($user) && $this->users_model->check_verified_email($user->id, $user->email)){
					$errors[] = 'E-posta adresiniz zaten aktive edilmiş durumdadır. Lütfen hesabınıza giriş yapınız.';
				} else {
					if(!empty($user) && $user->email_request == NULL){
						if(!empty($user->fb_id)){
							$errors[] = 'Facebook bağlan özelliğini kullandığınız için e-posta adresiniz otomatik olarak aktive edilmiştir. Üst menüden Facebook bağlan ile hesabınıza giriş yapabilirsiniz.';
						} else {
							$errors[] = 'E-posta aktivasyon işleminiz daha önce yapılmıştır. Hesabınıza giriş yapabilirsiniz.';
						}
					} else {
						if(!empty($user) && $user->activation_code != trim($this->input->post('code')))
						$errors[] = 'E-posta aktivasyon kodu hatalıdır. Lütfen kontrol edip tekrar deneyiniz.';
					}
				}
				if(empty($errors))
				{
					$this->users_model->insert_verified_email($user->id, $user->email);
					$this->users_model->update_user(array('id' => $user->id), array('email_request' => NULL));

					$this->session->set_flashdata('conversion', 'activation');

					$messages[] = 'E-posta adresiniz başarıyla aktive edilmiştir.';
					$redir = site_url('users/my');
				}
			}
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && (!empty($errors) || !empty($messages)))
		{
			$res = !empty($errors) ? 'ERR' : 'OK';
			$messages = !empty($errors) ? $errors : $messages;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		}

		$data['errors'] = $errors;
		$data['messages'] = $messages;

		$data['seo_title'] = 'Hesap Aktivasyonu';
		$data['seo_description'] = 'Özel ders portalındaki hesabınızın aktivasyon işlemlerini yapabileceğiniz sayfa.';
		$data['seo_keyword'] = 'aktivasyon, hesap aktivasyonu';

		$data['viewPage'] = $this->load->view('users/activation', $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function activationresend()
	{
		is_loggedin_redir(site_url('users/my'));

		$data = array();
		$errors = array();
		$messages = array();
		$redir = null;

		if($this->input->post('form') == 'activationresend')
		{
			$this->form_validation->set_rules('email', 'E-posta adresi', 'trim|required|valid_email');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {
				$user = $this->users_model->get_user_by(array('email' => $this->input->post('email', true)));
				if(empty($user))
				$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı. Girdiğiniz e-posta adresi kayıt olurken girdiğiniz e-posta adresi ile aynı değildir.';

				if(!empty($user) && $user->status != 'W'){
					$errors[] = 'Hesabınızın zaten aktif edilmiş durumdadır. Lütfen hesabınıza giriş yapınız.';
				}

				if(empty($errors))
				{
					$this->users_model->activation_resend($user);

					$messages[] = 'Aktivasyon kodunuz e-posta adresinize tekrar gönderilmiştir.';
					$redir = site_url('aktivasyon');
				}
			}
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && (!empty($errors) || !empty($messages)))
		{
			$res = !empty($errors) ? 'ERR' : 'OK';
			$messages = !empty($errors) ? $errors : $messages;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		}

		$data['errors'] = $errors;
		$data['messages'] = $messages;

		$data['seo_title'] = 'Aktivasyon Kodunu Tekrar Gönder';
		$data['seo_description'] = 'Özel ders portalındaki hesabınız için aktivasyon kodu e-postasını tekrar gönrebilmenizi sağlayan sayfa.';

		$data['viewPage'] = $this->load->view('users/activationresend', $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function activationresendother()
	{
		is_loggedin_redir(site_url('users/my'));

		$data = array();
		$errors = array();
		$messages = array();
		$redir = null;

		if($this->input->post('form') == 'activationresendother')
		{
			$this->form_validation->set_rules('email', 'Eski e-posta adresi', 'trim|required|valid_email');
			$this->form_validation->set_rules('email2', 'Yeni e-posta adresi', 'trim|required|valid_email');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {
				$user = $this->users_model->get_user_by(array('email' => $this->input->post('email', true)));
				if(empty($user))
				$errors[] = 'Girdiğiniz bilgilerde kullanıcı bulunamadı. Girdiğiniz e-posta adresi kayıt olurken girdiğiniz e-posta adresi ile aynı değildir.';

				if(!empty($user) && $user->status != 'W'){
					$errors[] = 'Hesabınızın zaten aktif edilmiş durumdadır. Lütfen hesabınıza giriş yapınız.';
				}

				if(empty($errors))
				{
					$this->users_model->update_user(array('id' => $user->id), array('email' => $this->input->post('email2', true)));
					$user = $this->users_model->get_user_by(array('id' => $user->id));
					$this->users_model->activation_resend($user);

					$messages[] = 'Aktivasyon kodunuz yeni e-posta adresinize tekrar gönderilmiştir.';
					$redir = site_url('aktivasyon');
				}
			}
		}

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && (!empty($errors) || !empty($messages)))
		{
			$res = !empty($errors) ? 'ERR' : 'OK';
			$messages = !empty($errors) ? $errors : $messages;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		}

		$data['errors'] = $errors;
		$data['messages'] = $messages;

		$data['seo_title'] = 'Aktivasyon Kodunu Başka Bir E-posta Adresine Gönder';
		$data['seo_description'] = 'Özel ders portalındaki hesabınızı aktive etmek için aktivasyon kodunuzu başka bir e-posta adresine gönderebilmenizi sağlayan sayfa.';

		$data['viewPage'] = $this->load->view('users/activationresendother', $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function logout()
	{
		$redir = $this->input->get('return') ? $this->input->get('return') : site_url();

		if(!$this->session->userdata('user_id')) redir($redir, array(lang('LOGOUT_SUCCESS')));

		if($this->session->userdata('user_id'))
		$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('online' => '0'));

		$this->session->sess_destroy();

		redir($redir, array(lang('LOGOUT_SUCCESS')));
	}

	public function deletephoto()
	{
		is_notloggedin_redir(site_url('giris'));

		if($this->session->userdata('user_photo'))
		@unlink(ROOTPATH . $this->session->userdata('user_photo'));

		$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('photo' => NULL));

		redir(site_url('users/my'), array(lang('SUCCESS')));
	}

	public function view($username = null)
	{
		if(empty($username)) redir(site_url());

		$data = array();
		$location_array = array();

		$data['user'] = $this->users_model->get_user_data(['username' => $username]);

		if(empty($data['user']->id))
		$data['user'] = $this->users_model->get_user_data(['username_old' => $username]);

		if(empty($data['user']->id))
		{
			//Tanıtım yazısı ise yeni linkine 301 yap
			$seo_link_array = explode('-', $username);
			$price_text_id = end($seo_link_array);
			if(!empty($price_text_id) && is_numeric($price_text_id))
			{
				$price_text = $this->users_model->get_user_price(['p.id' => $price_text_id]);
				if(!empty($price_text))
				{
					redirect(base_url('ders-detay/'.$price_text->seo_link), 'location', 301);
				}
			}
			else redir(site_url());
		}

		if($this->uri->segment(1) == $data['user']->username_old)
		redirect(site_url($data['user']->username), 'location', 301);

		$data['prices'] = $this->users_model->get_user_prices(array('user_id' => $data['user']->id));

		$locations = $this->db->from('locations')->where('uid', $data['user']->id)->get()->result();
		if(!empty($locations))
		{
			$locations_text = array();
			foreach($locations as $key => $location){
				$location_array[$location->city][] = $location;
			}
		}
		$data['locations'] = $location_array;

		$data['comments'] = $this->db->from('comments')->where('status', 'A')->where('to_uid', $data['user']->id)->order_by('id', 'DESC')->get()->result();

		$seo_text_user_city = txtWordUpper($this->locations_model->get_location('locations_cities', ['id' => $data['user']->city], 'title'));
		//$seo_text_short_upper = !empty($seo_text) ? implode(', ', array_map('txtWordUpper', array_values(array_unique($seo_text_lessons)))) : '';
		//$seo_text_short = !empty($seo_text) ? implode(', ', array_map('txtLower', array_values(array_unique($seo_text)))) : '';
		$seo_text_long = !empty($seo_text) ? implode(', ', preg_filter('/$/', ' özel ders', array_map('txtLower', array_values(array_unique($seo_text))))) : '';

		$user_fullname = $data['user']->firstname . ' ' . user_lastname(txtWordUpper($data['user']->lastname), $data['user']->privacy_lastname);

		$data['seo_title'] = "$user_fullname Özel Ders Profil Sayfası $seo_text_user_city";

		if(($data['user']->ugroup == 5 || $data['user']->service_web == 'Y') && $data['user']->private_web == 'Y'){
			$result	= $this->load->view('pages/theme1', $data, true);
			$this->output->set_output($result);
		} else {
			$view_template = $data['user']->virtual == 'Y' ? 'users/view_virtual' : 'users/view';
			$data['viewPage'] = $this->load->view($this->folder_prefix . $view_template, $data, true);
			$result	= $this->load->view($this->template, $data, true);
			$this->output->set_output($result);
		}
	}


	public function view_price($seo_link = null)
	{
		$data = [];

		$data['price'] = $this->users_model->get_user_price(['p.seo_link' => $seo_link]);

		if(empty($data['price'])) redir(site_url());

		$data['user'] = $this->users_model->get_user_by(['id' => $data['price']->uid]);

		if(empty($data['user'])) redir(site_url());

		$user_fullname = $data['user']->firstname . ' ' . user_lastname(txtWordUpper($data['user']->lastname), $data['user']->privacy_lastname);

		$data['seo_title'] = strip_tags($data['price']->title) . ' ' . $data['price']->level_title . ' özel ders '. $user_fullname;
		$data['seo_description'] = strip_tags($data['price']->description);
		$data['seo_keyword'] = $user_fullname . ', ' . $data['price']->level_title . ' özel ders, ' . $data['price']->price_private . ' TL, ' . $data['price']->subject_title;

		$data['viewPage'] = $this->load->view('users/view_prices', $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}


	public function getmobile()
	{

		$this->load->library('user_agent');

		if(
			stristr($this->agent->agent_string(), 'Googlebot') == true ||
			stristr($this->agent->agent_string(), 'YandexBot') == true ||
			stristr($this->agent->agent_string(), 'YandexImages') == true ||
			stristr($this->agent->agent_string(), 'MegaIndex') == true
		){
			return false;
		}

		$hash = $this->input->get('hash', true);
		$hash = explode('-', $hash);
		if($this->security->xss_clean($hash[1]) == md5(md5(date('d.m.Y', time()))))
		{
			$user = $this->users_model->get_user_by(array('activation_code' => $this->security->xss_clean($hash[0])));

			if(!empty($user))
			{
				$num = $this->db->from('users_viewphones')->where('ip', $this->input->ip_address())->where('date >=', strtotime(date('d.m.Y 00:00:00', time())))->where('date <=', strtotime(date('d.m.Y 23:59:59', time())))->count_all_results();
				if(!empty($num) && $num >=50)
				{
					$newext = rand(1000,9999);
					echo str_replace(substr($user->mobile, -4), $newext, $user->mobile);
				} else {
					$uid = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : NULL;
					$this->users_model->insert_view_phone(array('uid' => $uid, 'tutor_id' => $user->id, 'date' => time(), 'ip' => $this->input->ip_address()));

					if($user->ugroup == 3 && !empty($GLOBALS['settings_global']->mobile)){
						echo $GLOBALS['settings_global']->mobile;
					} else {
						echo $user->mobile;
					}
				}
			}
			exit;
		}
	}

	public function sendmessage()
	{
		$errors 	= array();
		$messages 	= array();
		$redir 		= false;
		$call 		= false;
		$refresh	= false;

		if($this->input->post('form') == 'ajax_message')
		{
			if(!$this->session->userdata('user_id')){
				$this->form_validation->set_rules('firstname', 'Adınız', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Soyadınız', 'trim|required');
				$this->form_validation->set_rules('email', 'E-posta adresiniz', 'trim|required|valid_email');
				$this->form_validation->set_rules('mobile', 'Cep telefonu numaranız', 'trim|required');
			}

			$this->form_validation->set_rules('message', 'Mesajınız', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE)
			{
				$errors = $this->form_validation->error_array();
			} else {
				//E-posta adresi sistemde var ancak gsm farklı ise hata ver
				$from_user = $this->users_model->get_user_by(array('email' => $this->input->post('email', true)));
				if(!empty($from_user) && !empty($from_user->mobile) && str_replace(' ', '', $from_user->mobile) != $this->input->post('mobile'))
				{
					$errors[] = 'Girdiğiniz e-posta adresi kullanılmaktadır ancak cep telefonu numarası ile uyuşmamaktadır. Üye iseniz hesabınıza giriş yaparak cep telefonu numaranızı güncelleyiniz.';
				}

				//Alıcı var mı?
				$to_user = $this->users_model->get_user_by(array('id' => (int)$this->input->post('user_id', true)));
				if(empty($to_user)){
					$errors[] = 'Mesaj göndermeye çalıştığınız alıcı bulunamadı.';
				}

				//Alıcı var mı?
				if(!empty($to_user) && ($to_user->ugroup != 3 && $to_user->ugroup != 4 && $to_user->ugroup != 5)){
					$errors[] = 'Mesaj göndermeye çalıştığınız alıcı eğitmen değildir.';
				}

				//Gonderen ggitmen mi?
				if($this->session->userdata('user_id') && ($this->session->userdata('user_ugroup') == 3 || $this->session->userdata('user_ugroup') == 4 || $this->session->userdata('user_ugroup') == 5)){
					$errors[] = 'Eğitmenlerin başka bir eğitmene mesaj göndermesi yasaktır.';
				}

				if(empty($errors))
				{
					if(!$this->session->userdata('user_id'))
					{
						if(empty($from_user))
						{
							$this->load->helper('string');
							$random_number = random_string('alnum', 5);
							$insert_data = array(
								'username' 			=> unique_string('users', 'username', 8, 'numeric'),
								'firstname'	 		=> $this->input->post('firstname', true),
								'lastname' 			=> $this->input->post('lastname', true),
								'email' 			=> $this->input->post('email', true),
								'email_request' 	=> $this->input->post('email', true),
								'mobile' 			=> $this->input->post('mobile', true),
								'password' 			=> NULL,
								'password_text' 	=> NULL,
								'activation_code' 	=> md5(time()),
								'lang_code' 		=> $this->session->userdata('site_sl'),
								'register_page'		=> $_SERVER['HTTP_REFERER'],
								'register_form'		=> $this->input->post('form', true),
								'ugroup'			=> 2,
								'status'			=> 'A'
							);
							$user_id = $this->users_model->insert_user($insert_data);
							$from_user = $this->users_model->get_user_by(array('id' => $user_id));
						}

						$this->load->helper('cookie');
						set_cookie('unknown_msg_firstname', $from_user->firstname, 7200);
						set_cookie('unknown_msg_lastname', $from_user->lastname, 7200);
						set_cookie('unknown_msg_email', $from_user->email, 7200);
						set_cookie('unknown_msg_mobile', $from_user->mobile, 7200);
					}

					$messagedata = array(
						'from_uid' => $from_user->id ? $from_user->id : $this->session->userdata('user_id'),
						'to_uid' => $to_user->id,
						'message' => $this->input->post('message', true),
						'date' => time(),
						'ip' => $this->input->ip_address()
					);
					$this->db->insert('messages', $messagedata);

					$this->db->set('message_count', 'message_count+1', FALSE)->where('id', $to_user->id)->update('users');

					if(empty($to_user->mailmessage) || $to_user->mailmessage < strtotime('-15 minute', time())){
						m('new_message', $this->input->post('user_id', true));
						if($to_user->virtual == 'N')
						send_sms($to_user->mobile, sprintf(lang('SMS_NEW_MESSAGE'), $_SERVER['HTTP_HOST']));
					}
					$this->db->where('email', $to_user->email)->update('users', array('mailmessage' => time()));

					$messages[] = 'Mesajınız başarıyla gönderilmiştir.';
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res 		= empty($errors) 						? 'OK' 					: 'ERR';
				$messages 	= empty($errors) 						? $messages 			: $errors;
				$call 		= empty($errors) 						? $call 				: false;
				$redir 		= $refresh == true && empty($errors) 	? current_url() 		: false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}
	}

	public function sendcomment()
	{
		$errors 	= array();
		$messages 	= array();
		$redir 		= false;
		$call 		= false;
		$refresh	= false;

		if($this->input->post('form') == 'ajax_comment')
		{
			$this->form_validation->set_rules('point', 'Verdiğiniz puan', 'trim|required');
			$this->form_validation->set_rules('comment', 'Yorumunuz', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {
				if(!$this->session->userdata('user_id')) $errors[] = 'Yorum gönderebilmek için hesabınıza giriş yapmanız gerekmektedir.';

				if(empty($errors))
				{
					$commentdata = array(
						'point' => $this->input->post('point', true),
						'from_uid' => $this->session->userdata('user_id'),
						'to_uid' => $this->input->post('user_id', true),
						'comment' => $this->input->post('comment', true),
						'status' => 'W',
						'date' => time(),
						'ip' => $this->input->ip_address()
					);
					$this->db->insert('comments', $commentdata);

					$messages[] = 'Yorumunuz başarıyla gönderilmiştir. Onaylandıktan sonra yayınlanacaktır.';
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res 		= empty($errors) 						? 'OK' 					: 'ERR';
				$messages 	= empty($errors) 						? $messages 			: $errors;
				$call 		= empty($errors) 						? $call 				: false;
				$redir 		= $refresh == true && empty($errors) 	? current_url() 		: false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}
	}


	public function sendcomplaint()
	{
		$errors 	= array();
		$messages 	= array();
		$redir 		= false;
		$call 		= false;
		$refresh	= false;

		if($this->input->post('form') == 'ajax_complaint')
		{
			if(!$this->session->userdata('user_id')){
				$this->form_validation->set_rules('firstname', 'Adınız', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Soyadınız', 'trim|required');
				$this->form_validation->set_rules('email', 'E-posta adresiniz', 'trim|required|valid_email');
			}

			$this->form_validation->set_rules('message', 'Şikayetiniz', 'trim|required');
			$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));

			if ($this->form_validation->run() == FALSE){
				$errors = $this->form_validation->error_array();
			} else {

				//Alıcı var mı?
				$teacher = $this->users_model->get_user_by(array('id' => (int)$this->input->post('user_id', true)));
				if(empty($teacher)){
					$errors[] = 'Şikayet etmeye çalıştığınız eğitmen bulunamadı.';
				}

				//Alıcı var mı?
				if(!empty($teacher) && ($teacher->ugroup != 3 && $teacher->ugroup != 4 && $teacher->ugroup != 5)){
					$errors[] = 'Şikayet etmeye çalıştığınız kullanıcı, eğitmen değildir.';
				}

				if(empty($errors))
				{
					$complaintdata = array(
						'teacher_id' => $teacher->id,
						'firstname' => $this->input->post('firstname', true),
						'lastname' => $this->input->post('lastname', true),
						'email' => $this->input->post('email', true),
						'message' => $this->input->post('message', true),
						'date' => time(),
						'ip' => $this->input->ip_address()
					);
					$this->db->insert('complaints', $complaintdata);

					$messages[] = 'Şikayetiniz başarıyla kaydedilmiştir.';
				}
			}

			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				$res 		= empty($errors) 						? 'OK' 					: 'ERR';
				$messages 	= empty($errors) 						? $messages 			: $errors;
				$call 		= empty($errors) 						? $call 				: false;
				$redir 		= $refresh == true && empty($errors) 	? current_url() 		: false;
				echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
				exit;
			} else {
				if(!empty($errors)){
					redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
				} else {
					redir(current_url(), $messages);
				}
			}
		}
	}

	public function get_levels()
	{
		if($this->input->get('subject')){
			header('Content-type: application/json');
			$levels = $this->users_model->get_levels($this->input->get_post('subject', true));
			if(!empty($levels)){
				$levels_array = array();
				$levels_array[0] = array('id' => '', 'name' => "-- ".lang('ALL')." --");
				foreach($levels as $key => $item){
					$levels_array[$key + 1] = array('id' => $item->id, 'name' => $item->title);
				}
			}
			echo json_encode($levels_array, JSON_FORCE_OBJECT);
			exit;
		} else {
			echo json_encode(array(array('id' => "", 'name' => lang('CONTENTS_EMPTY'))), JSON_FORCE_OBJECT);
		}
	}

	function captcha()
	{
		echo json_encode(array('image' => '<img src="'.base_url('captcha/'.generate_captcha($this->input->post('form', true))).'" width="100%" height="38" class="border border-primary rounded" />', 'csrf_name' => $this->security->get_csrf_token_name(), 'csrf_hash' => $this->security->get_csrf_hash()));
		exit;
	}

	function marketing_choice()
	{
		$email 				= $this->input->get('email', true);
		$activation_code 	= $this->input->get('activation_code', true);
		$choice 			= $this->input->get('choice', true);

		if(empty($email) || empty($activation_code) || empty($choice) || ($choice != 1 && $choice != 2)) redir(site_url('contents/page_404'));

		$user = $this->db->from('users')->where('status', 'N')->where('email', $this->db->escape_str($email))->where('activation_code', $this->db->escape_str($activation_code))->get()->row();

		if(empty($user)) redir(site_url('contents/page_404'));

		$this->users_model->insert_verified_email($user->id, $user->email_request);

		$ugroup = $choice == 1 ? 2 : 3;
		$status = $ugroup == 2 ? 'A' : 'R';
		$this->users_model->update_user(array('id' => $user->id), array('email_request' => NULL, 'ugroup' => $ugroup, 'status' => $status));
		redir(site_url('users/my'), array(lang('SUCCESS')));
	}
}

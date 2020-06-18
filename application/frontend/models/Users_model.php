<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('locations_model');
    }

	public function login($login='', $password='')
	{
		if(empty($login) || empty($password)) return false;

		$user = $this->db->from('users')->where("(username = '".$this->db->escape_str($login)."' OR email = '".$this->db->escape_str($login)."')", NULL, FALSE)->where('password', $password)->get()->row();

		if(!empty($user)){
			$this->load->library('user_agent');
			$this->db->where('id', $user->id)->update('users', array('online' => 1, 'lastactive' => time(), 'uagent' => $this->agent->agent_string()));
		}

		return $user;
	}

	public function get_user_by($params = array())
	{
		if(empty($params)) return false;

		return $this->db->from('users')->where($params)->get()->row();
	}

	public function get_users_by($params = array())
	{
		if(empty($params)) return false;

		return $this->db->from('users')->where($params)->get()->result();
	}

	public function insert_user($data = array(), $mail = 'new_user')
	{
		if(empty($data)) return false;

		$this->load->library('user_agent');

		$insert_data = array(
			'fb_id' 			=> isset($data['fb_id']) ? $data['fb_id'] : NULL,
			'username' 			=> seo($data['username']),
			'firstname'	 		=> $data['firstname'],
			'lastname' 			=> $data['lastname'],
			'mobile' 			=> $data['mobile'] ? $data['mobile'] : NULL,
			'email' 			=> $data['email'],
			'email_request' 	=> $data['email_request'],
			'gender' 			=> isset($data['gender']) ? $data['gender'] : NULL,
			'password' 			=> $data['password'],
			'password_text' 	=> $data['password_text'],
			'activation_code' 	=> $data['activation_code'],
			'lang_code' 		=> $data['lang_code'],
			'register_form'		=> $data['register_form'],
			'register_page'		=> $data['register_page'],
			'search_point'		=> $data['search_point'],
			'ugroup'			=> $data['ugroup'] ? $data['ugroup'] : 2,
			'status' 			=> isset($data['status']) ? $data['status'] : 'N',
			'online' 			=> isset($data['online']) && $data['online'] == 1 ? 1 : 0,
		    'joined' 			=> time(),
			'ip' 				=> $this->input->ip_address(),
			'uagent' 			=> $this->agent->agent_string()
		);
		$this->db->insert('users', $insert_data);

		$user_id = $this->db->insert_id();

		m($mail, $user_id, array('activation_code' => $data['activation_code'])); //mail: type, id, extra

		return $user_id;
	}

	public function insert_user_temp($data = array())
	{
		if(empty($data)) return false;

		$this->load->library('user_agent');

		$data['joined'] = time();
		$data['ip'] = $this->input->ip_address();
		$data['uagent'] = $this->agent->agent_string();

		$this->db->insert('users_temp_registration', $data);

		$user_id = $this->db->insert_id();

		return $user_id;
	}

	public function update_user($where = array(), $update = array())
	{
		if(empty($where) || empty($update)) return false;

		$this->db->where($where)->update('users', $update);

		if(!empty($where['id']))
		$this->update_user_session($where['id']);
	}

	public function update_user_temp($data = array())
	{
		if(empty($data)) return false;

		$this->load->library('user_agent');

		$data['uid'] = $this->session->userdata('user_id');
		$data['date'] = time();
		$data['ip'] = $this->input->ip_address();

		$this->db->insert('users_temp_update', $data);

		$user_id = $this->db->insert_id();

		return $user_id;
	}

	public function insert_view_phone($data = array()){
		$this->db->insert('users_viewphones', $data);
	}

	public function forgot_send($user)
	{
		if(empty($user)) return false;

		$this->load->helper('string');
		$forgot = random_string('alnum', 8);

		$data = array(
			'forgot' => md5(md5($forgot)),
			'forgot_date' => time()
		);
		$this->db->where('id', $user->id)->update('users', $data);

		m('forgot', $user->id);
	}

	public function activation_resend($user)
	{
		if(empty($user)) return false;

		$this->load->helper('string');
		$random_number = random_string('alnum', 8);
		$activation_code = md5(time());
		$update_data = array(
			'password' => md5(md5($random_number)),
			'activation_code' => $activation_code
		);
		$this->update_user(array('id' => $user->id), $update_data);

		m('new_user', $user->id, array('password' => $random_number, 'activation_code' => $activation_code)); //mail: type, id, extra
	}

	public function update_user_session($user_id)
	{
		if(empty($user_id)) return false;

		$user = $this->get_user_by(array('id' => (int)$user_id));
		if(!empty($user))
		{
			$user->group_name = $this->db->from('users_groups')->where('id', $user->ugroup)->get()->row()->name;

			if($user->city)
			$user->city_title = $this->locations_model->get_location('locations_cities', ['id' => $user->city], 'title');

			if($user->town)
			$user->town_title = $this->locations_model->get_location('locations_towns', ['id' => $user->town], 'title');

			if(is_teacher($user->ugroup)){
				$user->prices = $this->get_prices($user->id);
				$user->locations = $this->locations_model->get_user_locations($user->id);
			}

			if(empty($user->password)){
				$user->nopassword = 1;
			}

			unset($user->password);
			unset($user->password_text);
			unset($user->forgot);

			$this->session->set_userdata(prefix_array_key('user_', $user));
		}
	}

	public function get_verified_emails($user_id)
	{
		if(empty($user_id)) return false;

		return $this->db->from('users_verified_emails')->where('uid', $user_id)->get()->result();
	}

	public function check_verified_email($user_id, $email)
	{
		if(empty($user_id) || empty($email)) return false;

		return $this->db->from('users_verified_emails')->where('uid', $user_id)->where('email', $email)->count_all_results();
	}

	public function insert_verified_email($user_id, $email)
	{
		if(empty($user_id) || empty($email)) return false;

		if(!$this->check_verified_email($user_id, $email))
		{
			$data = array(
				'uid' => $user_id,
				'email' => $email,
				'date' => time()
			);
			$this->db->insert('users_verified_emails', $data);
		}
	}

	public function get_professions()
	{
		return $this->db->from('professions')->get()->result();
	}

	public function get_subjects()
	{
		return $this->db->from('contents_categories')->where('parent_id', 6)->where('lang_code', $this->session->userdata('site_sl'))->get()->result();
	}

	public function get_levels($subject_id)
	{
		if(empty($subject_id)) return false;
		return $this->db->select('id, title')->from('contents_categories')->where('parent_id', (int)$subject_id)->where('lang_code', $this->session->userdata('site_sl'))->order_by('position')->get()->result();
	}

	public function get_user_level_names($user_id)
	{
		$user_level = [];

		if(empty($user_id)) return false;

		$levels = $this->db->select('l.title')->from('prices p')->join('contents_categories l', 'p.level_id=l.category_id')->where('l.lang_code', $this->session->userdata('site_sl'))->where('p.uid', $user_id)->get()->result();
		if(!empty($levels)){

			foreach($levels as $level)
			{
				$user_level[] = $level->title;
			}
		}

		return implode(', ', array_unique($user_level));
	}

	public function get_category_name_by_id($id)
	{
		if(empty($id)) return false;
		return $this->db->from('contents_categories')->where('category_id', (int)$id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
	}

	public function get_prices($user_id = null)
	{
		$user_id = $user_id ? $user_id : $this->session->userdata('user_id');
		$this->db->where('p.uid', $user_id);
		$this->db->where('c1.lang_code', $this->session->userdata('site_sl'));
		$this->db->where('c2.lang_code', $this->session->userdata('site_sl'));
		$this->db->from('prices p');
		$this->db->join('contents_categories c1', 'c1.category_id=p.subject_id', 'left');
		$this->db->join('contents_categories c2', 'c2.category_id=p.level_id', 'left');

		$this->db->select('p.id, p.price_live, p.price_private, p.title, p.description, p.status, c1.title subject_title, c2.title level_title');

		$items = $this->db->get()->result();

		return $items;
	}

	public function insert_price_text($price_text_data = array())
	{
		if(empty($price_text_data)) return false;

		$check = $this->db->from('prices')->where('id', $price_text_data['id'])->where('uid', $price_text_data['uid'])->get()->row();
		if(!empty($check))
		$this->db->where('id', $check->id)->update('prices', $price_text_data);
	}

	public function insert_price($price_data = array())
	{
		if(empty($price_data)) return false;

		$check = $this->db->from('prices')->where('subject_id', $price_data['subject_id'])->where('level_id', $price_data['level_id'])->where('uid', $price_data['uid'])->get()->row();
		if(!empty($check))
		{
			$this->db->where('id', $check->id)->update('prices', $price_data);
		} else {
			$this->db->insert('prices', $price_data);
		}
	}

	public function delete_price($id)
	{
		if(empty($id)) return false;

		return $this->db->where('id', $id)->where('uid', $this->session->userdata('user_id'))->delete('prices');
	}

	public function update_price($data = array())
	{
		if(empty($data['id']) || empty($data['user_id']) || empty($data['update_data'])) return false;

		$this->db->where('uid', (int)$data['user_id'])->where('id', (int)$data['id'])->update('prices', $data['update_data']);
	}

	public function get_user_prices($data = array()){
		if(empty($data['user_id'])) return false;

		return $this->db
			->select('p.*, c1.title as subject_title, c2.title as level_title')
			->from('prices p')
			->join('contents_categories c1', 'p.subject_id=c1.category_id', 'left')
			->join('contents_categories c2', 'p.level_id=c2.category_id', 'left')
			->where('p.uid', $data['user_id'])
			->get()->result();
	}

	public function get_user_price($id = null){
		if(empty($id)) return false;

		return $this->db
			->select('p.*, c1.title as subject_title, c2.title as level_title')
			->from('prices p')
			->join('contents_categories c1', 'p.subject_id=c1.category_id', 'left')
			->join('contents_categories c2', 'p.level_id=c2.category_id', 'left')
			->where('p.id', $id)
			->get()->row();
	}

	public function get_user_month($data = array())
	{
		if(empty($data['subject_id']) || empty($data['level_id'])) return false;

		$start = explode('.', date('1.m.Y', time()));
		$end = explode('.', date('t.m.Y', time()));

		$start_date = mktime(0,0,0,$start[1],$start[0],$start[2]);
		$end_date = mktime(23,59,59,$end[1],$end[0],$end[2]);

		$user = $this->db
					->select('uid')
					->from('orders')
					->where('transaction_id IS NOT NULL')
					->where('subject_id', $data['subject_id'])
					->where('level_id', $data['level_id'])
					->where('start_date >=', $start_date)
					->where('end_date <=', $end_date)
					->where('product_id IN(26,27)')
					->limit(1)
					->get()->row();

		if(!empty($user))
		return $this->get_user_data($user->uid);
	}

	public function get_user_week($data = array())
	{
		if(empty($data['subject_id']) || empty($data['level_id'])) return false;

		$week = date('w');
		$week = $week;
		$start = explode('.', date('d.m.Y', strtotime('-'.$week.' days')));
		$end = explode('.', date('d.m.Y', strtotime('+'.(7-$week).' days')));

		$start_date = mktime(0,0,0,$start[1],$start[0],$start[2]);
		$end_date = mktime(23,59,59,$end[1],$end[0],$end[2]);

		$user = $this->db
					->select('uid')
					->from('orders')
					->where('transaction_id IS NOT NULL')
					->where('subject_id', $data['subject_id'])
					->where('level_id', $data['level_id'])
					->where('start_date >=', $start_date)
					->where('end_date <=', $end_date)
					->where('product_id IN(24,25)')
					->limit(1)
					->get()->row();

		if(!empty($user))
		return $this->get_user_data($user->uid);
	}

	public function get_user_day($data = array())
	{
		if(empty($data['subject_id']) || empty($data['level_id'])) return false;

		$day = explode('.', date('d.m.Y', time()));
		$start_date = mktime(0,0,0,$day[1],$day[0],$day[2]);
		$end_date = mktime(23,59,59,$day[1],$day[0],$day[2]);

		$user = $this->db
					->select('uid')
					->from('orders')
					->where('transaction_id IS NOT NULL')
					->where('subject_id', $data['subject_id'])
					->where('level_id', $data['level_id'])
					->where('start_date >=', $start_date)
					->where('end_date <=', $end_date)
					->where('product_id IN(22,23)')
					->limit(1)
					->get()->row();

		if(!empty($user))
		return $this->get_user_data($user->uid);
	}

	public function get_user_data($user_id = null)
	{
		if(empty($user_id)) return false;

		$this->db->where('users.id', (int)$user_id);
		//$this->db->where('users.status', 'A'); //inaktif olanlarin profilleri duracak, listelemede cikmayacak
		//$this->db->where('users.email_request', NULL);
		$this->db->where('users.ugroup IN(3,4,5)');
		//$this->db->where("(prices.price_private IS NOT NULL OR prices.price_live IS NOT NULL OR users.virtual = 'Y')");

		$this->db->from('users');
		$this->db->join('prices', 'prices.uid=users.id', 'left');
		$this->db->join('locations_cities', 'locations_cities.id=users.city', 'left');
		$this->db->join('locations_towns', 'locations_towns.id=users.town', 'left');

		$this->db->select('
			users.*,
			TIMESTAMPDIFF(YEAR, DATE_FORMAT(STR_TO_DATE('.$this->db->dbprefix('users').'.birthday, "%d/%m/%Y"), "%Y-%m-%d"), CURDATE()) age,
			MIN(LEAST(
				IF('.$this->db->dbprefix('prices').'.price_private = 0 OR '.$this->db->dbprefix('prices').'.price_private IS NULL, '.$this->db->dbprefix('prices').'.price_live, '.$this->db->dbprefix('prices').'.price_private),
				IF('.$this->db->dbprefix('prices').'.price_live = 0 OR '.$this->db->dbprefix('prices').'.price_live IS NULL, '.$this->db->dbprefix('prices').'.price_private, '.$this->db->dbprefix('prices').'.price_live)
			)) as price_min,
			MAX(GREATEST(COALESCE('.$this->db->dbprefix('prices').'.price_private, '.$this->db->dbprefix('prices').'.price_live),  COALESCE('.$this->db->dbprefix('prices').'.price_live, '.$this->db->dbprefix('prices').'.price_private))) as price_max,
			locations_cities.title city_title,
			locations_towns.title town_title,
			');

		$user = $this->db->get()->row();

		$user->prices = $this->get_user_prices(array('user_id' => $user->id));

		if(!empty($user->prices))
		{
			$groupped_prices = [];
			$groupped_prices2 = [];
			foreach($user->prices as $price)
			{
				$groupped_prices[$price->subject_title][] = ['title' => $price->level_title, 'private' => $price->price_private, 'live' => $price->price_live];
			}

			foreach($groupped_prices as $subject => $prices)
			{
				$groupped_prices2[] = ['title' => $subject, 'levels' => $prices];
			}

			$user->groupped_prices = $groupped_prices2;
		}

		$locations = $this->db
		->select('locations_cities.title city_title, locations_towns.title town_title')
		->from('locations')
		->join('locations_cities', 'locations_cities.id=locations.city', 'left')
		->join('locations_towns', 'locations_towns.id=locations.town', 'left')
		->where('locations.uid', $user->id)
		->get()->result();

		if(!empty($locations))
		{
			$groupped_locations = [];
			$groupped_locations2 = [];
			foreach($locations as $location)
			{
				$groupped_locations[$location->city_title][] = ['title' => $location->town_title];
			}

			foreach($groupped_locations as $city => $town)
			{
				$groupped_locations2[] = ['title' => $city, 'towns' => $town];
			}

			$user->groupped_locations = $groupped_locations2;
		}

		return $user;
	}

	public function get_users_by_search($data = array())
	{
		$response = array();

		$this->db->start_cache();

		$data['city_id'] = $data['city_id'] ? $data['city_id'] : $this->session->userdata('site_city');

		if(empty($data['live']) && (!empty($data['city_id']) || !empty($data['town_id'])))
		{
			if(!empty($data['town_id'])){
				$town = " && town = ".$data['town_id'];
				//disable virtual $this->db->where("(".$this->db->dbprefix('locations').".town = '".$data['town_id']."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".town = '".$data['town_id']."'))");
			}
			$this->db->where("users.id IN(SELECT uid FROM ".$this->db->dbprefix('locations')." WHERE city = ".$data['city_id']." $town)");
			//disable virtual $this->db->where("(".$this->db->dbprefix('locations').".city = '".$data['city_id']."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".city = '".$data['city_id']."'))");
			/*
			if(!empty($data['town_id'])){
				$this->db->where('locations.town', $data['town_id']);
				//disable virtual $this->db->where("(".$this->db->dbprefix('locations').".town = '".$data['town_id']."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".town = '".$data['town_id']."'))");
			}
			*/
		}

		/* çoklu bölge arama aktif edilirse
		if(!empty($data['town_ids'])){
			$townArray = array();
			foreach($data['town_ids'] as $town_id){
				$townArray[] = "".$this->db->dbprefix('locations').".town = $town_id";
			}
			$townArray = implode(' OR ', $townArray);
			$this->db->where("($townArray)");
		}
		*/

		if(!empty($data['subject_id'])){
			$this->db->where('prices.subject_id', $data['subject_id']);
			//disable virtual $this->db->where("(".$this->db->dbprefix('prices').".subject_id = '".$data['subject_id']."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && FIND_IN_SET(".$data['subject_id'].", ".$this->db->dbprefix('users').".virtual_subjects)))");
		}

		if(!empty($data['level_id'])){
			$this->db->where('prices.level_id', $data['level_id']);
			//disable virtual $this->db->where("(".$this->db->dbprefix('prices').".level_id = '".$data['level_id']."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && FIND_IN_SET(".$data['level_id'].", ".$this->db->dbprefix('users').".virtual_levels)))");
		}
		/*
		if(!empty($data['virtual'])){
			$this->db->where('prices.level_id', $data['level_id']);
			//disable virtual $this->db->where('virtual', $data['virtual']);
		}
		*/

		if(isset($data['price_min']))
		$this->db->where("(CASE WHEN ".$this->db->dbprefix('prices').".price_private < 1 THEN ".$this->db->dbprefix('prices').".price_live >= ".$data['price_min']." ELSE ".$this->db->dbprefix('prices').".price_private >= ".$data['price_min']." END)", NULL, FALSE);
		//disable virtual $this->db->where("(CASE WHEN ".$this->db->dbprefix('prices').".price_private < 1 THEN ".$this->db->dbprefix('prices').".price_live >= ".$data['price_min']." ELSE ".$this->db->dbprefix('prices').".price_private >= ".$data['price_min']." END)", NULL, FALSE);

		if(isset($data['price_max']))
		$this->db->where("(CASE WHEN ".$this->db->dbprefix('prices').".price_private < 1 THEN ".$this->db->dbprefix('prices').".price_live <= ".$data['price_max']." ELSE ".$this->db->dbprefix('prices').".price_private <= ".$data['price_max']." END)", NULL, FALSE);

		if(!empty($data['figure'])){
			$figureArray = array();
			foreach($data['figure'] as $figure_id){
				$figureArray[] = "FIND_IN_SET($figure_id, ".$this->db->dbprefix('users').".figures)";
			}
			$figureArray = implode(' OR ', $figureArray);
			$this->db->where("($figureArray)");
		}

		if(!empty($data['place'])){
			$placeArray = array();
			foreach($data['place'] as $place_id){
				$placeArray[] = "FIND_IN_SET($place_id, ".$this->db->dbprefix('users').".places)";
			}
			$placeArray = implode(' OR ', $placeArray);
			$this->db->where("($placeArray)");
		}

		if(!empty($data['time'])){
			$timeArray = array();
			foreach($data['time'] as $time_id){
				$timeArray[] = "FIND_IN_SET($time_id, ".$this->db->dbprefix('users').".times)";
			}
			$timeArray = implode(' OR ', $timeArray);
			$this->db->where("($timeArray)");
		}

		if(!empty($data['service'])){
			$serviceArray = array();
			foreach($data['service'] as $service_id){
				$serviceArray[] = "FIND_IN_SET($service_id, ".$this->db->dbprefix('users').".services)";
			}
			$serviceArray = implode(' OR ', $serviceArray);
			$this->db->where("($serviceArray)");
		}

		if(!empty($data['discount7']))
		$this->db->where("users.discount7 IS NOT NULL");

		if(!empty($data['discount8']))
		$this->db->where("users.discount8 IS NOT NULL");

		if(!empty($data['discount9']))
		$this->db->where("users.discount9 IS NOT NULL");

		if(!empty($data['discount10']))
		$this->db->where("users.discount10 IS NOT NULL");

		if(!empty($data['discount11']))
		$this->db->where("users.discount11 IS NOT NULL");

		if(!empty($data['discount12']))
		$this->db->where("users.discount12 IS NOT NULL");

		if(!empty($data['discount13']))
		$this->db->where("users.discount13 IS NOT NULL");

		if(!empty($data['discount_live']))
		$this->db->where("(users.discount1 IS NOT NULL OR users.discount2 IS NOT NULL OR users.discount3 IS NOT NULL OR users.discount4 IS NOT NULL OR users.discount5 IS NOT NULL OR users.discount6 IS NOT NULL)");

		if(!empty($data['group']))
		$this->db->where_in("users.ugroup", $data['group']);

		if(!empty($data['badge']))
		$this->db->where("users.service_badge", 'Y');

		if(!empty($data['online']))
		$this->db->where("users.online", 1);

		if(!empty($data['photo']))
		$this->db->where("users.photo !=", "");

		if(!empty($data['gender']))
		$this->db->where("users.gender", $data['gender']);

		/* disable virtual
		if(!empty($data['keyword']))
		{
			if(!empty($data['keyword_lesson_ids']))
			{
				$keyword_lesson_ids = explode(",", $data['keyword_lesson_ids']);
				$keyword_lesson_id_array = array();
				foreach($keyword_lesson_ids as $keyword_lesson_id){
					$keyword_lesson_id_array[] = "FIND_IN_SET(".$keyword_lesson_id.", ".$this->db->dbprefix('users').".virtual_levels)";
				}
				$find_in_set = implode(" OR ", $keyword_lesson_id_array);

				$this->db->where("(".$this->db->dbprefix('contents_categories').".category_id IN(".$this->db->escape_str($data['keyword_lesson_ids']).") OR ".$this->db->dbprefix('users').".virtual = 'Y' AND $find_in_set)", NULL, FALSE);
			} else {
				$this->db->where("(contents_categories.title LIKE '%".$this->db->escape_str($data['keyword'])."%' OR users.firstname LIKE '%".$this->db->escape_str($data['keyword'])."%' OR users.lastname LIKE '%".$this->db->escape_str($data['keyword'])."%' OR users.text_title LIKE '%".$this->db->escape_str($data['keyword'])."%' OR users.text_long LIKE '%".$this->db->escape_str($data['keyword'])."%')");
			}
		}
		*/

		if(!empty($data['keyword']))
		$this->db->where("CONCAT_WS(' ', ".$this->db->dbprefix('contents_categories').".title, ".$this->db->dbprefix('users').".firstname, ".$this->db->dbprefix('users').".lastname, ".$this->db->dbprefix('users').".text_title, ".$this->db->dbprefix('users').".text_short) LIKE '%".$this->db->escape_str($data['keyword'])."%' COLLATE utf8_general_ci", NULL, FALSE);

		$this->db->where('users.status', 'A');
		$this->db->where('users.email_request', NULL);
		$this->db->where('users.ugroup IN(3,4,5)');
		//disable virtual $this->db->where("(prices.price_private IS NOT NULL OR prices.price_live IS NOT NULL OR users.virtual = 'Y')");

		if(empty($data['live']))
		{
			$this->db->where("(prices.price_private IS NOT NULL OR prices.price_live IS NOT NULL)");
		}
		else
		{
			$this->db->where("prices.price_live IS NOT NULL");
		}

		$this->db->from('users');
		$this->db->join('prices', 'prices.uid=users.id', 'left');
		$this->db->join('contents_categories', 'contents_categories.category_id=prices.level_id', 'left');
		$this->db->join('locations_cities', 'locations_cities.id=users.city', 'left');
		$this->db->join('locations_towns', 'locations_towns.id=users.town', 'left');

		/*
		if(!empty($data['live'])){
			$this->db->join('calendar', 'calendar.uid=users.id');
		}
		*/

		$this->db->group_by('users.id');

		$this->db->stop_cache();

		$this->db->select('users.*');

		$response['total'] = $this->db->get()->num_rows();

		$this->db->select('
			users.id,
			users.virtual,
			users.virtual_age,
			users.virtual_price,
			users.ugroup,
			users.service_badge,
			users.service_featured,
			users.username,
			users.firstname,
			users.lastname,
			users.privacy_lastname,
			users.photo,
			users.gender,
			users.online,
			users.text_title,
			users.text_long,
			users.birthday,
			users.discount1,
			users.discount2,
			users.discount3,
			users.discount4,
			users.discount5,
			users.discount6,
			users.discount7,
			users.discount8,
			users.discount9,
			users.discount10,
			users.discount11,
			users.discount12,
			users.discount13,
			users.founder,
			users.city,
			users.town,
			users.search_point,
			TIMESTAMPDIFF(YEAR, DATE_FORMAT(STR_TO_DATE('.$this->db->dbprefix('users').'.birthday, "%d/%m/%Y"), "%Y-%m-%d"), CURDATE()) age,

			MIN(LEAST(
				IF('.$this->db->dbprefix('prices').'.price_private = 0 OR '.$this->db->dbprefix('prices').'.price_private IS NULL, '.$this->db->dbprefix('prices').'.price_live, '.$this->db->dbprefix('prices').'.price_private),
				IF('.$this->db->dbprefix('prices').'.price_live = 0 OR '.$this->db->dbprefix('prices').'.price_live IS NULL, '.$this->db->dbprefix('prices').'.price_private, '.$this->db->dbprefix('prices').'.price_live)
			)) as price_min,


			MAX(GREATEST(COALESCE('.$this->db->dbprefix('prices').'.price_private, '.$this->db->dbprefix('prices').'.price_live),  COALESCE('.$this->db->dbprefix('prices').'.price_live, '.$this->db->dbprefix('prices').'.price_private))) as price_max,
			locations_cities.title city_title,
			locations_towns.title town_title,
			', FALSE);

		if(isset($data['sort_price'])){
			$ascdesc = $data['sort_price'] == 'asc' ? 'asc' : 'desc';
			$this->db->order_by("prices.price_private $ascdesc, prices.price_live $ascdesc");
		} elseif(isset($data['sort_point'])){
			$ascdesc = $data['sort_point'] == 'asc' ? 'asc' : 'desc';
			$this->db->order_by("users.user_point $ascdesc");
		} elseif(isset($data['sort_date'])){
			$ascdesc = $data['sort_date'] == 'asc' ? 'asc' : 'desc';
			$this->db->order_by("users.joined $ascdesc");
		} else {
			$this->db->order_by("users.search_point desc, users.online desc, users.lastactive desc");
		}

		$limit = !empty($data['limit']) ? $data['limit'] : 20;
		$page = isset($data['page']) && !empty($data['page']) ? $data['page'] : 1;

		$this->db->limit($limit, (($page-1)*$limit));

		$response['users'] = $this->db->get()->result();

		$this->db->flush_cache();

		return $response;
	}

	public function insert_requests_wait($data = array())
	{
		if(!empty($data))
		{
			unset($data['security_code']);
			unset($data['ci_csrf_token']);

			$insert_data = array();

			foreach($data as $key => $value)
			{
				$insert_data[$key] = $this->security->xss_clean($value);
			}

			$insert_data['date'] = time();
			$insert_data['ip'] = $this->input->ip_address();

			$this->db->insert('requests_wait', $insert_data);
			return $this->db->insert_id();
		}
	}
}
?>

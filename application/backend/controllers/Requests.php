<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requests extends CI_Controller {

	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('requestsmodel');
		$this->load->model('locationsmodel');
		$this->load->model('contentsmodel');
		$this->load->model('usersmodel');
	}

	public function index()
	{
		check_perm('requests_overview');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{	
			$this->db->start_cache();

			if($this->input->get_post('sSearch')){
				$search_term = trim($this->input->get_post('sSearch', true));
				$this->db->where("CONCAT_WS(' ', ".$this->db->dbprefix('users').".firstname, ".$this->db->dbprefix('users').".lastname, ".$this->db->dbprefix('users').".mobile, ".$this->db->dbprefix('requests').".phone, ".$this->db->dbprefix('requests').".fullname, ".$this->db->dbprefix('requests_activities').".description) LIKE '%".$this->db->escape_str($search_term)."%' COLLATE utf8_general_ci", NULL, FALSE);
			}
									
			if($this->input->get_post('sSearch_0') == 'Y'){
				$this->db->where('requests_lessons.balance >', 0);
			}
			
			if($this->input->get_post('sSearch_1')){
				$this->db->where_in('requests_lessons.status_id', explode(',', $this->input->get_post('sSearch_1')));
			} else {
				$this->db->where_not_in('requests_lessons.status_id', array(8,15));
			}
			
			if($this->input->get_post('sSearch_0') == 'N'){
				$this->db->where('requests_lessons.balance', NULL);
			}				
				
			$this->db->from('requests_lessons');
			$this->db->join('requests', 'requests_lessons.request_id=requests.id');
			$this->db->join('users', 'requests_lessons.teacher_id=users.id', 'left');
			$this->db->join('requests_statuses', 'requests_lessons.status_id=requests_statuses.id');
			$this->db->join('requests_activities', 'requests_activities.lesson_id=requests_lessons.lesson_id AND requests_activities.request_id=requests_lessons.request_id', 'left');
			
			$this->db->stop_cache();
			
			$this->db->select('requests_lessons.id')->distinct();
	
			$total = $this->db->count_all_results();
			
			$this->db->select('requests_lessons.id, requests_lessons.request_id, requests_lessons.create_date, requests_lessons.status_id, requests_lessons.last_payment_date, requests.fullname, requests.phone, requests.city, requests.town, requests_lessons.lesson_id, requests_lessons.teacher_id, requests_lessons.appointment_date, requests_lessons.lesson_hour, requests_lessons.model_id, requests_lessons.status_sms, requests_lessons.status_start, requests_lessons.balance, requests_lessons.payed, users.firstname, users.lastname, users.mobile, users.id user_id')->distinct();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();
						
			$this->db->flush_cache();
			
			foreach($items as $item)
			{
				$item->level = $this->requestsmodel->get_category(array('category_id' => $item->lesson_id));
				$item->subject = $this->requestsmodel->get_category(array('category_id' => $item->level->parent_id));				
				$item->status_info = $this->requestsmodel->get_lesson_status_info($item);
				$item->city_title = $this->locationsmodel->get_location('locations_cities', ['id' => $item->city], 'title');
				$item->town_title = $this->locationsmodel->get_location('locations_towns', ['id' => $item->town], 'title');
			}
			
			$data['items'] = $items;

			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}
		}
		
		$data['statuses'] = $this->requestsmodel->get_requests_statuses();
		
		$data['viewPage'] = $this->load->view('requests/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	

	public function add(){
	
		check_perm('requests_add');
		
		$data 	= array();
		
		if($this->input->post('form'))
		{			
			$form		= $this->input->post('form', true);
			$lessons	= $this->input->post('new', true);
			
			if(empty($form['fullname'])) 		$data['errors'][] = 'Lütfen ad soyad alanını boş bırakmayınız';
			if(empty($form['phone'])) 			$data['errors'][] = 'Lütfen telefon alanını boş bırakmayınız';
			if(empty($form['town'])) 			$data['errors'][] = 'Lütfen ilçe alanını boş bırakmayınız';
			if(empty($lessons['category'][0])) 	$data['errors'][] = 'Lütfen talep için en az bir ders seçiniz';
			if(empty($data['errors']))
			{
				$inserted_request_id = $this->requestsmodel->insert_request($form);
				
				if(!empty($inserted_request_id))
				$inserted_request_lesson_ids = $this->requestsmodel->insert_request_lesson($inserted_request_id, $lessons);	
								
				f_redir(base_url('backend/requests/edit/'.$inserted_request_id), array(lang('SUCCESS')));
			}
		}
		
		$data['categories'] = $this->contentsmodel->getcategoriesrecursive(6);
		$data['cities'] = $this->locationsmodel->get_locations('locations_cities');

		$data['viewPage'] = $this->load->view('requests/add', $data, true);
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function edit($request_id){
	
		check_perm('requests_edit');
		
		$data = array();
		
		if($this->input->post('form'))
		{			
			$form		= $this->input->post('form', true);
			$lessons	= $this->input->post('new', true);
			
			if(empty($form['fullname'])) 	$data['errors'][] = 'Lütfen ad soyad alanını boş bırakmayınız';
			if(empty($form['phone'])) 		$data['errors'][] = 'Lütfen telefon alanını boş bırakmayınız';
			if(empty($form['town'])) 		$data['errors'][] = 'Lütfen ilçe alanını boş bırakmayınız';
						
			if(empty($data['errors']))
			{
				$this->requestsmodel->update_request(array('id' => $request_id), $form);
								
				$inserted_request_lesson_ids = $this->requestsmodel->insert_request_lesson($request_id, $lessons);	
				
				f_redir(base_url('backend/requests/edit/'.$request_id), array(lang('SUCCESS')));	
			}
		}
		
		if($this->input->post('form_name'))
		{
			$teacher_id = NULL;
			$price_type = NULL;
			$lesson_hour = NULL;
			$hourly_price = NULL;
			$model_id = NULL;
			$price = NULL;
			$appointment_date = NULL;
			$start_date = NULL;
			$end_date = NULL;
			
			switch($this->input->post('form_name'))
			{
				case 'information':
					$lesson_id 	 = $this->input->post('lesson');
					$type 		 = $this->input->post('type');
					$who 		 = $this->input->post('who');
					$description = $this->input->post('description');

					if(empty($lesson_id)) 	$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($type)) 		$data['errors'][] = 'Lütfen tür alanını boş bırakmayınız';
					if(empty($who)) 		$data['errors'][] = 'Lütfen görüşülen alanını boş bırakmayınız';
					if(empty($description)) $data['errors'][] = 'Lütfen açıklama alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson_data = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson_data)) $data['errors'][] = 'Ders talebi bulunamadı';	
						if($who == 2 && empty($lesson_data->teacher->id)) $data['errors'][] = 'Derse ait eğitmen kaydı bulunamadı';	

						if($type == 1 && $who == 1){
							$status_id = 11; //Öğrenci Bilgi Girişi Yapıldı
						} elseif($type == 1 && $who == 2){							
							$status_id = 12; //Eğitmen Bilgi Girişi Yapıldı
							$teacher_id = $lesson_data->teacher_id;	
						} elseif($type == 2 && $who == 1){
							$status_id = 9; //Öğrenci Görüşmesi Yapıldı
						} else {
							$status_id = 10; //Eğitmen Görüşmesi Yapıldı
							$teacher_id = $lesson_data->teacher_id;	
						}
					}					
				break;
				
				case 'assignment':
					$lesson_id 	 = $this->input->post('lesson');
					$teacher_id  = $this->input->post('teacher_id');
					$description = $this->input->post('description');
					$description2 = $this->input->post('description2');

					if(empty($lesson_id)) 	$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($teacher_id)) 	$data['errors'][] = 'Lütfen atanacak eğitmen alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						$teacher = $this->usersmodel->get_user(array('id' => $teacher_id));
						
						if(empty($lesson)) $data['errors'][] = 'Atama yapılacak ders kaydı bulunamadı';
						if(empty($teacher)) $data['errors'][] = 'Atanacak eğitmene ait kayıt bulunamadı';
						if(!empty($lesson->teacher->id) && empty($description2)) $data['errors'][] = 'Eğitmen iptal nedenini boş bırakmayınız';
					
						if(empty($data['errors']))
						{
							$status_id = 2; //Eğitmen atandı
							
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('status_id' => $status_id, 'teacher_id' => $teacher_id, 'appointment_date' => NULL, 'price_type' => NULL, 'lesson_hour' => NULL, 'hourly_price' => NULL, 'model_id' => NULL, 'price' => NULL, 'status_sms' => NULL, 'status_start' => NULL));
							
							if(!empty($lesson->teacher->id) && !empty($description2))
							{								
								//egitmen kaldirildi aktivitesi ekle
								$this->requestsmodel->insert_request_activity(array('request_id' => $request_id, 'lesson_id' => $lesson_id, 'status_id' => 6, 'teacher_id' => $lesson->teacher->id, 'description' => $description2));			
								
								//kaldirilan egitmene ait aktiviteleri silinmis yap
								$this->requestsmodel->update_request_activity(array('request_id' => $request_id, 'lesson_id' => $lesson_id, 'teacher_id' => $lesson->teacher->id), array('status' => 'O'));									
							}
						}
					}				
				break;
				
				case 'sms':
					$lesson_id 	 = $this->input->post('lesson');
					$sent 	 	 = $this->input->post('sent');
					$description = $this->input->post('description');

					if(empty($lesson_id)) 	$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($description)) $data['errors'][] = 'Lütfe mesaj alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson)) $data['errors'][] = 'SMS gönderilecek ders kaydı bulunamadı';
						if(empty($lesson->teacher)) $data['errors'][] = 'SMS gönderilecek eğitmene ait kayıt bulunamadı';
					
						if(empty($data['errors']))
						{
							$status_id = 3; //SMS Gönderildi
							$teacher_id = $lesson->teacher->id;
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('status_id' => $status_id, 'status_sms' => 'Y'));
							
							if($sent != 'Y'){
								$request = $this->requestsmodel->get_request(array('id' => $request_id));

								$description = str_replace("[OGR_NAME]", $request->fullname, $description);
								$description = str_replace("[OGR_TEL]", $request->phone, $description);
								$description = str_replace("[OGR_DERS]", $lesson->subject->title . ' > ' . $lesson->level->title, $description);
								$description = str_replace("[BANK_INFO]", $GLOBALS['settings_global']->bank_info, $description);
								send_sms($lesson->teacher->mobile, $description);
							}
						}
					}				
				break;
				
				case 'appointment':
					$lesson_id 	 		= $this->input->post('lesson');
					$appointment_date 	= $this->input->post('appointment_date');
					$description 		= $this->input->post('description');

					if(empty($lesson_id)) 			$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($appointment_date)) 	$data['errors'][] = 'Lütfen randevu tarihi alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson)) $data['errors'][] = 'SMS gönderilecek ders kaydı bulunamadı';
						if(empty($lesson->teacher)) $data['errors'][] = 'SMS gönderilecek eğitmene ait kayıt bulunamadı';
					
						if(empty($data['errors']))
						{
							$status_id = 4; //Randevu Tarihi Belirlendi
							$teacher_id = $lesson->teacher->id;
							$appointment_date = strtotime($appointment_date);
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('status_id' => $status_id, 'appointment_date' => $appointment_date));							
						}
					}				
				break;	
				
				case 'settime':
					$lesson_id 	 		= $this->input->post('lesson');
					$price_type 		= $this->input->post('price_type');
					$lesson_hour 		= $this->input->post('hour');
					$hourly_price 		= $this->input->post('price');
					$description 		= $this->input->post('description');

					if(empty($lesson_id)) 		$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($price_type)) 		$data['errors'][] = 'Lütfen tür alanını boş bırakmayınız';
					if(empty($lesson_hour)) 	$data['errors'][] = 'Lütfen saat alanını boş bırakmayınız';
					if(empty($hourly_price)) 	$data['errors'][] = 'Lütfen ücret alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson)) $data['errors'][] = 'Ders süresi girilecek ders kaydı bulunamadı';
						if(empty($lesson->teacher)) $data['errors'][] = 'Ders süresi girilecek dersin eğitmenine ait kayıt bulunamadı';
					
						if(empty($data['errors']))
						{
							$status_id = 13; //Ders Süresi Girişi Yapıldı
							$teacher_id = $lesson->teacher->id;
							
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('status_id' => $status_id, 'price_type' => $price_type, 'lesson_hour' => $lesson_hour, 'hourly_price' => $hourly_price));
							
							$this->requestsmodel->update_request_lessons_teacher(array('request_id' => $request_id, 'lesson_id' => $lesson_id, 'teacher_id' => $lesson->teacher->id, 'status' => 'A'), array('price_type' => $price_type, 'lesson_hour' => $hour, 'hourly_price' => $price));
						}
					}				
				break;	
				
				case 'setmodel':
					$lesson_id 	 	= $this->input->post('lesson');
					$model_id 		= $this->input->post('model');
					$price 	= $this->input->post('price') ? $this->input->post('price') : NULL;
					$description 	= $this->input->post('description');

					if(empty($lesson_id)) 												$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($model_id)) 												$data['errors'][] = 'Lütfen model alanını boş bırakmayınız';
					if(!empty($model_id) && $model_id == 10 && empty($price)) 	$data['errors'][] = 'Lütfen sabit ücret tutarı alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson)) $data['errors'][] = 'Ders modeli girilecek ders kaydı bulunamadı';
						if(empty($lesson->teacher)) $data['errors'][] = 'Ders modeli girilecek dersin eğitmenine ait kayıt bulunamadı';
					
						if(empty($data['errors']))
						{
							$status_id = 14; //Çalışma Modeli Girişi Yapıldı
							$teacher_id = $lesson->teacher->id;
							
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('status_id' => $status_id, 'model_id' => $model_id, 'price' => $price));
						}
					}				
				break;
				
				case 'setstatus':
					$lesson_id 	 	= $this->input->post('lesson');
					$status_id 		= $this->input->post('status');
					$description 	= $this->input->post('description');

					if(empty($lesson_id))												$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($status_id))												$data['errors'][] = 'Lütfen durum alanını boş bırakmayınız';
					if(!empty($status_id) && $status_id == 8 && empty($description))	$data['errors'][] = 'Lütfen açıklama alanına iptal nedenini giriniz';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson)) $data['errors'][] = 'Ders modeli girilecek ders kaydı bulunamadı';
					
						if(empty($data['errors']))
						{
							$status_id = $status_id;
							$teacher_id = $lesson->teacher->id ? $lesson->teacher->id : NULL;
							$status_start = $status_id == 5 || $lesson->status_start == 'Y' ? 'Y' : 'N';
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('status_id' => $status_id, 'status_start' => $status_start));
						}
					}				
				break;	
				
				case 'balance':
					$lesson_id 	 	= $this->input->post('lesson');
					$lesson_hour 	= $this->input->post('lesson_hour');
					$start_date 	= $this->input->post('start_date');
					$end_date 		= $this->input->post('end_date');
					$price 			= $this->input->post('price');
					$description 	= $this->input->post('description');

					if(empty($lesson_id)) 	$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($lesson_hour))	$data['errors'][] = 'Lütfen işlenen ders saati alanını boş bırakmayınız';
					if(empty($start_date))	$data['errors'][] = 'Lütfen başlangıç tarihi alanını boş bırakmayınız';
					if(empty($end_date))	$data['errors'][] = 'Lütfen sonlanma tarihi alanını boş bırakmayınız';
					if(empty($price))		$data['errors'][] = 'Lütfen tutar alanını boş bırakmayınız';

					if(empty($data['errors']))
					{
						$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id));
						
						if(empty($lesson)) $data['errors'][] = 'Alacak girilecek ders kaydı bulunamadı';
						if(empty($lesson->teacher)) $data['errors'][] = 'Alacak girilecek dersin eğitmenine ait kayıt bulunamadı';
					
						if(empty($data['errors']))
						{
							$status_id = 7;
							$teacher_id = $lesson->teacher->id;
							$balance = $lesson->balance + $price;
							$start_date = strtotime($this->input->post('start_date'));
							$end_date = strtotime($this->input->post('end_date'));
							$last_payment_date = $lesson->last_payment_date > $end_date ? $lesson->last_payment_date : $end_date;
							$this->requestsmodel->update_request_lesson(array('request_id' => $request_id, 'lesson_id' => $lesson_id), array('balance' => $balance ? $balance : NULL, 'last_payment_date' => $last_payment_date));
						}
					}				
				break;	
				
				case 'potential':
					$status_id = 16;
					$lesson_id 	 = $this->input->post('lesson');
					$description = $this->input->post('description');

					if(empty($lesson_id)) 	$data['errors'][] = 'Lütfen ders alanını boş bırakmayınız';
					if(empty($description)) $data['errors'][] = 'Lütfen açıklama alanını boş bırakmayınız';				
				break;																																	
			}
			
			if(empty($data['errors'])){
				$this->requestsmodel->insert_request_activity(array('request_id' => $request_id, 'lesson_id' => $lesson_id, 'status_id' => $status_id, 'teacher_id' => $teacher_id, 'price_type' => $price_type, 'lesson_hour' => $lesson_hour, 'hourly_price' => $hourly_price, 'model_id' => $model_id, 'price' => $price, 'appointment_date' => $appointment_date, 'start_date' => $start_date, 'end_date' => $end_date, 'description' => $description));			
				f_redir(base_url('backend/requests/edit/'.$request_id), array(lang('SUCCESS')));	
			}
		}

		$data['cities'] 	= $this->locationsmodel->get_locations('locations_cities');
		$data['models'] 	= $this->requestsmodel->get_requests_models();
		$data['lessons']	= $this->requestsmodel->get_request_lessons_with_activities(array('request_id' => $request_id));
		$data['item']		= $this->requestsmodel->get_request(array('id' => $request_id));
		$data['categories'] = $this->contentsmodel->getcategoriesrecursive(6);
		
		$data['viewPage'] = $this->load->view('requests/add', $data, true);
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function payments()
	{
		check_perm('requests_payments_overview');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{	
			$this->db->start_cache();

			$this->db->where('requests_activities.status_id', 7);
			
			if($this->input->get_post('sSearch_0')){
				if($this->input->get_post('sSearch_0') == 'Y' || $this->input->get_post('sSearch_0') == 'N'){
					$this->db->where('requests_activities.payed', $this->input->get_post('sSearch_0'));
					$this->db->where('requests_activities.status', 'A');
				}
				
				if($this->input->get_post('sSearch_0') == 'D'){
					$this->db->where('requests_activities.status', $this->input->get_post('sSearch_0'));
				}				
			}
				
			$this->db->from('requests_activities');
			$this->db->join('users', 'requests_activities.teacher_id=users.id');
			
			$this->db->stop_cache();
			
			$this->db->select('requests_activities.id');
	
			$total = $this->db->count_all_results();
			
			$this->db->select('users.firstname, users.lastname, users.mobile, users.id user_id, requests_activities.id, requests_activities.request_id, requests_activities.lesson_id, requests_activities.payed, requests_activities.lesson_hour, requests_activities.price, requests_activities.start_date, requests_activities.end_date, requests_activities.description, requests_activities.status');
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();
						
			$this->db->flush_cache();
						
			foreach($items as $item){
				$item->level = $this->requestsmodel->get_category(array('category_id' => $item->lesson_id));
				$item->subject = $this->requestsmodel->get_category(array('category_id' => $item->level->parent_id));				
				$item->start_date_nicetime = nicetime($item->start_date);
				$item->end_date_nicetime = nicetime($item->end_date);
			}
			
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('requests/payments', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function editpayment($id)
	{
		check_perm('requests_payments_edit');
		
		$data = array();
		
		$data['item'] = $this->db->from('requests_activities')->where('id', $id)->get()->row();
		
		if($this->input->post())
		{
			$price 			= $this->input->post('price');
			$lesson_hour 	= $this->input->post('lesson_hour');
			$start_date 	= $this->input->post('start_date');
			$end_date 		= $this->input->post('end_date');
			$description 	= $this->input->post('description');
			
			if(empty($lesson_hour))	$data['errors'][] = 'Lütfen işlenen ders saati alanını boş bırakmayınız';
			if(empty($start_date))	$data['errors'][] = 'Lütfen başlangıç tarihi alanını boş bırakmayınız';
			if(empty($end_date))	$data['errors'][] = 'Lütfen sonlanma tarihi alanını boş bırakmayınız';
			if(empty($price))		$data['errors'][] = 'Lütfen tutar alanını boş bırakmayınız';
			
			if(empty($data['errors']))
			{
				$update_activity_data = array();
				
				if($description != $data['item']->description)
				$update_activity_data['description'] = $description;
				
				if($lesson_hour != $data['item']->lesson_hour)
				$update_activity_data['lesson_hour'] = $lesson_hour;

				if($start_date != $data['item']->start_date)
				$update_activity_data['start_date'] = strtotime($start_date);				
								
				if($end_date != $data['item']->end_date)
				$update_activity_data['end_date'] = strtotime($end_date);
				
				$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $data['item']->request_id, 'lesson_id' => $data['item']->lesson_id, 'teacher_id' => $data['item']->teacher_id));
				
				if($price != $data['item']->price)
				{
					$balance 			= $lesson->balance;
					$payed 				= $lesson->payed;
					
					$update_activity_data['price'] = $price ? $price : NULL;
					
					if($data['item']->payed == 'Y')
					{
						if($price > $data['item']->price)
						{
							$payed = $payed + ($price - $data['item']->price);
							$balance = $balance - ($price - $data['item']->price);							
						} else {
							$payed = $payed - ($data['item']->price - $price);
							$balance = $balance + ($data['item']->price - $price);														
						}
					} else {
						if($price > $data['item']->price)
						{
							$balance = $balance + ($price - $data['item']->price);							
						} else {
							$balance = $balance - ($data['item']->price - $price);														
						}												
					}
					
					$this->requestsmodel->update_request_lesson(array('id' => $lesson->id), array('balance' => $balance ? $balance : NULL, 'payed' => $payed ? $payed : NULL));
				}
				
				$this->requestsmodel->update_request_activity(array('id' => $id), $update_activity_data);
				
				$this->requestsmodel->update_request_lesson(array('id' => $lesson->id), array('last_payment_date' => $this->requestsmodel->get_last_payment_date($lesson->request_id, $lesson->lesson_id)));
				
				f_redir(base_url('backend/requests/editpayment/'.$id), array(lang('SUCCESS')));	
			}			
		}
		
		$data['item'] = $this->db->from('requests_activities')->where('id', $id)->get()->row();
		$data['item']->level = $this->requestsmodel->get_category(array('category_id' => $data['item']->lesson_id));
		$data['item']->subject = $this->requestsmodel->get_category(array('category_id' => $data['item']->level->parent_id));				
		$data['item']->teacher = $this->db->from('users')->where('id', $data['item']->teacher_id)->get()->row();				
		
		$data['viewPage'] = $this->load->view('requests/editpayment', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}		

	public function deletepayment($id)
	{
		check_perm('requests_payments_delete');
		
		if(!empty($id))
		{
			$data = array();
				
			$data['item'] = $this->db->from('requests_activities')->where('id', $id)->get()->row();
			
			if(empty($data['item'])) $data['errors'][] = 'Silinecek finansal hareket bulunamadı';
			if(!empty($data['item']) && $data['item']->status_id != 7) $data['errors'][] = 'Silinecek kayıt finansal hareket değildir';

			if(empty($data['errors']))
			{
				$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $data['item']->request_id, 'lesson_id' => $data['item']->lesson_id, 'teacher_id' => $data['item']->teacher_id));
				$balance = $lesson->balance;
				$payed = $lesson->payed;
				
				$balance = $data['item']->price > $balance ? $data['item']->price - $balance  : $balance - $data['item']->price;					
				
				if($data['item']->payed == 'Y')
				$payed = $data['item']->price > $payed ? $data['item']->price - $payed : $payed - $data['item']->price;
														
				$this->requestsmodel->update_request_lesson(array('id' => $lesson->id), array('balance' => $balance ? $balance : NULL, 'payed' => $payed ? $payed : NULL));
				
				$this->requestsmodel->update_request_activity(array('id' => $id), array('status' => 'D'));
				
				f_redir(base_url('backend/requests/payments'), array(lang('SUCCESS')));	
			} else {
				f_redir(base_url('backend/requests/payments'), $data['errors']);	
			}			
		}		
	}	
		
	public function undeletepayment($id)
	{
		check_perm('requests_payments_undelete');
		
		if(!empty($id))
		{
			$data = array();
				
			$data['item'] = $this->db->from('requests_activities')->where('id', $id)->get()->row();
			
			if(empty($data['item'])) $data['errors'][] = 'Silinecek finansal hareket bulunamadı';
			if(!empty($data['item']) && $data['item']->status_id != 7) $data['errors'][] = 'Silinecek kayıt finansal hareket değildir';

			if(empty($data['errors']))
			{
				$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $data['item']->request_id, 'lesson_id' => $data['item']->lesson_id, 'teacher_id' => $data['item']->teacher_id));
				$balance = $lesson->balance;
				$payed = $lesson->payed;
				
				$balance = $data['item']->price > $balance ? $data['item']->price + $balance  : $balance + $data['item']->price;					
				
				if($data['item']->payed == 'Y')
				$payed = $data['item']->price > $payed ? $data['item']->price + $payed : $payed + $data['item']->price;
														
				$this->requestsmodel->update_request_lesson(array('id' => $lesson->id), array('balance' => $balance ? $balance : NULL, 'payed' => $payed ? $payed : NULL));
				
				$this->requestsmodel->update_request_activity(array('id' => $id), array('status' => 'A'));
				
				f_redir(base_url('backend/requests/payments'), array(lang('SUCCESS')));	
			} else {
				f_redir(base_url('backend/requests/payments'), $data['errors']);	
			}			
		}		
	}		

	public function paypayment($id)
	{
		check_perm('requests_payments_pay');
		
		if(!empty($id))
		{
			$data = array();
				
			$data['item'] = $this->db->from('requests_activities')->where('id', $id)->get()->row();
			
			if(empty($data['item'])) $data['errors'][] = 'Tahsilat yapılacak finansal hareket bulunamadı';
			if(!empty($data['item']) && $data['item']->status_id != 7) $data['errors'][] = 'Tahsilat yapılacak kayıt finansal hareket değildir';
			if(!empty($data['item']) && $data['item']->status_id == 7 && empty($data['item']->price)) $data['errors'][] = 'Tahsilat yapılacak kayıt için tutar alanı boştur';
			if(!empty($data['item']) && $data['item']->status_id == 7 && !empty($data['item']->price) && $data['item']->payed == 'Y') $data['errors'][] = 'İlgili kayıt için daha önceden tahsilat işlemi gerçekleştirilmiştir';

			if(empty($data['errors']))
			{
				$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $data['item']->request_id, 'lesson_id' => $data['item']->lesson_id, 'teacher_id' => $data['item']->teacher_id));
				$balance = $lesson->balance;
				$payed = $lesson->payed;
				
				$balance = $data['item']->price > $balance ? $data['item']->price - $balance : $balance - $data['item']->price;					
				
				$payed = $data['item']->price > $payed ? $data['item']->price + $payed : $payed + $data['item']->price;
														
				$this->requestsmodel->update_request_lesson(array('id' => $lesson->id), array('balance' => $balance ? $balance : NULL, 'payed' => $payed ? $payed : NULL));
				
				$this->requestsmodel->update_request_activity(array('id' => $id), array('payed' => 'Y'));
				
				f_redir(base_url('backend/requests/payments'), array(lang('SUCCESS')));	
			} else {
				f_redir(base_url('backend/requests/payments'), $data['errors']);	
			}			
		}			
	}
	
	public function unpaypayment($id)
	{
		check_perm('requests_payments_unpay');
		
		if(!empty($id))
		{
			$data = array();
				
			$data['item'] = $this->db->from('requests_activities')->where('id', $id)->get()->row();
			
			if(empty($data['item'])) $data['errors'][] = 'Tahsilat yapılacak finansal hareket bulunamadı';
			if(!empty($data['item']) && $data['item']->status_id != 7) $data['errors'][] = 'Tahsilat yapılacak kayıt finansal hareket değildir';
			if(!empty($data['item']) && $data['item']->status_id == 7 && empty($data['item']->price)) $data['errors'][] = 'Tahsilat yapılacak kayıt için tutar alanı boştur';
			if(!empty($data['item']) && $data['item']->status_id == 7 && !empty($data['item']->price) && $data['item']->payed == 'N') $data['errors'][] = 'İlgili kayıt için daha önceden tahsilat işlemi gerçekleştirilmemiştir';

			if(empty($data['errors']))
			{
				$lesson = $this->requestsmodel->get_request_lesson(array('request_id' => $data['item']->request_id, 'lesson_id' => $data['item']->lesson_id, 'teacher_id' => $data['item']->teacher_id));
				$balance = $lesson->balance;
				$payed = $lesson->payed;
				
				$balance = $data['item']->price > $balance ? $data['item']->price + $balance : $balance + $data['item']->price;
				
				$payed = $data['item']->price > $payed ? $data['item']->price - $payed : $payed - $data['item']->price;
														
				$this->requestsmodel->update_request_lesson(array('id' => $lesson->id), array('balance' => $balance ? $balance : NULL, 'payed' => $payed ? $payed : NULL));
				
				$this->requestsmodel->update_request_activity(array('id' => $id), array('payed' => 'N'));
				
				f_redir(base_url('backend/requests/payments'), array(lang('SUCCESS')));	
			} else {
				f_redir(base_url('backend/requests/payments'), $data['errors']);	
			}			
		}		
	}	
			
	public function get_average_prices()
	{
		$response = array();
		
		$level_id = (int)$this->input->get('level_id');
		$city = (int)$this->input->get('city_id');
		$town = (int)$this->input->get('town_id');		
		
		if(empty($level_id)) return false;
		
		$this->db->where('prices.level_id', $level_id);
		$this->db->where('users.status', 'A');
		
		$this->db->from('users');
		$this->db->join('prices', 'prices.uid=users.id', 'left');		
		
		
		$this->db->select('
			users.*,
			MIN(LEAST(
				IF('.$this->db->dbprefix('prices').'.price_private = 0 OR '.$this->db->dbprefix('prices').'.price_private IS NULL, '.$this->db->dbprefix('prices').'.price_live, '.$this->db->dbprefix('prices').'.price_private),
				IF('.$this->db->dbprefix('prices').'.price_live = 0 OR '.$this->db->dbprefix('prices').'.price_live IS NULL, '.$this->db->dbprefix('prices').'.price_private, '.$this->db->dbprefix('prices').'.price_live)
			)) as price_min,
			MAX(GREATEST(COALESCE('.$this->db->dbprefix('prices').'.price_private, '.$this->db->dbprefix('prices').'.price_live),  COALESCE('.$this->db->dbprefix('prices').'.price_live, '.$this->db->dbprefix('prices').'.price_private))) as price_max
			');
					
		$user = $this->db->get()->row();		
		
		if($user->price_min == $user->price_max){
			$response['price'] = $user->price_min;
		} else {
			$response['price'] = $user->price_min . ' - ' . $user->price_max;
		}

		if(!empty($city) && !empty($town))
		{
			$this->db->where("(".$this->db->dbprefix('prices').".level_id = '".$level_id."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && FIND_IN_SET($level_id, ".$this->db->dbprefix('users').".virtual_levels)))");
			$this->db->where("(".$this->db->dbprefix('locations').".city = '".$city."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".city = '".$city."'))");
			$this->db->where("(".$this->db->dbprefix('locations').".town = '".$town."' OR (".$this->db->dbprefix('users').".virtual = 'Y' && ".$this->db->dbprefix('users').".town = '".$town."'))");
			$this->db->where('users.status', 'A');
			
			$this->db->from('users');
			$this->db->join('prices', 'prices.uid=users.id', 'left');		
			$this->db->join('locations', 'locations.uid=users.id', 'left');		
			
			$response['total'] = $this->db->count_all_results();			
		}
		
		echo json_encode($response);
		exit;
	}		
}
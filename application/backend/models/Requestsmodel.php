<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requestsmodel extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }
	
	public function insert_request($data = array())
	{
		if(!empty($data))
		{
			$insert_data = array();
			
			foreach($data as $key => $value)
			{
				if(is_array($value))
				$value = implode(',', $value);
				
				$insert_data[$key] = $value;
			}
			
			$insert_data['uid'] = $this->session->userdata('user_id');
			$insert_data['create_date'] = time();
			
			$this->db->insert('requests', $insert_data);		
			return $this->db->insert_id();
		}	
	}
	
	public function update_request($where = array(), $data = array())
	{
		if(!empty($data))
		{
			$update_data = array();
			
			foreach($data as $key => $value)
			{

				if(is_array($value))
				$value = implode(',', $value);
							
				$update_data[$key] = $value;
			}			
			
			$this->db->where($where)->update('requests', $update_data);		
		}
	}	
	
	public function insert_request_lesson($request_id = 0, $data = array())
	{
		$response_data = array();
		
		$create_date = time();
		
		if(!empty($data))
		{
			foreach($data['category'] as $key => $value)
			{
				if(!empty($value))
				{
					$insert_data = array(
						'uid' 			=> $this->session->userdata('user_id'),
						'request_id' 	=> $request_id,
						'lesson_id' 	=> $data['category'][$key],
						'price_average' => $data['price_average'][$key],
						'teacher_count' => $data['teacher_count'][$key],
						'budget' 		=> $data['budget'][$key],
						'create_date' 	=> $create_date,
						'status_id' 	=> 1						
					);
					$this->db->insert('requests_lessons', $insert_data);
					$response_data[] = $this->db->insert_id();
					
					$this->insert_request_activity(array('request_id' => $request_id, 'lesson_id' => $data['category'][$key], 'status_id' => 1, 'create_date' => $create_date));
				}
			}
		}
		
		return $response_data;
	}
	
	public function update_request_lesson($where = array(), $data = array())
	{
		if(!empty($data))
		{
			$update_data = array();
			
			foreach($data as $key => $value){
				$update_data[$key] = $value;
			}			
			$this->db->where($where)->update('requests_lessons', $update_data);		
		}
	}	

	public function insert_request_activity($data = array())
	{
		if(!empty($data))
		{
			$insert_data = array();
			
			foreach($data as $key => $value){
				$insert_data[$key] = $value;
			}
			
			$insert_data['uid'] = $this->session->userdata('user_id');
			$insert_data['create_date'] = time();
			
			$this->db->insert('requests_activities', $insert_data);		
			return $this->db->insert_id();
		}
	}
	
	public function update_request_activity($where = array(), $data = array())
	{
		if(!empty($data))
		{
			$update_data = array();
			
			foreach($data as $key => $value){
				$update_data[$key] = $value;
			}			
			$this->db->where($where)->update('requests_activities', $update_data);		
		}
	}
	
	public function insert_request_lessons_teacher($data = array())
	{
		if(!empty($data))
		{
			$insert_data = array();
			
			foreach($data as $key => $value){
				$insert_data[$key] = $value;
			}
			
			$insert_data['uid'] = $this->session->userdata('user_id');
			$insert_data['create_date'] = time();
			
			$this->db->insert('requests_lessons_teachers', $insert_data);		
			return $this->db->insert_id();
		}
	}
	
	public function update_request_lessons_teacher($where = array(), $data = array())
	{
		if(!empty($data))
		{
			$update_data = array();
			
			foreach($data as $key => $value){
				$update_data[$key] = $value;
			}			
			$this->db->where($where)->update('requests_lessons_teachers', $update_data);		
		}
	}		
	
	public function get_requests_models()
	{
		return $this->db->from('requests_models')->get()->result();
	}
	
	public function get_requests_model($where = array())
	{
		return $this->db->from('requests_models')->where($where)->get()->row();
	}	
	
	public function get_requests_status($where = array())
	{
		return $this->db->from('requests_statuses')->where($where)->get()->row();
	}
	
	public function get_requests_statuses()
	{
		return $this->db->from('requests_statuses')->order_by('id')->get()->result();
	}			
	
	public function get_request($where = array())
	{
		return $this->db->from('requests')->where($where)->get()->row();
	}

	public function get_request_lesson($where = array()){

		$lesson = $this->db->from('requests_lessons')->where($where)->get()->row();
		
		if(!empty($lesson))
		{
			$lesson->level = $this->get_category(array('category_id' => $lesson->lesson_id));
			$lesson->subject = $this->get_category(array('category_id' => $lesson->level->parent_id));
			$lesson->status = $this->get_requests_status(array('id' => $lesson->status_id));
			$lesson->request = $this->get_request(array('id' => $lesson->request_id));
			$lesson->teacher = !empty($lesson->teacher_id) ? $this->db->from('users')->where('id', $lesson->teacher_id)->get()->row() : NULL;
		}
		
		return $lesson;
	}

	
	public function get_request_lessons($where = array())
	{
		$lessons = $this->db->from('requests_lessons')->where($where)->get()->result();
		
		if(!empty($lessons))
		{
			foreach($lessons as $lesson)
			{				
				$lesson->level = $this->get_category(array('category_id' => $lesson->lesson_id));
				$lesson->subject = $this->get_category(array('category_id' => $lesson->level->parent_id));
				$lesson->status = $this->get_requests_status(array('id' => $lesson->status_id));
				$lesson->request = $this->get_request(array('request_id' => $lesson->request_id));
				$lesson->teacher = !empty($lesson->teacher_id) ? $this->db->from('users')->where('id', $lesson->teacher_id)->get()->row() : NULL;
				$lesson->model = !empty($lesson->model_id) ? $this->get_requests_model(array('id' =>$lesson->model_id)) : NULL;
				$lesson->status_info = $this->get_lesson_status_info($lesson);
			}
		}
		
		return $lessons;
	}	
		
	public function get_request_lessons_with_activities($where = array())
	{
		$lessons = $this->db->from('requests_lessons')->where($where)->get()->result();
		
		if(!empty($lessons))
		{
			foreach($lessons as $lesson)
			{
				$lesson->level = $this->get_category(array('category_id' => $lesson->lesson_id));
				$lesson->subject = $this->get_category(array('category_id' => $lesson->level->parent_id));
				$lesson->status = $this->get_requests_status(array('id' => $lesson->status_id));
				$lesson->teacher = !empty($lesson->teacher_id) ? $this->db->from('users')->where('id', $lesson->teacher_id)->get()->row() : NULL;
				$lesson->model = !empty($lesson->model_id) ? $this->get_requests_model(array('id' =>$lesson->model_id)) : NULL;
				$lesson->activities = $this->get_request_activities(array('request_id' => $lesson->request_id, 'lesson_id' => $lesson->lesson_id, 'status' => 'A'));
				$lesson->activities_old = $this->get_request_activities(array('request_id' => $lesson->request_id, 'lesson_id' => $lesson->lesson_id, 'status' => 'O'));
				$lesson->status_info = $this->get_lesson_status_info($lesson);
			}
		}
		return $lessons;
	}	
	
	public function get_lesson_status_info($lesson = array())
	{
		if(empty($lesson)) return false;
		
		$status_info = array();
		
		if(($lesson->status_id != 8 && $lesson->status_id != 15) && !$lesson->teacher_id && $lesson->create_date > strtotime('-30 minute', time())){
			$status_info['key'] = 'assignment';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Derse eğitmen atanması gerekiyor';
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && !$lesson->teacher_id && $lesson->create_date < strtotime('-30 minute', time())){
			$status_info['key'] = 'urgent_assignment';
			$status_info['class'] = 'danger';
			$status_info['value'] = 'Derse acil eğitmen atanması gerekiyor';			
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && $lesson->teacher_id && !$lesson->model_id){
			$status_info['key'] = 'model';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Eğitmen çalışma modeli girilmesi gerekiyor';
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && $lesson->teacher_id && $lesson->model_id && $lesson->status_sms != 'Y'){
			$status_info['key'] = 'sms';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Eğitmene SMS atılması gerekiyor';
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && $lesson->teacher_id && $lesson->model_id && $lesson->status_sms == 'Y' && !$lesson->appointment_date){
			$status_info['key'] = 'appointment';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Ders için randevu tarihinin girilmesi gerekiyor';
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && $lesson->teacher_id && $lesson->model_id && $lesson->status_sms == 'Y' && $lesson->appointment_date && $lesson->appointment_date < time() && !$lesson->lesson_hour){
			$status_info['key'] = 'appointment_passed';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Ders randevu tarihi geçti! Eğitmen ve öğrenci ile görüşüp ders verilecekse anlaşılan ders süresinin sisteme girişi, anlaşılmadıysa başka bir eğitmenin atanması gerekiyor';
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && $lesson->teacher_id && $lesson->model_id && $lesson->status_sms == 'Y' && $lesson->appointment_date && $lesson->lesson_hour && $lesson->status_start != 'Y'){
			$status_info['key'] = 'status';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Ders başladı ise durum değişikliğinden ders başladı girişi gerekiyor';
		}elseif(($lesson->status_id != 8 && $lesson->status_id != 15) && $lesson->teacher_id && $lesson->model_id && $lesson->status_sms == 'Y' && $lesson->appointment_date && $lesson->lesson_hour && $lesson->status_start == 'Y' && (!$lesson->last_payment_date || ($lesson->last_payment_date && $lesson->last_payment_date < strtotime('-1 week', time())))){
			$status_info['key'] = 'financial';
			$status_info['class'] = 'warning';
			$status_info['value'] = 'Alacak girişi tarihi girilmedi veya son alacak girişi tarihi geçti. Ders devam ediyorsa alacak girişi yapılması gerekiyor';
		}
		
		return $status_info;
	}

	public function get_request_activities($where = array())
	{
		$activities = $this->db->from('requests_activities')->where($where)->order_by('id desc')->get()->result();
		if(!empty($activities)){
			foreach($activities as $activity)
			{
				$activity->model = !empty($activity->model_id) ? $this->get_requests_model(array('id' =>$activity->model_id)) : NULL;
				$activity->status = $this->get_requests_status(array('id' => $activity->status_id));
				
				if($activity->teacher_id && $where['status'])
				$activity->teacher = $this->db->from('users')->where('id', $activity->teacher_id)->get()->row();				
			}
		}
		
		return $activities;
	}
	
	public function get_category($where = array())
	{
		return $this->db->from('contents_categories')->where($where)->get()->row();
	}
	
	public function get_last_payment_date($request_id, $lesson_id)
	{
		$query = $this->db
		->select('MAX(end_date) as last_end_date')
		->from('requests_activities')
		->where('status_id', 7)
		->where('request_id', $request_id)
		->where('lesson_id', $lesson_id)
		->get()->row();

		return $query->last_end_date;
	}	
}
?>
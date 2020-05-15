<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends CI_Controller {
	
	var $template = 'pages/wrapper';

   public function __construct(){
        parent::__construct();
		$this->load->model('users_model');
		$this->config->set_item('language', $this->session->userdata('site_sl'));
    }

	public function index($user_id = 0)
	{	
		/*
		$professions = $this->db->from('professions')->limit(100)->get()->result();
		foreach($professions as $profession)
		{
			$username = rand(9476, 9477);	
			$username2 = $username == 9476 ? 9477 : 9476;
			$this->db->insert('messages', [
				'from_uid' => $username,
				'to_uid' => $username2,
				'message' => $profession->title,
				'date' => time(),
				'ip' => $this->input->ip_address()
			]);
			
		}
		
		$messages = $this->db->from('messages')->get()->result();
		$strtotime = strtotime('2018-08-01 09:00:00');
		foreach($messages as $message)
		{			
			$this->db->where('id', $message->id)->update('messages', ['date' => $strtotime]);
			$strtotime = strtotime('+2 minute', $strtotime);
		}
		*/		
		
		is_notloggedin_redir(site_url('giris'));
		
		//En son mesajlasmayi getir
		if(empty($user_id))
		{
			$last_messaging = $this->db->select('from_uid, to_uid')->from('messages')->where('from_uid', $this->session->userdata('user_id'))->or_where('to_uid', $this->session->userdata('user_id'))->order_by('id', 'DESC')->get()->row();
			if(empty($last_messaging)) redir(site_url('users/my'), ['Mesajınız bulunmamaktadır.'], '', '', true);
			
			$user_id = $last_messaging->from_uid == $this->session->userdata('user_id') ? $last_messaging->to_uid : $last_messaging->from_uid;
			redir(site_url('messages/'.$user_id));			
		}
		
		//Mesajlasilan kisileri getir
		$message_users = $this->db->query("
		SELECT m1.* 
		FROM core_messages m1 
		INNER JOIN (SELECT MAX(date) AS date, 
		                 IF(to_uid = ".$this->session->userdata('user_id').", from_uid, to_uid ) AS user 
		            FROM core_messages 
		           WHERE (from_uid = ".$this->session->userdata('user_id').") OR 
		                 (to_uid = ".$this->session->userdata('user_id').") 
		          GROUP BY user) m2 
		     ON m1.date = m2.date AND 
		       (m1.from_uid = m2.user OR m1.to_uid = m2.user) 
		 WHERE (from_uid = ".$this->session->userdata('user_id').") OR 
		       (to_uid = ".$this->session->userdata('user_id').") 
		GROUP BY if(from_uid = ".$this->session->userdata('user_id').", to_uid, from_uid)
		ORDER BY m1.date DESC
		")->result();
		
		if(!empty($message_users))
		{
			foreach($message_users as $message_user)
			{
				$counterpart_id = $message_user->from_uid == $this->session->userdata('user_id') ? $message_user->to_uid : $message_user->from_uid;
				$message_user->counterpart = $this->db->from('users')->where('id', $counterpart_id)->get()->row();
				$message_user->total = $this->db->from('messages')->where('from_uid', $message_user->from_uid)->where('to_uid', $this->session->userdata('user_id'))->where('readed', 'N')->count_all_results();
				
				if($message_user->counterpart->id == $user_id)
				$counterpart = $message_user->counterpart;
			}
		}
		
		$data['message_users'] = $message_users;
		$data['message_counterpart'] = $counterpart;
		$data['chat_messages'] = $this->_load($counterpart->id);
		

		$data['viewPage'] = $this->load->view('messages/index', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}
	
	public function _load($counterpart_id = 0, $offset = 0)
	{
		is_notloggedin_redir(site_url('giris'));
		
		if(empty($counterpart_id)) return false;
		
		$user_id = $this->session->userdata('user_id');
		
		$this->db->where('id', $this->session->userdata('user_id'))->update('users', array('mailmessage' => NULL));
		
		$total = $this->db->from('messages')
			->where("
				(from_uid = '".$counterpart_id."' AND to_uid = '".$this->session->userdata('user_id')."') OR 
				(from_uid = '".$this->session->userdata('user_id')."' AND to_uid = '".$counterpart_id."')
			", '', FALSE)
			->count_all_results();	
			
		$messages = $this->db->from('messages')
			->where("
				(from_uid = '".$counterpart_id."' AND to_uid = '".$this->session->userdata('user_id')."') OR 
				(to_uid = '".$counterpart_id."' AND from_uid = '".$this->session->userdata('user_id')."')
			", '', FALSE)
			->order_by('date', 'DESC')
			->limit(20, $offset)			
			->get()->result();
			
		
		$message_ids = [];
		foreach($messages as $message)
		{
			$message->time = date('d.m.Y H:i:s', $message->date);
			$message_ids[] = $message->id;
		}
		if(!empty($message_ids))
		$this->db->where_in('id', $message_ids)->update('messages', ['readed' => 'Y']);
		
		return $messages;
	}
	
	public function add()
	{
		$response = ['success' => false, 'message' => null, 'time' => null];
		
		$counterpartId = (int)$this->input->post('counterpartId');
		$message = $this->input->post('message');
		
		if(empty($counterpartId) || empty($message))
			$response['message'] = 'Eksik parametre!';
		else
		{
			$this->db->insert('messages', [
				'from_uid' => $this->session->userdata('user_id'),
				'to_uid' => $counterpartId,
				'message' => $message,
				'date' => time(),
				'ip' => $this->input->ip_address()
			]);
			
			$response['success'] = true;
			$response['message'] = 'OK';
			$response['time'] = date('d.m.Y H:i:s', time());
		}
		
		echo json_encode($response);
		exit;
	}
	
	public function loadmore($counterpart_id = 0, $offset = 0)
	{	
		echo json_encode($this->_load($counterpart_id, $offset));
		exit;
	}	
}



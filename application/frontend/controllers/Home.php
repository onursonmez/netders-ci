<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $template 		= 'pages/wrapper';
	var $folder_prefix 	= '';

	public function __construct ()
	{
        parent::__construct();
		
		if($this->input->get('amp') == 1){
			$this->template = $this->input->get('amp') ? 'pages/amp' : $template;
			$this->folder_prefix = 'amp/';
		}
	}
		
	public function index()
	{
		$data = array();
		/*
		echo "aa";
		$this->load->library('Mailchimp');
		$lists = $this->mailchimp->call('lists/list');
		print_r($lists);
		*/
				
		//if($_GET['debug'] == 1)
		//$this->output->enable_profiler(TRUE);
		
		$this->load->model('users_model');
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
		
		$data['viewPage'] = $this->load->view($this->folder_prefix . 'home', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
		
		//$this->output->delete_cache();
		//$this->output->cache(60);
		
	}	
}
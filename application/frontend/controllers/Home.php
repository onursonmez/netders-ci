<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	var $template 		= 'pages/wrapper';
	var $folder_prefix 	= '';

	public function __construct ()
	{
        parent::__construct();
				$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		if($this->input->get('amp') == 1){
			$this->template = $this->input->get('amp') ? 'pages/amp' : $template;
			$this->folder_prefix = 'amp/';
		}

		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$data = array();



		if ( ! $data = $this->cache->get('latest_users'))
		{
			$this->load->model('users_model');
			$latest_users = $this->users_model->get_users_by_search(array('virtual' => 'N', 'limit' => 10, 'sort_date' => 'desc', 'photo' => 1));

			foreach($latest_users['users'] as $user)
			{
					$user->levels = $this->users_model->get_user_level_names($user->id);
			}
			$data['latest_users'] = $latest_users['users'];


			// Save into the cache for 5 minutes
			$this->cache->save('latest_users', $data, 60*60);
		}

		$data['viewPage'] = $this->load->view('home', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);

		//$this->output->delete_cache();
		//$this->output->cache(60);

	}
}

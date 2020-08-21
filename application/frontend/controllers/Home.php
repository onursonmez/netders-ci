<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	var $template 		= 'pages/wrapper';
	var $folder_prefix 	= '';

	public function __construct ()
	{
    parent::__construct();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		//$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		$data = array();

		if ( ! $data = $this->cache->get('home'))
		{
			$this->load->model('users_model');
			$this->load->model('locations_model');
			$latest_users = $this->users_model->get_users_by_search(array('virtual' => 'N', 'limit' => 10, 'sort_date' => 'desc', 'photo' => 1));

			foreach($latest_users['users'] as $user)
			{
					$user->levels = $this->users_model->get_user_level_names($user->id);
			}
			$data['latest_users'] = $latest_users['users'];
			$data['subjects'] = $this->users_model->get_subjects();
			$data['cities'] = $this->locations_model->get_locations('locations_cities', ['status' => 'A']);

			// Save into the cache for 10 minutes
			$this->cache->save('home', $data, 60*60);
		}

		$data['viewPage'] = $this->load->view('home', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);

		//$this->output->delete_cache();
		//$this->output->cache(60);

	}
}

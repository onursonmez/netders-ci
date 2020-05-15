<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	

   public function __construct()
   {
        parent::__construct();
		$this->config->set_item('language', $this->session->userdata('site_sl'));
    }
	
	function amp_authorization()
	{
		echo json_encode(array('loggedIn' => $this->session->userdata('user_id') ? true : false));	
	}
}




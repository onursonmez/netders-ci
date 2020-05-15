<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms_model extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }

	public function insert_form()
	{
		$data = array(
			'firstname' 		=> $this->input->post('firstname', true),
			'lastname' 			=> $this->input->post('lastname', true),
			'email' 			=> $this->input->post('email', true),
			'phone' 			=> $this->input->post('phone', true),
			'message' 			=> $this->input->post('message', true),
			'page' 				=> $_SERVER['HTTP_REFERER'],
			'uagent' 			=> $this->agent->agent_string(),
		    'date' 				=> time(),
			'ip' 				=> $this->input->ip_address()
		);
		$this->db->insert('forms', $data);
		
		return $this->db->insert_id();
	}
}
?>
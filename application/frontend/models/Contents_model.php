<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contents_model extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }

	public function insert_newsletter_subscription()
	{
		$data = array(
			'email' 			=> $this->input->post('email', true),
		    'date' 				=> time(),
			'ip' 				=> $this->input->ip_address()
		);
		$this->db->insert('emails', $data);
	}
}
?>
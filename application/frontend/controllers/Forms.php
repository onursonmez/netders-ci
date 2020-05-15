<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {
   public function __construct()
   {
        parent::__construct();
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		$this->config->set_item('language', $this->session->userdata('site_sl'));
		$this->load->model('forms_model');
    }

	public function index()
	{
		switch($this->input->post('form'))
		{
			case 'ajax_contact':

				$this->form_validation->set_rules('firstname', 'Adınız', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Soyadınız', 'trim|required');
				$this->form_validation->set_rules('email', 'E-posta Adresiniz', 'trim|required|valid_email|is_unique[users.email]');
				$this->form_validation->set_rules('message', 'Mesajınız', 'trim|required');
				$this->form_validation->set_rules('security_code', 'Güvenlik kodu', array('trim', 'required', 'numeric', array('captcha_check_message', 'captcha_check')));
							
				if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
				{
					if ($this->form_validation->run() == FALSE){
						echo json_encode(array('RES' => 'ERR', 'MSG' => $this->form_validation->error_array(), 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
					} else {
						$form_id = $this->forms_model->insert_form();
						m('contact_form', 1, $this->input->post());
						echo json_encode(array('RES' => 'OK', 'MSG' => array(sprintf(lang('FORM_SENT'), $form_id)), 'REDIR' => $this->input->post('redir', true), 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
					}
					exit;
				} else {
					if ($this->form_validation->run() == FALSE){
						redir($this->input->post('redir', true), $this->form_validation->error_array(), '', '', TRUE);
					} else {				
						m('contact_form', 1, $this->input->post());
						redir($this->input->post('redir', true), array(sprintf(lang('FORM_SENT'), $form_id)));
					}
				}
			
			break;
		}
	}	
}

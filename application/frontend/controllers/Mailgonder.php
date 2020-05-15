<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailgonder extends CI_Controller {

	var $template = 'pages/rss';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		error_reporting(E_ERROR);
		ini_set('display_errors', 1);
		
		$this->load->library('email');

		$config['smtp_crypto']='';
		$config['protocol'] = 'sendmail';
		$config['charset'] = 'utf-8';
		$config['smtp_host'] = 'ssl://smtp.yandex.com';
		$config['smtp_user'] = 'destek@netders.com';
		$config['smtp_pass'] = 'jam75Pe*1!';
		$config['smtp_port'] = 587;
		$config['wordwrap'] = FALSE;
		$config['mailtype'] = 'html';
		$config['newline'] = "\r\n";

    	$this->email->initialize($config);
    	$this->email->subject('Netders.com');
    	$this->email->message('netders.com deneme mailidir. hmm kodun çalıştığını gösterir');
    	$this->email->from('destek@netders.com','netders.com');
    	$this->email->to('tavhane@gmail.com');
    	
		$send = $this->email->send();
		echo $this->email->print_debugger();
		exit;
	}
	
}
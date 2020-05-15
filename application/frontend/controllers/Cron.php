<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	

   public function __construct()
   {
        parent::__construct();

    }
    
    public function gundebir()
    {
		$urls = $this->router->routes;

		$this->load->library('xml_sitemap');
		$this->xml_sitemap->add($urls);
		$this->xml_sitemap->generate();	    
    }

	public function ondakikadabir()
	{
		$this->db->where('status', 'W')->update('prices', ['status' => 'A']);
		
		$onaybekleyenler = $this->db->from('users')->where('ugroup IN(3,4,5)')->where('status', 'S')->order_by('joined', 'asc')->limit(10)->get()->result();
		if(!empty($onaybekleyenler))
		{
			$this->load->library('email');
			$this->load->helper('email');
						
			foreach($onaybekleyenler as $onaybekleyen)
			{
				$subject = lang('MAIL_ADMIN_REVIEW_SUBJECT');
				$email = $onaybekleyen->email;
				$template = lang('MAIL_TEMPLATE');
												
				$body = str_replace('Editörün Mesajı:', '', lang('MAIL_ADMIN_REVIEW_BODY_APPROVE'));

				$approval_info = !empty($onaybekleyen->email_request) ? nl2br(lang('MAIL_ADMIN_APPROVAL_INFO')) : '';
				$approval_info = !empty($approval_info) ? str_replace('__APPROVAL_LINK__', site_url('aktivasyon/?code='.$onaybekleyen->activation_code.'&email='.$onaybekleyen->email), $approval_info) : '';
				
				$review_comment = '';
				
				$body = str_replace('__FIRSTNAME__', $onaybekleyen->firstname, $body);
				$body = str_replace('__LASTNAME__', $onaybekleyen->lastname, $body);
				$body = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $body);
				$body = str_replace('__APPROVAL_INFO__', $approval_info, $body);
				$body = str_replace('__REVIEW_COMMENT__', $review_comment, $body);
				
				$body = str_replace('__BODY__', nl2br($body), $template);
				
				$this->email->from($GLOBALS['settings_global']->admin_email, $GLOBALS['settings_global']->site_name);
				$this->email->to($email);
				
				$this->email->subject(lang('MAIL_ADMIN_REVIEW_SUBJECT').' - '.$GLOBALS['settings_global']->site_name);
				$this->email->message($body);
				
				if(!$this->email->send())
				{
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= 'From: '.$GLOBALS['settings_global']->site_name.' <'.$GLOBALS['settings_global']->admin_email.'>' . "\r\n";
					send_email($email, lang('MAIL_ADMIN_REVIEW_SUBJECT').' - '.$GLOBALS['settings_global']->site_name, $body);
				}
				
				$this->db->where('id', $onaybekleyen->id)->update('users', ['status' => 'A']);	
				
				echo $onaybekleyen->id.PHP_EOL;
			}
		}
	}	
}




<?php

settings();
init_language();
update_lastactive();

function settings($params = array())
{		
	$ci =& get_instance();
	$ci->load->database();
	
	$GLOBALS['settings_site'] = $ci->db->from('settings_site')->get()->row();
	$GLOBALS['settings_global'] = $ci->db->from('settings_global')->get()->row();
}

function init_language($params = array())
{	
    $ci =& get_instance();
	$ci->load->library('session');
	$ci->load->model('locations_model');
	
	if(!$ci->session->userdata('site_sl') || ($ci->uri->segment(1) && $ci->session->userdata('site_sl') != $ci->uri->segment(1)))
	{
		if(strlen($ci->uri->segment(1)) == 2){
	    	$check_language_request = $ci->db->select('lang_code')->from('languages')->where('lang_code', $ci->uri->segment(1))->count_all_results();
	    }
	    
	    if(!empty($check_language_request)){
	    	$requested_language = $ci->uri->segment(1);
	    } else {
	    	$ci->session->unset_userdata('site_sl');
	    }
	
		if(!$ci->session->userdata('site_sl') && empty($requested_language)){
			$ci->db->where('defaults', 'Y');
		}
	
		if(!empty($requested_language)){
			$ci->db->where('lang_code', $requested_language);
		}
	
		if(!$ci->session->userdata('site_sl') || !empty($requested_language)){
			$site_sl = $ci->db->from('languages')->get()->row();
		}
		
		if(!empty($site_sl)){
			$ci->session->set_userdata(array('site_sl_name' => $site_sl->name));
			$ci->session->set_userdata(array('site_sl' => $site_sl->lang_code));
		}
	}
	
	if(!$ci->session->userdata('site_city'))
	{
		$site_city = 34;
		
		$geop = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.getip()));
		if(!empty($geop['geoplugin_city']))
		{
			$seo_city = seo($geop['geoplugin_city']);
			$check = $ci->locations_model->get_location('locations_cities', ['seo_link' => $seo_city]);
			
			$site_city = !empty($check->id) ? $check->id : $site_city;
		}
		$ci->session->set_userdata('site_city', $site_city);
	}
	
			
	if($ci->session->userdata('site_sl') == 'tr')
	setlocale(LC_TIME,'tr_TR.UTF-8');
}

function update_lastactive()
{
    $ci=& get_instance();
    $ci->load->model('users_model');
    $ci->load->library('user_agent');
    
    $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

    //featured expired olmus kullanicinin service_featured kolonunu NULL yap
    if($featured_expired_users = $ci->cache->get('functions_update_lastactive_featured_expired_users'))
    {
	    $featured_expired_users = $ci->users_model->get_users_by(array('service_featured <=' => time(), 'service_featured !=' => NULL));
	    if(!empty($featured_expired_users)){
		    foreach($featured_expired_users as $user){
		    	$search_point = $user->search_point - point('featured');
				$ci->users_model->update_user(array('id' => $user->id), array('last_featured' => $user->service_featured, 'service_featured' => NULL, 'search_point' => $search_point));	    
		    }
	    }
	    
	    $ci->cache->save('functions_update_lastactive_featured_expired_users', $featured_expired_users, 86400);
    }
    
    //doping expired olmus kullanicinin service_doping kolonunu NULL yap
    if($doping_expired_users = $ci->cache->get('functions_update_lastactive_doping_expired_users'))
    {    
	    $doping_expired_users = $ci->users_model->get_users_by(array('service_doping <=' => time(), 'service_doping !=' => NULL));
	    if(!empty($doping_expired_users)){
		    foreach($doping_expired_users as $user){
		    	$search_point = $user->search_point - point('doping');
				$ci->users_model->update_user(array('id' => $user->id), array('last_doping' => $user->service_doping, 'service_doping' => NULL, 'search_point' => $search_point));	    
		    }
	    }
	    $ci->cache->save('functions_update_lastactive_doping_expired_users', $doping_expired_users, 86400);
    }    
    
    //membership expired olmuş kullanıcının puanını düşür
    if($memberships_expired_users = $ci->cache->get('functions_update_lastactive_memberships_expired_users'))
    { 
	    $memberships_expired_users = $ci->users_model->get_users_by(array('expire_membership !=' => NULL, 'expire_membership <' => time()));
	    if(!empty($memberships_expired_users)){
		    foreach($memberships_expired_users as $user){
		    	if($user->ugroup == 4 || $user->ugroup == 5){
			    	$search_point = $user->ugroup == 4 ? $user->search_point - point('advanced') : $user->search_point - point('premium');
		    	} else {
			    	$search_point = $user->search_point;
		    	}
				$ci->users_model->update_user(array('id' => $user->id), array('last_membership' => $user->expire_membership, 'expire_membership' => NULL, 'ugroup' => 3, 'search_point' => $search_point));	    
		    }
	    } 
	    $ci->cache->save('functions_update_lastactive_memberships_expired_users', $memberships_expired_users, 86400); 
    }
    
    //update user data
	if($ci->session->userdata('user_id')){
		$ci->users_model->update_user(array('id' => $ci->session->userdata('user_id')), array('online' => 1, 'lastactive' => time()));
		//$ci->users_model->update_user_session($ci->session->userdata('user_id'));//update_user bunu yapıyor
	}

    if(!$ci->cache->get('functions_update_lastactive_set_online'))
    {		
		$ci->users_model->update_user(array('lastactive <' => strtotime('-15 minute')), array('online' => 0));
	    $ci->cache->save('functions_update_lastactive_set_online', 1, 1800); 
    }	
}


function captcha($param)
{
    $ci=& get_instance();
    
    $sayi1 = rand(1,5); // 1 ile 5 arasında rastgele bir sayı
    $sayi2 = rand(1,5); // 1 ile 5 arasında rastgele bir sayı
	
    $cevap = ($sayi1+$sayi2); // Sorumuzun cevabını buluyoruz
    $ci->session->set_userdata($param, $cevap); // Sorumuzun cevabını sessiona atıyoruz
	
    return $sayi1." + ".$sayi2; // Sorumuzu ekrana bastırıyoruz
}

function captcha_check($security_code)
{
	$ci=& get_instance();

	if ($security_code != $ci->session->userdata('captcha_'.$ci->input->post('form')))
	{		
			$ci->load->helper(array('form'));
			$ci->load->library('form_validation');	
	        $ci->form_validation->set_message('captcha_check_message', 'Güvenlik kodu hatalıdır.');
	        return FALSE;
	}
	else
	{
	        return TRUE;
	}
}

/*
Belirtilen dizine, belirtilen ozelliklerde medya upload eder.
Maksimum resim boyutu 1MB'dir.
$name 		: medya ismi
$tmp_name 	: medya tmp ismi
$type 		: medya tipi
$size 		: medya boyutu
$new_name	: medinin yeni ismi
$target 	: medyanin yuklenecegi dizin
$watermark  : medyanin ustune yazilacak isim
$width		: imaj genisligi
$height		: imaj yuksekligi
$resize		: imaj resize
*/
function myUpload($name, $tmp_name, $type, $size, $new_name = null, $target = 'uploads/', $watermark = '', $width=600, $height=600, $resize=false){

    $ci=& get_instance();
	
	myMkdir(ROOTPATH . $target);

	$image_types = array(
		'image/pjpeg',
		'image/jpeg',
		'image/x-png',
		'image/png',
		'image/gif'
	);
	
	$document_types = array(
		'application/msword',
		'application/pdf',
		'application/excel', 
		'application/vnd.ms-excel', 
		'application/msexcel',
		'application/powerpoint', 
		'application/vnd.ms-powerpoint',
		'application/x-shockwave-flash',
		'text/html',
		'text/richtext',
		'text/rtf',
		'text/plain',
		'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	);
	
	$ext = @end(explode('.', $name));
		
	if(in_array($type, $document_types) || in_array($type, $image_types)){
		move_uploaded_file($tmp_name, ROOTPATH . $target . 'tmp_'.$new_name .'.'. $ext);
		
		if(in_array($type, $document_types))
		return array('response' => true, 'value' => $name);
	}
	
	if(in_array($type, $image_types))
	{
		
		$ci->load->library('upload');
		
		$handle = new Upload(ROOTPATH . $target . 'tmp_'.$new_name .'.'. $ext);
		
		$handle->image_resize            	 = $resize;
		
		if($handle->image_resize){
			$handle->image_x                 = $width;
			$handle->image_y                 = $height;
			$handle->image_ratio_crop		 = true;
		}
		
		if($type != 'image/png' && $type != 'image/x-png' && $type != 'image/gif'){
			$handle->image_convert 			 = 'jpg';
		}
		
		$handle->file_auto_rename 		 = false;
		$handle->file_new_name_body      = $new_name;

		if($watermark){
		    $handle->image_text           	 = $watermark;
			$handle->image_text_position   	 = 'BR';
			$handle->image_text_padding_x 	 = 10;
			$handle->image_text_padding_y 	 = 10;	
			$handle->image_text_percent    	 = 50;
		    $handle->image_text_color        = '#FFFFFF';
			$handle->image_text_font         = 2;
		}
		
		$handle->Process(ROOTPATH . $target);
				
		if ($handle->processed) {
			$handle->Clean();
			return array('response' => true, 'value' => $handle->file_dst_name);
		} else {
			return array('response' => false, 'value' => $handle->error);
		}
	}
	
}

function myMkdir( $dir = false )
{
	if ( !$dir )
        return false;
    
    $dir = str_replace(ROOTPATH, '', $dir);
    $dirs = explode('/', $dir);
    $directory = ROOTPATH;
    
    foreach ( $dirs as $next )
    {
        $directory .= $next . '/';
        
        if ( is_dir($directory) )
        {
            if ( !is_writable($directory) )
            {
                chmod($directory, 0755);
                if ( !is_writable($directory) )
                {
                    chmod($directory, 0777);
                }
            }
        }
        else
        {
            mkdir($directory);
            chmod($directory, 0755);
            if ( !is_writable($directory) )
            {
                chmod($directory, 0777);
            }
        }
    }
    return true;
}


function redir($url, $message = array(), $meta_redirect = false, $delay = 0, $error = FALSE){

	$ci=& get_instance();

	if($error == TRUE){
		$ci->session->set_flashdata(array('error' => 1));
	}

	if (!ob_get_contents() && !headers_sent() && !$meta_redirect) {

		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$res = $error == FALSE ? 'OK' : 'ERR';
			echo json_encode(array('RES' => $res, 'MSG' => $message, 'REDIR' => $url));
			exit;			
		} else {

			if(sizeof($message) > 0){
				$ci->session->set_flashdata(array('message' => $message));
			}
			
			header('Location: ' . $url);
			exit;
		}
			

	} else {
		if(!empty($message) > 0){
			echo '<ul>';
			foreach($message as $msg){
				echo '<li>'.$msg.'</li>';
			}
			echo '</ul>';
		}
		if ($delay != 0) {
			echo('<a href="' . htmlspecialchars($url) . '">Devam etmek için tıklayınız...</a>');
		}
		echo('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
		echo('<meta http-equiv="Refresh" content="' . $delay . ';URL=' . htmlspecialchars($url) . '" />');
	}
	
	f_flush();
	exit;
}

function f_flush()
{
	if (function_exists('ob_flush')) {
		@ob_flush();
	}
	flush();
}

function m($type = '', $id = '', $extra = array())
{
	if(empty($type) || empty($id) || $GLOBALS['settings_global']->mail_notifications == 'N') return false;
	
	$ci=& get_instance();

	$ci->load->library('email');
	$ci->load->helper('email');
		
	$from_email 	= $GLOBALS['settings_global']->admin_email;
	$to_email 		= $GLOBALS['settings_global']->admin_email;
	$site_name		= $GLOBALS['settings_global']->site_name;
	$template 		= lang('MAIL_TEMPLATE');
	
	switch($type)
	{
		case 'contact_form':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('ONLINE_CONTACT_FORM_SUBJECT');		
			$msg = nl2br(lang('ONLINE_CONTACT_FORM_BODY'));
			$msg = str_replace('__FIRSTNAME__', $extra['firstname'], $msg);
			$msg = str_replace('__LASTNAME__', $extra['lastname'], $msg);
			$msg = str_replace('__EMAIL__', $extra['email'], $msg);
			$msg = str_replace('__PHONE__', $extra['phone'], $msg);
			$msg = str_replace('__MESSAGE__', $extra['message'], $msg);
		break;
		
		case 'new_user':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_NEW_USER_SUBJECT');		
			$msg = nl2br(lang('MAIL_NEW_USER_BODY'));
			$msg = str_replace('__FIRSTNAME__', $user->firstname, $msg);
			$msg = str_replace('__LASTNAME__', $user->lastname, $msg);
			$msg = str_replace('__EMAIL__', $user->email, $msg);
			$msg = str_replace('__PASSWORD__', $user->password_text, $msg);
			$msg = str_replace('__ACTIVATION_CODE__', $extra['activation_code'], $msg);
			$msg = str_replace('__ACTIVATION_URL__', site_url('aktivasyon/?code='.$extra['activation_code'].'&email='.$user->email), $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			
			$to_email = $user->email;
		break;		
		
		case 'forgot':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('USERS_FORGOT_SUBJECT');		
			$msg = nl2br(lang('USERS_FORGOT_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$msg = str_replace('__LINK__', site_url('sifremi-unuttum/?code='.$user->forgot.'&email='.$user->email), $msg);
			
			$to_email = $user->email;
		break;
		
		case 'emailchange':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('USERS_EMAILCHANGE_SUBJECT');		
			$msg = nl2br(lang('USERS_EMAILCHANGE_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$msg = str_replace('__LINK__', site_url('users/emailchange/?code='.md5($user->email_request . $user->id).'&email='.$user->email_request), $msg);
			
			$to_email = $user->email_request;
		break;		

		case 'delete_user':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_USER_DELETE_SUBJECT');		
			$activation_url = site_url('aktivasyon/?email='.$user->email.'&code='.$extra['activation_code']);	
			$msg = nl2br(lang('MAIL_USER_DELETE_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__USERNAME__', $user->username, $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			
			$to_email = $user->email;
		break;
		
		case 'order_notify':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_ORDER_NOTIFY_SUBJECT');		
			$msg = nl2br(lang('MAIL_ORDER_NOTIFY_BODY'));
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__ORDERS__', '<table cellpadding="5" cellspacing="0" width="100%" border="0" style="border: 1px solid #eeeeee;">'.$extra["order_template"].'</table>', $msg);
			
			$to_email = $user->email;
			$bcc = $GLOBALS['settings_global']->admin_email;
		break;
		
		case 'orders_memberships_complete_oid_error':			
			$subject = "Kritik Hata! Memberships:_complete oid hatalı!";		
			$msg = "Memberships:_complete fonksiyonuna oid gönderilmeden işlem gerçekleştirilmeye çalışıldı. Mevcut veri: $id";
			$to_email = $GLOBALS['settings_global']->admin_email;
		break;
		
		case 'orders_memberships_complete_id_error':			
			$subject = "Kritik Hata! Memberships:_complete id hatalı!";		
			$msg = "Memberships:_complete fonksiyonundaki oid dönerken olmayan bir id saptandı. Mevcut veri: $id";
			$to_email = $GLOBALS['settings_global']->admin_email;
		break;			
		
		case 'orders_memberships_complete_oid_not_found':			
			$subject = "Kritik Hata! Memberships:_complete oid bulunamadı!";		
			$msg = "Memberships:_complete fonksiyonuna gönderilen oid sistemde bulunamadı. Mevcut veri: $id";
			$to_email = $GLOBALS['settings_global']->admin_email;
		break;	









				
		case 'approval':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$admins = $ci->db->from('users')->where('ugroup', 1)->where('status', 'A')->get()->result();
			if(empty($admins)) return false;
			foreach($admins as $admin){
				$subject = lang('MAIL_APPROVE_TUTOR_SUBJECT');		
				$msg = nl2br(lang('MAIL_APPROVE_TUTOR_BODY'));
				$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
				$msg = str_replace('__EMAIL__', $user->email, $msg);
				$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
				$msg = str_replace('__BODY__', $msg, $template);
				
				$to_email = $admin->email;
				
				$ci->email->from($from_email, $site_name);
				$ci->email->to($to_email);
				$ci->email->subject($subject . ' - ' . $site_name);
				$ci->email->message($msg);
				
				if(!$ci->email->send()){
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= 'From: '.$site_name.' <'.$from_email.'>' . "\r\n";
					send_email($to_email, $subject . ' - ' . $site_name, $msg);
				}
			}
			return;
		break;	
				
		case 'approaching_lesson':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user) || $user->n_upcoming != 'Y') return false;
			
			$counterpart = $user->id == $extra->uid ? $extra->tutor_id : $extra->uid;
			$counterpart = user_meta($counterpart);
			$lesson = lesson_meta($extra->id);
			
			$subject = lang('MAIL_APPROACHING_LESSON_SUBJECT');		
			$msg = nl2br(lang('MAIL_APPROACHING_LESSON_BODY'));
			$msg = str_replace('__COUNTERPART__', $counterpart['fullName'], $msg);
			$msg = str_replace('__LESSON__', $lesson['level']['level_title'], $msg);
			$msg = str_replace('__TIME__', nicetime(date_format(date_create($lesson['slot_start']), 'd.m.Y H:i')), $msg);
			
			$to_email = $user->email;
		break;
		
		case 'approaching_demo_user':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_ADMIN_APPROACHING_DEMO_SUBJECT');		
			$msg = nl2br(lang('MAIL_ADMIN_APPROACHING_DEMO_BODY'));
			$msg = str_replace('__EMAIL__', $user->email, $msg);
			$msg = str_replace('__DATE__', date('d.m.Y H:i', $user->demo_date) . ' (' . nicetime(date('d.m.Y H:i', $user->demo_date)) . ')', $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			
			$to_email = $GLOBALS['settings_global']->admin_email;
		break;
		
		case 'approaching_demo_admin':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_ADMIN_APPROACHING_DEMO_SUBJECT');		
			$msg = nl2br(lang('MAIL_ADMIN_APPROACHING_DEMO_BODY'));
			$msg = str_replace('__EMAIL__', $user->email, $msg);
			$msg = str_replace('__DATE__', date('d.m.Y H:i', $user->demo_date) . ' (' . nicetime(date('d.m.Y H:i', $user->demo_date)) . ')', $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			
			$to_email = $user->email;
		break;		
		
		case 'new_message':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			$extra['date'] = $extra['date'] ? $extra['date'] : time();
			$subject = lang('MAIL_NEW_MESSAGE_SUBJECT');		
			$msg = nl2br(lang('MAIL_NEW_MESSAGE_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__DATE__', date('d.m.Y H:i', $extra['date']), $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$to_email = $user->email;
		break;	
		
		case 'reschedule':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_RESCHEDULE_SUBJECT');		
			$msg = nl2br(lang('MAIL_RESCHEDULE_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__DATE__', $extra['date'], $msg);
			$msg = str_replace('__REQUEST_DATE__', $extra['request_date'], $msg);
			$msg = str_replace('__FROM_FULLNAME__', $extra['from_fullname'], $msg);
			$msg = str_replace('__LESSON__', $extra['lesson_name'], $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$to_email = $user->email;
		break;
		
		case 'book':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_BOOK_SUBJECT');		
			$msg = nl2br(lang('MAIL_BOOK_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__DATE__', $extra['date'], $msg);
			$msg = str_replace('__FROM_FULLNAME__', $extra['from_fullname'], $msg);
			$msg = str_replace('__LESSON__', $extra['lesson_name'], $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$to_email = $user->email;
		break;
		
		case 'trial':			
			$user = $ci->db->from('users')->where('id', $id)->get()->row();
			if(empty($user)) return false;
			
			$subject = lang('MAIL_TRIAL_SUBJECT');		
			$msg = nl2br(lang('MAIL_TRIAL_BODY'));
			$msg = str_replace('__FULLNAME__', $user->firstname . ' ' . $user->lastname, $msg);
			$msg = str_replace('__DATE__', $extra['date'], $msg);
			$msg = str_replace('__FROM_FULLNAME__', $extra['from_fullname'], $msg);
			$msg = str_replace('__LESSON__', $extra['lesson_name'], $msg);
			$msg = str_replace('__SITE__', txtLower($_SERVER['HTTP_HOST']), $msg);
			$to_email = $user->email;
		break;		
		
		case 'admin':			
			$subject = 'NetDers Notification';		
			$msg = $id;
			$to_email = $GLOBALS['settings_global']->admin_email;
		break;							
	}
	
	$msg = str_replace('__BODY__', $msg, $template);
	
	$ci->email->from($from_email, $site_name);
	$ci->email->to($to_email);
	if(!empty($bcc)) $ci->email->bcc($bcc);
	$ci->email->subject($subject . ' - ' . $site_name);
	$ci->email->message($msg);
	
	if(!$ci->email->send())
	{
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: '.$site_name.' <'.$from_email.'>' . "\r\n";
		send_email($to_email, $subject . ' - ' . $site_name, $msg);
	}
	
	if($type == 'new_user' && !empty($user)){
		$ci->db->where('id', $user->id)->update('users', array('mail_response' => $ci->email->print_debugger()));	
	}	
}

/*
* Mevcut site dilinde anahtar aranir varsa basar yoksa
* olmayan dil anahtarlarina insert eder basinda ve sonunda
* # isareti ile anahtari basar.
* 
* $param	: gelen dil anahtarı
*/
function lang($param = '')
{
	if(empty($param)) return false;
	
	$ci =& get_instance();
	$param = $ci->security->xss_clean($param);
	
	$language = $ci->db->select('lang_value')
					->from('lang_keys k')
					->join('languages l', 'l.lang_code = k.lang_code')
					->where('l.status', 'A')
					->where('k.lang_code', $ci->session->userdata('site_sl'))
					->where('k.lang_key', $param)
					->limit(1)
					->get()->row();

	if(!empty($language->lang_value)){
		return $language->lang_value;
	} else {
		$check = $ci->db->where(array('lang_key' => $param))->from('lang_keys_empties')->count_all_results();
		if($check == 0){
			$ci->db->insert('lang_keys_empties', array('lang_key' => $param));
		}
		return "#".$param."#";		
	}
}

// Kucuk harf
function txtLower($metin, $kod='UTF-8')
{
	$ci =& get_instance();
	
	if($ci->session->userdata('site_sl') == 'tr'){
		$ara = array('I');
		$deg = array('ı');
	}
	$mtn = str_replace($ara, $deg, trim($metin));
	return mb_convert_case($mtn, MB_CASE_LOWER, $kod);
}

// Buyuk harf
function txtUpper($metin, $kod='UTF-8')
{
	$ci =& get_instance();
	
	if($ci->session->userdata('site_sl') == 'tr'){
		$ara = array('i');
		$deg = array('İ');
	}
	$mtn = str_replace($ara, $deg, trim($metin));
	return mb_convert_case($mtn, MB_CASE_UPPER, $kod);
}

// Ilk harf buyuk
function txtFirstUpper($metin, $kod='UTF-8'){
   mb_internal_encoding($kod);
   $mtn = trim($metin);
   $bas = mb_substr(txtUpper($mtn, $kod), 0, 1);
   $son = mb_substr(txtLower($mtn, $kod), 1);
   return $bas . $son;
} 

// Kelime buyuk
function txtWordUpper($metin, $kod='UTF-8'){
   $mtn = explode(' ',$metin);
   foreach($mtn as $no => $klm) if($klm) $snc[] = txtFirstUpper($klm, $kod);
   if(is_array($snc)) return implode(' ',$snc);
} 

function _make_link($link_type = 'url', $link_value = NULL, $column = 'id'){

	if(is_null($link_value)) return false;

   	$ci=& get_instance();
   	$ci->load->model('locations_model');

    $out = site_url();

	switch ($link_type) 
	{
		case 'search':
			$city = $ci->locations_model->get_location('locations_cities', ['id' => $link_value]);
			if(!empty($city->seo_link))
			return site_url('ozel-ders-ilanlari-verenler/' . $city->seo_link);
		break;
		
		case 'url':
			return $link_value;
		break;
		
		case 'inurl':
			return site_url($link_value);
		break;		

		case 'home':
			return site_url();
		break;
		
		case 'contents':
			$content = $ci->db->select('seo_link, category_seo_link, lang_code')->from('contents')->where($column, $link_value)->where('lang_code', $ci->session->userdata('site_sl'))->get()->row();
			if(!empty($content))
			{
				if(!empty($content->category_seo_link) && $GLOBALS['settings_global']->content_link_type == 1){
					$out .= $content->category_seo_link . DS;	
				}
				if(!empty($content->seo_link)){
					$out .= $content->seo_link.'.html';
				}
			}
			return $out;
		break;

		case 'contents_categories':
			$category = $ci->db->select('seo_link, lang_code')->from('contents_categories')->where($column, $link_value)->where('lang_code', $ci->session->userdata('site_sl'))->get()->row();
			if(!empty($category))
			{
				if(!empty($category->seo_link)){
					$out .= $category->seo_link;
				}
			}
			return $out;
		break;
	}
}

function breadcrumb($type, $id = '')
{
	$ci=& get_instance();
	
	$breadcrumb = array();
	
	$breadcrumb[] = array('title' => lang('HOME'), 'link' => site_url());
	
	switch ($type) {
		case 'content':
			$content = $ci->db->from('contents')->where('id', $id)->limit(1)->get()->row();
			
			$category = $ci->db->from('contents_categories')->where('category_id', $content->main_category)->where('lang_code', $ci->session->userdata('site_sl'))->limit(1)->get()->row();

			if(!is_numeric($category->id_path)){
				foreach(explode('/', $category->id_path) as $category_id){
					$c = $ci->db->select('title, id')->from('contents_categories')->where('id', $category_id)->limit(1)->get()->row();
					if($c->title)
					$breadcrumb[] = array('title' => $c->title, 'link' => _make_link('contents_categories', $c->id));
				}
			} else {
				if($category->title)
				$breadcrumb[] = array('title' => $category->title, 'link' => _make_link('contents_categories', $category->id));
			}
			if($content->title)
			$breadcrumb[] = array('title' => $content->title, 'link' => _make_link('contents', $content->id));	
		break;

		case 'category':
			$category = $ci->db->select('id_path')->from('contents_categories')->where('category_id', $id)->where('lang_code', $ci->session->userdata('site_sl'))->limit(1)->get()->row();
			foreach(explode('/', $category->id_path) as $category_id){
				$c = $ci->db->select('title, id')->from('contents_categories')->where('category_id', $category_id)->where('lang_code', $ci->session->userdata('site_sl'))->limit(1)->get()->row();
				if($c->title && $c->id != 6){
					$breadcrumb[] = array('title' => $c->title, 'link' => _make_link('contents_categories', $c->id));
				}
			}
		break;
		
		case 'users':
			$breadcrumb[] = array('title' => lang('USERS'));
		break;

		case 'branches':
			$breadcrumb[] = array('title' => lang('BRANCHES'));
		break;
				
		case 'contact':
			$breadcrumb[] = array('title' => $ci->input->get('type') == 2 ? lang('SUGGEST') : lang('CONTACT'));
		break;		
		
	}
	
	return $breadcrumb;
}

function pagenav($total,$page,$perpage,$url) 
{

	$ci=& get_instance();
	
	$parameters = $ci->input->get();
	unset($parameters['page']);
	$url = $parameters ? current_url(false) . '?' . http_build_query($parameters, '', '&') : current_url(false);
	$symb = $parameters ? '&' : '?'; 	
	
	$page_arr = array();
	$arr_count = 0;

	$total_pages = ceil($total/$perpage);
	$llimit = 1;
	$rlimit = $total_pages;
	$window = 3;
	$html = '';
	if ($page<1 || !$page) 
	{
		$page=1;
	}
	
	if(($page - floor($window/2)) <= 0)
	{
		$llimit = 1;
		if($window > $total_pages)
		{
			$rlimit = $total_pages;
		}
		else
		{
			$rlimit = $window;
		}
	}
	else
	{
		if(($page + floor($window/2)) > $total_pages) 
		{
			if ($total_pages - $window < 0)
			{
				$llimit = 1;
			}
			else
			{
				$llimit = $total_pages - $window + 1;
			}
			$rlimit = $total_pages;
		}
		else
		{
			$llimit = $page - floor($window/2);
			$rlimit = $page + floor($window/2);
		}
	}
	if ($page>1)
	{
		$page_arr[$arr_count]['title'] = "Önceki";
		$page_arr[$arr_count]['link'] = $url.$symb.'page='.($page-1);
		$page_arr[$arr_count]['current'] = 0;
		$page_arr[$arr_count]['active'] = "prev";
		$arr_count++;

		if($page > 3){
			$page_arr[$arr_count]['title'] = 1;
			$page_arr[$arr_count]['link'] = $url.$symb.'page=1';
			$page_arr[$arr_count]['current'] = 0;
			$arr_count++;

			$page_arr[$arr_count]['title'] = "...";
			$page_arr[$arr_count]['link'] = "";
			$page_arr[$arr_count]['current'] = 0;
			$arr_count++;
		}
	}

	for ($x=$llimit;$x <= $rlimit;$x++) 
	{
		if ($x <> $page) 
		{
			$page_arr[$arr_count]['title'] = $x;
			$page_arr[$arr_count]['link'] = $url.$symb.'page='.($x);
			$page_arr[$arr_count]['current'] = 0;
		} 
		else 
		{
			$page_arr[$arr_count]['title'] = $x;
			$page_arr[$arr_count]['link'] = $url.$symb.'page='.($x);
			$page_arr[$arr_count]['current'] = 1;
		}

		if($ci->input->get('page') && $ci->input->get('page') == $x){
			$page_arr[$arr_count]['active'] = "active";
		}
	
		$arr_count++;
	}
	
	if($page < $total_pages)
	{
		if($page < $total_pages - 2){
		$page_arr[$arr_count]['title'] = "...";
		$page_arr[$arr_count]['link'] = "";
		$page_arr[$arr_count]['current'] = 0;
		$arr_count++;
		
		$page_arr[$arr_count]['title'] = $total_pages;
		$page_arr[$arr_count]['link'] = $url.$symb.'page='.($total_pages);
		$page_arr[$arr_count]['current'] = 0;
		$arr_count++;
		}
		
		$page_arr[$arr_count]['title'] = "Sonraki";
		$page_arr[$arr_count]['link'] = $url.$symb.'page='.($page+1);
		$page_arr[$arr_count]['current'] = 0;
		$page_arr[$arr_count]['active'] = "next";
		$arr_count++;
	}
	
	return $page_arr;
}

function my_mb_substr($data, $length){
	if(strlen($data) > $length){
		return mb_substr($data, 0, $length, 'UTF-8').'...';
	} else {
		return $data;
	}
}

/*
	Elemanin ust veya alt elemanlarini doner
	var type 		(string) 	[parents or parent_id or childrens or id]
	var item_id 	(int) 		[item id]
	var table 		(int) 		[query table]
	var lang_code 	(string) 	[item lang]
	return (array)
*/	
function get_items_recursive($type, $item_id, $table = 'categories', $lang_code = '', $found = array())
{
	$ci=& get_instance();
	
	if(!empty($lang_code))
	$ci->db->where('lang_code', $lang_code);
	
	$type = $type == 'parents' ? 'parent_id' : $type;
	$type = $type == 'childrens' ? 'id' : $type;
	
	$where = $type == 'parent_id' ? 'id' : 'parent_id';
	$select = $type == 'parent_id' ? 'parent_id' : 'id';
	
	if(!empty($item_id)) array_push($found, $item_id);
	
	$result = $ci->db->query("SELECT $select FROM ".$ci->db->dbprefix($table)." WHERE $where = $item_id")->result();
	
    if(!empty($result)){
        foreach($result as $row){
            $found = get_items_recursive($select, $row->$type, $table, $lang_code, $found);

        }
    }
    
    return $found;	
}

function prefix_array_key($prefix = '', $array = array())
{
	if(empty($prefix) || empty($array)) return false;
	
	$out = array();
	
	foreach ($array as $key => $val) {
	    $out[$prefix . $key] = $val;
	}
	
	return $out;
}

function is_loggedin_redir($redirect_url)
{		
	$ci=& get_instance();
	
	if($ci->session->userdata('user_id'))
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			echo json_encode(array('RES' => 'OK', 'MSG' => array('Hesabınıza zaten giriş yapmış durumdasınız.'), 'REDIR' => $redirect_url));
			exit;			
		} else {
			redir($redirect_url);
		}
	}	
}

function is_notloggedin_redir($redirect_url)
{		
	$ci=& get_instance();
	
	if(!$ci->session->userdata('user_id'))
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			echo json_encode(array('RES' => 'OK', 'MSG' => 'Hesabınıza giriş yapmanız gerekmektedir.', 'REDIR' => $redirect_url));
			exit;			
		} else {
			redir($redirect_url);
		}
	}	
}

function unique_string($db = '', $column = '', $length = 8, $type = 'numeric')
{    
    $ci=& get_instance();
        
	$ci->load->helper('string');
	$random_string = random_string($type, $length);
	
	if(!empty($db) && !empty($column))
	{
		$check = $ci->db->select($column)->from($db)->where($column, $random_string)->get()->row();
	}
	
	if(!empty($db) && !empty($column) && !empty($check)){
		random_str($db, $column, $lenght, $type);			
	}
	
	return $random_string;
}

function is_teacher($user_group = null)
{
	$ci=& get_instance();
	
	$user_group = $user_group ? $user_group : $ci->session->userdata('user_ugroup');
	return in_array($user_group, array(3,4,5)) ? true : false;
}

function is_student()
{
	$ci=& get_instance();
	if(!$ci->session->userdata('user_id')) return false;
	
	if($ci->session->userdata('user_id') && in_array($ci->session->userdata('user_ugroup'), array(2))) return true;
	
	return false;
}

function content($content_id)
{
	$ci=& get_instance();	
	return $ci->db->from('contents')->where('content_id', (int)$content_id)->where('lang_code', $ci->session->userdata('site_sl'))->get()->row();
}

function check_cart()
{
	$ci=& get_instance();
	$ci->load->model('payment_model');
	return $ci->payment_model->shopping_cart_count();
}

//money format
function format_money($money)
{	
	return number_format($money, 1, '.', '');
}

//price format
function format_price($price)
{	
	return number_format($price, 2, '.', '');
}

//price to money
function ptm($price)
{	
	return $price > 0 ? format_money($price * 10) : NULL;
}

//money to price
function mtp($money)
{	
	return $money > 0 ? format_price($money * 0.10) : NULL;
}

function point($param)
{
	$points = array(
		'premium' 	=> 18,
		'advanced' 	=> 4,
		'starter' 	=> 2,
		'featured' 	=> 12,
		'doping' 	=> 8,
		'student' 	=> 1
	);
	
	return $points[$param];
}

function unixtime_to_day($timestamp) 
{
    $seconds = $timestamp - strtotime("23:59:59"); 
    $minutes = (int)($seconds / 60);
    $hours = (int)($minutes / 60);
    $days = (int)($hours / 24);

    return $days;
}

function money($data)
{
	$ci=& get_instance();
	
	if(empty($data['category']) || empty($data['user_id']) || empty($data['money']) || empty($data['type'])) return false;
	
	$money_data = array(
		'category' 	=> $data['category'],
		'uid' 		=> $data['user_id'],
		'money' 	=> $data['money'],
		'type' 		=> $data['type'],
		'date' 		=> time(),
		'ip' 		=> $ci->input->ip_address()
	);
	$ci->db->insert('users_money', $money_data);
}

function required_profile_fields()
{
	$ci=& get_instance();
	
	$required = array();
	
	if(!$ci->session->userdata('user_birthday'))
	$required[] = array(site_url('users/personal'), 'Kişisel Bilgilerim > Doğum Tarihi');
	
	if(!$ci->session->userdata('user_gender'))
	$required[] = array(site_url('users/personal'), 'Kişisel Bilgilerim > Cinsiyet');
	
	if(!$ci->session->userdata('user_mobile'))
	$required[] = array(site_url('users/personal'), 'Kişisel Bilgilerim > Cep Telefonu Numaram');
	
	if(!$ci->session->userdata('user_city'))
	$required[] = array(site_url('users/personal'), 'Kişisel Bilgilerim > Bulunduğum Şehir');
	
	if(!$ci->session->userdata('user_town'))
	$required[] = array(site_url('users/personal'), 'Kişisel Bilgilerim > Bulunduğum İlçe');
	
	if(!$ci->session->userdata('user_text_title'))
	$required[] = array(site_url('users/informations'), 'Tanıtım Yazılarım > Başlık');
	
	/*
	if(!$ci->session->userdata('user_text_short'))
	$required[] = array(site_url('users/informations'), 'Tanıtım Yazılarım > Karşılama Metnim');
	
	if(!$ci->session->userdata('user_text_lesson'))
	$required[] = array(site_url('users/informations'), 'Tanıtım Yazılarım > Ders Yaklaşımım ve Tecrübem');		
	*/
	
	if(!$ci->session->userdata('user_text_long'))
	$required[] = array(site_url('users/informations'), 'Tanıtım Yazılarım > Detaylı Tanıtım Metnim');
	
	if(!$ci->session->userdata('user_prices'))
	$required[] = array(site_url('users/prices'), 'Ders Ücretlerim > Yeni Ders Ücreti');
	
	if(!$ci->session->userdata('user_locations'))
	$required[] = array(site_url('users/locations'), 'Ders Verdiğim Bölgeler > Yeni Ders Verdiğim Bölge');
	
	return $required;
}

function is_buyed($product_ids = array())
{
	$ci=& get_instance();
	
	if(empty($product_ids) || !$ci->session->userdata('user_id')) return false;
	
	return $ci->db->from('orders')->where_in('product_id', $product_ids)->where('transaction_id !=', 'NULL')->where('uid', $ci->session->userdata('user_id'))->count_all_results();
}

function education_types($type = ''){
	switch($type){
		case 1:
			return array(
				1 => 'Öğrenci Evinde',
				2 => 'Eğitmen Evinde',
				3 => 'Etüt Merkezi',
				4 => 'Kütüphane',
				5 => 'Diğer'
			);
		break;
		
		case 2:
			return array(
				1 => 'Hafta içi gündüz',
				2 => 'Hafta içi akşam',
				3 => 'Haftasonu gündüz',
				4 => 'Haftasonu akşam'
			);		
		break;
		
		case 3:
			return array(
				1 => 'Ödev Yardımı',
				2 => 'Tez Yardımı',
				3 => 'Proje Yardımı',
				4 => 'Eğitim Koçluğu',
				5 => 'Yaşam Koçluğu'
			);		
		break;		
		
		case 4:
			return array(
				1 => 'Erkek',
				2 => 'Kadın'
			);		
		break;	
		
		case 5:
			return array(
				1 => 'Birebir Ders',
				2 => 'Grup Dersi'
			);		
		break;						
	}
}

function location_name($type, $id)
{
	$ci=& get_instance();
	
	if(empty($type) || empty($id)) return false;
	
	$location = $ci->db->select('title')->from('locations_'.$type)->where('id', $id)->get()->row();
	return $location->title;
}

function user_lastname($lastname, $lastname_privacy)
{
	$ci=& get_instance();
	
	$show_lastname = $lastname ? txtUpper(mb_substr($lastname, 0, 1, 'UTF-8')).'.' : '';
	
	if($lastname_privacy == 1){
		$show_lastname = $lastname;
	}	

	if($lastname_privacy == 2){
		$show_lastname = 'Öğretmen';
	}
	
	if($lastname_privacy == 3 && $ci->session->userdata('user_ugroup') == 2){
		$show_lastname = $lastname;
	}
	
	return $show_lastname;
}

function calculate_age($unixdate)
{	
	$unixdate = str_replace('/', '-', $unixdate);
	return floor((time() - strtotime($unixdate)) / (60*60*24*365));
}

function render_page($area = null)
{
	if(empty($area)) return false;
	
	$ci=& get_instance();
	
	$ci->load->view($area);
}

function user_fullname($firstname, $lastname, $lastname_privacy)
{
	$ci=& get_instance();
	
	$show_lastname = $lastname ? txtUpper(mb_substr($lastname, 0, 1, 'UTF-8')).'.' : '';
	
	if($lastname_privacy == 1){
		$show_lastname = $lastname;
	}	

	if($lastname_privacy == 2){
		$show_lastname = 'Öğretmen';
	}
	
	if($lastname_privacy == 3 && $ci->session->userdata('user_ugroup') == 2){
		$show_lastname = $lastname;
	}
	
	return $firstname . ' ' . $show_lastname;
}

function make_filter_link($type = null)
{
	$ci=& get_instance();
	
	$parameters = $ci->input->get();
	foreach($parameters as $key => $value){
		if(strstr($key, 'sort_') == true){
			unset($parameters[$key]);
		}
	}
	$url = $parameters ? current_url(false) . '?' . http_build_query($parameters, '', '&') : current_url(false);
	$symb = $parameters ? '&' : '?'; 
	
	if($type){
		$ascdesc = $ci->input->get($type) == 'asc' ? 'desc' : 'asc';
		return $ci->security->xss_clean($url . $symb. $type . '=' . $ascdesc);	
	} else {
		return $ci->security->xss_clean($url);
	}
}

function escape_str($str, $like = FALSE)
{
	$ci=& get_instance();
	
    if (is_array($str))
    {
        foreach ($str as $key => $val)
        {
            $str[$key] = $ci->escape_str($val, $like);
        }

        return $str;
    }

    if (function_exists('mysqli_real_escape_string') AND is_object($ci->conn_id))
    {
        $str = mysqli_real_escape_string($ci->conn_id, $str);
    }
    else
    {
        $str = addslashes($str);
    }

    // escape LIKE condition wildcards
    if ($like === TRUE)
    {
        $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
    }

    return $str;
}

function seo($value)
{
	$special_chars[] = 'â';
	$special_chars[] = 'İ';
	$special_chars[] = 'Ş';
	$special_chars[] = 'Ç';
	$special_chars[] = 'Ğ';
	$special_chars[] = 'ş';
	$special_chars[] = 'ç';
	$special_chars[] = 'ğ';
	$special_chars[] = 'ı';
	$special_chars[] = 'ö';
	$special_chars[] = 'ü';
	$special_chars[] = 'Ö';
	$special_chars[] = 'Ü';
	$special_chars[] = 'Ä';
	$special_chars[] = 'Ü';
	$special_chars[] = 'ä';
	$special_chars[] = 'ü';
	$special_chars[] = 'ö';
	$special_chars[] = 'ß';
	$special_chars[] = 'Ž';
	$special_chars[] = '?';
	$special_chars[] = '.';
	$special_chars[] = ':';
	$special_chars[] = ',';
	$special_chars[] = '_';
	$special_chars[] = '-';
	$special_chars[] = '+';
	$special_chars[] = '&';
	$special_chars[] = '\\';
	$special_chars[] = ' ';
	$special_chars[] = '"';
	$special_chars[] = '#';
	$special_chars[] = "'";
	$special_chars[] = "\'";
	$special_chars[] = '!';
	$special_chars[] = 'quot';
	$special_chars[] = '--';
	$special_chars[] = '---';
	$special_chars[] = '----';

	$special_chars2[] = 'a';
	$special_chars2[] = 'i';
	$special_chars2[] = 's';
	$special_chars2[] = 'c';
	$special_chars2[] = 'g';
	$special_chars2[] = 's';
	$special_chars2[] = 'c';
	$special_chars2[] = 'g';
	$special_chars2[] = 'i';
	$special_chars2[] = 'o';
	$special_chars2[] = 'u';
	$special_chars2[] = 'O';
	$special_chars2[] = 'U';	
	$special_chars2[] = 'Ae';
	$special_chars2[] = 'Ue';
	$special_chars2[] = 'ae';
	$special_chars2[] = 'ue';
	$special_chars2[] = 'oe';
	$special_chars2[] = 'ss';
	$special_chars2[] = 'z';
	$special_chars2[] = '';
	$special_chars2[] = '';
	$special_chars2[] = '-';
	$special_chars2[] = '';
	$special_chars2[] = '-';
	$special_chars2[] = '-';
	$special_chars2[] = '-';
	$special_chars2[] = '';
	$special_chars2[] = '-';
	$special_chars2[] = '-';
	$special_chars2[] = '';
	$special_chars2[] = '';
	$special_chars2[] = '';
	$special_chars2[] = '';
	$special_chars2[] = '';
	$special_chars2[] = '';
	$special_chars2[] = '-';
	$special_chars2[] = '-';
	$special_chars2[] = '-';

	$value = trim($value);
	$value = str_replace($special_chars,$special_chars2,$value);
	$value = strtolower($value);
	$value = preg_replace('/[^0-9A-Za-z-\/]/',"",$value);
	
	return $value;
}

function seo_upper_en($value)
{
	$special_chars[] = 'ı';
	$special_chars[] = 'i';
	$special_chars[] = 'İ';
	$special_chars[] = 'ç';
	$special_chars[] = 'Ç';
	$special_chars[] = 'ö';
	$special_chars[] = 'Ö';
	$special_chars[] = 'ş';
	$special_chars[] = 'Ş';
	$special_chars[] = 'Ğ';
	$special_chars[] = 'ğ';
	$special_chars[] = 'Ü';
	$special_chars[] = 'ü';

	$special_chars2[] = 'I';
	$special_chars2[] = 'I';
	$special_chars2[] = 'I';
	$special_chars2[] = 'C';
	$special_chars2[] = 'C';
	$special_chars2[] = 'o';
	$special_chars2[] = 'O';
	$special_chars2[] = 'S';
	$special_chars2[] = 'S';
	$special_chars2[] = 'G';
	$special_chars2[] = 'S';
	$special_chars2[] = 'U';
	$special_chars2[] = 'U';

	$value = trim($value);
	$value = str_replace($special_chars,$special_chars2,$value);
	$value = preg_replace('/[^0-9A-Za-z-]/',"",$value);
	
	return $value;
}

function random_str($db = '', $column = '', $length = 8, $type = 'numeric')
{    
    $ci=& get_instance();
        
	$ci->load->helper('string');
	$random_string = random_string($type, $length);
	
	if(!empty($db) && !empty($column))
	{
		$check = $ci->db->select($column)->from($db)->where($column, $random_string)->get()->row();
	}
	
	if(!empty($db) && !empty($column) && !empty($check)){
		random_str($db, $column, $lenght, $type);			
	}
	
	return $random_string;
}

function get_data($param)
{
	if(empty($param)) return false;
	
	$ci=& get_instance();

	switch($param)
	{
		case 'register':
			return '
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 872564745;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "GpNxCPqss2oQiZCJoAM";
				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				<noscript>
				<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/872564745/?label=GpNxCPqss2oQiZCJoAM&amp;guid=ON&amp;script=0"/>
				</div>
				</noscript>				
			';
		break;
		
		case 'activation':
			return '
				<script type="text/javascript">
				/* <![CDATA[ */
				var google_conversion_id = 872564745;
				var google_conversion_language = "en";
				var google_conversion_format = "3";
				var google_conversion_color = "ffffff";
				var google_conversion_label = "H7YWCI_Ut2oQiZCJoAM";
				var google_remarketing_only = false;
				/* ]]> */
				</script>
				<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
				</script>
				<noscript>
				<div style="display:inline;">
				<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/872564745/?label=H7YWCI_Ut2oQiZCJoAM&amp;guid=ON&amp;script=0"/>
				</div>
				</noscript>				
			';
		break;				
	}
}

function generate_captcha($param = NULL)
{
	if(empty($param)) return false;
	
	$ci=& get_instance();
	$ci->load->library('session');
	$ci->load->helper('captcha');
	
	$vals = array(
	        'img_path'      => ROOTPATH . 'captcha/',
	        'img_url'       => site_url('captcha'),
	        'img_width'     => '200',
	        'img_height'    => 34,
	        'expiration'    => 7200,
	        'word_length'   => 4,
	        'font_size'     => 30,
	        'pool'          => '123456789',
	        'colors'        => array(
	                'background' => array(255, 255, 255),
	                'border' => array(255, 255, 255),
	                'text' => array(0, 0, 0),
	                'grid' => array(255, 40, 40)
	        )
	);
	
	$cap = create_captcha($vals);
	$ci->session->set_userdata(array('captcha_'.$param => (int)$cap['word']));
	
	return $cap['filename'];	
}

function get_user_discount($user, $param = '')
{
	if(empty($user)) return false;
	
	$discounts = array();
	
	//Ucretsiz ilk ders
	if($user->discount7){
		$discounts['freefirst'] = 1;
	}
	
	//Egitmen evi
	if($user->discount8){
		$discounts['teacher'] = (int)$user->discount8;
	}
	
	//Grup
	if($user->discount9){
		$discounts['group'] = (int)$user->discount9;
	}	
	
	//Uye ogrenci
	if($user->discount10){
		$discounts['registered'] = (int)$user->discount10;
	}
	
	//Program
	if($user->discount11){
		$discounts['program'] = (int)$user->discount11;
	}
	
	//Engelli
	if($user->discount12){
		$discounts['disabled'] = (int)$user->discount12;
	}

	//Oneri
	if($user->discount13){
		$discounts['review'] = (int)$user->discount13;
	}	
	
	//Canli ders
	if($user->discount1 > 0 || $user->discount2 > 0 || $user->discount3 > 0 || $user->discount4 > 0 || $user->discount5 > 0 || $user->discount6 > 0){
		$live_discounts = array($user->discount1, $user->discount2, $user->discount3, $user->discount4, $user->discount5, $user->discount6);
		$discounts['live'] = (int)max($live_discounts);
	}
	
	return $param ? $discounts[$param] : $discounts;		
}

function send_sms($number, $message)
{
	$xml = '<?xml version="1.0" encoding="UTF-8"?>
		<smspack ka="dollarrentacar" pwd="dollar34" org="Netders">
		<mesaj>
			<metin>'.$message.'</metin>
			<nums>'.str_replace(' ', '', $number).'</nums>
		</mesaj>
	</smspack>';
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL,"https://smsgw.mutlucell.com/smsgw-ws/sndblkex");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	curl_close ($ch);
}

function __usernameayarla(){
	$ci=& get_instance();
	$users = $ci->db->from('users')->get()->result();
	foreach($users as $user){
		$unique_string = unique_string('users', 'username', 8, 'numeric');
		$ci->db->where('id', $user->id)->update('users', array('username' => $unique_string));
	}
}

function __fotografayarla($userid)
{
	$ci=& get_instance();
	
	$ci->load->library('upload');
	
	$user = $ci->db->from('users')->where('id', $userid)->get()->row();
	if(empty($user)) return false;
	
	$handle = new Upload(ROOTPATH . $user->photo);
	
	$handle->image_resize            	 = true;
	
	if($handle->image_resize){
		$handle->image_x                 = 300;
		$handle->image_y                 = 300;
	}
	
	$ext = @end(explode('.', $user->photo));
	
	if($ext != 'png' && $ext != 'gif'){
		$handle->image_convert 			 = 'jpg';
	}
	
	$handle->image_ratio_crop		 = true;
	$handle->file_auto_rename 		 = false;
	$handle->file_new_name_body      = 'photo_'.$user->id.'_'.time();

    $handle->image_text           	 = 'netders';
	$handle->image_text_position   	 = 'BR';
	$handle->image_text_padding_x 	 = 10;
	$handle->image_text_padding_y 	 = 10;	
	$handle->image_text_percent    	 = 50;
    $handle->image_text_color        = '#FFFFFF';
	$handle->image_text_font         = 2;
	
	$handle->Process(ROOTPATH . 'uploads/users/');
		
	if ($handle->processed) {
		$handle->Clean();
		$photo = 'uploads/users/' . $handle->file_dst_name;
		$ci->db->where('id', $user->id)->update('users', array('photo' => $photo));
	} else {
		echo $handle->error;
		exit;
	}
}

function __update_user_points()
{
	$ci=& get_instance();
	
	$ci->db->where_in('ugroup', array(3,4,5))->update('users', array('search_point' => 2));

	$orders = $ci->db->from('orders')->where_in('product_id', array(9,10,14,15,16,17,18,19))->get()->result();
	
	$doping_users = array();
	$featured_users = array();
	
	foreach($orders as $order)
	{
		$user = $ci->db->from('users')->where('id', $order->uid)->get()->row();
		if(($order->product_id == 9 || $order->product_id == 10) && !in_array($order->uid, $featured_users)){
			$ci->db->where('id', $order->uid)->update('users', array('search_point' => $user->search_point + point('featured')));
			$featured_users[] = $order->uid;
		}
		
		if(($order->product_id == 14 || $order->product_id == 15 || $order->product_id == 16 || $order->product_id == 17 || $order->product_id == 18 || $order->product_id == 19) && !in_array($order->uid, $doping_users)){
			$ci->db->where('id', $order->uid)->update('users', array('search_point' => $user->search_point + point('doping')));
			$doping_users[] = $order->uid;
		}
	}

	
	$users = $ci->db->where('ugroup', 4)->from('users')->get()->result();
	foreach($users as $user)
	{
		$ci->db->where('id', $user->id)->update('users', array('search_point' => $user->search_point + point('advanced')));
	}
	
	$users = $ci->db->where('ugroup', 5)->from('users')->get()->result();
	foreach($users as $user)
	{
		$ci->db->where('id', $user->id)->update('users', array('search_point' => $user->search_point + point('premium')));
	}
	
	$users = $ci->db->where('discount10', 1)->from('users')->get()->result();
	foreach($users as $user)
	{
		$ci->db->where('id', $user->id)->update('users', array('search_point' => $user->search_point + point('student')));
	}	
	
}

function check_lesson_text()
{
	$ci=& get_instance();
	
	$response = false;
	
	if(is_teacher())
	$response = $ci->db->from('prices')->where('uid', $ci->session->userdata('user_id'))->where("title is NULL")->count_all_results();
	
	return $response;
}

function getip(){

 if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)){
 		if(strstr($_SERVER["HTTP_X_FORWARDED_FOR"], ',')){
	 		$ips = explode(',', $_SERVER["HTTP_X_FORWARDED_FOR"]);
	 		return trim($ips[0]);
 		} else {
        	return  $_SERVER["HTTP_X_FORWARDED_FOR"];  
        }
    }else if (array_key_exists('REMOTE_ADDR', $_SERVER)) { 
        return $_SERVER["REMOTE_ADDR"]; 
    }else if (array_key_exists('HTTP_CLIENT_IP', $_SERVER)) {
        return $_SERVER["HTTP_CLIENT_IP"]; 
    } 

    return '';
}

function find_seo_link_get_id($type = null, $value = null, $city = null){
    if(empty($type) || empty($value)) return null;
    
    $ci=& get_instance();
    $ci->load->model('locations_model');
    
    switch($type){
	    case 'city':
	    	if(stristr($value, '-') == TRUE)
	    	{
		    	$value = @array_shift(explode("-", $value));
	    	}
	    	$city = $ci->locations_model->get_location('locations_cities', ['seo_link' => $value]);
	    	return !empty($city->id) ? $city->id : null;		    	
	    break;

	    case 'town':
	    	if(stristr($value, "-") == TRUE){
		    	$value = substr(strstr($value,"-"), 1);	    	
		    	$town = $ci->locations_model->get_location('locations_towns', ['seo_link' => $value, 'city_id' => $city]);
		    	return !empty($town->id) ? $town->id : null;		    		    	
	    	} else {
		    	return null;		    		    	
	    	}
	    break;	
	    
	    case 'subject':
	    	$subject = $ci->db->from('contents_categories')->where('seo_link', $ci->db->escape_str($value))->get()->row();
	    	if(!empty($subject)){
	    		if($subject->parent_id == 6){
	    			return $subject->id;
	    		} else {
		    		$subject = $ci->db->from('contents_categories')->where('id', $subject->parent_id)->get()->row();		
		    		return $subject->id;
	    		}
	    	} else {
		    	return null;
	    	}
	    break;		 
	    
	    case 'level':
	    	$level = $ci->db->from('contents_categories')->where('seo_link', $ci->db->escape_str($value))->get()->row();
	    	if(!empty($level) && $level->parent_id > 6){
	    		return $level->id;
	    	} else {
		    	return null;
	    	}	    
	    break;		       	    
    }
}
function check_viewphones_ips($user_id = '')
{
	$ci=& get_instance();
	
	if(empty($user_id)) return false;
	
	$start_date = strtotime(date('Y-m-d') . ' 00:00:00');
	$end_date = strtotime(date('Y-m-d') . ' 23:59:59');
	$check = $ci->db->from('users_viewphones_ips')->where('ip', getip())->where("date >=", $start_date)->where("date <=", $end_date)->count_all_results();
	
	if($check >= 10) return false;
	
	return true;
}

function user_money($user_id = null)
{
	if(empty($user_id)) return false;
	
	$ci=& get_instance();
	
	$total_money = 0;
	
	$moneys = $ci->db->from('users_money')->where('uid', $user_id)->get()->result();
	if(!empty($moneys)){
		foreach($moneys as $money){
			if($money->type == 'earn'){
				$total_money += $money->money;
			} else {
				$total_money -= $money->money;
			}
		}
	}
	
	return $total_money;
}

function user_info($type='', $userId=''){
	if(empty($type) || empty($userId)) return false;
	
    $ci=& get_instance();
    
    $query = $ci->db->select($type)->from('users')->where('id', $userId)->limit(1)->get()->row();
    return !empty($query->$type) ? $query->$type : false;
    
}

function amp_url($url = '')
{
	$ci=& get_instance();
	
	$url = $url ? $url : current_url(true);
	
	$url = str_replace('&amp=1', '', $url);
	$url = str_replace('?amp=1', '', $url);
	
	return strstr($url, '?') == true ? $url . '&amp=1' : $url . '?amp=1';
}

function non_amp_url($url = '')
{
	$ci=& get_instance();
	
	$url = $url ? $url : current_url(true);

	$url = str_replace('&amp=1', '', $url);
	$url = str_replace('?amp=1', '', $url);
	
	return $url;
}

function truncate($data, $length){
	if(strlen($data) > $length){
		return mb_substr($data, 0, $length, 'UTF-8').'...';
	} else {
		return $data;
	}
}

function nicetime($unix_date)
{
    if(empty($unix_date)) {
        return "Belirsiz bir tarih";
    }
    
    $periods         = array("saniye", "dakika", "saat", "gün", "hafta", "ay", "yıl", "on 10");
    $lengths         = array("60","60","24","7","4.35","12","10");
    
    $now             = time();
    
    // check validity of date
    if(empty($unix_date)) {    
        return "Belirsiz bir tarih";
    }
	
    // is it future date or past date
    if($now > $unix_date) {    
        $difference     = $now - $unix_date;
        $tense         = "önce";
        
    } else {
        $difference     = $unix_date - $now;
        $tense         = "kaldı";
    }
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
        $difference /= $lengths[$j];
    }
    
    $difference = round($difference);
    
    if($difference != 1) {
        //$periods[$j].= "s";
    }
    
    return "$difference $periods[$j] {$tense}" == '0 saniye kaldı' ? '1 saniye önce' : "$difference $periods[$j] {$tense}";
}
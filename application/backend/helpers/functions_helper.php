<?php

/*
$GLOBALS['memcache'] = new Memcache;
$GLOBALS['memcache']->connect("127.0.0.1", 11211);
*/

$GLOBALS['settings_global'] = global_settings();

init_language();
init_admin();


$GLOBALS['settings_site'] = site_settings();

init_trash();

function mget($key)
{
	/*
	if($_SERVER['HTTP_HOST'] == 'localhost') return true;
	
	$memcache = new Memcache;
	$memcache->connect("127.0.0.1", 11211);	
	
	return $memcache->get($key);
	*/
	return false;
}

function mset($key, $value, $expire = 60)
{
	/*
	if($_SERVER['HTTP_HOST'] == 'localhost') return true;
	
	$memcache = new Memcache;
	$memcache->connect("127.0.0.1", 11211);	
	
	$memcache->set($key, $value, false, $expire);
	*/
	return false;	
}

function mdel($key)
{
	/*
	if($_SERVER['HTTP_HOST'] == 'localhost') return true;
	
	$memcache = new Memcache;
	$memcache->connect("127.0.0.1", 11211);	
	
	$memcache->delete($key);
	*/
	return false;	
}

function memcache_test()
{
	/*
	global $memcache;
	
	if($_SERVER['HTTP_HOST'] == 'localhost') return true;
	
	if($_SERVER['REMOTE_ADDR'] == '46.2.178.252'){
		$memcache->set('aaa', 'ttt', false, 60);
		
		echo $memcache->get('aaa');
		exit;
	}
	*/
	return false;		
}

function global_settings()
{
	$ci=& get_instance();
	$ci->load->database();
	$ci->load->library('session');
	
	$settings = $ci->db->from('settings_global')->get()->row();
	return $settings;
}


function site_settings()
{
	
	$ci=& get_instance();

	$settings = $ci->db->from('settings_site')
					->where('lang_code', $ci->session->userdata('descr_sl'))
					->limit(1)
					->get()->row();
	return $settings;
}

function init_language()
{
	$ci=& get_instance();

	$descr_sl = $ci->input->get_post('descr_sl');
	$admin_sl = $ci->input->get_post('admin_sl');

	foreach(site_languages() as $language){
		if($language->defaults == 'Y'){
			$def_lang = $language;	
		}
		$all_lang[$language->lang_code] = $language;
	}

	//Set describe language
	if(!$ci->session->userdata('descr_sl')){
		$ci->session->set_userdata(array('descr_sl' => $def_lang->lang_code));
	}
	
	if(isset($descr_sl) && !empty($all_lang[$descr_sl])){
		$ci->session->set_userdata(array('descr_sl' => $all_lang[$descr_sl]->lang_code));
	}

	define('DESCR_SL', $ci->session->userdata('descr_sl'));
	
	//Set admin language
	if(!$ci->session->userdata('admin_sl')){
		$default_admin_language = !empty($GLOBALS['settings_global']->default_admin_language) ? $GLOBALS['settings_global']->default_admin_language : $def_lang->lang_code;
		$ci->session->set_userdata(array('admin_sl' => $default_admin_language));
	}

	if(isset($admin_sl) && !empty($all_lang[$admin_sl])){
		$ci->session->set_userdata(array('admin_sl' => $all_lang[$admin_sl]->lang_code));
	}

	define('ADMIN_SL', $ci->session->userdata('admin_sl'));
}

function init_admin()
{
	$ci=& get_instance();
	
	if($ci->input->get_post('content_limit') && is_numeric($ci->input->get_post('content_limit'))){
		$ci->session->set_userdata(array('content_limit' => $ci->input->get_post('content_limit')));
	} else if(!$ci->session->userdata('content_limit')) {
		$ci->session->set_userdata(array('content_limit' => 20));
	}

	if(!$ci->session->userdata('user_id') && uri_string() != 'backend/users/login' && !strstr(uri_string(), 'backend/users/forgot')){
		f_redir(base_url('backend/users/login'), array(lang('PLEASE_LOG_IN')), '', '', true);
	}


	if($ci->session->userdata('user_id') && check_perm('admin_overview', true) == false){
		f_redir(site_url());
	}

	if($ci->session->userdata('user_id')){
		update_lastactive();
	}
	
}

function init_trash()
{
	$ci=& get_instance();
	
	if($ci->session->userdata('user_id')){
		$date = strtotime('-'.$GLOBALS['settings_global']->trash_delete.' day', time());
		if($GLOBALS['settings_global']->trash_delete > 0){
			$items = $ci->db->query("SELECT * FROM ".$ci->db->dbprefix('trash')." WHERE date < ".$date." ORDER BY date ASC")->result();
		} else {
			$items = $ci->db->from('trash')->order_by('date', 'ASC')->get()->result();
		}
	
		if(!empty($items)){
			foreach($items as $item){
				switch($item->module){
					case 'contents':
						include_once(APPPATH.'controllers/contents.php');
						$contents_class = new Contents();
						if(strstr($item->title, '||') == true){
							$item_ids = explode('||', $item->module_id);
							foreach($item_ids as $key => $id){
								$get_content_id = $ci->db->select('content_id, lang_code')->from('contents')->where('id', $id)->get()->row();
								$contents_class->deletelang($get_content_id->content_id, $get_content_id->lang_code, true);
							}
						} else {
							$get_content_id = $ci->db->select('content_id')->from('contents')->where('id', $item->id)->get()->row();
							$contents_class->deletelang($get_content_id->content_id, $item->lang_code, true);
						}					
					break;
					case 'contents_categories':
						include_once(APPPATH.'controllers/contents.php');
						$contents_class = new Contents();
						if(strstr($item->title, '||') == true){
							$item_ids = explode('||', $item->module_id);
							foreach($item_ids as $key => $id){
								$get_category_id = $ci->db->select('category_id, lang_code')->from('contents_categories')->where('id', $id)->get()->row();
								$contents_class->deletecategorylang($get_category_id->category_id, $get_category_id->lang_code, true);
							}
						} else {
							$get_category_id = $ci->db->select('category_id')->from('contents_categories')->where('id', $item->module_id)->get()->row();
							$contents_class->deletecategorylang($get_category_id->category_id, $item->lang_code, true);
						}
					break;
				}
				$ci->db->where('id', $item->id)->delete('trash');
			}
		}
	}
}

/*
* İstenilen dil değişkenini aktif olan dile göre select ederek return eder.
* Dil değişkenini bulamazsa başına ve sonuna # ekleyerek return olur.
* 
* $param	: gelen dil anahtarı
*/
function lang($param = ''){

	$ci =& get_instance();
	//eksik: productiona geçince cache queries i aktif et
	
	if(empty($param)) return false;

	$lang_key = $ci->db->query("SELECT lang_value FROM ".$ci->db->dbprefix('lang_keys')." WHERE lang_code = ? AND lang_key = ? LIMIT 1", array(ADMIN_SL, $param))->row();
	
	if(empty($lang_key->lang_value)){
		$check = $ci->db->query("SELECT lang_key FROM ".$ci->db->dbprefix('lang_keys_empties')." WHERE lang_key = ?", $param)->num_rows();
		if($check == 0){
			$ci->db->insert('lang_keys_empties', array('lang_key' => $param));
		}
		$key = "#".$param."#";
	} else {
		$key = $lang_key->lang_value;
	}
	
	return $key;
}

function admin_sl(){

    $ci=& get_instance();
	
	foreach(site_languages(true) as $language){
		$all_lang[$language->lang_code] = $language;
	}
	
	if(sizeof($all_lang) > 1){
		$main['name'] = $all_lang[ADMIN_SL]->name;
		$main['lang_code'] = $all_lang[ADMIN_SL]->lang_code;

        $out .= '<div class="pull-left m-r"><i class="flag flag-'.$main['lang_code'].'"></i> '.$main['name'].'</div>';
		foreach($all_lang as $key => $info){
			if($main['lang_code'] != $info->lang_code){
				$url = preg_replace('/[^(.*)]{1}+descr_sl=[^(.*)]{2}/', '', $url);
				$url = preg_replace('/[^(.*)]{1}+admin_sl=[^(.*)]{2}/', '', $url);
				$delimiter = strpos($url, '?') == FALSE ? "?" : "&";
				$delimiter = $delimiter == '&' && strstr(current_url(), '?admin_sl') == TRUE ? "?" : $delimiter;
				$info->link = $url.$delimiter.'admin_sl='.$info->lang_code;
				$out .= '<div class="pull-left m-r"><i class="flag flag-muted flag-'.$info->lang_code.'"></i> <a href="'.$info->link.'" class="text-muted">'.$info->name.'</a></div>';
			}
		}		
		return $out;
	} else {
		return false;
	}
}

function descr_sl(){

    $ci=& get_instance();

	foreach(site_languages(true) as $language){
		$all_lang[$language->lang_code] = $language;
	}
	
	if(sizeof($all_lang) > 1){
		$main['name'] = $all_lang[DESCR_SL]->name;
		$main['lang_code'] = $all_lang[DESCR_SL]->lang_code;
		$out .= '<div class="pull-left m-r"><i class="flag flag-'.$main['lang_code'].'"></i> '.$main['name'].'</div>';
		foreach($all_lang as $key => $info){
			if($main['lang_code'] != $info->lang_code){
				$url = preg_replace('/[^(.*)]{1}+descr_sl=[^(.*)]{2}/', '', $url);
				$url = preg_replace('/[^(.*)]{1}+admin_sl=[^(.*)]{2}/', '', $url);
				$delimiter = strpos($url, '?') == FALSE ? "?" : "&";
				$delimiter = $delimiter == '&' && strstr(current_url(), '?descr_sl') == TRUE ? "?" : $delimiter;
				$info->link = $url.$delimiter.'descr_sl='.$info->lang_code;
				$out .= '<div class="pull-left m-r"><i class="flag flag-muted flag-'.$info->lang_code.'"></i> <a href="'.$info->link.'" class="text-muted">'.$info->name.'</a></div>';
			}
		}

		return $out;
	} else {
		return false;
	}
}

function site_languages($onlyActive = false){

    $ci=& get_instance();
    
    if($onlyActive == true){
    	$query = $ci->db->query("SELECT * FROM ".$ci->db->dbprefix('languages')." WHERE status = ?", 'A')->result();
    } else {
		$query = $ci->db->query("SELECT * FROM ".$ci->db->dbprefix('languages'))->result();
	}
	return $query;
}

function f_redir($url, $message = array(), $meta_redirect = false, $delay = 0, $error = FALSE){

	$ci=& get_instance();

	if($error == TRUE){
		$ci->session->set_flashdata(array('error' => 1));
	}
		
	if(sizeof($message) > 0){
		$ci->session->set_flashdata(array('message' => $message));
	}

	if (!ob_get_contents() && !headers_sent() && !$meta_redirect) {
		header('Location: ' . $url);
		exit;
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

function pre()
{
	static $count = 0;
	$args = func_get_args();

	if (!empty($args) && $_SERVER['REMOTE_ADDR'] == '194.27.144.10') {
		echo '<ol style="font-family: Courier; font-size: 12px; border: 1px solid #dedede; background-color: #efefef; float: left; padding-right: 20px;">';
		foreach ($args as $k => $v) {
			$v = htmlspecialchars(print_r($v, true));
			if ($v == '') {
				$v = '    ';
		}

			echo '<li><pre>' . $v . "\n" . '</pre></li>';
		}
		echo '</ol><div style="clear:left;"></div>';
	}
	$count++;
}

// Kucuk harf
function txtLower($metin,$kod='UTF-8'){
   $ara = array('I');
   $deg = array('ı');
   $mtn = str_replace($ara,$deg,trim($metin));
   return mb_convert_case($mtn,MB_CASE_LOWER,$kod);
}

// Buyuk harf
function txtUpper($metin,$kod='UTF-8'){
   $ara = array('i');
   $deg = array('İ');
   $mtn = str_replace($ara,$deg,trim($metin));
   return mb_convert_case($mtn,MB_CASE_UPPER,$kod);
}

// Ilk harf buyuk
function txtFirstUpper($metin,$kod='UTF-8'){
   mb_internal_encoding($kod);
   $mtn = trim($metin);
   $bas = mb_substr(txtUpper($mtn,$kod),0,1);
   $son = mb_substr(txtLower($mtn,$kod),1);
   return $bas.$son;
} 

// Kelime buyuk
function txtWordUpper($metin,$kod='UTF-8'){
   $mtn = explode(' ',$metin);
   foreach($mtn as $no => $klm) if($klm) $snc[] = txtFirstUpper($klm,$kod);
   if(is_array($snc)) return implode(' ',$snc);
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
$onlyImage	: yalnizca resim yuklemesi icinse
*/
function myUpload($name, $tmp_name, $type, $size, $new_name, $target, $watermark, $width=600, $height=600, $resize=true, $onlyImage=false){

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
	
	if(in_array($type, $image_types) || @in_array($type, $document_types) && $onlyImage == false){
		move_uploaded_file($tmp_name, ROOTPATH . $target . $name);
	}
	
	if(in_array($type, $image_types))
	{
		$ci->load->library('upload');
		$handle = new Upload(ROOTPATH . $target . $name);
		
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

function create_seo_name($value, $database, $id = '', $column = '', $index = 0, $seo_arr = array()){
    
    $ci=& get_instance();
    
	if(!empty($id)){
		$query = $ci->db->query("SELECT seo_link FROM ".$ci->db->dbprefix($database)." WHERE {$column} = ? AND seo_link = ? AND lang_code = ?", array($id, seo($value), DESCR_SL))->row();
		
		if($query->seo_link){
			return $query->seo_link;
		} else {
			return create_seo_name($value, $database, $id = '', '', $index = 0);
		}
	} else {
		$value = seo($value);
		$val = isset($index) && $index > 0 ? $value.'-'.$index : $value;
		$exist = $ci->db->query("SELECT seo_link FROM ".$ci->db->dbprefix($database)." WHERE seo_link = ? AND lang_code = ?", array($val, DESCR_SL));
		if($exist->num_rows() > 0){
			if(!in_array(md5($val), $seo_arr)){ 
				$seo_arr[] = md5($val);
	            return create_seo_name($value, $database, $id, '', $exist->num_rows(), $seo_arr);
	       } else  {
	            return create_seo_name($value, $database, $id, '', $index+1, $seo_arr);
	       }
		} else {
			return $val;
		}
	}
}

function pagenav($total,$page,$perpage,$url) 
{

	$ci=& get_instance();

	$url = preg_replace('/[^(.*)]{1}+page=[^(.*)]/', '', $url);
	$arr_count = 0;
	$symb= strstr($url, "?") == TRUE ? '&' : '?';
	$total_pages = @ceil($total/$perpage);
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
	
	$out = '<ul class="pagination pagination-sm m-t-none m-b-none">';
	
	if ($page>1)
	{
		$out .= '<li><a href="'.$url.$symb.'page='.($page-1).'"><i class="fa fa-chevron-left"></i></a></li>';
		$arr_count++;

		if($page > 3){
			$out .= '<li><a href="'.$url.$symb.'page=1">1</a></li>';
			$arr_count++;
			
			$out .= '<li><a href="#">...</a></li>';
			$arr_count++;
		}
	}

	for ($x=$llimit;$x <= $rlimit;$x++) 
	{
		$active = ($ci->input->get('page') && $ci->input->get('page') == $x) || (!$ci->input->get('page') && 1 == $x) ? 'active' : 'inactive';
		$out .= '<li class="'.$active.'"><a href="'.$url.$symb.'page='.($x).'">'.$x.'</a></li>';
		$arr_count++;
	}
	
	if($page < $total_pages)
	{
		if($page < $total_pages - 2){
		$out .= '<li><a href="#">...</a></li>';
		$arr_count++;
		
		$out .= '<li><a href="'.$url.$symb.'page='.($total_pages).'">'.$total_pages.'</a></li>';
		$arr_count++;
		}
		
		$out .= '<li><a href="'.$url.$symb.'page='.($page+1).'"><i class="fa fa-chevron-right"></i></a></li>';
		$arr_count++;
	}
	
	return $out;
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
	$special_chars2[] = '';
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

function update_lastactive()
{
    $ci=& get_instance();
	
	if($ci->session->userdata('user_id'))
	{
		$user = $ci->db->query("SELECT ugroup, status FROM ".$ci->db->dbprefix('users')." WHERE id = ? LIMIT 1", $ci->session->userdata('user_id'))->row();
		
		if($user->status == 'B'){
			$ci->session->sess_destroy();
		} else {
			$data = array(
				'online' => 1,
				'lastactive' => time(),
				'ip' => $ci->input->ip_address()
			);
			$ci->db->where(array('id' => $ci->session->userdata('user_id')));
			$ci->db->update('users', $data);
		}
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

/*
	action: kullaniciya verilen izin adi
	returnType: TRUE ise ilgili dosyaya doner, islemi dosya yapar, FALSE ise login sayfasina yonlendirir
*/
function check_perm($action, $returnType = FALSE)
{
    $ci=& get_instance();

	if(!$ci->session->userdata('user_group') && $returnType == TRUE){
		return false;
	} else if(!$ci->session->userdata('user_group') && $returnType == FALSE){
		$ci->session->set_userdata(array('ref' => current_url()));
		f_redir(base_url('backend/users/login'));
	}
	
	$query = $ci->db->query("SELECT perm FROM ".$ci->db->dbprefix('users_permissions')." WHERE ugroup = ?", $ci->session->userdata('user_group'))->row();
	$elements = explode(",", $query->perm);
	$return = $query->perm != "All" && !in_array($action, $elements) ? FALSE : TRUE;
	if($return == FALSE && $returnType == TRUE){
		return FALSE;
	} else if($return == FALSE && $returnType == FALSE){
		exit(lang(NO_PERM).'. <a href="javascript:history.go(-1);return false;">'.lang(BACK).'</a>');
	} else {
		return TRUE;
	}
}

function extstres($content, $start, $end)
{
	if ((($content and $start) and $end))
	{
		$r = explode($start, $content);
		if (isset($r[1]))
		{
				$r = explode($end, $r[1]);
				return $r[0];
		}
		return '';
	}
}

function user_info($type='', $userId=''){
	if(empty($type) || empty($userId)) return false;
	
    $ci=& get_instance();
    
    $query = $ci->db->select($type)->from('users')->where('id', $userId)->limit(1)->get()->row();
    return !empty($query->$type) ? $query->$type : false;
    
}

 /************************************************
 * R $select: secilen kolon (where)
 * R $value: secilen value (where)
 * R $return: istenen kolon (select)
 * R $from: istenen tablo
 * O $lang_code: dil kodu
 * 
 * super_query('id', 1, 'title', 'contents_categories', 'tr');
 * contents_categories tablosunda, tr dilinde, id 1 olan select edilip, 
 * titlesi return oluyor
 *************************************************/
function super_query($select = '', $value = '', $return = '', $from = '', $lang_code = ''){
	if(empty($select) || empty($value) || empty($return) || empty($from)) return false;
	
    $ci=& get_instance();
    
    $ci->db->select($return)->where($select, $value);
    
    if($lang_code){
	    $ci->db->where('lang_code', $lang_code);
    }

    $query = $ci->db->from($from)->limit(1)->get()->row();
    
    return $query->$return;
}

function defval($newValue, $currentValue){
	return !empty($currentValue) ? $currentValue : $newValue;
}

function truncate($data, $length){
	if(strlen($data) > $length){
		return mb_substr($data, 0, $length, 'UTF-8').'...';
	} else {
		return $data;
	}
}

function captcha($param)
{
    $ci=& get_instance();
	
    $sayi1 = rand(1,5); // 1 ile 5 arasında rastgele bir sayı
    $sayi2 = rand(1,5); // 1 ile 5 arasında rastgele bir sayı

    $cevap = ($sayi1+$sayi2); // Sorumuzun cevabını buluyoruz
    $ci->session->set_userdata(array($param => $cevap)); // Sorumuzun cevabını sessiona atıyoruz

    return $sayi1." + ".$sayi2; // Sorumuzu ekrana bastırıyoruz
}

function areacodes(){
	return array('+90', '+93', '+355', '+213', '+1684', '+376', '+244', '+1264', '+672', '+1268', '+54', '+374', '+297', '+247', '+61', '+43', '+994', '+1242', '+973', '+880', '+1246', '+375', '+32', '+501', '+229', '+1441', '+975', '+591', '+387', '+267', '+55', '+1284', '+673', '+359', '+226', '+257', '+855', '+237', '+1', '+238', '+1345', '+236', '+235', '+56', '+86', '+53', '+61', '+57', '+269', '+242', '+682', '+506', '+225', '+385', '+53', '+599', '+357', '+420', '+45', '+246', '+253', '+1767', '+1809', '+670', '+56', '+593', '+20', '+503', '+240', '+291', '+372', '+251', '+500', '+298', '+679', '+358', '+33', '+596', '+594', '+689', '+241', '+220', '+995', '+49', '+233', '+350', '+30', '+299', '+1473', '+590', '+1671', '+502', '+224', '+245', '+592', '+509', '+504', '+852', '+36', '+354', '+91', '+62', '+98', '+964', '+353', '+972', '+39', '+1876', '+81', '+962', '+392', '+7', '+254', '+686', '+850', '+82', '+965', '+996', '+856', '+371', '+961', '+266', '+231', '+218', '+423', '+370', '+352', '+853', '+389', '+261', '+265', '+60', '+960', '+223', '+356', '+692', '+596', '+222', '+230', '+269', '+52', '+1808', '+373', '+377', '+976', '+382', '+1664', '+212', '+258', '+95', '+264', '+674', '+977', '+31', '+599', '+687', '+64', '+505', '+227', '+234', '+683', '+672', '+1670', '+47', '+968', '+92', '+680', '+507', '+595', '+51', '+63', '+48', '+351', '+1787', '+974', '+40', '+7', '+250', '+685', '+378', '+239', '+966', '+221', '+381', '+248', '+232', '+65', '+421', '+386', '+677', '+252', '+27', '+34', '+94', '+290', '+1869', '+1758', '+508', '+1784', '+249', '+597', '+268', '+46', '+41', '+963', '+886', '+992', '+255', '+66', '+670', '+228', '+690', '+1868', '+216', '+993', '+1649', '+688', '+256', '+380', '+971', '+44', '+1', '+598', '+1340', '+998', '+678', '+418', '+58', '+84', '+681', '+967', '+260', '+255', '+263');
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

function deleteDirectory( $dirname = false, $passive = false )
{
    if ( is_dir($dirname) )
    {
        $dir_handle = opendir($dirname);
    }
    
    if ( !$dir_handle )
    {
        return false;
    }
    
    // passive mode
    if ( $passive )
    {
        $empty = true;
        $file = readdir($dir_handle);
        
        while( $file = readdir($dir_handle) )
        {
            if ( $file != "." && $file != ".." )
            {
                $empty = false;
            }
        }
        
        if ( $empty )
        {
            rmdir($dirname);
        }
        
        return true;
        exit;
    }
    
    while( $file = readdir($dir_handle) )
    {
        if ( $file != "." && $file != ".." )
        {
            if ( !is_dir($dirname . '/' . $file) )
            {
                unlink($dirname . '/' . $file);
            }
            else
            {
                $this -> deleteDirectory($dirname . '/' . $file);
            }
        }
    }
    
    closedir($dir_handle);
    rmdir($dirname);
    
    return true;
}

/* kalıcı olarak silme işleminin doğru olmadığı
* düşünüldüğü için bu fonksiyon çalıştırılmadı
* çalıştırılsaydı login controllerinde fonksiyon
* çalıştırılıp, belli tarihten eski dataların kalıcı
* olarak silinmesi sağlanacaktı.
*/
function delete_trash()
{
	$ci=& get_instance();

	$settings = $ci->db->select('trash_delete')->from('settings_global')->get()->row();

	if($settings->trash_delete > 0){
		$gun_once = time() - $settings->trash_delete * 24 * 60 * 60;
		$items = $ci->db->from('trash')->where('date <', $gun_once)->get()->result();
		if(!empty($items)){
			foreach($items as $item){
				if($item->type == 'users'){

				}
			}
		}
	}
}

function delete_photo($module, $module_id)
{
	
	$ci=& get_instance();

	$photos = $ci->db->from('photos')->where(array('module_name' => $module, 'module_id' => $module_id))->get()->result();
	foreach($photos as $photo){
		$settings_photo = unserialize($GLOBALS['settings_global']->photo);
		if(!empty($settings_photo)){
			foreach($settings_photo as $versions){
				if(!empty($versions)){
					foreach($versions as $version => $value){
						@unlink(ROOTPATH . $photo->{$version});
					}
				}
			}
		}
		@unlink(ROOTPATH . $photo->original);		
		$ci->db->query("DELETE FROM ".$ci->db->dbprefix('photos')." WHERE id = ? LIMIT 1", $photo->id);
		
        $del_dir = explode('/', $photo->original);
        array_pop($del_dir);
        
        deleteDirectory(implode('/', $del_dir) . '/', true);
	}
}

function build_query( $data ) {
	if(function_exists('http_build_query')) {
		return http_build_query( $data );
	} else {
		return _http_build_query( $data, null, '&', '', false );
	}
}

// from php.net (modified by Mark Jaquith to behave like the native PHP5 function)
function _http_build_query($data, $prefix=null, $sep=null, $key='', $urlencode=true) {
	$ret = array();

	foreach ( (array) $data as $k => $v ) {
		if ( $urlencode)
			$k = urlencode($k);
		if ( is_int($k) && $prefix != null )
			$k = $prefix.$k;
		if ( !empty($key) )
			$k = $key . '%5B' . $k . '%5D';
		if ( $v === null )
			continue;
		elseif ( $v === FALSE )
			$v = '0';

		if ( is_array($v) || is_object($v) )
			array_push($ret,_http_build_query($v, '', $sep, $k, $urlencode));
		elseif ( $urlencode )
			array_push($ret, $k.'='.urlencode($v));
		else
			array_push($ret, $k.'='.$v);
	}

	if ( null === $sep )
		$sep = ini_get('arg_separator.output');

	return implode($sep, $ret);
}

function module_name($name = '')
{
	$modules = array(
		'contents' => lang('CONTENTS'),
		'contents_categories' => lang('CONTENTS_CATEGORIES'),
		'users' => lang('USERS')
	);
	
	return !empty($name) ? $modules[$name] : $modules;
}

/*
* Gelen $catId değerinin üst seviye kategorilerine ait istenen veriyi
* recursive olarak döner
*
* $catId 		: başlanılacak kategori id
* $type	 		: istenilen kolon ismi
* $found 		: result için gerekli array değeri
*/
function getSupElements($catId, $lang_code = '', $db_column, $type='parent_id', $found = array()) {

    $ci=& get_instance();
	
	if($catId > 0){
    	array_push ($found, $catId);
	}

	if($lang_code) $ci->db->where('lang_code', $lang_code);
	$result = $ci->db->select($type)->from($db_column)->where('id', $catId)->get()->result();
    
    if(sizeof($result) > 0){
        foreach($result as $row){
            $found = getSupElements($row->$type, $lang_code, $db_column, $type, $found);
        }
    }
    return $found;
}

/*
* Gelen $catId değerinin alt seviye kategorilerine ait istenen veriyi
* recursive olarak döner
*
* $catId 		: başlanılacak kategori id
* $type	 		: istenilen kolon ismi
* $found 		: result için gerekli array değeri
*/
function getSubElements($catId, $lang_code = '', $db_column, $type='id', $found = array()) {

    $ci=& get_instance();
    	
	if($catId > 0){
    	array_push ($found, $catId);
	}
	
	if($lang_code) $ci->db->where('lang_code', $lang_code);
	$result = $ci->db->select($type)->from($db_column)->where('parent_id', $catId)->get()->result();
	
	$result = empty($result) ? "empty" : $result;
	
    if(sizeof($result) > 0 && $result != 'empty'){
        foreach($result as $row){
			$found = getSubElements($row->$type, $lang_code, $db_column, $type, $found);
        }
    }
    
    return $found;
}

function parse_menu_link_value($link_type, $link_value, $lang_code = ''){

	$ci=& get_instance();
	
	if(($link_type == 'contents' || $link_type == 'contents_categories') && is_numeric($link_value)){
		if($lang_code){
			$ci->db->where('lang_code', $lang_code);
		}
		$q = $ci->db->from($link_type)->where('id', $link_value)->get()->row();
		return $q->title;
	} else {
		return $link_value;
	}
}

function gettag($object_type, $object_id, $lang_code = ''){

	$ci=& get_instance();
	
	if(empty($object_type) || empty($object_id)) return false;
		
	if($lang_code)
	$ci->db->where('lang_code', $lang_code);
	
	$tags = $ci->db
	->select('tags.name')
	->from('tags_relations')
	->join('tags', 'tags.id=tags_relations.tag_id')
	->where(
		array(
			'object_type' => $object_type,
			'object_id' => $object_id
		)
	)
	->get()->result();
	
	if(!empty($tags)){
		foreach($tags as $tag){
			$tags_array[] = $tag->name;
		}
	}
	return $tags_array ? json_encode($tags_array) : '';
}

function nicetotaltime($time, $showzero = true)
{
	$day = 1 * gmdate("z", $time);

	$hour = 1 * gmdate("H", $time);
	$minute = 1 * gmdate("i", $time);
	$second = 1 * gmdate("s", $time);
	
	if($showzero == true){
		return $day . ' ' . lang('DAY_S') . ' ' . $hour . ' ' . lang('HOUR_S') . ' ' . $minute . ' ' . lang('MINUTE_S') . ' ' . $second . ' ' . lang('SECOND_S');
	} else {
		$day = !empty($day) ? $day . ' ' . lang('DAY_S') . ' ' : '';
		$hour = !empty($hour) ? $hour . ' ' . lang('HOUR_S') . ' ' : '';
		$minute = !empty($minute) ? $minute . ' ' . lang('MINUTE_S') . ' ' : '';
		$second = !empty($second) ? $second . ' ' . lang('SECOND_S') . ' ' : '';
		return $day . $hour . $minute . $second;
	}
}

function category_info($type = '', $id = '', $column = '', $lang_code = ''){
	if(empty($type) || empty($id)) return false;
	
    $ci=& get_instance();
        
    if(!empty($column)){
    	$ci->db->select($column);
    }

    if(!empty($lang_code)){
    	$ci->db->where('lang_code', $lang_code);
    }
    
    if(!empty($id)){
    	$ci->db->where($type, $id);
    }    

    $query = $ci->db->from('contents_categories')->limit(1)->get()->row();
    
    if(empty($query)){
    	return false;
    }
    
    return empty($column) ? $query : $query->$column;
}

function prefix_array_key($prefix = '', $array = array())
{
	if(empty($prefix) || empty($array)) return false;
	
	$out = array();
	
	foreach ($array as $key => $val) {
	    $out[$prefix . $key] = $val;
	}
	
	return (object)$out;
}

function is_teacher($user_id = NULL)
{
	$ci=& get_instance();
	
	$teacher_group = array(3,4,5);
	
	if($user_id == NULL)
	{
		if(!$ci->session->userdata('user_id')) return false;
		if($ci->session->userdata('user_id') && in_array($ci->session->userdata('user_ugroup'), $teacher_group)) return true;
		
		return false;
	} else {
		$user = $ci->db->select('ugroup')->from('users')->where('id', $user_id)->get()->row();
		return in_array($user->ugroup, $teacher_group) ? true : false;
	}
}

function is_student($user_id = NULL)
{
	$ci=& get_instance();
	
	$student_group = array(2);

	if($user_id == NULL)
	{	
		if(!$ci->session->userdata('user_id')) return false;
		if($ci->session->userdata('user_id') && in_array($ci->session->userdata('user_ugroup'), $student_group)) return true;	
		return false;
	} else {
		$user = $ci->db->select('ugroup')->from('users')->where('id', $user_id)->get()->row();
		return in_array($user->ugroup, $student_group) ? true : false;		
	}	
}

function do_post_request($url, $data, $optional_headers = null,$getresponse = false) {
      $params = array('http' => array(
                   'method' => 'POST',
                   'content' => $data
                ));
      if ($optional_headers !== null) {
         $params['http']['header'] = $optional_headers;
      }
      $ctx = stream_context_create($params);
      $fp = @fopen($url, 'rb', false, $ctx);
      if (!$fp) {
        return false;
      }
      if ($getresponse){
        $response = stream_get_contents($fp);
        return $response;
      }
    return true;
}

function approval_comments(){
	$ci=& get_instance();
	return $ci->db->select('id')->from('comments')->where('status', 'W')->count_all_results();
}

function approval_photos(){
	$ci=& get_instance();
	return $ci->db->select('id')->from('users')->where('ugroup IN(3,4,5)')->where('photo_request !=', '')->count_all_results();
}

function approval_profiles(){
	$ci=& get_instance();
	return $ci->db->select('id')->from('users')->where('ugroup IN(3,4,5)')->where('status', 'S')->count_all_results();
}

function approval_badges(){
	$ci=& get_instance();
	return $ci->db->select('id')->from('users')->where('service_badge', 'W')->count_all_results();
}

function approval_prices_text(){
	$ci=& get_instance();
	return $ci->db->select('id')->from('prices')->where('status', 'W')->count_all_results();
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

function menu_data()
{
	$data = array(
		array(
			'name' 			=> '<i class="i i-file2 icon"></i> Talepler',
			'link' 			=> base_url('backend/requests'),
			'permission' 	=> 'requests_overview',
			'childrens' => array(
				array(
					'name' 			=> lang('OVERVIEW'),
					'link' 			=> base_url('backend/requests'),						
					'permission' 	=> 'requests_overview'
				), array(
					'name' 			=> 'Yeni Talep',
					'link' 			=> base_url('backend/requests/add'),						
					'permission' 	=> 'requests_add'
				), array(
					'name' 			=> 'Finansal Hareketler',
					'link' 			=> base_url('backend/requests/payments'),						
					'permission' 	=> 'requests_payments'
				)
			)			
		),
		array(
			'name' 			=> '<i class="i i-study icon"></i> ' . lang('LESSONS'),
			'link' 			=> base_url('backend/lessons'),
			'permission' 	=> 'lessons_overview',
			'childrens' => array(
				array(
					'name' 			=> lang('OVERVIEW'),
					'link' 			=> base_url('backend/lessons'),						
					'permission' 	=> 'lessons_overview'
				), array(
					'name' 			=> lang('LESSONS_CATEGORIES'),
					'link' 			=> base_url('backend/lessons/categories'),						
					'permission' 	=> 'lessons_overview'
				)
			)			
		),
		array(
			'name' 			=> '<i class="i i-stack2 icon"></i> ' . lang('CONTENTS'),
			'link' 			=> base_url('backend/contents'),
			'permission' 	=> 'contents_overview',
			'childrens' => array(
				array(
					'name' 			=> lang('OVERVIEW'),
					'link' 			=> base_url('backend/contents'),						
					'permission' 	=> 'contents_overview'
				), array(
					'name' 			=> lang('CONTENTS_CATEGORIES'),
					'link' 			=> base_url('backend/contents/categories'),						
					'permission' 	=> 'contents_overview'
				), array(
					'name' 			=> lang('CONTENTS_WORDS'),
					'link' 			=> base_url('backend/contents/words'),						
					'permission' 	=> 'contents_overview'
				)
			)			
		),		
		array(
			'name' 			=> '<i class="i i-menu2 icon"></i> ' . lang('MENUS'),
			'link' 			=> base_url('backend/menus'),
			'permission' 	=> 'menus_overview'
		),
		array(
			'name' 			=> '<i class="i i-mail icon"></i> ' . lang('FORMS'),
			'link' 			=> base_url('backend/forms'),
			'permission' 	=> 'forms_overview'
		),		
		array(
			'name' 			=> '<i class="i i-user2 icon"></i> ' . lang('USERS'),
			'link' 			=> base_url('backend/users'),
			'permission' 	=> 'users_overview',
			'childrens' => array(
				array(
					'name' 			=> lang('USERS_OVERVIEW'),
					'link' 			=> base_url('backend/users'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> lang('USERS_NEW'),
					'link' 			=> base_url('backend/users/add'),						
					'permission' 	=> 'users_add'
				), array(
					'name' 			=> lang('USERS_GROUPS'),
					'link' 			=> base_url('backend/users/groups'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Onay Bekleyen Fotoğraflar',
					'link' 			=> base_url('backend/users/pendingphotos'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Kullanıcı Mesajları',
					'link' 			=> base_url('backend/users/messages'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Kullanıcı Yorumları',
					'link' 			=> base_url('backend/users/comments'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> lang('USERS_POINTS'),
					'link' 			=> base_url('backend/users/points'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> lang('USERS_ACTIVITIES'),
					'link' 			=> base_url('backend/users/activities'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Telefonları Kontrol Et',
					'link' 			=> base_url('backend/users/phonescheck'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Ders Tanıtım Yazıları',
					'link' 			=> base_url('backend/users/prices_text'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Eğitmen Haritası',
					'link' 			=> base_url('backend/users/teachers'),						
					'permission' 	=> 'users_overview'
				), array(
					'name' 			=> 'Kullanıcı Fotoğrafları',
					'link' 			=> base_url('backend/users/showphotos'),						
					'permission' 	=> 'users_overview'
				)
			)
		),
		array(
			'name' 			=> '<i class="i i-cog2 icon"></i> ' . lang('SETTINGS'),
			'link' 			=> base_url('backend/settings'),
			'permission' 	=> 'settings_global_overview',
			'childrens' => array(
				array(
					'name' 			=> lang('SETTINGS_GLOBAL'),
					'link' 			=> base_url('backend/settings'),						
					'permission' 	=> 'settings_global_overview'
				), array(
					'name' 			=> lang('SETTINGS_SITE'),
					'link' 			=> base_url('backend/settings/site'),						
					'permission' 	=> 'settings_site_overview'
				), array(
					'name' 			=> lang('SETTINGS_WATERMARK'),
					'link' 			=> base_url('backend/settings/watermark'),						
					'permission' 	=> 'settings_watermark_overview'
				), array(
					'name' 			=> lang('TRASH'),
					'link' 			=> base_url('backend/settings/trash'),						
					'permission' 	=> 'settings_trash_overview'
				), array(
					'name' 			=> 'Ücretler',
					'link' 			=> base_url('backend/settings/prices'),						
					'permission' 	=> 'settings_prices_overview'
				), array(
					'name' 			=> 'Arama Terimleri',
					'link' 			=> base_url('backend/settings/search'),						
					'permission' 	=> 'settings_search_overview'
				)
			)
		),
		array(
			'name' 			=> '<i class="i i-domain3 icon"></i> ' . lang('LANGUAGES'),
			'link' 			=> base_url('backend/languages'),
			'permission' 	=> 'languages_overview',
			'childrens' => array(
				array(
					'name' 			=> lang('OVERVIEW'),
					'link' 			=> base_url('backend/languages'),						
					'permission' 	=> 'languages_overview'
				), array(
					'name' 			=> lang('LANGUAGES_IMPORT'),
					'link' 			=> base_url('backend/languages/import'),						
					'permission' 	=> 'languages_import'
				), array(
					'name' 			=> lang('LANGUAGES_PHRASES'),
					'link' 			=> base_url('backend/languages/editphrases'),						
					'permission' 	=> 'languages_phrases'
				), array(
					'name' 			=> lang('LANGUAGES_NEW_PHRASE'),
					'link' 			=> base_url('backend/languages/addphrase'),						
					'permission' 	=> 'languages_phrases'
				), array(
					'name' 			=> lang('LANGUAGES_EDIT_EMPTY_PHRASES'),
					'link' 			=> base_url('backend/languages/editemptyphrases'),						
					'permission' 	=> 'languages_phrases'
				)
			)
		),
		array(
			'name' 			=> '<i class="i i-pictures icon"></i> ' . lang('SLIDERS'),
			'link' 			=> base_url('backend/sliders'),
			'permission' 	=> 'sliders_overview'
		)
	);
	
	return $data;
}

function get_menu($type = '')
{
	$ci=& get_instance();
	
	$out = '';
	
	foreach(menu_data() as $menu)
	{
		if(check_perm($menu['permission'], TRUE) == TRUE)
		{
			$closeli = empty($menu['childrens']) ? '</li>'.PHP_EOL : '<ul>';
			if($type == 'mobile-menu'){
				$out .= '<li><span><a href="'.$menu['link'].'">'.$menu['name'].'</span></a>'.$closeli;
			} else {
				$selected = strstr($menu['link'], $ci->uri->segment(2)) == TRUE ? ' class="current"' : '';
				$out .= '<li'.$selected.'><a href="'.$menu['link'].'">'.$menu['name'].'</a>'.$closeli;
			}
			if(!empty($menu['childrens']))
			{
				foreach($menu['childrens'] as $children)
				{
					$childcount = 0;
					if(check_perm($children['permission'], TRUE) == TRUE)
					{
						$out .= '<li><a href="'.$children['link'].'">'.$children['name'].'</a></li>'.PHP_EOL;
						$childcount++;
					}
				}
				$out .= !empty($childcount) ? '</ul>'.PHP_EOL : '';
			}
			$out .= empty($closeli) ? '</li>'.PHP_EOL : '';
		}
	}
	
	return $out;
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

//price format
function format_price($price)
{	
	return number_format($price, 2, '.', '');
}
?>
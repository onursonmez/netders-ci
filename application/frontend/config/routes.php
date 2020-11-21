<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


require_once( BASEPATH .'database/DB.php' );
$db =& DB();

/*
$users = $db->select('username, username_old, id')->from('users')->where_in('ugroup', array(3,4,5))->where_in('status', ["A", "C"])->get()->result();
if(!empty($users)){
	foreach($users as $user){
		$route[$user->username] = 'users/view/'.$user->id;
		if(!empty($user->username_old))
		$route[$user->username_old] = 'users/view/'.$user->id;
	}
}


$prices_text = $db->select('id, uid, seo_link')->from('prices')->where_in('status', 'A')->get()->result();
if(!empty($prices_text)){
	foreach($prices_text as $text){
		$route[$text->seo_link] = 'users/view_price/'.$text->uid.'/'.$text->id;
	}
}
*/

$settings_global = $db->from('settings_global')->get()->row();

$categories = $db->select('category_id, seo_link, lang_code')->from('contents_categories')->where_not_in('category_id', explode(',', $settings_global->lesson_categories))->get()->result();

if(!empty($categories))
{
	foreach($categories as $value)
  {
		$route_value = $value->lang_code == $settings_global->default_language ? $value->seo_link : $value->lang_code.'/'.$value->seo_link;
		$route[$route_value] = 'contents/index/'.$value->category_id;
	}
}

$contents = $db->select('content_id, category_seo_link, seo_link, lang_code')->from('contents')->get()->result();

if(!empty($contents)){
	foreach($contents as $value){
		if($settings_global->content_link_type == 1 && !empty($value->category_seo_link)){
			$route_value = $value->lang_code == $settings_global->default_language ? $value->category_seo_link . '/' . $value->seo_link : $value->lang_code . '/' . $value->category_seo_link . '/' . $value->seo_link;
			$ext = $value->seo_link;
		} else {
			$route_value = $value->lang_code == $settings_global->default_language ? $value->seo_link : $value->lang_code.'/'.$value->seo_link;
			$ext = $value->seo_link;
		}
		$route[$route_value.'.html'] = 'contents/detail/'.$ext;
	}
}


$route['default_controller'] = "home";
$route['404_override'] = 'contents/page_404';
$route['forms'] = 'forms';

$route['fb'] = 'users/login_fb';
$route['giris'] = 'users/login';
$route['cikis'] = 'users/logout';
$route['kayit'] = 'users/register';
$route['sifremi-unuttum'] = 'users/forgot';
$route['aktivasyon'] = 'users/activation';
$route['aktivasyon-tekrar'] = 'users/activationresend';
$route['aktivasyon-diger'] = 'users/activationresendother';
$route['ozel-ders-ilani-vermek-istiyorum'] = 'users/register/1';
$route['ogrenci-olarak-kayit-olmak-istiyorum'] = 'users/register/2';
$route['ozel-ders-ilanlari-verenler'] = 'users/index';
$route['ozel-ders-ilanlari-verenler/(:any)'] = 'users/index/$1';
$route['ozel-ders-ilanlari-verenler/(:any)/(:any)'] = 'users/index/$1/$2';
$route['ozel-ders-ilanlari-verenler/(:any)/(:any)'] = 'users/index/$1/$2';

$route['messages'] = 'messages/index';
$route['messages/(:num)'] = 'messages/index/$1';
$route['messages/(:any)'] = 'messages/$1';

$route['api'] = 'api/index';
$route['api/(:any)'] = 'api/$1';

$route['ders-detay/(:any)'] = 'users/view_price/$1';

$route['(:any)'] = 'users/view/$1';

$route['translate_uri_dashes'] = FALSE;

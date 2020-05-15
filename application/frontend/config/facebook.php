<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['facebook_app_id']              = '1590771401140056';
$config['facebook_app_secret']          = '2741bd086a3ef47bbe8056bc74978d55';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = 'fb';
$config['facebook_logout_redirect_url'] = 'cikis';
$config['facebook_permissions']         = array('email,public_profile');
$config['facebook_graph_version']       = 'v2.10';
$config['facebook_auth_on_load']        = TRUE;
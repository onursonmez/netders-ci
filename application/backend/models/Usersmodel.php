<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usersmodel extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }
	
	public function userLogin($email='', $password=''){
		if(empty($email) || empty($password)){
			return false;
		}
		$query = $this->db->from('users')->where('email', $email)->where('password', md5(md5($password)))->get()->row();
		return $query;
	}
	
	public function get_user($where = array())
	{
		return $this->db->from('users')->where($where)->get()->row();
	}	
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locations_model extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }

	public function get_location($table = 'locations_cities', $where = [], $responseColumn = NULL)
	{	
		if(!empty($where))
		$this->db->where($where);
		
		$location = $this->db->from($table)->get()->row();
		
		return $responseColumn ? $location->$responseColumn : $location;
	}	
	
	public function get_locations($table = 'locations_cities', $where = [])
	{	
		if(!empty($where))
		$this->db->where($where);
		
		return $this->db->from($table)->get()->result();		
	}
	
	public function get_user_locations($user_id = NULL)
	{	
		$user_id = $user_id ? $user_id : $this->session->userdata('user_id');
		
		return $this->db
			->select('lo.*, ci.title city_title, to.title town_title')
			->from('locations lo')
			->join('locations_cities ci', 'ci.id=lo.city', 'left')
			->join('locations_towns to', 'to.id=lo.town', 'left')
			->where('lo.uid', (int)$user_id)
			->order_by('id')->get()->result();
	}
	
	public function insert_location($location_data = array())
	{
		if(empty($location_data)) return false;
		
		$this->db->where('town', $location_data['town']);

		$check = $this->db->from('locations')->where('city', $location_data['city'])->where('uid', $location_data['uid'])->get()->row();	
		
		return !empty($check) ? $this->db->where('id', $check->id)->update('locations', $location_data) : $this->db->insert('locations', $location_data);
	}
	
	public function delete_location($id)
	{
		if(empty($id)) return false;
		
		return $this->db->where('id', $id)->where('uid', $this->session->userdata('user_id'))->delete('locations');
	}		
}
?>
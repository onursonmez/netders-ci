<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Locationsmodel extends CI_Model {
	
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
		
}
?>
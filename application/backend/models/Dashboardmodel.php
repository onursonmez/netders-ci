<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboardModel extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }

	public function getUsersCount()
	{
		$queries[] = $GLOBALS['company']->id;
		$extra[] = 'cid = ?';
		
		$queries[] = 'D';
		$extra[] = 'status != ?';
		
		$extra = !empty($extra) ? "WHERE ".implode(" AND ", $extra) : "";
		return $this->db->query("SELECT id FROM ".PREFIX."users $extra", $queries)->num_rows();
	}

}
/*
return dbLeftRow('*', 'companies', 'l,d', "WHERE id = '1'", "LIMIT 1");
stdclass tipinde tum sonuclar
$q = $this->db->from('users')->get()->result();
//array tipinde tum sonuclar
$q = $this->db->from('users')->get()->result_array();
//stdclass tipinde 1 kullan&#305;c&#305; bilgileri
$q = $this->db->from('users')->get()->row();
//array tipinde 1 kullan&#305;c&#305; bilgileri
$q = $this->db->from('users')->get()->row_array();
//string toplam say&#305;s&#305;
$q = $this->db->from('users')->get()->num_rows();
//string kolon say&#305;s&#305;
$q = $this->db->from('users')->get()->num_fields();
//memoryi temizle
$q = $this->db->from('users')->get()->free_result();
*/
?>
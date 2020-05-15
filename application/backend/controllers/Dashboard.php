<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('dashboardmodel');
	}
	
	public function index()
	{
		$data = array();

		//egitmen telefon tiklamalari
		$grafik1 = $this->db
			->select("Date(FROM_UNIXTIME(date)) category, COUNT(id) value", FALSE)
			->group_by("Date(FROM_UNIXTIME(date))")
			->from("users_viewphones u")
			->where("FROM_UNIXTIME(date) >= CURDATE() - INTERVAL 1 MONTH")
			->order_by('date', 'asc')
			->get()->result();
		if(!empty($grafik1))
		{
			$categories = [];
			$values = [];
			foreach($grafik1 as $item)
			{
				$categories[] = substr(str_replace('-', '/', $item->category), 5,6);
				$values[] = $item->value;				
			}
			$data['grafik1'] = ['categories' => implode('","', $categories), 'values' => implode(',', $values)];
		}
		
		//egitmen uyelik sayilari
		$grafik2 = $this->db
			->select("Date(FROM_UNIXTIME(joined)) category, COUNT(id) value", FALSE)
			->group_by("Date(FROM_UNIXTIME(joined))")
			->from("users u")
			->where("FROM_UNIXTIME(joined) >= CURDATE() - INTERVAL 1 MONTH")
			->order_by('joined', 'asc')
			->get()->result();
		if(!empty($grafik2))
		{
			$categories = [];
			$values = [];
			foreach($grafik2 as $item)
			{
				$categories[] = substr(str_replace('-', '/', $item->category), 5,6);
				$values[] = $item->value;				
			}
			$data['grafik2'] = ['categories' => implode('","', $categories), 'values' => implode(',', $values)];
		}		
				
		$data['viewPage'] 	= $this->load->view('dashboard', $data, true);
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
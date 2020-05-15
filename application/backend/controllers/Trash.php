<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trash extends CI_Controller {

	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		check_perm('trash_overview');
		
		if(!empty($_REQUEST['keyword']))
		{
			$queries[] = '%'.$_REQUEST['keyword'].'%';
			$extra[] = "title LIKE ?";
			$search[] = "keyword=".urlencode($_REQUEST['keyword'])."";
		}
		
		if(!empty($_REQUEST['date_start']))
		{
			$startDate = @explode('.', $this->input->get_post('date_start', true));
			$startDate = @mktime(0,0,0,$startDate[1],$startDate[0],$startDate[2]);
			$queries[] = $startDate;
			$extra[] = "date >= ?";
			$search[] = "date_start=".urlencode($_REQUEST['date_start'])."";
		}
		
		if(!empty($_REQUEST['date_end']))
		{
			$endDate = @explode('.', $this->input->get_post('date_end', true));
			$endDate = @mktime(23,59,59,$endDate[1],$endDate[0],$endDate[2]);
			$queries[] = $endDate;
			$extra[] = "date <= ?";
			$search[] = "date_end=".urlencode($_REQUEST['date_end'])."";
		}
		
		if(!empty($_REQUEST['module']))
		{
			$queries[] = $_REQUEST['module'];
			$extra[] = "module = ?";
			$search[] = "module=".urlencode($_REQUEST['module'])."";
		}

		$extra = !empty($extra) ? "WHERE ".implode(" AND ", $extra) : "";
		
		$total = $this->db->query("SELECT id FROM ".PREFIX."trash $extra", $queries)->num_rows();
		
		$page = !$this->input->get('page') ? 1 : (int)$this->input->get('page', true);
		$limit = !empty($limit) ? $limit : (($page-1)*20).",20";
		
		$items = $this->db->query("SELECT * FROM ".PREFIX."trash $extra ORDER BY id DESC LIMIT $limit", $queries)->result();
		
		$search = sizeof($search) > 0 ? '?'.implode('&', $search) : "";
		$data['pages'] = pagenav($total,$page,20,current_url().$search);
		$data['items'] = $items;
		$data['viewPage'] = $this->load->view('trash/overview', $data, true);
		
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function restore($id)
	{	
		check_perm('trash_edit');
		
		$item = $this->db->query("SELECT * FROM ".PREFIX."trash WHERE id = ? ", array($id))->row();
		
		if(!empty($item->module)){
			switch($item->module){
				case 'contents':
				case 'contents_categories':
					$ids = explode('||', $item->module_id);
					foreach($ids as $i){
						$this->db->or_where(array('id' => $i));	
					}
					$this->db->update($item->module, array('status' => 'A'));
				break;
				
				case 'users':
					$this->db->where(array('id' => $item->module_id));
					$this->db->update(PREFIX.'users', array('status' => 'A'));
				break;

				case 'sliders':
					$this->db->where(array('id' => $item->module_id));
					$this->db->update(PREFIX.'sliders', array('status' => 'A'));
				break;
			}

			if($this->db->affected_rows()){
				$this->db->query("DELETE FROM ".PREFIX."trash WHERE id = ? LIMIT 1", array($id));
				$this->db->query("ALTER TABLE ".PREFIX."trash AUTO_INCREMENT = 1");
			}
		}
		
		f_redir(base_url('backend/trash'), array(lang('SUCCESS')));
	}

}
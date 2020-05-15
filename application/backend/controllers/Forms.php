<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends CI_Controller {
	
	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		check_perm('forms_overview');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{	
			$this->db->start_cache();
	
				if($this->input->get_post('sSearch')){
					$this->db->where('body REGEXP \'.*;s:[0-9]+:"'.$this->input->get_post('sSearch', true).'".*\' !=', 0);
					$this->db->or_where('ip', $this->input->get_post('sSearch', true));
				}
				
				$this->db->from('forms');
	
			$this->db->stop_cache();
			
			$this->db->select('id');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$data['items'] = $this->db->get()->result();

			$this->db->flush_cache();
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
				
		$data['viewPage'] = $this->load->view('forms/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function view($id){
		
		check_perm('forms_view');
		
		$data['item'] = $this->db->from('forms')->where('id', $id)->get()->row();
		
		if(!empty($data['item'])){
			$this->db->where('id', $id)->update('forms', array('readed' => 1));
		}
		
		$data['viewPage'] = $this->load->view('forms/view', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function delete($id)
	{
		check_perm('forms_delete');
		
		$this->db->where('id', $id)->delete('forms');
		$this->db->query("ALTER TABLE ".PREFIX."forms AUTO_INCREMENT = 1");

		f_redir(base_url('backend/forms'), array(lang('SUCCESS')));
	}
}
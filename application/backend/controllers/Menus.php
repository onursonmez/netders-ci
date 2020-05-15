<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus extends CI_Controller {

	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		check_perm('languages_overview');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete'))
			{
				foreach($this->input->post('delete') as $id => $value)
				{
					if($value == 'yes')
					{
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/menus'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
				
				if($this->input->get_post('sSearch')){
					$this->db->like('title', $this->input->get_post('sSearch', true));
				}
				
				if($this->input->get_post('sSearch_0')){
					$this->db->where('status', $this->input->get_post('sSearch_0'));
				}
				
				$this->db->from('menus');
	
			$this->db->stop_cache();
			
			$this->db->select('id');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();

			$this->db->flush_cache();
						
			foreach($items as $item){
				$item->status = $item->status == 'A' ? lang('ACTIVE') : lang('INACTIVE');
			}
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('menus/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function add(){
	
		check_perm('menus_add');
		
		if($this->input->post()){
						
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			$this->load->helper('string');
			$random_number = random_string('numeric', 9);

			foreach($post['lang'] as $lang_code => $language){
				if(!empty($language['title'])){
					$data = array(
					    'menu_id' => $random_number,
					    'title' => $language['title'],
					    'status' => $language['status'],
						'create_user' => $this->session->userdata('user_id'),
						'create_date' => strtotime($language['date'].' GMT+2'),
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					
					$this->db->insert(PREFIX.'menus', $data);
				}
			}
			$min = $this->db->select_min('id')->from('menus')->where(array('menu_id' => $random_number))->get()->row();
			
			$this->db->where(array('menu_id' => $random_number));
			$this->db->update(PREFIX.'menus', array('menu_id' => $min->id));

			f_redir(base_url('backend/menus/edit/'.$min->id), array(lang('SUCCESS')));
		}
		
		$data['viewPage'] = $this->load->view('menus/add', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
		
	public function edit($id){
	
		check_perm('menus_edit');
		
		if($this->input->post()){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			foreach($post['lang'] as $lang_code => $language)
			{	
				if(!empty($language['title']))
				{
					$is_exist = $this->db->query("SELECT 1 FROM ".PREFIX."menus WHERE menu_id = ? AND lang_code = ?", array($id, $lang_code))->num_rows();

					$data = array(
						'menu_id' => $id,
					    'title' => $language['title'],
					    'status' => $language['status'],
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					
					if($is_exist == 0){
						$data['create_user'] = $this->session->userdata('user_id');
						$this->db->insert(PREFIX.'menus', $data);
					} else {
						$data['update_user'] = $this->session->userdata('user_id');
						$data['up_date'] = time();
						$this->db->where(array('menu_id' => $id, 'lang_code' => $lang_code))->update(PREFIX.'menus', $data);
					}
				}
			}

			f_redir(base_url('backend/menus/edit/'.$id), array(lang('SUCCESS')));
		}
		
		$check_content_id_exist = $this->db->query("SELECT 1 FROM ".PREFIX."menus WHERE menu_id = ?", $id)->num_rows();
		if($check_content_id_exist == 0){
			f_redir(base_url('menus'));
		}
		
		foreach(site_languages(true) as $languages){
		$item[$languages->lang_code] = $this->db
					  ->from('menus')
					  ->where(array('menu_id' => $id, 'lang_code' => $languages->lang_code))
					  ->limit(1)
					  ->get()
					  ->row();			
		}
		
		$data['item'] = $item;
		$data['viewPage'] = $this->load->view('menus/add', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function delete($id){
		
		check_perm('menus_delete');
		
		$check = $this->db->from('menus')->where('id', $id)->get()->row();
		if(!empty($check)){
			$this->db->where(array('id' => $id))->update("menus", array('status' => 'D', 'update_user' => $this->session->userdata('user_id'), 'up_date' => time()));

			$data = array(
				'uid' => $this->session->userdata('user_id'),
				'title' => $check->title,
				'module' => 'menus',
				'module_id' => $id,
				'date' => time()
			);
			$this->db->insert('trash', $data);
		}
		f_redir(base_url('backend/menus'), array(lang('SUCCESS')));
	}
	
	public function items()
	{
		check_perm('menus_items');
		
		foreach(site_languages(true) as $language){
			$data['items'][$language->lang_code] = $this->_makenestableitems(0, $language->lang_code);
		}
		
		$data['viewPage'] = $this->load->view('menus/items', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function additem($menu_id = ''){
	
		check_perm('menus_items_add');
		
		if($this->input->post()){
						
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			$this->load->helper('string');
			$random_number = random_string('numeric', 9);
			
			foreach($post['lang'] as $lang_code => $language){
				$language['link_value'] = $language['link_type'] == 'contents' || $language['link_type'] == 'contents_categories' ? $language['link_id'] : $language['link_value'];
				if(!empty($language['title'])){
					$data = array(
						'menu_id' => $menu_id,
						'parent_id' => $language['parent_id'],
						'item_id' => $random_number,
					    'title' => $language['title'],
					    'link_type' => $language['link_type'],
					    'link_value' => $language['link_value'],
					    'status' => $language['status'],
					    'link_target' => $language['link_target'],
					    'css_class' => $language['css_class'],					    
						'create_user' => $this->session->userdata('user_id'),
						'create_date' => time(),
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					$this->db->insert(PREFIX.'menus_items', $data);
					
					$insert_id = $this->db->insert_id();
					
					$data = array(
						'id_path' => implode('/', array_reverse(getSupElements($insert_id, $lang_code, 'menus_items')))
					);
					$this->db->where('id', $insert_id)->update('menus_items', $data);
				}
			}

			$min = $this->db->select_min('id')->from('menus_items')->where(array('item_id' => $random_number))->get()->row();
			$this->db->where(array('item_id' => $random_number));
			$this->db->update(PREFIX.'menus_items', array('item_id' => $min->id));
			
			$data['success'] = true;
		}
		
		$data['items'] = $this->_getitemsrecursive(0);
		
		$data['viewPage'] = $this->load->view('menus/additem', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function edititem($menu_id, $item_id){
	
		check_perm('menus_items_edit');
		
		if($this->input->post()){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			foreach($post['lang'] as $lang_code => $language){
				
				if(!empty($language['title'])){
					$is_exist = $this->db->query("SELECT 1 FROM ".PREFIX."menus_items WHERE item_id = ? AND lang_code = ?", array($item_id, $lang_code))->num_rows();
					$language['link_value'] = $language['link_type'] == 'contents' || $language['link_type'] == 'contents_categories' ? $language['link_id'] : $language['link_value'];
					$data = array(
						'menu_id' => $menu_id,
						'item_id' => $item_id,
						'parent_id' => $language['parent_id'],
					    'title' => $language['title'],
					    'link_type' => $language['link_type'],
					    'link_value' => $language['link_value'],
					    'status' => $language['status'],
					    'link_target' => $language['link_target'],
					    'css_class' => $language['css_class'],					    
						'create_user' => $this->session->userdata('user_id'),
						'create_date' => time(),
						'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					
					if($is_exist == 0){
						$data['create_date'] = time();
						$data['create_user'] = $this->session->userdata('user_id');
						
						$this->db->insert(PREFIX.'menus_items', $data);
					
						$insert_id = $this->db->insert_id();
						
						$data = array(
							'id_path' => implode('/', array_reverse(getSupElements($insert_id, $lang_code, 'menus_items')))
						);
						$this->db->where('id', $insert_id)->update('menus_items', $data);						

					} else {
						$data['update_user'] = $this->session->userdata('user_id');
						$data['up_date'] = time();
						
						$this->db->where(array('id' => $language['id']))->update('menus_items', $data);
						
						$insert_id = $this->db->insert_id();
						
						$data = array(
							'id_path' => implode('/', array_reverse(getSupElements($language['id'], $lang_code, 'menus_items')))
						);
						$this->db->where('id', $insert_id)->update('menus_items', $data);							
					}
					
		
				}
			}
			
			f_redir(base_url('backend/menus/edititem/'.$menu_id.'/'.$item_id), array(lang('SUCCESS')));
		}
		
		$check_category_id_exist = $this->db->query("SELECT 1 FROM ".PREFIX."menus_items WHERE item_id = ?", $item_id)->num_rows();
		if($check_category_id_exist == 0){
			f_redir(base_url('backend/menus/items/'.$menu_id));
		}
		
		foreach(site_languages(true) as $languages){
		$i[$languages->lang_code] = $this->db
					  ->from('menus_items')
					  ->where(array('item_id' => $item_id, 'lang_code' => $languages->lang_code))
					  ->limit(1)
					  ->get()
					  ->row();			
		}
		
		$data['item'] = $i;
		
		$data['items'] = $this->_getitemsrecursive(0);
		
		$data['viewPage'] = $this->load->view('menus/additem', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function deleteitem($item_id, $lang_code, $redirect)
	{
		check_perm('menu_items_delete');
		
		if(!empty($lang_code)){
			$this->db->where('item_id', $item_id);
			$this->db->where('lang_code', $lang_code);
			$this->db->delete('menus_items');
		} else {
			$items = $this->db->from('menus_items')->where('item_id', $item_id)->get()->result();
			foreach($items as $item){
				$sub_elements = getSubElements($item->id, $item->lang_code, 'menus_items');
				foreach($sub_elements as $sub_element){
					$this->db->where('id', $sub_element);
					$this->db->delete('menus_items');
				}
				$this->db->where('item_id', $item_id);
				$this->db->delete('menus_items');				
			}
		}
		
		$redirect = $redirect . str_repeat('=', strlen($redirect) % 4);
		f_redir(base64_decode($redirect), array(lang('SUCCESS')));
	}
	
	public function updateitems(){
		if(check_perm('menus_items_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('items')){
			$jsonDecoded = json_decode($this->input->post('items'), true, 64);
			$readbleArray = $this->_updateitemsrecursive($jsonDecoded);
			$position = 10;
			foreach ($readbleArray as $key => $value) {
				if (is_array($value)) {
					$data = array(
						//'rang' => $key,
						'parent_id' => $value['parent_id'],
						'position' => $position
 					);
					$this->db->where('id', $value['id']);
					$this->db->update('menus_items', $data);
				}
				$position = $position + 10;
			}
		}			
		echo json_encode(lang('SUCCESS'));
	}

	public function autoComplete(){
		
		$type = $this->input->get('type', true);
		$term = $this->input->get('term', true);
		$language = $this->input->get('language', true);
		
		if($language){
			$this->db->where('lang_code', $language);
		}
		$query = $this->db->select('title, id')->from($type)->like('title', $term, 'both')->get()->result();	
		
		if(sizeof($query) > 0){
			foreach($query as $q){
				$res[] = array("text" => "$q->title", "id" => $q->id);
			}
		}
		echo json_encode($res);
	}

	public function _makenestableitems($parent_id = 0, $lang_code = '')
	{	
		if($lang_code){
			$this->db->where('lang_code', $lang_code);
		}
		$this->db->where('menu_id', $this->uri->segment(4));
		$this->db->where('parent_id', $parent_id);
		$this->db->from('menus_items');
		
		$items = $this->db->select('id, item_id, title, status, parent_id')->where('status !=', 'D')->order_by('position', 'ASC')->get()->result();
		
		if (!empty($items)) {
			$out .= "<ol class='dd-list'>";
				foreach($items as $item){
					$item->title = $item->status == 'A' ? $item->title : '<i class="text-muted">'.$item->title.'</i>';
					$out .= '
					<li class="dd-item dd3-item" data-id="'.$item->id.'">
					  <div class="dd-handle dd3-handle">&nbsp;</div><div class="dd3-content'.$grey.'">'.$item->title.'
						<div class="btn-group pull-right">
							<a href="'.base_url('backend/menus/additem/' . $this->uri->segment(4) . '/'.$item->id).'" class="btn btn-default btn-xs"><i class="fa fa-plus" data-toggle="tooltip" data-original-title="'.lang('ADD_SUB_ITEM').'"></i></a>
							<a href="'.base_url('backend/menus/edititem/' . $this->uri->segment(4) .'/'. $item->id).'" class="btn btn-default btn-xs"><i class="fa fa-pencil" data-toggle="tooltip" data-original-title="'.lang('EDIT').'"></i></a>
							<a onclick="confirmation(\''.lang('WARNING').'\', \'Menü öğesi kalıcı olarak silinecektir.\', \''.base_url('backend/menus/deleteitem/' . $item->item_id).'/0/'.rtrim(base64_encode(current_url()), '=').'\')" class="btn btn-default btn-trash btn-xs"><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="'.lang('DELETE').'"></i></a>
						</div>
					  </div>';
					$out .= $this->_makenestableitems($item->id);
					$out .= '</li>';
				}
			$out .= "</ol>";
		}
		
		return $out;
	}
	
	public function _getitemsrecursive($parent_id = 0, $delimiter = ''){
    	$elements = $this->db->from('menus_items')->where('parent_id', $parent_id)->get()->result();
	    $branch = array();
		
		$delimiter = '-';
		
	    foreach ($elements as $element) {
	        
	        $element->delimiter .= $delimiter;
	        $branch[] = $element;
	        
	        if ($element->parent_id == $parent_id) {
	            $children = $this->_getitemsrecursive($element->id, $delimiter);
	        }

            if ($children) {
                //$element->children = $children;
                foreach($children as $child){
                	$child->delimiter .= $delimiter;
                	$branch[] = $child;
                }
            }
	            	        
	    }
	
	    return $branch;
	}
	
	function _updateitemsrecursive($jsonArray, $parentID = 0){
	  $return = array();
	  foreach ($jsonArray as $subArray) {
		 $returnSubSubArray = array();
		 if (isset($subArray['children'])) {
		   $returnSubSubArray = $this->_updateitemsrecursive($subArray['children'], $subArray['id']);
		 }
		 $return[] = array('id' => $subArray['id'], 'parent_id' => $parentID);
		 $return = array_merge($return, $returnSubSubArray);
	  }

	  return $return;
	}		
}
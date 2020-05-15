<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {

	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		check_perm('settings_global_overview');

		if($this->input->get('proxytest') == 1)
		{
			$this->load->library('curl');							
			$proxy = $this->input->get('proxy') ? $this->input->get('proxy') : $GLOBALS['settings_global']->proxy;
			$this->curl->options(array(CURLOPT_TIMEOUT => 5));
			$this->curl->proxy(trim($proxy));
			$res = $this->curl->simple_get('http://www.vitargo.com.tr');
			echo $this->curl->error_string;							
			echo $res;
			exit;
		}
				
		if($this->input->post('form') || $this->input->post('photo'))
		{
			check_perm('settings_global_edit');
		}
		
		if($this->input->post('form'))
		{
			$form = $this->input->post('form', TRUE);
			
			foreach($form as $key => $value){
				if($key != 'site_languages'){
					$data[$key] = $value;
				}
			}

			$data['site_languages'] = sizeof($form['site_languages']) > 0 ? implode(",", $form['site_languages']) : "";
		}
		
		if($this->input->post('photo'))
		{	
			$photo = $this->input->post('photo', true);

			foreach($photo['versions'] as $name => $value)
			{
				if($name == 'new'){
					if(!empty($photo['versions']['new']['name'])){
						$photo['versions'][$value['name']] = $value;
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('photos')." ADD ".$value['name']." VARCHAR( 255 ) NOT NULL AFTER `original` ");
					}
					unset($photo['versions']['new']);
				}

				if($photo['versions'][$name]['delete'] == 1){
					$this->db->query("ALTER TABLE ".$this->db->dbprefix('photos')." DROP ".$value['name']);
					unset($photo['versions'][$name]);
				}
				
				unset($photo['versions'][$value['name']]['name']);
			}

			foreach($photo as $key => $value){
				if(empty($photo[$key])){
					unset($photo[$key]);
				}
			}
			if(is_array($photo['versions']) && empty($photo['versions'])){
				unset($photo['versions']);
			}
			
			if(!empty($photo))
			$data['photo'] = serialize($photo);
		}
		
		if($data)
		{
			$this->db->update('settings_global', $data);
			f_redir(base_url('backend/settings'), array(lang('SUCCESS')));			
		}

		$data['languages'] = site_languages(true);
		
		$item = $this->db->from('settings_global')->get()->row();
		
		if($item->site_languages)
		{
			$item->site_languages = explode(",", $item->site_languages);
		}
		
		if($item->photo)
		{
			$item->photo = unserialize($item->photo);
		}
		$data['item'] = $item;

		$data['viewPage'] = $this->load->view('settings/overview', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function site()
	{
	
		check_perm('settings_site_overview');
		
		if($this->input->post()){
			
			check_perm('settings_site_edit');

			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			foreach($post['lang'] as $lang_code => $language){
				
				$is_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('settings_site')." WHERE lang_code = ?", $lang_code)->num_rows();

				$data = array(
				    'seo_title' => $language['seo_title'],
				    'seo_description' => $language['seo_description'],
				    'seo_keyword' => $language['seo_keyword'],
				    'lang_code' => $lang_code
				);

				if($_FILES && $_FILES['lang']['size'][$lang_code]['logo'] < 1048576){ // 1mb
					$target = 'uploads/';
					
					$upload = myUpload(
						$_FILES['lang']['name'][$lang_code]['logo'], 
						$_FILES['lang']['tmp_name'][$lang_code]['logo'],
						$_FILES['lang']['type'][$lang_code]['logo'], 
						$_FILES['lang']['size'][$lang_code]['logo'], 
						'logo_'.$lang_code, /*new name*/ 
						$target, 
						'', 
						'',
						'',
						false,
						true
					);
					if($upload['response'] == true){
						$data['logo'] = $target . $upload['value'];
						if(!empty($post['lang'][$lang_code]['current_logo']) && $post['lang'][$lang_code]['current_logo'] != $data['logo']){
							@unlink(ROOTPATH . $post['lang'][$lang_code]['current_logo']);
						}						
					}
				}
				
				if($is_exist == 0){					
					$this->db->insert('settings_site', $data);
				} else {
					$this->db->where(array('lang_code' => $lang_code))->update('settings_site', $data);
				}
			}

			f_redir(base_url('backend/settings/site'), array(lang('SUCCESS')));
		}
		
		foreach(site_languages(true) as $languages){
		$item[$languages->lang_code] = $this->db
					  ->from('settings_site')
					  ->where(array('lang_code' => $languages->lang_code))
					  ->limit(1)
					  ->get()
					  ->row();			
		}
		
		$data['item'] = $item;
		$data['viewPage'] = $this->load->view('settings/site', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function watermark($action = '')
	{
		
		switch($action){
			case 'delete':
				check_perm('settings_watermark_delete');

				$settings_global = $this->db->select('watermark_image')->from('settings_global')->get()->row();
				@unlink(ROOTPATH . $settings_global->watermark_image);
		
				$this->db->update('settings_global', array('watermark_image' => ''));
				
				f_redir(base_url('backend/settings/watermark'), array(lang('SUCCESS')));
			break;
			
			default:
				check_perm('settings_watermark_edit');
				
				if($this->input->post('form')){
					
					$form = $this->input->post('form', TRUE);
					foreach($form as $key => $value){
						if($key != 'site_languages'){
							$data[$key] = $value;
						}
					}
								
					if($_FILES && $_FILES['watermark_image']['size'] < 1048576){ // 1mb
						$target = 'uploads/';
						
						$upload = myUpload(
							$_FILES['watermark_image']['name'], 
							$_FILES['watermark_image']['tmp_name'], 
							$_FILES['watermark_image']['type'], 
							$_FILES['watermark_image']['size'], 
							'watermark', /*new name*/
							$target, 
							'', 
							800,
							800,
							true,
							true
						);
						
						if($upload['response'] == true){
							if(!empty($form['current_watermark']) && $target.$upload['value'] != $form['current_watermark']){
								@unlink(ROOTPATH.$form['current_watermark']);
							}
							$data['watermark_image'] = $target.$upload['value'];
						}
					}
					
					//unset($data['current_watermark']);
					
					$this->db->update('settings_global', $data);
					
					f_redir(base_url('backend/settings/watermark'), array(lang('SUCCESS')));
				}
			break;
		}

		$data['item'] = $this->db->from('settings_global')->get()->row();
				
		$data['viewPage'] = $this->load->view('settings/watermark', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function trash($action = '', $id = '')
	{
		check_perm('trash_overview');
		
		switch($action){
			case 'restore':
				$item = $this->db->from('trash')->where('id', $id)->get()->row();
				if(!empty($item)){
					if(strstr($item->module_id, '||') == true){
						$item_ids = explode('||', $item->module_id);
						foreach($item_ids as $item_id){
							$this->db->where('id', $item_id)->update($item->module, array('status' => 'A'));
						}
					} else {
						$this->db->where('id', $item->module_id)->update($item->module, array('status' => 'A'));
					}
				}
				$this->db->where('id', $id)->delete('trash');
				f_redir(base_url('backend/settings/trash'), array(lang('SUCCESS')));
			break;
			
			default:
				$this->db->start_cache();
					
					if($this->input->get_post('sSearch')){
						$this->db->like('title', $this->input->get_post('sSearch', true));
					}
					
					$this->db->from('trash');
		
				$this->db->stop_cache();
				
				$this->db->select('id');
		
				$total = $this->db->count_all_results();
				
				if($this->input->get('sSortDir_0')){
					$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
					$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
				}
				
				$this->db->select('id, title, module, module_id, lang_code, date');
				
				$items = $this->db->get()->result();
						
				$this->db->flush_cache();
				
				foreach($items as $item){
					$out = '';
					$item->module_name = module_name($item->module);
					$item->nicetime = nicetime($item->date);
					if(strstr($item->title, '||') == true){
						$titles = explode('||', $item->title);
						$lang_codes = explode('||', $item->lang_code);
						foreach($titles as $key => $title){
							$out .=  '<span class="flag flag-'.$lang_codes[$key].'"></span> '.$title.'<br />';
						}
					} else {
						$out .=  '<span class="flag flag-'.$item->lang_code.'"></span> '.$item->title.'<br />';
					}
					$item->title = $out;
				}
				$data['items'] = $items;
				
				if($this->input->get()){
					echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items'], 'query' => $this->db->last_query()));
					exit;
				}
				
				$data['viewPage'] = $this->load->view('settings/trash', $data, true);
				
				$result	= $this->load->view($this->template, $data, true);
				$this->output->set_output($result);
			break;
		}
	}	
	
	public function prices()
	{
		check_perm('users_prices');
		
		if($this->input->post()){

			foreach($this->input->post('price') as $id => $value){
				$updatedata = array(
					'price' => $value,
				);	
				$this->db->where('id', $id)->update('settings_prices', $updatedata);				
			}
		}
		
		$items = $this->db->from('settings_prices')->get()->result();
		foreach($items as $item){
			$prices[$item->id] = $item;
		}
		$data['price'] = $prices;
		
		$data['viewPage'] = $this->load->view('settings/prices', $data, true);

		$result = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	

	public function search()
	{
		check_perm('settings_search_overview');
		
		if($this->input->post('form_name')){
			switch($this->input->post('form_name')){
				case 'new':
					if($this->input->post('keyword') && $this->input->post('cids')){
						$this->db->insert('settings_search', array
							(
							'uid' 			=> $this->session->userdata('user_id'), 
							'keyword' 		=> $this->input->post('keyword'), 
							'lesson_ids' 	=> $this->input->post('cids'), 
							'date' 			=> date("Y-m-d H:i:s"),
							'ip' 			=> $this->input->ip_address()
							)
						);
					}
				break;
				
				case 'update':
					foreach($this->input->post('keyword') as $id => $value){
						$update_data = array(
							'keyword' => $this->input->post('keyword')[$id],
							'lesson_ids' => $this->input->post('cids')[$id],
						);
						
						$this->db->where('id', $id)->update('settings_search', $update_data);
					}
				break;				
			}	
		}
		
		$data['items'] = $this->db->from('settings_search')->get()->result();
		if(!empty($data['items'])){
			foreach($data['items'] as $item){
				$item_ids = explode(',', $item->lesson_ids);
				$category_names = $this->db->from('contents_categories')->where_in('category_id', $item_ids)->get()->result();
				if(!empty($category_names)){
					$category_names_array = array();
					foreach($category_names as $category_name){
						$category_names_array[] = $category_name->title;
					}
					$item->category_name = implode(', ', $category_names_array);
				}
			}
		}
		
		$data['categories'] = $this->_makenestablecategoriescheckbox(6);
		
		$data['viewPage'] = $this->load->view('settings/search', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	
	
	public function _makenestablecategoriescheckbox($parent_id = 0, $content_id = '')
	{
		$this->db->where('parent_id', $parent_id);
		$this->db->from('contents_categories');
		
		$items = $this->db->select('id, category_id, title, parent_id')->order_by('id', 'ASC')->get()->result();
		
		if (!empty($items)) {
			if($content_id){
				$ids = super_query('content_id', $content_id, 'category', 'contents', 'tr');
			}
			
			$out .= "<ol class='dd-list'>";
				foreach($items as $item){
					$checked = @in_array($item->id, @explode(',', $ids)) ? 'checked' : '';
					echo @implode(',', $selected_ids);
					$out .= '
					<li class="dd-item">
					  <div class="dd-handle">'.$item->title.'
						<div class="pull-right"><label class="switch-small"><input type="checkbox" value="1" data-id="'.$item->id.'" data-title="'.$item->title.'" '.$checked.' /><span></span></label></div>
					  </div>';
					$out .= $this->_makenestablecategoriescheckbox($item->id, $content_id);
					$out .= '</li>';
				}
			$out .= "</ol>";
		}
		
		return $out;
	}	
	
}
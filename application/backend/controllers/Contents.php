<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contents extends CI_Controller {
	
	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('locationsmodel');
	}
	public function index()
	{
		check_perm('contents_overview');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete')){
				foreach($this->input->post('delete') as $id => $value){
					if($value == 'yes'){
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/contents'), array(lang('SUCCESS')));
			}
			
			$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
			
			$this->db->start_cache();
				
				$this->db->where('contents.lang_code', DESCR_SL);
				$this->db->where("contents_categories.category_id NOT IN(".implode(',', $sub_categories).")");
				
				if($this->input->get_post('sSearch')){
					$this->db->like('contents.title', $this->input->get_post('sSearch', true));
					$this->db->or_like('contents.description', $this->input->get_post('sSearch', true));
				}
				
				if($this->input->get_post('sSearch_0')){
					$this->db->where('contents.main_category', $this->input->get_post('sSearch_0', true));
				}				
				
				if($this->input->get_post('sSearch_1')){
					$this->db->where('contents.status', $this->input->get_post('sSearch_1'));
				} else {
					$this->db->where('contents.status !=', 'D');	
				}
				
				
				$this->db->from('contents');
				$this->db->join('contents_categories', 'contents.main_category=contents_categories.category_id');
	
			$this->db->stop_cache();
			
			$this->db->select('contents.id');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
			
			$this->db->select('contents.*');
			
			$items = $this->db->get()->result();

			$this->db->flush_cache();
						
			foreach($items as $item){
				/*
				$item_categories = array();
				if(!empty($item->category)){
					foreach(array_slice(explode(',', $item->category), 0, 3) as $category_id){
						$dot = sizeof(explode(',', $item->category)) > 3 ? ', ...' : '';
						$category = $this->db->select('title')->from('contents_categories')->where('id', $category_id)->get()->row();
						$item_categories[] = $category->title;
					}
					$item->category = implode(', ', $item_categories) . $dot;
				} else {
					$item->category = '<i class="text-muted">'.lang('N_A').'</i>';
				}
				*/
				$category = $this->db->select('title')->from('contents_categories')->where('id', $item->main_category)->get()->row();
				$item->main_category = $category->title;
				$item->status_name = $item->status == 'A' ? lang('ACTIVE') : lang('INACTIVE');
			}
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		$data['categories_selectbox'] = $this->_getcategoriesrecursive(0, '', $sub_categories);
		
		$data['viewPage'] = $this->load->view('contents/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function add(){
		
		check_perm('contents_add');
		
		if($this->input->post()){

			$this->load->helper('string');
			$random_number = random_string('numeric', 9);

			foreach($this->input->post('lang') as $lang_code => $language){
				if(!empty($language['title'])){
					$end_date = !empty($language['end']) ? strtotime($language['end']) : '';
					$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents") : create_seo_name($language['title'], "contents");												
					
					$data = array(
						'content_id' => $random_number,
				    	'main_category' => $language['main_category'],
				    	'category' => $language['cids'],
					    'title' => $language['title'],
					    'description' => $language['description'],
					    'status' => $language['status'],
						'create_user' => $this->session->userdata('user_id'),
						'start_date' => strtotime($language['date']),
					    'end_date' => (int)$end_date,
					    'template_content' => $language['template_content'],
					    'portfoy_sektor' => $language['portfoy_sektor'],
					    'portfoy_url' => $language['portfoy_url'],
					    'category_seo_link' => category_info('category_id', $language['main_category'], 'seo_link', $lang_code),
					    'seo_link' => $seo_link,
					    'seo_title' => $language['seo_title'],
					    'seo_description' => $language['seo_description'],
					    'seo_keyword' => $language['seo_keyword'],
					    'lesson_top_text' => $language['lesson_top_text'],
					    'lesson_url' => $language['lesson_url'],
					    'city' => $language['city'],
					    'keyword' => $language['keyword'],
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					
					$this->db->insert('contents', $data);
				}
			}
			$min = $this->db->select_min('id')->from('contents')->where(array('content_id' => $random_number))->get()->row();
			
			$this->db->where(array('content_id' => $random_number));
			$this->db->update('contents', array('content_id' => $min->id));

			if($this->input->post('hidden-lang')){
				foreach($this->input->post('hidden-lang') as $hidden_lang_code => $hidden_value){
					$check = $this->db->from('contents')->where('content_id', $min->id)->where('lang_code', $hidden_lang_code)->count_all_results();
					if(!empty($check)){
						$this->_tags_insert('contents', $hidden_value['tags'], $min->id, $hidden_lang_code);
					}
				}
			}
			
			mdel('netders_contents');
			
			//f_redir(base_url('backend/contents/edit/'.$min->id.'/#images'), array(lang('SUCCESS')));
			f_redir(base_url('backend/contents/add'), array(lang('SUCCESS')));
		}
		
		foreach(site_languages(true) as $language){
			$data['categories'][$language->lang_code] = $this->_makenestablecategoriescheckbox(0, $language->lang_code);
		}
		
		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		$data['categories_selectbox'] = $this->_getcategoriesrecursive(0, '', $sub_categories);
		
		//$data['categories_selectbox2'] = $this->_getcategoriesrecursive(6, '', $sub_categories, 'in');

		$data['cities'] = $this->locationsmodel->get_locations('locations_cities', ['status' => 'A']);
		
		$data['viewPage'] = $this->load->view('contents/add', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function update_category_seo_links(){
		$all = $this->db->select('id, main_category, lang_code')->from('contents')->get()->result();
		foreach($all as $c){
			$cinfo = category_info('category_id', $c->main_category, 'seo_link', $c->lang_code) ? category_info('category_id', $c->main_category, 'seo_link', $c->lang_code) : NULL;
			$data =	array(
				'category_seo_link' => $cinfo
			);
			$this->db->where('id', $c->id)->update('contents', $data);
			//echo $this->db->last_query();
		}
	}
	
	
	public function edit($content_id){
	
		check_perm('contents_edit');
		
		if($this->input->post()){
			
			foreach($this->input->post('lang') as $lang_code => $language){
						
				if(!empty($language['title'])){
					$end_date = !empty($language['end']) ? strtotime($language['end']) : '';
					$is_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('contents')." WHERE content_id = ? AND lang_code = ?", array($content_id, $lang_code))->num_rows();
					if($is_exist == 0){
						$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents") : create_seo_name($language['title'], "contents");												
					} else {
						$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents", $content_id, 'content_id') : create_seo_name($language['title'], "contents", $content_id, 'content_id');					
					}
					
					$data = array(
						'content_id' => $content_id,
						'main_category' => $language['main_category'],
				    	'category' => $language['cids'],
					    'title' => $language['title'],
					    'description' => $language['description'],
					    'status' => $language['status'],
					    'start_date' => strtotime($language['date']),
					    'end_date' => (int)$end_date,
					    'template_content' => $language['template_content'],
					    'portfoy_sektor' => $language['portfoy_sektor'],
					    'portfoy_url' => $language['portfoy_url'],					    
					    'category_seo_link' => category_info('category_id', $language['main_category'], 'seo_link', $lang_code),
					    'seo_link' => $seo_link,
					    'seo_title' => $language['seo_title'],
					    'seo_description' => $language['seo_description'],
					    'seo_keyword' => $language['seo_keyword'],
					    'lesson_top_text' => $language['lesson_top_text'],
					    'lesson_url' => $language['lesson_url'],
					    'city' => $language['city'],
					    'keyword' => $language['keyword'],					    					    
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					
					if($is_exist == 0){
						$data['create_user'] = $this->session->userdata('user_id');
						
						$this->db->insert('contents', $data);
					} else {
						$data['update_user'] = $this->session->userdata('user_id');
						$data['up_date'] = time();
						
						$this->db->where(array('content_id' => $content_id, 'lang_code' => $lang_code))->update('contents', $data);
						
						mdel('netders_contents');
					}
	
					if($this->input->post('hidden-lang')){
						foreach($this->input->post('hidden-lang') as $hidden_lang_code => $hidden_value){
							$check = $this->db->from('contents')->where('content_id', $content_id)->where('lang_code', $hidden_lang_code)->count_all_results();
							if(!empty($check)){
								$this->_tags_insert('contents', $hidden_value['tags'], $content_id, $hidden_lang_code);
							}
						}
					}

				}
			}
			
			$hash = $this->input->post('hash') ? '#'.$this->input->post('hash') : '';
			f_redir(base_url('backend/contents/edit/'.$content_id.$hash), array(lang('SUCCESS')));
		}
		
		$check_content_id_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('contents')." WHERE content_id = ?", $content_id)->num_rows();
		if($check_content_id_exist == 0){
			f_redir(base_url('backend/contents'));
		}
		
		foreach(site_languages(true) as $languages)
		{
			$item[$languages->lang_code] = $this->db
			->from('contents')
			->where(array('content_id' => $content_id, 'lang_code' => $languages->lang_code))
			->limit(1)
			->get()
			->row();
		}
		
		$data['item'] = $item;
		
		foreach(site_languages(true) as $language){
			$data['categories'][$language->lang_code] = $this->_makenestablecategoriescheckbox(0, $language->lang_code, $content_id);
		}
		
		$data['cities'] = $this->locationsmodel->get_locations('locations_cities', ['status' => 'A']);
		
		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		$data['categories_selectbox'] = $this->_getcategoriesrecursive(0, '', $sub_categories);
		
		$data['viewPage'] = $this->load->view('contents/add', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function update()
	{
		if(check_perm('contents_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('order')){
			
			$i = 10;
			
			foreach ($this->input->post('order') as $id)
			{
				if(!empty($id))
				{
					$data = array(
						'position' => $i,
					);
					$this->db->where(array('id' => $id))->update('contents', $data);
				}
				$i = $i + 10;
			}
		}
		echo json_encode(lang('SUCCESS'));
	}
	
	public function delete($content_id)
	{
		check_perm('contents_delete');
		
		$contents = $this->db->query("SELECT title, id, content_id, lang_code FROM ".$this->db->dbprefix('contents')." WHERE content_id = ?", array($content_id))->result();
		
		switch($GLOBALS['settings_global']->content_delete_type){
			case 1: //delete content
				foreach($contents as $content)
				{					
					$this->db->where('id', $content->id)->delete('contents');
					$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents')." AUTO_INCREMENT = 1");
					$photos = $this->db->from('photos')->where('module_name', 'contents')->where('module_id', $content->id)->get()->result();
					if(!empty($photos)){
						foreach($photos as $photo){
							@unlink(ROOTPATH . $photo->photo);
							@unlink(ROOTPATH . $photo->thumbnail);
							@unlink(ROOTPATH . $photo->original);
							$this->db->where('id', $photo->id)->delete('photos');
						}
					}
				}
			break;
			
			case 2: //move to trash content
				
				foreach($contents as $content){
					$ids[] = $content->id;
					$titles[] = $content->title;
					$lang_codes[] = $content->lang_code;
				}
				$insert_content_data = array(
					'uid' => $this->session->userdata('user_id'),
					'title' => implode('||', $titles),
					'module' => 'contents',
					'module_id' => implode('||', $ids),
					'date' => time() + 60,
					'lang_code' => implode('||', $lang_codes)
				);
				$this->db->insert('trash', $insert_content_data);
				
				$this->db->where('content_id', $content_id)->update('contents', array('status' => 'D'));
			break;
		}
		
		mdel('netders_contents');
		
		f_redir(base_url('backend/contents'), array(lang('SUCCESS')));
	}
	
	public function deletelang($content_id, $lang_code, $always_delete = false)
	{
		check_perm('contents_delete');
		
		$contents = $this->db->query("SELECT title, content_id, id, lang_code FROM ".$this->db->dbprefix('contents')." WHERE content_id = ? AND lang_code = ?", array($content_id, $lang_code))->result();

		if($always_delete == false && empty($contents)) f_redir(base_url('backend/contents'), array(lang('SUCCESS')));

		if($always_delete == true){
			$GLOBALS['settings_global']->content_delete_type = 1;
		}
				
		switch($GLOBALS['settings_global']->content_delete_type){
			case 1: //delete content				
				foreach($contents as $content)
				{
					//update content_id: check other languages but not id this content
					if($other_languages_contents_success != $content->content_id){
						$check_other_languages_contents = $this->db->from('contents')->where('content_id', $content->content_id)->where('id !=', $content->id)->get()->result();
						if($check_other_languages_contents){
							foreach($check_other_languages_contents as $other_contents){
								$this->db->where('content_id', $content->content_id)->update('contents', array('content_id' => $check_other_languages_contents[0]->id));
							}
						}
						$other_languages_contents_success = $content->content_id;
					}

					$this->db->where('id', $content->id)->delete('contents');
					$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents')." AUTO_INCREMENT = 1");
					$photos = $this->db->from('photos')->where('module_name', 'contents')->where('module_id', $content->id)->get()->result();
					if(!empty($photos)){
						foreach($photos as $photo){
							@unlink(ROOTPATH . $photo->photo);
							@unlink(ROOTPATH . $photo->thumbnail);
							@unlink(ROOTPATH . $photo->original);
							$this->db->where('id', $photo->id)->delete('photos');
						}
					}
				}
			break;
			
			case 2: //move to trash content
				
				foreach($contents as $content){
					$ids[] = $content->id;
					$titles[] = $content->title;
					$lang_codes[] = $content->lang_code;
				}
				$insert_content_data = array(
					'uid' => $this->session->userdata('user_id'),
					'title' => implode('||', $titles),
					'module' => 'contents',
					'module_id' => implode('||', $ids),
					'date' => time() + 60,
					'lang_code' => implode('||', $lang_codes)
				);
				$this->db->insert('trash', $insert_content_data);
				
				$this->db->where('content_id', $content_id)->update('contents', array('status' => 'D'));
			break;
		}
		
		mdel('netders_contents');
		
		if($always_delete == false) f_redir(base_url('backend/contents'), array(lang('SUCCESS')));
	}
	
	public function categories()
	{
		check_perm('contents_categories_overview');
		
		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		
		foreach(site_languages(true) as $language){
			$data['items'][$language->lang_code] = $this->_makenestablecategories(0, $language->lang_code, $sub_categories);
		}
		
		$data['viewPage'] = $this->load->view('contents/categories', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function _makenestablecategories($parent_id = 0, $lang_code = '', $only_this_categories = '')
	{	
		if($lang_code){
			$this->db->where('lang_code', $lang_code);
		}
		
		if($only_this_categories){
			$this->db->where("category_id NOT IN(".implode(',', $only_this_categories).")");
		}
		
		$this->db->where('parent_id', $parent_id);
		$this->db->from('contents_categories');
		
		$items = $this->db->select('id, category_id, title, status, parent_id')->where('status !=', 'D')->order_by('id', 'ASC')->get()->result();
		
		if (!empty($items)) {
			$category_delete_title = $GLOBALS['settings_global']->category_delete_type == 1 ? lang('DELETE_CONTENT_TEXT') : lang('TRASH_CONTENT_TEXT');
			$out .= "<ol class='dd-list'>";
				foreach($items as $item){
					$item->title = $item->status == 'A' ? $item->title : '<i class="text-muted">'.$item->title.'</i>';
					$out .= '
					<li class="dd-item dd3-item" data-id="'.$item->id.'">
					  <div class="dd-handle dd3-handle">&nbsp;</div><div class="dd3-content'.$grey.'">'.$item->title.'
						<div class="btn-group pull-right">
							<a href="'.base_url('backend/contents/editcategory/' . $item->category_id).'" class="btn btn-default btn-xs"><i class="fa fa-pencil" data-toggle="tooltip" data-original-title="Düzenle"></i></a>
							<a onclick="confirmation(\''.lang('WARNING').'\', \''.$category_delete_title.'\', \''.base_url('backend/contents/deletecategory/' . $item->category_id).'\')" class="btn btn-default btn-xs"><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Sil"></i></a>
						</div>
					  </div>';
					$out .= $this->_makenestablecategories($item->id, $lang_code, $only_this_categories);
					$out .= '</li>';
				}
			$out .= "</ol>";
		}
		
		return $out;
	}
	
	public function _makenestablecategoriescheckbox($parent_id = 0, $lang_code = '', $content_id = '')
	{
		if($lang_code){
			$this->db->where('lang_code', $lang_code);
		}
		$this->db->where('parent_id', $parent_id);
		$this->db->from('contents_categories');
		
		$items = $this->db->select('id, category_id, title, parent_id')->order_by('id', 'ASC')->get()->result();
		
		if (!empty($items)) {
			if($content_id){
				$ids = super_query('content_id', $content_id, 'category', 'contents', $lang_code);
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
					$out .= $this->_makenestablecategoriescheckbox($item->id, $lang_code, $content_id);
					$out .= '</li>';
				}
			$out .= "</ol>";
		}
		
		return $out;
	}

	public function addcategory(){
	
		check_perm('contents_categories_add');
		
		if($this->input->post()){
						
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			$this->load->helper('string');
			$random_number = random_string('numeric', 9);

			foreach($post['lang'] as $lang_code => $language){
				if(!empty($language['title'])){
					$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents_categories") : create_seo_name($language['title'], "contents_categories");												
					$data = array(
						'parent_id' => $language['parent_id'],
						'category_id' => $random_number,
					    'title' => $language['title'],
					    'description' => $language['description'],
					    'status' => $language['status'],
					    'template_category' => $language['template_category'],
					    'template_content' => $language['template_content'],
						'create_user' => $this->session->userdata('user_id'),
						'create_date' => time(),
					    'seo_link' => $seo_link,
					    'seo_title' => $language['seo_title'],
					    'seo_description' => $language['seo_description'],
					    'seo_keyword' => $language['seo_keyword'],
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					$this->db->insert('contents_categories', $data);

					$insert_id = $this->db->insert_id();
					
					$data = array(
						'id_path' => implode('/', array_reverse(getSupElements($insert_id, $lang_code, 'contents_categories')))
					);
					$this->db->where('id', $insert_id)->update('contents_categories', $data);
				}
			}

			$min = $this->db->select_min('id')->from('contents_categories')->where(array('category_id' => $random_number))->get()->row();
			$this->db->where(array('category_id' => $random_number));
			$this->db->update('contents_categories', array('category_id' => $min->id));
			
			//f_redir(base_url('backend/contents/addcategory/'.$min->id), array(lang('SUCCESS')));
			$data['success'] = true;
			
			mdel('netders_categories');
		}
		
		
		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		$data['categories'] = $this->_getcategoriesrecursive(0, '', $sub_categories);
		
		$data['viewPage'] = $this->load->view('contents/addcategory', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function editcategory($id){
	
		check_perm('contents_categories_edit');
		
		if($this->input->post()){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			foreach($post['lang'] as $lang_code => $language){
				
				if(!empty($language['title'])){
					$is_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('contents_categories')." WHERE category_id = ? AND lang_code = ?", array($id, $lang_code))->num_rows();
					if($is_exist == 0){
						$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents_categories") : create_seo_name($language['title'], "contents_categories");												
					} else {
						$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents_categories", $language['id'], 'id') : create_seo_name($language['title'], "contents_categories", $language['id'], 'id');					
					}
					$data = array(
						'parent_id' => $language['parent_id'],
						'category_id' => $id,
					    'title' => $language['title'],
					    'description' => $language['description'],
					    'status' => $language['status'],
					    'template_category' => $language['template_category'],
					    'template_content' => $language['template_content'],
					    'seo_link' => $seo_link,
					    'seo_title' => $language['seo_title'],
					    'seo_description' => $language['seo_description'],
					    'seo_keyword' => $language['seo_keyword'],
					    'lang_code' => $lang_code,
					    'ip' => $this->input->ip_address()
					);
					
					if($is_exist == 0){
						$data['create_date'] = time();
						$data['create_user'] = $this->session->userdata('user_id');
						
						$this->db->insert('contents_categories', $data);
					} else {
						$data['update_user'] = $this->session->userdata('user_id');
						$data['up_date'] = time();
						
						$this->db->where(array('id' => $language['id']))->update('contents_categories', $data);
					}
										
					$data = array(
						'id_path' => implode('/', array_reverse(getSupElements($language['id'], $lang_code, 'contents_categories')))
					);
					$this->db->where('id', $language['id'])->update('contents_categories', $data);					

					//update contents seo_links
					$category = $this->db->select('category_id')->from('contents_categories')->where(array('category_id' => $id, 'lang_code' => $lang_code))->limit(1)->get()->row();
					$this->db->where(array('main_category' => $category->category_id, 'lang_code' => $lang_code))->update('contents', array('category_seo_link' => $seo_link));
				}
			}
			
			mdel('netders_categories');
			
			f_redir(base_url('backend/contents/editcategory/'.$id), array(lang('SUCCESS')));
		}
		
		$check_category_id_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('contents_categories')." WHERE category_id = ?", $id)->num_rows();
		if($check_category_id_exist == 0){
			f_redir(base_url('backend/contents/categories'));
		}
		
		foreach(site_languages(true) as $languages){
		$item[$languages->lang_code] = $this->db
					  ->from('contents_categories')
					  ->where(array('category_id' => $id, 'lang_code' => $languages->lang_code))
					  ->limit(1)
					  ->get()
					  ->row();			
		}
		
		$data['item'] = $item;
		
		$sub_categories = getSubElements(6, '', 'contents_categories', 'category_id');
		$data['categories'] = $this->_getcategoriesrecursive(0, '', $sub_categories);
		
		$data['viewPage'] = $this->load->view('contents/addcategory', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function deletecategory($category_id = '')
	{
		check_perm('contents_categories_delete');

		$category = $this->db->from('contents_categories')->where('category_id', $category_id)->get()->row();
		if(empty($category)) f_redir(base_url('backend/contents/categories'), array(lang('SUCCESS')));
		$sub_categories = getSubElements($category->id, '', 'contents_categories');
		
		switch($GLOBALS['settings_global']->category_delete_type){
			case 1: //category, sub categories and contents delete				
				foreach($sub_categories as $sub_category){
					$the_categories = $this->db->from('contents_categories')->where('category_id', $sub_category)->get()->result();
					foreach($the_categories as $category){
						$this->db->where('id', $category->id)->delete('contents_categories');
						
						$the_contents = $this->db->from('contents')->where('category', $category->id)->get()->result();
						foreach($the_contents as $content){
							$this->db->where('content_id', $content->content_id)->delete('contents');
						}
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents')." AUTO_INCREMENT = 1");
					}
					$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents_categories')." AUTO_INCREMENT = 1");
				}
			break;
			
			case 2: //category, sub categories and contents move to trash
				foreach($sub_categories as $sub_category){
					$the_categories = $this->db->from('contents_categories')->where('category_id', $sub_category)->get()->result();
					foreach($the_categories as $category){

						//check trash exist
						$check = $this->db->query("SELECT title, id, module_id, lang_code FROM ".$this->db->dbprefix('trash')." WHERE module = 'contents_categories' AND FIND_IN_SET(module_id, ".$category->category_id.")")->row();
						if(empty($check)){
							$insert_category_data = array(
								'uid' => $this->session->userdata('user_id'),
								'title' => $category->title,
								'module' => 'contents_categories',
								'module_id' => $category->id,
								'date' => time(),
								'lang_code' => $category->lang_code
							);
							$this->db->insert('trash', $insert_category_data);
						} else {
							$update_category_data = array(
								'title' => implode('||', array($check->title, $category->title)),
								'module_id' => implode('||', array($check->module_id, $category->id)),
								'lang_code' => implode('||', array($check->lang_code, $category->lang_code)),
							);
							$this->db->where('id', $check->id)->update('trash', $update_category_data);
						}
						
						$this->db->where('id', $category->id)->update('contents_categories', array('status' => 'D'));
						
								$the_contents = $this->db->from('contents')->where('category', $category->id)->get()->result();
								foreach($the_contents as $content){
									//check trash exist
									$check = $this->db->query("SELECT title, id, module_id, lang_code FROM ".$this->db->dbprefix('trash')." WHERE module = 'contents' AND FIND_IN_SET(module_id, ".$content->content_id.")")->row();
									if(empty($check)){
										$insert_content_data = array(
											'uid' => $this->session->userdata('user_id'),
											'title' => $content->title,
											'module' => 'contents',
											'module_id' => $content->id,
											'date' => time() + 60,
											'lang_code' => $content->lang_code
										);
										$this->db->insert('trash', $insert_content_data);						
									} else {
										$update_content_data = array(
											'title' => implode('||', array($check->title, $content->title)),
											'module_id' => implode('||', array($check->module_id, $content->id)),
											'lang_code' => implode('||', array($check->lang_code, $content->lang_code)),
										);
										$this->db->where('id', $check->id)->update('trash', $update_content_data);
									}
									$this->db->where('id', $content->id)->update('contents', array('status' => 'D'));
								}
					}
				}
			break;
		}
		
		mdel('netders_categories');
		
		f_redir(base_url('backend/contents/categories'), array(lang('SUCCESS')));
	}
		
	public function deletecategorylang($category_id = '', $lang_code = '', $always_delete = false)
	{
		check_perm('contents_categories_delete');
		
		$category = $this->db->from('contents_categories')->where(array('category_id' => $category_id, 'lang_code' => $lang_code))->get()->row();
		if($always_delete == false && empty($category)) f_redir(base_url('backend/contents/categories'), array(lang('SUCCESS')));
		if($always_delete == true){
			$GLOBALS['settings_global']->category_delete_type = 1;
		}

		$sub_categories = getSubElements($category->id, $lang_code, 'contents_categories');

		switch($GLOBALS['settings_global']->category_delete_type){
			case 1: //category, sub categories and contents delete				
				foreach($sub_categories as $sub_category){
					$the_categories = $this->db->from('contents_categories')->where('id', $sub_category)->get()->result();
						
					foreach($the_categories as $category){
					
						//update category_id: check other languages but not id this category
						if($other_languages_categories_success != $category->category_id){
							$check_other_languages_categories = $this->db->from('contents_categories')->where('category_id', $category->category_id)->where('id !=', $category->id)->get()->result();

							if($check_other_languages_categories){
								foreach($check_other_languages_categories as $other_categories){
									$this->db->where('category_id', $category->category_id)->update('contents_categories', array('category_id' => $check_other_languages_categories[0]->id));
								}
							}
							$other_languages_categories_success = $category->category_id;
						}
										
						$this->db->where('id', $category->id)->delete('contents_categories');
						
						$the_contents = $this->db->from('contents')->where('category', $category->id)->get()->result();
						
						foreach($the_contents as $content){

							//update content_id: check other languages but not id this content
							if($other_languages_contents_success != $content->content_id){
								$check_other_languages_contents = $this->db->from('contents')->where('content_id', $content->content_id)->where('id !=', $content->id)->get()->result();
								if($check_other_languages_contents){
									foreach($check_other_languages_contents as $other_contents){
										$this->db->where('content_id', $content->content_id)->update('contents', array('content_id' => $check_other_languages_contents[0]->id));
									}
								}
								$other_languages_contents_success = $content->content_id; 
							}
						
							$this->db->where('id', $content->id)->delete('contents');
						}
						$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents')." AUTO_INCREMENT = 1");
					}
					$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents_categories')." AUTO_INCREMENT = 1");
				}
			break;
			
			case 2: //category, sub categories and contents move to trash
				foreach($sub_categories as $sub_category){
					$the_categories = $this->db->from('contents_categories')->where('id', $sub_category)->get()->result();
					foreach($the_categories as $category){
						$trash_category_data = array(
							'uid' => $this->session->userdata('user_id'),
							'title' => $category->title,
							'module' => 'contents_categories',
							'module_id' => $category->id,
							'date' => time(),
							'lang_code' => $category->lang_code
						);
						$this->db->insert('trash', $trash_category_data);
						
						$this->db->where('id', $category->id)->update('contents_categories', array('status' => 'D'));
						
						$the_contents = $this->db->from('contents')->where('category', $category->id)->get()->result();
						foreach($the_contents as $content){
							$trash_content_data = array(
								'uid' => $this->session->userdata('user_id'),
								'title' => $content->title,
								'module' => 'contents',
								'module_id' => $content->id,
								'date' => time(),
								'lang_code' => $content->lang_code
							);
							$this->db->insert('trash', $trash_content_data);
							$this->db->where('id', $content->id)->update('contents', array('status' => 'D'));
						}
					}
				}
			break;
		}
		
		mdel('netders_categories');
		
		if($always_delete == false) f_redir(base_url('backend/contents/categories'), array(lang('SUCCESS')));
	}
	
	public function updatecategories(){
		if(check_perm('contents_categories_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('categories')){
			$jsonDecoded = json_decode($this->input->post('categories'), true, 64);
			$readbleArray = $this->_updatecategoriesrecursive($jsonDecoded);
			foreach ($readbleArray as $key => $value) {
				if (is_array($value)) {
					$data = array(
						//'rang' => $key,
						'parent_id' => $value['parent_id']
					);
					$this->db->where('id', $value['id']);
					$this->db->update('contents_categories', $data);
				}
			}
		}
		
		mdel('netders_categories');
				
		echo json_encode(lang('SUCCESS'));
	}

	public function _getcategoriesrecursive($parent_id = 0, $delimiter = '', $only_this_categories = '', $where_type = 'notin')
	{
		if($only_this_categories && $where_type == 'notin'){
			$this->db->where("category_id NOT IN(".implode(',', $only_this_categories).")");
		}
		
		if($only_this_categories && $where_type == 'in'){
			$this->db->where("category_id IN(".implode(',', $only_this_categories).")");
		}		
		
    	$elements = $this->db->from('contents_categories')->where('parent_id', $parent_id)->where('status !=', 'D')->get()->result();
	    $branch = array();
		
		$delimiter = '-';
		
	    foreach ($elements as $element) {
	        
	        $element->delimiter .= $delimiter;
	        $branch[] = $element;
	        
	        if ($element->parent_id == $parent_id) {
	            $children = $this->_getcategoriesrecursive($element->id, $delimiter, $only_this_categories, $where_type);
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
		
	function _updatecategoriesrecursive($jsonArray, $parentID = 0){
	  $return = array();
	  foreach ($jsonArray as $subArray) {
		 $returnSubSubArray = array();
		 if (isset($subArray['children'])) {
		   $returnSubSubArray = $this->_updatecategoriesrecursive($subArray['children'], $subArray['id']);
		 }
		 $return[] = array('id' => $subArray['id'], 'parent_id' => $parentID);
		 $return = array_merge($return, $returnSubSubArray);
	  }

	  return $return;
	}
		
	public function photos($content_id)
	{	
		$this->load->library('photos/jfup');
		$jfup = new Jfup();

		header('Pragma: no-cache');
		header('Cache-Control: private, no-cache');
		header('Content-Disposition: inline; filename="files.json"');
		header('X-Content-Type-Options: nosniff');
				
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'OPTIONS':
            case 'HEAD':
                $jfup->head();
                break;
            case 'GET':
                $jfup->get($content_id);
                break;
            case 'PATCH':
            case 'PUT':
            case 'POST':
                $jfup->post($content_id);
                break;
            case 'DELETE':
                $jfup->delete($content_id);
                break;
            default:
                $jfup->header('HTTP/1.1 405 Method Not Allowed');
        }
	}
	
	public function cropPhotos(){
		$this->load->library('photos/RlCrop');
		$RlCrop = new RlCrop();
		$RlCrop->ajaxCrop($_POST['coords'], $_POST['id']);
	}
	
	public function mainPhotos(){
		$id = $_POST['id'];
		$module_id = $_POST['module_id'];
		
		$check = $this->db->from('photos')->where('id', $id)->get()->row();
		
		if($check->type == 'photo'){
			//$this->db->where('module_id', $module_id);
			//$this->db->update(PREFIX.'photos', array('type' => 'photo'));
			
			$this->db->where('module_id', $module_id);
			$this->db->where('id', $id);
			$this->db->update('photos', array('type' => 'main'));
		} else {
			$this->db->where('module_id', $module_id);
			$this->db->where('id', $id);
			$this->db->update('photos', array('type' => 'photo'));			
		}
		
		echo lang('SUCCESS');
	}
	
	public function descPhotos(){
		$id = $_POST['id'];
		$description = $_POST['description'];
		
		$this->db->where('id', $id);
		$this->db->update('photos', array('description' => $description));
		
		echo lang('SUCCESS');
	}

	public function langPhotos(){
		$id = $_POST['id'];
		$language = $_POST['language'];
		
		$this->db->where('id', $id);
		$this->db->update('photos', array('lang_code' => $language));
		
		echo lang('SUCCESS');
	}

	public function sortPhotos()
	{
		foreach($this->input->post('photo') as $k => $id){
			$this->db->where('id', $id);
			$this->db->update('photos', array('position' => $k+1));
		}
		echo lang('SUCCESS');
	}

	public function uploadhere(){
	    $imagePath = ROOTPATH . "uploads/";
	
		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
		$temp = explode(".", $_FILES["img"]["name"]);
		$extension = end($temp);
	
		if ( in_array($extension, $allowedExts))
		  {
		  if ($_FILES["img"]["error"] > 0)
			{
				 $response = array(
					"status" => 'error',
					"message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
				);
				echo "Return Code: " . $_FILES["img"]["error"] . "<br>";
			}
		  else
			{
				
			  $filename = $_FILES["img"]["tmp_name"];
			  list($width, $height) = getimagesize( $filename );
	
			  move_uploaded_file($filename,  $imagePath . $_FILES["img"]["name"]);
	
			  $response = array(
				"status" => 'success',
				"url" => site_url('uploads/'.$_FILES["img"]["name"]),
				"width" => $width,
				"height" => $height
			  );
			  
			}
		  }
		else
		  {
		   $response = array(
				"status" => 'error',
				"message" => 'something went wrong',
			);
		  }
		  
		  print json_encode($response);
	}
	
	public function crophere(){
		$origPath 	= $this->input->post('origPath');
		$savePath 	= $this->input->post('savePath');
		$imgInitW 	= $this->input->post('imgInitW');
		$imgInitW 	= $this->input->post('imgInitW');
		$imgInitH 	= $this->input->post('imgInitH');
		$imgW 		= $this->input->post('imgW');
		$imgH 		= $this->input->post('imgH');
		$imgY1 		= $this->input->post('imgY1');
		$imgX1 		= $this->input->post('imgX1');
		$cropW 		= $this->input->post('cropW');
		$cropH 		= $this->input->post('cropH');
		
		$jpeg_quality = 100;

		$what = getimagesize($origPath);
		switch(strtolower($what['mime']))
		{
		    case 'image/png':
		        $img_r = imagecreatefrompng($origPath);
				$source_image = imagecreatefrompng($origPath);
		        break;
		    case 'image/jpeg':
		        $img_r = imagecreatefromjpeg($origPath);
				$source_image = imagecreatefromjpeg($origPath);
		        break;
		    case 'image/gif':
		        $img_r = imagecreatefromgif($origPath);
				$source_image = imagecreatefromgif($origPath);
		        break;
		    default: die('image type not supported');
		}
			
		$resizedImage = imagecreatetruecolor($imgW, $imgH);
		imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, 
					$imgH, $imgInitW, $imgInitH);	
		
		
		$dest_image = imagecreatetruecolor($cropW, $cropH);
		imagecopyresampled($dest_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, 
					$cropH, $cropW, $cropH);	
	
	
		imagejpeg($dest_image, $savePath, $jpeg_quality);
		
		$response = array(
				"status" => 'success',
				"url" => base_url($savePath) 
			  );
		 print json_encode($response);		
	}
	
	public function _tags_insert($table, $tags, $object_id, $lang_code = '')
	{	
		if(empty($table) || empty($object_id)) return false;
		
		if($lang_code)
		$this->db->where('lang_code', $lang_code);
		
		$current_tags = $this->db
			->select('tags.name, tags.id tags_id, tags.count, tags_relations.*')
			->from('tags_relations')
			->join('tags', 'tags.id=tags_relations.tag_id')
			->where(
				array(
					'object_type' => $table,
					'object_id' => $object_id
				)			
			)
			->get()->result();
	
		if(empty($tags))
		{
			if(!empty($current_tags)){
				foreach($current_tags as $current_tag)
				{
					$this->db->where('id', $current_tag->id)->delete('tags_relations');
					if($current_tag->count == 1){
						$this->db->where('id', $current_tag->tags_id)->delete('tags');
					} else {
						$this->db->set('count', 'count-1', FALSE);
						$this->db->where('id', $current_tag->tags_id)->update('tags');
					}
				}
			}		
			return false;			
		}
		
		$tags = explode(',', $tags);
		
		if(!empty($current_tags)){
			foreach($current_tags as $current_tag){
				if(!in_array($current_tag->name, $tags)){
					$this->db->where('id', $current_tag->id)->delete('tags_relations');
					if($current_tag->count == 1){
						$this->db->where('id', $current_tag->tags_id)->delete('tags');
					} else {
						$this->db->set('count', 'count-1', FALSE);
						$this->db->where('id', $current_tag->tags_id)->update('tags');
					}
				}
				$current_tag_names[] = $current_tag->name;
			}
		}
		
		$insert_tags = !empty($current_tag_names) ? array_diff($tags, $current_tag_names) : $tags;
		
		if(!empty($insert_tags)){
			foreach($insert_tags as $insert_tag){
				
				if(!empty($insert_tag)){
					$check_tag_is_inserted = $this->db->from('tags')->where('name', $insert_tag)->get()->row(); 
					
					if(empty($check_tag_is_inserted)){
						$insert_data = array(
							'name' => $insert_tag,
							'slug' => seo($insert_tag),
							'count' => 1
						);
						$this->db->insert('tags', $insert_data);
						$insert_id = $this->db->insert_id();
					} else {
						$this->db->set('count', 'count+1', FALSE);
						$this->db->where('name', $insert_tag)->update('tags');
						$insert_id = $check_tag_is_inserted->id;
					}
									
					$insert_data = array(
						'object_id' => $object_id,
						'object_type' => $table,
						'tag_id' => $insert_id,
						'lang_code' => $lang_code,
					);
					$this->db->insert('tags_relations', $insert_data);	
				}			
			}
		}
	}
		
	public function searchtag(){
		
		$type = $this->input->get('type', true);
		$term = $this->input->get('term', true);
		
		$query = $this->db->select('title, id')->from('contents')->like('title', $term, 'both')->get()->result();	
		
		if(sizeof($query) > 0){
			foreach($query as $q){
				$res[] = array("text" => "$q->title", "id" => $q->id);
			}
		}
		echo json_encode($res);
	}
	
	public function words_test($id){
		check_perm('contents_overview');
		$this->load->model('contentsmodel');
		$word = $this->contentsmodel->word_test('Matematik', $id);
		
		echo $word;exit;
	}
	
	public function words()
	{
		check_perm('contents_overview');
		
		$this->load->model('contentsmodel');
		
		$data = array();
		
		if($this->input->post())
		{
			switch($this->input->post('form_name'))
			{
				case 'new':
					$insert_data = array();
					foreach($this->input->post('phase') as $id => $value){
						$insert_data['phase'.$id] = $value;	
					}
					
					$insert_data['uid'] = $this->session->userdata('user_id');
					$insert_data['status'] = $this->input->post('status');
					
					$this->db->insert('contents_words', $insert_data);
				break;
				
				case 'update':
					$update_data = array();
					foreach($this->input->post('phase') as $id => $phase){
						foreach($phase as $key => $value){
							$update_data['phase'.$key] = $value;	
						}
						$update_data['uid'] = $this->session->userdata('user_id');
						$update_data['status'] = $this->input->post('status')[$id];
						$this->db->where('id', $id)->update('contents_words', $update_data);										
					}
				break;
				
				case 'generate':
					//city,town,lesson,url
					$data['generated_word'] = $this->contentsmodel->generate($this->input->post('keyword'), $this->input->post('url'));
				break;
			}
		}
		
		
		$data['total_words'] = $this->contentsmodel->total_words();
		$data['words'] = $this->db->from('contents_words')->where('status', 'A')->get()->result();
		
		$data['viewPage'] = $this->load->view('contents/words', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	
	
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lessons extends CI_Controller {
	
	var $template = 'pages/wrapper';
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		check_perm('lessons_overview');
		
		$data = array();
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{		
			
					
			$this->db->start_cache();
	
				$this->db->from('lessons lessons');
				$this->db->join('contents_categories subject', 'subject.category_id=lessons.lesson_subject', 'left');
				$this->db->join('contents_categories level', 'level.category_id=lessons.lesson_level', 'left');
				$this->db->join('users users', 'users.id=lessons.tutor_id', 'left');
				$this->db->join('users users2', 'users2.id=lessons.uid', 'left');
				$this->db->join('lessons_types lessons_types', 'lessons_types.id=lessons.lesson_type', 'left');
	
			$this->db->stop_cache();
			
			$this->db->set_dbprefix('');
			
			$this->db->select('lessons.id');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
			
			
			$this->db->select('lessons.*, subject.title subject_title, level.title level_title, users.firstname tutor_firstname, users.lastname tutor_lastname, users2.firstname user_firstname, users2.lastname user_lastname, lessons_types.title lesson_type_name');
			
			$data['items'] = $this->db->get()->result();

			$this->db->flush_cache();
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
				
		$data['viewPage'] = $this->load->view('lessons/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function edit($id)
	{
		check_perm('lessons_edit');

		if($this->input->post()){
			$errors = array();
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			if(!$post['student']){$errors[] = "Öğrenci alanı boş bırakılamaz!";}
			if(!$post['tutor']){$errors[] = "Eğitmen alanı boş bırakılamaz!";}
			if(!$post['subject']){$errors[] = "Ders alanı boş bırakılamaz!";}
			if(!$post['slot_start']){$errors[] = "Başlangıç tarihi alanı boş bırakılamaz!";}
			if(!$post['slot_end']){$errors[] = "Sonlanma tarihi alanı boş bırakılamaz!";}
			if(!isset($post['slot_status'])){$errors[] = "Durum alanı boş bırakılamaz!";}
			if(!isset($post['lesson_type'])){$errors[] = "Tip alanı boş bırakılamaz!";}
				
			if(count($errors) > 0){
				$data['errors'] = $errors;
			} else {
				$subject = $this->db->select('parent_id')->from('contents_categories')->where('id', $post['subject'])->get()->row();
				$updatedata = array(
				    'slot_start' => date('Y-m-d\TH:i:s\Z', strtotime($post['slot_start'])),
				    'slot_end' => date('Y-m-d\TH:i:s\Z', strtotime($post['slot_end'])),
				    'uid' => $post['student'],
				    'tutor_id' => $post['tutor'],
				    'slot_status' => $post['slot_status'],
				    'lesson_type' => $post['lesson_type'],
				    'lesson_level' => $post['subject'],
				    'lesson_subject' => $subject->parent_id,
				    'school_id' => $post['school_id'],
				    'school_tutor_pwd' => $post['school_tutor_pwd'],
				    'school_student_pwd' => $post['school_student_pwd'],
				    'school_create_date' => $post['school_create_date'],
				);
				$this->db->where('id', $id)->update('lessons', $updatedata);
				
				f_redir(base_url('backend/lessons/edit/'.$id), array(lang('SUCCESS')));
			}
		}
		
		$data['item'] = $this->db->where('id', $id)->from('lessons')->get()->row();
		if(empty($data['item'])){ f_redir(base_url('backend/users')); }
		
		/*
		if(time() > strtotime(date_format(date_create($data['item']->slot_end), 'd.m.Y H:i'))){
			$this->load->library('bigbluebutton');
			$data['records'] = $this->bigbluebutton->getRecordingsWithXmlResponseArray(array('meetingId' => $data['item']->school_id));	
		}
		*/
		
			$this->load->library('bigbluebutton');
			$data['meetings'] = $this->bigbluebutton->getMeetingsWithXmlResponseArray();
			$data['records'] = $this->bigbluebutton->getRecordingsWithXmlResponseArray(array('meetingId' => $data['item']->school_id));			
			$data['isrunning'] = $this->bigbluebutton->isMeetingRunningWithXmlResponseArray($data['item']->school_id);
			$data['info'] = $this->bigbluebutton->getMeetingInfoWithXmlResponseArray(array('meetingId' => $data['item']->school_id, 'password' => $data['item']->school_tutor_pwd));			
			
		
		
		$data['subjects'] = $this->_getcategoriesrecursive(0, '', $GLOBALS['settings_global']->lesson_categories, 'Y');
		$data['types'] = $this->db->from('lessons_types')->get()->result();
		$data['students'] = $this->db->select('id, firstname, lastname')->where('ugroup', '2')->where('status', 'A')->from('users')->get()->result();
		$data['tutors'] = $this->db->select('id, firstname, lastname')->where_in('ugroup', array(3,4,5))->where('status', 'A')->from('users')->get()->result();
		
		$data['viewPage'] = $this->load->view('lessons/add', $data, true);
		
		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function join($member_type, $lesson_id)
	{
		if(empty($member_type) || empty($lesson_id)) f_redir(base_url('backend/lessons'));
		
		$lesson = $this->db->from('lessons')->where('id', $lesson_id)->get()->row();
		if(empty($lesson)) f_redir(base_url('backend/lessons'));
		
		
		$this->load->library('bigbluebutton');
		
		$password = $member_type == 'tutor' ? $lesson->school_tutor_pwd : $lesson->school_student_pwd;
		
		$joinParams = array(
			'meetingId' => $lesson->school_id,  																			// REQUIRED - We have to know which meeting to join.
			'username' => $this->session->userdata('user_firstname') . ' ' . $this->session->userdata('user_lastname'),		// REQUIRED - The user display name that will show in the BBB meeting.
			'password' => $password,	// REQUIRED - Must match either attendee or moderator pass for meeting.
			//'createTime' => '',		// OPTIONAL - string
			//'userId' => '',			// OPTIONAL - string
			//'webVoiceConf' => ''		// OPTIONAL - string
		);
		
		// Get the URL to join meeting:
		$itsAllGood = true;
		try {$result = $this->bigbluebutton->getJoinMeetingURL($joinParams);}
			catch (Exception $e) {
				m('admin', 'School API Join Tutor: Caught exception: ', $e->getMessage() .' L: '. json_encode($lesson) .' U:'. $ci->session->userdata('user_id'));
				$itsAllGood = false;
			}
		
		if ($itsAllGood == true) {
			f_redir($result);
		}		
	}
	
	public function categories()
	{
		check_perm('lessons_categories_overview');
		foreach(site_languages(true) as $language){
			$data['items'][$language->lang_code] = $this->_makenestablecategories(0, $language->lang_code, $GLOBALS['settings_global']->lesson_categories);
		}
		$data['viewPage'] = $this->load->view('lessons/categories', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function _makenestablecategories($parent_id = 0, $lang_code = '', $only_this_categories = '')
	{	
		if($lang_code){
			$this->db->where('lang_code', $lang_code);
		}
		
		if($only_this_categories){
			$this->db->where("category_id IN(".$only_this_categories.")");
		}
		
		$this->db->where('parent_id', $parent_id);
		$this->db->from('contents_categories');
		
		$items = $this->db->select('id, category_id, title, status, parent_id')->where('status !=', 'D')->order_by('position', 'ASC')->get()->result();
		
		if (!empty($items)) {
			$category_delete_title = $GLOBALS['settings_global']->category_delete_type == 1 ? lang('DELETE_CONTENT_TEXT') : lang('TRASH_CONTENT_TEXT');
			$out .= "<ol class='dd-list'>";
				foreach($items as $item){
					$item->title = $item->status == 'A' ? $item->title : '<i class="text-muted">'.$item->title.'</i>';
					$out .= '
					<li class="dd-item dd3-item" data-id="'.$item->id.'">
					  <div class="dd-handle dd3-handle">&nbsp;</div><div class="dd3-content'.$grey.'">[#'.$item->category_id.'] '.$item->title.'
						<div class="btn-group pull-right">
							<a href="'.base_url('backend/lessons/editcategory/' . $item->category_id).'" class="btn btn-default btn-xs"><i class="fa fa-pencil" data-toggle="tooltip" data-original-title="Düzenle"></i></a>
							<a onclick="confirmation(\''.lang('WARNING').'\', \''.$category_delete_title.'\', \''.base_url('backend/lessons/deletecategory/' . $item->category_id).'\')" class="btn btn-default btn-xs"><i class="fa fa-trash-o" data-toggle="tooltip" data-original-title="Sil"></i></a>
						</div>
					  </div>';
					$out .= $this->_makenestablecategories($item->id, $lang_code, $only_this_categories);
					$out .= '</li>';
				}
			$out .= "</ol>";
		}
		
		return $out;
	}

	public function addcategory(){
	
		check_perm('lessons_categories_add');
		
		if($this->input->post()){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			$this->load->helper('string');
			$random_number = random_string('numeric', 9);

			foreach($post['lang'] as $lang_code => $language){
				if(!empty($language['title'])){
									
					$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents_categories") : 'after';												
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
					
					if($seo_link == 'after'){
						$data['seo_link'] = $this->create_seo_name_tree($data['id_path'], '', $lang_code);
					}
					
					$this->db->where('id', $insert_id)->update('contents_categories', $data);
				}
			}

			$min = $this->db->select_min('id')->from('contents_categories')->where(array('category_id' => $random_number))->get()->row();
			$this->db->where(array('category_id' => $random_number));
			$this->db->update('contents_categories', array('category_id' => $min->id));
			
			//f_redir(base_url('backend/lessons/addcategory/'.$min->id), array(lang('SUCCESS')));
			$data['success'] = true;
			
			$this->db->update('settings_global', array('lesson_categories' => implode(',', getSubElements(6, '', 'contents_categories', 'category_id'))));
		}
		
		$data['categories'] = $this->_getcategoriesrecursive(0, '', $GLOBALS['settings_global']->lesson_categories);
		
		$data['viewPage'] = $this->load->view('lessons/addcategory', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function editcategory($id)
	{
		check_perm('lessons_categories_edit');
		
		if($this->input->post()){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			foreach($post['lang'] as $lang_code => $language){
				
				if(!empty($language['title'])){
					$is_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('contents_categories')." WHERE category_id = ? AND lang_code = ?", array($id, $lang_code))->num_rows();
					if($is_exist == 0){
						$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents_categories") : 'after';
					} else {
						$seo_link = $language['seo_link'] ? create_seo_name($language['seo_link'], "contents_categories", $language['id'], 'id') : $language['id'];
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
					
					if($seo_link == 'after' || is_numeric($seo_link))
					{	
						$data['seo_link'] = is_numeric($seo_link) ? $this->create_seo_name_tree($data['id_path'], '', $lang_code) : $this->create_seo_name_tree($data['id_path'], $seo_link, $lang_code);
						$seo_link = $data['seo_link'];
					}
										
					$this->db->where('id', $language['id'])->update('contents_categories', $data);					
					
				}
			}
			
			$this->db->update('settings_global', array('lesson_categories' => @implode(',', getSubElements(6, '', 'contents_categories', 'category_id'))));
			
			f_redir(base_url('backend/lessons/editcategory/'.$id), array(lang('SUCCESS')));
		}
		
		$check_category_id_exist = $this->db->query("SELECT 1 FROM ".$this->db->dbprefix('contents_categories')." WHERE category_id = ?", $id)->num_rows();
		if($check_category_id_exist == 0){
			f_redir(base_url('backend/lessons/categories'));
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
		
		$data['categories'] = $this->_getcategoriesrecursive(0, '', $GLOBALS['settings_global']->lesson_categories);
		
		$data['viewPage'] = $this->load->view('lessons/addcategory', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function deletecategory($category_id = '')
	{
		check_perm('lessons_categories_delete');
		
		switch($GLOBALS['settings_global']->category_delete_type){
			case 1: //delete category
				$this->db->where('category_id', $category_id)->delete('contents_categories');
				$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents_categories')." AUTO_INCREMENT = 1");
				$sub_categories = getSubElements($category_id, '', 'contents_categories', 'category_id');
				
				if(!empty($sub_categories)){
					foreach($sub_categories as $sub_category)
					{
						$this->db->where('category_id', $sub_category)->delete('contents_categories');
					}
					$this->db->query("ALTER TABLE ".$this->db->dbprefix('contents_categories')." AUTO_INCREMENT = 1");
				}
			break;
			
			case 2: //move to trash category
				$insert_content_data = array(
					'uid' => $this->session->userdata('user_id'),
					'title' => $category_id.' numaralı kategori',
					'module' => 'contents_categories',
					'module_id' => $category_id,
					'date' => time() + 60,
					'lang_code' => DESCR_SL
				);
				$this->db->insert('trash', $insert_content_data);
				
				$this->db->where('category_id', $category_id)->update('contents_categories', array('status' => 'D'));
				
			break;
		}
		
		f_redir(base_url('backend/lessons/categories'), array(lang('SUCCESS')));
	}
	
	public function deletecategorylang($category_id = '', $lang_code = '', $always_delete = false)
	{
		check_perm('lessons_categories_delete');
		
		$this->db->where('category_idid', $category->id)->where('lang_code', $lang_code)->update('contents_categories', array('status' => 'D'));
		
		f_redir(base_url('backend/lessons/categories'), array(lang('SUCCESS')));
	}
	
	public function updatecategories(){
		if(check_perm('lessons_categories_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('categories')){
			$jsonDecoded = json_decode($this->input->post('categories'), true, 64);
			$readbleArray = $this->_updatecategoriesrecursive($jsonDecoded);
			$position = 10;
			foreach ($readbleArray as $key => $value) {
				if (is_array($value)) {
					$data = array(
						//'rang' => $key,
						'parent_id' => $value['parent_id'],
						'position' => $position
					);
					$this->db->where('id', $value['id']);
					$this->db->update('contents_categories', $data);
				}
				$position += 10;
			}
		}			
		echo json_encode(lang('SUCCESS'));
	}

	public function _getcategoriesrecursive($parent_id = 0, $delimiter = '', $only_this_categories = '', $parent_category = 'N')
	{
		if($only_this_categories){
			$this->db->where("category_id IN(".$only_this_categories.")");
		}
		
    	$elements = $this->db->from('contents_categories')->where('parent_id', $parent_id)->where('status !=', 'D')->get()->result();
	    $branch = array();
		
		if($parent_category == 'N')
		$delimiter = '-';
		
	    foreach ($elements as $element) {
	        
	        if($parent_category == 'Y'){
		        $parent_category_sql = $this->db->from('contents_categories')->where('id', $element->parent_id)->where('status !=', 'D')->get()->row();
		        if(isset($element->delimiter)){
		        	$element->delimiter .= $parent_category_sql->title ? $parent_category_sql->title.' > ' : '';
		        } else {
			        $element->delimiter = isset($parent_category_sql->title) ? $parent_category_sql->title.' > ' : '';
		        }
	        } else {
		        $element->delimiter .= $delimiter;
	        }
	        $branch[] = $element;
	        
	        if ($element->parent_id == $parent_id) {
	            $children = $this->_getcategoriesrecursive($element->id, $delimiter, $only_this_categories, $parent_category);
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
	
	public function create_seo_name_tree($id_path, $id = '', $lang_code)
	{
		$categories = $this->db->select('title')->from('contents_categories')->where("category_id IN(".implode(',', explode('/', substr($id_path, 2))).")")->where('lang_code', $lang_code)->get()->result();
		if(!empty($categories)){
			$links = array();
			foreach($categories as $category){
				$links[] = seo($category->title);
			}
		}
		
		if($id){
			$seo_link = create_seo_name(implode('/', $links), "contents_categories", $id, 'id');
		} else {
			$seo_link = create_seo_name(implode('/', $links), "contents_categories");
		}
		
		return $seo_link;
	}
}
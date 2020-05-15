<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sliders extends CI_Controller {

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
				
				$this->db->from('sliders');
	
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
				$languages = array();
	            foreach(site_languages(true) as $language){
		            if(in_array($language->lang_code, explode(',', $item->lang_code))){
			            $languages[] = $language->name;
		            }
	            }
	            $item->sections = implode(', ', $languages);
				$item->status = $item->status == 'A' ? lang('ACTIVE') : lang('INACTIVE');
			}
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('sliders/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function add(){
	
		check_perm('sliders_add');
		
		if($this->input->post()){
						
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
			
			if(!empty($post['title'])){
				$data = array(
				    'title' => $post['title'],
				    'status' => $post['status'],
				    'lang_code' => @implode(',', $post['languages'])
				);
				$this->db->insert('sliders', $data);
			}

			f_redir(base_url('backend/sliders/edit/'.$this->db->insert_id()), array(lang('SUCCESS')));
		}
		
		$data['viewPage'] = $this->load->view('sliders/add', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
		
	public function edit($id){
	
		check_perm('sliders_edit');
		
		if($this->input->post()){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); } 
				
			if(!empty($post['title'])){
				$data = array(
				    'title' => $post['title'],
				    'status' => $post['status'],
				    'lang_code' => @implode(',', $post['languages'])
				);
				$this->db->where(array('id' => $id))->update('sliders', $data);
			}

			f_redir(base_url('backend/sliders/edit/'.$id), array(lang('SUCCESS')));
		}
		
		$data['item'] = $this->db
					  ->from('sliders')
					  ->where(array('id' => $id))
					  ->limit(1)
					  ->get()
					  ->row();
		$data['item']->lang_code = explode(',', $data['item']->lang_code);
		
		$data['viewPage'] = $this->load->view('sliders/add', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function delete($id){
		
		check_perm('sliders_delete');
		
		$this->db->where(array('id' => $id))->update("sliders", array('status' => 'D'));

		//Insert trash
		$item = $this->db->from('sliders')->where('id', $id)->get()->row();
		$data = array(
			'uid' => $this->session->userdata('user_id'),
			'title' => $item->title,
			'module' => 'sliders',
			'module_id' => $item->id,
			'date' => time(),
			'lang_code' => $item->lang_code
		);
		$this->db->insert('trash', $data);

		f_redir(base_url('backend/sliders'), array(lang('SUCCESS')));
	}
	
	public function images($slider_id)
	{
		check_perm('sliders_images_overview');
		
		if($this->input->post()){
			foreach($this->input->post('position') as $id => $value){
				$this->db->where('id', $id)->update('sliders_items', array('position' => $value));
			}
		}
		if(empty($slider_id)) f_redir(base_url('backend/sliders'), array('Slayt ID numarası tanımsız olamaz!'), '', '', true);

		$total = $this->db->query("SELECT id FROM ".$this->db->dbprefix('sliders_items')." WHERE slider_id = ?", array($slider_id))->num_rows();
		
		$page = !$this->input->get('page') ? 1 : (int)$this->input->get('page', true);
		$limit = !empty($limit) ? $limit : (($page-1)*20).",20";
		
		$items = $this->db->query("SELECT * FROM ".$this->db->dbprefix('sliders_items')." WHERE slider_id = ? ORDER BY position LIMIT $limit", array($slider_id))->result();
		if(!empty($items)){
			foreach($items as $item){
				$item->photos = $this->db->query("SELECT * FROM ".$this->db->dbprefix('photos')." WHERE module_name = ? AND module_id = ? ORDER BY RAND() LIMIT $limit", array('sliders', $item->id))->result();
			}
		}

		$data['items'] = $items;

		$data['pages'] = pagenav($total,$page,20,current_url());
		
		$data['viewPage'] = $this->load->view('sliders/images', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function addimages($slider_id = '')
	{
		check_perm('sliders_images_add');
		
		$data = array();
		
		if(empty($slider_id)) f_redir(base_url('backend/sliders'), array('Slayt ID numarası tanımsız olamaz!'), '', '', true);
		
		if($this->input->post()){

			$link_value = $this->input->post('link_type') == 'url' ? $this->input->post('link_value') : $this->input->post('link_id');

			$data = array(
				'slider_id' => $slider_id,
				'link_type' => $this->input->post('link_type'),
				'link_value' => $link_value,
				'link_target' => $this->input->post('link_target'),
				'lang_code' => @implode(',', $this->input->post('languages'))
			);
			$this->db->insert('sliders_items', $data);

			f_redir(base_url('backend/sliders/editimages/'.$this->db->insert_id().'/#images'), array(lang('SUCCESS')));
		}
		
		$data['viewPage'] = $this->load->view('sliders/addimages', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function editimages($item_id = '')
	{
		check_perm('sliders_images_edit');

		if(empty($item_id)) f_redir(base_url('backend/sliders'), array('Slayt görsel ID numarası tanımsız olamaz!'), '', '', true);

		if($this->input->post()){
			
			$link_value = $this->input->post('link_type') == 'url' ? $this->input->post('link_value') : $this->input->post('link_id');

			$data = array(
				'link_type' => $this->input->post('link_type'),
				'link_value' => $link_value,
				'link_target' => $this->input->post('link_target'),
				'lang_code' => @implode(',', $this->input->post('languages'))
			);
			
			$this->db->where('id', $item_id)->update('sliders_items', $data);

			f_redir(base_url('backend/sliders/editimages/'.$item_id), array(lang('SUCCESS')));
		}
		
		$data['item'] = $this->db->from('sliders_items')->where('id', $item_id)->get()->row();
		
		if(!$data['item']){
			f_redir(base_url('backend/sliders'), array('Slayt görsel ID numarası hatalıdır!'), '', '', true);
		}

		$data['viewPage'] = $this->load->view('sliders/addimages', $data, true);
			
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function deleteimages($id){
		$this->db->query("DELETE FROM ".$this->db->dbprefix('sliders_items')." WHERE id = ?", $id);
		delete_photo('sliders', $id);
		f_redir($_SERVER['HTTP_REFERER'], array(lang('SUCCESS')));
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
			$this->db->where('module_id', $module_id);
			$this->db->update('photos', array('type' => 'photo'));
			
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
		
}
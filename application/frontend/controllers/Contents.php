<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contents extends CI_Controller {

	var $template = 'pages/wrapper';
	var $folder_prefix 	= '';

   public function __construct()
   {
		 	parent::__construct();
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			$this->config->set_item('language', $this->session->userdata('site_sl'));
			$this->load->model('contents_model');
    }

	public function index($category_id = '')
	{
		$search = array();
		$help_categories = get_items_recursive('id', 2, 'contents_categories');

		$category = $this->db->from('contents_categories')->where('category_id', (int)$category_id)->where('lang_code', $this->session->userdata('site_sl'))->limit(1)->get()->row();
		$site_sl = $this->session->userdata('site_sl');

		if(empty($category)) redir(site_url());

		$this->db->start_cache();

		if(in_array($category_id, $help_categories))
		{
			$this->db->where("main_category IN(".implode(',',$help_categories).")");
		} else {
			$this->db->where("(main_category = $category_id OR FIND_IN_SET('".$category_id."', category))");
		}

		if($this->input->get('q')){
			$q = $this->security->xss_clean($this->input->get('q', true));
			$where = "MATCH (title) AGAINST ('*{$q}*' IN BOOLEAN MODE)";
			$this->db->where($where);
		} else {
			$this->db->where('main_category', $category_id);
		}


		$this->db->where('lang_code', $site_sl);
		$this->db->where('status !=', 'D');

		$this->db->from('contents');

		$this->db->stop_cache();

		$this->db->select('id');

		$total = $this->db->count_all_results();

		$page = !$this->input->get('page') ? 1 : (int)$this->input->get('page', true);
		$limit = !empty($limit) ? $limit : (($page-1)*5);

		$this->db->order_by('id DESC, position ASC');

		$this->db->limit(5, $limit);

		$items = $this->db->get()->result();

		$this->db->flush_cache();

		foreach($items as $item){
			$item->category_name = $this->db->select('title')->from('contents_categories')->where('category_id', $item->main_category)->where('lang_code', $this->session->userdata('site_sl'))->get()->row();
		}

		$data['breadcrumb'] = breadcrumb('category', $category->id);

		$search = sizeof($search) > 0 ? '?'.implode('&', $search) : "";
		$data['total'] = $total;
		$data['pages'] = pagenav($total,$page,5,current_url().$search);
		$data['items'] = $items;
		$data['category'] = $category;

		if($category_id == 2)
		$data['popular'] = $this->db->from('contents')->where_in('main_category', $help_categories)->order_by('views', 'desc')->limit(10)->get()->result();

		$data['help_categories'] = $this->_getcategoriesrecursive(2);

		$template_category = $category->template_category ? $category->template_category : 'contents/list';

		if($data['category']->seo_title)
		$data['seo_title'] = $data['category']->seo_title;

		if($data['category']->seo_description)
		$data['seo_description'] = $data['category']->seo_description;

		if($data['category']->seo_keyword)
		$data['seo_keyword'] = $data['category']->seo_keyword;

		$data['viewPage'] = $this->load->view($this->folder_prefix . $template_category, $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function detail($category_seo_link = '', $seo_link = '')
	{
		$this->load->model('locations_model');

		$seo_link = !empty($category_seo_link) && !empty($seo_link) ? $seo_link : $category_seo_link;

		//content
		$data['item'] = $this->db->where(array('seo_link' => $seo_link, 'lang_code' => $this->session->userdata('site_sl')))->from('contents')->get()->row();

		if(empty($data['item'])) redir(site_url());

		//+1 view
		if(!$this->session->userdata('view_'.$data['item']->id)){
			$this->db->set('views', 'views+1', FALSE)->where('id', $data['item']->id)->update('contents');
			$this->session->set_userdata('view_'.$data['item']->id, 1);
		}
		//content images
		$data['main_image'] = $this->db->where(array('module_name' => 'contents', 'module_id' => $data['item']->content_id, 'type' => 'main'))->where_in('lang_code', array($this->session->userdata('site_sl'), 'all'))->from('photos')->order_by('position ASC')->get()->row();

		//content images
		$data['images'] = $this->db->where(array('module_name' => 'contents', 'module_id' => $data['item']->content_id, 'type' => 'photo'))->where_in('lang_code', array($this->session->userdata('site_sl'), 'all'))->from('photos')->order_by('position ASC')->get()->result();

		//breadcrumb
		$data['breadcrumb'] = breadcrumb('content', $data['item']->id);

		//seo
		$data['seo_title'] = $data['item']->seo_title ? $data['item']->seo_title : $data['item']->title;
		$data['seo_url'] = current_url();
		$seo_description = strip_tags( $data['item']->description );
		$seo_description = str_replace("\n", "", $seo_description);
		$seo_description = $data['item']->seo_description ? $data['item']->seo_description : $seo_description;
		$data['seo_description'] = my_mb_substr($seo_description, 200);
		$data['seo_keyword'] = $data['item']->seo_keyword;
		$data['seo_image'] = base_url('public/img/netders-logo.png');

		//template
		if($data['item']->template_content){
			$template_content = $data['item']->template_content;
		} else {
			$check_category = $this->db->from('contents_categories')->where('id', $data['item']->main_category)->get()->row();
			$template_content = $check_category->template_content ? $check_category->template_content : 'contents/detail';
		}

		//category
		$data['category'] = $this->db->from('contents_categories')->where(array('category_id' => $data['item']->main_category, 'lang_code' => $this->session->userdata('site_sl')))->get()->row();

		//others
		$data['others'] = $this->db->from('contents')->where(array('main_category' => $data['item']->main_category))->order_by('position', 'ASC')->get()->result();

		$data['item']->city_title = $this->locations_model->get_location('locations_cities', ['id' => $data['item']->city], 'title');

		if($data['item']->city && $data['item']->keyword)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.netders.com/api/get_users?city=".$data['item']->city."&keyword=".$data['item']->keyword."&limit=10");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$res = curl_exec ($ch);
			curl_close ($ch);

			if(!empty($res)){
				$data['teachers'] = json_decode($res);
			}
		}

		$data['viewPage'] = $this->load->view($this->folder_prefix . $template_content, $data, true);

		$result	 = $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function newsletter_subscription()
	{
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$this->form_validation->set_rules('email', 'E-posta adresiniz', 'trim|required|valid_email|is_unique[emails.email]');
			if ($this->form_validation->run() == FALSE){
				echo json_encode(array('RES' => 'ERR', 'MSG' => $this->form_validation->error_array(), 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			} else {
				$this->contents_model->insert_newsletter_subscription();
				echo json_encode(array('RES' => 'OK', 'MSG' => lang('NEWSLETTER_SUCCESS'), 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			}
			exit;
		}
	}

	public function _getcategoriesrecursive($parent_id = 0, $delimiter = '')
	{
    	$elements = $this->db->from('contents_categories')->where('parent_id', $parent_id)->get()->result();
	    $branch = array();

		$delimiter = '-';

	    foreach ($elements as $element)
	    {
	    	if(isset($element->delimiter))
	    	{
	        	$element->delimiter .= isset($delimiter) ? $delimiter : '';
	        } else {
		        $element->delimiter = isset($delimiter) ? $delimiter : '';
	        }
	        $element->count = $this->db->from('contents')->where('main_category', $element->category_id)->count_all_results();
	        $branch[] = $element;

	        if ($element->parent_id == $parent_id) {
	            $children = $this->_getcategoriesrecursive($element->id, $delimiter);
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

	public function page_404()
	{
		$this->output->set_status_header('404');

		$data['header_status'] = '404';
		$data['seo_title'] = '404 Sayfa Bulunamadı';
		$data['viewPage'] = $this->load->view('contents/page_404', $data, true);

		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Languages extends CI_Controller {

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
				f_redir(base_url('backend/contents'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
				
				if($this->input->get_post('sSearch')){
					$this->db->like('name', $this->input->get_post('sSearch', true));
				}
				
				if($this->input->get_post('sSearch_0')){
					$this->db->where('status', $this->input->get_post('sSearch_0'));
				}				
				
				$this->db->from('languages');
	
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
				$item->status_name = $item->status == 'A' ? lang('ACTIVE') : lang('INACTIVE');
			}
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('languages/list', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function add()
	{
		check_perm('languages_add');

		if($this->input->post()){
			$errors = array();
			if(!$this->input->post('name')){$errors[] = "Lütfen başlık alanını boş bırakmayın";}
			if(!$this->input->post('code')){$errors[] = "Lütfen dil kodu alanını boş bırakmayın";}
			if(!$this->input->post('status')){$errors[] = "Lütfen durum alanını boş bırakmayın";}
			if(!$this->input->post('language')){$errors[] = "Lütfen aktarılacak dil seçin";}
			if(count($errors) > 0){
				$data['errors'] = $errors;
			} else {
				$data = array(
					'name' => $this->input->post('name', TRUE),
				    'lang_code' => seo($this->input->post('code', TRUE)),
				    'status' => $this->input->post('status')
				);
				$this->db->insert('languages', $data);
				
				$code_query = $this->db->query("SELECT lang_code FROM ".$this->db->dbprefix('languages')." WHERE id = ?", $this->input->post('language', TRUE));
				
				$get = $this->db->query("SELECT * FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_code = ?", $code_query->lang_code)->result();
				foreach($get as $keys){
					$data2 = array(
						'lang_code' => $this->input->post('code', TRUE),
						'lang_key' => $keys->lang_key,
						'lang_value' => $keys->lang_value
					);
					$this->db->insert('lang_keys', $data2);
				}
				
				f_redir(base_url('backend/languages'), array(lang('SUCCESS')));
			}
		}

		$data['errors'] = $errors;
		$data['viewPage'] = $this->load->view('languages/add', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}
	
	public function edit($id)
	{
		check_perm('languages_edit');
		
		$language = $this->db->from('languages')->where('id', $id)->get()->row();
		if(empty($language)) f_redir(base_url('backend/languages'));
		
		if($this->input->post()){
			$errors = array();
			if(!$this->input->post('name')){$errors[] = "Lütfen başlık alanını boş bırakmayın";}
			if(!$this->input->post('code')){$errors[] = "Lütfen dil kodu alanını boş bırakmayın";}
			if(!$this->input->post('status')){$errors[] = "Lütfen durum alanını boş bırakmayın";}
			if(count($errors) > 0){
				$data['errors'] = $errors;
			} else {
				$status = !$this->input->post('status') ? (int)$this->input->post('status', true) : 1;
				$data = array(
					'name' => $this->input->post('name', TRUE),
				    'lang_code' => seo($this->input->post('code', TRUE)),
				    'status' => $this->input->post('status')
				);
				$this->db->where('id', $id)->update('languages', $data);

				f_redir(base_url('backend/languages/edit/'.$id), array(lang('SUCCESS')));
			}
		}

		$data['errors'] = $errors;
		$data['item'] = $language;
		$data['viewPage'] = $this->load->view('languages/add', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}	

	public function addphrase()
	{
		check_perm('languages_phrase_add');
		
		if($this->input->post()){
			$errors = array();
			if(!$this->input->post('key')){$errors[] = "Lütfen degisken kodu giriniz";}
			if(!$this->input->post('value')){$errors[] = "Lütfen açiklama giriniz";}
			if(count($errors) > 0){
				$data['errors'] = $errors;
			} else {
					$total = $this->db->query("SELECT * FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_key = ? AND lang_code = ? LIMIT 1", array($this->input->post('key', TRUE), DESCR_SL))->num_rows();
					if($total == 0){
						foreach(site_languages() as $key => $value){
							$data = array(
							    'lang_key' => $this->input->post('key', TRUE),
							    'lang_value' => $this->input->post('value'),
							    'lang_code' => $value->lang_code
							);
							$this->db->insert('lang_keys', $data);
						}
					} else {
						$data = array(
						    'lang_value' => $this->input->post('value')
						);
						$this->db->where(array('lang_key' => $this->input->post('key', TRUE), 'lang_code' => DESCR_SL));
						$this->db->update('lang_keys', $data);
					}
				f_redir(current_url(), array(lang('SUCCESS')));
			}
		}

		$data['viewPage'] = $this->load->view('languages/addphrase', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function editphrases($lang_code = '')
	{
		check_perm('languages_phrase_edit');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete')){
				foreach($this->input->post('delete') as $id => $value){
					if($value == 'yes'){
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/languages'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
				
				if($this->input->get_post('sSearch')){
					$this->db->like('lang_key', $this->input->get_post('sSearch', true));
					$this->db->or_like('lang_value', $this->input->get_post('sSearch', true));
				}
				
				if($this->input->get_post('sSearch_0')){
					$this->db->where('lang_code', $this->input->get_post('sSearch_0'));
				} else if(!empty($lang_code)){
					$this->db->where('lang_code', $lang_code);
				}
				
				$this->db->from('lang_keys');
	
			$this->db->stop_cache();
			
			$this->db->select('key_id');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();

			$this->db->flush_cache();
			
			foreach($items as $item){
				$item->lang_value = htmlspecialchars($item->lang_value, ENT_COMPAT);
			}
			
			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('languages/phrases', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function editemptyphrases()
	{
		check_perm('languages_phrase_edit');
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		{
			if($this->input->post('multiple_operation') && ($this->input->post('multiple_operation') == 'multiple_delete') && $this->input->post('delete')){
				foreach($this->input->post('delete') as $id => $value){
					if($value == 'yes'){
						$this->delete($id, false);
					}
				}
				f_redir(base_url('backend/languages'), array(lang('SUCCESS')));
			}
			
			$this->db->start_cache();
				
				if($this->input->get_post('sSearch')){
					$this->db->like('lang_key', $this->input->get_post('sSearch', true));
				}
				
				$this->db->from('lang_keys_empties');
	
			$this->db->stop_cache();
			
			$this->db->select('lang_key');
	
			$total = $this->db->count_all_results();
			
			if($this->input->get('sSortDir_0')){
				$this->db->order_by($this->input->get('mDataProp_'.$this->input->get('iSortCol_0')), $this->input->get('sSortDir_0'));
				$this->db->limit($this->input->get('iDisplayLength'), $this->input->get('iDisplayStart'));
			}
					
			$items = $this->db->get()->result();

			$this->db->flush_cache();
						

			$data['items'] = $items;
			
			if($this->input->get()){
				echo json_encode(array('iTotalRecords' => $total, 'iTotalDisplayRecords' => $total, 'aaData' => $data['items']));
				exit;
			}

		}
		
		$data['viewPage'] = $this->load->view('languages/emptyphrases', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	public function deleteemptyphrase($lang_key)
	{
		check_perm('languages_phrase_delete');
		
		$this->db->query("DELETE FROM ".$this->db->dbprefix('lang_keys_empties')." WHERE lang_key = ?", $lang_key);
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('lang_keys_empties')." AUTO_INCREMENT = 1");
		
		f_redir(base_url('backend/languages/editemptyphrases'), array(lang('SUCCESS')));
	}
		
	public function deletephrase($lang_key)
	{
		check_perm('languages_phrase_delete');
		
		$query = $this->db->query("SELECT lang_key FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_key = ? LIMIT 1", $lang_key)->row();
		if(!empty($query->lang_key)){
			$this->db->query("DELETE FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_key = ?", $lang_key);
			$this->db->query("ALTER TABLE ".$this->db->dbprefix('lang_keys')." AUTO_INCREMENT = 1");
		}
		f_redir(base_url('backend/languages/editphrases'), array(lang('SUCCESS')));
	}

	public function delete($id)
	{
		check_perm('languages_delete');
		
		if($id != 1){
			$query = $this->db->query("SELECT lang_code FROM ".$this->db->dbprefix('languages')." WHERE id = ? AND defaults != ? LIMIT 1", array($id, 'Y'))->row();
			if($query->lang_code){
				$this->db->query("DELETE FROM ".$this->db->dbprefix('languages')." WHERE id = ? AND defaults != ? LIMIT 1", array($id, 'Y'));
				$this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." AUTO_INCREMENT = 1");
				$this->db->query("DELETE FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_code = ?", $query->lang_code);
				$this->db->query("ALTER TABLE ".$this->db->dbprefix('lang_keys')." AUTO_INCREMENT = 1");
			}
		}
		f_redir(base_url('backend/languages'), array(lang('SUCCESS')));
	}

	public function setdefault($id)
	{
		check_perm('languages_edit');
		$this->db->update('languages', array('defaults' => 'N'));
		$this->db->where(array('id' => $id))->update('languages', array('defaults' => 'Y', 'status' => 'A'));
		f_redir(base_url('backend/languages'), array(lang('SUCCESS')));
	}

	public function export($id)
	{
		check_perm('languages_export');
		
		if ( !$id )
		{
			return false;
		}
		
		$language = $this->db->query("SELECT * FROM ".$this->db->dbprefix('languages')." WHERE id = ? LIMIT 1", $id)->row();
		$phrases = $this->db->query("SELECT * FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_code = ?", $language->lang_code)->result_array();

		if ( $phrases )
		{
			$insert = "INSERT INTO `{prefix}lang_keys` (`lang_code`, `lang_key`, `lang_value`) VALUES ". PHP_EOL;
			$lang_name = $language->name. " (". $language->lang_code .")";
			
			$content = "-- Webizm.com | İçerik Yönetim Sistemi". PHP_EOL
					  ."-- Tarih: ". date('d.m.Y') . PHP_EOL
					  ."-- Version: v5.0". PHP_EOL
					  ."-- Site Dili: {$lang_name}". PHP_EOL
					  ."-- http://www.webizm.com/". PHP_EOL . PHP_EOL
					  ."INSERT INTO `{prefix}languages` (`name`, `lang_code`, `direction`, `status`, `date_format`) VALUES ('{$language->name}', '{$language->lang_code}', '{$language->direction}', '{$language->status}', '{$language->date_format}');". PHP_EOL . PHP_EOL;
					  
			$content .= $insert;
			
			foreach ( $phrases as $key => $value )
			{
				$tmp = <<<VS
('$language->lang_code', '$value[lang_key]', '$value[lang_value]')
VS;
				
				if ( count($phrases)-1 == $key )
				{
					$content .= $tmp .';';
				}
				else
				{
					if ( $key%500 == 0 && $key != 0 )
					{
						$content .= $tmp .';'. PHP_EOL . $insert;
					}
					else
					{
						$content .= $tmp .','. PHP_EOL;
					}
				}
			}
			header('Content-Type: application/download');
    		header('Content-Disposition: attachment; filename='.$language->name.'('.$language->lang_code.').sql');
			echo $content;
			exit;
		} else {
			echo "Dil dosyasina ait girilmis herhangi bir deger yok.";
			exit;
		}
	}

	public function import()
	{
		check_perm('languages_import');
		
		$errors = array();
		
		if($_FILES){
			$dump_sours = $_FILES['dump']['tmp_name'];
			$dump_file = $_FILES['dump']['name'];
			preg_match( "/\(([a-z]{2})\)(\.sql)/", $dump_file, $matches );
			
			if (!empty($matches[1]) && $matches[2] == '.sql')
			{
				if ( is_readable($dump_sours) )
				{
					$dump_content = fopen($dump_sours, "r");
					$this->db->query("SET NAMES `utf8`");
					
					if ($dump_content)
					{
						/* check exist language */
						$query = $this->db->query("SELECT * FROM ".$this->db->dbprefix('languages')." WHERE lang_code = ?", $matches[1]);
						if  ( $exist_lang_key = $query->lang_code)
						{
							$errors[] = str_replace(array('{language}', '{code}'), array($query->name, $matches[1]), "Bu dil kullanimdadir!");
						}
						else
						{
							while ( $query = fgets ( $dump_content, 10240) )
							{
								$query = trim($query);
								if ( $query[0] == '#' ) continue;
								if ( $query[0] == '-' ) continue;
								
								if ( $query[strlen($query)-1] == ';' )
								{
									$query_sql .= $query;
								}
								else
								{
									$query_sql .= $query;
									continue;
								}
								
								if (!empty($query_sql) && empty($errors))
								{
									$query_sql = str_replace('{prefix}', $this->db->dbprefix, $query_sql);
								}
								
								$res = $this->db->query( $query_sql );
								if (!$res && count($errors) < 5)
								{
									$errors[] = "MySQL çalistirilamadi " . mysql_error();
								}
								unset($query_sql);
							}
							
							fclose($dump_content);
							
							if (empty($errors))
							{
								$lang_code = $matches[1];
								$query = $this->db->query("SELECT lang_code FROM ".$this->db->dbprefix('languages')." WHERE defaults = ? LIMIT 1", 'Y')->row();
								$imported = $this->db->query("SELECT lang_key, lang_value FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_code = ?", $lang_code)->result_array();
								$defaults = $this->db->query("SELECT lang_key, lang_value FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_code = ?", $query->lang_code)->result_array();
								$differents = array_diff_assoc($defaults, $imported);
								foreach($differents as $value){
									$data = array(
										'lang_key' => $value[0],
										'lang_value' => $value[1],
										'lang_code' => $lang_code
									);
									$this->db->insert('lang_keys', $data);
								}
								f_redir(base_url('backend/languages'), array(lang('SUCCESS')));
							}
							else
							{
								$errors[] = "Içeri aktarilmaya çalisilan dil dosyasi bozuktur";
							}
						}
					}
					else
					{
						$errors[] = "Içerik aktarilmaya çalisilan dil dosyasi bostur";
					}
				}
				else
				{
					$errors[] = "Içerik aktarilmaya çalisilan dil dosyasi okunamiyor";
				}
			}
			else
			{
				$errors[] = "Dil dosyasi yükleme islemi hatalidir";
			}
			
			if (sizeof($errors) > 0)
			{
				$data['errors'] = $errors;
			}
		}
		
		$data['errors'] = $errors;
		$data['viewPage'] = $this->load->view('languages/import', $data, true);
		
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}

	public function update()
	{
		if(check_perm('languages_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('name')){
			
			$post = array(); foreach($_POST as $key => $val){ $post[$key] = $this->input->post($key, TRUE); }  
			
			foreach ($post['name'] as $nid => $var)
			{
				$check_other_conflict = $this->db->query("SELECT lang_code FROM ".$this->db->dbprefix('languages')." WHERE id != ? AND lang_code = ? LIMIT 1", array($nid, $_POST['code'][$nid]))->num_rows();
				if($check_other_conflict > 0){
					echo "Bu dil kodu baska bir dilde kullaniliyor!";
					exit;
				}
				$check_lang_code = $this->db->query("SELECT lang_code FROM ".$this->db->dbprefix('languages')." WHERE id='".$nid."' LIMIT 1")->row();
				if($check_lang_code->lang_code != $post['code'][$nid]){
					$this->db->where(array('lang_code' => $check_lang_code->lang_code));
					$this->db->update('lang_keys', array('lang_code' => $post['code'][$nid]));
				}
				
				//Varsayilan dil pasif olamaz :)
				if($post['status'][$nid] != 'A'){
					$total = $this->db->query("SELECT id FROM ".$this->db->dbprefix('languages')." WHERE id = ? AND defaults = ? LIMIT 1", array($nid, 'Y'))->num_rows();
					if($total > 0){
						$status = 'A';
					} else {
						$status = $post['status'][$nid];
					}
				} else {
					$status = $post['status'][$nid];
				}
				
				if(!empty($post['name'][$nid]))
				{
					$data = array(
						'name' => $post['name'][$nid],
						'lang_code' => $post['code'][$nid],
						'status' => $status,
						'direction' => $post['direction'][$nid],
						'date_format' => $post['date_format'][$nid]
					);
					$this->db->where(array('id' => (int)$nid))->update('languages', $data);
				}
			}
		}
		echo json_encode(lang('SUCCESS'));
	}
	
	public function updatephrase()
	{
		if(check_perm('languages_phrase_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $this->input->post('name') && $this->input->post('pk') && $this->input->post('value'))
		{
			$this->db->where(array('lang_key' => $this->input->post('name'), 'lang_code' => $this->input->post('pk')));
			$this->db->update('lang_keys', array('lang_value' => $this->input->post('value')));
		}		
	}

	public function updateemptyphrases()
	{
		if(check_perm('languages_phrase_edit', TRUE) == FALSE){
			echo json_encode(array('res' => 'ERROR', 'msg' => lang('NO_PERM')));
			return false;
		}
		
		if($this->input->post('name') && $this->input->post('value')){
			foreach(site_languages() as $k => $v)
			{
				$check = $this->db->query("SELECT lang_key FROM ".$this->db->dbprefix('lang_keys')." WHERE lang_key = ? AND lang_code = ?", array($this->input->post('name'), $v->lang_code))->row();
				if(empty($check->lang_key))
				{
					$data = array(
						'lang_key' => $this->input->post('name'),
						'lang_value' => $this->input->post('value'),
						'lang_code' => $v->lang_code
					);
					$this->db->insert('lang_keys', $data);
				}
			}
			$this->db->query("DELETE FROM ".$this->db->dbprefix('lang_keys_empties')." WHERE lang_key = ?", $this->input->post('name'));
		}
		echo json_encode(lang('SUCCESS'));
	}
}
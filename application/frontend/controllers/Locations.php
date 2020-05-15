<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends CI_Controller {

   public function __construct(){
        parent::__construct();
		$this->load->model('locations_model');
    }
    	
	public function gettowns()
	{	
		return $this->response($this->locations_model->get_locations('locations_towns', ['city_id' => (int)$this->input->get_post('city', true)]), false, '', lang('CONTENTS_EMPTY'));
	}
	
	public function gettownssearch()
	{
				
		return $this->response($this->locations_model->get_locations('locations_towns', ['city_id' => (int)$this->input->get_post('city', true)]), true, lang('ALL'), lang('ALL'));
	}
	
	/*
		(array) $items
		(bool) $please_select
		(string) $please_select_text
		(string) $empty_text
	*/
	public function response($items, $please_select = true, $please_select_text = '', $empty_text = '')
	{
		$please_select_text = $please_select_text ? $please_select_text : lang('PLEASE_SELECT');
		$empty_text = $empty_text ? $empty_text : lang('CONTENTS_EMPTY');
		
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{	
			if(!empty($items))
			{	
				if($please_select == true)
				$i[0] = array('id' => '', 'name' => "-- ".$please_select_text." --");
				foreach($items as $key => $item){
					$key = $please_select == true ? $key + 1 : $key;
					$i[$key] = array('id' => $item->id, 'name' => $item->title);
				}
			} else {
				$i[0] = array('id' => '', 'name' => "-- ".$empty_text." --");
			}
			echo json_encode($i, JSON_FORCE_OBJECT);
			exit;
		}
		
		return $items;
	}	
}

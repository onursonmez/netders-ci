<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {
	
    public function __construct()
    {
        parent::__construct();
    }
    
    public function check_same_order_in_cart($product_id, $check_data = array())
    {
		if(empty($product_id)) return false;
		
		if(!empty($check_data['subject_id']) && !empty($check_data['level_id']) && !empty($check_data['start_date'])){
			$this->db->where('subject_id', $check_data['subject_id']);
			$this->db->where('level_id', $check_data['level_id']);
			$this->db->where("(start_date IS NOT NULL AND (start_date >= $check_data[start_date] && start_date <= $check_data[start_date]) OR start_date IS NULL)", NULL, FALSE);
		}
		
		return $this->db->from('orders_temp')->where('uid', $this->session->userdata('user_id'))->where_in('product_id', $product_id)->where('transaction_id IS NULL')->count_all_results();
    }

    public function check_other_services_in_cart($product_id)
    {
		if(empty($product_id)) return false;
		
		$order = $this->db
			->select('o.id')
			->from('orders_temp o')
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->where('o.uid', $this->session->userdata('user_id'))
			->where('o.product_id !=', $product_id)
			->where('sp.type', 2)
			->where('o.transaction_id IS NULL')
			->order_by('o.id ASC')
			->get()->row();
		
		return !empty($order->id) ? $order->id : NULL;
    }    
    
    public function get_product_by($where = array())
    {
	    if(empty($where)) return false;
	    
	    return $this->db->from('settings_prices')->where($where)->get()->row();
    }
    
    public function get_order_by($where = array())
    {
	    if(empty($where)) return false;
	    
	    $orders = $this->db->from('orders')->where($where)->get()->row();
	    
	    if(!empty($orders)){
		    foreach($orders as $order){
			    if(!empty($order->subject_id) && !empty($order->level_id)){
				    $order->subject_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
				    $order->level_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
			    }
		    }
	    }
	    
	    return $orders;
    }   
    
    public function get_orders_by($where = array())
    {
	    if(empty($where)) return false;
	    
	    $orders = $this->db->from('orders')->where($where)->get()->result();
	    
	    if(!empty($orders)){
		    foreach($orders as $order){
			    if(!empty($order->subject_id) && !empty($order->level_id)){
				    $order->subject_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
				    $order->level_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
			    }
		    }
	    }
	    
	    return $orders;
    }        
    
  
    
    public function shopping_cart_count()
    {
    	if(!$this->session->userdata('user_id')) return false;
    	
		return $this->db
			->select('o.id')
			->from('orders_temp o')
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->where('o.uid', $this->session->userdata('user_id'))
			->where('sp.type', 2)
			->where('o.transaction_id IS NULL')
			->count_all_results();
    }
    
    public function shopping_cart_orders()
    {
    	if(!$this->session->userdata('user_id')) return false;
    	
		return $this->db
			->select('o.*, sp.title, sp.description, sc.title subject_title, lc.title level_title')
			->from('orders_temp o')
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->join('contents_categories sc', 'sc.category_id=o.subject_id', 'left')
			->join('contents_categories lc', 'lc.category_id=o.level_id', 'left')
			->where('o.uid', $this->session->userdata('user_id'))
			->where("((o.subject_id IS NOT NULL && sc.lang_code = '".$this->session->userdata('site_sl')."') || o.subject_id IS NULL)")
			->where("((o.level_id IS NOT NULL && lc.lang_code = '".$this->session->userdata('site_sl')."') || o.level_id IS NULL)")
			->where('sp.type', 2)
			->where('o.transaction_id IS NULL')
			->order_by('o.id ASC')
			->get()->result();
    } 
    
    public function get_membership_order($temp = '')
    {
    	if(!$this->session->userdata('user_id')) return false;
    	
		return $this->db
			->select('o.*, sp.title, sp.description')
			->from("orders$temp o")
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->where('o.uid', $this->session->userdata('user_id'))
			->where('sp.type', 1)
			->where('o.transaction_id IS NULL')
			->order_by('o.id DESC')
			->get()->row();
    }
    
   
   public function get_last_payed_membership_orders($user_id)
    {
    	if(!$this->session->userdata('user_id')) return false;
    	
		return $this->db
			->select('o.*, sp.title, sp.description, sp.unix_date')
			->from('orders o')
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->where('o.uid', (int)$user_id)
			->where('sp.type', 1)
			->where_not_in('o.product_id', array(30,31))
			->where('o.transaction_id IS NOT NULL')
			->where('o.end_date >', time())
			->where('o.status', 'A')
			->order_by('o.id DESC')
			->get()->result();
    }
    
  public function get_payed_orders()
    {
    	if(!$this->session->userdata('user_id')) return false;
    	
		return $this->db
			->select('o.*, sp.title, sp.string_date, re.username referee_username, sp.description, sp.unix_date, sc.title subject_title, lc.title level_title')
			->from('orders o')
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->join('contents_categories sc', 'sc.category_id=o.subject_id', 'left')
			->join('contents_categories lc', 'lc.category_id=o.level_id', 'left')			
			->join('users re', 'o.referee_id=re.id', 'left')			
			->where('o.uid', $this->session->userdata('user_id'))
			->where("(o.subject_id IS NOT NULL && sc.lang_code = '".$this->session->userdata('site_sl')."' || o.subject_id IS NULL)")
			->where("(o.level_id IS NOT NULL && lc.lang_code = '".$this->session->userdata('site_sl')."' || o.level_id IS NULL)")			
			->order_by('o.id DESC')
			->get()->result();
    }      
    
    public function check_date_is_exist($check_data = array()){
    
    	if(empty($check_data)) return false;
    	
		return $this->db
		->select('id')
		->from('orders')
		->where('subject_id', $check_data['subject_id'])
		->where('level_id', $check_data['level_id'])
		->where('start_date', $check_data['start_date'])
		->where_in('product_id', $check_data['product_id'])
		->count_all_results();
    }
    
    public function get_unavailable_dates($unavailable_data = array())
    {
    	if(empty($unavailable_data)) return false;
    	
		return $this->db
		->select("from_unixtime(start_date, '%d.%m.%Y') start_date, from_unixtime(end_date, '%d.%m.%Y') end_date")
		->from('orders')
		->where('subject_id', $unavailable_data['subject_id'])
		->where('level_id', $unavailable_data['level_id'])
		->where('end_date >', time())
		->where_in('product_id', $unavailable_data['product_id'])
		->group_by('start_date')
		->get()->result();
    } 
    
    public function recalculate_cart(){
	    $orders = $this->shopping_cart_orders();
	    if(!empty($orders)){
	    	$user_price = mtp(user_money($this->session->userdata('user_id')));
		    foreach($orders as $order){
		    	if($this->session->userdata('user_use_money') == 'Y' && $user_price > 0){
				    if($order->price > $user_price){
				    	$order_data = array(
				    		'used_money' => ptm($user_price),
				    		'payed_price' => $order->price - $user_price
				    	);
					    $this->db->where('id', $order->id)->update('orders_temp', $order_data);
					    $user_price = 0;
				    } else {
				    	$order_data = array(
				    		'used_money' => ptm($order->price),
				    		'payed_price' => 0
				    	);
					    $this->db->where('id', $order->id)->update('orders_temp', $order_data);
					    $user_price -= $order->price;
				    }
			    } else {
			    	$order_data = array(
			    		'used_money' => 0,
			    		'payed_price' => $order->price
			    	);
				    $this->db->where('id', $order->id)->update('orders_temp', $order_data);				    
			    }
		    }
	    }
    }  










    public function get_orders_temp_by($where = array())
    {
	    if(empty($where)) return false;
	    
	    $orders = $this->db->from('orders_temp')->where($where)->get()->result();
	    
	    if(!empty($orders)){
		    foreach($orders as $order){
			    if(!empty($order->subject_id) && !empty($order->level_id)){
				    $order->subject_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
				    $order->level_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
			    }
		    }
	    }
	    
	    return $orders;
    }  
    
    public function get_order_temp_by($where = array())
    {
	    if(empty($where)) return false;
	    
	    $order = $this->db->from('orders_temp')->where($where)->get()->row();
	    
	    if(!empty($order)){
		    if(!empty($order->subject_id) && !empty($order->level_id)){
			    $order->subject_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->subject_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
			    $order->level_title = $this->db->select('title')->from('contents_categories')->where('category_id', $order->level_id)->where('lang_code', $this->session->userdata('site_sl'))->get()->row()->title;
		    }
	    }
	    
	    return $order;
    } 
    
    public function create_order_temp($order_data)
    {
    	if(empty($order_data)) return false;
		
		$this->load->library('user_agent');
		
		$order_data['uagent'] 	= $this->agent->agent_string();
		$order_data['date'] 	= time();
		$order_data['ip'] 		= $this->input->ip_address();
		
		$this->db->insert('orders_temp', $order_data);
		
		$insert_id = $this->db->insert_id();
		
		$oid = isset($order_data['oid']) ? $order_data['oid'] : $insert_id;
		$this->update_order_temp(array('id' => $insert_id), array('oid' => $oid));

		return $insert_id;
    }
    
	public function update_order_temp($where = array(), $update = array())
	{
		if(empty($where) || empty($update)) return false;
		
		$this->db->where($where)->update('orders_temp', $update);
	}  
    
    public function delete_order_temp($id, $user_id)
    {
    	if(empty($id) || empty($user_id)) return false;
		$this->db->where('id', (int)$id)->where('uid', (int)$user_id)->delete('orders_temp');
    }  
    	
	public function update_order_temp_to_order($id = null)
	{
		if(empty($id)) return false;
		
		$order = $this->get_order_temp_by(array('id' => $id));
		if(!empty($order))
		{
			$temp_orders = $this->db->where('id', $id)->get('orders_temp')->result_array();
			
			if(!empty($temp_orders)){
				foreach($temp_orders as $temp_order){
					unset($temp_order['id']);
					$this->db->insert('orders', $temp_order);
				}	
			}
		}
	}  	
	
    public function delete_memberships_orders_temp($uid = null)
    {
    	if(!$this->session->userdata('user_id') && empty($uid)) return false;
    	
    	$user_id = $uid ? $uid : $this->session->userdata('user_id');
    	
		$orders = $this->db
			->select('o.id')
			->from('orders_temp o')
			->join('settings_prices sp', 'sp.id=o.product_id', 'left')
			->where('o.uid', $user_id)
			->where('sp.type', 1)
			->get()->result();
			
		foreach($orders as $order){
			$this->db->where('id', $order->id)->where('uid', $user_id)->delete('orders_temp');
		    $this->db->query("ALTER TABLE ".$this->db->dbprefix('orders_temp')." AUTO_INCREMENT = 1");		
		}
    } 
}
?>
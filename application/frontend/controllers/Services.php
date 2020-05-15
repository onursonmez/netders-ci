<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {
	
	var $template = 'pages/wrapper';

   public function __construct(){
        parent::__construct();
		$this->load->helper(array('form'));
		$this->load->library('form_validation');        
		$this->load->model('payment_model');
		$this->load->model('users_model');
		$this->config->set_item('language', $this->session->userdata('site_sl'));
    }

	/******************************************
	* Servislerin listelendiği sayfa
	******************************************/	
	public function index()
	{
		is_notloggedin_redir(site_url('giris'));

		if(!is_teacher()) redir(site_url('users/my'), array('Ücretli hizmetleri yalnızca eğitmen hesapları kullanabilir!'), '', '', TRUE);
		
		if($this->session->userdata('user_email_request')) redir(site_url('users/my'), array('Ücretli hizmetleri kullanabilmek için öncelikle e-posta adresinize gönderilen aktivasyon bağlantısına tıklayınız!'), '', '', TRUE);
				
		if($this->input->get('get_levels')){
			header('Content-type: application/json');
			$items = $this->users_model->get_levels((int)$this->input->get_post('subject_id', true));
			if(!empty($items)){
				$i[0] = array('id' => '', 'name' => "-- ".lang('PLEASE_SELECT')." --");
				foreach($items as $key => $item){
					$i[$key + 1] = array('id' => $item->id, 'name' => $item->title);
				}
			} else {
				$i[0] = array('id' => '', 'name' => lang('CONTENTS_EMPTY'));
			}
			echo json_encode($i, JSON_FORCE_OBJECT);			
			exit;
		}
		
		$data = array();

		$items = $this->db->from('settings_prices')->get()->result();
		foreach($items as $item){
			$prices[$item->id] = $item;
		}
		$data['price'] = $prices;
		
		$data['categories'] = $this->db->from('contents_categories')->where('parent_id', 6)->where('lang_code', $this->session->userdata('site_sl'))->get()->result();
				
		$data['viewPage'] = $this->load->view('services/index', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);					
	}
	
	public function buy()
	{
		is_notloggedin_redir(site_url('giris'));
		
		$errors 		= array();
		$messages 		= array('Ürün alışveriş sepetinize eklenmiştir.');
		$redir 			= site_url('services/cart');
		$call			= 'checkCart()';
		$start_date 	= NULL;
		$end_date 		= NULL;
		$subject_id 	= $this->input->post('subject') 	? (int)$this->input->post('subject', true) 		: NULL;
		$level_id 		= $this->input->post('level') 		? (int)$this->input->post('level', true) 		: NULL;
		$product_id 	= $this->input->post('product_id') 	? (int)$this->input->post('product_id', true) 	: NULL;
		$date 			= $this->input->post('date') 		? $this->input->post('date', true) 				: NULL;

		if(!empty($date))
		{
			if(strstr($date, '-'))
			{
				$date 		= explode('-', $date);
				$start_date = explode('.', trim($date[0]));
				$end_date 	= explode('.', trim($date[1]));
				$start_date = mktime(0,0,0,$start_date[1],$start_date[0],$start_date[2]);
				$end_date	= mktime(23,59,59,$end_date[1],$end_date[0],$end_date[2]);
			} else {
				$date 		= explode('.', $date);
				$start_date = mktime(0,0,0,$date[1],$date[0],$date[2]);
				$end_date 	= mktime(23,59,59,$date[1],$date[0],$date[2]);
			}	
		}
		
		switch($product_id)
		{
			case 11: //rozet starter
			case 12: //rozet advanced
			case 13: //rozet premium
				$this->form_validation->set_rules('aggrement', 'Uzman eğitmen rozeti şartları', 'trim|required');
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();	
				} else {								
					if($this->payment_model->check_same_order_in_cart($product_id))
					$errors[] = 'Bu ürün zaten alışveriş sepetindedir.';
					
					if($this->session->userdata('user_service_badge') != 'N')
					$errors[] = 'Bu ürün daha önce satın alınmıştır.';
				}
			break;
			
			case 20: //özel sayfa starter
			case 21: //özel sayfa advanced
				if($this->payment_model->check_same_order_in_cart($product_id))
				$errors[] = 'Bu ürün zaten alışveriş sepetindedir.';
				
				if($this->session->userdata('user_service_web') != 'N')
				$errors[] = 'Bu ürün daha önce satın alınmıştır.';				
			break;
			
			case 9: //öne çıkanlar starter
			case 10: //öne çıkanlar advanced
				if($this->payment_model->check_same_order_in_cart($product_id)){
					$errors[] = 'Bu ürün zaten alışveriş sepetindedir.';
				}
			break;
			
			case 14: //haftalık doping starter
			case 15: //haftalık doping advanced
			case 16: //haftalık doping premium
			case 17: //aylık doping starter
			case 18: //aylık doping advanced
			case 19: //aylık doping premium
				if($this->payment_model->check_same_order_in_cart($product_id)){
					$errors[] = 'Bu ürün zaten alışveriş sepetindedir.';
				}
			break;
			
			case 22: //günün eğitmeni advanced
			case 23: //günün eğitmeni premium
			case 24: //haftanın eğitmeni advanced
			case 25: //haftanın eğitmeni premium
			case 26: //ayın eğitmeni advanced
			case 27: //ayın eğitmeni premium
				$this->form_validation->set_rules('subject', 'Konu', 'trim|required');
				$this->form_validation->set_rules('level', 'Ders', 'trim|required');
				$this->form_validation->set_rules('date', 'Tarih', 'trim|required');
				if ($this->form_validation->run() == FALSE){
					$errors = $this->form_validation->error_array();	
				} else {
					//eger haftanin egitmeni ise baslangic gunun haftanin ilk gunu mu kontrol et				
					if(($product_id == 24 || $product_id == 25) && (date('l', $start_date) != 'Monday' && date('l', $start_date) != 'Pazartesi'))
					$errors[] = 'Seçilen tarihin başlangıcı günü haftanın ilk günü değildir.';
					
					//eger haftanin egitmeni ise başlangıç ile bitiş arasında 7 gün varmı kontrol et
					if(($product_id == 24 || $product_id == 25) && ceil(abs($end_date - $start_date) / 86400) != 7)
					$errors[] = 'Seçilen tarih aralığı 7 gün değildir.';
					
					//eger ayin egitmeni ise başlangıç tarihi ayın ilk günü mü kontrol et
					if(($product_id == 26 || $product_id == 27) && date('j', $start_date) != 1)
					$errors[] = 'Seçilen tarih ayın ilk gününden başlamamaktadır.';
					
					//eger ayin egitmeni ise sonlanma tarihi ayın son günü mü kontrol et
					if(($product_id == 26 || $product_id == 27) && date('d', $end_date) != date('t', $end_date))
					$errors[] = 'Seçilen tarihin sonlanma tarihi ayın son günü değildir.';
					
					//eger ayin egitmeni ise seçilen tarih gün sayısı ilgili ay gün sayısı kadarmı kontrol et
					if(($product_id == 26 || $product_id == 27) && ceil(abs($end_date - $start_date) / 86400) != date('t', $start_date))
					$errors[] = 'Seçilen tarihteki gün sayısı ilgili ayın gün sayısından farklıdır.';				
								
					$check_data = array(
						'start_date' 	=> $start_date,
						'subject_id' 	=> $subject_id, 
						'level_id' 		=> $level_id, 
						'product_id' 	=> array(22,23,24,25,26,27)
					);
					if($this->payment_model->check_date_is_exist($check_data)){
						$errors[] = 'Seçilen tarih müsait değildir. Lütfen başka bir tarih seçiniz.';
					}
	
					$check_data = array(
						'start_date' 	=> $start_date,
						'subject_id' 	=> $subject_id, 
						'level_id' 		=> $level_id, 
						'product_id' 	=> $product_id
					);	
					if($this->payment_model->check_same_order_in_cart($product_id, $check_data)){
						$errors[] = 'Bu ürün zaten alışveriş sepetindedir.';
					}
				}
			break;								
		}
		
		if(empty($errors))
		{
			$order_data = array(
				'uid' 			=> $this->session->userdata('user_id'),		
				'product_id' 	=> $product_id,
				'start_date' 	=> $start_date,
				'end_date' 		=> $end_date,
				'subject_id' 	=> $subject_id,
				'level_id' 		=> $level_id,
			);
			$order_data = $this->_prepare_order($order_data);
			$this->payment_model->create_order_temp($order_data);		
			$this->payment_model->recalculate_cart();
		}
		
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
			$res 		= empty($errors) 	? 'OK' 			: 'ERR';
			$messages 	= empty($errors) 	? $messages 	: $errors;
			$redir 		= empty($errors) 	? $redir 		: false;
			$call 		= empty($errors) 	? $call 		: false;
			echo json_encode(array('RES' => $res, 'MSG' => $messages, 'REDIR' => $redir, 'CALL' => $call, 'CSRF_NAME' => $this->security->get_csrf_token_name(), 'CSRF_HASH' => $this->security->get_csrf_hash()));
			exit;
		} else {
			if(!empty($errors)){
				redir($_SERVER['HTTP_REFERER'], $errors, '', '', TRUE);
			} else {
				redir(current_url(), $messages);
			}
		}		
	}
	
	public function cart()
	{
		is_notloggedin_redir(site_url('giris'));
		
		if(!is_teacher()) redir(site_url('users/my'), array('Ücretli hizmetleri yalnızca eğitmen hesapları kullanabilir!'), '', '', TRUE);
		
		if($this->session->userdata('user_email_request')) redir(site_url('users/my'), array('Ücretli hizmetleri kullanabilmek için öncelikle e-posta adresinize gönderilen bağlantıya tıklayarak e-posta adresinizi aktive ediniz!'), '', '', TRUE);	
	
		$total_price 			= 0;
		$total_payed_price 		= 0;
		$total_used_money 		= 0;
		$data 					= array();
		$errors 				= array();
		$complete				= false;
							
		if($this->input->get('delete')){
			$this->payment_model->delete_order_temp((int)$this->input->get('delete', true), $this->session->userdata('user_id'));
			redir(site_url('services/cart'), array('Ürün alışveriş sepetinden başarıyla kaldırılmıştır.'));
		}
		
		if($this->input->get('use_money'))
		{
			$use_money = $this->input->get('use_money') == 'Y' ? 'Y' : 'N';
			$this->users_model->update_user(array('id' => $this->session->userdata('user_id')), array('use_money' => $use_money));
			$this->payment_model->recalculate_cart();			
			redir(site_url('services/cart'));
		}

		$orders = $this->payment_model->shopping_cart_orders();
		
		if(empty($orders)) redir(site_url('services'), array('Alışveriş sepetinizde ürün bulunmamaktadır!'), '', '', TRUE);	
					
		if(!empty($orders)){
			foreach($orders as $order){
				$total_price 		+= $order->price;
				$total_payed_price 	+= $order->payed_price;
				$total_used_money	+= $order->used_money;
			}
		}
		
		$data['orders'] = array('orders' => $orders, 'total_price' => $total_price, 'total_payed_price' => $total_payed_price, 'total_used_money' => $total_used_money);
			
		if($this->input->post())
		{
			$this->form_validation->set_rules('aggrement', 'Satış sözleşmesi', 'trim|required');
			if($this->form_validation->run() == FALSE)
			$errors = $this->form_validation->error_array();			

			if(empty($orders))
			$errors[] = 'Alışveriş sepetinizde ürün bulunmamaktadır!';
								
			if(empty($errors))
			{
				if($total_payed_price == 0)
				{
					$response = $this->_complete_services($orders[0]->oid);
					if($response == true) redir(site_url('services/complete'));
				} else {
					$this->form_validation->set_rules('identity_no', 'T.C. kimlik numarası', 'trim|required');
					$this->form_validation->set_rules('address', 'Adres', 'trim|required');
						
					if($this->form_validation->run() == FALSE)
					$errors = $this->form_validation->error_array();
					
					if(!$this->session->userdata('user_firstname'))
					$errors[] = 'Sipariş verebilmek için adınızın profil bilgilerinizde tanımlı olması gerekmektedir!';
					
					if(!$this->session->userdata('user_lastname'))
					$errors[] = 'Sipariş verebilmek için soyadınızın profil bilgilerinizde tanımlı olması gerekmektedir!';
					
					if(!$this->session->userdata('user_mobile'))
					$errors[] = 'Sipariş verebilmek için cep telefonu numaranızın profil bilgilerinizde tanımlı olması gerekmektedir!';
					
					if(!$this->session->userdata('user_email'))
					$errors[] = 'Sipariş verebilmek için e-posta adresinizin profil bilgilerinizde tanımlı olması gerekmektedir!';
					
					if(!$this->session->userdata('user_city'))
					$errors[] = 'Sipariş verebilmek için bulunduğunuz şehrin profil bilgilerinizde tanımlı olması gerekmektedir!';
					
					if(!$this->session->userdata('user_town'))
					$errors[] = 'Sipariş verebilmek için bulunduğunuz ilçenin profil bilgilerinizde tanımlı olması gerekmektedir!';			
					
					//Bilgileri iyzicoya gonder
					if(empty($errors))
					{	
						$user = $this->users_model->get_user_data($this->session->userdata('user_id'));
						
						require_once(APPPATH . 'libraries/iyzipay-php-2.0.25/samples/config.php');
								
						# create request class
						$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
						$request->setLocale(\Iyzipay\Model\Locale::TR);
						$request->setConversationId($data['orders']['orders'][0]->oid);
						$request->setPrice($total_payed_price);
						$request->setPaidPrice($total_payed_price);
						$request->setCurrency(\Iyzipay\Model\Currency::TL);
						$request->setBasketId($data['orders']['orders'][0]->oid);
						$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);
						$request->setCallbackUrl(site_url('services/callback'));
						if($total_payed_price >= format_price(50)){
							$request->setEnabledInstallments(array(2, 3, 6, 9));
						} else {
							$request->setEnabledInstallments(array(1));
						}
						
						$buyer = new \Iyzipay\Model\Buyer();
						$buyer->setId($user->id);
						$buyer->setName($user->firstname);
						$buyer->setSurname($user->lastname);
						$buyer->setGsmNumber(str_replace(' ', '', $user->mobile));
						$buyer->setEmail($user->email);
						$buyer->setIdentityNumber((int)$this->input->post('identity_no'));
						$buyer->setLastLoginDate(date('Y-m-d H:i:s', $user->lastactive));
						$buyer->setRegistrationDate(date('Y-m-d H:i:s', $user->joined));
						$buyer->setRegistrationAddress($this->security->xss_clean($this->input->post('address', true)));
						$buyer->setIp(getip());
						$buyer->setCity($user->city_title);
						$buyer->setCountry("Turkey");
						$buyer->setZipCode("");
						$request->setBuyer($buyer);
						
						$shippingAddress = new \Iyzipay\Model\Address();
						$shippingAddress->setContactName($user->firstname . ' ' . $user->lastname);
						$shippingAddress->setCity($user->city_title);
						$shippingAddress->setCountry("Turkey");
						$shippingAddress->setAddress($this->security->xss_clean($this->input->post('address', true)));
						$shippingAddress->setZipCode("");
						$request->setShippingAddress($shippingAddress);
						
						$billingAddress = new \Iyzipay\Model\Address();
						$billingAddress->setContactName($user->firstname . ' ' . $user->lastname);
						$billingAddress->setCity($user->city_title);
						$billingAddress->setCountry("Turkey");
						$billingAddress->setAddress($this->security->xss_clean($this->input->post('address', true)));
						$billingAddress->setZipCode("");
						$request->setBillingAddress($billingAddress);
						
						$basketItems = array();
						foreach($orders as $order)
						{
							if($order->payed_price > 0){
								$basketItem = new \Iyzipay\Model\BasketItem();
								$basketItem->setId($order->id);
								$basketItem->setName($order->title);
								$basketItem->setCategory1("Hizmet");
								$basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
								$basketItem->setPrice($order->payed_price);
								$basketItems[] = $basketItem;		
							}	
						}
						
						$request->setBasketItems($basketItems);
										
						# make request
						$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());
						
						if($checkoutFormInitialize->getStatus() != 'success'){
							$errors[] = txtFirstUpper($checkoutFormInitialize->getErrorMessage());
						}
						
						if(empty($errors)){
							$data['payment_form'] = $checkoutFormInitialize->getCheckoutFormContent();
							
							//update user identity no, address
							$this->users_model->update_user(array('id' => $user->id), array('identity_no' => (int)$this->input->post('identity_no'), 'address' => $this->input->post('address', true)));
						}
					}
				}
			}	
		}
		
		$data['errors'] = $errors;
		
		$data['viewPage'] = $this->load->view('services/cart', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);
	}

	/******************************************
	* Ödeme sonucunun callback adresi
	******************************************/				
	public function callback()
	{	
		require_once(APPPATH . 'libraries/iyzipay-php-2.0.25/samples/config.php');
				
		$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
		$request->setLocale(\Iyzipay\Model\Locale::TR);
		$request->setConversationId("");
		$request->setToken($this->input->post('token', true));
		$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

		$json_result = $checkoutForm->getRawResult();
		$result = json_decode($json_result);
		
		//Karttan para cekilemediyse
		if($result->paymentStatus != 'SUCCESS'){
			$redirect_url = isset($result->errorMessage) ? site_url('services/error?message='.$result->errorMessage) : site_url('services/error');
			redir($redirect_url);
		}
		
		//Karttan para cekildiyse
		if($result->paymentStatus == 'SUCCESS')
		{
			foreach($result->itemTransactions as $item)
			{
				$order = $this->payment_model->get_order_temp_by(array('id' => (int)$item->itemId));
				
				if(!empty($order)){
					$statuses = array(2 => 'A', 0 => 'P', -1 => 'D');
					$this->payment_model->update_order_temp(array('id' => (int)$item->itemId), array('transaction_id' => $item->paymentTransactionId, 'status' => $statuses[(int)$item->transactionStatus]));
				}
			}
			
			$this->payment_model->update_order_temp(array('oid' => (int)$result->basketId), array('payment_id' => (int)$result->paymentId, 'payment_data' => serialize($json_result)));
			
			$response = $this->_complete_services((int)$result->basketId);
			
			if($response == true){
				redir(site_url('services/complete?order='.$result->paymentId));			
			} else {
				redir(site_url('services/error?message='.$response));
			}
		}
	}
	
	public function complete()
	{		
		$data = array();
		
		$data['seo_title'] = 'Hizmet Satınalma Başarılı';
		
		$data['viewPage'] = $this->load->view('services/complete', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}
	
	public function error()
	{
		$data = array();
		
		$data['seo_title'] = 'Hizmet Satınalma Hatalı';
		
		$data['viewPage'] = $this->load->view('services/error', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}	
		
	public function _complete_services($oid)
	{
		$orders = $this->payment_model->get_orders_temp_by(array('oid' => (int)$oid));
		
		if(!empty($orders)){
			$order_template = "<tr><td width='40%' style='border: 1px solid #eeeeee; font-weight:bold;'>Ürün Adı</td><td style='border: 1px solid #eeeeee; font-weight:bold;'>Sipariş Açıklaması</td><td nowrap style='border: 1px solid #eeeeee; font-weight:bold;'>Ödenen Ücret</td></tr>";
			foreach($orders as $order)
			{
				$product = $this->payment_model->get_product_by(array('id' => $order->product_id));
				switch($order->product_id){
					case 11: //rozet starter
					case 12: //rozet advanced
					case 13: //rozet premium
						$this->users_model->update_user(array('id' => $order->uid), array('service_badge' => 'W'));
						
						$order_description = lang('ORDER_DEFINITION_BADGE');
						$order_description = str_replace("__ADMIN_EMAIL__", $GLOBALS['settings_global']->admin_email, $order_description);
					break;
					
					case 20: //özel sayfa starter
					case 21: //özel sayfa advanced
						$this->users_model->update_user(array('id' => $order->uid), array('service_web' => 'Y'));
						
						$order_description = lang('ORDER_DEFINED');
					break;
					
					case 9: //öne çıkanlar starter
					case 10: //öne çıkanlar advanced
						$user = $this->users_model->get_user_by(array('id' => $order->uid));
						$add_user_featured = $user->service_featured == NULL || $user->service_featured < time() ? strtotime($product->unix_date) : strtotime($product->unix_date, $user->service_featured);
						$user_search_point = $user->service_featured == NULL ? $user->search_point + point('featured') : $user->search_point;
						$this->users_model->update_user(array('id' => $order->uid), array('last_featured' => $add_user_featured, 'service_featured' => $add_user_featured, 'search_point' => $user_search_point));

						$order_description = lang('ORDER_DEFINED');
					break;
					
					case 14: //haftalık doping starter
					case 15: //haftalık doping advanced
					case 16: //haftalık doping premium
					case 17: //aylık doping starter
					case 18: //aylık doping advanced
					case 19: //aylık doping premium
						$user = $this->users_model->get_user_by(array('id' => $order->uid));
						$add_user_doping = $user->service_doping == NULL || $user->service_doping < time() ? strtotime($product->unix_date) : strtotime($product->unix_date, $user->service_doping);
						$user_search_point = $user->service_doping == NULL ? $user->search_point + point('doping') : $user->search_point;
						$this->users_model->update_user(array('id' => $order->uid), array('last_doping' => $add_user_doping, 'service_doping' => $add_user_doping, 'search_point' => $user_search_point));
						
						$order_description = lang('ORDER_DEFINITION_DATE');
						$order_description = str_replace("__DATE__", date('d.m.Y H:i:s', $add_user_doping), $order_description);
					break;
					
					case 22: //günün eğitmeni advanced
					case 23: //günün eğitmeni premium
					case 24: //haftanın eğitmeni advanced
					case 25: //haftanın eğitmeni premium
					case 26: //ayın eğitmeni advanced
					case 27: //ayın eğitmeni premium
					
						$order_description = lang('ORDER_DEFINITION_CAT_START_END');
						$order_description = str_replace("__CATEGORY__", $order->subject_title . ' > ' . $order->level_title, $order_description);
						$order_description = str_replace("__START_DATE__", date('d.m.Y H:i:s', $order->start_date), $order_description);
						$order_description = str_replace("__END_DATE__", date('d.m.Y H:i:s', $order->end_date), $order_description);
					break;				
				}
				
				$update_order_temp_data = array();
				
				if($order->payed_price > 0){
					money(array('category' => 2, 'user_id' => $order->uid, 'money' => format_money($order->payed_price), 'type' => 'earn'));
					
					$update_order_temp_data['earn_money'] = format_money($order->payed_price);
				} else {
					if(mtp($order->used_money) == $order->price) $update_order_temp_data['status'] = 'A';
				}
				
				if($order->used_money)
				money(array('category' => 2, 'user_id' => $order->uid, 'money' => $order->used_money, 'type' => 'spent'));
								
				$this->payment_model->update_order_temp(array('id' => $order->id), $update_order_temp_data);
				$this->payment_model->update_order_temp_to_order($order->id);
				$this->payment_model->delete_order_temp($order->id, $order->uid);
								
				$order_template .= "<tr><td style='border: 1px solid #eeeeee'>".$product->title."</td><td style='border: 1px solid #eeeeee'>".$order_description."</td><td style='border: 1px solid #eeeeee'>".format_price($order->payed_price)." TL</td></tr>";
			}
			
			m('order_notify', $orders[0]->uid, array('order_template' => $order_template));			
			
			return true;
		}
	}
	
	public function _prepare_order($order_data)
	{
		if(empty($order_data)) return false;
		
		$product = $this->payment_model->get_product_by(array('id' => $order_data['product_id']));
		
		$oid = $this->payment_model->check_other_services_in_cart($order_data['product_id']);
				
		if(empty($product)) return false;
		
		if($this->session->userdata('user_ugroup') == 4){
			$product->price = $product->price - ($product->price * 10 / 100);
		}
		
		if($this->session->userdata('user_ugroup') == 5){
			$product->price = $product->price - ($product->price * 20 / 100);
		}		
		
		$insert_data = array(
			'oid' 			=> $oid,
			'uid' 			=> $order_data['uid'],
			'product_id' 	=> $order_data['product_id'],
			'start_date' 	=> $order_data['start_date'],
			'end_date' 		=> $order_data['end_date'],
			'subject_id' 	=> $order_data['subject_id'],
			'level_id' 		=> $order_data['level_id'],
			'price'			=> $product->price,
			'payed_price'	=> $product->price,
		);
		
		return $insert_data;
	}
	
	public function check_cart()
	{
		is_notloggedin_redir(site_url('giris'));
		
		echo json_encode($this->payment_model->shopping_cart_count());
		exit;
	}	
	
	public function unavailables()
	{	
		is_notloggedin_redir(site_url('giris'));
		
		$res = array();
		$subject_id 	= (int)$this->input->post('subject', true);
		$level_id 		= (int)$this->input->post('level', true);
		$product_id 	= (int)$this->input->post('product_id', true);
		$type 			= $this->input->post('type', true);
				
		if($subject_id && $level_id && $product_id && $type && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			$unavailable_data = array(
				'subject_id' 	=> $subject_id, 
				'level_id' 		=> $level_id, 
				'product_id' 	=> $product_id
			);					
			$out = array('type' => $type, 'items' => $this->payment_model->get_unavailable_dates($unavailable_data));
			
			if(!empty($out['items'])){
				foreach($out['items'] as $key => $value)
				{
					$begin = new DateTime( $value->start_date );
					$end = new DateTime( $value->end_date );
					$end = $end->modify( '+1 day' ); 
					
					$interval = new DateInterval('P1D');
					$daterange = new DatePeriod($begin, $interval ,$end);
					
					foreach($daterange as $date){
					    $res[] = $date->format("d.m.Y");
					}
				}
			}
			echo json_encode(array('type' => $out['type'], 'items' => $res));
			exit;
		}
	}	
}



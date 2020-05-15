<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	
	var $template = 'pages/wrapper';

   public function __construct(){
        parent::__construct();
		$this->load->model('payment_model');
		$this->load->model('users_model');
		$this->config->set_item('language', $this->session->userdata('site_sl'));
		
		if(PAYMENT_SYSTEM == 0) redir(site_url('users/my'), array('Bilgi: Ücretli üyelik ve hizmetler, ödeme sistemi istemcisi güncellemeleri nedeniyle, geliştirme süreci tamamlanana kadar inaktif edilmiştir.'), '', '', TRUE);		
    }
	
	/******************************************
	* Üyeliklerin listelendiği sayfa
	******************************************/
	public function index()
	{
		is_notloggedin_redir(site_url('giris'));
		
		if(!is_teacher()) redir(site_url('users/my'), array('Ücretli üyelik hizmetlerini yalnızca eğitmen hesapları kullanabilir!'), '', '', TRUE);
		
		if($this->session->userdata('user_email_request')) redir(site_url('users/my'), array('Ücretli üyelikleri kullanabilmek için öncelikle e-posta adresinize gönderilen bağlantıya tıklayarak e-posta adresinizi aktive ediniz!'), '', '', TRUE);
		
		$data = array();

		/*	
			Aşağıdaki fiyatlar ham fiyatlar,
			advanced üye ise %10 indirim daha,
			premium üye ise %20 indirim daha
			uygulanacak. Ücretli modele geçildiğinde
			unutulmasın.
		*/
			
		$items = $this->db->from('settings_prices')->get()->result();
		foreach($items as $item){
			$prices[$item->id] = $item;
		}
		$data['price'] = $prices;
		$data['seo_title'] = 'Üyelik Satınalma Sayfası';
		
		$data['viewPage'] = $this->load->view('memberships/index', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);					
	}

	/******************************************
	* Üyeliğe satın al denildiğinde
	******************************************/	
	public function buy()
	{
		is_notloggedin_redir(site_url('giris'));
		
		$errors 		= array();
		$messages 		= array();
		$redir 			= site_url('memberships/cart');
		$call			= '';
		$product_id 	= (int)$this->input->post('product_id', true);

		if(($product_id == 30 || $product_id == 31) && is_buyed(array($product_id)))
		$errors[] = 'Bu üyeliğin ücretsiz deneme hakkını daha önce kullanmışsınız.';
		
		if(($product_id == 30 || $product_id == 31) && !$this->session->userdata('user_allow_trial'))
		$errors[] = 'Deneme üyeliği satın almanıza izin verilmiyor!';
		
		if(empty($errors))
		{
			//Kullaniciya ait sepetteki diger bekleyen uyelik siparislerini sil (orders_temp)
			$this->payment_model->delete_memberships_orders_temp();
			
			$product = $this->payment_model->get_product_by(array('id' => $product_id));
			
			if(!empty($product)){
				$order_data = array(
					'uid' 			=> $this->session->userdata('user_id'),		
					'product_id' 	=> $product_id,
					'price'			=> $product->price,
					'payed_price'	=> $product->price,
				);
				$this->payment_model->create_order_temp($order_data);
			} else {
				$errors[] = 'Satın almaya çalıştığınız üyelik bulunamadı!';
			}
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
				redir($redir, $errors, '', '', TRUE);
			} else {
				redir($redir, $messages);
			}
		}		
	}

	/******************************************
	* Üyelik satın alma alışveriş sepeti
	******************************************/		
	public function cart()
	{				
		is_notloggedin_redir(site_url('giris'));
		
		if(!is_teacher()) redir(site_url('users/my'), array('Ücretli üyelik hizmetlerini yalnızca eğitmen hesapları kullanabilir!'), '', '', TRUE);
		
		if($this->session->userdata('user_email_request')) redir(site_url('users/my'), array('Ücretli üyelikleri kullanabilmek için öncelikle e-posta adresinize gönderilen bağlantıya tıklayarak e-posta adresinizi aktive ediniz!'), '', '', TRUE);	

		$data = array();
		$errors = array();

		if($this->input->get('delete')){
			$this->payment_model->delete_order_temp((int)$this->input->get('delete', true), $this->session->userdata('user_id'));
			redir(site_url('memberships'), array('Üyelik satın alma işlemi iptal edilmiştir.'), '', '', TRUE);
		}
		
		if($this->input->post())
		{
			$this->load->helper(array('form'));
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('aggrement', 'Satış sözleşmesi', 'trim|required');
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
			
			//Siparişi ve içindeki ürünün varolduğunu kontrol et
			if(empty($errors)){
				$order = $this->payment_model->get_membership_order('_temp');
				
				$product = $this->payment_model->get_product_by(array('id' => $order->product_id));				

				if(empty($order))
				$errors[] = 'Satın alma işlemi gerçekleştirilecek sipariş bulunamadı. Lütfen kontrol edip tekrar deneyiniz.';
				
				if(empty($product))
				$errors[] = 'Satın alınacak üyelik tipi bulunamadı. Lütfen kontrol edip tekrar deneyiniz.';
				
				$user = $this->users_model->get_user_data($this->session->userdata('user_id'));
				
				if(empty($user))
				$errors[] = 'Siparişe devam etmek için lütfen hesabınıza giriş yapınız.';				
			}
			
			//Bilgileri iyzicoya gonder
			if(empty($errors))
			{	
				require_once(APPPATH . 'libraries/iyzipay-php-2.0.25/samples/config.php');
						
				# create request class
				$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
				$request->setLocale(\Iyzipay\Model\Locale::TR);
				$request->setConversationId($order->oid);
				$request->setPrice($order->price);
				$request->setPaidPrice($order->payed_price);
				$request->setCurrency(\Iyzipay\Model\Currency::TL);
				$request->setBasketId($order->id);
				$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);
				$request->setCallbackUrl(site_url('memberships/callback'));
				if($order->payed_price >= 50){
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
				$firstBasketItem = new \Iyzipay\Model\BasketItem();
				$firstBasketItem->setId($order->id);
				$firstBasketItem->setName($product->title);
				$firstBasketItem->setCategory1("Üyelik");
				$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
				$firstBasketItem->setPrice($order->price);
				$basketItems[0] = $firstBasketItem;			
				
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
				
		$data['order'] = $this->payment_model->get_membership_order('_temp');
		if(empty($data['order'])) redir(site_url('memberships'), array('Lütfen almak istediğiniz üyelik tipini seçiniz'), '', '', TRUE);
		
		$data['errors'] = $errors;
		
		$data['seo_title'] = 'Üyelik Satınalma Alışveriş Sepeti';
		
		$data['viewPage'] = $this->load->view('memberships/cart', $data, true);
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
			$redirect_url = isset($result->errorMessage) ? site_url('memberships/error?message='.$result->errorMessage) : site_url('memberships/error');
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
			
			$response = $this->_complete_memberships((int)$result->basketId);
			
			if($response == true){
				redir(site_url('memberships/complete?order='.$result->paymentId));			
			} else {
				redir(site_url('memberships/error?message='.$response));
			}
		}
	}
	
	public function complete()
	{		
		$data = array();
		
		$data['seo_title'] = 'Üyelik Satınalma Başarılı';
		
		$data['viewPage'] = $this->load->view('memberships/complete', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}
	
	public function error()
	{
		$data = array();
		
		$data['seo_title'] = 'Üyelik Satınalma Hatalı';
		
		$data['viewPage'] = $this->load->view('memberships/error', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}	
	
	public function _complete_memberships($oid = null)
	{
		if(empty($oid)){
			m('orders_memberships_complete_oid_error', serialize($this->input->get_post()));
			return "Hata! Sipariş grubu numarası ödeme istemcisi tarafından gönderilmedi.";
		}
		
		$orders = $this->payment_model->get_orders_temp_by(array('oid' => (int)$oid));
		
		if(empty($orders)){
			m('orders_memberships_complete_oid_not_found', serialize($this->input->get_post()));
			return "Hata! Ödeme istemcisi tarafından gönderilen sipariş grubu numarası bulunamadı.";
		}
		
		if(!empty($orders))
		{
			$order_template = "<tr><td width='40%' style='border: 1px solid #eeeeee; font-weight:bold;'>Ürün Adı</td><td style='border: 1px solid #eeeeee; font-weight:bold;'>Sipariş Açıklaması</td><td nowrap style='border: 1px solid #eeeeee; font-weight:bold;'>Ödenen Ücret</td></tr>";

			foreach($orders as $order)
			{
				$product	= $this->payment_model->get_product_by(array('id' => $order->product_id));
				$user 		= $this->users_model->get_user_by(array('id' => $order->uid));
				$user_data	= array();
				$order_data	= array();
				
				switch($order->product_id)
				{
					//trial membership
					case 30: //deneme advanced
					case 31: //deneme premium
						$user_data['expire_membership'] = strtotime($product->unix_date);

						$order_data['start_date'] = time();
						$order_data['end_date'] = $user_data['expire_membership'];
					break;
					
					//payed membership
					default:
						//Kullanıcı aynı üyelik tipini satın aldıysa
						if($user->ugroup == $product->user_group)
						{
							//Kullanıcının üyeliği bitmediyse üzerine ekle
							if($user->expire_membership > time())
							{
								$user_data['expire_membership'] = strtotime($product->unix_date, $user->expire_membership);

								$order_data['start_date'] 		= $user->expire_membership;
								$order_data['end_date'] 		= strtotime($product->unix_date, $order_data['start_date']);
							} else {
								$user_data['expire_membership'] = strtotime($product->unix_date);

								$order_data['start_date'] = time();
								$order_data['end_date'] = $user_data['expire_membership'];
							}		
						//Kullanıcı farklı bir üyelik tipi satın aldıysa					
						} else {
							if(($user->ugroup == 4 || $user->ugroup == 5) && ($product->user_group == 4 || $product->user_group == 5))
							$this->_membership_price_to_money(array('user_id' => $user->id, 'expire_membership' => $user->expire_membership));

							$user_data['expire_membership'] = strtotime($product->unix_date);

							$order_data['start_date'] = time();
							$order_data['end_date'] = $user_data['expire_membership'];
						}

						//Ücret ödediyse ödediği ücret kadar sanal para kazansın
						if($order->payed_price > 0){
							$order_data['earn_money'] = $order->payed_price;
							money(array('category' => 1, 'user_id' => $user->id, 'money' => $order->payed_price, 'type' => 'earn'));
						}
						
						//Son ücretli üyelik bitiş tarihini kullanıcıya tanımla (bittikten sonra marketing için)
						$user_data['last_membership'] = $user_data['expire_membership'];
					break;			
				}
				
				//Yeni kullanıcı grubunu tanımla
				$user_data['ugroup'] = $product->user_group;
				
				//Arama puanını güncelle
				if($user->ugroup != $product->user_group){
					if($user->ugroup == 4 && $product->user_group == 5){
						$user_data['search_point']	= $user->search_point + point('premium') - point('advanced');
					}
					
					if($user->ugroup == 5 && $product->user_group == 4){
						$user_data['search_point']	= $user->search_point + point('advanced') - point('premium');
					}
					
					if($user->ugroup == 3 && $product->user_group == 4){
						$user_data['search_point']	= $user->search_point + point('advanced');
					}
					
					if($user->ugroup == 3 && $product->user_group == 5){
						$user_data['search_point']	= $user->search_point + point('premium');
					}				
				}
							
				$this->users_model->update_user(array('id' => $order->uid), $user_data);
				
				$this->payment_model->update_order_temp(array('id' => $order->id), $order_data);
				$this->payment_model->update_order_temp_to_order($order->id);
				$this->payment_model->delete_order_temp($order->id, $order->uid);
				
				$order_description = $product->description ? $product->description : lang('ORDER_DEFINED');
				
				$order_template .= "<tr><td style='border: 1px solid #eeeeee'>".$product->title."</td><td style='border: 1px solid #eeeeee'>".$order_description."</td><td style='border: 1px solid #eeeeee'>".format_price($order->payed_price)." TL</td></tr>";
			}				
			
			m('order_notify', $orders[0]->uid, array('order_template' => $order_template));
						
			return true;
		}
	}
	
	
	public function _membership_price_to_money($data = array())
	{
		if(empty($data['user_id']) || empty($data['expire_membership'])) return false;
				
		$user_id			= (int)$data['user_id'];
		$expire_membership	= (int)$data['expire_membership'];
		$total_earn_money	= 0;
		$total_payed_price	= 0;
		$order_ids			= array();
		
		$last_membership_orders = $this->payment_model->get_last_payed_membership_orders($user_id);
		
		if(!empty($last_membership_orders) && $expire_membership > strtotime('+1 day'))
		{
			foreach($last_membership_orders as $last_membership_order)
			{
				if($last_membership_order->earn_money > 0)
				$total_earn_money += $last_membership_order->earn_money;
				
				if($last_membership_order->payed_price > 0)
				$total_payed_price += $last_membership_order->payed_price;
				
				$order_ids[] = $last_membership_order->id;
			}
			
			if(!empty($total_payed_price))
			{
				$remaining_days = unixtime_to_day($expire_membership);
				
				$one_day_price = $total_payed_price / $remaining_days;
				
				if(!empty($remaining_days) && !empty($one_day_price))
				{
					$price = floor(format_price($one_day_price) * $remaining_days);
					
					if(!empty($price))
					{
						$money = $total_earn_money > 0 ? ptm($price) - $total_earn_money : ptm($price);
						money(array('category' => 6, 'user_id' => $user_id, 'money' => $money, 'type' => 'earn'));	
						
						if(!empty($order_ids))
						$this->db->where_in('id', $order_ids)->update('orders', array('status' => 'T'));
					}
					
				}
			}		
		}	
	}
}



<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quickpay extends CI_Controller {
	
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
		$data = array();
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('firstname', 'Ad soyad', 'trim|required');
			$this->form_validation->set_rules('lastname', 'Ad soyad', 'trim|required');
			$this->form_validation->set_rules('mobile', 'Cep telefonu', 'trim|required');
			$this->form_validation->set_rules('identity_no', 'T.C. kimlik no', 'trim|required');
			$this->form_validation->set_rules('address', 'Adres', 'trim|required');
			$this->form_validation->set_rules('city', 'Şehir', 'trim|required');
			$this->form_validation->set_rules('price', 'Ödenecek tutar', 'trim|required');
			$this->form_validation->set_rules('aggrement', 'Satış sözleşmesi', 'trim|required');

			if($this->form_validation->run() == FALSE)
			$data['errors'] = $this->form_validation->error_array();			
								
			if(empty($data['errors']))
			{
				$order_id = time();
				
				require_once(APPPATH . 'libraries/iyzipay-php-2.0.25/samples/config.php');
						
				# create request class
				$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
				$request->setLocale(\Iyzipay\Model\Locale::TR);
				$request->setConversationId($order_id);
				$request->setPrice($this->input->post('price'));
				$request->setPaidPrice($this->input->post('price'));
				$request->setCurrency(\Iyzipay\Model\Currency::TL);
				$request->setBasketId($order_id);
				$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::SUBSCRIPTION);
				$request->setCallbackUrl(site_url('quickpay/callback'));
				$request->setEnabledInstallments(array(1));
				
				$buyer = new \Iyzipay\Model\Buyer();
				$buyer->setId($order_id);
				$buyer->setName($this->security->xss_clean($this->input->post('firstname', true)));
				$buyer->setSurname($this->security->xss_clean($this->input->post('lastname', true)));
				$buyer->setGsmNumber(str_replace(' ', '', $this->security->xss_clean($this->input->post('mobile', true))));
				$buyer->setEmail($this->security->xss_clean($this->input->post('email', true)));
				$buyer->setIdentityNumber((int)$this->input->post('identity_no'));
				$buyer->setLastLoginDate(date('Y-m-d H:i:s', $order_id));
				$buyer->setRegistrationDate(date('Y-m-d H:i:s', $order_id));
				$buyer->setRegistrationAddress($this->security->xss_clean($this->input->post('address', true)));
				$buyer->setIp(getip());
				$buyer->setCity($this->security->xss_clean($this->input->post('city', true)));
				$buyer->setCountry("Turkey");
				$buyer->setZipCode("");
				$request->setBuyer($buyer);
				
				$shippingAddress = new \Iyzipay\Model\Address();
				$shippingAddress->setContactName($this->security->xss_clean($this->input->post('firstname', true)) . ' ' . $this->security->xss_clean($this->input->post('lastname', true)));
				$shippingAddress->setCity($this->security->xss_clean($this->input->post('city', true)));
				$shippingAddress->setCountry("Turkey");
				$shippingAddress->setAddress($this->security->xss_clean($this->input->post('address', true)));
				$shippingAddress->setZipCode("");
				$request->setShippingAddress($shippingAddress);
				
				$billingAddress = new \Iyzipay\Model\Address();
				$billingAddress->setContactName($this->security->xss_clean($this->input->post('firstname', true)) . ' ' . $this->security->xss_clean($this->input->post('lastname', true)));
				$billingAddress->setCity($this->security->xss_clean($this->input->post('city', true)));
				$billingAddress->setCountry("Turkey");
				$billingAddress->setAddress($this->security->xss_clean($this->input->post('address', true)));
				$billingAddress->setZipCode("");
				$request->setBillingAddress($billingAddress);
				
				$basketItems = array();
				$basketItem = new \Iyzipay\Model\BasketItem();
				$basketItem->setId($order_id);
				$basketItem->setName('Hizli Odeme');
				$basketItem->setCategory1("Hizmet");
				$basketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
				$basketItem->setPrice($this->security->xss_clean($this->input->post('price', true)));
				$basketItems[] = $basketItem;
				
				$request->setBasketItems($basketItems);
								
				# make request
				$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());
				
				if($checkoutFormInitialize->getStatus() != 'success'){
					$data['errors'][] = txtFirstUpper($checkoutFormInitialize->getErrorMessage());
				}
				
				if(empty($errors)){
					$data['payment_form'] = $checkoutFormInitialize->getCheckoutFormContent();
				}
			}	
		}
	
		$data['viewPage'] = $this->load->view('quickpay/index', $data, true);
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
			$redirect_url = isset($result->errorMessage) ? site_url('quickpay/error?message='.$result->errorMessage) : site_url('quickpay/error');
			redir($redirect_url);
		}
		
		//Karttan para cekildiyse
		if($result->paymentStatus == 'SUCCESS')
		{			
			redir(site_url('quickpay/complete?order='.$result->paymentId));
		}
	}
	
	public function complete()
	{		
		$data = array();
		
		$data['seo_title'] = 'Ödeme İşlemi Başarılı';
		
		$data['viewPage'] = $this->load->view('quickpay/complete', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}
	
	public function error()
	{
		$data = array();
		
		$data['seo_title'] = 'Ödeme İşlemi Hatalı';
		
		$data['viewPage'] = $this->load->view('quickpay/error', $data, true);
		$result	= $this->load->view($this->template, $data, true);
		$this->output->set_output($result);		
	}		
}



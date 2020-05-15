<?php

require_once(APPPATH . 'libraries/iyzipay-php-2.0.25/IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Config
{
    public static function options()
    {
        $options = new \Iyzipay\Options();
        /*
        $options->setApiKey("sandbox-O9N6UO4urgaPQwpwLjj86jlRW4flq7nk");
        $options->setSecretKey("sandbox-FnU8fEhzMDGlRGsD3WMtvpTrOYZ34rh2");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");
        */
        $options->setApiKey("Yc4tFSxgPaDx5ggvXqlSKiH9DPb63ST5");
        $options->setSecretKey("ABC59OsSuGYA2XtrbpWWMyuQsRp25L5A");
        $options->setBaseUrl("https://api.iyzipay.com");        
        return $options;
    }
}
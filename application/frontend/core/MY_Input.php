<?php

class MY_Input extends CI_Input {

    function __construct()
    {
        parent::__construct();
    }

    function ip_address() 
    {
        return getip();
    }
}
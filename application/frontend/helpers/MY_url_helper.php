<?php

function current_url($query_string = true)
{
    $CI =& get_instance();

    $url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] && $query_string == true ? $CI->security->xss_clean($url.'?'.$_SERVER['QUERY_STRING']) : $CI->security->xss_clean($url);
}
<?php

class Jfup extends CI_Controller
{
    var $options;

    function Jfup($options=null) {
		
        $this->ci=& get_instance();
        $this->ci->load->database();
    	$this->ci->load->library('photos/RlCrop');
    	$this->ci->load->library('photos/RlResize');
		
		if(empty($GLOBALS['settings_global']->photo)){
			return false;
		}
		
		$photo = unserialize($GLOBALS['settings_global']->photo);
		
		if(empty($photo)){
			return false;
		}
		
        $this->options = array(
        	'module_name' => $this->ci->uri->segment(2),
            'img_crop_interface' => 1,
            'script_url' => base_url('backend/'.$this->ci->uri->segment(2).'/photos/'.$this->ci->uri->segment(4).'/'),
            'upload_dir' => ROOTPATH.'uploads/',
            'upload_url' => base_url().'uploads/',
            'dir_name' => null,// personal module directory
            'param_name' => 'files',
            'min_file_size' => 1,
            'accept_file_types' => '/^image\/(gif|jpeg|png|jpg)$/i',
            'max_number_of_files' => null,
            'discard_aborted_uploads' => true,
            'img_quality' => $photo['photo_quality'],
			'original_max' => $photo['photo_original_max'],
            'image_versions' => $photo['versions'],
        );
        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
    }
    
    /*
    function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'].$file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file -> original_name = $file_name;
            $file -> primary = 0;
            $file -> description = '';
            $file -> size = filesize($file_path);
            $file -> url = $this->options['upload_url'].rawurlencode($file->name);
            foreach( $this -> options['image_versions'] as $version => $options)
            {
                if (is_file($options['upload_dir'].$file_name))
                {
                    $file -> {$version.'_url'} = $options['upload_url'].rawurlencode($file->original_name);
                }
            }
            $file -> delete_url = $this->options['script_url'] . '?file='.rawurlencode($file->original_name);
            $file -> delete_type = 'DELETE';
            $file -> lang_code = 'all';
            return $file;
        }
        return null;
    }
    */
    
    function get_file_objects($module_id = '') {

    	$photos = $this->ci->db->from('photos')->where('module_name', $this->ci->db->escape_str($this->options['module_name']))->where('module_id', (int)$module_id)->order_by('position')->get()->result();
    	if ( !$photos )
    		return false;
    	    		
    	foreach ($photos as $photo)
    	{
    		$info = getimagesize(ROOTPATH . $photo->original);
    		$file = new stdClass();
    		$file -> id = $photo->id;
    		$file -> module_id = $photo->module_id;
            $file -> description = $photo->description;
            $file -> lang_code = $photo->lang_code;
    		
    		$file -> original_name = end(explode('/', $photo->original));
    		$file -> original_size = filesize(ROOTPATH . $photo->original);
    		$file -> original_local = $photo->original;
    		$file -> original_url = site_url() . $photo->original;
    		$file -> original_type = $info['mime'];
    		$file -> original_width = $info[0];
    		$file -> original_height = $info[1];
    		    		
    		$file -> primary = $photo->type == 'main' ? 1 : 0;
    
			if(!empty($this->options['image_versions'])){		
				foreach($this->options['image_versions'] as $version => $options){
	        		$version_name = $version . '_name';
	        		$version_size = $version . '_size';
	        		$version_url = $version . '_url';
	        		$version_local = $version . '_local';

	        		$file -> $version_name = end(explode('/', $photo->$version));
	        		$file -> $version_size = filesize(ROOTPATH . $photo->$version);
	        		$file -> $version_url = site_url() . $photo->$version;
	        		$file -> $version_local = $photo->$version;
				}
			}

    		$file -> delete_url = $this->options['script_url'].'?file='. $photo->original .'&id='. $this->ci->uri->segment(4);
    		$file -> delete_type = 'DELETE';
    		
    		$files[] = $file;
    	}
		
		return $files;
    }

	function create_scaled_image($file_name, $new_file_name, $options) {
    	global $config;
    	
    	$file_path = $this -> options['upload_dir'] . $file_name;
    	$new_file_path = $this -> options['upload_dir'] . $new_file_name;

		if(!empty($options['max_width']) && !empty($options['max_height'])){
	    	$this->ci->rlcrop->loadImage($file_path);
			$this->ci->rlcrop->cropBySize($options['max_width'], $options['max_height'], ccCENTER);
			$this->ci->rlcrop->saveImage($new_file_path, $this->options['img_quality']);
			$this->ci->rlcrop->flushImages();
			$this->ci->rlresize->resize( $new_file_path, $new_file_path, 'C', array($options['max_width'], $options['max_height']), null, $options['watermark'] );
		} else {
			$width_height = $options['max_width'] ? $options['max_width'] : $options['max_height'];
			list($orig_width, $orig_height) = getimagesize($file_path);
			if($orig_width > $orig_height){
				$this->ci->rlresize->resize( $file_path, $new_file_path, 'W', $width_height, null, $options['watermark']);
			} else {
				$this->ci->rlresize->resize( $file_path, $new_file_path, 'H', $width_height, null, $options['watermark']);
			}
		}
	
		return true;
    }

    function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options['accept_file_types'], $file->type)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
		
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
            ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }
    
    function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
    	global $module_id, $dir, $config;
    	
    	$ext = array_reverse(explode('.', $name));
    	$ext = $ext[0];
    	
        $file = new stdClass();
        $file -> name = seo(current(explode('.',$name))) . '_orig_'. time() . mt_rand(). '.' .$ext;
        $file -> size = intval($size);
        $file -> type = $type;
        $error = $this -> has_error($uploaded_file, $file, $error);
        
        if ( !$error && $file -> name )
        {
            $file_path = $this -> options['upload_dir'] . $file -> name;
            $append_file = is_file($file_path) && $file -> size > filesize($file_path);
            clearstatcache();
            if ( $uploaded_file && is_uploaded_file($uploaded_file) )
            {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file)
                {
                    file_put_contents($file_path, fopen($uploaded_file, 'r'), FILE_APPEND);
                }
                else
                {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            }
            else
            {
                // Non-multipart uploads (PUT method support)
                file_put_contents($file_path, fopen('php://input', 'r'), $append_file ? FILE_APPEND : 0);
            }
            
			list($orig_width, $orig_height) = getimagesize($file_path);
			if($orig_width > $this -> options['original_max'] && $orig_width > $orig_height){
				$this->ci->rlresize->resize( $file_path, $file_path, 'W', $this -> options['original_max'], null, false);
				$file->size = filesize($file_path);
			} else if($orig_height > $this -> options['original_max'] && $orig_height > $orig_width){
				$this->ci->rlresize->resize( $file_path, $file_path, 'H', $this -> options['original_max'], null, false);
				$file->size = filesize($file_path);
			}
						
            if ( $file -> size )
            {
                //$file -> url = $this -> options['upload_url'] . rawurlencode($file->name);
                
                foreach($this->options['image_versions'] as $version => $options)
                {
                	$new = seo(current(explode('.',$name))) . '_' . $version . '_' . time() . mt_rand(). '.' .$ext;
                    if ( $this -> create_scaled_image( $file -> name, $new, $options ) )
                    {
                    	$version_name = $version . '_name';
                    	$version_size = $version . '_size';
                        $file -> $version_name = $new;
                        $file -> $version_size = filesize($this -> options['upload_dir'] . $new);
                        //type lazim olursa burada olusturulabilir
                    }
                }
                
                //remove original image if crop user interface disabled 
                if ( !$this->options['img_crop_interface'] )
                {
                	unlink($file_path);
                }
            }
            else if ( $this -> options['discard_aborted_uploads'] )
            {
                unlink($file_path);
                $file -> error = 'abort';
            }
            $file -> delete_url = $this->options['script_url'].'?file='. $this -> options['dir_name'] . rawurlencode($file -> name).'&id='.$this->ci->uri->segment(4);
            $file -> delete_type = 'DELETE';
            $file -> lang_code = 'all';
        } else {
            $file->error = $error;
        }
        		
        return $file;
    }
    
    function get($module_id) {
    	global $rlJson;
    	
        $file_name = isset($_REQUEST['file']) ? basename(stripslashes($_REQUEST['file'])) : null; 
        if ($file_name) {
            $info = $this->get_file_object($file_name, $module_id);
        } else {
            $info = $this->get_file_objects($module_id);
        }
        header('Content-type: application/json');
        echo json_encode(array('files' => $info));
    }
    
    function post($module_id) {
    	global $rlActions, $rlJson, $config;
		
    	/* file directories handler */
    	$query = $this->ci->db->query("SELECT original FROM ".PREFIX."photos WHERE module_name = '".$this->options['module_name']."' AND module_id = '{$module_id}'")->row();
    	$cur_photo = $query->original;
    	if ( $cur_photo )
    	{
    		$exp_dir = explode('/', $cur_photo);
    		if ( count($exp_dir) > 1 )
    		{
    			array_pop($exp_dir);
    			$dir = ROOTPATH . implode('/', $exp_dir) . '/';
    			$dir_name = implode('/', $exp_dir) .'/';
    		}
    	}
    	
    	if ( !$dir )
    	{
	    	$dir = ROOTPATH.'uploads/' . date('m-Y') . '/' . $this->options['module_name'] . $module_id . '/';
	    	$dir_name = 'uploads/'. date('m-Y') .'/'. $this->options['module_name'] . $module_id .'/';
    	}
        
        $url = base_url() . $dir_name;
        $this -> createDirectory($dir);
    	
		$this -> options['upload_dir'] = $dir;
		$this -> options['upload_url'] = $url;
		$this -> options['dir_name'] = $dir_name;
		
        $upload = isset($_FILES[$this->options['param_name']]) ?
            $_FILES[$this->options['param_name']] : array(
                'tmp_name' => null,
                'name' => null,
                'size' => null,
                'type' => null,
                'error' => null
            );
        $info = array();
        if (is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                    $upload['tmp_name'][$index],
                    isset($_SERVER['HTTP_X_FILE_NAME']) ?
                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                    isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                    isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                    $upload['error'][$index]
                );
            }
        } else {
            $info[] = $this->handle_file_upload(
                $upload['tmp_name'],
                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                    $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'],
                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                    $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'],
                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                    $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'],
                $upload['error']
            );
        }
        
        $max_pos = $this->ci->db->query("SELECT MAX(position) AS Max FROM ".PREFIX."photos WHERE module_name = '".$this->options['module_name']."' AND module_id = '{$module_id}'")->row();
        $max_pos = $max_pos->Max;
                
        /* add pictures to db */
        foreach ( $info as $index => $photo )
        {
        	if($photo -> name && file_exists(ROOTPATH . $dir_name . $photo -> name)){
	        	$max_pos++;
	        	$insert = array(
	        		'module_id' => $module_id,
	        		'module_name' => $this->options['module_name'],
	        		'position' => $max_pos,
	                'original' => $this->options['img_crop_interface'] ? $dir_name . $photo -> name : '',
	        		'description' => '',
	        		'type' => 'photo',
	        		'status' => 'A',
	        		'lang_code' => 'all'
	        	);
	        	
	        	if($this->options['image_versions']){
		        	foreach($this->options['image_versions'] as $version => $options)
		        	{
		        		$version_name 	= $version . '_name';
		        		$version_size 	= $version . '_size';
		        		$version_url 	= $version . '_url';
		        		$version_local 	= $version . '_local';
		        		
		        		$insert[$version] = $dir_name . $photo->$version_name;
		        		
		        		$info[$index] -> $version_name 	= $photo->$version_name;
		        		$info[$index] -> $version_size 	= $photo->$version_size;
		        		$info[$index] -> $version_url 	= $url . $photo->$version_name;
		        		$info[$index] -> $version_local = $this -> options['upload_dir'] . $photo->$version_name;
		        	}
	        	}
	        	
	        	$this->ci->db->insert(PREFIX.'photos', $insert);
	        	$insert_id =  $this->ci->db->insert_id();
	        	
	            //$db->print_last_query();
	        	$info[$index] -> id = $insert_id;
	        	$info[$index] -> module_id = $module_id;
	        	$info[$index] -> primary = 0;
                $info[$index] -> description = '';
        	}
        }
        
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo json_encode(array('files' => $info));
    }
    
    function delete($module_id) {
    	
    	$id = $this->ci->input->get_post('id');
        $file_name = $this->ci->input->get_post('file') ? stripslashes($this->ci->input->get_post('file')) : null;
        $file_path = ROOTPATH . $file_name;
        
        $success = $id == $module_id && is_file($file_path) && unlink($file_path);
        $info = $this->ci->db->query("SELECT * FROM ".PREFIX."photos WHERE original = '".$file_name."' AND module_name = '".$this->options['module_name']."' AND module_id = '".$module_id."' AND original = '{$file_name}' LIMIT 1")->row();
        if ( $success && $info )
        {

        	if($this->options['image_versions']){
	        	foreach($this->options['image_versions'] as $version => $options)
	        	{
					$version_dir = ROOTPATH . $info->$version;
					unlink($version_dir);						        	
	        	}
	        }
			
            /* remove from DB */
            $this->ci->db->query("DELETE FROM ".PREFIX."photos WHERE module_name = '".$this->options['module_name']."' AND module_id = '{$module_id}' AND original = '{$file_name}' LIMIT 1");
            
            /* remove related directory if it is empty */
            $del_dir = explode('/', $photo_dir);
            array_pop($del_dir);
            $this -> deleteDirectory(implode('/', $del_dir) . '/', true);
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }

    function deleteDirectory( $dirname = false, $passive = false )
    {
        if ( is_dir($dirname) )
        {
            $dir_handle = opendir($dirname);
        }
        
        if ( !$dir_handle )
        {
            return false;
        }
        
        // passive mode
        if ( $passive )
        {
            $empty = true;
            $file = readdir($dir_handle);
            
            while( $file = readdir($dir_handle) )
            {
                if ( $file != "." && $file != ".." )
                {
                    $empty = false;
                }
            }
            
            if ( $empty )
            {
                rmdir($dirname);
            }
            
            return true;
            exit;
        }
        
        while( $file = readdir($dir_handle) )
        {
            if ( $file != "." && $file != ".." )
            {
                if ( !is_dir($dirname . '/' . $file) )
                {
                    unlink($dirname . '/' . $file);
                }
                else
                {
                    $this -> deleteDirectory($dirname . '/' . $file);
                }
            }
        }
        
        closedir($dir_handle);
        rmdir($dirname);
        
        return true;
    }

    function createDirectory( $dir = false )
    {
        if ( !$dir )
            return false;
            
        $dir = str_replace(ROOTPATH, '', $dir);
        $dirs = explode('/', $dir);
        $directory = ROOTPATH;

        foreach ( $dirs as $next )
        {
            $directory .= $next . '/';
            
            if ( is_dir($directory) )
            {
                if ( !is_writable($directory) )
                {
                    chmod($directory, 0755);
                    if ( !is_writable($directory) )
                    {
                        chmod($directory, 0777);
                    }
                }
            }
            else
            {

                mkdir($directory);
                chmod($directory, 0755);
                if ( !is_writable($directory) )
                {
                    chmod($directory, 0777);
                }
            }
        }
        
        return true;
    }
    
	function seo($value)
	{
		$special_chars[] = 'â';
		$special_chars[] = 'İ';
		$special_chars[] = 'Ş';
		$special_chars[] = 'Ç';
		$special_chars[] = 'Ğ';
		$special_chars[] = 'ş';
		$special_chars[] = 'ç';
		$special_chars[] = 'ğ';
		$special_chars[] = 'ı';
		$special_chars[] = 'ö';
		$special_chars[] = 'ü';
		$special_chars[] = 'Ö';
		$special_chars[] = 'Ü';
		$special_chars[] = 'Ä';
		$special_chars[] = 'Ü';
		$special_chars[] = 'ä';
		$special_chars[] = 'ü';
		$special_chars[] = 'ö';
		$special_chars[] = 'ß';
		$special_chars[] = 'Ž';
		$special_chars[] = '?';
		$special_chars[] = '.';
		$special_chars[] = ':';
		$special_chars[] = ',';
		$special_chars[] = '_';
		$special_chars[] = '-';
		$special_chars[] = '+';
		$special_chars[] = '&';
		$special_chars[] = '/';
		$special_chars[] = '\\';
		$special_chars[] = ' ';
		$special_chars[] = '"';
		$special_chars[] = '#';
		$special_chars[] = "'";
		$special_chars[] = "\'";
		$special_chars[] = '!';
		$special_chars[] = 'quot';
		$special_chars[] = '--';
		$special_chars[] = '---';
		$special_chars[] = '----';
	
		$special_chars2[] = 'a';
		$special_chars2[] = 'i';
		$special_chars2[] = 's';
		$special_chars2[] = 'c';
		$special_chars2[] = 'g';
		$special_chars2[] = 's';
		$special_chars2[] = 'c';
		$special_chars2[] = 'g';
		$special_chars2[] = 'i';
		$special_chars2[] = 'o';
		$special_chars2[] = 'u';
		$special_chars2[] = 'O';
		$special_chars2[] = 'U';	
		$special_chars2[] = 'Ae';
		$special_chars2[] = 'Ue';
		$special_chars2[] = 'ae';
		$special_chars2[] = 'ue';
		$special_chars2[] = 'oe';
		$special_chars2[] = 'ss';
		$special_chars2[] = 'z';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '-';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '-';
		$special_chars2[] = '-';
		$special_chars2[] = '';
		$special_chars2[] = '-';
		$special_chars2[] = '-';
		$special_chars2[] = '-';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '';
		$special_chars2[] = '-';
		$special_chars2[] = '-';
		$special_chars2[] = '-';
	
		$value = trim($value);
		$value = str_replace($special_chars,$special_chars2,$value);
		$value = strtolower($value);
		$value = preg_replace('/[^0-9A-Za-z-]/',"",$value);
		
		return $value;
	}    
}
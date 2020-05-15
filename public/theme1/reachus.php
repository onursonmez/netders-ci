


<?php
	$msg = "no"; 
    $name     = $_POST['name'];
    $email    = $_POST['email'];
	$phone    = $_POST['phone'];
    $msgs     = $_POST['message'];
    
    if($name !='' && $email!='' && $msgs !='' && phone != ''){
        $to = "lanternthemes@gmail.com";
	$subject = "Contact Mail";
	$message = "<p>Dear Admin,</p><p>You have a contact request </p><p>Please find the below information</p>
                    <p>Name :".$name."</p>
                    <p>Email :".$email."</p>
					 <p>Phone :".$phone."</p>
                    <p>Message:</p><p>".$msgs."</p>";
	$header .= "To: ".$to. "\r\n";
	$header  = "From:".$email."\r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
	$send = mail ($to,$subject,$message,$header);
        if($send){
	$msg = "ok"; 
	} else{
	$msg = "no"; 
	}
        echo $msg;
    }
	else
	{
		echo $msg;
	}
?>

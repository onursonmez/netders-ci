// Theme    : Lantern - Responsive vCard & Resume Template
//	Theme URI: http://themeforest.net/user/lanternthemes
//	Description: This javascript file is using for email sending.
//	Version: 1.0
//	Author: Lantern Themes
//	Author URI: http://themeforest.net/user/lanternthemes
//	Tags:
//  ====================================================================

(function() {
	"use strict";
	function validate_email(email) 
	{
	   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	   return reg.test(email);
	}
	
	$(document).ready(function(e) {
		$('#contact-submit').click(function(e) {
			e.preventDefault();
			contact_submit();
		});
		
		$('#comment-submit').click(function(e) {
			e.preventDefault();
			comment_submit();
		});		
		
		$('input:text, textarea').keyup(function(e) {
			$(this).removeClass('error');
		});
		
		$('#contact_form #contact-loading').hide();
		$('#contact_form #contact-success').hide();
		$('#contact_form #contact-failed').hide();
		
		$('#comment_form #contact-loading').hide();
		$('#comment_form #contact-success').hide();
		$('#comment_form #contact-failed').hide();		
	});
	
	
	
	// Contact form validation
	
	function contact_submit()
	{		
		var submit_flag = 'yes';
		
		var firstname = $('#firstname').val();
		if( firstname =='')
		{
			if(submit_flag == 'yes')
			{
				$('#firstname').focus();
			}
			$('#firstname').addClass('error');
			submit_flag = 'no';
		}
		
		var lastname =$('#lastname').val();
		if(lastname =='')
		{
			if(submit_flag == 'yes')
			{
				$('#lastname').focus();
			}
			$('#lastname').addClass('error');
			submit_flag = 'no';
		}
		
		var email =$('#email').val();
		if(email =='')
		{
			if(submit_flag == 'yes')
			{
				$('#email').focus();
			}
			$('#email').addClass('error');
			submit_flag = 'no';
		}		
		
		if(!validate_email(email))
		{
			if(submit_flag == 'yes')
			{
				$('#email').focus();
			}
			$('#email').addClass('error');
			submit_flag = 'no';
		}
		
		var mobile = $('#mobile').val();
		if( mobile =='')
		{
			if(submit_flag == 'yes')
			{
				$('#mobile').focus();
			}
			$('#mobile').addClass('error');
			submit_flag = 'no';
		}
		
		var message = $('#message').val();
		if( message =='' || message== 'Mesajınız *')
		{
			if(submit_flag == 'yes')
			{
				$('#message').focus();
			}
			$('#message').addClass('error');
			submit_flag = 'no';
		}
		
		var security_code = $('#security_code').val();
		if( security_code =='')
		{
			if(submit_flag == 'yes')
			{
				$('#security_code').focus();
			}
			$('#security_code').addClass('error');
			submit_flag = 'no';
		}		
		
		if(submit_flag != 'yes')
		{	
			return false;
		} else {
			$('#contact_form #contact-success').hide();
			$('#contact_form #contact-failed').hide();
			$('#contact_form #contact-loading').show();
			$('#contact-form').hide();			
	
			$.ajax({
				url: base_url+'users/sendmessage',
				type: 'post',
				cache: false,
				data: $('#contact_form').serialize(),
				success: function(data) 
				{ 
					var data = $.parseJSON(data);

					if(data.CSRF_NAME && data.CSRF_HASH)
					$('input[name="'+data.CSRF_NAME+'"]').val(data.CSRF_HASH);					

					$('#contact-error').hide();
					
					if(data.RES =='OK')
					{
						$('#contact_form #contact-failed').hide();
						$('#contact_form #contact-loading').hide();
						$('#contact_form #contact-success').show();
						$('#contact-form').hide();						
						
						$('#firstname').val('');
						$('#lastname').val('');
						$('#email').val('');
						$('#mobile').val('');
						$('#message').val('');
						$('#security_code').val('');
					}
					else
					{
						$('#contact_form #contact-failed').html('');
						$('#contact_form #contact-success').hide();
						$('#contact_form #contact-loading').hide();
						$('#contact_form #contact-failed').show();
						$('#contact-form').hide();						
						$.each(data.MSG, function(i, item) {
						    $('#contact_form #contact-failed').append(item);
						});
						setTimeout("$('#contact_form #contact-failed').hide();$('#contact-form').show();",2000);
					}
				}
			});	
		}
	}
	
	
	
	
	// Contact form validation
	
	function comment_submit()
	{		
		var submit_flag = 'yes';
		
		var point = $('#point').val();
		if( point =='')
		{
			if(submit_flag == 'yes')
			{
				$('#point').focus();
			}
			$('#point').addClass('error');
			submit_flag = 'no';
		}
		
		var comment = $('#comment').val();
		if( comment =='' || comment== 'Yorumunuz *')
		{
			if(submit_flag == 'yes')
			{
				$('#comment').focus();
			}
			$('#comment').addClass('error');
			submit_flag = 'no';
		}
		
		var security_code = $('#security_code2').val();
		if( security_code =='')
		{
			if(submit_flag == 'yes')
			{
				$('#security_code').focus();
			}
			$('#security_code2').addClass('error');
			submit_flag = 'no';
		}		
		
		if(submit_flag != 'yes')
		{	
			return false;
		} else {
			$('#comment_form #contact-success').hide();
			$('#comment_form #contact-failed').hide();
			$('#comment_form #contact-loading').show();
			$('#comment-form').hide();
			$.ajax({
				url: base_url+'users/sendcomment',
				type: 'post',
				cache: false,
				data: $('#comment_form').serialize(),
				success: function(data) 
				{ 
					var data = $.parseJSON(data);

					if(data.CSRF_NAME && data.CSRF_HASH)
					$('input[name="'+data.CSRF_NAME+'"]').val(data.CSRF_HASH);					
					
					if(data.RES =='OK')
					{
						$('#comment_form #contact-failed').hide();
						$('#comment-form').hide();
						$('#comment_form #contact-loading').hide();
						$('#comment_form #contact-success').show();
						
						$('#point').val('');
						$('#comment').val('');
						$('#security_code2').val('');
					}
					else
					{
						$('#comment_form #contact-failed').html('');
						$('#comment_form #contact-success').hide();
						$('#comment-form').hide();
						$('#comment_form #contact-loading').hide();
						$('#comment_form #contact-failed').show();
						$.each(data.MSG, function(i, item) {
						    $('#comment_form #contact-failed').append(item);
						});
						setTimeout("$('#comment_form #contact-failed').hide();$('#comment-form').show();",2000);
					}
				}
			});	
		}
	}	
})(jQuery);

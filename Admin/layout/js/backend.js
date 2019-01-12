/*global $*/
$(function () {
    "use strict";
    /*edit place holder*/
    $('[placeholder]').focusin(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
        
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    /*end place holder*/
    /*edit asterisk*/
    $('input').each(function(){
    		if($(this).attr("required")=="required"){
                $(this).after("<span class='asterisk'>*</span")
                
    		}
    });
    /*end asterisk*/
    $('.eye').on('click',function(){
    	if($('.password').attr('type')=='password')
    	{
    		$('.password').attr('type','text');
    	}else
    	{
    		$('.password').attr('type','password');
    	}
    	
    });
    $('.confirm').click(function(){
    	return confirm("are you sure you want to delete?")
    });

    /*this for category slide */
    $(".cat h3").click(function(){
        $(this).next().slideToggle();
    });
    
});
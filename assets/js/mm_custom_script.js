 jQuery(document).ready(function(){

 	var $ = jQuery;

	 $(".mm_icon_group").click(function(){

	   $(this).find(":radio").attr('checked', true);

	   $('.mm_icon_group').not(this).removeClass('icon_checked');
	   $(this).toggleClass('icon_checked');
	   
	   $('.mm_icon').not(this).removeClass('mm_icon_checked');
	   $(this).find(".mm_icon").toggleClass('mm_icon_checked');	   

	 });

	 $("#mm_featured").click(function(){
	    if($(this).is(":checked")) {
		    $(".mm_set_marker_animation").fadeIn();
		} else {
		    $(".mm_set_marker_animation").fadeOut();
		}	 	
	 });

	 $("#mm_add_coordinates").click(function(){
	    if($(this).is(":checked")) {
		    $("#mm_latitude").prop("disabled", false);
		    $("#mm_latitude").css({"cursor": "auto", "background-color": "#ffffff"});

		    $("#mm_longitude").prop("disabled", false);
		    $("#mm_longitude").css({"cursor": "auto", "background-color": "#ffffff"});
		} else {
		    $("#mm_latitude").prop("disabled", true);
		    $("#mm_latitude").css({"cursor": "no-drop", "background-color": "#f1f1f1"});

		    $("#mm_longitude").prop("disabled", true);
		    $("#mm_longitude").css({"cursor": "no-drop", "background-color": "#f1f1f1"});
		}	 	
	 });

 });
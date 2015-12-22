<?php 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action('admin_menu', 'mm_help_page');
 
function mm_help_page(){       
    add_submenu_page( 
       	'mm_menu_page', 
       	'Help', 
       	'Help', 
       	'administrator', 
       	'mm_menu_page_handle', 
       	'mm_help_menu_display'
    	);

}

function mm_help_menu_display($object) { ?>

  <div class="wraper">

	<h1>Help Menu</h1>
	<hr>
	<p>To include map on page or post simply add this shortcode <code><strong>[mm_map]</strong></code> </p>  

  </div>

<?php
}

?>
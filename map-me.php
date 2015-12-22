<?php
 /*
 Plugin Name: Map Me
 Plugin URI: 
 Description: Google Maps Plugin
 Author: MarcatoM
 Version: 0.1
 Author URI: http://marcatom.xyz
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
  exit;
} 

function icons_path(){
  $folder =  plugin_dir_url( __FILE__ ) . 'assets/icons/';
  return $folder;
} 
function icons_dir_path(){
  $folder =  plugin_dir_path( __FILE__ ) . 'assets/icons/';
  return $folder;
} 
 
include 'admin/plugin_menu_page.php';
include 'admin/add_locations.php';
include 'admin/help_menu_page.php';


function mm_styles_and_scripts() {	 
  wp_enqueue_script('map-styles', plugins_url( '/assets/js/map_styles.js' , __FILE__ ), array('jquery'), '1.0', true);
	wp_register_script('maps-api', '//maps.googleapis.com/maps/api/js', true);
	wp_register_script('init-script', plugins_url( '/assets/js/init.js' , __FILE__ ), array('jquery'), '1.0', true);	
}
add_action( 'wp_enqueue_scripts', 'mm_styles_and_scripts' );



function mm_location_styles() {
    global $post_type;
    if( 'mm' == $post_type ){     
      wp_enqueue_style( 'mm_custom_styles', plugins_url( '/assets/css/mm_custom_styles.css', __FILE__ )); 
      wp_enqueue_script( 'mm_custom_script', plugins_url( '/assets/js/mm_custom_script.js', __FILE__ ), array('jquery'), '1.0', true);  
    }
}
add_action( 'admin_print_scripts-post-new.php', 'mm_location_styles', 11 );
add_action( 'admin_print_scripts-post.php', 'mm_location_styles', 11 );



// Map 
function mm_map(){ 

	wp_enqueue_script( 'maps-api' );
	wp_enqueue_script( 'init-script' );

  $map_settings = get_option('mm_plugin_settings');

  if ($map_settings['scroll'] == 1) {
    $scroll = true;
  } else {
    $scroll = false;
  }

  if ($map_settings['controls'] == 1) {
    $controls = true;
  } else {
    $controls = false;
  }

  $map_options = array();   
  array_push( $map_options, [ $map_settings['zoom'], $scroll, $controls, $map_settings['styles'] ] );



	$locations_a = array();

	$args = array(
      'post_type'           => 'mm',
      'post_status'         => 'publish',
      'posts_per_page'      => -1
      );
    $loop = new WP_Query( $args );

    while ( $loop->have_posts() ) : $loop->the_post(); 

    $mm_title = get_the_title(); 

    $the_post_id = get_the_ID();     

    $mm_longitude = get_post_meta(get_the_ID(), 'mm_longitude', true);
  	$mm_latitude = get_post_meta(get_the_ID(), 'mm_latitude', true);

  	$mm_address = get_post_meta(get_the_ID(), "mm_address", true);
	  $mm_city = get_post_meta(get_the_ID(), "mm_city", true);
	  $mm_zip = get_post_meta(get_the_ID(), "mm_zip", true);
	  $mm_country = get_post_meta(get_the_ID(), "mm_country", true);

  	$mm_url = get_post_meta(get_the_ID(), "mm_url", true);
 	  $mm_featured = get_post_meta(get_the_ID(), "mm_featured", true);

    $mm_description = get_post_meta(get_the_ID(), "mm_description", true);

    $mm_icon = get_post_meta(get_the_ID(), "mm_icon", true);

    $mm_featured_animation = get_post_meta(get_the_ID(), "mm_featured_animation", true);

  	array_push($locations_a, [
      $mm_longitude, 
      $mm_latitude, 
      $mm_title, 
      $mm_address, 
      $mm_zip, 
      $mm_city, 
      $mm_country, 
      $mm_url, 
      $mm_featured, 
      $mm_description, 
      $mm_icon,
      $mm_featured_animation
      ] );
    endwhile;

    wp_reset_postdata();

    $center_at = geocode($map_settings['zip'].', '.$map_settings['city'].', '.$map_settings['country'].', '.$map_settings['address']);
 
?>
<script>	
	var location_marker = <?php echo json_encode($locations_a); ?>;
  var map_options = <?php echo json_encode($map_options); ?>;	

  var center_at = <?php echo json_encode($center_at); ?>; 

</script>


	<div id="googleMap" style="width:100%;height:<?php echo $map_settings['height']; ?>px;"></div>

<?php
}


// ADD EG A FORM TO THE PAGE
function mm_shortcode(){ 	
  	return mm_map();		
 }
add_shortcode("mm_map", "mm_shortcode"); 

?>
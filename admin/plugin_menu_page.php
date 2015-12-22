<?php 

function mm_dashboard_page() {
 
    add_menu_page(
        'Map Me',           
        'Map Me',           
        'administrator',            
        'mm_menu_page',   
        'mm_display_page',
        'dashicons-admin-site',
        20    
    );

    add_submenu_page( 
        'mm_menu_page',
        'Map Me Settings',
        'Settings',  
        'administrator', 
        'mm_plugin_settings', 
        'mm_display_page'
    );
 
} 
add_action('admin_menu', 'mm_dashboard_page');



function mm_default_center_options() {
    
    $defaults = array(
        'city'            =>  '',
        'zip'             =>  '',
        'country'         =>  '',
        'address'         =>  ''                  
    );
    
    return apply_filters( 'mm_default_center_options', $defaults );
    
}

function mm_default_display_options() {
    
    $defaults = array(
        'zoom'            =>  7,
        'scroll'          =>  false,
        'controls'        =>  true,   
        'styles'          =>  'default',
        'height'          =>  380                   
    );
    
    return apply_filters( 'mm_default_display_options', $defaults );
    
}

function mm_initialize_plugin_options() {
    
    if( false == get_option( 'mm_plugin_settings' ) ) {  
        add_option( 'mm_plugin_settings', apply_filters( 'mm_default_center_options', mm_default_center_options() ) );
    } 

    
    add_settings_section(
        'general_settings_section',        
        __( 'Center Map', 'sandbox' ),     
        'mm_general_options_callback', 
        'mm_plugin_settings'     
    );
    
   
    add_settings_field( 
        'city',                      
        __( 'City', 'sandbox' ),                          
        'mm_city_callback', 
        'mm_plugin_settings',   
        'general_settings_section',        
        array(                              
            __( ' Name of the city.', 'sandbox' ),
        )
    );
    add_settings_field( 
        'zip',                      
        __( 'Zip Code', 'sandbox' ),                          
        'mm_zip_callback', 
        'mm_plugin_settings',   
        'general_settings_section',        
        array(                              
            __( ' Enter a zip code.', 'sandbox' ),
        )
    );
    add_settings_field( 
        'country',                      
        __( 'Country', 'sandbox' ),                          
        'mm_country_callback', 
        'mm_plugin_settings',   
        'general_settings_section',        
        array(                              
            __( ' Country or State name', 'sandbox' ),
        )
    );
    add_settings_field( 
        'address',                      
        __( 'Address', 'sandbox' ),                          
        'mm_address_callback', 
        'mm_plugin_settings',   
        'general_settings_section',        
        array(                              
            __( ' Street name and number', 'sandbox' ),
        )
    );
    
  
    register_setting(
        'mm_plugin_settings',
        'mm_plugin_settings'
    );
    
} 
add_action( 'admin_init', 'mm_initialize_plugin_options' );


function mm_general_options_callback() {
    echo '<p>' . __( 'Enter at least one location parameter.</br>For more precise centering populate more fields.', 'sandbox' ) . '</p>';
}





function mm_initialize_plugin_display_options() {
    
    if( false == get_option( 'mm_plugin_settings' ) ) {  
        add_option( 'mm_plugin_settings', apply_filters( 'mm_default_display_options', mm_default_display_options() ) );
    } 

    
    add_settings_section(
        'general_display_settings_section',        
        __( 'Display Options', 'sandbox' ),     
        'mm_general_display_options_callback', 
        'mm_plugin_settings'     
    );    
   

    add_settings_field( 
        'zoom',                      
        __( 'Initial Zoom', 'sandbox' ),                          
        'mm_zoom_callback', 
        'mm_plugin_settings',   
        'general_display_settings_section',        
        array(                              
            __( ' Map Zoom.', 'sandbox' ),
        )
    );
    add_settings_field( 
        'scroll',                      
        __( 'Mouse Scroll', 'sandbox' ),                          
        'mm_scroll_callback', 
        'mm_plugin_settings',   
        'general_display_settings_section',        
        array(                              
            __( ' Eneable scrolling/zooming over map.', 'sandbox' ),
        )
    );
    add_settings_field( 
        'controls',                      
        __( 'Controls', 'sandbox' ),                          
        'mm_controls_callback', 
        'mm_plugin_settings',   
        'general_display_settings_section',        
        array(                              
            __( ' Hide controls on the map.', 'sandbox' ),
        )
    ); 
    add_settings_field( 
        'styles',                      
        __( 'Map Sytele', 'sandbox' ),                          
        'mm_styles_callback', 
        'mm_plugin_settings',   
        'general_display_settings_section',        
        array(                              
            __( ' Choose your prefered map style.', 'sandbox' ),
        )
    );

    add_settings_field( 
        'height',                      
        __( 'Map Height', 'sandbox' ),                          
        'mm_height_callback', 
        'mm_plugin_settings',   
        'general_display_settings_section',        
        array(                              
            __( ' (width is always 100% of parent element).', 'sandbox' ),
        )
    );     
    
  
    register_setting(
        'mm_plugin_settings',
        'mm_plugin_settings'
    );
    
} 
add_action( 'admin_init', 'mm_initialize_plugin_display_options' );


function mm_general_display_options_callback() {
    echo '<p>' . __( 'Display options.', 'sandbox' ) . '</p>';
}








function mm_city_callback($args) {
    $options = get_option('mm_plugin_settings');
    $html = '<input type="text" id="city" name="mm_plugin_settings[city]" value="'.$options['city'].'" />';   
    $html .= '<label for="city">&nbsp;'  . $args[0] . '</label>';     
    echo $html;    
}  

function mm_zip_callback($args) {
    $options = get_option('mm_plugin_settings');  
    $html = '<input type="text" id="zip" name="mm_plugin_settings[zip]" value="'.$options['zip'].'" />';    
    $html .= '<label for="zip">&nbsp;'  . $args[0] . '</label>';    
    echo $html;
} 

function mm_country_callback($args) {
    $options = get_option('mm_plugin_settings');  
    $html = '<input type="text" id="country" name="mm_plugin_settings[country]" value="'.$options['country'].'" />';    
    $html .= '<label for="country">&nbsp;'  . $args[0] . '</label>';    
    echo $html;
} 

function mm_address_callback($args) {
    $options = get_option('mm_plugin_settings');  
    $html = '<input type="text" id="address" name="mm_plugin_settings[address]" value="'.$options['address'].'" />';     
    $html .= '<label for="address">&nbsp;'  . $args[0] . '</label>';    
    echo $html;
}  

// Display Options

function mm_zoom_callback($args) {
    $options = get_option('mm_plugin_settings'); ?>

    <select name="mm_plugin_settings[zoom]">
          <?php              
              for( $i = 1; $i <= 18; $i++ ){
                  if($i == $options['zoom']){
                      ?>
                          <option selected><?php echo $i; ?></option>
                      <?php    
                  }else{
                      ?>
                          <option><?php echo $i; ?></option>
                      <?php
                  }
              }
          ?>
      </select>
<?php   
}

function mm_scroll_callback($args) {    
    $options = get_option('mm_plugin_settings');    
    $html = '<input type="checkbox" id="mm_scroll" name="mm_plugin_settings[scroll]"" value="1" ' . checked( 1, isset( $options['scroll'] ) ? $options['scroll'] : 0, false ) . '/>'; 
    $html .= '<label for="scroll">&nbsp;'  . $args[0] . '</label>';     
    echo $html;
    
}

function mm_controls_callback($args) {    
    $options = get_option('mm_plugin_settings');    
    $html = '<input type="checkbox" id="mm_controls" name="mm_plugin_settings[controls]"" value="1" ' . checked( 1, isset( $options['controls'] ) ? $options['controls'] : 0, false ) . '/>'; 
    $html .= '<label for="controls">&nbsp;'  . $args[0] . '</label>';     
    echo $html;
    
}

function mm_styles_callback($args) {
    $options = get_option('mm_plugin_settings'); ?>

      <select id="mm_styles" name="mm_plugin_settings[styles]">
          <?php 
              $option_values = array(
                'subtile_gray_scale',
                'blue_water',
                'ultra_light_with_labels',
                'pale_dawn',
                'apple_maps_esque',
                'blue_essence',
                'light_dream',
                'paper',
                'light_monochrome',
                'flat_map',
                'black_and_white',
                'cool_grey',
                'retro',
                'midnight_commander',
                'shades_of_grey',
                'vitamin_c',
                'flat_green',
                'red_alert',
                'default',
                'the_propia_effect'
                );
              sort($option_values);
              foreach($option_values as $key => $value){
                  if($value == $options['styles']){
                      ?>
                          <option value="<?php echo $value; ?>" selected><?php echo ucwords(str_replace('_', ' ', $value)); ?></option>
                      <?php    
                  }else{
                      ?>
                          <option value="<?php echo $value; ?>"><?php echo ucwords(str_replace('_', ' ', $value)); ?></option>
                      <?php
                  }
              }
          ?>
      </select>

      <label for="mm_styles"> <?php echo $args[0]; ?></label>
<?php   
}


function mm_height_callback($args) {
    $options = get_option('mm_plugin_settings');  
    $html = '<input type="number" id="height" name="mm_plugin_settings[height]" value="'.$options['height'].'" />';    
    $html .= '<span>px </span>';
    $html .= '<label for="height">&nbsp;'  . $args[0] . '</label>';    
    echo $html;
} 


function mm_display_page() { ?> 
    
<div class="wrap" style="background-color:#ADCDFF;margin:0;padding:10px;border-bottom:1px solid #0085BA;">
  <h2>Map Me Settings</h2>
  <p class="description">Set your center point on the map and customize your display options.</p>
</div>

    <form method="post" action="options.php" style="background-color:#fff; padding:15px;">
    <?php                
        settings_fields( 'mm_plugin_settings' );
        do_settings_sections( 'mm_plugin_settings' );
                
        submit_button();            
    ?>
    </form>     


<?php     
} 


?>
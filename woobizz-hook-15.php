<?php
/*
Plugin Name: Woobizz Hook 15
Plugin URI: http://woobizz.com
Description: Change billing & shipping titles and limit number of caracters to 30
Author: Woobizz
Author URI: http://woobizz.com
Version: 1.0.0
Text Domain: woobizzhook15
Domain Path: /lang/
*/
//Prevent direct acces
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Load translation
add_action( 'plugins_loaded', 'woobizzhook15_load_textdomain' );
function woobizzhook15_load_textdomain() {
  load_plugin_textdomain( 'woobizzhook15', false, basename( dirname( __FILE__ ) ) . '/lang' ); 
}
//Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	//echo "woocommerce is active";
	add_filter( 'woocommerce_checkout_fields' , 'custom_wc_checkout_fields' );
    add_action("wp_footer", "woobizzhook15_max_length");
	add_filter( 'woocommerce_after_checkout_form' , 'woobizzhook15_lightbox_content' );
	
}else{
	//Show message on admin
	//echo "woocommerce is not active";
	add_action( 'admin_notices', 'woobizzhook15_wc_admin_notice' );
}
//Check if Woobizz LightBox is active
if ( in_array( 'woobizz-lightbox/woobizz-lightbox.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	//echo "woobizz lightbox is active";
	
	
}else{
	//Show message on admin
	//echo "woobizz lightbox is not active";
	add_action( 'admin_notices', 'woobizzhook15_lb_admin_notice' );
	
}
//Add Hook 15
//Change billing & shipping titles
//---------------------------------------------------------------
// START HOOK 15 FUNCTIONS
//---------------------------------------------------------------
function custom_wc_checkout_fields( $fields ) {
	
	//variables to translate
	$woobizzhook15_label1= __('Adresse Line 1','woobizzhook15');
	$woobizzhook15_limit= __('30 characters máx.','woobizzhook15');
	$woobizzhook15_link= __('READ!','woobizzhook15');
	$woobizzhook15_label2= __('Address Line 2','woobizzhook15');
	//Billing & Shipping		
	$fields['billing']['billing_address_1']['label'] = $woobizzhook15_label1." (".$woobizzhook15_limit.") "."<a href='#' data-featherlight='#BAD1'><strong>".$woobizzhook15_link."</strong></a>";	
	$fields['billing']['billing_address_2']['label'] = $woobizzhook15_label2." (".$woobizzhook15_limit.") "."<a href='#' data-featherlight='#BAD2'><strong>".$woobizzhook15_link."</strong></a>";	
	$fields['shipping']['shipping_address_1']['label'] = $woobizzhook15_label1." (".$woobizzhook15_limit.") "."<a href='#' data-featherlight='#SAD1'><strong>".$woobizzhook15_link."</strong></a>";	
	$fields['shipping']['shipping_address_2']['label'] = $woobizzhook15_label2." (".$woobizzhook15_limit.") "."<a href='#' data-featherlight='#SAD1'><strong>".$woobizzhook15_link."</strong></a>";	
	return $fields;

}
function woobizzhook15_lightbox_content(){
	//Titles
	$woobizzhook15_lightbox_title_address1= __('Address Line 1');
	$woobizzhook15_lightbox_title_adresse2= __('Address Line 2','woobizzhook15');
	//Shipping Content
	$woobizzhook15_lightbox_line1_text1= __('Fill this space only with the name and number of the street where you live (street, avenue, boulevard, etc.), use the next space to write any other data. This box is limited to 30 characters, use abbreviations if necessary.','woobizzhook15');
	$woobizzhook15_lightbox_line1_text2= __('Please remember to verify your address before you send it, any mistake may result in the loss or return of the product, causing extra costs. These shall be entirely your responsibility.','woobizzhook15','woobizzhook15');
	$woobizzhook15_lightbox_line2_text1= __('Use this space to write any other data such as your building’s name, the area, urbanization, floor number or other address details. This box is limited to 30 characters, use abbreviations if necessary.','woobizzhook15');
	$woobizzhook15_lightbox_line2_text2= __('Please remember to verify your address before you send it, any mistake may result in the loss or return of the product, causing extra costs. These shall be entirely your responsibility.','woobizzhook15');	?>
	<html>	
		<div id="BAD1" class="lightbox">
			<div class="wb-lightbox-content">
			<h2><?php echo $woobizzhook15_lightbox_title_address1;?></h2>
			<p><?php echo $woobizzhook15_lightbox_line1_text1;?></p>
			<p><?php echo $woobizzhook15_lightbox_line1_text2;?></p>
			</div>

		</div>
		<div id="BAD2" class="lightbox">
			<div class="wb-lightbox-content">		
			<h2><?php echo $woobizzhook15_lightbox_title_adresse2;?></h2>
			<p><?php echo $woobizzhook15_lightbox_line2_text1;?></p>
			<p><?php echo $woobizzhook15_lightbox_line2_text2;?></p>
			</div>

		</div>
		<div id="SAD1" class="lightbox">
			<div class="wb-lightbox-content">
			<h2><?php echo $woobizzhook15_lightbox_title_address1;?></h2>
			<p><?php echo $woobizzhook15_lightbox_line1_text1;?></p>
			<p><?php echo $woobizzhook15_lightbox_line1_text2;?></p>
			</div>

		</div>
		<div id="SAD2" class="lightbox">
			<div class="wb-lightbox-content">		
			<h2><?php echo $woobizzhook15_lightbox_title_adresse2;?></h2>
			<p><?php echo $woobizzhook15_lightbox_line2_text1;?></p>
			<p><?php echo $woobizzhook15_lightbox_line2_text2;?></p>
			</div>

		</div>
				
	</html>		
	<?php
}
//Limit number of caracteres
function woobizzhook15_max_length(){
	if( !is_checkout())	
	return;
	?>
	<script>
	jQuery(document).ready(function($){
		  $("#billing_address_1").attr('maxlength','30');
		  $("#billing_address_2").attr('maxlength','30');
		  $("#shipping_address_1").attr('maxlength','30');
		  $("#shipping_address_2").attr('maxlength','30');
		 // more fields
	});
	</script>
	<?php
}	
//Hook15 Woccomerce Notice
function woobizzhook15_wc_admin_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'Woobizz Hook 15 needs WooCommerce to work properly, If you do not use this plugin you can disable it!', 'woobizzhook15' ); ?></p>
    </div>
    <?php
}
//Hook15 Woccomerce Notice
function woobizzhook15_lb_admin_notice() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'Woobizz Hook 15 needs Woobizz Lightbox to work properly, If you do not use this plugin you can disable it!', 'woobizzhook15' ); ?></p>
    </div>
    <?php
}
//---------------------------------------------------------------
// END HOOK 15 FUNCTIONS
//---------------------------------------------------------------
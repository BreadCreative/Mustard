<?php
/*Plugin Name: Online Worldpay For WooCommerce
 Plugin URI: https://wordpress.paymentplugins.com
 Description: Accept credit card and PayPal payments or donations on your wordpress site using your Online Worldpay merchant account. This plugin is SAQ A compliant.
 Version: 1.2.2
 Author: Clayton Rogers, mr.clayton@paymentplugins.com
 Author URI:
 Tested up to: 4.7.3
 */

if( version_compare( PHP_VERSION, '5.3', '<') ){
	add_action( 'admin_notices', function(){
		?>
		<div class="notice notice-error">
		  <p><?php echo sprintf(__('Online Worldpay For WooCommerce requires at least PHP Version 5.3 but you are using version %s', 'onlineworldpay'), PHP_VERSION )?></p>
		</div>
		<?php
	});
	return;
}
define('ONLINEWORLDPAY_LICENSE_ACTIVATION_URL', 'https://wordpress.paymentplugins.com/');
define('ONLINEWORLDPAY_LICENSE_VERIFICATION_KEY', 'gTys$hsjeScg63dDs35JlWqbx7h');
define('ONLINEWORLDPAY_ADMIN', plugin_dir_path( __FILE__ ) . 'admin/');
define('ONLINEWORLDPAY_PAYMENTS', plugin_dir_path( __FILE__ ) . 'payments/' );
define('ONLINEWORLDPAY_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );
define('ONLINEWORLDPAY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

include_once( ONLINEWORLDPAY_PLUGIN_PATH . 'class-loader.php' );
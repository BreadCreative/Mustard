<?php 
/*
Plugin Name: Order Delivery Date for WooCommerce (Lite version)
Plugin URI: http://www.tychesoftwares.com/store/free-plugin/order-delivery-date-on-checkout/
Description: This plugin allows customers to choose their preferred Order Delivery Date during checkout.
Author: Tyche Softwares
Version: 2.9
Author URI: http://www.tychesoftwares.com/about
Contributor: Tyche Softwares, http://www.tychesoftwares.com/
*/

$wpefield_version = '2.9';

include_once( 'integration.php' );
include_once( 'orddd-lite-config.php' );
include_once( 'orddd-lite-common.php' );
include_once( 'orddd-lite-settings.php' );
include_once( 'orddd-lite-process.php' );
include_once( 'filter.php' );

if ( !class_exists( 'order_delivery_date_lite' ) ) {
    class order_delivery_date_lite {
        
        public function __construct() {
            //Initialize settings
            register_activation_hook( __FILE__,  array( &$this, 'orddd_lite_activate' ) );
            register_uninstall_hook( __FILE__,   array( 'order_delivery_date_lite', 'orddd_lite_deactivate' ) );

            add_action( 'init',                  array( &$this, 'orddd_lite_update_po_file' ) );
            add_action( 'admin_init',            array( &$this, 'orddd_lite_update_db_check' ) );
            add_action( 'admin_init',            array( &$this, 'orddd_lite_capabilities' ) );
            add_action( 'admin_init',            array( &$this, 'orddd_lite_check_if_woocommerce_active' ) );
            add_action( 'admin_footer',          array( &$this, 'admin_notices_scripts' ) );
            add_action( 'wp_ajax_admin_notices', array( &$this, 'orddd_lite_admin_notices' ) );
            add_action( 'admin_notices',         array( &$this, 'order_lite_coupon_notice' ) );
            
            //To create timestamp for old orders
            add_action( 'admin_init',            array( &$this, 'orddd_create_timestamp_for_old_order' ) );

            //Settings
            add_action( 'admin_menu', array( 'orddd_lite_settings', 'orddd_lite_order_delivery_date_menu' ) );
            add_action( 'admin_init', array( 'orddd_lite_settings', 'order_lite_delivery_date_admin_settings' ) );
            add_action( 'admin_init', array( 'orddd_lite_settings', 'order_lite_appearance_admin_settings' ) );
            add_action( 'admin_init', array( 'orddd_lite_settings', 'order_lite_holidays_admin_settings' ) );
            add_action( 'admin_init', array( 'orddd_lite_settings', 'orddd_lite_delete_settings' ) );

            //Admin scripts
            add_action( 'admin_enqueue_scripts', array( &$this,  'orddd_lite_my_enqueue' ) );

            //Frontend
            add_action( ORDDD_LITE_SHOPPING_CART_HOOK, array( 'orddd_lite_process', 'orddd_lite_my_custom_checkout_field' ) );
            add_action( ORDDD_LITE_SHOPPING_CART_HOOK, array( &$this, 'orddd_lite_front_scripts_js' ) );

            add_action( 'woocommerce_checkout_update_order_meta', array( 'orddd_lite_process', 'orddd_lite_my_custom_checkout_field_update_order_meta' ) );
           
            if ( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, "2.3", '>=' ) < 0 ) {
                add_filter( 'woocommerce_email_order_meta_fields', array( 'orddd_lite_process', 'orddd_lite_add_delivery_date_to_order_woo_new' ), 11, 3 );
            } else {
                add_filter( 'woocommerce_email_order_meta_keys', array( 'orddd_lite_process', 'orddd_lite_add_delivery_date_to_order_woo_deprecated' ), 11, 1 );
            }
            
            if ( get_option( 'orddd_lite_date_field_mandatory' ) == 'checked' && get_option( 'orddd_lite_enable_delivery_date' ) == 'on' ) {
                add_action( 'woocommerce_checkout_process', array( 'orddd_lite_process', 'orddd_lite_validate_date_wpefield' ) );
            }

            add_filter( 'woocommerce_order_details_after_order_table', array( 'orddd_lite_process', 'orddd_lite_add_delivery_date_to_order_page_woo' ) );

            //WooCommerce Edit Order page
            add_filter( 'manage_edit-shop_order_columns', array( 'orddd_lite_filter', 'orddd_lite_woocommerce_order_delivery_date_column'), 20, 1 );
            add_action( 'manage_shop_order_posts_custom_column', array( 'orddd_lite_filter', 'orddd_lite_woocommerce_custom_column_value') , 20, 1 );
            add_filter( 'manage_edit-shop_order_sortable_columns', array( 'orddd_lite_filter', 'orddd_lite_woocommerce_custom_column_value_sort' ) );
            add_filter( 'request', array( 'orddd_lite_filter', 'orddd_lite_woocommerce_delivery_date_orderby' ) );

            //To recover the delivery date when order is cancelled, refunded, failed or trashed.
            add_action( 'woocommerce_order_status_cancelled' , array( 'orddd_lite_common', 'orddd_lite_cancel_delivery' ), 10, 1 );
            add_action( 'woocommerce_order_status_refunded' , array( 'orddd_lite_common', 'orddd_lite_cancel_delivery' ), 10, 1 );
            add_action( 'woocommerce_order_status_failed' , array( 'orddd_lite_common', 'orddd_lite_cancel_delivery' ), 10, 1 );
            add_action( 'wp_trash_post', array( 'orddd_lite_common', 'orddd_lite_cancel_delivery_for_trashed' ), 10, 1 );
        }
        
        function orddd_lite_activate() {
            global $orddd_lite_weekdays;
        
            add_option( 'orddd_lite_enable_delivery_date', '' );
            foreach ( $orddd_lite_weekdays as $n => $day_name ) {
                add_option( $n, 'checked' );
            }
            add_option( 'orddd_lite_minimumOrderDays', '0' );
            add_option( 'orddd_lite_number_of_dates', '30' );
            add_option( 'orddd_lite_date_field_mandatory', '' );
            add_option( 'orddd_lite_lockout_date_after_orders', '' );
            add_option( 'orddd_lite_lockout_days', '' );
            add_option( 'orddd_lite_update_value', 'yes' );
            add_option( 'orddd_lite_abp_hrs', 'HOURS' );
            add_option( 'orddd_lite_default_appearance_settings', 'yes' );
            add_option( 'orddd_lite_enable_default_sorting_of_column', '' );
            add_option( 'orddd_lite_enable_delivery_date_enabled', 'yes' );
            
            // appearance options
            add_option( 'orddd_lite_delivery_date_format', ORDDD_LITE_DELIVERY_DATE_FORMAT );
            add_option( 'orddd_lite_delivery_date_field_label', ORDDD_LITE_DELIVERY_DATE_FIELD_LABEL );
            add_option( 'orddd_lite_delivery_date_field_placeholder', ORDDD_LITE_DELIVERY_DATE_FIELD_PLACEHOLDER );
            add_option( 'orddd_lite_delivery_date_field_note', ORDDD_LITE_DELIVERY_DATE_FIELD_NOTE );
            add_option( 'orddd_lite_number_of_months', '1' );
            add_option( 'orddd_lite_calendar_theme', ORDDD_LITE_CALENDAR_THEME );
            add_option( 'orddd_lite_calendar_theme_name', ORDDD_LITE_CALENDAR_THEME_NAME );
            add_option( 'orddd_lite_language_selected', 'en-GB' );
            add_option( 'orddd_lite_delivery_date_fields_on_checkout_page', 'billing_section' );
            add_option( 'orddd_lite_no_fields_for_virtual_product', '' );
            add_option( 'orddd_lite_no_fields_for_featured_product', '' );

            //flags
            add_option( 'orddd_lite_update_calculate_min_time_disabled_days', 'yes' );
        }

        public static function orddd_lite_deactivate() {
            global $orddd_lite_weekdays;
            delete_option( 'orddd_lite_db_version' );
            foreach ( $orddd_lite_weekdays as $n => $day_name ) {
                delete_option( $n );
            }

            delete_option( 'orddd_lite_enable_delivery_date' );
            delete_option( 'orddd_lite_minimumOrderDays' );
            delete_option( 'orddd_lite_number_of_dates' );
            delete_option( 'orddd_lite_date_field_mandatory' );
            delete_option( 'orddd_lite_admin_notices' );
            delete_option( 'orddd_lite_lockout_date_after_orders' );
            delete_option( 'orddd_lite_lockout_days' );
            delete_option( 'orddd_lite_update_value' );
            delete_option( 'orddd_lite_abp_hrs' );
            delete_option( 'orddd_lite_enable_default_sorting_of_column' );

            // appearance options
            delete_option( 'orddd_lite_delivery_date_field_label' );
            delete_option( 'orddd_lite_delivery_date_field_placeholder' );
            delete_option( 'orddd_lite_delivery_date_field_note' );
            delete_option( 'orddd_lite_delivery_date_format' );
            delete_option( 'orddd_lite_number_of_months' );
            delete_option( 'orddd_lite_calendar_theme' );
            delete_option( 'orddd_lite_calendar_theme_name' );
            delete_option( 'orddd_lite_language_selected' );
            delete_option( 'orddd_lite_delivery_date_fields_on_checkout_page' );
            delete_option( 'orddd_lite_default_appearance_settings' );    
            delete_option( 'orddd_lite_no_fields_for_virtual_product' );
            delete_option( 'orddd_lite_no_fields_for_featured_product' );

            //holidays
            delete_option( 'orddd_lite_holidays' );
        }

        // For language translation
        function  orddd_lite_update_po_file() {
            $domain = 'order-delivery-date';
            $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
            if ( $loaded = load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '-' . $locale . '.mo' ) ) {
                return $loaded;
            } else {
                load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
            }
        }

        /**
         * Check if WooCommerce is active.
         */
        public static function orddd_lite_check_woo_installed() {
            if ( class_exists( 'WooCommerce' ) ) {
                return true;
            } else {
                return false;
            }
        }
        
        /**
         * Function checks if the WooCommerce plugin is active or not. If it is not active then it will display a notice.
         *
         */
        
        function orddd_lite_check_if_woocommerce_active() {
            if ( ! self::orddd_lite_check_woo_installed() ) {
                if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
                    deactivate_plugins( plugin_basename( __FILE__ ) );
                    add_action( 'admin_notices', array( 'order_delivery_date_lite', 'orddd_lite_disabled_notice' ) );
                    if ( isset( $_GET[ 'activate' ] ) ) {
                        unset( $_GET[ 'activate' ] );
                    }
                }
            }
        }
        
        /**
         * Display a notice in the admin Plugins page if the booking plugin is
         * activated while WooCommerce is deactivated.
         */
        public static function orddd_lite_disabled_notice() {
            $class = 'notice notice-error';
            $message = __( 'Order Delivery Date for WooCommerce (Lite version) plugin requires WooCommerce installed and activate.', 'order-delivery-date' );
        
            printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
        }
        
       

        /***********************************************************
         * This function returns the order delivery date plugin version number
         **********************************************************/
        
        function get_orddd_lite_version() {
            $plugin_data = get_plugin_data( __FILE__ );
            $plugin_version = $plugin_data[ 'Version' ];
            return $plugin_version;
        }
        
        /***************************************************************
         *  This function is executed when the plugin is updated using
         *  the Automatic Updater. It calls the wpefield_update_install function
         *  which will check the options for the plugin and
         *  make any changes if necessary.
         ***************************************************************/
        
        function orddd_lite_update_db_check() {
            global $orddd_lite_plugin_version, $wpefield_version;
            $orddd_lite_plugin_version = $wpefield_version;
            if ( $orddd_lite_plugin_version == "2.9" ) {
                order_delivery_date_lite::orddd_lite_update_install();
            }
        }
        
        function orddd_lite_update_install() {
            global $wpdb, $orddd_lite_weekdays;
        
            //code to set the option to on as default
            $orddd_lite_plugin_version = get_option( 'orddd_lite_db_version' );
            if ( $orddd_lite_plugin_version != order_delivery_date_lite::get_orddd_lite_version() ) {
                update_option( 'orddd_lite_db_version', '2.9' );
                if ( get_option( 'orddd_lite_update_value' ) != 'yes' ) {
                    $i = 0;
                    foreach ( $orddd_lite_weekdays as $n => $day_name ) {
        
                        $orddd_lite_weekday = get_option( 'orddd_weekday_'.$i );
                        update_option( $n , $orddd_lite_weekday );
                        delete_option( 'orddd_weekday_'.$i );
                        $i++;
                    }
        
                    $orddd_lite_minimumOrderDays = get_option( 'orddd_minimumOrderDays' );
                    update_option( 'orddd_lite_minimumOrderDays', $orddd_lite_minimumOrderDays );
                    delete_option( 'orddd_minimumOrderDays' );
            
                    $orddd_lite_number_of_dates = get_option( 'orddd_number_of_dates' );
                    update_option( 'orddd_lite_number_of_dates', $orddd_lite_number_of_dates );
                    delete_option( 'orddd_number_of_dates' );
        
                    $orddd_lite_date_field_mandatory = get_option( 'orddd_date_field_mandatory' );
                    update_option( 'orddd_lite_date_field_mandatory', $orddd_lite_date_field_mandatory );
                    delete_option( 'orddd_date_field_mandatory' );
        
                    $orddd_lite_lockout_date_after_orders = get_option( 'orddd_lockout_date_after_orders' );
                    update_option( 'orddd_lite_lockout_date_after_orders', $orddd_lite_lockout_date_after_orders );
                    delete_option( 'orddd_lockout_date_after_orders' );
        
                    $orddd_lite_lockout_days = get_option( 'orddd_lockout_days' );
                    update_option( 'orddd_lite_lockout_days', $orddd_lite_lockout_days );
                    delete_option( 'orddd_lockout_days' );
                    
                    // Code to convert the Minimum delivery time(in days) to Minimum delivery time(in hours)
                    $orddd_abp_hrs = get_option( 'orddd_lite_abp_hrs' );
                    if ( $orddd_abp_hrs != 'HOURS' ) {
                        // Convert the Minimum Delivery time in days to hours
                        if ( get_option( 'orddd_lite_minimumOrderDays' ) > 0 ) {
                            $advance_period_hrs = ( get_option( 'orddd_lite_minimumOrderDays' ) + 1 ) * 24;
                            update_option( 'orddd_lite_minimumOrderDays', $advance_period_hrs );
                        }
                        update_option( 'orddd_lite_abp_hrs', 'HOURS' );
                    }
                    
                    update_option( 'orddd_lite_update_value', 'yes' );
                }

                if( get_option( "orddd_lite_default_appearance_settings" ) != 'yes' ) {
                    // appearance options
                    update_option( 'orddd_lite_delivery_date_format', ORDDD_LITE_DELIVERY_DATE_FORMAT );
                    update_option( 'orddd_lite_delivery_date_field_label', ORDDD_LITE_DELIVERY_DATE_FIELD_LABEL );
                    update_option( 'orddd_lite_delivery_date_field_placeholder', ORDDD_LITE_DELIVERY_DATE_FIELD_PLACEHOLDER );
                    update_option( 'orddd_lite_delivery_date_field_note', ORDDD_LITE_DELIVERY_DATE_FIELD_NOTE );
                    update_option( 'orddd_lite_number_of_months', '1' );
                    update_option( 'orddd_lite_calendar_theme', ORDDD_LITE_CALENDAR_THEME );
                    update_option( 'orddd_lite_calendar_theme_name', ORDDD_LITE_CALENDAR_THEME_NAME );
                    update_option( 'orddd_lite_language_selected', 'en-GB' );
                    update_option( 'orddd_lite_date_in_shipping', '' );
                    update_option( 'orddd_lite_default_appearance_settings', 'yes' );
                }

                if ( get_option( "orddd_lite_delivery_date_on_checkout_page_enabled" ) != 'yes' ) {
                    if ( get_option( "orddd_lite_date_in_shipping" ) == 'on' ) {
                        update_option( "orddd_lite_delivery_date_fields_on_checkout_page", "shipping_section" );
                        delete_option( "orddd_lite_date_in_shipping" );                       
                    } else {
                        update_option( "orddd_lite_delivery_date_fields_on_checkout_page", "billing_section" );
                        delete_option( "orddd_lite_date_in_shipping" );
                    }
                    update_option( "orddd_lite_delivery_date_on_checkout_page_enabled", 'yes' );
                }
                
                if ( get_option( 'orddd_lite_enable_delivery_date_enabled' ) != 'yes' ) {
                    update_option( 'orddd_lite_enable_delivery_date', 'on' );                    
                    update_option( 'orddd_lite_enable_delivery_date_enabled', 'yes' );
                }

                if ( get_option( 'orddd_lite_update_calculate_min_time_disabled_days' ) != 'yes' ) {
                    update_option( 'orddd_lite_calculate_min_time_disabled_days', 'on' );                    
                    update_option( 'orddd_lite_update_calculate_min_time_disabled_days', 'yes' );
                }
            }
        }
        
        
        
        /** 
		 * Capability to allow shop manager to edit settings
		 */
		function orddd_lite_capabilities() {
            $role = get_role( 'shop_manager' );
		    if( '' != $role ) {
		        $role->add_cap( 'manage_options' );
		    }
		}
        
        function admin_notices_scripts() {
            wp_enqueue_script(
                'dismiss-notice.js',
                plugins_url('/js/dismiss-notice.js', __FILE__),
                '',
                '',
                false
            );
        
            wp_enqueue_style( 'dismiss-notice', plugins_url('/css/dismiss-notice.css', __FILE__ ) , '', '', false);
        }
        
        function order_lite_coupon_notice() {
            $admin_url = get_admin_url();
            echo '<input type="hidden" id="admin_url" value="' . $admin_url . '"/>';
            $minimum_delivery_notice = get_option( 'orddd_lite_minimum_delivery_notices' );
            if( $minimum_delivery_notice != 'yes' ) {
                if( isset( $_GET['page'] ) && ( $_GET['page'] == 'order_delivery_date_lite' ) ) {
                    ?>
                    <div class="error notice is-dismissible" id="minimum_delivery_time" >
                        <p><?php _e( 'Minimum Delivery time (in days) will now be calculated in hours which is from current WordPress time. To keep the functionality of our plugin intact at your site, we have added +24 hours to the \'Minimum Delivery time (in hours)\' setting.', 'order-delivery-date' ); ?></p>
                    </div>            
                    <?php 
                    update_option( 'orddd_update_minimum_delivery_notice', 'yes' );
                }                
            }
        }
                
        function orddd_lite_admin_notices() {
            if ( get_option( 'orddd_update_minimum_delivery_notice' ) == 'yes' ) {
                update_option( 'orddd_lite_minimum_delivery_notices', 'yes' );
            }  
            die();
        }

        /**
         * This function needs to be called when updating to 1.9 version
         * So that the timestamps for all previous orders of the Order delivery date field are inserted
         * This is necessary for the sorting to give expected results
         *
         */
        function orddd_create_timestamp_for_old_order() {
            global $wpdb;
            $db_updated = get_option( 'orddd_timestamp_update_script' );
        
            if ( $db_updated != 'yes' ) {
                add_action( 'admin_notices', array( &$this, 'orddd_db_update_notice' ) );
            }
        
            if ( isset( $_GET['mode'] ) && $_GET['mode'] == 'update_db' ) {
                global $orddd_lite_date_formats;
                $order_ids_updated = get_option( 'orddd_lite_orders_script_updated' );
                if( $order_ids_updated == 'null' || $order_ids_updated == '' || $order_ids_updated == '{}' || $order_ids_updated == '[]') {
                    $order_ids_updated = array();
                }
                $step_variable = get_option( 'orddd_lite_steps_for_script' );
                if( $step_variable == 'null' || $step_variable == '' || $step_variable == '{}' || $step_variable == '[]') {
                    $step_variable = 1;
                } else {
                    $step_variable = $step_variable + 1;
                }
                $results = $wpdb->get_results( "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type='shop_order' AND post_status IN ('" . implode("','", array_keys( wc_get_order_statuses() )) . "') AND ID NOT IN ('" . implode("','", $order_ids_updated ) . "') LIMIT 300" );
                if( count( $results ) > 0 ) {
                    echo "Step: " . $step_variable;
                }
                foreach( $results as $key => $value ) {
                    $date_str = '';
                    $order_id = $value->ID;
                    $order_ids_updated[] = $order_id;
                    $data = get_post_meta( $order_id );
                    $delivery_date_timestamp = $delivery_date_formatted = '';
                    $delivery_date_prev_timestamp = '';
                    $m = $d = $y = "";
                    $old_order = "NO";
                    if ( isset( $data[ '_orddd_lite_timestamp' ] ) ) {
                        $delivery_date_prev_timestamp = $data['_orddd_lite_timestamp'][0];
                        if( $delivery_date_prev_timestamp == '' ) {
                            $old_order = "YES";
                        }
                    } else {
                        $old_order = "YES";
                    }
        
                    if ( isset( $data[ '_orddd_lite_timestamp' ] ) || isset( $data[ 'Delivery Date' ] ) ) {
                        if ( isset( $data[ '_orddd_lite_timestamp' ] ) ) {
                            $delivery_date_timestamp = $data[ '_orddd_lite_timestamp' ][ 0 ];
                        } 
                        if ( $delivery_date_timestamp == '' ) {
                            $delivery_date_timestamp_1 = strtotime( $data[ 'Delivery Date' ][ 0 ] );
                            if ( $delivery_date_timestamp_1 != '' ) {
                                // add timestamp for sorting
                                $date_format = 'MM d, yy';
                                $delivery_date = $data[ 'Delivery Date' ][ 0 ];
                                $hour = 0;
                                $min = 1;
                                switch ( $date_format ) {
                                    case 'MM d, yy':
                                        $date_str = str_replace( ',', '', $delivery_date );
                                    break;
                                }
                                if ( isset( $date_str ) ) {
                                    $timestamp = strtotime( $date_str );
                                }   
                                add_post_meta( $order_id, '_orddd_lite_timestamp', $timestamp );
                            }
                        }
                    } 
                }
                if( count( $results ) > 0 ) {
                    update_option( 'orddd_lite_steps_for_script', $step_variable );
                    update_option( 'orddd_lite_orders_script_updated', $order_ids_updated );
                    echo '<script>
                    location.reload();
                    </script>';
                } else {
                    update_option( 'orddd_timestamp_update_script', 'yes' );
                    add_action( 'admin_notices', array( &$this, 'orddd_db_updated_notice' ) );
                    echo'<script>
                    window.location="'.get_admin_url().'edit.php?post_type=shop_order";
                    </script>';
                }
            }
        }   
            
        /**
        * Show database update notice for plugin version 1.9
        *
        */
        function orddd_db_update_notice() {
            $db_updated = get_option( 'orddd_timestamp_update_script' );
            if ( $db_updated != 'yes' ) {
                
            ?>
                <div class="error">
                   <p><?php _e( 'Order Delivery Date for WooCommerce Plugin needs to update your database. Please <a href="?page=order_delivery_date_lite&action=date&mode=update_db">click here</a> to update.', 'order-delivery-date' ); ?></p>
                </div>
            <?php 
            }
        }
            
        /**
        * Show database updated success notice for plugin version 1.9
        *
        */
        function orddd_db_updated_notice() {
        ?>
            <div class="updated">
                <p><?php _e( 'The database has been updated. You can now take advantage of all features of the Order Delivery Date plugin. Thank you.', 'order-delivery-date' ); ?></p>
            </div>
        <?php 
        }

        function orddd_lite_my_enqueue( $hook ) {
            global $orddd_lite_languages, $wpefield_version;
            if( 'toplevel_page_order_delivery_date_lite' != $hook ) {
                return;
            }
            
            wp_dequeue_script( 'themeswitcher' );
            wp_enqueue_script( 'themeswitcher-orddd', plugins_url( '/js/jquery.themeswitcher.min.js', __FILE__ ), array( 'jquery', 'jquery-ui-sortable', 'jquery-ui-datepicker' ), $wpefield_version, false );
                
            foreach ( $orddd_lite_languages as $key => $value ) {
                wp_enqueue_script( $value, plugins_url( "/js/i18n/jquery.ui.datepicker-$key.js", __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), $wpefield_version, false );
            }
            
            wp_register_style( 'woocommerce_admin_styles', plugins_url() . '/woocommerce/assets/css/admin.css', array(), WC_VERSION );
            wp_enqueue_style( 'woocommerce_admin_styles' );
            wp_enqueue_style( 'order-delivery-date', plugins_url('/css/order-delivery-date.css', __FILE__ ) , '', $wpefield_version, false);
            wp_register_style( 'jquery-ui-style', '//code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css', '', $wpefield_version, false );
            wp_enqueue_style( 'jquery-ui-style' );
            wp_enqueue_style( 'datepicker', plugins_url('/css/datepicker.css', __FILE__) , '', $wpefield_version, false);            
        }
        
        function orddd_lite_front_scripts_js() {
            global $wpefield_version;
            if ( get_option( 'orddd_lite_enable_delivery_date' ) == 'on' ) {
                $calendar_theme = get_option( 'orddd_lite_calendar_theme' );
                if ( $calendar_theme == '' ) {
                    $calendar_theme = 'base';
                }
                wp_dequeue_style( 'jquery-ui-style' );
                wp_register_style( 'jquery-ui-style-orddd-lite', "//code.jquery.com/ui/1.9.2/themes/$calendar_theme/jquery-ui.css", '', $wpefield_version, false );
                wp_enqueue_style( 'jquery-ui-style-orddd-lite' );
                wp_enqueue_style( 'datepicker', plugins_url('/css/datepicker.css', __FILE__) , '', $wpefield_version, false);
                
                wp_dequeue_script( 'initialize-datepicker' );
                wp_enqueue_script( 'initialize-datepicker-orddd', plugins_url('/js/orddd-lite-initialize-datepicker.js', __FILE__ ), '', $wpefield_version, false );
                
                $jsArgs = array(
                        'clearText'    => __( 'Clear', 'order-delivery-date' )
                    );
                wp_localize_script( 'initialize-datepicker-orddd', 'jsL10n', $jsArgs );

                if ( isset( $_GET[ 'lang' ] ) && $_GET[ 'lang' ] != '' && $_GET[ 'lang' ] != null ) {
                    $language_selected = $_GET['lang'];
                } else {
                    $language_selected = get_option( 'orddd_lite_language_selected' );
                    if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
                        if( constant( 'ICL_LANGUAGE_CODE' ) != '' ) {
                            $wpml_current_language = constant( 'ICL_LANGUAGE_CODE' );
                            if ( !empty( $wpml_current_language ) ) {
                                $language_selected = $wpml_current_language;
                            } else {
                                $language_selected = get_option( 'orddd_lite_language_selected' );
                            }
                        }
                    }
                    if ( $language_selected == "" ) {
                        $language_selected = "en-GB";
                    }
                }
                 
                wp_enqueue_script( $language_selected, plugins_url( "/js/i18n/jquery.ui.datepicker-$language_selected.js", __FILE__ ), array( 'jquery', 'jquery-ui-datepicker' ), $wpefield_version, false );
            }
        }               
    }
} 
$order_delivery_date_lite = new order_delivery_date_lite();
?>

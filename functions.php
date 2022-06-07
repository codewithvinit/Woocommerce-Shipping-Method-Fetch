function my_hide_shipping_when_free_is_available( ) {

    $shipping_methods = WC()->shipping->get_shipping_methods();
    foreach($shipping_methods as $shipping_method) {
        if(!empty($shipping_method->rates)) {
            $rates[] = $shipping_method->rates;
        }
    
    }
    global $woocommerce;
    $total = WC()->cart->cart_contents_total;
                    

    $free = $std = array();
	foreach ( $rates as $rate) {

        foreach ( $rate as $rate_id => $_rate ) {
            if( 200 >= $total ) {
                if ( 'flat_rate:8' === $_rate->id ) {
                    $std[ $rate_id ] = $_rate;
                }
            }

            if( 200 <= $total ) {
                
                if ( 'free_shipping:7' === $_rate->id ) {
                    $free[ $rate_id ] = $_rate;
                }
            }
            
            
            if ( 'flat_rate:9' === $_rate->id ) {
                $exp[ $rate_id ] = $_rate;
            }
            if ( 'local_pickup:10' === $_rate->id ) {
                $local[ $rate_id ] = $_rate;
            }
        }

    }
    if( 200 >= $total ) {
        return ! empty( $std ) ? array_merge( $std, $exp, $local ) : $rates;
        
    } else {
        return ! empty( $free ) ? array_merge( $free, $exp, $local ) : $rates;  
    }
	
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

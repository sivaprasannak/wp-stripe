<?php

// Custom Post Type - Transactions
// Custom Post Type - Campaigns

function create_wp_stripe_cpt_trx() {
    
    $labels = array(
        'name'                  => _x('Stripe Payments', ''),
        'singular_name'         => _x('Payment', 'post type singular name'),
        'add_new'               => _x('Add New', 'Payments'),
        'add_new_item'          => __('Add New Payment'),
        'edit_item'             => __('Edit Payment'),
        'new_item'              => __('New Payment'),
        'view_item'             => __('View Payment'),
        'search_items'          => __('Search Payments'),
        'not_found'             => __('No Payments found'),
        'not_found_in_trash'    => __('No Payments found in Trash'),
        'parent_item_colon'     => '',
    );

    $args = array(
        'labels' 		    => $labels,
        'public' 		    => false,
        'can_export' 	    => true,
        'capability_type'   => 'post',
        'hierarchical' 	    => false,
        'supports'		    => array( 'title', 'editor' )
    );

    register_post_type( 'wp-stripe-trx', $args);
    
}

// Custom Post Type - Campaigns

function create_wp_stripe_cpt_campaigns() {

    $labels = array(
        'name'                  => _x('Stripe Campaigns', ''),
        'singular_name'         => _x('Campaign', 'post type singular name'),
        'add_new'               => _x('Add New', 'Campaigns'),
        'add_new_item'          => __('Add New Campaign'),
        'edit_item'             => __('Edit Campaign'),
        'new_item'              => __('New Campaign'),
        'view_item'             => __('View Campaign'),
        'search_items'          => __('Search Campaigns'),
        'not_found'             => __('No Campaigns found'),
        'not_found_in_trash'    => __('No Campaigns found in Trash'),
        'parent_item_colon'     => '',
    );

    $args = array(
        'labels' 		    => $labels,
        'public' 		    => false,
        'can_export' 	    => true,
        'capability_type'   => 'post',
        'hierarchical' 	    => false,
        'supports'		    => array( 'title', 'editor', 'thumbnail' )
    );

    register_post_type( 'wp-stripe-campaigns', $args);

}

add_action( 'init', 'create_wp_stripe_cpt_trx' );
add_action( 'init', 'create_wp_stripe_cpt_campaigns' );

?>

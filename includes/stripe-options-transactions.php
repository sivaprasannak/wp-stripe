<?php

/**
 * Display Transctions on Options Page
 *
 * @since 1.0
 *
 */

function wp_stripe_options_display_trx() {

        // Paging

        function retrievePage() {

            if ((!isset($_POST['pagination'])) || ($_POST['pagination'] == "1")) {
                $paged = 1;
            } else {
                $paged = $_POST['pagination'];
            }
            return intval($paged);

        }

        // Query Custom Post Types

        $args = array(
            'post_type' => 'wp-stripe-trx',
            'post_status' => 'publish',
            'orderby' => 'meta_value_num',
            'meta_key' => 'wp-stripe-date',
            'order' => 'DESC',
            'posts_per_page' => 10,
            'paged' => retrievePage()
        );

		$campaignsFilterCurrent = isset($_POST['wp_stripe_campaigns_filter']) ? $_POST['wp_stripe_campaigns_filter'] : '';
		//show only those which don't have the meta key value (unassigned to a campaign)
		if ($campaignsFilterCurrent == 'unassigned') {
			//if it's not in a campaign, the key won't exist.
			$args['meta_query'] = array(
				array(
					'key' => 'wp-stripe-campaign',
					'value'   => '',
					'compare' => 'NOT EXISTS'
				)
			);
		}else if (is_numeric($campaignsFilterCurrent)) {
			$args['meta_query'] = array(
				array(
					'key' => 'wp-stripe-campaign',
					'value'   => $campaignsFilterCurrent,
					'compare' => 'IN'
				)
			);
		}
		
        // - query -
        $my_query = null;
        $my_query = new WP_query( $args );
		
		//On refund button click
        if(isset($_POST['wp_stripe_refund_id']))
            {
          
                $id = $_POST['wp_stripe_refund_id'];
                $ch = Stripe_Charge::retrieve($id);
                $response = $ch->refund();
                
            
                update_post_meta( $_POST['wp_stripe_refund_post_id'], 'wp-stripe-refund', 'true');
                
                if($_POST['wp_stripe_refund_campaign_id'] != '')
                {
                    $refund_campaign=get_post_custom($_POST['wp_stripe_refund_campaign_id']);
                    update_post_meta( $_POST['wp_stripe_refund_campaign_id'], 'wp-stripe-campaign-raised', ($refund_campaign["wp-stripe-campaign-raised"][0]- $_POST['wp_stripe_refund_amount']) , $refund_campaign["wp-stripe-campaign-raised"][0] );
                }   
            }

        while ( $my_query->have_posts() ) : $my_query->the_post();

            $time_format = get_option( 'time_format' );

            // - variables -

            $custom = get_post_custom( get_the_ID() );
            $id = ( $my_query->post->ID );
            $public = $custom["wp-stripe-public"][0];
            $live = $custom["wp-stripe-live"][0];
            $name = $custom["wp-stripe-name"][0];
            $email = $custom["wp-stripe-email"][0];
            $content = get_the_content();
            $date = $custom["wp-stripe-date"][0];
            $cleandate = date('d M', $date);
            $cleantime = date('H:i', $date);
            $amount = $custom["wp-stripe-amount"][0];
            $fee = ($custom["wp-stripe-fee"][0])/100;
            $net = round($amount - $fee,2);

			$campaignId = $custom["wp-stripe-campaign"][0];

			//lookup the campaign name if it's a donation for a campaign
			if (is_numeric($campaignId)) {
				$campaignName = get_the_title($campaignId);
				$campaignNameMaxLength = 18;
				if (strlen($campaignName) > $campaignNameMaxLength) {
					$campaignName = substr($campaignName,0, $campaignNameMaxLength - 3) . '...';
				}
			}else{
				$campaignName = '';
			}
			
			echo '<tr>';

            // Dot

            if ( $live == 'LIVE' ) {
                $dotlive = '<div class="dot-stripe-live"></div>';
            } else {
                $dotlive = '<div class="dot-stripe-test"></div>';
            }

            if ( $public == 'YES' ) {
                $dotpublic = '<div class="dot-stripe-public"></div>';
            } else {
                $dotpublic = '<div class="dot-stripe-test"></div>';
            }

            // Person

            $img = get_avatar( $email, 32 );
            $person = $img . ' <span class="stripe-name">' . $name . ' <a href="mailto:' . $email . '">'.$email.'</a></span>';
			if ($public == "YES") {
				$person .= '<form method="POST">
					<input type="hidden" value="' . $id . '" name="wp_stripe_postid">
					<input type="submit" value="Hide from public view" name="wp_stripe_hide" id="wp_stripe_hide">
				</form>';
			}

            // Received
            //Checks the transaction have been refunded or not by the meta added to the post
            //Inserts the refund button or Refunded text
            
            if(get_post_meta($id,'wp-stripe-refund',true)=='')
            {
                $received = '<span class="stripe-netamount"> + ' . $net . '</span> (-' . $fee . ')
                                <form method="post">
                                <input type="hidden" name="wp_stripe_refund_id" value='. $my_query->post->post_title .'>
                                <input type="hidden" name="wp_stripe_refund_post_id" value='. $id .'>
                                <input type="hidden" name="wp_stripe_refund_campaign_id" value='. $campaignId .'>
                                <input type="hidden" name="wp_stripe_refund_amount" value='. $amount .'>
                                <input type="submit" value="Refund">
                                </form> ';
            }
            else
            {
                $received = '<span class="stripe-refundamount">  ' . $net . '</span> (-' . $fee . ')<p>Refunded</p>';   
            }

            // Content

            echo '<td>' . $dotlive . $dotpublic . '</td>';
            echo '<td>' . $person . '</td>';
            echo '<td>' . $received . '</td>';
            echo '<td>' . $cleandate . ' - ' . $cleantime . '</td>';
            echo '<td>' . $campaignName . '</td>';
            echo '<td class="stripe-comment">"' . $content . '"</td>';

            echo '</tr>';

        endwhile;
?>

</table>

<div style="clear:both"></div>

<?php

    function totalPages($transactions) {
	
        // get total pages

        if ( $transactions > 0 ) {
            $totalpages = floor( $transactions / 10) + 1 ;
        } else {
            return;
        }

        return $totalpages;

    }

    $currentpage = retrievePage();
    $totalpages = totalPages($my_query->found_posts);

    if ( $currentpage > 1 ) {
		$campaignsFilterCurrent = isset($_POST['wp_stripe_campaigns_filter']) ? $_POST['wp_stripe_campaigns_filter'] : '';

        echo '<form method="POST" class="pagination">';
		echo '<input type="hidden" name="wp_stripe_campaigns_filter" value="' . $campaignsFilterCurrent . '" />';
        echo '<input type="hidden" name="pagination" value="' . ( retrievePage() - 1 ) . '" />';
        echo '<input type="submit" value="Previous 10" />';
        echo '</form>';

    }

    if ( $currentpage < $totalpages ) {
		$campaignsFilterCurrent = isset($_POST['wp_stripe_campaigns_filter']) ? $_POST['wp_stripe_campaigns_filter'] : '';

        echo '<form method="POST" class="pagination">';
		echo '<input type="hidden" name="wp_stripe_campaigns_filter" value="' . $campaignsFilterCurrent . '" />';
        echo '<input type="hidden" name="pagination" value="' . ( retrievePage() + 1 ) . '" />';
        echo '<input type="submit" value="Next 10" />';
        echo '</form>';

    }

    echo ' <div style="clear:both"></div>';

}

?>
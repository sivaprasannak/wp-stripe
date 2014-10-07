<?php


/**
 * Campaigns - Display campaigns within options page
 */
function wp_stripe_options_display_campaigns() {

        // Query Custom Post Types
        $args = array(
            'post_type' => 'wp-stripe-campaigns',
            'posts_per_page' => 1000
        );

        // - query -
        $my_query = null;
        $my_query = new WP_query( $args );

        while ( $my_query->have_posts() ) : $my_query->the_post();

            $time_format = get_option( 'time_format' );

            // - variables -

            $custom = get_post_custom( get_the_ID() );
            $id = ( $my_query->post->ID );
            $name = get_the_title();
            $date = get_the_date() . " " . get_the_time();
			$date = strtotime($date);
			$date = date('M dS Y - g:i a', $date);
            //$cleantime = date('H:i', $date);

            $raised = $custom["wp-stripe-campaign-raised"][0];
            $offlineAmount = $custom["wp-stripe-campaign-offlineamount"][0];
            $goal = $custom["wp-stripe-campaign-goal"][0];
            $description = get_the_content();

            echo '<tr>';

            // Content
			setlocale(LC_MONETARY, 'en_US');

            echo '<td><a href="' . admin_url( 'options-general.php?page=wp_stripe&editcampaignid=') . $id .'">edit</a>' . '</td>';
            echo '<td>' . $id . '</td>';
            echo '<td>' . $name . '</td>';
            echo '<td>' . $date . '</td>';
            echo '<td>' . money_format("%2n", $raised + $offlineAmount) . '<br />(' . money_format("%2n", $raised) . ' / ' . money_format("%2n", $offlineAmount) . ')</td>';
            echo '<td>' . money_format("%1n", $goal) . '</td>';
            echo '<td class="stripe-comment">"' . $description . '"</td>';

            echo '</tr>';

        endwhile;

    }

	
	
/**
 * Campaigns - Display a dropdown list with campaigns to select
 */
function wp_stripe_options_display_campaigns_dropdown() {

		$campaignsFilterCurrent = isset($_POST['wp_stripe_campaigns_filter']) ? $_POST['wp_stripe_campaigns_filter'] : '';
	
        // Query Custom Post Types
        $args = array(
            'post_type' => 'wp-stripe-campaigns',
            'posts_per_page' => 1000
        );

        // - query -
        $my_query = null;
        $my_query = new WP_query( $args );


		echo "<select id='wp_stripe_campaigns_filter' name='wp_stripe_campaigns_filter' >";
		$selectedValue = $campaignsFilterCurrent == '' ? ' selected ' : ' ';
		echo "<option value='' {$selectedValue} >All</option>";

		$selectedValue = $campaignsFilterCurrent == 'unassigned' ? ' selected ' : ' ';
		echo "<option value='unassigned' {$selectedValue} >Unassigned</option>";

		while ( $my_query->have_posts() ) : $my_query->the_post();

            // - variables -
            $custom = get_post_custom( get_the_ID() );
            
			$campaignId = ( $my_query->post->ID );
            
			$campaignName = get_the_title();
			$campaignNameMaxLength = 30;
			if (strlen($campaignName) > $campaignNameMaxLength) {
				$campaignName = substr($campaignName,0, $campaignNameMaxLength - 3) . '...';
			}

			$selectedValue = $campaignsFilterCurrent == $campaignId ? ' selected ' : ' ';
			echo "<option value='{$campaignId}' {$selectedValue} >{$campaignName}</option>";
			

        endwhile;

		echo "</select>";
    }
	
?>

<?php

/**
 * Create Options Fields
 *
 * @since 1.0
 *
 */

function wp_stripe_options_init() {

		register_setting( 'wp_stripe_options', 'wp_stripe_options' );
        add_settings_section( 'wp_stripe_section_main', '', 'wp_stripe_options_header', 'wp_stripe_section' );
        add_settings_field( 'stripe_header', 'Payment Form Header', 'wp_stripe_field_header', 'wp_stripe_section', 'wp_stripe_section_main' );
        add_settings_field( 'stripe_recent_switch', 'Enable Recent Widget?', 'wp_stripe_field_recent', 'wp_stripe_section', 'wp_stripe_section_main' );
        add_settings_field( 'stripe_css_switch', 'Enable Payment Form CSS?', 'wp_stripe_field_css', 'wp_stripe_section', 'wp_stripe_section_main' );
        add_settings_field( 'stripe_payment_minimum', 'Minimum Payment Amount?', 'wp_stripe_payment_minimum', 'wp_stripe_section', 'wp_stripe_section_main' );
        add_settings_section( 'wp_stripe_section_api', '', 'wp_stripe_options_header_api', 'wp_stripe_section' );
        add_settings_field( 'stripe_api_switch', 'Enable Test API Environment?', 'wp_stripe_field_switch', 'wp_stripe_section', 'wp_stripe_section_api' );
        add_settings_field( 'stripe_test_api', 'API Secret Key (Test Environment)', 'wp_stripe_field_test', 'wp_stripe_section', 'wp_stripe_section_api' );
        add_settings_field( 'stripe_test_api_publish', 'API Publishable Key (Test Environment)', 'wp_stripe_field_test_publish', 'wp_stripe_section', 'wp_stripe_section_api' );
        add_settings_field( 'stripe_prod_api', 'API Secret Key (Production Environment)', 'wp_stripe_field_prod','wp_stripe_section', 'wp_stripe_section_api' );
        add_settings_field( 'stripe_prod_api_publish', 'API Publishable Key (Production Environment)', 'wp_stripe_field_prod_publish', 'wp_stripe_section', 'wp_stripe_section_api' );
        add_settings_section( 'wp_stripe_section_ssl', '', 'wp_stripe_options_header_ssl', 'wp_stripe_section' );
        add_settings_field( 'stripe_modal_ssl', 'Enable SSL for modal pop-up?', 'wp_stripe_field_ssl', 'wp_stripe_section', 'wp_stripe_section_ssl' );
        add_settings_section( 'wp_stripe_section_email_confirmation', '', 'wp_stripe_options_header_email_confirmation', 'wp_stripe_section' );
        add_settings_field( 'email_confirmation_send', 'Send an email confirmation?', 'wp_stripe_field_email_confirmation_send', 'wp_stripe_section', 'wp_stripe_section_email_confirmation' );
        add_settings_field( 'email_confirmation_from_name', 'From name', 'wp_stripe_field_email_confirmation_from_name', 'wp_stripe_section', 'wp_stripe_section_email_confirmation' );
        add_settings_field( 'email_confirmation_from_email', 'From email', 'wp_stripe_field_email_confirmation_from_email', 'wp_stripe_section', 'wp_stripe_section_email_confirmation' );
        add_settings_field( 'email_confirmation_subject', 'Subject', 'wp_stripe_field_email_confirmation_subject', 'wp_stripe_section', 'wp_stripe_section_email_confirmation' );
        add_settings_field( 'email_confirmation_message', 'Message', 'wp_stripe_field_email_confirmation_message', 'wp_stripe_section', 'wp_stripe_section_email_confirmation' );
        add_settings_section( 'wp_stripe_section_action', '', 'wp_stripe_options_header_action', 'wp_stripe_section' );
        add_settings_field( 'action_success_redirect', 'Optional URL to redirect on successful transaction', 'wp_stripe_field_action_success_redirect', 'wp_stripe_section', 'wp_stripe_section_action' );
	
}

/**
 * Options Page Headers (blank)
 *
 * @since 1.0
 *
 */

function wp_stripe_options_header () {

    ?>

    <h2>General</h2>

    <?php

}

function wp_stripe_options_header_api () {

    ?>

    <h2>API</h2>

    <?php

}

function wp_stripe_options_header_ssl () {

    ?>

    <h2>SSL</h2>

    <?php

}

function wp_stripe_options_header_email_confirmation () {

    ?>

    <h2>Email Confirmation</h2>

    <?php

}

function wp_stripe_options_header_action () {

    ?>

    <h2>Actions</h2>

    <?php

}


function wp_stripe_campaigns_header_new() {

    ?>

    <h2>Create a new campaign</h2>

    <?php

}

/**
 * Individual Fields
 *
 * @since 1.0
 *
 */

function wp_stripe_field_header () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['stripe_header'];
        echo "<input id='setting_api' name='wp_stripe_options[stripe_header]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_recent () {

        $options = get_option( 'wp_stripe_options' );
        $items = array( 'Yes', 'No' );
        echo "<select id='stripe_api_switch' name='wp_stripe_options[stripe_recent_switch]'>";

        foreach( $items as $item ) {
            $selected = ($options['stripe_recent_switch']==$item) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }

        echo "</select>";
}

function wp_stripe_field_css () {

        $options = get_option( 'wp_stripe_options' );
        $items = array( 'Yes', 'No' );
        echo "<select id='stripe_api_switch' name='wp_stripe_options[stripe_css_switch]'>";

        foreach( $items as $item ) {
            $selected = ($options['stripe_css_switch']==$item) ? 'selected="selected"' : '';
            echo "<option value='$item' $selected>$item</option>";
        }

        echo "</select>";

}

function wp_stripe_payment_minimum () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['stripe_payment_minimum'];
        echo "<input id='setting_api' name='wp_stripe_options[stripe_payment_minimum]' type='text' size='40' value='$value' />";

}


function wp_stripe_field_switch () {

        $options = get_option( 'wp_stripe_options' );
        $items = array( 'Yes', 'No' );
        echo "<select id='stripe_api_switch' name='wp_stripe_options[stripe_api_switch]'>";

            foreach( $items as $item ) {
                    $selected = ($options['stripe_api_switch']==$item) ? 'selected="selected"' : '';
                    echo "<option value='$item' $selected>$item</option>";
            }

        echo "</select>";

}

function wp_stripe_field_test () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['stripe_test_api'];
        echo "<input id='setting_api' name='wp_stripe_options[stripe_test_api]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_test_publish () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['stripe_test_api_publish'];
        echo "<input id='setting_api' name='wp_stripe_options[stripe_test_api_publish]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_prod () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['stripe_prod_api'];
        echo "<input id='setting_api' name='wp_stripe_options[stripe_prod_api]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_prod_publish () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['stripe_prod_api_publish'];
        echo "<input id='setting_api' name='wp_stripe_options[stripe_prod_api_publish]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_ssl () {

    $options = get_option( 'wp_stripe_options' );
    $items = array( 'Yes', 'No' );
    echo "<select id='stripe_modal_ssl' name='wp_stripe_options[stripe_modal_ssl]'>";

    foreach( $items as $item ) {
        $selected = ($options['stripe_modal_ssl']==$item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }

    echo "</select>";

}

function wp_stripe_field_email_confirmation_send () {

    $options = get_option( 'wp_stripe_options' );
    $items = array( 'Yes', 'No' );
    echo "<select id='email_confirmation_send' name='wp_stripe_options[email_confirmation_send]'>";

    foreach( $items as $item ) {
        $selected = ($options['email_confirmation_send']==$item) ? 'selected="selected"' : '';
        echo "<option value='$item' $selected>$item</option>";
    }

    echo "</select>";

}

function wp_stripe_field_email_confirmation_from_name () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['email_confirmation_from_name'];
        echo "<input id='setting_api' name='wp_stripe_options[email_confirmation_from_name]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_email_confirmation_from_email () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['email_confirmation_from_email'];
        echo "<input id='setting_api' name='wp_stripe_options[email_confirmation_from_email]' type='email' size='40' value='$value' />";

}

function wp_stripe_field_email_confirmation_subject () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['email_confirmation_subject'];
        echo "<input id='setting_api' name='wp_stripe_options[email_confirmation_subject]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_email_confirmation_message () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['email_confirmation_message'];
        echo "<textarea id='setting_api' name='wp_stripe_options[email_confirmation_message]' style='width:500px; height:200px;'>$value</textarea><br /><strong>Note:</strong> %Name% and %Amount% will be replaced with their actual values.";
}

//If filled in, the page will redirect after a successful transaction.
//If left blank, the normal success message will be displayed.
function wp_stripe_field_action_success_redirect () {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['action_success_redirect'];
        echo "<input id='setting_api' name='wp_stripe_options[action_success_redirect]' type='text' size='40' value='$value' />";

}


//Create a new campaign
function wp_stripe_field_campaigns_new_name() {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['campaigns_new_name'];
        echo "<input id='setting_api' name='wp_stripe_options[campaigns_new_name]' type='text' size='40' value='$value' />";

}

function wp_stripe_field_campaigns_new_goal() {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['campaigns_new_goal'];
        echo "<input id='setting_api' name='wp_stripe_options[campaigns_new_goal]' type='text' size='40' value='$value' />";

}


function wp_stripe_field_campaigns_new_offlineamount() {

        $options = get_option( 'wp_stripe_options' );
        $value = $options['campaigns_new_offlineamount'];
        echo "<input id='setting_api' name='wp_stripe_options[campaigns_new_offlineamount]' type='text' size='40' value='$value' />";
}

function wp_stripe_field_campaigns_new_description() {
        $options = get_option( 'wp_stripe_options_' );
        $value = $options['campaigns_new_description'];
        echo "<textarea id='setting_api' name='wp_stripe_options[email_confirmation_description]' style='width:500px; height:200px;'>$value</textarea>";

}
/**
 * Register Options Page
 *
 * @since 1.0
 *
 */

function wp_stripe_add_page() {

        add_options_page( 'WP Stripe', 'WP Stripe', 'manage_options', 'wp_stripe', 'wp_stripe_options_page' );

    }

/**
 * Create Options Page Content
 *
 * @since 1.0
 *
 */

function wp_stripe_options_page() {
    ?>

    <script type="text/javascript">
        jQuery(function() {
            jQuery("#wp-stripe-tabs").tabs();
			
			window.location.hash = "#";
        });
    </script>

    <div id="wp-stripe-tabs">

        <h1 class="stripe-title">WP Stripe</h1>

        <ul id="wp-stripe-tabs-nav">
            <li><a href="#wp-stripe-tab-transactions">Transactions</a></li>
            <li><a href="#wp-stripe-tab-settings">Settings</a></li>
			<li><a href="#wp-stripe-tab-campaigns">Campaigns</a></li>
            <li><a href="#wp-stripe-tab-about">About</a></li>
        </ul>

        <div style="clear:both"></div>

        <div id="wp-stripe-tab-transactions">
			<form method="POST" id="wp-stripe-tab-transactions-campaigns-filter-form">
			Filter transactions to the following campaigns: <?php wp_stripe_options_display_campaigns_dropdown(); ?>
			<input type="submit" name="submit" id="submit" value="Go" />
            </form>
			<table class="wp-stripe-transactions">
              <thead><tr class="wp-stripe-absolute"></tr><tr>

                  <th style="width:44px;"><div class="dot-stripe-live"></div><div class="dot-stripe-public"></div></th>
                  <th style="width:200px;">Person</th>
                  <th style="width:100px;">Net Amount (Fee)</th>
                  <th style="width:80px;">Date</th>
                  <th style="width:100px;">Campaign</th>
                  <th>Comment</th>

              </tr></thead>

            <?php

                wp_stripe_options_display_trx();

            ?>

            <p style="color:#777">The amount of payments display is limited to 500. Log in to your Stripe account to see more.</p>
            <div style="color:#777"><div class="dot-stripe-live"></div>Live Environment (as opposed to Test API)</div>
            <div style="color:#777"><div class="dot-stripe-public"></div>Will show in Widget (as opposed to only being visible to you)</div>

            <br />

            <form method="POST">
                <input type="hidden" name="wp_stripe_delete_tests" value="1">
                <input type="submit" value="Delete all test transactions">
            </form>

        </div>

        <div id="wp-stripe-tab-settings">

            <form action="options.php" method="post">
                <?php settings_fields( 'wp_stripe_options' ); ?>
                <?php do_settings_sections( 'wp_stripe_section' ); ?>
                <br />
                <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
            </form>

            <p style="margin-top:20px;color:#777">I highly suggest you test payments using the <strong>Test Environment</strong> first. You can use the following details:</p>
            <ul style="color:#777">
                <li><strong>Card Number</strong> 4242424242424242</li>
                <li><strong>Card Month</strong> 05</li>
                <li><strong>Card Year</strong> 2015</li>
            </ul>
            <p style="color:#777"><strong>Note:</strong> CVC is optional when payments are made.</p>
            
        </div>
        <div id="wp-stripe-tab-campaigns">

			<?php
			//Are we trying to edit an existing campaign?
			if (is_numeric($_GET['editcampaignid'])) {
				$campaign_id = $_GET['editcampaignid'];
				
				//set the tab to the campaigns
				$GLOBALS['wp_stripe_tab_select_arg_tab'] = 'campaigns';
				wp_stripe_tab_select();
				
				//look up the campaign, display the edit form and prepopulate it with the fields.
				
				//Query Custom Post Types
				$args = array(
					'post_type' => 'wp-stripe-campaigns',
					'id' => $campaign_id
				);

				// - query -
				$my_query = null;
				$my_query = new WP_query( $args );

				if ( $my_query->have_posts() )  {
					$my_query->the_post();

					$id = ( $my_query->post->ID );
					$custom = get_post_custom($id);
				
					// Content
					setlocale(LC_MONETARY, 'en_US');

					echo '<h2>Edit a campaign</h2>';
					
					global $wp_stripe_vars;
					if (isset($wp_stripe_vars['wp_stripe_campaigns_edit']['error'])) {
						echo "<div class='error'><ul>";
						foreach ($wp_stripe_vars['wp_stripe_campaigns_edit']['error'] as $errorMessage) {
							echo "<li>{$errorMessage}</li>";
						}
						echo "</ul></div>";

						//use the submitted information instead of resetting the form with the original data.
						$name = $_POST['wp_stripe_campaigns_edit']['name'];
						$description = $_POST['wp_stripe_campaigns_edit']['description'];
						$goal = $_POST['wp_stripe_campaigns_edit']['goal'];
						$raised = $_POST['wp_stripe_campaigns_edit']['raised'];
						$offlineAmount = $_POST['wp_stripe_campaigns_edit']['offlineamount'];
					}else{
						$name = get_the_title();
						$description = get_the_content();

						$goal = $custom["wp-stripe-campaign-goal"][0];
						$raised = $custom["wp-stripe-campaign-raised"][0];
						$offlineAmount = $custom["wp-stripe-campaign-offlineamount"][0];
						
						$goal = money_format("%1n", $goal);
						$offlineAmount = money_format("%1n", $offlineAmount);
					}
					
					
					
					?>
					<form method="post">
						 <?php wp_nonce_field('wp_stripe_campaigns_edit','wp_stripe_campaigns_edit_nonce'); ?>
						<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">Campaign name</th>
									<td><input type="text" value="<?php echo htmlspecialchars($name, ENT_QUOTES | ENT_IGNORE, 'UTF-8') ?>" size="40" name="wp_stripe_campaigns_edit[name]" id="campaigns_edit_name"></td>
								</tr><tr valign="top">
									<th scope="row">Fundraising goal</th>
									<td><input type="text" value="<?php echo htmlspecialchars($goal, ENT_QUOTES | ENT_IGNORE, 'UTF-8') ?>" size="40" name="wp_stripe_campaigns_edit[goal]" id="campaigns_edit_goal"></td>
								</tr><tr valign="top">
									<th scope="row">How much was raised offline?</th>
									<td><input type="text" value="<?php echo htmlspecialchars($offlineAmount, ENT_QUOTES | ENT_IGNORE, 'UTF-8') ?>" size="40" name="wp_stripe_campaigns_edit[offlineamount]" id="campaigns_edit_offlineamount"></td>
								</tr></tr><tr valign="top">
									<th scope="row">How much was raised with the Stripe form?</th>
									<td><input type="text" value="<?php echo htmlspecialchars($raised, ENT_QUOTES | ENT_IGNORE, 'UTF-8') ?>" size="40" name="wp_stripe_campaigns_edit[raised]" id="campaigns_edit_offlineamount">
									<br />Note: this is automatically adjusted as people donate through the Stripe form. This should only be changed in cases of a refund or similar situation.</td>
								</tr>
								<tr valign="top">
									<th scope="row">Description</th>
									<td><textarea style="width:500px; height:200px;" name="wp_stripe_campaigns_edit[description]" id="campaigns_edit_description"><?php echo htmlspecialchars($description, ENT_QUOTES | ENT_IGNORE, 'UTF-8') ?></textarea></td>
								</tr>
							</tbody>
						</table>
						<br />
						<input type="hidden" value="<?php echo htmlspecialchars($id, ENT_QUOTES | ENT_IGNORE, 'UTF-8') ?>" name="wp_stripe_campaigns_edit[id]">
						<input type="submit" value="Save Changes" name="wp_stripe_campaigns_edit[submit]">
						<input type="submit" value="Cancel" name="wp_stripe_campaigns_edit[cancel]">
				</form>
				<?php
					
				}else{
					echo "<div class='error'><ul>";
					foreach ($wp_stripe_vars['wp_stripe_campaigns_edit']['error'] as $errorMessage) {
						echo "<li>That campaign was not found. (error: editcamp-{$campaign_id})</li>";
						echo "<li><a href='" . admin_url( 'options-general.php?page=wp_stripe') . "'>Click here</a> to return to get the list of campaigns.</li>";
					}
					echo "</ul></div>";
				}
			}else{
				//not trying to edit a campaign so show the regular screen
			?>
                 <table class="wp-stripe-campaigns">
                    <thead><tr class="wp-stripe-absolute"></tr><tr>

                        <th style="width:50px;">Options</th>
                        <th style="width:10px;">ID</th>
                        <th style="width:150px;">Name</th>
                        <th style="width:150px;">Created</th>
                        <th style="width:100px;">Raised<br />(online/offline)</th>
                        <th style="width:100px;">Goal</th>
                        <th>Description</th>

                    </tr></thead>
					<?php
			wp_stripe_options_display_campaigns();
		            ?>

				 </table>
					<h2>Create a new campaign</h2>
					<?php 
					global $wp_stripe_vars;
					if (isset($wp_stripe_vars['wp_stripe_campaigns_new']['error'])) {
						echo "<div class='error'><ul>";
						foreach ($wp_stripe_vars['wp_stripe_campaigns_new']['error'] as $errorMessage) {
							echo "<li>{$errorMessage}</li>";
						}
						echo "</ul></div>";
					}
					?>
				<form method="post">
					 <?php wp_nonce_field('wp_stripe_campaigns_new','wp_stripe_campaigns_new_nonce'); ?>
				    <table class="form-table">
						<tbody>
							<tr valign="top">
								<th scope="row">Name your campaign</th>
								<td><input type="text" value="" size="40" name="wp_stripe_campaigns_new[name]" id="campaigns_new_name"></td>
							</tr><tr valign="top">
								<th scope="row">Fundraising goal</th>
								<td><input type="text" value="" size="40" name="wp_stripe_campaigns_new[goal]" id="campaigns_new_goal"></td>
							</tr><tr valign="top">
								<th scope="row">How much was raised offline?</th>
								<td><input type="text" value="" size="40" name="wp_stripe_campaigns_new[offlineamount]" id="campaigns_new_offlineamount"></td>
							</tr>
							<tr valign="top">
								<th scope="row">Description</th>
								<td><textarea style="width:500px; height:200px;" name="wp_stripe_campaigns_new[description]" id="campaigns_new_description"></textarea></td>
							</tr>
						</tbody>
					</table>
					<br />
                <input type="submit" value="Save Changes" name="wp_stripe_campaigns_new[submit]">
            </form>
			<?php } ?>			
		
		</div>

        <div id="wp-stripe-tab-about">

            <p>This plugin was created by <a href="http://www.twitter.com/noeltock" target="_blank">@noeltock</a>, follow me for updates & WordPress goodness.</p>
            <p>If you need any support, please use the <a href="http://wordpress.org/tags/wp-stripe?forum_id=10">forums</a>, this is the only location I will provide unpaid support. Thank you!</p>

		</div>

<?php
}

add_action('admin_init', 'wp_stripe_campaigns_new_create');
function wp_stripe_campaigns_new_create() {
	if ( isset($_POST['wp_stripe_campaigns_new'] ) ) {
		if (check_admin_referer('wp_stripe_campaigns_new','wp_stripe_campaigns_new_nonce') ) {
			global $wp_stripe_vars;
			
			//set the tab to the campaigns
			$GLOBALS['wp_stripe_tab_select_arg_tab'] = 'campaigns';
			add_action( 'admin_head', 'wp_stripe_tab_select');
			
			//make sure all values are correct
			if ($_POST['wp_stripe_campaigns_new']['name'] == '') {
				$wp_stripe_vars['wp_stripe_campaigns_new']['error'][] = 'You must name your campaign.';
			}
			
			$goal = str_replace('$', '', $_POST['wp_stripe_campaigns_new']['goal']);
			if (is_numeric($goal) == false) {
				$wp_stripe_vars['wp_stripe_campaigns_new']['error'][] = 'You must set your campaign goal. How much money are you trying to raise?';
			}
			
			$offlineAmount = str_replace('$', '', $_POST['wp_stripe_campaigns_new']['offlineamount']);
			if (is_numeric($offlineAmount) == false) {
				$wp_stripe_vars['wp_stripe_campaigns_new']['error'][] = 'You must set the amount of money you raised offline, even if it\'s $0.';
			}

			//create the campaign if everything is good.
			if (isset($wp_stripe_vars['wp_stripe_campaigns_new']['error']) == false) {
                $new_post = array(
                    'ID' => '',
                    'post_type' => 'wp-stripe-campaigns',
                    'post_author' => 1,
                    'post_content' => $_POST['wp_stripe_campaigns_new']['description'],
                    'post_title' => $_POST['wp_stripe_campaigns_new']['name'],
                    'post_status' => 'publish',
                );

                $post_id = wp_insert_post( $new_post );

                //Update Meta values. Set the raised value to 0 since nothing has been raised yet.
                update_post_meta( $post_id, 'wp-stripe-campaign-goal', $goal);
                update_post_meta( $post_id, 'wp-stripe-campaign-offlineamount', $offlineAmount);
                update_post_meta( $post_id, 'wp-stripe-campaign-raised', 0);
				
			}
			
		}
	}
}

add_action('admin_init', 'wp_stripe_campaigns_edit_submit');
function wp_stripe_campaigns_edit_submit() {
	if ( isset($_POST['wp_stripe_campaigns_edit'] ) ) {
		if (check_admin_referer('wp_stripe_campaigns_edit','wp_stripe_campaigns_edit_nonce') ) {
			if ($_POST['wp_stripe_campaigns_edit']['cancel'] != '') {
				//redirect to the admin page
				wp_redirect(admin_url( 'options-general.php?page=wp_stripe#wp-stripe-tab-campaigns'));
				exit();
			}
		
			if ($_POST['wp_stripe_campaigns_edit']['submit'] != '') {
				//get the vars
				$id = $_POST['wp_stripe_campaigns_edit']['id'];
				$name = $_POST['wp_stripe_campaigns_edit']['name'];
				$description = $_POST['wp_stripe_campaigns_edit']['description'];
				$goal = $_POST['wp_stripe_campaigns_edit']['goal'];
				$raised = $_POST['wp_stripe_campaigns_edit']['raised'];
				$offlineAmount = $_POST['wp_stripe_campaigns_edit']['offlineamount'];
				
				//clean the data
				$goal = floatval(preg_replace('/[^\d.]/', '', $goal));
				$offlineAmount = floatval(preg_replace('/[^\d.]/', '', $offlineAmount));
				
				//make sure all values are correct
				global $wp_stripe_vars;
				
				if ($_POST['wp_stripe_campaigns_edit']['name'] == '') {
					$wp_stripe_vars['wp_stripe_campaigns_edit']['error'][] = 'You must name your campaign.';
				}

				if (is_numeric($goal) == false) {
					$wp_stripe_vars['wp_stripe_campaigns_edit']['error'][] = 'You must set your campaign goal. How much money are you trying to raise?';
				}

				if (is_numeric($raised) == false) {
					$raised = '';
				}
				
				if (is_numeric($offlineAmount) == false) {
					$wp_stripe_vars['wp_stripe_campaigns_edit']['error'][] = 'You must set the amount of money you raised offline, even if it\'s $0.';
				}

				//make sure the id exists
				if (is_numeric($id) == false) {
					$wp_stripe_vars['wp_stripe_campaigns_edit']['error'][] = 'Problem loading the campaign information. The ID was not a number.';
				}else{
					//Query Custom Post Types
					$args = array(
						'post_type' => 'wp-stripe-campaigns',
						'id' => $campaign_id
					);

					// - query -
					$my_query = null;
					$my_query = new WP_query( $args );

					if ( $my_query->have_posts() == false )  {
						$wp_stripe_vars['wp_stripe_campaigns_edit']['error'][] = "Couldn't find that campaign.";
					}					
				}

				//save the changes if everything is good.
				if (isset($wp_stripe_vars['wp_stripe_campaigns_edit']['error']) == false) {
					$edit_post = array(
						'ID' => $id,
						'post_content' => $description,
						'post_title' => $name,
					);

					wp_update_post( $edit_post );

					//Update Meta values.
					update_post_meta( $id, 'wp-stripe-campaign-goal', $goal);
					update_post_meta( $id, 'wp-stripe-campaign-offlineamount', $offlineAmount);
					
					//if the raised amount is blank because of an error, don't update it.
					if ($raised != '' && is_numeric($raised)) {
						update_post_meta( $id, 'wp-stripe-campaign-raised', $raised);
					}

					//redirect to the normal admin page with the hash to set the tab and without the option to edit as a querystring.
					wp_redirect(admin_url( 'options-general.php?page=wp_stripe#wp-stripe-tab-campaigns'));
					edit();
				}
			}
		}
	}
}



/*
 * Switch to the correct tab.
 * use the global var so that arguments can be "passed" into it when executing from add_action.
 * use window load instead of document ready because the tabs function needs to be execute before we can switch tabs
 */
function wp_stripe_tab_select() {
	echo '<script>
	jQuery(window).load(function(){
		jQuery("#wp-stripe-tabs").tabs("select", "#wp-stripe-tab-' . $GLOBALS['wp_stripe_tab_select_arg_tab'] . '");
	});
</script>';
}

function wp_stripe_delete_tests() {
	//TO-DO: Add nonce check.
	
	//hide the donation from public view
	if ( isset($_POST['wp_stripe_hide'] ) ) {
		update_post_meta( $_POST['wp_stripe_postid'], 'wp-stripe-public', "NO");
		
		//"update" the post with the same info so the cache gets cleared
		$hide_post = array();
		$hide_post['ID'] = $_POST['wp_stripe_postid'];

		// Update the post into the database
		wp_update_post( $hide_post );
	}
	
	//remove all tests
    if ( isset($_POST['wp_stripe_delete_tests'] ) == '1') {

        // Query Custom Post Types
        $args = array(
            'post_type' => 'wp-stripe-trx',
            'post_status' => 'publish',
            'posts_per_page' => 500
        );

        // Query
        $my_query = null;
        $my_query = new WP_query( $args );

        while ( $my_query->have_posts() ) : $my_query->the_post();

            // Meta
            $custom = get_post_custom( get_the_ID() );
            $id = ( $my_query->post->ID );
            $live = $custom["wp-stripe-live"][0];

            // Delete Post
            if ( $live == 'TEST' ) {
				//Look for campaign information
				if (isset($custom["wp-stripe-campaign"][0])) {
					//Looks like there's a campaign associated with this transaction. Let's look it up and adjust the amount it's raised.
					$campaign = get_post_custom($custom["wp-stripe-campaign"][0]);
					
					//is this a valid campaign?
					if (isset($campaign["wp-stripe-campaign-raised"][0])) {
						//subtract the amount of this transaction from the total amount raised and update the campaign value
						update_post_meta( $custom["wp-stripe-campaign"][0], 'wp-stripe-campaign-raised', $campaign["wp-stripe-campaign-raised"][0] - $custom["wp-stripe-amount"][0]);
					}
				}
				
				//delete the transaction post
                wp_delete_post( $id, true );
            }

        endwhile;

        wp_redirect( wp_get_referer() );
        exit;

    }

}

add_action( 'admin_init', 'wp_stripe_delete_tests');

?>
<?php

// Display Stripe iFrame Page

define('WP_USE_THEMES', false);
//getting 404 with wp-blog-header.php so switching to wp-load
//http://wordpress.org/support/topic/integrating-wp-in-external-php-pages
require('../../../../wp-load.php');

header('Content-Type: text/html; charset=' . get_bloginfo( 'charset') );

?>

<!doctype html>

<html lang="en">

    <head>

        <meta charset="utf-8">
        <title><?php _e('Stripe Payment','wp-stripe'); ?></title>
        <link rel="stylesheet" href="<?php echo WP_STRIPE_PATH . '/css/wp-stripe-display.css'; ?>">
		<link rel="stylesheet" href="<?php echo WP_STRIPE_PATH . '/jquery-placeholder-plugin/jquery.placeholder.min.css'; ?>">

        <script type="text/javascript">
            //<![CDATA[
            var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
            var wpstripekey = '<?php echo WP_STRIPE_KEY; ?>';
            //]]>;
        </script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script type="text/javascript">
			setInterval('resizeParent();', 1000);
			function resizeParent() {
				var height = jQuery("html").outerHeight();
				parent.wp_stripe_SetIFrameHeight(height);
			}
		</script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" ></script>
        <script src="https://js.stripe.com/v1/"></script>
        <script src="<?php echo WP_STRIPE_PATH . '/js/wp-stripe.js'; ?>" ></script>
        <script src="<?php echo WP_STRIPE_PATH . '/jquery-placeholder-plugin/jquery.placeholder.min.js'; ?>" ></script>

		<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(":input[placeholder]").placeholder();
		});   
		</script>
    </head>

    <body>

        <?php

        echo wp_stripe_form();

        ?>

    </body>

</html>

<?php

?>
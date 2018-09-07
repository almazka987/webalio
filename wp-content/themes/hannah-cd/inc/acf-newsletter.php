<?php 
/*
*************************************** 
Displaying form shortcodes for newsletter select 
***************************************
*/

the_row();

$newsletter_select = ACF_GSF('newsletter_select');
$form_id_mailchimp = ACF_GSF('form_id_mailchimp');
$form_id_mailpoet = ACF_GSF('form_id_mailpoet');
$the_newsletter_plugin_form = ACF_GSF('the_newsletter_plugin_form');
$form_id_the_newsletter_plugin = ACF_GSF('form_id_the_newsletter_plugin'); ?>

<div class="newsletter-subscription">
	<?php if( $newsletter_select == 'mail_chimp' ) {
    
        if( $form_id_mailchimp ) { 
			// MAIL CHIMP
			echo do_shortcode( '[mc4wp_form id="' . esc_html( $form_id_mailchimp ) . '"]' ); 
		}

    } elseif( $newsletter_select == 'mail_poet' ) {
    
        if( $form_id_mailpoet ) { 
			// MAIL POET
			echo do_shortcode( '[wysija_form id="' . esc_html( $form_id_mailpoet ) . '"]' ); 
		}

    } elseif ( $newsletter_select == 'the_newsletter' ) {
    
        if( $the_newsletter_plugin_form == 'default_form' ) { 
			// THE NEWSLETTER PLUGIN (DEFAULT FORM)
			echo do_shortcode( '[newsletter]' ); 
		} elseif( $the_newsletter_plugin_form == 'custom_form' ) { 
			// THE NEWSLETTER PLUGIN (CUSTOM FORM)
			echo do_shortcode( '[newsletter_form form="' . esc_html( $form_id_the_newsletter_plugin ) . '"]' ); 
		}

    } ?>
</div>
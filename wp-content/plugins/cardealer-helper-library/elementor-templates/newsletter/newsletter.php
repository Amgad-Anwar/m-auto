<?php
/**
 * Newsletter widget template
 *
 * @package car-dealer-helper
 */

$nl_back_img      = isset( $settings['nl_back_img'] ) ? $settings['nl_back_img'] : '';
$newsletter_title = isset( $settings['newsletter_title'] ) ? $settings['newsletter_title'] : '';
$description      = isset( $settings['description'] ) ? $settings['description'] : '';
$color_style      = isset( $settings['color_style'] ) ? $settings['color_style'] : '';
$uid              = 'pgs-newsletter-widget-' . $this->get_id();

$this->add_render_attribute( 'cdhl_newsletter', 'class', 'news-letter row news-letter-main bg-1 bg-overlay-black-70 ' . $color_style );
if ( isset( $nl_back_img['url'] ) && $nl_back_img['url'] ) {
	$this->add_render_attribute( 'cdhl_newsletter', 'style', 'background:url(' . $nl_back_img['url'] . ');background-attachment:fixed' );
}

$this->add_render_attribute( 'cdhl_newsletter_form', 'class', 'news-letter-form' );
$this->add_render_attribute( 'cdhl_newsletter_form', 'id', $uid );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_newsletter' ); ?>>
		<div class="col-lg-6 col-md-6 col-sm-6">
		<?php
		if ( $newsletter_title ) {
			?>
			<h4 class="text-red"><?php echo esc_html( $newsletter_title ); ?></h4>
			<?php
		}
		if ( $description ) {
			?>
			<p class="text-white"><?php echo esc_html( $description ); ?></p>        
			<?php
		}
		?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6">
			<form <?php $this->print_render_attribute_string( 'cdhl_newsletter_form' ); ?>>
				<div class="row no-gutter">
					<input type="hidden" name="news_nonce" class="news-nonce" value="<?php echo esc_attr( wp_create_nonce( 'mailchimp_news' ) ); ?>">
					<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">							
						<input type="email" class="placeholder form-control newsletter-email" name="newsletter_email" placeholder="<?php esc_html_e( 'Enter your email', 'cardealer-helper' ); ?>">
					</div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<a class="button red newsletter-mailchimp submit" href="#" data-form-id="<?php echo esc_attr( $uid ); ?>"><?php esc_html_e( 'Subscribe', 'cardealer-helper' ); ?></a>
					</div><br>
					<span class="spinimg-<?php echo esc_attr( $uid ); ?>"></span>
					<p class="newsletter-msg" style="display:none;"></p>
				</div>
			</form>
		</div>
	</div>
</div>

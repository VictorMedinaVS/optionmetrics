<?php
/**
 * Footer
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */


if ( visualcomposerstarter_is_the_footer_displayed() ) : ?>
	<?php visualcomposerstarter_hook_before_footer(); ?>
    <footer class="footer px-3 py-5">
      <div class="container px-0">
        <div class="row justify-content-md-between">
          <div class="col-12 col-sm-6 d-flex justify-content-center justify-content-sm-start align-items-center mb-4">
            <a class="nav d-xl-none" href="<?php echo home_url(); ?>">              
              <img class="logo_toggle logo-container" src="<?php echo home_url('wp-content/themes/omtheme/images/logo_final/om_logo_dark_bg.png');?>" alt="optionmetrics logo" />
            </a>
          </div>
          <div class="col-12 col-sm-6 d-flex justify-content-center justify-content-sm-end mb-4 align-items-center">
            <ul class="nav d-xl-none">
              <?php echo wp_nav_menu( array(
                'theme_location'  => 'social-menu',
                'menu'            => 'Social Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )); ?>
            </ul>
          </div>
          <div class="col-xs-auto d-none d-xl-block">
            <?php
				if ( has_custom_logo() ) :
					the_custom_logo();
				else : ?>
					<h1>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
					</h1>
			<?php endif; ?>
          </div>
          <div class="col-4 col-lg-auto text-center text-lg-left">
            <div class="list-group mb-5" id="list-tab-about" role="tablist">
              <?php echo strip_tags( wp_nav_menu( array(
                'theme_location'  => 'footer-about',
                'menu'            => 'Footer About Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )), '<a>'); ?>
            </div>
          </div>
          <div class="col-4 col-lg-auto text-center text-lg-left">
            <div class="list-group mb-5" id="list-tab-data-products" role="tablist">
              <?php echo strip_tags( wp_nav_menu( array(
                'theme_location'  => 'footer-about',
                'menu'            => 'Footer Data Products Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )), '<a>'); ?>
            </div>
          </div>
          <div class="col-4 col-lg-auto text-center text-lg-left">
            <div class="list-group mb-5" id="list-tab-news-events" role="tablist">
              <?php echo strip_tags( wp_nav_menu( array(
                'theme_location'  => 'footer-about',
                'menu'            => 'Footer News & Events Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )), '<a>'); ?>
            </div>
          </div>
          <div class="col-4 col-lg-auto text-center text-lg-left">
            <div class="list-group mb-5" id="list-tab-contact" role="tablist">
              <?php echo strip_tags( wp_nav_menu( array(
                'theme_location'  => 'footer-about',
                'menu'            => 'Footer Research Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )), '<a>'); ?>
            </div>
          </div>
          <div class="col-4 col-lg-auto text-center text-lg-left">
            <div class="list-group mb-5" id="list-tab-contact" role="tablist">
              <?php echo strip_tags( wp_nav_menu( array(
                'theme_location'  => 'footer-about',
                'menu'            => 'Footer Contact Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )), '<a>'); ?>
            </div>
          </div>
          <div class="col-4 col-lg-auto text-center text-lg-left">
            <div class="list-group mb-5" id="list-tab-legal" role="tablist">
              <?php echo strip_tags( wp_nav_menu( array(
                'theme_location'  => 'footer-about',
                'menu'            => 'Footer Legal Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )), '<a>'); ?>
            </div>
          </div>
          <div class="col-xs-auto justify-content-end d-none d-xl-block">
            <ul class="nav">
              <?php echo wp_nav_menu( array(
                'theme_location'  => 'social-menu',
                'menu'            => 'Social Navigation',
                'container'       => false,
                'echo'            => false,
                'items_wrap'      => '%3$s',
                'depth'           => 0,
              )); ?>
            </ul>
          </div>
          <div class="col-md-12 rights mt-5 mb-3">Copyright © 2016-2019 OptionMetrics, LLC</div>
        </div>
      </div>
    </footer>
    <?php endif; ?>
    <?php wp_footer(); ?>
  </body>
</html>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('.linkedin').children().html('<img src="<?php echo home_url('wp-content/themes/omtheme/images/linkedin.png');?>" />');
    $('.twitter').children().html('<img src="<?php echo home_url('wp-content/themes/omtheme/images/twitter.png');?>" />');
    $('.email').children().html('<img src="<?php echo home_url('wp-content/themes/omtheme/images/email.png');?>" />');
    $('.facebook').children().html('<img src="<?php echo home_url('wp-content/themes/omtheme/images/facebook.png');?>" />');
  })
</script>




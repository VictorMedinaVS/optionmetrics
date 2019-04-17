<?php
/**
 * Header
 *
 * @package WordPress
 * @subpackage Visual Composer Starter
 * @since Visual Composer Starter 1.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php visualcomposerstarter_hook_after_head(); ?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head() ?>
	</head>
<body id="page-top" data-spy="scroll" >
<?php if ( visualcomposerstarter_is_the_header_displayed() ) : ?>
	<?php visualcomposerstarter_hook_before_header(); ?>
		<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav" data-spy="affix" data-offset-top="50">
			<div class="container px-lg-0">
				<a class="js-scroll-trigger" href="<?php echo get_home_url(); ?>">
          <img class="logo logo-container" src="<?php echo home_url('wp-content/themes/omtheme/images/logo_final/om_logo_dark_bg.png');?>" alt="optionmetrics logo" />
          <img class="logo_toggle logo-container" src="<?php echo home_url('wp-content/themes/omtheme/images/logo_final/om_logo_white_bg.png');?>" alt="optionmetrics logo" />
        </a>
		        <button class="navbar-toggler navbar-toggler-right collapsed text-white" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
		          <span id="menu-bars" class="fa fa-bars"></span>
		          <span id="menu-times" class="d-none fa fa-times"></span>
		        </button>
		        <?php wp_nav_menu( array(
		          'theme_location'   => 'primary',
		          'container'        => 'div',
		          'container_class'  => 'collapse navbar-collapse',
		          'container_id'     => 'navbarResponsive',
		          'items_wrap'       => '<ul class="navbar-nav ml-auto">%3$s</ul>'
		        )); ?>
			</div>
		</nav>
		<?php do_action( 'visualcomposerstarter_after_header_menu' ); ?>
		<?php if ( is_singular() && apply_filters( 'visualcomposerstarter_single_image', true ) ) : ?>
			<div class="header-image">
				<?php visualcomposerstarter_header_featured_content(); ?>
			</div>
		<?php endif; ?>
	<?php visualcomposerstarter_hook_after_header(); ?>
<?php endif;


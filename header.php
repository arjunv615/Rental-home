<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Home_Rent
 */

 global $post;
 $author_id = $post->post_author;
 $author_email = get_the_author_meta('user_email', $author_id);
 $current_user = wp_get_current_user();


 if(!current_user_can('administrator')){

	$user_id = email_exists($author_email);

if (is_single() && $current_user->ID != $author_id ) {

$my_account_url = wc_get_account_endpoint_url('dashboard');

	// print_r($my_account_url);die;
   
	// Perform the redirect
	wp_redirect($my_account_url);
	exit;
 }
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'home-rent' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
		
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'home-rent' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

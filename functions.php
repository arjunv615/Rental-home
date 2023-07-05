<?php

/**
 * Home Rent functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Home_Rent
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function home_rent_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Home Rent, use a find and replace
		* to change 'home-rent' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('home-rent', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'home-rent'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'home_rent_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'home_rent_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function home_rent_content_width()
{
	$GLOBALS['content_width'] = apply_filters('home_rent_content_width', 640);
}
add_action('after_setup_theme', 'home_rent_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function home_rent_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'home-rent'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'home-rent'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'home_rent_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function home_rent_scripts()
{
	wp_enqueue_style('home-rent-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('home-rent-style', 'rtl', 'replace');

	wp_enqueue_script('home-rent-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'home_rent_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

//ics file download

require_once 'inc/user-creation.php';
require_once 'inc/rental-form.php';
require_once 'inc/mail-form.php';

// AJAX handler to fetch user data
add_action('wp_ajax_fetch_user_data', 'fetch_user_data_callback');
function fetch_user_data_callback()
{
	$user_id = $_POST['user_id'];
	$year = $_POST['year'];
	// Fetch the months data
	$months_data = get_user_meta($user_id, 'months', true);

	// Generate the table HTML
	$table_html = '<style>
	div#payment-status-wrapper {
		display: none;
	}
        table {

            width: 50%;
            /* Adjust the width as needed */
            height: 300px;
            /* Adjust the height as needed */
        }
    </style>';
	$table_html .= '<h1>' . $year . ' Payment Details</h1>';
	$table_html .= '<h3>' . __('Payment Information', 'text-domain') . '</h3>';
	$table_html .= '<table class="custom-profile-table">
        <tr>
            <th>' . __('Month', 'text-domain') . '</th>
            <th>' . __('Payment Status', 'text-domain') . '</th>
        </tr>';

	foreach ($months_data as $data => $data_key) {
		foreach ($data_key as $rent_data) {
			if ($data_key['year'] == $year) {
				$title_year = $data_key['year'];
				foreach ($rent_data as $month => $value) {



					$payment_status = $value['rent'] == 0 ? '<h3 style="color:red;">Unpaid</h3>' : '<h3 style="color:green;">Paid</h3>';
					$table_html .= '<tr style="background-color: white; color: blue;">
            <td style="text-align:center;font-size:20px;">' . $month . '</td>
            <td style="text-align:center;">' . $payment_status . '</td>
        </tr>';
				}
			}
		}
	}

	$table_html .= '</table>';

	// Output the table HTML
	echo $table_html;

	wp_die(); // Terminate the AJAX request
}

//woocommerce related functionality




function rename_dashboard_menu_items($items)
{



	$items['edit-account'] = 'Settings';
	$items['custom_link_1'] = 'Profile';


	return $items;
}
add_filter('woocommerce_account_menu_items', 'rename_dashboard_menu_items');


function reorder_dashboard_menu_items($items)
{
	// Define the desired order of the menu items

	$current_user = wp_get_current_user();
	$user_roles = $current_user->roles;

	$user_posts = get_posts(
		array(
			'author' => $current_user->ID,
			'post_type' => 'post',
			'posts_per_page' => -1, // Retrieve all posts
		)
	);

	// print_r($user_posts[0]->ID);die;
	$post_name = get_post_field('post_name', $user_posts[0]->ID);
	$new_order = array(
		'dashboard' => $items['dashboard'],
		"../{$post_name}" => $items['custom_link_1'],
		'edit-account' => $items['edit-account'],
		'customer-logout' => $items['customer-logout'],

	);

	return $new_order;
}
add_filter('woocommerce_account_menu_items', 'reorder_dashboard_menu_items');

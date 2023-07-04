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



// Hook into Contact Form 7 submission
function create_user_and_post_from_contact_form7($form)
{
    // Get submitted form data
    $submission = WPCF7_Submission::get_instance();
	// Get the uploaded file
    $uploaded_files = $submission->uploaded_files();

    if ($submission) {
        $posted_data = $submission->get_posted_data();

        // Get the user data
        $email = sanitize_email($posted_data['your-email']);
        $first_name = sanitize_text_field($posted_data['first-name']);
        $phone_number = sanitize_text_field($posted_data['tel-761']);
        $dob = sanitize_text_field($posted_data['date-665']);
        $age = sanitize_text_field($posted_data['number-645']);
        $gender = sanitize_text_field($posted_data['Gender'][0]);
        $martial_status = sanitize_text_field($posted_data['martial-status'][0]);
        $guardian_name = sanitize_text_field($posted_data['fathername']);
        $guardian_relation = sanitize_text_field($posted_data['relation-with-guardian']);
        $id_type = sanitize_text_field($posted_data['id-type'][0]);
        $id_no = sanitize_text_field($posted_data['IDNo']);
        $occupation = sanitize_text_field($posted_data['Occupation']);
        $office = sanitize_text_field($posted_data['Office-InstitutionName']);
        $dop = sanitize_text_field($posted_data['date-675']);
        $address = sanitize_text_field($posted_data['your-message']);

        // Create a new user
        $username = sanitize_user($email);
        $password = 'rentlogin2023';
        $user_id = wp_create_user($username, $password, $email);

        if (!is_wp_error($user_id)) {
            // Update user meta with additional data
            add_user_meta($user_id, 'first_name', $first_name);
            add_user_meta($user_id, 'phone_number', $phone_number);
            add_user_meta($user_id, 'dob', $dob);
            add_user_meta($user_id, 'age', $age);
            add_user_meta($user_id, 'gender', $gender);
            add_user_meta($user_id, 'martial_status', $martial_status);
            add_user_meta($user_id, 'guardian_name', $guardian_name);
            add_user_meta($user_id, 'guardian_relation', $guardian_relation);
            add_user_meta($user_id, 'id_type', $id_type);
            add_user_meta($user_id, 'id_no', $id_no);
            add_user_meta($user_id, 'occupation', $occupation);
            add_user_meta($user_id, 'office', $office);
            add_user_meta($user_id, 'dop', $dop);
            add_user_meta($user_id, 'address', $address);

            update_user_meta($user_id, 'nickname', $first_name);
			$months = array();

			for ($year = 2023; $year <= 2030; $year++) {
				$monthlyData = array(
					'January' => array('rent' => 0),
					'February' => array('rent' => 0),
					'March' => array('rent' => 0),
					'April' => array('rent' => 0),
					'May' => array('rent' => 0),
					'June' => array('rent' => 0),
					'July' => array('rent' => 0),
					'August' => array('rent' => 0),
					'September' => array('rent' => 0),
					'October' => array('rent' => 0),
					'November' => array('rent' => 0),
					'December' => array('rent' => 0)
				);
			
				$yearData = array('year' => $year, $monthlyData);
				$months[] = $yearData;
			}

            // Append months data to user meta
            $existing_months_data = get_user_meta($user_id, 'months', true);
            if (empty($existing_months_data)) {
                // If 'months' meta doesn't exist, set the new value directly
                add_user_meta($user_id, 'months', $months);
            }

            $post_data = array(
                'post_title' => $first_name,
                'post_author' => $user_id,
                'post_status' => 'publish',
                'post_type' => 'post'
            );
            $new_post_id = wp_insert_post($post_data);


			$count = 0;
            foreach ($uploaded_files as $field_name => $file_paths) {
				
				
                foreach ($file_paths as $file_path) {
					
					
                    // Generate a unique filename
                    $file_name = wp_unique_filename(wp_upload_dir()['path'], basename($file_path));

                    // Move the uploaded file to the uploads folder
                    $destination = wp_upload_dir()['path'] . '/' . $file_name;
                    $is_moved = copy($file_path, $destination);

                    if ($is_moved) {
                        // Get the file type
                        $file_type = wp_check_filetype($file_name, null);

                        // Set the file options
                        $file_options = array(
                            'post_mime_type' => $file_type['type'],
                            'post_title' => $file_name,
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );
						$attachment_id = wp_insert_attachment($file_options, $destination);
							if($count == 1){
								add_user_meta($user_id, 'attached_second_file', $attachment_id);
								return;

							}
                        // Insert the file as an attachment to the media library
                        
						add_user_meta($user_id, 'attached_file', $attachment_id);
						include( ABSPATH . 'wp-admin/includes/image.php' );
						$attachment_data = wp_generate_attachment_metadata($attachment_id, $destination);
                        wp_update_attachment_metadata($attachment_id, $attachment_data);
						$count += 1;

						// Generate metadata for the attachment

                        
                    }
					
					
                }
			}



            if (!is_wp_error($new_post_id)) {
                // Optionally, you can perform additional actions after the post is created.
                // For example, you may want to add custom fields or taxonomies to the post.
            }
        }
    }
}

// Hook into Contact Form 7 submission
add_action('wpcf7_before_send_mail', 'create_user_and_post_from_contact_form7');





// Create the Rental Form menu
function create_rental_form_menu()
{
	add_menu_page(
		'Rental Form',
		'Rental Form',
		'manage_options',
		'rental-form',
		'render_rental_form'
	);
}
add_action('admin_menu', 'create_rental_form_menu');




// Render the Rental Form
function render_rental_form()
{
	$months = array(
		'January', 'February', 'March', 'April', 'May', 'June',
		'July', 'August', 'September', 'October', 'November', 'December'


	);
	$years = range(2023, 2030);

?>
	<div class="wrap">
		<h1>Rental Form</h1>
		<form method="post" action="" id="rent_id">

		<label for="year_dropdown">Year:</label>
			<select name="year_dropdown" id="year_dropdown">
				<option value="-1">please select year</option>
				<?php
				foreach ($years as $year) {
					echo '<option  value="' . $year . '">' . $year . '</option>';
				}
				?>
			</select>



			<label for="user_dropdown">Users:</label>
			<select name="user_dropdown" id="user_dropdown">

				<option value="-1">please select the mail id</option>
				<?php
				// Query all users
				$users = get_users(array('role' => 'subscriber'));
				foreach ($users as $user) {

					$selected = ($_POST['user_dropdown'] == $user->ID) ? 'selected' : '';
					echo '<option value="' . $user->ID . '" ' . $selected . '>' . $user->user_email . '</option>';
				}
				?>
			</select>


			<label for="month_dropdown">Months:</label>
			<select name="month_dropdown" id="month_dropdown">
				<option value="-1">please select month</option>
				<?php
				foreach ($months as $month) {
					echo '<option  value="' . $month . '">' . $month . '</option>';
				}
				?>
			</select>

			<input type="submit" name="submit" value="Submit">
		</form>
		<div id="user_data"></div>
	</div>
	<?php



	if (isset($_POST['user_dropdown']) && isset($_POST['month_dropdown'])) {

		$rent_user_id = $_POST['user_dropdown'];
		$rent_month = $_POST['month_dropdown'];
		$rent_year = $_POST['year_dropdown'];
		

		
		//mail send

		$user_data = get_userdata($rent_user_id);



		

		if ($user_data && $rent_month !=-1 && $rent_year !=-1) {


			// user meta update
			
			// print_r(get_user_meta($rent_user_id, 'months', true));die;

			$rent_paying_month = get_user_meta($rent_user_id, 'months', true);

			$count = 0;
			foreach($rent_paying_month as $data => $data_key){
				foreach($data_key as $rent_data){

					if($data_key['year'] == $rent_year ){

						if (array_key_exists($rent_month, $data_key[0])) {

							
						
							$rent_paying_month[$count][0][$rent_month]['rent'] = 1;
	
							update_user_meta($rent_user_id, 'months', $rent_paying_month );
							


						}


					}
				
				}
				$count++;
			
			}

			?>

			<?php

			// Fetch the months data
			$months_data = get_user_meta($rent_user_id, 'months', true);

			// Generate the table HTML
			$table_html = '<style>
					table {

					width: 50%;
					/* Adjust the width as needed */
					height: 300px;
					/* Adjust the height as needed */
						}
				</style>';
			$table_html .= '<div id="payment-status-wrapper"><h3>' . __('Payment Information', 'text-domain') . '</h3>';
			$table_html .= '<table class="custom-profile-table">
			<tr>
				<th>' . __('Month', 'text-domain') . '</th>
				<th>' . __('Payment Status', 'text-domain') . '</th>
			</tr>';

			foreach($months_data as $data=>$data_key){
				
					
					if($data_key['year'] == $rent_year ){
						
						
					foreach ($data_key[0] as $month => $value) {


				$payment_status = $value['rent'] == 0 ? '<h3 style="color:red;">Unpaid</h3>' : '<h3 style="color:green;">Paid</h3>';
				$table_html .= '<tr style="background-color: white; color: blue;">
					<td style="text-align:center;font-size:20px;">' . $month . '</td>
					<td style="text-align:center;">' . $payment_status . '</td>
					</tr>';
			}
		
	}
}
		

			$table_html .= '</table></div>';

			// Output the table HTML
			echo $table_html;

			?>
	<?php
		}
	}

	?>

	<script>
		jQuery(document).ready(function($) {
			$('#user_dropdown').on('change', function() {
				var userId = $(this).val();
				var year = $('#year_dropdown').val();
				if (userId !== '-1' && year !== '-1') {
					// Perform AJAX request
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {
							action: 'fetch_user_data',
							user_id: userId,
							year: year
						},
						success: function(response) {
							// Update the user_data div with the fetched data
							$('#user_data').html(response);
						},
						error: function(xhr, status, error) {
							console.log(error); // Handle the error gracefully
						}
					});
				} else {
					// Clear the user_data div if no option is selected
					$('#user_data').empty();
				}
			});
		});
	</script>
<?php
}


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
	$table_html .= '<h3>' . __('Payment Information', 'text-domain') . '</h3>';
	$table_html .= '<table class="custom-profile-table">
        <tr>
            <th>' . __('Month', 'text-domain') . '</th>
            <th>' . __('Payment Status', 'text-domain') . '</th>
        </tr>';

		foreach($months_data as $data=>$data_key){
			foreach($data_key as $rent_data){
				if($data_key['year'] == $year ){
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

function rename_dashboard_menu_items($items) {



    $items['edit-account'] = 'Settings';
	$items['custom_link_1'] = 'Profile';


    return $items;
}
add_filter('woocommerce_account_menu_items', 'rename_dashboard_menu_items');


function reorder_dashboard_menu_items($items) {
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
	$post_name= get_post_field('post_name', $user_posts[0]->ID);
    $new_order = array(
        'dashboard' => $items['dashboard'],
        "../{$post_name}" => $items['custom_link_1'],
        'edit-account' => $items['edit-account'],
		'customer-logout' => $items['customer-logout'],
						
    );

    return $new_order;

}
add_filter('woocommerce_account_menu_items', 'reorder_dashboard_menu_items');


<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Home_Rent
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				home_rent_posted_on();
				home_rent_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php home_rent_post_thumbnail(); ?>

	<?php
// Check if the user is logged in
global $post;

// Get the post author ID
$author_id = $post->post_author;

// Get the author's email
$author_email = get_the_author_meta('user_email', $author_id);

// Check if the author's email exists in the user database
$user_id = email_exists($author_email);
if ($user_id) {
   
    // Get the user meta fields
    $first_name = get_user_meta($user_id)['first_name'][1];
    $phone_number = get_user_meta($user_id, 'phone_number', true);
    $dob = get_user_meta($user_id, 'dob', true);
    $age = get_user_meta($user_id, 'age', true);
    $gender = get_user_meta($user_id, 'gender', true);
    $martial_status = get_user_meta($user_id, 'martial_status', true);
    $guardian_name = get_user_meta($user_id, 'guardian_name', true);
    $guardian_relation = get_user_meta($user_id, 'guardian_relation', true);
    $id_type = get_user_meta($user_id, 'id_type', true);
    $id_no = get_user_meta($user_id, 'id_no', true);
    $occupation = get_user_meta($user_id, 'occupation', true);
    $office = get_user_meta($user_id, 'office', true);
    $dop = get_user_meta($user_id, 'dop', true);
    $address = get_user_meta($user_id, 'address', true);

    // Display the user details
    echo 'First Name: ' . $first_name . '<br>';
    echo 'Phone Number: ' . $phone_number . '<br>';
    echo 'Date of Birth: ' . $dob . '<br>';
    echo 'Age: ' . $age . '<br>';
    echo 'Gender: ' . $gender . '<br>';
    echo 'Marital Status: ' . $martial_status . '<br>';
    echo 'Guardian Name: ' . $guardian_name . '<br>';
    echo 'Guardian Relation: ' . $guardian_relation . '<br>';
    echo 'ID Type: ' . $id_type . '<br>';
    echo 'ID Number: ' . $id_no . '<br>';
    echo 'Occupation: ' . $occupation . '<br>';
    echo 'Office: ' . $office . '<br>';
    echo 'Date of Posting: ' . $dop . '<br>';
    echo 'Address: ' . $address . '<br>';

}

?>


	
</article><!-- #post-<?php the_ID(); ?> -->

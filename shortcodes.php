<?php
// Include the functions.php file
require_once get_template_directory() . '/functions.php'; // Update with the correct path to functions.php

// Register the shortcode
add_shortcode('subscribe', 'render_rental_shortcode');

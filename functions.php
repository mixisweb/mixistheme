<?php
/* ====== Add theme support options ====== */
add_theme_support('automatic-feed-links');
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

/* ====== Register javascripts and jquery ====== */
function setup_theme_scripts() {
	wp_enqueue_style( 'main', get_template_directory_uri() . '/css/style.css', null, null );
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/theme.js', array('jquery'), null, true );
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'setup_theme_scripts' );

/* ====== Edit page title ====== */
function set_page_title($title ) {
	$title=(is_home() || is_front_page())?bloginfo('name'):bloginfo('name').' |'.$title;
	return $title;
}
add_filter('wp_title', 'set_page_title');

/* ====== Setup additional image size ====== */
function image_setup_thumb(){
	add_image_size( 'category-thumbnails', 280, 140, true );
}
add_action( 'after_setup_theme', 'image_setup_thumb' );

function my_custom_sizes( $sizes ) {
	return array_merge( $sizes, array(
			'category-thumbnails' => __( 'Category thumbnails' )
	) );
}
add_filter( 'image_size_names_choose', 'my_custom_sizes' );

/* ====== Change upload filename ====== */
function rename_upfile($filename, $filename_raw) {
	$info = pathinfo($filename);
	$ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
	$date=date('Y-m-d-H-i-s');
	$domain='';
	$new =$domain.'-'.$date.$ext;
	if( $new != $filename_raw ) {
		$new = sanitize_file_name( $new );
	}
	return $new;
}
add_filter('sanitize_file_name', 'rename_upfile', 10, 2);

/* ====== Register menu ====== */
register_nav_menus(array(
'top'    =>__('Top menu', 'Mixis Theme'),
'main' => __('Main menu', 'Mixis Theme'),
'footer' => __('Footer col1', 'Mixis Theme'),
));

?>

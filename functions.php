<?php
define('THEME_SLUG', 'mixistheme');

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


/* ====== Theme languages ====== */
function setup_theme_lang(){
	load_theme_textdomain(THEME_SLUG, get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'setup_theme_lang');


/* ====== Edit page title ====== */
function set_page_title($title ) {
	$title = (is_home() || is_front_page())?bloginfo('name'):bloginfo('name').' |'.$title;
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
			'category-thumbnails' => __( 'Category thumbnails', THEME_SLUG )
	) );
}
add_filter( 'image_size_names_choose', 'my_custom_sizes' );


/* ====== Change upload filename ====== */
function rename_upfile($filename, $filename_raw) {
	$info	= pathinfo($filename);
	$ext	= empty($info['extension']) ? '' : '.' . $info['extension'];
	$date	= date('Y-m-d-H-i-s');
	$domain	= '';
	$new 	= $domain.'-'.$date.$ext;
	if( $new != $filename_raw ) {
		$new = sanitize_file_name( $new );
	}
	return $new;
}
add_filter('sanitize_file_name', 'rename_upfile', 10, 2);


/* ====== Register menu ====== */
register_nav_menus(array(
	'top'	=> __('Top menu', THEME_SLUG),
	'main'	=> __('Main menu', THEME_SLUG),
	'footer'=> __('Footer col1', THEME_SLUG),
));


/* ====== Register sidebar ====== */
function register_theme_widgets(){
	register_sidebar( array(
	'name' => __('Left sidebar', THEME_SLUG),
	'id' => 'left-sidebar',
	'description' => __('Left sidebar desc', THEME_SLUG),
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>'
	));
	register_sidebar( array(
	'name' => __('Right sidebar', THEME_SLUG),
	'id' => 'right-sidebar',
	'description' => __('Right sidebar desc', THEME_SLUG),
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>'
	));
	register_sidebar( array(
	'name' => __('Contacs sidebar', THEME_SLUG),
	'id' => 'contacts-sidebar',
	'description' => __('Contacs sidebar desc', THEME_SLUG),
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>'
	));
}
add_action( 'widgets_init', 'register_theme_widgets' );


/* ====== Register breadcrumbs ====== */
include ('breadcrumbs.php');


/* ====== Remove # from more-link ====== */
function remove_more_jump_link($link) {
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
		//$link = str_replace('more-link','more-link rmrh-show-more',$link);
	}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

?>

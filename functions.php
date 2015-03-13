<?php
define('THEME_SLUG', 'mixistheme');
if ( ! isset( $content_width ) ) $content_width = 960;
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

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
	'footer'=> __('Footer', THEME_SLUG),
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


/*====== Edit THE_EXCERPT ======*/
function custom_excerpt_filter($excerpt) {
	$excerpt='<p>'.preg_replace( '/\[[^\]]+\]/', '',get_the_excerpt()).'</p>';
	return $excerpt;
}
add_filter('the_excerpt', 'custom_excerpt_filter', 11);


/*====== Edit READMORE link in THE_EXCERPT ======*/
function new_excerpt_more( $more ) {
	return ' <a class="more-link" href="'. get_permalink( get_the_ID() ) . '"><span>' . __('Read more', THEME_SLUG) . '</span></a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


/*====== Category pagination ======*/
function post_pagination_digits() {
	global $wp_query;
	$pages = '';
	$max = $wp_query->max_num_pages;
	if (!$current = get_query_var('paged')) $current = 1;
	$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
	$a['total'] = $max;
	$a['current'] = $current;

	$total = 1;
	$a['mid_size'] = 3;
	$a['end_size'] = 1;
	$a['prev_text'] = '&laquo;';
	$a['next_text'] = '&raquo;';

	if ($max > 1) echo '<div class="navigation">';
	echo $pages . paginate_links($a);
	if ($max > 1) echo '</div>';
}


/*====== Child Pages ======*/
function child_pages() {
	$output="";
	global $post;
	//Request child pages
	$args = array(
			'post_parent' => $post->ID,
			'post_type' => 'page',
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post__not_in' => array()
	);
	$subpages = new WP_query($args);
	// Make data
	if ($subpages->have_posts()) :
	$output = '<div id="child-pages">';
	while ($subpages->have_posts()) : $subpages->the_post();
	global $more;
	$output .= '
				<div class="child-one">
					<a href="'.get_permalink().'">'.get_the_post_thumbnail($post->ID,'thumbnail').'</a>
					<a href="'.get_permalink().'" class="child-one-title">'.get_the_title().'</a>
				</div>';
	endwhile;
	$output .="</div>";
	endif;
	wp_reset_postdata();
	echo $output;
}
?>

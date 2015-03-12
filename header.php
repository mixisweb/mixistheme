<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="wrap">
		<?php if ( has_nav_menu( 'top') ):?>
			<nav class="top-menu">
				<?php wp_nav_menu( array( 'theme_location'=>'top','container' => false,'items_wrap'=> '<ul>%3$s</ul>') ); ?>
			</nav><!-- end top site-navigation -->
		<?php endif;?>
		<header class="site-header">
			<div class="branding-header">
				<div class="col-1"></div>
                <div class="col-2"></div>
				<div class="col-3"></div>
			</div>
		</header><!-- end site-header -->
		<?php if ( has_nav_menu( 'main') ):?>
			<nav class="main-menu">
				<?php wp_nav_menu( array( 'theme_location'=>'main','container' => false,'items_wrap'=> '<ul>%3$s</ul>') ); ?>
			</nav><!-- end main site-navigation -->
		<?php endif;?>
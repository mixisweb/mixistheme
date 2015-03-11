<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="wrap">
		<header class="site-header">
			<div class="branding-header">
				<div class="col-1">
                	<a href="<?php echo get_site_url();?>"><img src="<?php bloginfo('template_url'); ?>/images/logo-main-4.1.png"></a>
                </div>
                <div class="col-2"></div>
				<div class="col-3">
                </div>
			</div>
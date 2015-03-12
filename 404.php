<?php get_header();?>
		<section class="content">
			<section class="content-area">
					<article  id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="post-header"><h2>
							<?php echo __( 'Oops! That page can&rsquo;t be found.', THEME_SLUG ); ?>
						</h2></header>
					</article>
			</section>
		</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
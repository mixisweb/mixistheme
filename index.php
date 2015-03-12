<?php get_header();?>
		<section class="content">
			<section class="content-area">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article class="post">
						<header class="post-header"><h2><?php the_title();?></h2></header>
						<?php the_content();?>
						<?php //Navigation in post
							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', THEME_SLUG ),
								'after'  => '</div>',
							) );
						?>
					</article>
						<?php //Comments
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						?>
						<?php if(is_tag()):?>
							<?php the_tags();?>
						<?php endif;?>
				<?php endwhile;?>
				<?php endif;?>
			</section>
		</section>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php if ( is_active_sidebar( 'right-sidebar' ) ) : ?>
	<aside class="right-sidebar">
		<ul>
			<?php dynamic_sidebar( 'right-sidebar' );?>
		</ul>
	</aside><!-- end right sidebar -->
<?php endif; ?>
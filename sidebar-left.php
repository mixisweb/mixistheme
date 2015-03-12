<?php if ( is_active_sidebar( 'left-sidebar' ) ) : ?>
	<aside class="left-sidebar">
		<ul>
			<?php dynamic_sidebar( 'left-sidebar' );?>
		</ul>
	</aside> <!-- end left sidebar -->
<?php endif; ?>
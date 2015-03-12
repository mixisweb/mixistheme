		<footer class="footer">
			<div class="copyright">
				Copyright &copy; <?php echo date('Y');?> Brand Name. All rights reserved.
			</div>
			<?php if ( has_nav_menu( 'footer') ):?>
				<nav class="footer-menu">
					<?php wp_nav_menu( array( 'theme_location'=>'footer','container' => false,'items_wrap'=> '<ul>%3$s</ul>') ); ?>
				</nav><!-- end top site-navigation -->
			<?php endif;?>
		</footer>
	</div><!-- end wrap -->
<?php wp_footer(); ?>
</body>
</html>
<?php
/**
 * Footer widget areas
 * 
 * @package Izo
 */
?>

<?php
	$izo_footer_widgets_layout = get_theme_mod( 'footer_widgets_layout', 'disabled' );

	switch ( $izo_footer_widgets_layout ) {
		case 'columns1':
			$izo_widget_areas = 1;
			break;

		case 'columns2':
			$izo_widget_areas = 2;
			break;
			 
		case 'columns1l2s':	
		case 'columns3':
			$izo_widget_areas = 3;
			break;

		case 'columns4':
			$izo_widget_areas = 4;
			break;	

		default:
			return;
	}	
?>

<div class="footer-widgets <?php echo esc_attr( $izo_footer_widgets_layout ); ?>">
	<div class="izo-container">
	<?php for ( $izo_counter = 1; $izo_counter <= $izo_widget_areas; $izo_counter++ ) { ?>
		<?php if ( is_active_sidebar( 'footer-' . $izo_counter ) ) : ?>
		<div class="widgets-column">
			<?php dynamic_sidebar( 'footer-' . $izo_counter); ?>
		</div>
		<?php endif; ?>	
	<?php } ?>
	</div>
</div>

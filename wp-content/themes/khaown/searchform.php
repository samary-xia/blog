
<div class="search-container">
	<form role="search" method="get" class="form-inline my-lg-0 em-search-bar ml-auto p-2" action="<?php  echo esc_url(home_url( '/' )); ?>">
		<label for='s' class='screen-reader-text'><?php _e( 'Search', 'khaown' ); ?></label> 
		<input style="flex-grow: 5" class="form-control" aria-label="<?php esc_attr_e('Search','khaown'); ?>" type="search" name="s" placeholder="<?php esc_attr_e('Search','khaown'); ?>" value="<?php echo get_search_query(); ?>">
		<button style="flex-grow: 1" class="btn search-btn btn-color-change" type="submit"><?php _e('Search', 'khaown'); ?></button>
	</form> 	
</div>
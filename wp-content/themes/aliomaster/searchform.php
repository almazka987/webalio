<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
	<input type="text" value="<?php echo get_search_query() ?>" placeholder="search..." name="s" id="s" />
	<button type="submit" id="searchsubmit" class="loop-btn"><i class="fa fa-search"></i></button>
</form>
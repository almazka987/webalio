<?php

/* ==================================================

Sidebar Template

================================================== */

if ( ! is_active_sidebar( 'footer3_sidebar' ) ) {
     return;
}
?>

<div class="sidebar footer3_sidebar">
     <?php dynamic_sidebar( 'footer3_sidebar' ); ?>
</div>

<div class="photodex-single">
    <a href="<?php echo get_the_post_thumbnail_url( $attributes['post_id'] ); ?>">
	<?php echo get_the_post_thumbnail( $attributes['post_id'], $attributes['thumbnail_size'] ); ?>
    </a>
</div>
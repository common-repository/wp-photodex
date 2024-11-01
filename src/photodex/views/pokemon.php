<div class="photodex-entry">
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_post_thumbnail_url() ?>">
			<?php the_post_thumbnail( 'photodex_thumbnail' ); ?>
		</a>
	<?php endif; ?>
</div>

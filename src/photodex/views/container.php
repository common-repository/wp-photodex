<?php use Ajskelton\WpPhotodex\Photodex\Shortcode as Shortcode; ?>

<div class="photodex--container photodex">
    <?php Shortcode\loop_and_render_pokemon( $query, $attributes, $config ); ?>
</div>

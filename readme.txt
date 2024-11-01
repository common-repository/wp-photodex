=== WP Photodex ===
Contributors: ajskelton
Donate link: https://anthonyskelton.com/contact
Tags: pokemon, photodex, pokemon go, pokedex
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 1.0.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The WP Photodex plugin creates an easy way for you to share your photos of Pokemon in the wild of Pokemon Go.

== Description ==
The WP Photodex creates a custom post type for you to add the photos of the pokemon you capture in the wild. It was inspired by Jamie Humphries and his [photodex project](https://github.com/jamiehumphries/photodex)

Mimicking the in game pokedex the WP Photodex organizes the pokemon by pokedex number and shows your entire collection or one of your choosing. You can also show a single random pokemon.

In the Admin section you can sort your posts by name, or by pokedex number. When you add a new post you assign it to a pokemon. Each pokemon can only be assigned once, if you want a new picture you'll have to update the featured image of the original post or delete it and create a new one.

Admin:

The WP Pokemon Photodex plugin adds a tab to the admin for the Photodex post class.

You can add new posts for each pokemon in your collection. For each post you select the pokemon from the Pokedex the post is associated with and select a featured image.

When you load the Photodex section the default sort is by post date. You can also sort by pokemon name, or pokedex number.


Shortcode Attributes:

* [photodex] - Prints full photodex
* [photodex post_id="#" thumbnail_size="thumbnail(default)/medium/large/full"] - Prints Single Pokemon of selected post number
* [photodex random="true" thumbnail_size="thumbnail(default)/medium/large/full"] = Prints Single random Pokemon


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Photodex screen to begin adding Pokemon
4. Add the shortcode to a post/page to print the full Photodex or a single Pokemon

== Frequently Asked Questions ==

= Can I have more than one picture for a pokemon? =
No, to prevent repeats in the full photodex you can only assign a post to single pokedex number, and that number is no longer
available for future posts.

== Screenshots ==

1. A screen shot of a full photodex being rendered. This is only a partial, an actual photodex would continue until your highest pokedex number pokemon.
2. This is an example of a single pokemon being rendered with the default 'medium' size.

== Changelog ==

= 1.0.0 =
* Initial Release

== Upgrade Notice ==

= 1.0.0 =
* Initial Release
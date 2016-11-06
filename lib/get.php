<?php namespace Plumbus;

/**
* Get acts as a theme utility for WordPress and Advanced Custom Fields so you don't have to re write the same code over and over in templates.
*/
class Get
{
	/**
	* Get the current post's slug, or the slug of $id
	* @method slug
	* @param  integer        $id  ID of page you want the slug for. (leave blank to default to the current post)
	* @return string
	*/
	public static function slug($ID = 0) {
		global $post;
		return ($ID) ? basename(get_permalink($ID)) : basename(get_permalink($post->ID));
	}

	/**
	* Get the current post parent's slug.
	* @method parentSlug
	* @return string
	*/
	public static function parentSlug() {
		global $post;
		$parent_id = wp_get_post_parent_id($post->ID);
		$ancestors = get_post_ancestors($post);
		$slug = ($ancestors) ? self::slug($ancestors[count($ancestors)-1]) : self::slug($parent_id);
		return (!$post->post_parent && !in_array($post->id, $ancestors)) ? '' : $slug;
	}

	/**
	* Get the current post's featured image.
	* The returned array contains four values: the URL of the attachment image src, the width of the image file, the height of the image file, and a boolean representing whether the returned array describes an intermediate (generated) image size or the original, full-sized upload.
	* Returns an array [url, width, height, is_intermediate], or fallback if no image is set.
	* @method featuredImage
	* @param  string        $size  The image size you want to get back.
	* @param  int        $pid  optional post ID
	* @return array
	*/
	public static function featuredImage($size = 'full', $pid = false) {
		if (!$pid) {
			global $post;
			$pid = $post->ID;
		}

		$fallback = get_theme_mod('defaultHeroImage', 'http://placehold.it/1920/1080');
		return has_post_thumbnail() ? wp_get_attachment_image_src(get_post_thumbnail_id($pid), $size) : $fallback;
	}

}

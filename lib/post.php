<?php namespace Plumbus;

/**
* Post is for conditional stuff you may want to do in your theme.
*/
class Post
{

	public static function hasChildren($pid = null) {
		global $post;
		$pid = (!is_null($pid) && is_numeric($pid)) ? $pid : $post->ID;
		$page = get_post($pid);
		return (bool)(count(get_posts([
			'post_parent' => $pid,
			'post_type' => $page->post_type
		])));
	}

	public static function isChild($pid = null) {
		global $post;
		$pid = (!is_null($pid && is_numeric($pid))) ? $pid : $post->ID;
		$page = get_post($pid);
		return (bool)($page->post_parent);
	}

	public static function isAncestor($pid = null) {
		global $wp_query;
		global $post;
		$pid = (!is_null($pid && is_numeric($pid))) ? $pid : $post->ID;
		$ancestors = $wp_query->post->ancestors;
		return (bool)(in_array($pid, $ancestors));
	}

	/**
	* Return true if the post is the top most part of a tree (the root)
	*/
	public static function isTree($pid = null) {
		return (bool)(!self::isChild($pid) && self::hasChildren($pid) && self::isAncestor($pid));
	}

	/**
	* Display estimated reading time, ala Medium, et al.
	* Assumes a reading speed of 200 words per minute.
	*/
	public static function readTime($pid = null) {
		$pid = (!is_null($pid && is_numeric($pid))) ? $pid : $post->ID;
		$page = get_post($pid);
		$words = str_word_count(strip_tags($page->content));
		$readTime = floor($words / 200);
		return ($readTime === 0) ? 'Less than 1 min read' : $readTime.' min read';
	}

}

<?php
/*
Plugin Name: Modern Posts Widget
Plugin Author: Gregory Cornelius
Description: A flexible widget for listing posts and pages. Created for a Boston WordPress Meetup.
*/

/*

Copyright (C) 2011 Gregory Cornelius

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

function modern_posts_widgets_init() {
	register_widget('ModernPostsWidget');
}
add_action('widgets_init', 'modern_posts_widgets_init');

class ModernPostsWidget extends WP_Widget {

	protected $defaults = array(
		'title' => '',
		'title_href' => '',
		'category' => 0,
		'number' => 1
	);
	
	/**
	 * Old school object constructor.
	 */
	public function ModernPostsWidget() {
		$widget_ops = array(
			'classname' => 'widget-modern-posts',
			'description' => 'A more flexible Recent Posts widget.',
		);

		$this->WP_Widget('modern-posts', __('Modern Posts'), $widget_ops);
	}
	/**
	 * Output widget markup.
	 *
	 * @global object $post
	 * @param array $args
	 * @param array $instance
	 *
	 */
	public function widget($args, $instance) {
		global $post;

		extract($args);
		unset($args);
		
		$show = apply_filters('modern_posts_visibility', true, $instance);
		if($show == false) return;
		
		$instance = wp_parse_args($instance, $this->defaults);

		$title = $instance['title'];


		if(!empty($instance['title_href']) && !empty($instance['title'])) {
			$title = sprintf('<a href="%s">%s</a>', esc_attr($instance['title_href']), $title);
		}

		$query_args = $this->build_query($instance);
		$query = new WP_Query($query_args);

		$output = apply_filters('modern_posts_template', '', &$query, $instance);

		wp_reset_postdata();

		if(!empty($output)) {
			echo $before_widget;
			if(!empty($title)) echo $before_title . $title . $after_title;
			echo $output;
			echo $after_widget;
		}
	}
	/**
	 * Generate query_args to be passed to instance of WP_Query. Method is broken
	 * out so that the widget can be extended.
	 *
	 * @global  $post
	 * @param array $instance
	 * @return array $query_args
	 */

	public function build_query($instance) {
		global $post;

		$query_args = array(
			'post_type' => 'post',
			'cat' => $instance['category'],
			'posts_per_page' => $instance['number']
		);

		if(is_single()) {
			$query_args['post__not_in'] = (array) $post->ID;
		}

		return apply_filters('modern_posts_query_args', $query_args, $instance);

		
	}

	/**
	 * Merge and validate new form values with the previous values.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array $instance
	 */
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['title_href'] = strip_tags($new_instance['title_href']);
		$instance['category'] = (int) $new_instance['category'];
		$instance['number'] = (int) $new_instance['number'];

		//error_log(sprintf("modern posts: %s", print_r($new_instance, true)));
		
		return $instance;
	}
	/**
	 * Generate widget control form elements.
	 *
	 * @param array $instance
	 */
	public function form($instance) {
		
		$args = wp_parse_args($instance, $this->defaults);

		$cat_selector_args = array(
			'hierarchical'=>1,
			'show_option_all' => 'All Categories',
			'orderby' => 'name',
			'show_count' => 1,
			'name'=> $this->get_field_name('category'),
			'selected' => $args['category']
		);

		include('interface/widget-controls.php');
	}

	/**
	 * Form field helper.
	 *
	 * @param string $name
	 */
	public function field_id($name) {
		echo $this->get_field_id($name);
	}

	/**
	 * Form field helper.
	 *
	 * @param string $name
	 */
	public function field_name($name) {
		echo $this->get_field_name($name);
	}
	/**
	 * Default widget template.
	 * 
	 * @global object $post
	 * @param string $content
	 * @param WP_Query $query
	 * @return string
	 */
	static function template($content, WP_Query $query) {
		global $post;

		//WordPress Loop
		$content = '';
		if($query->have_posts()) {
			$content .= '<ul>';
			while($query->have_posts()) {
				$query->the_post();

				$content .= sprintf('<li><a href="%s">%s</a></li>', get_permalink(), get_the_title());
			
			}
			$content .= '</ul>';

		}
		return $content;
	}
}

add_filter('modern_posts_template', 'ModernPostsWidget::template', 1, 2);




?>

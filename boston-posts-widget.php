<?php
/*
Name: Boston Posts Widget
Description: A flexible widget for listing posts and pages. Created for a Boston WordPress Meetup.
Author: Gregory Cornelius
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


BostonPostsWidget extends WP_Widget {

	function __construct($id_base = false, $name, $widget_options = array(), $control_options = array()) {

	}

	function widget($args, $instance) {

		extract($args);
		unset($args);
		
		$show = apply_filters('boston_posts_widget_visibility', false);
		if($show == false) return;

		$title = $instance['title'];

		$query_args = array();
			
		$query_args = apply_filters();
		$query = new WP_Query();

	
		$output = apply_filters('boston_posts_template', '');

		wp_reset_postdata();

		if(!empty($output)) {
			echo $before_widget;

			if(!empty($title)) echo $before_title . $title . $after_title;
			echo $html 
			echo $after_widget;
		}
	}

	function update($new_instance, $old_instance) {
		
		return $new_instance;
	}

	function form($instance) {
		$defaults = array();
		
	}

	static function template($content) {
		global $post;

		//WordPress Loop Here

		return $content;
	}
}

add_filter('boston_posts_template', array(), 1, 1);



?>

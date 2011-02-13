<p>
	<label for="<?php $this->field_id('title'); ?>"><?php _e('Title:'); ?></label>&nbsp;
	<input class="widefat" id="<?php $this->field_id('title'); ?>" name="<?php $this->field_name('title'); ?>" type="text" value="<?php echo $args['title']; ?>" />
</p>
<p>
	<label for="<?php $this->field_id('title_href'); ?>"><?php _e('Archive Link:'); ?></label>
	<input class="widefat" id="<?php $this->field_id('title_href'); ?>" name="<?php $this->field_name('title_href'); ?>" type="text" value="<?php echo $args['title_href']; ?>" />
</p>
<p>
	<label for="<?php $this->field_id('category'); ?>"><?php _e('Category:'); ?></label>
	<?php wp_dropdown_categories($cat_selector_args); ?>
</p>
<p>
	<label for="<?php $this->field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
	<input type="text" id="<?php $this->field_id('number'); ?>" name="<?php $this->field_name('number'); ?>" size="3" value="<?php echo $args['number']; ?>"/>
</p>

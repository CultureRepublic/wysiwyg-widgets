<?php

class WYSIWYG_Widgets_Widget extends WP_Widget
{
	public function __construct() {
		parent::__construct(
	 		'wysiwyg_widgets_widget', // Base ID
			'WYSIWYG Widget', // Name
			array( 'description' => __('Displays one of your Widget Blocks.', 'wysiwyg-widgets') ) // Args
		);
	}

 	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		$id = ($instance['wysiwyg-widget-id']) ? $instance['wysiwyg-widget-id'] : 0;

		$show_title = (isset($instance['show_title'])) ? $instance['show_title'] : 1;
		$post = get_post($id);

		echo $before_widget;

		if(!empty($id) && $post) {

			if($show_title) { 
				// first check $instance['title'] so titles are not changes for people upgrading from an older version of the plugin
				// titles WILL change when they re-save their widget.. 
				$title = (isset($instance['title'])) ? $instance['title'] : $post->post_title;
				$title = apply_filters( 'widget_title', $title );
			}

			$content = $post->post_content;
			$content = do_shortcode($content);
			$content = wpautop($content);
			$content = apply_filters('ww_content', $content, $id);

			?>
			
			<!-- Widget by WYSIWYG Widgets v<?php echo WYWI_VERSION_NUMBER ?> - http://wordpress.org/plugins/wysiwyg-widgets/ -->
			<?php if($show_title) { echo $before_title . $title . $after_title; } ?>
			<?php echo $content; ?>
			<!-- / WYSIWYG Widgets -->

			<?php

		} elseif(current_user_can('manage_options')) { ?>
				<p>
					<?php if(empty($id)) { 
						_e('Please select a Widget Block to show in this area.', 'wysiwyg-widgets');
					} else { 
						printf(__('No widget block found with ID %d, please select an existing Widget Block in the widget settings.', 'wysiwyg-widgets'), $id);
					} ?>
				</p>
		<?php 
		}

		echo $after_widget;
		
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['wysiwyg-widget-id'] = $new_instance['wysiwyg-widget-id'];
		$instance['show_title'] = (isset($new_instance['show_title']) && $new_instance['show_title'] == 1) ? 1 : 0;
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		
		$posts = (array) get_posts(array(
			'post_type' => 'wysiwyg-widget',
			'numberposts' => -1
		));

		$show_title = (isset($instance['show_title'])) ? $instance['show_title'] : 1;
		$selected_widget_id = (isset($instance['wysiwyg-widget-id'])) ? $instance['wysiwyg-widget-id'] : 0;
		$title = ($selected_widget_id) ? get_the_title($selected_widget_id) : 'No widget block selected.';
		?>

		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="hidden" value="<?php echo esc_attr( $title ); ?>" />

		<p>	
			<label for="<?php echo $this->get_field_id( 'wysiwyg-widget-id' ); ?>"><?php _e( 'Widget Block to show:', 'wysiwyg-widgets' ); ?></label> 
			<select class="widefat" id="<?php echo $this->get_field_id('wysiwyg-widget-id'); ?>" name="<?php echo $this->get_field_name( 'wysiwyg-widget-id' ); ?>" required>
				<option value="0" disabled <?php selected($selected_widget_id, 0); ?>><?php if(empty($posts)) { _e('No widget blocks found', 'wysiwyg-widgets'); } else { _e('Select a widget block', 'wysiwyg-widgets'); } ?></option>
				<?php foreach($posts as $p) { ?>
					<option value="<?php echo $p->ID; ?>" <?php selected($selected_widget_id, $p->ID); ?>><?php echo $p->post_title; ?></option>
				<?php } ?>
			</select>
		</p>

		<p>
			<label><input type="checkbox" id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" value="1" <?php checked($show_title, 1); ?> /> <?php _e("Show title?", "wysiwyg-widgets"); ?></label>
		</p>

		<p class="help"><?php printf(__('Manage your widget blocks %shere%s', 'wysiwyg-widgets'), '<a href="'. admin_url('edit.php?post_type=wysiwyg-widget') .'">', '</a>'); ?></p>
		<?php
	}

}
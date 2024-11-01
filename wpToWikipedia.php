<?php
/*
Plugin Name: wpToWikipedia
Plugin URI: https://wordpress.org/plugins/wpToWikipedia/
Description: Mostra un link alla pagina di wikipedia relativa al titolo del post
Version: 1.0.0
Author: Abe Wayer
Author URI: https://www.delvecchiolorenzo.com
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html*/


// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Creating the widget
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'wpb_widget',

// Widget name will appear in UI
__('wpToWikipedia', 'wpb_widget_domain'),

// Widget description
array( 'description' => __( 'Carca il titolo dell\'articolo su wikipedia', 'wpb_widget_domain' ), )
);
}

// Creating widget front-end

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );

// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
if (is_single()){
	echo "<script>jQuery('.widget_wpb_widget').show();</script>";
	global $post;
	$abe_title = $post->post_title;
	$abe_to_link=explode(" ", $abe_title);
	$abe_link="";
	foreach ($abe_to_link as $value) {
		$abe_link.="".$value."_";
	}
	$abe_link=substr_replace($abe_link, "", -1);
	echo "<a target='_blank' href='https://it.wikipedia.org/wiki/".$abe_link."'>Cerca $abe_title su Wikipedia</a>";
}
else{
	echo "<script>jQuery('.widget_wpb_widget').hide();</script>";
}
}



// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}

} // Class wpb_widget ends here

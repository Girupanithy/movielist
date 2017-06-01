<?php

/**
*Plugin Name:Movie and Song Listing
*Plugin URI:https://github.com/Girupanithy
*Description:This plugin allows you to add a simple Movie and Song listing it.
*Author:Giri
*Version:0.1
*/

if(!defined('ABSPATH')){
	exit;
}

function movie_post(){
	$singular='Movie';
	$plural='Movies';

	$labels=array(
          'name'=>$plural,
          'singular_name'=>$singular,
          'add_name'=>'Add New',
          'add_new_item'=>'Add New' . $singular,
          'edit'=>'Edit',
          'edit_item' =>'Edit' . $singular,
          'new_item' =>'New' . $singular,
          'view'=>'View' . $singular,
          'view_item'=>'View' . $singular,
          'search_item'=>'Search' . $plural,
          'parent'=>'Parent' . $singular,
          'not_found'=>'No' . $plural .'found',
          'not_found_in_trash'=>'No' . $plural .'in Trash'
		);
	$args =array(
          'labels' =>$labels,
          'public' =>true,
          'menu_position'=>10,
          'has_archive'=>true,
          'capability_type'=>'post',
          'map_meta_cap'=>true,
          'supports'=>array(
              'title',
              'editor',
              'custom-fields',
              'thumbnail'
          	)
		);
	register_post_type('movie',$args);
	$singular='Song';
	$plural='Songs';

	$labels=array(
          'name'=>$plural,
          'singular_name'=>$singular,
          'add_name'=>'Add New',
          'add_new_item'=>'Add New' . $singular,
          'edit'=>'Edit',
          'edit_item' =>'Edit' . $singular,
          'new_item' =>'New' . $singular,
          'view'=>'View' . $singular,
          'view_item'=>'View' . $singular,
          'search_item'=>'Search' . $plural,
          'parent'=>'Parent' . $singular,
          'not_found'=>'No' . $plural .'found',
          'not_found_in_trash'=>'No' . $plural .'in Trash'
		);
	$args =array(
          'labels' =>$labels,
          'public' =>true,
          'menu_position'=>10,
          'has_archive'=>true,
          'capability_type'=>'post',
          'map_meta_cap'=>true,
          'supports'=>array(
              'title',
              'editor',
              'custom-fields',
              'thumbnail'
          	)
		);
	register_post_type('song',$args);
}
add_action('init','movie_post');
add_action( 'admin_init', 'movie_collection' );
function movie_collection() {
    add_meta_box( 'movie_review_meta_box',
        'Movie Review Details',
        'display_movie_review_meta_box',
        'movie', 'normal', 'high'
    );
}
function display_movie_review_meta_box( $movie_review ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $movie_director = esc_html( get_post_meta( $movie_review->ID, 'movie_director', true ) );
    $cast_name = esc_html( get_post_meta( $movie_review->ID, 'cast_name', true ) );
    $movie_description = esc_html( get_post_meta( $movie_review->ID, 'movie_description', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Movie Director<font color="red">*</font></td>
            <td><input type="text" size="80" name="movie_review_director_name" value="<?php echo $movie_director; ?>" /></td>
        </tr>
         <tr>
            <td style="width: 100%">Cast<font color="red">*</font></td>
            <td><input type="text" size="80" name="movie_review_cast_name" value="<?php echo $cast_name; ?>" required /></td>
        </tr>
        <tr>
        	<td>Movie Description</td>
            <td><input type="text" size="80" name="movie_description" value="<?php echo $movie_description; ?>"/></td>
		</tr>
    </table>
    <?php
}
add_action( 'save_post', 'add_movie_review_fields',10,2);
function add_movie_review_fields( $movie_review_id, $movie_review ) {
    // Check post type for movie reviews
    if ( $movie_review->post_type == 'movie' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['movie_review_director_name'] ) && $_POST['movie_review_director_name'] != '' ) {
            update_post_meta( $movie_review_id, 'movie_director', $_POST['movie_review_director_name'] );
        }
        if ( isset( $_POST['movie_review_cast_name'] ) && $_POST['movie_review_cast_name'] != '' ) {
            update_post_meta( $movie_review_id, 'cast_name', $_POST['movie_review_cast_name'] );
        }
        if ( isset( $_POST['movie_description'] ) && $_POST['movie_description'] != '' ) {
            update_post_meta( $movie_review_id, 'movie_description', $_POST['movie_description'] );
        }

    }
}
add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'movie' ) {
        if ( is_single() ) {
            if ( $theme_file = locate_template( array ( 'list_template.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/list_template.php';
            }
        }
    }
    return $template_path;
}
add_action( 'admin_init', 'song_collection' );
function song_collection() {
    add_meta_box( 'song_meta_box',
        'Song Details',
        'display_song_meta_box',
        'song', 'normal', 'high'
    );
}
function display_song_meta_box( $song) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $song_composer = esc_html( get_post_meta( $song->ID, 'song_composer', true ) );
    $song_singer = esc_html( get_post_meta( $song->ID, 'song_singer', true ) );
    $song_file = esc_html( get_post_meta( $song->ID, 'song_file', true ) );
    ?>
    <table>
         <tr>
            <td>Composer<font color="red">*</font></td>
            <td><input type="text" size="80" name="song_composer" value="<?php echo $song_composer; ?>" /></td>
        </tr>
         <tr>
            <td>Singer<font color="red">*</font></td>
            <td><input type="text" size="80" name="song_singer" value="<?php echo $song_signer; ?>" /></td>
        </tr>
        <tr>
            <td>Song File</td>
            <form enctype="multipart/form-data" method="post">
            <td><input type="file" name="song_file" value="" size="25" /></td>
            </form>
        </tr>
        <tr>
            <td style="width: 150px">Movie Name</td>
            <td>
                <select name="song_director_name">

					<?php 

					$select_array = array();

					$args = array (
					    'post_type' => 'movie',
					);

					$query1 = new WP_Query( $args );

					while ( $query1->have_posts() ) {

					    $query1->the_post(); 
                         $movie_director= get_post_meta( $query1->post->ID, 'movie_director', true);
					    echo '<option value="">' . $movie_director. '</option>';

					}

					wp_reset_postdata();
					?>

               </select>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'save_post', 'add_song_fields', 10, 2 );
function add_song_fields( $song_id, $song) {
    // Check post type for movie reviews
    if ( $song->post_type == 'song' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['song_name'] ) && $_POST['song_name'] != '' ) {
            update_post_meta( $song_id, 'song_name', $_POST['song_name'] );
        }
        if ( isset( $_POST['song_composer'] ) && $_POST['song_composer'] != '' ) {
            update_post_meta( $song_id, 'song_composer', $_POST['song_composer'] );
        }
        if ( isset( $_POST['song_singer'] ) && $_POST['song_singer'] != '' ) {
            update_post_meta( $song_id, 'song_singer', $_POST['song_singer'] );
        }
        if(!empty($_FILES['song_file']['name'])) {
         
            // Use the WordPress API to upload the file
            $upload = wp_upload_bits($_FILES['song_file']['name'], null, file_get_contents($_FILES['song_file']['tmp_name']));
            if(isset($upload['error']) && $upload['error'] != 0) {
                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
            } else {
                add_post_meta($song_id, 'song_file', $upload);
                update_post_meta($song_id, 'song_file', $upload);     
            } // end if/else
 
        }
         
  }
}
function update_edit_form() {
    echo ' enctype="multipart/form-data"';
} // end update_edit_form
add_action('post_edit_form_tag', 'update_edit_form');
add_filter( 'template_include', 'includes_template_function', 1 );
function includes_template_function( $template_path ) {
    if ( get_post_type() == 'song' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'list_template.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/list_template.php';
            }
        }
    }
    return $template_path;
}

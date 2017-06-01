<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
 /*Template Name: New Template
 */
 
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'movie' );
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content"><?php the_content(); ?></div>
            <header class="entry-header">
 
                <div style="float: right; margin: 10px">
                    <?php the_post_thumbnail( array( 100, 100 ) ); ?>
                </div>

                <strong>Name of Movie: </strong><?php the_title(); ?><br />
                <strong>Director: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'movie_director', true ) ); ?>
                <br />
                <strong>Cast: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'cast_name', true ) ); ?>
                <br />
                <strong>Description: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'movie_description', true ) ); ?>
                <br />
        </header>
 
            <!-- Display movie review contents -->
        </article>
 
    <?php endwhile; ?>
    </div>
</div>
 <div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'song' );
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
 
                <div style="float: right; margin: 10px">
                    <?php the_post_thumbnail( array( 100, 100 ) ); ?>
                </div>
 
                <strong>Name of Song: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'song_name', true ) ); ?>
                <br />
                <strong>Composer: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'song_composer', true ) ); ?>
                <br />
                <strong>Singer: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'song_singer', true ) ); ?>
                <br />
                <strong>Playlist:</strong>
                <?php $img = get_post_meta(get_the_ID(), 'song_file', true); ?>
                <audio controls>
                   <source src="<?php echo $img['url']; ?>" type="audio/mpeg">
                Your browser does not support the audio element.
               </audio>

            </header>
 
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
 
    <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>


<?php
/**
Template Name: Custom PHP Zareen trial
 * The template for displaying standard pages
 *
 * @package Azuma
 */

get_header();

if ( in_array( 'edd-page', get_body_class() ) ) {
	$sidebar = 'edd';
} else {
	if ( function_exists( 'EDD' ) && get_theme_mod( 'edd_shortcode_sidebar' ) ) {
		if ( has_shortcode( $post->post_content, 'downloads') ) {
			$sidebar = 'edd';
		} else {
			$sidebar = 'page';
		}
	} else {
		$sidebar = 'page';
	}
}

if ( ! is_active_sidebar( 'azuma-sidebar-' . $sidebar ) ) {
	$page_full_width = ' full-width';
} else {
	$page_full_width = '';
}
?>

	<div id="primary" class="content-area<?php echo $page_full_width;?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>


<script src="https://maps.googleapis.com/maps/api/js?sensor=false">
</script>

<script type="text/javascript">
function addressclick(){
            var geocoder =  new google.maps.Geocoder();
    		geocoder.geocode({'address' : document.getElementById("address").value}, function(results, status) {
          	if (status == google.maps.GeocoderStatus.OK) {
            document.getElementById("lat").value = results[0].geometry.location.lat();
            document.getElementById("lng").value = results[0].geometry.location.lng();
            //submit form
            document.getElementById("Myform").submit();
         	 } else {
            alert("Bitte Korrekte Addresse eingeben!");
          }
        });
}
</script>

<input type="text" id="address" size="30" name="address"  placeholder="Standort des Artikels?"/>
<input id="btn" type="button" value="Gimme numbers" onclick="javascript: addressclick();"/>
<br>

<input type="text" id="lat" size="30" name="lat"/>
<input type="text" id="lng" size="30" name="long"/>


				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar( $sidebar ); ?>

<?php get_footer(); ?>
<?php
/**
Template Name: Custom PHP Rajat
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
          
            <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
                
th {
  display: table-cell;
  vertical-align: inherit;
  font-weight: bold;
  text-align: center;
}
                
td{
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.wrapper {
  display: inline-block;
}
</style>
<body onload="getLocation()">  
    

                
    
<script type="text/javascript">
    

    
    function getLocation(){
        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    }
    
    function showPosition(position){
        document.getElementById("lats").value=+position.coords.latitude;
        document.getElementById("longs").value=+position.coords.longitude;
        document.getElementById("radius").value=+document.getElementById("radiusSelect").value;
    }
    
            </script>
                    <div>
                    
            
            
            <form name ="form" actions="" method="post">
            
            <input type="hidden" name="lats" id="lats">
            <input type="hidden" name="longs" id="longs">
           <select id="radius" name="radius">
<option value="50" selected>50 kms</option>
<option value="40">40 kms</option>
<option value="30">30 kms</option>
<option value="20">20 kms</option>
<option value="10">10 kms</option>
</select>
                
                <button class="button" type="submit" name="subm" id="subm">Find Endangered Animal Near Me</button>
            
            </form>
                    </div>

        
            <?php
            global $wpdb;
                if(isset($_POST['subm'])){
                    $l1 = doubleval($_POST['lats']);
                    $l2 = doubleval($_POST['longs']);
                    $radius = $_POST["radius"];
                    //(isset($_POST["radius"])) ? $radius = $_POST["radius"] : $radius=50;
                   
                    
                    echo nl2br(str_replace(' ',"\n", $l1));
                    echo nl2br(str_replace(' ',"\n", $radius));
                    
                    $limit = $radius - 1;

                    
                    
// replace * by id, lat and long since you don't need other fields
$sql = "SELECT * FROM vic_animals";
$rows = $wpdb->get_results("SELECT VernacularName, ( 3959 * acos( cos( radians($l1) ) * cos( radians( Latitude ) ) * cos( radians( Longitude ) - radians($l2) ) + sin( radians($l1) ) * sin( radians( Latitude ) ) ) ) AS distance FROM vicanimalsview HAVING distance < $radius ORDER BY distance LIMIT 0 , $limit;"); 
$rowCount = $wpdb->num_rows;
                    echo nl2br(str_replace(' ',"\n", $rowCount));
                    if($rowCount > 0)
                    {
                        ?>
            <table class = "table table-hover">
                <tr>
                <th>Animal Name</th>
                <th>Distance in KM</th>
                </tr>

<?php foreach($rows as $value) { ?>

<tr>
<td><?php echo $value -> VernacularName; ?></td>
<td><?php echo doubleval($value -> distance); ?></td>
</tr>
<?php } ?>
</table>
        <script type="text/javascript">
  document.getElementById('radius').value = "<?php echo $radius;?>";
</script>
            <?php
                    }
                    else 
                    {
                        echo "There are no endangered animals in the specified radius. Please increase the radius :)";
                    }
                }
                        
            ?>
    




</body>
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
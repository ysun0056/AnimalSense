<?php
/**
Template Name: Custom Page PHP
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

<!-- Styling table -->            
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
            

<!-- Get location of user everytime page is loaded -->            
<body onload="getLocation()">  
                
    
    <script type="text/javascript">
    

        //this function will get location of user by asking for location access on page load
        function getLocation(){
            if (navigator.geolocation){
                // timeout at 60000 milliseconds (60 seconds)
                var options = {timeout:60000};
                navigator.geolocation.getCurrentPosition(showPosition, errorHandler, options);
            }
            else {
               alert("Sorry, browser does not support geolocation!");
            }
        }
    
        //call this function if location retrieved succeefully
        //prints latitude and longitude in hidden text boxes
        function showPosition(position){
            document.getElementById("lats").value=+position.coords.latitude;
            document.getElementById("longs").value=+position.coords.longitude;
            //document.getElementById("radius").value=+document.getElementById("radiusSelect").value;
        }
        
        //call this function in case of error
        function errorHandler(err) {
            if(err.code == 1) {
               alert("Error: Access is denied! Please allow access :)");
            } else if( err.code == 2) {
               alert("Error: Position is unavailable! Please refresh the page :)");
            }
        }
    
    </script>
    
<!-- Creating post function for text inputs and radius dropdown -->
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
    
<!-- Get value of input from hytml in php-->        
    <?php
        global $wpdb;
        if(isset($_POST['subm'])){
                    
            //store user location and radius 
            $l1 = doubleval($_POST['lats']);
            $l2 = doubleval($_POST['longs']);
            $radius = $_POST["radius"];
            //(isset($_POST["radius"])) ? $radius = $_POST["radius"] : $radius=50;                    
            $limit = $radius - 1;
                    
                    
            //Query in-built wordpress database to get name of animal and their respective distance from user location  
            $rows = $wpdb->get_results("SELECT VernacularName, ( 3959 * acos( cos( radians($l1) ) * cos( radians( Latitude ) ) * cos( radians( Longitude ) - radians($l2) ) + sin( radians($l1) ) * sin( radians( Latitude ) ) ) ) AS distance FROM vicanimalsview HAVING distance < $radius ORDER BY distance LIMIT 0 , $limit;");
                    
            //Get number of rows in the result
            $rowCount = $wpdb->num_rows;
            //Check if retrieved row is greater than 0 then display values in table
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
            <td><?php echo number_format((float)($value -> distance), 2, '.', ''); ?></td>
        </tr>
    <?php } ?>
    </table>
    <script type="text/javascript">
        //set value of select input as the selected one on form load
        document.getElementById('radius').value = "<?php echo $radius;?>";
    </script>
    <?php
            }
            else 
            {
            //Condition if no animal found
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
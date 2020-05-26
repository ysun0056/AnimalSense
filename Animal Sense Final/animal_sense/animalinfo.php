<?php
/**
Template Name: animal info
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

				<?php get_template_part( 'content', 'page' ); ?>

				
  <?php
  //code start 
  //query the data from database
  global $wpdb;
  $ID = $_GET['ID'];
  $rows = $wpdb->get_results ( "SELECT * FROM animal_images WHERE ID = $ID" );
  ?>


  <!--animal information page-->
	<!DOCTYPE html>
	<html>
	<head>

  <!--js plugin-->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
  integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
  crossorigin=""></script>
	
  <!--css style-->
  <style>
	table {
  		font-family: arial, border-collapse;
  		border-collapse: collapse;
	}

	td, th {
  		border: 1px solid #E3E6E2;
  		font-weight: 500;
  		text-align: left;
  		padding: 8px;
      vertical-align: top;
	}
  td{
    valign:top;
  }

	tr:nth-child(even) {
  		background-color: #E3E6E2;

	}
  #map {
    width:80%; 
    height:600px;
    margin:0 auto;
  }
	</style>
	</head>
	
  <!--animal information with name, destribution, image, and details-->
  <!--load map-->
  <body onload="setMap()">
	<?php foreach ($rows as $row) ?>
		
		<table width="200"> <td width="40%" align="right"><center><h1><?php echo $row-> AnimalName; ?></h1><br><img src='http://animalsense.tk/wp-content/uploads/2020/05/<?php echo $row-> image?>'></center></td>
		<td width="60%"><center><h1>Description </h1></center> <br> <?php echo $row-> description;?></td>
		</table>
		</br>
		<table border="1" width="300">
			<tr><td align="center"><p> Scientific Name</p></td><td align="left"><?php echo $row-> ScientificName;?>  </td></tr>
			<tr><td align="center"><p> Taxon Rank </p></td><td align="left"><?php echo $row-> TaxonRank;?></td></tr>
			<tr><td align="center"><p> Kingdom </p></td><td align="left"><?php echo $row-> Kingdom;?>  </td></tr>
			<tr><td align="center"><p> Phylum </p></td><td align="left"><?php echo $row-> Phylum;?>  </td></tr>
			<tr><td align="center"><p> Class </p></td><td align="left"><?php echo $row-> Class;?>  </td></tr>
			<tr><td align="center"><p> Family </p></td><td align="left"><?php echo $row-> Family;?>  </td></tr>
			<tr><td align="center"><p> Genus </p></td><td align="left"><?php echo $row-> Genus;?>  </td></tr>			
		</table>

		<p id = 'demo'></p>
		<div id="cover-spin"></div>
		</br>
		</br>
		<div id = "map"></div>
    
    <!--javascript function-->
    <script>
        
       var map;
       var markers = [];


       function setMap(){ //set the default map
         
         map = new L.Map('map'); 

                
      	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 18
        }).addTo(map);

      	map.attributionControl.setPrefix('');
        var australia = new L.LatLng(-27.833, 133.583); 
        map.setView(australia, 4);
         
        getLocation();//after the map setting run the function to get animal location

}
          
        function getLocation() { //get the animal location
          var url = window.location.search; 
         	var params = new URLSearchParams(url);
         	var number = parseInt(params.get("ID")); //get the ID of the dynamic url

          var searchUrl = '/queryData'; 
          downloadUrl(searchUrl, function(data) { 
          var xml = parseXml(data); 
          var markerNodes = xml.documentElement.getElementsByTagName("marker");

            for (var i = 0; i < markerNodes.length; i++) {
                var name = markerNodes[i].getAttribute("name");
                var id = parseInt(markerNodes[i].getAttribute("id"));
                var lat = parseFloat(markerNodes[i].getAttribute("lat"));
                var lng = parseFloat(markerNodes[i].getAttribute("lng"));
                var state = markerNodes[i].getAttribute("state");
                if (number == id){ //if the id of the url equal to animal id
                state = document.getElementById("animalState");
                var marker = L.marker([lat,lng]).addTo(map);

             		map.addLayer(marker);
             		markers.push(marker);
             		console.log('3')
             	}
             	else{
             			console.log('Error');
                	}
            }
            });
        }



		    function downloadUrl(url,callback) {
            console.log("I am in XML");
            var xmlhttp;
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

            xmlhttp.onreadystatechange = function() {
                console.log("In function");

                if (xmlhttp.readyState == 4) {
                    console.log("State 4");
                      var x = document.getElementById("cover-spin");

                    x.style.display = "none";
                  
                    xmlhttp.onreadystatechange = doNothing;
                    console.log(this.responseText);
                    callback(xmlhttp.responseText, xmlhttp.status);
                }
            };

            xmlhttp.open('GET', url, true);
            xmlhttp.send(null);

        }

          //native parsing function of the browser to create a valid XML Document
		      function parseXml(str) {
          if (window.ActiveXObject) {
            var doc = new ActiveXObject('Microsoft.XMLDOM');
            doc.loadXML(str);
            return doc;
          } else if (window.DOMParser) {
            return (new DOMParser).parseFromString(str, 'text/xml');
          }
       }

       function doNothing() {}

  </script>
 	</br>
 	</br>
	</body>
</html>
<!--code end-->

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

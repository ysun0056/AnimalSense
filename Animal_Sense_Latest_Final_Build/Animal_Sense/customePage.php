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
         
<style> 
    
/*Style for screen loader */
    
#cover-spin {
    content:'loading..';
    position:absolute;
    left:48%;top:40%;
    width:40px;height:40px;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    border-style:solid;
    border-color:black;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
}
        
@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}
   
/* Add padding to map and select box*/
#selectBox {
    padding-bottom: 30px;
}
        
#googleMap {
    padding-bottom: 40px;
}
   
/* Change background color*/
body {
    background-color: #f6f6f6;    
}

</style> 


            

<!-- Get location of user everytime page is loaded -->            
<body onload="getLocation()">  
    
<div id="cover-spin"></div>
    
<!-- Creating drop-down for selecting radius -->
<div id="selectBox">
    <select id="radius" name="radius">
        <option value="50" selected>50 kms</option>
        <option value="40">40 kms</option>
        <option value="30">30 kms</option>
        <option value="20">20 kms</option>
        <option value="10">10 kms</option>
    </select>
                
    <input type="button" id="searchButton" value="Search Animals" />

</div>

<!-- Division to show map-->
<div id="googleMap" style="width:100%;height:600px;"></div>
    
    
<script type="text/javascript">
    var map;
    var infoWindow;
    var markers = [];
    var lat;
    var lng;
    var geocoder;
    
    //this function will load google map with melbourne as center
    function myMap() {
        var mapProp= {
            center:new google.maps.LatLng(-37.840935, 144.946457),
            zoom:5,
        };
        map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        infoWindow = new google.maps.InfoWindow();
        geocoder = new google.maps.Geocoder();    
        
        searchButton = document.getElementById("searchButton").onclick = radiusChangeSearchAnimals;
        
                        
    }

    //this function will get location of user by asking for location access on page load
    function getLocation(){
        if (navigator.geolocation){
            var options = {timeout:60000};
            navigator.geolocation.getCurrentPosition(showPosition, errorHandler, options);
        }
        else {
           alert("Sorry, browser does not support geolocation!");
        }
    }
    
    //call this function if location retrieved succeefully
    function showPosition(position){
        lat=position.coords.latitude;
        lng=position.coords.longitude;
        var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            
        var marker = new google.maps.Marker({position: coords});

        marker.setMap(map); 
                        
        searchLocationsNear(position);
    }
        
    //call this function in case of error
    function errorHandler(err) {
        if(err.code == 1) {
           alert("Error: Access is denied! Please allow access :)");
        } else if( err.code == 2) {
           alert("Error: Position is unavailable! Please refresh the page :)");
        }
    }
    
    
    //function to be called on radius change and button click and searches for animals near user location
    function radiusChangeSearchAnimals() {
        clearLocations();
        var x = document.getElementById("cover-spin");
        if (x.style.display === "none") {
            x.style.display = "block";
        }
        else{
            x.style.display = "none";
        }

        var radius = document.getElementById('radius').value;
        var searchUrl = '/example?lat=' + lat + '&lng=' + lng + '&radius=' + radius;
        downloadUrl(searchUrl, function(data) {
            var xml = parseXml(data);
            var markerNodes = xml.documentElement.getElementsByTagName("marker");
            var bounds = new google.maps.LatLngBounds();
            if(markerNodes.length == 0)
            {
                alert("There are no Endangered Animals in the specified radius");
            }
            else{
                for (var i = 0; i < markerNodes.length; i++) {
                    var name = markerNodes[i].getAttribute("name");
                    var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                    var image = markerNodes[i].getAttribute("image");
                    var year = parseInt(markerNodes[i].getAttribute("year"));
                    var latlng = new google.maps.LatLng(
                        parseFloat(markerNodes[i].getAttribute("lat")),
                        parseFloat(markerNodes[i].getAttribute("lng")));

                    createMarker(latlng, name, distance, year, image);
                    bounds.extend(latlng);
                }
                map.fitBounds(bounds);
            }
        });
    }
        
    //this function searches for animal location near the position mentioned in the parameters
    function searchLocationsNear(position) {
        clearLocations();

        var radius = document.getElementById('radius').value;
        var searchUrl = '/example?lat=' + position.coords.latitude + '&lng=' + position.coords.longitude + '&radius=' + radius;
        downloadUrl(searchUrl, function(data) {
            var xml = parseXml(data);
            var markerNodes = xml.documentElement.getElementsByTagName("marker");
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0; i < markerNodes.length; i++) {
                var name = markerNodes[i].getAttribute("name");
                var distance = parseFloat(markerNodes[i].getAttribute("distance"));
                var image = markerNodes[i].getAttribute("image");
                var add = markerNodes[i].getAttribute("add");
                var year = parseInt(markerNodes[i].getAttribute("year"));
                var latlng = new google.maps.LatLng(
                    parseFloat(markerNodes[i].getAttribute("lat")),
                    parseFloat(markerNodes[i].getAttribute("lng")));

                //createOption(name, distance, i);
                createMarker(latlng, name, distance, year, image, add);
                bounds.extend(latlng);
            }
            map.fitBounds(bounds);
        });
    }
    
    //Create map markers with pop-up
    function createMarker(latlng, name, distance, year, image, add) {
        var html = '<div id="content">'+
		'<h3 id="firstHeading">'+name+'</h3>'+
		'<div id="bodyContent">'+ '<div><img src="http://animalsense.tk/wp-content/uploads/2020/04/'+image+' "width="200" height="90"/></div>' +
		'<br><b>Last Seen:</b>'+year+'<br><b>Location:</b>'+add+'<br><b>Distance:</b>'+Number.parseFloat(distance).toFixed(2)+' KM</p></div>'+
		'</div>'+
		'</div>'
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            animation:google.maps.Animation.BOUNCE
        });
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });
        markers.push(marker);
    }
    
    //clears all markers from the map
    function clearLocations() {
        infoWindow.close();
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers.length = 0;
    }

    //function to call php function with database query and read xml
    function downloadUrl(url,callback) {
        var xmlhttp;
        
        //Checking type of browser
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
                //hide loading spinner after query execution
                var x = document.getElementById("cover-spin");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    }
                    else{
                        x.style.display = "none";
                    }
                xmlhttp.onreadystatechange = doNothing;
                callback(xmlhttp.responseText, xmlhttp.status);
            }
        };

        xmlhttp.open('GET', url, true);
        xmlhttp.send(null);

    }
        
    //function to parse xml output from database php file
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
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiJJysB6cGyZrznHoKBaf2kl-76AGosHM&callback=myMap"></script-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDk8Jx74FP4b6rzsynfoa1Czdfpkxc_UlE&callback=myMap&sensor=false"></script> 


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
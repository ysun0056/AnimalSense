<?php
/**
Template Name: Custom Page PHP Animal Distribution
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

<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
 
    <link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.css" />
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.css" />
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/MarkerCluster.Default.css" />
 
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn.leafletjs.com/leaflet/v0.7.7/leaflet.js'></script>
    <script type='text/javascript' src='http://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/0.4.0/leaflet.markercluster.js'></script>

    
<!-- Styling elements -->            
<style> 

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
        
        
body {
    background-color: #f6f6f6;    
}
        
.image-icon img {
    height: 50px !important;
    width: 50px !important;
    border-radius: 50%;
    border: solid;
    border-color: black;
}

#filterBox{
    margin: 0 auto;
    padding-bottom: 25px;
    width: 150%;
}
        
#map{
    margin: 0 auto;
    width:100%;
    height:800px;
    padding: 25px;
}
        
.quote{
  font-size: 2em;
  width:100%;
  margin:80px auto;
  color: #555555;
  padding:1.2em 30px 1.2em 75px;
  border-left:8px solid #78C0A8 ;
  border-right:8px solid #78C0A8 ;
  line-height:1.5;
  position: relative;
  background:#EDEDED;
}

.quote p {
    font-family: "Palatino Linotype","Book Antiqua",Palatino,serif;
    font-style: bold;
    font-size: 40px;
    font-weight: 700px;
    text-align: center;
}

</style> 
</head>
            
       
<div class="quote">
    <p>There are more than 700 endangered animals in Australia!! <br> Explore our map to find more about these animals!!</p>
</div>
    
<div class = "fliter">
    <form  id = "filterForm" class = "filterForm" action=""  method="POST">  
        <select id="state" name="state">
            <option value="All State" <?php echo (isset($_POST['state']) && $_POST['state'] == 'All State') ? 'selected="selected"' : ''; ?>>All State</option> 
            <option value="Victoria" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Victoria') ? 'selected="selected"' : ''; ?>>Victoria</option> 
            <option value="New South Wales" <?php echo (isset($_POST['state']) && $_POST['state'] == 'New South Wales') ? 'selected="selected"' : ''; ?>>New South Wales</option> 
            <option value="Queensland" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Queensland') ? 'selected="selected"' : ''; ?>>Queensland</option> 
            <option value="Tasmania" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Tasmania') ? 'selected="selected"' : ''; ?>>Tasmania</option> 
            <option value="Australian Capital Territory" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Australian Capital Territory') ? 'selected="selected"' : ''; ?>>Australian Capital Territory</option> 
            <option value="South Australia" <?php echo (isset($_POST['state']) && $_POST['state'] == 'South Australia') ? 'selected="selected"' : ''; ?>>South Australia</option> 
            <option value="Western Australia" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Western Australia') ? 'selected="selected"' : ''; ?>>Western Australia</option> 
            <option value="Northern Territory" <?php echo (isset($_POST['state']) && $_POST['state'] == 'Northern Territory') ? 'selected="selected"' : ''; ?>>Northern Territory</option> 
        </select>

        <select id="animalClass" name="animalClass">
            <!-- Added in javascript-->
        </select>
        <button class="button" type="submit" name="findAnimal" id="findAnimal">Filter</button>
    </form>
<!--input type='button' value='Find' class="findAnimal", id="findAnimal"-->
</div>

<div id="cover-spin"></div>
       
<div id = "map"></div>
<script>
var markers = [];
var map;
var markerClusters;

var countryLists = new Array(8) ;
    countryLists["All State"] = ["All Class", "Mammalia", "Amphibia", "Aves", "Reptilia", "Insecta", "Malacostraca", "Gastropoda", "Chondrichthyes", "Actinopterygii"]; 
    countryLists["Victoria"] = ["Mammalia"]; 
    countryLists["South Australia"] = ["Mammalia"]; 
    countryLists["Tasmania"] = ["Mammalia"]; 
    countryLists["Queensland"]= ["All Class", "Mammalia", "Amphibia", "Aves", "Reptilia", "Insecta", "Malacostraca", "Gastropoda", "Chondrichthyes", "Actinopterygii"]; 
    countryLists["New South Wales"] = ["Mammalia"];
    countryLists["Australian Capital Territory"] = ["Mammalia"];
    countryLists["Western Australia"] = ["Mammalia"];
    countryLists["Northern Territory"] = ["Mammalia"];
        
function removeAllOptions(sel) {
    var len, par;
    
    len = sel.options.length;
    for (var i=len; i; i--) {
        par = sel.options[i-1].parentNode;
        par.removeChild( sel.options[i-1] );
    }
}
        
function appendDataToSelect(stateName, rel){
    cList = countryLists[stateName];
            

    var f = document.createDocumentFragment();
    var o;

    for (var i=0; i<cList.length; i++) { 
        o = document.createElement('option');
        o.appendChild( document.createTextNode( cList[i] ) );
            
        o.value = cList[i];
        f.appendChild(o);
    }
    rel.appendChild(f);
}
        
// anonymous function assigned to onchange event of controlling select list
document.forms['filterForm'].elements['state'].onchange = function(e) {
    // name of associated select list
    var relName = 'animalClass';
    
    // reference to associated select list 
    var relList = this.form.elements[ relName ];
    
 		var stateElement = document.getElementById("state");
        var stateName= stateElement.options[stateElement.selectedIndex].text;
    
    
    // remove current option elements
    removeAllOptions(relList);
    
    // call function to add optgroup/option elements
    // pass reference to associated select list and data for new options
    appendDataToSelect(stateName, relList);
};
        



window.onload = function() {
    var form = document.forms['filterForm'];
    
    // name of associated select list
    var relName = 'animalClass';
    // reference to associated select list
    var rel = form.elements[ relName ];
    
    var stateElement = document.getElementById("state");
    var stateName= stateElement.options[stateElement.selectedIndex].text;
    
    appendDataToSelect(stateName, rel);
    
    if (localStorage.AniClass) {
        //console.log("Checking class of local storage"+localStorage.AniClass);
    var sel = document.getElementById("animalClass");
        for(var i = 0, j = sel.options.length; i < j; ++i) {
            if(sel.options[i].innerHTML === localStorage.AniClass) {
                sel.selectedIndex = i;
                break;
            }
        }
    }   
  
    map = new L.Map('map');                       
                
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
        maxZoom: 18
    }).addTo(map);
    map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.

    var australia = new L.LatLng(-27.833, 133.583); 
    map.setView(australia, 5);
                    
    markerClusters = L.markerClusterGroup();         
    getAnimalLocation();
                    
    var filterButton = document.getElementById("findAnimal");
    filterButton.addEventListener('click', function(){
        getAnimalLocation();
    });  
};
    
//initializing map
function init() {
          
                    
}

//gets location of animal from database
function getAnimalLocation() {
    clearLocations();
        
    var x = document.getElementById("cover-spin");
    x.style.display = "block";
        
    var stateElement = document.getElementById("state");
    var stateName= stateElement.options[stateElement.selectedIndex].text;
    var classElement = document.getElementById("animalClass");
    var className= classElement.options[classElement.selectedIndex].text;
    localStorage.AniClass= className;
    var searchUrl = '/animalLocation?state=' + stateName + '&class=' + className;
    
    //queries database, reads xml file and puts markers on map
    downloadUrl(searchUrl, function(data) {
        var xml = parseXml(data);
        var markerNodes = xml.documentElement.getElementsByTagName("marker");
        var bounds = L.latLngBounds();
        if (markerNodes.length == 0)
        {
            alert("No endangered animals of class "+className+" found in "+stateName);
        }

        for (var i = 0; i < markerNodes.length; i++) {
            var name = markerNodes[i].getAttribute("name");
            var image = markerNodes[i].getAttribute("image");
            var year = parseInt(markerNodes[i].getAttribute("year"));
            var id = parseInt(markerNodes[i].getAttribute("id"));
            var lat = parseFloat(markerNodes[i].getAttribute("lat"));
            var lng = parseFloat(markerNodes[i].getAttribute("lng"));
            var address = markerNodes[i].getAttribute("add");

            var html = '<div id="content">'+
		      '<a href="/animal-information?ID='+id+'"><h3 id="firstHeading">'+name+'</h3></a>'+
		      '<div id="bodyContent">'+ '<div><img src="http://animalsense.tk/wp-content/uploads/2020/05/'+image+' "width="200" height="90"/></div>' +
		      '<div><p><br><b>Last Seen:</b>'+year+'<br><b>Location:</b>'+address+'</p></div>'+
		      '</div>'+
		      '</div>';
            
            var img = '<img src="http://animalsense.tk/wp-content/uploads/2020/05/'+image+' "/>';
            
            var iconOptions = {
                html: img,
                className: 'image-icon',
                iconSize: [50, 50]
            };
            
            var marker = new L.Marker([lat, lng], {
                icon: L.divIcon({
                    html: img,
                    // Specify a class name we can refer to in CSS.
                    className: 'image-icon',
                    // Set a markers width and height.
                    iconSize: [50, 50]
                }) 
            });
             
         
            marker.bindPopup(html);
            markerClusters.addLayer(marker);
            markers.push(marker);
                
        }
        map.addLayer(markerClusters);
        var group = new L.featureGroup(markers);

        map.fitBounds(group.getBounds());
    });
}
          
//Clear markers location        
function clearLocations() {
    markerClusters.clearLayers();
    markers.length = 0;
}

function downloadUrl(url,callback) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4) {
                    console.log("State 4");
                    var x = document.getElementById("cover-spin");
                    x.style.display = "none";
                    xmlhttp.onreadystatechange = doNothing;

                    callback(xmlhttp.responseText, xmlhttp.status);
                }
    };

    xmlhttp.open('GET', url, true);
    xmlhttp.send(null);
}
        
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

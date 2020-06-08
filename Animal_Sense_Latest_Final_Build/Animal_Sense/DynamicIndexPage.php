<?php
/**
Template Name: dynamic index page
 * The template for displaying standard pages
 *
 * @package Azuma
 */

/*
$dbc = mysqli_connect('localhost', 'root', 'dcbQt6v55qgs0', 'bitnami_wordpress' ) or die ("Bad Connect". mysqli_connect_error() );
echo "Success";*/

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

	<head>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
  -->
		
	<style>
	.tb {
  		font-family: arial, border-collapse;
  		border-collapse: collapse;
  		table-layout: auto;
  		width: 100%;
	}


	.tb td tr{
  		border: 1px solid #E3E6E2;
  		text-align: center;
  		padding-top: 30px;
  		padding-bottom:20px; 
  		font-size: 23px;
  		min-width: 30%;
  		width:100px;
	}
	.search{
		width:60%;
	}


	.animalImage{
		width: 300px;
		height: 200px;
	}
	.button {
		color:white;	
	}
	.button:hover{
  	background-color: #AEC2AF;
  	color: black;
  	transition: .5s;
  	cursor: pointer;}

    body {
  font-family: Arial, Helvetica, sans-serif;
}
		
/* Zoom In #1 */
		
.column {
	margin: 0 30px 0;
	padding: 0;
}
.column:last-child {
	padding-bottom: 0px;
}
.column::after {
	content: '';
	clear: both;
	display: block;
}
.column div {
	position: relative;
	float: center; 
	width: 300px; 
	height: 200px;
	margin: 0 0 0 0px;
	padding: 0;
}
.column div:first-child {
	margin-left: 0;
}
.column div span {
	position: absolute;
	bottom: -20px;
	left: 0;
	z-index: -1;
	display: block;
	width: 0px;   /**/
	margin: 0;
	padding: 0;
	color: #444;
	font-size: 18px;
	text-decoration: none;
	text-align: center;
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
	opacity: 0;
}
figure {
	width: 300px; 
	height: 200px;
	margin: 0;
	padding: 0;
	background: #fff;
	overflow: hidden;
}
		
figure:hover+span {
	bottom: -36px;
	opacity: 1;
}		

.hover01 figure img {
	-webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
		
.hover01 figure:hover img {
	-webkit-transform: scale(1.3);
	transform: scale(1.3);
}

	/* Search Box */
	
div.searchable {
    width: 500px;
    float: center;
    margin: 0 0px;
}

.searchable input {
    width: 100%;
    height: 50px;
    font-size: 18px;
    padding: 10px;
    -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
    -moz-box-sizing: border-box; /* Firefox, other Gecko */
    box-sizing: border-box; /* Opera/IE 8+ */
    display: block;
    font-weight: 400;
    line-height: 1.6;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    background: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E") no-repeat right .75rem center/8px 10px;
}

.searchable ul {
  	display:none;
    list-style-type: none;
    background-color: #fff;
    border-radius: 0 0 5px 5px;
    border: 1px solid #add8e6;
    border-top: none;
    max-height: 180px;
    margin: 0;
    overflow-y: scroll;
    overflow-x: hidden;
    padding: 0;
	width:500px;
	position: absolute;
	z-index: 3;
}

.searchable ul li {
    padding: 7px 9px;
    border-bottom: 1px solid #e1e1e1;
    cursor: pointer;
    color: #6e6e6e;
}

.searchable ul li.selected {
    background-color: #e8e8e8;
    color: #333;
}
	
  .filter{
  display: -webkit-box;  /* OLD - iOS 6-, Safari 3.1-6, BB7 */
  display: -ms-flexbox;  /* TWEENER - IE 10 */
  display: -webkit-flex; /* NEW - Safari 6.1+. iOS 7.1+, BB10 */
  display: flex;         /* NEW, Spec - Firefox, Chrome, Opera */
  
  justify-content: center;
  align-items: center;
            
        }
        
</style>
	</head>
		
	<body>
		<center>
	
	<tr>
	<td class = "searchBar" width = "100%"> 
			
		<div class="searchable">
        <input id="seek" type="text" placeholder="Search Animals" type="text" value="<?php if (!empty($_GET['value'])){echo $_GET['value']; }?>" onkeyup="filterFunction(this,event)">
   		 <ul>
		     
				<?php 
				$options = $wpdb->get_results ( "SELECT * FROM animal_images");
				foreach ( $options as $opt )
				{ ?>	
				<li>	<p style="font-family:Arial; font-size:120%;"><?php echo $opt->AnimalName; ?></p> </li>
         	 <?php } ?>
		      </ul>
		</div>
		</td>
	</tr>
	
		<br>
		
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
    <script>
    document.getElementById('animalClass').value = "<?php if(isset($_POST['class'])){echo $_POST['class'];} elseif(!empty($_GET['class'])){echo $_GET['class'];}else{echo "All Class";}?>";
    </script>
    <button class="button" type="submit" name="findAnimal" id="findAnimal">Filter</button>
	</form> 
	<!--input type='button' value='Find' class="findAnimal", id="findAnimal"-->
	</div>
			</center>
<br>

<?php
global $wpdb;
global $result; 
$ID = $_GET['ID']; 
if(isset($_POST['findAnimal'])){
    $state = $_POST['state'];
    $class = $_POST['animalClass'];
    //default loading without any search for animal name when filter is set
    if (empty($ID)){
    if ($state == "All State") {
        if ($class == "All Class")
        {
            $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName; ");
            $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName; ");
        }
        else
        {
            $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' ;");
            $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' ;");
        }
    }
    else{
        if ($class == "All Class")
        {
            $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' ;");
            $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' ;");
        
        }
        else
        {
            $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class' ;");
            $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class';");
        }
    }
    }
    else{
        //search for animals with name like ID with filter set
        		if ($state == "All State") {
            if ($class == "All Class")
            {
                $result = $wpdb->get_results ( "SELECT * FROM animal_images WHERE AnimalName like '%$ID%';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(*) FROM animal_images WHERE AnimalName like '%$ID%' ");
            }
            else
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' AND y.AnimalName like '%$ID%';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' AND y.AnimalName like '%$ID%' ;");
            }
        }
        else{
            if ($class == "All Class")
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND y.AnimalName like '%$ID%' ;");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND y.AnimalName like '%$ID%';");
        
            }
            else
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class' AND y.AnimalName like '%$ID%';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class' AND y.AnimalName like '%$ID%';");
            }
        }
    }
}
else {
    //no filter post function and no specific animal name
    //load with the existing select values
   if (empty($ID))
    {
       if(empty($_GET['state']))
       {
            $result = $wpdb->get_results ( "SELECT * FROM animal_images;");
            $total_rows=  $wpdb->get_var("SELECT COUNT(*) FROM animal_images");
       }
       else
       {
           $state = $_GET['state'];
    	   $class = $_GET['class'];
		  if ($state == "All State") {
            if ($class == "All Class")
            {
                $result = $wpdb->get_results ( "SELECT * FROM animal_images;");
                $total_rows=  $wpdb->get_var("SELECT COUNT(*) FROM animal_images;");
            }
            else
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' ;");
            }
        }
        else{
            if ($class == "All Class")
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state';");
        
            }
            else
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class';");
            }
        }
       }
    }
    else{
        //ID specified with state and class filters
   		 $state = $_GET['state'];
    	 $class = $_GET['class'];
		if ($state == "All State") {
            if ($class == "All Class")
            {
                $result = $wpdb->get_results ( "SELECT * FROM animal_images WHERE AnimalName like '%$ID%';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(*) FROM animal_images WHERE AnimalName like '%$ID%' ");
            }
            else
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' AND y.AnimalName like '%$ID%';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class' AND y.AnimalName like '%$ID%' ;");
            }
        }
        else{
            if ($class == "All Class")
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND y.AnimalName like '%$ID%' ;");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND y.AnimalName like '%$ID%';");
        
            }
            else
            {
                $result = $wpdb->get_results("SELECT DISTINCT x.VernacularName as AnimalName, y.image as image, y.ID as ID FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class' AND y.AnimalName like '%$ID%';");
                $total_rows=  $wpdb->get_var("SELECT COUNT(DISTINCT(x.VernacularName)) FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class' AND y.AnimalName like '%$ID%';");
            }
        }
    
}
}


?>
<!--display results in grid format-->
<table id="tb" class = "tb">
<?php
 $i=0;
    if($total_rows == 0)
    {
       echo "No endangered animals found of class ".$class." in state ".$state."!";

    }

 foreach ( $result as $print ) {
  if ($i%3==0){
  ?>  
    <tr>
     <?php 
  				}
		?>
		
          <td>
			  <center>
			    <a href='/animal-information?ID= <?php echo $print->ID; ?>'> 
		         
					<div class="hover01 column">
				
					 <div>
			   <figure>
				   
       			 <img id = "animalImage" class = "animalImage" src='http://animalsense.tk/wp-content/uploads/2020/05/<?php echo $print->image; ?>'/>
				 
					</figure>		
						
					  </div>
					
					</div>
				</a>     
					<br> 
					<p id = "animalName" style="font-family:Arial; font-size:150%;"><?php echo $print->AnimalName; ?></p>
			  </center></td>
  
  		<?php
   		if($i%3==2)
    	{
      	?> </tr>
  		<?php
    		}
       		$i++;
   			} ?>
		</table>
		
		
	
		 
	<script> 
    //search by entering animal name
	function filterFunction(that, event) {
    let container, input, filter, li, input_val;
    container = $(that).closest(".searchable");
    input_val = container.find("input").val().toUpperCase();

    if (["ArrowDown", "ArrowUp", "Enter"].indexOf(event.key) != -1) {
        keyControl(event, container)
    } else {
        li = container.find("ul li");
        li.each(function (i, obj) {
            if ($(this).text().toUpperCase().indexOf(input_val) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        container.find("ul li").removeClass("selected");
        setTimeout(function () {
            container.find("ul li:visible").first().addClass("selected");
        }, 100)
    }
}

//key control actions for animal name list
function keyControl(e, container) {
    if (e.key == "ArrowDown") {
        if (container.find("ul li").hasClass("selected")) {
            if (container.find("ul li:visible").index(container.find("ul li.selected")) + 1 < container.find("ul li:visible").length) {
                container.find("ul li.selected").removeClass("selected").nextAll().not('[style*="display: none"]').first().addClass("selected");
            }

        } else {
            container.find("ul li:first-child").addClass("selected");
        }

    } else if (e.key == "ArrowUp") {

        if (container.find("ul li:visible").index(container.find("ul li.selected")) > 0) {
            container.find("ul li.selected").removeClass("selected").prevAll().not('[style*="display: none"]').first().addClass("selected");
        }
		
    } else if (e.key == "Enter") {
        container.find("input").val(container.find("ul li.selected").text()).blur();
        
        onSelect(container.find("ul li.selected").text())
    }

    container.find("ul li.selected")[0].scrollIntoView({
        behavior: "smooth",
    });
}

function onSelect(val) {
  alert(val)
}

$(".searchable input").focus(function () {
    $(this).closest(".searchable").find("ul").show();
    $(this).closest(".searchable").find("ul li").show();
});
$(".searchable input").blur(function () {
    let that = this;
    setTimeout(function () {
        $(that).closest(".searchable").find("ul").hide();
    }, 300);
});
        
        
$("#seek").on("keyup",function(){
    var value = $(this).val();
    var searchValue=value.toLowerCase();
    console.log("value entered"+searchValue);
    var stateElement = document.getElementById("state");
    var stateName= stateElement.options[stateElement.selectedIndex].text;
    var classElement = document.getElementById("animalClass");
    var className= classElement.options[classElement.selectedIndex].text;
    localStorage.AniClass= className;
    window.location.href='http://www.animalsense.tk/endangered-animal/?ID='+searchValue.trim()+'&value='+value+'&state='+stateName+'&class='+className;

 });
		
$(document).on('click','.searchable ul li', function () {
	$(this).closest(".searchable").find("input").val($(this).text()).blur();
    var value = $("#seek").val();
    
    var stateElement = document.getElementById("state");
    var stateName= stateElement.options[stateElement.selectedIndex].text;
    var classElement = document.getElementById("animalClass");
    var className= classElement.options[classElement.selectedIndex].text;
    localStorage.AniClass= className;
	
	window.location.href='http://www.animalsense.tk/endangered-animal/?ID='+$("#seek").val().trim().toLowerCase()+'&value='+value+'&state='+stateName+'&class='+className;
	
 });	

$(".searchable ul li").hover(function () {
    $(this).closest(".searchable").find("ul li.selected").removeClass("selected");
    $(this).addClass("selected");
});

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
        
function appendDataToSelect(stateName, rel)
        {
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

$(document).ready(function(){
  			 $("#findAnimal").click(function(){
     		         var classElement = document.getElementById("animalClass");
                    var className= classElement.options[classElement.selectedIndex].text;
                    localStorage.AniClass= className;
  		});
});
	

window.onload = function() {
        // name of associated select list
    var form = document.forms['filterForm'];
    var relName = 'animalClass';
    // reference to associated select list
    var rel = form.elements[ relName ];
    
    var stateElement = document.getElementById("state");
    var stateName= stateElement.options[stateElement.selectedIndex].text;
    
    appendDataToSelect(stateName, rel);
    document.getElementById('state').value = "<?php if(isset($_POST['state'])){echo $_POST['state'];} elseif(!empty($_GET['state'])){echo $_GET['state'];}else{echo "All State";}?>";
    document.getElementById('animalClass').value = "<?php if(isset($_POST['class'])){echo $_POST['class'];} elseif(!empty($_GET['class'])){echo $_GET['class'];}else{echo "All Class";}?>";

    select = document.getElementById("animalClass");

    if (localStorage.AniClass) {
        //console.log("Checking class of local storage"+localStorage.AniClass);
        var sel = document.getElementById('animalClass');
        for(var i = 0, j = sel.options.length; i < j; ++i) {
            if(sel.options[i].innerHTML === localStorage.AniClass) {
                sel.selectedIndex = i;
                break;
            }
        }
    }   

};



function downloadUrl(url,callback) {
            var xmlhttp;
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
            //var request = window.ActiveXObject ?
              //  new ActiveXObject('Microsoft.XMLHTTP') :
            //new XMLHttpRequest;

            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4) {
                    xmlhttp.onreadystatechange = doNothing;
                    console.log(this.responseText);
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
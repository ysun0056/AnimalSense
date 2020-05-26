<?php
/**
Template Name: IndexTesting page
 * The template for displaying standard pages
 *
 * @package Azuma
 */

/*
$dbc = mysqli_connect('localhost', 'root', 'dcbQt6v55qgs0', 'bitnami_wordpress' ) or die ("Bad Connect". mysqli_connect_error() );
echo "Success";

//global $wpdb;

//$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM wp_users" );
//echo "<p>User count is {$user_count}</p>";

//$rowscount = $wpdb->get_var( "SELECT COUNT(*) FROM vic_animals");
//echo "<p>The number of rows in posts table are: {$rowscount}</p>";

//$rows= $wpdb->get_results( "SELECT * FROM animal_images" );

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
<?php
	/*Pagination class*/		
		
/**
 * semicolonworld is a programming blog. Our mission is to provide the best online resources on programming and web development.
 *
 * This Pagination class helps to integrate ajax pagination in PHP.
 *
 * @class        Pagination
 * @author        semicolonworld
 * @link        http://www.semicolonworld.com
 * @contact        http://www.semicolonworld.com/contact-us
 * @version        1.0
 */
class Pagination{
    var $baseURL        = '';
    var $totalRows      = '';
    var $perPage         = 10;
    var $numLinks        =  3;
    var $currentPage    =  0;
    var $firstLink       = '&lsaquo; First';
    var $nextLink        = '&gt;';
    var $prevLink        = '&lt;';
    var $lastLink        = 'Last &rsaquo;';
    var $fullTagOpen    = '<div class="pagination">';
    var $fullTagClose    = '</div>';
    var $firstTagOpen    = '';
    var $firstTagClose    = '&nbsp;';
    var $lastTagOpen    = '&nbsp;';
    var $lastTagClose    = '';
    var $curTagOpen        = '&nbsp;<b>';
    var $curTagClose    = '</b>';
    var $nextTagOpen    = '&nbsp;';
    var $nextTagClose    = '&nbsp;';
    var $prevTagOpen    = '&nbsp;';
    var $prevTagClose    = '';
    var $numTagOpen        = '&nbsp;';
    var $numTagClose    = '';
    var $anchorClass    = '';
    var $showCount      = true;
    var $currentOffset    = 0;
    var $contentDiv     = '';
    var $additionalParam= '';
    var $link_func      = '';
    
    function __construct($params = array()){
        if (count($params) > 0){
            $this->initialize($params);        
        }
        
        if ($this->anchorClass != ''){
            $this->anchorClass = 'class="'.$this->anchorClass.'" ';
        }    
    }
    
    function initialize($params = array()){
        if (count($params) > 0){
            foreach ($params as $key => $val){
                if (isset($this->$key)){
                    $this->$key = $val;
                }
            }        
        }
    }
    
    /**
     * Generate the pagination links
     */    
    function createLinks(){ 
        // If total number of rows is zero, do not need to continue
        if ($this->totalRows == 0 OR $this->perPage == 0){
           return '';
        }

        // Calculate the total number of pages
        $numPages = ceil($this->totalRows / $this->perPage);

        // Is there only one page? will not need to continue
        if ($numPages == 1){
            if ($this->showCount){
                $info = 'Showing : ' . $this->totalRows;
                return $info;
            }else{
                return '';
            }
        }

        // Determine the current page    
        if ( ! is_numeric($this->currentPage)){
            $this->currentPage = 0;
        }
        
        // Links content string variable
        $output = '';
        
        // Showing links notification
        if ($this->showCount){
           $currentOffset = $this->currentPage;
           $info = 'Showing ' . ( $currentOffset + 1 ) . ' to ' ;
        
           if( ( $currentOffset + $this->perPage ) < ( $this->totalRows -1 ) )
              $info .= $currentOffset + $this->perPage;
           else
              $info .= $this->totalRows;
        
           $info .= ' of ' . $this->totalRows . ' | ';
        
           $output .= $info;
        }
        
        $this->numLinks = (int)$this->numLinks;
        
        // Is the page number beyond the result range? the last page will show
        if ($this->currentPage > $this->totalRows){
            $this->currentPage = ($numPages - 1) * $this->perPage;
        }
        
        $uriPageNum = $this->currentPage;
        
        $this->currentPage = floor(($this->currentPage/$this->perPage) + 1);

        // Calculate the start and end numbers. 
        $start = (($this->currentPage - $this->numLinks) > 0) ? $this->currentPage - ($this->numLinks - 1) : 1;
        $end   = (($this->currentPage + $this->numLinks) < $numPages) ? $this->currentPage + $this->numLinks : $numPages;

        // Render the "First" link
        if  ($this->currentPage > $this->numLinks){
            $output .= $this->firstTagOpen 
                . $this->getAJAXlink( '' , $this->firstLink)
                . $this->firstTagClose; 
        }

        // Render the "previous" link
        if  ($this->currentPage != 1){
            $i = $uriPageNum - $this->perPage;
            if ($i == 0) $i = '';
            $output .= $this->prevTagOpen 
                . $this->getAJAXlink( $i, $this->prevLink )
                . $this->prevTagClose;
        }

        // Write the digit links
        for ($loop = $start -1; $loop <= $end; $loop++){
            $i = ($loop * $this->perPage) - $this->perPage;
                    
            if ($i >= 0){
                if ($this->currentPage == $loop){
                    $output .= $this->curTagOpen.$loop.$this->curTagClose;
                }else{
                    $n = ($i == 0) ? '' : $i;
                    $output .= $this->numTagOpen
                        . $this->getAJAXlink( $n, $loop )
                        . $this->numTagClose;
                }
            }
        }

        // Render the "next" link
        if ($this->currentPage < $numPages){
            $output .= $this->nextTagOpen 
                . $this->getAJAXlink( $this->currentPage * $this->perPage , $this->nextLink )
                . $this->nextTagClose;
        }

        // Render the "Last" link
        if (($this->currentPage + $this->numLinks) < $numPages){
            $i = (($numPages * $this->perPage) - $this->perPage);
            $output .= $this->lastTagOpen . $this->getAJAXlink( $i, $this->lastLink ) . $this->lastTagClose;
        }

        // Remove double slashes
        $output = preg_replace("#([^:])//+#", "\\1/", $output);

        // Add the wrapper HTML if exists
        $output = $this->fullTagOpen.$output.$this->fullTagClose;
        
        return $output;        
    }

    function getAJAXlink( $count, $text) {
        if($this->link_func == '' && $this->contentDiv == '')
            return '<a href="'.$this->baseURL.'?'.$count.'"'.$this->anchorClass.'>'.$text.'</a>';
        
        $pageCount = $count?$count:0;
        if(!empty($this->link_func)){
            $linkClick = 'onclick="'.$this->link_func.'('.$pageCount.')"';
        }else{
            $this->additionalParam = "{'page' : $pageCount}";
            $linkClick = "onclick=\"$.post('". $this->baseURL."', ". $this->additionalParam .", function(data){
                       $('#". $this->contentDiv . "').html(data); }); return false;\"";
        }
        
        return "<a href=\"javascript:void(0);\" " . $this->anchorClass . "
                ". $linkClick .">". $text .'</a>';
    }
}
	/************/		
			
			
global $wpdb;
global $result; 
$ID = $_GET['ID']; 


if (empty($ID))
{
 $result = $wpdb->get_results ( "SELECT * FROM animal_images LIMIT $offset, $no_of_records_per_page");
$total_rows=  $wpdb->get_var("SELECT COUNT(*) FROM animal_images");
	 $total_pages = ceil($total_rows / $no_of_records_per_page);
}
else{
 $result = $wpdb->get_results ( "SELECT * FROM animal_images WHERE AnimalName like '%$ID%' LIMIT $offset, $no_of_records_per_page");
$total_rows=  $wpdb->get_var("SELECT COUNT(*) FROM animal_images WHERE AnimalName like '%$ID%' ");
	$total_pages = ceil($total_rows / $no_of_records_per_page);
}
?>
			
<!DOCTYPE html>
	<html>
	<head>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> 
		
	<style>
	.tb {
  		font-family: arial, border-collapse;
  		border-collapse: collapse;
  		table-layout: fixed;
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
    display: none;
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
	
		
</style>
	</head>
		
	<body>
	<table class="search">
	<tr>
	<td class = "searchBar" width = "50%">
		<div class="searchable">
    	<input id="seek" type="text" placeholder="Search Animals" onkeyup="filterFunction(this,event)">
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
		
		
		
	<td width = "25%"><center>
		<button id="searching" class="button">Search</button></center>
	</td>
	<td width = "25%"><center>
		<button id="cancelling" class="button">Cancel</button></center>
	</td>
	</tr>
	</table>
		<br>
		
		
		
		
		<div class="post-search-panel">
    <input type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
    <select id="sortBy" onchange="searchFilter()">
        <option value="">Sort By</option>
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
    </select>
</div>
<div class="post-wrapper">
    <div class="loading-overlay"><div class="overlay-content">Loading.....</div></div>
    <div id="posts_content">
    <?php
    //Include pagination class file
    include('Pagination.php');
    
    //Include database configuration file
    include('dbConfig.php');
    
    $limit = 10;
    
    //get number of rows
    $queryNum = $db->query("SELECT COUNT(*) as postNum FROM posts");
    $resultNum = $queryNum->fetch_assoc();
    $rowCount = $resultNum['postNum'];
    
    //initialize pagination class
    $pagConfig = array(
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'link_func' => 'searchFilter'
    );
    $pagination =  new Pagination($pagConfig);
    
    //get rows
    $query = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT $limit");
    
    if($query->num_rows > 0){ ?>
        <div class="posts_list">
        <?php
            while($row = $query->fetch_assoc()){ 
                $postID = $row['id'];
        ?>
            <div class="list_item"><a href="javascript:void(0);"><h2><?php echo $row["title"]; ?></h2></a>
		
		
		
		
		
		
		
<table>
<?php
 $i=0;
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
				   
       			 <img class = "animalImage" src='http://animalsense.tk/wp-content/uploads/2020/05/<?php echo $print->image; ?>'/>
				 
					</figure>		
						
					  </div>
					
					</div>
				</a>     
					<br> <p style="font-family:Arial; font-size:150%;"><?php echo $print->AnimalName; ?></p>
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
		<script src="jquery.min.js"></script>
		
		
		<script>
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    $.ajax({
        type: 'POST',
        url: 'getData.php',
        data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (html) {
            $('#posts_content').html(html);
            $('.loading-overlay').fadeOut("slow");
        }
    });
}
</script>
		
	
		 
	<script> 
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

$(document).ready(function(){
  			 $("#cancelling").click(function(){
   			    window.location.href='http://www.animalsense.tk/testing3/';
  					});
  				});
		
		
$(document).ready(function(){
  			 $("#searching").click(function(){
   			    window.location.href='http://www.animalsense.tk/testing3/?ID='+$("#seek").val().trim();
  					});
  				});
		
$(document).on('click','.searchable ul li', function () {
	$(this).closest(".searchable").find("input").val($(this).text()).blur();
     $("#searching").click(function(){
	 window.location.href='http://www.animalsense.tk/testing3/?ID='+$("#seek").val().trim();
		 
});
});
$(".searchable ul li").hover(function () {
    $(this).closest(".searchable").find("ul li.selected").removeClass("selected");
    $(this).addClass("selected");
});
</script>
		
	</body>
	</html>

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
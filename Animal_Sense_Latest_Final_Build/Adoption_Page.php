<?php
/**
Template Name: Custom Page PHP Adoption
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

<!-- Styling cards -->            
<style type="text/css">

*{
 margin: 0px;
 padding: 0px;
}
body{
 font-family: arial;
    background-color: #f6f6f6;
}
    
ol {
	counter-reset:li; /* Initiate a counter */
	margin-left:0; /* Remove the default left margin */
	padding-left:0; /* Remove the default left padding */
    display: table;
    margin:0 auto;
}
    
/*.fade li{
  opacity:0;
  background:rgba(255,255,255,.4);
  text-shadow: 1px 1px white;
  white-space:nowrap;
 
}
.fade li:first-child{ animation:bringback 1s 0s forwards;}
.fade li:nth-child(2){animation:bringback 1s  2s forwards;}
.fade li:nth-child(3){animation:bringback 1s  3s forwards;}
.fade li:nth-child(4){ animation:bringback 1s 4s forwards;}
.fade li:nth-child(5){animation:bringback 1s  5s forwards;}
.fade li:nth-child(6){animation:bringback 1s 6s forwards;}
    
@keyframes bringback{
  to{opacity:1;text-indent:25px; }
}*/

    
ol > li {
	position:relative; /* Create a positioning context */
	margin:0 0 6px 2em; /* Give each list item a left margin to make room for the numbers */
	padding:4px 8px; /* Add some spacing around the content */
	list-style:none; /* Disable the normal item numbering */
	border-top:2px solid #666;
	background:#f6f6f6;
}
ol > li:before {
	content:counter(li); /* Use the counter as content */
	counter-increment:li; /* Increment the counter by 1 */
	/* Position and style the number */
	position:absolute;
	top:-2px;
	left:-2em;
	-moz-box-sizing:border-box;
	-webkit-box-sizing:border-box;
	box-sizing:border-box;
	width:2em;
	/* Some space between the number and the content in browsers that support
	   generated content but not positioning it (Camino 2 is one example) */
	margin-right:8px;
	padding:4px;
	border-top:2px solid green;
	color:white;
	background:#41C03D;
	font-weight:bold;
	font-family:"Helvetica Neue", Arial, sans-serif;
	text-align:center;
}
    
.intro{
    font-family: "Palatino Linotype","Book Antiqua",Palatino,serif;
    font-size: 27px;
    letter-spacing: 0px;
    word-spacing: 2px;
    color: black;
    font-weight: 400;
    text-decoration: none;
    font-style: italic;
    font-variant: normal;
    text-transform: none;
    text-align: center;
    padding-top: 40px;
}
    
.fade{
font-family: "Palatino Linotype","Book Antiqua",Palatino,serif;
    font-size: 25px;
    letter-spacing: 0px;
    word-spacing: 2px;
    color: black;
    font-weight: 400;
    text-decoration: none;
    font-style: bold;
    font-variant: normal;
    text-transform: none;
    text-align: center;
    padding-top: 50px;
}
    
.quote{
  font-size: 2em;
  width:100%;
  margin:80px auto;
  color: #555555;
  padding:1.2em 30px 1.2em 75px;
  border-left:8px solid #78C0A8 ;
  line-height:1.6;
  position: relative;
  background:#EDEDED;
}

.quote p {
    font-family: "Palatino Linotype","Book Antiqua",Palatino,serif;
    font-style: bold;
    font-size: 60px;
    font-weight: 700px;
    text-align: center;
}


.cards{
    margin: 0 auto;
    max-width: 1300px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    grid-auto-rows: auto;
    gap: 50px;
    font-family: sans-serif;
    padding-top: 100px;
    padding-bottom: 50px;

}


.cards{
	box-sizing: border-box;
	width: 100%

}

.card{
	box-shadow: 2px 2px 20px rgba(0,0,0, 1);
    border-radius: 10px; 
}
    
.card__image{
	width: 100%;
	height: 360px;
	display: block;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
}

.title{
 
  text-align: center;
  padding: 10px;
  
 }
    
.card__content{

	line-height: 1.5;
	padding: 15px;

}

.card__info{
	padding: 15px;
	line-height: 1;
	word-break : break-all;
	font-size: 15px;

}

button{
  margin-top: 15px;
  margin-bottom: 10px;
  border: 1px solid black;
  border-radius: 5px;
  padding:10px;
    text-transform:capitalize

}
button:hover{
  background-color: #AEC2AF;
  color: black;
  transition: .5s;
  cursor: pointer;
}        
           
</style>

<div class="quote">
    <p>"Each and every animal of Earth has as much right to be here as you and me. "</p>
</div>
<div class="intro">
<p>
    As plenty of the planet&apos;s most unique and adorable animals are in trouble these days, we need your help and kindness to save them. You can make a difference in the difficult situation faced by wildlife nowadays by adopting an animal from the following organizations for yourself or as a gift for others. Animal adoption can be the most special gift that you could ever offer to someone who loves animals and together you can help us with environmental preservation and endangered species protection. So please feel free to look through these NGOs provided below if you want to adopt a precious endangered animal that belongs to you and make contributions to:
</p>
</div>
    
<div class="fade">


    <ol>
        <li>Critical financial support to save some of the most vulnerable and imperilled species in the world</li>
        <li>Fighting against the hazardous factors affecting wildlife and the environment</li>
        <li>Utmost capability to help endangered animals with minimum cost</li>
        <li>Offering direct care and assistant for endangered wildlife who lost their habitat</li>
        <li>Facilitating educational reasearch programmes</li>
    </ol>
</div>
<!-- Designing content of the card -->   
<div class="cards">
<div class="card">

<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/wwf.png" alt="" class="card__image">
<div class = "card__content">
<div class="title">
 <h3> WWF Australia </h3>
</div>
<div class="des">
    <p>This organization works for the conservation of environment and wildlife with a mission to stop degradation of natural environment</p>
</div>
</div>
<div class="card__info">
    <p><b>Email:</b> enquiries@wwf.org.au</p>
    <p><b>Phone:</b> 1800 032 551</p>
    <!--form method="get" action="https://donate.wwf.org.au/adopt#gs.5wh1qn">
    	<button type="submit">Learn More</button>
	</form-->
    <button onclick=" window.open('https://donate.wwf.org.au/adopt#gs.5wh1qn','_blank')">Learn More</button>
</div>
</div>
    
    
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Australia-zoo.png" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Australia Zoo
				</h3>
            </div>
			<div class = "des">
				<p>
					This organization focusses on various wildlife conservation project with educational research to save wildlife and their habitats.
				</p>
			</div>	
			
		</div>	
		<div class="card__info">
			<div>
				<p>
					<b>Email:</b> info@australiazoo.com.au
				</p>
				<p>
					<b>Phone:</b> +61 754 362 000
				</p>
				<!--form method="get" action="https://www.australiazoo.com.au/support-wildlife/adopt-an-animal/">
    			<button type="submit">Learn More</button>
				</form-->
                <button onclick=" window.open('https://www.australiazoo.com.au/support-wildlife/adopt-an-animal/','_blank')">Learn More</button>
			</div>

		</div>

		</div>
    
<div class="card">

<div class="card__image">
   <img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Zoos-Victoria.jpg">
</div>
    <div class="card__content">
    
<div class="title">
 <h3>Zoos Victoria</h3>
</div>
<div class="des">
 <p>It is a not-for-profit conservation organisation dedicated to fighting wildlife extinction and carry out various conservation measures</p>
        </div>
    </div>
        <div class="card__info">
    <p><b>Email:</b> donate@zoo.org.au</p>
            <p><b>Phone:</b> 1300 966 784 </p>
<!--form method="get" action="https://donate.zoo.org.au/adoption">
    			<button type="submit">Learn More</button>
				</form-->
            <button onclick=" window.open('https://donate.zoo.org.au/adoption','_blank')">Learn More</button>
            </div>
</div>
<div class="card">

   <img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Zoos_SA_logo_large.png" alt="" class="card__image">

    <div class="card__content">
<div class="title">
 <h3>Zoos SA</h3>
</div>
<div class="des">
 <p>Zoos SA is a not-for-profit conservation charity and has long been established as a treasured part of South Australia's heritage and social history with a purpose to connect people with nature to save wild animals</p>
    </div>
    </div>
        <div class="card__info">
        <p><b>Email:</b> information@zoossa.com.au</p>
            <p><b>Phone:</b> (08) 8267 3255</p>
<!--form method="get" action="https://www.zoossa.com.au/adopt/">
    			<button type="submit">Learn More</button>
				</form-->
            <button onclick=" window.open('https://www.zoossa.com.au/adopt/','_blank')">Learn More</button>
            </div>
</div>
    
<div class="card">

   <img src="http://www.animalsense.tk/wp-content/uploads/2020/05/MoonSanc.gif" alt="" class="card__image">
    <div class="card__content">
<div class="title">
 <h3>Moonlit Sanctuary</h3>
</div>
<div class="des">
 <p>It is a not for profit organization that takes care of  many endangered species with no government funding, and it seeks for support for wildlives as well as conservation and education programs</p>
    </div>
    </div>
        <div class="card__info">
            <p><br><b>Email Address:</b> info@moonlit-sanctuary.com</p>
            <p><b>Phone:</b> +61 359 787 935</p>
            
<!--form method="get" action="https://moonlitsanctuary.com.au/adopt-an-animal/">
    			<button type="submit">Learn More</button>
				</form-->
            <button onclick=" window.open('https://moonlitsanctuary.com.au/adopt-an-animal/','_blank')">Learn More</button>
</div>
</div>
    
<div class="card">

   <img src="http://www.animalsense.tk/wp-content/uploads/2020/05/reptile_park_logo.jpg" alt="" class="card__image">

    <div class="card__content">
<div class="title">
 <h3>Australian Reptile Park</h3>
</div>
<div class="des">
 <p>The Australian Reptile Park is regarded as one of the country's premier attractions and is the only zoo in Australia committed to saving lives with a spider and snake Venom-Milking Program in place</p>
    </div>
        </div>
        <div class="card__info">
            
            <p><br><b>Email:</b> admin@reptilepark.com.au</p>
            <p><b>Phone:</b> +61 243 401 022</p>
<!--form method="get" action="https://reptilepark.com.au/shop/adoption/adopt-an-animal/">
    			<button type="submit">Learn More</button>
				</form-->
            <button onclick=" window.open('https://reptilepark.com.au/shop/adoption/adopt-an-animal/','_blank')">Learn More</button>
</div>
</div>
        </div>
</div>

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
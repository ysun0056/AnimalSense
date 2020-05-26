<?php
/**
 * The template for displaying standard pages
 * Template name: Donation page
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


<!--code start-->
<!DOCTYPE html>
<!--CSS style-->
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
	background: #41C03D;
	font-weight:bold;
	font-family:"Helvetica Neue", Arial, sans-serif;
	text-align:center;
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
 .intro{
  font-family: "Palatino Linotype","Book Antiqua",Palatino,serif;
  font-size: 29px;
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
    
  .point{
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
    
 .cards {
    margin: 0 auto;
    max-width: 1300px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    grid-auto-rows: auto;
    gap: 50px;
    font-family: sans-serif;
    padding-top: 100px;

}


.cards{
	box-sizing: border-box;
	width: 100%

}

.card{
	box-shadow: 2px 2px 20px rgba(0,0,0, 1);
    background-color: white;
    border-radius: 10px;
	/*box-shadow: 2px 2px 20px black;*/
}
.card__image{
	width: 420px;
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



<!--quote in the beginning-->   
<div class="quote">
 <p>"Giving is not just about making a donation. <br>It is about making a difference. "</p>
</div>
    
<!--donation introduction-->
<div class="intro">
<p>
   In recent years, Australia has been facing an unprecedented wild animals extinction crisis due to the consistent climate change and severe pollution. And we have been losing numerous animal species in Australia posing serious threat to the biodiversity in this country. However, your help can make a real difference starting from today, and also allow us to save the wondrous species that remain. Your financial support for these influential NGOs will boost their frontline efforts to protect these endangered species in the wild and their habitats. These funds are directed towards the following purpose:
   </p>
</div>
    
<!--donation point-->
<div class="point">
<ol>
    <li>Preserve endangered animals in a safe habitat and help in their breeding</li>
    <li>Protect the habitat of these endangered species at risk</li>
    <li>Prevent the vulnerable species from the attack by invasive ones</li>
    <li>Improve the ability to operate endangered animal rescue programmes</li>
    <li>Facilitating educational reasearch and organizd wareness campaign</li>
  </ol>
    </div>
    
<!--donation organization-->
<div class = "cards">
		<!--cards 1-->
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
			<form method="get" action="https://wildlifewarriors.org.au/support/australia">
    		<button type="submit">Learn More</button>
			</form>
			</div>
		</div>
		</div>

		<!--cards2-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/wwf.png" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					WWF Australia
				</h3>
            </div>
		<div class = "des">
				<p>
				    This organization works for the conservation of environment and wildlife with a mission to stop degradation of natural environment.				
				</p>
		</div>	
			

		</div>	
		<div class="card__info">
		<div>
			<p>
				<b>Email:</b> enquiries@wwf.org.au
			</p>
			<p>
				<b>Phone:</b> 1800 032 551
			</p>
			<form method="get" action="https://donate.wwf.org.au/#gs.5wh7d3">
    		<button type="submit">Learn More</button>
			</form>
		</div>
		</div>
		</div>

		<!--cards3-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Australian-Animal-Rescue.png" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Australian Animal Rescue
				</h3>
            </div>
		<div class = "des">
				<p>
					Established after bush fire in 2009, this is a non-profit, volunteer run, and non-government organization.
				</p>
		</div>		
		</div>	
		<div class="card__info">
			<div>
				<p>
                    <br>
					<b>Email:</b> info@australiananimalrescue.org.au
				</p>
				<p>
					<b>Phone:</b> +61 430 883 083
				</p>
			<form method="get" action="https://www.australiananimalrescue.org.au/donate.html">
    		<button type="submit">Learn More</button>
			</form>
			</div>
		</div>
		</div>

		<!--cards 4-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Wildlife-Victoria.jpg" alt="" class="card__image">
		<div class = "card__content">
		<div class = "title">	
				<h3>
					Wildlife Victoria
				</h3>
        </div>	
		<div class = "des">
				<p>
					This organization helps and protects wildlife through rescue, education, and advocacy activities by promoting community knowledge and care of wildlife and advocate for the protection and welfare of wildlife.
				</p>
		</div>		
		</div>	
		<div class="card__info">
			<div>
				<p>
                   <br>
				   <b>Email:</b> office@wildlifevictoria.org.au
				</p>
				<p>
					<b>Phone:</b> +61 394 450 310
				</p>
			<form method="get" action="https://www.wildlifevictoria.org.au/donate/donate-to-wildlife-victoria">
    		<button type="submit">Learn More</button>
			</form>
			</div>
		</div>
		</div>

		<!--cards 5-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Zoos-Victoria.jpg" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Zoos Victoria
				</h3>
                </div>	
			<div class = "des">
				<p>
					It is a not-for-profit conservation organisation dedicated to fighting wildlife extinction.
				</p>
			</div>	
		</div>	
		<div class="card__info">
			<div>
				<br/>
				<br/>
				<br/>	
				<br/>
                <br/>
				<p>
					<b>Email:</b> donate@zoo.org.au
				</p>
				<p>
					<b>Phone:</b> 1300 966 784 
				</p>
			<form method="get" action="https://donate.zoo.org.au/donation">
    		<button type="submit">Learn More</button>
			</form>
			</div>

		</div>

		</div>

		<!--cards 6-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Warriers-4-Wildlife.png" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Warriers 4 Wildlife
				</h3>
                </div>	
			<div class = "des">
				<p>
					It is a not-for-profit rescue organisation dedicated to rescuing sick, injured, orphaned or abandoned animals in need.
				</p>
			</div>	

		</div>	
		<div class="card__info">
			<div>
				<br/>
				<br/>
				<br/>
				<p>
                    <b>Email:</b> warriors4wildlife@hotmail.com
				</p>
				<p>
					<b>Phone:</b> +61 401 811 937
				</p>
			<form method="get" action="https://www.warriors4wildlife.org/donate">
    		<button type="submit">Learn More</button>
			</form>
			</div>

		</div>

		</div>

		<!--cards 7-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Wires.png" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Wires
				</h3>
                </div>	
			<div class = "des">
				<p>
					Major mission is to actively rehabilitate and preserve Australian wildlife and inspire others to do the same.
				</p>
			</div>	
				

		</div>	
		<div class="card__info">
			<div>

				<p>
					<b>Email:</b> info@wires.org.au 
				</p>
				<p>
					<b>Phone:</b> +61 289 773 327
				</p>
			<form method="get" action="https://donations.wires.org.au/">
    		<button type="submit">Learn More</button>
			</form>
			</div>

		</div>

		</div>
		
		<!--cards 8-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Kanyana-Wildlife.jpg" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Kanyana Wildlife
				</h3>
                </div>	
			<div class = "des">
				<p>
					Kanyana Wildlife Rehabilitation Centre is a charity dedicated to caring for sick and injured wildlife, breeding threatened species, and public education.
				</p>
			</div>	

		</div>	
		<div class="card__info">
			<div>
				<p>
					<b>Email:</b> info@kanyanawildlife.org.au
				</p>
				<p>
					<b>Phone:</b> +61 892 913 900
				</p>
			<form method="get" action="https://kanyanawildlife.org.au/help-us-make-a-difference/">
    		<button type="submit">Learn More</button>
			</form>
			</div>

		</div>

		</div>

		<!--cards 9-->
		<div class = "card">
		<img src="http://www.animalsense.tk/wp-content/uploads/2020/05/Humane-Society-International.jpg" alt="" class="card__image">
		<div class = "card__content">
			<div class = "title">	
				<h3>
					Humane Society International
				</h3>
                </div>	
			<div class = "des">
				<p>
					Humane Society International (HSI) is the largest and most effective international charity working for a more humane and sustainable world for animals.
				</p>
			</div>		
		</div>	
		<div class="card__info">
		<div>
			<p>
				<b>Email:</b> admin@hsi.org.au
			</p>
			<p>
				<b>Phone:</b> 1800 333 737
			</p>
			<form method="get" action="https://action.hsi.org.au/page/34353/donate/1">
    		<button type="submit">Learn More</button>
			</form>
			</div>
		</div>
		</div>
		</div>
<!--code end-->	



				<?php get_template_part( 'content', 'page' ); ?>

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

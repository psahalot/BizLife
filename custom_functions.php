<?php
/* By taking advantage of hooks, filters, and the Custom Loop API, you can make Thesis
 * do ANYTHING you want. For more information, please see the following articles from
 * the Thesis User’s Guide or visit the members-only Thesis Support Forums:
 * 
 * Hooks: http://diythemes.com/thesis/rtfm/customizing-with-hooks/
 * Filters: http://diythemes.com/thesis/rtfm/customizing-with-filters/
 * Custom Loop API: http://diythemes.com/thesis/rtfm/custom-loop-api/

---:[ place your custom code below this line ]:---*/

// include plugin activation file for installing Soliloquy
include(THESIS_CUSTOM . '/tgmpa/plugin-details.php');

remove_action('thesis_hook_before_header','thesis_nav_menu');
add_action('thesis_hook_header','ict_nav_menu');

function ict_nav_menu() { ?>
<div id="nav-wrapper">
	<?php thesis_nav_menu(); ?>
</div>
<?php }

//hide headline on home page 
function ict_hide_headline() {
	if (is_front_page())
		return false; // Do not show headline
	else
		return true; // Show headline
}

add_filter('thesis_show_headline_area', 'ict_hide_headline');

/* register sidebars for featured box headline */
register_sidebar(array('name'=>'Featured Headline', 'before_title'=>'<h3>', 'after_title'=>'</h3>','description'=>'Drag a text widget and enter your text for headline'));

// hook our featured headline after header
function featured_headline() { 
?>
<div class="full_width" id="headline_area">
<div class="page">
	<div id="featured_headline">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Featured Headline') ) : ?>
		<?php endif; ?>
	</div>
</div>
</div>
<?php 
}
add_action('thesis_hook_before_content_area','featured_headline');

/* register sidebars for featured box headline */
register_sidebar(array('name'=>'Home Slider', 'id'=>'home-slider', 'before_title'=>'<h3>', 'after_title'=>'</h3>','description'=>'Drag a widget here to replace slider on home page'));

function ict_custom_slider() { 
if(is_front_page()) { ?>
<div class="full_width" id="slider_area">
<div class="page">
	<?php 
	if ( is_active_sidebar('home-slider') ) { 
		dynamic_sidebar('home-slider') ;
	}
	else {
			if (function_exists("easing_slider")){ easing_slider(); }
	} ?>
</div>
</div>
<?php }
}
add_action('thesis_hook_before_content_area','ict_custom_slider');

//create 3 column Home Widget widget areas 
if (function_exists('register_sidebar')) {
	$sidebars = array(1, 2, 3);
	foreach($sidebars as $number) {
		register_sidebar(array(
			'name' => 'Home Widget ' . $number,
			'id' => 'home-widget-' . $number,
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
	}
}

/* set up Home Widgets */
function ict_home_widgets() {
if(is_front_page()) {
 ?>

<div class="full_width" id="home_widget_area">
<div class="page">
	<div id="home_widgets" class="sidebar">
		<div class="home_items1">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Widget 1') ) : ?>
			<?php endif; ?>
		</div>
		<div class="home_items2">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Widget 2') ) : ?>
			<?php endif; ?>
		</div>
		<div class="home_items3">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Widget 3') ) : ?>
			<?php endif; ?>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>
</div>
<?php
}
}
add_action('thesis_hook_after_content_area','ict_home_widgets');

//remove thesis attribution
remove_action('thesis_hook_footer','thesis_attribution');


/* register sidebars for widgetized footer */
if (function_exists('register_sidebar')) {
	$sidebars = array(1, 2, 3, 4);
	foreach($sidebars as $number) {
		register_sidebar(array(
			'name' => 'Footer ' . $number,
			'id' => 'footer-' . $number,
			'before_widget' => '<div class="footer_wigets %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
	}
}


/* set up footer widgets */
function ict_widgetized_footer() {
?>
	<div id="footer_setup" class="sidebar">
		<div class="footer_items1">
  	  	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1') ) : ?>
    		<?php endif; ?>
		</div>

		<div class="footer_items2">
    		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2') ) : ?>
    		<?php endif; ?>
		</div>

		<div class="footer_items3"> 		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3') ) : ?> 		
		<?php endif; ?>		
		</div>

		<div class="footer_items4"> 		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 4') ) : ?> 		
		<?php endif; ?>		
		</div>

	</div>
<?php
}
add_action('thesis_hook_footer','ict_widgetized_footer');


function ict_custom_footer() {?>
<div class="full_width" id="copyright_area">
	<div class="page">
		<div id="copyright">
			<p> Copyright &copy; <?php echo date('Y'); ?> | <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> | Thesis Customization by <a href="http://icustomizethesis.com/" onclick="window.open(this.href); return false;">Puneet Sahalot</a>
			</p>
		</div>
	</div>
</div>
<?php }
add_action('thesis_hook_after_html','ict_custom_footer');

//custom body class for home page 
function ict_custom_body_class($classes) {
	if(is_front_page()) {
	$classes[] .= 'home-class';
	}

	return $classes;
}
add_filter('thesis_body_classes', 'ict_custom_body_class');
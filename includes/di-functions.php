<?php namespace Doc_It;
class Doc_It_Core {
	function __construct() {
		//Register Intro Posts
		add_action('init', array($this, 'register_intro_posts'));
		//Create Taxenomy for Doc It
		add_action('init', array($this, 'register_taxonomy_di_categories'));
		//wp_trim_words
		//add_filter( 'wp_trim_words', array($this,'wpso36236774999_trim_words'), 10, 5 );
		//Create Doc It Custom Post type
		add_filter('cpt_post_types', array($this, 'docit_cpt_post_types'));
		//Doc It Custom Post Types
		add_action( 'init', array($this,'di_cpt_init'));
		// Register Settings
		add_action('admin_init', array($this, 'doc_it_settings_page_settings' ));
		//Add Admin Styles
		add_action('admin_enqueue_scripts',  array($this, 'doc_it_admin_css'));
		//Add Meta Boxes
		add_action('add_meta_boxes', array($this,'add_quick_response_metaboxes'));
		//Save Meta Box Info
		add_action('save_post', array($this,'save_custom_meta_box'), 10, 3);
		
				
		//Add Admin Settings Scripts & Styles
		if (isset($_GET['page']) && $_GET['page'] == 'doc-it-settings-page') {
			add_action('admin_enqueue_scripts', array($this, 'doc_it_settings'));
		}
		//Add Admin System Info Styles
		if (isset($_GET['page']) && $_GET['page'] == 'doc-it-system-info-submenu-page') {
			add_action('admin_enqueue_scripts', array($this, 'doc_it_system_info_css'));
		}
		//Settings option. Add Padding to #Prime Wrapper. DO NOT MESS WITH SPACING BELOW.
		$docit_include_custom_css_checked_padding =  get_option('doc-it-color-options-settings-custom-css-main-wrapper-padding');
		if ($docit_include_custom_css_checked_padding == '1') {
			add_action('wp_enqueue_scripts', array($this, 'di_color_options_head_padding'));
		}
		//Settings option. Add Custom CSS to the header of docit pages only
		$docit_include_custom_css_checked_css =  get_option('doc-it-color-options-settings-custom-css');
		if ($docit_include_custom_css_checked_css == '1') {
			add_action('wp_enqueue_scripts', array($this, 'di_color_options_head_css'));
		}
		//Settings options. Rainbow Color Code Option
		$docit_include_custom_colored_code =  get_option('doc-it-color-coded');
		if ($docit_include_custom_colored_code == '1') {
			add_action('wp_enqueue_scripts', array($this, 'di_head_color_code'));
		}
		//Settings option. Closes Menu... Works but not in effect. More work to debug this issue.
		$docit_include_custom_display_menu_closed =  get_option('doc-it-display-menu-closed');
		if ($docit_include_custom_display_menu_closed == '1') {
			add_action('wp_enqueue_scripts', array($this, 'di_display_menu_closed'));
		}
		//Rename Doc It Second Menu Iten
		add_filter( 'attribute_escape', array($this,'rename_second_doc_it_submenu_name'), 10, 2 );
		//Add Settings Page
		add_action('admin_menu', array($this,'Doc_It_Submenu_Pages'));
		//Page Templates for Doc It
		add_filter('single_template', array($this,'DocIt_post_template'), 99);
		add_filter('page_template', array($this,'DocIt_page_template'), 99);
		add_filter('archive_template', array($this,'DocIt_archive_template'), 99) ;
		add_filter('taxonomy_template', array($this,'DocIt_archive_template'), 99);
	}
	//**************************************************
	// Generic Register Settings function
	//**************************************************
	function register_settings($settings_name , $settings) {
		foreach ($settings as $key => $setting) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			register_setting($settings_name, $setting);
		}
	}
	//**************************************************
	// Register Facebook Style Options.
	//**************************************************
	// function doc_it_settings_taxes() {
		
//	}

	//**************************************************
	// Register Facebook Style Options.
	//**************************************************
	function doc_it_settings_page_settings() {
		
		$di_settings_taxes = array(
			'doc_it_menu_labelz',
		);
		$this->register_settings('doc-it-settings-taxes', $di_settings_taxes);
		
		
		$di_settings_options = array(
			'doc-it-color-options-settings-custom-css-main-wrapper-padding', 
			'doc-it-color-options-main-wrapper-padding-input', 
			'doc-it-color-options-main-wrapper-margin-input', 
			'doc-it-color-options-main-wrapper-width-input', 
			'doc-it-color-options-main-wrapper-css-input', 
			'doc-it-color-options-settings-custom-css', 
			'doc-it-color-options-menu-position', 
			'doc-it-color-coded', 
			'doc-it-display-menu-closed',
			'doc-it-logged-out-word-count', 
			'doc-it-logged-out-button-text',
			'doc-it-premium-content',
			'doc-it-list-words', 
			'doc-it-add-menu-above-sidebar',
			'doc-it-custom-menu-name',
			'doc-it-custom-menu-link',
			'doc-it-hide-footer-navigation',
			'doc-it-hide-breadcrumbs',
		);
		$this->register_settings('doc-it-settings-options', $di_settings_options);
	}
	//**************************************************
	// Introductions
	//**************************************************
	function register_intro_posts() {
		$intro_exists = post_type_exists('docit_intro');
		if ($intro_exists == false) {
			register_post_type( 'docit_intro', array(
					'labels' => array(
						'menu_name' => 'Introductions',
						'name' => 'Doc It Introductions',
						'singular_name' => 'Doc It Introduction',
					),
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => 'edit.php?post_type=docit',
					'supports' => array('title','thumbnail','editor'),
				));
			flush_rewrite_rules();
		}
	}
	//**************************************************
	// Admin Styles
	//**************************************************
	function doc_it_admin_css() {
		wp_register_style( 'doc_it_admin', plugins_url( 'admin/css/admin.css', dirname(__FILE__) ) );
		wp_enqueue_style('doc_it_admin');
	}
	//**************************************************
	// Admin Settings Scripts & Styles
	//**************************************************
	function doc_it_settings() {
		wp_register_style( 'doc_it_settings_css', plugins_url( 'admin/css/settings-page.css',  dirname(__FILE__) ) );
		wp_enqueue_style('doc_it_settings_css');
	}
	//**************************************************
	// Admin System Info Styles
	//**************************************************
	function doc_it_system_info_css() {
		wp_register_style( 'doc-it-settings-admin-css', plugins_url( 'admin/css/admin-settings.css',  dirname(__FILE__) ) );
		wp_enqueue_style('doc-it-settings-admin-css');
	}
	//**************************************************
	// Front End Styles & Scripts
	//**************************************************
	function di_head_color_code() {
		wp_register_style('di_head_color_code', plugins_url( 'colorCode/css/custom.css',  dirname(__FILE__) ) );
		wp_enqueue_style('di_head_color_code');
		wp_register_script('di_head_color_code_main', plugins_url( 'colorCode/js/rainbow.min.js',  dirname(__FILE__) ), true );
		wp_enqueue_script( 'di_head_color_code_main');
	}
	//**************************************************
	// Front End Color Option styles (header)
	//**************************************************
	function di_color_options_head_padding() { ?>
		<style type="text/css">
			#docit-primary {
			<?php //padding
		$docit_include_custom_css_padding =  get_option('doc-it-color-options-main-wrapper-padding-input');
		if ($docit_include_custom_css_padding == ' ' || $docit_include_custom_css_padding == '') { ?>
			<?php }
		else { ?>
			padding: <?php print get_option('doc-it-color-options-main-wrapper-padding-input');?>  !important;
			<?php } ?>
			<?php //margin
		$docit_include_custom_css_margin =  get_option('doc-it-color-options-main-wrapper-margin-input');
		if ($docit_include_custom_css_margin == ' ' || $docit_include_custom_css_margin == '') { ?>
			<?php }
		else { ?>margin: <?php print get_option('doc-it-color-options-main-wrapper-margin-input');?>  !important;
			<?php } ?>
			<?php //max width
		$docit_include_custom_css_max_width =  get_option('doc-it-color-options-main-wrapper-width-input');
		if ($docit_include_custom_css_max_width == ' ' || $docit_include_custom_css_max_width == '') { ?>
			<?php }
		else { ?>max-width: <?php print get_option('doc-it-color-options-main-wrapper-width-input');?>  !important;
			<?php } ?> 	}
			<?php //Menu on Right
		$docit_include_custom_menu_position =  get_option('doc-it-color-options-menu-position');
		if ($docit_include_custom_menu_position == '2') { ?>
		#docit-primary .docit-menu-wrap {
				float: right !important;
				margin-left: 3% ;
				margin-right: 0% !important;
				}
			<?php } ?>
		</style>
		<?php
	}
	//**************************************************
	// Front End Stylesheet
	//**************************************************
	function di_color_options_head_css() {
?>
		<style type="text/css"><?php print get_option('doc-it-color-options-main-wrapper-css-input');?></style>
		<?php
	}
	//**************************************************
	// Closed Menu
	//**************************************************
	function di_display_menu_closed() {
?>
		<style type="text/css">#docit-primary .docit-sub-sub-menu-wrap, #docit-primary .docit-sub-post { display:none; }</style>
		<?php
	}
	//**************************************************
	// Register Dynamic Taxonomy Categories
	//**************************************************
	function register_taxonomy_di_categories() {

 	
	$tax_arrays = get_option('doc_it_menu_labelz'); 
 	
	
 	global $di_root_slug, $pagenow;
	$di_root_slug = 'docs';	
 
	global $di_list_of_taxs;
	
if (!empty($tax_arrays)){
	$di_list_of_taxs = array();
	 
		 array_filter($tax_arrays);
		foreach ($tax_arrays as $tax)	{
			//Check for bad Characters 
			$tax = preg_replace("/[^A-Za-z0-9 '-]/",'',$tax);
			if (!empty($tax)){
					//Clean things up a bit.
					$menu_name_lenth = (strlen($tax) > 21) ? substr($tax,0,18).'...' : $tax;
					$qv_tax_lower = strtolower($tax);
					$qv_tax = str_replace(' ', '_', $qv_tax_lower);
					$qv_tax_slug = str_replace(' ', '-', $qv_tax_lower);
						
					  $labels2 = array( 
						  'label' =>_x($tax, 'di_'.$qv_tax),
						  'name' => _x($tax, 'di_'.$qv_tax),
						  'singular_name' => _x($tax, 'di_'.$qv_tax),
						  'search_items' => _x( 'Search '.$tax.'s', 'di_'.$qv_tax),
						  'all_items' => _x( 'All '.$tax.'s', 'di_'.$qv_tax ),
						  'parent_item' => _x( 'Parent '.$tax, 'di_'.$qv_tax),
						  'parent_item_colon' => _x( 'Parent '.$tax.':', 'di_'.$qv_tax ),
						  'edit_item' => _x( 'Edit '.$tax, 'di_'.$qv_tax ),
						  'update_item' => _x( 'Update'.$tax, 'di_'.$qv_tax ),
						  'add_new_item' => _x( 'Add New '.$tax, 'di_'.$qv_tax ),
						  'new_item_name' => _x( 'New '.$tax, 'di_'.$qv_tax ),
						  'separate_items_with_commas' => _x( 'Separate '.$tax.' with commas', 'di_'.$qv_tax ),
						  'add_or_remove_items' => _x( 'Add or remove '.$tax, 'di_'.$qv_tax ),
						  'choose_from_most_used' => _x( 'Choose from the most used '.$tax, 'di_'.$qv_tax ),
						  'menu_name' => _x( $menu_name_lenth, 'di_'.$qv_tax),
					  );
				  
					  $args1 = array( 
						  
						  'labels' => $labels2,
						  'public' => true,
						  'show_in_nav_menus' => true,
						  'show_ui' => true,
						  //'show_tagcloud' => true,
						  'hierarchical' => true,
						  //'update_count_callback' => '_update_post_term_count',
						  'rewrite' => array('slug' => $di_root_slug.'/'.$qv_tax_slug),
						  'query_var' => 'di_'.$qv_tax,
					  );
					  
					  $di_list_of_taxs[$qv_tax]['label'] = $tax;
					  $di_list_of_taxs[$qv_tax]['slug'] = $qv_tax_slug;
					  $di_list_of_taxs[$qv_tax]['name'] = $tax;
					  $di_list_of_taxs[$qv_tax]['query_var'] = 'di_'.$qv_tax;
					   
						register_taxonomy( 'di_'.$qv_tax.'', array('Doc It'), $args1 );
						
						if($pagenow == 'doc-it-settings-page' && $_POST['settings-updated'] == 'true') {	
						 flush_rewrite_rules();
					}  
			}
	}
  }
}
	//**************************************************
	// Front End Navigation
	//**************************************************
	function di_next_previous_post($postid, $tax_parent) {
		$term_children_args = array(
			'orderby'       => 'none',
			'order'         => 'ASC',
			'hide_empty'    => false,
			'exclude'       => '',
			'exclude_tree'  => '',
			'include'       => '',
			'number'        => '',
			'fields'        => 'all',
			'slug'          => '',
			'parent'        => '',
			'hierarchical'  => false,
			'get'           => '',
			'name__like'    => '',
			'pad_counts'    => false,
			'offset'        => '',
			'search'        => '',
			'cache_domain'  => 'core'
		);
		// Gets every "category" (term) in this taxonomy to get the respective posts
		$termchildren = get_terms($tax_parent, $term_children_args);
		$ids = array();
		$array_count = 0;
		foreach ($termchildren as $termchild) {
			$tax = !empty($termchild->taxonomy) ? $termchild->taxonomy : '';
			$tax_sub = !empty($termchild->slug) ? $termchild->slug : '';
			if ($termchild->parent !== '0') {
				$postlist_args = array(
					'posts_per_page'  => -1,
					'order'           => 'ASC',
					'post_type'       => 'docit',
					'tax_query' => array(
						array(
							'taxonomy' => $tax,
							'field' => 'slug',
							'terms' => $tax_sub
						)
					)
				);
				$postlist = get_posts( $postlist_args );
				// get ids of posts retrieved from get_posts
				foreach ($postlist as $thepost) {
					if (!in_array($thepost->ID, $ids)) {
						$ids[$array_count] = $thepost->ID;
						$array_count++;
					}
				}
			}
		}
		// get and print previous and next post in the same taxonomy
		$thisindex = array_search($postid, $ids);
		$previd = isset($ids[$thisindex-1]) ? $ids[$thisindex-1] : '';
		$nextid = isset($ids[$thisindex+1]) ? $ids[$thisindex+1] : '';
		if ( !empty($previd) ) {
			print '<span class="docit-icon-arrowleft"></span> <a class="docit-prev-post" rel="prev" href="' . get_permalink($previd). '">'.get_the_title($previd).'</a>';
		}
		if ( !empty($nextid) ) {
			print '<span class="docit-icon-arrowright"></span> <a class="docit-next-post" rel="next" href="' . get_permalink($nextid). '">'.get_the_title($nextid).'</a>';
		}
	}
	//**************************************************
	// Add Doc It to Custom Post Types to sidebar of posts
	//**************************************************
	function docit_cpt_post_types( $post_types ) {
		$post_types[] = 'docit';
		return $post_types;
	}
	//**************************************************
	// Add Doc It to Custom Post Types
	//**************************************************
	function di_cpt_init() {
	
	$tax_arrays = get_option('doc_it_menu_labelz'); 
	
	global $di_root_slug, $pagenow;
	
	if (!empty($tax_arrays)){
		$tax_functions = array();
		foreach ($tax_arrays as $tax)	{
			$qv_tax_lower = strtolower($tax);
			$qv_tax = str_replace(' ', '_', $qv_tax_lower);
			$tax_functions[] = 'di_'.$qv_tax;
		}
	$is_taxes = "taxonomies";
	}
	else	{
		$tax_functions ='';	
		$is_taxes = "";
	}
	
    $args = array(
		'label' => 'Doc It',
		'labels' => array (
               'menu_name' => 'Documents',
               'name' => 'All Your Documents',
			   'singular_name' => 'Document',
			   'add_new_item' => 'Add New Document',
            ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'rewrite' => array('slug' => $di_root_slug),
		'query_var' => 'docit',
		'menu_icon' => '',
		'supports' => array(
		'title',
		'editor',
		'thumbnail',
		'excerpt',
		'trackbacks',
		'custom-fields',
		'comments',
		'revisions',
		'thumbnail',
		'author',
		),
		
		// Set the available taxonomies here
        $is_taxes => $tax_functions
		 );
		 
register_post_type('docit', $args );
	if($pagenow == 'doc-it-settings-page') {	
		flush_rewrite_rules();
	}
}	//**************************************************
	// Rename First Submenu Item
	//**************************************************
	function rename_second_doc_it_submenu_name($safe_text, $text) {
		if ('Documents' !== $text ) {
			return $safe_text;
		}
		// We are on the main menu item now. The filter is not needed anymore.
		remove_filter( 'attribute_escape', array($this,'rename_second_doc_it_submenu_name'));
		return 'Doc It';
	}
	//**************************************************
	// Add DI Submenu Pages
	//**************************************************
	function Doc_It_Submenu_Pages() {
		//System Info Page
		add_submenu_page(
			'edit.php?post_type=docit'
			, 'System Info'
			, 'System Info'
			, 'manage_options'
			, 'doc-it-system-info-submenu-page'
			, 'doc_it_system_info_page'
		);
	}
	//**************************************************
	// Page Template for Doc It
	//**************************************************
	function DocIt_page_template($template) {
		global $post;
		if (has_shortcode( $post->post_content, 'docit')) {
			$template = dirname( __FILE__ ) . '/templates/docit-page-template.php';
		}
		return $template;
	}
	//**************************************************
	// Create new Post Template for Doc It
	//**************************************************
	function DocIt_post_template($single_template) {
		global $post;
		if ($post->post_type == 'docit') {
			$single_template = dirname( __FILE__ ) . '/templates/docit-post-template.php';
		}
		return $single_template;
	}
	//**************************************************
	// Archive Template for Doc It
	//**************************************************
	function DocIt_archive_template($archive_template ) {
		global $post;
		if (!empty($post->post_type) && $post->post_type == 'docit' && is_archive ( 'docit' )) {
			$archive_template = dirname( __FILE__ ) . '/templates/docit-archive-template.php';
		}
		return $archive_template;
	}
	//**************************************************
	// Breadcrumbs
	//**************************************************
	function doc_it_breadcrumb() {
		print '<div id="breadcrumb"><span class="docit-icon-home"></span>';
		// Are there any taxonomies to get terms from?
		if (is_single()) {
			//Get single taxs
			$single_taxs = $this->di_post_main_slug();
			if ( FALSE == is_wp_error($single_taxs)) {
				//Print Single Tax Breadcrumb
				foreach ($single_taxs as $main_parent) {
					$main_parent_url = get_term_link($main_parent->name, $main_parent->taxonomy );
					if ( FALSE == is_wp_error($main_parent_url)) {
						print '<a href="'.$main_parent_url.'">'.$main_parent->name.'</a> » ';
					}
					//If Main Parent has Children
					if (!empty($main_parent->children)) {
						foreach ($main_parent->children as $first_child) {
							$first_child_url = get_term_link( $first_child->name, $first_child->taxonomy);
							// commented out sub cat print because of fatal error, need to fix. srl  8-5-14
						//	 print'<a href="'.$first_child_url.'">'.$first_child->name.'</a> » ';
							//If First Child has Children
							if (!empty($first_child->children)) {
								foreach ($first_child->children as $second_child) {
									$second_child_url = get_term_link($second_child->name, $second_child->taxonomy);
									print'<a href="'.$second_child_url.'">'.$second_child->name.'</a> » ';
								}//endforeach
							}//endif
						}//endforach
					}//endif
				}//endforeach
			}//end if single
			print the_title();
		}//endif single
		else {
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			//get current term info
			//store curent term's id as first in the array
			$breadcrumbarray[] = $term->term_id;
			//transfer the term info object so we don't mess it up
			$tempterm = $term;
			//backward crawl terms...
			//if the current term in the crawl has a parent - get it's parent's id...
			while ($tempterm->parent != 0) {
				$tempterm = get_term_by('id', $tempterm->parent, get_query_var( 'taxonomy' ));
				// and store it in the array
				$breadcrumbarray[] .= $tempterm->term_id;
			}
			//now reverse order the array so it goes from parent to child...
			$breadcrumbarray = array_reverse($breadcrumbarray);
			//now we'll loop through our array to display each item in the parent to child order and with links...
			$isfirst = true;
			foreach ($breadcrumbarray as $termid) {
				if (!$isfirst) print " » ";
				$isfirst = false;
				// get all the info again for the current term id in the array
				$terminfo = get_term_by('id', $termid, get_query_var( 'taxonomy' ));
				//show links for all terms except the current one..
				if ($terminfo->term_id != $term->term_id) {
					$url = get_term_link( $terminfo->name, get_query_var( 'taxonomy' ));
					//get the URL for that terms's page
			 		print '<a href="'.$url.'">'.$terminfo->name.'</a>';
				} else {
					print $terminfo->name;
				}
			}
		}//endelse
		print '</div><!--breadcrumb-->';
	}
	//**************************************************
	// Post Main Tax
	//**************************************************
	function di_post_main_tax() {
		// Get an array of all taxonomies for this post
		$taxonomies = get_taxonomies( '', 'names' );
		// Are there any taxonomies to get terms from?
		if ($taxonomies) {
			// Call the wp_get_post_terms function to retrieve all terms. It accepts an array of taxonomies as argument.
			$arr_terms = wp_get_post_terms(get_the_ID(), array_values($taxonomies), array('fields' => 'all'));
			if ($arr_terms) {
				$tax_array = array();
				foreach ($arr_terms as $term) {
					$tax_name = $term->taxonomy;
					$tax_array[] = $tax_name;
				}
				$clean_parents = array_unique($tax_array);
				$final_tax_array = implode(',', $clean_parents);
				return $final_tax_array;
			}
		}
	}
	//**************************************************
	// DI Slug
	//**************************************************
	function di_post_main_slug() {
		global $di_list_of_taxs;
		// Get an array of all taxonomies for this post
		$taxonomies = get_taxonomies( '', 'names' );
		// Are there any taxonomies to get terms from?
		if ( $taxonomies ) {
			// Call the wp_get_post_terms function to retrieve all terms. It accepts an array of taxonomies as argument.
			$arr_terms = wp_get_post_terms(get_the_ID(), array_values($taxonomies), array('fields' => 'all'));
			$categoryHierarchy = array();
			$this->di_sort_terms_hierarchicaly($arr_terms, $categoryHierarchy);
			return $categoryHierarchy;
		}
	}
	//**************************************************
	// Sort Post Tax Terms into Hierarchy
	//**************************************************
	function di_sort_terms_hierarchicaly(array &$cats, array &$into, $parentId = 0) {
		foreach ($cats as $i => $cat) {
			if ($cat->parent == $parentId) {
				$into[$cat->term_id] = $cat;
				unset($cats[$i]);
			}
		}
		foreach ($into as $topCat) {
			$topCat->children = array();
			$this->di_sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
		}
	}
	
	/* Trims text to a certain number of words.
 * 
 * Keep shortcode if exist in text.
 * Combination function of strip_shortcodes and wp_trim_words
 * 
 ** USAGE
 ** Using directly
 ** wpso36236774_trim_words( $text, 55, $more = null )
 ** wpso36236774_trim_words(  $text, 55, null, false, true ) - return array
 ** 
 ** Use wp_trim_words
 ** wp_trim_words( $text )
 ** Fire wp_trim_words
 ** add_filter( 'wp_trim_words', 'wpso36236774_trim_words', 10, 5 );
 *
 * @param  string  $text             Text to trim.
 * @param  int     $num_words        The number of words to trim the text to. Default 5.
 * @param  string  $more             An optional string to append to the end of the trimmed text, e.g. &hellip;.
 * @param  string  $original_content The text before it was trimmed.
 * @param  boolean $count            Get word count
 * @return string  The text after the filter witch $num_words
 * @return array   If using directly and parameter $count set to true
 */
function slick_docit_post_limit( $text, $num_words, $more = NULL,  $original_content = false, $count = false )
{
	
				$text = get_the_content();
	 if ( null === $more)
        $more = ' ' . '[&hellip;]';

    $shortcode = $strip_shortcode = true;

    if ( ! $original_content )
        $original_content = $text;

    $text = $original_content;

    /* Check existing shortcode
     *
     */
    if ( false === strpos( $text, '[' ) )
        $strip_shortcode = false;

    global $shortcode_tags;

    if ( empty( $shortcode_tags ) || ! is_array( $shortcode_tags ) )
        $strip_shortcode = false;

    /* Strip content from shortcode
     *
     */
    if ( $strip_shortcode )
    {
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $text, $matches );
        $tagnames = array_intersect( array_keys( $shortcode_tags ), $matches[1] );

        if ( ! empty( $tagnames ) )
        {
            $text = do_shortcodes_in_html_tags( $text, true, $tagnames );
            $pattern = get_shortcode_regex( $tagnames );
            preg_match_all( "/$pattern/", $text, $match );
            if ( ! empty( $match[0] ) && is_array( $match[0] ) )
            {
                $shortcode = '';
                $length    = count( $match[0] );
                for ( $i = 0 ; $i < $length; $i++ )
                    $shortcode .= do_shortcode( $match[0][ $i ] ); //match shortcode
            }

            $text = preg_replace_callback( "/$pattern/", 'strip_shortcode_tag', $text );
            $text = unescape_invalid_shortcodes( $text );
        }
    }

    /* Hide shortcode
     * Base on count function arguments
     *
     */
    if ( func_num_args() == 1 || ( func_num_args() == 4 && 55 == $num_words ) )
         $shortcode = '';

    /* Split content into array words
     *
     */
    //  $text = wp_strip_all_tags( $text );
    $text = $text;

    /*
     * translators: If your word count is based on single characters (e.g. East Asian characters),
     * enter 'characters_excluding_spaces' or 'characters_including_spaces'. Otherwise, enter 'words'.
     * Do not translate into your own language.
     */
    if ( strpos( _x( 'words', 'Word count type. Do not translate!' ), 'characters' ) === 0 && preg_match( '/^utf\-?8$/i', get_option( 'blog_charset' ) ) )
    {
        $text = trim( preg_replace( "/[\n\r\t ]+/", ' ', $text ), ' ' );
        preg_match_all( '/./u', $text, $words_array );
        $limit_words_array = array_slice( $words_array[0], 0, $num_words + 1 );
        $full_words_array  = $words_array[0];
        $sep = '';
    }
    else
    {
        $limit_words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
        $full_words_array  = explode( ' ', preg_replace( "/[\n\r\t ]+/", ' ', $text ) );
        $sep = ' ';
    }

    /* Check word count base on $num_words
     *
     */
    $word_count = count( $full_words_array );
    if ( $word_count >= $num_words )
    {
        array_pop( $limit_words_array );
        $text  = implode( $sep, $limit_words_array );
        $text .= $more;

        /* keep shortcode if exists and set position ( top or bottom text )
         *
         */
							if(! empty( $tagnames )){
									$pos = 'bottom';
        switch( $pos )
        {
            case 'top' :
                $text = '<p>'.$shortcode.'</p>'. $text;
                break;

            default :
                $text .= '<br/><br/><p>'.$shortcode.'</p>';
                break;
        }
							}
    }
    else
    {
        $text = apply_filters( 'the_content', $original_content );
    }

    if ( $count )
        return array(
            'text'  => $text,
            'count' => $word_count
        );

    return $text; //output
				
}
	//**************************************************
	// Category Page List of Posts word limit
	//**************************************************
	function slick_docit_cat_list_content($limit) {
				$content = explode(' ', get_the_content(), $limit);
				if (count($content)>=$limit) {
						array_pop($content);
						$content = implode(" ",$content).'...';
				} else {
						$content = implode(" ",$content);
				} 
  $content = preg_replace('/\[.+\]/','', $content);
		$content = apply_filters('the_content', $content); 
	 $content = str_replace(']]>', ']]&gt;', $content);
	 $content = str_replace("<br />", "", $content);
	 $content = str_replace("&nbsp;", "", $content);
		return $content;
		}
		
	//**************************************************
	// Add Quick Response Meta Boxes
	//**************************************************
	function add_quick_response_metaboxes() {
		//Sidebar Meta Boxes
		add_meta_box('docit-per-post-word-limit-settings-mb', __('Premium Content Word Limit', 'sidebar-suppport'),  array($this,'quick_response_side_meta_box'), 'docit', 'side', 'high', null);
	}
	//**************************************************
	// Quick Response Settings Meta Box
	//**************************************************
function quick_response_side_meta_box($object) {
	    wp_nonce_field(basename(__FILE__), 'docit-per-post-word-limit-meta-box-nonce');
	    
	    $meta_box = '<div class="side-sup-meta-wrap">';
	    //Quick Response Status 
					$meta_box .= '<p>';
						$meta_box .= '<label> '.__( 'The number of words to show when users are logged out. Leave blank to use the <a href="edit.php?post_type=docit&page=doc-it-settings-page#di-premium-content">Settings</a> page Post Words limit option:', 'slick-doc-it' ).'</label><br/>';
						// Get the location data if its already been entered
						$location = get_post_meta($object->ID, 'docit_per_post_word_limit', true);
						$meta_box .= '<label> '.__( 'Word Count:', 'slick-doc-it' ).'</label>';
						// Echo out the field
						$meta_box .=  '<input type="text" name="docit_per_post_word_limit" value="' . $location  . '" class="widefat" style="width:70px; margin:15px 0 0 15px;" />';
					$meta_box .= '</p>';

		$meta_box .= '</div><!-- /.das-order-update-box -->';
		// ECHO MetaBox
		echo $meta_box;
	}
	//**************************************************
	// Save Fields for Quick Responses
	//**************************************************
function save_custom_meta_box($post_id, $post, $update) {
		//Metabox Nonce 
	    if (!isset($_POST['docit-per-post-word-limit-meta-box-nonce']) || !wp_verify_nonce($_POST['docit-per-post-word-limit-meta-box-nonce'], basename(__FILE__)))
	        return $post_id;
	    //Can User Edit Post?   
	    if(!current_user_can('edit_post', $post_id))
	        return $post_id;
		//Autosave
	    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	        return $post_id;
	    //CPT Check
	    $slug = 'docit';
	    if($slug != $post->post_type)
	        return $post_id;
		//Default Field value	
	    $field_value = '';
	    // Field Array
	    $payment_field_array = array(
		    'docit_per_post_word_limit'
	    );
	    //Save Each Field Function
	    foreach ($payment_field_array as $field_name) {
		    if(isset($_POST[$field_name])) {
		        $field_value = $_POST[$field_name];
		    }   
		    update_post_meta($post_id, $field_name, $field_value);
	    }
	}
}//END CLASS Doc_It_Core
new Doc_It_Core();
?>
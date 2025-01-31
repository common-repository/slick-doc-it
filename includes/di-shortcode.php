<?php namespace Doc_It;
class DI_Shortcode extends Doc_It_Core {
	function __construct() {
		//Enqueue Doc It Header Scripts and Styles
		add_action('wp_enqueue_scripts', array($this,'di_head'));
		//Add ShortCode
		add_shortcode('docit', array($this,'docit_shortcode_func'));
	}
	//**************************************************
	// Doc It Front End Header
	//**************************************************
	function di_head() {
		wp_register_style( 'slick-di-style', plugins_url( 'css/styles.css', dirname(__FILE__) ) );
		wp_enqueue_style('slick-di-style');
		wp_enqueue_script( 'docit', plugins_url( 'js/docit.js',  dirname(__FILE__)), array( 'jquery' ));
	}
	//**************************************************
	// Shortcode Function
	//**************************************************
	function docit_shortcode_func($atts){
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		global $di_root_slug;
		global $di_list_of_taxs;

		extract( shortcode_atts( array(
					'id' => '',
					'intro' => '',
				), $atts ) );

		global $docit_att;
		$docit_att = array(
			'id' => $id,
			'intro' => $intro,
		);

		ob_start();

		//Start Doc It Menu
 if(is_plugin_active('doc-it-premium/doc-it-premium.php') && get_option('doc-it-add-menu-above-sidebar') && get_option('doc-it-premium-content')) {
					
					$custom_menu_name = get_option('doc-it-custom-menu-name');
					$custom_menu_link = get_option('doc-it-custom-menu-link');
					
					print'<div id="slick-docit-login-home-bar"><span class="docit-icon-home"></span><a href="'.$custom_menu_link.'">';
					
					if(!empty($custom_menu_name)){ 
							print $custom_menu_name;
					}
					else{ 
							print 'Home';
					}
					print '</a> <span class="slick-di-pipe">&nbsp;</span>';
						
							if(is_user_logged_in() !== true) {
									print '<a href="'.wp_login_url(get_permalink()).'">Login</a>';
						}
						else {
						print '<a href="'.wp_logout_url( get_permalink()).'">Logout</a>';
						}
						print '</div>';
		}//end premium check
		
		print '<div class="docit-menu-wrap">';
		
		if(!empty($id)){
			$taxonomies = array($id);
		}
		else {
			// get available taxonomies
			$taxonomies = $di_list_of_taxs;
		}

		// loop all taxonomies
		foreach($taxonomies as $taxonomy) {
			if(!empty($id)){
				$pre_tax_slug = str_replace('di_', '', $taxonomy);
				$tax_slug = str_replace('_', '-', $pre_tax_slug );

			}
			else{
				$tax_slug = $taxonomy->slug;
			}

			$args = array(
				'orderby'       => 'none',
				'order'         => 'ASC',
				'hide_empty'    => true,
				'exclude'       => '',
				'exclude_tree'  => '',
				'include'       => '',
				'number'        => '',
				'fields'        => 'all',
				'slug'          => '',
				'parent'         => '0',
				'hierarchical'  => true,
				'child_of'      => '',
				'get'           => '',
				'name__like'    => '',
				'pad_counts'    => false,
				'offset'        => '',
				'search'        => '',
				'cache_domain'  => 'core'
			);
			// Gets every "category" (term) in this taxonomy to get the respective posts
			$terms = get_terms($taxonomy, $args);

			if(empty($terms)) {
				$output_top_wrap .= '<div class="di-empty-category">Please attach post to this category to see sidebar.</div>';
			}


			if($terms) {
				// Add Main Titles
				$term_child_posts = array();
				$next_prev_posts = array();
				$term_counter = 1;
				foreach($terms as $term ) {


					print '<ul class="docit-menu  '.$term->slug.'-main-menu">';

					if ($term->parent =='0'){
						//main category title (on bottom is posts if no sub category)

						print '<li class="docit-main-header"><a href="'.get_site_url().'/'.$di_root_slug.'/'.$tax_slug.'/'.$term->slug.'" class="docit-main-cat-title">'.$term->name.'</a><div><span class="docit-icon-arrowdown"></span></div></li>';

					}

					$term_id_children = isset($term->term_id) ? $term->term_id : '';

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
						'parent'         => $term_id_children,
						'hierarchical'  => false,
						'child_of'      => '',
						'get'           => '',
						'name__like'    => '',
						'pad_counts'    => false,
						'offset'        => '',
						'search'        => '',
						'cache_domain'  => 'core'
					);
					// Gets every "category" (term) in this taxonomy to get the respective posts
					$termchildren = get_terms($taxonomy, $term_children_args);

					$child_count = 0;
					$term_child_count = 0;
					//Add first sub-category
					$check_list = array();
					foreach ($termchildren as $termchild) {
						$child_count++;
						$term_child_count++;


						$child_term = get_term($termchild->term_id, $taxonomy);

						$termchildren_lvl2_args = array(
							'orderby'       => 'none',
							'order'         => 'ASC',
							'hide_empty'    => false,
							'exclude'       => '',
							'exclude_tree'  => '',
							'include'       => '',
							'number'        => '',
							'fields'        => 'all',
							'slug'          => '',
							'parent'         => $child_term->term_id,
							'hierarchical'  => false,
							'child_of'      => '',
							'get'           => '',
							'name__like'    => '',
							'pad_counts'    => false,
							'offset'        => '',
							'search'        => '',
							'cache_domain'  => 'core'
						);
						// Gets every "category" (term) in this taxonomy to get the respective posts
						$termchildren_lvl2 = get_terms($taxonomy, $termchildren_lvl2_args);

						$child_check = array();
						$child_child_term_check = array();
						if(!empty($termchildren_lvl2)) {
							//Pre check Children Posts ID's and create array.
							foreach ($termchildren_lvl2 as $pre_subkey => $pre_subvalue) {
								$pre_child_of_child_term = get_term($pre_subvalue, $taxonomy);
								$child_child_term_check[] = isset($pre_child_of_child_term_term_id->term_id) ? $pre_child_of_child_term_term_id->term_id : '';
								$pre_sub_posts_args = array (
									'orderby' => 'menu_order',
									'order' => 'ASC',
									'taxonomy'=> $taxonomy,
									'term'=> $pre_child_of_child_term->slug,
									'posts_per_page' => -1,
									'suppress_filters' => true,
								);
								$pre_sub_posts = new \WP_Query($pre_sub_posts_args);
								if ($pre_sub_posts-> have_posts()) {
									//loop through posts
									while ($pre_sub_posts-> have_posts()) {
										$pre_sub_posts->the_post();



										$child_check[] = $pre_sub_posts->post->ID;
										$term_child_posts[] = $pre_sub_posts->post->ID;

										//Next/Prev array build

										if (!in_array($pre_sub_posts->post->ID,$next_prev_posts)) {
											$next_prev_posts[$term_counter][2][]  = $pre_sub_posts->post->ID;
										}
										else {
											foreach (array_keys($next_prev_posts[$term_counter][2], $pre_sub_posts->post->ID, true) as $key) {
												unset($next_prev_posts[$term_counter][2][$key]);
											}
											$next_prev_posts[$term_counter][2][]  = $pre_sub_posts->post->ID;
										}


									}//end while
								}//end if
							}//end foreach
						}//end if
						
						$output_sub_posts = isset($output_sub_posts) ? $output_sub_posts : '';
						$output_sub_posts .= '<li class="docit-main-cat-title"><ul class="docit-sub-menu">';
						$subcategoryCheck = in_array($child_term->term_id,$check_list);

						//If this sub category is NOT a parent add posts now otherwise don't
						if(!$subcategoryCheck) {

							$output_sub_posts .= '<li class="docit-sub-header '.$child_term->slug.'"><a href="'.get_site_url().'/'.$di_root_slug.'/'.$tax_slug.'/'.$child_term->slug.'" class="docit-sub-cat-title">'.$child_term->name.'</a><div><span class="docit-icon-arrowdown"></span></div></li>';
						}


						if(!in_array($child_term->term_id,$check_list)) {
							$no_parent_sub_posts_args = array (
								'order' => 'ASC',
								'orderby' => 'menu_order',
								'taxonomy'=> $taxonomy,
								'term'=> $child_term->slug,
								'posts_per_page' => -1,
								'suppress_filters' => true,
							);
							$posts = new \WP_Query($no_parent_sub_posts_args);

							//loop through posts
							while ($posts->have_posts()) {

								//get the post
								$posts->the_post();

								// show post titles for this cat
								if (!in_array($posts->post->ID,$child_check)){
									$output_sub_posts .= '<li class="docit-sub-post '.$posts->post->post_name.'" id="'.get_the_ID().'"><a href="'.get_site_url().'/'.$di_root_slug.'/'.$posts->post->post_name.'" class="docit-post-title">'. $posts-> post-> post_title .'</a></li>';
								}
								$posts_count = 0;
								//Update temporary value
								$posts_count++;
								//Add Id to $checklist
								$check_list[]=$child_term->term_id;

								$term_child_posts[] = $posts->post->ID;

								//Next/Prev array build
								if (!in_array($posts->post->ID,$next_prev_posts)) {
									$next_prev_posts[$term_counter][2][]  = $posts->post->ID;
								}
								else {
									foreach (array_keys($next_prev_posts[$term_counter][2], $posts->post->ID, true) as $key) {
										unset($next_prev_posts[$term_counter][2][$key]);
									}
									$next_prev_posts[$term_counter][2][]  = $posts->post->ID;
								}


							}//end while
						}//end if


						//If this sub category is a parent (Has Children) add children titles then posts [second sub category]
						if(!empty($termchildren_lvl2)) {

							$output_sub_posts .= '<li class="docit-sub-sub-menu-wrap"><ul class="docit-sub-sub-menu">';

							$check_list_lvl2 = array();
							//Add children here
							foreach ($termchildren_lvl2 as $subkey => $subvalue) {


								$child_of_child_term = get_term($subvalue, $taxonomy);
								$sub_posts_args = array (
									'orderby' => 'menu_order',
									'order' => 'ASC',
									'taxonomy'=> $taxonomy,
									'term'=> $child_of_child_term->slug,
									'posts_per_page' => -1,
									'suppress_filters' => true,
								);
								$sub_posts = new \WP_Query($sub_posts_args);

								if ( $sub_posts-> have_posts() ) {
									if(!in_array($child_of_child_term->term_id,$check_list_lvl2)){
										$output  = ''; 
										$output .= '<li class="docit-sub-sub-header '.$child_of_child_term->slug.'"><a href="'.get_site_url().'/'.$di_root_slug.'/'.$tax_slug.'/'.$child_of_child_term->slug.'" class="docit-sub-sub-cat-title">'. $child_of_child_term->name .'</a></li>';
									}
									//loop through posts
									while ( $sub_posts-> have_posts() ) {
										//get the post
										$sub_posts-> the_post();
										// show post titles for this cat
										$output_sub_posts .= '<li class="docit-sub-sub-post '.$sub_posts->post->post_name.'"><a href="'.get_site_url().'/'.$di_root_slug.'/'.$sub_posts->post->post_name.'" class="docit-post-title">'. $sub_posts->post->post_title .'</a></li>';

										//Update temporary value
										$posts_count++;
										$check_list_lvl2[] = $child_of_child_term->term_id;
										$term_child_posts[] = $sub_posts->post->ID;

										//Next/Prev array build
										if (!in_array($sub_posts->post->ID,$next_prev_posts)) {
											$next_prev_posts[$term_counter][2][]  = $sub_posts->post->ID;
										}
										else {
											foreach (array_keys($next_prev_posts[$term_counter][2], $sub_posts->post->ID, true) as $key) {
												unset($next_prev_posts[$term_counter][2][$key]);
											}
											$next_prev_posts[$term_counter][2][]  = $sub_posts->post->ID;
										}


									}//endwhile

								}
							}//end foreach

							$output_sub_posts .= '</ul></li>';//end sub sub ul


						}

						$output_sub_posts .= '</ul></li>';//end sub menu

					}

					//If no Sub categories add posts under main title
					$post_args = array (
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy'  => $taxonomy,
								'field'     => 'id',
								'terms'     => $term->term_id, // exclude media posts in the news-cat custom taxonomy
								'include_children' => false
							)),
						'post__not_in' => $term_child_posts,
						'posts_per_page' => -1,
						'suppress_filters' => true,
					);
					// get posts
					$posts = new \WP_Query($post_args );

					// check for posts
					if ( $posts-> have_posts() ) {

						// loop through posts
						while ( $posts-> have_posts() ) {
							// get the post
							$posts-> the_post();

							// show post titles for this cat
							print '<li class="docit-main-link '.$posts->post->post_name.'"><a href="'.get_site_url().'/'.$di_root_slug.'/'.$posts->post->post_name.'" class="docit-post-title">'. $posts-> post-> post_title .'</a></li>';

							if (!in_array($posts->post->ID,$next_prev_posts)) {
								$next_prev_posts[$term_counter][1][]  = $posts->post->ID;
							}

							$posts_count = 0;
							// Update temporary value
							$posts_count++;
						}//end while
						//  print $output_main_posts;
					}//end I

					print isset($output_sub_posts) ? $output_sub_posts : '';

					unset($output_main_posts,$output_sub_posts,$sub_post_list,$main_post_list);
					print '</ul>';//end main ul

					$term_counter++;
				}

			}//endiif Terms
			$main_loop_count = 0;
			$main_loop_count++;
		}
		print '</div>';

		$final_nav = array();
		foreach($next_prev_posts as $thiss) {
			$thiss2 = array_reverse($thiss, true);
			foreach ($thiss2  as $layer2) {
				foreach ($layer2 as $key => $value) {

					$final_nav[] = $value;

				}
			}
		}

		global $di_reindexed_next_prev;
		$di_reindexed_next_prev = $final_nav;

		$url = $_SERVER['REQUEST_URI']; //returns the current URL
		$tokens = explode('/', $url);
		$final_url = $tokens[sizeof($tokens)-2];
		if(!empty($final_url)) {
	// This adds an active state to the clicked item. The second statement will also open the ul li's below each main category clicked if you have the menu closed on page load..?> 
<script>jQuery(document).ready(function(){jQuery('.docit-menu-wrap .<?php print $final_url;?>').addClass('di-active').parent().children().css("display", "block");jQuery('.docit-menu.<?php print $final_url;?>-main-menu').children().children().children().css("display", "block");});
</script>
 	<?php }
		wp_reset_query();
		return ob_get_clean();
	}
}//END CLASS Doc_It_Core
new DI_Shortcode();
?>
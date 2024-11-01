<?php
/************************************************
 	Template file for Doc It Posts
************************************************/
get_header(); 

	//Post Info 
	$postid = $post->ID;
	$DI_core = new Doc_It\Doc_It_Core();
	$tax_parent = $DI_core->di_post_main_tax();
	global $text, $num_words;
?>
<div id="docit-primary" class="docit-content-area">
  <div id="docit-content" class="docit-site-content" role="main">
    <?php //Doc It sidebar menu
	    if ($post->post_type == 'docit') {
			echo do_shortcode('[docit id='.$tax_parent.']'); 
		}
	?>
    <div id="doc-it-content-wrap" class="<?php if (get_option( 'doc-it-premium-content' ) == '1') {?>slick-docit-premium-content<?php }?>">
      <?php /* The loop */ ?>
      <?php while ( have_posts() ) : the_post();
	   ?>
      <article id="docit-post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="docit-entry-header">
          <h1 class="header-text-docit">
            <?php the_title(); ?>
          </h1>
      <?php if(get_option('doc-it-hide-breadcrumbs') == '1') { }
						else { $DI_core->doc_it_breadcrumb(); }
						 ?>
        </header>
        <!-- .docit-entry-header -->
        <div class="docit-entry-content">
          <article id="docit-post-<?php the_ID(); ?>" <?php post_class(); ?>>
          
<?php 	
		 if (is_plugin_active('doc-it-premium/doc-it-premium.php') && get_option( 'doc-it-premium-content' ) == '1' && get_option( 'doc-it-logged-out-word-count' ) !== '' || is_plugin_active('doc-it-premium/doc-it-premium.php') && get_option( 'doc-it-premium-content' ) == '1' && get_post_meta($postid, 'docit_per_post_word_limit', true) !== '') {
												
							   if(!is_user_logged_in()) { ?>
																			<?php 
                   
                   $di_settings_word_count = get_option( 'doc-it-logged-out-word-count' );
                   $di_post_word_count = get_post_meta($postid, 'docit_per_post_word_limit', true);
                   
                   if( get_option( 'doc-it-logged-out-word-count' )  !== '' && get_post_meta($postid, 'docit_per_post_word_limit', true) == '') {
                    echo $DI_core->slick_docit_post_limit($text, $di_settings_word_count, '...');
                   }
                   elseif(get_post_meta($postid, 'docit_per_post_word_limit', true) !== '') {
                    echo $DI_core->slick_docit_post_limit( $text, $di_post_word_count, '...');
                    //	echo $DI_core->slick_docit_content($di_post_word_count);
                   }else	{
																					echo the_content();
																			}
                   ?>
													<div class="slick-read-more"></div>
										<?php
											}
						else	{
										echo the_content();
										}
				}
					else	{
						 echo the_content();
					} ?> 
          </article>
          <!-- #docit-post -->
        </div>
        <!-- .docit-entry-content --> 
          <?php 	if(is_plugin_active('doc-it-premium/doc-it-premium.php')) {
	 if (!is_user_logged_in() && get_option( 'doc-it-premium-content' ) == '1' && get_option( 'doc-it-logged-out-button-text' ) !== '' && get_option( 'doc-it-logged-out-word-count' ) !== '' || !is_user_logged_in() && get_option( 'doc-it-premium-content' ) == '1' && get_option( 'doc-it-logged-out-button-text' ) !== '' && get_post_meta($postid, 'docit_per_post_word_limit', true) !== '') { ?>
        <div class="docit-login-url"><a href="<?php echo wp_login_url(get_permalink()) ?>" class="button"><?php print get_option( 'doc-it-logged-out-button-text' ) ?></a></div>
       <?php } } ?>
       
      </article>
      <!-- #docit-post -->
      <?php endwhile; 
						
						if(get_option('doc-it-hide-footer-navigation') == '1') { }
						else { ?>
      <div class="doc-it-next-prev-wrap"><?php $DI_core->di_next_previous_post($postid, $tax_parent);?></div> 
      <?php } ?>
      
    </div>
    <!-- #docit-archive-wrap --> 
  </div>
  <!-- #docit-content -->
  <div class="clear"></div>
</div>
<!-- #docit-primary -->
<div class="clear"></div>
<?php get_footer(); ?>
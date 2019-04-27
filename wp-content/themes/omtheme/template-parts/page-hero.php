<?php

  if( is_page( 'about-us' ) ) $tag = 'about-us';
  if( is_page( 'research' ) ) $tag = 'research';
  if( is_page( 'data-products' ) ) $tag = 'data-products';
  if( is_page( 'news-events' ) ) $tag = 'news-events';
  if( is_page( 'contact' ) ) $tag = 'contact';
  if( is_page( 'privacy-policy' ) ) $tag = 'privacy-policy';
  if( is_page( 'qualification-process' ) ) $tag = 'qualification-process';
  if( is_page( 'terms-of-use' ) ) $tag = 'terms-of-use';
  if( is_page( 'careers' ) ) $tag = 'careers';
  if( is_page( 'support' ) ) $tag = 'support';
  if( is_single() ) $tag = get_the_category()[0]->slug;

  $args = array(
    'category_name' => 'home-slider',
    'tax_query'     => array( array(
      'taxonomy'    => 'post_tag',
      'field'       => 'slug',
      'terms'       => $tag
    )));
    $header = get_posts( $args );

    $wpblog_fetrdimg = get_the_post_thumbnail_url($header[0]->ID);
    setup_postdata( $header[0] );
        
    if( !is_page( 'homepage' )){ 
?>
 <header class="masthead masthead-part d-flex align-items-center justify-content-center" style="background-image: url(<?=$wpblog_fetrdimg; ?>)">
    <p class="blender-pro-bold main-slider-title page px-2" id="main-title"><?= $header[0]->post_title; ?></p>
  </header>

<script>
  const postTitle = <?= json_encode($header[0]->post_name); ?>;
  if (postTitle == 'qualification-process') {
    const mainTitle = document.getElementById('main-title');
    mainTitle.classList.add('main-get-started-title');
  }
</script>


<?php
     }
    
?>

 
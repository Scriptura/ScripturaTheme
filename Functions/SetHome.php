<?php

// -----------------------------------------------------------------------------
// @section     Set Home
// @description Configuration pour la page d'accueil
// -----------------------------------------------------------------------------

	ob_start();

  $popular = new WP_Query( [
      //'orderby' => 'rand',
      'post__in' => get_option( 'sticky_posts' ), // cibler posts "Mis en avant"
      'posts_per_page' => 5
  ] );

  if( get_option( 'sticky_posts' ) ) {
    echo '<header id="slideshow1" data-cycle-slides=".cycle-item" data-cycle-timeout="10000" data-cycle-speed="2000" data-cycle-prev="#prev" data-cycle-next="#next" data-cycle-manual-fx="scrollHorz" data-cycle-manual-speed="300" class="section slideshow">';
    if( have_posts() ) {

      while ( $popular->have_posts() ) : $popular->the_post();

        $postId = get_the_ID();
        $postImg = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false )[ 0 ];
        $postTitle = get_the_title();
        $permalink = get_permalink();
        $restrictedRead = get_post_meta( $post->ID, 'restrictedread', true );
        $authorizedGroups = get_post_meta( $post->ID, 'authorizedgroups', true );

        if ( has_post_thumbnail() ) {
          ob_start();
          the_post_thumbnail_url( 'image300' );
          $image300 = ob_get_clean();
          ob_start();
          the_post_thumbnail_url( 'image1000' );
          $image1000 = ob_get_clean();
          ob_start();
          the_post_thumbnail_url( 'image1500' );
          $image1500 = ob_get_clean();
          ob_start();
          the_post_thumbnail_url( 'image2000' );
          $image2000 = ob_get_clean();
        } elseif ( get_option( 'scriptura_def_thumbnail' ) ) {
          $image300 = get_option( 'scriptura_def_thumbnail' );
          $image1000 = get_option( 'scriptura_def_thumbnail' );
          $image1500 = get_option( 'scriptura_def_thumbnail' );
          $image2000 = get_option( 'scriptura_def_thumbnail' );
        } else {
          $image300 = $imgDefault300;
          $image1000 = $imgDefault1000;
          $image1500 = $imgDefault1500;
          $image2000 = $imgDefault2000;
        }
        if ( ( $restrictedRead AND ! $capacityRead ) OR ( ! $capacityAdministrator AND $userGroup != $authorizedGroups ) ) {
          $image300 = $imageProtected300;
          $image1000 = $imageProtected1000;
          $image1500 = $imageProtected1500;
          $image2000 = $imageProtected2000;
        }
        echo '<style>
                @media screen and (max-width: 36.01rem) {
                  #cycle-item' . $postId . ' {
                    background-image: url(' . $image1000 . ');
                  }
                }
                @media screen and (min-width: 36.01rem) and (max-width: 65.01rem) {
                  #cycle-item' . $postId . ' {
                    background-image: url(' . $image1500 . ');
                  }
                }
                @media screen and (min-width: 65.01rem) {
                  #cycle-item' . $postId . ' {
                    background-image: url(' . $image2000 . ');
                  }
                }
              </style>
              <div id="cycle-item' . $id . '" class="cycle-item">
                <picture>
                  <source srcset="' . $image300 . '" sizes="100vw">
                  <img src="' . $image2000 . '" alt="' . $postTitle . '">
                </picture>
                <div class="wrap cycle-text">
                  <div>
                    <h2><a href="' . $permalink . '">' . $postTitle . '</a></h2>
                  </div>
                </div>
              </div>';
      endwhile;
    }
    echo '</header>';
  }
	wp_reset_postdata();
	$slideshow = ob_get_clean();

  $name = $siteName;


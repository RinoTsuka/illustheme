<?php get_header(); ?>



<main>
  <div class="eyecatch">
    <img src="<?php echo wp_get_attachment_image_src( get_option('it_eyecatch') , 'full' )[0]; ?>" class="eyecatch__img">
  </div>



  <?php
    $loop = new WP_Query(array("post_type" => "event"));
    $date = date("Y-m-d");
    $count = 0;
    if ( $loop->have_posts() ) : while($loop->have_posts()): $loop->the_post();
  ?>
    <?php if ( $count === 0 ) : $count++; ?>
      <article class="article event">
    <?php endif; ?>
      <?php if ( get_post_meta($post->ID, 'event_end-date', true) >= $date ) : ?>
        <div class="event__inner">
          <div class="event__img-outer"><img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id() , 'full' )[0]; ?>" alt="" class="event__img"></div>
          <div class="event__body">
            <?php if ( get_post_meta($post->ID, 'event_url', true) ) : ?>
              <div class="event__title"><a href="<?php echo get_post_meta($post->ID, 'event_url', true); ?>" target="_blank"><?php the_title(); ?></a></div>
            <?php else : ?>
              <div class="event__title"><?php the_title(); ?></div>
            <?php endif; ?>
            <div class="event__meta">
              <div class="event__meta__item"><img src="<?php bloginfo('template_url'); ?>/img/public/icon/calendar.svg" alt="" class="event__meta__icon"><?php echo get_post_meta($post->ID, 'event_date', true); ?></div>
              <div class="event__meta__item"><img src="<?php bloginfo('template_url'); ?>/img/public/icon/map.svg" alt="" class="event__meta__icon"><?php echo get_post_meta($post->ID, 'event_position', true); ?></div>
            </div>
            <div><?php echo get_post_meta($post->ID, 'event_comment', true); ?></div>
          </div>
        </div>
      <?php endif; ?>
  <?php endwhile; ?>
    <?php if ( $count === 1 ) : ?>
      </article>
    <?php endif; ?>
  <?php endif; ?>



  <article class="article profile">
    <div class="profile__inner">
      <div class="profile__img-outer">
        <img src="<?php echo wp_get_attachment_image_src( get_option('it_user_icon') , 'post-thumbnail' )[0]; ?>" class="profile__img">
      </div>
      <div class="profile__body">
        <div class="profile__name"><?php echo get_option('it_user_name'); ?><span class="ruby"><?php echo get_option('it_user_name_yomi'); ?></span></div>
        <div class="profile__text">
          <?php echo get_option('it_user_profile'); ?>
        </div>


        <div class="sns">
          <?php if (get_option('it_pixiv')): ?>
            <div class="sns__item">
              <a href="https://www.pixiv.net/member.php?id=<?php echo get_option('it_pixiv')?>" target="_blank" class="sns__link">
                <img src="<?php bloginfo('template_url'); ?>/img/public/sns/pixiv.svg" class="sns__img pixiv">
                <div class="sns__tooltip">pixiv</div>
              </a>
            </div>
          <?php endif ?>

          <?php if (get_option('it_twitter')): ?>
            <div class="sns__item">
              <a href="https://twitter.com/<?php echo get_option('it_twitter')?>" target="_blank" class="sns__link">
                <img src="<?php bloginfo('template_url'); ?>/img/public/sns/twitter.svg" class="sns__img twitter">
                <div class="sns__tooltip">Twitter</div>
              </a>
            </div>
          <?php endif ?>

          <?php if (get_option('it_tumblr')): ?>
            <div class="sns__item">
              <a href="<?php echo get_option('it_tumblr')?>" target="_blank" class="sns__link">
                <img src="<?php bloginfo('template_url'); ?>/img/public/sns/tumblr.svg" class="sns__img tumblr">
                <div class="sns__tooltip">Tumblr</div>
              </a>
            </div>
          <?php endif ?>

          <?php if (get_option('it_instagram')): ?>
            <div class="sns__item">
              <a href="https://www.instagram.com/<?php echo get_option('it_instagram')?>/" target="_blank" class="sns__link">
                <img src="<?php bloginfo('template_url'); ?>/img/public/sns/instagram.png" class="sns__img instagram">
                <div class="sns__tooltip">Instagram</div>
              </a>
            </div>
          <?php endif ?>

          <?php if (get_option('it_facebook')): ?>
            <div class="sns__item">
              <a href="https://www.facebook.com/<?php echo get_option('it_facebook')?>" target="_blank" class="sns__link">
                <img src="<?php bloginfo('template_url'); ?>/img/public/sns/facebook.svg" class="sns__img facebook">
                <div class="sns__tooltip">Facebook</div>
              </a>
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </article>



  <article class="article gallery">
    <div class="slider">
      <?php
        $args = array(
          'post_type' => 'post',
          'posts_per_page' => -1
        );
      ?>
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="slider__item"><a href="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id() , 'full' )[0]; ?>" rel="lightbox" class="slider__link"><img src="<?php bloginfo('template_url'); ?>/img/gallery/gallery-loading.png" data-src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id() , 'post-thumbnail' )[0]; ?>" class="lazyload"></a></div>
      <?php endwhile; endif; ?>
    </div>
    <div class="slider-nav">
      <div class="slider-nav__inner"></div>
    </div>
  </article>


  <article class="banner">
    <div class="banner__body">
      <label for="banner__input"><img src="<?php echo wp_get_attachment_image_src( get_option('it_banner') , 'full' )[0]; ?>" class="banner__img"></label>
      <div class="banner__code">
        <?php
          function h($str) {
              echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
          };
        ?>
        <input type="text" value="<?php h( '<a href="' ); ?><?php h( bloginfo('url') ); ?><?php h( '" target="_blank"><img src="' ); ?><?php h( wp_get_attachment_image_src( get_option('it_banner') , 'full' )[0] ); ?><?php h( '" alt="' ); ?><?php h( bloginfo('name') ); ?><?php h( '" style="display:block;"></a>' ); ?>" id="banner__input" class="banner__input">
      </div>
    </div>
  </article>



  <?php
    $loop = new WP_Query(array("post_type" => "banner"));
    if ( $loop->have_posts() ) : while($loop->have_posts()): $loop->the_post();
  ?>
    <article class="article link-collection">
      <div class="link-collection__list">
        <div class="link-collection__item">
          <?php if ( get_post_meta($post->ID, 'link_code', true) ) :?>
            <?php
              $arr = explode("\"", get_post_meta($post->ID, 'link_code', true));
            ?>
            <a href="<?php echo $arr[1]; ?>" target="_blank" class="link-collection__link">
              <img src="<?php echo $arr[5]; ?>" class="link-collection__img">
              <div class="link-collection__tooltip"><?php echo $arr[7]; ?></div>
            </a>
          <?php else: ?>
            <a href="<?php echo get_post_meta($post->ID, 'link_name', true); ?>" target="_blank" class="link-collection__link">
              <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id() , 'full' )[0]; ?>" class="link-collection__img">
              <div class="link-collection__tooltip"><?php the_title(); ?></div>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </article>
  <?php endwhile; else: ?>
  <?php endif; ?>



  <?php if (get_option('it_contact_shortcode')): ?>
    <article class="article contact">
      <div class="contact__inner">
        <div class="contact__body">
          <div class="contact__title">お問い合わせ</div>
          <div class="contact__text">
            <?php echo get_option('it_contact_description'); ?>
          </div>
        </div>
        <div class="form">
          <?php echo do_shortcode(str_replace('\\', '', htmlspecialchars_decode(get_option('it_contact_shortcode')))); ?>
        </div>
      </div>
    </article>
  <?php endif ?>
</main>



<?php get_footer(); ?>

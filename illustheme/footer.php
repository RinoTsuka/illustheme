<footer class="footer">
  <div class="footer__body">
    <div class="copyright">
      <p><span class="copyright__site-name"><?php bloginfo('name'); ?></span><br>
      &copy; <?php
        $getlatest = get_posts('numberposts=1&post_type=any&orderby=modified');
        foreach($getlatest as $post) {
          if(get_the_date('Y')) {
            if(get_the_date('Y') == date('Y')){
              echo date('Y');
            } else {
              echo get_the_date('Y').'-'.date('Y');
            }
          } else {
            echo get_the_date('Y');
          }
        }
      ?> <span class="copyright__name"><?php echo get_option('user_name_yomi'); ?></span></p>
    </div>
    <div class="credit">
      <p>Powered by WordPress<br>
      <a href="//sora-maru.jp/illustheme/" target="_blank">Illustheme</a> Theme designed by <a href="//sora-maru.jp/" target="_blank">sora-maru</a></p>
    </div>
  </div>
</footer>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/script.min.js"></script>
<?php if(get_option('it_google_analytics')) echo stripslashes(htmlspecialchars_decode(get_option('it_google_analytics'))); ?>
<?php wp_footer(); ?>
</body>
</html>

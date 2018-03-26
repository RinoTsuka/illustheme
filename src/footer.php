<footer class="footer">
  <div class="footer__body">
    <div class="copyright">
      <p><span class="copyright__site-name"><?php bloginfo('name'); ?></span><br>
      &copy; 2018 <span class="copyright__name"><?php echo get_option('user_name_yomi'); ?></span></p>
    </div>
    <div class="credit">
      <p>Powered by WordPress<br>
      <a href="#" target="_blank">Illustheme</a> Theme designed by <a href="#" target="_blank">sora-maru</a></p>
    </div>
  </div>
</footer>



<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-beta.2/lazyload.js"></script>
<script src="<?php bloginfo('template_url'); ?>/js/script.min.js"></script>
<?php wp_footer(); ?>
</body>
</html>

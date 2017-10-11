<?php
/**
 * The template for displaying the footer.
 */
?>
<footer class="row bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <!-- Contact Info -->
        <span class="footer-column-header"><?php echo get_theme_mod( 'footer_column_header_1_1', 'CONTACT'); ?></span>
        <p class="footer-column-p">
          <?php echo get_theme_mod( 'footer_contact_1', '130 Albert St., Suite 710'); ?>
          <br>
          <?php echo get_theme_mod( 'footer_contact_2', 'Ottawa, Ontario Canada'); ?>
          <br>
          <?php echo get_theme_mod( 'footer_contact_3', 'K1P 5G4'); ?>
        </p>
        <p class="footer-column-p">
          <a href="tel:<?php echo get_theme_mod( 'footer_contact_4', '1.613.232.5000'); ?>"><?php echo get_theme_mod( 'footer_contact_4', '1.613.232.5000'); ?></a>
          <br>
          <?php echo get_theme_mod( 'footer_contact_5', '(Monday to Friday, 8AM - 4:30PM E.S.T.)'); ?>
        </p>
        <!--<p class="footer-column-p">
          <a href="sms:<?php echo get_theme_mod( 'footer_contact_6', '613.290.9009'); ?>"><?php echo get_theme_mod( 'footer_contact_6', '613.290.9009'); ?></a>
        </p>
        <p class="footer-column-p">
          <?php echo get_theme_mod( 'footer_contact_7', '1.613.236.6063'); ?>
        </p>-->
        <p class="footer-column-p">
          <a href="mailto:<?php echo get_theme_mod( 'footer_contact_8', 'info@interlangues.ca'); ?>"><?php echo get_theme_mod( 'footer_contact_8', 'info@interlangues.ca'); ?></a>
        </p>
        <br><br>
        <!-- Social Media -->
        <span class="footer-column-header"><?php echo get_theme_mod( 'footer_column_header_1', 'FOLLOW US'); ?></span>
        <a href="<?php echo get_theme_mod( 'footer_social_1', 'https://www.facebook.com/Interlangues1976'); ?>" target="_blank" class="footer-social-icons fa fa-facebook-square fa-2x"></a>
        <a href="<?php echo get_theme_mod( 'footer_social_2', 'https://www.instagram.com/interlangues76/'); ?>" target="_blank" class="footer-social-icons fa fa-instagram fa-2x"></a>
        <a href="<?php echo get_theme_mod( 'footer_social_3', 'https://twitter.com/Interlangues76'); ?>" target="_blank" class="footer-social-icons fa fa-twitter-square fa-2x"></a>
        <br><br>
      </div>
      <div class="col-md-3">
        <!-- About Interlangues Column -->
        <span class="footer-column-header"><?php echo get_theme_mod( 'footer_column_header_2', 'ABOUT INTERLANGUES'); ?></span>
          
      </div>
      <div class="col-md-3">
        <!-- Programs Column -->
        <span class="footer-column-header"><?php echo get_theme_mod( 'footer_column_header_3', 'PROGRAMS'); ?></span>
        <?wp_nav_menu( array( 'theme_location' => 'footer-menu2', 'items_wrap' => '<ul class="footer-column-ul">%3$s</ul>' ) ); ?>
      </div>
      <div class="col-md-3">
        <!-- Student Help Column -->
        <span class="footer-column-header"><?php echo get_theme_mod( 'footer_column_header_4', 'STUDENT HELP'); ?></span>
        <?wp_nav_menu( array( 'theme_location' => 'footer-menu3', 'items_wrap' => '<ul class="footer-column-ul">%3$s</ul>' ) ); ?>
      </div>
    </div>
  </div>
</footer>
<div class="footer-copy text-center">
  <div class="container">
    <img class="footer-logo" src="<?php header_image(); ?>">
    <p>&copy; Interlangues <?php echo date('Y'); ?>. All Rights Reserved.</p>
  </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<!-- Facebook Pixel Code -->
<!-- Begin Google Translate Code -->
<div id="google_translate_element"><div id="translate-btn">SELECT LANGUAGE</div></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.FloatPosition.BOTTOM_LEFT}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!-- End Google Translate Code -->     
<?php wp_footer(); ?>

</body>
</html>
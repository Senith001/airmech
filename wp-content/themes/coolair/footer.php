        </div><!-- .content -->
    </div><!-- .container -->
</div><!-- .main-container -->

<?php
$coolair_option = get_option('coolair_option');
?>
<footer>
  <div class="footer-bottom">
    <div>
        <div class="copyright_border">            
            <div class="copyright text-center">            
                <p><?php echo esc_html('&copy;')?> <?php echo date("Y");?>. <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> 
                </p>                
            </div>              
        </div>
    </div>
</div>
</footer>
</div><!-- #page -->
<?php 
if(!empty($coolair_option['show_top_bottom'])){
?>
 <!-- start top-to-bottom  -->
<div id="top-to-bottom">
    <i class="rt-angles-up"></i>
</div>   
<?php } ?>
 <?php wp_footer(); ?>
  </body>
</html>

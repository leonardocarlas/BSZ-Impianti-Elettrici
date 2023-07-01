<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Catch Themes
 * @subpackage Catch Everest
 * @since Catch Everest 1.0
 */
?>

	</div><!-- #main .site-main -->
    
	<?php 
    /** 
     * catcheverest_after_main hook
     */
    do_action( 'catcheverest_after_main' ); 
    ?> 
    
	<footer id="colophon" role="contentinfo">
		<?php
        /** 
         * catcheverest_before_footer_sidebar hook
         */
        do_action( 'catcheverest_before_footer_sidebar' );    

		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with three columns of widgets.
		 */
		get_sidebar( 'footer' ); 

		/** 
		 * catcheverest_after_footer_sidebar hook
		 */
		do_action( 'catcheverest_after_footer_sidebar' ); ?>   
           
        <div id="site-generator" class="container">
			<?php 
            /** 
             * catcheverest_before_site_info hook
             */
            do_action( 'catcheverest_before_site_info' ); ?>  
                    
        	<div class="site-info">
            	<?php 
				/** 
				 * catcheverest_site_info hook
				 *
				 * @hooked catcheverest_footer_content - 10
				 */
		
			
		 //BSZ <div class="copyright">'. esc_attr__( 'Copyright', 'catcheverest' ) . ' &copy; [the-year] <span>[site-link]</span>. '. esc_attr__( 'All Rights Reserved', 'catcheverest' ) . </div>
		//BSZ		do_action( 'catcheverest_site_generator' ); ?> 
		
			<DIV align="center"> &copy; BSZ IMPIANTI <?php echo date("Y"); ?> - Tutti i diritti riservati. &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160; BSZ IMPIANTI ELETTROTECNICI - Piazza Serragli, 8 - 36010 Chiuppano VI - P.IVA 00897210241 </DIV>
			
          	</div><!-- .site-info -->
            
			<?php 
            /** 
             * catcheverest_after_site_info hook
             */
           do_action( 'catcheverest_after_site_info' ); ?>              
       	</div><!-- #site-generator --> 
        
        <?php
        /** 
		 * catcheverest_after_site_generator hook
		 */
		do_action( 'catcheverest_after_site_generator' ); ?>  
               
	</footer><!-- #colophon .site-footer -->
    
    <?php 
    /** 
     * catcheverest_after_footer hook
     */
    do_action( 'catcheverest_after_footer' ); 
    ?> 
    
</div><!-- #page .hfeed .site -->

<?php 
/** 
 * catcheverest_after hook
 */
do_action( 'catcheverest_after' );

wp_footer(); ?>

</body>
</html>
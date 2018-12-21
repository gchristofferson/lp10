<?php
/**
 * Child template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php twentyseventeen_edit_link( get_the_ID() ); ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
            <div class="pull-left">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
				'after'  => '</div>',
			) );
		?>
            </div> 
            
            <div id="mySidenav" class="slideout-menu sidenav">
                <div>
                    <ul class="links">
                    </ul>   
                </div>
            </div> 
            
            <div class="sidebar">
                <span id="open-menu" class="open-menu" onclick="openNav()">Contents &#9776;</span>
                <a id="closebtn" href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            </div>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
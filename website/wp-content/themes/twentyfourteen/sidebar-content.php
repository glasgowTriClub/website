<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

if ( ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}
?>
<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
	<aside id="latestnews" class="widget widget_recent_entries">
  <?php query_posts('category_name=news&showposts=10'); ?>

  <h1 class="widget-title">Latest News</h1>

  <?php while (have_posts()) : the_post(); ?>
    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br /><br />
  <?php endwhile;?>
	</aside>

  <!-- light coloured twitter widget -->
<a class="twitter-timeline" href="https://twitter.com/GlasgowTriClub" data-widget-id="472848360324337664">Tweets by @GlasgowTriClub</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	<?php dynamic_sidebar( 'sidebar-2' ); ?>
</div><!-- #content-sidebar -->

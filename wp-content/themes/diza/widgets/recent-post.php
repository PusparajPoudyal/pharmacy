<?php
extract( $args );
extract( $instance );
$title = apply_filters('widget_title', $instance['title']);

if ( $title ) {
    echo trim($before_title)  . trim( $title ) . trim($after_title);
}

$args = array(
	'post_type' => 'post',
	'posts_per_page' => $number_post
);

$query = new WP_Query($args);
if($query->have_posts()): ?>

	<div class="post-widget">
	<ul>
	<?php
		while($query->have_posts()):$query->the_post();
	?>
		<li class="post">

	        <?php
	        if ( has_post_thumbnail() ) {
	            ?>
                <div class="entry-thumb">
                    <a href="<?php the_permalink(); ?>" class="entry-image">
                        <?php the_post_thumbnail( array(100, 100) ); ?>
                    </a>  
                </div>
	            <?php
	        }
	        ?>
	        <div class="entry-content">
	          	<?php
	            if (get_the_title()) { ?>
                  	<h4 class="entry-title">
					  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  	</h4>
	            <?php } ?>
           		<ul class="entry-meta-list">
					  <li class="entry-date"><i class="tb-icon tb-icon-calendar-31"></i><?php echo diza_time_link(); ?></li>
					  <li class="comments-link"><?php echo comments_popup_link( 'No comments','1 comment', '% comments', 'comments-link', 'Comments are off for this post' ); ?></li>
                </ul>
	        </div>
		</li>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
	</ul>
	</div>
<?php endif; ?>

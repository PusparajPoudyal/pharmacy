<?php
if( !defined('TBAY_ELEMENTOR_ACTIVED') ) return;

class Tbay_Widget_Woo_Carousel extends Tbay_Widget {
    public function __construct() {
        parent::__construct(
            'diza_woo_carousel',
            esc_html__('Diza woocommerce Carousel', 'diza'),
            array( 'description' => esc_html__( 'Show list product', 'diza' ), )
        );
        $this->widgetName = 'woo_carousel';
    }

    public function getTemplate() {
        $this->template = 'woo-carousel.php';
    }

    public function widget( $args, $instance ) {
        $this->display($args, $instance);
    }
    
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        } else {
            $title = esc_html__( 'Title', 'diza' );
        }

        if(isset($instance[ 'categories' ])){
            $categories = $instance[ 'categories' ];
        } else {
            $categories ='';
        }        

        if(isset($instance[ 'types' ])){
            $types = $instance[ 'types' ];
        } else {
            $types ='';
        }       
 
        if(isset($instance[ 'numbers' ])){
            $numbers = $instance[ 'numbers' ];
        } else {
            $numbers = 4;
        }        

        if(isset($instance[ 'columns' ])){
            $columns = $instance[ 'columns' ];
        } else {
            $columns = 4;
        }        

        if(isset($instance[ 'columns_destsmall' ])){
            $columns_destsmall = $instance[ 'columns_destsmall' ];
        } else {
            $columns_destsmall = 3;
        }        

        if(isset($instance[ 'columns_tablet' ])){
            $columns_tablet = $instance[ 'columns_tablet' ];
        } else {
            $columns_tablet = 2;
        }        

        if(isset($instance[ 'columns_mobile' ])){
            $columns_mobile = $instance[ 'columns_mobile' ];
        } else {
            $columns_mobile = 1;
        }

        if(isset($instance[ 'rows' ])){
            $rows = $instance[ 'rows' ];
        } else {
            $rows = 1;
        }


        $navigations         = isset($instance['navigations']) ? (bool) $instance['navigations'] : false;
        $paginations         = isset($instance['paginations']) ? (bool) $instance['paginations'] : false;
        $loop_type           = isset($instance['loop_type']) ? (bool) $instance['loop_type'] : false;
        $auto_type           = isset($instance['auto_type']) ? (bool) $instance['auto_type'] : false;
        $disable_mobile      = isset($instance['disable_mobile']) ? (bool) $instance['disable_mobile'] : false;
       

        $alltypes = array(
            'Best Selling' => 'best_selling',
            'Featured Products' => 'featured_product',
            'Recent Products' => 'recent_product',
            'On Sale' => 'on_sale',
            'Random products' => 'rand'
        );

        $allcolumns = array(
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            6 => 6
        );

        $allrows    = array(
            1 => 1,
            2 => 2,
            3 => 3
        );
    

        $allpaginations  = array(
                'No' => 'no',
                'Yes' => 'yes'
        );

        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:', 'diza' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>

            <?php 
            $taxonomy     = 'product_cat';
            $orderby      = 'name';  
            $show_count   = 1;
            $pad_counts   = 0;
            $hierarchical = 1;
            $title        = '';  
            $empty        = 0;

            $args = array(
                'taxonomy'     => $taxonomy,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
            );

            $all_categories = get_categories( $args );

            ?>
            <label for="<?php echo esc_attr($this->get_field_id( 'categories' )); ?>"><?php esc_html_e( 'Please select category to show:', 'diza' ); ?></label>


            <?php if(!empty($all_categories)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>">
                <?php
                foreach ($all_categories as $cat) {


                if($cat->category_parent == 0) {

                    $category_slug = $cat->slug;


                    printf(

                        '<option value="%s" %s>%s (%s)</option>',

                        esc_attr($category_slug),

                        ( $category_slug == $categories ) ? 'selected="selected"' : '',

                        esc_html($cat->name),

                        esc_html($cat->count)

                    );


                    }

                }
            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No woocommerce category found ', 'diza'); ?>

            <?php endif; ?>

        </p>        

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'numbers' )); ?>"><?php esc_html_e( 'Number of products to show:', 'diza' ); ?></label>

            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'numbers' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'numbers' )); ?>" type="text" value="<?php echo  esc_attr( $numbers ); ?>" />
        </p>        

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'types' )); ?>"><?php esc_html_e( 'Type Products:', 'diza' ); ?></label>


            <?php if(!empty($alltypes)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('types')); ?>" name="<?php echo esc_attr($this->get_field_name('types')); ?>">
                <?php 

                foreach ($alltypes as $key => $type) {
                     printf(

                        '<option value="%s" %s>%s</option>',

                        esc_attr($type),

                        ( $type == $types ) ? 'selected="selected"' : '',

                        esc_html($key)

                    );

                    }

            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No choose type product found ','diza'); ?>

            <?php endif; ?>

        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'columns' )); ?>"><?php esc_html_e( 'Columns:', 'diza' ); ?></label>


            <?php if(!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>">
                <?php 

                foreach ($allcolumns as $key => $column) {
                     printf(

                        '<option value="%s" %s>%s</option>',

                        esc_attr($column),

                        ( $column == $columns ) ? 'selected="selected"' : '',

                        esc_html($key)

                    );

                    }

            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No choose columns product found ', 'diza'); ?>

            <?php endif; ?>

        </p>          

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'columns_destsmall' )); ?>"><?php esc_html_e( 'Columns screen desktop small:', 'diza' ); ?></label>


            <?php if(!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_destsmall')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_destsmall')); ?>">
                <?php 

                foreach ($allcolumns as $key => $column) {
                     printf(

                        '<option value="%s" %s>%s</option>',

                        esc_attr($column),

                        ( $column == $columns_destsmall ) ? 'selected="selected"' : '',

                        esc_html($key)

                    );

                    }

            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No choose columns desktop small product found ', 'diza'); ?>

            <?php endif; ?>

        </p>   

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'columns_tablet' )); ?>"><?php esc_html_e( 'Columns screen tablet:', 'diza' ); ?></label>


            <?php if(!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_tablet')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_tablet')); ?>">
                <?php 

                foreach ($allcolumns as $key => $column) {
                     printf(

                        '<option value="%s" %s>%s</option>',

                        esc_attr($column),

                        ( $column == $columns_tablet ) ? 'selected="selected"' : '',

                        esc_html($key)

                    );

                    }

            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No choose columns table product found ','diza'); ?>

            <?php endif; ?>

        </p>           

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'columns_mobile' )); ?>"><?php esc_html_e( 'Columns screen mobile:', 'diza' ); ?></label>


            <?php if(!empty($allcolumns)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('columns_mobile')); ?>" name="<?php echo esc_attr($this->get_field_name('columns_mobile')); ?>">
                <?php 

                foreach ($allcolumns as $key => $column) {
                     printf(

                        '<option value="%s" %s>%s</option>',

                        esc_attr($column),

                        ( $column == $columns_mobile ) ? 'selected="selected"' : '',

                        esc_html($key)

                    );

                    }

            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No choose columns table product found ', 'diza'); ?>

            <?php endif; ?>

        </p>   

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'rows' )); ?>"><?php esc_html_e( 'Rows:', 'diza' ); ?></label>


            <?php if(!empty($allrows)) :  ?>

            <select id="<?php echo esc_attr($this->get_field_id('rows')); ?>" name="<?php echo esc_attr($this->get_field_name('rows')); ?>">
                <?php 

                foreach ($allrows as $key => $row) {
                     printf(

                        '<option value="%s" %s>%s</option>',

                        esc_attr($row),

                        ( $row == $rows ) ? 'selected="selected"' : '',

                        esc_html($key)

                    );

                    }

            ?>
            </select>

            <?php else: ?>

                <?php esc_html_e('No choose rows product found ','diza'); ?>

            <?php endif; ?>

        </p>       
 

        <p><input id="<?php echo esc_attr($this->get_field_id('navigations')); ?>" name="<?php echo esc_attr($this->get_field_name('navigations')); ?>" type="checkbox" value="1" <?php checked( $navigations ); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('navigations') ); ?>">
                <?php esc_html_e('Show navigations','diza'); ?>
            </label>

        </p>        

        <p><input id="<?php echo esc_attr($this->get_field_id('paginations')); ?>" name="<?php echo esc_attr($this->get_field_name('paginations')); ?>" type="checkbox" value="1" <?php checked( $paginations ); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('paginations') ); ?>">
                <?php esc_html_e('Show paginations','diza'); ?>
            </label>

        </p>        
        <p><input id="<?php echo esc_attr($this->get_field_id('loop_type')); ?>" name="<?php echo esc_attr($this->get_field_name('loop_type')); ?>" type="checkbox" value="1" <?php checked( $loop_type ); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('loop_type') ); ?>">
                <?php esc_html_e('Show loop','diza'); ?>
            </label>

        </p>        
        <p><input id="<?php echo esc_attr($this->get_field_id('auto_type')); ?>" name="<?php echo esc_attr($this->get_field_name('auto_type')); ?>" type="checkbox" value="1" <?php checked( $auto_type ); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('auto_type') ); ?>">
                <?php esc_html_e('Show auto','diza'); ?>
            </label>

        </p>        
        <p><input id="<?php echo esc_attr($this->get_field_id('disable_mobile')); ?>" name="<?php echo esc_attr($this->get_field_name('disable_mobile')); ?>" type="checkbox" value="1" <?php checked( $disable_mobile ); ?> />
            <label for="<?php echo esc_attr($this->get_field_id('disable_mobile') ); ?>">
                <?php esc_html_e('Disable mobile','diza'); ?>
            </label>

        </p>



<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        $instance['categories'] = ( ! empty( $new_instance['categories'] ) ) ? strip_tags( $new_instance['categories'] ) : '';

        $instance['types']      = ( ! empty( $new_instance['types'] ) ) ? strip_tags( $new_instance['types'] ) : '';

        $instance['numbers']    = ( ! empty( $new_instance['numbers'] ) ) ? strip_tags( $new_instance['numbers'] ) : '';

        $instance['columns']    = ( ! empty( $new_instance['columns'] ) ) ? strip_tags( $new_instance['columns'] ) : '';

        $instance['columns_destsmall']    = ( ! empty( $new_instance['columns_destsmall'] ) ) ? strip_tags( $new_instance['columns_destsmall'] ) : '';       

        $instance['columns_tablet']    = ( ! empty( $new_instance['columns_tablet'] ) ) ? strip_tags( $new_instance['columns_tablet'] ) : '';        

        $instance['columns_mobile']    = ( ! empty( $new_instance['columns_mobile'] ) ) ? strip_tags( $new_instance['columns_mobile'] ) : '';

        $instance['rows']       = ( ! empty( $new_instance['rows'] ) ) ? strip_tags( $new_instance['rows'] ) : '';

        $instance['navigations']        = $new_instance['navigations'];     
        $instance['paginations']        = $new_instance['paginations'];     
        $instance['loop_type']          = $new_instance['loop_type'];     
        $instance['auto_type']          = $new_instance['auto_type'];     
        $instance['disable_mobile']     = $new_instance['disable_mobile'];     


        return $instance; 
    }
}
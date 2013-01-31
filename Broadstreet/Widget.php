<?php


/**
 * This is an optional widget to display a broadstreet zone
 */
class Broadstreet_Zone_Widget extends WP_Widget
{
    /**
     * Set the widget options
     */
     function __construct()
     {
        $widget_ops = array('classname' => 'bs_zones', 'description' => 'A list of your Broadstreet zones');
        $this->WP_Widget('bs_zones', 'Broadstreet Ad Zone', $widget_ops);
     }

     /**
      * Display the widget on the sidebar
      * @param array $args
      * @param array $instance
      */
     function widget($args, $instance)
     {
         extract($args);
         
         $zone_id   = $instance['w_zone'];
         $zone_data = Broadstreet_Utility::getZoneCache();
         
         if($zone_data)
         {
            echo $before_widget;

            echo $zone_data[$zone_id]->html;

            echo $after_widget;
         }
     }

     /**
      * Update the widget info from the admin panel
      * @param array $new_instance
      * @param array $old_instance
      * @return array
      */
     function update($new_instance, $old_instance)
     {
        $instance = $old_instance;
        
        $instance['w_zone'] = $new_instance['w_zone'];

        return $instance;
     }

     /**
      * Display the widget update form
      * @param array $instance
      */
     function form($instance) 
     {

        $defaults = array('w_title' => 'Broadstreet Ad Zones', 'w_info_string' => '', 'w_opener' => '', 'w_closer' => '');
		$instance = wp_parse_args((array) $instance, $defaults);
        
        $zones = Broadstreet_Utility::refreshZoneCache();
        
       ?>
        <div class="widget-content">
       <?php if(count($zones) == 0): ?>
            <p style="color: green; font-weight: bold;">You either have no zones or
                Broadstreet isn't configured correctly. Go to 'Settings', then 'Broadstreet',
            and make sure your access token is correct, and make sure you have zones set up.</p>
        <?php else: ?>
        <input class="widefat" type="hidden" id="<?php echo $this->get_field_id('w_title'); ?>" name="<?php echo $this->get_field_name('w_title'); ?>" value="" />
       <p>
            <label for="<?php echo $this->get_field_id('w_info_string'); ?>">Zone</label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'w_zone' ); ?>" name="<?php echo $this->get_field_name('w_zone'); ?>" >
                <?php foreach($zones as $id => $zone): ?>
                <option <?php if(isset($instance['w_zone']) && $instance['w_zone'] == $zone->id) echo "selected" ?> value="<?php echo $zone->id ?>"><?php echo $zone->name ?></option>
                <?php endforeach; ?>
            </select>
       </p>
        <?php endif; ?>
        </div>
       <?php
     }
}

/**
 * This is an optional widget to display a broadstreet zone
 */
class Broadstreet_Business_Listing_Widget extends WP_Widget
{
    /**
     * Set the widget options
     */
     function __construct()
     {
        $widget_ops = array('classname' => 'bs_business_listings', 'description' => 'A list of entries in the business directory');
        $this->WP_Widget('bs_business_listings', 'Broadstreet Business List', $widget_ops);
     }

     /**
      * Display the widget on the sidebar
      * @param array $args
      * @param array $instance
      */
     function widget($args, $instance)
     {
        extract($args);
         
        $title     = $instance['w_title'];
        $ordering  = $instance['w_ordering'];
        $is_random = $instance['w_random'];
        $count     = $instance['w_count'];
        $category  = $instance['w_category'];
         
        $args = array (
            'post_type' => Broadstreet_Core::BIZ_POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => ($is_random == 'no' ? intval($count) : 100),
            'caller_get_posts'=> 1
        );
        
        if($category != 'all')
        {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => Broadstreet_Core::BIZ_TAXONOMY,
                    'field' => 'id',
                    'terms' => $category
                )
            );
        }
        
        if($ordering == 'alpha')
        {
            $args['order'] = 'ASC';
            $args['orderby'] = 'title';
        }
        
        if($ordering == 'mrecent')
        {
            $args['order'] = 'DESC';
            $args['orderby'] = 'ID';
        }
        
        if($ordering == 'lrecent')
        {
            $args['order'] = 'ASC';
            $args['orderby'] = 'ID';
        }

        $posts = get_posts($args);
        
        if($ordering == 'random')
        {
            shuffle($posts);
        }
        
        if($is_random == 'yes' && count($posts) > $count) {
            shuffle($posts);
            $posts = array_slice($posts, 0, $count);
        }
        
        echo $before_widget;
        
        if($title);
            echo $before_title . $title. $after_title;
            
        echo '<ul>';
        // The 2nd Loop
        foreach($posts as $post)
        {
            echo '<li><a href="'.get_permalink($post->ID).'">' . $post->post_title . '</a></li>';
        }

        echo '</ul>';
        echo $after_widget;
     }

     /**
      * Update the widget info from the admin panel
      * @param array $new_instance
      * @param array $old_instance
      * @return array
      */
     function update($new_instance, $old_instance)
     {
        $instance = $old_instance;

        $instance['w_title']    = $new_instance['w_title'];
        $instance['w_ordering'] = $new_instance['w_ordering'];
        $instance['w_random']   = $new_instance['w_random'];
        $instance['w_count']    = $new_instance['w_count'];
        $instance['w_category'] = $new_instance['w_category'];

        return $instance;
     }

     /**
      * Display the widget update form
      * @param array $instance
      */
     function form($instance) 
     {

        $defaults = array('w_title' => 'Businesses', 'w_ordering' => 'alpha', 'w_random' => 'no', 'w_count' => '10', 'w_category' => 'all');
		$instance = wp_parse_args((array) $instance, $defaults);
        
        $categories = get_terms(Broadstreet_Core::BIZ_TAXONOMY, 'orderby=name&hide_empty=0' );
        
       ?>
        <div class="widget-content">
            
        <p>
            <label for="<?php echo $this->get_field_id('w_title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('w_title'); ?>" name="<?php echo $this->get_field_name('w_title'); ?>" value="<?php echo $instance['w_title']; ?>" />
        </p>
       <p>
            <label for="<?php echo $this->get_field_id('w_category'); ?>">Business Category:</label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'w_category' ); ?>" name="<?php echo $this->get_field_name('w_category'); ?>" >
                <option value="all">All Categories</option>
                <?php foreach($categories as $cat): ?>
                <option <?php if($instance['w_category'] == $cat->term_id) echo "selected" ?> value="<?php echo $cat->term_id ?>"><?php echo $cat->name ?></option>
                <?php endforeach; ?>
            </select>
       </p>
       <p>
           <label for="<?php echo $this->get_field_id('w_random'); ?>">Random Selection? </label>
           <input type="checkbox" name="<?php echo $this->get_field_name('w_random'); ?>" value="yes"  <?php if($instance['w_random'] == 'yes') echo 'checked'; ?> />
       </p>
       <p>
            <label for="<?php echo $this->get_field_id('w_ordering'); ?>">Ordering:</label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'w_ordering' ); ?>" name="<?php echo $this->get_field_name('w_ordering'); ?>" >
                <option value="none">No Ordering</option>
                <option <?php if($instance['w_ordering'] == 'alpha') echo "selected" ?> value="alpha">Alphabetical</option>
                <option <?php if($instance['w_ordering'] == 'mrecent') echo "selected" ?> value="mrecent">Created (Most Recent First)</option>
                <option <?php if($instance['w_ordering'] == 'lrecent') echo "selected" ?> value="lrecent">Created (Most Recent Last)</option>
                <option <?php if($instance['w_ordering'] == 'random') echo "selected" ?> value="random">Random</option>
            </select>
       </p>
        <p>
            <label for="<?php echo $this->get_field_id('w_count'); ?>">Number of Items to List:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('w_count'); ?>" name="<?php echo $this->get_field_name('w_count'); ?>" value="<?php echo $instance['w_count']; ?>" />
        </p>
        </div>
       <?php
     }
}

/**
 * This is an optional widget to display a broadstreet zone
 */
class Broadstreet_Business_Profile_Widget extends WP_Widget
{
    /**
     * Set the widget options
     */
     function __construct()
     {
        $widget_ops = array('classname' => 'bs_business_profile', 'description' => 'A profile for a business in your sidebar');
        $this->WP_Widget('bs_business_profile', 'Broadstreet Business Spotlight', $widget_ops);
     }

     /**
      * Display the widget on the sidebar
      * @param array $args
      * @param array $instance
      */
     function widget($args, $instance)
     {
        extract($args);
         
        $title     = $instance['w_title'];
        $business  = $instance['w_business'];
        $category  = $instance['w_category'];
         
        $args = array (
            'post_type' => Broadstreet_Core::BIZ_POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'caller_get_posts'=> 1
        );
        
        if($business == 'random')
        {        
            if($category != 'any')
            {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => Broadstreet_Core::BIZ_TAXONOMY,
                        'field' => 'id',
                        'terms' => $category
                    )
                );
            }
            
            $args['orderby'] = 'rand';
        }
        else 
        {
            $args['p'] = $business;
        }
        
        $posts = get_posts($args);
        
        
        if($is_random == 'yes' && count($posts) > $count) {
            shuffle($posts);
            $posts = array_slice($posts, 0, $count);
        }
        
        echo $before_widget;
        
        
        
        if($posts)
        {
            $post = $posts[0];
            
            if($title)
                echo $before_title . $title. $after_title;
            else
                echo $before_title . $post->post_title. $after_title;
            
            echo '<div>';
            
            $has_thumbnail = has_post_thumbnail($post->ID); 
            $thumb_url     = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID));
            $thumb_url     = @$thumb_url['url'];
            $meta          = Broadstreet_Utility::getAllPostMeta($post->ID);
            $link          = get_permalink($post->ID);
            
            if(!$thumb_url)
            {
                $meta['bs_images'] = maybe_unserialize($meta['bs_images']);
                if(count($meta['bs_images']))
                {
                    $thumb_url = $meta['bs_images'][0];
                } 
                else 
                {
                    $thumb_url = false;
                }
            }

            if($thumb_url)
                echo '<a href="'.$link.'"><img width="100%" alt="Business profile" src="'.$thumb_url.'"></a>';
            
            echo '<strong><a href="'.$link.'">'.$post->post_title.'</a></strong><br/>';

            if($meta['bs_update_source'])
            {
                echo '<div style="border:1px solid #ccc;margin:3px 0;border-radius:3px;padding:5px;text-align:center;background: rgb(254,252,234);background: -moz-linear-gradient(top,  rgba(254,252,234,1) 0%, rgba(241,218,54,1) 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(254,252,234,1)), color-stop(100%,rgba(241,218,54,1)));background: -webkit-linear-gradient(top,  rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%);background: -o-linear-gradient(top,  rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%);background: -ms-linear-gradient(top,  rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%);background: linear-gradient(to bottom,  rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#fefcea", endColorstr="#f1da36",GradientType=0 );padding: 5px;margin-bottom: 10px;border-radius: 3px;border: 1px solid #ddd;text-align: center;">';
                echo $meta['bs_advertisement_html'];
                echo '</div>';
            }
            
            echo '<p>'.wp_trim_words(strip_tags($post->post_content), 30).' <a href="'.$link.'">more.</a></p>';
            
            echo '</div>';
        }
        

        echo $after_widget;
     }

     /**
      * Update the widget info from the admin panel
      * @param array $new_instance
      * @param array $old_instance
      * @return array
      */
     function update($new_instance, $old_instance)
     {
        $instance = $old_instance;

        $instance['w_title']    = $new_instance['w_title'];
        $instance['w_business']   = $new_instance['w_business'];
        $instance['w_category'] = $new_instance['w_category'];

        return $instance;
     }

     /**
      * Display the widget update form
      * @param array $instance
      */
     function form($instance) 
     {

        $defaults = array('w_title' => 'Business Spotlight', 'w_business' => 'random', 'w_category' => 'any');
		$instance = wp_parse_args((array) $instance, $defaults);
        
        $categories = get_terms(Broadstreet_Core::BIZ_TAXONOMY, 'orderby=name&hide_empty=0' );
        $businesses = array (
            'post_type' => Broadstreet_Core::BIZ_POST_TYPE,
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'caller_get_posts'=> 1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        
        $businesses = get_posts($businesses);
        
       ?>
        <div class="widget-content">
            <p><strong>Note:</strong> If no businesses are found with the options
            below, the widget will be hidden.</p>
        <p>
            <label for="<?php echo $this->get_field_id('w_title'); ?>">Title:</label><br/>
            <small>If this is blank, we'll default to the business name.</small>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('w_title'); ?>" name="<?php echo $this->get_field_name('w_title'); ?>" value="<?php echo $instance['w_title']; ?>" />
        </p>
       <p>
            <label for="<?php echo $this->get_field_id('w_business'); ?>">Business to show:</label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'w_business' ); ?>" name="<?php echo $this->get_field_name('w_business'); ?>" >
                <option value="random">Random Listing</option>
                <?php foreach($businesses as $bus): ?>
                <option <?php if($instance['w_business'] == $bus->ID) echo "selected" ?> value="<?php echo $bus->ID ?>"><?php echo $bus->post_title ?></option>
                <?php endforeach; ?>
            </select>
       </p>
       <p>
            <label for="<?php echo $this->get_field_id('w_category'); ?>">Business Category:</label><br/>
            <small>Applicable only if you chose 'Random' for the above. Then we'll pick something from this category.</small>
            <select class="widefat" id="<?php echo $this->get_field_id( 'w_category' ); ?>" name="<?php echo $this->get_field_name('w_category'); ?>" >
                <option value="any">Any Category</option>
                <?php foreach($categories as $cat): ?>
                <option <?php if($instance['w_category'] == $cat->term_id) echo "selected" ?> value="<?php echo $cat->term_id ?>"><?php echo $cat->name ?></option>
                <?php endforeach; ?>
            </select>
       </p>

        </div>
       <?php
     }
}

/**
 * This is an optional widget to display a broadstreet zone
 */
class Broadstreet_Business_Categories_Widget extends WP_Widget
{
    /**
     * Set the widget options
     */
     function __construct()
     {
        $widget_ops = array('classname' => 'bs_business_categories', 'description' => 'A listing of all business categories');
        $this->WP_Widget('bs_business_categories', 'Broadstreet Business Categories', $widget_ops);
     }

     /**
      * Display the widget on the sidebar
      * @param array $args
      * @param array $instance
      */
     function widget($args, $instance)
     {
        global $wpdb;
        extract($args);
         
        $title  = $instance['w_title'];
        $counts = $instance['w_show_counts'];
        
        $sql = "select t.name, t.slug, tax.taxonomy, tax.term_taxonomy_id, t.term_id, count(t.term_id) AS 'count'
                from $wpdb->term_taxonomy tax
                join $wpdb->term_relationships rel on rel.term_taxonomy_id = tax.term_taxonomy_id
                join $wpdb->terms t on t.term_id = tax.term_id
                join $wpdb->posts p on p.ID = rel.object_id
                where tax.taxonomy = '".Broadstreet_Core::BIZ_TAXONOMY."' and p.post_status = 'publish'
                group by t.term_id
                order by t.name";
        
        $rows = $wpdb->get_results($sql);
        
        echo $before_widget;
            
        if($title)
            echo $before_title . $title. $after_title;
        
        echo '<ul>';
        foreach($rows as $row)
        {
            echo '<li>';
                echo '<a href="'.get_term_link($row->slug, $row->taxonomy).'">'.$row->name.($counts == 'yes' ? ' ('.$row->count.')' : '').'</a>';
            echo '</li>';
        }
        echo '</ul>';

        echo $after_widget;
     }

     /**
      * Update the widget info from the admin panel
      * @param array $new_instance
      * @param array $old_instance
      * @return array
      */
     function update($new_instance, $old_instance)
     {
        $instance = $old_instance;

        $instance['w_title']    = $new_instance['w_title'];
        $instance['w_show_counts']= $new_instance['w_show_counts'];

        return $instance;
     }

     /**
      * Display the widget update form
      * @param array $instance
      */
     function form($instance) 
     {

        $defaults = array('w_title' => 'Business Categories', 'w_business' => 'random', 'w_category' => 'any');
		$instance = wp_parse_args((array) $instance, $defaults);
       ?>
        <div class="widget-content">
        <p>
            <label for="<?php echo $this->get_field_id('w_title'); ?>">Title:</label><br/>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('w_title'); ?>" name="<?php echo $this->get_field_name('w_title'); ?>" value="<?php echo $instance['w_title']; ?>" />
        </p>
       <p>
           <label for="<?php echo $this->get_field_id('w_show_counts'); ?>">Include post counts? </label>
           <input type="checkbox" name="<?php echo $this->get_field_name('w_show_counts'); ?>" value="yes"  <?php if($instance['w_show_counts'] == 'yes') echo 'checked'; ?> />
       </p>

        </div>
       <?php
     }
}
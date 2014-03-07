<?php
class Projectupdates
{

   private $access = array('public');
   private $custom_type = 'projectupdate';
   private $display = array(1=>"image",2=>"text",3=>"both");
  // private $order = array(1=>"1",2=>"2",3=>"3",4=>"4",5=>"5");
	
   public function __construct()
    {
		
 
        // Create a hook to create custom Post Type 
        add_action( 'init', array($this, 'create_post_type' ));
        
        // Create a hook to create metabox for the custom post type
        add_action( 'add_meta_boxes', array($this, 'init_metabox' ));
        
         // Call the exce_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projectupdates_excerpt_metabox' ));   

        // Create a hook to save the custom post type
        add_action( 'save_post', array($this, 'save_projectupdates_postdata' ),1,2);
 
       // Hook into the 'init' action
       add_action( 'init', array($this,'ovoid_projectupdates_categories'), 0 );
 
        // Hook into the 'init' action
        add_action( 'init', array($this,'ovoid_projectupdates_tags'), 0 ); 


       // Hook into the 'init' action  
       add_action('init',array($this,'admin_enqueue_scripts')) ; 

      // Call the exce_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projectupdates_excerpt_metabox' )); 
		
		add_action('restrict_manage_posts', array(&$this,'restrict_manage_project'));
		
		add_filter( 'parse_query', array(&$this,'ovoid_admin_posts_filter'));
    }

       function ovoid_projectupdates_tags()  {

	$labels_tags = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Tags', 'text_domain' ),
		'all_items'                  => __( 'All tags', 'text_domain' ),
		'parent_item'                => __( 'Parent tag', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent  tag:', 'text_domain' ),
		'new_item_name'              => __( 'New tag', 'text_domain' ),
		'add_new_item'               => __( 'Add new tag', 'text_domain' ),
		'edit_item'                  => __( 'Edit tag', 'text_domain' ),
		'update_item'                => __( 'Update tag', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'text_domain' ),
		'search_items'               => __( 'Search tags', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove  tags', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most tags', 'text_domain' ),
	);
	$args_tags = array(
		'labels'                     => $labels_tags,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
		register_taxonomy( 'ovoid_proj_upd_tag_taxonomy', $this->custom_type, $args_tags );
	
}



    // Create a Custom Post Type
    public function create_post_type() {
	

   $labels = array(
           
          'name'               => __( 'Project Updates',                   WPG_TEXTDOMAIN ),
          'singular_name'      => __( 'Project Update',                    WPG_TEXTDOMAIN ), 
          'add_new'            => __( 'Add New Project Update',                     WPG_TEXTDOMAIN ),
          'add_new_item'       => __( 'Add New Ovoid Project Update',            WPG_TEXTDOMAIN ),
          'edit_item'          => __( 'Edit Ovoid Project Update',               WPG_TEXTDOMAIN ),
          'new_item'           => __( 'Add New Ovoid Project Update',            WPG_TEXTDOMAIN ),
          'view_item'          => __( 'View Ovoid Project Update',               WPG_TEXTDOMAIN ),
          'search_items'       => __( 'Search Ovoid Project Updates',            WPG_TEXTDOMAIN ),
          'not_found'          => __( 'No Ovoid Project Updates found',          WPG_TEXTDOMAIN ),
          'not_found_in_trash' => __( 'No Ovoid Project Updates found in trash', WPG_TEXTDOMAIN )
        );

        register_post_type( $this->custom_type,
            array(
                'labels'  => $labels,
                'public' => true,
                'has_archive' => true,
                'supports' => array( 'title','editor','thumbnail' ),
                
            )
        );
    }


// Register Custom Taxonomy
public function ovoid_projectupdates_categories()  {

	$labels = array(
		'name'                       => _x( 'Update Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Update Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Update Categories', 'text_domain' ),
		'all_items'                  => __( 'All categories', 'text_domain' ),
		'parent_item'                => __( 'Parent category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent category:', 'text_domain' ),
		'new_item_name'              => __( 'New category', 'text_domain' ),
		'add_new_item'               => __( 'Add new update category', 'text_domain' ),
		'edit_item'                  => __( 'Edit work area', 'text_domain' ),
		'update_item'                => __( 'Save category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'text_domain' ),
		'search_items'               => __( 'Search categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used categories', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'ovoid_proj_upd_cat_work', $this->custom_type, $args );

}



    // Create a new Metabox for the Custom Post Type
    public function init_metabox() {
        // Callback function hooked to opportunity_metabox function 
        add_meta_box( 'Projectupdates', "Project Updates", array($this,'Projectupdates_metabox'), $this->custom_type, 'advanced', 'high');
    }
  
 public function init_projectupdates_excerpt_metabox() {
        
        add_meta_box( 'project_excerpt', "Excerpt", array($this,'new_excerpt_metabox'), $this->custom_type, 'normal', 'low');
    }  

    
   // include js and css for display the datepicker
   static function admin_enqueue_scripts()
		{
			$url = RWMB_CSS_URL . 'jqueryui';
			wp_register_style( 'jquery-ui-core', "{$url}/jquery.ui.core.css", array(), '1.8.17' );
			wp_register_style( 'jquery-ui-theme', "{$url}/jquery.ui.theme.css", array(), '1.8.17' );
			wp_enqueue_style( 'jquery-ui-datepicker', "{$url}/jquery.ui.datepicker.css", array( 'jquery-ui-core', 'jquery-ui-theme' ), '1.8.17' );

			// Load localized scripts
			$locale = str_replace( '_', '-', get_locale() );
			$file_path = 'jqueryui/datepicker-i18n/jquery.ui.datepicker-' . $locale . '.js';
			$deps = array( 'jquery-ui-datepicker' );
			if ( file_exists( RWMB_DIR . 'js/' . $file_path ) )
			{
				wp_register_script( 'jquery-ui-datepicker-i18n', RWMB_JS_URL . $file_path, $deps, '1.8.17', true );
				$deps[] = 'jquery-ui-datepicker-i18n';
			}

			wp_enqueue_script( 'rwmb-date', RWMB_JS_URL . 'date.js', $deps, RWMB_VER, true );
			wp_localize_script( 'rwmb-date', 'RWMB_Datepicker', array( 'lang' => $locale ) );
		}

 // call the metaboxes for partners
    public function new_excerpt_metabox(){
   $post=$_GET['post'];
 
        $excerpt_array = get_post_meta($post);
        $excerpt = $excerpt_array['excerpt'][0];
?>
       <div class="rwmb-field rwmb-textarea-wrapper">
                 
				 <div class="rwmb-input">
                     <textarea rows="3" cols="20" id="excerpt" name="excerpt" class="rwmb-textarea large-text">
                        <?php echo $excerpt.$post->ID; ?>
                     </textarea>
                     
                </div>
            </div>
<?php
    }

    // Called when the custom posttype is saved
    public function save_Projectupdates_postdata( $post_id ) {
        global $post , $wpdb;
        
        if( $post->post_type != $this->custom_type ) return $post_id;
        /*
        * We need to verify this came from the our screen and with proper authorization,
        * because save_post can be triggered at other times.
        */
        // Comment by Venkat - Removed the Nonce for the moment. Will do it later...

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            echo "Autosaved....";
            return $post_id;
        }

        // Check the user's permissions.
        if ( $this->custom_type == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) )
                return $post_id;
        
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize user input.
        $access = sanitize_text_field( $_POST['access'] );
        $projectname = sanitize_text_field( $_POST['projectname'] );
        $excerpt = sanitize_text_field( $_POST['excerpt'] );
        $display = sanitize_text_field( $_POST['display'] ); 
		if (isset($_POST['order'])){
		$order = explode("_",$_POST['order']) ;
		
		//echo "<pre>",$_POST['order'],"</pre>";
		//die;
        $selected_post_id =  $order[0];	
		$selected_order =  $order[1];
		}
        $previous_order = get_post_meta($post_id,'order',true );
        update_post_meta( $post_id, 'excerpt', $excerpt);
        update_post_meta( $post_id, 'projectname', $projectname);
        update_post_meta( $post_id, 'access', $access);
        update_post_meta( $post_id, 'display', $display); 
		if (isset($_POST['order']) && $_POST['order']!= '') {
		echo $previous_order;
			
		  if (!empty($previous_order) &&  trim($previous_order)!= ""  ) {
		 // die('1');	
				if ($previous_order != $selected_order){
					update_post_meta( $post_id, 'order', $selected_order);  
					update_post_meta( $selected_post_id, 'order', $previous_order);
				}
		  }
		  else{
		 // die('2');	
			 $count = $wpdb->get_var( "select count(*) from wp_postmeta where post_id in (SELECT post_id FROM wp_postmeta wpmt where wpmt.meta_key = 'projectname' and wpmt.meta_value ='$projectname') and meta_key = 'order'" );
		
			 update_post_meta( $post_id, 'order', $count+1);
		  }
		}
		else{
		//echo  $previous_order;
		//die('2');
			if (empty($previous_order) ){
			 $count = $wpdb->get_var( "select count(*) from wp_postmeta where post_id in (SELECT post_id FROM wp_postmeta wpmt where wpmt.meta_key = 'projectname' and wpmt.meta_value ='$projectname') and meta_key = 'order'" );
		
			 update_post_meta( $post_id, 'order', $count+1); 
			}
		}
		
          
    }   

    public function Projectupdates_metabox($post) {
        global  $wpdb;
         
        $postmetaArray = get_post_meta($post->ID);
       
        if (sizeof($postmetaArray) > 0) {
      
            $id = $postmetaArray['projectname'][0];
            $access  = $postmetaArray['access'][0];
            $display  = $postmetaArray['display'][0];
			$order  = $postmetaArray['order'][0];
               
        } else {
      
            $id ='';
            $access   = '';
            $display  =''; 
			$order =''; 
            
        }
      
        ?>
        <style>
        .disp-row {

        
        }
        
        .label {
            display: inline;
            width: 40%;
            float:left;
        
        }
        
        .input {
                display: inline-block;
                width:50%;
        }
        
        </style>
        <?php 
   
        $array_name = array();
        $args = array( 'post_type' => 'project','meta_key' =>'status','meta_value' =>'Active', 'posts_per_page' => -1 );
        $loop = new WP_Query( $args );
			  $i = 0; 
              while ( $loop->have_posts() ) : $loop->the_post();
                 $projectname = get_the_title();
                 $projectid = get_the_ID();
                 $array_name[$i]['name'] = $projectname;
                 $array_name[$i]['id'] = $projectid;
				 $i++;
              endwhile;
                
             wp_reset_query();            
       //echo "<pre>", print_r($array_name) ,"</pre>";
        echo "<div class='disp-row'>";
            echo "<div class='label'>\n";
                echo "<label for='Project'>Project</label>";
            echo "</div>\n";

            echo "<div class='input'>\n";
            
              echo "<select name='projectname' id='projectname'>\n";   
                   for($array_index=0;$array_index < sizeof($array_name); $array_index++) :
                   ?>
                    
                    <option value="<?php echo $array_name[$array_index]['id'] ?>"
					<?php if($id == $array_name[$array_index]['id'] ): ?> 
					selected="selected" <?php endif;?> ><?php echo $array_name[$array_index]['name']; ?></option>

                   <?php                
                    endfor;
              echo "</select>";
            echo "</div>";
        echo "</div>";
            
        
        // Field Defintion for Project Name
        echo "<div class='disp-row'>";
            echo "<div class='label'>\n";
                echo "<label for='Access'>Access</label>\n";
            echo "</div>\n";

            echo "<div class='input'>\n";?>
                <select size="0" id="access" name="access" class="rwmb-select">
                  <option value="" selected="selected">Select an Access</option>
                 <?php foreach($this->access as $value) :?>                    

                  <option value="<?php echo $value;?>" <?Php if($access == $value):?> selected="selected" <?php endif;?>><?php echo $value;?>
                  </option>
                 <?php endforeach;?>  
                </select>
           <?php 
           echo "</div>";
        echo "</div>";

 // Field Defintion for Display
        echo "<div class='disp-row'>";
            echo "<div class='label'>\n";
                echo "<label for='Display'>Display</label>\n";
            echo "</div>\n";

        echo "<div class='input'>\n";?>
                <select size="0" id="display" name="display" class="rwmb-select">
                  <option value="" selected="selected">Select an Display</option>
                 <?php 
                     for($i=1;$i<=count($this->display);$i++) :
                      if( $display == $i ):
                         echo"<option value='".$i."' selected='selected'>".$this->display[$i]." </option>"; 
                       else:
                         echo"<option value='".$i."'>".$this->display[$i]." </option>"; 
                       endif;
                      
                      endfor;
                  ?>  
                </select>
           <?php 
           echo "</div>";
        echo "</div>";
		
		// Field Defintion for order
        echo "<div class='disp-row'>";
            echo "<div class='label'>\n";
                echo "<label for='order'>Order</label>\n";
            echo "</div>\n";

		$sql = "SELECT  post_id , meta_value FROM wp_postmeta WHERE  post_id in (select post_id from wp_postmeta where meta_key = 'projectname' and meta_value = $id ) and meta_key = 'order' order by meta_value";
		//$order_meta = array();
		$result = $wpdb->get_results($sql, ARRAY_A);
		
	//echo"<pre>",print_r($result),"</pre>";

					
                     
        echo "<div class='input'>\n";?>
                <select size="0" id="order" name="order" class="rwmb-select">
                  <option value="" selected="selected">Select an Order</option>
                 <?php 
				 foreach( $result as $meta ) {
				  $combine = $meta['post_id']."_".$meta['meta_value'];
						   if( $meta['meta_value'] == $order ):
						  
						   echo"<option value='".$combine."' selected='selected'>".$meta['meta_value']." </option>"; 
						   else:
							 echo"<option value='".$combine."'>".$meta['meta_value']." </option>"; 
						   endif;
				 }  
                  ?>  
                </select>
           <?php 
		   
           echo "</div>";
        echo "</div>";
       
    }     

	  function restrict_manage_project() {
         if (isset($_GET['post_type']) && post_type_exists($_GET['post_type']) && in_array(strtolower($_GET['post_type']), array('projectupdate', 'here'))) {
        $this->wp_dropdown_custom_field(array(
            'show_option_all'    => 'Show all Projects',
            'show_option_none'    => false,
            'name'            => 'projects',
            'selected'        => !empty($_GET['projects']) ? $_GET['projects'] : "",
            'include_selected'    => false,
            'custom_filed' => 'projectname',
            'class' =>'',
            ));
        }
   }


function wp_dropdown_custom_field( $args = '' ) {

       global $wpdb;
       $name = 'ADMIN_FILTER_FIELD_VALUE';
        $id = "ADMIN_FILTER_FIELD_VALUE";
       $class = $args['class'];
       $show_option_all = $args['show_option_all'];
       $custom_filed  =  $args['custom_filed']; 
	  
	 
	
  
       $sql = 'SELECT DISTINCT meta_value FROM wp_postmeta where meta_key="'. $custom_filed.'" ORDER BY 1';
       $fields = $wpdb->get_results($sql, ARRAY_A);
   
        $output = '';

         if ( !empty($fields) || count($fields) > 1 ) {
                $output = "<select name='{$name}'{$id} class='$class'>\n";
            if ( $show_option_all )
                     $output .= "\t<option value=''>$show_option_all</option>\n";
                  $found_selected = false;
                    foreach ( (array) $fields as $field ) {
                        $field_value = $field['meta_value'];
                        $_selected = selected( $field_value, $selected, false );
                        if ( $_selected )
                            $found_selected = true;
							$projectname = get_the_title($field_value);
                        $output .= "\t<option value='$field_value'$_selected>" .$projectname. "</option>\n";
                  }
          $output .= "</select><input type='hidden' name='ADMIN_FILTER_FIELD_NAME' value='".$custom_filed."'/>";
          echo $output;
    }
 }
      function ovoid_admin_posts_filter( $query ) {
    
         global $pagenow;
         if ( is_admin() && $pagenow=='edit.php' && isset($_GET['ADMIN_FILTER_FIELD_NAME']) && $_GET['ADMIN_FILTER_FIELD_NAME'] != '') {
        $query->query_vars['meta_key'] = $_GET['ADMIN_FILTER_FIELD_NAME'];
        if (isset($_GET['ADMIN_FILTER_FIELD_VALUE']) && $_GET['ADMIN_FILTER_FIELD_VALUE'] != '')
            $query->query_vars['meta_value'] = $_GET['ADMIN_FILTER_FIELD_VALUE'];
      }
     }
}
?>

<?php

class Projects extends Listing
{
   private $custom_type = 'project';

   public function __construct() {
        
        // Create a new Post Type
        add_action( 'init', array($this, 'create_post_type' ));
        
        // Add the scripts of the Listing plugin (taken from Explorable Themes)
        add_action( 'admin_enqueue_scripts', array($this,'admin_scripts_styles') );
       
     
       // Call the projects_information_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projects_information_metabox' ));
        
        // Call the projects_user_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projects_user_metabox' ));

        // Call the projects_user_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projects_partner_metabox' ));

        // Call the projects_user_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projects_client_metabox' )); 

      // Call the exce_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projects_excerpt_metabox' )); 
        
        
        // Call the Projects_Location_Metabox when showing the post
        add_action( 'add_meta_boxes', array($this, 'init_projects_Location_metabox' )); 

        // Call the Save Post when av_unit is being saved
        add_action( 'save_post', array($this, 'save_projects_postdata' ));

       // Hook into the 'init' action
        add_action( 'init', array($this,'ovoid_projects_categories'), 0 );
 
       // Hook into the 'init' action
        add_action( 'init', array($this,'ovoid_projects_tags'), 0 ); 



    }

    // Create a new Post Type 
    public function create_post_type() {

   /*     $labels = array(
  'name'               => __( 'Glossary Terms',                   WPG_TEXTDOMAIN ),
  'singular_name'      => __( 'Glossary Term',                    WPG_TEXTDOMAIN ),
  'add_new'            => __( 'Add New Term',                     WPG_TEXTDOMAIN ),
  'add_new_item'       => __( 'Add New Glossary Term',            WPG_TEXTDOMAIN ),
  'edit_item'          => __( 'Edit Glossary Term',               WPG_TEXTDOMAIN ),
  'new_item'           => __( 'Add New Glossary Term',            WPG_TEXTDOMAIN ),
  'view_item'          => __( 'View Glossary Term',               WPG_TEXTDOMAIN ),
  'search_items'       => __( 'Search Glossary Terms',            WPG_TEXTDOMAIN ),
  'not_found'          => __( 'No Glossary Terms found',          WPG_TEXTDOMAIN ),
  'not_found_in_trash' => __( 'No Glossary Terms found in trash', WPG_TEXTDOMAIN )
);*/

$labels = array(
 
         
          'name'               => __( 'Projects',                   WPG_TEXTDOMAIN ),
          'singular_name'      => __( 'Project',                    WPG_TEXTDOMAIN ),
          'add_new'            => __( 'Add New Project',                     WPG_TEXTDOMAIN ),
          'add_new_item'       => __( 'Add New Ovoid Project',            WPG_TEXTDOMAIN ),
          'edit_item'          => __( 'Edit Ovoid Project',               WPG_TEXTDOMAIN ),
          'new_item'           => __( 'Add New Ovoid Project',            WPG_TEXTDOMAIN ),
          'view_item'          => __( 'View Ovoid Project',               WPG_TEXTDOMAIN ),
          'search_items'       => __( 'Search Ovoid Projects',            WPG_TEXTDOMAIN ),
          'not_found'          => __( 'No Ovoid Projects found',          WPG_TEXTDOMAIN ),
          'not_found_in_trash' => __( 'No Ovoid Projects found in trash', WPG_TEXTDOMAIN )
          
        );



        register_post_type( $this->custom_type,
            array(
                 
              'labels' => $labels,   
              'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => $this->custom_type),
                'supports' => array( 'title','editor','thumbnail' ),
            )   
        );
     register_taxonomy_for_object_type( 'category', 'posts' );
    }
    
    function ovoid_projects_categories()  {

	$labels_categories = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Categories', 'text_domain' ),
		'all_items'                  => __( 'All categories', 'text_domain' ),
		'parent_item'                => __( 'Parent category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent  category:', 'text_domain' ),
		'new_item_name'              => __( 'New category', 'text_domain' ),
		'add_new_item'               => __( 'Add new  category', 'text_domain' ),
		'edit_item'                  => __( 'Edit  category', 'text_domain' ),
		'update_item'                => __( 'Update category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'text_domain' ),
		'search_items'               => __( 'Search categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove  categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most categories', 'text_domain' ),
	);
	$args_categories = array(
		'labels'                     => $labels_categories,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
		register_taxonomy( 'ovoid_proj_cat_units', $this->custom_type, $args_categories );
	
}

    function ovoid_projects_tags()  {

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
		register_taxonomy( 'ovoid_proj_tag_taxonomy',$this->custom_type, $args_tags );
	
}


    // Showing the contents of the Metaboxes for Project_informations
    public function init_projects_information_metabox() {
        
         global $meta_boxes;
         $meta_boxes = array();
    
         $meta_boxes[] = array(
                'title' => __( 'Projects Information', 'rwmb' ),
                        // Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
                        'pages' => array('project' ),
                'fields' => array(

                     // project acronym
                    array(
                        'name' => __( 'Project Acronym', 'rwmb' ),
                        'id'   => "project_acronym",
                        'type' => 'text',

                    ),
                                        
                    //Status
                    array(
                        'name'     => __( 'Status', 'rwmb' ),
                        'id'       => "status",
                        'type'     => 'select',
                        // Array of 'value' => 'Label' pairs for select box
                        'options'  => array(
                            'Active' => __( 'Active', 'rwmb' ),
                            'Archived' => __( 'Archived', 'rwmb' ),
                            'Completed' => __( 'Completed', 'rwmb' ),
                            'Cancelled' => __( 'Cancelled', 'rwmb' ),  
                            
                        ),
                        
                        // Select multiple values, optional. Default is false.
                        'multiple'    => false,
                        'std'         => 'value2',
                        'placeholder' => __( 'Select an Status', 'rwmb' ),
                    ),
                    // Completion date
                    array(
                        'name' => __( 'Completion date', 'rwmb' ),
                        'id'   => "completion_date",
                        'type' => 'date',
                        
                        // jQuery date picker options. See here http://api.jqueryui.com/datepicker
                        'js_options' => array(
                            'appendText'      => __( '(dd-mm-yyyy)', 'rwmb' ),
                            'dateFormat'      => __( 'dd-mm-yy', 'rwmb' ),
                            'changeMonth'     => true,
                            'changeYear'      => true,
                            'showButtonPanel' => true,
                        ),
                    ),
                     //Status
                    array(
                        'name'     => __( 'Access', 'rwmb' ),
                        'id'       => "access",
                        'type'     => 'select',
                        // Array of 'value' => 'Label' pairs for select box
                        'options'  => array(
                            'Office' => __( 'Office', 'rwmb' ),
                            'Partners' => __( 'Partners', 'rwmb' ),
                            'Client' => __( 'Client', 'rwmb' ),
                            'Public' => __( 'Public', 'rwmb' ),  
                            
                        ),
                        
                        // Select multiple values, optional. Default is false.
                        'multiple'    => false,
                        'std'         => 'value3',
                        'placeholder' => __( 'Select an Access', 'rwmb' ),
                    ), 

                   
                    // Editor settings, see wp_editor() function: look4wp.com/wp_editor
                'options' => array(
                                'textarea_rows' => 4,
                                'teeny'         => true,
                                'media_buttons' => false,
                            ),
                                                     
                )
                
            );
                    
        
        global $meta_boxes;
        foreach ( $meta_boxes as $meta_box ) {
            new RW_Meta_Box( $meta_box );
        }
    }  
  

  public function init_projects_excerpt_metabox() {
        
        add_meta_box( 'project_excerpt', "Excerpt", array($this,'new_excerpt_metabox'), $this->custom_type, 'normal', 'low');
    }  


    // Showing the contents of the Metaboxes for Projects Team Members
    public function init_projects_user_metabox() {

     add_meta_box( 'projects_user', "Projects Team Members", array($this,'team_members_metabox'), $this->custom_type, 'normal', 'low');   
    }
    // Showing the contents of the Metaboxes for Projects Partners
    public function init_projects_partner_metabox() {

     add_meta_box( 'projects_partner', "Projects Partners", array($this,'partners_metabox'), $this->custom_type, 'normal', 'low');   
    }
      // Showing the contents of the Metaboxes for Projects clients
    public function init_projects_client_metabox() {

     add_meta_box( 'projects_client', "Projects Clients", array($this,'clients_metabox'), $this->custom_type, 'normal', 'low');   
    } 


   // Showing the contents of the Metaboxes for Projects_Location
    public function init_projects_Location_metabox() {

     add_meta_box( 'project_location', 'Projects Location', array($this,'et_listing_settings_meta_box'), $this->custom_type, 'advanced', 'high' ); 
    }  
    // call the metaboxes for team members
    public function team_members_metabox($post){

     $teamprojects = get_post_meta($post->ID, 'projects_team', false);
        $allteamProjects = $teamprojects[0];
        
        echo "<div class='teammember-repeat-wrapper'>\n";
        $teamtotal = 0;
        if (sizeof($allteamProjects) > 0) {
            
            foreach($allteamProjects as $key=>$projectinfo) {
            
                $teamtotal =$teamtotal +1; 
                $teammember_name="teammember_name_".$teamtotal;
                $teammember_div ="teammember_div_".$teamtotal;
                $teammember_name_container ="teammember_name_container".$teamtotal; 

                echo "<div class='teammember-repeat-fields'id='".$teammember_div."'>\n";
                echo "<label>Email</label><input name='teammemberemail[]' type='text' onchange=\"check_email(this".",'".$teammember_name."');\" class='teammember-email' style='vertical-align:top;' value='".$projectinfo['teammemberemail']."'>\n";
                echo "<div class ='team-members-name' id ='".$teammember_name_container."' style='display:inline'><label>Name</label><input name='teammembername[]' id ='".$teammember_name."' type='text' style='vertical-align:top;' value='".$projectinfo['teammembername']."' readonly='readonly'>\n";
                echo "<input type='button' value='-' onclick='removethis(".$teammember_div.")'></div>";
                echo "</div>";
             
            }
        } 
        echo "</div> <!-- repeat-wrapper -->\n";
        echo "<div><input type='button' value='Add a Team Member' onclick='addonemore()'></div>\n";
        ?>

        <script>
            var teamtotal =<?php echo $teamtotal ?>;
            function addonemore() {
                // $fields = jQuery();
                size = jQuery(".teammember-repeat-fields").size();
               /* if(jQuery('.teammember-email').length == 0)
                {
                 
                  teamtotal=1;               
                }
                else {
	            */   
	               teamtotal = teamtotal + 1;
               // }                
                teammember_name="teammember_name_"+teamtotal;
                teammember_div ="teammember_div_"+teamtotal;
                teammember_name_container ="teammember_name_container"+teamtotal; 
                
                   
                
                
                htmlText = '<div class="teammember-repeat-fields" id ='+teammember_div+'>'
                htmlText += '<label>Email</label><input name="teammemberemail[]" onchange="check_email(this'+',\''+teammember_name+'\');" class="teammember-email" style="vertical-align:top;" type="text">';
                htmlText += '<div class ="team-members-name" id ="'+teammember_name_container+'" style="display:inline"><label> Name</label><input name="teammembername[]" style="vertical-align:top;" type="text" id ='+teammember_name+'>';
                htmlText += '<input type="button" value="-" onclick="removethis('+teammember_div+')"></div>';
                htmlText += '</div>';
                jQuery(".teammember-repeat-wrapper").append(htmlText);
            }

            function removethis(removeIndex,obj) {
                size = jQuery(".teammember-repeat-fields").size();
                if (size == 1) 
                    return
                    
               // repObj = jQuery(".repeat-fields").get(removeIndex);
                 jQuery(removeIndex).remove();
            }
             function check_email(t,id){
    //ajax request 
    email = t.value;
   // alert ("<?php echo get_bloginfo('url') ?>");
    jQuery.ajax({
    
        url: "<?php echo get_bloginfo('url')?>/wp-admin/admin-ajax.php",
        data: {
            'action': 'ovoid_emailCheck', 
            'email' : email,
        },
        success: function(respon) {
        //alert(respon); 
            if(respon != 0) {
                jQuery("#"+id).val(respon);
                jQuery("#"+id).attr('readonly','readonly');
            }
            else {
                jQuery("#"+id).val('');
                jQuery("#"+id).removeAttr('readonly');
            }
        },
        error: function(respon, ajaxOptions, thrownError) {
        alert(respon.status);
        alert(thrownError);
        alert(ajaxOptions);
        }
        });
}
        </script>
        <?php



    }
    // call the metaboxes for partners
    public function partners_metabox($post){

        $partnerprojects = get_post_meta($post->ID, 'projects_partner', false);
        $allpartnerProjects = $partnerprojects[0];
        
        echo "<div class='partner-repeat-wrapper'>\n";
        $partotal = 0;
        if (sizeof($allpartnerProjects) > 0) {
            
            foreach($allpartnerProjects as $key=>$projectinfo) {
                $partotal = $partotal + 1;
                $partner_name="partner_name_".$partotal;
                $partner_div ="partner_div_".$partotal;
                $partner_name_container ="partner_name_container".$partotal;                

                echo "<div class='partner-repeat-fields' id =".$partner_div.">\n";
                echo "<label>Email</label><input name='partneremail[]' onchange=\"check_email(this".",'".$partner_name."');\" class='partner-email' type='text' style='vertical-align:top;' value='".$projectinfo['partneremail']."'>\n";
                echo "<div class ='partners-name' id ='".$partner_name_container."' style='display:inline'><label>Name</label><input name='partnername[]' type='text' id ='".$partner_name."' style='vertical-align:top;' value='".$projectinfo['partnername']."' readonly='readonly'>\n";
                echo "<input type='button' value='-' onclick='removepartner(".$partner_div.")'></div>";
                echo "</div>";
             
            }
        } 
        echo "</div> <!-- repeat-wrapper -->\n";
        echo "<div><input type='button' value='Add a Partner' onclick='addpartnermore()'></div>\n";
        ?>

        <script>
            var partotal = <?php echo $partotal ?>;
            function addpartnermore() {
                // $fields = jQuery();
                size = jQuery(".partner-repeat-fields").size();
               /* if(jQuery('.partner-email').length == 0)
                {
                 
                  partotal=1;               
                }
                else {
	            */   
	               partotal = partotal + 1;
                //}                
                partner_name="partner_name_"+partotal;
                partner_div ="partner_div_"+partotal;
                partner_name_container ="partner_name_container"+partotal; 
                
                htmlText = '<div class="partner-repeat-fields" id ='+partner_div+'>'
                htmlText += '<label>Email</label><input name="partneremail[]" onchange="check_email(this'+',\''+partner_name+'\');" class="partner-email" style="vertical-align:top;" type="text">';
                htmlText += '<div class ="partners-name" id ="'+partner_name_container+'" style="display:inline"><label> Name</label><input name="partnername[]" style="vertical-align:top;" type="text" id ='+partner_name+'>';
                htmlText += '<input type="button" value="-" onclick="removepartner('+partner_div+')"></div>';
                htmlText += '</div>';
                jQuery(".partner-repeat-wrapper").append(htmlText);
            }

            function removepartner(removeIndex,obj) {
                size = jQuery(".partner-repeat-fields").size();
                if (size == 1) 
                    return
                    
               // repObj = jQuery(".partner-repeat-fields").get(removeIndex);
                jQuery(removeIndex).remove();
            }
            function check_email(t,id){
    //ajax request 
    email = t.value;
   // alert ("<?php echo get_bloginfo('url') ?>");
    jQuery.ajax({
    
        url: "<?php echo get_bloginfo('url')?>/wp-admin/admin-ajax.php",
        data: {
            'action': 'ovoid_emailCheck', 
            'email' : email,
        },
        success: function(respon) {
        //alert(respon); 
            if(respon != 0) {
                jQuery("#"+id).val(respon);
                jQuery("#"+id).attr('readonly','readonly');
            }
            else {
                jQuery("#"+id).val('');
                jQuery("#"+id).removeAttr('readonly');
            }
        },
        error: function(respon, ajaxOptions, thrownError) {
        alert(respon.status);
        alert(thrownError);
        alert(ajaxOptions);
        }
        });
}
 
        </script>
        <?php



    }
  // call the metaboxes for Clients
   public function clients_metabox($post){

     $clientprojects = get_post_meta($post->ID, 'projects_client', false);
        $allclientProjects = $clientprojects[0];
        
        echo "<div class='client-repeat-wrapper'>\n";
        $total = 0;
        if (sizeof($allclientProjects) > 0) {
            
            foreach($allclientProjects as $key=>$projectinfo) {
                $total = $total + 1; 
                $client_name="client_name_".$total;
                $client_div ="client_div_".$total;
                $client_name_container ="client_name_container".$total;

                echo "<div class='client-repeat-fields' id ='".$client_div."'>\n";
                echo "<label>Email</label><input name='clientemail[]' type='text' onchange=\"check_email(this".",'".$client_name."');\" class='client-email' style='vertical-align:top;' value='".$projectinfo['clientemail']."'>\n";
                echo "<div class ='clients-name' id ='".$client_name_container."' style='display:inline'><label>Name</label><input name='clientname[]' type='text' id ='".$client_name."' style='vertical-align:top;' value='".$projectinfo['clientname']."' readonly='readonly'>\n";
                echo "<input type='button' value='-' onclick='removepartner(".$client_div.")'></div>";
                echo "</div>";
             
            }
        } 
        echo "</div> <!-- repeat-wrapper -->\n";
        echo "<div><input type='button' value='Add a Client' onclick='addclientmore()'></div>\n";
        ?>

        <script>
         var  total = <?php echo $total ?>;
            function addclientmore() {
                // $fields = jQuery();
                
                size = jQuery(".client-repeat-fields").size();
              /*  if(jQuery('.client-email').length == 0)
                {
                 
                  total=1;               
                }
                else {
	            */   
	               total = total + 1;
               // }
                client_name="client_name_"+total;
                client_div ="client_div_"+total;
                client_name_container ="client_name_container"+total; 
                htmlText = '<div class="client-repeat-fields" id ='+client_div+'>'
                htmlText += '<label>Email</label><input name="clientemail[]" onchange="check_email(this'+',\''+client_name+'\');" class="client-email" style="vertical-align:top;" type="text">';
                htmlText += '<div class ="clients-name" id ="'+client_name_container+'"  style="display:inline"><label> Name</label><input name="clientname[]" style="vertical-align:top;" type="text" id ='+client_name+'>';
                htmlText += '<input type="button" value="-" onclick="removeclient('+client_div+')"></div>';
                htmlText += '</div>';
                jQuery(".client-repeat-wrapper").append(htmlText);
            }

            function removeclient(removeIndex,obj) {
                size = jQuery(".client-repeat-fields").size();
                if (size == 1) 
                    return
                    
               // repObj = jQuery(".client-repeat-fields").get(removeIndex);
                jQuery(removeIndex).remove();
            }

            // jquery
        
   function check_email(t,id){
    //ajax request 
    email = t.value;
   // alert ("<?php echo get_bloginfo('url') ?>");
    jQuery.ajax({
    
        url: "<?php echo get_bloginfo('url')?>/wp-admin/admin-ajax.php",
        data: {
            'action': 'ovoid_emailCheck', 
            'email' : email,
        },
        success: function(respon) {
        //alert(respon); 
            if(respon != 0) {
                jQuery("#"+id).val(respon);
                jQuery("#"+id).attr('readonly','readonly');
            }
            else {
                jQuery("#"+id).val('');
                jQuery("#"+id).removeAttr('readonly');
            }
        },
        error: function(respon, ajaxOptions, thrownError) {
        alert(respon.status);
        alert(thrownError);
        alert(ajaxOptions);
        }
        });
}
 
        </script>
        <?php



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
                        <?php echo $excerpt; ?>
                     </textarea>
                     
                </div>
            </div>
<?php
    }


    // ovoidng the meta data when ovoidng the post
    public function save_projects_postdata( $post_id ) {
      global $post ;
        
        if( $post->post_type != "project" ) return $post_id;

        /*
        * We need to verify this came from the our screen and with proper authorization,
        * because save_post can be triggered at other times.
        */
        // Comment by Venkat - Removed the Nonce for the moment. Will do it later...

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
         //   return $post_id;
        
        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) )
                return $post_id;
        
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) )
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize user input.
        $project_acronym = sanitize_text_field( $_POST['project_acronym'] );
        $status = sanitize_text_field( $_POST['status'] );
        $completion_date = sanitize_text_field( $_POST['completion_date'] );
        $access = sanitize_text_field( $_POST['access'] );
        $excerpt = sanitize_text_field( $_POST['excerpt'] );

        $teamEmail_array = $_POST['teammemberemail'];
        $teamName_array = $_POST['teammembername'];

        $partnerEmail_array = $_POST['partneremail'];
        $partnerName_array = $_POST['partnername'];

        $clientEmail_array = $_POST['clientemail'];
        $clientName_array = $_POST['clientname'];
  
        $teamarraySize = sizeof($teamEmail_array);
        $teamprojects = array();
 
        $partnerarraySize = sizeof($partnerEmail_array);
        $partnerprojects = array();

        $clientarraySize = sizeof($clientEmail_array);
        $clientprojects = array();
        
        // get teammember mail and name list to store
        for ($teamarrayIndex=0;$teamarrayIndex<$teamarraySize; $teamarrayIndex++) {
                $teamEmail = $teamEmail_array[$teamarrayIndex];
                $teamName = $teamName_array[$teamarrayIndex];
              if(trim($teamEmail)!=""){
                if(trim($teamName)!=""){ 
                $projectInfo = array (  "teammemberemail" => $teamEmail,
                                        "teammembername" => $teamName,
                               );
                $teamprojects[$teamarrayIndex] = $projectInfo;
             
                    // create user account automatically if the user does not exists
                    if (email_exists($teamEmail) == false ) {
                       
                       $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	                   $user_id = wp_create_user( $teamName, $random_password, $teamEmail );
                    }

                }
             }   
        }        
      // get partner mail and name list to store
         for ($partnerarrayIndex=0;$partnerarrayIndex<$partnerarraySize; $partnerarrayIndex++) {
              $partnerEmail = $partnerEmail_array[$partnerarrayIndex];
              $partnerName = $partnerName_array[$partnerarrayIndex];
              if(trim($partnerEmail)!=""){
                if(trim($partnerName)!=""){ 
                  $projectInfo1 = array (  "partneremail" => $partnerEmail,
                                        "partnername" => $partnerName,
                               );
                  $partnerprojects[$partnerarrayIndex] = $projectInfo1;
                   // create user account automatically if the user does not exists
                    if (email_exists($partnerEmail) == false ) {
                       
                       $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	                   $user_id = wp_create_user( $partnerName, $random_password, $partnerEmail );
                    }
                 }
             }   
        }  
        // get client mail and name list to store
       for ($clientarrayIndex=0;$clientarrayIndex<$clientarraySize; $clientarrayIndex++) {
            $clientEmail = $clientEmail_array[$clientarrayIndex];
            $clientName = $clientName_array[$clientarrayIndex];
          if(trim($clientEmail)!=""){
            if(trim($clientName)!=""){ 
              $projectInfo2 = array (  "clientemail" => $clientEmail,
                                    "clientname" => $clientName,
                           );
              $clientprojects[$clientarrayIndex] = $projectInfo2;

               // create user account automatically if the user does not exists
                if (email_exists($clientEmail) == false ) {
                   
                   $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
	               $user_id = wp_create_user( $clientName, $random_password, $clientEmail );
                }
            }
         }   
        }  
                
        // Update the meta field in the database.

        update_post_meta( $post_id, 'project_acronym', $project_acronym);
        update_post_meta( $post_id, 'status', $status);
        update_post_meta( $post_id, 'completion_date', $completion_date);
        update_post_meta( $post_id, 'access', $access);
        update_post_meta( $post_id, 'excerpt', $excerpt);
 
        update_post_meta( $post_id, 'projects_team', $teamprojects);
        update_post_meta( $post_id, 'projects_partner', $partnerprojects);
        update_post_meta( $post_id, 'projects_client', $clientprojects);  

        $this->update_listing_fields($post_id);
     }   

}

?>

<?php
/**
 * Plugin Name: Williams Media Custom Interactions
 * Plugin URI: https://github.com/williams_media/Williams-Media-Custom-Interactions
 * Description: This is an Custom Media Interactions.
 * Version: 1.0.0
 * Author: Williams Media
 */

namespace williams_media;

if (!defined("ABSPATH")) {
  exit; 
}

class WilliamsMedia {
  public function __construct() {
   
  }
  public function load() {

    require_once(ABSPATH . 'wp-config.php'); 
    require_once(ABSPATH . 'wp-includes/wp-db.php'); 
    require_once(ABSPATH . 'wp-admin/includes/taxonomy.php'); 

    add_action( 'init', [$this,'wm_create_taxonomy'], 0 );
    add_action('admin_menu', [$this, 'add_plugin_options_page']);
    add_action('wm_create_own_category', [$this, 'wm_create_category']);
    add_action("wp_ajax_wm_ajax_settings", [$this,"wm_ajax_settings"]);
    add_action("wp_ajax_nopriv_wm_ajax_settings", [$this,"wm_ajax_settings"]);
    add_action("wp_ajax_wm_ajax_class_delete", [$this,"wm_ajax_class_delete"]);
    add_action("wp_ajax_nopriv_wm_ajax_class_delete", [$this,"wm_ajax_class_delete"]);    
    add_action('wp_enqueue_scripts', [$this,"wm_ajax_enqueuescripts"]);
    add_action('wp_enqueue_styles', [$this,"wm_ajax_enqueuestyles"]);
    do_action('wp_enqueue_scripts');
    do_action('wp_enqueue_styles');
  }
  function wm_create_taxonomy(){

    $labels = array(
      'name' => _x( 'Williams Media', '' ),
      'singular_name' => _x( 'williams_media', '' ),
      'search_items' =>  __( 'Search Williams Media' ),
      'all_items' => __( 'All Williams Media' ),
      'parent_item' => __( 'Parent Williams Media' ),
      'parent_item_colon' => __( 'Parent Williams Media:' ),
      'edit_item' => __( 'Edit Williams Media' ), 
      'update_item' => __( 'Update Williams Media' ),
      'add_new_item' => __( 'Add New Williams Media' ),
      'new_item_name' => __( 'New Williams Media Name' ),
      'menu_name' => __( 'Williams Media' ),
    );    
   
   
    register_taxonomy('williams_media',array('post'), array(
      'hierarchical' => true,
      'labels' => $labels,
      'show_ui' => true,
      'show_admin_column' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => 'williams_media' ),
    ));

    $cat_static_list = array('Fade','Moving','Scale');
    foreach($cat_static_list as $cat_item)
    {
        wp_insert_term($cat_item,'williams_media',array('description' => $cat_item,'slug'=> strtolower(str_replace(" ","-",$cat_item)),));
    }


  }
  function wm_ajax_enqueuescripts(){      
      wp_enqueue_script('ajaxloadpost', plugin_dir_url( __FILE__ ).'/admin/asset/js/wm-ajax.js', array('jquery'));
      wp_localize_script( 'ajaxloadpost', 'ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
      wp_enqueue_script('tableJs1', plugin_dir_url( __FILE__ )."/admin/asset/js/script.js");
      wp_enqueue_script('tableJs2', plugin_dir_url( __FILE__ )."/admin/asset/js/jquery.min.js");
      wp_enqueue_script('tableJs2', "https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js");// used to effect move text      
      wp_enqueue_script('tableJs3', plugin_dir_url( __FILE__ )."/admin/asset/js/bootstrap.min.js"); 
      
  }
  function wm_ajax_enqueuestyles(){    
   wp_enqueue_style('tablecss1', plugin_dir_url( __FILE__ )."/admin/asset/css/style.css");
    wp_enqueue_style('tablecss2', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css");     

  }
  function add_plugin_options_page() {
    add_menu_page( 'Williams Media', 'Williams Media', 'manage_options','williams_media', [$this, 'render_admin_page'], '', plugins_url('WilliamsMedia/public/media/image/icon.png'), 90 );
  }
  function render_admin_page() {
    do_action('wp_enqueue_styles');
    include_once(dirname(__FILE__).'/include/template-classes-table.php');
    do_action('wp_enqueue_scripts');
  }
  function wm_ajax_settings(){
    if (is_admin() && $_POST['action'] == "wm_ajax_settings") {
      $option_data = array();
      $williams_media = get_option('williams_media');
      $skip_one = false;
      foreach($_POST as $key => $value){
        $data_arr = explode(',',$value);
        if($key != 'action'){
          foreach($williams_media as $effect_id => $class_arr){
            foreach($class_arr as $class_name){
              if($class_name == $data_arr[1])
              {
                //if($data_arr[2] == $effect_id)
                {
                  if($skip_one){ 
                    echo json_encode(array('status'=>false,'error' => "exist")); exit;
                  }
                  else{
                    $skip_one = true;
                  }
                }
              }
            }
          }
        }       
      }
      foreach($_POST as $key => $value)
      {
          if($key != 'action')
          {
              $data_arr = explode(',',$value);
              $index = $data_arr[0];
              $class_name = $data_arr[1];
              $effect = $data_arr[2];
              if(!is_array($option_data[$effect])){$option_data[$effect] = array();}
              array_push($option_data[$effect],$class_name);
          }        
      }
      update_option('williams_media', $option_data);
      echo json_encode(array('status'=>true));
      exit;

    }
    else
    {
        echo json_encode(array('status'=>false,'error'=>'unauthorized'));
    }
  }
  function wm_ajax_class_delete(){
    if (is_admin() && $_POST['action'] == "wm_ajax_class_delete") {

    $term_key = $_POST['term_key'];
    $class_name_del = $_POST['class_name'];
    
    $williams_media = get_option('williams_media');
    $option_data = array();

    foreach($williams_media as $key => $value){
        foreach($value as $class_name)
        {
          if($class_name != $class_name_del)
          {
            if(!is_array($option_data[$key])){$option_data[$key] = array();}
            array_push($option_data[$key],$class_name);
          }
        }
    }
    update_option('williams_media', $option_data);
    print_r($option_data);
    echo json_decode(array('status'=>true));
    exit;
    }
  }

}

if (is_admin()) {
  $plugin = new WilliamsMedia();
  $plugin->load();
}

class wm_public_script_load
{
  public function __construct() {
   
  }
  public function load() {
    add_action( 'wp_head',  [$this,'wm_public_style_list'] );
    add_action( 'wp_footer',  [$this,'wm_public_script_list'] );

  }

  function wm_public_style_list()
  {
    wp_enqueue_script( 'my-custom-script',plugin_dir_url( __FILE__ ) .'/public/asset/js/effect_1/wm-public.js', array( 'jquery' ) );
    wp_enqueue_style('effect1', plugin_dir_url( __FILE__ )."/public/asset/css/effect_1/jquerysctipttop.css");
  }
  
  function wm_public_script_list(){
    include_once(dirname(__FILE__).'/include/effect/fade.php');
    include_once(dirname(__FILE__).'/include/effect/moving.php');
    include_once(dirname(__FILE__).'/include/effect/scale.php');
    include_once(dirname(__FILE__).'/include/effect/effect1.php');
    include_once(dirname(__FILE__).'/include/effect/effect2.php');
    include_once(dirname(__FILE__).'/include/effect/effect3.php');
    include_once(dirname(__FILE__).'/include/effect/effect4.php');
    }

}



$plugin_script = new wm_public_script_load();
$plugin_script->load();


<?php

//     CODE SAMPLE


function get_editable_roles() {
	global $wp_roles;
	if ( ! isset( $wp_roles ) )
		$wp_roles = new WP_Roles();

	return $wp_roles->get_names();
}

function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}

function REST_is_logged_in($user_id)
{
    return get_user_meta( $user_id, 'session_tokens', true ); 
}


function generateRandomString($length = 4) {

    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


// DEVELOPER UNABLE TO CHECK CODE JS
$(document).keydown(function (event) {
	if (event.keyCode == 123) { // Prevent F12
		return false;
	} else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
		return false;
	}
});

$(document).ready(function() {
	$(document)[0].oncontextmenu = function() { return false; }
	$(document).mousedown(function(e) {
		if( e.button == 2 ) {
			alert('Sorry, this functionality is disabled!');
			return false;
		} else {
		return true;
		}
	});
});


// Google address search 
?>
<script>
        google_place_search(document.getElementById('origin'));
        google_place_search(document.getElementById('destination'));
        
        function google_place_search(input)
        {
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed',   function () {
            
                var place = autocomplete.getPlace();
                var lat = place.geometry.location.lat();
                var long = place.geometry.location.lng();
                console.log(lat + ", " + long);
            });
        }

/* Ajax form submission with image */

jQuery("form").submit(function(e)    {
e.preventDefault();
e.stopImmediatePropagation();
	e.stopPropagation();	


        var formdata = new FormData();
        var img = jQuery('input[name="channel_img"]')[0].files[0];
        var title = jQuery('#channel_name').val();
        var cat = jQuery('#cat').val();
        var detail = jQuery('#channel_detail').val();
        
        formdata.append("img", img);
        formdata.append("title", title);
        formdata.append("cat", cat);
        formdata.append("detail", detail);
        formdata.append("action", 'create_cst_post');
        formdata.append("type", 'wpstream_product');
        
          jQuery.ajax({
            type: 'POST',
            url: '<?=admin_url("admin-ajax.php")?>',
            traditional: true,
            processData: false,
	contentType: false,
            data:formdata,
            success: function (response)
	{
		post_id = response.post_id;
 console.log(response);
            },
            error: function (jqXHR,textStatus,errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
             
            }
        });
});

</script>
<?php

add_action("wp_ajax_admin_comment_on_user", "admin_comment_on_user");
add_action("wp_ajax_nopriv_admin_comment_on_user", "admin_comment_on_user");
function admin_comment_on_user(){}

 ?>

<!-- Add script in footer -->
<?php

function myscript() { ?> 
<script type="text/javascript"> 
if ( undefined !== window.jQuery ) { // script dependent on jQuery }
 </script> <?php } 
add_action( 'wp_footer', 'myscript' );
?>
/*  element view on screen event */
<script type="text/javascript"> 
jQuery(window).scroll(function() {
    var top_of_element = jQuery("#video-8186-1_html5").offset().top;
    var bottom_of_element = jQuery("#video-8186-1_html5").offset().top + jQuery("#video-8186-1_html5").outerHeight();
    var bottom_of_screen = jQuery(window).scrollTop() + jQuery(window).innerHeight();
    var top_of_screen = jQuery(window).scrollTop();

    if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
        jQuery('#video-8186-1_html5').trigger('play');
            var video = jQuery('#video-8186-1_html5').get(0);
            if ( video.paused ) {               jQuery('#video-8186-1_html5').trigger('play');
            } 
    } else {
       
    }
});
</script>


/*  current user role */
<?php
$user = new WP_User( get_current_user_id() );

if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
    foreach ( $user->roles as $role )
        echo $role;
}
?>


	/*  remove emoji code javascript*/
const line_text = jQuery(this).val();

  resp = Array.from(line_text, x => {let theUnicode = x.charCodeAt(0).toString(16); while (theUnicode.length < 4) {theUnicode = '0' + theUnicode; } if (theUnicode < '00ff') {return x;}}).join('');


jQuery(this).val(resp);


// Sending mail with javascript code

$.ajax({
 type: "POST",
 url: "https://mandrillapp.com/api/1.0/messages/send.json",
 data: {
   'key': 'YOUR API KEY HERE',
   'message': {
     'from_email': 'YOUR@EMAIL.HERE',
     'to': [
         {
           'email': 'RECIPIENT_NO_1@EMAIL.HERE',
           'name': 'RECIPIENT NAME (OPTIONAL)',
           'type': 'to'
         },
         {
           'email': 'RECIPIENT_NO_2@EMAIL.HERE',
           'name': 'ANOTHER RECIPIENT NAME (OPTIONAL)',
           'type': 'to'
         }
       ],
     'autotext': 'true',
     'subject': 'YOUR SUBJECT HERE!',
     'html': 'YOUR EMAIL CONTENT HERE! YOU CAN USE HTML!'
   }
 }
}).done(function(response) {
  console.log(response); // if you're into that sorta thing
});
==============================================

/*************** search location by address and radious *************************/
$tableName = "db.table";
$origLat = 42.1365;
$origLon = -71.7559;
$dist = 10; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
$query = "SELECT name, latitude, longitude, 3956 * 2 * 
          ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
          +COS($origLat*pi()/180 )*COS(latitude*pi()/180)
          *POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
          as distance FROM $tableName WHERE 
          longitude between ($origLon-$dist/cos(radians($origLat))*69) 
          and ($origLon+$dist/cos(radians($origLat))*69) 
          and latitude between ($origLat-($dist/69)) 
          and ($origLat+($dist/69)) 
          having distance < $dist ORDER BY distance limit 100"; 
$result = mysql_query($query) or die(mysql_error());



/************drag and drop image then see preview **********/
http://www.inwebson.com/html5/html5-drag-and-drop-file-upload-with-canvas/


/*********** Send CSV file in correct formate link *************/
https://ziplineinteractive.com/blog/proper-php-headers-for-csv-documents-all-browsers/


/*********** End link *************/
/************** Link of scrolling content detect div is reach pr not *********/
http://jsbin.com/eyojaz/1/edit?html,js,output

/****** end link ********/

/***************** Simple Modal Popup link ************/
https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal

/****************** End link **********************/

/**************** for scrolling UP and DOWN ******************/


var lastScrollTop = 0;
    $(window).on('scroll', function() {
        st = $(this).scrollTop();
        if(st < lastScrollTop) {
            console.log('up 1');
        }
        else {
            console.log('down 1');
        }
        lastScrollTop = st;
    })

/************** APPLY CSS IN IFRAME ****************/

$('#id').load(function(){
$("#id").contents().find("#buddypress").css("margin-top", "-100px");
});


/********* Uploading files and images with AJAX ***********/
$('#bac-img').change(function(){
if (this.files && this.files[0] ){				    	
		        var reader = new FileReader();
		        //var p_id = jQuery("#post_ID").val();
		        reader.readAsDataURL(this.files[0]);
		    }
		    var file_data = jQuery('#bac-img').prop('files')[0];  
			var form_data = new FormData();                  
			form_data.append('bacimg', file_data); 
			$.ajax({
			url: '../wp-content/themes/Divi/custom_calender/image-upload-ajax.php', 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(response){
					}	});
		      });

/**************** Woocommerce Hook link ******************/
https://gist.github.com/anderly/264754af7f8ddd942dd9

/******** ADDING EXTRA COLUMN IN WOOCOMMERCE ADMIN SITE *******/
add_filter('manage_edit-film_columns', 'my_columns');
function my_columns($columns) {
    $columns['views'] = 'Views';
    return $columns;
}
Actually, the hook manage_edit-${post_type}_columns takes an argument $columns which is an array of all registered columns. To add a new column, just add a new element to this array, like this:


/****** upload image PROGRESS BAR ******/
/*** adding this in ajax code before success ******/
xhr: function() {
          var myXhr = jQuery.ajaxSettings.xhr();
           if(myXhr.upload){
                       myXhr.upload.addEventListener('progress',progress, false);
                    }
              return myXhr;
        },
success: function(response){
	 jQuery("#progBar").hide();
}


function progress(e){
        if(e.lengthComputable){
            jQuery('progress').attr({value:e.loaded,max:e.total});
            var percentage = (e.loaded / e.total) * 100;
            jQuery('#prog').html(percentage.toFixed(0)+'%');
        }
    }
 
    function resetProgressBar() {
        jQuery('#prog').html('0%');
        jQuery('progress').attr({value:0,max:100});
    }
/**********************************End Code*************************************************/


/*************************  Changing wordpress Email header Filter *********************************/

// Change default WP email sender
add_filter('wp_mail_from', 'doEmailFilter');
add_filter('wp_mail_from_name', 'doEmailNameFilter');

function doEmailFilter($email_address){
if($email_address === "wordpress@webdevelopment11.com")
    return 'blrrid@webdevelopment11.com';
else
    return $email_address;
}
function doEmailNameFilter($email_from){
if($email_from === "WordPress")
    return 'Blrrid';
else
    return $email_from;
}



/************************* Adding wordpress media *************************/
<?php 
  wp_enqueue_script('jquery');
  // This will enqueue the Media Uploader script
  wp_enqueue_media();
?>
    <div>
    <label for="image_url">Image</label>
    <input type="text" name="image_url" id="image_url" class="regular-text">
    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">

</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#image_url').val(image_url);
        });
    });
});
</script>
/************************* End code *************************/

/************************ Enqueue Style and Script ********************/

wp_enqueue_style( 'style-name', plugin_dir_url( _FILE_ ) . 'custom-style.css' );
wp_enqueue_script( 'script-name', plugin_dir_url( _FILE_ ) .' custom-script.js');

/************************* End code *************************/


/************* Contact form7 adding Captcha ****************/

[captchac captcha-21] [captchar captcha-31]

/************* End Shortcode ********************/

/************* Wordpress Login Code ****************/

Note : this code put before get_header();
$creds = array();
    $creds['user_login'] = $_POST['email'];
    $creds['user_password'] = $_POST['pwd'];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );
    if(isset($user->ID)){
    wp_clear_auth_cookie();
    wp_set_current_user ( $user->ID );
    wp_set_auth_cookie  ( $user->ID );
    $redirect_to = get_site_url();//user_admin_url();
    wp_safe_redirect( $redirect_to );
/************* End Shortcode ********************/

/*custom code for Custom Post display display*/
add_action( 'init', 'codex_book_init',1 );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_book_init() {
	$labels = array(
		'name'               => _x( 'Propertys', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'property', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Propertys', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'property', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'property', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New property', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Property', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Property', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Property', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Propertys', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Propertys', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Propertys:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Propertys found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Propertys found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'property' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'property', $args );
}

function taxonomy_slug_rewrite($wp_rewrite) {
    $rules = array();
    // get all custom taxonomies
    $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
    // get all custom post types
    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');

    foreach ($post_types as $post_type) {
        foreach ($taxonomies as $taxonomy) {

            // go through all post types which this taxonomy is assigned to
            foreach ($taxonomy->object_type as $object_type) {

                // check if taxonomy is registered for this custom type
                if ($object_type == $post_type->rewrite['slug']) {
                    // get category objects
                    $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));

                    // make rules
                    foreach ($terms as $term) {
                        $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    }
                }
            }
        }
    }
    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');

/*custom code for Custom Post display end*/


/***** htaccess rules for https *****/
RewriteCond %{SERVER_PORT} !^443$
RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
/********** end code *******/



/******************************check div content size**********************/
<script>
$.fn.textWidth = function(text, font) {
    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
    $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
    return $.fn.textWidth.fakeEl.width();
};
 
$('.text-preview').on('keypress', function(event) {
  if(event.keyCode==13){
   		event.preventDefault();
  }
  
  
  if($(this).textWidth() > $('.text-preview').width()-30 ){
    event.preventDefault();
  }
}).trigger('input');
</script>

/******************************end check div content size**********************/



/************************Remove menu from wp-admin panel ***************/
add_action( 'admin_menu', 'my_remove_menu_pages' );

function my_remove_menu_pages() {
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  remove_menu_page( 'edit.php?post_type=acf' );
  remove_menu_page( 'wpcf7' );


};
/******************************end Remove menu from wp-admin panel**********************/

/****************************** Placeholder hide on focus ******************************/
Input:focus::placeholder{
	opacity:0;
}
/******************************End code ******************************/

/******************************Get Exact mouse position in canvas ******************************/
function getRelativeMousePosition(event, target) {
			target = target || event.target;
			var rect = target.getBoundingClientRect();

			return {
			    x: event.clientX - rect.left,
			    y: event.clientY - rect.top,
			}
		}

		// assumes target or event.target is canvas
function getNoPaddingNoBorderCanvasRelativeMousePosition(event, target) {
			target = target || event.target;
			var pos = getRelativeMousePosition(event, target);

			pos.x = pos.x * target.width  / target.clientWidth;
			pos.y = pos.y * target.height / target.clientHeight;

			return pos;  
		}
       	const pos = getNoPaddingNoBorderCanvasRelativeMousePosition(e, canvas);

  		mouse_at.x = pos.x;
  		mouse_at.y = pos.y;


/******************************End code ******************************/
/******************* Admin Ajax wordpress *************************/
var url = "<?php echo admin_url('admin-ajax.php'); ?>";

    jQuery.ajax({

           type: 'post',
           url: url,
           data: {action:'action_name',form_data:jQuery("#idForm").serialize()},
           success: function(data)           {	

           }
         });

function function_name(){

	die();

}

  add_action( 'wp_ajax_action_name', 'functon_name' );    // If called from admin panel
  add_action('wp_ajax_nopriv_action_name', 'functon_name' );

************************************get size of text*********************************************
function getWidthOfText(txt, fontname, fontsize){
		if(getWidthOfText.c === undefined){
			getWidthOfText.c=document.createElement('canvas');
			getWidthOfText.ctx=getWidthOfText.c.getContext('2d');
		}
		getWidthOfText.ctx.font = fontsize + ' ' + fontname;
		return getWidthOfText.ctx.measureText(txt).width;
	}



************************************end get size of text*********************************************




***************************************hide show menu for difrent users**************************
function wpse31748_exclude_menu_items( $items, $menu, $args ) {
    // Iterate over the items to search and destroy
    foreach ( $items as $key => $item ) {
        if ( $item->object_id == 26 && is_user_logged_in() ){
			unset( $items[$key] );
		}else if(!is_user_logged_in() && ( $item->object_id == 88 || $item->object_id == 100)){
			unset( $items[$key] );
		}else if(is_user_logged_in() &&  $item->object_id == 88 &&  get_user_meta(get_current_user_id(),'custom_role',true)=='laundry_user'){
			unset( $items[$key] );
		}else if(is_user_logged_in() &&  $item->object_id == 100 &&  get_user_meta(get_current_user_id(),'custom_role',true)=='laundry_admin'){
			unset( $items[$key] );
		}
    }

    return $items;
}

add_filter( 'wp_get_nav_menu_items', 'wpse31748_exclude_menu_items', null, 3 );
***************************************end hide show menu for difrent users**************************




********************************* Set & destroy cookie in jQuery **********************************
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="text/javascript">
	$("#add").click(function(){
		$.cookie('login-vault', '1');
	});
	$("#delete").click(function(){
		 var date = new Date();
         var m = 10;
		 date.setTime(date.getTime() - (m * 60 * 1000));
		 $.cookie('login-vault', '1', { expires: date });
	});
******************************** End cookie in jQuery ************************************

****************************** https tricks link ********************************************

https://www.eukhost.com/kb/3-simple-ways-to-redirect-a-website-from-http-to-https/

function redirectTohttps() {
if($_SERVER['HTTPS']!="on") {

$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

header("Location:$redirect"); } }

************************************** End link *************************************

**********************************Wocommerce Zipcode function********************************

Add code in function.php file :

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_postcode_field' );
function custom_override_default_postcode_field( $address_fields ) {
    // Your postcodes array
    $postcode_array = array(
        'opt1' => "001122",
        'opt2' => "112200",
        'opt3' => "334400"
    );
    $address_fields['postcode']['type'] = 'select';
    $address_fields['postcode']['options'] = $postcode_array;

    return $address_fields;
}
*******************************end Wocommerce Zipcode function****************************



************************Start Woocommerce product Invisible code*******************************
Put in functions.php File 

//Removes links
add_filter( 'woocommerce_product_is_visible','product_invisible');
function product_invisible(){
    return false;
}

//Remove single page
add_filter( 'woocommerce_register_post_type_product','hide_product_page',12,1);
function hide_product_page($args){
    $args["publicly_queryable"]=false;
    $args["public"]=false;
    return $args;
}
************************End Woocommerce product Invisible code*********************************


************************  Css Loader  *********************************

	.class_name {
   border: 6px solid #f3f3f3;
   border-radius: 50%;
   border-top: 6px solid #3498db;
   border-bottom: 6px solid #3498db;
   width: 20px;
   height: 20px;
   -webkit-animation: spin 2s linearinfinite;
   animation: spin 2s linearinfinite;
}

********************* Time Ago **********************

function timeago($date) {
		$timestamp = strtotime($date);	
						   
		$strTime = array("second", "minute", "hour", "day", "month", "year");
		$length = array("60","60","24","30","12","10");

		$currentTime = time();
		if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
					$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return $diff . " " . $strTime[$i] . "(s) ago ";
			}
		}

================Wordpress auto login to user ==============
 	    wp_clear_auth_cookie();
                wp_set_current_user( $user );
                wp_set_auth_cookie( $user );


=============== CURL WORKING LIKE BROWSER WORK ==============

function getUrlContent($url) {
    fopen("cookies.txt", "w");
    $parts = parse_url($url);
    $host = $parts['host'];
    $ch = curl_init();
    $header = array('GET /1575051 HTTP/1.1',
        "Host: {$host}",
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language:en-US,en;q=0.8',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Host:adfoc.us',
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
    );

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);

    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

$url = "http://adfoc.us/1575051";
$html = getUrlContent($url);

REFERENCE LINK: https://stackoverflow.com/questions/17363545/file-get-contents-is-not-working-for-some-url



************************************ CURL FOR API CALL *****************************************

function getUrlContent($url) {
  
    $parts = parse_url($url);
    $host = $parts['host'];
    $ch = curl_init();
    $header = array('GET /1575051 HTTP/1.1',
        "Host: {$host}",
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language:en-US,en;q=0.8',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Authorization:Bearer 7f9318bb-4d99-4b32-8cdc-b7d8b9cf8459',
        
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
    );

    curl_setopt($ch, CURLOPT_URL, $url);
   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);


 
 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}




/***** From multiple array get keys ******/

function array_keys_multi(array $array)
{
    $keys = array();
    foreach ($array as $key => $value) {
        $keys[] = $key;
        if (is_array($array[$key])) {
            $keys = array_merge($keys, array_keys_multi($array[$key]));
        }
    }
    return $keys;
}


000webhost.com
files.000webhost.com
elfish-rotor
hunani@123



=================================================

// get web page response through php function

function get_web_page($url) {
	$options = array(
	CURLOPT_RETURNTRANSFER => true,   // return web page
	CURLOPT_HEADER         => false,  // don't return headers
	CURLOPT_FOLLOWLOCATION => true,   // follow redirects
	CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
	CURLOPT_ENCODING       => "",     // handle compressed
	CURLOPT_USERAGENT      => "test", // name of client
	CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
	CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
	CURLOPT_TIMEOUT        => 120,    // time-out on response
	); 
	
	$ch = curl_init($url);
	curl_setopt_array($ch, $options);
	
	$content  = curl_exec($ch);
	
	curl_close($ch);
	
	return $content;
}



=============================================
Related Products in woocommerce modify code for same category product show:
==============================================

add_filter("woocommerce_related_products", "show_same_cat_related_products",10,3);

function show_same_cat_related_products($related_posts,$product_id,$limit_array){
    global $woocommerce;
    
    $cats_array = array('');
    $product = wc_get_product( $product_id );
    
    $terms = wp_get_post_terms($product_id, 'School');
    foreach ( $terms as $key => $term ){
        $check_for_children = get_categories(array('parent' => $term->term_id, 'taxonomy' => 'School'));
        
        if(empty($check_for_children)){
            $cats_array[] = $term->term_id;
        }
    }
  
    if ( sizeof($cats_array)==1 ) return array();
 
    $meta_query = array();
    $meta_query[] = $woocommerce->query->visibility_meta_query();
    $meta_query[] = $woocommerce->query->stock_status_meta_query();
    $meta_query   = array_filter( $meta_query );
   
    $related_posts = get_posts( array(
            'orderby'        => 'rand',
            'posts_per_page' => 4,
            'post_type'      => 'product',
            'fields'         => 'ids',
            'meta_query'     => $meta_query,
            'tax_query'      => array(
                'relation'      => 'OR',
                array(
                    'taxonomy'     => 'School',
                    'field'        => 'id',
                    'terms'        => $cats_array
                )
            )
        ) );
        
     $related_posts = array_diff($related_posts, array( $product->id ), $product->get_upsells() );
     $limit_array['limit'] = 4;
     return $related_posts;
 }  

/*************** search location by address and radious *************************/
$tableName = "db.table";
$origLat = 42.1365;
$origLon = -71.7559;
$dist = 10; // This is the maximum distance (in miles) away from $origLat, $origLon in which to search
$query = "SELECT name, latitude, longitude, 3956 * 2 * 
          ASIN(SQRT( POWER(SIN(($origLat - latitude)*pi()/180/2),2)
          +COS($origLat*pi()/180 )*COS(latitude*pi()/180)
          *POWER(SIN(($origLon-longitude)*pi()/180/2),2))) 
          as distance FROM $tableName WHERE 
          longitude between ($origLon-$dist/cos(radians($origLat))*69) 
          and ($origLon+$dist/cos(radians($origLat))*69) 
          and latitude between ($origLat-($dist/69)) 
          and ($origLat+($dist/69)) 
          having distance < $dist ORDER BY distance limit 100"; 
$result = mysql_query($query) or die(mysql_error());



/************drag and drop image then see preview **********/
http://www.inwebson.com/html5/html5-drag-and-drop-file-upload-with-canvas/


/*********** Send CSV file in correct formate link *************/
https://ziplineinteractive.com/blog/proper-php-headers-for-csv-documents-all-browsers/


/*********** End link *************/
/************** Link of scrolling content detect div is reach pr not *********/
http://jsbin.com/eyojaz/1/edit?html,js,output

/****** end link ********/

/***************** Simple Modal Popup link ************/
https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal

/****************** End link **********************/

/**************** for scrolling UP and DOWN ******************/


var lastScrollTop = 0;
    $(window).on('scroll', function() {
        st = $(this).scrollTop();
        if(st < lastScrollTop) {
            console.log('up 1');
        }
        else {
            console.log('down 1');
        }
        lastScrollTop = st;
    })

/************** APPLY CSS IN IFRAME ****************/

$('#id').load(function(){
$("#id").contents().find("#buddypress").css("margin-top", "-100px");
});


/********* Uploading files and images with AJAX ***********/
$('#bac-img').change(function(){
if (this.files && this.files[0] ){				    	
		        var reader = new FileReader();
		        //var p_id = jQuery("#post_ID").val();
		        reader.readAsDataURL(this.files[0]);
		    }
		    var file_data = jQuery('#bac-img').prop('files')[0];  
			var form_data = new FormData();                  
			form_data.append('bacimg', file_data); 
			$.ajax({
			url: '../wp-content/themes/Divi/custom_calender/image-upload-ajax.php', 
			dataType: 'text',  
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(response){
					}	});
		      });

/**************** Woocommerce Hook link ******************/
https://gist.github.com/anderly/264754af7f8ddd942dd9

/******** ADDING EXTRA COLUMN IN WOOCOMMERCE ADMIN SITE *******/
add_filter('manage_edit-film_columns', 'my_columns');
function my_columns($columns) {
    $columns['views'] = 'Views';
    return $columns;
}
Actually, the hook manage_edit-${post_type}_columns takes an argument $columns which is an array of all registered columns. To add a new column, just add a new element to this array, like this:


/****** upload image PROGRESS BAR ******/
/*** adding this in ajax code before success ******/
xhr: function() {
          var myXhr = jQuery.ajaxSettings.xhr();
           if(myXhr.upload){
                       myXhr.upload.addEventListener('progress',progress, false);
                    }
              return myXhr;
        },
success: function(response){
	 jQuery("#progBar").hide();
}


function progress(e){
        if(e.lengthComputable){
            jQuery('progress').attr({value:e.loaded,max:e.total});
            var percentage = (e.loaded / e.total) * 100;
            jQuery('#prog').html(percentage.toFixed(0)+'%');
        }
    }
 
    function resetProgressBar() {
        jQuery('#prog').html('0%');
        jQuery('progress').attr({value:0,max:100});
    }
/**********************************End Code*************************************************/


/*************************  Changing wordpress Email header Filter *********************************/

// Change default WP email sender
add_filter('wp_mail_from', 'doEmailFilter');
add_filter('wp_mail_from_name', 'doEmailNameFilter');

function doEmailFilter($email_address){
if($email_address === "wordpress@webdevelopment11.com")
    return 'blrrid@webdevelopment11.com';
else
    return $email_address;
}
function doEmailNameFilter($email_from){
if($email_from === "WordPress")
    return 'Blrrid';
else
    return $email_from;
}



/************************* Adding wordpress media *************************/
<?php 
  wp_enqueue_script('jquery');
  // This will enqueue the Media Uploader script
  wp_enqueue_media();
?>
    <div>
    <label for="image_url">Image</label>
    <input type="text" name="image_url" id="image_url" class="regular-text">
    <input type="button" name="upload-btn" id="upload-btn" class="button-secondary" value="Upload Image">

</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('#upload-btn').click(function(e) {
        e.preventDefault();
        var image = wp.media({ 
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
        .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            // Output to the console uploaded_image
            console.log(uploaded_image);
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#image_url').val(image_url);
        });
    });
});
</script>
/************************* End code *************************/

/************************ Enqueue Style and Script ********************/

wp_enqueue_style( 'style-name', plugin_dir_url( _FILE_ ) . 'custom-style.css' );
wp_enqueue_script( 'script-name', plugin_dir_url( _FILE_ ) .' custom-script.js');

/************************* End code *************************/


/************* Contact form7 adding Captcha ****************/

[captchac captcha-21] [captchar captcha-31]

/************* End Shortcode ********************/

/************* Wordpress Login Code ****************/

Note : this code put before get_header();
$creds = array();
    $creds['user_login'] = $_POST['email'];
    $creds['user_password'] = $_POST['pwd'];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );
    if(isset($user->ID)){
    wp_clear_auth_cookie();
    wp_set_current_user ( $user->ID );
    wp_set_auth_cookie  ( $user->ID );
    $redirect_to = get_site_url();//user_admin_url();
    wp_safe_redirect( $redirect_to );
/************* End Shortcode ********************/

/*custom code for Custom Post display display*/
add_action( 'init', 'codex_book_init',1 );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_book_init() {
	$labels = array(
		'name'               => _x( 'Propertys', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'property', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Propertys', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'property', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'property', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New property', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Property', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Property', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Property', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Propertys', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Propertys', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Propertys:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Propertys found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Propertys found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'property' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'property', $args );
}

function taxonomy_slug_rewrite($wp_rewrite) {
    $rules = array();
    // get all custom taxonomies
    $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
    // get all custom post types
    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');

    foreach ($post_types as $post_type) {
        foreach ($taxonomies as $taxonomy) {

            // go through all post types which this taxonomy is assigned to
            foreach ($taxonomy->object_type as $object_type) {

                // check if taxonomy is registered for this custom type
                if ($object_type == $post_type->rewrite['slug']) {
                    // get category objects
                    $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));

                    // make rules
                    foreach ($terms as $term) {
                        $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    }
                }
            }
        }
    }
    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');

/*custom code for Custom Post display end*/


/***** htaccess rules for https *****/
RewriteCond %{SERVER_PORT} !^443$
RewriteRule (.*) https://%{HTTP_HOST}%{REQUEST_URI} [R=301,L]
/********** end code *******/



/******************************check div content size**********************/
<script>
$.fn.textWidth = function(text, font) {
    if (!$.fn.textWidth.fakeEl) $.fn.textWidth.fakeEl = $('<span>').hide().appendTo(document.body);
    $.fn.textWidth.fakeEl.text(text || this.val() || this.text()).css('font', font || this.css('font'));
    return $.fn.textWidth.fakeEl.width();
};
 
$('.text-preview').on('keypress', function(event) {
  if(event.keyCode==13){
   		event.preventDefault();
  }
  
  
  if($(this).textWidth() > $('.text-preview').width()-30 ){
    event.preventDefault();
  }
}).trigger('input');
</script>

/******************************end check div content size**********************/



/************************Remove menu from wp-admin panel ***************/
add_action( 'admin_menu', 'my_remove_menu_pages' );

function my_remove_menu_pages() {
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit-comments.php' );          //Comments
  remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
  remove_menu_page( 'options-general.php' );        //Settings
  remove_menu_page( 'edit.php?post_type=acf' );
  remove_menu_page( 'wpcf7' );


};
/******************************end Remove menu from wp-admin panel**********************/

/****************************** Placeholder hide on focus ******************************/
Input:focus::placeholder{
	opacity:0;
}
/******************************End code ******************************/

/******************************Get Exact mouse position in canvas ******************************/
function getRelativeMousePosition(event, target) {
			target = target || event.target;
			var rect = target.getBoundingClientRect();

			return {
			    x: event.clientX - rect.left,
			    y: event.clientY - rect.top,
			}
		}

		// assumes target or event.target is canvas
function getNoPaddingNoBorderCanvasRelativeMousePosition(event, target) {
			target = target || event.target;
			var pos = getRelativeMousePosition(event, target);

			pos.x = pos.x * target.width  / target.clientWidth;
			pos.y = pos.y * target.height / target.clientHeight;

			return pos;  
		}
       	const pos = getNoPaddingNoBorderCanvasRelativeMousePosition(e, canvas);

  		mouse_at.x = pos.x;
  		mouse_at.y = pos.y;


/******************************End code ******************************/
/******************* Admin Ajax wordpress *************************/
var url = "<?php echo admin_url('admin-ajax.php'); ?>";

    jQuery.ajax({

           type: 'post',
           url: url,
           data: {action:'action_name',form_data:jQuery("#idForm").serialize()},
           success: function(data)           {	

           }
         });

function function_name(){

	die();

}

  add_action( 'wp_ajax_action_name', 'functon_name' );    // If called from admin panel
  add_action('wp_ajax_nopriv_action_name', 'functon_name' );

************************************get size of text*********************************************
function getWidthOfText(txt, fontname, fontsize){
		if(getWidthOfText.c === undefined){
			getWidthOfText.c=document.createElement('canvas');
			getWidthOfText.ctx=getWidthOfText.c.getContext('2d');
		}
		getWidthOfText.ctx.font = fontsize + ' ' + fontname;
		return getWidthOfText.ctx.measureText(txt).width;
	}



************************************end get size of text*********************************************




***************************************hide show menu for difrent users**************************
function wpse31748_exclude_menu_items( $items, $menu, $args ) {
    // Iterate over the items to search and destroy
    foreach ( $items as $key => $item ) {
        if ( $item->object_id == 26 && is_user_logged_in() ){
			unset( $items[$key] );
		}else if(!is_user_logged_in() && ( $item->object_id == 88 || $item->object_id == 100)){
			unset( $items[$key] );
		}else if(is_user_logged_in() &&  $item->object_id == 88 &&  get_user_meta(get_current_user_id(),'custom_role',true)=='laundry_user'){
			unset( $items[$key] );
		}else if(is_user_logged_in() &&  $item->object_id == 100 &&  get_user_meta(get_current_user_id(),'custom_role',true)=='laundry_admin'){
			unset( $items[$key] );
		}
    }

    return $items;
}

add_filter( 'wp_get_nav_menu_items', 'wpse31748_exclude_menu_items', null, 3 );
***************************************end hide show menu for difrent users**************************




********************************* Set & destroy cookie in jQuery **********************************
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script type="text/javascript">
	$("#add").click(function(){
		$.cookie('login-vault', '1');
	});
	$("#delete").click(function(){
		 var date = new Date();
         var m = 10;
		 date.setTime(date.getTime() - (m * 60 * 1000));
		 $.cookie('login-vault', '1', { expires: date });
	});
******************************** End cookie in jQuery ************************************

****************************** https tricks link ********************************************

https://www.eukhost.com/kb/3-simple-ways-to-redirect-a-website-from-http-to-https/

function redirectTohttps() {
if($_SERVER['HTTPS']!="on") {

$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

header("Location:$redirect"); } }

************************************** End link *************************************

**********************************Wocommerce Zipcode function********************************

Add code in function.php file :

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_postcode_field' );
function custom_override_default_postcode_field( $address_fields ) {
    // Your postcodes array
    $postcode_array = array(
        'opt1' => "001122",
        'opt2' => "112200",
        'opt3' => "334400"
    );
    $address_fields['postcode']['type'] = 'select';
    $address_fields['postcode']['options'] = $postcode_array;

    return $address_fields;
}
*******************************end Wocommerce Zipcode function****************************



************************Start Woocommerce product Invisible code*******************************
Put in functions.php File 

//Removes links
add_filter( 'woocommerce_product_is_visible','product_invisible');
function product_invisible(){
    return false;
}

//Remove single page
add_filter( 'woocommerce_register_post_type_product','hide_product_page',12,1);
function hide_product_page($args){
    $args["publicly_queryable"]=false;
    $args["public"]=false;
    return $args;
}
************************End Woocommerce product Invisible code*********************************


************************  Css Loader  *********************************

	.class_name {
   border: 6px solid #f3f3f3;
   border-radius: 50%;
   border-top: 6px solid #3498db;
   border-bottom: 6px solid #3498db;
   width: 20px;
   height: 20px;
   -webkit-animation: spin 2s linearinfinite;
   animation: spin 2s linearinfinite;
}

********************* Time Ago **********************

function timeago($date) {
		$timestamp = strtotime($date);	
						   
		$strTime = array("second", "minute", "hour", "day", "month", "year");
		$length = array("60","60","24","30","12","10");

		$currentTime = time();
		if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
					$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			return $diff . " " . $strTime[$i] . "(s) ago ";
			}
		}

================Wordpress auto login to user ==============
 	    wp_clear_auth_cookie();
                wp_set_current_user( $user );
                wp_set_auth_cookie( $user );


=============== CURL WORKING LIKE BROWSER WORK ==============

function getUrlContent($url) {
    fopen("cookies.txt", "w");
    $parts = parse_url($url);
    $host = $parts['host'];
    $ch = curl_init();
    $header = array('GET /1575051 HTTP/1.1',
        "Host: {$host}",
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language:en-US,en;q=0.8',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Host:adfoc.us',
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
    );

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);

    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

$url = "http://adfoc.us/1575051";
$html = getUrlContent($url);

REFERENCE LINK: https://stackoverflow.com/questions/17363545/file-get-contents-is-not-working-for-some-url



************************************ CURL FOR API CALL *****************************************

function getUrlContent($url) {
  
    $parts = parse_url($url);
    $host = $parts['host'];
    $ch = curl_init();
    $header = array('GET /1575051 HTTP/1.1',
        "Host: {$host}",
        'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language:en-US,en;q=0.8',
        'Cache-Control:max-age=0',
        'Connection:keep-alive',
        'Authorization:Bearer 7f9318bb-4d99-4b32-8cdc-b7d8b9cf8459',
        
        'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116 Safari/537.36',
    );

    curl_setopt($ch, CURLOPT_URL, $url);
   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);


 
 
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}




/***** From multiple array get keys ******/

function array_keys_multi(array $array)
{
    $keys = array();
    foreach ($array as $key => $value) {
        $keys[] = $key;
        if (is_array($array[$key])) {
            $keys = array_merge($keys, array_keys_multi($array[$key]));
        }
    }
    return $keys;
}


000webhost.com
files.000webhost.com
elfish-rotor
hunani@123











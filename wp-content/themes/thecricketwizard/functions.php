<?php
require_once('modal/class.Base.php');
require_once('modal/class.Team.php');
require_once('modal/class.Competition.php');
require_once(STYLESHEETPATH . '/includes/wordpress-tweaks.php');
loadVCTemplates();
add_action( 'wp_enqueue_scripts', 'p_enqueue_styles');
function p_enqueue_styles() {
    wp_enqueue_style( 'bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css?' . filemtime(get_stylesheet_directory() . '/css/bootstrap.min.css'));
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?' . filemtime(get_stylesheet_directory() . '/css/font-awesome.css'));
    wp_enqueue_style( 'understrap-theme', get_stylesheet_directory_uri() . '/style.css?' . filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400');
    wp_enqueue_style( 'sigmar', 'https://fonts.googleapis.com/css?family=Sigmar+One');
    wp_enqueue_style( 'sofia', 'https://fonts.googleapis.com/css?family=Princess+Sofia');
    wp_enqueue_style( 'lato', 'https://fonts.googleapis.com/css?family=Lato:400,700');
    wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js?' . filemtime(get_stylesheet_directory() . '/js/bootstrap.min.js'), array('jquery'));
    wp_enqueue_script('understap-theme', get_stylesheet_directory_uri() . '/js/theme.js?' . filemtime(get_stylesheet_directory() . '/js/theme.js'), array('jquery'));

    // Ensure Visual Composer is loaded on all pages so we can take advantage of animations
    wp_enqueue_script( 'wpb_composer_front_js' );
    wp_enqueue_style( 'js_composer_front' );
    wp_enqueue_style( 'js_composer_custom_css' );
    wp_enqueue_style( 'animate-css' );
    wp_enqueue_script( 'waypoints' );
}
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

// Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_filter( 'vc_load_default_templates', 'p_vc_load_default_templates' ); // Hook in
function p_vc_load_default_template( $data ) {
    return array();
}

function register_my_session(){
    if( ! session_id() ) {
        session_start();
    }
}
add_action('init', 'register_my_session');

// make sure team id is always set.  Home page and pavilion page only pages that don't need team id set.
if($post->ID <> 4 || $post->ID <> 21) {
    // check session
    if(!isset($_SESSION['cw']['teamid'])) {
        //$url = get_permalink( 21 );
        //wp_redirect($url);
        //exit;
    }
}

add_action('cred_save_data', 'my_save_data_action',10,2);
function my_save_data_action($post_id, $form_data)
{
    /************ Adding New Players ****************/
    // add team id when adding in new players
    if ($form_data['id']==32)
    {
        // add it to saved post meta
        update_post_meta($post_id, 'wpcf-player-team-id', $_SESSION['cw']['teamid']);
    }
    if ($form_data['id']==32)
    {
        /************ Adding New Competition ****************/
        update_post_meta($post_id, 'wpcf-competition-team-id', $_SESSION['cw']['teamid']);
    }
}


/*************** Registering new player ***************/
function create_user_from_registration($cfdata) {
    if (!isset($cfdata->posted_data) && class_exists('WPCF7_Submission')) {
        // Contact Form 7 version 3.9 removed $cfdata->posted_data and now
        // we have to retrieve it from an API
        $submission = WPCF7_Submission::get_instance();
        if ($submission) {
            $formdata = $submission->get_posted_data();
        }
    } elseif (isset($cfdata->posted_data)) {
        // For pre-3.9 versions of Contact Form 7
        $formdata = $cfdata->posted_data;
    } else {
        // We can't retrieve the form data
        return $cfdata;
    }
    // Check this is the user registration form
    if ( $cfdata->title() == 'Registration Form') {
        //$password = wp_generate_password( 12, false );
        $email = $formdata['email'];
        $name = $formdata['fullname'];
        $password = $formdata['r_password'];
        // Construct a username from the user's name
        $username = $formdata['r_username'];
        $name_parts = explode(' ',$name);
        if ( !email_exists( $email ) ) {
            // Find an unused username
            $username_tocheck = $username;
            $i = 1;
            while ( username_exists( $username_tocheck ) ) {
                $username_tocheck = $username . $i++;
            }
            $username = $username_tocheck;
            // Create the user
            $userdata = array(
                'user_login' => $username,
                'user_pass' => $password,
                'user_email' => $email,
                'nickname' => reset($name_parts),
                'display_name' => $name,
                'first_name' => reset($name_parts),
                'last_name' => end($name_parts),
                'role' => 'subscriber'
            );
            $user_id = wp_insert_user( $userdata );
            if ( !is_wp_error($user_id) ) {
                // Email login details to user
                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                $message = "Welcome! Your login details are as follows:" . "\r\n";
                $message .= sprintf(__('Username: %s'), $username) . "\r\n";
                $message .= sprintf(__('Password: %s'), $password) . "\r\n";
                $message .= wp_login_url() . "\r\n";
                //wp_mail($email, sprintf(__('[%s] Your username and password'), $blogname), $message);
                //auto login

            }
        }
    }
    return $cfdata;
}
add_action( 'wp_footer', 'mycustom_wp_footer' );

function mycustom_wp_footer() {
    ?>
    <script type="text/javascript">
        document.addEventListener( 'wpcf7mailsent', function( event ) {
            location = '/register-team/';
        }, false );
    </script>
    <?php
}

add_action('wpcf7_before_send_mail', 'create_user_from_registration', 1);

function getTeams() {
    $teams = Array();
    $post_array = get_posts([
        'post_type' => 'team',
        'post_status' => 'published',
        'numberposts' => -1,
        'orderby' => 'post_title',
        'order' => 'ASC'
    ]);
    foreach($post_array as $post) {
        $team = new Team($post);
        $teams[] = $team;
    }
    return $teams;
}

function getCompetitions($teamid) {
    $comps = Array();
    $posts_array = get_posts([
        'post_type' => 'competition',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'post_title',
        'order' => 'ASC',
        'meta_query' => [
            [
                'key' => 'wpcf-competition-team-id',
                'value' => $teamid
            ]
        ]
    ]);
    foreach ($posts_array as $post) {
        $comp = new Compeition($post);
        $comps[] = $comp;
    }
    return $comps;
}

function displayTeamAdminLogin() {
    // check if anyone is logged in
    $html = '';
    if(is_user_logged_in()) {
        // Team Admin is logged in
        $html = 'logged in';
    } else {
        $html = '
        <h4>Team Administrator</h4>
        <a href="javascript:;" class="btn btn-primary login-btn">Login</a>';
    }
    return $html;
}

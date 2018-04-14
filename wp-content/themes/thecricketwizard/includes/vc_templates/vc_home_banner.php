<?php
vc_map( array(
    "name"                    => __( "Home Banner" ),
    "base"                    => "cw_home_banner",
    "category"                => __( 'Content' ),
    'icon' => 'icon-wpb-single-image',
    "params" => array(
        array(
            "type" => "attach_image",
            "heading" => __("Banner Image"),
            "param_name" => "banner",
        ),
    )
) );

add_shortcode( 'cw_home_banner', 'homeBanner' );

function homeBanner($atts) {
    $args = shortcode_atts( array(
        'banner' => ''
    ), $atts);
    $imageid= intval($args['banner']);
    $img = wp_get_attachment_image_src($imageid, 'full');
    $html = '
    <div class="home-banner">
        <img src="' . $img[0] . '" alt="" />
        <div class="banner-cta">
            <div class="title">Manage your cricket team online</div>
            <p>Register your team for free and receive a Team Administrator login account. This account allows you to manage your team - add players to your team roster; add matches your team plays; and enter the scorecard data from that match.</p>
            <a href="javascript:;" class="btn btn-primary register" onclick="openModal(registrationModal);">Register Now</a>         
        </div>
    </div>';

    return $html;
}
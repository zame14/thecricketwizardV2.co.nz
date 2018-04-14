<?php
$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">
    <section id="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="logo-wrapper">
                        <a href="<?=get_home_url()?>">
                            <span class="the">The</span>
                            <span class="cricket">cricket</span>
                            <span class="wizard">Wizard</span>
                        </a>
                    </div>
                    <div class="login-screen-wrapper">
                        <?=displayTeamAdminLogin()?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * After setup theme hook
 */
function fashion_diva_theme_setup(){
    /*
     * Make chile theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'fashion-diva', get_stylesheet_directory() . '/languages' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'secondary' => esc_html__( 'Secondary', 'fashion-diva' ),
    ) );
}
add_action( 'after_setup_theme', 'fashion_diva_theme_setup' );

function fashion_diva_styles() {
    	$my_theme = wp_get_theme();
    	$version = $my_theme['Version'];
        
        if( blossom_fashion_is_woocommerce_activated() ){
            $dependencies = array( 'blossom-fashion-woocommerce', 'owl-carousel', 'animate', 'blossom-fashion-google-fonts' );  
        }else{
            $dependencies = array( 'owl-carousel', 'animate', 'blossom-fashion-google-fonts' );
        }

        wp_enqueue_style( 'fashion-diva-parent-style', get_template_directory_uri() . '/style.css', $dependencies );
        
        wp_enqueue_script( 'fashion-diva', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), $version, true );
        
        $array = array( 
            'rtl'       => is_rtl()
        ); 
        wp_localize_script( 'fashion-diva', 'fashion_diva_data', $array );
    }
add_action( 'wp_enqueue_scripts', 'fashion_diva_styles', 10 );

//Remove a function from the parent theme
function remove_parent_filters(){ //Have to do it after theme setup, because child theme functions are loaded first
    remove_action( 'customize_register', 'blossom_fashion_customizer_theme_info' );
    remove_action( 'customize_register', 'blossom_fashion_customize_register' );
    remove_action( 'customize_register', 'blossom_fashion_customize_register_appearances' );
    remove_action( 'wp_enqueue_scripts', 'blossom_fashion_dynamic_css', 99 );

}
add_action( 'init', 'remove_parent_filters' );

/**
*   Fashion Diva Body Classes
**/
function blossom_fashion_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    $home_layout = get_theme_mod( 'home_layout', 'two' );

    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }
    
    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image custom-background';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color custom-background';
    }

    if ( $home_layout == 'two' && is_front_page() ) {
        $classes[] = 'homepage-layout-two';
    }
    
    $classes[] = blossom_fashion_sidebar_layout();

    return $classes;
}

/**
*   Fashion Diva customize_register
**/
if( ! function_exists( 'fashion_diva_customize_register ') ):
    function fashion_diva_customize_register( $wp_customize ){

        /** DEMO & DOCUMENTATION */
        $wp_customize->add_section(
            'theme_info',
            array(
                'title'     => __( 'Demo & Documentation', 'fashion-diva' ),
                'priority'  => 6,
            )
        );

        /** Important Links */
        $wp_customize->add_setting(
            'theme_info_link',
            array(
                'default'   => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $theme_info  = '<p>';
        $theme_info .= sprintf( __( '%1$sDemo Link:%2$s %3$sClick here.%4$s', 'fashion-diva' ),'<strong>', '</strong>',  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=fashion-diva' ) . '" target="_blank">', '</a>' );
        $theme_info .= '</p><p>';
        $theme_info .= sprintf( __( '%1$sDocumentation Link:%2$s %3$sClick here.%4$s', 'fashion-diva' ),'<strong>', '</strong>',  '<a href="' . esc_url( 'https://docs.blossomthemes.com/docs/fashion-diva/' ) . '" target="_blank">', '</a>' );
        $theme_info .= '</p>';

        $wp_customize->add_control( new Blossom_Fashion_Note_Control( $wp_customize,
                'theme_info_link',
                array(
                    'section'       => 'theme_info',
                    'description'   => $theme_info,
                ) 
            )
        );

        /** === APPEARANCE === */

        /** Add postMessage support for site title and description */
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'background_color' )->transport = 'refresh';
        $wp_customize->get_setting( 'background_image' )->transport = 'refresh';
        
        if ( isset( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial( 'blogname', array(
                'selector'        => '.site-title a',
                'render_callback' => 'blossom_fashion_customize_partial_blogname',
            ) );
            $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
                'selector'        => '.site-description',
                'render_callback' => 'blossom_fashion_customize_partial_blogdescription',
            ) );
        }
        
        /** Site Title Font */
        $wp_customize->add_setting( 
            'site_title_font', 
            array(
                'default' => array(                                         
                    'font-family' => 'Rouge Script',
                    'variant'     => 'regular',
                ),
                'sanitize_callback' => array( 'Blossom_Fashion_Fonts', 'sanitize_typography' )
            ) 
        );

        $wp_customize->add_control( 
            new Blossom_Fashion_Typography_Control( 
                $wp_customize, 
                'site_title_font', 
                array(
                    'label'       => __( 'Site Title Font', 'fashion-diva' ),
                    'description' => __( 'Site title and tagline font.', 'fashion-diva' ),
                    'section'     => 'title_tagline',
                    'priority'    => 60, 
                ) 
            ) 
        );
        
        /** Site Title Font Size*/
        $wp_customize->add_setting( 
            'site_title_font_size', 
            array(
                'default'           => 60,
                'sanitize_callback' => 'blossom_fashion_sanitize_number_absint'
            ) 
        );
        
        $wp_customize->add_control(
            new Blossom_Fashion_Slider_Control( 
                $wp_customize,
                'site_title_font_size',
                array(
                    'section'     => 'title_tagline',
                    'label'       => __( 'Site Title Font Size', 'fashion-diva' ),
                    'description' => __( 'Change the font size of your site title.', 'fashion-diva' ),
                    'priority'    => 65,
                    'choices'     => array(
                        'min'   => 10,
                        'max'   => 200,
                        'step'  => 1,
                    )                 
                )
            )
        );

        /** === APPEARANCE === */

        /** Typography */
        $wp_customize->add_section(
            'typography_settings',
            array(
                'title'    => __( 'Typography', 'fashion-diva' ),
                'priority' => 10,
                'panel'    => 'appearance_settings',
            )
        );

        /** Primary Font */
        $wp_customize->add_setting(
            'primary_font',
            array(
                'default'           => 'Muli',
                'sanitize_callback' => 'blossom_fashion_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Blossom_Fashion_Select_Control(
                $wp_customize,
                'primary_font',
                array(
                    'label'       => __( 'Primary Font', 'fashion-diva' ),
                    'description' => __( 'Primary font of the site.', 'fashion-diva' ),
                    'section'     => 'typography_settings',
                    'choices'     => blossom_fashion_get_all_fonts(),  
                )
            )
        );
        /** Secondary Font */
        $wp_customize->add_setting(
            'secondary_font',
            array(
                'default'           => 'EB Garamond',
                'sanitize_callback' => 'blossom_fashion_sanitize_select'
            )
        );

        $wp_customize->add_control(
            new Blossom_Fashion_Select_Control(
                $wp_customize,
                'secondary_font',
                array(
                    'label'       => __( 'Secondary Font', 'fashion-diva' ),
                    'description' => __( 'Secondary font of the site.', 'fashion-diva' ),
                    'section'     => 'typography_settings',
                    'choices'     => blossom_fashion_get_all_fonts(),  
                )
            )
        );
        
        /** Font Size*/
        $wp_customize->add_setting( 
            'font_size', 
            array(
                'default'           => 18,
                'sanitize_callback' => 'blossom_fashion_sanitize_number_absint'
            ) 
        );
        
        $wp_customize->add_control(
            new Blossom_Fashion_Slider_Control( 
                $wp_customize,
                'font_size',
                array(
                    'section'     => 'typography_settings',
                    'label'       => __( 'Font Size', 'fashion-diva' ),
                    'description' => __( 'Change the font size of your site.', 'fashion-diva' ),
                    'choices'     => array(
                        'min'   => 10,
                        'max'   => 50,
                        'step'  => 1,
                    )                 
                )
            )
        );

        /** Primary Color*/
        $wp_customize->add_setting( 
            'primary_color', array(
                'default'           => '#e7cfc8',
                'sanitize_callback' => 'sanitize_hex_color'
            ) 
        );

        $wp_customize->add_control( 
            new WP_Customize_Color_Control( 
                $wp_customize, 
                'primary_color', 
                array(
                    'label'       => __( 'Primary Color', 'fashion-diva' ),
                    'description' => __( 'Primary color of the theme.', 'fashion-diva' ),
                    'section'     => 'colors',
                    'priority'    => 5,                
                )
            )
        );

        /** LAYOUT SETTINGS PANEL */
        $wp_customize->add_panel(
            'layout_settings',
            array(
                'title'    => __( 'Layout Settings', 'fashion-diva' ),
                'priority' => 45,   
            )
        );

        /** Header Layout */
        $wp_customize->add_section(
            'header_layout_settings',
            array(
                'title'     => __( 'Header Layout', 'fashion-diva' ),
                'panel'     => 'layout_settings',
                'priority'  => 10,
            )
        );
        /** Blog Page layout */
        $wp_customize->add_setting( 
            'header_layout', 
            array(
                'default'           => 'two',
                'sanitize_callback' => 'blossom_fashion_sanitize_radio'
            ) 
        );
        
        $wp_customize->add_control(
            new Blossom_Fashion_Radio_Image_Control(
                $wp_customize,
                'header_layout',
                array(
                    'section'   => 'header_layout_settings',
                    'label'     => __( 'Header Layout', 'fashion-diva' ),
                    'description'   => __( 'This is the available layout for header', 'fashion-diva' ),
                    'choices'       => array(
                        'one'   => get_stylesheet_directory_uri(). '/images/header/header-one.jpg',
                        'two'   => get_stylesheet_directory_uri(). '/images/header/header-two.jpg',

                    )
                )
            )
        );

        /** Slider Layouts */
        $wp_customize->add_section(
            'slider_layout_settings',
            array(
                'title'     => __( 'Slider Layouts', 'fashion-diva' ),
                'panel'     => 'layout_settings',
                'priority'  => 20,
            )
        );

        $wp_customize->add_setting( 
            'slider_layout', 
            array(
                'default'           => 'two',
                'sanitize_callback' => 'blossom_fashion_sanitize_radio'
            ) 
        );


        $wp_customize->add_control(
        new Blossom_Fashion_Radio_Image_Control(
            $wp_customize,
            'slider_layout',
                array(
                    'section'     => 'slider_layout_settings',
                    'label'       => __( 'Slider Layout', 'fashion-diva' ),
                    'description' => __( 'Choose the layout of the slider for your site.', 'fashion-diva' ),
                    'choices'     => array(
                        'one'   => get_stylesheet_directory_uri() . '/images/slider/slider-one.jpg',
                        'two'   => get_stylesheet_directory_uri() . '/images/slider/slider-two.jpg',
                    )
                )
            )
        );


        /** Home Page Layouts */
        $wp_customize->add_section(
            'home_layout_settings',
            array(
                'title'     => __( 'Home Page Layouts', 'fashion-diva' ),
                'panel'     => 'layout_settings',
                'priority'  => 30,
            )
        );

        $wp_customize->add_setting( 
            'home_layout', 
            array(
                'default'           => 'two',
                'sanitize_callback' => 'blossom_fashion_sanitize_radio'
            ) 
        );

        $wp_customize->add_control(
            new Blossom_Fashion_Radio_Image_Control(
                $wp_customize,
                'home_layout',
                    array(
                        'section'     => 'home_layout_settings',
                        'label'       => __( 'Home Page Layout', 'fashion-diva' ),
                        'description' => __( 'Choose the layout of the home page for your site.', 'fashion-diva' ),
                        'choices'     => array(
                            'one'   => get_stylesheet_directory_uri() . '/images/home/home-one.jpg',
                            'two'   => get_stylesheet_directory_uri() . '/images/home/home-two.jpg',
                    )
                )
            )
        );
    }
endif;
add_action( 'customize_register', 'fashion_diva_customize_register', 40 );

function blossom_diva_single_post_hooks(){
    add_action( 'blossom_fashion_single_post_before_entry_content', 'blossom_fashion_entry_header', 15 );
    add_action( 'blossom_fashion_single_post_before_entry_content', 'blossom_fashion_post_thumbnail', 20 );
    add_action( 'blossom_fashion_single_post_entry_content', 'blossom_fashion_entry_content', 15 );
    add_action( 'blossom_fashion_single_post_entry_content', 'blossom_fashion_entry_footer', 20 );
}
add_action( 'init', 'blossom_diva_single_post_hooks', 20 );


/** HEADER SECTION */
function blossom_fashion_header(){
    $header_layout = get_theme_mod( 'header_layout', 'two' );
    $ed_cart = get_theme_mod( 'ed_shopping_cart', true ); ?>

     <header id="masthead" class="site-header<?php if( $header_layout == 'two' ) echo ' header-two' ;?>" itemscope itemtype="http://schema.org/WPHeader">
        <div class="header-holder">
            <div class="header-t">
                <div class="container">                        
                  <?php
                    if( $header_layout == 'one' ){ ?>
                        <div class="row">
                            <div class="col">
                                <?php get_search_form(); ?>
                            </div>
                            <div class="col">
                                <?php fashion_diva_site_branding(); ?>
                            </div>
                            <div class="col">
                                <div class="tools">
                                    <?php 
                                    if( blossom_fashion_social_links( false ) || ( blossom_fashion_is_woocommerce_activated() && $ed_cart ) ){
                                        if( blossom_fashion_is_woocommerce_activated() && $ed_cart ) blossom_fashion_wc_cart_count();
                                        if( blossom_fashion_is_woocommerce_activated() && $ed_cart && blossom_fashion_social_links( false ) ) echo '<span class="separator"></span>';
                                        blossom_fashion_social_links();
                                    }                                    
                                    ?>
                                </div>
                            </div>
                        </div><!-- .row-->
                    <?php }  ?>  

                    <?php if($header_layout == 'two') { ?>
                        <?php fashion_diva_secondary_navigation(); ?>

                        <?php 
                            if( blossom_fashion_social_links( false ) || ( blossom_fashion_is_woocommerce_activated() && $ed_cart ) || get_search_form( false ) ){ ?>
                                 <div class="right">
                                    <div class="tools">
                                     <?php 
                                        if( blossom_fashion_is_woocommerce_activated() && $ed_cart ) blossom_fashion_wc_cart_count();
                                        ?>
                                        <div class="form-section">
                                            <button aria-label="<?php esc_attr_e( 'search toggle', 'fashion-diva' ); ?>" id="btn-search" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"><i class="fa fa-search"></i></button>
                                            <div class="form-holder search-modal cover-modal" data-modal-target-string=".search-modal">
                                                <div class="header-search-inner-wrap">
                                                    <?php get_search_form(); ?>
                                                    <button class="btn-close-form" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                                                        <span></span>
                                                    </button><!-- .search-toggle -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                        if( blossom_fashion_is_woocommerce_activated() && $ed_cart && blossom_fashion_social_links( false ) ) echo '<span class="separator"></span>';
                                        echo '<div class="social-networks-holder">';
                                        blossom_fashion_social_links();
                                        echo '</div>';
                                    ?>
                                 </div>   
                            <?php } ?>                                     
                        

                   <?php } ?>            
                </div> <!-- .container -->
            </div> <!-- .header-t -->

            <?php if( $header_layout == 'two' ) { ?>
                <div class="main-header">
                    <div class="container">
                        <?php fashion_diva_site_branding(); ?>
                    </div>
                </div>
            <?php } ?>
        </div> <!-- .header-holder -->

        <div class="<?php echo ( $header_layout == 'two' ) ? 'navigation-holder' : 'nav-holder'; ?>">
            <div class="container">
                <div class="overlay"></div>
                <button id="toggle-button" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                    <span></span><?php esc_html_e( 'Menu', 'fashion-diva' ); ?>
                </button>
                <?php fashion_diva_primary_navigation();  

                if( $header_layout == 'one' ) {
                ?>

                <div class="form-holder">
                    <?php get_search_form(); ?>
                </div>
                <div class="tools">
                    <div class="form-section">
                        <button aria-label="search form toggle" id="btn-search"><i class="fa fa-search"></i></button>                       
                    </div>
                    <?php 
                    if( blossom_fashion_social_links( false ) || ( blossom_fashion_is_woocommerce_activated() && $ed_cart ) ){
                        if( blossom_fashion_is_woocommerce_activated() && $ed_cart ) blossom_fashion_wc_cart_count();
                        if( blossom_fashion_is_woocommerce_activated() && $ed_cart && blossom_fashion_social_links( false ) ) echo '<span class="separator"></span>';
                        blossom_fashion_social_links();
                    }
                    ?>                  
                </div>
            <?php } ?>
            </div>          
        </div>
     </header>
<?php
}

/** Primary Navigation */
function fashion_diva_primary_navigation(){ ?>
    <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
            <button class="btn-close-menu close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"><span></span></button>
            <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'fashion-diva' ); ?>">
                <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'main-menu-modal',
                        'fallback_cb'    => 'blossom_fashion_primary_menu_fallback',
                    ) );
                ?>
            </div>
        </div>
    </nav><!-- #site-navigation -->
<?php
}

/** Secondary Navigation */
function fashion_diva_secondary_navigation() {
    ?>
    <?php if ( has_nav_menu('secondary') ){ ?>
        <button id="secondary-toggle-button" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
            <span></span><?php esc_html_e('Menu', 'fashion-diva');?>
        </button>
    <?php } ?>
    <nav class="secondary-nav">
        <div class="menu-list menu-modal cover-modal" data-modal-target-string=".menu-modal">
            <button class="btn-close-menu close-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".menu-modal">
                <span></span><?php esc_html_e('Close', 'fashion-diva');?>
            </button>
            <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'fashion-diva' ); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'secondary',
                    'menu_id' => 'secondary-menu',
                    'menu_class'     => 'menu-modal',
                    'fallback_cb' => 'fashion_diva_secondary_menu_fallback',
                ));
                ?>
            </div>
        </div>
    </nav>
    <?php
}

/** Fallback for secondary menu */
function fashion_diva_secondary_menu_fallback() {
    if (current_user_can('manage_options')) {
        echo '<ul id="secondary-menu" class="menu">';
        echo '<li><a href="' . esc_url(admin_url('nav-menus.php')) . '">' . esc_html__('Click here to add a menu', 'fashion-diva') . '</a></li>';
        echo '</ul>';
    }
}

/** Site Branding */
function fashion_diva_site_branding() { 
$header_layout = get_theme_mod( 'header_layout', 'two' );
    ?>
<div class="<?php echo ( $header_layout == 'two') ? 'site-branding' : 'text-logo'; ?>" itemscope itemtype="http://schema.org/Organization">
    <?php 
        if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
            the_custom_logo();
        }
        
        if( is_front_page() ){ ?>
            <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
            <?php 
        }else{ ?>
            <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
        <?php 
        } 
     
        $description = get_bloginfo( 'description', 'display' );
        if ( $description || is_customize_preview() ){ ?>
            <p class="site-description"><?php echo $description; ?></p>
        <?php
        } ?>
</div>
<?php
}

/** BANNER SECTION */
function blossom_fashion_banner(){
    $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
    $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' ); 
    $slider_cat     = get_theme_mod( 'slider_cat' );
    $posts_per_page = get_theme_mod( 'no_of_slides', 5 );
    $slider_layout  = get_theme_mod( 'slider_layout', 'two' );
    $image_size     = ( $slider_layout == 'two' ) ? 'fashion-stylist-slider' : 'blossom-fashion-slider';    
    
    if( is_front_page() || is_home() ){ 
        
        if( $ed_banner == 'static_banner' && has_custom_header() ){ ?>
            <div class="banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); ?>">
                <?php the_custom_header_markup(); ?>
            </div>
            <?php
        }elseif( $ed_banner == 'slider_banner' ){
            $args = array(
                'post_type'           => 'post',
                'post_status'         => 'publish',            
                'ignore_sticky_posts' => true
            );
            
            if( $slider_type === 'cat' && $slider_cat ){
                $args['cat']            = $slider_cat; 
                $args['posts_per_page'] = -1;  
            }else{
                $args['posts_per_page'] = $posts_per_page;
            }
                
            $qry = new WP_Query( $args );
            
            if( $qry->have_posts() ){ ?>
            <div class="banner<?php echo ( $slider_layout == 'two' ) ? ' banner-layout-two' : ''; ?>">
                <div id="banner-slider<?php echo ( $slider_layout == 'two' ) ? '-two' : ''; ?>" class="owl-carousel">
                    <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <div class="item">
                        <?php 
                        if( has_post_thumbnail() ){
                            the_post_thumbnail( $image_size );    
                        }else{ 
                            blossom_fashion_get_fallback_svg( $image_size ); 
                        }
                        ?>                        
                        <div class="banner-text">
                            <div class="container">
                                <div class="text-holder">
                                    <?php
                                        blossom_fashion_category();
                                        the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>
            <?php
            wp_reset_postdata();
            }
        } 
    }    
}

/** Category */
function blossom_fashion_category(){
    $ed_cat_single = get_theme_mod( 'ed_category', false );
    if ( 'post' === get_post_type() && !$ed_cat_single ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( ' ' );
        if ( $categories_list ) {
            echo '<span class="cat-links" itemprop="about">' . $categories_list . '</span>';
        }
    }
}

/** Blossom Fashion Fonts URL */
function blossom_fashion_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'Muli' );
    $ig_primary_font    = blossom_fashion_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'EB Garamond' );
    $ig_secondary_font  = blossom_fashion_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=>'Rouge Script', 'variant'=>'regular' ) );
    $ig_site_title_font = blossom_fashion_is_google_font( $site_title_font['font-family'] );
        
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'fashion-diva' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'fashion-diva' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'fashion-diva' );
    
    
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $ig_primary_font ) {
            $primary_variant = blossom_fashion_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $ig_secondary_font ) {
            $secondary_variant = blossom_fashion_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $ig_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . blossom_fashion_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
            }else{
                $site_title_var = '';
            }
            $font_families[] = $site_title_font['font-family'] . $site_title_var;
        }
        
        $font_families = array_diff( array_unique( $font_families ), array('') );
        
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),            
        );
        
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
     
    return esc_url_raw( $fonts_url );
}


/** Fashion Icon Dynamic CSS */
function fashion_diva_dynamic_css(){    
    $primary_font    = get_theme_mod( 'primary_font', 'Muli' );
    $primary_fonts   = blossom_fashion_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'EB Garamond' );
    $secondary_fonts = blossom_fashion_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 18 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Rouge Script', 'variant'=>'regular' ) );
    $site_title_fonts     = blossom_fashion_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 60 );
    
    $primary_color = get_theme_mod( 'primary_color', '#e7cfc8' );
    
    $rgb = blossom_fashion_hex2rgb( blossom_fashion_sanitize_hex_color( $primary_color ) );
     
    $custom_css = '';
    $custom_css .= '

    :root{
        --primary-color: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }
     
    .content-newsletter .blossomthemes-email-newsletter-wrapper.bg-img:after,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper:after{
        ' . 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.8);' . '
    }

    .shop-section, 
    .bottom-shop-section,
    .widget_bttk_popular_post .style-two li .entry-header .cat-links a, .widget_bttk_pro_recent_post .style-two li .entry-header .cat-links a, .widget_bttk_popular_post .style-three li .entry-header .cat-links a, .widget_bttk_pro_recent_post .style-three li .entry-header .cat-links a, .widget_bttk_posts_category_slider_widget .carousel-title .cat-links a {
        ' . 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.3);' . '
    }
    
    /*Typography*/

    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : ' . wp_kses_post( $primary_fonts['font'] ) . ';
        font-size   : ' . absint( $font_size ) . 'px;        
    }

    .site-description,
    .main-navigation ul li,
    #primary .post .entry-content h1, 
    #primary .page .entry-content h1, 
    #primary .post .entry-content h2, 
    #primary .page .entry-content h2, 
    #primary .post .entry-content h3, 
    #primary .page .entry-content h3, 
    #primary .post .entry-content h4, 
    #primary .page .entry-content h4, 
    #primary .post .entry-content h5, 
    #primary .page .entry-content h5, 
    #primary .post .entry-content h6, #primary .page .entry-content h6{
        font-family : ' . wp_kses_post( $primary_fonts['font'] ) . ';
    }
    
    .site-title{
        font-size   : ' . absint( $site_title_font_size ) . 'px;
        font-family : ' . wp_kses_post( $site_title_fonts['font'] ) . ';
        font-weight : ' . esc_html( $site_title_fonts['weight'] ) . ';
        font-style  : ' . esc_html( $site_title_fonts['style'] ) . ';
    }
    
    /*Color Scheme*/
    a,
    .site-header .social-networks li a:hover,
    .site-title a:hover,
    .banner .text-holder .cat-links a:hover,
    .shop-section .shop-slider .item h3 a:hover,
    #primary .post .entry-footer .social-networks li a:hover,
    .widget ul li a:hover,
    .widget_bttk_author_bio .author-bio-socicons ul li a:hover,
    .widget_bttk_popular_post ul li .entry-header .entry-title a:hover,
    .widget_bttk_pro_recent_post ul li .entry-header .entry-title a:hover,
    .widget_bttk_popular_post ul li .entry-header .entry-meta a:hover,
    .widget_bttk_pro_recent_post ul li .entry-header .entry-meta a:hover,
    .bottom-shop-section .bottom-shop-slider .item .product-category a:hover,
    .bottom-shop-section .bottom-shop-slider .item h3 a:hover,
    .instagram-section .header .title a:hover,
    .site-footer .widget ul li a:hover,
    .site-footer .widget_bttk_popular_post ul li .entry-header .entry-title a:hover,
    .site-footer .widget_bttk_pro_recent_post ul li .entry-header .entry-title a:hover,
    .single .single-header .site-title:hover,
    .single .single-header .right .social-share .social-networks li a:hover,
    .comments-area .comment-body .fn a:hover,
    .comments-area .comment-body .comment-metadata a:hover,
    .page-template-contact .contact-details .contact-info-holder .col .icon-holder,
    .page-template-contact .contact-details .contact-info-holder .col .text-holder h3 a:hover,
    .page-template-contact .contact-details .contact-info-holder .col .social-networks li a:hover,
    #secondary .widget_bttk_description_widget .social-profile li a:hover,
    #secondary .widget_bttk_contact_social_links .social-networks li a:hover,
    .site-footer .widget_bttk_contact_social_links .social-networks li a:hover,
    .site-footer .widget_bttk_description_widget .social-profile li a:hover,
    .portfolio-sorting .button:hover,
    .portfolio-sorting .button.is-checked,
    .portfolio-item .portfolio-cat a:hover,
    .entry-header .portfolio-cat a:hover,
    .single-blossom-portfolio .post-navigation .nav-previous a:hover,
    .single-blossom-portfolio .post-navigation .nav-next a:hover,
    #primary .post .btn-readmore,
    #primary .post .entry-header .cat-links a:hover,
    .error-holder .recent-posts .post .entry-header .entry-title a:hover, 
    .instagram-section .profile-link:hover{
        color: ' .  blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }

    .site-header .tools .cart .number,
    .shop-section .header .title:after,
    .header-two .header-t,
    .header-six .header-t,
    .header-eight .header-t,
    .shop-section .shop-slider .item .product-image .btn-add-to-cart:hover,
    .widget .widget-title:before,
    .widget .widget-title:after,
    .widget_calendar caption,
    .widget_bttk_popular_post .style-two li:after,
    .widget_bttk_popular_post .style-three li:after,
    .widget_bttk_pro_recent_post .style-two li:after,
    .widget_bttk_pro_recent_post .style-three li:after,
    .instagram-section .header .title:before,
    .instagram-section .header .title:after,
    #primary .post .entry-content .pull-left:after,
    #primary .page .entry-content .pull-left:after,
    #primary .post .entry-content .pull-right:after,
    #primary .page .entry-content .pull-right:after,
    .page-template-contact .contact-details .contact-info-holder h2:after,
    .widget_bttk_image_text_widget ul li .btn-readmore:hover,
    #secondary .widget_bttk_icon_text_widget .text-holder .btn-readmore:hover,
    #secondary .widget_blossomtheme_companion_cta_widget .btn-cta:hover,
    #secondary .widget_blossomtheme_featured_page_widget .text-holder .btn-readmore:hover,
    #primary .post .entry-content .highlight, 
    #primary .page .entry-content .highlight,
    .error-holder .recent-posts .post .entry-header .cat-links a:hover,
    .error-holder .text-holder .btn-home:hover,
    .single #primary .post .entry-footer .tags a:hover, 
    #primary .post .entry-footer .tags a:hover, 
    .widget_tag_cloud .tagcloud a:hover, 
    .instagram-section .profile-link::before, 
    .instagram-section .profile-link::after{
        background: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }
    
    .banner .text-holder .cat-links a,
    #primary .post .entry-header .cat-links a,
    .page-header span,
    .page-template-contact .top-section .section-header span,
    .portfolio-item .portfolio-cat a,
    .entry-header .portfolio-cat a{
        border-bottom-color: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }

    .banner .text-holder .title a,
    .header-four .main-navigation ul li a,
    .header-four .main-navigation ul ul li a,
    #primary .post .entry-header .entry-title a,
    .portfolio-item .portfolio-img-title a,
    .search #primary .search-post .entry-header .entry-title a, 
    .archive #primary .blossom-portfolio .entry-title a{
        background-image: linear-gradient(180deg, transparent 95%, ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ' 0);
    }

    .widget_bttk_social_links ul li a:hover{
        border-color: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }

    button:hover,
    input[type="button"]:hover,
    input[type="reset"]:hover,
    input[type="submit"]:hover{
        background: ' .  blossom_fashion_sanitize_hex_color( $primary_color ) . ';
        border-color: ' .  blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }

    #primary .post .btn-readmore:hover{
        background: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
    }

    @media only screen and (min-width: 1025px){
        .main-navigation ul li:after{
            background: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
        }
    }
    
    /*Typography*/
    .main-navigation ul,
    .banner .text-holder .title,
    .top-section .newsletter .blossomthemes-email-newsletter-wrapper .text-holder h3,
    .shop-section .header .title,
    #primary .post .entry-header .entry-title,
    #primary .post .post-shope-holder .header .title,
    .widget_bttk_author_bio .title-holder,
    .widget_bttk_popular_post ul li .entry-header .entry-title,
    .widget_bttk_pro_recent_post ul li .entry-header .entry-title,
    .widget-area .widget_blossomthemes_email_newsletter_widget .text-holder h3,
    .bottom-shop-section .bottom-shop-slider .item h3,
    .page-title,
    #primary .post .entry-content blockquote,
    #primary .page .entry-content blockquote,
    #primary .post .entry-content .dropcap,
    #primary .page .entry-content .dropcap,
    #primary .post .entry-content .pull-left,
    #primary .page .entry-content .pull-left,
    #primary .post .entry-content .pull-right,
    #primary .page .entry-content .pull-right,
    .author-section .text-holder .title,
    .single .newsletter .blossomthemes-email-newsletter-wrapper .text-holder h3,
    .related-posts .title, .popular-posts .title,
    .comments-area .comments-title,
    .comments-area .comment-reply-title,
    .single .single-header .title-holder .post-title,
    .portfolio-text-holder .portfolio-img-title,
    .portfolio-holder .entry-header .entry-title,
    .related-portfolio-title,
    .archive #primary .post .entry-header .entry-title, 
    .archive #primary .blossom-portfolio .entry-title, 
    .search #primary .search-post .entry-header .entry-title,
    .search .top-section .search-form input[type="search"],
    .archive #primary .post-count, 
    .search #primary .post-count,
    .error-holder .text-holder h2,
    .error-holder .recent-posts .title,
    .error-holder .recent-posts .post .entry-header .entry-title{
        font-family: ' . wp_kses_post( $secondary_fonts['font'] ) . ';
    }
    #primary .post .entry-header .cat-links a, 
    .banner .text-holder .cat-links a,
    .error-holder .recent-posts .post .entry-header .cat-links a{
        ' . 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.3);' . '
    }
    #primary .post .btn-readmore:after{
        background-image: url(' . '\'data:image/svg+xml; utf8, <svg xmlns="http://www.w3.org/2000/svg" width="30" height="10" viewBox="0 0 30 10"><g id="arrow" transform="translate(-10)"><path fill=" ' . fashion_diva_hash_to_percent23( blossom_fashion_sanitize_hex_color( $primary_color ) ) . '" d="M24.5,44.974H46.613L44.866,40.5a34.908,34.908,0,0,0,9.634,5,34.908,34.908,0,0,0-9.634,5l1.746-4.474H24.5Z" transform="translate(-14.5 -40.5)"></path></g></svg>\'' . ' );
    }';
    
    if( blossom_fashion_is_woocommerce_activated() ) {
        $custom_css .= '
        .woocommerce #secondary .widget_price_filter .ui-slider .ui-slider-range, 
        .woocommerce-checkout .woocommerce form.woocommerce-form-login input.button:hover, .woocommerce-checkout .woocommerce form.woocommerce-form-login input.button:focus, .woocommerce-checkout .woocommerce form.checkout_coupon input.button:hover, .woocommerce-checkout .woocommerce form.checkout_coupon input.button:focus, .woocommerce form.lost_reset_password input.button:hover, .woocommerce form.lost_reset_password input.button:focus, .woocommerce .return-to-shop .button:hover, .woocommerce .return-to-shop .button:focus, .woocommerce #payment #place_order:hover, .woocommerce-page #payment #place_order:focus{
            background: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
        }
        
        .woocommerce #secondary .widget .product_list_widget li .product-title:hover,
        .woocommerce #secondary .widget .product_list_widget li .product-title:focus,
        .woocommerce div.product .entry-summary .product_meta .posted_in a:hover,
        .woocommerce div.product .entry-summary .product_meta .posted_in a:focus,
        .woocommerce div.product .entry-summary .product_meta .tagged_as a:hover,
        .woocommerce div.product .entry-summary .product_meta .tagged_as a:focus{
            color: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
        }
        
        .woocommerce-checkout .woocommerce .woocommerce-info,
        .woocommerce ul.products li.product .add_to_cart_button:hover,
        .woocommerce ul.products li.product .add_to_cart_button:focus,
        .woocommerce ul.products li.product .product_type_external:hover,
        .woocommerce ul.products li.product .product_type_external:focus,
        .woocommerce ul.products li.product .ajax_add_to_cart:hover,
        .woocommerce ul.products li.product .ajax_add_to_cart:focus,
        .woocommerce ul.products li.product .added_to_cart:hover,
        .woocommerce ul.products li.product .added_to_cart:focus,
        .woocommerce div.product form.cart .single_add_to_cart_button:hover,
        .woocommerce div.product form.cart .single_add_to_cart_button:focus,
        .woocommerce div.product .cart .single_add_to_cart_button.alt:hover,
        .woocommerce div.product .cart .single_add_to_cart_button.alt:focus,
        .woocommerce #secondary .widget_shopping_cart .buttons .button:hover,
        .woocommerce #secondary .widget_shopping_cart .buttons .button:focus,
        .woocommerce #secondary .widget_price_filter .price_slider_amount .button:hover,
        .woocommerce #secondary .widget_price_filter .price_slider_amount .button:focus,
        .woocommerce-cart #primary .page .entry-content table.shop_table td.actions .coupon input[type="submit"]:hover,
        .woocommerce-cart #primary .page .entry-content table.shop_table td.actions .coupon input[type="submit"]:focus,
        .woocommerce-cart #primary .page .entry-content .cart_totals .checkout-button:hover,
        .woocommerce-cart #primary .page .entry-content .cart_totals .checkout-button:focus{
            background: ' . blossom_fashion_sanitize_hex_color( $primary_color ) . ';
        }

        .woocommerce div.product .product_title,
        .woocommerce div.product .woocommerce-tabs .panel h2{
            font-family: ' . wp_kses_post( $secondary_fonts['font'] ) . ';
        }';    
    }
           
    wp_add_inline_style( 'blossom-fashion-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'fashion_diva_dynamic_css', 100 );

/**
 * Convert '#' to '%23'
*/
function fashion_diva_hash_to_percent23( $color_code ){
    $color_code = str_replace( "#", "%23", $color_code );
    return $color_code;
}

/** Fashion Diva Footer */
function blossom_fashion_footer_bottom(){ ?>
    <div class="footer-b">
        <div class="container">
            <div class="site-info">            
            <?php
                blossom_fashion_get_footer_copyright();
                esc_html_e( ' Fashion Diva | Developed By ', 'fashion-diva' );                                
                echo '<a href="' . esc_url( 'https://blossomthemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Blossom Themes', 'fashion-diva' ) . '</a>.';                                
                printf( esc_html__( ' Powered by %s', 'fashion-diva' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'fashion-diva' ) ) .'" target="_blank">WordPress</a>.' );
                if ( function_exists( 'the_privacy_policy_link' ) ) {
                    the_privacy_policy_link();
                }
            ?>               
            </div>
        </div>
    </div>
    <?php
}
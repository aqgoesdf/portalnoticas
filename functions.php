<?php
/**
 * Configurações e funções do aqgoes Theme
 *
 * @package aqgoes
 */

if ( ! function_exists( 'aqgoes_setup' ) ) :
    /**
     * Configura os recursos suportados pelo tema.
     */
    function aqgoes_setup() {
        // Suporte a tag <title> dinâmica gerenciada pelo WordPress
        add_theme_support( 'title-tag' );

        // Suporte a Imagens Destacadas (Post Thumbnails)
        add_theme_support( 'post-thumbnails' );

        // Registro do Menu de Navegação Principal
        register_nav_menus( array(
            'primary' => __( 'Menu Principal', 'aqgoes' ),
        ) );

        // Suporte a marcação HTML5
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );
    }
endif;
add_action( 'after_setup_theme', 'aqgoes_setup' );


/**
 * Enfileira os estilos (CSS) e scripts (JS) do tema.
 */
function aqgoes_enqueue_scripts() {

    // 1. Google Fonts (Inter + Plus Jakarta Sans)
    wp_enqueue_style(
        'google-fonts-inter-jakarta',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap',
        array(),
        null
    );

    // 2. Estilo principal em assets/css/main.css
    wp_enqueue_style( 
        'aqgoes-main-style', 
        get_template_directory_uri() . '/assets/css/main.css', 
        array(), 
        '1.0.0', 
        'all' 
    );

    // 3. Estilo padrão style.css (para cabeçalho do tema e eventuais sobrescritas)
    wp_enqueue_style( 
        'aqgoes-theme-style', 
        get_stylesheet_uri(), 
        array('aqgoes-main-style'), 
        '1.0.0' 
    );

    // 4. Tailwind CSS via CDN
    wp_enqueue_script(
        'tailwind-cdn',
        'https://cdn.tailwindcss.com',
        array(),
        null,
        false // Carrega no <head> para evitar FOUC (Flash of Unstyled Content)
    );

    // 5. Configuração em linha (Inline Script) do Tailwind CSS
    $tailwind_config = "
        tailwind.config = {
          darkMode: 'class',
          theme: {
            extend: {
              colors: {
                brand: {
                  DEFAULT: '#2563EB',
                  hover: '#1D4ED8',
                }
              },
              fontFamily: {
                sans: ['Inter', 'sans-serif'],
                title: ['Plus Jakarta Sans', 'sans-serif'],
              }
            }
          }
        };
    ";
    wp_add_inline_script( 'tailwind-cdn', $tailwind_config, 'after' );

    // 6. JavaScript personalizado do Tema em assets/js/script.js
    wp_enqueue_script( 
        'aqgoes-main-script', 
        get_template_directory_uri() . '/assets/js/script.js', 
        array(), 
        '1.0.0', 
        true // Carrega antes do </body> (no footer)
    );
}
add_action( 'wp_enqueue_scripts', 'aqgoes_enqueue_scripts' );


/**
 * Otimização: Adiciona Preconnect e Crossorigin para as tags das fontes do Google
 */
function aqgoes_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
        );
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'aqgoes_resource_hints', 10, 2 );
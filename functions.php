<?php
/**
 * Configurações e Funções do Tema aqgoes Theme
 *
 * @package aqgoes-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function aqgoes_setup_theme() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => __( 'Menu Principal (Header)', 'aqgoes-theme' ),
		'footer'  => __( 'Menu do Rodapé', 'aqgoes-theme' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
}
add_action( 'after_setup_theme', 'aqgoes_setup_theme' );

function aqgoes_enqueue_assets() {

	// --- 1. FONTS & EXTERNAL CSS ---
	wp_enqueue_style(
		'aqgoes-google-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap',
		array(),
		null
	);

	// --- 2. TAILWIND CDN (Injetado no HEAD) ---
	wp_enqueue_script(
		'tailwind-cdn',
		'https://cdn.tailwindcss.com',
		array(),
		null,
		false
	);

	// Configuração do Tailwind via JS embutido
	wp_add_inline_script(
		'tailwind-cdn',
		'tailwind.config = {
			darkMode: "class",
			theme: {
				extend: {
					fontFamily: {
						display: ["Playfair Display", "serif"],
						body:    ["DM Sans", "sans-serif"],
						mono:    ["JetBrains Mono", "monospace"],
					}
				}
			}
		};',
		'after'
	);

	// --- 3. CUSTOM STYLES (Procura em assets/css ou asseds/css) ---
	$css_path = file_exists( get_template_directory() . '/assets/css/customer.css' ) 
		? '/assets/css/customer.css' 
		: '/assets/css/blog_style.css';

	wp_enqueue_style(
		'aqgoes-customer-style',
		get_template_directory_uri() . $css_path,
		array(),
		'1.0.1',
		'all'
	);

	wp_enqueue_style(
		'aqgoes-main-style',
		get_stylesheet_uri(),
		array( 'aqgoes-customer-style' ),
		'1.0.1'
	);

	// --- 4. SCRIPTS DE TEMA (Dark Mode & Menu) ---
	wp_enqueue_script(
		'aqgoes-theme-js',
		get_template_directory_uri() . '/assets/js/theme.js',
		array(),
		'1.0.1',
		false // Roda no head para evitar o "flicker" do Dark Mode
	);

	wp_enqueue_script(
		'aqgoes-blog-script',
		get_template_directory_uri() . '/assets/js/blog_script.js',
		array(),
		'1.0.1',
		true // Carrega no footer
	);
}
add_action( 'wp_enqueue_scripts', 'aqgoes_enqueue_assets' );
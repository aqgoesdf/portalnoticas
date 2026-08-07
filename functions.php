<?php
/**
 * AqGoEs Theme functions.php
 * Tema clássico, sem parent theme, sem page builder.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'AQGOES_VERSION', '1.0.0' );
define( 'AQGOES_DIR', get_template_directory() );
define( 'AQGOES_URI', get_template_directory_uri() );

require_once AQGOES_DIR . '/inc/class-nav-walker.php';

/* ─────────────────────────────
   THEME SETUP
───────────────────────────── */
function aqgoes_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array(
		'height'      => 40,
		'width'       => 40,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus( array(
		'primary' => __( 'Menu Principal', 'aqgoes' ),
		'footer'  => __( 'Menu do Rodapé', 'aqgoes' ),
	) );

	add_image_size( 'aqgoes-card', 600, 400, true );
	add_image_size( 'aqgoes-featured', 800, 600, true );
	add_image_size( 'aqgoes-thumb', 120, 90, true );
}
add_action( 'after_setup_theme', 'aqgoes_setup' );

/* ─────────────────────────────
   ASSETS
───────────────────────────── */
function aqgoes_assets() {
	// Google Fonts
	wp_enqueue_style(
		'aqgoes-fonts',
		'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&family=JetBrains+Mono:wght@400;600&display=swap',
		array(),
		null
	);

	// Tailwind via CDN (mesmo padrão usado no resto do site)
	wp_enqueue_script( 'tailwind-cdn', 'https://cdn.tailwindcss.com', array(), null, false );
	wp_add_inline_script( 'tailwind-cdn', aqgoes_tailwind_config(), 'after' );

	// style.css "oficial" do WP (fica quase vazio, ver style.css)
	wp_enqueue_style( 'aqgoes-style', get_stylesheet_uri(), array(), AQGOES_VERSION );

	// CSS principal do tema
	wp_enqueue_style( 'aqgoes-main', AQGOES_URI . '/assets/css/main.css', array( 'aqgoes-style' ), AQGOES_VERSION );

	// JS principal (menu, tema, filtros, busca client-side)
	wp_enqueue_script( 'aqgoes-main', AQGOES_URI . '/assets/js/main.js', array(), AQGOES_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'aqgoes_assets' );

function aqgoes_tailwind_config() {
	return "tailwind.config = {
		darkMode: 'class',
		theme: {
			extend: {
				fontFamily: {
					display: ['Playfair Display', 'serif'],
					body:    ['DM Sans', 'sans-serif'],
					mono:    ['JetBrains Mono', 'monospace'],
				}
			}
		}
	}";
}

/* ─────────────────────────────
   SEO — meta description, canonical, Open Graph, Twitter Card
───────────────────────────── */
function aqgoes_seo_meta_tags() {
	if ( is_admin() ) return;

	$title       = wp_get_document_title();
	$description = '';
	$image       = '';
	$type        = 'website';
	$url         = home_url( add_query_arg( array(), $GLOBALS['wp']->request ) );

	if ( is_singular( 'post' ) ) {
		global $post;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_trim_words( wp_strip_all_tags( $post->post_content ), 30 );
		$type        = 'article';
		$url         = get_permalink();
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( $post, 'aqgoes-featured' );
		}
	} elseif ( is_search() ) {
		$description = sprintf( 'Resultados da busca por "%s" no blog %s.', get_search_query(), get_bloginfo( 'name' ) );
		$url         = get_search_link();
	} elseif ( is_category() || is_tag() ) {
		$term        = get_queried_object();
		$description = $term && ! empty( $term->description )
			? wp_strip_all_tags( $term->description )
			: sprintf( 'Artigos sobre %s no blog %s.', single_term_title( '', false ), get_bloginfo( 'name' ) );
		$url         = get_term_link( $term );
	} elseif ( is_author() ) {
		$description = sprintf( 'Artigos escritos por %s.', get_the_author_meta( 'display_name', get_queried_object_id() ) );
	} elseif ( is_home() || is_front_page() ) {
		$description = get_bloginfo( 'description' ) ? get_bloginfo( 'description' ) : get_theme_mod( 'aqgoes_blog_hero_desc', '' );
		$url         = home_url( '/' );
	} else {
		$description = get_bloginfo( 'description' );
	}

	if ( ! $image && has_custom_logo() ) {
		$logo_id = get_theme_mod( 'custom_logo' );
		$logo    = $logo_id ? wp_get_attachment_image_src( $logo_id, 'full' ) : false;
		if ( $logo ) $image = $logo[0];
	}

	$description = trim( $description );
	?>
	<meta name="description" content="<?php echo esc_attr( wp_trim_words( $description, 30 ) ); ?>"/>
	<link rel="canonical" href="<?php echo esc_url( $url ); ?>"/>

	<meta property="og:type" content="<?php echo esc_attr( $type ); ?>"/>
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>"/>
	<meta property="og:description" content="<?php echo esc_attr( wp_trim_words( $description, 30 ) ); ?>"/>
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>"/>
	<?php if ( $image ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $image ); ?>"/>
	<?php endif; ?>
	<?php if ( is_singular( 'post' ) ) : ?>
		<meta property="article:published_time" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"/>
		<meta property="article:modified_time" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"/>
		<?php foreach ( get_the_category() as $cat ) : ?>
			<meta property="article:section" content="<?php echo esc_attr( $cat->name ); ?>"/>
		<?php endforeach; ?>
	<?php endif; ?>

	<meta name="twitter:card" content="<?php echo $image ? 'summary_large_image' : 'summary'; ?>"/>
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>"/>
	<meta name="twitter:description" content="<?php echo esc_attr( wp_trim_words( $description, 30 ) ); ?>"/>
	<?php if ( $image ) : ?>
		<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>"/>
	<?php endif; ?>
	<?php
}
add_action( 'wp_head', 'aqgoes_seo_meta_tags', 1 );

/* ─────────────────────────────
   ANTI-FLASH DARK/LIGHT (inline, no <head>, antes do CSS)
   Mesma chave usada no resto do site: aqgoes-theme
───────────────────────────── */
function aqgoes_theme_flash_prevention() {
	?>
	<script>
	(function () {
		try {
			var saved = localStorage.getItem('aqgoes-theme') || 'light';
			document.documentElement.classList.remove('light', 'dark');
			document.documentElement.classList.add(saved);
		} catch (e) {
			document.documentElement.classList.add('light');
		}
	})();
	</script>
	<?php
}
add_action( 'wp_head', 'aqgoes_theme_flash_prevention', 1 );

/* ─────────────────────────────
   WIDGETS (rodapé / extensibilidade futura)
───────────────────────────── */
function aqgoes_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Newsletter (Rodapé)', 'aqgoes' ),
		'id'            => 'footer-newsletter',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="font-semibold text-sm mb-3">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'aqgoes_widgets_init' );

/* ─────────────────────────────
   HELPERS
───────────────────────────── */

/**
 * Estima tempo de leitura em minutos (igual ao "6 min" do design original).
 */
function aqgoes_reading_time( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$content = get_post_field( 'post_content', $post_id );
	$word_count = str_word_count( wp_strip_all_tags( $content ) );
	$minutes = max( 1, (int) ceil( $word_count / 200 ) );
	return $minutes;
}

/**
 * Retorna slugs das tags do post, separados por vírgula.
 * Usado no data-tags="" dos post-cards para o filtro client-side.
 */
function aqgoes_post_tags_data( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$tags = get_the_tags( $post_id );
	if ( ! $tags || is_wp_error( $tags ) ) return '';
	return implode( ',', wp_list_pluck( $tags, 'slug' ) );
}

/**
 * Slug da primeira categoria do post (usado no data-cat="").
 */
function aqgoes_post_cat_slug( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$cats = get_the_category( $post_id );
	return ! empty( $cats ) ? $cats[0]->slug : 'sem-categoria';
}

/**
 * Cores/emoji fixos por slug de categoria, pra bater com o design original.
 * Ajuste os slugs conforme as categorias reais que você criar no wp-admin.
 */
function aqgoes_category_style( $slug ) {
	$map = array(
		'tecnologia' => array( 'emoji' => '🖥️', 'bg' => 'rgba(124,58,237,.12)',  'color' => '#7c3aed' ),
		'python'     => array( 'emoji' => '🐍', 'bg' => 'rgba(55,118,171,.15)',  'color' => '#3776ab' ),
		'front-end'  => array( 'emoji' => '🎨', 'bg' => 'rgba(200,57,43,.12)',   'color' => '#c8392b' ),
		'css'        => array( 'emoji' => '✨', 'bg' => 'rgba(56,189,248,.15)',  'color' => '#0891b2' ),
		'javascript' => array( 'emoji' => '⚡', 'bg' => 'rgba(240,219,79,.2)',   'color' => '#6b5900' ),
		'django'     => array( 'emoji' => '🦄', 'bg' => 'rgba(68,183,139,.15)', 'color' => '#0c4b33' ),
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : array( 'emoji' => '📄', 'bg' => 'rgba(120,120,120,.12)', 'color' => '#666' );
}

/**
 * Posts relacionados: mesma categoria do post atual, excluindo ele mesmo.
 */
function aqgoes_related_posts( $post_id, $limit = 3 ) {
	$cats = wp_get_post_categories( $post_id );
	if ( empty( $cats ) ) return new WP_Query( array( 'post__in' => array( 0 ) ) );

	return new WP_Query( array(
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'post__not_in'   => array( $post_id ),
		'category__in'   => $cats,
		'orderby'        => 'date',
	) );
}

function aqgoes_category_dot_color( $slug ) {
	return aqgoes_category_style( $slug )['color'];
}

/**
 * Fallback simples caso nenhum menu tenha sido criado em Aparência > Menus.
 */
function aqgoes_menu_fallback() {
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">Início</a>';
	echo '<a href="' . esc_url( home_url( '/sobre' ) ) . '">Sobre</a>';
	echo '<a href="' . esc_url( home_url( '/blog' ) ) . '" class="active">Blog</a>';
	echo '<a href="' . esc_url( home_url( '/contato' ) ) . '">Contato</a>';
}

/* ─────────────────────────────
   CUSTOMIZER — textos editáveis do hero do blog
───────────────────────────── */
function aqgoes_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'aqgoes_blog_hero', array(
		'title'    => __( 'Hero do Blog', 'aqgoes' ),
		'priority' => 30,
	) );

	$wp_customize->add_setting( 'aqgoes_blog_hero_label', array( 'default' => 'Dev Blog', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'aqgoes_blog_hero_label', array( 'label' => 'Label pequeno', 'section' => 'aqgoes_blog_hero', 'type' => 'text' ) );

	$wp_customize->add_setting( 'aqgoes_blog_hero_title', array( 'default' => 'Artigos & Tutoriais', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'aqgoes_blog_hero_title', array( 'label' => 'Título', 'section' => 'aqgoes_blog_hero', 'type' => 'text' ) );

	$wp_customize->add_setting( 'aqgoes_blog_hero_desc', array( 'default' => 'Conteúdo técnico sobre desenvolvimento web, Python, CSS moderno e as ferramentas que uso no dia a dia.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'aqgoes_blog_hero_desc', array( 'label' => 'Descrição', 'section' => 'aqgoes_blog_hero', 'type' => 'textarea' ) );

	$wp_customize->add_section( 'aqgoes_pages', array(
		'title'    => __( 'Textos: Sobre & Contato', 'aqgoes' ),
		'priority' => 31,
	) );

	$wp_customize->add_setting( 'aqgoes_sobre_subtitle', array( 'default' => 'Desenvolvimento web, do backend ao front-end — documentando o processo de aprender na prática.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'aqgoes_sobre_subtitle', array( 'label' => 'Subtítulo da página Sobre', 'section' => 'aqgoes_pages', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'aqgoes_contato_subtitle', array( 'default' => 'Dúvidas, projetos ou só bater um papo sobre dev — a caixa de entrada está aberta.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'aqgoes_contato_subtitle', array( 'label' => 'Subtítulo da página Contato', 'section' => 'aqgoes_pages', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'aqgoes_customize_register' );

/* ─────────────────────────────
   LIMPEZA DE HEAD
───────────────────────────── */
remove_action( 'wp_head', 'wp_generator' );

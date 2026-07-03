<?php
function aqgoes_theme_setup() {
    // Suporte ao título dinâmico
    add_theme_support('title-tag');

    // ATIVA AS IMAGENS DESTACADAS NOS POSTS
    add_theme_support('post-thumbnails');

    // Registra os locais dos menus para aparecerem no Painel do WP
    register_nav_menus(array(
        'primary-menu' => __('Menu Desktop', 'aqgoes'),
        'mobile-menu'  => __('Menu Mobile', 'aqgoes'),
        'footer-editorias' => __('Footer — Editorias (Categorias)', 'aqgoes'),
        'footer-empresa'   => __('Footer — Empresa (Páginas)', 'aqgoes'),
    ));
}
add_action('after_setup_theme', 'aqgoes_theme_setup');

// Filtro opcional para injetar as classes utilitárias do Tailwind diretamente nas tags <a> do menu dinâmico
function aqgoes_menu_link_class($attrs, $item, $args) {
    if (isset($args->link_class)) {
        $attrs['class'] = $args->link_class;
    }
    return $attrs;
}
add_filter('nav_menu_link_attributes', 'aqgoes_menu_link_class', 10, 3);
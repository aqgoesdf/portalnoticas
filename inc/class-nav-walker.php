<?php
/**
 * Walker de menu customizado.
 *
 * O header estático original usa <a> soltos dentro de uma <nav> flex
 * (sem <ul><li>), então este walker ignora a estrutura padrão de lista
 * e imprime apenas âncoras, aplicando a classe "active" / "mobile-nav-link active"
 * no item da página atual — igual ao HTML de referência.
 */

if ( ! class_exists( 'Aqgoes_Walker_Nav_Menu' ) ) {

	class Aqgoes_Walker_Nav_Menu extends Walker_Nav_Menu {

		/** @var bool Se true, imprime classes/estrutura do menu mobile */
		public $is_mobile = false;

		public function __construct( $is_mobile = false ) {
			$this->is_mobile = $is_mobile;
		}

		// Não abrimos <ul> — o container já vem do header.php.
		public function start_lvl( &$output, $depth = 0, $args = null ) {}
		public function end_lvl( &$output, $depth = 0, $args = null ) {}

		public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
			$is_current = in_array( 'current-menu-item', $item->classes, true )
				|| in_array( 'current-menu-parent', $item->classes, true );

			if ( $this->is_mobile ) {
				$classes = 'mobile-nav-link' . ( $is_current ? ' active' : '' );
			} else {
				$classes = $is_current ? 'active' : '';
			}

			$attributes  = ' href="' . esc_url( $item->url ) . '"';
			$attributes .= $classes ? ' class="' . esc_attr( $classes ) . '"' : '';
			if ( $is_current ) {
				$attributes .= ' aria-current="page"';
			}

			$output .= '<a' . $attributes . '>' . esc_html( $item->title ) . '</a>';
		}

		public function end_el( &$output, $item, $depth = 0, $args = null ) {}
	}
}

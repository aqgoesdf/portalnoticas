<!DOCTYPE html>
<html lang="pt-BR" class="light">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="sticky top-0 z-50">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 font-display font-black text-2xl tracking-tight" style="color:#c8392b;text-decoration:none;">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect width="22" height="22" rx="4" fill="#c8392b"/><path d="M5 5h5l3 6-3 6H5l3-6-3-6zm7 0h5l-3 6 3 6h-5l-3-6 3-6z" fill="#fff"/></svg>
			<?php endif; ?>
			<?php bloginfo( 'name' ); ?>
		</a>

		<nav class="hidden md:flex items-center gap-6" aria-label="Menu principal">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new Aqgoes_Walker_Nav_Menu( false ),
				) );
			} else {
				aqgoes_menu_fallback();
			}
			?>
		</nav>

		<div class="flex items-center gap-3">
			<button class="theme-toggle" id="theme-toggle" aria-label="Alternar tema"><span class="knob"></span></button>

			<a href="#" class="hidden md:inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white" style="background:#c8392b;">Assine</a>

			<button id="menu-btn" class="md:hidden flex flex-col justify-center items-center w-9 h-9 rounded-md gap-1.5" style="background:var(--bg);border:1px solid var(--border);" aria-label="Abrir menu" aria-expanded="false">
				<span class="ham-bar"></span>
				<span class="ham-bar"></span>
				<span class="ham-bar"></span>
			</button>
		</div>
	</div>

	<div id="mobile-menu">
		<nav class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1" aria-label="Menu mobile">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new Aqgoes_Walker_Nav_Menu( true ),
				) );
			} else {
				aqgoes_menu_fallback();
			}
			?>
			<div style="border-top:1px solid var(--border);margin:.5rem 0;"></div>
			<a href="#" class="inline-flex justify-center items-center px-4 py-2.5 rounded-md text-sm font-bold text-white" style="background:#c8392b;">Assine grátis</a>
		</nav>
	</div>
</header>

<main>

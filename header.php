<!DOCTYPE html>
<html <?php language_attributes(); ?> class="light">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <!-- Script inline urgente do Dark Mode (Executado antes do CSS/HTML renderizar) -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('theme') || 'light';
      if (savedTheme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        document.documentElement.classList.remove('light');
      } else {
        document.documentElement.classList.add('light');
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ═══════════════════════════ HEADER ═══════════════════════════ -->
<header class="sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
    
    <!-- Logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-2 font-display font-black text-2xl tracking-tight" style="color:#c8392b;text-decoration:none;">
      <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect width="22" height="22" rx="4" fill="#c8392b"/><path d="M5 5h5l3 6-3 6H5l3-6-3-6zm7 0h5l-3 6 3 6h-5l-3-6 3-6z" fill="#fff"/></svg>
      <?php bloginfo( 'name' ); ?>
    </a>

    <!-- Menu Desktop -->
    <nav class="hidden md:flex items-center gap-6">
      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array(
              'theme_location' => 'primary',
              'container'      => false,
              'items_wrap'     => '%3$s',
              'depth'          => 1,
          ) );
      } else {
          ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active" style="color:#c8392b;">Início</a>
          <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>">Sobre</a>
          <a href="<?php echo esc_url( home_url( '/portfolio' ) ); ?>" target="_blank">PortFolio</a>
          <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Blog</a>
          <a href="<?php echo esc_url( home_url( '/contato' ) ); ?>">Contato</a>
          <?php
      }
      ?>
    </nav>

    <!-- Switcher / Botão Dark e Ações -->
    <div class="flex items-center gap-3">
      <button class="theme-toggle" onclick="toggleTheme()" aria-label="Alternar tema">
        <span class="knob"></span>
      </button>
      
      <a href="#" class="hidden md:inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white" style="background:#c8392b;">Assine</a>
      
      <button id="menu-btn" class="md:hidden flex flex-col justify-center items-center w-9 h-9 rounded-md gap-1.5" style="background:var(--bg);border:1px solid var(--border);" onclick="toggleMenu()" aria-label="Abrir menu" aria-expanded="false">
        <span class="ham-bar" style="display:block;width:18px;height:2px;background:var(--text);border-radius:2px;transition:transform .3s,opacity .3s;"></span>
        <span class="ham-bar" style="display:block;width:18px;height:2px;background:var(--text);border-radius:2px;transition:transform .3s,opacity .3s;"></span>
        <span class="ham-bar" style="display:block;width:18px;height:2px;background:var(--text);border-radius:2px;transition:transform .3s,opacity .3s;"></span>
      </button>
    </div>
  </div>

  <!-- Menu Mobile -->
  <div id="mobile-menu" style="max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(.4,0,.2,1);background:var(--surface);border-top:1px solid var(--border);">
    <nav class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1">
      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array(
              'theme_location' => 'primary',
              'container'      => false,
              'items_wrap'     => '%3$s',
              'depth'          => 1,
          ) );
      } else {
          ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a>
          <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>">Sobre</a>
          <a href="<?php echo esc_url( home_url( '/portfolio' ) ); ?>" target="_blank">PortFolio</a>
          <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>">Blog</a>
          <a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" class="active" style="color:#c8392b;">Contato</a>
          <?php
      }
      ?>
      <div style="border-top:1px solid var(--border);margin:.5rem 0;"></div>
      <a href="#" class="inline-flex justify-center items-center px-4 py-2.5 rounded-md text-sm font-bold text-white" style="background:#c8392b;">Assine grátis</a>
    </nav>
  </div>
</header>
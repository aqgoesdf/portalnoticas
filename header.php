<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
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
    }
  </script>

  <?php wp_head(); ?>
</head>
<body <?php body_class('bg-primary text-primary font-sans antialiased transition-colors duration-300 min-h-screen flex flex-col'); ?>>
<?php wp_body_open(); ?>

  <!-- HEADER FIXO -->
  <header class="fixed top-0 left-0 w-full z-50 bg-header border-b border-subtle backdrop-blur-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      
      <!-- Logo -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="font-title font-extrabold text-2xl tracking-tight text-accent flex items-center gap-2">
        <span class="w-3 h-3 rounded-full bg-brand inline-block"></span>
        AqGoEs DeV<span class="text-brand">.</span>
      </a>

      <!-- Menu Desktop -->
      <nav class="hidden md:flex items-center gap-8">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'hidden md:flex items-center gap-8',
                'fallback_cb'    => false,
            ) );
        } else {
            // Fallback caso ainda não tenha configurado um menu no Painel WP
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-sm font-medium hover:text-brand transition-colors">Home</a>
            <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" class="text-sm font-medium hover:text-brand transition-colors">Sobre</a>
            <a href="<?php echo esc_url( home_url( '/artigos' ) ); ?>" class="text-sm font-medium hover:text-brand transition-colors">Artigos</a>
            <a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" class="text-sm font-medium hover:text-brand transition-colors">Contato</a>
            <?php
        }
        ?>
      </nav>

      <!-- Botão Dark/Light + Menu Mobile -->
      <div class="flex items-center gap-4">
        <!-- Toggle Theme Button -->
        <button id="theme-toggle" aria-label="Alternar tema" class="p-2.5 rounded-full border border-subtle bg-secondary hover:bg-subtle transition-all duration-300 text-primary">
          <!-- Ícone Sol (Light) -->
          <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
          <!-- Ícone Lua (Dark) -->
          <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
          </svg>
        </button>

        <!-- Botão Menu Hambúrguer (Mobile) -->
        <button id="menu-toggle" aria-label="Abrir menu" class="md:hidden p-2.5 rounded-xl border border-subtle bg-secondary text-primary">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Dropdown Mobile -->
    <div id="mobile-menu" class="hidden md:hidden border-b border-subtle bg-secondary px-4 pt-2 pb-6 space-y-3">
      <?php
      if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array(
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'space-y-3',
              'fallback_cb'    => false,
          ) );
      } else {
          ?>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block text-base font-medium hover:text-brand py-2">Home</a>
          <a href="<?php echo esc_url( home_url( '/sobre' ) ); ?>" class="block text-base font-medium hover:text-brand py-2">Sobre</a>
          <a href="<?php echo esc_url( home_url( '/artigos' ) ); ?>" class="block text-base font-medium hover:text-brand py-2">Artigos</a>
          <a href="<?php echo esc_url( home_url( '/contato' ) ); ?>" class="block text-base font-medium hover:text-brand py-2">Contato</a>
          <?php
      }
      ?>
    </div>
  </header>
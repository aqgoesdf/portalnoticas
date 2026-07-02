<!DOCTYPE html>
<!-- Substitui a tag html estática para injetar o idioma correto e classes do WP -->
<html <?php language_attributes(); ?> class="light">
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <!-- Removemos a tag <title> estática. O WP gerencia isso dinamicamente agora -->
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  
  <!-- Corrigindo o caminho do CSS nativo do seu tema -->
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style.css">
  
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            display: ['Playfair Display', 'serif'],
            body: ['DM Sans', 'sans-serif'],
          },
          colors: {
            ink: {
              50:  '#f5f3ef', 100: '#e8e4dc', 200: '#d0c9bc', 300: '#b3a892',
              400: '#978770', 500: '#7d6d58', 600: '#65584a', 700: '#50453b',
              800: '#3a3129', 900: '#28221c', 950: '#161210',
            },
            accent: '#c8392b',
            gold: '#d4a845',
          }
        }
      }
    }
  </script>

  <!-- OBRIGATÓRIO: Permite que o WP e plugins injetem scripts/estilos no head -->
  <?php wp_head(); ?>
</head>

<!-- body_class() adiciona classes automáticas baseadas na página atual -->
<body <?php body_class(); ?>>

<!-- ═══════════════════════════════════════
     HEADER
═══════════════════════════════════════ -->
<header class="sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">

    <!-- Logo -->
    <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 font-display font-black text-2xl tracking-tight" style="color:#c8392b; text-decoration:none;">
      <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect width="22" height="22" rx="4" fill="#c8392b"/><path d="M5 5h5l3 6-3 6H5l3-6-3-6zm7 0h5l-3 6 3 6h-5l-3-6 3-6z" fill="#fff"/></svg>
      AqGoEs
    </a>

    <!-- Nav desktop (DINÂMICO) -->
    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary-menu',       // Identificador do local
        'container'      => 'nav',                 // Envolve o menu em uma tag <nav>
        'container_class'=> 'hidden md:flex items-center gap-6', // Classes do container do seu front-end
        'items_wrap'     => '%3$s',                // Remove as tags <ul> e <li> para renderizar apenas os links puros
        'fallback_cb'    => false,
        'link_class'     => '',                    // Caso queira passar classes globais para o link (as do seu nav a já estão no CSS global)
    ));
    ?>

    <!-- Direita: toggle + assine + hamburguer -->
    <div class="flex items-center gap-3">
      <!-- Theme toggle -->
      <button class="theme-toggle" onclick="toggleTheme()" aria-label="Alternar tema">
        <span class="knob"></span>
      </button>
      <!-- Assine só desktop -->
      <a href="#" class="hidden md:inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold text-white" style="background:#c8392b;">
        Assine
      </a>
      <!-- Hamburguer só mobile -->
      <button id="menu-btn" class="md:hidden flex flex-col justify-center items-center w-9 h-9 rounded-md gap-1.5 transition-colors" style="background:var(--bg); border:1px solid var(--border);" onclick="toggleMenu()" aria-label="Abrir menu" aria-expanded="false">
        <span class="ham-bar" style="display:block;width:18px;height:2px;background:var(--text);border-radius:2px;transition:transform .3s,opacity .3s;"></span>
        <span class="ham-bar" style="display:block;width:18px;height:2px;background:var(--text);border-radius:2px;transition:transform .3s,opacity .3s;"></span>
        <span class="ham-bar" style="display:block;width:18px;height:2px;background:var(--text);border-radius:2px;transition:transform .3s,opacity .3s;"></span>
      </button>
    </div>
  </div>

  <!-- ── DRAWER MOBILE ── -->
  <div id="mobile-menu"
       style="max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(.4,0,.2,1);background:var(--surface);border-top:1px solid var(--border);">
    
    <!-- Nav mobile (DINÂMICO) -->
    <?php
    wp_nav_menu(array(
        'theme_location' => 'mobile-menu',
        'container'      => 'nav',
        'container_class'=> 'max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1',
        'items_wrap'     => '%3$s',
        'fallback_cb'    => false,
        'link_class'     => 'mobile-nav-link',   // Injeta a sua classe específica mobile do Tailwind em cada item
    ));
    ?>
    
    <!-- Bloco de assinatura fixo abaixo do menu mobile -->
    <div class="max-w-7xl mx-auto px-4 pb-4 flex flex-col gap-1">
      <div style="border-top:1px solid var(--border);margin:.5rem 0;"></div>
      <a href="#" class="inline-flex justify-center items-center px-4 py-2.5 rounded-md text-sm font-bold text-white" style="background:#c8392b;">
        Assine grátis
      </a>
    </div>
  </div>
</header>
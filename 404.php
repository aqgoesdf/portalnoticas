<?php
/**
 * Template para Página de Erro 404 (Não Encontrado)
 *
 * @package aqgoes-theme
 */

get_header(); 
?>

<main class="py-20 flex items-center justify-center min-h-[60vh]">
  <div class="max-w-md mx-auto px-4 text-center">
    
    <div class="font-mono text-6xl font-black mb-2" style="color:#c8392b;">404</div>
    
    <h1 class="font-display font-bold text-2xl mb-3" style="color:var(--text);">
      Página não encontrada
    </h1>
    
    <p class="text-sm mb-8 leading-relaxed" style="color:var(--muted);">
      O conteúdo que você está procurando foi movido, excluído ou nunca esteve disponível.
    </p>

    <!-- Form de busca rápida no erro 404 -->
    <form role="search" method="get" class="search-wrap mb-6" action="<?php echo esc_url( home_url( '/' ) ); ?>">
      <input type="text" class="search-input" name="s" placeholder="Pesquisar no site…" autocomplete="off"/>
      <button type="submit" style="background:none;border:none;cursor:pointer;">
        <svg class="search-icon" width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="6" cy="6" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M9.5 9.5l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
      </button>
    </form>

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center px-5 py-2.5 rounded-md text-sm font-bold text-white transition-opacity hover:opacity-90" style="background:#c8392b;text-decoration:none;">
      Voltar para o Início
    </a>

  </div>
</main>

<?php get_footer(); ?>